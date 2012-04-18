<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAEfq-J88L6W8QaeK-_jrMEBSmtvUnVE3cIil7-e0uzArV_1Eo-BQ-ci8NjtfYjDp41KfVVkgHllPC8Q" type="text/javascript"></script>
<style type="text/css" media="screen">
img { border: 0; }
#map{
width: 800px;
height: 500px;
border:solid red 1px;
}
#content {
position: fixed;
top: 10px;
left: 800px;
margin: 30px;
}
</style>
<script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>


  <script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
//var infoWindow = new google.maps.InfoWindow({});
var markers = new Array(); 
locations=(["13.040391666667","77.557393333333"]);
//console.log(locations[0]);
//console.log(locations[1]);
//console.log(locations);
console.log(locations.length);
function setMarkers(map, locations, areaId) {
     for(var i = 0; i < locations.length; i++) {
         var Location = locations[i];
	console.log(locations[i]);
         var latlng = new google.maps.LatLng(location.Location[0], location.Location[1]);
         var marker = new google.maps.Marker({
             position: latlng,
             map: map,
             shadow: createMarkerShadow(location.MarkerShadow),
             icon: createMarkerImage(location.MarkerImage),
             shape: markerShape,
             title: location.Name
         });
         marker.set('location', location);
         google.maps.event.addListener(marker, "click", function(event) {
            var area = this.get('location');
            var infoWindowHtml = parseTemplate($("#MarkerTemplate").html(), { location : location} );
            infoWindow.setContent(infoWindowHtml);
            infoWindow.open(map, this);
         });
         markers.push(marker);
     }
}

function clearMarkers() {
     infoWindow.close();
     for(var i = 0; i < markers.length; i++) {
         markers[i].setMap(null);
     }
     markers.length = 0;
}
</script>
</head>
<body>
<div id='map'></div>
</body>
</html>
