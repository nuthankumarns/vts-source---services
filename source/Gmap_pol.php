<html>
<head>
<title>Clearing Overlays On A Map</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
var mark = {
  map: null,
  markers: [],
  polyline: null,
  polygon: null
};
  
/**
 * Shows or hides all marker overlays on the map.
 */
/*mark.toggleMarkers = function(opt_enable) {
  if (typeof opt_enable == 'undefined') {
    opt_enable = !mark.markers[0].getMap();
  }
  for (var n = 0, marker; marker = mark.markers[n]; n++) {
    marker.setMap(opt_enable ? mark.map : null);
  }
};*/

/**
 * Shows or hides the polyline overlay on the map.
 */
/*mark.togglePolyline = function(opt_enable) {
  if (typeof opt_enable == 'undefined') {
    opt_enable = !mark.polyline.getMap();
  }
  mark.polyline.setMap(opt_enable ? mark.map : null);
};*/

/**
 * Shows or hides the polygon overlay on the map.
 */
mark.togglePolygon = function(opt_enable) {
  if (typeof opt_enable == 'undefined') {
    opt_enable = !mark.polygon.getMap();
  }
  mark.polygon.setMap(opt_enable ? mark.map : null);
};

/*mark.toggleAllOverlays = function() {
  var enable = true;
  if (mark.markers[0].getMap() ||
      mark.polyline.getMap() ||
      mark.polygon.getMap()) {
    enable = false;
  }
  mark.toggleMarkers(enable);
  mark.togglePolyline(enable);
  mark.togglePolygon(enable);
};*/
mark.toggleAllOverlays = function() {
  var enable = true;
  if (mark.polygon.getMap()) {
    enable = false;
  }
  mark.togglePolygon(enable);
};

/**
 * Called only once on initial page load to initialize the map.
 */
mark.init = function() {
  // Create single instance of a Google Map.
  mark.map = new google.maps.Map(document.getElementById('map-canvas'), {
    zoom: 7,
    center: new google.maps.LatLng(20.352524120908313, -156.51013176888227),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  
  // Create multiple Marker objects at various positions.
  var markerPositions = [
    new google.maps.LatLng(21.297222168933754, -157.86145012825727),
    new google.maps.LatLng(19.650520003641244, -155.09289544075727),
    new google.maps.LatLng(19.072501451715087, -155.753173828125)
  ];
  for (var n = 0, latLng; latLng = markerPositions[n]; n++) {
    var marker = new google.maps.Marker({
      position: latLng
    });
    
    // Add marker to collection.
    mark.markers.push(marker);
  }
  
  // Create a polyline connected all markers.
  mark.polyline = new google.maps.Polyline({
    path: markerPositions.concat(markerPositions[0]),
    strokeWeight: 6
  });
  
  // Create a polyline connected all markers.
  mark.polygon = new google.maps.Polygon({
    path: markerPositions.concat(markerPositions[0]),
    strokeColor: '#3f3',
    strokeWeight: 1,
    fillColor: '#00f'
  });
  
  // Initially show all overlays.
  mark.toggleAllOverlays();
};

// Call the init function when the page loads.
google.maps.event.addDomListener(window, 'load', mark.init);
</script>
</head>
<body>
  <h2>Clearing overlays from a map.</h2>
  <div>
    Toggle on/off:
    <input onclick="mark.toggleMarkers();" type=button value="Markers"/>
    <input onclick="mark.togglePolyline();" type=button value="Polyline"/>
    <input onclick="mark.togglePolygon();" type=button value="Polygon"/>
    <input onclick="mark.toggleAllOverlays();" type=button value="All Overlays"/>
  </div>
  <div id="map-canvas" style="width:600px; height:500px"></div>
</body>
</html>

