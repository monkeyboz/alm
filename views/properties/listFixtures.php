<link rel="stylesheet" type="text/css" href="css/tableDisplay.css">
<?php
	$info = $this->info;
	$fixtures = $this->query('SELECT * FROM fixture_type');
	$fixture_type = array();
	foreach($fixtures as $f){
		$fixture_type[$f['name']] = $f;
	}
?>
<form action="" method="POST">
    <span style="color: #fff; font-size: 20px;">Fixtures</span> <input type="text" value="search" name="search" onclick="$(this).val('');"/>
    <div class="right">
		<select name="fixtures[term]">
			<option value="type">type</option>
			<option value="status">status</option
        </select>
        <input type="submit" value="Search" name="Submit" />
    </div>
</form>
<div class="table">
	<div class="header">
		<div>Name</div>
		<div>Watts</div>
		<div>Property</div>
		<div>Current Status</div>
		<div></div>
	</div>
<?php
foreach($info as $k=>$i){ 
    $ftr = $this->query('SELECT * FROM maintenance as m WHERE m.type="fixture" AND m.type_id='.$i['fixture_id'].' AND m.status != "closed" ORDER BY m.date DESC');
    $even = ($k%2)?'even':'odd';
    $status = 'current';
    
    if(sizeof($ftr) > 0){
        $status = '<span class="error">Initial Maintenance</span>';
        $holder = $this->query('SELECT * FROM logs WHERE type LIKE "%maintenance%" AND type_id='.$ftr[0]['maintenance_id'].' ORDER BY date DESC');
    
        //print_r($holder);
        if(sizeof($holder) > 0){
            $status = str_replace('maintenance_', '', $holder[0]['type']);
            $status = '<span class="'.$status.'">'.ucfirst($status).'</span>';
        }
    }
    //$status = (isset($ftr['']))?'Initial Request':;
    if(!isset($i['name'])){
        $v = $this->query('SELECT name FROM properties as p JOIN fixtures as f ON p.property_id = f.property_id WHERE f.fixture_id = '.$i['fixture_id']);
        $i['name'] = $v[0]['name'];
    } 
?>
	<div class="<?php echo $even; ?>">
		<div><?php echo $fixture_type[$i['type']]['name']; ?></div>
		<div><?php echo $fixture_type[$i['type']]['watts']; ?></div>
		<div><a href="?page=properties/propertyDisplay/<?php echo $i['property_id']; ?>"><?php echo $i['name']; ?></a></div>
                <div><?php echo $status; ?></div>
                <div><a href="?page=properties/propertyDisplay/<?php echo $i['property_id']; ?>">View</a> | <a href="?page=properties/maintenanceLog/<?php echo $i['fixture_id']; ?>">Maintenance</a> | <a href="?page=properties/deleteFixture/<?php echo $i['fixture_id']; ?>" class="remove">Delete</a></div>
	</div>
<?php
}
?>
</div>
<div class="bottomNav">
	<a href="?page=fixtures/createPanel">New</a>
</div>