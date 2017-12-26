<?php
/** Strip Magic Quotes if exists */
        if(  ( function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc() ) || ini_get('magic_quotes_sybase')  ){
            foreach($_GET as $k => $v) $_GET[$k] = stripslashes($v);
            foreach($_POST as $k => $v) $_POST[$k] = stripslashes($v);
            foreach($_COOKIE as $k => $v) $_COOKIE[$k] = stripslashes($v);
			unset($k,$v);
        }
		
		
		
ini_set('max_execution_time', '0')  ;

define('_EXEC', 1 );
define('DS', DIRECTORY_SEPARATOR );
define('PATH_MAIN', dirname(__FILE__) );

$file = $_GET["file"].".hex";
$name = $_GET["name"];

if(!file_exists(PATH_MAIN.DS."hex".DS.$file)) die ("File not found");

$size = filesize(PATH_MAIN.DS."hex".DS.$file);
$name = $name;
header('Content-type: application/octet-stream');
header("Content-Disposition: ".(!strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 5.5")?"attachment; ":"")."filename=\"".$name."\"");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".$size."");

echo file_get_contents(PATH_MAIN.DS."hex".DS.$file);
?>