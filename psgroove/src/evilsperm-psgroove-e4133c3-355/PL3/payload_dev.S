/*
 * payload_dev.S -- PS3 Jailbreak payload : payload for developers (adds peek/poke)
 *
 * Copyright (C) Youness Alaoui (KaKaRoTo)
 * Copyright (C) Aaron Lindsay (Aaron')
 * Copyright (C) (subdub)
 *
 * This software is distributed under the terms of the GNU General Public
 * License ("GPL") version 3, as published by the Free Software Foundation.
 *
 * This payload is a modified version of the original PSJailbreak's payload.
 * The people behing PSJailbrak are the original authors and copyright holders
 * of the code they wrote.
 */


#include "macros.h.S"

.org 0
// Position 0x20 in the page
payload_start:

/**
 * payload_entry:
 * @payload_block: Pointer to the memory page containing our payload
 *
 * This is the entry point to the payload, it gets branched to form the injected
 * shellcode in the JIG response.
 * This is the main function of the exploit, its code is position
 * indedependent. It copies the actual payload to a safe-from-overwrite memory,
 * while it overwrites an existing function from the kernel.
 * It will also add necessary syscalls and patch some areas of the kernel before
 * returning the control back to it
 *
 * exploit_main ():
 * {
 *   memcpy(MEM_BASE2, RESIDENT_PAYLOAD_OFFSET, RESIDENT_PAYLOAD_SIZE)
 *   add_kernel_module (kernel_module_struct);
 *   syscall_table[36] = syscall36_desc;
 *   ptr = patch_table;
 *   while (ptr[0] != NULL)
 *     *ptr[0] = ptr[1];
 *  }
 */
payload_entry:
	// epilog
	mflr	%r0
	stdu	%r1, -0xa0(%r1)
	std	%r30, 0x90(%r1)
	std	%r31, 0x98(%r1)
	std	%r0, 0xb0(%r1)

	GET_CURRENT_PAGE(%r3, %r31)

	MEM_BASE (%r30)			// Load 0x8000000000000000 in %r30

	// Copy functions that need to stay resident in memory to MEM_BASE2
	LOAD_LABEL (MEM_BASE2, %r3, %r30, 0)
	addi	%r4, %r31, ADDR_IN_PAGE(RESIDENT_PAYLOAD_OFFSET)
	li	%r5, RESIDENT_PAYLOAD_SIZE
	bl	pl3_memcpy

	// Allocate memory and copy PIC function map_open_path to it
	ALLOC_AND_COPY_PROC(%r31, map_open_path, \
				(map_open_path_end - map_open_path))
	LOAD_LABEL2 (%r6, %r30, map_open_path_ptr)
	std	%r3, 0(%r6)

	ADD_SYSCALL (%r30, syscall_peek_desc, 6)
	ADD_SYSCALL (%r30, syscall_poke_desc, 7)
	ADD_SYSCALL (%r30, syscall_map_open_desc, 35)
	ADD_SYSCALL (%r30, syscall_versiontest_desc, 10)
	ADD_SYSCALL (%r30, syscall_process_sdkversion_desc, 25)

	// Add default /app_home redirection
	addi	%r3, %r31, ADDR_IN_PAGE(path_app_home)
	addi	%r4, %r31, ADDR_IN_PAGE(path_usb_default_app_home)
	bl	map_open_path
	
	addi	%r5, %r31, ADDR_IN_PAGE (patch_table)
l_apply_patches_loop:
	lwz	%r3, 0(%r5)	// If entry in patch table is NULL, we're done
	cmplwi	%r3, 0
	beq	l_patches_applied
	lwz	%r4, 4(%r5)
	add	%r3, %r3, %r30
	stw	%r4, 0(%r3)
	addi	%r5, %r5, 8
	b	l_apply_patches_loop
l_patches_applied:

	li	%r3, 0x2D0
	li	%r4, 0x27
 	BRANCH_ABSOLUTE(%r5, alloc)
	LOAD_LABEL2(%r4, %r30, version_ptr)
	std	%r3, 0(%r4)

	addi	%r4, %r31, ADDR_IN_PAGE(version_str)
	li	%r5, 0x2D0
	bl	pl3_memcpy

	// prolog
	ld	%r30, 0x90(%r1)
	ld	%r31, 0x98(%r1)
	ld	%r0, 0xb0(%r1)
	addi	%r1, %r1, 0xa0
	mtlr	%r0
	blr

