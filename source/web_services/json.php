<?php
  //  $cities = array('Adelaide','Perth','Melbourne','Sydney');
    $cities['Result']['Data']= array(array("location"=>'Adelaide',"id"=>'1'),array("location"=>'Perth',"id"=>'2'),array("location"=>'Melbourne',"id"=>'3'),array("location"=>'Sydney',"id"=>'4'));
   // header('Content-type: application/json');
    echo json_encode($cities);
?>
