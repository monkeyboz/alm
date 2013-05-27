<link rel="stylesheet" type="text/css" href="css/tableDisplay.css">
<?php
	$info = $this->info;
?>
<form action="?page=users/search" method="POST">
    <span style="color: #fff; font-size: 20px;">Fixtures</span> <input type="text" value="search" name="users[search]" onclick="$(this).val('');"/>
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
		<div>Name</div>
		<div>Watts</div>
        <div>Description</div>
        <div>Type</div>
		<div></div>
	</div>
<?php
foreach($info as $i){
?>
	<div class="even">
		<div><?php echo $i['name']; ?></div>
		<div><?php echo $i['watts']; ?></div>
        <div><?php echo $i['description']; ?></div>
        <div><?php echo $i['type']; ?></div>
		<div><a href="?page=fixtures/view/<?php echo $i['fixture_type_id']; ?>">View</a> | <a href="?page=fixtures/remove/<?php echo $i['fixture_type_id']; ?>">Delete</a> | <a href="?page=fixtures/editForm/<?php echo $i['fixture_type_id']; ?>">Edit</a></div>
	</div>
<?php
}
?>
</div>
<div id="bottomNav">	
	<a href="?page=fixtures/createForm">New</a>
</div>