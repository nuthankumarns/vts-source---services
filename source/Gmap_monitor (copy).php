<?php
include'set_session.php';
$user_id=$_SESSION['UID'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<link rel="icon" type="image/png" href="vw-beetle-icon.png">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<!--<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;
user-scalable=0;" />-->

    <title>Vehicle Tracking System</title>
 <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAEfq-J88L6W8QaeK-_jrMEBSmtvUnVE3cIil7-e0uzArV_1Eo-BQ-ci8NjtfYjDp41KfVVkgHllPC8Q" type="text/javascript"></script>
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>

	<!--<script src="http://www.tritonetech.com/php_uploads/rnd/BDCCPolygon2.js" type="text/javascript"></script>-->
	<script src="http://www.bdcc.co.uk/Gmaps/BDCCPolyline.js" type="text/javascript"></script>
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="jquery-1.5.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://api.wipmania.com/wip.js"></script>
<link rel="stylesheet" media="screen" href="todolist.css" />

   <script type="text/javascript" src="jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="js/jquery.js" type="text/javascript"></script> 
<script src="js/jquery-fdd2div.js" type="text/javascript"></script> 
 
<script type='text/javascript'>
jQuery(function($) {
      //  $.getJSON('json.php', function(json) {
	  $.getJSON('get_vehicle.php?user_id=<?php echo $user_id;?>', function(json) {
                var select = $('#vehicle-list');
 		
                $.each(json.Result.Data, function(i, v) {
			
						
			var option = $('<option />');
			

                        option.attr('value', v.uid)
                              .html(v.alias)
                              .appendTo(select);
			
                });
        });
});
</script>

 <!--<script language="javascript">
		$('#form_wrapper').ready(function() {
		$("#vehicle-list").fdd2div();
		});
		</script>-->
<style type="text/css">
     <!--html { height: 100% }-->
     body { height: 100%; margin: 0px; padding: 0px ;}
     #map { height: 100%;width:80%;float:right; }
	#console {width:20%;float:left;
    -moz-box-shadow: 1px 4px 4px rgba(0, 0, 0, 0.5);
}

fieldset { border:4px solid #333333; }
legend {
  padding: 0.2em 0.5em;
  border:1px solid green;
  color:green;
  font-size:90%;
  text-align:right;
  }
.navbox {
 position: relative;
 float: left;
}

ul.nav {
 list-style: none;
 display: block;
 width: 200px;
 position: relative;
 top: -40px;
 left: 10px;
 padding: 20px 0 20px 0;
 background: url(images/shad2.png) no-repeat;
 -webkit-background-size: 50% 100%;
}

li {
 margin: 5px 0 0 0;
}

ul.nav li a {
 -webkit-transition: all 0.3s ease-out;
 background: #cbcbcb url(images/border.png) no-repeat;
 color: #174867;
 padding: 7px 15px 7px 15px;
 -webkit-border-top-right-radius: 10px;
 -webkit-border-bottom-right-radius: 10px;
 width: px;
 display: block;
 text-decoration: none;
 -webkit-box-shadow: 2px 2px 4px #888;
}

ul.nav li a:hover {
 background: #ebebeb url(border.png) no-repeat;
 color: #67a5cd;
 padding: 7px 15px 7px 30px;
} 

   </style>
<script type='text/javascript'>function get_request( name )
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null )
    return "";
  else
    return results[1];
}

var id=get_request('id');
console.log(id);
</script>


  </head>
<!--<body onload="window.scrollTo(0, 1);">-->

  <body onunload="GUnload();">
	<div id='console'>
		<h1 class="simple">Console</h1>
		<div class='navbox'>
			<ul class='nav'>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_location.php'">Home</a></li>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_history.php?id='+id">History</a></li>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_fencing.php?id='+id">Geo Fencing</a></li>
				<li><a href="javascript:void(0)" onclick="#">Live Monitor</a></li>
				
				<li><a href="javascript:void(0)" onclick="location.href='index.php?msg=3'">logout</a></li>
				
			</ul>
		</div>
					
					
					<br/>
					<div id='datetime' style="float:left;">
					
					<br/>
					<fieldset><legend>current location</legend><div id='text'>loading...</div></fieldset>
					<br/>
					<fieldset><legend>Vehicle Details</legend><div id='speed'>loading...</div><div id='activity'></div></fieldset>
				
					</div>
		
				
		
	</div>
 
<div id="map"><center><img style="position:absolute;top:50%;left:50%;" src="./images/loader.gif"/></center></div>


<script type="text/javascript">

