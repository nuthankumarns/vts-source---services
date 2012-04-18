<?php
// Including the class
include'set_session.php';
$user_id=$_SESSION['UID'];
require_once("class_registration.php");
//print_r($_REQUEST);exit();
//var_dump($user_id);exit();
//include'config.php';
/// You must establish a connection to the mysql database before using this class
/*$database_connection=mysql_connect("localhost", "root", "paswd");
$database_selection=mysql_select_db("classi", $database_connection);*/
//var_dump($_GET['module']);
//http://www.tritonetech.com/php_uploads/rnd/registration.php?module=registration&user_name=&user_pass=&uid=&mobile=&offset=&user_mail=&alias=
if(isset($_GET['module']) && ($_GET['module']=="registration"))
{
   // var_dump($_POST['user_name']);
    // Instantiating the class object
    
    $registration = new Registration();
    
    # Class configuration methods:
    
    // Setting the user table of mysql database
    $registration->setDatabaseUserTable('users');
    
    // Setting the crypting method for passwords, can be set as 'sha1' or 'md5'
    $registration->setCryptMethod('sha1');
    
    // Setting if class messages will be shown
    $registration->setShowMessage(true);
    
    # Creating user account:
//var_dump($user_id);
    $registration->setUserRegistration($user_id);
}
?>
