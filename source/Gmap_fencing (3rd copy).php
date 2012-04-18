<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<?php include'set_session.php';$user_id=$_SESSION['UID'];?>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
    
  <link rel="icon" type="image/png" href="vw-beetle-icon.png">
	<title>Vehicle Tracking System</title>
   <!-- <meta name="viewport" content="width=device-width, user-scalable=no" />-->
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript">
javascript:window.history.forward(1);
</script>
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

 color: #67a5cd;
 padding: 7px 15px 7px 30px;
} 


    </style>
    <?php include'set_session.php';$user_id=$_SESSION['UID'];?>
    <script type="text/javascript">
 //var init = function() {
$(document).ready(function() {	
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
		console.log(gmap.Status);
		alert(status);
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
                google.maps.event.addListener(polygon, 'click', polygonDrawHandler);
		
            }
         //   alert(unitkey);
           // google.maps.event.addListener(map, 'click',  polygonDrawHandler);

	 $.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
	
               $.each(json.result,function(i,gmap){
		latitude=gmap.latitude;
			longitude=gmap.longitude;
		//alert(gmap.geo_status);
		//alert(latitude);
		//alert(longitude);
//	$(document).ready(function(){


	var distance1=gmap.range;//console.log(distance1);//calculated distance
		var distance2=gmap.ranged;//console.log(distance2);//preset range by fleet manager

				
		$("#speed").html('<b>Address:</b>&nbsp;'+gmap.Location+'&nbsp;<hr><b>Speed:</b>&nbsp;'+gmap.velocity+'&nbsp;kmph<br><b>Vehicle Name:</b>'+gmap.alias+'<br><b>last update:</b>&nbsp;'+gmap.Server_IST+'<br>');
			
		if(distance1>distance2)
		{
			$("#speed").append('<b>Vehicle Status:</b>Outbound');
		}
		else
		{
		$("#speed").append('<b>Vehicle Status:</b>Inbound');
		}

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
Marker.setMap(map);



	setInterval(function() {	  
		//Marker.setVisible(false);
		//clearOverlays();
		Marker.setMap(null);
		$.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {


              		$.each(json.result,function(i,gmap){
			latitude=gmap.latitude;
			longitude=gmap.longitude;
		//	alert(latitude);
			var image = 'vw-beetle-icon.png';
			var latlng= new google.maps.LatLng(latitude, longitude)
			//marker.setMap(null);
			 marker = new google.maps.Marker({
				position:latlng,
				//setCenter:new google.maps.LatLng(latitude, longitude),
				map: map,
				icon: image,
				//setcenter:new google.maps.LatLng(latitude, longitude)
			       //title: gmap.alias
				//setMap:null	
		
			      });
		marker.setMap(map);
		var distance1=gmap.range;//console.log(distance1);//calculated distance
		var distance2=gmap.ranged;//console.log(distance2);//preset range by fleet manager

		//$("#speed").html('<b>Speed:</b>&nbsp;'+gmap.velocity+'&nbsp;kmph<br>');
			
		$("#speed").html('<b>Address:</b>&nbsp;'+gmap.Location+'&nbsp;<hr><b>Speed:</b>&nbsp;'+gmap.velocity+'&nbsp;kmph<br><b>Vehicle Name:</b>'+gmap.alias+'<br><b>last update:</b>&nbsp;'+gmap.Server_IST+'<br>');
			// $("#text").html('<p>'+gmap.Location+'</p>');
		if(distance1>distance2)
		{
		
			
			$("#speed").append('<b>Vehicle Status:</b>Outbound');
			
		//alert("vehicle out of location");
		}
		else
		{
		$("#speed").append('<b>Vehicle Status:</b>Inbound');
		}        

		});
	
			

	});

//marker.setMap(null);

 }, 5000);



		
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
			console.log(e.latLng);
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
			/* destruction listener for internal geo fencing*/
               // google.maps.event.addListener(polygon, 'click', polygonDrawHandler);
		/*enable/disable geo fencing within children geo fencing*/
		//console.log(gmap.Status);
            }

		
         //   alert(unitkey);
 
	//google.maps.event.addListener(map, 'click',  oldDrawHandler);
		
		$("#geoFenceLink").click(function() {
		//map.setMap(null);
			 $.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
		
               $.each(json.result,function(i,gmap){
		
		console.log(gmap);
				
		

		if(gmap.geo_status!='1')
		{
		//console.log("set");
		alert("Geo Fence Not set!!!");
		return;
		}
		//console.log(gmap.geo_status);
                // Get the desired radius + units
                //var select = document.getElementById('unitSelector');
		//var select=mt;
               // var unitKey = select.getElementsByTagName('option')[select.selectedIndex].value;
		var unitKey = 'mt';
                var earth = earthRadiuses[unitKey];
              //  var radius = parseFloat(document.getElementById('radiusInput').value);
		var radius = gmap.ranged;
                // Draw the polygon
			var lt=gmap.lat_ref;
			var ln=gmap.long_ref;
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

		});
	});
		//google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
			/*enable/disable external geo fence*/
		// google.maps.event.addListener(polygon, 'click', polygonDrawHandler);
			/*enable/disable internal geo fences*/
            });

		$("#removeFence").click(function() {
		//map.setMap(null);
			 $.getJSON('web_services/latlong.php?option=5&id=<?php echo $_REQUEST['id'];?>', function(json) {
		
               $.each(json.Result.Data,function(i,gmap){
		
		if(gmap.Status=='failure')
		{
		alert("Please set the Geo Fence First");
		}
		else if(gmap.Status=='success')
		{
		alert("Geo Fencing removed");
		}		

		//console.log(gmap);
				
		
		});
	});
		/*if(gmap.geo_status!='1')
		{
		//console.log("set");
		alert("Geo Fence Not set!!!");
		return;
		}
		//console.log(gmap.geo_status);
                // Get the desired radius + units
                //var select = document.getElementById('unitSelector');
		//var select=mt;
               // var unitKey = select.getElementsByTagName('option')[select.selectedIndex].value;
		var unitKey = 'mt';
                var earth = earthRadiuses[unitKey];
              //  var radius = parseFloat(document.getElementById('radiusInput').value);
		var radius = gmap.ranged;
                // Draw the polygon
			var lt=gmap.lat_ref;
			var ln=gmap.long_ref;
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
                });*/


		//google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
			/*enable/disable external geo fence*/
		// google.maps.event.addListener(polygon, 'click', polygonDrawHandler);
			/*enable/disable internal geo fences*/
            });


		$("#setGeoFence").click(function() {
	
	
	                // var polygonDrawHandler = function(e) {
                // Get the desired radius + units
                var select = document.getElementById('unitSelector');
                var unitKey = select.getElementsByTagName('option')[select.selectedIndex].value;
		
                var earth = earthRadiuses[unitKey];
                var radius = parseFloat(document.getElementById('radiusInput').value);
		console.log(radius);
		console.log(latLng.lat());
                // Draw the polygon
                var points = getPoints(e.latLng.lat(), e.latLng.lng(), radius, earth);
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
		//alert(radius);
		
                google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
                google.maps.event.addListener(polygon, 'click', polygonDrawHandler);
		//console.log(gmap.Status);
          //  }
		//alert(radius);
		
            
               
		//alert(e.latLng.lat());

            });

	});

            

});

});

    </script>