if (GBrowserIsCompatible()) {


   /*  var boy = new GIcon();
         boy.image="user.png"
         boy.iconSize=new GSize(32,18);
         boy.iconAnchor=new GPoint(16,9);

   var car = new GIcon();
         car.image="caricon.png"
         car.iconSize=new GSize(32,18);
         car.iconAnchor=new GPoint(16,9);*/
/*var car=new GIcon();
car.image = 'vw-beetle-icon.png';
car.iconSize=new GSize(32,18);
car.iconAnchor=new Gpoint(16,9);*/


      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());

	var point;



setInterval(function() {


            $.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
			//console.log(json);
               $.each(json.result,function(i,gmap){
			
		latitude=gmap.latitude;
			longitude=gmap.longitude;
			vel=gmap.velocity;
			last_update=gmap.Server_IST;
			//alert(last_update);
			//  alert(latitude);
			map.clearOverlays();

			/*		google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
				  infowindow.setContent(json.Result.Data[i].alias);
					console.log(json.Result.Data[i]);
				  infowindow.open(map, marker);
				}
			      })(marker, i));*/
			//alert(point);
			if(isNaN(point) || typeof(point)=="undefined")
			{
			point=18;
			map.setCenter(new GLatLng(latitude,longitude),point);
			//alert(point);
			}	
			else
			{

			point=checkResize(point);
			map.setCenter(new GLatLng(latitude,longitude),point);
			//marker = new GMarker(latitude,longitude);
			//alert(point);
			}

			latlng=latitude+','+longitude;

			  geocoder = new GClientGeocoder();
			geocoder.getLocations(latlng, showAddress)

			$(document).ready(function(){
 			$("#speed").html('<p>Speed@&nbsp;'+vel+'&nbsp;kmph</p>');
			$("#activity").html('<p>last update@&nbsp;'+last_update+'</p>');
				 }); 


		if(gmap.geo_status==1 && gmap.read_status==2 && gmap.out_range>gmap.range)
			{
			var overshot=gmap.out_range-gmap.range;
			alert('vehicle out of geo fence:'+overshot+'metres'); 

			}

	var carIcon = new GIcon(G_DEFAULT_ICON);
carIcon.image = "vw-beetle-icon.png";
                
// Set up our GMarkerOptions object
markerOptions = { icon:carIcon };
		
		  marker = new GMarker(new GLatLng(latitude,longitude),markerOptions);
			

		var contentString = '<div id="content">'+
		    '<div id="siteNotice">'+
		    '</div>'+
		    '<h2 id="firstHeading" class="firstHeading">Uluru</h2>'+
		    '<div id="bodyContent">'+
		    '<p>Attribution: Uluru, <a href="http://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
		    'http://en.wikipedia.org/w/index.php?title=Uluru</a> (last visited June 22, 2009).</p>'+
		    '</div>'+
		    '</div>';

		var infowindow = new google.maps.InfoWindow({
		    content: contentString
		
		});
//console.log(content);
		/*var marker = new google.maps.Marker({
		    position: myLatlng,
		    map: map,
		    title:"Uluru (Ayers Rock)"
		});*/

		
 			/*GEvent.addListener(marker, 'click', function() {
			  // When clicked, open an Info Window
			//alert(gmap.alias);
			//infowindow.open(map, marker);
			  marker.openInfoWindowHtml(content);
			});*/

	
		
		google.maps.event.addListener(marker, 'click', function() {
		  infowindow.open(map,marker);
		});

         
    
     // marker1 = new GMarker(new GLatLng(latitude,longitude),{icon:boy});
     // marker2 = new GMarker(new GLatLng(latitude,longitude),{icon:car});


     //marker_arry = new Array(marker,marker1,marker2);
	 marker_arry = new Array(marker);
/*	var carIcon = new GIcon(G_DEFAULT_ICON);
carIcon.image = "vw-beetle-icon.png";
                
// Set up our GMarkerOptions object
mgrOptions = { icon:carIcon };*/

      var mgrOptions = {maxZoom: 10, trackMarkers: true };
      var mgr = new MarkerManager(map, mgrOptions);
//		icon:image
      mgr.addMarkers(marker_arry, 6);
      mgr.refresh();

      stepnum = 0;
      pause_stepnum = 0;
      speed = 1500;

 });
  });

        }, 5000);


		function checkResize(point) {
		    //  var point = map.getCenter();
			var point= map.getZoom();
			return point;

		    }

	


	function showAddress(response) {

	  if (!response || response.Status.code != 200) {

	  } else {
	    place = response.Placemark[0];

	$(document).ready(function(){
	 

	$("#text").html('<p>'+place.address+'</p>');

	 }); 

	  }
	}



}
   else
   {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }


</script>
  </body>
</html>

