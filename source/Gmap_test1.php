<?php
include'set_session.php';
$user_id=$_SESSION['UID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>jQuery + Google Maps API v3 Demo</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAEfq-J88L6W8QaeK-_jrMEBSmtvUnVE3cIil7-e0uzArV_1Eo-BQ-ci8NjtfYjDp41KfVVkgHllPC8Q" type="text/javascript"></script>

<script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
if (GBrowserIsCompatible()) {
var map;
var arrMarkers = [];
var arrInfoWindows = [];
	var infowindow = null;

function mapInit(){
/*var centerCoord = new google.maps.LatLng(13.040391666667, 77.557393333333); // Puerto Rico
var mapOptions = {
zoom: 9,
center: centerCoord,
mapTypeId: google.maps.MapTypeId.TERRAIN
};*/
  var map1;  

		var lat=new Array();var lng=new Array();var latlng = [];
		var map;
		var arrMarkers = [];
		var arrInfoWindows = []
 $.getJSON('web_services/latlong.php?option=4&user_id=<?php echo $user_id;?>', function(json) {
               $.each(json.Result.Data,function(i,gmap){
	
		lat[i]=gmap.latitude;
		lng[i]=	gmap.longitude;
		latlng[i] = new google.maps.LatLng(lat[i], lng[i]);    
		map1 = new google.maps.Map2( document.getElementById( 'map' ) );      
		map1.addControl( new google.maps.LargeMapControl3D( ) );      
		map1.addControl( new google.maps.MenuMapTypeControl( ) );      
		map1.setCenter( new google.maps.LatLng( 0, 0 ), 0 );
		//console.log(latlng[i]);
		//console.log(map1.getCenter());
		
			for ( var i = 0; i < latlng.length; i++ )      
			{        
			var marker = new google.maps.Marker( latlng[ i ]);
			 //var infoWindow = new google.maps.InfoWindow();
			 var markerBounds = new google.maps.LatLngBounds();
			 var markerArray = [];

			 function makeMarker(options){
			   var pushPin = new google.maps.Marker({map:map});
			   pushPin.setOptions(options);
			   google.maps.event.addListener(pushPin, 'click', function(){
			     infoWindow.setOptions(options);
			     infoWindow.open(map1, pushPin);
			   });
			   markerArray.push(pushPin);
			   return pushPin;
			 }

			 google.maps.event.addListener(map1, 'click', function(){
			   infoWindow.close();
			 });

			 function openMarker(i){
			   google.maps.event.trigger(markerArray[i],'click');
			 };

			 /**
			 *markers
			 */
			 makeMarker({
			   position: new google.maps.LatLng(39.943962, 3.891220),
			   title: 'Title',
			   content: '<div><h1>Lorem ipsum</h1>Lorem ipsum dolor sit amet<div>'
			 });

			showMarker(0);
			//var infowindow = new google.maps.InfoWindow({content: 'nuthan'});
			//console.log(infowindow);
			//var marker = new google.maps.Marker({position: new google.maps.LatLng(latlng[i]), map: map, draggable: true}); 
			/*console.log(marker);
			var infowindow = new google.maps.InfoWindow({content: "nuthan"});
			console.log(infowindow); 
			google.maps.event.addListener(marker, 'click', infoCallback(infowindow, marker)); */
			map1.addOverlay( marker );  
   			/*	google.maps.event.addListener(map, 'click', function() {
				infowindow.open(map1, marker);
				});
			var infowindow = new google.maps.InfoWindow({
				content: "<h3>"+ gmap.alias +"</h3>"
				});
				arrInfoWindows[i] = infowindow;*/
			}   

		
	/*	for (var i = 0; i < latlng.length; i++) 
			{  
			var marker = new google.maps.Marker({position: new google.maps.LatLng(latlng[i]), map: map, draggable: true}); 
			var infowindow = new google.maps.InfoWindow({content: "nuthan"}); 
			google.maps.event.addListener(marker, 'click', infoCallback(infowindow, marker)); 
			}*/

			/* now inside your initialise function */
			

			
				
				//arrMarkers[i] = marker;
				/*var infowindow = new google.maps.InfoWindow({
				content: "<h3>"+ gmap.alias +"</h3>"
				});
				arrInfoWindows[i] = infowindow;*/
				function infoCallback(infowindow, marker) 
		{ return function() 
			{ 
			infowindow.open(map, marker); 
			}; 
		} 

			   

			var latlngbounds = new google.maps.LatLngBounds( );    
				 
			for ( var i = 0; i < latlng.length; i++ )      
			{        
			latlngbounds.extend( latlng[ i ] );    
				
			}      
		map1.setCenter( latlngbounds.getCenter( ), map1.getBoundsZoomLevel( latlngbounds ) );
		
		
		});

	});
/*var mapOptions = {
zoom: 9,
center: centerCoord,
mapTypeId: google.maps.MapTypeId.TERRAIN
};
map = new google.maps.Map(document.getElementById("map"),mapOptions);
$.getJSON("web_services/latlong.php?option=4&user_id=<?php echo $user_id;?>", {}, );*/
}

//function mapInit(){

//map = new google.maps.Map(document.getElementById("map"));
//$.getJSON("web_services/latlong.php?option=4&user_id=<?php echo $user_id;?>", {}, );

//}
$(function(){
// initialize map (create markers, infowindows and list)
mapInit();
// "live" bind click event
$("#markers a").live("click", function(){
var i = $(this).attr("rel");
// this next line closes all open infowindows before opening the selected one
//for(x=0; x < arrInfoWindows.length; x++){ arrInfoWindows[x].close(); }
arrInfoWindows[i].open(map, arrMarkers[i]);
});
});
}
   else
   {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }
</script>
<style type="text/css" media="screen">
img { border: 0; }
#map{
width: 800px;
height: 500px;
}
#content {
position: fixed;
top: 10px;
left: 800px;
margin: 30px;
}
</style>
</head>
<body>
<div id="container">
<div id="header"><a href="../"><img src="header.gif" alt="we are all robots header image" width="600" height="45"/></a></div>
<div id="map"></div>
<div id="content">
<p>this demo uses the newest version of the <a href="http://code.google.com/apis/maps/documentation/v3/">Google Maps API</a> and some jQuery to easily and dynamically create an interactive map of various points of interest (in this case of my country, Puerto Rico). it uses a simple <a href="http://en.wikipedia.org/wiki/Json">JSON</a> file as it's <a href="map.json">data source</a>. when it's finished loading, click an item on the list or a marker on the map to see more info about each location.</p>
<ul id="markers"></ul>
</div>
</div>

</body>
</html> 
