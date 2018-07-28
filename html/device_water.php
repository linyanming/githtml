<?php
require('./class/php_main.php');//主类
require('./class/db_o.php');//数据库类
require('./check_login.php');
$mysql = new db_o; 
?>
<!-- saved from url=(0081)https://www.tlink.io/user/userIndex.htm?menu=%E7%9B%91%E6%8E%A7%E4%B8%AD%E5%BF%83 -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="icon" href="https://www.tlink.io/images/favicon.ico">

<script src="./js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="./js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="./css/myIndex.css">



</head>
<body>
  
        <!--主题
        <div class="index_c">-->
            <!--左侧栏-->
            <!--中间部分-->
            


<style>
.right-content{
    margin-left: 330px;
	background:#fff;
    height: 100%;
    min-height:100%;
    overflow:auto;
}
.avast03
	{
		float:left;position:fixed;
	}
.avast
	{
		width:16px;left:315px;cursor:pointer;position:fixed;z-index:9;height:80px;top:440;
	}

.avast1
	{
		width:16px;cursor:pointer;position:fixed;z-index:9;height:80px;top:440;
		
	}
	
#avast01
	{	
		width:330px;float:left;margin:0px;
	}
.Tleft
	{
		margin-left:90px;
	}
.Tright
	{
		margin-left:440px;
	}	
 .clear 
	 {
	  	clear:both;
	  }
.index_centen_p{ top:0px;width:380px;position:fixed;border-right:solid #aaa 1px;
   				overflow-y:auto; bottom:0;background-color:#f7f6f2;z-index:8;float: left;}
</style>	
		<div class="avast03">
            <div class="index_centen_p" id="avast01">
                <div class="conten_title">
                    <h4>水质监控点</h4>
                </div>
<?php
$select_all_id = "select distinct id from device_view where type_id >= 1 and type_id <= 9 or type_id = 17 or type_id = 18";
$id_result = $mysql->s($select_all_id);
while($id_r = $id_result->fetch_array(MYSQLI_ASSOC))
{

$location_id = $id_r['id'];
$select_sentence = "select location_name from locations where id = ".$location_id." order by id desc limit 1";
$s_result = $mysql->s($select_sentence);
$r = $s_result->fetch_array(MYSQLI_ASSOC)
?>
                <div class="index_imgInfo_big">
                   <div class="index_img_infosN">
				        <div class="in_imgN" id="dev_<?php echo $location_id ?>">
				            <a href="detail_water.php?location=<?php echo $location_id ?>" target="menuFramewater">
                                      <img src="./images/GPS.png">
				            </a>
				        </div>
						<a href="detail_water.php?location=<?php echo $location_id ?>" target="menuFramewater">
				        <div class="in_infosN">
				            <h4><?php echo $r['location_name'] ?></h4>
				        </div></a>
				    </div>
                </div>
            
           <?php
}
           ?>     
		   </div>
            <div class="avast" id="Thide">
            	<img src="./images/pre.png">
            </div>
			<div class="avast1" id="Tshow" style="display:none;">
				<img src="./images/next.png">
			</div>
			 <div class="clear">
            </div>
			</div>
           </div>
        </div>
		<div id="right-content" class="right-content">
        <div class="content">
            <div id="page_content">
                <iframe id="menuFramewater" name="menuFramewater" src="detail_water.php?location=<?php echo $location_id ?>" style="overflow:visible;"
                        scrolling="yes" frameborder="no" width="100%" height="100%"></iframe>
            </div>
        </div>
    </div>
<script>
 	
$(document).ready(function(){
	  $("#Thide").click(function(){
		  $("#avast01").hide();
		  $("#Thide").hide();
		  $("#Tshow").show();
		  $("#Tright").addClass("Tleft");
		  $("#Tright").removeClass("Tright");
//		  $("#right-content").margin-left=0px;
		  document.getElementById("right-content").style.marginLeft=0+'px';
		});
	  $("#Tshow").click(function(){
		  $("#avast01").show();
		  $("#Tshow").hide();
		  $("#Thide").show();
		  $("#Tright").addClass("Tright");
		  $("#Tright").removeClass("Tleft");
//		  $("#right-content").margin-left=355px;
		  document.getElementById("right-content").style.marginLeft=330+'px';
	  }); 
	  
});
</script>

<!-- </div>   -->
</body>
</html>