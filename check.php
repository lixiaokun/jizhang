<?php
	$link = mysql_connect('localhost','root','123456');
	mysql_select_db('test');
	$date =  $_GET['date'];
	date_default_timezone_set("PRC"); 
	$start_time = strtotime('2013-'.$date.' 00:00:00');
	$end_time = strtotime('2013-'.$date.' 23:59:59');
	$sql = 'select * from jz where time >='.$start_time.' and time <='.$end_time;
	$res = mysql_query($sql);
	while(list($id,$lb,$je,$time) = mysql_fetch_array($res,MYSQL_NUM)){
		$c_time = date("Y/m/d H:i:s",$time);
		$html[]= "$lb-$je-$c_time-$id";
	}
	echo json_encode($html);
?>
					