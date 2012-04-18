#!/usr/bin/php -q
<?php
//
//include'../config.php';
//$deviceToken = '70b50c34 6e14aaab 7010198b 65f1f989 a75845b0 e33b4e52 4b8f85f7 83cf9699';
// Passphrase for the private key (ck.pem file)
// $pass = '';

// Get the parameters from http get or from command line
/*$message = $_GET['message'] or $message = $argv[1] or $message = 'Message received.';
$badge = (int)$_GET['badge'] or $badge = (int)$argv[2];*/
//$sound = $_GET['sound'] or $sound = $argv[3];

// Construct the notification payload
$message="vts Success!!!";
$badge="1";
$sound="1";
$body = array();
$body['aps'] = array('alert' => $message);
if ($badge)
  $body['aps']['badge'] = $badge;
if ($sound)
  $body['aps']['sound'] = $sound;

/* End of Configurable Items */

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'apns-prod.pem');

//$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 10, STREAM_CLIENT_CONNECT, $ctx);

$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 10, STREAM_CLIENT_CONNECT, $ctx);

if (!$fp) {
    print "Failed to connect $err $errstr\n";
    return;
}
else {
   print "Connection OK\n";
}
$link = mysql_connect('localhost', 'nuthan', 'tritone123');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';

mysql_select_db('vts');

$sql    = 'SELECT device_token FROM apns';
$deviceTokens = mysql_query($sql, $link);
//var_dump($deviceTokens);exit();
while ($row = mysql_fetch_assoc($deviceTokens)) {
	$deviceToken = $row['device_token'];
	$payload = json_encode($body);
	print "sending message :" . $payload . "\n";
	//$msg = chr(0) . pack("n",32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n",strlen($payload)) . $payload;
	$msg = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $deviceToken)) . chr(0) . chr(strlen($payload)) . $payload;
	fwrite($fp, $msg);
}
//socket_close($fp);
fclose($fp);
?>
