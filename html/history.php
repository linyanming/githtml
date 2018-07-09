<?php
require('./class/php_main.php');//主类
require('./class/db_o.php');//数据库类
require('./check_login.php');
$mysql = new db_o; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>历史曲线</title>
    <!-- 引入 echarts.js -->
    <script src="echarts.js"></script>
</head>
<body>
    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <div id="main" style="width: 800px;height:400px;"></div>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

<?php
$location_id = $_GET['location'];
$device_id = $_GET['device'];
$sql_str = "select  `".$device_id."`, record_time from monitor_".$location_id." order by id desc";
$result = $mysql->s($sql_str);
$data_str ="";

while($r = $result->fetch_array(MYSQLI_ASSOC))
{
	$value = sprintf("%.3f",$r[$device_id]);
	$data_str = "['".$r['record_time']."',".$value."],".$data_str;
}
$sql_str = "select type_name,unit_symbol from device_view where serial=".$device_id;
$name_r = $mysql->s($sql_str);
$temp = $name_r->fetch_array(MYSQLI_ASSOC);
$type_name = $temp['type_name'];
$unit_name = $temp['unit_symbol'];
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


</body>
</html>