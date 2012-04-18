<?php
//header("Pragma:");
include'config.php';
include'httprequest.php';
include'set_session_API.php';
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
	$latitude = $var->get('lat');
	$longitude =$var->get('long');
	$time1	=$var->get('time1');
	$date1	=$var->get('date1');
	$time2	=$var->get('time2');
	$date2	=$var->get('date2');
	$velocity=$var->get('vel');
	$user_id=$_SESSION['UID'];
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
		$this->logDetails($date1,$time1,$date2,$time2,$uid);
		break;
		case'2':
		$this->currentLocation($uid);
		break;
		case'3':
		$this->checkPoint($lat_ref,$long_ref,$uid,$range);
		break;
		case'4':
		$this->customMessage($uid,$message);
		break;
		case'5':
		$this->geoFencing($uid);
		break;
		case'6':
		$this->operateGeofence($uid,$geo_status);
		break;
		case'7':
		$this->getDevices($user_id);
		break;
		case'8':
		$this->multipleCurrentLocation($user_id);
		break;
		}

		/*if($option==0)
		{
		$this->initiateProcess($latitude,$longitude,$date,$time,$uid,$velocity);
		}
		elseif($option==1)
		{
		$this->logDetails($date1,$time1,$date2,$time2,$uid);
		}
		else
		{
		$this->currentLocation($uid);

		}*/
	}

	function initiateProcess($latitude,$longitude,$date,$time,$imei,$velocity,$ack)
	{
	$this->manipulateLatLong($latitude,$longitude);
	$timestamp=$this->makeTimestamp($date,$time);
	$this->trackFleet($imei,$latitude,$longitude,$timestamp,$velocity,$ack);
	}

	function getImei($user_id)
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

	function currentLocation($imei)
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
		$UTC=CLS_MYSQL::GetResultValue($loc,0,'UTC');
		$Local=CLS_MYSQL::GetResultValue($loc,0,'Local_activity');
		$unix_time=date('d-m-Y H:i:s',$Local);
		$id=CLS_MYSQL::GetResultValue($loc,0,'gid');
		/*$curloc=CLS_MYSQL::Query("SELECT  avg( t1.velocity ) AS avg_speed, t2.velocity as cur_speed,t2.*
						FROM gprs AS t1
						INNER JOIN gprs AS t2 ON t1.UTC
						BETWEEN $UTC-3600
						AND $UTC
						WHERE t2.UTC =$UTC AND t2.uid='$uid'");*/
		//$curloc=CLS_MYSQL::Query("SELECT * FROM gprs WHERE gid BETWEEN $id-1 AND $id");
	
			/*for($i=0;$i<2;$i++)
			{
			$latitude[$i]=CLS_MYSQL::GetResultValue($curloc,$i,'latitude');
			$longitude[$i]=CLS_MYSQL::GetResultValue($curloc,$i,'longitude');
			}*/
			//print_r($latitude);
			//echo $latitude[1];
			$latitude=CLS_MYSQL::GetResultValue($loc,0,'latitude');
			$longitude=CLS_MYSQL::GetResultValue($loc,0,'longitude');
		$dataDB['Result']['Data'][0]['latitude']=$latitude;
			$dataDB['Result']['Data'][0]['longitude']=$longitude;
				$dataDB['Result']['Data'][0]['cur_speed']=CLS_MYSQL::GetResultValue($loc,0,'velocity');
					//$dataDB['Result']['Data'][0]['avg_speed']=CLS_MYSQL::GetResultValue($curloc,0,'avg_speed');
					$ack=CLS_MYSQL::GetResultValue($loc,0,'ack');
					$dataDB['Result']['Data'][0]['ack']=$ack;
					//$message=CLS_MYSQL::GetResultValue($loc,0,'message');
					/*if($ack==0)
					{
					
					
					$dataDB['Result']['Data'][1]['alert']="your message has succesfully delivered";
					//CLS_MYSQL::Execute("UPDATE user_devices SET message='' WHERE uid='$uid'");
					}*/
					
				
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
	$uids=$this->getImei($user_id);
	//print_r($uids);
		for($j=0;$j<count($uids);$j++)
		{
			$loc[$j]=CLS_MYSQL::Query("SELECT 			a.gid,a.UTC,a.latitude,a.longitude,a.Local_activity,a.velocity,b.ack,b.message,b.range,b.out_range,b.read_status,b.geo_status,b.alias,b.lat_ref,b.long_ref FROM gprs AS a RIGHT JOIN user_devices AS b ON a.uid=b.uid WHERE b.uid='$uids[$j]' ORDER BY UTC DESC LIMIT 1");

		//sopdb47'@'72.167.233.37
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
		//$UTC=CLS_MYSQL::GetResultValue($loc[$j],0,'UTC');
		$dataDB[Result][Data][$j][alias]=$alias;
		$dataDB[Result][Data][$j][uid]=$uids[$j];
		$Local=CLS_MYSQL::GetResultValue($loc[$j],0,'Local_activity');
		if($Local!='')
		{

		
		$unix_time=date('d-m-Y H:i:s',$Local);
		$id=CLS_MYSQL::GetResultValue($loc[$j],0,'gid');
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
			if(($geo_status)=='1')
			{
					$range=CLS_MYSQL::GetResultValue($loc[$j],0,'range');
				$dataDB['Result']['Data'][$j]['lat_ref']=CLS_MYSQL::GetResultValue($loc[$j],0,'lat_ref');
				$dataDB['Result']['Data'][$j]['long_ref']=CLS_MYSQL::GetResultValue($loc[$j],0,'long_ref');
				$dataDB['Result']['Data'][$j]['range']=$range;
				//var_dump($latitude);
				$this->checkBeyondRange($latitude,$longitude,$uid);	
				//$this->display($dataDB);
				$query=CLS_MYSQL::Query("SELECT out_range,read_status FROM user_devices WHERE uid='$uids[$j]'");
				$out_range=CLS_MYSQL::GetResultValue($query,0,'out_range');
				$read_status=CLS_MYSQL::GetResultValue($query,0,'read_status');
				//echo $read_status;
				//var_dump($out_range);
				//var_dump($range);
				//if($read_status=='2')
				//{	
				//echo $range;
				$dataDB['Result']['Data'][$j]['alert']=$out_range;
		//$this->geoFencing($uid,$out_range,$range);
				//CLS_MYSQL::Execute("UPDATE user_devices SET read_status='1' WHERE uid='$uid'");
				//}
				//$this->display($dataDB);
			}
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


	/*function hourGapData($uid)
	{
	$a="SELECT latitude,longitude,UTC,velocity FROM gprs WHERE UTC between $dur-3600 AND $dur";
	echo $a;
	$loc=CLS_MYSQL::Query("SELECT t1. * , avg( t1.velocity ) , t2.gid, t2.velocity
		FROM gprs AS t1
		INNER JOIN gprs AS t2 ON t1.UTC
		BETWEEN $dur-3600
		AND $dur
		WHERE t2.UTC =$dur ");
			/*SELECT t1. * , avg( t1.velocity ) , t2.gid, t2.velocity
		FROM gprs AS t1
		INNER JOIN gprs AS t2 ON t1.UTC
		BETWEEN 1309975709
		AND 1309975869
		WHERE t2.UTC =1309975869 */
		//SELECT *FROM gprsWHERE activityBETWEEN now() -1000AND now( )
		/*$count=CLS_MYSQL::GetResultNumber($loc);
		if($count==1)
			{
			$dataDB['Result']['Data'][0]['latitude']=CLS_MYSQL::GetResultValue($loc,0,'latitude');
				$dataDB['Result']['Data'][0]['longitude']=CLS_MYSQL::GetResultValue($loc,0,'longitude');
			}
			else
			{
			$dataDB['Result']['Data'][0]['Status']="No data";
			}
		$this->display($dataDB);

	}*/

	function trackFleet($imei,$latitude,$longitude,$timestamp,$velocity,$ack)
	{
		//date1=30-06-11&time1=10:10:11&date2=30-06-11&time2=16:10:10&UID=12

	$local=$timestamp+19800;
	$user_time=$_SESSION['gmt'];
	$velocity=round($velocity);
	$track=CLS_MYSQL::Execute("insert into gprs(uid,latitude,longitude,UTC,Local_activity,velocity) values('$imei','$latitude','$longitude','$timestamp','$local','$velocity')");
	//var_dump($track);
		if($track==true)
		{
			if($ack==1)
			{
			CLS_MYSQL::Execute("UPDATE user_devices SET ack='0',message='' WHERE uid='$imei'");
				//$message=CLS_MYSQL::GetResultValue($query,0,'message');
			$data="(SUCCESS)";
			//echo "1";
			//var_dump($data);
			}
			else
			{
			$query=CLS_MYSQL::Query("SELECT message FROM user_devices WHERE uid='$imei'");
			$message=CLS_MYSQL::GetResultValue($query,0,'message');
			//var_dump($message);
			$data=($message!='')?"$message":"(SUCCESS)";
				//$data=CLS_MYSQL::GetResultValue($query,0,'message');
			//echo "0";
			//var_dump($data);
			}
		//echo $data;
		}
		else
		{
		$data="FAILURE";
		//echo $data;
		}
	//var_dump($data);
	//$this->checkBeyondRange($latitude,$longitude,$uid);
		$query=CLS_MYSQL::Query("SELECT read_status FROM user_devices WHERE uid='$imei'");
				
		//$this->checkBeyondRange($latitude,$longitude,$uid,$range);	
				//$this->display($dataDB);
				
				//$read_status=CLS_MYSQL::GetResultValue($query,0,'read_status');
				//echo $out_range;
				//echo $range;
				if($read_status==1)
				{	
				//echo $range;
				//$dataDB['alert']=$this->geoFencing($uid,$out_range,$range);
				$data="(geo)";
				CLS_MYSQL::Execute("UPDATE user_devices SET read_status='0' WHERE uid='$imei'");
				}
	echo $data;
	//$this->display($dataDB);

	}

	function logDetails($date1,$time1,$date2,$time2,$uid)
	{
	$Timestamp1=$this->makeTimestamp($date1,$time1);
	//echo $Timestamp1;echo "<br/>";
	$Timestamp2=$this->makeTimestamp($date2,$time2);
	//echo $Timestamp2;echo "<br/>";
	$this->query =CLS_MYSQL::Query("SELECT gid,uid, latitude, longitude,FROM_UNIXTIME(Local_activity) AS date_time FROM gprs where Local_activity BETWEEN '$Timestamp1' AND '$Timestamp2' AND uid='$uid'");
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
		// $dataDB['Result']['Data'][$i]['gid'] = CLS_MYSQL::GetResultValue($this->query,$i,'gid');
		// $dataDB['Result']['Data'][$i]['uid'] = CLS_MYSQL::GetResultValue($this->query,$i,'uid');
			 $dataDB['Result']['Data'][$i]['latitude'] = CLS_MYSQL::GetResultValue($this->query,$i,'latitude');
				 $dataDB['Result']['Data'][$i]['longitude'] = CLS_MYSQL::GetResultValue($this->query,$i,'longitude');
					 $dataDB['Result']['Data'][$i]['date_time'] = CLS_MYSQL::GetResultValue($this->query,$i,'date_time');
				}
			}

	$this->display($dataDB);
	}

	function display($dataDB)
	{
	echo DB_Mysql::encode($dataDB);
	}

	function checkPoint($lat_ref,$long_ref,$uid,$range)
	{
	/*$query=CLS_MYSQL::Query("SELECT lat_ref,long_ref,range FROM user_devices WHERE uid='$uid'");
	$lat_ref_db=CLS_MYSQL::GetResultValue($query,0,'lat_ref');
	$long_ref_db=CLS_MYSQL::GetResultValue($query,0,'long_ref');
	$range_db=CLS_MYSQL::GetResultValue($query,0,'range');
	if($lat_ref_db=='' && $long_ref_db=='' && $range_db=='')
		{*/
		$query=CLS_MYSQL::Query("SELECT latitude,longitude FROM gprs WHERE uid='$uid' ORDER BY UTC DESC LIMIT 1");
		$latitude=CLS_MYSQL::GetResultValue($query,0,'latitude');
		$longitude=CLS_MYSQL::GetResultValue($query,0,'longitude');
		$distance=$this->distance($latitude,$longitude,$lat_ref,$long_ref,'M');
		//echo $distance;
		//echo $range;
		$query=CLS_MYSQL::Execute("UPDATE user_devices SET lat_ref='$lat_ref',long_ref='$long_ref',range='$range',out_range='',geo_status='1',read_status='2' WHERE uid='$uid'");
		$dataDB['Result']['Data'][0]['Status']=($query==true)?"geo_fensing success":"geo_fensing failure";
		if($distance>$range)
		{
		$dataDB['Result']['Data'][0]['alert']="vehicle out of location";
		//echo "me";
		}
		
		
		
	/*	}
		else{
		$dataDB['Result']['Data'][0]['lat_ref']=($lat_ref=='')?"not assigned":$lat_ref;
		$dataDB['Result']['Data'][0]['long_ref']=($long_ref=='')?"not assigned":$long_ref;
		$dataDB['Result']['Data'][0]['range']=($range=='')?"not assigned":$range;
		}*/
	$this->display($dataDB);
		
	}

	function operateGeofence($uid,$geo_status)
	{
	$query=CLS_MYSQL::Execute("UPDATE user_devices SET geo_status='$geo_status' WHERE uid='$uid'");
	

		$dataDB['Result']['Data'][0]['Status']=($query==true)?"$geo_status":"failure";
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


	function checkBeyondRange($latitude,$longitude,$uid)
	{
	$query=CLS_MYSQL::Query("SELECT id,lat_ref,long_ref,range FROM user_devices WHERE uid='$uid'");
	$lat_ref=CLS_MYSQL::GetResultValue($query,0,'lat_ref');
	$long_ref=CLS_MYSQL::GetResultValue($query,0,'long_ref');
	$range=CLS_MYSQL::GetResultValue($query,0,'range');
	$user_device_id=CLS_MYSQL::GetResultValue($query,0,'id');
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
		CLS_MYSQL::Execute("UPDATE user_devices SET lat_set='$latitude',long_set='$longitude',out_range='$distance',read_status='1' WHERE uid='$uid'");
			//var_dump($distance);
		//echo "out";
		//}
	//var_dump($distance);
	}
	
	function geoFencing($uid,$out_range,$range)
	{
	//$query=CLS_MYSQL::Query("SELECT range,out_range FROM user_devices WHERE uid='$uid'");
	//$range=CLS_MYSQL::GetResultValue($query,0,'range');
	//$out_range=CLS_MYSQL::GetResultValue($query,0,'out_range');
	//var_dump($out_range);
	if($out_range!=0)
	{
	$query=CLS_MYSQL::Query("SELECT out_range
				FROM user_devices WHERE uid = '$uid'");
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


	function customMessage($uid,$message)
	{
	//$message=mysql_real_escape_string($message);
	$query=CLS_MYSQL::Execute("UPDATE user_devices SET message='$message',ack='1' WHERE uid='$uid'");
	$dataDB['Result']['Data'][0]['Status']=($query==true)?"message tracked":"message track failure";
	$this->display($dataDB);
	}
}

$start=new fleetLogDetails();
$start->getPostData();
//$start->hourGapData();
?>
