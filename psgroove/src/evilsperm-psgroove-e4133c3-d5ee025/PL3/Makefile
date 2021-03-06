B2HTARGET = $(CURDIR)/tools/bin2header
CFLAGS = -Wall -O3

PS3_COMPILERS= /opt/cell/toolchain/bin

CC = gcc
PPU_CC = $(PS3_COMPILERS)/ppu-gcc
PPU_OBJCOPY = $(PS3_COMPILERS)/ppu-objcopy

PPU_CFLAGS =

# This isn't enough, you must also add rules for the filename_fw with the -D define
SUPPORTED_FIRMWARES = 3.41 

PAYLOADS = shellcode_egghunt.bin \
	shellcode_panic.bin \
	dump_lv2.bin

FW_PAYLOADS = \
	default_payload.bin \
	payload_dump_elfs.bin \
	payload_dev.bin

FIRMWARES_2=$(SUPPORTED_FIRMWARES:2.%=2_%)
FIRMWARES=$(FIRMWARES_2:3.%=3_%)
FW_PAYLOADS_EXT = $(foreach fw,$(FIRMWARES), \
	$(foreach pl,$(FW_PAYLOADS),$(pl:%.bin=%_$(fw).bin)))
ALL_PAYLOADS = $(PAYLOADS) $(FW_PAYLOADS_EXT)

HEADERS = $(ALL_PAYLOADS:%.bin=%.h)

MAX_PAYLOAD_SIZE=3808

all: tools $(ALL_PAYLOADS) $(HEADERS) check_sizes

tools:
	$(MAKE) -C tools

$(B2HTARGET): tools
	@true

check_sizes: $(ALL_PAYLOADS)
	@error=0; \
	 for f in $+; do \
		size=`ls -l $$f | awk '{print $$5}'`; \
		if [ $$size -gt $(MAX_PAYLOAD_SIZE) ]; then \
			echo "File $$f has a size of $$size."; \
			false; \
			error=1; \
		fi; \
	 done; \
	 if [ $$error -eq 1 ]; then \
		echo ""; \
		echo "The maximum allowed size for a payload is $(MAX_PAYLOAD_SIZE)"; \
		exit 1; \
	 fi; \
	 true


$(ALL_PAYLOADS): *.h.S config.h

%_3_01.o : %.S
	$(PPU_CC) $(PPU_CFLAGS) -DFIRMWARE_3_01 -c $< -o $@

%_3_10.o : %.S
	$(PPU_CC) $(PPU_CFLAGS) -DFIRMWARE_3_10 -c $< -o $@

%_3_15.o : %.S
	$(PPU_CC) $(PPU_CFLAGS) -DFIRMWARE_3_15 -c $< -o $@

%_3_41.o : %.S
	$(PPU_CC) $(PPU_CFLAGS) -DFIRMWARE_3_41 -c $< -o $@

%.o : %.S
	$(PPU_CC) $(PPU_CFLAGS) -c $< -o $@
%.bin : %.o
	$(PPU_OBJCOPY) -O binary $< $@
%.h : %.bin $(B2HTARGET)
	$(B2HTARGET) $< $@ $(*F)

# Target: clean project.
clean:
	$(MAKE) -C tools/ clean
	rm -f *~ *.bin $(ALL_PAYLOADS) $(HEADERS)

.PHONY: all clean tools check_sizes
