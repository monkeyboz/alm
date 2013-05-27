<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Actor' rel='stylesheet' type='text/css'>
		<style>
			body{
				margin: 0px;
				font-family: 'Actor', sans-serif;
			}
			a{
				text-decoration: none;
				color: #fff;
			}
			form{
				background: rgba(0,0,0,.8);
				padding: 10px;
				color: #fff;
			}
			h3{
				background: #000;
				color: #fff;
				padding: 10px;
				margin: 0px;
			}
			input[type="text"]{
				border-radius: 5px;
				border: none;
				padding: 10px;
				margin: 10px 0px;
			}
			input[type="submit"]{
				border-radius: 5px;
				border: none;
				padding: 10px 15px;
				font-size: 14px;
				background: #0061ff;
				color: #fff;
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
			#mainOverlay{
				background: rgba(0,0,0,.8);
				position: absolute;
				top: 0px;
				left: 0px;
				width: 100%;
				height: 100%;
				display: none;
			}
			#overlayForm{
				
			}
			#leftNav{
				position: fixed;
				top: 0px;
				left: 0px;
				width: 200px;
				z-index: 10000;
				background: rgba(0,0,0,.8);
				text-align: center;
				height: 100%;
				overflow: hidden;
			}
			#navHolder a{
				display: block;
				padding: 25px;
				border-bottom: #444;
				color: #fff;
				text-decoration: none;
				border-bottom: #1c1c1c solid 1px;
			}
			#navHolder a:hover{
				background: #1c1c1c;
			}
			#logoHolder{
				padding: 20px;
				padding-bottom: 4px;
				border-bottom: #1c1c1c solid 1px;
				height: 40px;
			}
			#logoHolder img{
				float: left;
			}
			#contentHolder{
				position: relative;
				z-index: 10;
				margin-left: 200px;
			}
			#topNav{
				position: absolute;
				height: 0px;
				overflow: hidden;
				left: 0px;
				top: 0px;
				width: 100%;
				background: rgba(0,0,0,.8);
				z-index: 10000;
			}
			#topNav a{
				float: left;
				display: block;
			}
			#topNav #navHolder{
				float: left;
				left: 200px;
				overflow: hidden;
				position: absolute;
				top: -7px;
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
		<div id="leftNav">
			<?php include('views/navigation/'.$content->navLayout.'.php'); ?>
		</div>
		<div id="topNav">
			<?php include('views/navigation/'.$content->navLayout.'.php'); ?>
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