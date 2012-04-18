<?php
//session_start();
//isset($_SESSION["UID"])?$_SESSION["UID"]:header("location:logout_api.php");
require_once('sssh.class.php');
$session=new MySessionHandler('localhost','nuthan','tritone123','vts');
session_start();
if(isset($_SESSION['isLoggedIn'])) {
    header("Location: Gmap_location.php");
}
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
		var_dump($array);

		if($array['Result']['Status']=="Successfully logged in")
		{
		$_SESSION["UID"] = $array['Result']['user_id'];
		//isset($_SESSION["UID"])?var_dump($_SESSION['UID']):header("location:logout_api.php");
		//var_dump($_SESSION['UID']);
		//exit();
		$_SESSION['timestamp']=time();
		
		//$uid=$array['Result']['Data'][0]['uid'];
		//var_dump($uid);
			header("location: Gmap_location.php");
		}
		
		
		else
		{
			header('location: index.php?msg=2');
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
					$Url="../logout_api.php";
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
					echo ($jsonobj->Result->Data[0]->Status);

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<title> VTS Login page </title>

<style type="text/css">

html{

margin: 0px;
padding: 0px;
background: #efecdf;
}

#wrapper{

border: solid #efecdf 1px;
background: #efecdf;
/* height: 740px; */
height: auto;
}

#wrapbg{

border: solid #efecdf 1px;
background: url('images/formimg/bg1.png') no-repeat #efecdf;
margin: 0px auto;
width: 960px;
height: 702px;
}

#formbg{

border: solid brown 0px;
width: 340px;
height: 405px; 
background: url('images/formimg/image_0009_Layer-3.png') no-repeat;
margin-left: 337px;
margin-top: 72px;
}

#userimg{

background: url('images/formimg/image_0006_username.png') no-repeat;
border-style: none;
border: none;
width:170px;
height:35px;
padding-left:25px;
margin-left:70px;
margin-left: 60px\9;
/* margin-top: 20px; */
margin-top: -12px\9;
/* margin:0px auto; */
}

#passimg{

background: url('images/formimg/image_0005_password.png') no-repeat;
border-style: none;
border: solid green 0px;
width:100px;
height:35px;
margin-left:70px;
margin-top:10px;
padding-left:95px;
margin-left: 60px\9;
width:150px\9;
/* margin:0px auto; */
}

.inputimg{
border-style: none;
background: url('images/formimg/image_0004_Layer-6.png') no-repeat;
width:240px;
height:40px;
padding-left:20px;
padding-top:15px \9;
margin-left:53px;
border:none;
}

#formcont{

border: solid yellow 0px;
margin-top: 30px;
margin-top: 0px\9;
padding-top: 40px;
padding-top: 0px\9;
}

#squareimg{

background: url('images/formimg/image_0000_Layer-8.png') no-repeat;
border-style: none;
width:10px;
height:10px;
float: left;
}

#rememberwrap{

margin-left: 80px;
margin-top:-5px\9;
}

#rememberimg{

background: url('images/formimg/image_0001_remember-me.png') no-repeat;
border-style: none;
margin-top: 3px;
margin-left: 10px;
width: 135px;
height: 20px;
float: left;
}

#subimg{

background: url('images/formimg/image_0002_login.png');
border-style: none;
clear: all;
margin-top: 18px;
margin-top: 8px\9;
margin-left: 105px;
/* margin-top: 10px; */
width: 138px;
height: 70px;
}

#sherr{

color:red\9;
text-align:center\9;
font-size:16px\9;
padding-top: 20px\9;


}

</style>
<link rel="icon" type="image/png" href="vw-beetle-icon.png">
<script language="javascript">

function validateme()
{

var alpnum = document.f1.username.value;

if((document.f1.username.value == '') && (document.f1.password.value == ''))
{
alert('Please Enter Username and Password!');
return false;
}

if(document.f1.username.value == '')
{
alert('Please Enter Username!');
return false;
}

if(!(alpnum.match(/^[a-zA-Z0-9]+$/)))
{
alert('Use Only AlphaNumeric');
return false;
}

if(document.f1.password.value == '')
{
alert('Please Enter Password!');
return false;
}

}

</script>
<script type="text/javascript">
    window.history.forward();
    function noBack(){ window.history.forward(); }
</script>
</head>
<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="" id="bg" background="center" style="margin:0px auto;background-position:top center">


<div id="wrapper">
	<div id="wrapbg">
	     <div id="formbg">
		  <div id="formcont">
		    <form action="web_services/login_parse.php" name="f1" method='POST'> <br><br><div style="color:red;text-align:center;font-size:20px;padding-top: 8px; margin-top: 40px\9;" id="sherr"><?php showMessage();?></div> <br>
		    <div id="userimg">  </div> <input type="text" name="username" class="inputimg" /><br />
		    <div id="passimg">  </div> <input type="password" name="password" class="inputimg" />
		    <!-- <div id="rememberwrap"><input type="checkbox" name="sqaureimg" id="squareimg" /> <div id="rememberimg"> </div> </div> <br /> -->
		    <div id="submitwrap"><input type="submit" id="subimg" name="Submit" value=""onclick='return validateme();' /></div> 
		   </form>
		  </div>
	     </div>
	</div>
</div>

</body>

</html>

