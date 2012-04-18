<?php
//http://www.tritonetech.com/php_uploads/rnd/registration.php?module=registration&user_name=&user_pass=&uid=&mobile=&offset&user_mail=&alias=
	if(isset($_REQUEST['Submit']))
	{
$username=$_REQUEST['username'];
$password=$_REQUEST['password'];
$uid=$_REQUEST['uid'];
$mobile=$_REQUEST['mobile'];
$offset=$_REQUEST['offset'];
//var_dump($offset);
//exit();
$alias=$_REQUEST['alias'];
$email=$_REQUEST['Email'];
//var_dump($username);
		//$loginSystem = new LoginSystem();
		if(($username) || ($password) || ($uid) || ($mobile) || ($offset) || ($email) || ($alias))
		{
$response=file_get_contents("http://www.tritonetech.com/php_uploads/rnd/registration.php?module=registration&user_name=$username&user_pass=$password&uid=$uid&mobile=$mobile&offset=$offset&user_mail=$email&alias=$alias");
			$array=json_decode($response,true);
//print_r($array);
$status=$array['Result']['Data'][0]['Status'];
//var_dump($array);
//echo($status);
		if($status=="Registration was successful")
		{
		
			header("location: index.php");
		}
		
		
		else
		{
		
			header("location: register.php?msg=$status");
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
		
		if(($_GET['msg']))
		{
	//echo $status;
	echo ($_GET['msg']);
			/*switch($_GET['msg'])
			{
				case 1: echo "all fields are compulsory.";
				break;

				case 2: echo "Incorrect Login Details";
				break;
				
				case 3: echo "successfully logged-out";
				break;
			}*/
		}
	}
?>
<html>

<head>
<title> </title>

<style type="text/css">

#bg{

background: url('assets/regis.png') no-repeat;
width:960px;
margin:0px auto;
background-position:top center;
}

#regformwrap{

border: solid black 0px;

}

.inputimg{

background: url('assets/place_holder.png') no-repeat;
float:left;
width:225px;
height:45px;
border:none;
padding-left:12px;
}
.selimg{

/*background: url('assets/place_holder.png') no-repeat;*/
//float:left;
width:290px;
height:30px;
//border:none;
margin-top:9px;
padding-left:63px;
}

#userimg{

background: url('assets/username.png') no-repeat;
width:280px;
height:45px;
float:left;
}

#passimg{

background: url('assets/password.png') no-repeat;
width:280px;
height:45px;
clear:both;
float:left;
}

#confirmimg{

background: url('assets/confirm_pass.png') no-repeat;
width:280px;
height:45px;
clear:both;
float:left;
}

#emailimg{

background: url('assets/emailed.png') no-repeat;
width:280px;
height:45px;
clear:both;
float:left;
}

#mobileimg{

background: url('assets/mobile_no.png') no-repeat;
width:280px;
height:45px;
clear:both;
float:left;
}

#deviceimg{

background: url('assets/device_name.png') no-repeat;
width:280px;
height:45px;
clear:both;
float:left;
}

#logformcontent{

border: solid red 0px;
width:665px;
margin:0px auto;
margin-top:20px;

}

#logsub{

border: solid green 0px;
margin-left:94px;
margin-top:75px;

}

#submitwrap{

clear:both;
}

#subimg{

background: url('assets/submit.png') no-repeat;
clear:both;
width:145px;
height:56px;
margin-left:240px;
margin-top:40px;
border:none;
}
.error_strings{ font-family:Verdana; font-size:14px; color:#660000; background-color:#ff0;}
</style>
<script src="gen_validatorv4.js" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>

<body id="bg">

<div id="wrapper">

	<div id="regformwrap">
	     <div id="logformcontent">
		<div id="logsub">	
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='GET' id='myform'> <br><br><br><br>
		    <!--<div id="userimg">  </div> <input type="text" name="username" id="username" class="inputimg" />
		    <div id="passimg">  </div> <input type="text" name="password" id="password" class="inputimg" />
		    <div id="confirmimg">  </div> <input type="text" name="confpassword" class="inputimg" />
		    <div id="emailimg">  </div> <input type="text" name="Email" id="Email" class="inputimg" />-->
		    <div id="deviceimg">  </div> <input type="text" name="uid" id="uid" class="inputimg" />
			<div id="deviceimg">  </div> <input type="text" name="alias" id="alias" class="inputimg" />
		    <div id="mobileimg">  </div> <input type="text" name="mobile" id="mobile" class="inputimg" />
					<div id="mobileimg"> </div>	<select name="offset" id="city-list" class="selimg">
                				<option value="">Select your country</option>
           					 </select>
			<!--<div id="offsetimg"></div><input type="text" name="offset" id="offset" class="inputimg"/>-->
			
			<div id="submitwrap"><input type="submit" id="subimg" name="Submit" value="" /></div> 	
			
            
			<!--<div id="myform_errorloc" class="error_strings"></div>			    -->
		</form>	
<div id='myform_errorloc' class="error_strings"></div>
		</div>
	     </div>
	</div>
<div style="color:red;text-align:center;font-size:25px;"><?php showMessage();?></div>
</div>
<script language="JavaScript" type="text/javascript" xml:space="preserve">
  var frmvalidator  = new Validator("myform");
 // frmvalidator.EnableOnPageErrorDisplaySingleBox();
 // frmvalidator.EnableMsgsTogether();
 frmvalidator.EnableMsgsTogether();
  frmvalidator.addValidation("username","req","Please enter your Name");
 frmvalidator.addValidation("password","req","Please enter your password");
  frmvalidator.addValidation("confpassword","eqelmnt=password","The confirmed password is not same as password");
  frmvalidator.addValidation("password","neelmnt=username","The password should not be same as username");
   frmvalidator.addValidation("Email","maxlen=50");
 frmvalidator.addValidation("Email","req","please enter your email id");
 frmvalidator.addValidation("Email","email")
 frmvalidator.addValidation("uid","req","Please enter your device id");
	 frmvalidator.addValidation("mobile","req","please enter your mobile number");
  frmvalidator.addValidation("mobile","maxlen=50");
  frmvalidator.addValidation("mobile","numeric");
 frmvalidator.addValidation("alias","req","please enter vehicle alias");
//frmvalidator.addValidation("offset","req","Please select offset");
</script>
</body>

</html>
