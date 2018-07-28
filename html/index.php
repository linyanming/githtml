<?php
require('./check_login.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>智慧环境监测系统</title>

<link rel="stylesheet" href="css/index.css" type="text/css" media="screen" />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/tendina.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>

</head>
<body>
    <!--顶部-->
    <div class="top">
            <div style="float: left"><span style="font-size: 16px;line-height: 45px;padding-left: 20px;color: #fff">智慧环境监测系统</h1></span></div>
            <div id="ad_setting" class="ad_setting">
                <a class="ad_setting_a" href="javascript:; ">admin</a>
                <ul class="dropdown-menu-uu" style="display: none" id="ad_setting_ul">
                    <li class="ad_setting_ul_li"> <a href="./login.php"><i class="icon-user glyph-icon"></i>注销</a> </li>
                </ul>
                <img class="use_xl" src="images/right_menu.png" />
            </div>
    </div>
    <!--顶部结束-->
    <!--菜单-->
    <div class="left-menu">
        <ul id="menu">
            <li class="menu-list">
               <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>监测项目<s class="sz"></s></a>
                <ul>
                    <li><a href="monitor.php" target="menuFrame"><i class="glyph-icon icon-chevron-right3"></i>监控地图</a></li>
                    <li><a href="device_water.php" target="menuFrame"><i class="glyph-icon icon-chevron-right3"></i>水质监控</a></li>  
					<li><a href="device_air.php" target="menuFrame"><i class="glyph-icon icon-chevron-right3"></i>空气质量</a></li> 
					<li><a href="device_weather.php" target="menuFrame"><i class="glyph-icon icon-chevron-right3"></i>气象参数</a></li> 
                </ul>
            </li>
           
        </ul>
    </div>
    
    <!--菜单右边的iframe页面-->
    <div id="right-content" class="right-content">
        <div class="content">
            <div id="page_content">
                <iframe id="menuFrame" name="menuFrame" src="monitor.php" style="overflow:visible;"
                        scrolling="yes" frameborder="no" width="100%" height="95%"></iframe>
            </div>
        </div>
    </div>
</body>
</html>