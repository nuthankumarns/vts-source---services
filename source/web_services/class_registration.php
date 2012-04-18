<?php
include'config.php';
include'httprequest.php';
require_once ("GsgumaMail.class.php");
//include'mail_class.php';
/**
 * Project:     Registration PHP Class
 * File:        class_registration.php
 * Purpose:     Register users in a mysql database
 *
 * For questions, help, comments, discussion, etc, please send
 * e-mail to antonio.desire@gmail.com
 *
 * @link http://antoniociccia.netsons.org
 * @author Antonio Ciccia <antonio.desire@gmail.com>
 * @package Registration PHP Class
 * @version 1.1
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/
 */

class Registration extends DB_Mysql
{
    private $databaseUsersTable;
    private $cryptMethod;
    private $showMessage;

    /**
     * Sets the database users table
     *
     * @param string $database_user_table
     */
    public function setDatabaseUserTable($database_user_table)
    {
        $this->databaseUsersTable=$database_user_table;
    }
    
    /**
     * Sets the crypting method
     *
     * @param string $crypt_method - You can set it as 'md5' or 'sha1' to choose the crypting method for the user password.
     */
    public function setCryptMethod($crypt_method)
    {
        $this->cryptMethod=$crypt_method;
    }

    /**
     * Crypts a string
     *
     * @param string $text_to_crypt -  crypt a string if $this->cryptMethod was defined.
     * If not, the string will be returned uncrypted.
     */
    public function setCrypt($text_to_crypt)
    {
	//echo "nuthan";exit();
        switch($this->cryptMethod)
        {
            case 'md5': $text_to_crypt=trim(md5($text_to_crypt)); break;
            case 'sha1': $text_to_crypt=trim(sha1($text_to_crypt)); break;
        }
       return $text_to_crypt;
    }
    
    /**
     * Anti-Mysql-Injection method, escapes a string.
     *
     * @param string $text_to_escape
     */
    static public function setEscape($text_to_escape)
    {
        if(!get_magic_quotes_gpc()) $text_to_escape=mysql_real_escape_string($text_to_escape);
        return $text_to_escape;
    }
    
    /**
     * If on true, displays class messages
     *
     * @param boolean $database_user_table
     */
    public function setShowMessage($registration_show_message)
    {
        if(is_bool($registration_show_message)) $this->showMessage=$registration_show_message;
    }
    
    /**
     * Prints the class messages with a customized style if html tags are defined
     *
     * @param string $message_text - the message text
     * @param string $message_html_tag_open - the html tag placed before the text
     * @param string $message_html_tag_close - the html tag placed after the text
     * @param boolean $message_die - if on true die($message_text);
     */
    public function getMessage($message_text, $message_html_tag_open=null, $message_html_tag_close=null, $message_die=false)
    {
        if($this->showMessage)
        {
            if($message_die) die($message_text);
            else echo DB_Mysql($message_html_tag_open . $message_text . $message_html_tag_close);
        }
    }

	public function display($data)
	{
	$dataDB['Result']['Data'][0]['Status']=$data;
	echo DB_Mysql::encode($dataDB);
	}
	
    
    /**
     * Register user in the database
     *
     * The user form data needed is: user_name, user_pass, user_confirm_pass, user_mail, user_confirm_mail
     */
	public function checkFields($imei,$mobile,$offset,$alias,$admin_mob,$apn)
	{
	if($imei=='' || $mobile=='' || $offset=='' || $alias==''||$admin_mob==''||$apn=='')
		{
		$data="missing parameters";
		$this->display($data);
		exit();

		}

	}

	public function updateFields($mobile,$offset,$alias,$admin_mob,$apn,$device_id)
	{
		if($mobile=='' || $offset=='' || $alias==''|| $admin_mob==''|| $apn=='' || $device_id=='')
		{
		$data="missing parameters";
		$this->display($data);
		exit();

		}

	}

	public function enquiryFields($name,$email,$phone,$message)
	{
		if($email=='' || $name=='' || $phone==''|| $message=='')
		{
		$data="missing parameters";
		$this->display($data);
		exit();

		}

	}

