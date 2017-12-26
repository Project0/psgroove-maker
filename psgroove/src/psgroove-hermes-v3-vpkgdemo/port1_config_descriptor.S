# modified by Hermes to add /app_home/PS3_GAME /see readme.txt) and the shortcut to launch bluray from here
# added syscall 8, perm mode, relocatable code....

#define USB_MODULE
#define SYS8_VERSION 0x100
#define PERM_MODE 2  // 0 -> restricted 1-> original 2-> new for some games

// kernel 3.41 address

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
#define hook_open_out 0x2AAFF0

#define SYSCALL_TABLE 0x2eb128
#define USER_DATA 0x800000000033E720


/* Addressing Macros */
// Payload bases

#define LABEL_CODE (0x1cc)
#define DESTINATION  0x7FF000

#define BASE1 (0x700000)
#define BASE2 (DESTINATION - LABEL_CODE)

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
	        li	%r5, (end_dest_code-return1)@l #0x4FA

		bl      ABS1(memcpy)
                mr      %r3, %r31
           
#ifdef USB_MODULE	  

		LOADI_LABEL2(%r3, memory_patch_amod) # 0x800050B3C
		
                bl      ABS1(add_kernel_module)
                mr      %r3, %r31
#endif             
                mr      %r4, %r31
        
		LOADI_ABS(%r4, SYSCALL_TABLE)

		# syscall 36
		LOADI_LABEL2(%r3, syscall36_desc)
                std     %r3, 0x120(%r4)


		mr      %r5, %r31
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


	PATCH_BRANCH(0x04f0a8, bl, (DESTINATION+8)) // memory_patching_desc
	PATCH_BRANCH(0x2aafc8, b, (DESTINATION+12)) // vsh_open_hook_desc
	PATCH_INST(0x04ed18, li %r4, 0)
	PATCH_INST(0x04ed1c, stw %r4, 0(%r3))
	PATCH_INST(0x04ed20, blr)
	PATCH_DATA(0x3ba890, 0x01000000)
	
####### WARNING! This patch cause problems with games as F1 2010 with USB devices ########

	#PATCH_INST(0x0505d0, li %r3, 1)
	#PATCH_INST(0x0505d4, blr)

####### New patch to avoid problems with games as F1 2010 with USB devices ########


	#PATCH_INST(0x234D0, li %r3, 0) 
	#PATCH_INST(0xE83D4, li %r3, 0) 

	PATCH_BRANCH(0x0505d0, b, (DESTINATION+(perm_routine-return1)))
	PATCH_BRANCH(0x234D0, bl, (DESTINATION+(perm0_routine-return1)))
	PATCH_BRANCH(0xE83D4, bl, (DESTINATION+(perm0_routine-return1)))


##########################################################################################

// syscalls patch

	PATCH_INST(0x17CBC, ld %r3, 0(%r3)) // syscall 6
	PATCH_INST(0x17CC0, blr)
	PATCH_INST(0x17CC8, std %r4, 0(%r3)) // syscall 7
	PATCH_INST(0x17CCC, blr)

	PATCH_BRANCH(0x17CD4, b, (DESTINATION+(syscall8-return1))) // syscall 8

	PATCH_INST(0x50B3C, li      %r3, 1) # use this patch if you move the payload resident code to other address 
	PATCH_INST(0x50B40, blr)
		
# 007001C8
	.long 0


########################################################################################################################################################

.org LABEL_CODE
# 00050B3C #

 return1:
	li	%r3, 1
        blr
		 
# 00050B44
 memory_patching_desc:
                
	b	some_additional_patching_on_the_fly

# 00050B48 		
 vsh_open_hook_desc:
       
	b	hook_open

return0:
	li      %r3, 0
        blr

# ---------------------------------------------------------------------------


# 00050B4C 
 syscall36_desc:
	QUAD_ABS2(Syscall_36_activate_virtual_bluray_drive)
	.quad USER_DATA

