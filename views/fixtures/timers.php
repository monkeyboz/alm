<link rel="stylesheet" type="text/css" href="css/tableDisplay.css">
<?php
	$info = $this->info;
?>
<form action="?page=fixtures/searchPanels" method="POST">
    <span style="color: #fff; font-size: 20px;">Controls</span> <input type="text" value="search" name="panel[search]" onclick="$(this).val('');"/>
    <div class="right">
		<select name="panel[term]">
			<option value="name">type</option>
			<option value="status">status</option
        </select>
        <input type="submit" value="Search" name="Submit" />
    </div>
</form>
<div class="table">
	<div class="header">
		<div>Name</div>
		<div>Voltage</div>
        <div>Manufacturer</div>
        <div>Type</div>
		<div></div>
	</div>
<?php
foreach($info as $i){
?>
	<div class="even">
		<div><?php echo $i['name']; ?></div>
		<div><?php echo $i['voltage']; ?></div>
        <div><?php echo $i['manufacturer']; ?></div>
        <div><?php echo $i['type']; ?></div>
		<div><a href="?page=fixtures/viewTimer/<?php echo $i['panel_id']; ?>">View</a> | <a href="?page=fixtures/removeTimer/<?php echo $i['panel_id']; ?>">Delete</a> | <a href="?page=fixtures/editTimer/<?php echo $i['panel_id']; ?>">Edit</a></div>
	</div>
<?php
}
?>
</div>
<div class="bottomNav">
	<a href="?page=fixtures/createTimer">New</a>
</div>