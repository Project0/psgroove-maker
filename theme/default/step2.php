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
<li class="active">  Configuration</li>	
<li class="inactive">  Build</li>
</ul>
<p><i><?php echo $tpl["psgroove"]["src_name"] ?></i></p>
<?php style_msg_print(); ?>
	<input type="hidden" name="psgroovemaker_form_src_id" value="<?php echo $_POST["psgroovemaker_form_src_id"] ?>" />
	<p>
	Use predefined Boards:
		 <select style="width:350px" name="psgroovemaker_form_board" onChange="psgroovemaker_load('<?php echo $tpl["www_path"]?>index.php?do=step2')">
					<option value="">user-defined</option>
			<?php foreach($tpl["psgroove"]["type"]["board"] as $id => $val) { ?>
					<option value="<?php echo $id ?>" <?php if(isset($_POST["psgroovemaker_form_board"]) && $_POST["psgroovemaker_form_board"] != "" && $_POST["psgroovemaker_form_board"] == $id) echo "selected=\"selected\""?>><?php echo $val["name"] ?> </option>
			<?php } ?>
		</select>
		
	</p>
	<hr/>
	<h3>Define CPU and Frequency</h3>
	<div>
		<p>
		CPU: <select name="psgroovemaker_form_cpu" >
			<option value=""> </option>
			<?php foreach($tpl["psgroove"]["type"]["cpu"] as $cpu_id => $cpu_val) { ?>
					<option value="<?php echo $cpu_id ?>" <?php if(isset($_POST["psgroovemaker_form_cpu"]) && $_POST["psgroovemaker_form_cpu"] != "" && $_POST["psgroovemaker_form_cpu"] == $cpu_id) echo "selected=\"selected\""?>><?php echo $cpu_val["label"] ?> </option>
			<?php } ?>
		</select>
		</p>
		<p>
				Frequency: <select name="psgroovemaker_form_fcpu" >
				<option value=""> </option>
			<?php foreach($tpl["psgroove"]["type"]["fcpu"] as $fcpu_id => $fcpu_val) { ?>
					<option value="<?php echo $fcpu_id ?>" <?php if(isset($_POST["psgroovemaker_form_fcpu"]) && $_POST["psgroovemaker_form_fcpu"] != "" &&  $_POST["psgroovemaker_form_fcpu"] == $fcpu_id) echo "selected=\"selected\""?>><?php echo $fcpu_val["label"] ?> </option>
			<?php } ?>
		</select>
		
		
			<?php if($tpl["psgroove"]["type"]["attributes"]["frequency_custom"]){ ?>
				or Custom Frequency in Hz (<?php echo $tpl["psgroove"]["type"]["attributes"]["frequency_range"][0]?> - <?php echo $tpl["psgroove"]["type"]["attributes"]["frequency_range"][1]?>)
				<input type="text" size="10" name="psgroovemaker_form_fcpu_custom" value="<?php if(isset($_POST["psgroovemaker_form_fcpu_custom"])) echo $_POST["psgroovemaker_form_fcpu_custom"]?>" />
			<?php } ?>
		</p>
	</div>
	
	<?php if(isset($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["pl3_firmware"])) {?>
	<h3>PL3 Settings</h3>
	<div>
		<p>
		Firmware: <select name="psgroovemaker_form_pl3_firmware" >
			
			<?php foreach($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["pl3_firmware"] as $fw_id => $fw_val) { ?>
					<option value="<?php echo $fw_id ?>" <?php if(isset($_POST["psgroovemaker_form_pl3_firmware"]) && $_POST["psgroovemaker_form_pl3_firmware"] != "" && $_POST["psgroovemaker_form_pl3_firmware"] == $fw_id) echo "selected=\"selected\""?>><?php echo $fw_val ?> </option>
			<?php } ?>
		</select>
		</p>
	<?php if(isset($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["pl3_payload_type"])) {?>
		<p>
		Payload: <select name="psgroovemaker_form_pl3_payload_type" >
			
			<?php foreach($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["pl3_payload_type"] as $fw_id => $fw_val) { ?>
					<option value="<?php echo $fw_id ?>" <?php if(isset($_POST["psgroovemaker_form_pl3_payload_type"]) && $_POST["psgroovemaker_form_pl3_payload_type"] != "" && $_POST["psgroovemaker_form_pl3_payload_type"] == $fw_id) echo "selected=\"selected\""?>><?php echo $fw_val ?> </option>
			<?php } ?>
		</select>
		</p>
	<?php } ?>		
	</div>
	<?php } ?>
	

	
	
	
	<?php if(isset($tpl["psgroove"]["src"][$_POST["psgroovemaker_form_src_id"]]["dfu_auto"])) {?>
	<h3>Bootloader Settings (Optional)</h3>
	<div>
		<p>
		AutoDFU Mode: 
			<input type="checkbox" value="dfu" name="psgroovemaker_form_dfu_auto"  <?php if(isset($_POST["psgroovemaker_form_dfu_auto"]) && $_POST["psgroovemaker_form_dfu_auto"] != "") echo "checked=\"checked\""?>/>
			<br/><i>Enter the Bootloader automatically</i>
		</p>
	</div>
	<?php } ?>	


	
	<h3>Define LEDs (Optional)</h3>
	<div>
	
		
			<?php if($tpl["psgroove"]["type"]["attributes"]["led_custom"] && !$tpl["psgroove"]["type"]["attributes"]["led_ports_mixed"]){ ?>
				<div>
				<p>
				Select main port: 
				<?php foreach($tpl["psgroove"]["type"]["attributes"]["led_ports"] as $id => $attr) { ?>
					<input type="radio" value="<?php echo $id ?>" name="psgroovemaker_form_led_port"  <?php if(isset($_POST["psgroovemaker_form_led_port"]) && $_POST["psgroovemaker_form_led_port"] != "" && $_POST["psgroovemaker_form_led_port"] == $id) echo "checked=\"checked\""?> /><?php echo $tpl["psgroove"]["type"]["attributes"]["led_ports_prefix"].$attr[0] ?>x 
				<?php } ?>
				</p>
				
				<?php if($tpl["psgroove"]["type"]["attributes"]["led_inv"]) { ?>
				<p>
					Invert LED Ports: <input type="checkbox" value="inv" name="psgroovemaker_form_led_inv"  <?php if(isset($_POST["psgroovemaker_form_led_inv"]) && $_POST["psgroovemaker_form_led_inv"] != "") echo "checked=\"checked\""?>/>
					<br/><i>(incoming port)</i>
					
				
				</p>
				<?php } ?>
				<p>
				Select Portnumber: <br/>
				
				<?php foreach($tpl["psgroove"]["type"]["attributes"]["led"] as $id => $val) { ?>
					<?php echo $val ?>: 
					<select name="psgroovemaker_form_led_gate_<?php echo $id?>">
							<option value="" >None</option>
						<?php for ($i = $tpl["psgroove"]["type"]["attributes"]["led_ports"][0][1]; $i <= $tpl["psgroove"]["type"]["attributes"]["led_ports"][0][2]; $i++) {?>
								<option value="<?php echo $i?>"  <?php if(isset($_POST["psgroovemaker_form_led_gate_".$id]) && $_POST["psgroovemaker_form_led_gate_".$id] != "" && $_POST["psgroovemaker_form_led_gate_".$id] == $i) echo "selected=\"selected\""?>><?php echo $i?></option>
						<?php } ?>
					</select><br/>								
				<?php } ?>
				</p>
				</div>				
			<?php }elseif($tpl["psgroove"]["type"]["attributes"]["led_custom"] && $tpl["psgroove"]["type"]["attributes"]["led_ports_mixed"]){ ?>
				
				
				<ul style="list-style:none;margin:0px;padding:0px">
				
				<?php foreach($tpl["psgroove"]["type"]["attributes"]["led"] as $led_id => $val) { ?>
					<li style="margin-left:20px;margin-bottom:10px;"><i><?php echo $val ?>:</i> <br/>
					
						<select  name="psgroovemaker_form_led_port_<?php echo $led_id?>">
							<option value="" >None</option>
						<?php foreach($tpl["psgroove"]["type"]["attributes"]["led_ports"] as $id => $val) {?>
								<option value="<?php echo $id ?>"  <?php if(isset($_POST["psgroovemaker_form_led_port_".$led_id]) && $_POST["psgroovemaker_form_led_port_".$led_id] != "" && $_POST["psgroovemaker_form_led_port_".$led_id] == $id) echo "selected=\"selected\""?>><?php echo $tpl["psgroove"]["type"]["attributes"]["led_ports_prefix"].$val[0]?></option>
						<?php } ?>
						</select>
								
						<select name="psgroovemaker_form_led_gate_<?php echo $led_id?>">
							<option value="" >None</option>
						<?php for ($i = $tpl["psgroove"]["type"]["attributes"]["led_ports"][0][1]; $i <= $tpl["psgroove"]["type"]["attributes"]["led_ports"][0][2]; $i++) {?>
								<option value="<?php echo $i?>"  <?php if(isset($_POST["psgroovemaker_form_led_gate_".$led_id]) && $_POST["psgroovemaker_form_led_gate_".$led_id] != "" && $_POST["psgroovemaker_form_led_gate_".$led_id] == $i) echo "selected=\"selected\""?>><?php echo $i?></option>
						<?php } ?>
						</select>
						
						<?php if($tpl["psgroove"]["type"]["attributes"]["led_inv"]) { ?>
							<br/>
								Invert LED Ports <i>(incoming port)</i>: <input type="checkbox" value="inv" name="psgroovemaker_form_led_inv_<?php echo $led_id?>"  <?php if(isset($_POST["psgroovemaker_form_led_inv_".$led_id]) && $_POST["psgroovemaker_form_led_inv_".$led_id] != "") echo "checked=\"checked\""?>/>
							
						<?php } ?>
					</li>
				<?php } ?>			
				
				</ul>
			
			
			
			
			
			
			
			<?php } ?>
	</div>

		<input type="button" value="Build" onClick="psgroovemaker_load('<?php echo $tpl["www_path"]?>index.php?do=step3')" />