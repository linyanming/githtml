<?php
/*******************************
这是一个，类来操作数据库
********************************/
define('DB_OPATH',__FILE__);//绝对文件路径(类能使用，有可能被包含到其他文件)
class db_o{
 var $db_h = 'localhost';//数据库主机
 var $db_u ='root';//数据库用户
 var $db_p = '123456';//数据库密码
 var $db_k ='env_monitor';//要使用的库
	var $sql=NULL;//查询语句
	var $l_db;//连接的资源
	var $errorl;//输出
	var $errorv;//错误原因
	var $q_inid;//q语句插入的ID
	function __construct(){//构建(一般成功返回0，错误返回非0 )
		$this->l_db = @mysqli_connect($this->db_h,$this->db_u,$this->db_p,$this->db_k);
		if(!$this->l_db){
			$this->errorv = '数据库无法打开_数据库主机='.$this->db_h.'错误101';
			$this->cerr(__LINE__);
			return 101;//不正常退出
		}
		$this->l_db->query("set names utf8");
		/*
		if(!@mysqli_select_db ($this->db_k)){
			$this->errorv = '数据库='.$this->db_k.'无法使用_错误102';
			$this->cerr(__LINE__);
		}
		*/
	}
	function cerr($line){//类级捕获错误
		$this->errorl =  "\nclass_error_".DB_OPATH .'_'. $line . '_line!_' . $this->errorv ."\n";
		$this->errorv = '';//清理错误
		echo $this->errorl ;
	}
	function db_err(){//数据库错误提示		
		$dberr_info = "\n错误";
		echo $dberr_info;
	}
	function q(){//数据修改性query//先设置$this->sql属性
		if(empty($this->sql)){//检查
			$this->errorv = '请为$this->sql属性设置查询语句';
			$this->cerr(__LINE__);
			return 10;
		}
		$rulcode_sql = rawurlencode($this->sql);//varchar(210)
		/*
		$sql_n = "INSERT INTO `db_oper_log` (`id` ,`sql_query` ,`yn`) VALUES (NULL , '$rulcode_sql', 'n')";
		$sql_event = mysql_query($sql_n);//插入前
		if(!(is_resource($sql_event)||$sql_event)){
			$this->errorv = '操作记录建立失败-错误103';
			$this->cerr(__LINE__);
			$this->db_err();//数据库错误提示
			return 103;
		}
		$insert_id = mysql_insert_id();
		*/
		$q_result = $this->l_db->query($this->sql);//实际语句
		$this->sql = NULL;//还原
		if(!(is_resource($q_result)||$q_result)){//--------------------
			$this->errorv = '数据操作语句='.$this->sql.'_错误104';
			$this->cerr(__LINE__);
			$this->db_err();//数据库错误提示
			return 104;
		}
		$this->q_inid = $this->l_db->insert_id();//id
		/*
		$sql_y = "UPDATE `db_oper_log` SET `yn` = 'y' WHERE `id` = $insert_id  LIMIT 1 ";
		$sql_event = mysql_query($sql_y);//插入后
		if(!(is_resource($sql_event)||$sql_event)){
			$this->errorv = '操作记录更新失败-错误105';
			$this->cerr(__LINE__);
			$this->db_err();//数据库错误提示
			return 105;
		}
		*/
		return 0;//成功
	}
	function s($sql_sentence){//简单查询
		$sql_result = $this->l_db->query($sql_sentence);		
		/*
		if(!is_resource($sql_result)){
			$this->errorv = '查询语句='.$sql_sentence.'query_错误106';
			$this->cerr(__LINE__);
			$this->db_err();//数据库错误提示
		}		
		*/
		return $sql_result;
	}
};
?>