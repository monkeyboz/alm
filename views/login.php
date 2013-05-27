<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Actor' rel='stylesheet' type='text/css'>
		<style>
			body{
				margin: 0px;
				font-family: 'Actor', sans-serif;
			}
			form input{
				border: none;
				border-radius: 5px;
				background: #1c1c1c;
				color: #fff;
				padding: 15px;
				margin-bottom: 10px;
			}
			input[name="submit"]{
				ursor: hand; 
				cursor: pointer;
			}
			#backgroundHolder{
				position: fixed;
				width: 100%;
				height: 100%;
			}
			#backgroundHolder img{
				width: 100%;
				height: 100%;
			}
			<?php echo $content->style[1]; ?>
		</style>
		<link href="css/tableDisplay.css" rel="text/style"></link>
		<script src="js/jquery.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="backgroundHolder">
			<img src="images/fullerton.jpg"/>
		</div>
		<div id="contentHolder">
			<div id="loginHolder">
				<div id="login">
					<?php echo $content->contents; ?>
				</div>
			</div>
		</div>
	</body>
</html>