</head>

<!--<body onload="init()">-->
<body>
<div id='console'>
		<h1 class="simple">Console</h1>
		<div class='navbox'>
			<ul class='nav'>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_location.php'">Home</a></li>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_history.php?id='+<?php echo $_REQUEST['id'];?>">History</a></li>
				<!--<li><a href="javascript:void(0)" onclick="location.href=#">Geo Fencing</a></li>-->
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_monitor.php?id='+<?php echo $_REQUEST['id'];?>">Live Monitor</a></li>
				<li><a id="geoFenceLink" href="#">Check Fencing</a></li>
				<li><a id="removeFence" href="#">Remove Fencing</a></li>
				<!--<li><a id="setGeoFence" href="javascript:void(0)" onclick="google.maps.event.addListener(polygon, 'click', polygonDrawHandler);">Set Fence</a></li>-->
				<li><a href="javascript:void(0)" onclick="location.href='log_out.php'">logout</a></li>
				
			</ul>
		</div>
					
					
					<br/>
					<div id='datetime' style="float:left;">
					
					<br/>
					<!--<fieldset><legend>current location</legend><div id='text'>loading...</div></fieldset>-->
					<br/>
					<div id='detail'><h2>Vehicle Details</h2><div id='speed'>loading...</div></div>
				
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
