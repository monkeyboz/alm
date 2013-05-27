<?php
	$info = $this->info;
?>
<style>
	form input{
		font-size: 20px;
	}
</style>
<h3>Create Property</h3>
<form action="" method="POST">
        <div>
		Name
		<div>
			<input type="text" name="properties[name]" value="<?php echo $info['name']; ?>"/>
		</div>
	</div>
	<div>
		Address
		<div>
			<input type="text" name="properties[address]" value="<?php echo $info['address']; ?>"/>
		</div>
	</div>
	<div>
		City
		<div>
			<input type="text" name="properties[city]" value="<?php echo $info['city']; ?>"/>
		</div>
	</div>
	<div>
		State
		<div>
			<input type="text" name="properties[state]" value="<?php echo $info['state']; ?>"/>
		</div>
	</div>
	<input type="hidden" name="properties[user_id]" value="<?php echo $info['user_id']; ?>"/>
	<?php if(isset($info['property_id'])){ ?><input name="properties[property_id]" value="<?php echo $info['property_id']; ?>" type="hidden"/><?php } ?>
	<input name="submit" value="submit" type="submit" />
</form>