<?php
//header("Pragma:");
include'config.php';
include'httprequest.php';
include'set_session_API.php';
require_once ("GsgumaMail.class.php");
//date_default_set_timezone('Asia/Calcutta');
//date_default_timezone_set('Asia/Calcutta');
//include'set_session.php';
//header("Cache-Control: no-cache, must-revalidate");
//header("Accept:text/xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5");
//header("Accept-Language: en-gb,en;q=0.5");
//header("Accept-Encoding: gzip,deflate");
//header("Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7");
//header("Keep-Alive: 300");
//header("Connection: keep-alive");
//header("content-type:txt");
//date_default_timezone_set('India/Bangalore');

//www.tritonetech.com/php_uploads/rnd/location.php?latitude=&longitude=&option=&ack=&date=&time=
//www.tritonetech.com/php_uploads/rnd/location.php?&date1=&time1=&date2=&time2=&option=1&ack=
//www.tritonetech.com/php_uploads/rnd/location.php?option=2&uid=
//www.tritonetech.com/php_uploads/rnd/location.php?option=3&geo_status=0&lat_ref=&long_ref=&uid=&range=
//www.tritonetech.com/php_uploads/rnd/location.php?option=4&uid=&message=
//www.tritonetech.com/php_uploads/rnd/location.php?option=5
//www.tritonetech.com/php_uploads/rnd/location.php?option=6&geo_status=&uid=
class fleetLogDetails extends DB_Mysql
{

	/*parent::construct()
	{
	$_SESSION["UID"]
	}*/


	function getPostData()
	{
	$var=new HTTPrequest();
	$date	=	$var->get('date');
	$time	=	$var->get('time');

	$option	= $var->get('option');
	$name	= $var->get('name');
	$imei =$var->get('imei');
	$uid	=$var->get('uid');
	$device_id=$var->get('device_id');
	//$device_id=$var->get('id');
	$latitude = $var->get('lat');
	$longitude =$var->get('long');
	$time1	=$var->get('time1');
	$date1	=$var->get('date1');
	$time2	=$var->get('time2');
	$date2	=$var->get('date2');
	$velocity=$var->get('vel');
	$user_id=$_SESSION['UID'];
	//$list=$var->get('list');
	//$list=json_decode($var->get('list'));
	$list=$var->get('list');
	$list=(explode(",",$list));
//print_r($list);exit();
	//$this->getImei($user_id);
	//var_dump($user_id);
	$velocity=1.852*$velocity;
	$lat_ref=$var->get('lat_ref');
	$long_ref=$var->get('long_ref');
	$ack=$var->get('ack');
	$message=$var->get('message');
	$range=$var->get('range');
	$geo_status=$var->get('geo_status');
	//echo $option;

		switch($option)
		{
		case'0':
		$this->initiateProcess($latitude,$longitude,$date,$time,$imei,$velocity,$ack);
		break;
		case'1':
		$this->logDetails($date1,$time1,$date2,$time2,$device_id);
		break;
		case'2':
		$this->currentLocation($device_id);
		break;
		case'3':
		$this->checkPoint($lat_ref,$long_ref,$device_id,$range);
		break;
		case'5':
		$this->geoFencing($device_id);
		break;
		case'6':
		$this->operateGeofence($device_id,$geo_status);
		break;
		case'7':
		$this->getDevices($user_id);
		break;
		case'8':
		$this->multipleCurrentLocation($user_id);
		break;
		case'9':
		$this->manyCurrentLocation($list);
		break;
		case'10':
		$this->removeFencing($device_id);
		break;
		}


	}

	function initiateProcess($latitude,$longitude,$date,$time,$imei,$velocity,$ack)
	{
	$this->manipulateLatLong($latitude,$longitude);
	$timestamp=$this->makeTimestamp($date,$time);
	$this->trackFleet($imei,$latitude,$longitude,$timestamp,$velocity,$ack);
	}

	function removeFencing($id)
	{
	$query=CLS_MYSQL::Execute("UPDATE user_devices SET lat_ref='', long_ref='', geo_status='0' WHERE id='$id'");
	//echo "SELECT a.*,b.* FROM gmt_zones AS a LEFT JOIN user_devices AS b ON a.id=b.offset WHERE b.id='$device_id'";
	$dataDB['Result']['Data'][0]['Status']=($query==true)?"success":"failure";
	$this->display($dataDB);	

	}


