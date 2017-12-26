<?php
/**
  * Global configuration file
  * @category Configuration
  * @author Richard Hillmann 
  * @global array $sysconf
*/
$sysconf = array();

if (!defined('_EXEC')) die ("This is a part of the programm");

/** Domain path
* @global string $sysconf["www"]["path"]  
*/
$sysconf["www"]["path"] = "/psgroove/";


/** Database Connection Info: user
* @global string $sysconf["db"]["user"]  
*/
$sysconf["db"]["user"] = "root";

/** Database Connection Info: password 
* @global string $sysconf["db"]["password"]  
*/
$sysconf["db"]["password"] = "";

/** Database Connection Info: Database to use 
* @global string $sysconf["db"]["database"]  
*/
$sysconf["db"]["database"] = "accountmanager";

/** Database Connection Info: Host
* @global string $sysconf["db"]["host"]  
*/
$sysconf["db"]["host"] = "localhost";

/** Database Connection Info: Port  
* @global string $sysconf["db"]["port"]  
*/
$sysconf["db"]["port"] = "3306"; 

/** Database Table prefix  
* @global string $sysconf["db"]["table_prefix"]  
* @see TB_PREFIX
*/
$sysconf["db"]["table_prefix"] = "";


/** Default Theme 
* @global string $sysconf["theme"]["default"] 
*/
$sysconf["theme"]["default"] = "default";



/*
* --- VERY IMPORTANT !! ---
* --- DO NOT CHANGE THIS SETTINGS AFTER FIRST USE !!  ---
*
* These are the encryption settings for your account data, see http://www.php.net/manual/en/function.mcrypt-module-open.php for further details.
*/





/** mcrypt algorithm
* @global string $sysconf["crypt"]["algorithm"]
*/
$sysconf["crypt"]["algorithm"] = MCRYPT_RIJNDAEL_256;
#$sysconf["crypt"]["algorithm"] = MCRYPT_DES;

/** mcrypt algorithm_directory
* @global string $sysconf["crypt"]["algorithm_directory"];
*/
$sysconf["crypt"]["algorithm_directory"] = ''; 

/** mcrypt mode
* @global string $sysconf["crypt"]["mode"]
*/ 
$sysconf["crypt"]["mode"] = MCRYPT_MODE_ECB;

/** mcrypt mode_directory
* @global string $sysconf["crypt"]["mode_directory"]
*/
$sysconf["crypt"]["mode_directory"] = '';


?>
