<link rel="stylesheet" type="text/css" href="css/tableDisplay.css">
<?php
	$info = $this->info;
?>
<form action="?page=users/search" method="POST">
    <span style="color: #fff; font-size: 20px;">Users</span> <input type="text" value="search" name="users[search]" onclick="$(this).val('');"/>
    <div class="right">
		<select name="fixtures[term]">
			<option value="name">type</option>
			<option value="status">status</option
        </select>
        <input type="submit" value="Search" name="Submit" />
    </div>
</form>
<div class="table">
	<div class="header">
		<div>Username</div>
		<div>Password</div>
		<div></div>
	</div>
<?php
$user = $this->query('SELECT user_type FROM users WHERE user_id = '.$_SESSION['user_id']);
foreach($info as $k=>$i){
?>
	<div class="<?php echo ($k%2 == 0)?'even':'odd'; ?>">
		<div><?php echo $i['username']; ?></div>
		<div><?php echo ($user[0]['user_type'] == 'superadmin')?$i['password']:'******'; ?></div>
		<?php $this->editOptions('user',$i['user_id']); ?>
	</div>
<?php
}
?>
</div>
<div class="bottomNav">
	<a href="?page=users/createForm">New</a>
</div>