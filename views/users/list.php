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
foreach($info as $i){
?>
	<div class="even">
		<div><?php echo $i['username']; ?></div>
		<div><?php echo $i['password']; ?></div>
		<div><a href="?page=users/view/<?php echo $i['user_id']; ?>">View</a> | <a href="?page=users/remove/<?php echo $i['user_id']; ?>">Delete</a> | <a href="?page=users/editForm/<?php echo $i['user_id']; ?>">Edit</a></div>
	</div>
<?php
}
?>
</div>
<div class="bottomNav">
	<a href="?page=users/createForm">New</a>
</div>