    public function setUserRegistration($user_id)
    {
        if(!$this->databaseUsersTable) $this->getMessage('contact nuthan','','','true');
	
	$imei=$_REQUEST['imei'];
	//var_dump($imei);
	$admin_mob=$_REQUEST['admin_mob'];
	$apn=$_REQUEST['apn'];
	$mobile=$_REQUEST['mobile'];
	$offset=$_REQUEST['offset'];
	$alias=$_REQUEST['alias'];
	$this->checkFields($imei,$mobile,$offset,$alias,$admin_mob,$apn);
	//$user_id=$_SESSION['user_id'];
        //$user_confirm_pass=$_POST['user_confirm_pass'];
       // $user_mail=$_REQUEST['user_mail'];
       // $user_confirm_mail=$_POST['user_confirm_mail'];
       // $user_crypted_pass=$this->setCrypt($user_pass);
	
        $query=CLS_MYSQL::Query("SELECT * FROM user_devices WHERE imei='$imei'");
	$count=CLS_MYSQL::GetResultNumber($query);
			
       // $result_user_mail=CLS_MYSQL::Query("SELECT * FROM"." ".$this->databaseUsersTable." "."WHERE user_mail='$user_mail'");
	
		
		$count=CLS_MYSQL::GetResultNumber($query);
		//var_dump($count);
		//$imei=CLS_MYSQL::GetResultValue($query,0,'imei');
		//$uid==CLS_MYSQL::GetResultValue($query,0,'uid');
		//var_dump($uid)
	if($count==1) {$this->display('device id already exist');
		}
        //elseif((strlen($user_name)<6) or (strlen($user_name)>16)) $this->display('Entered username length must be of 6 to 16 characters');
        //elseif(CLS_MYSQL::GetResultNumber($query)) $this->display('Entered username already exists in the database');
        //elseif((strlen($user_pass)<6) or (strlen($user_pass)>16)) $this->display('Entered password length must be of 8 to 16 characters');
        //elseif($user_pass!=$user_confirm_pass) $this->getMessage('Passwords entered do not match.');
       // elseif(CLS_MYSQL::GetResultNumber($result_user_mail)) $this->display('Entered email already exists in the database.');
       // elseif($user_mail!=$user_confirm_mail) $this->getMessage('Email addresses entered do not match.');
        //elseif(!preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{4,})+\.)+([a-zA-Z0-9]{2,})+$/", $user_mail)) $this->display('Email address entered is not valid');
        else
        {
		$query=CLS_MYSQL::Query("SELECT * FROM users WHERE user_id='$user_id'");
	  $user_name=CLS_MYSQL::GetResultValue($query,0,'user_name');
		$user_mail=CLS_MYSQL::GetResultValue($query,0,'user_mail');
		$user_pass=CLS_MYSQL::GetResultValue($query,0,'user_pass');
            if(CLS_MYSQL::Execute("INSERT INTO user_devices (user_id, mobile, offset, imei, alias) VALUES ('$user_id','$mobile','$offset','$imei','$alias')")) 
		$Email = New VTSMail();
		$Email-> setName($user_name);                                  //To name
		$Email-> setMail($user_mail);                       //To e-mail
		$Email-> setSubject("VTS Registration");                            //Subject
		$Email-> setMessage("VTS Registration for Device IMEI:$imei");
		$Email-> sendMail();
		//var_dump($Email);
		 $this->display('Registration was successful');
        }
    }

	public function updateDetails()
	{
		if(!$this->databaseUsersTable) $this->getMessage('contact nuthan','','','true');
	
	$admin_mob=$_REQUEST['admin_mob'];
	$apn=$_REQUEST['apn'];
	$mobile=$_REQUEST['mobile'];
	$offset=$_REQUEST['offset'];
	$alias=$_REQUEST['alias'];
	$device_id=$_REQUEST['device_id'];
	$this->updateFields($mobile,$offset,$alias,$admin_mob,$apn,$device_id);
		
	$query=(CLS_MYSQL::Execute("UPDATE user_devices SET admin_mob='$admin_mob',apn_settings='$apn',mobile='$mobile',offset='$offset',alias='$alias' WHERE id='$device_id'"));
	//$count=CLS_MYSQL::GetResultNumber($query);
	$rows=CLS_MYSQL::AffectedRows($query);
		if($rows==1)
		{
		$Email = New VTSMail();
			$Email-> setName($user_name);                                  //To name
			$Email-> setMail($user_mail);                       //To e-mail
			$Email-> setSubject("VTS Updation");                            //Subject
			$Email-> setMessage("VTS Updation for Device");
			$Email-> sendMail();
			//var_dump($Email);
			 $this->display('Updation was successful');
		}
		else
		{
		 $this->display('Fields Remain same');
		}
	}

	public function enquiry($user_id)	
	{
	$name=$_REQUEST[name];
	$phone=$_REQUEST[phone];
	$email=$_REQUEST[email];
	$message=$_REQUEST[message];
	$admin="nuthan@tritonetech.com";
	$sub="VTS Enquiry";
	$this->enquiryFields($name,$email,$phone,$message);
		$Email = New VTSMail();
			$Email-> setName($name);                                 
			$Email-> setMail($admin);                
			$Email-> setSubject("VTS Enquiry");                          
			$Email-> setMessage("$name,$phone,$email,$message");
			$Email-> sendMail();
		$Recipient = New VTSMail();
			$Recipient-> setName($sub);                                 
			$Recipient-> setMail($email);                
			$Recipient-> setSubject("VTS Enquiry");                          
			$Recipient-> setMessage("Thank You for Contacting Us, will revert back soon");
			$Recipient-> sendMail();
			
			//var_dump($Email);
			 $this->display('Enquiry sent');
	}


	/*public function forgotPassword($email)
	{
	$query=CLS_MYSQL::Query("SELECT user_mail FROM users WHERE user_mail='$email'");
	$count=CLS_MYSQL::GetResultNumber($query);
		if($count==0)
		{
		$dataDB['Result']['Data'][0]['Status']="Email does not exist";
		}
		else
		{


		}
	
	}*/
}

?>
