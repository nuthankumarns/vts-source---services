<?php
header("Content-type: application/x-javascript");
header("Cache-Control: no-cache, must-revalidate");
echo "<script type='text/javascript'>";

?>

<?php
include'config.php';
include'httprequest.php';
//include'latlong.php';

class vehicleTrack extends DB_Mysql
{
	var $latitude=array(),$longitude=array();
	/*constructor eating mysql link*/
	function initiate()
	{
	$var=new HTTPrequest();
	$date=$var->get('date');
	$id=$var->get('id');
	$imei = $var->get('imei');
	$time1	=$var->get('time1');
	$date1	=$var->get('date1');
	$time2	=$var->get('time2');
	$date2	=$var->get('date2');
	//$this->traceRoute($latitude,$longitude,$count);
	//$this->getLatLong($date,$uid);
	//$this->currentLocation($uid);
	$this->logDetails($date1,$time1,$date2,$time2,$id);
	}


	function makeTimestamp($date,$time)
	{
		//echo $date."<br>";
		//echo $time."<br>";
		
		$date=explode("-",$date);
		$time=explode(":",$time);
		//print_r($date);print_r($time);exit();
		$H=$time[0];//hour
		$i=$time[1];//min
		$s=$time[2];//sec
		$n=$date[1];//month
		$j=$date[0];//date
		$y=$date[2];//year
		/*$h =  strtotime($time);

		$H=date("H", $h);//echo $H;echo "<br/>";
		$i=date("i", $h);//echo $i;echo "<br/>";
		$s=date("s", $h);//echo $s;echo "<br/>";


		$d = strtotime($date);
		$n=date("n", $d);//echo $n;echo "<br/>";
		$j=date("j", $d);//echo $j;echo "<br/>";
		$y=date("Y", $d);//echo $y;echo "<br/>";*/
		//$Y='20'.$y;

	$timestamp=mktime($H,$i,$s,$n,$j,$y);
	//echo $timestamp;
	// date("d-m-y H:i:s",$timestamp);exit();
		
	/*echo $timestamp;
	echo "<br/>";
	echo date('H:i:s n-j-Y',$timestamp);
	echo "<br/>";
	//echo mktime(03,33,28,07,07,2011);
	echo "<br/>";
	//echo time();
	echo "<br/>";
	echo date('d m y h:i:s',time()-1800);
	exit();*/
	return $timestamp;
	//H i s n j Y

	}

