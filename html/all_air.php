<?php
require('./class/php_main.php');//主类
require('./class/db_o.php');//数据库类
require('./check_login.php');
$mysql = new db_o; 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>空气质量</title>
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
	function showFrameDiv(device_id)
	{
		var id = '#main'+device_id;
		$(id).slideToggle("slow");
	}
</script>
</head>

<body>
<?php
$select_all_id = "select distinct id from device_view where type_id = 10 or type_id = 11";
$id_result = $mysql->s($select_all_id);
while($id_r = $id_result->fetch_array(MYSQLI_ASSOC))
{

$location_id = $id_r['id'];
$select_sentence = "select location_name from locations where id = ".$location_id." order by id desc limit 1";
$s_result = $mysql->s($select_sentence);
$r = $s_result->fetch_array(MYSQLI_ASSOC)
?>

                
                <p class="in_sen_title" id="divicename_200005075">
                	 <?php echo $r['location_name'] ?>空气质量
                	
                </p>  
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
                		$sql_str = "select * from device_view where serial='".$col_name->name."' and (type_id = 10 or type_id = 11)";
                		
                		$temp = $mysql->s($sql_str);
						if(!$temp)
						{
							continue;
						}
                		$r = $temp->fetch_array(MYSQLI_ASSOC);
                	
                	?>
                	
                	<div class="row infos_imgsTitle" id="device-item-200005075">
                    	<div class="col-sm-2">
                    	    
                    	         
                    	         
                    	             <img src="./images/temperature.png" onerror="this.src='./images/temperature.png'">
                    	         
                    	    
                        	<p style="padding:0px 0px 10px 10px;">ID:<?php echo $r['serial']; ?></p>
                    	</div>
                    	<div class="col-sm-4" >
                        	<h4><?php echo $r['type_name']; ?></h4>
                        	<p>当前状态：
                        	<span id="sz_200049695"><font color="#ff0000;">正常</font></span>
                        	</p>
                        	<p style="margin-top:14px;">更新时间：<span id="st_200049695"><?php  echo $row_info['record_time']; ?></span></p>
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
                    		
                    		
                        	
                        	<span data-toggle="modal" data-target="#myModal_hist"><a onclick="showFrameDiv('<?php echo $r['serial'];?>')">&nbsp;&gt;&nbsp;历史查询</a></span>&nbsp;
                        	
                    	</div>
                	</div>
					                	    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
					    <div id="main<?php echo $r['serial'];?>" style="width: 1000px;height:400px;display:none;margin:0px auto"></div>
					    <script type="text/javascript">
					        // 基于准备好的dom，初始化echarts实例
					        var mytable = "main<?php echo $r['serial'];?>";
					        var myChart = echarts.init(document.getElementById(mytable));

					<?php
					$device_id = $r['serial'];
					$sql_str_p = "select  `".$device_id."`, record_time from monitor_".$location_id." order by id desc";
					$result_p = $mysql->s($sql_str_p);
					$data_str ="";
					$r_p = "";
					while($r_p = $result_p->fetch_array(MYSQLI_ASSOC))
					{
						$value = sprintf("%.3f",$r_p[$device_id]);
						$data_str = "['".$r_p['record_time']."',".$value."],".$data_str;
					}
					$sql_str_p = "select type_name,unit_symbol from device_view where serial=".$device_id;
					$name_r = $mysql->s($sql_str_p);
					$temp_p = $name_r->fetch_array(MYSQLI_ASSOC);
					$type_name = $temp_p['type_name'];
					$unit_name = $temp_p['unit_symbol'];
					?>        
					data = [<?php echo $data_str ?>];

					var dateList = data.map(function (item) {
					    return item[0];
					});
					var valueList = data.map(function (item) {
					    return item[1];
					});

					option = {
					    title: {
					        left: 'center',
					        text: '<?php echo $type_name."(".$unit_name.")   ID: ".$device_id;?>'
					    },
					    tooltip: {
					        trigger: 'axis'
					    },
					    xAxis: {
					        data: dateList
					    },
					    yAxis: {
					        splitLine: {show: false}
					    },
					    grid: {
					        bottom: '10%'
					    },
					    series: {
					        type: 'line',
					        showSymbol: false,
					        data: valueList,
					         itemStyle:{
					                normal:{
					                    lineStyle:{
					                        
					                        color:'black'  //'dotted'虚线 'solid'实线
					                    }
					                }
					            }, 
					    }
					};

					        // 使用刚指定的配置项和数据显示图表。
					        myChart.setOption(option);
					    </script>

           <?php
         }
}
           ?>
            

</body>
</html>
