
<?php
/**
* @package HelloWorld
* @version 1.0
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software and parts of it may contain or be derived from the
* GNU General Public License or other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
 
$db = JFactory::getDBO();
$race = JRequest::getVar('race');
 
 
 
if($race){
# GET NO. OF participate in a race
 
$usr_qry = "SELECT distinct UserID,name"
. " FROM race_journey,jos_users"
. " WHERE (Latitude>0 or Longitude >0) and RaceID={$race} and jos_users.id=UserID order by UserID";
;
$db->setQuery($usr_qry);
$usr_rows = $db->loadObjectList();
//$itemrow = $rows[1];
    
    $j=0;
    $str_lat='';
    $str_lon='';
    $participants='';
    foreach($usr_rows as $row){
 
        $query = "SELECT distinct UserID,Latitude,Longitude"
        . " FROM race_journey"
        . " WHERE (Latitude>0 or Longitude >0) and RaceID={$race} and UserID={$row->UserID}";
        ;
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        //$itemrow = $rows[1];
            $i=0;
            $str_lon.="longs".$j." = new Array();\n";
            foreach($rows as $itemrow){
            
             $str_lat.="locations[".$i."] = ".$itemrow->Latitude.";\n";
             $str_lon.="longs".$j."[".$i."] = ".$itemrow->Longitude.";\n";
             $i++;
            
            }
        $participants.= "<tr><td>&nbsp;<img height='15' width='15' src='images/".$j.".png' /> ".$row->name." </td></tr>";
        
    $j++;    
    }
 
$time_qry = "SELECT max(DateTime) as mxtime, min(DateTime) as mntime"
. " FROM race_journey"
. " WHERE (Latitude>0 or Longitude >0) and RaceID={$race} AND DateTime > 0";
;
$db->setQuery($time_qry);
$time_rows = $db->loadObjectList();
foreach($time_rows as $row){
$max_time=date('H:i:s',strtotime($row->mxtime));
$min_time=date('H:i:s',strtotime($row->mntime));
}
?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAABO67c0yx46K95vriCvxUchR0IgmOfv8rwhUfsi9P3OGA1sQO7RQjUQM_osyumbPg6Iy5P45EePczEw" type="text/javascript"></script>
 
    <script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>
    <script src="http://cu.mobispector.com/sail/race.js" type="text/javascript"></script>
      <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <style type="text/css">
    #slider {      
    float: left;
    margin: 15px 20px 20px 0;
    width: 225px;  
    }
    .ui-widget-header {
    background: none repeat scroll 0 0 #347DEC;
    }
    </style>
 
 
   <div style="width:100%;float: left;">
   <div id="map" style="width: 520px; height: 380px;float:left;"></div>  
   <div style="float:left;border:1px solid #000;margin-left: 15px;">  
           <table style="color:#000;">
               <tr><th>Race Participants</th></tr>
               <tr><td>&nbsp;</td></tr>
            <?php    
                echo $participants;
            ?>
            <tr><td>Race start-<?php echo $min_time; ?></td></tr>
            <tr><td>Race end-<?php echo $max_time; ?></td></tr>
         </table>
        <?php
        $protest_qry = "SELECT distinct UserID,name,DateTime"
        . " FROM race_protest,jos_users"
        . " WHERE RaceID={$race} and jos_users.id=UserID order by UserID";
        ;
        $db->setQuery($protest_qry);
        $protest_rows = $db->loadObjectList();
        $protests='';
        $j=0;
        foreach($protest_rows as $row){
        $protest_time=date('H:i:s',strtotime($row->DateTime));
        $protests.="<tr><td>&nbsp;<img height='15' width='15' src='images/".$j.".png' /> ".$row->name."<br> <span style='font-size:9px;'>Logged protest at ".$protest_time."</span></td></tr>";
        $j++;
        }
        if($protests!=''){
        ?>
        
           <table style="color:#000; margin-top:50px;">
               <tr><td><b>Protests:</b></td></tr>
               <?php    
                echo $protests;
            ?>
         </table>
        <?php
        }
        ?>
          
          
   </div>
 
 
    <script type="text/javascript">
    
      stepnum = 0;
      pause_stepnum = 0;
      speed = 1500;
      locations = new Array();
      <?php echo $str_lat; ?>
      <?php echo $str_lon; ?>
       
    if (GBrowserIsCompatible()) {
      
      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(locations[0],longs0[0]),12);
    <?php
    $i=1;
    $j=0;
    $Point='';
    foreach($usr_rows as $data){
    # Creating participant Icons
         echo' var i'.$j.' = new GIcon();
         i'.$j.'.image=\'images/'.$j.'.png\';
         i'.$j.'.iconSize=new GSize(18,18);
         i'.$j.'.iconAnchor=new GPoint(16,9);';
          echo 'marker'.$i.' = new GMarker(new GLatLng(locations[0],longs'.$j.'[0]),{icon:i'.$j.'});';
        
        $mrk_array[]='marker'.$i;
        
        $Point.="   points".$i." = [
                    new GLatLng(locations[stepnum-1],longs".$j."[stepnum-1]),
                    new GLatLng(locations[stepnum],longs".$j."[stepnum])
                    ];\n
 
         polyline".$i." = new GPolyline(points".$i.", colours[".$j."], 5, 0.7);\n
         marker".$i.".setPoint(new GLatLng(locations[stepnum],longs".$j."[stepnum]));\n
         map.addOverlay(polyline".$i.");
        ";
        
    $i++;    
    $j++;
    }
     $markers=implode(',',$mrk_array);  
    ?>
    marker_arry = new Array(<?php echo $markers; ?>);
    
    
    var mgrOptions = {maxZoom: 15, trackMarkers: true };
    var mgr = new MarkerManager(map, mgrOptions);
    mgr.addMarkers(marker_arry, 6);
    mgr.refresh();
 
 
 
 
 
       
      /*
      points = [
      new GLatLng(locations[0],longs[0]),
      new GLatLng(locations[1],longs[1])
      ];
      polyline = new GPolyline(points, '#ff0000', 5, 0.7);
      */
      //marker = new GMarker(new GLatLng(51.49453,-3.038235));
      //map.addOverlay(marker);
      //map.addOverlay(polyline);
      function animate(d) {
      colours = new Array('#ff0000','#486E2F','#C71585','#0A2A29','#0080FF','#5F04B4','#F78181','#071910','#DF7401','#240B3B','#610B5E','#2A0A1B');
    <?php
    echo $Point;
    ?>
         /*
         if( (longs[stepnum] > longs1[stepnum]) && (longs[stepnum] > longs2[stepnum]) ) {
             if( longs1[stepnum] > longs2[stepnum]) {
                final_longs = longs1[stepnum];
             } else {
                final_longs = longs2[stepnum];
             }
         }
         */
        if(stepnum > 3){
        //map.setCenter(new GLatLng(locations[stepnum],longs0[stepnum]),12);
        }
 
 
 
         stepnum++;
         if(stepnum<locations.length)
         setTimeout("animate(0),mslide(stepnum)",speed);
          
 
      }
      stepnum++;
      // setTimeout("animate(0)",5000);
 
 
      function play() {
 
 
          if(document.getElementById('play').src=="http://regatta.mobispector.com/images/play.jpg")
          {
                document.getElementById('play').src="http://regatta.mobispector.com/images/pause.jpg";
              stepnum = pause_stepnum;
              animate(0);
              mslide(stepnum);
          }
          else
          {
                document.getElementById('play').src="http://regatta.mobispector.com/images/play.jpg";               
              pause_stepnum = stepnum;
              mslide(stepnum);
              stepnum = 0;
          }
 
      }
      function speeds(fast) {
          switch(fast) {
              case 1:
                      speed = 1500;
                      document.getElementById('speed').innerHTML='X1';
                      break;
              case 2:
                      speed = 1000;
                      document.getElementById('speed').innerHTML='X2';                       
                      break;
              case 5:
                      speed = 600;
                      document.getElementById('speed').innerHTML='X5';                                             
                      break;
              case 10:
                      speed = 300;
                      document.getElementById('speed').innerHTML='X10';                                             
                      break;
          }
      }
 
    }
   else
   {
      alert("Sorry, the Google Maps API is not compatible with this browser");
   }
 
   </script>
    
       <script type="text/javascript">
    
    $(function() {
    $("#slider").slider({
        range: "min",
        value: 1,
        min: 1,
        max: locations.length,
        slide: function(event, ui) {
            $("#amount").val('$' + ui.value);
        }
    });
     $("#amount").val('$' + $("#slider").slider("value"));  
    });
    
    function mslide(sval){
    $("#slider").slider({value: sval});
        if(locations.length==sval){
        $( "#slider" ).slider({ disabled: true });
        }
    }
    </script>
   </div>
   <div style="width:100%;">
   <input type="image" id ="play" value ="Play" onclick ="play()" src="images/play.jpg" style="width:40px; vertical-align:middle;"/>
