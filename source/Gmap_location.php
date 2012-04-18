<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
 <meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="Sat, 01 Dec 2001 00:00:00 GMT">
<?php include'set_session.php';$user_id=$_SESSION['UID'];?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript">
/*    var SessionVars = {
        user: "UID",
        id: "isLoggedIn",
	sess_id:"session_id"
    }
console.log(SessionVars.user);
console.log(SessionVars.id);
console.log(SessionVars.sess_id);*/
//console.log(document.cookie());
</script>

<link href='http://fonts.googleapis.com/css?family=Walter+Turncoat' rel='stylesheet' type='text/css'>
<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" media="screen" href="todolist.css" />
<link rel="stylesheet" href="jquery.alerts.css"/>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
<link rel="stylesheet" type="text/css" href="style.css"/>

  <link rel="icon" type="image/png" href="vw-beetle-icon.png">
    <title>Vehicle Tracking System</title>

   <!-- <meta name="viewport" content="width=device-width, user-scalable=no" />-->
    
       <!-- <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAA7zatdDuuNbbeMyULD2yG5RQX2gm04R9FDFXzSd74lb-TAfkBGRRwjhMX1Kvf0hb7vtBJUUfnnFT-6g" type="text/javascript"></script>-->
<!--<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAEfq-J88L6W8QaeK-_jrMEBSmtvUnVE3cIil7-e0uzArV_1Eo-BQ-ci8NjtfYjDp41KfVVkgHllPC8Q" type="text/javascript"></script>-->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<!--<script src="http://maps.google.com/maps?file=api&v=3&sensor=true" type="text/javascript"></script>-->
<!--<script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>-->
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
  <!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
 <script src="jquery.alerts.js"></script>
 <!--<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>-->
<script type="text/javascript" src="jquery-1.5.js"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>-->
<script type="text/javascript" src="msdropdown/js/jquery.dd.js"></script>
<script type="text/javascript" src="msdropdown/js/test.js"></script>
<!--<script type='text/javascript'>
$(document).ready(function() {
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
	
});
var imei=get_request('imei');

</script>-->

    <script type="text/javascript"> 
var json=[];
$(document).ready(function() {	


//  function initialize() {
	
    // Create the map 
    // No need to specify zoom and center as we fit the map further down.
    var map = new google.maps.Map(document.getElementById("map_canvas"), {
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      streetViewControl: false
    });

	
	/*if(!mapOverlays.isEmpty()) 
	     { 
	     mapOverlays.clear(); 
	     mapView.invalidate();

	 }*/

	/*jQuery.extend({
	getValues: function(url) {
	    var result = null;
	$.getJSON('web_services/latlong.php?option=4&user_id=21', function(json) {
		result = json;
              });
		return result;
	}
	});*/
	
		jQuery.extend({
	getValues: function(url) {
    	var result = null;
    	$.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(data) {
            result = data.Result.Data;
        }
    });
    return result;
}

});

var markersArray = [];
function clearOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
  }
}

//setInterval(function() {
clearOverlays();
var markers=$.getValues("web_services/latlong.php?option=4&user_id=<?php echo $user_id;?>");//console.log(markers);
console.log(markers);



	//var mk=loadJSON('http://118.102.132.147/app_proto/web_services/latlong.php?option=4&user_id=21');
