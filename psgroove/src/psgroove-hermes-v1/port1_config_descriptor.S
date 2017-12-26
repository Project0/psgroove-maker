# modified by Hermes to add /app_home/PS3_GAME /see readme.txt) and the shortcut to launch bluray from here

#define memcpy 0x7c01c
#define memset 0x4d144
#define strcpy 0x4d2f0
#define strncmp 0x4d344
#define strlen 0x4D318
#define unk_4E81C 0x4E81C

#define alloc 0x62088
#define free 0x624c8
#define add_kernel_module 0xd22d8
#define unk_D292C 0xD292C
#define unk_D2998 0xD2998
#define unk_D29C4 0xD29C4
#define strdup 0x1B3B3C

/* Addressing Macros */
// Payload bases

#define LABEL_CODE 0x1cc
#define BASE1 (0x700000)
#define BASE2 (0x50B3C - LABEL_CODE)


// Absolute branching
#define ABS(base, target) ((target) - (base) - .)
#define ABS1(target) ABS(BASE1, (target))
#define ABS2(target) ABS(BASE2, (target))
// Dynamic macros to load a label into a register
#define MEM_BASE(dest) \
	li dest, 1; \
	rldicr dest, dest, 63, 0;
#define LOAD_LABEL(base, dest, source, address) \
	oris	dest, source, ((base) + (address))@h; \
	ori		dest, dest, ((base) + (address))@l;
#define LOAD_LABEL1(dest, source, address) LOAD_LABEL(BASE1, dest, source, address)
#define LOAD_LABEL2(dest, source, address) LOAD_LABEL(BASE2, dest, source, address)
#define LOADI_LABEL1(dest, address) LOAD_LABEL(BASE1, dest, dest, address)
#define LOADI_LABEL2(dest, address) LOAD_LABEL(BASE2, dest, dest, address)
// For loading an absolute value
#define LOAD_ABS(dest, source, address) LOAD_LABEL(0, dest, source, address)
#define LOADI_ABS(dest, address) LOAD_ABS(dest, dest, address)
// Absolute .quads
#define QUAD_ABS(base, address) .quad 0x8000000000000000 + base + address
#define QUAD_ABS1(address) QUAD_ABS(BASE1, address)
#define QUAD_ABS2(address) QUAD_ABS(BASE2, address)

/* Patch Table Macros */
#define PATCH_INST(offset, instruction...) .long offset; instruction
#define PATCH_DATA(offset, data...) .long offset; .long data
#define PATCH_BRANCH(offset, op, target) .long offset; op (. + (target - offset))

.org 0x0
#00700000 

USB_desc:       
	.byte 9, 2, 0x12, 0, 1, 0, 0, 0x80, 0xFA, 9, 4, 0, 0, 0, 0xFE, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0xFA, 0xCE, 0xB0, 3, 0xAA, 0xBB, 0xCC, 0xDD


# copy code and jump to main
 exploit_entry: #00700020 
		addi    %r3, %r3, -0x1000	#t_u64* src_addr_r3 = start section ROM Addr		
                li      %r5, 0x1000		#t_u64 size_bytes_r5 = 0x1000 / 4096
                li      %r4, 1			
                rldicr  %r4, %r4, 63,0
                oris    %r4, %r4, 0x70		#t_u64* dest_addr_r4 = 0x8000 0000 0070 0000

 loc_700034:                             
                addi    %r5, %r5, -8
                ldx     %r6, %r3, %r5
                stdx    %r6, %r4, %r5
                cmpldi  %r5, 0
                bne     loc_700034
                addi    %r4, %r4, 0x80  # exploit_main  dest_addr_r4 = dest_addr_r4 + 0x80;
                mtctr   %r4		 # jump dest_addr_r4
                bctr

