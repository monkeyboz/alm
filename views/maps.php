<html>
	<head>
		<link href='//fonts.googleapis.com/css?family=Actor' rel='stylesheet' type='text/css'>
		<style>
			body{
				margin: 0px;
				font-family: 'Actor', sans-serif;
			}
			a{
				text-decoration: none;
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
			#overlayFormHolder{
				display: block;
				position: absolute;
				z-index: 1000;
				text-align: center;
				height: 0px;
				width: 0px;
				top: 50%;
				left: 50%;
				opacity: 0;
			}
			#overlayForm{
				width: 400px;
				background: rgba(0,0,0,.8);
				color: #fff;
				padding: 10px;
				text-align: left;
				position: absolute;
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
		<script src="js/jquery.js" type="text/javascript"></script>
		<link href="css/tableDisplay.css" rel="text/style"></link>
	</head>
	<body>
		<div id="backgroundHolder">
			<img src="images/fullerton.jpg"/>
		</div>
		<div id="leftNav">
			<?php include('views/navigation/contents.php'); ?>
		</div>
		<div id="topNav">
			<?php include('views/navigation/contents.php'); ?>
		</div>
		<div id="contentHolder">
			<div id="loginHolder">
				<div id="login">
					<?php echo $content->contents; ?>
				</div>
			</div>
		</div>
		<div id="mainOverlay"></div>
		<div id="overlayFormHolder">
			<div id="overlayForm"></div>
		</div>
	</body>
</html>