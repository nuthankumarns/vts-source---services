<?php
/*require_once('sssh.class.php');
$session=new MySessionHandler('sopdb47.db.5236568.hostedresource.com','sopdb47','Tritone123#','sopdb47');
session_start();*/
//include "setup.php";
include "config.php";
include "httprequest.php";
class getVehicle extends DB_Mysql
{
	function getPostData()
	{
	$var=new HTTPRequest();
	$user_id=$var->get('user_id');
	//var_dump($user_id);
	//$password=$var->get('password');
	//$option=$var->get('option');
	$this->vehicleDetails($user_id);
	}

	function vehicleDetails($user_id)
	{
	$query=CLS_MYSQL::Query("SELECT * FROM user_devices WHERE user_id='$user_id'");
	$count=CLS_MYSQL::GetResultNumber($query);
		if($count==0)
		{
			$dataDB['Result']['Data'][0]['Status']="no vehicle";
		}
		else
		{
			for($i=0;$i<$count;$i++)
			{
			$dataDB['Result']['Data'][$i]['uid']=CLS_MYSQL::GetResultValue($query,$i,'uid');
				$dataDB['Result']['Data'][$i]['alias']=CLS_MYSQL::GetResultValue($query,$i,'alias');

			}
		}
		$this->display($dataDB);
	}

	function display($dataDB)
	{
	echo DB_Mysql::encode($dataDB);
	}
}

$a=new getVehicle();
$a->getPostData();
?>
