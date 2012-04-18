<?php
include'set_session.php';
$user_id=$_SESSION['UID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<link rel="stylesheet" media="screen" href="todolist.css" />
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
<style>

        ul.nav li a {
    background: url("images/border.png") no-repeat scroll 0 0 #CBCBCB;
    color: #174867;
    display: block;
    padding: 7px 15px;
    text-decoration: none;
}
        /* Mine */
        body { font-family: Helvetica, Arial, sans-serif; font-size: 16px; }
        div#map { position: absolute; top: 0; right: 0; width: 80%; height: 100%; }
        form#options { position: absolute; bottom: 5px; left: 100px; background: #fff; border: 1px solid #666; padding: 3px 5px; }
        form#options em { margin: 0 10px; color: #666; }
#console{width:20%;}
.navbox {
 position: relative;
 float: left;
}
fieldset { border:4px solid #333333; }
legend {
  padding: 0.2em 0.5em;
  border:1px solid green;
  color:green;
  font-size:90%;
  text-align:right;
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
  <link rel="icon" type="image/png" href="vw-beetle-icon.png">
    <title>Vehicle Tracking System</title>
    <meta name="description" content="Google Map allowing a radius to be added">
    <meta name="author" content="Oliver Beattie">
   <!-- <meta name="viewport" content="width=device-width, user-scalable=no" />-->
    
       <!-- <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAA7zatdDuuNbbeMyULD2yG5RQX2gm04R9FDFXzSd74lb-TAfkBGRRwjhMX1Kvf0hb7vtBJUUfnnFT-6g" type="text/javascript"></script>-->
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAEfq-J88L6W8QaeK-_jrMEBSmtvUnVE3cIil7-e0uzArV_1Eo-BQ-ci8NjtfYjDp41KfVVkgHllPC8Q" type="text/javascript"></script>
<!--<script src="http://maps.google.com/maps?file=api&v=3&sensor=true" type="text/javascript"></script>-->
<script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript">
jQuery(function($) {
	  $.getJSON('web_services/latlong.php?option=4&user_id=<?php echo $user_id;?>', function(json) {
                var select = $('#vehicle');
 		
                $.each(json.Result.Data, function(i, v) {
			var option = $('<option />');
			

                        option.attr('value', v.device_id)
                              .html(v.alias)
                              .appendTo(select);
			
                });
        });
});
</script>
<script type="text/javascript" src="jquery-1.5.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type='text/javascript'>
function get_request( name )
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

var imei=get_request('imei');

</script>

    <script type="text/javascript">

if (GBrowserIsCompatible()) {


  var map1;  
     // var map = new GMap2(document.getElementById("map"));
    //  map.addControl(new GLargeMapControl());
     // map.addControl(new GMapTypeControl());
		var lat=new Array();var lng=new Array();var latlng = [];
		var map;
		var arrMarkers = [];
		var arrInfoWindows = [];
/* other code */


	

	 $.getJSON('web_services/latlong.php?option=4&user_id=<?php echo $user_id;?>', function(json) {
               $.each(json.Result.Data,function(i,gmap){
	
		lat[i]=gmap.latitude;
		lng[i]=	gmap.longitude;
		latlng[i] = new google.maps.LatLng(lat[i], lng[i]);
			


/*	google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
				  infowindow.setContent('nuthan');
					console.log(json.Result.Data[i]);
				  infowindow.open(map, marker);
				}
			      })(marker, i)); */

	
		if ( google.maps.BrowserIsCompatible( ) )    
		{      
		map1 = new google.maps.Map2( document.getElementById( 'map' ) );      
		map1.addControl( new google.maps.LargeMapControl3D( ) );      
		map1.addControl( new google.maps.MenuMapTypeControl( ) );      
		map1.setCenter( new google.maps.LatLng( 0, 0 ), 0 );
		

			for ( var i = 0; i < latlng.length; i++ )      
			{        
			var marker = new google.maps.Marker( latlng[ i ]);		
			map1.addOverlay( marker );  
   		
			}      

			var latlngbounds = new google.maps.LatLngBounds( );    
				 
			for ( var i = 0; i < latlng.length; i++ )      
			{        
			latlngbounds.extend( latlng[ i ] );    
		
			}      
			map1.setCenter( latlngbounds.getCenter( ), map1.getBoundsZoomLevel( latlngbounds ) );
			  
			//for (var i = 0; i < latlng.length; i++) {
			
			
			
			//}
		
				
		
			/*GEvent.addListener(marker, 'click', function() {
			  // When clicked, open an Info Window with a min map in it
			  marker.showMapBlowup();
			});*/
			    /*  google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
				  infowindow.setContent(json.Result.Data[i].alias);
					alert(json.Result.Data[i]);
				  infowindow.open(map, marker);
				}
			      })(marker, i));*/
		 }
			   

		});

	}, function(data){
$.each(data.Result.Data, function(i, item){
console.log(data);
$("#markers").append('<li><a href="#" rel="' + i + '">' + item.alias + '</a></li>');
var marker = new google.maps.Marker({
position: new google.maps.LatLng(item.latitude, item.longitude),
map: map,
title: item.alias
});
arrMarkers[i] = marker;
var infowindow = new google.maps.InfoWindow({
content: "<h3>"+ item.alias +"</h3>"
});
arrInfoWindows[i] = infowindow;
google.maps.event.addListener(marker, 'click', function() {
infowindow.open(map, marker);
});
});
}); 

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
/*var contentString = "nuthan";

			var infowindow = new google.maps.InfoWindow({
			content: contentString
			});

			google.maps.event.addListener(marker, 'click', function() {
			infowindow.setContent(this.html);
			infowindow.open(map,this);
			});*/
		
	
	/*	var point;
		var lat=new Array();var lng=new Array();var latlng = [];
			
			
		setInterval(function() {
			 



	 $.getJSON('web_services/latlong.php?option=4&user_id=<?php echo $user_id;?>', function(json) {
               $.each(json.Result.Data,function(i,gmap){
	
		lat[i]=gmap.latitude;
		lng[i]=	gmap.longitude;
		latlng[i] = new google.maps.LatLng(lat[i], lng[i]);*/
		
	/*google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
				  infowindow.setContent(json.Result.Data[i].alias);
					console.log(json.Result.Data[i]);
				  infowindow.open(map, marker);
				}
			      })(marker, i)); */
		
	/*
		if ( google.maps.BrowserIsCompatible( ) )    
		{      
		map1 = new google.maps.Map2( document.getElementById( 'map' ) );      
		map1.addControl( new google.maps.LargeMapControl3D( ) );      
		map1.addControl( new google.maps.MenuMapTypeControl( ) );      
		map1.setCenter( new google.maps.LatLng( 0, 0 ), 0 );      
			for ( var i = 0; i < latlng.length; i++ )      
			{        
			var marker = new google.maps.Marker( latlng[ i ] ); 
			
			map1.addOverlay( marker );  
		  	var contentString = "nuthan";

			var infowindow = new google.maps.InfoWindow({
			content: contentString
			});

			google.maps.event.addListener(marker, 'click', function() {
			infowindow.setContent(this.html);
			infowindow.open(map,this);
			});

			
			}      

			var latlngbounds = new google.maps.LatLngBounds( );    
				 
			for ( var i = 0; i < latlng.length; i++ )      
			{        
			latlngbounds.extend( latlng[ i ] );    
			  
			}      
			map1.setCenter( latlngbounds.getCenter( ), map1.getBoundsZoomLevel( latlngbounds ) );*/
			
			/*var infowindow = null;
			infowindow = new google.maps.InfoWindow({
			content: "holding..."
			});
			  //for (var i = 0; i < latlng.length; i++) {
			var marker = latlng[i];
			google.maps.event.addListener(marker, 'click', function () {
			// where I have added .html to the marker object.
			infowindow.setContent(this.html);
			infowindow.open(map, this);
			});
			}*/
			/*GEvent.addListener(marker, 'click', function() {
			  // When clicked, open an Info Window with a min map in it
			  marker.showMapBlowup();
			});*/
			    /*  google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
				  infowindow.setContent(json.Result.Data[i].alias);
					alert(json.Result.Data[i]);
				  infowindow.open(map, marker);
				}
			      })(marker, i));*/
	/*	 }
	
		});

	}); 

 
	 }, 5000);*/

}
   else
   {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }

			/*GEvent.addListener(marker, 'click', function() {
				  // When clicked, open an Info Window
				//alert(gmap.alias);
				  marker.openInfoWindowHtml('nuthan');
				}); */
	 
//}  

	//google.setOnLoadCallback( map1_initialize );
</script>
    <!--<script type="text/javascript">
 var init = function() {
	
	 $.getJSON('web_services/latlong.php?option=4', function(json) {
	alert(json.result.length);
/*---------------------------------------*/
	$.each(json.result,function(i,gmap){
			latitude=gmap.latitude;
			longitude=gmap.longitude;
var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: new google.maps.LatLng(latitude,longitude),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
	
	// map: an instance of GMap2
// latlng: an array of instances of GLatLng
var latlngbounds = new GLatLngBounds( );
for ( var i = 0; i < latlng.length; i++ )
{
  latlngbounds.extend( latlng[ i ] );
}
map.setCenter( latlngbounds.getCenter( ), map.getBoundsZoomLevel( latlngbounds ) );

   // var infowindow = new google.maps.InfoWindow();

   /* var marker, i;

    for (i = 0; i < json.result.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(json.result[i].latitude, json.result[i].longitude),
        map: map
      });*/

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(json.result[i].alias);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
});
});


        }
/******************************************/
/*		for (j = 0; j < json.result.length; j++) {  
	//alert('nuthan');
	
	alert(j);
alert(json.result[j].latitude);
	
           
//     $.each(json.result[j],function(i,gmap){
	
	//	alert(gmap.latitude[j]);
	//alert(gmap.latitude);
	//alert(gmap.latitude[1]);
		
				//var marker, i;
			//alert(json);
		//alert(result.length);
	//alert(json.result.latitude[0][0]);
		     
	//	alert(json.result.latitude[j][0]);
	//	alert(latitude);
     /* marker = new google.maps.Marker({
       // position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));*/
   


		//alert(json);
	/*	latitude=json.result[j].latitude;
			longitude=json.result[j].longitude;
		//alert(i);
		alert(latitude);
		alert(longitude);
      var latlng= new google.maps.LatLng(latitude, longitude)
            var opts = {
                zoom: 16,
                center:latlng , // London
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById('map'), opts);
var geocoder;
		//GEOCODER
		  geocoder = new google.maps.Geocoder();
/*	setInterval(function() {	
			  
		$.getJSON('http://www.tritonetech.com/php_uploads/rnd/latlong.php?option=2, function(json) {
			for (var i = 0; i < markers.length; i++) {
				var marker = markers[i];
				google.maps.event.addListener(marker, 'click', function () {
				// where I have added .html to the marker object.
				infowindow.setContent(this.html);
				infowindow.open(map, this);
				});
}
              		$.each(json.result,function(i,gmap){
			latitude=gmap.latitude;
			longitude=gmap.longitude;
			
			var latlngdyn= new google.maps.LatLng(latitude, longitude) 
		  	marker = new google.maps.Marker({
		    	position: latlngdyn,
		    	draggable: true
		  	});
			marker.setMap(map); 
			if(gmap.geo_status==1 && gmap.read_status==2 && gmap.out_range>gmap.range)
			{
			var overshot=gmap.out_range-gmap.range;
			alert('vehicle out of geo fence:'+overshot+'metres'); 

			}
			
		
		});
		// map.clearOverlays();
	});
 }, 5000);*/
 //map.addOverlay(marker);
/*var marker = new GMarker(map.getCenter(), markerOptions);
 map.addOverlay(marker);*/
/*point = new GLatLng(latitude,longitude);
   marker = new GMarker(point);
    map.addOverlay(marker);
marker = new GMarker(new GLatLng(latitude,longitude));*/
		// map.setCenter(point, 10);
		//var marker = new GMarker(point);
		//map.addOverlay(marker);
    // google.maps.event.addListener(map, 'click',  polygonDrawHandler);
		//http://www.tritonetech.com/php_uploads/rnd/location.php?option=3&geo_status=0&lat_ref=e.latLng.lat()&long_ref=e.latLng.lng()&uid=uid&range=radius
//	});
//}


    </script>-->

</head>

<!--<body onload="map1_initialize( )">-->
<body onunload="GUnload();">
	<div id='console'>
		<h1 class="simple">Console</h1>
		<div class='navbox'>
			<ul class='nav'>
				<li><a href="javascript:void(0)" onclick="#">Home</a></li>
				<li><a href="javascript:void(0)" onclick="var val= document.frm.vehicle.value; if(val=='this.value')
					{alert('please select vehicle');exit;}location.href='Gmap_history.php?id='+val">History</a></li>
				<li><a href="javascript:void(0)" onclick="var val= document.frm.vehicle.value; if(val=='this.value')
					{alert('please select vehicle');exit;}location.href='Gmap_monitor.php?id='+val">Live Monitor</a></li>
				<li><a href="javascript:void(0)" onclick="var val= document.frm.vehicle.value; if(val=='this.value')
					{alert('please select vehicle');exit;}location.href='Gmap_fencing.php?id='+val">Geo Fencing</a></li>
				<li><a href="javascript:void(0)" onclick="location.href='registration/form.php'">Add Device</a></li>

				<li><a href="javascript:void(0)" onclick="location.href='index.php?msg=3'">logout</a></li>
			</ul>
		</div>
					<fieldset><legend>select vehicle:</legend>
					<div id='form_wrapper'>
						<form method="get" name="frm">
							<select name="id" id="vehicle">
                						<option value="this.value">Select your vehicle</option>
           					 	</select>
							<!--<input type="submit" value="GO"/>-->
						</form>
					</div>	
					</fieldset>
					

				
		
	</div>
   <div id="map"><center><img style="position:absolute;top:50%;left:50%;" src="./images/loader.gif"/></center></div>
   
       
		
	
	
	<!--location.href="Gmap_location.php?uid="+uid;-->
        
   
	 </form>
	<!--<button type="submit" onclick="location.href='http://www.tritonetech.com/php_uploads/rnd/Gmap_location.php?uid='+uid">
   	 home
		</button>-->
</body>
</html>
