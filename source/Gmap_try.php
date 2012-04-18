<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<!--<?php	header( 'Location: http://www.tritonetech.com/php_uploads/rnd/Gmap_location.php' ) ;	?>-->
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Dhananjay's Home AND TritoneTech</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAA7zatdDuuNbbeMyULD2yG5RQX2gm04R9FDFXzSd74lb-TAfkBGRRwjhMX1Kvf0hb7vtBJUUfnnFT-6g" type="text/javascript"></script>
    <script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>
    <script src="race.js" type="text/javascript"></script>
	<!--<script src="http://www.tritonetech.com/php_uploads/rnd/BDCCPolygon2.js" type="text/javascript"></script>-->
	<script src="http://www.bdcc.co.uk/Gmaps/BDCCPolyline.js" type="text/javascript"></script>
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<!--<script src="http://www.bdcc.co.uk/Gmaps/BDCCPolygon.js" type="text/javascript"></script>-->
	<!--<script src="arrowmaker.js" type="text/javascript"></script>-->
<!--<script type='text/javascript>
<script type="text/javascript" src="jquery-1.5.js"></script>
<script  type="text/JavaScript">
$(document).ready(function () {
    $("#map").load("Gmap_location.php");
    var refreshId = setInterval(function () {
        $("#map").load('Gmap_location.php?randval=' + Math.random());
    }, 3000);
});
  </script>
</script>-->
<!--<script type="text/javascript" src="jquery-1.5.js"></script>
<script  type="text/JavaScript">
setInterval(function() {
    $('#map').load('Gmap_location.php');
}, 5000);
  </script>-->
<script type='text/javascript'>setInterval( "showUser()", 5000 );</script>
<script type='text/javascript'>
function showUser(str)
	{
	if (str=="")
	  {
	  document.getElementById("map").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4)
	    {
	 document.getElementById("cod").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","http://www.tritonetech.com/php_uploads/rnd/location.php?option=2",true);
	xmlhttp.send();
	}
</script>
  </head>
  <body onunload="GUnload()">

   <div id="map" style="width: 1000px; height: 550px; margin:0 auto;">
	<!--<?php 
$request='http://www.tritonetech.com/php_uploads/rnd/location.php?option=2';
$json = file_get_contents($request);$jsondata = file_get_contents($request);
function json_code ($json) {
//remove curly brackets to beware from regex errors
$json = substr($json, strpos($json,'{')+1, strlen($json));
$json = substr($json, 0, strrpos($json,'}'));
$json = preg_replace('/(^|,)([\\s\\t]*)([^:]*) (([\\s\\t]*)):(([\\s\\t]*))/s', '$1"$3"$4:', trim($json));
return json_decode('{'.$json.'}', true);
}

print_r(json_code($json));?>--></div>
<!--www.tritonetech.com/php_uploads/rnd/Gmap_try.php?uid=&date=-->


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

<?php			}

?>

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

//www.tritonetech.com/php_uploads/rnd/nut.php


</script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
{
$('#map').load('Gmap_location.php').fadeIn("slow");
}, 5000); // refresh every 10000 milliseconds

/*<body>
<div id="load_tweets"> </div>
</body>*/

</script>-->

<div style="margin:0 auto; width:1000px;">
   <input type="button" id ="pause" value ="Pause" onclick ="pause()"/>
   <input type="button" id ="play" value ="Play" disabled ="true" onclick ="play()"/>
   <input type="button"  value ="Normal Speed" onclick ="speeds(1)"/>
   <input type="button"  value ="5 * Speed" onclick ="speeds(5)"/>
   <input type="button"  value ="10 * Speed" onclick ="speeds(10)"/>
	<input type="button"  value ="refresh" onclick ="showUser()"/>

</div>
<div id="cod" style="width: 1000px; height: 20px; margin:0 auto;"></div>
  </body>
<?php
function get_tag( $attr, $value, $xml ) {

        $attr = preg_quote($attr);
        $value = preg_quote($value);

        $tag_regex = '/<div[^>]*'.$attr.'="'.$value.'">(.*?)<\\/div>/si';

        preg_match($tag_regex,
        $xml,
        $matches);
        return $matches[1];
    }

    $yourentirehtml = file_get_contents("location_try.php");
    $extract = get_tag('id', 'cod', $yourentirehtml);
    var_dump($extract);
?>
<!--<script type="text/JavaScript">

function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}
//
</script>
<body onload="JavaScript:timedRefresh(10000);">-->
<!--<script type="text/JavaScript">
$("#map").load("/Gmap_location.php", function(response, status, xhr) {
/*  if (status == "error") {
    var msg = "Sorry but there was an error: ";
    $("#error").html(msg + xhr.status + " " + xhr.statusText);
  }*/
});
  </script>-->





