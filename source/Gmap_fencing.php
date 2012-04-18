<!DOCTYPE html>
<head>
<?php include'set_session.php';$user_id=$_SESSION['UID'];?>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
    <link href='http://fonts.googleapis.com/css?family=Walter+Turncoat' rel='stylesheet' type='text/css'>
  <link rel="icon" type="image/png" href="vw-beetle-icon.png">
<link rel="stylesheet" href="jquery.alerts.css"/>
<link rel="stylesheet" media="screen" href="todolist.css" />
<link rel="stylesheet" href="style.css"/>
	<title>Vehicle Tracking System</title>
   <!-- <meta name="viewport" content="width=device-width, user-scalable=no" />-->
<script src="jquery-1.7.1.js" type="text/javascript"> </script>
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
 <script src="jquery.alerts.js"></script>
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

</script>
   <!-- <style type="text/css">


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


    </style>-->
    <?php include'set_session.php';$user_id=$_SESSION['UID'];?>
    <script type="text/javascript">
 //var init = function() {
$(document).ready(function() {	


	 $.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
	
               $.each(json.result,function(i,gmap){
		latitude=gmap.latitude;
			longitude=gmap.longitude;
		//alert(gmap.geo_status);
		//alert(latitude);
		//alert(longitude);
//	$(document).ready(function(){
;

	var distance1=gmap.range;//console.log(distance1);//calculated distance
		var distance2=gmap.ranged;//console.log(distance2);//preset range by fleet manager

				
		$("#speed").html('<b>Address:</b>&nbsp;'+gmap.Location+'&nbsp;<hr><b>Speed:</b>&nbsp;'+gmap.velocity+'&nbsp;kmph<br><b>Vehicle Name:</b>'+gmap.alias+'<br><b>last update:</b>&nbsp;'+gmap.Server_IST+'<br>');
			
		if(distance1>distance2 && gmap.geo_status=='1')
		{
			$("#speed").append('<b>Vehicle Status:</b>Outbound<br><b>Range(m):</b>'+gmap.ranged+'<br><b>Out of Range By(m):</b>'+gmap.range);
		}
		else if(distance1<distance2 && gmap.geo_status=='1')
		{
		$("#speed").append('<b>Vehicle Status:</b><br>Inbound<b>Range:</b>'+gmap.ranged);		
		}
		else
		{
		$("#speed").append('<b>Vehicle Status:</b>Not Set');
		}

	var image = 'vw-beetle-icon.png'
      var latlng= new google.maps.LatLng(latitude, longitude)
            var opts = {
                zoom: 16,
                center:latlng , // London
                mapTypeId: google.maps.MapTypeId.ROADMAP,
		//mapTypeId: google.maps.MapTypeId.HYBRID,
		icon: image
            };


		/*function AutoCenter() {
//  Create a new viewpoint bound
var bounds = new google.maps.LatLngBounds();
//  Go through each...
$.each(markers, function (index, marker) {
bounds.extend(marker.position);
});
//  Fit these bounds to the map
map.fitBounds(bounds);
}*/


            var map = new google.maps.Map(document.getElementById('map'), opts);
var Marker = new google.maps.Marker({
      		position: latlng,	
	      map: map,
	      icon: image
  })

//console.log(infowindow);
/*2012*/
/*var bounds = new google.maps.LatLngBounds();

    for (var i=0; i<=address.length; i++) {     
        geocoder.geocode({'address': address[i]}, function(results, status) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({map: map, position: results[0].geometry.location});  
            //Mod
            bounds.extend(marker.getPosition());
        });
    } 
    //Mod
    map.fitBounds(bounds);*/
/* var bounds = new google.maps.LatLngBounds();
    for (index in markers) {
	
      var data = markers[index];
      bounds.extend(new google.maps.LatLng(data.latitude, data.longitude));
    }
	
    map.fitBounds(bounds);//clearOverlays();*/


var lat = new Array();
var lon = new Array();
lat[0]=gmap.lat_ref;
lon[0]=gmap.long_ref;
lat[1]=gmap.latitude;
lon[1]=gmap.longitude;

/*var loc[1] = new Array(2);
loc[1][0]=gmap.latitude;
loc[1][1]=gmap.longitude;*/
//console.log(lat);
//console.log(lon);
/*loc[1][0]=gmap.latitude;
loc[1][1]=gmap.longitude;*/

//console.log(loc);

//var markers= new google.maps.LatLng(gmap, longitude)
/*var bounds = new google.maps.LatLngBounds();
    for (i in markers) {
	
      var data = markers[i];
      bounds.extend(new google.maps.LatLng(data.lati, data.longi));
 }
	
    map.fitBounds(bounds)*/

/*
var bounds = new google.maps.LatLngBounds();


bounds.extend(latlng);

map.fitBounds(bounds);*/

/*var bounds = new google.maps.LatLngBounds();
var pos= new google.maps.LatLng(gmap.lat_ref,gmap.long_ref);
console.log(pos);
    for (var i=0; i<=2; i++) {     
        //geocoder.geocode({'address': address[i]}, function(results, status) {
          //  map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({map: map, zoom: 16, position: pos});  
            //Mod
            bounds.extend(marker.getPosition());
       // });
    } 
    //Mod
    map.fitBounds(bounds);*/

/*2012*/

//var latlng= new google.maps.LatLng(gmap.lat_ref, gmap.long_ref)
           /* var opts = {
                zoom: 16,
                center:latlng , // London
                mapTypeId: google.maps.MapTypeId.ROADMAP,
		//mapTypeId: google.maps.MapTypeId.HYBRID,
		icon: image
            };*/
/*var bounds = new google.maps.LatLngBounds();

latlng1= new google.maps.LatLng(gmap.lat_ref, gmap.long_ref);
latlng2= new google.maps.LatLng(gmap.latitude, gmap.longitude);
			var Marker = new google.maps.Marker({
      		//position: latlng,	
	      map: map,
	     // icon: image
  });
	
bounds.extend(latlng);

map.fitBounds(bounds)*/
var infowindow = new google.maps.InfoWindow();
//marke.setMap(null)	
		console.log(infowindow);
			if(gmap.geo_status=='1')
			{
			//infowindow()=[];
			var marke = new google.maps.Marker({
			  position: new google.maps.LatLng(gmap.lat_ref, gmap.long_ref),
			  map: map,
			 // title: 'My workplace'
			});
			//marke.setMap(map);
			//console.log(infowindow);
			//var infowindow.close();
			
			var infowindow = new google.maps.InfoWindow({
			  content: 'Geo Fencing Mid-Point'
			});
			//infowindow.setContent('Marker position: ' + this.getPosition());
			infowindow.open(map, marke);

			//if (infowindow) {
			infowindow.close(map,marke);
			//marke.setMap(null);
				//};
			
			}
			if (infowindow) {
			infowindow.close(map,marke);
			//marke.setMap(null);
				};
if(gmap.geo_status=='1')
		{
		//console.log("set");
		//alert("Geo Fence Not set!!!");
jAlert('Circular Shape Overlay with Orange color', 'GeoFencing Area');
var bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < 2; i++) {
     // var beach = locations[i];
      var myLatLng = new google.maps.LatLng(lat[i], lon[i]);
      var marker = new google.maps.Marker({
        position: myLatLng,

       // map: map,
      //  icon:null
    });

	//console.log(marker);
    bounds.extend(myLatLng);
    map.fitBounds(bounds);
}

		}

		/*var Marker,i
		Marker = new google.maps.Marker({
      		position: new google.maps.LatLng(gmap.lat_ref, gmap.long_ref),	
	      map: map,
	      icon: image
  });*/
	
/*var marker, i;

    for (i = 0; i < 1; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(gmap.lat_ref, gmap.long_ref),
        map: map
      });*/
Marker.setMap(map);
 var earthRadiuses = {
                // The radius of the earth in various units
                /*'mi': 3963.1676,
                'km': 6378.1,
                'ft': 20925524.9,*/
                'mt': 6378100
               /* 'in': 251106299,
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
            
          /*  var polygonDestructionHandler = function() {
		this.setMap(null);
		console.log(this);
                
            }*/
            		/*$('#map').bind('contextmenu', function(e){
    e.preventDefault();
    alert('hi there!');
    return false;
})*/
     var unitKey = 'mt';
	var earth = earthRadiuses[unitKey];
              //  var radius = parseFloat(document.getElementById('radiusInput').value);
		var radius = gmap.ranged;
                // Draw the polygon
			var lt=gmap.lat_ref;
			var ln=gmap.long_ref;

//console.log(infowindow);
                var points = getPoints(lt, ln, radius, earth);
		//alert(e.latLng.lat());
	//console.log(points)
                var polygon = new google.maps.Polygon({
                    paths: points,
                    strokeColor: '#FF5333',
                    strokeWeight: 1,
                    strokeOpacity: 0.62,
                    fillColor: '#FF5333',
                    fillOpacity: 0.27,
                    geodesic: true,
                    map: map
                });



//google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
            var polygonDrawHandler = function(e) {
		//this.polygonDestructionHandler();
		//this.setMap(null);
		$.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
		
               $.each(json.result,function(i,gmap){
		
		//console.log(gmap);
		if(gmap.geo_status=='1')
		{
		//polygonDestructionHandler(this.setMap);
		//this.polygonDestructionHandler();
		//console.log(this);
		/*var unitKey = 'mt';
                var earth = earthRadiuses[unitKey];
              //  var radius = parseFloat(document.getElementById('radiusInput').value);
		var radius = gmap.ranged;
                // Draw the polygon
			var lt=gmap.lat_ref;
			var ln=gmap.long_ref;
                var points = getPoints(lt, ln, radius, earth);
		//alert(e.latLng.lat());
	//console.log(points)
                var polygon = new google.maps.Polygon({
                    paths: points,
                    strokeColor: '#FF5333',
                    strokeWeight: 1,
                    strokeOpacity: 0.62,
                    fillColor: '#FF5333',
                    fillOpacity: 0.27,
                    geodesic: true,
                    map: map
                });*/
//console.log(polygon);
//console.log(polygon.map);

		jAlert('Geo Fence Already Set!!!', 'Alert');
		//alert("Geo Fence Already Set!!!");
		google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
		return;
			

		}
		
		//var radius=prompt("Please enter radius","500");
		jPrompt('Enter Radius in metres within 50 and 500000:', '500', 'Enter Radius(mts)', function(radius) {
   // if( r ) alert('You entered ' + r);
		if (radius!=null || radius!="")
		  {
			if(radius<50 || radius>500000)
			{
			jAlert('Enter Within Range of 500000m', 'Alert');return false;
			}
			
					
			var RE = /^-{0,1}\d*\.{0,1}\d+$/;
		    if((RE.test(radius))==false)
			{
			jAlert('No special Characters', 'Alert');return false;
			//alert("Only Numbers Allowed");return false;
			}
			jAlert('Geo Fenced for radius:'+radius+'mts.', 'Alert');
			//alert("Geo Fenced for radius:"+radius+"mts.");
		  //console.log(distance);
		  }
		else
		{
		return false;
		}

		
			


	
			 $.getJSON('web_services/latlong.php?option=3&geo_status=1&lat_ref='+e.latLng.lat()+'&long_ref='+e.latLng.lng()+'&id='+id+'&range='+radius, function(json) {
		
               $.each(json.Result.Data,function(i,gmap){
		var status=gmap.Status;

		
		
                // Get the desired radius + units
                var select = document.getElementById('unitSelector');
               // var unitKey = select.getElementsByTagName('option')[select.selectedIndex].value;
		var unitKey = 'mt';
                var earth = earthRadiuses[unitKey];
               // var radius = parseFloat(document.getElementById('radiusInput').value);
                // Draw the polygon
	
                var points = getPoints(e.latLng.lat(), e.latLng.lng(), radius, earth);
		
                var polygon = new google.maps.Polygon({
                    paths: points,
                    strokeColor: '#FF5333',
                    strokeWeight: 1,
                    strokeOpacity: 0.62,
                    fillColor: '#FF5333',
                    fillOpacity: 0.27,
                    geodesic: true,
                    map: map
                });
		
                google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
				
		});
	});

	});

});
		});
//google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
               // google.maps.event.addListener(polygon, 'click', polygonDrawHandler);
            }
            
            google.maps.event.addListener(map, 'click', polygonDrawHandler);

	setInterval(function() {	  
		//Marker.setVisible(false);
		//clearOverlays();
		Marker.setMap(null);
		$.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {

		//console.log(gmap);
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

		//marke.setMap(null);
		//console.log(infowindow);
	/*	 if (infowindow) {
            //infowindow.close(map, marke);
marke.setMap(null);
        };*/
			//marke.setMap(null);
/*var infowindow = new google.maps.InfoWindow({
  content: 'Hello world'
});
infowindow.open(map, marker);*/
		marker.setMap(map);
		var distance1=gmap.range;//console.log(distance1);//calculated distance
		var distance2=gmap.ranged;//console.log(distance2);//preset range by fleet manager

		//$("#speed").html('<b>Speed:</b>&nbsp;'+gmap.velocity+'&nbsp;kmph<br>');
			
		$("#speed").html('<b>Address:</b>&nbsp;'+gmap.Location+'&nbsp;<hr><b>Speed:</b>&nbsp;'+gmap.velocity+'&nbsp;kmph<br><b>Vehicle Name:</b>'+gmap.alias+'<br><b>last update:</b>&nbsp;'+gmap.Server_IST+'<br>');
			// $("#text").html('<p>'+gmap.Location+'</p>');
		if(distance1>distance2 && gmap.geo_status=='1')
		{
		$("#speed").append('<b>Vehicle Status:</b>Outbound<br><b>Range(m):</b>'+gmap.ranged+'<br><b>Out of Range By(m):</b>'+gmap.range);
		}
		else if(distance1<distance2 && gmap.geo_status=='1')
		{
		$("#speed").append('<b>Vehicle Status:</b>Inbound<br><b>Range:</b>'+gmap.ranged);
		
		}
		else
		{
		$("#speed").append('<b>Vehicle Status:</b>Not Set');
		}    

		});		
//marke.setMap(null);
	});


marker.setMap(null);
//marke.setMap(null);
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
				marke.setMap(null);
		console.log(marke);
		//console.log(marke);
		//console.log(this);
		console.log("nuthan");
		Marker.setMap(null);
		$.getJSON('web_services/latlong.php?option=5&id=<?php echo $_REQUEST['id'];?>', function(json) {
		
               $.each(json.Result.Data,function(i,gmap){
		//console.log(gmap);
		
		if(gmap.Status=='failure')
		{
		//alert("Left Click to set GeoFencing!!!");
		jAlert('Left Click to set GeoFencing!!!', 'Alert');
		}
		else if(gmap.Status=='success')
		{
		//alert("Geo Fencing removed");
		jAlert('Geo Fencing removed', 'Alert');
		}	
		});
		});
		//console.log("2");
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
			
                var polygon = new google.maps.Polygon({
                    paths: points,
                    strokeColor: '#FF5333',
                    strokeWeight: 1,
                    strokeOpacity: 0.62,
                    fillColor: '#FF5333',
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
		/*var polygonDestructionHandler = function() {
               this.setMap(null);
		}*/
		$("#geoFenceLink").click(function() {
	
	//console.log(polygon);
// this.setMap(null);
	/*if (this.getAttribute('clicked') == '1') 
	{ return false; } 
	else 
	{ this.setAttribute('clicked', '1'); }*/

		  //polygon.setMap(null);
		/*$('div').bind('rightclick', function(){ 
    alert('right mouse button is pressed');
})*/

	/*$('div').bind('click', function(){
    alert('clicked');
});*/

	//$('#map').mousedown(function(event) {

//});
			 $.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
		
               $.each(json.result,function(i,gmap){
		//console.log(this.map);
		//console.log(gmap);
	
		if(gmap.geo_status!='1')
		{
		//console.log("set");
		//alert("Geo Fence Not set!!!");
		jAlert('Geo Fence Not set!!!', 'Alert');
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
	//console.log(points)
                var polygon = new google.maps.Polygon({
                    paths: points,
                    strokeColor: '#FF5333',
                    strokeWeight: 1,
                    strokeOpacity: 0.62,
                    fillColor: '#FF5333',
                    fillOpacity: 0.27,
                    geodesic: true,
                    map: map
                });
//console.log(polygon);
//console.log(polygon.map);
			google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
			/*enable/disable external geo fence*/
		});
	});
	//this.setMap(null);
		// google.maps.event.addListener(polygon, 'click', polygonDrawHandler);
			/*enable/disable internal geo fences*/

	

            });




		/*$("#removeFence").click(function() {
		//map.setMap(null);
		// this.setMap(null);
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

/*if((gmap.geo_status=='1') && (distance1 < distance2))
{

document.getElementById('beep-one').play();
}

		//google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);var beepOne = $("#beep-one")[0];
$(".nav a")
	.mouseover(function() {
		beepOne.play();
	});*/
			/*enable/disable external geo fence*/
		// google.maps.event.addListener(polygon, 'click', polygonDrawHandler);
			/*enable/disable internal geo fences*/
         //   });



	});

            

});

});

    </script>
