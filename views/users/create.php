<link rel="stylesheet" type="text/css" href="css/tableDisplay.css">
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
<h3>Create Users</h3>
<form action="" method="POST" enctype="multipart/form-data">
	<div>
		Username
		<div>
			<input type="text" value="<?php echo $info['username']; ?>" name="users[username]"/>
		</div>
	</div>
	<div>
		Password
		<div>
			<input type="text" value="<?php echo $info['password']; ?>" name="users[password]"/>
		</div>
	</div>
	<div>
		Email
		<div>
			<input type="text" value="<?php echo $info['email']; ?>" name="users[email]"/>
		</div>
	</div>
	<div>
		First Name
		<div>
			<input type="text" value="<?php echo $info['first_name']; ?>" name="users[first_name]"/>
		</div>
	</div>
	<div>
		Last Name
		<div>
			<input type="text" value="<?php echo $info['last_name']; ?>" name="users[last_name]"/>
		</div>
	</div>
	<div>
		User Type
		<div>
			<input type="text" value="<?php echo $info['user_type']; ?>" name="users[user_type]"/>
		</div>
	</div>
	<?php if(isset($info['user_id'])){ ?>
	<input type="hidden" name="users[user_id]" value="<?php echo $info['user_id']; ?>"/>
	<?php } ?>
        <div><input name="addFixture" value="submit" type="submit" /></div>
</form>
