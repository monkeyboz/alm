<style>
	.right{
		margin-left: 58px;
	}
	#navHolder{
		overflow: hidden;
	}
	#logoHolder a{
		display: block;
	}
</style>
<div id="logoHolder">
	<a href="?page=MainAdmin"><img src="images/logo.png"/></a>
	<img src="images/minus_button.png" class="right"/>
</div>
<div id="navHolder">
	<div id="navInfo">
		<a href="?page=MainAdmin">Dashboard</a>
		<a href="?page=fixtures/createForm" class="add">Add Fixture</a>
	</div id="navInfo">
</div>
<script>
	$('.right').click(function(){
		if($('#navHolder').height() > 0){
			$('#navHolder').animate({'height':'0px'},500);
			$('#topNav').animate({'height':'58px'},500);
		} else {
			$('#navHolder').animate({'height':$('#navInfo').height()+'px'},500);
			$('#topNav').animate({'height':'100%'},500);
		}
	})
</script>