#ifdef USB_MODULE
 memory_patch_amod:	
	QUAD_ABS2(aMod)
	QUAD_ABS2(probe)
	QUAD_ABS2(initialize)
	QUAD_ABS2(disconnect)         
 probe:                 
	QUAD_ABS2(kmod_func1) # 50BD4 - struct func {function_ptr, = kmod_func1
        .quad USER_DATA #                      user_data?}

 initialize:
	QUAD_ABS2(kmod_func2) # 50C1C - struct func {function_ptr, = kmod_func2
        .quad USER_DATA #                      user_data?}
 disconnect:
	QUAD_ABS2(kmod_func3) # 50C78 - struct func {function_ptr, = kmod_func3
        .quad USER_DATA #                      user_data?}
 initialized_flag:
        QUAD_ABS2(set_initialized_flag) # 50C84 - ptr to set_initialized_flag (unused)
        .quad USER_DATA #                      user_data?}

#endif


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
	MEM_BASE(%r6)
	LOADI_LABEL2(%r6, initialized_flag)
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

	li      %r3, 0
	blr

       # li      %r11, 0xFF
       # sc	1
 
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

Syscall_36_activate_virtual_bluray_drive:

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

	LOAD_LABEL2(%r27, %r31, str_open_cmp)
	ld	%r26, 0(%r27)
	cmpldi	%r26, 0
	beq	hook_open1

 _b_hook_open00:

	mr      %r3, %r29
	ld	%r4, 0(%r26)  // get compare path
	cmpldi	%r4, 0
	beq	hook_open1
	
	lwz	%r5, 16(%r26) // get len of compare path
	bl      ABS2(strncmp)

	
	cmpldi	%r3, 0
	bne	_b_hook_open01

	lwz	%r5, 16(%r26) 
	add	%r4, %r29, %r5 // &open_path[compare_path_len]

	ld	%r3, 8(%r26) // get new path
	mr      %r29, %r3    // changes open_path
	lwz	%r5, 20(%r26) // get len of new path

	add	%r3, %r3, %r5

	bl	ABS2(strcpy)
	mr      %r4, %r28
	b	proceed

 _b_hook_open01:

	addi	%r26, %r26, 24
	b	_b_hook_open00
		
 hook_open1:
	LOAD_LABEL2(%r4, %r31, strAppHome)
	li	%r5, 9
	bl	ABS2(strncmp)
	cmpldi	%r3, 0
	bne	hook_open_bdvd

	LOAD_LABEL2(%r26, %r31, GAME_NAME_PTR2)
	ld	%r27, 0x00(%r26)
	cmpldi	%r27, 0
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

#ifdef USB_MODULE
	lwz     %r3, 0x10(%r31)
	cmplwi  %r3, 0
	beq     proceed
#endif
	ld      %r3, 0(%r31)
	cmpldi  %r3, 0
	beq     proceed
	ld      %r3, 8(%r31)
	addi    %r4, %r29, 9
	bl      ABS2(strcpy)
	ld      %r29, 0(%r31)
 proceed:

        mr      %r3, %r29
        b       ABS2(hook_open_out)

# ---------------------------------------------------------------------------
# 00050DBC

 some_additional_patching_on_the_fly:
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
	LOADI_LABEL2(%r7, memory_patch_table) #hermes

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
	#stdu    %sp, -0xB0(%sp)
	#mflr    %r0
	#std     %r30, 0xA0(%sp)
	#std     %r31, 0xA8(%sp)
	#std     %r29, 0x98(%sp)
	#std     %r0, 0xC0(%sp)
	#li      %r30, 0xFA0
	#li      %r31, 0xC8
	#b       ABS2(0xAB04)

########################################################################################################################################################

# generic tool main syscall

