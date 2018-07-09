<?php
/*******************************
这是一个，php主类
********************************/
define('EXEPATH',$_SERVER["SCRIPT_FILENAME"]);//执行文件路径
define('ERR_LEVEL',1);//错误等级 0忽略 1显示输出 2写入文件 3写入数据库

function gcerr($li){ //全局捕获错误//参数为行号
	echo  "\n" . EXEPATH ."_gcerr_" . $li ."_line\n";
}
function gbug($str_info){//全局调试
	echo  "\n".$str_info."";
} 
?>