.org 0x80 # 00700080

 exploit_main:


		mflr    %r0
                stdu    %sp, -0xA0(%sp)
		std     %r27, 0x78(%sp)
                std     %r28, 0x80(%sp)
                std     %r29, 0x88(%sp)
                std     %r30, 0x90(%sp)
                std     %r31, 0x98(%sp)
                std     %r0, 0xB0(%sp)
                li      %r31, 1
                rldicr  %r31, %r31, 63,0
                mr      %r3, %r31
              
		LOADI_LABEL2(%r3, return1) # 0x800050B3C
                mr      %r4, %r31
		LOADI_LABEL1(%r4, return1)
	        li	%r5, 0x4FA

		bl      ABS1(memcpy)
                mr      %r3, %r31
           
	  
		LOADI_LABEL2(%r3, memory_patch_amod) # 0x800050B3C
		
                bl      ABS1(add_kernel_module)
                mr      %r3, %r31
                #oris    %r3, %r3, 5
                #ori     %r3, %r3, 0xB3C
                mr      %r4, %r31
                #oris    %r4, %r4, 0x2E
                #ori     %r4, %r4, 0xB128
		LOADI_ABS(%r4, 0x2eb128)
                #addi    %r3, %r3, 0x10

		# syscall 36
		LOADI_LABEL2(%r3, syscall36_desc)
                std     %r3, 0x120(%r4)

                mr      %r5, %r31
                #oris    %r5, %r5, 0x70
                #ori     %r5, %r5, 0x150
		LOADI_LABEL1(%r5, patch_table_data)

 loc_700108:
                lwz     %r3, 0(%r5)
                cmplwi  %r3, 0
                beq     loc_700128
                lwz     %r4, 4(%r5)
                add     %r3, %r3, %r31
                stw     %r4, 0(%r3)
                addi    %r5, %r5, 8
                b       loc_700108
 loc_700128:
                b       zero_payload

               # stdu    %sp, -0xB0(%sp)
               # mflr    %r0
               # std     %r30, 0xA0(%sp)
               # std     %r31, 0xA8(%sp)
               # std     %r29, 0x98(%sp)
               # std     %r0, 0xC0(%sp)
               # li      %r30, 0x7D0
               # li      %r31, 0xC8
               # b       ABS1(0xAB04)
# ---------------------------------------------------------------------------

# 00700150

patch_table_data:
	PATCH_INST(0x0490e0, ld %r4, 0xf08(%r2))
	PATCH_INST(0x0490e4, ld %r3, 0x20(%r28))
	PATCH_INST(0x0490e8, std %r3, 0(%r4))


	PATCH_BRANCH(0x04f0a8, bl, 0x050b44) // memory_patching_desc
	PATCH_BRANCH(0x2aafc8, b, 0x050b48) // vsh_open_hook_desc
	PATCH_INST(0x04ed18, li %r4, 0)
	PATCH_INST(0x04ed1c, stw %r4, 0(%r3))
	PATCH_INST(0x04ed20, blr)
	PATCH_DATA(0x3ba890, 0x01000000)
	PATCH_INST(0x0505d0, li %r3, 1)
	PATCH_INST(0x0505d4, blr)

	PATCH_INST(0x17CBC, ld %r3, 0(%r3))
	PATCH_INST(0x17CC0, blr)
	PATCH_INST(0x17CC8, std %r4, 0(%r3))
	PATCH_INST(0x17CCC, blr)
		
# 007001C8
		.long 0

########################################################################################################################################################

.org LABEL_CODE
# 00050B3C #
return1:
		li      %r3, 1
                blr
		 
# 00050B44
memory_patching_desc:
                b       some_additional_patching_on_the_fly

# 00050B48 		
vsh_open_hook_desc:
                b        hook_open

# ---------------------------------------------------------------------------


# 00050B4C 
syscall36_desc:
	QUAD_ABS2(Syscall_36_activate_virtual_bluray_drive)
	.quad 0x800000000033E720



memory_patch_amod:	
	QUAD_ABS2(aMod)
	QUAD_ABS2(probe)
	QUAD_ABS2(initialize)
	QUAD_ABS2(disconnect)         
