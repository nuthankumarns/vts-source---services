<?php
$request='http://www.tritonetech.com/php_uploads/rnd/location_try.php?option=2';
$json = file_get_contents($request);
function json_code ($json) {
//remove curly brackets to beware from regex errors
$json = substr($json, strpos($json,'{')+1, strlen($json));
$json = substr($json, 0, strrpos($json,'}'));
$json = preg_replace('/(^|,)([\\s\\t]*)([^:]*) (([\\s\\t]*)):(([\\s\\t]*))/s', '$1"$3"$4:', trim($json));
return json_decode('{'.$json.'}', true);
}

//echo "<pre>";
$convertedtoarray = json_code($json);

//print_r($convertedtoarray);
$latitude[]=$convertedtoarray['latitude'];
print_r($latitude);
$longitude[]=$convertedtoarray['longitude'];
print_r($longitude);
$count='1'?>
