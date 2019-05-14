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
		<div></div>
	</div>
<?php
foreach($info as $k=>$i){
	$even = ($k%2 == 0)?'even':'odd';
?>
	<div class="<?php echo $even; ?>">
		<div><?php echo $i['name']; ?></div>
		<div><?php echo $i['watts']; ?></div>
        <div><?php echo $i['description']; ?></div>
        <div><?php $this->editOptions('fixture_type',$i['fixture_type_id']); ?></div>
	</div>
	</div>
<?php
}
?>
</div>
<div id="bottomNav">	
	<a href="?page=fixtures/createForm">New</a>
</div>