<?php
//ini_set("display_errors", "1");
//error_reporting(E_ALL);
//How to use - Begin
require_once ("GsgumaMail.class.php");
$Email = New GsgumaMail();
$Email-> setName("nuthan");                                  //To name
$Email-> setMail("nuthankumarns@gmail.com");                       //To e-mail
$Email-> setSubject("test");                            //Subject
$Email-> setMessage("this \n is \n testing"); //Message
echo $Email-> sendMail() ? "Ok!" : "Error!";               //Send e-mail
//How to use - End
?>
