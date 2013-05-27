<?php echo $info = $this->info; ?>
<style>
	#loginHolder{
		height: 0px;
		position: absolute;
		top: 50%;
		text-align: center;
		width: 100%;
	}
	#login{
		background: rgba(0,0,0,.8);
		width: 100%;
		min-height: 380px;
		position: absolute;
		top: -190px;
		padding-top: 100px;
	}
	form{
		padding: 10px;
		margin-top: 20px;
		width: 260px;
		margin: 0px auto;
	}
	form input[type="text"], form input[type="password"]{
		width: 260px;
	}
	input[name="submit"]{
		color: #fff;
		background: #0066CC;
		font-size: 14px;
		float: right;
	}
	.right{
		float: left;
	}
	.right a{
		color: #fff;
		text-decoration: none;
		font-size: 14px;
		font-weight: bold;
	}
	#fillOut{
		color: #fff;
		font-size: 11px;
		margin-bottom: 10px;
	}
</style>
<form action="?page=main/forgot" method="POST">
	<div id="fillOut">
		Please fill out the form below with your email that you used to sign up for ALM and we will send you your login credentials.
	</div>
	<div>
		<?php echo $this->showError('email','forgot'); ?>
		<input type="text" name="forgot[email]" value="Email Address"/>
	</div>
	<div><div class="right"><a href="?page=main">Return to Login</a></div><input type="submit" name="submit" value="Submit"/></div>
</form>
<script>
	$('input').click(function(){
		$(this).val('');
	})
</script>