	function manipulateLatLong(&$latitude,&$longitude)
	{
	$a=$latitude;
	$b=strpos($a,'.');
	$deg=substr($a,0,($b-2));
	$min=substr($a,($b-2));
	$latitude=$deg+($min/60);

	$pos2=strpos($longitude,'.');
	$deg2=substr($longitude,0,($pos2-2));
	$min2=substr($longitude,($pos2-2));
	$longitude=$deg2+($min2/60);

	}

	function roundOffVelocity($velocity)
	{
	$velocity=round($velocity);
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
	/*echo "<br/>";
	//echo time();
	echo "<br/>";
	echo date('d m y h:i:s',time()-1800);
	exit();*/
	return $timestamp;
	//H i s n j Y

	}

	function localTime($device_id)
	{
	$query=CLS_MYSQL::Query("SELECT a.*,b.* FROM gmt_zones AS a LEFT JOIN user_devices AS b ON a.id=b.offset WHERE b.id='$device_id'");
	//echo "SELECT a.*,b.* FROM gmt_zones AS a LEFT JOIN user_devices AS b ON a.id=b.offset WHERE b.id='$device_id'";
	$result=CLS_MYSQL::GetResultValue($query,0,'secondsDiff');
	return $result;

	}

	/*function currentLocation($device_id)
	{
	//$uid=$this->getImei($user_id);
	//print_r($uid);
	$query=CLS_MYSQL::Query("SELECT a.*,b.* FROM track_data AS a LEFT JOIN user_devices AS b ON b.id=a.device_id WHERE a.device_id='$device_id' ORDER BY activity DESC LIMIT 1");
	//echo "SELECT a.*,b.* FROM track_data AS a LEFT JOIN user_devices AS b ON b.id=a.device_id WHERE a.device_id='$device_id' ORDER BY activity DESC LIMIT 1";exit();
	$count=CLS_MYSQL::GetResultNumber($query);
	//var_dump($count);
	if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="No data";

		}
		else
		{
		$offset=$this->localTime($device_id);
		$Local=$offset+CLS_MYSQL::GetResultValue($query,0,'activity');
		//$Local=CLS_MYSQL::GetResultValue($query,0,'activity');
		$unix_time=date('d-m-Y H:i:s',$Local);
		$dataDB['Result']['Data'][0]['latitude']=CLS_MYSQL::GetResultValue($query,0,'latitude');;
			$dataDB['Result']['Data'][0]['longitude']=CLS_MYSQL::GetResultValue($query,0,'longitude');
				$dataDB['Result']['Data'][0]['cur_speed']=CLS_MYSQL::GetResultValue($query,0,'velocity');
			$dataDB['Result']['Data'][0]['ack']=CLS_MYSQL::GetResultValue($query,0,'ack');;
			$dataDB['Result']['Data'][0]['timestamp']=$unix_time;
		$dataDB['Result']['Data'][0]['alias']=CLS_MYSQL::GetResultValue($query,0,'alias');
	$dataDB['Result']['Data'][0]['Location']=CLS_MYSQL::GetResultValue($query,0,'Location');
	$dataDB['Result']['geo_status']=CLS_MYSQL::GetResultValue($query,0,'geo_status');
	}
	
	$this->display($dataDB);
	}*/

