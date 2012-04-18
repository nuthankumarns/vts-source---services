<?php
//session_start();
//isset($_SESSION["UID"])?$_SESSION["UID"]:header("location:logout_api.php");
header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");  
header("Pragma: public"); 
session_cache_limiter('nocache');
require_once('sssh.class.php');
$session=new MySessionHandler('localhost','nuthan','tritone123','vts');
session_start();

			//echo $username;
			//echo $password;
	//require_once('LoginSystem.class.php');
//echo "<pre>";
	if(isset($_POST['Submit']))
	{
		if((!$_POST['username']) || (!$_POST['password']))
		{
			// display error message
			header('location: index.php?msg=1');// show error
			//header('login_api.php')
			exit;
		}

		//$loginSystem = new LoginSystem();
		if(($_POST['username']) || ($_POST['password']))
		{
			$username=$_REQUEST['username'];
			$password=$_REQUEST['password'];
			$response=file_get_contents('http://'.$_SERVER["HTTP_HOST"].'/app_proto/login_api.php?username='.$username.'&password='.$password);
			$array=json_decode($response,true);

	/*echo "<pre>";
print_r($array);
echo $array['Result']['Status'];*/
//echo $_SERVER["DOCUMENT_ROOT"];
//echo $_SERVER["HTTP_HOST"];
	//var_dump($array);
	//exit();
		if($array['Result']['Status']=="Successfully logged in")
		{
		
		$_SESSION["UID"] = $array['Result']['user_id'];
			 $_SESSION['isLoggedIn'] = true;
		//isset($_SESSION["UID"])?var_dump($_SESSION['UID']):header("location:logout_api.php");
		//var_dump($_SESSION['UID']);
		//exit();
		$_SESSION['timestamp']=time();
		//$uid=$array['Result']['Data'][0]['uid'];
		//var_dump($uid);
		//exit();
			header("location:../Gmap_location.php");
		}	
		else
		{
			header('location:../index.php?msg=2');
			exit;
		}
		}
	}

	/**
	 * show Error messages
	 *
	 */
	function showMessage()
	{
		if(is_numeric($_GET['msg']))
		{
			switch($_GET['msg'])
			{
				case 1: echo "Please fill both fields.";
				break;

				case 2: echo "Incorrect Login Details";
				break;
				
				case 3: 
					//$response=file_get_contents("http://www.tritonetech.com/php_uploads/rnd/logout_api.php");
					//$array=json_decode($response,true);
						//echo $array['Result']['Data'][0]['Status'];
					$Url="./logout_api.php";
					//$ch = curl_init($url);
					//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) 
					//$recived_content = curl_exec($ch); 
					//$data = json_decode($recived_content);
					//var_dump($data);
					//print_r($data);
					$data=get_data($Url);
						//var_dump(json_decode($data));
					//echo "<pre>";
					$jsonobj=json_decode($data);
					//print_r($jsonobj);
					//echo ($jsonobj->Result->Data[0]->Status);

					//print $data['Result']['Data'];
					//var_dump($data['Result']['Data'][0]['Status']);
					
				break;
			}
		}
	}

	/* gets the data from a URL */
		function get_data($url)
		{
		  $ch = curl_init();
		  $timeout = 5;
		  curl_setopt($ch,CURLOPT_URL,$url);
		  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		  $data = curl_exec($ch);
		  curl_close($ch);
		  return $data;
		}


?>