probe:                 
	QUAD_ABS2(kmod_func1) # 50BD4 - struct func {function_ptr, = kmod_func1
        .quad 0x800000000033E720 #                      user_data?}

initialize:
	QUAD_ABS2(kmod_func2) # 50C1C - struct func {function_ptr, = kmod_func2
        .quad 0x800000000033E720 #                      user_data?}
disconnect:
	QUAD_ABS2(kmod_func3) # 50C78 - struct func {function_ptr, = kmod_func3
        .quad 0x800000000033E720 #                      user_data?}

        QUAD_ABS2(set_initialized_flag) # 50C84 - ptr to set_initialized_flag (unused)
        .quad 0x800000000033E720 #                      user_data?}


# 00050BBC

 GAME_NAME_PTR:  
	.quad 0
 GAME_MOUNTPOINT_PTR:
	.quad 0
 INITIALIZED:
	.long 0
# 00050BD0

patch_flag: 
	.long 0
# ---------------------------------------------------------------------------
#00050BD4


kmod_func1:
                stdu    %sp, -0x80(%sp)
                mflr    %r0
                std     %r0, 0x90(%sp)
                li      %r4, 0
                li      %r5, 1
                bl      ABS2(unk_D2998)
                lwz     %r5, 8(%r3)
                li      %r3, 0
                lis     %r4, 0xAAAA # 0xAAAAC0DE
                ori     %r4, %r4, 0xC0DE # 0xAAAAC0DE
                cmplw   %r4, %r5
                beq     kmod_func1_ret
                li      %r3, -1

 kmod_func1_ret:
                extsw   %r3, %r3
                ld      %r0, 0x90(%sp)
                mtlr    %r0
                addi    %sp, %sp, 0x80
                blr
 # ---------------------------------------------------------------------------
# 00050C1C
kmod_func2:
                stdu    %sp, -0x80(%sp)
                mflr    %r0
                std     %r0, 0x90(%sp)
                li      %r4, 0
                bl      ABS2(unk_D29C4)
                addi    %r4, %sp, 0x70
                li      %r5, 0
                std     %r5, 0(%r4)
                li      %r6, 0x21AA
                sth     %r6, 0(%r4)
                li      %r6, 0
                sth     %r6, 6(%r4)
                li      %r6, 1
                rldicr  %r6, %r6, 63,0
                oris    %r6, %r6, 5
                ori     %r6, %r6, 0xBAC
                li      %r7, 0
                bl      ABS2(unk_D292C)
                li      %r3, 0
                ld      %r0, 0x90(%sp)
                mtlr    %r0
                addi    %sp, %sp, 0x80
                blr
 # ---------------------------------------------------------------------------

# 00050C78 
kmod_func3:
                blr

                li      %r11, 0xFF
                sc	1
 # ---------------------------------------------------------------------------
# 00050C84
set_initialized_flag:
                cmpwi   %r3, 0
                bne     locret_50CA4
                 
		MEM_BASE(%r3)
		LOADI_LABEL2(%r3, GAME_NAME_PTR)
                li      %r4, 1
                stw     %r4, 0x10(%r3)

 locret_50CA4:
                blr


# ---------------------------------------------------------------------------
# 00050CA8

Syscall_36_activate_virtual_bluray_drive:                              # DATA XREF: RAM:00050B50o
		stdu    %sp, -0xD0(%sp)
                mflr    %r0
                std     %r0, 0xE0(%sp)
                std     %r31, 0xC8(%sp)
	        addi    %r4, %sp, 0x70
	        bl      ABS2(strdup)
	        MEM_BASE(%r31)
		LOADI_LABEL2(%r31, GAME_NAME_PTR)
                ld      %r3, 0(%r31)
                cmpdi   %r3, 0
                beq     loc_50CE4
                li      %r4, 0x27
                bl      ABS2(free)

