<?php
/**
* Helper functions for various encryption jobs
* @author Richard Hillmann
*/
if (!defined('_EXEC')) die ("This is a part of the programm");


/** Encrypts a string 
 * @param string key
 * @param string|int plain data
 * @return string encrypted data
*/
function crypt_encrypt($key,$data) {
	global $sysconf;
		/* Open the cipher */
	    $td = mcrypt_module_open($sysconf["crypt"]["algorithm"], $sysconf["crypt"]["algorithm_directory"], $sysconf["crypt"]["mode"], $sysconf["crypt"]["mode_directory"]);
	
		/* Create IV */
	    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
	    $ks = mcrypt_enc_get_key_size($td);
	
	    $key = crypt_gen_key($key,$ks);

	    /* Intialize encryption */	
	    mcrypt_generic_init($td, $key, $iv);
		
	    /* Encrypt data */
	    $encrypted = mcrypt_generic($td, $data);

	    /* Terminate encryption handler */
	    mcrypt_generic_deinit($td);
	    mcrypt_module_close($td);
	return $encrypted;	
}

/** Decrypts the Data
 * @param string key
 * @param string encrypted data
 * @return string|int decrypted data
*/

function crypt_decrypt($key,$data)
{
	 global $sysconf;
            /* Open the cipher */
            $td = mcrypt_module_open($sysconf["crypt"]["algorithm"], $sysconf["crypt"]["algorithm_directory"], $sysconf["crypt"]["mode"], $sysconf["crypt"]["mode_directory"]);
            /* Create IV */
            $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
            $ks = mcrypt_enc_get_key_size($td);

            $key = crypt_gen_key($key,$ks);
	/* Initialize encryption module for decryption */
	    mcrypt_generic_init($td, $key, $iv);

	/* Decrypt encrypted string and trim null bytes*/
	    $decrypted = trim(mdecrypt_generic($td, $data),"\0");

	 /* Terminate decryption handle and close module */
	    mcrypt_generic_deinit($td);
	   mcrypt_module_close($td);
	return $decrypted;
}


/** Generate a Key by specified length
 * @param string Key
 * @param int key size
 * @return string generated key 
*/
function crypt_gen_key($key,$size){
	
	$key = substr(sha1($key,true).md5($key,true), 0, $size);
	return $key;
}


/** Encodes the Value
 * @param array|string Value to enocde
 * @return string json encoded data
*/
function crypt_encode_data($data){
	/* Add Test Condition */
	$val = array("check" => true,"data" => $data);
	#return json_encode($val,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP);
	return json_encode($val);

}

/** Decodes the string into a assoziative array
 * @param string json encoded data
 * @return array|bool 
*/
function crypt_decode_data($str){
	$val = json_decode($str,true);
	/* If something went wrong with the string return false, decryption failed */
	if(function_exists("json_last_error")) if(json_last_error() != JSON_ERROR_NONE) return false;
	/* Check Test Condition */
	if($val["check"] != true) return false;
	return $val["data"];
}


?>
