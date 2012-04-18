<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='http://fonts.googleapis.com/css?family=Walter+Turncoat' rel='stylesheet' type='text/css'>
<link rel="icon" type="image/png" href="vw-beetle-icon.png">
<link rel="stylesheet" href="jquery.alerts.css"/>
<link rel="stylesheet" href="style.css"/>
    <title>Vehicle Tracking System</title>
<script language="JavaScript">
javascript:window.history.forward(1);
</script>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAEfq-J88L6W8QaeK-_jrMEBSmtvUnVE3cIil7-e0uzArV_1Eo-BQ-ci8NjtfYjDp41KfVVkgHllPC8Q" type="text/javascript"></script>
 <!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>-->
   <script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>
   <!-- <script src="race.js" type="text/javascript"></script>-->
	<!--<script src="http://www.tritonetech.com/php_uploads/rnd/BDCCPolygon2.js" type="text/javascript"></script>-->
	<script src="http://www.bdcc.co.uk/Gmaps/BDCCPolyline.js" type="text/javascript"></script>
<?php include'set_session.php'; $user_id=$_SESSION['UID'];?>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></script>

  <script src="http://code.jquery.com/jquery-latest.js"></script>
 <script src="jquery.alerts.js"></script>
<link rel="stylesheet" media="screen" href="todolist.css" />

<!--<style type="text/css">
     
         body { height: 100%; margin: 0px; padding: 0px ;}
     #map { height: 100%;width:80%;float:right; }
	#console {width:20%;float:left; }
	2* { margin:0;
 padding:0;
}

html {height: 100%;}

body{
 position: relative;
 height: 100%;
 background: -webkit-gradient(linear, left top, left bottom, from(#ccc), to(#fff));

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
 padding: 20px 0 20px 0;
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
fieldset { border:4px solid #333333; }
legend {
  padding: 0.2em 0.5em;
  border:1px solid green;
  color:green;
  font-size:90%;
  text-align:right;
  }
   </style>-->
<!--<script type='text/javascript'>
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

var id=get_request('id');
//alert(id);
</script>-->

  </head>
  <body>
<div id='console' style="width: 285px; height: 715px;"> <!-- <h1 class="simple text_change">Console</h1> -->
<div class='navbox'>
<ul class='nav'>
	<li><a href="javascript:void(0)" onclick="location.href='Gmap_location.php'">Home</a></li>
	<!--<li><a href="javascript:void(0)" onclick="parse_datetime();">Check History</a></li>-->
	<li><a href='javascript:void(0)' onclick="play()">Play</a></li>
	<li><a href='javascript:void(0)' onclick ="pause()">Pause</a></li>
	<li><a href='javascript:void(0)' onclick ="speeds(1)">Normal Speed</a></li>
	<!--<li><a href='javascript:void(0)' onclick ="speeds(5)">speed(5)</a></li>-->
	<li><a href='javascript:void(0)' onclick ="speeds(10)">High Speed</a></li>
	<li><a href='javascript:void(0)' onclick="location.href='log_out.php'">Logout</a></li>
	</ul>
</div>

	<div id='detail' style="clear: both;"><div id='speed'>loading...</div></div><br>
				<div id='datetime' style="float:left; margin-left: 28px; clear: both;">
					<form method="POST" name='frm'>
						<!--<fieldset>
						<legend>check history</legend>-->
				From Date:&nbsp;&nbsp;&nbsp;<input type="text" id="select1" maxlength="25" size="20" disabled><a href="javascript:NewCal('select1','ddmmyyyy',true)"><img src="images/cal.gif" 						width="20" height="16" border="0" alt="Pick a date"></a><br/><br/>
				To Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="select2" maxlength="25" size="20" disabled><a href="javascript:NewCal('select2','ddmmyyyy',true,24)"><img src="images/cal.gif" 						width="20" height="16" border="0" alt="Pick a date"></a><br><br>
		<input type="button" onclick="parse_datetime();" value="Check History">
						<!--</fieldset>-->
				
					</form>
				</div>
			

</div>

   <div id="map" style="width: 81%; height: 725px;"><div id="initial"><script>jAlert('Select date,time and click Check History.', 'Alert');</script></div></div>

<div id="loaddiv">




</div>

<script type='text/javascript'>
	//var init = function() {
	
$(document).ready(function() {

 $.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
			//console.log(json);
               $.each(json.result,function(i,gmap){
			console.log(gmap);
		latitude=gmap.latitude;
			longitude=gmap.longitude;
			vel=gmap.velocity;
			last_update=gmap.Server_IST;
			alias=gmap.alias;
		$("#speed").html('<b>Vehicle Name:</b>'+gmap.alias+'<br>');
 });
  });
/*if (GBrowserIsCompatible()) {



      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());

	var point;



setInterval(function() {


            $.getJSON('web_services/latlong.php?option=2&id='+id, function(json) {
			//console.log(json);
               $.each(json.result,function(i,gmap){
			
		latitude=gmap.latitude;
			longitude=gmap.longitude;
			vel=gmap.velocity;
			last_update=gmap.Server_IST;

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
			map.setCenter(new GLatLng(latitude,longitude),point);

			}

			latlng=latitude+','+longitude;

			  geocoder = new GClientGeocoder();
			geocoder.getLocations(latlng, showAddress)

			
		
	var carIcon = new GIcon(G_DEFAULT_ICON);
carIcon.image = "vw-beetle-icon.png";

markerOptions = { icon:carIcon };
		
		  marker = new GMarker(new GLatLng(latitude,longitude),markerOptions);

	 marker_arry = new Array(marker);
      var mgrOptions = {maxZoom: 10, trackMarkers: true };
      var mgr = new MarkerManager(map, mgrOptions);
//		icon:image
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
	  }
	}



}
   else
   {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }*/
	

//alert(gup('date1'));
//$(document).ready(function() {	
	var image = 'vw-beetle-icon.png';


});
function parse_datetime()
{
var datetime1 = new Array(); 

var datetime2 = new Array(); 
datetime1= document.frm.select1.value.split(' ');

datetime2= document.frm.select2.value.split(' '); 

if(datetime1=='' || datetime2=='') 
{jAlert('please select Duration!!!', 'Alert');
//alert('please select Duration!!!');
exit;}
var date1=datetime1[0];
var time1=datetime1[1];
var date2=datetime2[0]
var time2=datetime2[1]

/*var date1=get_request('date1');
var date2=get_request('time1');
var time1=get_request('date2');
var time2=get_request('time2');*/
$('#loaddiv').load('latlong1.php', "date1="+date1+"&time1="+time1+"&date2="+date2+"&time2="+time2+"&id="+id+"&option=1",function(response, status, xhr) {
	console.log(response);
	console.log(status);
	console.log(xhr);
 /* if (status == "error") {
    var msg = "Sorry but there was an error: ";
   // $("#error").html(msg + xhr.status + " " + xhr.statusText);
	//console.log(msg + xhr.status + " " + xhr.statusText);
  }*/
	});
}
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

var id=get_request('id')
</script>

  </body>


<!--<script type="text/JavaScript">
'date1=12-07-2011&time1=11:30:05&date2=12-07-2011&time2=13:30:15&uid=12&option=1
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


</html>




