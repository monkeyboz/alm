<?php if($_SESSION['login']){ 
	$_SESSION['login'] = false;
?>
	<div style="width: 100%; height: 0px; position: absolute; top: 50%; left: 50%; margin: 0px auto;" class="loginOverlay">
		<div style="background: rgba(0,0,0,.8); width: 100%; height: 100%;">
			<div style="background: #000; padding: 10px; color: #fff; position: absolute; left: -100px;"><?php $user = $this->query('SELECT * FROM users WHERE user_id='.$_SESSION['user_id']); ?>
			<a href="" class="close" style="color: #fff; clear: both;">close x</a>
			Welcome back <?php echo $user[0]['first_name']; ?> <?php echo $user[0]['last_name']; ?>!</div>
		</div>
	</div>
<?php } ?>
<?php echo $this->propertyDisplay; ?>
<script>
	$('.close').click(function(){
		
	})
</script>