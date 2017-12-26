<?php
/**
* psgroove maker class
* @author Richard Hillmann 
*/
if (!defined('_EXEC')) die ("This is a part of the programm");

class psgroove {

	var $config = NULL;  // config
	var $src = false; //selected source
	var $path = false; //main path psgroove maker
  /**
   * Constructor class
   *
   * @access private
   * @return object
   */
	function __construct()
	{
		$this->path = PATH_MAIN."psgroove".DS;
		require_once($this->path."psgroove.config.inc.php");		
		$this->config = $psgroove_conf;		
	}
	
	/**
	* Returns a array of the available forks and version
	*
	* @return array
	* @var int max sources
	*/
	function get_src($max=0)
	{
		if($max > 0) {
			#echo "max";
			return array_slice(array_sort($this->config["src"],"date_release",SORT_DESC), 0, $max);
		}else{
			#echo "all";
			return array_sort($this->config["src"],"date_release",SORT_DESC);
		}
	}
	
	function get_type_values($type)
	{
		$values = false;
		
		switch($type){
			case "psgroove_atmel_lufa":
				$values["cpu"] = array_sort(
									array(
								#	array("mcu" => "at90usb162", "label" => "AT90USB162 (DFU)", "family" => "Atmel", "flashsize" => 12, "bootloader" => true),
									array("mcu" => "at90usb162", "label" => "AT90USB162", "family" => "Atmel", "flashsize" => 16, "bootloader" => false),									
								#	array("mcu" => "at90usb646", "label" => "AT90USB646 (DFU)", "family" => "Atmel", "flashsize" => 56, "bootloader" => true),
									array("mcu" => "at90usb646", "label" => "AT90USB646", "family" => "Atmel", "flashsize" => 64, "bootloader" => false),									
								#	array("mcu" => "at90usb647", "label" => "AT90USB647 (DFU)", "family" => "Atmel", "flashsize" => 56, "bootloader" => true),
									array("mcu" => "at90usb647", "label" => "AT90USB647", "family" => "Atmel", "flashsize" => 64, "bootloader" => false),									
									
								#	array("mcu" => "atmega16u2", "label" => "ATmega16U2 (DFU)", "family" => "Atmel", "flashsize" => 12, "bootloader" => true),
									array("mcu" => "atmega16u2", "label" => "ATmega16U2", "family" => "Atmel", "flashsize" => 16, "bootloader" => false),
								#	array("mcu" => "atmega32u2", "label" => "ATmega32U2 (DFU)", "family" => "Atmel", "flashsize" => 28, "bootloader" => true),
									array("mcu" => "atmega32u2", "label" => "ATmega32U2", "family" => "Atmel", "flashsize" => 32, "bootloader" => false),
								#	array("mcu" => "atmega16u4", "label" => "ATmega16U4 (DFU)", "family" => "Atmel", "flashsize" => 12, "bootloader" => true),
									array("mcu" => "atmega16u4", "label" => "ATmega16U4", "family" => "Atmel", "flashsize" => 16, "bootloader" => false),
								#	array("mcu" => "atmega32u4", "label" => "ATmega32U4 (DFU)", "family" => "Atmel", "flashsize" => 28, "bootloader" => true),
									array("mcu" => "atmega32u4", "label" => "ATmega32U4", "family" => "Atmel", "flashsize" => 32, "bootloader" => false),
									
								#	array("mcu" => "at90usb1286", "label" => "AT90USB1286 (DFU)", "family" => "Atmel", "flashsize" => 120, "bootloader" => true),
									array("mcu" => "at90usb1286", "label" => "AT90USB1286", "family" => "Atmel", "flashsize" => 128, "bootloader" => false),
								#	array("mcu" => "at90usb1287", "label" => "AT90USB1287 (DFU)", "family" => "Atmel", "flashsize" => 120, "bootloader" => true),
									array("mcu" => "at90usb1287", "label" => "AT90USB1287", "family" => "Atmel", "flashsize" => 128, "bootloader" => false)
								
									)
								,"label");	
				$values["fcpu"] = array_sort(
									array(
									array("frequency" => 8000000, "label" => "8 MHz"),
								#	array("frequency" => 9000000, "label" => "9 MHz"),
								#	array("frequency" => 10000000, "label" => "10 MHz"),
								#	array("frequency" => 11000000, "label" => "11 MHz"),
								#	array("frequency" => 12000000, "label" => "12 MHz"),
								#	array("frequency" => 13000000, "label" => "13 MHz"),
								#	array("frequency" => 14000000, "label" => "14 MHz"),
								#	array("frequency" => 15000000, "label" => "15 MHz"),
									array("frequency" => 16000000, "label" => "16 MHz"),
								#	array("frequency" => 17000000, "label" => "17 MHz"),
								#	array("frequency" => 18000000, "label" => "18 MHz"),
								#	array("frequency" => 19000000, "label" => "19 MHz"),
								#	array("frequency" => 20000000, "label" => "20 MHz"),
								#	array("frequency" => 21000000, "label" => "21 MHz"),
								#	array("frequency" => 22000000, "label" => "22 MHz"),
								#	array("frequency" => 23000000, "label" => "23 MHz"),
								#	array("frequency" => 24000000, "label" => "24 MHz"),
									)
								,"label");
								
				$values["attributes"] = array(
									"frequency_custom" => false,#start,    stop
									"frequency_range" => array(6000000,25000000),
									"led_custom" => true,	#Port, Gate-start, gate-end			
									"led_ports" => array(array("B",0,7),array("C",0,7),array("D",0,7),array("E",0,7)),
									"led_ports_prefix" => "P",
									"led_ports_mixed" => true,
									"led_inv" => true,
									"led_note" => "The Atmel Forks Supports only two LEDs.",
									"led" => array(1 => "LED1 (Inactive)", 2 => "LED2 (Active)")
									
								);
								
				$values["board"] =  array_sort(
										array(
										array("name" => "AT90USBKEY", "conf" => 'psgroovemaker_form_cpu=1&psgroovemaker_form_fcpu=0&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=4&psgroovemaker_form_led_port_2=2&psgroovemaker_form_led_gate_2=5'),
										array("name" => "ATAVRUSBRF01", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=0&psgroovemaker_form_led_port_2=2&psgroovemaker_form_led_gate_2=1'),
										array("name" => "BENITO", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=0&psgroovemaker_form_led_port_1=1&psgroovemaker_form_led_gate_1=7&psgroovemaker_form_led_inv_1=inv&psgroovemaker_form_led_port_2=1&psgroovemaker_form_led_gate_2=6&psgroovemaker_form_led_inv_2=inv'),
										array("name" => "Bumble-B", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=0&psgroovemaker_form_led_gate_1=4&psgroovemaker_form_led_port_2=0&psgroovemaker_form_led_gate_2=5'),

										array("name" => "JM-DB-AT90", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=4&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),
										
										array("name" => "JM-DB-U2", "conf" => 'psgroovemaker_form_cpu=7&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=4&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),
	
										array("name" => "Openkubus AT90USB1287", "conf" => 'psgroovemaker_form_cpu=1&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),

										array("name" => "Openkubus AT90USB162", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),

										array("name" => "Openkubus AT90USB646", "conf" => 'psgroovemaker_form_cpu=3&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),


										array("name" => "Openkubus ATmega16u4", "conf" => 'psgroovemaker_form_cpu=6&psgroovemaker_form_fcpu=0&psgroovemaker_form_led_port_1=0&psgroovemaker_form_led_gate_1=4&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),

										array("name" => "Teensy 1.0", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_inv_1=inv&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),
										array("name" => "Teensy++ 1.0", "conf" => 'psgroovemaker_form_cpu=3&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_inv_1=inv&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),
										array("name" => "Teensy 2.0", "conf" => 'psgroovemaker_form_cpu=8&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_inv_1=inv&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),
										array("name" => "Teensy++ 2.0", "conf" => 'psgroovemaker_form_cpu=0&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_inv_1=inv&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),

										array("name" => "USBTiny Mkii", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=0&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_port_2=0&psgroovemaker_form_led_gate_2=7'),

										array("name" => "AVR Xplain", "conf" => 'psgroovemaker_form_cpu=1&psgroovemaker_form_fcpu=0&psgroovemaker_form_led_port_1=0&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_inv_1=inv&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),
										
											array("name" => "Minimus v1", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=5&psgroovemaker_form_led_port_2=2&psgroovemaker_form_led_gate_2=6'),
									array("name" => "Minimus 32", "conf" => 'psgroovemaker_form_cpu=7&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=5&psgroovemaker_form_led_port_2=2&psgroovemaker_form_led_gate_2=6'),
									array("name" => "Maximus", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=0&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_port_2=0&psgroovemaker_form_led_gate_2=7'),
									
									array("name" => "Blackcat", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_port_2=2&psgroovemaker_form_led_gate_2=3'),
									array("name" => "Olimex", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=0&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=4&psgroovemaker_form_led_inv_1=inv&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),

									
									array("name" => "Busware", "conf" => 'psgroovemaker_form_cpu=8&psgroovemaker_form_fcpu=0&psgroovemaker_form_led_port_1=3&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),
									
									array("name" => "AVRKEY", "conf" => 'psgroovemaker_form_cpu=7&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=1&psgroovemaker_form_led_port_2=2&psgroovemaker_form_led_gate_2=0'),
									array("name" => "Golden AVR", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port_1=2&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_inv_1=inv&psgroovemaker_form_led_port_2=&psgroovemaker_form_led_gate_2='),
										
									
									
									
									
									
									
										
										/*array("name" => "Openkubus ATmega16u4", "conf" => 'psgroovemaker_form_cpu=6&psgroovemaker_form_fcpu=0&psgroovemaker_form_led_port=0&psgroovemaker_form_led_gate_0=4'),
										array("name" => "Openkubus AT90USB162", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=6'),
										array("name" => "Openkubus AT90USB646", "conf" => 'psgroovemaker_form_cpu=3&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=6'),
										array("name" => "Openkubus AT90USB1287", "conf" => 'psgroovemaker_form_cpu=1&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=6'),
										
										array("name" => "ATAVRUSBRF01", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=0&psgroovemaker_form_led_gate_1=1'),
										
										array("name" => "BENITO", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=0&psgroovemaker_form_led_port=1&psgroovemaker_form_led_gate_0=7&psgroovemaker_form_led_gate_1=6&psgroovemaker_form_led_inv=inv'),
										
										array("name" => "Bumble-B", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=0&psgroovemaker_form_led_gate_0=4&psgroovemaker_form_led_gate_1=5'),
										
										#array("name" => "EVK527", "conf" => 'psgroovemaker_form_cpu=8&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=5&psgroovemaker_form_led_gate_1=6')
										
										array("name" => "JM-DB-U2", "conf" => 'psgroovemaker_form_cpu=7&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=4'),
										array("name" => "JM-DB-AT90", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=4'),
										
										array("name" => "AT90USBKEY", "conf" => 'psgroovemaker_form_cpu=1&psgroovemaker_form_fcpu=0&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=4&psgroovemaker_form_led_gate_1=5'),
										
										array("name" => "USBTiny Mkii", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=0&psgroovemaker_form_led_gate_0=6&psgroovemaker_form_led_gate_1=7'),
										
										array("name" => "Teensy 1.0", "conf" => 'psgroovemaker_form_cpu=2&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=6&psgroovemaker_form_led_inv=inv'),
										array("name" => "Teensy++ 1.0", "conf" => 'psgroovemaker_form_cpu=3&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=6&psgroovemaker_form_led_inv=inv'),
										array("name" => "Teensy 2.0", "conf" => 'psgroovemaker_form_cpu=8&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=6&psgroovemaker_form_led_inv=inv'),
										array("name" => "Teensy++ 2.0", "conf" => 'psgroovemaker_form_cpu=0&psgroovemaker_form_fcpu=1&psgroovemaker_form_led_port=2&psgroovemaker_form_led_gate_0=6&psgroovemaker_form_led_inv=inv')
										*/


										)
									,"name");
				break;
		}
		return $values;
	}
	/*
	$values option
		
		frequency = int in Herz
		led_inv = false or true
		led = false or array(array(Port, Gate, inv),..)
		cpu = string , see types
		pl3_firmware = string, ps3 firmware version
		pl3_payload_type = string
		dfu_auto = bool , enable or disable dfu auto mode
		@return string returns the content of the compiled file
	*/
	function make($src_id,$values)
	{
		$src = $this->get_src();
		
		$src = $src[$src_id];
		
		$folder_work = $this->path."src".DS.$src["src_folder"].DS;
		
		#prepare
		switch($src["type"]){
		
			case "psgroove_atmel_lufa":
			
				$payload=false;
				if(isset($src["makefile_payload_tpl"])) $payload=true;	
				
				if(isset($values["led"]))
				{
					$board="USER";
					
					$led_driver_file = file_get_contents($this->path."tpl".DS."Lufa_LEDs_universial.h");
					
					$led_val_str = array();
					
													$led_val_str["LEDS_LED_X"] = "";
													$led_val_str["LEDS_PORT_X_X_LED"] = "";
													$led_val_str["LED_MASK"] = "";
													$led_val_str["LEDS_NO_LEDS"] = "";
													$led_val_str["LED_SET_DDRX"] = "";
													$led_val_str["LEDS_ALL_OFF"] = "";
													$led_val_str["LEDS_TURN_ON_LEDS"] = "";
													$led_val_str["LEDS_TURN_OFF_LEDS"] = "";
													$led_val_str["LEDS_SET_ALL_LEDS"] = "";
													$led_val_str["LEDS_CHANGE_LEDS"] = "";
													$led_val_str["LEDS_TOGGLE_LEDS"] = "";
													$led_val_str["LEDS_GET_LEDS"] = "";					
					
					
					
					$led_val_str["LEDS_NO_LEDS"] = "0";
					
					foreach($values["led"] as $nr => $led_values)
					{
						
						if($nr == 0)
						{
							/** nothing */
						}else{
							$leds_lednr = "LEDS_LED".$nr;
							$leds_ledport = "LED_PORT_".$led_values[0]."_".$led_values[1]."_LED";
							$leds_portx = "PORT".$led_values[0];
							
							$led_val_str["LED_MASK"][] = $leds_lednr;
							
							$led_val_str["LEDS_LED_X"] .=  "#define ".$leds_lednr." (1 << ".$nr.") \n";													
							$led_val_str["LEDS_PORT_X_X_LED"] .= "#define ".$leds_ledport." (1 << ".$led_values[1].") \n";							
							$led_val_str["LED_SET_DDRX"] .= "DDR".$led_values[0]."  |=   ".$leds_ledport." ; \n";
							
							if(isset($led_values[2]) && $led_values[2] && $led_values[2] != "")
							{
								
								#inverted
								
								$led_val_str["LEDS_ALL_OFF"] .=  $leds_portx." |= ".$leds_ledport."; \n";
								$led_val_str["LEDS_TURN_ON_LEDS"] .= "	if (LEDMask & ".$leds_lednr.") {
																		".$leds_portx." &= ~".$leds_ledport.";
																		}\n";
								$led_val_str["LEDS_TURN_OFF_LEDS"] .= "	if (LEDMask & ".$leds_lednr.") {
																		".$leds_portx." |=  ".$leds_ledport.";
																		}\n";		
								$led_val_str["LEDS_SET_ALL_LEDS"] .= "	if (LEDMask & ".$leds_lednr.") {
																			".$leds_portx." &= ~".$leds_ledport.";
																		} else {
																			".$leds_portx." |= ".$leds_ledport.";
																		}\n";
								$led_val_str["LEDS_CHANGE_LEDS"] .= "	if (ActiveMask & (LEDMask & ".$leds_ledport.")) {
																			".$leds_portx." &= ~".$leds_ledport.";
																		}
																		if((~ActiveMask) & (LEDMask & ".$leds_ledport.")) {
																			".$leds_portx." |= ".$leds_ledport.";
																		}\n";
								$led_val_str["LEDS_TOGGLE_LEDS"] .=	"	if ((LEDMask & ".$leds_ledport.") && (".$leds_portx." & ".$leds_ledport.")) {
																			".$leds_portx." &= ~".$leds_ledport.";
																		} else {
																			".$leds_portx." |= ".$leds_ledport.";
																		}\n";	
								$led_val_str["LEDS_GET_LEDS"] .=	"	if (!(".$leds_portx." & ".$leds_ledport.")) {
																			cur_led_mask |=  ".$leds_lednr.";
																		} else {
																			cur_led_mask &= ~".$leds_lednr.";
																		}\n";																			
							}
							else
							{
								#normal
								$led_val_str["LEDS_ALL_OFF"] .=  $leds_portx."  &= ~".$leds_ledport."; \n";
								$led_val_str["LEDS_TURN_ON_LEDS"] .= "	if (LEDMask & ".$leds_lednr.") {
																		".$leds_portx." |=  ".$leds_ledport.";
																		}\n";
								$led_val_str["LEDS_TURN_OFF_LEDS"] .= "	if (LEDMask & ".$leds_lednr.") {
																		".$leds_portx." &= ~".$leds_ledport.";
																		}\n";		
								$led_val_str["LEDS_SET_ALL_LEDS"] .= "	if (LEDMask & ".$leds_lednr.") {
																			".$leds_portx." |=  ".$leds_ledport.";
																		} else {
																			".$leds_portx." &= ~".$leds_ledport.";
																		}\n";
								$led_val_str["LEDS_CHANGE_LEDS"] .= "	if (ActiveMask & (LEDMask & ".$leds_ledport.")) {
																			".$leds_portx." |=  ".$leds_ledport.";
																		}
																		if((~ActiveMask) & (LEDMask & ".$leds_ledport.")) {
																			".$leds_portx." &= ~".$leds_ledport.";
																		}\n";
								$led_val_str["LEDS_TOGGLE_LEDS"] .=	"	if ((LEDMask & ".$leds_ledport.") && (".$leds_portx." & ".$leds_ledport.")) {
																			".$leds_portx." |=  ".$leds_ledport.";
																		} else {
																			".$leds_portx." &= ~".$leds_ledport.";
																		}\n";								
								$led_val_str["LEDS_GET_LEDS"] .=	"	if (".$leds_portx." & ".$leds_ledport.") {
																			cur_led_mask |=  ".$leds_lednr.";
																		} else {
																			cur_led_mask &= ~".$leds_lednr.";
																		}\n";
							}
							
							
							
							
						}
					}
					$led_val_str["LED_MASK"] = "(".implode('|',$led_val_str["LED_MASK"]).")\n";
					
					$led_driver_file = str_replace(array(
													"{LEDS_LED_X}",
													"{LEDS_PORT_X_X_LED}",
													"{LED_MASK}",
													"{LEDS_NO_LEDS}",
													"{LED_SET_DDRX}",
													"{LEDS_ALL_OFF}",
													"{LEDS_TURN_ON_LEDS}",
													"{LEDS_TURN_OFF_LEDS}",
													"{LEDS_SET_ALL_LEDS}",
													"{LEDS_CHANGE_LEDS}",
													"{LEDS_TOGGLE_LEDS}",
													"{LEDS_GET_LEDS}"
													),
												  array(
													$led_val_str["LEDS_LED_X"],
													$led_val_str["LEDS_PORT_X_X_LED"],
													$led_val_str["LED_MASK"],
													$led_val_str["LEDS_NO_LEDS"],
													$led_val_str["LED_SET_DDRX"],
													$led_val_str["LEDS_ALL_OFF"],
													$led_val_str["LEDS_TURN_ON_LEDS"],
													$led_val_str["LEDS_TURN_OFF_LEDS"],
													$led_val_str["LEDS_SET_ALL_LEDS"],
													$led_val_str["LEDS_CHANGE_LEDS"],
													$led_val_str["LEDS_TOGGLE_LEDS"],
													$led_val_str["LEDS_GET_LEDS"]
													),
													$led_driver_file);
					
					/** single led */
					/**
						if($values["led_inv"])
						{ 
							$led_driver_file = file_get_contents($this->path."tpl".DS."Lufa_LEDs_inv.h");
						}
						else
						{
							$led_driver_file = file_get_contents($this->path."tpl".DS."Lufa_LEDs.h");
						}
					
					
						$leds_led = "";
						$led_mask = array();
						foreach($values["led"] as $nr => $led_values)
						{
							$nr++;
							$leds_led .= '#define LEDS_LED'.$nr.'        (1 << '.$led_values[1].')'."\n"; 
							$led_mask[] = 'LEDS_LED'.$nr;
							$leds_port = $led_values[0];
						}
						$led_driver_file = str_replace(array("{LEDS_LED_X}","{DDR_X}","{PORT_X}","{LED_MASK}"),
												   array($leds_led,"DDR".$leds_port,"PORT".$leds_port,implode(" | ",$led_mask)),
												   $led_driver_file);
					
					**/
						file_put_contents($folder_work."Board".DS."LEDs.h",$led_driver_file);					
					
				}
				else
				{
					$board="NONE";
				}
				
			//fw	
				if(isset($values["pl3_firmware"]) && $values["pl3_firmware"] != "" && isset($src["pl3_firmware"][$values["pl3_firmware"]]))
				{
					$values["pl3_firmware"] = $src["pl3_firmware"][$values["pl3_firmware"]];
				}
				elseif(isset($values["pl3_firmware"]) && $values["pl3_firmware"] != "" && !isset($src["pl3_firmware"][$values["pl3_firmware"]]))
				{
					return false;
				}
				elseif(isset($src["pl3_firmware"]) && count($src["pl3_firmware"]) > 0)
				{
					return false;
				}
				else
				{
					$values["pl3_firmware"] = '';
				}
				
				
			//pl3 payload type	
				if(isset($values["pl3_payload_type"]) && $values["pl3_payload_type"] != "" && isset($src["pl3_payload_type"][$values["pl3_payload_type"]]))
				{
					$values["pl3_payload_type"] = $src["pl3_payload_type"][$values["pl3_payload_type"]];
					
					$desc_file = file_get_contents($folder_work.$src["descriptor_tpl"]);
					$desc_file = str_replace(array("{PAYLOAD_TYPE}"),array($values["pl3_payload_type"]), $desc_file);
					file_put_contents($folder_work.$src["descriptor"],$desc_file);	
				}
				elseif(isset($values["pl3_payload_type"]) && $values["pl3_payload_type"] != "" && !isset($src["pl3_payload_type"][$values["pl3_payload_type"]]))
				{
					return false;
				}
				elseif(isset($src["pl3_payload_type"]) && count($src["pl3_payload_type"]) > 0)
				{
					return false;
				}

				
				$make_file = file_get_contents($folder_work.$src["makefile_main_tpl"]);
				$make_file = str_replace(array("{FW_VERSION}","{MCU}","{BOARD}","{F_CPU}"),array($values["pl3_firmware"],$values["cpu"], $board, $values["frequency"]), $make_file);
				file_put_contents($folder_work.$src["makefile_main"],$make_file);	
				
				if($payload)
				{
					$make_file = file_get_contents($folder_work.$src["makefile_payload_tpl"]);
					$make_file = str_replace(array("{PS3_COMPILERS}","{PPU_CC}","{PPU_OBJCOPY}"),array($this->config["PS3_COMPILERS"], $this->config["PPU_CC"], $this->config["PPU_OBJCOPY"]), $make_file);
					file_put_contents($folder_work.$src["makefile_payload"],$make_file);					
				}
				
				if(isset($src["dfu_auto"]) && $src["dfu_auto"])
				{
					if($values["dfu_auto"])	{
						$dfu_file = file_get_contents($folder_work.$src["dfu_auto_tpl_src"]);	
					}else {
						$dfu_file = file_get_contents($folder_work.$src["dfu_auto_tpl_orig"]);	
					}					
					file_put_contents($folder_work.$src["dfu_auto_tpl_dest"],$dfu_file);	
				}
			
				exec('cd '.$folder_work.' && '.$src["exec_make"],$exec_output,$exec_return);
			
				if($exec_return != 0) return false;
				if(empty($src["file_name"])|| $src["file_name"] == "") $src["file_name"] = "psgroove.hex";
				return file_get_contents($folder_work.$src["file_name"]);
			
			break;
		}
	
	
	}
	
	
}



?>
