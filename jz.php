<?php
	$link = mysql_connect('localhost','root','123456');
	mysql_select_db('test');
	$lb = $_POST['lb'];
	$je = $_POST['je'];
	$del = '';
	$del = array_search('请选择', $lb);		
	if($del || $del === 0){
		unset($lb[$del]);
		unset($je[$del]);
	}
	$sql = "insert into jz(`lb`,`je`,`time`) values";
	foreach ($lb as $key => $value) {
		if(is_numeric($je[$key]))
			$sql .= '("'.$lb[$key].'","'.$je[$key].'","'.time().'"),';	
	}
	$sql = substr($sql, 0,-1);
	$sql .= ';';
	if(mysql_query($sql)){
		$info = 'success';
	}else{
		$info = 'error';
	}
	echo "<script>alert('$info');window.location.href='index.php';</script>";
?>