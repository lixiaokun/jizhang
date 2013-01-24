<?php
	header('Content-type: text/html;charset=utf-8');
	$link = mysql_connect('localhost','root','123456');
	mysql_select_db('test');
	$sql = 'select * from jz';
	$result = mysql_query($sql);
	$total = 0;
	$month = 0;
	date_default_timezone_set("PRC");
	while(list($id,$lb,$je,$time) = mysql_fetch_array($result,MYSQL_NUM)){
		$total += $je;
		//$c_time = date("Y-m-d H:i:s",$time);
		//$c_html .= "$lb : <b style='color:red'>$je ￥</b> $c_time <a href = 'del.php?id=$id'>X</a><br>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src = './jquery.js'></script>
	<style>
		#main{width:400px;margin:0 0 0 200px;text-align: center;float: left;}
		#add,#bc{margin-top: 10px;padding-top:0px;}
		#check{width:400px;height:200px;margin:0 0 0 150px;float: left;}
		#check select{margin-bottom:10px;margin-right: 10px}
	</style>
</head>
<body>
	<div id = 'main'>
		<h1>add</h1>
		<form name = 'jz' method = 'post' action = 'jz.php'>
		<div class = 'clone'>	
		  类别：<select id = 'select' name = 'lb[]'></select>　
		  金额：<input type = "text" class = 'text' name = 'je[]'>
		</div>
			<input type = 'button' value = '添加' id = 'add'>
			<input type = 'button' value = '添加类别' id = 'addlb'>
			<input type = 'submit' value = '保存' id = 'bc'>
		</form>
		今日总额：<input type = text id = 'today' size = 5 readonly>
		今月总额：<input type = text id = 'month' size = 5 readonly>
		当前总额：<input type = text id = 'total' size = 5 readonly value = '<?php  echo $total;?>'>
	</div>
	<div id = 'check'>
		<center><h1>check</h1></center>
		<select id = 'c_month'>
			<option>选择月</option>
			<?php
				for($i = 1;$i <= 12;$i++)
					echo '<option>'.$i.'</option>';
			?>
		</select>
		<select id = 'c_day'>
			<option>选择天</option>
		</select><br>
		<div id = 'content'>
		
		</div>
	</div>
	<script>
		$(function(){
			function loadXmlFile(xmlFile){   
          		var xmlDom = null;   
          		if (window.ActiveXObject){   
           			xmlDom = new ActiveXObject("Microsoft.XMLDOM");   
            		xmlDom.async=false;   
           			xmlDom.loadXML(xmlFile);//如果用的是XML字符串//如果用的是xml文件   
          		}else if (document.implementation && document.implementation.createDocument){   
            		var xmlhttp = new window.XMLHttpRequest();   
            		xmlhttp.open("GET", xmlFile, false);   
            		xmlhttp.send(null);   
            		xmlDom = xmlhttp.responseXML;   
          		}else{   
            		xmlDom = null;   
          		}   
          		return xmlDom;   
        	}
        	function updateSelect(){    
		        var xml = loadXmlFile('select.xml');
		        var items=xml.getElementsByTagName("option");
		        var s_html = '',trans = []; 
		        for(var i = 0;i < items.length;i++){
		        	var text = $(items[i]).text();
		        	var temp = text.split('-'),v = '',t = '';
		        	v = temp[0];
		        	t = temp[1];
		        	s_html += '<option value='+t+'>'+v+'</option>';
		        	trans[t] = v;
		        }
	        	$('#select').html(s_html);
        	}
        	updateSelect();
			$('#add').click(function(){
				var jia = 0;
				for(var i = 0;i < $('.text').length;i++){
					jia += parseInt($('.text').eq(i).val());
				}
				if(!isNaN(jia))
					$('#today').val(jia);

				var clone = $('.clone').clone().eq(0);
				$('#add').before(clone);
				$('div[class=clone]:last').children('.text').val('')
				var l = $('.clone').length;
				if(l == 5)
					alert('今天的项目有点多');
			});
			var shao = ['4','6','9','11'],duo = ['1','3','5','7','8','10','12'];
			$('#c_month').change(function(){
				var m = $(this).val(),html = '';
				var d = $.inArray(m,duo),s = $.inArray(m,shao);
				html = '';
				if(d >= 0){
					for(var i = 1;i <= 31;i++){
						html += '<option>'+i+'</option>';
					}
				}else if(s >= 0){
					for(var i = 1;i <= 30;i++){
						html += '<option>'+i+'</option>';
					}
				}else{
					for(var i = 1;i <= 29;i++){
						html += '<option>'+i+'</option>';
					}
				}
				if(m == '选择月') html = '<option>选择天</option>';
				$('#c_day').html(html);
			});
			$('#c_day').change(function(){
				var cs = $('#c_month').val() + '-' + $(this).val();
				$.get('./check.php?date='+cs,function(data){
					//: <b style='color:red'>$je ￥</b> $c_time <a href = 'del.php?id=$id'>X</a><br>
					var obj = eval('('+ data + ')') , h = '';
					for(var i = 0;i < obj.length;i++){
						var temp = obj[i].split('-');
						h += temp[0] + ': <b style="color:red">' + temp[1] + '￥</b>　　' + temp[2] + '<a href = "del.php?id=$id">X</a><br>';
					}
					$('#content').html(h);
				});
			});
			$('#addlb').click(function(){
				var lbm = prompt('类别名：');
				var lbpy = prompt('类别拼音：');
				var s_html = '<option>'+ lbm + '-' + lbpy +'</option>';
				$.post('writeXml.php',{'w':s_html},function(data){
					updateSelect();
				});
			});
		});
	</script>
</body>
</html>