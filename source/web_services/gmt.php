<?php
include'config.php';
$split=$_REQUEST['split'];

//www.tritonetech.com/php_uploads/rnd/gmt.php?split=1
class gmt extends DB_Mysql
{

	public function getFullGmtData($split)
	{
	$query=CLS_MYSQL::Query("SELECT * FROM gmt_zones");
	$count=CLS_MYSQL::GetResultNumber($query);
	//echo"<pre>";
//var_dump($query);
	
		for($i=0;$i<$count;$i++)
		{
		$data['Result']['Data'][$i]['gmt_id']=CLS_MYSQL::GetResultValue($query,$i,'id');
		$data['Result']['Data'][$i]['gmt']=CLS_MYSQL::GetResultValue($query,$i,'gmt');
		$data['Result']['Data'][$i]['secondsDiff']=CLS_MYSQL::GetResultValue($query,$i,'secondsDiff');
		

		//$data['Result']['Data'][$i]['Location']=CLS_MYSQL::GetResultValue($query,$i,'Location');
		
		
		//print_r($location);
		//$spl=preg_split('/(,(?: ))/', $location);
		$location=CLS_MYSQL::GetResultValue($query,$i,'Location');
		/*if($split==1)
		{
		$data['Result']['Data'][$i]['Location']=preg_split('/(,(?: ))/', $location);
		}
		else
		{
		$data['Result']['Data'][$i]['Location']=$location;
		}*/
		$data['Result']['Data'][$i]['Location']=($split==1)?preg_split('/(,(?: ))/', $location):$location;
		//print_r($spl);
		//exit();
		}
	
	$this->display($data);
	}

	public function display($data)
	{
	echo DB_Mysql::encode($data);

	}
}
$gmt=new gmt();
$gmt->getFullGmtData($split);


?>
