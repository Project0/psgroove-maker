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


			/** LED mask for the LEDs on the board. */
			{LEDS_LED_X}

			/** Real Ports*/
			{LEDS_PORT_X_X_LED}

			
			/** LED mask for all the LEDs on the board. */
			#define LEDS_ALL_LEDS    {LED_MASK}

			/** LED mask for the none of the board LEDs. */
			#define LEDS_NO_LEDS     {LEDS_NO_LEDS}

		/* Inline Functions: */
		#if !defined(__DOXYGEN__)
			static inline void LEDs_Init(void)
			{
				/** set direction */
				{LED_SET_DDRX}
				
				/** set off leds */
				
				{LEDS_ALL_OFF}
				
				
			}
			
			static inline void LEDs_TurnOnLEDs(const uint8_t LEDMask)
			{
			
				{LEDS_TURN_ON_LEDS}
			}

			static inline void LEDs_TurnOffLEDs(const uint8_t LEDMask)
			{
				{LEDS_TURN_OFF_LEDS}
			}

			static inline void LEDs_SetAllLEDs(const uint8_t LEDMask)
			{
				{LEDS_SET_ALL_LEDS}
				
			}
			
			static inline void LEDs_ChangeLEDs(const uint8_t LEDMask,
			                                   const uint8_t ActiveMask)
			{

				{LEDS_CHANGE_LEDS}
				
			}
			
			static inline void LEDs_ToggleLEDs(const uint8_t LEDMask)
			{
				{LEDS_TOGGLE_LEDS}
			}
			
			static inline uint8_t LEDs_GetLEDs(void) ATTR_WARN_UNUSED_RESULT;
			static inline uint8_t LEDs_GetLEDs(void)
			{
			    unsigned int cur_led_mask = 0;
				
				{LEDS_GET_LEDS}
							
				return (cur_led_mask);
			}
		#endif

	/* Disable C linkage for C++ Compilers: */
		#if defined(__cplusplus)
			}
		#endif
		
#endif

/** @} */
