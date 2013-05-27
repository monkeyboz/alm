<?php
	$info = $this->info;
?>
<h3>Update Fixtures</h3>
<form action="" method="POST" enctype="multipart/form-data">
	<div>
		Watts
		<div>
			<input type="text" value="<?php echo $info['watts']; ?>" name="fixture_info[watts]"/>
		</div>
	</div>
	<div>
		Burn Hours
		<div>
			<input type="text" value="<?php echo $info['burnhours']; ?>" name="fixture_info[burnhours]"/>
		</div>
	</div>
        <!-- <h4>Icon Upload</h4>
        <input type="file" name="upload" />
	<?php if(isset($info['fixture_type_id'])){ ?>
            <input name="fixture_type[fixture_type_id]" type="hidden" value="<?php echo $info['fixture_type_id']?>"/>
        <?php echo $this->displayIcon('fixture', $info['fixture_type_id']); ?>        
        <?php } ?> -->
        <div><input name="editFixture" value="submit" type="submit" /></div>
</form>
