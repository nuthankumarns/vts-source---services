<?php
include'set_session.php';
$user_id=$_SESSION['UID'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<link href='http://fonts.googleapis.com/css?family=Walter+Turncoat' rel='stylesheet' type='text/css'>
<link rel="icon" type="image/png" href="vw-beetle-icon.png">
<link rel="stylesheet" href="jquery.alerts.css"/>
<link rel="stylesheet" href="style.css"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<!--<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;
user-scalable=0;" />-->

    <title>Vehicle Tracking System</title>

 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script language="JavaScript">
javascript:window.history.forward(1);
</script>

	<!--<script src="http://www.tritonetech.com/php_uploads/rnd/BDCCPolygon2.js" type="text/javascript"></script>-->



  <script src="http://code.jquery.com/jquery-latest.js"></script>
 <script src="jquery.alerts.js"></script>
<link rel="stylesheet" media="screen" href="todolist.css" />

	<script type="text/javascript" src="jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></script>


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

<!--<style type="text/css">
    
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

   </style>-->
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
//console.log(id);
</script>
<link href='http://fonts.googleapis.com/css?family=Walter+Turncoat' rel='stylesheet' type='text/css'>

  </head>
<!--<body onload="window.scrollTo(0, 1);">-->

  <body>
	<div id='console' style="width: 18%; height: 715px;">
		<!-- <h1 class="simple" style= "font-family: 'Walter Turncoat', cursive; font-weight: bold; text-align: center; font-size: 18px;">Console</h1> -->
		<div class='navbox'>
			<ul class='nav'>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_location.php'">Home</a></li>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_history.php?id='+<?php echo $_REQUEST['id'];?>">History</a></li>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_fencing.php?id='+<?php echo $_REQUEST['id'];?>">Geo Fencing</a></li>
				<li><a href="javascript:void(0)" onclick="#" style="background: url('images/inside_ui/image_0005_Layer-4-copy-6.png') no-repeat">Live Monitor</a></li>
				
				<li><a href="javascript:void(0)" onclick="location.href='log_out.php'">Logout</a></li>
				
			</ul>
		</div>
					
					
					<br/>
					<div id='datetime' style="float:left; margin-left: 5px; clear: both;">
					
					<!--<br/>
					<fieldset><legend>current location</legend><div id='text'>loading...</div></fieldset>
					<br/>-->
					<!--<fieldset><legend>Vehicle Details</legend>-->
					<div id='speed' style="clear: both;">loading...</div>
					<!--<div id='activity'></div></fieldset>-->
				
					</div>
		
				
		
	</div>
 
<div id="map" style="width: 80%; height: 725px;"><center><img style="position:absolute;top:50%;left:50%;" src="./images/loader.gif"/></center></div>


<!--<script type="text/javascript">

if (GBrowserIsCompatible()) {



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

			map.clearOverlays();

			//alert(point);
			if(isNaN(point) || typeof(point)=="undefined")
			{
			point=18;
			map.setCenter(new GLatLng(latitude,longitude),point);

			}	
			else
			{

			point=checkResize(point);
			map.setCenter(new GLatLng(latitude,longitude),point);

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

markerOptions = { icon:carIcon };
		
		  marker = new GMarker(new GLatLng(latitude,longitude),markerOptions);

	 marker_arry = new Array(marker);
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


</script>-->
<script type="text/javascript">
$(document).ready(function() {	
// var init = function() {
	
	 $.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
	//console.log(json);
               $.each(json.result,function(i,gmap){
		latitude=gmap.latitude;
		
			longitude=gmap.longitude;
		var distance1=gmap.range;//console.log(distance1);//calculated distance
		var distance2=gmap.ranged;//console.log(distance2);//preset range by fleet manager

				
		$("#speed").html('<b>Address:</b>&nbsp;'+gmap.Location+'&nbsp;<hr><b>Speed:</b>&nbsp;'+gmap.velocity+'&nbsp;kmph<br><b>Vehicle Name:</b>'+gmap.alias+'<br><b>last update:</b>&nbsp;'+gmap.Server_IST+'<br>');
			
		if(distance1>distance2 && gmap.geo_status=='1')
		{
		
			
			$("#speed").append('<b>Vehicle Status:</b>Outbound');
			
		//alert("vehicle out of location");
		}
		else if(distance1<distance2 && gmap.geo_status=='1')
		{
		$("#speed").append('<b>Vehicle Status:</b>Inbound');
		}
		else
		{
		$("#speed").append('<b>Vehicle Status:</b>Not Set');
		} 
		//alert(gmap.geo_status);
		//alert(latitude);
		//alert(longitude);
	var image = 'vw-beetle-icon.png'
      var latlng= new google.maps.LatLng(latitude, longitude)
	//console.log(latlng);
            var opts = {
                zoom: 16,
                center:latlng , // London
                mapTypeId: google.maps.MapTypeId.ROADMAP,

            };
            var map = new google.maps.Map(document.getElementById('map'), opts);
		var Marker = new google.maps.Marker({
      		position: latlng,
	      map: map,
	      icon: image
  });
		//opts.setMap(map);
});
});
var geocoder;
/************************/
	/*	clearOverlays();

		function clearOverlays() {
    if (marker) {
      for (i in marker) {
        marker[i].setMap(null);
      }
    }
  }*/
/***************************/
		//GEOCODER

		  geocoder = new google.maps.Geocoder();
	setInterval(function() {	  
		$.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
			//map.clearOverlays();
			
			//console.log(json);
              		$.each(json.result,function(i,gmap){
			
			latitude=gmap.latitude;
			longitude=gmap.longitude;
		//	alert(latitude);
			var distance1=gmap.range;//console.log(distance1);//calculated distance
		var distance2=gmap.ranged;//console.log(distance2);//preset range by fleet manager

				
		$("#speed").html('<b>Address:</b>&nbsp;'+gmap.Location+'&nbsp;<hr><b>Speed:</b>&nbsp;'+gmap.velocity+'&nbsp;kmph<br><b>Vehicle Name:</b>'+gmap.alias+'<br><b>last update:</b>&nbsp;'+gmap.Server_IST+'<br>');
			
		if(distance1>distance2 && gmap.geo_status=='1')
		{
		
			
			$("#speed").append('<b>Vehicle Status:</b>Outbound');
			
		//alert("vehicle out of location");
		}
		else if(distance1<distance2 && gmap.geo_status=='1')
		{
		$("#speed").append('<b>Vehicle Status:</b>Inbound');
		}
		else
		{
		$("#speed").append('<b>Vehicle Status:</b>Not Set');
		}    
			var image = 'vw-beetle-icon.png';
			var latlng= new google.maps.LatLng(latitude, longitude);
			//console.log(map.hasOwnProperty('getZoom'));
		//console.log(marker.getZoom());
		
		  	marker = new google.maps.Marker({
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center:latlng,
		    	//position: latlng,
			zoom: 16,
		    	//draggable: true,
			icon:image,
			
		  	});
		
		

			var map = new google.maps.Map(document.getElementById('map'), marker);
/*code of 2012*/
//console.log(map.getZoom());
    google.maps.event.addListener(map, 'zoom_changed', function() {
        setTimeout(centrify, 1500);
    });
function centrify() {
  var loc = latlng;
  map.setCenter(loc);
	var userzoom=map.getZoom();
	map.setZoom(userzoom);
		
	//console.log(map.getZoom());
	//map.setZoom(15);
	
}
/*code of 2012*/

		var Marker = new google.maps.Marker({
      		position: latlng,
		
	    map: map,
	      icon: image,
		
  });

	//console.log(json);
		/*var Marker = new google.maps.Marker({
      		position: latlng,
	      map: map,
	      icon: image
  });*/
			//var map = new google.maps.Map(document.getElementById('map'), marker);
			//marker.setMap(null);
			//marker.setMap(marker);
			//marker.setMap(map);
	
		//$(document).ready(function(){
 			/*$("#speed").html('<p><b>Speed:</b>&nbsp;'+gmap.velocity+'&nbsp;kmph</p>');
			
			$("#activity").html('<p><b>Vehicle Name:</b>'+gmap.alias+'</p><p><b>last update:</b>&nbsp;'+gmap.Server_IST+'</p>');
			 $("#text").html('<p>'+gmap.Location+'</p>');*/
				 });
		//map.clearOverlays();
		//});
 

		// map.clearOverlays();
	});

	

//map.clearOverlays();
 }, 5000);



            

            

		
	


});
    //    }

    </script>
  </body>
</html>

