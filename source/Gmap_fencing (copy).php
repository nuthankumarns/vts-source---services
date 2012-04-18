<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
    
  <link rel="icon" type="image/png" href="vw-beetle-icon.png">
	<title>Vehicle Tracking System</title>
   <!-- <meta name="viewport" content="width=device-width, user-scalable=no" />-->
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
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
var id=get_request('id');


function show_confirm()
{

var r=confirm("Set Geo-fencing...?");
if (r==true)
  {
  alert("Geo fencing set");
  }
else
  {
	
  alert("Cancel!");

  }
}
</script>
    <style type="text/css">


        ul.nav li a {
   
    display: block;
    padding: 7px 15px;
    text-decoration: none;
}
        /* Mine */
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; }
        div#map { position: absolute; top: 0; right: 0; width: 80%; height: 100%; }
	/* #map { height: 100%;width:80%;float:right; }*/
	
        form#options { position: absolute; bottom: 5px; left: 320px; background: #fff; border: 1px solid #666; padding: 3px 5px; }
        form#options em { margin: 0 10px; color: #666; }
	#console {width:20%;left:0;
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
    
    <script type="text/javascript">
 var init = function() {
	var mark = {
  polygon: null
};
	 $.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
	
               $.each(json.result,function(i,gmap){
		latitude=gmap.latitude;
			longitude=gmap.longitude;
		//alert(gmap.geo_status);
		//alert(latitude);
		//alert(longitude);
	$(document).ready(function(){
 			$("#speed").html('<p>Speed@&nbsp;'+gmap.velocity+'&nbsp;kmph</p>');
			$("#activity").html('<p>last update@&nbsp;'+gmap.last_update+'</p>');
			 $("#text").html('<p>'+gmap.Location+'</p>');
				 });
	var image = 'vw-beetle-icon.png'
      var latlng= new google.maps.LatLng(latitude, longitude)
            var opts = {
                zoom: 16,
                center:latlng , // London
                mapTypeId: google.maps.MapTypeId.ROADMAP,
		icon: image
            };
            var map = new google.maps.Map(document.getElementById('map'), opts);
			var Marker = new google.maps.Marker({
      		position: latlng,
	      map: map,
	      icon: image
  });
var geocoder;
	//map.clearOverlays();
		//GEOCODER
		
		  geocoder = new google.maps.Geocoder();
	setInterval(function() {	  
		$.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
			console.log(json.result);
              		$.each(json.result,function(i,gmap){
			latitude=gmap.latitude;
			longitude=gmap.longitude;
		//	alert(latitude);
			var image = 'vw-beetle-icon.png'
			var latlngdyn= new google.maps.LatLng(latitude, longitude) 
		  	marker = new google.maps.Marker({
		    	position: latlngdyn,
		    	draggable: true,
			icon:image
		  	});
			
			marker.setMap(map);
			console.log(gmap.geo_status);
			//this.setMap(null);
			
            
			if(gmap.geo_status==1)
			{
			//var unitSelector=mt
			//marker.setMap(null);
			//polygonDestructionHandler();
			oldDrawHandler();

			}
			/*if(gmap.geo_status==1 && gmap.out_range>gmap.range)
			{
			var overshot=gmap.out_range-gmap.range;
			alert('vehicle out of geo fence:'+overshot+'metres'); 

			}*/
			
		
		});
		// map.clearOverlays();

	});
//marker.setMap(null);
		$(document).ready(function(){
 			$("#speed").html('<p>Speed@&nbsp;'+gmap.velocity+'&nbsp;kmph</p>');
			$("#activity").html('<p>last update@&nbsp;'+gmap.last_update+'</p>');
			 $("#text").html('<p>'+gmap.Location+'</p>');
				 });
//marker.setMap(null);
//this.setMap(null);
 }, 5000);
	
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

            var earthRadiuses = {
                // The radius of the earth in various units
               // 'mi': 3963.1676,
               // 'km': 6378.1,
              //  'ft': 20925524.9,
                'mt': 6378100,
             /*   'in': 251106299,
                'yd': 6975174.98,
                'fa': 3487587.49,
                'na': 3443.89849,
                'ch': 317053.408,
                'rd': 1268213.63,
                'fr': 31705.3408*/
            };
            
            var getPoints = function(lat, lng, radius, earth){
                // Returns an array of GLatLng instances representing the points of the radius circle
                var lat = (lat * Math.PI) / 180; //rad
		
                var lon = (lng * Math.PI) / 180; //rad
                var d = parseFloat(radius) / earth; // d = angular distance covered on earth's surface
                var points = [];
                for (x = 0; x <= 360; x++) 
                { 
                    brng = x * Math.PI / 180; //rad
			
                    var destLat = Math.asin(Math.sin(lat)*Math.cos(d) + Math.cos(lat)*Math.sin(d)*Math.cos(brng));
                    var destLng = ((lon + Math.atan2(Math.sin(brng)*Math.sin(d)*Math.cos(lat), Math.cos(d)-Math.sin(lat)*Math.sin(destLat))) * 180) / Math.PI;
                    destLat = (destLat * 180) / Math.PI;
                    points.push(new google.maps.LatLng(destLat, destLng));
                }
                return points;
            }
            
            var polygonDestructionHandler = function() {
               this.setMap(null);
		//marker.setMap(null);
            }
            
            var polygonDrawHandler = function(e) {
                // Get the desired radius + units
                var select = document.getElementById('unitSelector');
                var unitKey = select.getElementsByTagName('option')[select.selectedIndex].value;
		
                var earth = earthRadiuses[unitKey];
                var radius = parseFloat(document.getElementById('radiusInput').value);
                // Draw the polygon
                var points = getPoints(e.latLng.lat(), e.latLng.lng(), radius, earth);
		//alert(e.latLng.lat());
		 $.getJSON('web_services/latlong.php?option=3&geo_status=0&lat_ref='+e.latLng.lat()+'&long_ref='+e.latLng.lng()+'&id='+id+'&range='+radius, function(json) {
		
               $.each(json.Result.Data,function(i,gmap){
		var status=gmap.Status;
		//console.log(gmap.Status);
		//alert(status);
			if(status=="geo_fensing success")
			{
			
			show_confirm();
			// google.maps.event.addListener(map, 'click', polygonDestructionHandler);
			//alert('me');
			}
			else
			{
			alert('geo_fensing failure');
			}
		
		
		});
	});
                var polygon = new google.maps.Polygon({
                    paths: points,
                    strokeColor: '#004de8',
                    strokeWeight: 1,
                    strokeOpacity: 0.62,
                    fillColor: '#004de8',
                    fillOpacity: 0.27,
                    geodesic: true,
                    map: map
                });
		//alert(radius);
		
                google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
               // google.maps.event.addListener(polygon, 'click', polygonDrawHandler);
		//console.log(gmap.Status);
            }


		var oldDrawHandler = function() {
		//map.setMap(null);
                // Get the desired radius + units
                //var select = document.getElementById('unitSelector');
		//var select=mt;
               // var unitKey = select.getElementsByTagName('option')[select.selectedIndex].value;
		var unitKey = 'mt';
                var earth = earthRadiuses[unitKey];
              //  var radius = parseFloat(document.getElementById('radiusInput').value);
		var radius = 2000;
                // Draw the polygon
			lt=13.0497548596428;
			ln=77.6202746243287;
                var points = getPoints(lt, ln, radius, earth);
		//alert(e.latLng.lat());

                var polygon = new google.maps.Polygon({
                    paths: points,
                    strokeColor: '#004de8',
                    strokeWeight: 1,
                    strokeOpacity: 0.62,
                    fillColor: '#004de8',
                    fillOpacity: 0.27,
                    geodesic: true,
                    map: map
                });
		//this.setMap(null);
		//this.set_map(null);
		google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
		//this.polygonDestructionHandler();
		//alert(radius);
		//marker.setMap(null);
              //  google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
               // google.maps.event.addListener(polygon, 'click', polygonDrawHandler);
		//console.log(gmap.Status);
		
            }
         //   alert(unitkey);
        // google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
	//google.maps.event.addListener(map, 'click',  oldDrawHandler);
		
		
	});

});


        }

    </script>
</head>

<body onload="init()">
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
    <div id="map"></div>
    
    <form id="options">
        <label for="radiusInput">Radius</label> <input type="text" value="500" id="radiusInput" name="radiusInput" />
        <label for="unitSelector">Units</label> 
		<select id="unitSelector" name="unitSelector">
		  <option value="mt">Metres</option>
             <!--<option value="mi">Miles</option>
            <option value="km">Kilometers</option>
           <option value="ft">Feet</option>
          
            <option value="in">Inches</option>
            <option value="yd">Yards</option>
            <option value="fa">Fathoms</option>
            <option value="na">Nautical miles</option>
            <option value="ch">Chains</option>
            <option value="rd">Rods</option>
            <option value="fr">Furlongs</option>-->
        </select>
	
	<!--<a href='javascript:void(0);' onclick="location.href='Gmap_location.php?imei='+imei">home</a>-->
	<!--location.href="Gmap_location.php?uid="+uid;-->
        <em><b>Click the map to place a circle, right click a circle to remove it</b></em>
   	<!--<ul class='nav'>
	<li><a href="javascript:void(0)" onclick="location.href='Gmap_location.php'"><em><b>home</b></em></a></li></ul>-->
	
	
	 </form>
	
	
</body>
</html>
