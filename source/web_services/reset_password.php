<?php
include'set_session.php';
$user_id=$_SESSION['UID'];
$password=$_REQUEST['password'];
$passcode=$_REQUEST['passcode'];

//echo $user_id;
//echo $password;
//require_once('forgot_password.php');
require_once("class_registration.php");
class Reset extends Registration
{

	public function parameterCheck($password,$passcode)
	{
		if($password=='' || $passcode=='')
		{
		$data="missing parameters";
		$this->display($data);exit();
		}

	}


	public function changePassword($password,$user_id,$passcode)
	{
		$this->parameterCheck($password,$passcode);
		
		//echo $rand;
		$count=$this->verifyPasscode($passcode,$user_id);
		if($count==0)
		{
		$data="Incorrect passcode";
		}
		else
		{
		$this->setCryptMethod('sha1');
		$rand=$this->setCrypt($password);
		$query=CLS_MYSQL::Execute("UPDATE users SET user_pass='$rand',user_active='0' WHERE user_active='$passcode'");
		$data="Password changed";
		}
		
		
		$this->display($data);
	}

	public function verifyPasscode($passcode,$user_id)
	{
		$query=CLS_MYSQL::Query("SELECT user_name FROM users WHERE user_active='$passcode' and user_id='$user_id'");
	$count=CLS_MYSQL::GetResultNumber($query);
	return $count;
	}

}

$reset=new Reset();
$reset->changePassword($password,$user_id,$passcode);

?>
