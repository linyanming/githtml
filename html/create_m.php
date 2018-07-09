<?php
require('./class/php_main.php');//主类
require('./class/db_o.php');//数据库类
$mysql = new db_o; 

$select_sentence = "select serial from devices";
$s_result = $mysql->s($select_sentence);
for($j=1;$j<13;$j++)
{
	$table_name ="monitor_".$j;
	$i=0;
	$cols ="";
	while($r = $s_result->fetch_array(MYSQLI_ASSOC))
	{
		$i++;
		$cols=$cols."`".$r['serial']."` double,";
		if($i>=9)
		{
			break;
		}
	}
	$qstr = "create table ".$table_name." (`id` INT UNSIGNED AUTO_INCREMENT,".$cols." `record_time` DATETIME,PRIMARY KEY (id))";
	$s_r = $mysql->s($qstr);
}

	

echo $qstr;



?>
