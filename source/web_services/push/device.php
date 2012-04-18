<?php
include'../config.php';

class apns extends DB_Mysql
{
	function checkParameters($app_id,$device_token)
	{
		if($app_id=='' || $device_token=='')
		{
		$dataDB['Result']['Data'][0]['Status']="missing parameters";
		$this->display($dataDB);exit();
		}
	$this->InsertToken($app_id,$device_token);
	}

	function display($dataDB)
	{
	echo DB_Mysql::encode($dataDB);

	}
	
	function InsertToken($app_id,$device_token)
	{
	$query=CLS_MYSQL::Execute("INSERT INTO apns (app_id,device_token) VALUES('$app_id','$device_token')");
	$dataDB['Result']['Data'][0]['Status']=($query==true?"Success":"Failure");
	$this->display($dataDB);

	}



}
$app_id=$_REQUEST[app_id];
$device_token=$_REQUEST[device_token];
$apns=new apns();
$apns->checkParameters($app_id,$device_token);

?>
