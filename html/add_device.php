<?php
require('./class/php_main.php');//主类
require('./class/db_o.php');//数据库类
$mysql = new db_o; 
$i=1;
for($j=0;$j<11;$j++)
{
for($i=1;$i<10;$i++)
{
	$rnum=rand(1000000,9999999);
$select_sentence = "insert into devices (serial,type_id) values ('00".$i.$rnum."',$i)";
$s_result = $mysql->s($select_sentence);
}
}
echo "hello";
?>