syscall8:

	mflr    %r0
	stdu    %sp, -0xA0(%sp)
	std     %r27, 0x78(%sp)
	std     %r28, 0x80(%sp)
	std     %r29, 0x88(%sp)
	std     %r30, 0x90(%sp)
	std     %r31, 0x98(%sp)
	std     %r0, 0xB0(%sp)

	MEM_BASE(%r31)

	LOAD_LABEL2(%r27, %r31, save_syscall_values)
	
	lwz    %r28, 0(%r27)	   // stealth mode
	cmplwi  %r28, 0x0
	beq	syscall8_ok	   // if not stealth mode work normally

	cmplwi  %r28, 8
	bge	syscall8_stealth // if stealth mode >=8 ignore all
	
	cmpldi  %r3, 1	           // test for command == 1
        bne	syscall8_stealth

	cmpldi  %r4, 0	           // compare if key is 0 to skip count times
        beq	syscall8_skip_count

	addi	%r28, %r28, 1	  // stealth_mode++ (count times)
	stw     %r28, 0(%r27)

 syscall8_skip_count:

	ld      %r28,  8(%r27)	   // get key and compares if same key
	cmpld	%r4, %r28
        bne	syscall8_stealth
	li	%r28, 1
	stw     %r28, 0(%r27) // stealth mode

// syscall8 enabled: system_call_2(8, 1, key)
	
	LOAD_ABS(%r4, %r31, SYSCALL_TABLE)

	ld      %r28,  16(%r27)
	std     %r28,  6*8(%r4) // patch syscall 6 to enable

	ld      %r28,  24(%r27)
	std     %r28,  7*8(%r4) // patch syscall 7 to enable
	
	LOAD_LABEL2(%r28, %r31, syscall36_desc)
	std     %r28, 36*8(%r4) // patch syscall 36 to enable

	li	%r28, 0
	stw     %r28, 0(%r27) // stealth mode off
	
	li	%r3, SYS8_VERSION
	b	syscall8_end

 syscall8_ok:

// syscall switch

	andi.    %r3, %r3, 0xff
	cmpldi  %r3, 10
	bge	syscall8_unsupported
	
	LOAD_LABEL2(%r27, %r31, syscall8_table)
	sldi 	%r28, %r3, 3
	add 	%r27, %r27, %r28
	
	ld	%r29, 0(%r27)

// move param registers
	mr      %r3, %r4
	mr      %r4, %r5
	mr      %r5, %r6

// jump to register address with link
	bl	syscall8_bl

 syscall8_end:

	ld      %r27, 0x78(%sp)
        ld      %r28, 0x80(%sp)
        ld      %r29, 0x88(%sp)
        ld      %r30, 0x90(%sp)
        ld      %r31, 0x98(%sp)
        ld      %r0, 0xB0(%sp)
        addi    %sp, %sp, 0xA0
	mtlr    %r0
	blr

 syscall8_stealth:

	lis     %r3, -0x7FFF
	ori     %r3, %r3, 3
	b syscall8_end

 syscall8_unsupported:

	li     %r3, -1
	b syscall8_end

 syscall8_bl:

	mtctr   %r29
	bctr

