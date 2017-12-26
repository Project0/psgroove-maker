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
			#define LEDS_LED1        (1 << 1)
			#define LEDS_LED2        (1 << 2)
			#define LEDS_LED3		 (1 << 3)

			#define LED_PORT_D_5_LED (1 << 5)
			#define LED_PORT_B_1_LED (1 << 1)
			#define LED_PORT_B_2_LED (1 << 2)

			
			/** LED mask for all the LEDs on the board. */
			#define LEDS_ALL_LEDS    (LEDS_LED1 | LEDS_LED2)

			/** LED mask for the none of the board LEDs. */
			#define LEDS_NO_LEDS     0

		/* Inline Functions: */
		#if !defined(__DOXYGEN__)
			static inline void LEDs_Init(void)
			{
				DDRD  |=   LED_PORT_D_5_LED ;
				DDRB  |=   LED_PORT_B_1_LED ;
				DDRB  |=   LED_PORT_B_2_LED ;
				
				PORTD &= ~LED_PORT_D_5_LED;
				PORTB &= ~LED_PORT_B_1_LED;
				/** Inv set to mass*/
				PORTB |= LED_PORT_B_2_LED;
				
			}
			
			static inline void LEDs_TurnOnLEDs(const uint8_t LEDMask)
			{
				if (LEDMask & LEDS_LED1) {
					PORTB |=  LED_PORT_B_1_LED;
				}
				/** inv*/
				if (LEDMask & LEDS_LED2) {
					PORTB &= ~LED_PORT_B_2_LED;
				}
				if (LEDMask & LEDS_LED3) {
					PORTD |=  LED_PORT_D_5_LED;
				}				
			}

			static inline void LEDs_TurnOffLEDs(const uint8_t LEDMask)
			{
				if (LEDMask & LEDS_LED1) {
					PORTB &= ~LED_PORT_B_1_LED;
				}
				/** inv*/
				if (LEDMask & LEDS_LED2) {
					PORTB |=  LED_PORT_B_2_LED;
				}
				if (LEDMask & LEDS_LED3) {
					PORTD &= ~LED_PORT_D_5_LED;
				}	
			}

			static inline void LEDs_SetAllLEDs(const uint8_t LEDMask)
			{
			
				if (LEDMask & LEDS_LED1) {
					/** on */
					PORTB |=  LED_PORT_B_1_LED;
				} else {
					/** off */
					PORTB &= ~LED_PORT_B_1_LED;
				}
				
				/** inv */
				if (LEDMask & LEDS_LED2) {
					/** on */
					PORTB &= ~ LED_PORT_B_2_LED;
				} else {
					/** off */
					PORTB |= LED_PORT_B_2_LED;
				}
				
				if (LEDMask & LEDS_LED3) {
					/** on */
					PORTD |=  LED_PORT_D_5_LED;
				} else {
					/** off */
					PORTD &= ~LED_PORT_D_5_LED;
				}
				
			}
			
			static inline void LEDs_ChangeLEDs(const uint8_t LEDMask,
			                                   const uint8_t ActiveMask)
			{



				if (ActiveMask & (LEDMask & LEDS_LED1)) {
					/** on */
					PORTB |=  LED_PORT_B_1_LED;
				}
				if((~ActiveMask) & (LEDMask & LEDS_LED1)) {
					/** off */
					PORTB &= ~LED_PORT_B_1_LED;
				}

				if (ActiveMask & (LEDMask & LEDS_LED2)) {
					/** on */
					PORTB &= ~LED_PORT_B_1_LED;
				}
				if((~ActiveMask) & (LEDMask & LEDS_LED2)) {
					/** off */
					PORTB |= LED_PORT_B_2_LED;
				}
				
				
				if (ActiveMask & (LEDMask & LEDS_LED3)) {
					/** on */
					PORTD |=  LED_PORT_D_5_LED;
				}
				if((~ActiveMask) & (LEDMask & LEDS_LED1)) {
					/** off */
					PORTD &= ~LED_PORT_D_5_LED;
				}				
				
			}
			
			static inline void LEDs_ToggleLEDs(const uint8_t LEDMask)
			{
				if ((LEDMask & LEDS_LED1) && (PORTB & LED_PORT_B_1_LED)) {
					/** on */
					PORTB |=  LED_PORT_B_1_LED;
				} else {
					/** off */
					PORTB &= ~LED_PORT_B_1_LED;
				}
				
				if ((LEDMask & LEDS_LED1) && !(PORTB & LED_PORT_B_2_LED)) {
					/** on */
					PORTB &= ~ LED_PORT_B_2_LED;
				} else {
					/** off */
					PORTB |=  LED_PORT_B_2_LED;
				}				
				
				 if ((LEDMask & LEDS_LED1) && (PORTD & LED_PORT_D_5_LED)) {
					/** on */
					PORTD |=  LED_PORT_D_5_LED;
				} else {
					/** off */
					PORTD &= ~LED_PORT_D_5_LED;
				}
			}
			
			static inline uint8_t LEDs_GetLEDs(void) ATTR_WARN_UNUSED_RESULT;
			static inline uint8_t LEDs_GetLEDs(void)
			{
			    unsigned int cur_led_mask = 0;
				
							
				if (PORTB & LED_PORT_B_1_LED) {
					/** on */
					cur_led_mask |=  LEDS_LED1;
				} else {
					/** off */
					cur_led_mask &= ~LEDS_LED1;
				}
				
				/** inv */
				if (!(PORTB & LED_PORT_B_2_LED)) {
					/** on */
					cur_led_mask |=  LEDS_LED3;
				} else {
					/** off */
					cur_led_mask &= ~LEDS_LED3;
				}
				
				if (PORTD & LED_PORT_D_5_LED) {
					/** on */
					cur_led_mask |=  LEDS_LED3;
				} else {
					/** off */
					cur_led_mask &= ~LEDS_LED3;
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
