<?php
// Including the class
require_once("class_registration.php");
//include'config.php';
/// You must establish a connection to the mysql database before using this class
/*$database_connection=mysql_connect("localhost", "root", "paswd");
$database_selection=mysql_select_db("classi", $database_connection);*/
//var_dump($_GET['module']);
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

    $registration->setUserRegistration();
}
?>

<head>
    <style>
        h1 {
            color: #555;
            font-size: 16px;
            text-decoration: underline;
        }
        form#registration_form {
            background: #FFFFCC;
            border: 1px solid #555;
            color: #555;
            width: 500px;
        }
        label.registration_label {
            float: left;
            margin-left: 50px;
            margin-bottom: 10px;
            width: 200px;
            text-align: left;
        }
        
        label.registration_label:hover {
            background: #FFFFCC;
        }
        
        input.registration_input {
            color: #777;
            font-size: 11px;
            margin-bottom: 10px;
            width: 200px;
        }
        input.registration_submit {
            width: 200px;
            margin-left: 150px;
        }
        hr.registration_hr {
            color: #555;
            clear: both;
            height: 0px;
            margin-bottom: 10px;
            width: 450px;
        }
    </style>
</head>
<body>
    <h1>Registration Module:</h1>
    <p><small>Look the source of this file to view the html code used in the form shown below:</small></p>
    <form action="?module=registration" id="registration_form" method="post">
        <p>
            <label class="registration_label">Username:</label><input name="user_name" class="registration_input">
            <label class="registration_label">Password:</label><input name="user_pass" class="registration_input">
		<label class="registration_label">uid:</label><input name="uid" class="registration_input">
		<label class="registration_label">Mobile No.:</label><input name="mobile" class="registration_input">
		<label class="registration_label">Offset:</label><input name="offset" class="registration_input">
           <!-- <label class="registration_label">Re-enter Password:</label><input name="user_confirm_pass" class="registration_input">-->
            <label class="registration_label">E-mail:</label><input name="user_mail" class="registration_input">
            <!--<label class="registration_label">Re-enter E-mail:</label><input name="user_confirm_mail" class="registration_input"">-->
            <hr class="registration_hr" />
            <input type="submit" class="registration_submit">
        </p>
    </form>
</body>
