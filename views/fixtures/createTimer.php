<style>
	body{
		color: #fff;
	}
	form > div > div{
		margin: 10px 0px;
	}
	h3{
		color: #fff;
		background: #000;
		padding: 20px;
		margin: 0px;
	}
</style>
<?php
	$info = $this->info;
?>
<h3>Create Panels</h3>
<form action="" method="POST" enctype="multipart/form-data">
	<div>
		Name
		<div>
			<input type="text" value="<?php echo $info['name']; ?>" name="panels[name]"/>
		</div>
	</div>
	<div>
		Voltage
		<div>
			<input type="text" value="<?php echo $info['voltage']; ?>" name="panels[voltage]"/>
		</div>
	</div>
	<div>
		Manufacturer
		<div>
			<input type="text" value="<?php echo $info['manufacturer']; ?>" name="panels[manufacturer]"/>
		</div>
	</div>
	<div>
		Type
		<div>
			<select name="panels[type]">
				<option value="photocell">Photocell</option>
				<option value="time">Timer</option>
			</select>
		</div>
	</div>
		<div>
			<div>
				<img src="uploads/icon/Electric_Panel.png"/><input type="radio" name="icon" value="Electric_Panel"/>
				<img src="uploads/icon/Panel_2.png"/><input type="radio" name="icon" value="Panel_2"/>
				<img src="uploads/icon/Panel_3.png"/><input type="radio" name="icon" value="Panel_3"/>
				<img src="uploads/icon/Panel_4.png"/><input type="radio" name="icon" value="Panel_4"/>				
			</div>
		</div>
        <!-- <h4>Icon Upload</h4>
        <input type="file" name="upload" /> -->
	<?php if(isset($info['panel_id'])){ ?>
            <input name="panels[panel_id]" type="hidden" value="<?php echo $info['panel_id']?>"/>   
        <?php } ?>
        <div><input name="addFixture" value="submit" type="submit" /></div>
</form>
