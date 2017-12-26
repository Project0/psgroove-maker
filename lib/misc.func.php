<?php
/**
* Various function
* @author Richard Hillmann
*/
if (!defined('_EXEC')) die ("This is a part of the programm");


/** Generates a Random String
 * @param int length
 * @param string|int char list
 * @return string random
*/
function rand_str($length = 32, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
{
    // Length of character list
    $chars_length = (strlen($chars) - 1);

    // Start our string
    $string = $chars{rand(0, $chars_length)};

    // Generate random string
    for ($i = 1; $i < $length; $i = strlen($string))
    {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};

        // Make sure the same two characters don't appear next to each other
        if ($r != $string{$i - 1}) $string .=  $r;
    }

    // Return the string
    return $string;
}



/** Init Theme and loads the theme.inc.php 
 * @param string set custom theme
 * @return bool
*/
function init_theme($par_theme =false)
{
	global $tpl;
	//generate possible theme list;
	$theme_list[] = $par_theme;
	if(isset($_SESSION["user_theme"])) $theme_list[] = $_SESSION["user_theme"];
	$theme_list[] = "default";
	
	/* allready set, return false */
	if(defined('PATH_THEME')) return false;

		
	foreach($theme_list as $theme) {
		$theme_dir = PATH_MAIN.'theme'.DS.$theme.DS;

		if($theme && is_dir($theme_dir))
		{
			define('PATH_THEME',$theme_dir);
		}
	}


	if(defined('PATH_THEME'))
	{
		if(is_file(PATH_THEME.'theme.inc.php')) require_once(PATH_THEME.'theme.inc.php');
		return true;
	}else {
		 return false;
	}
}

function send_mail($email, $subject, $message)
{

        $headers  = 'MIME-Version: 1.0' . "\r\n";
 #       $headers .= 'Content-type: plain/text; charset=iso-8859-1' . "\r\n";
 	$headers .= 'Content-Type: text/plain; charset="ISO-8859-1"'. "\r\n";
	$headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
	$headers .= 'User-Agent: Rex Automailer' . "\r\n";
        // Additional headers
        $headers .= 'To: '. $email . "\r\n";
        $headers .= 'From: Project0 Automailer <automailer@project0.de>' . "\r\n";
        #mail($email, $subject, $message, $headers);
        return true;

}



    function array_sort($table, $colname,$sort = SORT_ASC) {
  $tn = $ts = $temp_num = $temp_str = array();
  foreach ($table as $key => $row) {
	 if(preg_match("/\d\d\.\d\d\.\d\d\d\d/",$row[$colname])) {
      $ts[$key] = substr($row[$colname],6,4).substr($row[$colname],3,2).substr($row[$colname],0,2);
		
      $temp_str[$key] = $row;
    }
    elseif(is_numeric(substr($row[$colname], 0, 1))) {
      $tn[$key] = $row[$colname];
      $temp_num[$key] = $row;
    }
    else {
      $ts[$key] = $row[$colname];
      $temp_str[$key] = $row;
    }
  }
  unset($table);

  array_multisort($tn, $sort, SORT_NUMERIC, $temp_num);
  array_multisort($ts, $sort, SORT_STRING, $temp_str);
  return array_merge($temp_num, $temp_str);
    } 
?>
