<!doctype html>  

<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <title>Map Radius</title>
    <meta name="description" content="Google Map allowing a radius to be added">
    <meta name="author" content="Oliver Beattie">
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
      <script src="http://code.jquery.com/jquery-latest.js"></script>
    <style type="text/css">
        /*  Copyright (c) 2010, Yahoo! Inc. All rights reserved.
            Code licensed under the BSD License:
            http://developer.yahoo.com/yui/license.html
            version: 3.2.0
            build: 2676
        */
        html{color:#000;background:#FFF;}body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td{margin:0;padding:0;}table{border-collapse:collapse;border-spacing:0;}fieldset,img{border:0;}address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal;}li{list-style:none;}caption,th{text-align:left;}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;}q:before,q:after{content:'';}abbr,acronym{border:0;font-variant:normal;}sup{vertical-align:text-top;}sub{vertical-align:text-bottom;}input,textarea,select{font-family:inherit;font-size:inherit;font-weight:inherit;}input,textarea,select{*font-size:100%;}legend{color:#000;}
        
        /* Mine */
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; }
        div#map { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
        form#options { position: absolute; bottom: 5px; left: 100px; background: #fff; border: 1px solid #666; padding: 3px 5px; }
        form#options em { margin: 0 10px; color: #666; }
    </style>
    
    <script type="text/javascript">
       // var init = function() {
$(document).ready(function() {	
            var opts = {
                zoom: 10,
                center: new google.maps.LatLng(51.500358, -0.125506), // London
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById('map'), opts);
            
            var earthRadiuses = {
                // The radius of the earth in various units
                'mi': 3963.1676,
                'km': 6378.1,
                'ft': 20925524.9,
                'mt': 6378100,
                'in': 251106299,
                'yd': 6975174.98,
                'fa': 3487587.49,
                'na': 3443.89849,
                'ch': 317053.408,
                'rd': 1268213.63,
                'fr': 31705.3408
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
                google.maps.event.addListener(polygon, 'rightclick', polygonDestructionHandler);
                google.maps.event.addListener(polygon, 'click', polygonDrawHandler);
            }
            
            google.maps.event.addListener(map, 'click', polygonDrawHandler);
      //  }
});
    </script>
</head>

<body onload="init()">
    <div id="map"></div>
    <p id="tip">Click anywhere on the map to draw a radius circle, right-click any circle to remove it</p>
    <form id="options">
        <label for="radiusInput">Radius</label> <input type="text" value="5" id="radiusInput" name="radiusInput" />
        <label for="unitSelector">Units</label> <select id="unitSelector" name="unitSelector">
            <option value="mi">Miles</option>
            <option value="km">Kilometers</option>
            <option value="ft">Feet</option>
            <option value="mt">Metres</option>
            <option value="in">Inches</option>
            <option value="yd">Yards</option>
            <option value="fa">Fathoms</option>
            <option value="na">Nautical miles</option>
            <option value="ch">Chains</option>
            <option value="rd">Rods</option>
            <option value="fr">Furlongs</option>
        </select>
        <em>Click the map to place a circle, right click a circle to remove it</em>
    </form>
</body>
</html>
