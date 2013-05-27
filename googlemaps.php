<?php 
	session_start();
	include('config.php');
	include('db.php');
	
	$db = new db();
	$property = $db->query('SELECT * FROM properties WHERE property_id='.$_GET['id']);
	$property = $property[0];
	$fixtures = $db->query('SELECT * FROM fixtures WHERE property_id='.$_GET['id']);
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>MVC is Fun</title>

        <style type="text/css">
            *{
                margin: 0px;
                padding: 0px;
				font-family: arial;
            }
            html { height: 100% }
            body{ height: 100%; margin: 0px; padding: 0px;}
            #map_canvas { height: 80% }
            #shelf{position:fixed; top:10px; left:500px; height:100px;width:200px;background:white;opacity:0.7;}
            #draggable {position:absolute; top:10px; left:10px; width: 30px; height: 30px;z-index:1000000000;}
			.boxNav a{
				float: left;
				padding: 10px;
				background: #545454;
				color: #fff;
				text-decoration: none;
			}
			#info{
				clear: both;
				padding: 20px;
				text-align: right;
				background: #000;
			}
			#info a{
				color: #fff;
				text-decoration: none;
				text-transform: uppercase;
				padding-right: 20px;
				font-size: 13px;
			}
        </style>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        
    </head>
    <body onload="initialize()">
		<?php include('userNav.php'); ?>
        <div id="map_canvas"></div>
        <div id="info">
			<img src="fixture1.png"/><a href="" id="fixtureA">Solar Parking Lights</a>
			<img src="fixture2.png"/><a href="" id="fixtureB">Quad Usage Lights</a>
			<img src="fixture3.png"/><a href="" id="fixtureC">Surveillance Camera</a>
		<div>
		<script type="text/javascript">
            var $map;
            var $latlng;
            var overlay;
			var markerArray = new Array;
            function initialize() {
				var geocoder = new google.maps.Geocoder();
                $latlng = new google.maps.LatLng(-34.397, 150.644);
				geocoder.geocode({address:'<?php echo $property['address']; ?> <?php echo $property['city']; ?>, <?php echo $property['state']; ?>'}, function(results, status){ $latlng = results[0].geometry.location; setMap(); });
            };
			function setMap(){
				var myOptions = {
                    zoom: 19,
                    center: $latlng,
                    mapTypeId: google.maps.MapTypeId.SATELLITE,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                        position: google.maps.ControlPosition.TOP_LEFT },
                    zoomControl: true,
                    zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.LARGE,
                        position: google.maps.ControlPosition.LEFT_TOP
                    },
                    scaleControl: true,
                    scaleControlOptions: {
                        position: google.maps.ControlPosition.TOP_LEFT
                    },
                    streetViewControl: false,

                    panControl:false,

                };
				
				var id;
				var markers = {};
				var markersId = {};
				
                $map = new google.maps.Map(document.getElementById("map_canvas"),
                myOptions);
				
				function addInitMarkers(fixture_id, image, fixture_info, lat, lon){
					var newlatlng = new google.maps.LatLng(lat, lon);
					
					marker = new google.maps.Marker({ 
						position: newlatlng,
						map: $map,
						title: 'Fixture',
						draggable: true,
						animation: google.maps.Animation.DROP,
						icon: image,
						size: new google.maps.Size(25, 25),
					});
					$map.panTo($latlng);
					id = marker.__gm_id;
					markers[id] = marker;
					markersId[id] = fixture_id;

					var boxNav = '<a href="maintenance/'+id+'">Request Maintenance</a><a href="update/'+id+'">Update</a><a href="notes/'+id+'">Notes</a>';
					
					marker.info = new google.maps.InfoWindow({content:'Fixture id: '+ marker.__gm_id + '<br/>'+fixture_info+'<div class="boxNav">'+boxNav+'</div>'})
					google.maps.event.addListener(marker, "rightclick", function (point) { id = this.__gm_id; delMarker(id) });
					google.maps.event.addListener(marker, "click", function (point) { id = this.__gm_id; locationOnClick(id) });
					google.maps.event.addListener(marker, "dragend", function (point) { id = this.__gm_id; dragEnd(id) });
					
					$('.boxNav').click(function(){
						boxNav = '';
					});
				}
				
				<?php foreach($fixtures as $f){ ?>
				addInitMarkers(<?php echo $f['fixture_id'] ?>,'<?php echo $f['type'] ?>.png', 'Type: <?php echo $f['type']; ?><br/>Watts: <?php echo $f['watts']; ?><br/>', <?php echo $f['lat']; ?>, <?php echo $f['lon']; ?>)
				<?php } ?>
				
				function dragEnd(id){
					marker = markers[id];
					$.ajax({
						url: 'saveMarker.php',
						data: 'latlon=' + marker.position +'&icon='+marker.icon+'&id=<?php echo $_GET['id']; ?>&markerId='+markersId[id],
						type: 'POST',
						success: function(html){
							if(isNaN(html)){
								markersId[id] = html;
							}
						}
					})
				}
				
				var addMarker = function (image, fixture_info){
					marker = new google.maps.Marker({ 
						position: $latlng,
						map: $map,
						title: 'Fixture',
						draggable: true,
						animation: google.maps.Animation.DROP,
						icon: image,
						size: new google.maps.Size(25, 25),
					});
					$map.panTo($latlng);
					id = marker.__gm_id;
					markers[id] = marker; 

					var boxNav = '<a href="maintenance/'+id+'">Request Maintenance</a><a href="update/'+id+'">Update</a><a href="notes/'+id+'">Notes</a>';
					
					marker.info = new google.maps.InfoWindow({content:'Fixture id: '+ marker.__gm_id + '<br/>'+fixture_info+'<div class="boxNav">'+boxNav+'</div>'})
					google.maps.event.addListener(marker, "rightclick", function (point) { id = this.__gm_id; delMarker(id) });
					google.maps.event.addListener(marker, "click", function (point) { id = this.__gm_id; locationOnClick(id) });
					google.maps.event.addListener(marker, "dragend", function (point) { id = this.__gm_id; dragEnd(id) });
					
					$('.boxNav').click(function(){
						boxNav = '';
					});
				}

				var delMarker = function (id) {
					marker = markers[id];
					marker.setMap(null);
					$.ajax({
						url: 'deleteMarker.php',
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
			
				$('#fixtureA').click(function(){
					addMarker('fixture1.png', 'Type: Solar Parking Lights<br/>Watts: 400 Watts HPS<br/>');
					return false;
				})
				$('#fixtureB').click(function(){
					addMarker('fixture2.png', 'Type: Quad Usage Parking Lights<br/>Watts: 500 Watts HPS');
					return false;
				})
				$('#fixtureC').click(function(){
					addMarker('fixture3.png', 'Type: Survailence Camera<br/>Motion Sensors: Infared<br/>');
					return false;
				})
			}
        </script>
		<script>
			
		</script>
    </body>
</html>