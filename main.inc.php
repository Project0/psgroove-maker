<?php
/**
* Main Include File. Defines basics.
* @author Richard Hillmann 
*/
if (!defined('_EXEC')) die ("This is a part of the programm");

/** Strip Magic Quotes if exists */
        if(  ( function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc() ) || ini_get('magic_quotes_sybase')  ){
            foreach($_GET as $k => $v) $_GET[$k] = stripslashes($v);
            foreach($_POST as $k => $v) $_POST[$k] = stripslashes($v);
            foreach($_COOKIE as $k => $v) $_COOKIE[$k] = stripslashes($v);
			unset($k,$v);
        }


/** Short Version of  Directory Separator */
define("DS",DIRECTORY_SEPARATOR); # / or \, win/linux specified

/** path constant. Getting absolute path from server */
define("PATH_MAIN",dirname(__FILE__).DS);


/** Include Configuration file */	
require_once(PATH_MAIN."config.inc.php");



/** init debug handler */
#require_once(PATH_MAIN."inc".DS."debug.inc.php");

/** Check register globals */
if (ini_get('register_globals') == 1) trigger_error('Register Globals is on, Script will not continue',E_USER_ERROR); 



/** Defines the Constant  for Table Prefix in Database  
* @see $sysconf */
define("TB_PREFIX",$sysconf["db"]["table_prefix"]);


/** Includes gettext library */
require_once(PATH_MAIN."lib".DS."gettext".DS."gettext.inc");

$locale = 'en_US'; // Pretend this came from the Accept-Language header
$encoding = 'UTF-8';
$locale_dir = PATH_MAIN.'lang'; // your .po and .mo files should be at $locale_dir/$locale/LC_MESSAGES/messages.{po,mo}
putenv("LANGUAGE=$locale");
T_setlocale(LC_MESSAGES, $locale);
T_bindtextdomain("messages", $locale_dir);
T_bind_textdomain_codeset("messages", $encoding);
T_textdomain('messages');







#try {
	
	/** Global Database Handler
	* 
	* Inits a PDO object with MySQL driver
	* @global object $dbh
	* @see $sysconf
	*/
 #   $dbh = new PDO('mysql:host='.$sysconf["db"]["host"] .';dbname='.$sysconf["db"]["database"] .'', $sysconf["db"]["user"], $sysconf["db"]["password"],  array(PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES utf8") );
#	$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
#} catch (PDOException $e) {
#    trigger_error('Connection failed: ' . $e->getMessage(),E_USER_ERROR);
#}	





// Load Functions
require_once(PATH_MAIN.'lib'.DS.'crypt.func.php');
require_once(PATH_MAIN.'lib'.DS.'misc.func.php');
require_once(PATH_MAIN.'psgroove'.DS.'psgroove.class.php');

?>
