<?php
	$id = $_GET['id'];
	$sql = 'delete from jz where id ='.$id;
	mysql_connect('localhost','root','123456');
	mysql_select_db('test');
	if(mysql_query($sql))
		$info = 'del success';
	else
		$info = 'del error';
	echo "<script>window.location.href='index.php';</script>";
?>