		function currentLocation($device_id)
	{
//var_dump($imei);
		//$delay=19800;
		$delay=$this->localTime($id);
	$query=CLS_MYSQL::Query("SELECT a.*,b.*,FROM_UNIXTIME(Server_IST) AS Server_IST FROM track_data AS a LEFT JOIN user_devices AS b ON b.id=a.device_id WHERE a.device_id='$device_id' ORDER BY activity DESC LIMIT 1");
	
	//echo "SELECT a.*,b.* FROM track_data AS a LEFT JOIN user_devices AS b ON b.id=a.device_id WHERE a.device_id='$id' ORDER BY activity DESC LIMIT 1";

//var_dump($query);
	$count=CLS_MYSQL::GetResultNumber($query);
	//echo $count;
	if($count==0)
		{
		$data['Result']['Data'][0]['Status']="No data";

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
		$data['Result']['Data'][$i]['latitude'] = $latitude;
					$data['Result']['Data'][$i]['longitude'] =$longitude;
				$data['Result']['Data'][$i]['geo_status'] = CLS_MYSQL::GetResultValue($query,0,'geo_status');
				$data['Result']['Data'][$i]['out_range'] = CLS_MYSQL::GetResultValue($query,0,'out_range');
				$data['Result']['Data'][$i]['read_status'] = CLS_MYSQL::GetResultValue($query,0,'read_status');
				//$alias = CLS_MYSQL::GetResultValue($query,0,'alias');
				$data['Result']['Data'][$i]['range'] = $range;
				$data['Result']['Data'][$i]['alias']=CLS_MYSQL::GetResultValue($query,0,'alias');
				$data['Result']['Data'][$i]['velocity'] = CLS_MYSQL::GetResultValue($query,0,'velocity');
				$current=$delay+CLS_MYSQL::GetResultValue($query,0,'activity');
				$data['Result']['Data'][$i]['last_update'] = date("D-M-Y H:i:s",$current);
				$data['Result']['Data'][$i]['activity'] = CLS_MYSQL::GetResultValue($query,0,'activity');
				$data['Result']['Data'][$i]['Server_UTC']=CLS_MYSQL::GetResultValue($query,0,'Server_UTC');
				$data['Result']['Data'][$i]['Server_IST']=CLS_MYSQL::GetResultValue($query,0,'Server_IST');
				$data['Result']['Data'][$i]['Location']=CLS_MYSQL::GetResultValue($query,0,'Location');
				$data['Result']['Data'][$i]['lat_ref']=CLS_MYSQL::GetResultValue($query,0,'lat_ref');
				$data['Result']['Data'][$i]['long_ref']=CLS_MYSQL::GetResultValue($query,0,'long_ref');
				$data['Result']['Data'][$i]['ranged']=CLS_MYSQL::GetResultValue($query,0,'ranged');//distance1
				$data['Result']['Data'][$i]['mobile']=CLS_MYSQL::GetResultValue($query,0,'mobile');
				
			}
		}
		//$this->traceRoute($latitude,$longitude,$count);
		$this->display($data);		
	}

