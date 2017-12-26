<?php
/**
* Default page
* @package style
* @author Richard Hillmann
*/
if (!defined('_EXEC')) die ("This is a part of the programm");
require_once(PATH_THEME."head.inc.php");
?>
<style type="text/css">


ul#psgroovemaker_step{ 
	width: 100%;
	height: 43px;

	font-size: 0.8em; 
	font-size: 0.8em; 
	font-family: "Lucida Grande", Verdana, sans-serif; 
	font-weight: bold; 
	list-style-type: none; 
	margin: 0; 
	padding: 0;	
	}
ul#psgroovemaker_step li {
	display: block; 
	float: left; 
	margin: 5px 5px 5px 5px; 
	padding:2px;
	border:1px solid #cccccc;
	}
ul#psgroovemaker_step li.active {
	background-color:#aaaaFF;
	}	
ul#psgroovemaker_step li.inactive {
	display:none;
	}
	

.msg {text-align:center; background-color:#f8f8f8;margin:0px;padding:0px; font-weight:bold }
.msg p {padding:0px; margin:0px;}
.msg.error { color:red}
.msg.info {color:green}
#psgroovemaker_main { text-align:left}
#psgroovemaker_main table td { vertical-align:top; text-align:left }

</style>

	<script type="text/javascript">
	
	function psgroovemaker_more(obj) {
		var vis = jQuery(obj).children('::visible');
		var hid = jQuery(obj).children(':hidden');
		vis.fadeOut('fast', function() {});
		hid.fadeIn('slow', function() {});
	}
	
	function psgroovemaker_load(url) {

							jQuery.ajax({
                                type: "POST",
                                timeout: 200000,
                                data: jQuery("#psgroovemaker_form").serialize(),
                                url: url,
                                beforeSend: function(){
                                                jQuery("#psgroovemaker_main").html('<p>Loading, Please wait.</p><img src="<?php echo $tpl["www_path"]?>theme/default/img/ajax-loader2.gif" alt="load" />');
                                        },
                                success: function(result){
											jQuery("#psgroovemaker_main").html(result);
										},
								error: function(){
                                               jQuery("#psgroovemaker_main").html("Error while loading the page");
                                        }
                                });

	}
	function test()
	{
		alert(jQuery("#psgroovemaker_form").serialize());
	}
	</script>
	
	

	<form action="" method="post" id="psgroovemaker_form" >
		<div id="psgroovemaker_main">
		<?php require_once(PATH_THEME."step1.php") ; ?>
		
			</div>

	</form>
<?php require_once(PATH_THEME."foot.inc.php"); ?>