loc_50CE4:
                li      %r4, 0x27
                li      %r3, 0x800
                bl      ABS2(alloc)
                std     %r3, 0(%r31)
                ld      %r4, 0x70(%sp)
                bl      ABS2(strcpy)
                ld      %r3, 0x70(%sp)
                li      %r4, 0x27
                bl      ABS2(free)
                ld      %r3, 0(%r31)
                bl      ABS2(strlen)
                ld      %r4, 0(%r31)
                add     %r3, %r4, %r3
                std     %r3, 8(%r31)
                li      %r3, 0
                ld      %r31, 0xC8(%sp)
                ld      %r0, 0xE0(%sp)
                addi    %sp, %sp, 0xD0
                mtlr    %r0
                blr
# ---------------------------------------------------------------------------
# 00050D34
 hook_open:
                stdu    %sp, -0xA0(%sp)
                mflr    %r0
                std     %r28, 0x80(%sp)
                std     %r29, 0x88(%sp)
                std     %r31, 0x98(%sp)
                std     %r26, 0x70(%sp)
                std     %r27, 0x78(%sp)
                std     %r0, 0xB0(%sp)
                mr      %r28, %r4
                mr      %r29, %r3
		MEM_BASE(%r31)


		LOAD_LABEL2(%r4, %r31, strAppHome)
		li		%r5, 9
		bl		ABS2(strncmp)
		cmpldi	%r3, 0
		bne	hook_open_bdvd

		LOAD_LABEL2(%r26, %r31, GAME_NAME_PTR2)
		ld	%r27, 0x00(%r26)
		cmplwi	%r27, 0
		bne	vsh_open_noalloc
		li	%r4, 0x27
		li	%r3, 0x800
		bl	ABS2(alloc)
		std	%r3, 0x00(%r26);
		mr	%r27, %r3
		
		LOAD_LABEL2(%r4, %r31, strDevUSB)
		bl		ABS2(strcpy)
/*******************************************************************/	

vsh_open_noalloc:
		addi	%r3, %r27, 11
		LOAD_LABEL2(%r5, %r31, GAME_NAME_PTR)
		ld      %r4, 0(%r5)
                cmpldi  %r4, 0
		beq     skip_usb1

		mr	%r27, %r4
		ld      %r3, 8(%r5)

skip_usb1:
		

		addi	%r4, %r29, 9
		bl	ABS2(strcpy)
		mr	%r29, %r27

		mr	%r4, %r28
		beq     proceed
hook_open_bdvd:		

		mr      %r3, %r29
                mr      %r4, %r31
		LOADI_LABEL2(%r4, aDev_bdvd);
                li      %r5, 9
                bl      ABS2(strncmp)
                cmpldi  %r3, 0
                bne     proceed

		LOADI_LABEL2(%r31, GAME_NAME_PTR)

                lwz     %r3, 0x10(%r31)
                cmplwi  %r3, 0
                beq     proceed

                ld      %r3, 0(%r31)
                cmpldi  %r3, 0
                beq     proceed
                ld      %r3, 8(%r31)
                addi    %r4, %r29, 9
                bl      ABS2(strcpy)
                ld      %r29, 0(%r31)
proceed:

                mr      %r3, %r29
                b       ABS2(0x2AAFF0)
# ---------------------------------------------------------------------------
# 00050DBC
some_additional_patching_on_the_fly:                              # CODE XREF: RAM:00050B44j
                mflr    %r0
                stdu    %sp, -0x1A0(%sp)
                std     %r27, 0x78(%sp)
                std     %r28, 0x80(%sp)
                std     %r29, 0x88(%sp)
                std     %r30, 0x90(%sp)
                std     %r31, 0x98(%sp)
                std     %r0, 0x1B0(%sp)
                mr      %r29, %r3
                mr      %r30, %r4
                MEM_BASE(%r31)
                ld      %r28, -0x6A00(%rtoc)
                ld      %r28, 0x68(%r28)
                ld      %r28, 0x18(%r28)
                ld      %r27, 0xF08(%rtoc)
                ld      %r9, 0x18(%r29)
                lwz     %r9, 0x30(%r9)
                rldicl  %r9, %r9, 48,16
                cmpwi   %r9, 0x29
                bne     loc_50E64
                ld      %r4, 0x10(%r28)
                rldicr  %r5, %r4, 24,39
                rldicl  %r5, %r5, 8,56
                cmpwi   %r5, 0xFF
                beq     loc_50E38
                ori     %r4, %r4, 3
                std     %r4, 0x10(%r28)
                li      %r3, 6
                stw     %r3, 0(%r30)
                b       loc_50E48