</head>

<!--<body onload="init()">-->
<body>
<audio id="beep-one" controls="controls" preload="auto" style="display: none;">
				<source src="audio/Centaurus.mp3"></source> 
				<source src="audio/Centaurus.ogg"></source>
				Your browser isn't invited for super fun time.
			</audio>

<div id='console' style="width: 285px; height: 715px;">
		<!-- <h1 class="simple" style= "font-family: 'Walter Turncoat', cursive; font-weight: bold; text-align: center; font-size: 18px;">Console</h1> -->
		<div class='navbox' style="height: 225px">
			<ul class='nav'>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_location.php'">Home</a></li>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_history.php?id='+<?php echo $_REQUEST['id'];?>">History</a></li>
				<!--<li><a href="javascript:void(0)" onclick="location.href=#">Geo Fencing</a></li>-->
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_monitor.php?id='+<?php echo $_REQUEST['id'];?>">Live Monitor</a></li>
				<!--<li><a id="geoFenceLink">Check Fencing</a></li>-->
				<li><a href="#" style="background: url('images/inside_ui/image_0005_Layer-4-copy-6.png') no-repeat">Geo Fencing</a></li>
				<!--<li><a id="removeFence" href="#">Remove Fencing</a></li>-->
				<!--<li><a id="setGeoFence" href="javascript:void(0)" onclick="google.maps.event.addListener(polygon, 'click', polygonDrawHandler);">Set Fence</a></li>-->
				<li><a href="javascript:void(0)" onclick="location.href='log_out.php'">Logout</a></li>
				
			</ul>
		</div>
					
					<br/>
					<div id='datetime' style="float:left;">
					
					<!--<fieldset><legend>current location</legend><div id='text'>loading...</div></fieldset>-->
					<!--<em><b>--> <span style="font-size: 12px; color: green; font-weight: bold; text-align: center; margin-left: 20px;"> Click the map to place a circle. </span><br> <span style="font-size: 12px; color: green; font-weight: bold; text-align: center; margin-left: 20px;">Right click a circle to remove it </span> <!-- </b></em> -->
					<br/>
					<div id='detail' style="padding: 5px; font-size: 14px; overflow:scroll; width:250px; height:210px; "><h4>Vehicle Details</h4><div id='speed'>loading...</div></div>
		<!--   -->		
					</div>
		
				
		
	</div>
    <div id="map" style="width: 80%; height: 725px;"></div>
    
   <!-- <form id="options">
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
      <!--  </select>
	
	<!--<a href='javascript:void(0);' onclick="location.href='Gmap_location.php?imei='+imei">home</a>-->
	<!--location.href="Gmap_location.php?uid="+uid;-->
       <!-- <em><b>Click the map to place a circle, right click a circle to remove it</b></em>-->
   	<!--<ul class='nav'>
	<li><a href="javascript:void(0)" onclick="location.href='Gmap_location.php'"><em><b>home</b></em></a></li></ul>-->
	
	
	<!--</form>-->
	
	
</body>
</html>
