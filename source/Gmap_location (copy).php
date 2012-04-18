<?php
include'set_session.php';
$user_id=$_SESSION['UID'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<link rel="icon" type="image/png" href="vw-beetle-icon.png">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<!--<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;
user-scalable=0;" />-->

    <title>Vehicle Tracking System</title>
 <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAEfq-J88L6W8QaeK-_jrMEBSmtvUnVE3cIil7-e0uzArV_1Eo-BQ-ci8NjtfYjDp41KfVVkgHllPC8Q" type="text/javascript"></script>


    <script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>

	<!--<script src="http://www.tritonetech.com/php_uploads/rnd/BDCCPolygon2.js" type="text/javascript"></script>-->
	<script src="http://www.bdcc.co.uk/Gmaps/BDCCPolyline.js" type="text/javascript"></script>
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="jquery-1.5.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://api.wipmania.com/wip.js"></script>
<link rel="stylesheet" media="screen" href="todolist.css" />
<script type="text/javascript" src="todolist.js"></script>
   <script type="text/javascript" src="jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="js/jquery.js" type="text/javascript"></script> 
<script src="js/jquery-fdd2div.js" type="text/javascript"></script> 
 
<script type='text/javascript'>
jQuery(function($) {
      //  $.getJSON('json.php', function(json) {
	  $.getJSON('get_vehicle.php?user_id=<?php echo $user_id;?>', function(json) {
                var select = $('#vehicle-list');
 		
                $.each(json.Result.Data, function(i, v) {
			
						
			var option = $('<option />');
			

                        option.attr('value', v.uid)
                              .html(v.alias)
                              .appendTo(select);
			
                });
        });
});
</script>

 <!--<script language="javascript">
		$('#form_wrapper').ready(function() {
		$("#vehicle-list").fdd2div();
		});
		</script>-->
<style type="text/css">
     <!--html { height: 100% }-->
     body { height: 100%; margin: 0px; padding: 0px ;}
     #map { height: 100%;width:80%;float:right; }
	#console {width:20%;float:left;
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
 padding: 60px 0 60px 0;
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
 background: #ebebeb url(border.png) no-repeat;
 color: #67a5cd;
 padding: 7px 15px 7px 30px;
} 

   </style>
<script type='text/javascript'>function get_request( name )
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
var uid=get_request('uid');
var imei=get_request('imei');
//alert(uid);
</script>


  </head>
<!--<body onload="window.scrollTo(0, 1);">-->

  <body onunload="GUnload();">
	<div id='console'>
		<!--<h1 class="simple">Console</h1>-->
		<div class='navbox'>
			<ul class='nav'>
				<li><a href="javascript:void(0)" onclick="#">home</a></li>
				<li><a href="javascript:void(0)" onclick="var datetime1 = new Array(); var datetime2 = new Array(); datetime1= document.frm.select1.value.split(' '); 					datetime2= document.frm.select2.value.split(' '); if(datetime1=='' || datetime2=='') {alert('fields missing');exit;} location.href='Gmap_history.php?date1='+datetime1[0]+'&time1='+datetime1[1]+'&date2='+datetime2[0]+'&time2='+datetime2[1]+'&uid='+uid">check history</a></li>
				<li><a href="javascript:void(0)" onclick="location.href='Gmap_fencing.php?imei='+imei">Geo fencing</a></li>
				<li><a href="javascript:void(0)" onclick="location.href='index.php?msg=3'">logout</a></li>
			</ul>
		</div>
					<fieldset><legend>select vehicle:</legend>
					<div id='form_wrapper'>
					<form method="get" action="Gmap_location.php">
					<select name="uid" id="vehicle-list">
                				<option value="this.value">Select your vehicle</option>
           					 </select>
					<input type="submit" value="GO"/>
					</form>
					</div>				
					</fieldset>
					
					<br/>
					<div id='datetime' style="float:left;">
					<form method="POST" name='frm'>
						<fieldset>
						<legend>check history</legend>
						time1:<input type="Text" id="select1" maxlength="25" size="25"><a href="javascript:NewCal('select1','ddmmyyyy',true)"><img src="images/cal.gif" 						width="20" height="16" border="0" alt="Pick a date"></a><br/><br/>
						time2:<input type="Text" id="select2" maxlength="25" size="25"><a href="javascript:NewCal('select2','ddmmyyyy',true,24)"><img src="images/cal.gif" 						width="20" height="16" border="0" alt="Pick a date"></a>
						</fieldset>
					</form>
				<br/>
				<fieldset><legend>current location:</legend><div id='text'>loading current location...</div></fieldset>
				
				</div>
		
				
		
	</div>
 
<div id="map"><center><img style="position:absolute;top:50%;left:50%;" src="./images/loader.gif"/></center></div>


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

	var point;




setInterval(function() {


            $.getJSON('latlong.php?option=2&imei='+imei, function(json) {
               $.each(json.result,function(i,gmap){
		latitude=gmap.latitude;
			longitude=gmap.longitude;
			//  alert(latitude);
			map.clearOverlays();
			//alert(point);
			if(isNaN(point) || typeof(point)=="undefined")
			{
			point=18;
			map.setCenter(new GLatLng(latitude,longitude),point);
			}	
			else
			{

			point=checkResize(point);
			marker = new GMarker(latitude,longitude);
			}

			latlng=latitude+','+longitude;

			  geocoder = new GClientGeocoder();
			geocoder.getLocations(latlng, showAddress)


		if(gmap.geo_status==1 && gmap.read_status==2 && gmap.out_range>gmap.range)
			{
			var overshot=gmap.out_range-gmap.range;
			alert('vehicle out of geo fence:'+overshot+'metres'); 

			}


 

         
      marker = new GMarker(new GLatLng(latitude,longitude));
      marker1 = new GMarker(new GLatLng(latitude,longitude),{icon:boy});
      marker2 = new GMarker(new GLatLng(latitude,longitude),{icon:car});


     marker_arry = new Array(marker,marker1,marker2);

      var mgrOptions = {maxZoom: 15, trackMarkers: true };
      var mgr = new MarkerManager(map, mgrOptions);
      mgr.addMarkers(marker_arry, 6);
      mgr.refresh();

      stepnum = 0;
      pause_stepnum = 0;
      speed = 1500;

 });
  });

        }, 5000);


function checkResize(point) {
    //  var point = map.getCenter();
	var point= map.getZoom();
	return point;

    }




function showAddress(response) {

  if (!response || response.Status.code != 200) {

  } else {
    place = response.Placemark[0];

$(document).ready(function(){
 

$("#text").html('<p>'+place.address+'</p>');

 }); 

  }
}



      function animate(d) {
         points = [
                    new GLatLng(locations[stepnum-1],longs[stepnum-1]),
                    new GLatLng(locations[stepnum],longs[stepnum])
                    ];


   polyline =new BDCCPolyline(points,"red",3,0.9,"polygon3","dot");
		   


         points1 = [
                    new GLatLng(locations[stepnum-1],longs1[stepnum-1]),
                    new GLatLng(locations[stepnum],longs1[stepnum])
                    ];


         points2 = [
                    new GLatLng(locations[stepnum-1],longs2[stepnum-1]),
                    new GLatLng(locations[stepnum],longs2[stepnum])
                    ];



         marker.setPoint(new GLatLng(locations[stepnum],longs[stepnum]));
         marker1.setPoint(new GLatLng(locations[stepnum],longs1[stepnum]));
         marker2.setPoint(new GLatLng(locations[stepnum],longs2[stepnum]));

	
         map.addOverlay(polyline);

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
  </body>
</html>

