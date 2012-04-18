<?php
require_once('sssh.class.php');
$session=new MySessionHandler('118.102.132.147','nuthan','tritone123','vts');
session_start();
//var_dump($_SESSION["UID"]);
//exit();
isset($_SESSION["UID"])?$_SESSION["UID"]:header("location:logout_api.php");
/*if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minates ago
    session_destroy();   // destroy session data in storage
    session_unset();     // unset $_SESSION variable for the runtime
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp*/

//on session creation
/*if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 1800) {
    // session started more than 30 minates ago
    session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
}*/

?>
