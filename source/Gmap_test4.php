<html> 
<head> 
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
<title>Google Maps JavaScript API v3 Example: Markers, Info Window and StreetView</title> 
<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
  <script src="http://code.jquery.com/jquery-latest.js">
		</script>
<script type="text/javascript"> 
var json=[];
  function initialize() {

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
//(function() {})();
//var markers =setInterval(function() {var mark=$.getValues("web_services/latlong.php?option=4&user_id=21");console.log(mark);return mark;},5000);
setInterval(function() {
//markers.clearOverlays();
//var markers=[];
//markers.clearOverlays();
clearOverlays();
var markers=$.getValues("web_services/latlong.php?option=4&user_id=21");console.log(markers);




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

      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(data.latitude, data.longitude),
        map: map,
       // title: data.alias
      });
    
      // Create the infowindow with two DIV placeholders
      // One for a text string, the other for the StreetView panorama.
      var content = document.createElement("DIV");
      var title = document.createElement("DIV");
	    var spd= document.createElement("DIV");
		var Server_IST=document.createElement("DIV");
      title.innerHTML = "Alias:&nbsp;"+data.alias;
	spd.innerHTML="Current Speed:&nbsp;"+data.cur_speed;
	Server_IST.innerHTML="Server_IST:&nbsp;"+data.Server_IST;
      content.appendChild(title);
	 content.appendChild(spd);
	 content.appendChild(Server_IST);


      /*var streetview = document.createElement("DIV");
      streetview.style.width = "200px";
      streetview.style.height = "200px";
      content.appendChild(streetview);*/
      var infowindow = new google.maps.InfoWindow({
        content: content
      });

      // Open the infowindow on marker click
	markersArray.push(marker);
      google.maps.event.addListener(marker, "click", function() {
        infowindow.open(map, marker);
      });
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
},5000);
  }
</script> 
</head> 
<body onload="initialize()"> 
  <div id="map_canvas"></div> 
</body> 
</html>
