<?php
	session_start();
	include('config.php');
	include('db.php');
	$db = new db();
	
	if(isset($_GET['delete'])){
		$db->delete('properties', array('property_id'=>$_GET['id']));
	}
	if(isset($_POST['info']['address'])){
		$db->save('properties', array('address'=>$_POST['info']['address'], 'city'=>$_POST['info']['city'], 'state'=>$_POST['info']['state'],'user_id'=>$_SESSION['user_id']));
		//echo $db->debug;
	}
	
	$info = $db->query('SELECT * FROM properties WHERE user_id='.$_SESSION['user_id']);
?>
<style>
	body{
		margin: 0px;
	}
	form > div > div{
		width: 100px;
		float: left;
	}
	#holder{
		background: #efefef;
		padding: 10px;
		margin-bottom: 10px;
	}
	#holder tr{
		background: #fff;
	}
	#holder td{
		padding: 10px;
	}
</style>
<?php include('userNav.php'); ?>
<div id="holder">
	<table width="100%">
		<tr>
			<td>address</td>
			<td>total fixtures</td>
			<td>action</td>
		</tr>
		<?php foreach($info as $i){ 
			$fixtures = $db->query('SELECT fixture_id FROM fixtures WHERE property_id='.$i['property_id']);
		?>
		<tr>
			<td><?php echo $i['address']; ?></td>
			<td><?php echo sizeof($fixtures); ?></td>
			<td><a href="googlemaps.php?id=<?php echo $i['property_id']; ?>">View</a> | <a href="mainProperties.php?delete=true&id=<?php echo $i['property_id']; ?>">Delete</a></td>
		</tr>	
		<?php } ?>
	</table>
</div>
<h2>Add An Address	</h2>	
<form action="" method="POST">
	<div>
		<div>Address</div>
		<input type="text" name="info[address]">
	</div>
	<div>
		<div>City</div>
		<input type="text" name="info[city]">
	</div>
	<div>
		<div>State</div>
		<input type="text" name="info[state]">
	</div>
	<input type="submit" value="submit" name="submit"/>
</form>