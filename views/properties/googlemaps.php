<?php
	$property = $this->info[0];
	$fixtures = $this->fixtures;
	$fixture_type = $this->fixture_type;
	$panel_type = $this->query('SELECT * FROM panels');
	$properties = $this->query('SELECT * FROM properties WHERE user_id='.$_SESSION['user_id']);
?>
        <style type="text/css">
            *{
                margin: 0px;
                padding: 0px;
				font-family: arial;
            }
            html { height: 100% }
            body{ height: 100%; margin: 0px; padding: 0px;}
            #map_canvas { height: 100% }
            .cleanMap{
            }
            #shelf{position:fixed; top:10px; left:500px; height:100px;width:200px;background:white;opacity:0.7;}
            #draggable {position:absolute; top:10px; left:10px; width: 30px; height: 30px;z-index:1000000000;}
			.boxNav a{
				float: left;
				padding: 10px;
				background: #545454;
				color: #fff;
				text-decoration: none;
			}
                        .indicator{
                            position: absolute;
                            right: 20px;
                            top: 5px;
                        }
			#info a{
				color: #fff;
				text-decoration: none;
				text-transform: uppercase;
				padding-right: 20px;
				font-size: 13px;
			}
			#propertyHolder{
				position: fixed;
				top: 10px;
				right: 40px;
			}
                        #fixtureNav{
                            position: fixed;
                            z-index: 10000;
                            background: rgba(255,255,255,.8);
							bottom: 37px;
                            right: 173px;
                            border-radius: 10px;
                            box-shadow: 0px 2px 10px #000;
							overflow: hidden;
							border: 1px solid #545454;
                        }
                        #fixtureNav a{
                            clear: both;
                            display: block;
                            text-align: left;
                            padding: 10px;
                            font-weight: bold;
                            font-size: 11px;
                        }
                        #fixtureSearch{
                            background: rgba(0,0,0,.8);
                            min-height: 100px;
                            max-height: 101px;
                            overflow-y: scroll;
							margin-top: 10px;
							padding: 10px;
							border-radius: 5px;
                        }
						#panelSearch{
                            background: rgba(0,0,0,.8);
                            min-height: 100px;
                            max-height: 101px;
                            overflow-y: scroll;
							margin-top: 10px;
							padding: 10px;
							border-radius: 5px;
                        }
                        #holderLayout{
							background: rgba(255,255,255,.8);
							padding: 10px;
							border-radius: 5px;
                        }
                        #bottomMapNav{
                            position: fixed;
                            bottom: 40px;
                            right: 10px;
                            font-size: 11px;
                            z-index: 10;
                        }
                        #bottomMapNav #new{
                            background: #fff;
							color: #545454;
							border: #545454 solid 1px;
							border-radius: 5px;
							box-shadow: 0px 1px 2px #000;
							padding: 13;
							font-size: 11px;
                        }
						#bottomMapNav #site{
							margin-top: 5px;
						}
						#bottomMapNav #siteHolder{
							float: left;
							background: #fff;
							border-radius: 5px;
							width: 30px;
							padding: 3px;
							border: 1px solid #545454;
							box-shadow: 0px 1px 3px;
							margin-top: -11px;
							margin-right: 12px;
						}
						input[name="fixtures[search]"]{
							border-radius: 5px;
							border: 1px solid #545454;
							padding: 5px 10px;
							background: #545454;
							color: #fff;
						}
						input[name="search"]{
							background: #0061ff;
							padding: 5px 10px;
							border: 0px;
							border-radius: 5px;
							color: #fff;
						}
						.close{
							margin-bottom: 10px;
						}
						.propertySelect{
							padding: 10px;
							border-radius: 5px;
							border: none;
						}
        </style>
		<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
		<link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="https://maps-api-ssl.google.com/maps/api/js?v=3&amp;sensor=false&amp;key=AIzaSyCOhw6iwEmOs7m3q_Rz3yN7nM7TEcRL0Vo"></script>
    <script type="text/javascript">
      var script = '<script type="text/javascript" src="js/infobubble';
      script += '.js"><' + '/script>';
      document.write(script);
	  
		$(document).ready(function(){
			$('.propertySelect').change(function(){
				window.location.href = $(this).val();
			});
		})
	  
	  function overlay(link){
						$.ajax({
                                    url: link+'&ajax=1',
                                    type: 'POST',
                                    success: function(html){
                                            $('#overlayForm').html(html);

                                            $('#mainOverlay').css('opacity','0').css('display','block');
                                            $('#overlayFormHolder').css('opacity','0').css('display','block');

                                            var top = $('#overlayForm').height()/2;
                                            var left = $('#overlayForm').width()/2;
                                            $('#overlayForm').css('top','-'+top+'px').css('left','-'+left+'px');

                                            $('#mainOverlay').animate({'opacity':1},500);
                                            $('#overlayFormHolder').animate({'opacity':1},500);
											
											$('input[name="addFixture"]').click(function(){
												var parent = $(this).parent().parent();
												var data = '';
												parent.find('input[type="text"]').each(function(){
													data += $(this).attr('name')+'='+$(this).val()+'&';
												})
												data += 'icon='+parent.find('input:radio[name="icon"]:checked').val();
												$.ajax({
													url: '?page=fixtures/createForm&ajax=1',
													type: 'POST',
													data: data,
													success: function(html){
														var json = jQuery.parseJSON(html);
														$('#fixtureSearch').prepend('<a href="" id="'+json.name.replace(' ','_')+'">'+json.name+'</a>');
														$('#'+json.name.replace(' ','_')).css('color','#00ff00');
														$('#'+json.name.replace(' ','_')).click(function(){
															addMarker('uploads/icon/'+json.name+'.png', 'Type: '+json.name+'<br/>Watts: '+json.watts+'<br/>');
															return false;
														})
														$('#mainOverlay').stop();
														$('#overlayFormHolder').stop();
														$('#mainOverlay').animate({'opacity':0},500,function(){ $(this).css('display','none'); });
														$('#overlayFormHolder').animate({'opacity':0},500,function(){ $(this).css('display','none'); $('#overlayForm').html(''); });
													}
												})
												return false;
											})
											
											$('input[name="editFixture"]').click(function(){
												var parent = $(this).parent().parent();
												var data = '';
												parent.find('input[type="text"]').each(function(){
													data += $(this).attr('name')+'='+$(this).val()+'&';
												})
												data += 'icon='+parent.find('input:radio[name="icon"]:checked').val();
												$.ajax({
													url: '?page=fixtures/createForm&ajax=1',
													type: 'POST',
													data: data,
													success: function(html){
														var json = jQuery.parseJSON(html);
														
														$('#mainOverlay').stop();
														$('#overlayFormHolder').stop();
														$('#mainOverlay').animate({'opacity':0},500,function(){ $(this).css('display','none'); });
														$('#overlayFormHolder').animate({'opacity':0},500,function(){ $(this).css('display','none'); $('#overlayForm').html(''); });
													}
												})
												return false;
											})

                                            $('#mainOverlay').click(function(){
                                                    $('#mainOverlay').stop();
                                                    $('#overlayFormHolder').stop();
                                                    $('#mainOverlay').animate({'opacity':0},500,function(){ $(this).css('display','none'); });
                                                    $('#overlayFormHolder').animate({'opacity':0},500,function(){ $(this).css('display','none'); $('#overlayForm').html(''); });
                                            })
                                    }
                            })
					}
    </script>
        <div>
        <div id="map_canvas"></div>
        <div id="info">
	<div id="fixtureNav">
            <div id="holderLayout">
                <div class="close"><b>x</b></div>
				<h6><b>Fixtures</b></h6>
                <form action="" method="POST">
                    <input type="text" name="fixtures[search]"/>
                    <input type="submit" name="search" value="Search"/>
                </form>
                <div id="fixtureSearch">
            <?php foreach($fixture_type as $f){ ?>
                <a href="" id="<?php echo str_replace(' ', '_', $f['name']); ?>"><?php echo $f['name']; ?></a>
            <?php } ?>
                </div>
				<h6 style="margin-top: 20px;"><b>Panels</b></h6>
				<form action="" method="POST">
                    <input type="text" name="fixtures[search]"/>
                    <input type="submit" name="search" value="Search"/>
                </form>
				<div id="panelSearch">
				<?php foreach($panel_type as $f){ ?>
					<a href="" id="<?php echo str_replace(' ', '_', $f['name']); ?>"><?php echo $f['name']; ?></a>
				<?php } ?>
                </div>
            </div>
        </div>
            <div id="bottomMapNav">
                <div id="siteHolder"><a href="" id="site"><img src="images/refresh_button.png"/></a></div>
                <a href="?page=fixtures/createForm" id="new">New Fixture</a>
            </div>
			<div id="propertyHolder">
				<select name="propertySelect" class="propertySelect">
					<?php foreach($properties as $p){ ?>
					<option value="?page=properties/propertyDisplay/<?php echo $p['property_id']; ?>"><?php echo $p['name']; ?></option>
					<?php } ?>
				</select>
			</div>
		<script type="text/javascript">
			$(document).ready(function(){
				var $map;
				var $latlng;
				var overlay;
				var markerArray = new Array;
								
                                $('#map_canvas').click(function(e){
                                    if(e.shiftKey){
                                        if($('#fixtureNav').css('opacity') == 0){
                                            $('#fixtureNav').animate({'opacity':1},500);
                                            $('#holderLayout').css('height','200px').css('left',e.pageX+'px').css('top',e.pageY+'px');
                                        } else {
                                            $('#fixtureNav').animate({'opacity':0},500);
                                            $('#holderLayout').css('height','0px');
                                        }
                                    }
                                })
                                
								$.fn.topNav = function(){
									$(this).data('fixtureSearchHeight',$('#fixtureSearch').height()+85);
									$(this).data('panelSearchHeight',$('#panelSearch').height()+108);
									$(this).click(function(){
										var height = $(this).data('panelSearchHeight') + $(this).data('fixtureSearchHeight');
										if($('#holderLayout').height() < height){
											$('#holderLayout').animate({'height':height+'px'},500);
										} else {
											$('#holderLayout').animate({'height':'20px'},500);
										}
										return false;
									});
								}
                                $('#fixtureNav .close').topNav();
                                
                                $('.viewFixtures').click(function(){
                                    if($('#fixtureNav').css('opacity') == 0){
                                        $('#fixtureNav').animate({'opacity':1,'height':'200px'},500);
                                        $('#holderLayout').css('height','200px');
                                    } else {
                                        $('#fixtureNav').animate({'opacity':0,'height':'0px'},500);
                                        $('#holderLayout').css('height','0px');
                                    }
                                    return false;
                                })
				
				var geocoder = new google.maps.Geocoder();
				
				<?php if($property['lat'] != ''){ ?>
				$latlng = new google.maps.LatLng(<?php echo $property['lat']; ?>,<?php echo $property['log']; ?>);
				setMap();
				<?php } else { ?>
				//$latlng = new google.maps.LatLng(<?php echo $property['lat']; ?>,<?php echo $property['log']; ?>);
				geocoder.geocode({address:'<?php echo $property['address']; ?> <?php echo $property['city']; ?>, <?php echo $property['state']; ?>'}, function(results, status){ $latlng = results[0].geometry.location; setMap(); });
				<?php } ?>
				function setMap(){
					var myOptions = {
						zoom: 19,
						center: $latlng,
						mapTypeId: google.maps.MapTypeId.SATELLITE,
						mapTypeControl: false,
						zoomControl: true,
						zoomControlOptions: {
							style: google.maps.ZoomControlStyle.LARGE,
							position: google.maps.ControlPosition.RIGHT_TOP
						},
						streetViewControl: false,

						panControl:false,

					};
					
					var id;
					var markers = {};
					var markersId = {};
					
					$map = new google.maps.Map(document.getElementById("map_canvas"),
					myOptions);
					
					function addInitMarkers(fixture_id, image, type, fixture_info, lat, lon){
						var newlatlng = new google.maps.LatLng(lat, lon);
						
						marker = new google.maps.Marker({ 
							position: newlatlng,
							map: $map,
							title: type,
							draggable: true,
							animation: google.maps.Animation.DROP,
							icon: image,
							size: new google.maps.Size(25, 25),
						});
						$map.panTo($latlng);
						id = marker.__gm_id;
						markers[id] = marker;
						markersId[id] = fixture_id;

						var boxNav = '<a href="javascript:overlay(\'?page=fixtures/requestMaintenance/'+fixture_id+'\')" class="maintenance">Request Maintenance</a><a href="javascript:overlay(\'?page=fixtures/editFixture/'+fixture_id+'\')">Update</a><a href="javascript:overlay(\'?page=notes/createForm/'+id+'/fixture/\')">Notes</a>';
						
						marker.info = new InfoBubble({content:'<div style="color: #000;  width: 283px; overflow: hidden; padding: 10px;"><div class="indicator"><img src="images/indicator.png"/></div>Fixture id: '+ marker.__gm_id + '<br/>'+fixture_info+'<div class="boxNav">'+boxNav+'</div>',padding:0,minHeight:130,backgroundClassName:'cleanMap'})
						
						google.maps.event.addListener(marker, "rightclick", function (point) { id = this.__gm_id; delMarker(id) });
						google.maps.event.addListener(marker, "click", function (point) { id = this.__gm_id; locationOnClick(id) });
						google.maps.event.addListener(marker, "dragend", function (point) { id = this.__gm_id; dragEnd(id) });
						
					}
					
					<?php foreach($fixtures as $f){ ?>
					addInitMarkers(<?php echo $f['fixture_id'] ?>,'uploads/icon/<?php echo $f['type'] ?>.png', '<?php echo $f['type']; ?>','Type: <?php echo $f['type']; ?><br/>Watts: <?php //echo $f['watts']; ?><br/></div>', <?php echo $f['lat']; ?>, <?php echo $f['lon']; ?>)
					<?php } ?>
					
					function dragEnd(id){
						marker = markers[id];
						
						$.ajax({
							url: '?page=properties/saveMarker&debug=1',
							data: 'latlon=' + marker.position +'&icon='+marker.icon+'&id=<?php echo $this->id; ?>&markerId='+markersId[id],
							type: 'POST',
							success: function(html){
								var json = jQuery.parseJSON(html);
                                                                markersId[id] = json[0]['fixture_id'];
                                                                
                                                                var boxNav = '<a href="javascript:overlay(\'?page=fixtures/requestMaintenance/'+json[0]['fixture_id']+'\')">Request Maintenance</a><a href="javascript:overlay(\'?page=fixtures/editFixture/'+json[0]['fixture_id']+'\')">Update</a><a href="javascript:overlay(\'?page=notes/createForm/'+json[0]['fixture_id']+'/fixture/\')">Notes</a>';
						
                                                                marker.info = new InfoBubble({content:'<div style="color: #000;  width: 308px; overflow: hidden; padding: 10px;"><div class="indicator"><img src="images/indicator.png"/></div>Fixture id: '+ json[0]['fixture_id']+ '<br/>Type: '+json[0]['name']+'<br/>Watts: '+json[0]['watts']+'<br/><div class="boxNav">'+boxNav+'</div>',padding:0,minHeight:130,backgroundClassName:'cleanMap'})

							}
						})
					}
					
					$('#site').click(function(){
						$.ajax({
							url: '?page=properties/saveOrigin&ajax=1',
							type: 'POST',
							data: 'origin='+$map.getCenter()+'&id=<?php echo $this->id; ?>',
							success: function(html){
								
							}
						});
						return false;
					});
					
					var addPanel = function (image,fixture_info,type){
						marker = new google.maps.Marker({ 
							position: $map.getCenter(),
							map: $map,
							title: 'Panel',
							draggable: true,
							animation: google.maps.Animation.DROP,
							icon: image,
							size: new google.maps.Size(25, 25),
						});
						//$map.panTo($latlng);
                        
                        id = marker.__gm_id;
                        $.ajax({
                            url: '?page=properties/savePanel&debug=1',
                            data: 'latlon=' + marker.position +'&icon='+marker.icon+'&id=<?php echo $this->id; ?>&markerId=null',
                            type: 'POST',
                            success: function(html){
                                var json = jQuery.parseJSON(html);
                                markerId[id] = '{json[0].name,json[0].panel_id}';
                                markers[id] = marker;
                                
                                var boxNav = '<a href="javascript:overlay(\'?page=fixtures/requestMaintenance/'+json[0]['panel_id']+'/panel\')">Request Maintenance</a><a href="javascript:overlay(\'?page=fixtures/editPanel/'+json[0]['fixture_id']+'/\')">Update</a><a href="javascript:overlay(\'?page=notes/createForm/'+json[0]['fixture_id']+'/fixture/\')">Notes</a>';
                                
                                marker.info = new InfoBubble({content:'<div style="color: #000;  width: 308px; overflow: hidden; padding: 10px;"><div class="indicator"><img src="images/indicator.png"/></div>Fixture id: '+ json[0].fixture_id + '<br/>Type: '+json[0].name+'<br/>Watts: '+json[0].watts+'<br/><div class="boxNav">'+boxNav+'</div>',padding:0,minHeight:130,backgroundClassName:'cleanMap'})
								
                                google.maps.event.addListener(marker, "rightclick", function (point) { id = this.__gm_id; delMarker(id) });
                                google.maps.event.addListener(marker, "click", function (point) { id = this.__gm_id; locationOnClick(id) });
                                google.maps.event.addListener(marker, "dragend", function (point) { id = this.__gm_id; dragEnd(id) });
                            }
                        })
						
						$('.boxNav').click(function(){
							boxNav = '';
						});
					}
					
					var addMarker = function (image,fixture_info,type){
						marker = new google.maps.Marker({ 
							position: $map.getCenter(),
							map: $map,
							title: 'Fixture',
							draggable: true,
							animation: google.maps.Animation.DROP,
							icon: image,
							size: new google.maps.Size(25, 25),
						});
						//$map.panTo($latlng);
                        
                        id = marker.__gm_id;
                        $.ajax({
                            url: '?page=properties/saveMarker&debug=1',
                            data: 'latlon=' + marker.position +'&icon='+marker.icon+'&id=<?php echo $this->id; ?>&markerId=null',
                            type: 'POST',
                            success: function(html){
                                var json = jQuery.parseJSON(html);
                                markersId[id] = '{json[0].name,json[0].fixture_id}';
                                markers[id] = marker;
                                
                                var boxNav = '<a href="javascript:overlay(\'?page=fixtures/requestMaintenance/'+json[0]['fixture_id']+'\')">Request Maintenance</a><a href="javascript:overlay(\'?page=fixtures/editFixture/'+json[0]['fixture_id']+'\')">Update</a><a href="javascript:overlay(\'?page=notes/createForm/'+json[0]['fixture_id']+'/fixture/\')">Notes</a>';
                                
                                marker.info = new InfoBubble({content:'<div style="color: #000;  width: 308px; overflow: hidden; padding: 10px;"><div class="indicator"><img src="images/indicator.png"/></div>Fixture id: '+ json[0].fixture_id + '<br/>Type: '+json[0].name+'<br/>Watts: '+json[0].watts+'<br/><div class="boxNav">'+boxNav+'</div>',padding:0,minHeight:130,backgroundClassName:'cleanMap'})
								
                                google.maps.event.addListener(marker, "rightclick", function (point) { id = this.__gm_id; delMarker(id) });
                                google.maps.event.addListener(marker, "click", function (point) { id = this.__gm_id; locationOnClick(id) });
                                google.maps.event.addListener(marker, "dragend", function (point) { id = this.__gm_id; dragEnd(id) });
                            }
                        })
						
						$('.boxNav').click(function(){
							boxNav = '';
						});
					}

					var delMarker = function (id) {
						marker = markers[id];
						marker.setMap(null);
						$.ajax({
							url: '?page=properties/deleteMarker',
							data: 'id='+markersId[id],
							type: 'POST',
							success: function(html){
								
							}
						})
					}
					
					function locationOnClick(id) {
						marker = markers[id];
						marker.info.open($map, marker);
					}
				
					<?php foreach($fixture_type as $f){ ?>
					$('#<?php echo str_replace(' ', '_', $f['name']); ?>').click(function(){
						addMarker('uploads/icon/<?php echo $f['name']; ?>.png', 'Type: <?php echo $f['name']; ?><br/>Watts: <?php echo $f['watts']; ?><br/>');
						return false;
					})
					<?php }?>
					<?php foreach($panel_type as $f){ ?>
					$('#<?php echo str_replace(' ', '_', $f['name']); ?>').click(function(){
						addPanel('uploads/icon/<?php echo $f['name']; ?>.png', 'Type: <?php echo $f['name']; ?><br/>Voltage: <?php echo $f['voltage']; ?><br/>Breaker Type: <?php echo $f['breaker_type']; ?><br/>Type: <?php echo $f['type']; ?><br/>','panel');
						return false;
					})
					<?php }?>
					
                                        $('input[name="search"]').parent().submit(function(){
                                        var data = 'search='+$(this).find('input[name="fixtures[search]"]').val();
										$('#findSearch').html('loading...');
                                        $.ajax({
                                            url: '?page=fixtures/search&ajax=1',
                                            data: data,
                                            type: 'POST',
                                            success: function(html){
                                                var json = jQuery.parseJSON(html);
                                                $('#fixtureSearch').html('');
                                                for(var i = 0; i < json.length;i++){
                                                    var info = json[i];
                                                    $('#fixtureSearch').append('<a href="" id="'+info.name.replace(' ','_')+'">'+info.name+'</a>');
                                                    
                                                    $('#'+info.name.replace(' ','_')).data('name',info.name);
                                                    $('#'+info.name.replace(' ','_')).data('watts',info.watts);
                                                    $('#'+info.name.replace(' ','_')).click(function(){
                                                        addMarker('uploads/icon/'+$(this).data('name')+'.png', 'Type: '+$(this).data('name')+'<br/>Watts: '+$(this).data('watts')+'<br/>');
                                                        return false;
                                                    })
                                                }
                                            }
                                        })
                                        return false;
                                    })
									jQuery.fn.overlayForm = function(){
                    $(this).click(function(){
                            $('#mainOverlay').stop();
                            $('#overlayFormHolder').stop();

                            var link = $(this).attr('href');
                            $.ajax({
                                    url: link+'&ajax=1',
                                    type: 'POST',
                                    success: function(html){
                                            $('#overlayForm').html(html);

                                            $('#mainOverlay').css('opacity','0').css('display','block');
                                            $('#overlayFormHolder').css('opacity','0').css('display','block');

                                            var top = $('#overlayForm').height()/2;
                                            var left = $('#overlayForm').width()/2;
                                            $('#overlayForm').css('top','-'+top+'px').css('left','-'+left+'px');

                                            $('#mainOverlay').animate({'opacity':1},500);
                                            $('#overlayFormHolder').animate({'opacity':1},500);
											
											$('input[name="addFixture"]').click(function(){
												var parent = $(this).parent().parent();
												var data = '';
												parent.find('input[type="text"]').each(function(){
													data += $(this).attr('name')+'='+$(this).val()+'&';
												})
												data += 'icon='+parent.find('input:radio[name="icon"]:checked').val();
												$.ajax({
													url: '?page=fixtures/createForm&ajax=1',
													type: 'POST',
													data: data,
													success: function(html){
														var json = jQuery.parseJSON(html);
														$('#fixtureSearch').prepend('<a href="" id="'+json.name.replace(' ','_')+'">'+json.name+'</a>');
														$('#'+json.name.replace(' ','_')).css('color','#00ff00');
														$('#'+json.name.replace(' ','_')).click(function(){
															addMarker('uploads/icon/'+json.name+'.png', 'Type: '+json.name+'<br/>Watts: '+json.watts+'<br/>');
															return false;
														})
														$('#mainOverlay').stop();
														$('#overlayFormHolder').stop();
														$('#mainOverlay').animate({'opacity':0},500,function(){ $(this).css('display','none'); });
														$('#overlayFormHolder').animate({'opacity':0},500,function(){ $(this).css('display','none'); $('#overlayForm').html(''); });
													}
												})
												return false;
											})
											
											$('input[name="editFixture"]').click(function(){
												var parent = $(this).parent().parent();
												var data = '';
												parent.find('input[type="text"]').each(function(){
													data += $(this).attr('name')+'='+$(this).val()+'&';
												})
												data += 'icon='+parent.find('input:radio[name="icon"]:checked').val();
												$.ajax({
													url: '?page=fixtures/createForm&ajax=1',
													type: 'POST',
													data: data,
													success: function(html){
														var json = jQuery.parseJSON(html);
														
														$('#mainOverlay').stop();
														$('#overlayFormHolder').stop();
														$('#mainOverlay').animate({'opacity':0},500,function(){ $(this).css('display','none'); });
														$('#overlayFormHolder').animate({'opacity':0},500,function(){ $(this).css('display','none'); $('#overlayForm').html(''); });
													}
												})
												return false;
											})

                                            $('#mainOverlay').click(function(){
                                                    $('#mainOverlay').stop();
                                                    $('#overlayFormHolder').stop();
                                                    $('#mainOverlay').animate({'opacity':0},500,function(){ $(this).css('display','none'); });
                                                    $('#overlayFormHolder').animate({'opacity':0},500,function(){ $(this).css('display','none'); $('#overlayForm').html(''); });
                                            })
                                    }
                            })
                            return false;
                    });
            }
            $('#new').overlayForm();
				}
			});
			$("#fixtureSearch").mCustomScrollbar();
			$("#panelSearch").mCustomScrollbar();
        </script>