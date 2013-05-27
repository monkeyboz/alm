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
<h3>Create Fixtures</h3>
<form action="" method="POST" enctype="multipart/form-data">
	<div>
		Name
		<div>
			<input type="text" value="<?php echo $info['name']; ?>" name="fixture_type[name]"/>
		</div>
	</div>
	<div>
		Watts
		<div>
			<input type="text" value="<?php echo $info['watts']; ?>" name="fixture_type[watts]"/>
		</div>
	</div>
	<div>
		Description
		<div>
			<input type="text" value="<?php echo $info['description']; ?>" name="fixture_type[description]"/>
		</div>
	</div>
        <div>
            Fixture Type
            <div>
                <select name="fixture_type[type]">
                    <option value="fixture" <?php if($info['type'] == 'fixture'){ ?>selected<?php } ?>>Fixture</option>
                    <option value="circuit" <?php if($info['type'] == 'circuit'){ ?>selected<?php } ?>>Circuit</option>
                </select>
            </div>
        </div>
		<div>
			<div>
				<img src="uploads/icon/Camera.png"/><input type="radio" name="icon" value="Camera"/>
				<img src="uploads/icon/Circuit.png"/><input type="radio" name="icon" value="Circuit"/>
				<img src="uploads/icon/Light.png"/><input type="radio" name="icon" value="Light"/>
				<img src="uploads/icon/Hanging Light.png"/><input type="radio" name="icon" value="Hanging Light"/>
				<img src="uploads/icon/Lighting.png"/><input type="radio" name="icon" value="Lighting"/>
				<img src="uploads/icon/Surveillance.png"/><input type="radio" name="icon" value="Surveillance"/>				
			</div>
		</div>
        <!-- <h4>Icon Upload</h4>
        <input type="file" name="upload" />
	<?php if(isset($info['fixture_type_id'])){ ?>
            <input name="fixture_type[fixture_type_id]" type="hidden" value="<?php echo $info['fixture_type_id']?>"/>
        <?php echo $this->displayIcon('fixture', $info['fixture_type_id']); ?>        
        <?php } ?> -->
        <div><input name="addFixture" value="submit" type="submit" /></div>
</form>