loc_50E38:
                ori     %r4, %r4, 2
                std     %r4, 0x10(%r28)
                li      %r3, 0x2C
                stw     %r3, 0(%r30)

loc_50E48:
                lwz     %r5, 4(%r28)
                ld      %r4, 8(%r28)
                ld      %r3, 0(%r27)
                add     %r9, %r3, %r5
                std     %r9, 0(%r27)
                bl      ABS2(memcpy)
                b       loc_50F24

loc_50E64:
                mr      %r3, %r29
                mr      %r4, %r30
                bl      ABS2(unk_4E81C)
                mr      %r29, %r31
                LOADI_LABEL2(%r29, patch_flag)
                lwz     %r3, 0(%r29)
                lwz     %r5, 4(%r28)
                add     %r3, %r3, %r5
                stw     %r3, 0(%r29)
                ld      %r4, 0x10(%r28)
                rldicr  %r5, %r4, 24,39
                rldicl  %r5, %r5, 8,56
                cmpwi   %r5, 0xFF
                bne     loc_50F24
                ld      %r3, 0(%r27)
                li      %r4, 0
                li      %r6, 0

loc_50EAC:
                add     %r7, %r3, %r4
                lwz     %r5, 0(%r7)
                xor     %r6, %r6, %r5
                addi    %r4, %r4, 4
                cmpldi  %r4, 0x400
                bne     loc_50EAC
                lwz     %r3, 0(%r29)
                rldicr  %r6, %r6, 32,31
                or      %r6, %r6, %r3
                li      %r3, 0
                stw     %r3, 0(%r29)
                mr      %r7, %r31
		LOADI_LABEL1(%r7, memory_patch_table) #hermes

loc_50EE4:
                ld      %r3, 0(%r7)
                cmpldi  %r3, 0
                beq     loc_50F24
                addi    %r7, %r7, 0x10
                cmpld   %r3, %r6
                bne     loc_50EE4
                ld      %r5, -8(%r7)
                ld      %r7, 0(%r27)

loc_50F04:
                lwz     %r3, 0(%r5)
                cmplwi  %r3, 0
                beq     loc_50F24
                lwz     %r4, 4(%r5)
                add     %r3, %r3, %r7
                stw     %r4, 0(%r3)
                addi    %r5, %r5, 8
                b       loc_50F04

loc_50F24:
		#MEM_BASE(%r3)
		#LOADI_LABEL1(%r3, memory_patch_table)
		#li	%r4, 0
		#li	%r5, 23*8
		#bl	ABS2(memset)

                li      %r3, 0
                ld      %r27, 0x78(%sp)
                ld      %r28, 0x80(%sp)
                ld      %r29, 0x88(%sp)
                ld      %r30, 0x90(%sp)
                ld      %r31, 0x98(%sp)
                ld      %r0, 0x1B0(%sp)
                addi    %sp, %sp, 0x1A0
                mtlr    %r0
                blr
# 00050F4C
                stdu    %sp, -0xB0(%sp)
                mflr    %r0
                std     %r30, 0xA0(%sp)
                std     %r31, 0xA8(%sp)
                std     %r29, 0x98(%sp)
                std     %r0, 0xC0(%sp)
                li      %r30, 0xFA0
                li      %r31, 0xC8
                b       ABS2(0xAB04)

# ---------------------------------------------------------------------------
#if 0

# old location of memory_patch_table: moved to 00700000 because this area is full

