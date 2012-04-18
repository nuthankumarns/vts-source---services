<?php $json=file_get_contents('http://www.tritonetech.com/php_uploads/rnd/latlong.php?option=2');
var_dump($json);
$data=json_decode($json,true);
print_r($data);
echo $data[result][latitude];

?>

