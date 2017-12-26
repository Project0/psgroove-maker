#ifndef __LEDS_USBKEY_H__
#define __LEDS_USBKEY_H__
#include <avr/io.h>
#include "lufa-lib/trunk/LUFA/Common/Common.h"

#if defined(__cplusplus)
			extern "C" {
#endif

		#if !defined(__INCLUDE_FROM_LEDS_H)
			#error Do not include this file directly. Include LUFA/Drivers/Board/LEDS.h instead.
		#endif


			/** LED mask for the first LED on the board. */
			{LEDS_LED_X}
			
			/** LED mask for all the LEDs on the board. */
			#define LEDS_ALL_LEDS    ({LED_MASK})

			/** LED mask for the none of the board LEDs. */
			#define LEDS_NO_LEDS     0

		/* Inline Functions: */
		#if !defined(__DOXYGEN__)
			static inline void LEDs_Init(void)
			{
				{DDR_X}  |=  LEDS_ALL_LEDS;
				{PORT_X} &= ~LEDS_ALL_LEDS;
			}
			
			static inline void LEDs_TurnOnLEDs(const uint8_t LEDMask)
			{
				{PORT_X} |= LEDMask;
			}

			static inline void LEDs_TurnOffLEDs(const uint8_t LEDMask)
			{
				{PORT_X} &= ~LEDMask;
			}

			static inline void LEDs_SetAllLEDs(const uint8_t LEDMask)
			{
				{PORT_X} = (({PORT_X} & ~LEDS_ALL_LEDS) | LEDMask);
			}
			
			static inline void LEDs_ChangeLEDs(const uint8_t LEDMask,
			                                   const uint8_t ActiveMask)
			{
				{PORT_X} = (({PORT_X} & ~LEDMask) | ActiveMask);
			}
			
			static inline void LEDs_ToggleLEDs(const uint8_t LEDMask)
			{
				{PORT_X} = ({PORT_X} ^ (LEDMask & LEDS_ALL_LEDS));
			}
			
			static inline uint8_t LEDs_GetLEDs(void) ATTR_WARN_UNUSED_RESULT;
			static inline uint8_t LEDs_GetLEDs(void)
			{
				return ({PORT_X} & LEDS_ALL_LEDS);
			}
		#endif

	/* Disable C linkage for C++ Compilers: */
		#if defined(__cplusplus)
			}
		#endif
		
#endif

/** @} */
