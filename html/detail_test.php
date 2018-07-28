<?php
require('./class/php_main.php');//主类
require('./class/db_o.php');//数据库类
require('./check_login.php');
$mysql = new db_o; 
$location_id = $_GET['location'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>环境数据</title>
		<link href="css1/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css1/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css1/myIndex.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css1/jquery.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css1/jquery_002.css" rel="stylesheet" type="text/css" media="all" />
    <!-- 引入 echarts.js -->
    <script src="echarts.js"></script>
    <script src="js/jquery.min.js">
</script>
<script> 

var loc_id = <?php echo $location_id;?>;
var myVar=setInterval(function(){myTimer()},60000);
 
function myTimer()
{
	$.ajax({
	type:'GET',
	url:"update_current.php?location="+loc_id,
	success: function(data){
		eval(data);
	}
	});
}

function showFrameDiv(device_id,location_id)
{
	var id = '#main'+device_id;

	$.ajax({
	type:'GET',
	url:"history.php?location="+location_id+"&device="+device_id,
	success: function(data){
		eval(data);
		$(id).slideToggle("slow");
	}
	});
}

</script>
</head>

<body>
<?php

$select_sentence = "select location_name from locations where id = ".$location_id." order by id desc limit 1";
$s_result = $mysql->s($select_sentence);
$r = $s_result->fetch_array(MYSQLI_ASSOC)
?>
                <p class="in_sen_title" id="divicename_200005075"><?php echo $r['location_name'] ?>环境数据</p>  
                	<?php
                	$sql_str = "select * from monitor_".$location_id." order by id desc limit 1";
                	$result = $mysql->s($sql_str);
                	$row_info = $result->fetch_array(MYSQLI_ASSOC);                	
                	for($i=0;$i < $result->field_count;$i++)
                	{
                		$col_name = $result->fetch_field();                		
                		if(strcmp($col_name->name,"id")==0 || strcmp($col_name->name,"record_time")==0)
                		{
                			continue;
                		} 
                		$sql_str = "select * from device_view where serial='".$col_name->name."'";
                		$temp = $mysql->s($sql_str);
						if($temp->num_rows == 0)
						{
							continue;
						}
                		$r = $temp->fetch_array(MYSQLI_ASSOC);
						$time_echo = $row_info['record_time'];
						if($row_info[$r['serial']] == 0)
						{
							$sql_temp_str = "select `".$col_name->name."`,`record_time` from monitor_".$location_id." where `".$col_name->name."` is not null order by id desc limit 1";
							$temp_t = $mysql->s($sql_temp_str);
							$r_t = $temp_t->fetch_array(MYSQLI_ASSOC);
							$row_info[$r['serial']] = $r_t[$col_name->name];
							$time_echo = $r_t['record_time'];
						}
                	?>
                	<div class="row infos_imgsTitle" id="device_<?php echo $r['serial'];?>">
                    	<div class="col-sm-2">
                    	    <img src="./images/temperature.png" onerror="this.src='./images/temperature.png'">
                        	<p style="padding:0px 0px 10px 10px;">ID:<?php echo $r['serial']; ?></p>
                    	</div>
                    	<div class="col-sm-4" >
                        	<h4><?php echo $r['type_name']; ?></h4>
                        	<p>当前状态：
                        	<span id="sz_200049695"><font color="#ff0000;">正常</font></span>
                        	</p>
                        	<p style="margin-top:14px;">更新时间：<span id="st_200049695"><?php  echo $time_echo; ?></span></p>
                    	</div>
                    	<div class="col-sm-3">
                    		<b><font size=7 color="black">
                    	     <span id="s_200049695">
	                    	    <?php
	                    	    echo sprintf("%.3f", $row_info[$r['serial']]);  ?>
                    	     </span>
                    	     <span class="value_unit"><?php echo $r['unit_symbol']; ?></span></font></b>
                    	</div>
                    	<div class="pull-right" >
                        	<span data-toggle="modal" data-target="#myModal_hist"><a onclick="showFrameDiv('<?php echo $r['serial'];?>',<?php echo $location_id;?>)">&nbsp;&gt;&nbsp;历史查询</a></span>&nbsp;
                    	</div>
                	</div>
					                	    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
					    <div id="main<?php echo $r['serial'];?>" style="width: 1000px;height:500px;display:none;margin:0px auto"></div>
           <?php
         }
           ?>
            

</body>
</html>
