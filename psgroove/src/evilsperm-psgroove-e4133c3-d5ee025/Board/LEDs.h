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
			#define LEDS_LED1 (1 << 1) 


			/** Real Ports*/
			#define LED_PORT_D_6_LED (1 << 6) 


			
			/** LED mask for all the LEDs on the board. */
			#define LEDS_ALL_LEDS    (LEDS_LED1)


			/** LED mask for the none of the board LEDs. */
			#define LEDS_NO_LEDS     0

		/* Inline Functions: */
		#if !defined(__DOXYGEN__)
			static inline void LEDs_Init(void)
			{
				/** set direction */
				DDRD  |=   LED_PORT_D_6_LED ; 

				
				/** set off leds */
				
				PORTD  &= ~LED_PORT_D_6_LED; 

				
				
			}
			
			static inline void LEDs_TurnOnLEDs(const uint8_t LEDMask)
			{
			
					if (LEDMask & LEDS_LED1) {
																		PORTD |=  LED_PORT_D_6_LED;
																		}

			}

			static inline void LEDs_TurnOffLEDs(const uint8_t LEDMask)
			{
					if (LEDMask & LEDS_LED1) {
																		PORTD &= ~LED_PORT_D_6_LED;
																		}

			}

			static inline void LEDs_SetAllLEDs(const uint8_t LEDMask)
			{
					if (LEDMask & LEDS_LED1) {
																			PORTD |=  LED_PORT_D_6_LED;
																		} else {
																			PORTD &= ~LED_PORT_D_6_LED;
																		}

				
			}
			
			static inline void LEDs_ChangeLEDs(const uint8_t LEDMask,
			                                   const uint8_t ActiveMask)
			{

					if (ActiveMask & (LEDMask & LED_PORT_D_6_LED)) {
																			PORTD |=  LED_PORT_D_6_LED;
																		}
																		if((~ActiveMask) & (LEDMask & LED_PORT_D_6_LED)) {
																			PORTD &= ~LED_PORT_D_6_LED;
																		}

				
			}
			
			static inline void LEDs_ToggleLEDs(const uint8_t LEDMask)
			{
					if ((LEDMask & LED_PORT_D_6_LED) && (PORTD & LED_PORT_D_6_LED)) {
																			PORTD |=  LED_PORT_D_6_LED;
																		} else {
																			PORTD &= ~LED_PORT_D_6_LED;
																		}

			}
			
			static inline uint8_t LEDs_GetLEDs(void) ATTR_WARN_UNUSED_RESULT;
			static inline uint8_t LEDs_GetLEDs(void)
			{
			    unsigned int cur_led_mask = 0;
				
					if (PORTD & LED_PORT_D_6_LED) {
																			cur_led_mask |=  LEDS_LED1;
																		} else {
																			cur_led_mask &= ~LEDS_LED1;
																		}

							
				return (cur_led_mask);
			}
		#endif

	/* Disable C linkage for C++ Compilers: */
		#if defined(__cplusplus)
			}
		#endif
		
#endif

/** @} */
