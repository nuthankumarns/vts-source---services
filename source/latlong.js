<?php
header("Content-type: application/x-javascript");?>
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
<?php
$request='http://www.tritonetech.com/php_uploads/rnd/location_try.php?option=2';
$json = file_get_contents($request);
function json_code ($json) {
//remove curly brackets to beware from regex errors
$json = substr($json, strpos($json,'{')+1, strlen($json));
$json = substr($json, 0, strrpos($json,'}'));
$json = preg_replace('/(^|,)([\\s\\t]*)([^:]*) (([\\s\\t]*)):(([\\s\\t]*))/s', '$1"$3"$4:', trim($json));
return json_decode('{'.$json.'}', true);
}

//echo "<pre>";
$convertedtoarray = json_code($json);

//print_r($convertedtoarray);
$latitude[]=$convertedtoarray['latitude'];
print_r($latitude);
$longitude[]=$convertedtoarray['longitude'];
print_r($longitude);
$count='1';?>
      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(<?php echo $latitude[0];?>,<?php echo $longitude[0];?>),12);

      marker = new GMarker(new GLatLng(<?php echo $latitude[0];?>,<?php echo $longitude[0];?>));
      marker1 = new GMarker(new GLatLng(<?php echo $latitude[0];?>,<?php echo $longitude[0];?>),{icon:boy});
      marker2 = new GMarker(new GLatLng(<?php echo $latitude[0];?>,<?php echo $longitude[0];?>),{icon:car});
  //marker_arry = new Array(marker2);
     marker_arry = new Array(marker,marker1,marker2);


      var mgrOptions = {maxZoom: 15, trackMarkers: true };
      var mgr = new MarkerManager(map, mgrOptions);
      mgr.addMarkers(marker_arry, 6);
      mgr.refresh();
 /*$lat=12.999247;
	$lng=77.568276;*/
      stepnum = 0;
      pause_stepnum = 0;
      speed = 1500;
 locations = new Array();
longs = new Array();
longs1 = new Array();
longs2 = new Array();

<?php for($i=0;$i<$count;$i++)
			{
			//$latitude[$i]=CLS_MYSQL::GetResultValue($this->query,$i,'latitude');
			//$longitude[$i]=CLS_MYSQL::GetResultValue($this->query,$i,'longitude');
			?>

locations[<?php echo $i;?>] = <?php echo $latitude[$i];?>;
longs[<?php echo $i;?>] = <?php echo $longitude[$i];?>;
longs1[<?php echo $i;?>] = <?php echo $longitude[$i];?>;
        longs2[<?php echo $i;?>] =<?php echo $longitude[$i];?>;

<?php			}?>

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

         polyline = new GPolyline(points, '#ff0000', 2, 0.7);
//BDCCPolyline(points, color, weight, opacity, tooltip, dash)
//KMPolyline(points, color, weight, opacity, tooltip, dash)
//polyline =new KMPolyline(points,'#00007F',5,0.9,'polygon3','dotted');
//polyline = new ArrowMarker(points, '0', 'red', 0.7, 'polygon1')
  // polyline =new BDCCPolyline(points,"red",3,0.9,"polygon3","dot");
		   // polyline = new GPolyline([], "#DC143C", 4, 1.0);


         points1 = [
                    new GLatLng(locations[stepnum-1],longs1[stepnum-1]),
                    new GLatLng(locations[stepnum],longs1[stepnum])
                    ];

        // polyline1 = new GPolyline(points1, 'green', 5, 0.7);
//polyline1 =new KMPolyline(points1,'#00007F',5,0.9,'polygon3','solid');
         points2 = [
                    new GLatLng(locations[stepnum-1],longs2[stepnum-1]),
                    new GLatLng(locations[stepnum],longs2[stepnum])
                    ];

        // polyline2 = new GPolyline(points2, 'yellow', 5, 0.7);
//polyline2 =new KMPolyline(points2,'#00007F',5,0.9,'polygon3','solid');
         /*
         if( (longs[stepnum] > longs1[stepnum]) && (longs[stepnum] > longs2[stepnum]) ) {
             if( longs1[stepnum] > longs2[stepnum]) {
                final_longs = longs1[stepnum];
             } else {
                final_longs = longs2[stepnum];
             }
         }
         */
       /* if(stepnum == 10){
         map.setCenter(new GLatLng(51.51453,-3.038235),12);
        }*/

         marker.setPoint(new GLatLng(locations[stepnum],longs[stepnum]));
         marker1.setPoint(new GLatLng(locations[stepnum],longs1[stepnum]));
         marker2.setPoint(new GLatLng(locations[stepnum],longs2[stepnum]));

		/*GEvent.addListener(marker, "dragend", function() {
		  marker.openInfoWindowHtml("Just bouncing along...");
		  });*/

         map.addOverlay(polyline);

         //map.addOverlay(polyline1);
         //map.addOverlay(polyline2);

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


	/*function refreshData()
	{
  // Load the content of "path/to/script.php" into an element with ID "#container".
  $('#map').load('www.tritionetech.com/php_uploads/nut.php');
	}

	// Execute every 5 seconds
	window.setInterval(refreshData, 5000);*/

    }
   else
   {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }

