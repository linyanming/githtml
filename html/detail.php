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
<title>无标题文档</title>
		<link href="css1/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css1/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css1/myIndex.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css1/jquery.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css1/jquery_002.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>

                
                <p class="in_sen_title" id="divicename_200005075">
                	 水质
                	
                </p>
                	<?php
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
                		$r = $temp->fetch_array(MYSQLI_ASSOC);
                	
                	?>
                	
                	<div class="row infos_imgsTitle" id="device-item-200005075">
                    	<div class="col-sm-2">
                    	    
                    	         
                    	         
                    	             <img src="/images/temperature.png" onerror="this.src='./images/temperature.png'">
                    	         
                    	    
                        	<p style="padding:0px 0px 10px 10px;">ID:<?php echo $r['serial']; ?></p>
                    	</div>
                    	<div class="col-sm-4">
                        	<h4><?php echo $r['type_name']; ?></h4>
                        	<p>当前状态：
                        	<span id="sz_200049695"><font color="#ff0000;">正常</font></span>
                        	</p>
                        	<p style="margin-top:14px;">更新时间：<span id="st_200049695"><?php  echo $row_info['record_time']; ?></span></p>
                    	</div>
                    	<div class="col-sm-3">
                    	     <span id="s_200049695">
	                    	    <?php
	                    	     
	                    	    echo sprintf("%.3f", $row_info[$r['serial']]);  ?>
	                    	     
	                    	     
                    	     </span>
                    	     <span class="value_unit"><?php echo $r['unit_symbol']; ?></span>
                    	</div>
                    	<div class="pull-right">
                    		
                    		
                        	
                        	<span data-toggle="modal" data-target="#myModal_hist"><a href="history.php?location=<?php echo $location_id; ?>&device=<?php echo $r['serial'];?>">&nbsp;&gt;&nbsp;历史查询</a></span>&nbsp;
                        	
                    	</div>
                	</div>
           <?php
         }
           ?>
            

</body>
</html>
