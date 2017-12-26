<?php

/**
* PSGroove Maker

 Changelog: 
 0.3:
	- psgroove auto dfu mode added.
	- pl3 payload select
	- archive mode added
	- filename specification at src config
 
 
 0.2:
	- more boards added to predefined config. 
	- new led driver structure and parser for lufa library, mixing of ports are now available. 
	- compatibility for pl3 added.
	
 
 0.1:
	-first release
* @author Richard Hillmann 
* @version 0.2
*/

/* Security constant */
define("_EXEC",true);
error_reporting(E_ALL);
require_once("main.inc.php");

/*if (locale_emulation()) {

	 echo 'php-gettext wird verwendet.<br /><br />';

} else {

	echo 'gettext wird nativ verwendet.<br /><br />';

}

*/
session_start();

*/
/** @global array $tpl Stored Data Array */
$tpl = array();

$tpl["www_path"] = $sysconf["www"]["path"];

/** @global array $tpl["msg"] User Informative messages */
$tpl["msg"] = array("error" => array(),"info" => array());

/** @global array $tpl["sessionid"] Current Session ID */
$tpl["sessionid"] = session_id();
	
/** Check Value for Forms. Prevent for unneeded POST vars, like refreshing page and send data again.*/
if(empty($_SESSION["form_check"])) $_SESSION["form_check"] = false;
$form_check =  $_SESSION["form_check"];
$tpl["form"]["check"] =  rand_str(8);
$_SESSION["form_check"] = $tpl["form"]["check"];


/*set theme*/
init_theme();

if(empty($_GET["do"])) $_GET["do"] = false;

$psgroove = new psgroove;