//console.log(markers);
    // Define the list of markers.
    // This could be generated server-side with a script creating the array.
    /*var markers = [
      { lat: -33.85, lng: 151.05, name: "marker 1" },
      { lat: -33.90, lng: 151.10, name: "marker 2" },
      { lat: -33.95, lng: 151.15, name: "marker 3" },
      { lat: -33.85, lng: 151.15, name: "marker 4" }
    ];*/

    // Create the markers ad infowindows.
    for (index in markers) addMarker(markers[index]);
    function addMarker(data) {
      // Create the marker
	var image = 'vw-beetle-icon.png'
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(data.latitude, data.longitude),
        map: map,
	icon: image
       // title: data.alias
	
      });

	function toggleBounce() {

  if (marker.getAnimation() != null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

// var geocoder = new google.maps.Geocoder();
//console.log(geocoder);
/*	function showAddress(marker) {
  if (geocoder) {
    geocoder.getLatLng(marker,
      function(point) {
	if (!point) {
	  alert(marker + " not found");
	} else {
	  mark = new GMarker(point);
	  map.addOverlay(mark);
	  marker[i] = mark;
	}
      }
    );
  }
}*/

/*for (var i = 0; i < markers.length; i++) {
  showAddress(markers[i]);
}*/



     google.maps.event.addListener(marker, 'click', toggleBounce);
      // Create the infowindow with two DIV placeholders
      // One for a text string, the other for the StreetView panorama.
//var latlng = new google.maps.LatLng(data.latitude, data.longitude);
//latlng=data.latitude+','+data.longitude;
var latlng1 = new google.maps.LatLng(data.latitude, data.longitude);

//console.log(latlng);
var geocoder = new google.maps.Geocoder();
//console.log(geocoder);
	geocoder.geocode({'latLng': latlng1}, function(results, status) {
	//console.log(results);
	//console.log(status);
	//console.log(results[1]);
	var content = document.createElement("DIV");
      var title = document.createElement("DIV");
	    var spd= document.createElement("DIV");
		var Server_IST=document.createElement("DIV");
		var address =document.createElement("DIV");

 // if (status == google.maps.GeocoderStatus.OK) {
	//console.log(results[1]);

//console.log(results[1].formatted_address);
   // if (results[1]) {
   //  	address.innerHTML="Address:&nbsp;"+results[1].formatted_address;
  //  } else {
  //   	address.innerHTML="Address:&nbsp;No Address";
  //  }
 // } else {
 //    	address.innerHTML="Address:&nbsp;"+status;
 // }
		address.innerHTML="Address:&nbsp;"+data.Location;
       title.innerHTML = "Alias:&nbsp;"+data.alias;
	spd.innerHTML="Current Speed:&nbsp;"+data.cur_speed;
	Server_IST.innerHTML="Last Received:&nbsp;"+data.Server_IST;
	
      content.appendChild(title);
	 content.appendChild(spd);
	 content.appendChild(Server_IST);
	content.appendChild(address);


var infowindow = new google.maps.InfoWindow({
        content: content
      });

      // Open the infowindow on marker click
	markersArray.push(marker);
      google.maps.event.addListener(marker, "click", function() {
        infowindow.open(map, marker);
      });
});


	/*address = addresses.Placemark[0];
            var myHtml = address.address;
            map.openInfoWindow(latlng, myHtml);*/

//console.log(showAddress(marker));
      /*var streetview = document.createElement("DIV");
      streetview.style.width = "200px";
      streetview.style.height = "200px";
      content.appendChild(streetview);*/
      
   	//marker.clearOverlays();
      // Handle the DOM ready event to create the StreetView panorama
      // as it can only be created once the DIV inside the infowindow is loaded in the DOM.
    /*  google.maps.event.addListenerOnce(infowindow, "domready", function() {
        var panorama = new google.maps.StreetViewPanorama(streetview, {
            navigationControl: false,
            enableCloseButton: false,
            addressControl: false,
            linksControl: false,
            visible: true,
            position: marker.getPosition()
        });
      });*/
    }

	

    // Zoom and center the map to fit the markers
    // This logic could be conbined with the marker creation.
    // Just keeping it separate for code clarity.
  
	 var bounds = new google.maps.LatLngBounds();
    for (index in markers) {
	
      var data = markers[index];
      bounds.extend(new google.maps.LatLng(data.latitude, data.longitude));
    }
	
    map.fitBounds(bounds);//clearOverlays();
//},10000);

setInterval(function() {
clearOverlays();
var markers=$.getValues("web_services/latlong.php?option=4&user_id=<?php echo $user_id;?>");//console.log(markers);




	//var mk=loadJSON('http://118.102.132.147/app_proto/web_services/latlong.php?option=4&user_id=21');
//console.log(markers);
    // Define the list of markers.
    // This could be generated server-side with a script creating the array.
    /*var markers = [
      { lat: -33.85, lng: 151.05, name: "marker 1" },
      { lat: -33.90, lng: 151.10, name: "marker 2" },
      { lat: -33.95, lng: 151.15, name: "marker 3" },
      { lat: -33.85, lng: 151.15, name: "marker 4" }
    ];*/

    // Create the markers ad infowindows.
    for (index in markers) addMarker(markers[index]);
    function addMarker(data) {
      // Create the marker
	var image = 'vw-beetle-icon.png'
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(data.latitude, data.longitude),
        map: map,
	icon: image
       // title: data.alias
	
      });

	function toggleBounce() {

  if (marker.getAnimation() != null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

// var geocoder = new google.maps.Geocoder();
//console.log(geocoder);
/*	function showAddress(marker) {
  if (geocoder) {
    geocoder.getLatLng(marker,
      function(point) {
	if (!point) {
	  alert(marker + " not found");
	} else {
	  mark = new GMarker(point);
	  map.addOverlay(mark);
	  marker[i] = mark;
	}
      }
    );
  }
}*/

/*for (var i = 0; i < markers.length; i++) {
  showAddress(markers[i]);
}*/



     google.maps.event.addListener(marker, 'click', toggleBounce);
      // Create the infowindow with two DIV placeholders
      // One for a text string, the other for the StreetView panorama.
//var latlng = new google.maps.LatLng(data.latitude, data.longitude);
//latlng=data.latitude+','+data.longitude;
var latlng1 = new google.maps.LatLng(data.latitude, data.longitude);

//console.log(latlng);
var geocoder = new google.maps.Geocoder();
//console.log(geocoder);
	geocoder.geocode({'latLng': latlng1}, function(results, status) {
	//console.log(results);
	//console.log(status);
	//console.log(results[1]);
	var content = document.createElement("DIV");
      var title = document.createElement("DIV");
	    var spd= document.createElement("DIV");
		var Server_IST=document.createElement("DIV");
		var address =document.createElement("DIV");

 // if (status == google.maps.GeocoderStatus.OK) {
	//console.log(results[1]);

//console.log(results[1].formatted_address);
   // if (results[1]) {
   //  	address.innerHTML="Address:&nbsp;"+results[1].formatted_address;
  //  } else {
  //   	address.innerHTML="Address:&nbsp;No Address";
  //  }
 // } else {
 //    	address.innerHTML="Address:&nbsp;"+status;
 // }
		address.innerHTML="Address:&nbsp;"+data.Location;
       title.innerHTML = "Alias:&nbsp;"+data.alias;
	spd.innerHTML="Current Speed:&nbsp;"+data.cur_speed;
	Server_IST.innerHTML="Last Received:&nbsp;"+data.Server_IST;
	
      content.appendChild(title);
	 content.appendChild(spd);
	 content.appendChild(Server_IST);
	content.appendChild(address);


var infowindow = new google.maps.InfoWindow({
        content: content
      });

      // Open the infowindow on marker click
	markersArray.push(marker);
      google.maps.event.addListener(marker, "click", function() {
        infowindow.open(map, marker);
      });
});


	/*address = addresses.Placemark[0];
            var myHtml = address.address;
            map.openInfoWindow(latlng, myHtml);*/

//console.log(showAddress(marker));
      /*var streetview = document.createElement("DIV");
      streetview.style.width = "200px";
      streetview.style.height = "200px";
      content.appendChild(streetview);*/
      
   	//marker.clearOverlays();
      // Handle the DOM ready event to create the StreetView panorama
      // as it can only be created once the DIV inside the infowindow is loaded in the DOM.
    /*  google.maps.event.addListenerOnce(infowindow, "domready", function() {
        var panorama = new google.maps.StreetViewPanorama(streetview, {
            navigationControl: false,
            enableCloseButton: false,
            addressControl: false,
            linksControl: false,
            visible: true,
            position: marker.getPosition()
        });
      });*/
    }

	

    // Zoom and center the map to fit the markers
    // This logic could be conbined with the marker creation.
    // Just keeping it separate for code clarity.
  
	 var bounds = new google.maps.LatLngBounds();
    for (index in markers) {
	
      var data = markers[index];
      bounds.extend(new google.maps.LatLng(data.latitude, data.longitude));
    }
	
  //  map.fitBounds(bounds);//clearOverlays();
},10000);
 // }
jQuery(function($) {
	  $.getJSON('web_services/latlong.php?option=4&user_id=<?php echo $user_id;?>', function(json) {
                var select = $('#vehicle');
 		
                $.each(json.Result.Data, function(i, v) {
			var option = $('<option/>');
			

                        option.attr('value', v.device_id)
                              .html(v.alias)
                              .appendTo(select);
			
                });
        });


});
});

