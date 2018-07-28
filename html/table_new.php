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
    <div id="main" style="width: 1000px;height:600px;"></div>
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
        visualMap: {
            top: 10,
            right: 10,
            pieces: [{
                gt: 0,
                lte: 50,
                color: '#096'
            }, {
                gt: 50,
                lte: 100,
                color: '#ffde33'
            }, {
                gt: 100,
                lte: 150,
                color: '#ff9933'
            }, {
                gt: 150,
                lte: 200,
                color: '#cc0033'
            }, {
                gt: 200,
                lte: 300,
                color: '#660099'
            }, {
                gt: 300,
                color: '#7e0023'
            }],
            outOfRange: {
                color: '#999'
            }
        },
        series: {
            name: '<?php echo $type_name."(".$unit_name.")";?>',
            type: 'line',
            data: data.map(function (item) {
                return item[1];
            }),
            markLine: {
                silent: true,
                data: [{
                    yAxis: 50
                }, {
                    yAxis: 100
                }, {
                    yAxis: 150
                }, {
                    yAxis: 200
                }, {
                    yAxis: 300
                }]
            }
        }
    });
    </script>


</body>
</html>