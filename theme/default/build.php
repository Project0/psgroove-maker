<?php
/**
* step 2 page
*  
* @author Richard Hillmann
*/
if (!defined('_EXEC')) die ("This is a part of the programm");

?>

<ul id="psgroovemaker_step">
<li >  Select Source</li>
<li >  Configuration</li>
<li >  Build</li>
<li class="active">  Download</li>
</ul>
<p><i><?php echo $tpl["psgroove"]["src_name"] ?></i></p>
<?php if(style_msg_print() == 0){ ?>
	<a href="<?php echo $tpl["www_path"]?>dl.php?file=<?php echo $tpl["psgroove"]["checksum"]?>&name=<?php echo $tpl["psgroove"]["filename"]?>"> Download <?php echo $tpl["psgroove"]["filename"]?></a>
<?php } ?>