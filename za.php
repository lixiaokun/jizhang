<?php
	header('Content-type: text/html;charset=utf-8');
	$link = mysql_connect('localhost','root','123456');
	mysql_select_db('test');
	date_default_timezone_set("PRC");
	$sql = 'select * from jz';
	$result = mysql_query($sql);
	$total = 0;
	$today = 0;
	$month = 0;
	$sanyi = array(1,3,5,7,8,10,12);
	$today_start = strtotime(date('Y-m-d').' 00:00:00');
	$today_end = strtotime(date('Y-m-d').' 23:59:59');
	$month_start = strtotime(date('Y-m').'-1 00:00:00');
	if(in_array(date('m'), $sanyi))
		$month_end = strtotime(date('Y-m').'-31 23:59:59');
	else
		$month_end = strtotime(date('Y-m').'-30 23:59:59');
	date_default_timezone_set("PRC");
	while(list($id,$lb,$je,$time) = mysql_fetch_array($result,MYSQL_NUM)){
		$total += $je;
		if($time > $today_start && $time < $today_end){
			$today += $je;
		}
		if($time > $month_start && $time < $month_end){
			$month += $je;
		}
	}
	if($_GET['huoq']){
		echo $month.'-'.$today.'-'.$total;
	}