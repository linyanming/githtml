<?php
require('./class/php_main.php');//主类
require('./class/db_o.php');//数据库类
require('./check_login.php');
$mysql = new db_o; 
$location_id = $_GET['location'];
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
	echo "$(\"#device_".$r['serial']." #st_200049695\").html('".$time_echo."');";
	echo "$(\"#device_".$r['serial']." #s_200049695\").html('".sprintf("%.3f", $row_info[$r['serial']])."');";
}
?>