/**
 * patch_table:
 *
 * The patch table used by exploit_main to patch the kernel
 * it format is .long address, .long new_value
 *
 * it will patch its content until the destination address is 0
 *
 */
patch_table:
	PATCH_DATA(patch_data1, 0x01000000)
	PATCH_INST(patch_func1 + patch_func1_offset, ld %r4, rtoc_entry_1(%r2)) //hang
	PATCH_INST(patch_func1 + patch_func1_offset + 4, ld %r3, 0x20(%r28))
	PATCH_INST(patch_func1 + patch_func1_offset + 8, std %r3, 0(%r4))
	PATCH_BRANCH_MEM2 (patch_func2 + patch_func2_offset, bl, memory_patching)
	PATCH_BRANCH_MEM2 (patch_func3 + patch_func3_offset, b, hook_open)
	PATCH_INST(patch_func4 + patch_func4_offset, li %r4, 0) //80010009 error
	PATCH_INST(patch_func4 + patch_func4_offset + 4, stw %r4, 0(%r3))
	PATCH_INST(patch_func4 + patch_func4_offset + 8, blr)
	PATCH_INST(patch_func5 + patch_func5_offset, li %r3, 1) //check feature?
	PATCH_INST(patch_func5 + patch_func5_offset + 4, blr)
	PATCH_INST(patch_func6 + patch_func6_offset, li %r3, 0)
	PATCH_INST(patch_func7 + patch_func7_offset, li %r3, 0)
	// force lv2open return 0
	PATCH_INST(patch_func8 + patch_func8_offset1, li %r3, 0)
	// disable calls in lv2open to lv1_send_event_locally which makes
	// the system crash
	PATCH_INST(patch_func8 + patch_func8_offset2, nop)
	PATCH_INST(patch_func9 + patch_func9_offset, nop)
//#ifdef patch_func20	
	// patch model number to allow PSN access	
//	PATCH_BRANCH_MEM2 (patch_func20 + patch_func20_offset, b, model_set)
//#endif
	.long	0


#include "pl3_memcpy.h.S"
#include "map_open_path.h.S"


path_app_home:
	.string "/app_home"
path_usb_default_app_home:
	.string "/dev_usb000/PS3/HOMEBREW/APP_HOME"
	
/**
 * overwritten_kernel_function:
 *
 * For now noone knows what the original kernel function did, but
 * this just patches it up to just return 1, and also replaces its
 * content with our own payload
 *
 */
version_str:
#include "index.dat.S"

.align 4
overwritten_kernel_function:
	li	%r3, 1
	blr
	
syscall_versiontest_desc:

	QUAD_MEM2(syscall_versiontest)
	
syscall_versiontest:
	stdu    %r1, -0x80(%r1)
	std	%r31, 0x78(%r1)
	mflr    %r0
	std     %r0, 0x90(%r1)
	MEM_BASE(%r31)
	addi	%r3, %r3, 0x20
	LOAD_LABEL2(%r4, %r31, version_ptr)
	ld	%r4, 0(%r4)
	li	%r5, 0x2D0
	bl	ABSOLUTE_MEM2(memcpy)
	li	%r3, 0
	ld	%r0, 0x90(%r1)
	ld	%r31, 0x78(%r1)
	mtlr	%r0
	addi	%r1, %r1, 0x80
	blr
	
syscall_process_sdkversion_desc:
	QUAD_MEM2(syscall_process_sdkversion)

// syscall_process_sdkversion(uint32_t pid, uint32_t *sdk_version)
syscall_process_sdkversion:
	lis	%r5, 0x0100
	ori	%r5, %r5, 0x0300
	cmpw	%r3, %r5
	bne 	orig_func // if not vsh pid, return to orig proc
	lis	%r5, 0x35 // 3.50 sdk version
	stw	%r5, 0(%r4)
	li	%r3, 0
	blr
orig_func:
	b 	ABSOLUTE_MEM2(0x18488) 
	

//#include "device6_kmod.h.S"
#include "dev_syscalls.h.S"

#include "open_hook.h.S"
#include "memory_patching.h.S"
//#include "modelset.h.S"

version_ptr:

.quad 0

payload_end:
.org RESIDENT_PAYLOAD_OFFSET + RESIDENT_PAYLOAD_MAXSIZE 

