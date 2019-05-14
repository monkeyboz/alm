<?php $info = $this->info; ?>
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
		font-size: 12px;
		float: right;
		padding: 10px 15px;
	}
	#logo{
		text-align: left;
		margin-bottom: 10px;
	}
	.right{
		float: left;
	}
	.right a{
		color: #fff;
		text-decoration: none;
		font-size: 12px;
		font-weight: bold;
	}
</style>
	
		<form action="" method="POST">
			<div id="logo"><img src="images/logo.png"/></div>
			<div>
				<?php echo $this->showError('username','login'); ?>
				<input type="text" name="login[username]" value="Username"/>
			</div>
			<div>
				<?php echo $this->showError('password','login'); ?>
				<input type="password" name="login[password]" value="Password"/>
			</div>
			<div><div class="right"><a href="?page=main/forgot">Forgot Password?</a></div><input type="submit" name="submit" value="Login"/></div>
		</form>
	</div>
</div>
<script>
	$('input[type="text"]').click(function(){
		$(this).val('');
	})
</script>