<?php
require_once('sssh.class.php');
$session=new MySessionHandler('localhost','nuthan','tritone123','vts');
session_start();
session_destroy();
//echo "nuthan";exit();
//var_dump($_SESSION['isLoggedIn']);exit();
header("Location: index.php?msg=3");
?>