function switch_page($page, $continued = false)
{
	global $dbh;
	global $psgroove;
	global $tpl;
	
switch ($page) {
	
	

	case "build":
			$tpl["psgroove"]["src"] = $psgroove->get_src();
			
			#no source selected, switch back to page step1S
			if(!isset($_POST["psgroovemaker_form_src_id"]) || !isset($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]])){
				$tpl["msg"]["error"][] = 'Please select first a fork!';
				
				switch_page("step1",true);				
				return false;
			}
			$tpl["psgroove"]["src_id"] = $_POST["psgroovemaker_form_src_id"];
			$tpl["psgroove"]["src_name"] = $tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["name"].' - '.$tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["version"].'('.$tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["date_release"].')';
			
			#no  values sent
			if(!isset($_POST["psgroovemaker_form_values"]) || $_POST["psgroovemaker_form_values"] == ""){
				$tpl["msg"]["error"][] = 'Error while getting configuration!';
				
				switch_page("step2",false);				
				return false;
			}			
			
			$values =  crypt_decode_data(base64_decode($_POST["psgroovemaker_form_values"]));
			
			$checksum = md5($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["id"].print_r($values,true));
			
			$tpl["psgroove"]["checksum"] = $checksum;
			if(empty($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["file_name"]) || $tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["file_name"] == "") $tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["file_name"] = "psgroove.hex";
			$tpl["psgroove"]["filename"] = $tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["file_name"];
			$hex_dl = false;
			if(file_exists(PATH_MAIN."hex".DS.$checksum.".hex"))
			{
				$hex_dl = PATH_MAIN."hex".DS.$checksum.".hex";
			}
			else
			{
				$lockfile = PATH_MAIN."tmp".DS.$tpl["psgroove"]["src_id"].".lock";
				if(file_exists($lockfile))
				{
			
					$tpl["psgroove"]["values"] = addcslashes(base64_encode(crypt_encode_data($values)),'=+');;
					require_once(PATH_THEME."step3.php") ;
					return true;
				}
				else
				{
					file_put_contents($lockfile,'lock');
					set_time_limit(60*10);
					$hex_dl = PATH_MAIN."hex".DS.$checksum.".hex";
					
					$hex = $psgroove->make($tpl["psgroove"]["src_id"],$values);
					if($hex)
					{
						file_put_contents($hex_dl,$hex);
					}
					else
					{
						send_mail("richie@project0.de", "PSGroovemaker Error", "Error while building an hexfile\n\n".print_r($values,true));
						$tpl["msg"]["error"][] = "Something failed while building hex";
					}
					unlink($lockfile);
				}
			}
			
			
			require_once(PATH_THEME."build.php") ;
			
	
		break;
	case "step3":
			$tpl["psgroove"]["src"] = $psgroove->get_src();
			$values = array();
			
			#no source selected, switch back to page step1S
			if(!isset($_POST["psgroovemaker_form_src_id"]) || !isset($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]])){
				$tpl["msg"]["error"][] = 'Please select first a fork!';
				
				switch_page("step1",true);				
				return false;
			}
			$tpl["psgroove"]["src_id"] = $_POST["psgroovemaker_form_src_id"];
			$tpl["psgroove"]["src_name"] = $tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["name"].' - '.$tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["version"].'('.$tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["date_release"].')';
			
			$tpl["psgroove"]["type"] = $psgroove->get_type_values($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["type"]);
			
			
			#no cpu selected, switch back to page step2
			if(!isset($_POST["psgroovemaker_form_cpu"]) || !isset($tpl["psgroove"]["type"]["cpu"][$_POST["psgroovemaker_form_cpu"]])){
				$tpl["msg"]["error"][] = 'Please select CPU!';
				
				switch_page("step2",true);				
				return false;
			}
			#set cpu
			$values["cpu"] = $tpl["psgroove"]["type"]["cpu"][$_POST["psgroovemaker_form_cpu"]]["mcu"];
			
			if($tpl["psgroove"]["type"]["attributes"]["frequency_custom"])
			{
				
				#no frequency selected, switch back to page step2
				if(!isset($_POST["psgroovemaker_form_fcpu"],$_POST["psgroovemaker_form_fcpu_custom"]) || (!isset($tpl["psgroove"]["type"]["fcpu"][$_POST["psgroovemaker_form_fcpu"]]) && $_POST["psgroovemaker_form_fcpu_custom"] == "")){
					$tpl["msg"]["error"][] = 'Please select Frequency!';
				
					switch_page("step2",true);				
					return false;
				}
			
		
				#wrong frequency entered, switch back to page step2
				if($_POST["psgroovemaker_form_fcpu_custom"] != "" 
					&& ( $_POST["psgroovemaker_form_fcpu_custom"] < $tpl["psgroove"]["type"]["attributes"]["frequency_range"][0]  
					||   $_POST["psgroovemaker_form_fcpu_custom"] > $tpl["psgroove"]["type"]["attributes"]["frequency_range"][1]  )){
				
					$tpl["msg"]["error"][] =  'Please insert a correct frequency in given Range!';
				
					switch_page("step2",true);				
					return false;
				}	
			}
			else
			{
			
				#no frequency selected, switch back to page step2
				if(!isset($_POST["psgroovemaker_form_fcpu"]) || !isset($tpl["psgroove"]["type"]["fcpu"][$_POST["psgroovemaker_form_fcpu"]])){
					$tpl["msg"]["error"][] = 'Please select Frequency!';
				
					switch_page("step2",true);				
					return false;
				}
						
			}
			
			
			#set frequency
			if(isset($_POST["psgroovemaker_form_fcpu_custom"]) && $_POST["psgroovemaker_form_fcpu_custom"] != "") {
				$values["frequency"] = $_POST["psgroovemaker_form_fcpu_custom"];
			}else {
				$values["frequency"] = $tpl["psgroove"]["type"]["fcpu"][$_POST["psgroovemaker_form_fcpu"]]["frequency"];
			}

			#pl3 firmware			
			if(isset($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["pl3_firmware"])) {
				
					if(!isset($_POST["psgroovemaker_form_pl3_firmware"]) || !isset($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["pl3_firmware"][$_POST["psgroovemaker_form_pl3_firmware"]]))
					{
						$tpl["msg"]["error"][] =  'Please select your Firmware version!';
							
						switch_page("step2",true);				
						return false;
					}
					$values["pl3_firmware"] = $_POST["psgroovemaker_form_pl3_firmware"];
			}

			
			#pl3 payload			
			if(isset($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["pl3_payload_type"])) {
				
					if(!isset($_POST["psgroovemaker_form_pl3_payload_type"]) || !isset($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["pl3_payload_type"][$_POST["psgroovemaker_form_pl3_payload_type"]]))
					{
						$tpl["msg"]["error"][] =  'Please select your Payload!';
							
						switch_page("step2",true);				
						return false;
					}
					$values["pl3_payload_type"] = $_POST["psgroovemaker_form_pl3_payload_type"];
			}
			
			#dfu auto mode			
			if(isset($_POST["psgroovemaker_form_dfu_auto"]) && $_POST["psgroovemaker_form_dfu_auto"] == "dfu")
				 {
					$values["dfu_auto"] = true;
				}else {
					$values["dfu_auto"] = false;
				}			
			
			#leds
			$led_selected = array();
			if($tpl["psgroove"]["type"]["attributes"]["led_custom"] && !$tpl["psgroove"]["type"]["attributes"]["led_ports_mixed"])
			{	
				
				 foreach($tpl["psgroove"]["type"]["attributes"]["led"] as $led_id => $led_val) 
				 {
					if(isset($_POST["psgroovemaker_form_led_gate_".$led_id]) && $_POST["psgroovemaker_form_led_gate_".$led_id] != "")
					{
						$led_selected[$led_id] = $_POST["psgroovemaker_form_led_gate_".$led_id];
					}				 
				 }
				 
				 if(count($led_selected) > 0)
				 {
					
					if(!isset($_POST["psgroovemaker_form_led_port"]) || !isset($tpl["psgroove"]["type"]["attributes"]["led_ports"][$_POST["psgroovemaker_form_led_port"]])) 
					{
						$tpl["msg"]["error"][] =  'Please select Main Port if you chose an LED Gate!';
							
						switch_page("step2",true);				
						return false;
					}
					foreach($led_selected as $led_id => $led_gate)
					{
						$values["led"][] = array($tpl["psgroove"]["type"]["attributes"]["led_ports"][$_POST["psgroovemaker_form_led_port"]][0],$led_gate);
					}
					
				 }
				 
				 if(isset($_POST["psgroovemaker_form_led_inv"]) && $_POST["psgroovemaker_form_led_inv"] == "inv")
				 {
					$values["led_inv"] = true;
				}else {
					$values["led_inv"] = false;
				}
			}
			elseif($tpl["psgroove"]["type"]["attributes"]["led_custom"] && $tpl["psgroove"]["type"]["attributes"]["led_ports_mixed"])
			{
				foreach($tpl["psgroove"]["type"]["attributes"]["led"] as $led_id => $val) 
				{
					if((isset($_POST["psgroovemaker_form_led_port_".$led_id]) 
					|| isset($_POST["psgroovemaker_form_led_gate_".$led_id]))
					&& ($_POST["psgroovemaker_form_led_port_".$led_id] != "" || $_POST["psgroovemaker_form_led_gate_".$led_id] != "")
					)
					{
							
							if(!isset($_POST["psgroovemaker_form_led_port_".$led_id]) || !isset($tpl["psgroove"]["type"]["attributes"]["led_ports"][$_POST["psgroovemaker_form_led_port_".$led_id]])) 
							{
								$tpl["msg"]["error"][] =  'Please select Portnumber if you chose an Port!';
								switch_page("step2",true);				
								return false;					
							}
							
							if(!isset($_POST["psgroovemaker_form_led_gate_".$led_id]) 
								||
									!(	
									 ($_POST["psgroovemaker_form_led_gate_".$led_id] >= $tpl["psgroove"]["type"]["attributes"]["led_ports"][$_POST["psgroovemaker_form_led_port_".$led_id]][1])
										&& ($_POST["psgroovemaker_form_led_gate_".$led_id] <= $tpl["psgroove"]["type"]["attributes"]["led_ports"][$_POST["psgroovemaker_form_led_port_".$led_id]][2] )
									 )
									|| $_POST["psgroovemaker_form_led_gate_".$led_id] == ""
								) 
							{
								
								$tpl["msg"]["error"][] =  'Please select Port if you chose an Portnumber!';
								switch_page("step2",true);				
								return false;					
							}
							
							if(isset($_POST["psgroovemaker_form_led_inv_".$led_id]) && $_POST["psgroovemaker_form_led_inv_".$led_id] == "inv")
							{
								$led_inv = true;
							}else {
								$led_inv = false;
							}
							
							
							$values["led"][$led_id] = array($tpl["psgroove"]["type"]["attributes"]["led_ports"][$_POST["psgroovemaker_form_led_port_".$led_id]][0],$_POST["psgroovemaker_form_led_gate_".$led_id],$led_inv);
				
					}			
				}
			
			}
			#print_r($values);
			#unset($_POST["psgroovemaker_form_src_id"], $_POST["psgroovemaker_form_pl3_firmware"],$_POST["psgroovemaker_form_board"]);
			#echo 'array("name" => "board", "conf" => \'';
			#foreach($_POST as $id => $val){
		#		echo $id."=".$val."&";
		#	}
		#	echo '\'),';
			$_POST["psgroovemaker_form_values"] = addcslashes(base64_encode(crypt_encode_data($values)),'=+');
			switch_page("build",true);				
			return false;
			
		break;
	case "step2":
		
			$tpl["psgroove"]["src"] = $psgroove->get_src();		
	
			
			#no source selected, switch back to page step1S
			if(!isset($_POST["psgroovemaker_form_src_id"]) || !isset($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]])){
				$tpl["msg"]["error"][] = 'Please select a fork first!';
				
				switch_page("step1",true);				
				return false;
			}
			
			$tpl["psgroove"]["type"] = $psgroove->get_type_values($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["type"]);
			
			$src_id = $_POST["psgroovemaker_form_src_id"] ;	
			$tpl["psgroove"]["src_name"] = $tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["name"].' - '.$tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["version"].'('.$tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["date_release"].')';
			
			
			
			if(!$continued && isset($_POST["psgroovemaker_form_board"]) && $_POST["psgroovemaker_form_board"] != "")
			{
				$board = $_POST["psgroovemaker_form_board"];
				unset($_POST);
				$_POST["psgroovemaker_form_board"] = $board;
				$conf = $tpl["psgroove"]["type"]["board"][$board]["conf"];
				$v = explode('&',$conf);
				$p = array();
				foreach($v as $kv){
					$k = explode('=',$kv);
					$_POST[$k[0]] = $k[1];
				}
				
			}
			elseif(!$continued)
			{	
				unset($_POST);				
			}
			
			$_POST["psgroovemaker_form_src_id"]  = $src_id;
			#	print_r($_POST);
			#	print_r( $tpl["psgroove"]["type"]);
			require_once(PATH_THEME."step2.php") ;
	break;
	
	case "step1":
		$max=4;
		if(isset($_GET["src_show_all"]) && $_GET["src_show_all"] == 1) $max=0;
		
		$tpl["psgroove"]["src"] = $psgroove->get_src($max);		
		
		require_once(PATH_THEME."step1.php") ;
		break;
	default: 
		$max=4;
		if(isset($_GET["src_show_all"]) && $_GET["src_show_all"] == 1) $max=0;
		
		$tpl["psgroove"]["src"] = $psgroove->get_src($max);		
		
		require_once(PATH_THEME."index.php") ;
		break;

}
return true;
}


switch_page($_GET["do"]);
?>
