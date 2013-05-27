<?php 
	include('config.php');
	include('db.php');

	$db = new db();
	$db->delete('fixtures', array('fixture_id'=>$_POST['id']));
	echo $db->debug;
?>