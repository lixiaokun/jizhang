<?php
	$w = $_POST['w'];
	if(strstr($w, '<option>') ){
		if(file_exists('./select.xml')){
			$wb = file_get_contents('./select.xml');
			$pos = strpos($wb, '</opt>');
			$lj = substr($wb, 0,$pos) . $w .'</opt>';
			echo $lj;
			$fp = fopen('./select.xml', 'w');
			if(fwrite($fp, $lj))
				echo '写入成功';
			else
				echo '写入失败';
			fclose($fp);
		}
	}
?>