function current1Location($imei)
	{
	//$uid=$this->getImei($user_id);
	//print_r($uid);
	$loc=CLS_MYSQL::Query("SELECT a.gid,a.UTC,a.latitude,a.longitude,a.Local_activity,a.velocity,b.ack,b.message,b.range,b.out_range,b.read_status,b.geo_status,b.lat_ref,b.long_ref,b.alias FROM gprs AS a LEFT JOIN user_devices AS b ON a.uid=b.uid WHERE a.uid='$uid' ORDER BY UTC DESC LIMIT 1");
	$count=CLS_MYSQL::GetResultNumber($loc);
	//var_dump($count);
	if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="No data";

		}
		else
		{
		$offset=$this->localTime($device_id);
		$Local=$offset+CLS_MYSQL::GetResultValue($query,0,'activity');
		//$Local=CLS_MYSQL::GetResultValue($loc,0,'Local_activity');
		$unix_time=date('d-m-Y H:i:s',$Local);
		$id=CLS_MYSQL::GetResultValue($loc,0,'gid');
		$latitude=CLS_MYSQL::GetResultValue($loc,0,'latitude');
			$longitude=CLS_MYSQL::GetResultValue($loc,0,'longitude');
		$dataDB['Result']['Data'][0]['latitude']=$latitude;
			$dataDB['Result']['Data'][0]['longitude']=$longitude;
				$dataDB['Result']['Data'][0]['cur_speed']=CLS_MYSQL::GetResultValue($loc,0,'velocity');
					
					$ack=CLS_MYSQL::GetResultValue($loc,0,'ack');
					$dataDB['Result']['Data'][0]['ack']=$ack;
					
					$dataDB['Result']['Data'][0]['timestamp']=$unix_time;
		$dataDB['Result']['Data'][0]['alias']=CLS_MYSQL::GetResultValue($query,0,'alias');
	$geo_status=CLS_MYSQL::GetResultValue($loc,0,'geo_status');
	$dataDB['Result']['geo_status']=$geo_status;
	if(($geo_status)=='1')
	{
			$range=CLS_MYSQL::GetResultValue($loc,0,'range');
		$dataDB['Result']['lat_ref']=CLS_MYSQL::GetResultValue($loc,0,'lat_ref');
		$dataDB['Result']['long_ref']=CLS_MYSQL::GetResultValue($loc,0,'long_ref');
		$dataDB['Result']['range']=$range;
		//var_dump($latitude);
		$this->checkBeyondRange($latitude,$longitude,$uid);	
		//$this->display($dataDB);
		$query=CLS_MYSQL::Query("SELECT out_range,read_status FROM user_devices WHERE uid='$uid'");
		$out_range=CLS_MYSQL::GetResultValue($query,0,'out_range');
		$read_status=CLS_MYSQL::GetResultValue($query,0,'read_status');
		//echo $read_status;
		//var_dump($out_range);
		//var_dump($range);
		//if($read_status=='2')
		//{	
		//echo $range;
		$dataDB['Result']['alert']=$out_range;
//$this->geoFencing($uid,$out_range,$range);
		//CLS_MYSQL::Execute("UPDATE user_devices SET read_status='1' WHERE uid='$uid'");
		//}
		//$this->display($dataDB);
	}
	
		}
	
	$this->display($dataDB);
	}

	function multipleCurrentLocation($user_id)
	{
	//var_dump($user_id);
	$devices=$this->getDeviceList($user_id);
	//print_r($devices);
	
		for($j=0;$j<count($devices);$j++)
		{
		$loc[$j]=CLS_MYSQL::Query("SELECT a.*,b.* FROM track_data AS a LEFT JOIN user_devices AS b ON b.id=a.device_id WHERE a.device_id='$devices[$j]' ORDER BY activity DESC LIMIT 1");


	
	$count=CLS_MYSQL::GetResultNumber($loc[$j]);
	//echo $count;
	//var_dump($count);
	if($count==0)
		{
		$dataDB['Result']['Data'][$j]['Status']="No data";
		$dataDB['Result']['Data'][$j]['alias']=CLS_MYSQL::GetResultValue($loc[$j],0,'alias');
		}
		else
		{
		$dataDB['Result']['Data'][$j]['Status']="Success";
		$alias=CLS_MYSQL::GetResultValue($loc[$j],0,'alias');
		//$UTC=CLS_MYSQL::GetResultValue($loc[$j],0,'UTC');
		$dataDB['Result']['Data'][$j]['alias']=$alias;
		
		$offset=$this->localTime($devices[$j]);
		$dataDB['Result']['Data'][$j]['device_id']=$devices[$j];
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
					$dataDB['Result']['Data'][$j]['Location']=CLS_MYSQL::GetResultValue($loc[$j],0,'Location');
					$dataDB['Result']['Data'][$j]['mobile']=CLS_MYSQL::GetResultValue($loc[$j],0,'mobile');
					$ack=CLS_MYSQL::GetResultValue($loc[$j],0,'ack');
					$dataDB['Result']['Data'][$j]['ack']=$ack;
					$dataDB['Result']['Data'][$j]['timestamp']=$unix_time;
	$geo_status=CLS_MYSQL::GetResultValue($loc[$j],0,'geo_status');
	$dataDB['Result']['Data'][$j]['geo_status']=$geo_status;
			
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


	function manyCurrentLocation($list)
	{
	//print_r($list);exit();
	//var_dump($user_id);
	//$devices=$this->getDeviceList($user_id);
	//print_r($devices);
	
		for($j=0;$j<count($list);$j++)
		{
		$loc[$j]=CLS_MYSQL::Query("SELECT a.*,b.*,FROM_UNIXTIME(Server_IST) AS Server_IST FROM track_data AS a LEFT JOIN user_devices AS b ON b.id=a.device_id WHERE a.device_id='$list[$j]' ORDER BY activity DESC LIMIT 1");


	
	$count=CLS_MYSQL::GetResultNumber($loc[$j]);
	//echo $count;
	//var_dump($count);
	if($count==0)
		{
		$dataDB['Result']['Data'][$j]['Status']="No data";
		$dataDB['Result']['Data'][$j]['alias']=CLS_MYSQL::GetResultValue($loc[$j],0,'alias');
		}
		else
		{
		$dataDB['Result']['Data'][$j]['Status']="Success";
		$alias=CLS_MYSQL::GetResultValue($loc[$j],0,'alias');
		//$UTC=CLS_MYSQL::GetResultValue($loc[$j],0,'UTC');
		$dataDB['Result']['Data'][$j]['alias']=$alias;
		
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
					$dataDB['Result']['Data'][$j]['Location']=CLS_MYSQL::GetResultValue($loc[$j],0,'Location');
					$dataDB['Result']['Data'][$j]['Server_IST']=CLS_MYSQL::GetResultValue($loc[$j],0,'Server_IST');
					$dataDB['Result']['Data'][$j]['mobile']=CLS_MYSQL::GetResultValue($loc[$j],0,'mobile');
					$ack=CLS_MYSQL::GetResultValue($loc[$j],0,'ack');
					$dataDB['Result']['Data'][$j]['ack']=$ack;
					$dataDB['Result']['Data'][$j]['timestamp']=$unix_time;
	$geo_status=CLS_MYSQL::GetResultValue($loc[$j],0,'geo_status');
	$dataDB['Result']['Data'][$j]['geo_status']=$geo_status;
			
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

	function getDevices($user_id)
	{
	$query=CLS_MYSQL::Query("SELECT b.uid,b.mobile
		FROM users AS a
		LEFT JOIN user_devices AS b ON a.user_id = b.user_id
		WHERE a.user_id = '$user_id'");
	
	$count=CLS_MYSQL::GetResultNumber($query);
		for($i=0;$i<$count;$i++)
		{
		
		//$dataDB['Result']['Data'][$i]['user_device_id']=CLS_MYSQL::GetResultValue($query,$i,'id');
			$dataDB['Result']['Data'][$i]['mobile_num']=CLS_MYSQL::GetResultValue($query,$i,'mobile');
				//$dataDB['Result']['Data'][$i]['offset']=CLS_MYSQL::GetResultValue($query,$i,'offset');
					$dataDB['Result']['Data'][$i]['uid']=CLS_MYSQL::GetResultValue($query,$i,'uid');


		}
//$dataDB['Result']['id']=session_id();
		//$dataDB['Result']['user_id']=$id;
			//$dataDB['Result']['Status']="Successfully logged in";
	$this->display($dataDB);

	}


	function logDetails($date1,$time1,$date2,$time2,$device_id)
	{
	$offset=$this->localTime($device_id);
	//echo $offset;

	$Timestamp1=$this->makeTimestamp($date1,$time1);
	$Timestamp1=$Timestamp1+$offset;
	//echo $Timestamp1;echo "<br/>";
	$Timestamp2=$this->makeTimestamp($date2,$time2);
	$Timestamp2=$Timestamp2+$offset;
	//echo $Timestamp2;echo "<br/>";
	$this->query =CLS_MYSQL::Query("SELECT latitude, longitude,activity,Location FROM track_data where activity BETWEEN '$Timestamp1' AND '$Timestamp2' AND device_id='$device_id'");

//echo "SELECT latitude, longitude,activity FROM track_data where activity BETWEEN '$Timestamp1' AND '$Timestamp2' AND device_id='$device_id'";
	//08-07-2011&time1=06:01:07
	//echo mktime(06,01,07,07,08,2011);

	//echo date("Y-m-d H:i:s",1310130067);

	$this->count=CLS_MYSQL::GetResultNumber($this->query);

		if($this->count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="No data";
		}
		else
		{
				for($i=0;$i<$this->count;$i++)
				{

			 $dataDB['Result']['Data'][$i]['latitude'] = CLS_MYSQL::GetResultValue($this->query,$i,'latitude');
				 $dataDB['Result']['Data'][$i]['longitude'] = CLS_MYSQL::GetResultValue($this->query,$i,'longitude');
				$dataDB['Result']['Data'][$i]['Location']=CLS_MYSQL::GetResultValue($this->query,$i,'Location');
				$activity=$offset+CLS_MYSQL::GetResultValue($this->query,$i,'activity');
				$unix_time=date('d-m-Y H:i:s',$activity);
					 $dataDB['Result']['Data'][$i]['date_time'] = $unix_time;
				}
			}

	$this->display($dataDB);
	}

	function display($dataDB)
	{
	echo DB_Mysql::encode($dataDB);
	}

	function checkPoint($lat_ref,$long_ref,$device_id,$range)
	{
		/*$query=CLS_MYSQL::Query("SELECT latitude,longitude FROM track_data WHERE device_id='$device_id' ORDER BY activity DESC LIMIT 1");
		$latitude=CLS_MYSQL::GetResultValue($query,0,'latitude');
		$longitude=CLS_MYSQL::GetResultValue($query,0,'longitude');
		$distance=$this->distance($latitude,$longitude,$lat_ref,$long_ref,'M');*/
		//echo $distance;
		//echo $range;
		//var_dump($imei);
		//echo "UPDATE user_devices SET lat_ref='$lat_ref',long_ref='$long_ref',ranged='$range',out_range='',geo_status='1',read_status='1' WHERE uid='$imei'";
		$query=CLS_MYSQL::Execute("UPDATE user_devices SET lat_ref='$lat_ref',long_ref='$long_ref',ranged='$range',geo_status='1' WHERE id='$device_id'");
		$dataDB['Result']['Data'][0]['Status']=($query==true)?"geo_fencing success":"geo_fencing failure";
		/*if($distance>$range)
		{
		$dataDB['Result']['Data'][0]['alert']="vehicle out of location";
		//echo "me";
		}*/
		
	$this->display($dataDB);

		}
		
		

	/*$this->display($dataDB);
		
	}*/

	function operateGeofence($device_id,$geo_status)
	{
	$query=CLS_MYSQL::Execute("UPDATE user_devices SET geo_status='$geo_status' WHERE id='$device_id'");
	

		$dataDB['Result']['Data'][0]['Status']=($query==true)?"success":"failure";
	/*$dist=$this->distance(12.993017,77.574635,12.9923616667,77.578,'M');
var_dump($dist);*/
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


	function checkBeyondRange($latitude,$longitude,$device_id)
	{
	$query=CLS_MYSQL::Query("SELECT id,lat_ref,long_ref,range FROM user_devices WHERE id='$device_id'");
	$lat_ref=CLS_MYSQL::GetResultValue($query,0,'lat_ref');
	$long_ref=CLS_MYSQL::GetResultValue($query,0,'long_ref');
	$range=CLS_MYSQL::GetResultValue($query,0,'range');
	//$user_device_id=CLS_MYSQL::GetResultValue($query,0,'id');
	//$latitude=$this->latitude;
	//$longitude=$this->longitude;
	//var_dump($latitude);
	
	//$distance1=($this->distance($latitude[0],$longitude[0],$lat_ref,$long_ref,'M'))-$range;
	$distance=$this->distance($latitude,$longitude,$lat_ref,$long_ref,'M');
	//var_dump($distance1);
	//$distance2=($this->distance($latitude[1],$longitude[1],$lat_ref,$long_ref,'M'))-$range;
	//var_dump($distance2);
	
	//echo $distance;
		//if($distance2>0 && $distance1<0)
		//{
		//CLS_MYSQL::Execute("INSERT INTO geo_fencing(user_device_id,lat_cur,long_cur,out_range,read_status) VALUES('$user_device_id','$latitude','$longitude','$distance','0')");
		//CLS_MYSQL::Execute("UPDATE user_devices SET lat_set='$latitude[0]',long_set='$longitude[0]',out_range='$distance2',read_status='2' WHERE uid='$uid'");
		CLS_MYSQL::Execute("UPDATE user_devices SET lat_set='$latitude',long_set='$longitude',out_range='$distance',read_status='1' WHERE id='$device_id'");
			//var_dump($distance);
		//echo "out";
		//}
	//var_dump($distance);
	}
	
	function geoFencing($device_id,$out_range,$range)
	{
	//$query=CLS_MYSQL::Query("SELECT range,out_range FROM user_devices WHERE uid='$uid'");
	//$range=CLS_MYSQL::GetResultValue($query,0,'range');
	//$out_range=CLS_MYSQL::GetResultValue($query,0,'out_range');
	//var_dump($out_range);
	if($out_range!=0)
	{
	$query=CLS_MYSQL::Query("SELECT out_range
				FROM user_devices WHERE id = '$device_id'");
	$count=CLS_MYSQL::GetResultNumber($query);
	
		if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="no data";
		}
		else
		{
			for($i=0;$i<$count;$i++)
			{
			//$dataDB[$i]['lat_ref']=CLS_MYSQL::GetResultValue($query,0,'lat_ref');
			//$dataDB[$i]['long_ref']=CLS_MYSQL::GetResultValue($query,0,'long_ref');
			//$dataDB[$i]['lat_set']=CLS_MYSQL::GetResultValue($query,0,'lat_set');
			//$dataDB[$i]['long_set']=CLS_MYSQL::GetResultValue($query,0,'long_set');
			//$dataDB[$i]['preset_range']=CLS_MYSQL::GetResultValue($query,0,'range');
			$dataDB['out_range']=CLS_MYSQL::GetResultValue($query,0,'out_range');
			}
		}
		return $dataDB;
		//$this->display($dataDB);
		}
		//return '';
	}

	


}

$start=new fleetLogDetails();
$start->getPostData();
//$start->hourGapData();
?>
