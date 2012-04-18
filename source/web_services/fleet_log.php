<?php
include'config.php';
include'httprequest.php';
header("Cache-Control: no-cache, must-revalidate");
header("Accept:text/xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5");
header("Accept-Language: en-gb,en;q=0.5");
header("Accept-Encoding: gzip,deflate");
header("Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7");
header("Keep-Alive: 300");
header("Connection: keep-alive");
//www.tritonetech.com/php_uploads/rnd/fleet_log.php?
class fleetLogDetails extends DB_Mysql
{
	
global $link,$user1,$uid,$ID,$date,$time;

	function getPostData()
	{
	$_var=new HTTPrequest();
	$option	= $var->('option');
	$name	= $_var->('name');
	$message= $_var->('message');
	$uid	=$_var->('UID');
	$pass	=$_var->('pass');
	$raceID	=$_var->('raceID');
	$latitude = $_var->('latitude');
	$longitude =$_var->('longitude');
	$time1	=$_var->('time1');
	$date1	=$_var->('date1');
	$time2	=$_var->('time2');
	$date2	=$_var->('date2');
	}

	function manipulateLatLong()
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
		$this->trackFleet($uid,$latitude,$longitude); 
	}

	function trackFleet($uid,$latitude,$longitude)
	{
	$timestamp=time();
	$track=CLS_MYSQL::Execute("insert into gprs(uid,latitude,longitude,date_time) values('$uid','$latitude','$longitude','$timestamp')";
		if($track==true)
		{
		$dataDB['Result']['Data'][0]=array('Status'=>"Success");
		}
		else
		{
		$dataDB['Result']['Data']['0']=array('Status'=>"Not updated");
		}
	$this->display($dataDB);
	}

	/*function logDetails()
	{
	$DateTime1=$date1." ".$time1;

	$DateTime2=$date2." ".$time2;
	$query =CLS_MYSQL::Query("SELECT uid, latitude, longitude,date_time FROM gprs where date_time BETWEEN '$DateTime1' AND '$DateTime2' and uid='$uid'"); 
	$count=CLS_MYSQL::GetResultNumber($query);
		
		if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="No data");
		}
		else
		{
		 $dataDB['Result']['Data'][$i]['uid'] = CLS_MYSQL::GetResultValue($query,$i,'uid');
			 $dataDB['Result']['Data'][$i]['latitude'] = CLS_MYSQL::GetResultValue($query,$i,'latitude');
				 $dataDB['Result']['Data'][$i]['longitude'] = CLS_MYSQL::GetResultValue($query,$i,'longitude');
					 $dataDB['Result']['Data'][$i]['date_time'] = CLS_MYSQL::GetResultValue($query,$i,'activity');
		}
	$this->display($dataDB);
	}*/
	
	function display($dataDB)
	{
	echo CLS_MYSQL::encode($dataDB);
	}
  
	}
}

$start=new fleetLogDetails();
?>
