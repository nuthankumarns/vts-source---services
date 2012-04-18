<?php
//include'config.php';
//include'httprequest.php';
//require_once ("GsgumaMail.class.php");


require_once("class_registration.php");
//include'class_registration.php';
$email=$_REQUEST['email'];
//var_dump($email);
class authenticate extends Registration
{

	var $email;

	public function resetPasscode($string,$email)
	{
		//$this->setCryptMethod('sha1');
		//$rand=$this->setCrypt($string);
		
		CLS_MYSQL::Execute("UPDATE users SET user_active='$string' WHERE user_mail='$email'");
	}

	public function forgotPassword($email)
	{
	//var_dump($email);exit();
	$query=CLS_MYSQL::Query("SELECT user_name,user_mail FROM users WHERE user_mail='$email'");
	//echo "SELECT user_name,user_mail FROM users WHERE user_mail='$email'";
	//var_dump($query);exit();
	$count=CLS_MYSQL::GetResultNumber($query);
		if($count==0)
		{
		$data="Email does not exist";
		$this->display($data);
		}
		else
		{
		$user_name=CLS_MYSQL::GetResultValue($query,0,'user_name');
		$string=$this->random_string();
		//var_dump($string);
		
		//var_dump($rand);
		//echo sha1($string);
		//echo "9011d6581a45b82e5f559063c4aa6d367e5c3ac5";
		//var_dump(sha1($string));exit();
		$this->resetPasscode($string,$email);
		//exit();
		$Email = New VTSMail();
		$Email-> setName($user_name);                                  //To name
		$Email-> setMail($email);                       //To e-mail
		$Email-> setSubject("Registration");                            //Subject
		$Email-> setMessage("Password Reset Successful\n Your Passcode:$string");
		$Email-> sendMail();
		 $this->display('Password reset successful');

		}
	
	}

	function random_string( )
  {
    $character_set_array = array( );
    $character_set_array[ ] = array( 'count' => 7, 'characters' => 'abcdefghijklmnopqrstuvwxyz' );
    $character_set_array[ ] = array( 'count' => 1, 'characters' => '0123456789' );
    $temp_array = array( );
    foreach ( $character_set_array as $character_set )
    {
      for ( $i = 0; $i < $character_set[ 'count' ]; $i++ )
      {
        $temp_array[ ] = $character_set[ 'characters' ][ rand( 0, strlen( $character_set[ 'characters' ] ) - 1 ) ];
      }
    }
    shuffle( $temp_array );
    return implode( '', $temp_array );
  }

	

	  



}

$forgot=new authenticate();

$forgot->forgotPassword($email);


//var_dump($forgot);


?>
