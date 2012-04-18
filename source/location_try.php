<?php
include'config.php';
include'httprequest.php';
//header("Cache-Control: no-cache, must-revalidate");
//header("Accept:text/xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5");
//header("Accept-Language: en-gb,en;q=0.5");
//header("Accept-Encoding: gzip,deflate");
//header("Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7");
//header("Keep-Alive: 300");
//header("Connection: keep-alive");
//header("content-type:txt");
//date_default_timezone_set('India/Bangalore');

//www.tritonetech.com/php_uploads/rnd/location.php?lat=&long=&vel=&date=&time=&option=0
//www.tritonetech.com/php_uploads/rnd/location.php?&date1=&time1=&date2=&time2=&option=1
//www.tritonetech.com/php_uploads/rnd/location.php?option=2
class fleetLogDetails extends DB_Mysql
{



	function getPostData()
	{
	$var=new HTTPrequest();
	$date	=	$var->get('date');
	$time	=	$var->get('time');

	$option	= $var->get('option');
	$name	= $var->get('name');
	$uid	=$var->get('uid');
	$latitude = $var->get('lat');
	$longitude =$var->get('long');
	$time1	=$var->get('time1');
	$date1	=$var->get('date1');
	$time2	=$var->get('time2');
	$date2	=$var->get('date2');
	$velocity=$var->get('vel');
	$velocity=1.852*$velocity;
	//echo $option;
		if($option==0)
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

		}
	}

	function initiateProcess($latitude,$longitude,$date,$time,$uid,$velocity)
	{
	$this->manipulateLatLong($latitude,$longitude);
	$timestamp=$this->makeTimestamp($date,$time);
	$this->trackFleet($uid,$latitude,$longitude,$timestamp,$velocity);
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

	function currentLocation($uid)
	{
	$loc=CLS_MYSQL::Query("SELECT UTC FROM gprs WHERE uid='12' ORDER BY UTC DESC LIMIT 5");
	$count=CLS_MYSQL::GetResultNumber($loc);
	//var_dump($count);
	if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="No data";

		}
		else
		{
		$UTC=CLS_MYSQL::GetResultValue($loc,0,'UTC');
		/*$curloc=CLS_MYSQL::Query("SELECT  avg( t1.velocity ) AS avg_speed, t2.velocity as cur_speed,t2.*
						FROM gprs AS t1
						INNER JOIN gprs AS t2 ON t1.UTC
						BETWEEN $UTC-3600
						AND $UTC
						WHERE t2.UTC =$UTC AND t2.uid='12'");*/
		$curloc=CLS_MYSQL::Query("SELECT latitude,longitude from gprs where uid='12' ORDER BY UTC DESC LIMIT 5");
		$count=CLS_MYSQL::GetResultNumber($curloc);
		for($i=0;$i<$count;$i++)
		{
		$dataDB[$i]['latitude']=CLS_MYSQL::GetResultValue($curloc,$i,'latitude');
			$dataDB[$i]['longitude']=CLS_MYSQL::GetResultValue($curloc,$i,'longitude');
		}				//$dataDB['Result']['Data'][0]['cur_speed']=CLS_MYSQL::GetResultValue($curloc,0,'cur_speed');
					//$dataDB['Result']['Data'][0]['avg_speed']=CLS_MYSQL::GetResultValue($curloc,0,'avg_speed');

		}
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

	function trackFleet($uid,$latitude,$longitude,$timestamp,$velocity)
	{
		//date1=30-06-11&time1=10:10:11&date2=30-06-11&time2=16:10:10&UID=12

	$local=$timestamp+19800;
	$track=CLS_MYSQL::Execute("insert into gprs(uid,latitude,longitude,UTC,Local_activity,velocity) values('$uid','$latitude','$longitude','$timestamp','$local','$velocity')");
		if($track==true)
		{
		$dataDB['Result']['Data'][0]['Status']="Success";
		}
		else
		{
		$dataDB['Result']['Data'][0]['Status']="Not updated";
		}
	$this->display($dataDB);

	}

	function logDetails($date1,$time1,$date2,$time2,$uid)
	{
	$Timestamp1=$this->makeTimestamp($date1,$time1);
	//echo $Timestamp1;echo "<br/>";
	$Timestamp2=$this->makeTimestamp($date2,$time2);
	//echo $Timestamp2;echo "<br/>";
	$this->query =CLS_MYSQL::Query("SELECT gid,uid, latitude, longitude,FROM_UNIXTIME(UTC) AS date_time FROM gprs where UTC BETWEEN '$Timestamp1' AND '$Timestamp2' AND uid='12'");
	//08-07-2011&time1=06:01:07
	//echo mktime(06,01,07,07,08,2011);

	//echo date("Y-m-d H:i:s",1310130067);
	$a="SELECT gid,uid, latitude, longitude,FROM_UNIXTIME(UTC) AS date_time FROM gprs where UTC BETWEEN '$Timestamp1' AND '$Timestamp2' AND uid='12'";
//echo $a;
	
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


}

$start=new fleetLogDetails();
$start->getPostData();
//$start->hourGapData();
?>