</script> 

<!--<script>
function backButtonOverride()
{
  // Work around a Safari bug
  // that sometimes produces a blank page
  setTimeout("backButtonOverrideBody()", 1);

}

function backButtonOverrideBody()
{
  // Works if we backed up to get here
  try {
    history.forward();
  } catch (e) {
    // OK to ignore
  }
  // Every quarter-second, try again. The only
  // guaranteed method for Opera, Firefox,
  // and Safari, which don't always call
  // onLoad but *do* resume any timers when
  // returning to a page
  setTimeout("backButtonOverrideBody()", 500);
}
</script>
</head>
<body onLoad="backButtonOverride()">-->
<!--<script type="text/javascript">
    window.history.forward();
    function noBack(){ window.history.forward(); }
</script>-->
<script language="JavaScript">
javascript:window.history.forward(1);
</script>
</HEAD>
<BODY>
<!--<body onload="map1_initialize( )">-->
<!--<SCRIPT type="text/javascript">
    window.history.forward();
    function noBack() { window.history.forward(); }
</SCRIPT>
</head>
<BODY onload="noBack();"
    onpageshow="if (event.persisted) noBack();" onunload="">-->
<!--<body onload="initialize()"> -->

 
	<div id='console' style="background: url('images/inside_ui/bg.jpg') no-repeat scroll 0 0 transparent; width: 285px; background-color: #edead9; height: 715px; border: solid #3C3B37 6px; border-radius: 8px 8px 8px 8px; font-size: 18px;">
		<!-- <h1 class="simple text_change">Console</h1> -->
		<div class='navbox'>
			<ul class='nav' id="nav">
				<li><a href="javascript:void(0)" onclick="#" style="background: url('images/inside_ui/image_0005_Layer-4-copy-6.png') no-repeat">Home</a>

			<audio id="beep-one" controls="controls" preload="auto" style="display: none;">
				<source src="audio/beep.mp3"></source>
				<source src="audio/beep.ogg"></source>				
			</audio>
		
				</li>
				<li><a href="javascript:void(0)" onclick="var val= document.frm.vehicle.value; if(val=='this.value')
					{jAlert('Please Select Vehicle', 'Alert');exit;}location.href='Gmap_history.php?id='+val">History</a></li>
				<li><a href="javascript:void(0)" onclick="var val= document.frm.vehicle.value; if(val=='this.value')
					{jAlert('Please Select Vehicle', 'Alert');exit;}location.href='Gmap_monitor.php?id='+val">Live Monitor</a></li>
				<li><a href="javascript:void(0)" onclick="var val= document.frm.vehicle.value; if(val=='this.value')
					{jAlert('Please Select Vehicle', 'Alert');exit;}location.href='Gmap_fencing.php?id='+val">Geo Fencing</a></li>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_multiple_location.php'">Selective Live Monitor</a></li>
				<!--<li><a href="javascript:void(0)" onclick="location.href='registration/form.php'">Add Device</a></li>-->

				<li><a href="javascript:void(0)" onclick="location.href='log_out.php'">Logout</a></li>
			</ul>
		</div>
