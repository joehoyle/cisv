<?php

	/* Form builder v1.0
	By UnPointZero Webagency
	www.unpointzero.com
	*/

	function form_input_hidden($name,$value)
	{
		?>
		<input name="<?php echo $name; ?>" type="hidden" value="<?php echo $value; ?>" />
		<?php
	}
	
	function form_input($name,$value,$size=32)
	{
		?>
		<input size="<?php echo $size; ?>" type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
		<?php
	}

	function form_textarea($name,$value)
	{
		?>
		<textarea name="<?php echo $name; ?>" cols="" rows=""><?php echo $value; ?></textarea>
		<?php
	}
	
	function form_checkbox($name,$desc,$value,$default)
	{
		?>
		<label><input name="<?php echo $name; ?>" type="checkbox" value="<?php echo $value; ?>" <?php if($default==$value) { echo "checked"; } ?> /><?php echo $desc; ?></label><br />
		<?php
	}
	
	function form_select($name,$values,$default) 
	{
		?>
		<select name="<?php echo $name; ?>">
		<option>Selectionnez</option>
		<?php
		foreach($values as $value => $value_desc)
		{
			?>
			<option value="<?php echo $value; ?>" <?php if ($default==$value) { echo "selected=\"selected\""; } ?>><?php echo $value_desc; ?></option>
			<?php
		}
		?>
		</select>
		<?php
	}
	
	function form_radio($name,$values,$default)
	{
		foreach($values as $val => $value_desc)
		{
		?>
		<label><input type="radio" name="<?php echo $name; ?>" value="<?php echo $val; ?>" <?php if($val==$default) { echo "checked=\"checked\""; } ?> /><?php echo $value_desc; ?></label><br />
		<?php
		}
	}
	
?>
