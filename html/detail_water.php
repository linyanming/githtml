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
<title>水质</title>
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
$location_id = $_GET['location'];
$select_sentence = "select location_name from locations where id = ".$location_id." order by id desc limit 1";
$s_result = $mysql->s($select_sentence);
$r = $s_result->fetch_array(MYSQLI_ASSOC)
?>
                <p class="in_sen_title" id="divicename_200005075"><?php echo $r['location_name'] ?>水质</p>  
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
                		$sql_str = "select * from device_view where serial='".$col_name->name."' and (type_id >= 1 and type_id <= 9 or type_id = 17 or type_id = 18)";
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
                    		
                    		
                        	
                        	<span data-toggle="modal" data-target="#myModal_hist"><a onclick="showFrameDiv('<?php echo $r['serial'];?>')">&nbsp;&gt;&nbsp;历史查询</a></span>&nbsp;
                        	
                    	</div>
                	</div>
					                	    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
					    <div id="main<?php echo $r['serial'];?>" style="width: 1000px;height:500px;display:none;margin:0px auto"></div>
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
						if($r_p[$device_id] == 0)
							continue;
						$value = sprintf("%.3f",$r_p[$device_id]);
						$data_str = "['".$r_p['record_time']."',".$value."],".$data_str;
					}
					$sql_str_p = "select type_name,unit_symbol,low_limit,high_limit from device_view where serial=".$device_id;
					$name_r = $mysql->s($sql_str_p);
					$temp_p = $name_r->fetch_array(MYSQLI_ASSOC);
					$type_name = $temp_p['type_name'];
					$unit_name = $temp_p['unit_symbol'];
					$low_limit = $temp_p['low_limit'];
					$high_limit = $temp_p['high_limit'];
					?>        
					data = [<?php echo $data_str ?>];

						myChart.setOption(option = {
							title: {
								text: '<?php echo $type_name."(".$unit_name.")   ID: ".$device_id;?>'
							},
							tooltip: {
								trigger: 'axis'
							},
							xAxis: {
								data: data.map(function (item) {
									return item[0];
								})
							},
							yAxis: {
								splitLine: {
									show: false
								}
							},
							toolbox: {
								left: 'center',
								feature: {
									dataZoom: {
										yAxisIndex: 'none'
									},
									restore: {},
									saveAsImage: {}
								}
							},
							dataZoom: [{
								startValue: '2014-06-01'
							}, {
								type: 'inside'
							}],
							<?php if($low_limit != 0 or $high_limit != 0)
							{
								echo "
							visualMap: {
								top: 10,
							right: 10, ";}?>
								<?php if($low_limit == 0 and $high_limit == 0) 
									  {
									  }
									  else if($low_limit == 0 and $high_limit > 0)
									  {
										  echo "
											pieces: [{
												gt: 0,
												lte: ".$high_limit.",
												color: '#096'
											}, {
												gt: ".$high_limit.",
												color: '#cc0033'
											}],
											outOfRange: {
												color: '#096'
											}
											";								  
									  }
									  else if($low_limit > 0 and $high_limit > 0)
									  {
										  echo "
											pieces: [{
												gt: 0,
												lte: ".$low_limit.",
												color: '#cc0033'
											},{
												gt: ".$low_limit.",
												lte: ".$high_limit.",
												color: '#096'
											}, {
												gt: ".$high_limit.",
												color: '#cc0033'
											}],
											outOfRange: {
												color: '#096'
											}
											";										  
									  }
									  else if($low_limit > 0 and $high_limit == 0)
									  {
										  echo "
											pieces: [{
												gt: 0,
												lte: ".$low_limit.",
												color: '#cc0033'
											}, {
												gt: ".$low_limit.",
												color: '#096'
											}],
											outOfRange: {
												color: '#096'
											}
											";										  
									  }
									  else
									  {
	/*									  echo "
											pieces: [{
												gt: 0,
												color: '#096'
											}],
											outOfRange: {
												color: '#096'
											}
											";				   */					  
									  }
										  ?>
							<?php if($low_limit != 0 or $high_limit != 0)
							{
								echo "},";
							}
							?>
							series: {
								name: '<?php echo $type_name."(".$unit_name.")";?>',
								type: 'line',
								data: data.map(function (item) {
									return item[1];
								}),
								markLine: {
									silent: true,
									data: [
									<?php 
										if($low_limit == 0 and $high_limit == 0) 
										{
										}
										else if($low_limit == 0 and $high_limit > 0)
										{
											echo "{yAxis: ".$high_limit."}";
										}
										else if($low_limit > 0 and $high_limit > 0)
										{
											echo "{yAxis: ".$low_limit."},{yAxis: ".$high_limit."}";
										}
										else if($low_limit > 0 and $high_limit == 0)
										{
											echo "{yAxis: ".$low_limit."}";
										}
										else
										{
										}
									?>
									]
								}
							}
						});
					    </script>

           <?php
         }
           ?>
            

</body>
</html>