<script>var beepOne = $("#beep-one")[0];
$("#nav a")
	.mouseenter(function() {
		beepOne.play();
	});</script>
					
					<div id='form_wrapper' ><h2 style="clear: both; margin-left: 65px;font-size: 18px">select vehicle:</h2>
						<form method="get" name="frm">
							<select name="id" id="vehicle">
                						<option value="this.value">Select your vehicle</option>
           					 	</select>
							<!--<input type="submit" value="GO"/>-->
						</form>
					<!--<input type='checkbox' id="vehicle" value="this.value"/>-->
					</div>	
			<!--	<script type="text/javascript">
$(document).ready(function(){
	try {
		oHandler = $("#vehicle").msDropDown({mainCSS:'dd2'}).data("dd");
		//alert($.msDropDown.version);
		//$.msDropDown.create("body select");
		$("#ver").html($.msDropDown.version);
		} catch(e) {
			alert("Error: "+e.message);
		}
});
</script>	-->
	<h3 style="text-align: center; font-size: 18px">click on any of the markers to open info window</h3>
					

				
		
	</div>
	<div id="map_canvas" style="height: 725px"><center><img style="position:absolute;top:50%;left:50%;" src="./images/loader.gif"/></center></div>  
   
	 </form>

<div style="display: none;">
<img src="images/inside_ui/back_new.jpg" />
<img src="images/inside_ui/image_0001_click-on-any-of-the-markers-to-open--info-window.png" />
<img src="images/inside_ui/image_0002_Layer-5.png" />
<img src="images/inside_ui/image_0003_select-vehicle.png" />
<img src="images/inside_ui/image_0005_Layer-4-copy-6.png" />
<img src="images/inside_ui/image_0006_Layer-4.png" />
<img src="images/inside_ui/image_0007_Layer-3_old.png" />
</div>


</body>
</html>
