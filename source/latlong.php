<?php
include'config.php';
include'httprequest.php';
//include'latlong.php';
include'set_session.php';
class vehicleTrack extends DB_Mysql
{
	var $latitude=array(),$longitude=array(),$var,$data;
	/*constructor eating mysql link*/
	function initiate()
	{
	$var=new HTTPrequest();
	$date=$var->get('date');
	//$uid=$var->get('uid');
	$time1	=$var->get('time1');
	$date1	=$var->get('date1');
	$time2	=$var->get('time2');
	$date2	=$var->get('date2');
	$option =$var->get('option');
	$user_id=$_SESSION['UID'];
	$imei=$var->get('imei');
	$lat_ref=$var->get('lat_ref');
	$long_ref=$var->get('long_ref');
	$range=$var->get('range');
	if($option==1)
	{
	$this->logDetails($date1,$time1,$date2,$time2,$uid);
		
	}
	elseif($option==2)
	{
	$this->currentLocation($imei);
	}
	elseif($option==3)
	{
	$this->checkPoint($lat_ref,$long_ref,$imei,$range);
	}
	//$this->traceRoute($latitude,$longitude,$count);
	//$this->getLatLong($date,$uid);
	//
	//$this->logDetails($date1,$time1,$date2,$time2,$uid);
	//$this->traceRoute($latitude,$longitude,$count);
	//$this->getLatLong($date,$uid);
	}


	function makeTimestamp($date,$time)
	{
		$h =  strtotime($time);

		$H=date("H", $h);//echo $H;echo "<br/>";
		$i=date("i", $h);//echo $i;echo "<br/>";
		$s=date("s", $h);//echo $s;echo "<br/>";


		$d = strtotime($date);
		$n=date("n", $d);//echo $n;echo "<br/>";
		$j=date("j", $d);//echo $j;echo "<br/>";
		$y=date("Y", $d);//echo $y;echo "<br/>";
		//$Y='20'.$y;

	$timestamp=mktime($H,$i,$s,$n,$j,$y);
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

	/*function getImei($user_id)
	{
	//var_dump($user_id);
	$query=CLS_MYSQL::Query("SELECT uid FROM user_devices WHERE user_id='$user_id'");
		$count=CLS_MYSQL::GetResultNumber($query);
	//echo $count;
		for($i=0;$i<$count;$i++)
		{
		$uids[$i]=CLS_MYSQL::GetResultValue($query,$i,'uid');
		}
	//print_r($uids);
	return $uids;
	//print_r($uid);
	}

	function logDetails($date1,$time1,$date2,$time2,$uid)
	{
	//$uid='12';
	$Timestamp1=$this->makeTimestamp($date1,$time1);
	$Timestamp2=$this->makeTimestamp($date2,$time2);
	$query =CLS_MYSQL::Query("SELECT uid, latitude, longitude,FROM_UNIXTIME(UTC) AS date_time FROM gprs where UTC BETWEEN '$Timestamp1' AND '$Timestamp2' AND uid='$uid'");
	$count=CLS_MYSQL::GetResultNumber($query);
//echo $count;
		if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="No data";
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
	}*/

	function currentLocation($imei)
	{
//var_dump($imei);
		$delay=19800;
	$query=CLS_MYSQL::Query("SELECT latitude,longitude,activity,velocity FROM track_data WHERE imei='$imei' ORDER BY activity DESC LIMIT 1");
//var_dump($query);
	$count=CLS_MYSQL::GetResultNumber($query);
	//echo $count;
	if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="No data";

		}
		else
		{
//imei 	latitude 	longitude 	activity 	velocity
for($i=0;$i<$count;$i++)
	{
		$data['result'][$i]['latitude'] = CLS_MYSQL::GetResultValue($query,0,'latitude');
					 $data['result'][$i]['longitude'] = CLS_MYSQL::GetResultValue($query,0,'longitude');
				//$geo_status = CLS_MYSQL::GetResultValue($query,0,'geo_status');
				//$out_range = CLS_MYSQL::GetResultValue($query,0,'out_range');
				//$read_status = CLS_MYSQL::GetResultValue($query,0,'read_status');
				//$alias = CLS_MYSQL::GetResultValue($query,0,'alias');
				//$range = CLS_MYSQL::GetResultValue($query,0,'range');
				$data['result'][$i]['velocity'] = CLS_MYSQL::GetResultValue($query,0,'velocity');
				$current=$delay+CLS_MYSQL::GetResultValue($query,0,'activity');
				$data['result'][$i]['last_update'] = date("D-M-Y H:i:s",$current);
}
		}
		//$this->traceRoute($latitude,$longitude,$count);
		if($data=='')
		{
		$data['result'][0]['status'] = "No data";
		$this->display($data);
		}

		$this->display($data);

	}

