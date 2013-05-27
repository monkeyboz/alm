<style>
	#logoHolder .right{
		margin-left: 58px;
		margin-top: 0px;
	}
	#navHolder{
		overflow: hidden;
	}
	#logoHolder a{
		display: block;
	}
	.selected{
		background: #1c1c1c;
	}
</style>
<div id="logoHolder">
	<a href="?page=MainAdmin"><img src="images/logo.png"/></a>
	<img src="images/minus_button.png" class="right"/>
</div>
<div id="navHolder">
	<div id="navInfo">
		<a href="?page=MainAdmin">Dashboard</a>
		<a href="?page=properties/listProperties" <?php if($page[1] == 'listProperties') echo 'class="selected"'; ?>>Sitemaps</a>
		<a href="?page=users/listMaintenance" <?php if($page[1] == 'listMaintenance') echo 'class="selected"'; ?>>Maintenance</a>
		<a href="?page=properties/listAllFixtures" <?php if($page[1] == 'listAllFixtures') echo 'class="selected"'; ?>>Inventory</a>
		<a href="?page=fixtures/listPanels" <?php if($page[1] == 'listPanels') echo 'class="selected"'; ?>>Panels</a>
		<a href="?page=fixtures/listTimer" <?php if($page[1] == 'listTimer') echo 'class="selected"'; ?>>Controls</a>
		<a href="?page=users/listUsers" <?php if($page[1] == 'listUsers') echo 'class="selected"'; ?>>Users</a>
		<a href="?page=users/logout" <?php if($page[1] == 'logout') echo 'class="selected"'; ?> class="logout">Logout</a>
	</div>
</div>
<script>
	$('.right').click(function(){
		if($('#navHolder').height() > 0){
			$('#navHolder').animate({'height':'0px'},500);
			$('#leftNav').animate({'height':'0px','opacity':'0','width':'0px'},500);
			$('#topNav').animate({'height':'65px'},500);
			$('#contentHolder').animate({'margin-left':'0px','padding-top':'65px'},500);
		} else {
			$('#navHolder').animate({'height':$('#navInfo').height()+'px'},500);
			$('#topNav').animate({'height':'0px'},500);
			$('#leftNav').animate({'height':'100%','opacity':'1','width':'200px'},500);
			$('#contentHolder').animate({'margin-left':'200px','padding-top':'0px'},500);
		}
	})
	$.fn.animateNav = function(id){
		$(this).click(function(){
			var parent = $(this).parent();
			var siblingNav = $('#'+id);
			
			var link = $(this).attr('href');
			parent.find('a').each(function(){  $(this).removeClass('selected'); });
			siblingNav.find('a').each(function(){  $(this).removeClass('selected'); });
			$(this).addClass('selected');
			$.ajax({
				url: link+'&ajax=1',
				success: function(html){
					$('#contentHolder').stop();
					$('#contentHolder').animate({'opacity':'0'},500, function(){ $('#contentHolder').html(html); $('#contentHolder').animate({'opacity':'1'},500); });
				}
			})
			return false;
		})
	}
	$('.logout').click(function(){ window.location.href = $(this).attr('href'); });
	$('#leftNav a').each(function(){ $(this).animateNav('topnav'); });
	$('#topNav a').each(function(){ $(this).animateNav('leftnav'); });
</script>