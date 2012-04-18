<?php
include'config.php';
include'set_session.php';

class Faq extends DB_Mysql
{
public function display($dataDB)
	{
	//$dataDB['Result']['Data'][0]['Status']=$data;
	echo DB_Mysql::encode($dataDB);
	}

public function fetchFaq()
	{
	$query=CLS_MYSQL::Query("SELECT * FROM faq");
	$count=CLS_MYSQL::GetResultNumber($query);
	for($i=0;$i<$count;$i++)
	{
	$dataDB['Result']['Data'][$i]['Faq']=CLS_MYSQL::GetResultValue($query,$i,'faq');

	}
	$this->display($dataDB);

}


}
$faq=new Faq;
$faq->fetchFaq();



?>


