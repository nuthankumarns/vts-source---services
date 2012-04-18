<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="jquery-1.5.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
<style> div#map { position: absolute; top: 0; right: 0; width: 80%; height: 100%; }</style>
<script>
function initialize() {
var centerMap = new google.maps.LatLng(39.828175, -98.5795);
var myOptions = {
zoom: 4,
center: centerMap,
mapTypeId: google.maps.MapTypeId.ROADMAP
}

var map = new google.maps.Map(document.getElementById("map"), myOptions);
setMarkers(map, sites);
}

var sites = [
['Mount Evans', 39.58108, -105.63535, 4, 'This is Mount Evans.'],
['Irving Homestead', 40.315939, -105.440630, 2, 'This is the Irving Homestead.'],
['Badlands National Park', 43.785890, -101.90175, 1, 'This is Badlands National Park'],
['Flatirons in the Spring', 39.99948, -105.28370, 3, 'These are the Flatirons in the spring.']
];

function setMarkers(map, markers) {
var redMarker = new google.maps.MarkerImage('red_marker.png')

for (var i = 0; i < markers.length; i++) {
var sites = markers[i];
var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
var marker = new google.maps.Marker({
position: siteLatLng,
map: map,
icon: redMarker,
title: sites[0],
zIndex: sites[3],
html: sites[4]
});

var contentString = "nuthan";

var infowindow = new google.maps.InfoWindow({
content: contentString
});

google.maps.event.addListener(marker, 'click', function() {
//infowindow.setContent(this.html);
infowindow.open(map,this);
});
}
}
</script>
</head>
<body onload="initialize();">
<div id="map"><center><img style="position:absolute;top:50%;left:50%;" src="./images/loader.gif"/></center></div>
</body>
</html>