<div id="slider"></div>
   <input type="button"  value ="X1" onclick ="speeds(1)" style="background:#FFFFFF;padding:10px;border: 1px solid #000000;"/>
   <input type="button"  value ="X2" onclick ="speeds(2)" style="background:#FFFFFF;padding:10px;border: 1px solid #000000;"/>
   <input type="button"  value ="X5" onclick ="speeds(5)" style="background:#FFFFFF;padding:10px;border: 1px solid #000000;"/>
   <input type="button"  value ="X10" onclick ="speeds(10)" style="background:#FFFFFF;padding:10px;border: 1px solid #000000;"/>
   <div>Speed: <b><span id="speed">X1</span></b></div>
  </div>
   
<?php }else{  
 
$user =& JFactory::getUser();
$q=JRequest::getVar('q');
if($q){
 
        $query = "SELECT distinct RaceID,race_name,race_series_name"
        . " FROM race_journey rj, race_management rm"
        . " WHERE (Latitude>0 or Longitude >0) and rj.RaceID=rm.race_id and rj.RaceID=". $q;
        ;
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        //$itemrow = $rows[1];
        $i=0;
        $races='<table style="width:100%;margin-top:25px;"><tr><th align="left">Race ID</th><th align="left">Race</th><th align="left">Series</th></tr>';
        
        foreach($rows as $itemrow){
        $races.="<tr><td><a href='index.php?option=com_map&race={$itemrow->RaceID}'>$itemrow->RaceID</a></td><td>$itemrow->race_name</td><td>$itemrow->race_series_name</td></tr>";
        $i++;
        
 
        
        }
                /*if($num_rows<1){
        $races='';
        $races.='<table style="width:100%;margin-top:25px;"><tr><td align="center"><b>No race found.</b></td></tr>';
        }*/
        $races.="</table>";
        
        
 
 
}else{
//if (!$user->guest) {
    if ($user->id) {
        $query = "SELECT distinct RaceID,race_name,race_series_name"
        . " FROM race_journey rj, race_management rm"
        . " WHERE (Latitude>0 or Longitude >0) and rj.RaceID=rm.race_id and UserID=". $user->id;
        ;
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $num_rows=$db->getNumRows();
        //$itemrow = $rows[1];
        $i=0;
        $races='<table style="width:100%;margin-top:25px;"><tr><td colspan=3><b>Your races:</b></td></tr><tr><th align="left">Race ID</th><th align="left">Race</th><th align="left">Series</th></tr>';
        foreach($rows as $itemrow){
        $races.="<tr><td><a href='index.php?option=com_map&race={$itemrow->RaceID}'>$itemrow->RaceID</a></td><td>$itemrow->race_name</td><td>$itemrow->race_series_name</td></tr>";
        $i++;
        
        }
        /*if($num_rows<1){
        $races='';
        $races.='<table style="width:100%;margin-top:25px;"><tr><td align="center"><b>You havn\'t taken part in any race.</b></td></tr>';
        }*/
        $races.="</table>";
        
      //echo 'User name: ' . $user->username . '<br />';
      //echo 'Real name: ' . $user->name . '<br />';
      //echo 'User ID  : ' . $user->id . '<br />';
    }
 
}
?>
 <div>Search Races:<form method="post" action=""> <input type="text" name="q"   /> <input type="submit" name="submit" value="Search" style='background-color: #0054A5; box-shadow:5px -5px 10px #700; -webkit-box-shadow:5px -5px 10px #888; -moz-border-radius: 5px; -webkit-border-radius: 5px; border: 1px solid #0054A5; padding:5px; color:#fff;' /></form></div>  
 
 <div style="width:100%;">
     <?php
         
        echo $races;
     ?>
 </div>
 
 <? } ?>

