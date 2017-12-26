<?php
/**
* Style Functions
* @package style
* @author Richard Hillmann
*/
if (!defined('_EXEC')) die ("This is a part of the programm");



/** Prints stored msg
@param string|bool $type of messages. "error","info" or false for all mesaages 
@return int number of printed messages
@see $tpl["msg"]
*/
function style_msg_print($type_print=false){
	global $tpl;
	$msg_types=array("error","info");
	$count = 0;
	
	/** Proceed all msg types by array */
	foreach($msg_types as $type) {
		$c_tmp = count($tpl["msg"][$type]);
		
		if((!$type_print || $type_print == $type) && $c_tmp > 0) {
			$count += $c_tmp;
			
			echo '<div class="msg '.$type.'">';
				foreach($tpl["msg"][$type] as $msg) {
					echo '<p>'.$msg.'</p>';
				}
			echo '</div>';
		}
	}

	return $count;



}
?>
