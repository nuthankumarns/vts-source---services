<?php
require_once('sssh.class.php');
$session=new MySessionHandler('localhost','nuthan','tritone123','vts');
session_start();
//include "setup.php";
include "config.php";
include "httprequest.php";
//www.tritonetech.com/php_uploads/rnd/login_api.php?username=&password=
class login extends DB_Mysql
{
var $user1;
var $pass;
var $query;
var $option;
var $gid;
var $dataDB;
var $dbpassword;
var $ID;
var $a;
	/*function __construct()
		{
		parent::__construct();
		 //CLS_MYSQL::Connect();
   		}*/
	function getPostData()
	{
	$var=new HTTPRequest();
	$username=$var->get('username');
	$password=$var->get('password');
	$device_token=$var->get('device_token');
	//$option=$var->get('option');
	$this->check($username,$password,$device_token);
	}

	function check($username,$password,$device_token)
	{
//echo $this->user1;

		$this->query= CLS_MYSQL::Query("select user_id,user_pass from users where CONVERT(user_name USING latin1) COLLATE latin1_general_cs ='$username'");

			$this->count = CLS_MYSQL::GetResultNumber($this->query);

				if($this->count==0)
				{
				$dataDB['Result']['Data'][0]=array('Status'=>"Incorrect username/password");
				$this->display($dataDB);
				}
				else
				{
				//$password=CLS_MYSQL::GetResultValue($this->query,0,'user_pass');
					$this->get_id($password,$device_token);
				}
	}

	function get_id($password,$device_token)
	{
		//$dbpassword=array();

		$dbpassword =  CLS_MYSQL::GetResultValue($this->query, 0, "user_pass");
		//$uid= CLS_MYSQL::GetResultValue($this->query,0,'uid');
		//$gid['gid']= CLS_MYSQL::GetResultValue($this->query, 0 ,"gid");
		//list($this->md5pass, $this->saltpass) = explode(":", $dbpassword);
		//echo sha1($password);
			if (sha1($password)==$dbpassword)
			{
			$id =  CLS_MYSQL::GetResultValue($this->query, 0, "user_id");
			
			//$this->verifyDeviceToken($device_token,$id);	
			$_SESSION["UID"] = $id;
			$_SESSION['timestamp']=time();
			//$_SESSION["timestamp"]=
			//$gid=$gid['gid'];
			
			$this->getDevices($id);

			}
			else
			{
			$dataDB['Result']['Data'][0]=array('Status'=>"Password does not match");
			$this->display($dataDB);
			}
	}

	function verifyDeviceToken($device_token,$id)
	{
	$qry=CLS_MYSQL::Query("SELECT devicetoken FROM apns_devices WHERE devicetoken='$device_token'");
	$count=CLS_MYSQL::GetResultNumber($qry);
		if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="Invalid Token";
		$this->display($dataDB);exit();
		}
		else
		{
		$token=CLS_MYSQL::Execute("UPDATE apns_devices SET user_id='$id' WHERE devicetoken='$device_token'");
		}

	}

	function getDevices($id)
	{
	$query=CLS_MYSQL::Query("SELECT b. *
FROM users AS a
LEFT JOIN user_devices AS b ON a.user_id = b.user_id
WHERE a.user_id = '$id'");
	
	$count=CLS_MYSQL::GetResultNumber($query);
		for($i=0;$i<$count;$i++)
		{
		
		$dataDB['Result']['Data'][$i]['device_id']=CLS_MYSQL::GetResultValue($query,$i,'id');
			$dataDB['Result']['Data'][$i]['mobile_num']=CLS_MYSQL::GetResultValue($query,$i,'mobile');
				//$dataDB['Result']['Data'][$i]['offset']=CLS_MYSQL::GetResultValue($query,$i,'offset');
					$dataDB['Result']['Data'][$i]['imei']=CLS_MYSQL::GetResultValue($query,$i,'imei');
					$dataDB['Result']['Data'][$i]['alias']=CLS_MYSQL::GetResultValue($query,$i,'alias');


		}
//$dataDB['Result']['id']=session_id();
		$dataDB['Result']['user_id']=$id;
			$dataDB['Result']['Status']="Successfully logged in";
	$this->display($dataDB);

	}


	function display($dataDB)
	{
		echo stripslashes(DB_Mysql::encode($dataDB));
	}
}
//4331954320
$a=new login();
$a->getPostData();
?>
