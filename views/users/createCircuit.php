<?php
	$info = $this->info;
?>
<h3>Create Circuit</h3>
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
    <h4><h4>Icon Upload</h4>
        <input type="file" name="upload" />
        <input type="hidden" name="fixture_type[type]" value="<?php echo $info['type']; ?>"/>
	<?php if(isset($info['fixture_type_id'])){ ?>
            <input name="fixture_type[fixture_type_id]" type="hidden" value="<?php echo $info['fixture_type_id']?>"/>
            <?php echo $this->displayIcon('fixture', $info['fixture_type_id']); ?>
        <?php } ?>
        <div><input name="submit" value="submit" type="submit" /></div>
</form>
