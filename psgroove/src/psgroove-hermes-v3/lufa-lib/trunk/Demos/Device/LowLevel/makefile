#
#             LUFA Library
#     Copyright (C) Dean Camera, 2010.
#              
#  dean [at] fourwalledcubicle [dot] com
#      www.fourwalledcubicle.com
#

# Makefile to build all the LUFA Device Demos. Call with "make all" to
# rebuild all Device demos.

# Projects are pre-cleaned before each one is built, to ensure any
# custom LUFA library build options are reflected in the compiled
# code.

all:
	$(MAKE) -C AudioInput clean
	$(MAKE) -C AudioInput all

	$(MAKE) -C AudioOutput clean
	$(MAKE) -C AudioOutput all

	$(MAKE) -C DualVirtualSerial clean
	$(MAKE) -C DualVirtualSerial all

	$(MAKE) -C GenericHID clean
	$(MAKE) -C GenericHID all

	$(MAKE) -C Joystick clean
	$(MAKE) -C Joystick all

	$(MAKE) -C Keyboard clean
	$(MAKE) -C Keyboard all

	$(MAKE) -C KeyboardMouse clean
	$(MAKE) -C KeyboardMouse all

	$(MAKE) -C MassStorage clean
	$(MAKE) -C MassStorage all

	$(MAKE) -C MIDI clean
	$(MAKE) -C MIDI all

	$(MAKE) -C Mouse clean
	$(MAKE) -C Mouse all

	$(MAKE) -C RNDISEthernet clean
	$(MAKE) -C RNDISEthernet all

	$(MAKE) -C VirtualSerial clean
	$(MAKE) -C VirtualSerial all

%:
	$(MAKE) -C AudioInput $@
	$(MAKE) -C AudioOutput $@
	$(MAKE) -C DualVirtualSerial $@
	$(MAKE) -C GenericHID $@
	$(MAKE) -C Joystick $@
	$(MAKE) -C Keyboard $@
	$(MAKE) -C KeyboardMouse $@
	$(MAKE) -C MassStorage $@
	$(MAKE) -C MIDI $@
	$(MAKE) -C Mouse $@
	$(MAKE) -C RNDISEthernet $@
	$(MAKE) -C VirtualSerial $@
