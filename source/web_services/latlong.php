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
	$id=$var->get('id');
	//var_dump($user_id);
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
	$this->currentLocation($id);
	}
	elseif($option==3)
	{
	$this->checkPoint($lat_ref,$long_ref,$id,$range);
	}
	elseif($option==4)
	{
	$this->multipleCurrentLocation($user_id);
	}
	elseif($option==5)
	{
	$this->removeFencing($id);
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

	return $timestamp;
	//H i s n j Y

	}
	function removeFencing($id)
	{
	$query=CLS_MYSQL::Execute("UPDATE user_devices SET lat_ref='', long_ref='', geo_status='0' WHERE id='$id'");
	//echo "SELECT a.*,b.* FROM gmt_zones AS a LEFT JOIN user_devices AS b ON a.id=b.offset WHERE b.id='$device_id'";
	$dataDB['Result']['Data'][0]['Status']=($query==true)?"success":"failure";
	$this->display($dataDB);	

	}
	
	function currentLocation($id)
	{
//var_dump($imei);
		//$delay=19800;
		$delay=$this->localTime($id);
	$query=CLS_MYSQL::Query("SELECT a.*,b.*,FROM_UNIXTIME(Server_IST) AS Server_IST FROM track_data AS a LEFT JOIN user_devices AS b ON b.id=a.device_id WHERE a.device_id='$id' ORDER BY activity DESC LIMIT 1");
	
	//echo "SELECT a.*,b.* FROM track_data AS a LEFT JOIN user_devices AS b ON b.id=a.device_id WHERE a.device_id='$id' ORDER BY activity DESC LIMIT 1";

//var_dump($query);
	$count=CLS_MYSQL::GetResultNumber($query);
	//echo $count;
	if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="No data";

		}
		else
		{
		$latitude=CLS_MYSQL::GetResultValue($query,0,'latitude');
		 $longitude=CLS_MYSQL::GetResultValue($query,0,'longitude');
		 $lat_ref=CLS_MYSQL::GetResultValue($query,0,'lat_ref');
		$long_ref=CLS_MYSQL::GetResultValue($query,0,'long_ref');
		$range=$this->distance($latitude,$longitude,$lat_ref,$long_ref,'M');//distance2
	
//imei 	latitude 	longitude 	activity 	velocity
		for($i=0;$i<$count;$i++)
			{
		$data['result'][$i]['latitude'] = $latitude;
					 $data['result'][$i]['longitude'] =$longitude;
				$data['result'][$i]['geo_status'] = CLS_MYSQL::GetResultValue($query,0,'geo_status');
				$data['result'][$i]['out_range'] = CLS_MYSQL::GetResultValue($query,0,'out_range');
				$data['result'][$i]['read_status'] = CLS_MYSQL::GetResultValue($query,0,'read_status');
				//$alias = CLS_MYSQL::GetResultValue($query,0,'alias');
				$data['result'][$i]['range'] = $range;
				$data['result'][$i]['alias']=CLS_MYSQL::GetResultValue($query,0,'alias');
				$data['result'][$i]['velocity'] = CLS_MYSQL::GetResultValue($query,0,'velocity');
				$current=$delay+CLS_MYSQL::GetResultValue($query,0,'activity');
				$data['result'][$i]['last_update'] = date("D-M-Y H:i:s",$current);
				$data['result'][$i]['activity'] = CLS_MYSQL::GetResultValue($query,0,'activity');
				$data['result'][$i]['Server_UTC']=CLS_MYSQL::GetResultValue($query,0,'Server_UTC');
				$data['result'][$i]['Server_IST']=CLS_MYSQL::GetResultValue($query,0,'Server_IST');
				$data['result'][$i]['Location']=CLS_MYSQL::GetResultValue($query,0,'Location');
				$data['result'][$i]['lat_ref']=CLS_MYSQL::GetResultValue($query,0,'lat_ref');
				$data['result'][$i]['long_ref']=CLS_MYSQL::GetResultValue($query,0,'long_ref');
				$data['result'][$i]['ranged']=CLS_MYSQL::GetResultValue($query,0,'ranged');//distance1
				
			}
		}
		//$this->traceRoute($latitude,$longitude,$count);
		$this->display($data);		
	}

	function checkPoint($lat_ref,$long_ref,$id,$range)
	{

		/*$query=CLS_MYSQL::Query("SELECT latitude,longitude FROM track_data WHERE device_id='$id' ORDER BY activity DESC LIMIT 1");
		$latitude=CLS_MYSQL::GetResultValue($query,0,'latitude');
		$longitude=CLS_MYSQL::GetResultValue($query,0,'longitude');
		$distance=$this->distance($latitude,$longitude,$lat_ref,$long_ref,'M');*/
		//echo $distance;
		//echo $range;
		//var_dump($imei);
		//echo "UPDATE user_devices SET lat_ref='$lat_ref',long_ref='$long_ref',ranged='$range',out_range='',geo_status='1',read_status='1' WHERE uid='$imei'";
		$query=CLS_MYSQL::Execute("UPDATE user_devices SET lat_ref='$lat_ref',long_ref='$long_ref',ranged='$range',out_range='',geo_status='1',read_status='1' WHERE id='$id'");
		$dataDB['Result']['Data'][0]['Status']=($query==true)?"geo_fencing success":"geo_fencing failure";
		/*if($distance>$range)
		{
		$dataDB['Result']['Data'][0]['alert']="vehicle out of location";
		//echo "me";
		}*/
		
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


	function multipleCurrentLocation($user_id)
	{
	$devices=$this->getDeviceList($user_id);
	//print_r($devices);
	
		for($j=0;$j<count($devices);$j++)
		{
		$loc[$j]=CLS_MYSQL::Query("SELECT a.*,b.*,FROM_UNIXTIME(Server_IST) AS Server_IST FROM track_data AS a LEFT JOIN user_devices AS b ON b.id=a.device_id WHERE a.device_id='$devices[$j]' ORDER BY activity DESC LIMIT 1");
	

	
	$count=CLS_MYSQL::GetResultNumber($loc[$j]);
	//echo $count;
	//var_dump($count);
	if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="No data";

		}
		else
		{
		$alias=CLS_MYSQL::GetResultValue($loc[$j],0,'alias');
		$dataDB[Result][Data][$j][device_id]=CLS_MYSQL::GetResultValue($loc[$j],0,'device_id');
		//$UTC=CLS_MYSQL::GetResultValue($loc[$j],0,'UTC');
		$dataDB[Result][Data][$j][alias]=$alias;
		
		$offset=$this->localTime($devices[$j]);
		$Local=$offset+CLS_MYSQL::GetResultValue($loc[$j],0,'activity');
		//$Local=CLS_MYSQL::GetResultValue($loc[$j],0,'activity');
		if($Local!='')
		{
		$unix_time=date('d-m-Y H:i:s',$Local);
		//$id=CLS_MYSQL::GetResultValue($loc[$j],0,'gid');
			$latitude=CLS_MYSQL::GetResultValue($loc[$j],0,'latitude');
			$longitude=CLS_MYSQL::GetResultValue($loc[$j],0,'longitude');
		$dataDB['Result']['Data'][$j]['latitude']=$latitude;
			$dataDB['Result']['Data'][$j]['longitude']=$longitude;
				$dataDB['Result']['Data'][$j]['cur_speed']=CLS_MYSQL::GetResultValue($loc[$j],0,'velocity');
					
					$ack=CLS_MYSQL::GetResultValue($loc[$j],0,'ack');
					$dataDB['Result']['Data'][$j]['ack']=$ack;
					$dataDB['Result']['Data'][$j]['timestamp']=$unix_time;
	$geo_status=CLS_MYSQL::GetResultValue($loc[$j],0,'geo_status');
	$dataDB['Result']['Data'][$j]['geo_status']=$geo_status;
	$dataDB['Result']['Data'][$j]['Server_IST']=CLS_MYSQL::GetResultValue($loc[$j],0,'Server_IST');
	$dataDB['Result']['Data'][$j]['Location']=CLS_MYSQL::GetResultValue($loc[$j],0,'Location');
			
		}
		else
		{
		$dataDB['Result']['Data'][$j][Status]="No Data";
		}
	
		}
	}
//echo "<pre>";
//print_r($dataDB);
	$this->display($dataDB);
	}

	function getDeviceList($user_id)
	{
	//var_dump($user_id);
	$query=CLS_MYSQL::Query("SELECT id FROM user_devices WHERE user_id='$user_id'");
		$count=CLS_MYSQL::GetResultNumber($query);
	//echo $count;
		for($i=0;$i<$count;$i++)
		{
		$devices[$i]=CLS_MYSQL::GetResultValue($query,$i,'id');
		}
	//print_r($uids);
	return $devices;
	//print_r($uid);
	}

	function localTime($device_id)
	{
	$query=CLS_MYSQL::Query("SELECT a.secondsDiff FROM gmt_zones AS a LEFT JOIN user_devices AS b ON a.id=b.offset WHERE b.id='$device_id'");
	//echo "SELECT a.*,b.* FROM gmt_zones AS a LEFT JOIN user_devices AS b ON a.id=b.offset WHERE b.id='$device_id'";
	$result=CLS_MYSQL::GetResultValue($query,0,'secondsDiff');
	return $result;

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

