<?php
require('./class/php_main.php');//主类
require('./class/db_o.php');//数据库类
require('./check_login.php');
$mysql = new db_o; 
$location_id = $_GET['location'];
$device_id = $_GET['device'];
 echo "var myChart = echarts.init(document.getElementById('main".$device_id."'));";



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
echo "data = [".$data_str."];
	myChart.setOption(option = {
		title: {
			text: '".$type_name."(".$unit_name.")   ID: ".$device_id."'
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
		}],";
		if($low_limit != 0 or $high_limit != 0)
		{
			echo "
		visualMap: {
			top: 10,
			right: 10, ";
		}
				  if($low_limit == 0 and $high_limit == 0) 
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
				  }
		if($low_limit != 0 or $high_limit != 0)
		{
			echo "},";
		}
echo "
		series: {
			name: '".$type_name."(".$unit_name.")',
			type: 'line',
			data: data.map(function (item) {
				return item[1];
			}),
			markLine: {
				silent: true,
				data: ["; 
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
echo "
				]
			}
		}
	});";
?>    