	function logDetails($date1,$time1,$date2,$time2,$id)
	{
	//$uid='12';
	$delay=$this->localTime($id);
	//$delay=19800;
	$Timestamp1=$this->makeTimestamp($date1,$time1);
	$Timestamp2=$this->makeTimestamp($date2,$time2);
	$Timestamp1=$Timestamp1+$delay;
	$Timestamp2=$Timestamp2+$delay;
	$query =CLS_MYSQL::Query("SELECT * FROM track_data where activity BETWEEN '$Timestamp1' AND '$Timestamp2' AND device_id='$id'");
	//echo "SELECT * FROM track_data where activity BETWEEN '$Timestamp1' AND '$Timestamp2' AND device_id='$id'";
	//exit();
	$count=CLS_MYSQL::GetResultNumber($query);
//echo $count;
		if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="No data";
	//	echo "alert('No history');</script>";
		echo "jAlert('No history', 'Alert');</script>";
		exit();
		}
		else
		{
				for($i=0;$i<$count;$i++)
				{
		 //$dataDB['Result']['Data'][$i]['uid'] = CLS_MYSQL::GetResultValue($this->query,$i,'uid');
			 $latitude[$i] = CLS_MYSQL::GetResultValue($query,$i,'latitude');
				 $longitude[$i] = CLS_MYSQL::GetResultValue($query,$i,'longitude');
					// $dataDB['Result']['Data'][$i]['date_time'] = CLS_MYSQL::GetResultValue($query,$i,'date_time');
				}
			}
	//var_dump($latitude);
	$this->traceRoute($latitude,$longitude,$count);
	}

	function localTime($id)
	{
	$query=CLS_MYSQL::Query("SELECT a.secondsDiff FROM gmt_zones AS a LEFT JOIN user_devices AS b ON a.id=b.offset WHERE b.id='$device_id'");
	//echo "SELECT a.*,b.* FROM gmt_zones AS a LEFT JOIN user_devices AS b ON a.id=b.offset WHERE b.id='$device_id'";
	$result=CLS_MYSQL::GetResultValue($query,0,'secondsDiff');
	return $result;

	}

	/*function currentLocation($uid)
	{
	$loc=CLS_MYSQL::Query("SELECT UTC FROM gprs WHERE uid='12' ORDER BY UTC DESC LIMIT 1");
	$count=CLS_MYSQL::GetResultNumber($loc);
	//echo $count;
	if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="No data";

		}
		else
		{
		$UTC=CLS_MYSQL::GetResultValue($loc,0,'UTC');
		$query=CLS_MYSQL::Query("SELECT  avg( t1.velocity ) AS avg_speed, t2.velocity as cur_speed,t2.*
						FROM gprs AS t1
						INNER JOIN gprs AS t2 ON t1.UTC
						BETWEEN $UTC-3600
						AND $UTC
						WHERE t2.UTC =$UTC AND t2.uid='12'");
		}
		//$this->traceRoute($latitude,$longitude,$count);
	}*/

	/*function getLatLong($date,$uid)
	{

	//for($i=0;$i<time();$i++)
		//{
	$query =CLS_MYSQL::Query("SELECT uid, latitude, longitude FROM gprs where uid='12' ORDER BY UTC DESC LIMIT 15");
		//$this->query=CLS_MYSQL::Query("SELECT latitude,longitude FROM gprs where uid='12' AND date_time LIKE '%06-07-11%' order by gid");
		//}
		$count=CLS_MYSQL::GetResultNumber($query);
		//echo $count;
		if($count!=0)
		{
			for($i=0;$i<$count;$i++)
				{
		 $latitude[$i] = CLS_MYSQL::GetResultValue($query,$i,'latitude');
				 $longitude[$i] = CLS_MYSQL::GetResultValue($query,$i,'longitude');

				}
		$latitude=array_reverse($latitude);
		$longitude=array_reverse($longitude);
	//var_dump($latitude);
		$this->traceRoute($latitude,$longitude,$count);

		}

	}*/

	function traceRoute($latitude,$longitude,$count)
	{
		{
			?>
if (GBrowserIsCompatible()) {

   
      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(<?php echo $latitude[0];?>,<?php echo $longitude[0];?>),15);

	var carIcon = new GIcon(G_DEFAULT_ICON);
	carIcon.image = "vw-beetle-icon.png";
		        
	// Set up our GMarkerOptions object
	markerOptions = { icon:carIcon };
      marker = new GMarker(new GLatLng(<?php echo $latitude[0];?>,<?php echo $longitude[0];?>),markerOptions);
       marker_arry = new Array(marker);
   


      var mgrOptions = {maxZoom: 15, trackMarkers: true };
      var mgr = new MarkerManager(map, mgrOptions);
      mgr.addMarkers(marker_arry, 6);
      mgr.refresh();

      stepnum = 0;
      pause_stepnum = 0;
      speed = 1500;
 locations = new Array();
longs = new Array();
longs1 = new Array();
longs2 = new Array();

<?php for($i=0;$i<$count;$i++)
			{

			?>

locations[<?php echo $i;?>] = <?php echo $latitude[$i];?>;
longs[<?php echo $i;?>] = <?php echo $longitude[$i];?>;
longs1[<?php echo $i;?>] = <?php echo $longitude[$i];?>;
        longs2[<?php echo $i;?>] =<?php echo $longitude[$i];?>;

<?php			}

?>


      
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



         marker.setPoint(new GLatLng(locations[stepnum],longs[stepnum]));
        



         map.addOverlay(polyline);

        
         stepnum++;
         if(stepnum<locations.length)
         setTimeout("animate(0)",speed);
		console.log(locations.length);
		console.log(stepnum);
		if(locations.length==stepnum)
		{
		jAlert('History Tracking Finished', 'Alert');
		}
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




<?php	}}}?>

<?php





$latlong=new vehicleTrack();
$latlong->initiate();


?>
	
    
<?php  echo "</script>"; 
?>
