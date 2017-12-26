<?php
/**
* step 1 page
*  
* @author Richard Hillmann
*/
if (!defined('_EXEC')) die ("This is a part of the programm");?>

<ul id="psgroovemaker_step">
<li class="active">  Select Source</li>
<li class="inactive">  Configuration</li>
<li class="inactive">  Build</li>
</ul>

<?php style_msg_print(); ?>
	

	
		  <table border="0" cellpadding="5" cellspacing="1" >
				<tr style="background-color:#f5f5f5">
					<td></td>
					<td>Name</td>
					<td>Version</td>
					<td>Release</td>
					<td>Info</td>
				</tr>
		<?php $row_color='#eeeeff'; foreach($tpl["psgroove"]["src"] as $src_id => $src) { 
				if($row_color=='#eeeeff'){  $row_color='#ccccff'; }else{ $row_color='#eeeeff';} 
			?>
	
			
			
				<tr style="background-color:<?php echo $row_color?>">
					<td style="white-space:nowrap; width:5%" ><input type="radio" name="psgroovemaker_form_src_id" value="<?php echo $src_id?>" /> </td>
					<td  style=" width:25%" ><?php echo $src["name"] ?></td>
					<td  style="white-space:nowrap; width:10%" ><?php echo $src["version"] ?></td>
					<td  style="white-space:nowrap; width:15%" ><?php echo $src["date_release"] ?></td>
					<td style="width:45%">
						<div class="psgroovemaker_form_src_nfo" style="cursor:pointer" onClick="psgroovemaker_more(jQuery(this))">
						
						<?php 
							$nfo = $src["nfo"];
							$cut=(array)explode('\n\n',wordwrap($nfo,50,'\n\n'));
							$nfo = str_replace("\n",'<br />',$src["nfo"]);
							if(strlen($cut[0]) < strlen($nfo)){
								
								echo '<span style="display:none">'.$nfo."</span>";?>
								<span class="show"><?php echo $cut[0];?> ... <b>more</b></span	>
						<?php }else { echo $nfo; } ; ?>
						
						</div>
					
					</td>
				</tr>

		<?php  } ?>
		
			</table>
			
		<input type="button" value="Show Archive" onClick="psgroovemaker_load('<?php echo $tpl["www_path"]?>index.php?do=step1&amp;src_show_all=1')" /> <input type="button" value="Next" onClick="psgroovemaker_load('<?php echo $tpl["www_path"]?>index.php?do=step2')" />
