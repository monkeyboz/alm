<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include('config.php');
	include('db.php');
	$db = new db();
	
	if(isset($_POST['latlon'])){
		$position = explode(',', $_POST['latlon']);
		$type = explode('.', $_POST['icon']);
		$id = $_POST['id'];
		
		$lat = str_replace('(', '', $position[0]);
		$lon = str_replace(')', '', $position[1]);
		
		$test = $db->query('SELECT * FROM fixtures WHERE fixture_id='.$_POST['markerId']);
		if(sizeof($test) < 1){
			$id = $db->save('fixtures', array('property_id'=>$id,'lat'=>$lat,'lon'=>$lon, 'type'=>$type[0]));
			echo $id;
		} else {
			$db->edit('fixtures', array('lat'=>$lat,'lon'=>$lon), array('fixture_id'=>$_POST['markerId']));
			echo $_POST['markerId'];
		}
	}
?>