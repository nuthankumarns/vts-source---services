<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Affiliate App</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAA3X5VF_hOxssS91v5NtopWBR_OkPTBJaDFcunIJbtiTk6tLrwQRQAId5af7DsyKT5HZSZcyP-xEL5qQ" type="text/javascript"></script>
    <script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>
    <script src="race.js" type="text/javascript"></script>
  </head>
  <body onunload="GUnload()">
 
   <div id="map" style="width: 550px; height: 550px"></div>
 
 
    <script type="text/javascript">
    if (GBrowserIsCompatible()) {
     var boy = new GIcon();
         boy.image="user.png"
         boy.iconSize=new GSize(32,18);
         boy.iconAnchor=new GPoint(16,9);
 
     var car = new GIcon();
         car.image="caricon.png"
         car.iconSize=new GSize(32,18);
         car.iconAnchor=new GPoint(16,9);
 
      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(51.49453,-3.038235),12);
 
      marker = new GMarker(new GLatLng(51.450691,-3.094368));
      marker1 = new GMarker(new GLatLng(51.450691,-3.094368),{icon:boy});
      marker2 = new GMarker(new GLatLng(51.450691,-3.094368),{icon:car});
 
      marker_arry = new Array(marker,marker1,marker2);
 
 
      var mgrOptions = {maxZoom: 15, trackMarkers: true };
      var mgr = new MarkerManager(map, mgrOptions);
      mgr.addMarkers(marker_arry, 6);
      mgr.refresh();
 
      stepnum = 0;
      pause_stepnum = 0;
      speed = 1500;
      locations = new Array();
      locations[0] = 51.450691;
      locations[1] = 51.460691;
      locations[2] = 51.470691;
      locations[3] = 51.480691;
      locations[4] = 51.490691;
      locations[5] = 51.500691;
      locations[6] = 51.510691;
      locations[7] = 51.520691;
      locations[8] = 51.530691;
      locations[9] = 51.540691;
      locations[10] = 51.550691;
      locations[11] = 51.560691;
 
      longs = new Array();
      longs[0] = -3.094368;
      longs[1] = -3.084368;
      longs[2] = -3.087668;
      longs[3] = -3.074368;
      longs[4] = -3.064368;
      longs[5] = -3.062368;
      longs[6] = -3.054368;
      longs[7] = -3.043468;
      longs[8] = -3.034368;
      longs[9] = -3.030368;
      longs[10] = -3.024368;
      longs[11] = -3.014368;
 
      longs1 = new Array();
      longs1[0] = -3.094368;
      longs1[1] = -3.085068;
      longs1[2] = -3.089068;
      longs1[3] = -3.077068;
      longs1[4] = -3.079068;
      longs1[5] = -3.069068;
      longs1[6] = -3.050268;
      longs1[7] = -3.040468;
      longs1[8] = -3.033068;
      longs1[9] = -3.039068;
      longs1[10] = -3.028368;
      longs1[11] = -3.014368;
 
      longs2 = new Array();
      longs2[0] = -3.094368;
      longs2[1] = -2.939999;
      longs2[2] = -2.969999;
      longs2[3] = -2.979900;
      longs2[4] = -2.981100;
      longs2[5] = -2.999900;
      longs2[6] = -2.971100;
      longs2[7] = -2.969900;
      longs2[8] = -2.951100;
      longs2[9] = -2.939900;
      longs2[10] = -2.921100;
      longs2[11] = -3.014368;
      /*
      points = [
      new GLatLng(locations[0],longs[0]),
      new GLatLng(locations[1],longs[1])
      ];
      polyline = new GPolyline(points, '#ff0000', 5, 0.7);
      */
      //marker = new GMarker(new GLatLng(51.49453,-3.038235));
      //map.addOverlay(marker);
      //map.addOverlay(polyline);
      function animate(d) {
         points = [
                    new GLatLng(locations[stepnum-1],longs[stepnum-1]),
                    new GLatLng(locations[stepnum],longs[stepnum])
                    ];
 
         polyline = new GPolyline(points, '#ff0000', 5, 0.7);
 
         points1 = [
                    new GLatLng(locations[stepnum-1],longs1[stepnum-1]),
                    new GLatLng(locations[stepnum],longs1[stepnum])
                    ];
 
         polyline1 = new GPolyline(points1, 'green', 5, 0.7);
 
         points2 = [
                    new GLatLng(locations[stepnum-1],longs2[stepnum-1]),
                    new GLatLng(locations[stepnum],longs2[stepnum])
                    ];
 
         polyline2 = new GPolyline(points2, 'yellow', 5, 0.7);
         /*
         if( (longs[stepnum] > longs1[stepnum]) && (longs[stepnum] > longs2[stepnum]) ) {
             if( longs1[stepnum] > longs2[stepnum]) {
                final_longs = longs1[stepnum];
             } else {
                final_longs = longs2[stepnum];
             }
         }
         */
        if(stepnum == 10){
         map.setCenter(new GLatLng(51.51453,-3.038235),12);
        }
 
         marker.setPoint(new GLatLng(locations[stepnum],longs[stepnum]));
         marker1.setPoint(new GLatLng(locations[stepnum],longs1[stepnum]));
         marker2.setPoint(new GLatLng(locations[stepnum],longs2[stepnum]));
 
         map.addOverlay(polyline);
         map.addOverlay(polyline1);
         map.addOverlay(polyline2);
 
         stepnum++;
         if(stepnum<locations.length)
         setTimeout("animate(0)",speed);
 
      }
      stepnum++;
      setTimeout("animate(0)",3000);
 
      function pause() {
          pause_stepnum = stepnum;
          stepnum = 0;
          document.getElementById('play').disabled= false;
          document.getElementById('pause').disabled= true;
      }
      function play() {
          stepnum = pause_stepnum;
          animate(0);
          document.getElementById('play').disabled= true;
          document.getElementById('pause').disabled= false;
      }
      function speeds(fast) {
          switch(fast) {
              case 1:
                      speed = 1500;
                      break;
              case 5:
                      speed = 1000;
                      break;
              case 10:
                      speed = 300;
                      break;
          }
      }
 
    }
   else
   {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }
 
   </script>
   <input type="button" id ="pause" value ="Pause" onclick ="pause()"/>
   <input type="button" id ="play" value ="Play" disabled ="true" onclick ="play()"/>
   <input type="button"  value ="Normal Speed" onclick ="speeds(1)"/>
   <input type="button"  value ="5 * Speed" onclick ="speeds(5)"/>
   <input type="button"  value ="10 * Speed" onclick ="speeds(10)"/>
  </body>
 
</html>


