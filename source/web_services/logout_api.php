<?php
//header('Content-type: text/json');
require_once('sssh.class.php');
	$session=new MySessionHandler('localhost','nuthan','tritone123','vts');
   	session_start();
//var_dump($_SESSION['UID']);
include 'config.php';
//www.tritonetech.com/php_uploads/rnd/logout_api.php
class logOut extends DB_Mysql
{
	function __construct()
	{

		$this->checkIsset();
	}

	function checkIsset()
	{
		if(isset($_SESSION['UID']))
		{
		//	var_dump($_SESSION['UID']);
			
		$this->destroy();
		}
		else
		{
		//var_dump($_SESSION['UID']);
		$this->expireSession();
		}
	}

	function destroy()
	{
		$id=$_SESSION['UID'];
		session_unset();
		session_destroy();
		//var_dump($id);
		//$_DB->Execute("UPDATE jos_porsche_student as a left join jos_porsche_student_module as b on a.id=b.student_id SET time_taken='0' where a.user_id='$id'");
		$dataDB['Result']['Data'][0]=array('Status'=>"Successfully logged out");

		$this->display($dataDB);
		
	}

	function expireSession()
	{
		$dataDB['Result']['Data'][0]=array('Status'=>"Session Expired");
		$this->display($dataDB);
		session_unset();
		session_destroy();
	}

	function display($dataDB)
	{
	echo DB_Mysql::encode($dataDB);
	}
}

$logout=new logOut();




?>