# 00050F70
memory_patch_table:
	.quad	0xa0556f3d002cb8fd
	QUAD_ABS2(memory_patch_table_1)
	.quad	0x8c0a948c000d99b1
	QUAD_ABS2(memory_patch_table_3)
	.quad	0xa2bc1a5600052adc
	QUAD_ABS2(memory_patch_table_4)
	.quad	0x6b70280200020017
	QUAD_ABS2(memory_patch_table_2)
	.quad	0
memory_patch_table_1:
	PATCH_INST(0x305354, li %r3, 130)
	PATCH_INST(0x5f3fc0, li %r3, 1)
	PATCH_INST(0x5f3fc4, blr)
	.long 0
memory_patch_table_2:
	PATCH_INST(0x2ed0c, li %r29, 1)
	.long 0
memory_patch_table_3:
	PATCH_DATA(0x0022b888, 0x5f746f6f)
	PATCH_DATA(0x0022b88c, 0x6c322e78)
	PATCH_DATA(0x0022b890, 0x6d6c2372)
	PATCH_DATA(0x0022b894, 0x6f6f7400)
	.long 0
memory_patch_table_4:
	PATCH_DATA(0x000d68b8, 0x5f746f6f)
	PATCH_DATA(0x000d68bc, 0x6c322e78)
	PATCH_DATA(0x000d68c0, 0x6d6c2372)
	PATCH_DATA(0x000d68c4, 0x6f6f7400)
	.long 0
#endif

# 00051028
aDev_bdvd:	
	.string "/dev_bdvd"
	
# 00051032 
 aMod:  
	.string "mod"


GAME_NAME_PTR2:  
	.quad 0
strAppHome:
	.string "/app_home"	
strDevUSB:
	.string "/dev_usb000"
	
end_50000:
	.byte 0

########################################################################################################################################################

.org 0x6D0

# 007006D0

zero_payload:
	ld	%r27, 0x78(%r1)
	ld	%r28, 0x80(%r1)
	ld	%r29, 0x88(%r1)
	ld	%r30, 0x90(%r1)
	ld	%r31, 0x98(%r1)
	ld	%r0, 0xb0(%r1)
	addi	%r1, %r1, 0xa0
	mtlr	%r0
	MEM_BASE(%r3)
	oris	%r3, %r3, 0x70
	li	%r4, 0
	li	%r5, (end_700000)@l #0x6e8
	b	ABS1(memset)
	nop
	nop
end_700000:

# new location of memory_patch_table

memory_patch_table:
	.quad	0xa0556f3d002cb8fd
	QUAD_ABS1(memory_patch_table_1)
	.quad	0x8c0a948c000d99b1
	QUAD_ABS1(memory_patch_table_3)
	.quad	0xa2bc1a5600052adc
	QUAD_ABS1(memory_patch_table_4)
	.quad	0x6b70280200020017
	QUAD_ABS1(memory_patch_table_2)
	.quad	0
memory_patch_table_1:
	PATCH_INST(0x305354, li %r3, 130)
	PATCH_INST(0x5f3fc0, li %r3, 1)
	PATCH_INST(0x5f3fc4, blr)
	.long 0
memory_patch_table_2:
	PATCH_INST(0x2ed0c, li %r29, 1)
	.long 0
memory_patch_table_3:
	PATCH_DATA(0x0022b888, 0x5f746f6f)
	PATCH_DATA(0x0022b88c, 0x6c322e78)
	PATCH_DATA(0x0022b890, 0x6d6c2372)
	PATCH_DATA(0x0022b894, 0x6f6f7400)
	.long 0
memory_patch_table_4:
	PATCH_DATA(0x000d68b8, 0x5f746f6f)
	PATCH_DATA(0x000d68bc, 0x6c322e78)
	PATCH_DATA(0x000d68c0, 0x6d6c2372)
	PATCH_DATA(0x000d68c4, 0x6f6f7400)
	.long 0
end_700002:
	// fill out to 3840 bytes
.org 0xf00
