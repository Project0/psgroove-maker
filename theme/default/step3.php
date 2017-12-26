<?php
/**
* step 3 page
*  
* @author Richard Hillmann
*/
if (!defined('_EXEC')) die ("This is a part of the programm");
?>

<ul id="psgroovemaker_step">
<li >  Select Source</li>
<li >  Configuration</li>
<li class="active">  Build</li>
</ul>
<p><i><?php echo $tpl["psgroove"]["src_name"] ?></i></p>
<?php style_msg_print(); ?>

	<script type="text/javascript">
		window.setTimeout("psgroovemaker_load('<?php echo $tpl["www_path"]?>index.php?do=build')", 10000);

	</script>

	<input type="hidden" name="psgroovemaker_form_src_id" value="<?php echo $tpl["psgroove"]["src_id"] ?>" />
	<input type="hidden" name="psgroovemaker_form_values" value="<?php echo $tpl["psgroove"]["values"] ?>" />

	
	<p>Please wait for free slot</p>
	<img src="<?php echo $tpl["www_path"]?>theme/default/img/ajax-loader.gif" alt="load" />
	