<?php
include'config.php';


//www.tritonetech.com/php_uploads/rnd/gmt.php?split=1
class apn extends DB_Mysql
{

	public function getFullApnData()
	{
	$query=CLS_MYSQL::Query("SELECT * FROM apn_settings");
	$count=CLS_MYSQL::GetResultNumber($query);
	//echo"<pre>";
//var_dump($query);
	
		for($i=0;$i<$count;$i++)
		{
		$data['Result']['Data'][$i]['apn_id']=CLS_MYSQL::GetResultValue($query,$i,'id');
		$data['Result']['Data'][$i]['apn_settings']=CLS_MYSQL::GetResultValue($query,$i,'apn_settings');
		$data['Result']['Data'][$i]['network']=CLS_MYSQL::GetResultValue($query,$i,'network');
		$data['Result']['Data'][$i]['country']=CLS_MYSQL::GetResultValue($query,$i,'country');
		

		
		}
	
	$this->display($data);
	}

	public function display($data)
	{
	echo DB_Mysql::encode($data);

	}
}
$apn=new apn();
$apn->getFullApnData();


?>