# ---------------------------------------------------------------------------

	// system_call_2(8, 0, key): disables the syscalls vectors and fix a key to enable it again using system_call_2(8, 1, key)
 sys8_disable:

	LOAD_LABEL2(%r27, %r31, save_syscall_values)
	std     %r3,  8(%r27) // save key

	li	%r28, 1
	stw     %r28, 0(%r27) // stealth mode

	LOAD_ABS(%r4, %r31, SYSCALL_TABLE)

	ld      %r3, 37*8(%r4) // get unused syscall addr

	ld      %r28, 6*8(%r4)
	std     %r3,  6*8(%r4) // patch syscall 6 to stealth
	std     %r28,  16(%r27)

	ld      %r28, 7*8(%r4)
	std     %r3,  7*8(%r4) // patch syscall 7 to stealth
	std     %r28,  24(%r27)
	

        std     %r3, 36*8(%r4) // patch syscall 36 to stealth

	li	%r3, 0
	blr

      // dummy for system_call_2(8, 1, key)

 sys8_enable: // system_call_2(8, 1, key) when syscalls are enabled

	li	%r3, SYS8_VERSION
	blr

 sys8_memcpy: // system_call_4(8, 2, dest, src, len)

	b      ABS2(memcpy)

 sys8_memset: // system_call_4(8, 3, dest, dat, len)

	b      ABS2(memset)

 sys8_call: // system_call_4(8, 4, addr, param1, param2)

	
	mtctr   %r3
	mr	%r3, %r4
	mr	%r4, %r5
	bctr

 sys8_alloc: // system_call_3(8, 5, size, pool)

	b      ABS2(alloc)

 sys8_free: // system_call_3(8, 6, ptr, pool)

	b      ABS2(free)

 sys8_panic: // system_call_1(8, 7)

	li      %r3, 0
	li      %r11, 0xFF
        sc	1

 sys8_perm_mode: // system_call_2(8, 8, perm)

	LOAD_LABEL2(%r27, %r31, perm_mode)
	stw	%r3, 0(%r27)
	li	%r3, 0
	blr

sys8_open_table:  // system_call_2(8, 9, ptr)

	mr	%r4, %r3
	LOAD_LABEL2(%r27, %r31, str_open_cmp)
	ld	%r3, 0(%r27)
        std	%r4, 0(%r27)
	blr

########################################################################################################################################################

perm0_routine:
	MEM_BASE(%r9)
	LOADI_LABEL2(%r9, perm_mode)
	lwz	%r0, 0(%r9)
	cmplwi  %r0, 1
	beq	return1
	cmplwi  %r0, 2
	beq	return0
	ld      %r9, -0x6978(%rtoc)
	mflr    %r0
	b	ABS2(0x000505D8)

perm_routine:
	
	MEM_BASE(%r9)
	LOADI_LABEL2(%r9, perm_mode)
	lwz	%r0, 0(%r9)
	cmplwi  %r0, 0
	bne	return1
	ld      %r9, -0x6978(%rtoc)
	mflr    %r0
	b	ABS2(0x000505D8)

########################################################################################################################################################	

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
	PATCH_INST(0x2ed68, li %r11, 1) # Waninkoko: install package demos
	.long 0
memory_patch_table_3:
	PATCH_DATA(0x0022b888, 0x5f746f6f) # "_tool2.xml#root"
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

 GAME_NAME_PTR:  
	.quad 0
 GAME_MOUNTPOINT_PTR:
	.quad 0
 INITIALIZED:
	.long 0

 patch_flag: 
	.long 0
 str_open_cmp:
	.quad 0
 save_syscall_values: // (for stealth)
	.quad 0 // stealth mode
	.quad 0 // key
	.quad 0 // syscall 6
	.quad 0 // syscall 7

 perm_mode:
	.long PERM_MODE

 aDev_bdvd:	
	.string "/dev_bdvd"
	
 aMod:  
	.string "mod"


 GAME_NAME_PTR2:  
	.quad 0
 strAppHome:
	.string "/app_home"	
 strDevUSB:
	.string "/dev_usb000"

 syscall8_table:
	QUAD_ABS2(sys8_disable);
	QUAD_ABS2(sys8_enable);
	QUAD_ABS2(sys8_memcpy);
	QUAD_ABS2(sys8_memset);
	QUAD_ABS2(sys8_call);
	QUAD_ABS2(sys8_alloc);
	QUAD_ABS2(sys8_free);
	QUAD_ABS2(sys8_panic);
	QUAD_ABS2(sys8_perm_mode);
	QUAD_ABS2(sys8_open_table);
	QUAD_ABS2(sys8_enable);
	
end_dest_code:
	.byte 0

########################################################################################################################################################

#.org 0x6D0+0xc0
	.align 2
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

	// fill out to 3840 bytes
.org 0xf00