	function checkPoint($lat_ref,$long_ref,$imei,$range)
	{

		$query=CLS_MYSQL::Query("SELECT latitude,longitude FROM track_data WHERE imei='$imei' ORDER BY activity DESC LIMIT 1");
		$latitude=CLS_MYSQL::GetResultValue($query,0,'latitude');
		$longitude=CLS_MYSQL::GetResultValue($query,0,'longitude');
		$distance=$this->distance($latitude,$longitude,$lat_ref,$long_ref,'M');
		echo $distance;
		echo $range;
		var_dump($imei);
		echo "UPDATE user_devices SET lat_ref='$lat_ref',long_ref='$long_ref',range='$range',out_range='',geo_status='1',read_status='1' WHERE uid='$imei'";
		//$query=CLS_MYSQL::Execute("UPDATE user_devices SET lat_ref='$lat_ref',long_ref='$long_ref',range='$range',out_range='',geo_status='1',read_status='1' WHERE uid='$imei'");
		$dataDB['Result']['Data'][0]['Status']=($query==true)?"geo_fensing success":"geo_fensing failure";
		if($distance>$range)
		{
		$dataDB['Result']['Data'][0]['alert']="vehicle out of location";
		//echo "me";
		}
		
	$this->display($dataDB);
		
	}

	function distance($lat1, $lon1, $lat2, $lon2, $unit) {

	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);

	  if ($unit == "K")
	  {
	  return ($miles * 1.609344);
	  }
		  else if ($unit == "N")
		  {
		  return ($miles * 0.8684);
		  }
			  elseif($unit=="M")
			  {
			return ($miles * 1609.344);
			  }
				else return $miles;
				      }

/*	function getLatLong($user_id)
	{
	$uids=$this->getImei($user_id);
	//for($i=0;$i<time();$i++)
		//{
	//print_r($uids);
		
for($i=0;$i<count($uids);$i++)
	{
	$query =CLS_MYSQL::Query("SELECT a.uid, a.latitude, a.longitude,b.geo_status,b.out_range,b.range,b.read_status,b.alias FROM track_data AS a LEFT JOIN user_devices AS b ON a.uid=b.uid where b.uid='$uids[$i]' ORDER BY track_data DESC LIMIT 1");
		//$this->query=CLS_MYSQL::Query("SELECT latitude,longitude FROM gprs where uid='12' AND date_time LIKE '%06-07-11%' order by gid");
		//}
		$count=CLS_MYSQL::GetResultNumber($query);
		//echo $count;
		/*if($count!=0)
		{
			for($i=0;$i<$count;$i++)
				{*/
	/*	 $latitude = CLS_MYSQL::GetResultValue($query,0,'latitude');
				 $longitude = CLS_MYSQL::GetResultValue($query,0,'longitude');
			$geo_status = CLS_MYSQL::GetResultValue($query,0,'geo_status');
			$out_range = CLS_MYSQL::GetResultValue($query,0,'out_range');
			$read_status = CLS_MYSQL::GetResultValue($query,0,'read_status');
			$alias = CLS_MYSQL::GetResultValue($query,0,'alias');
			$range = CLS_MYSQL::GetResultValue($query,0,'range');

				//}
		//$latitude=array_reverse($latitude);
		//$longitude=array_reverse($longitude);
	//var_dump($latitude);
	
			
			//$latitude[0]=CLS_MYSQL::GetResultValue($this->query,0,'latitude');
			//$longitude[0]=CLS_MYSQL::GetResultValue($this->query,0,'longitude');
	//for($i=0;$i<$count;$i++)
	//{
	$data['result'][$i]['latitude']=$latitude;
	$data['result'][$i]['longitude']=$longitude;
	$data['result'][$i]['geo_status']=$geo_status;
	$data['result'][$i]['out_range']=$out_range;
	$data['result'][$i]['range']=$range;
	$data['result'][$i]['read_status']=$read_status;
	$data['result'][$i]['alias']=$alias;
	//}
	//$data['result'][0]['longitude']=$longitude;
		CLS_MYSQL::Execute("UPDATE user_devices SET read_status ='1' WHERE uid='$uids[$i]'");
	//print_r($data);
	
	//	}
	}
$this->display($data);
	}*/

	function display($data)
	{
	echo DB_Mysql::encode($data);


	}
}



//9738228577
//8105590068
//45134049


$latlong=new vehicleTrack();
$latlong->initiate();
//exec("echo 'php Gmap_location.php' | at now +5 seconds");

?>

