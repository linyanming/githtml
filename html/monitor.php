<?php
require('./class/php_main.php');//主类
require('./class/db_o.php');//数据库类
require('./check_login.php');
$mysql = new db_o; 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="百度地图,百度地图API，百度地图自定义工具，百度地图所见即所得工具" />

<meta name="description" content="百度地图API自定义地图，帮助用户在可视化操作下生成百度地图" />

<title>地图控制</title>
<!--引用百度地图API-->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
    
html,body{margin:0;padding:0;width:100%;height:100%;}
    
.iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
    
.iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word}

</style>

<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true">
</script>

</head>
	
<body>
<!-- portfolio -->
	<!-- Portfolio Starts Here -->
<div style="width:100%;height:100%;border:#ccc solid 1px;" id="dituContent"></div>
<!-- //portfolio -->
</body>
</html>
<!-- //portfolio -->
<!-- footer -->
<script type="text/javascript">
var mymap = new BMap.Map("dituContent");//在百度地图容器中创建一个地图
var mypoint = new BMap.Point(121.91077,29.87082);//定义一个中心点坐标
//标注点数组
var marker_array = new Array();
<?php

$select_sentence = "select * from locations";
$s_result = $mysql->s($select_sentence);
	while($r = $s_result->fetch_array(MYSQLI_ASSOC))
	{
?>
var marker_temp = [{title:"<?php echo $r['location_name'] ?>",content:"状态：正常  &nbsp &nbsp &nbsp &nbsp  <a href='detail.php?location=<?php echo $r['id'] ?>' style='color:blue'>详情</a>",point:"<?php echo $r['longitude']."|".$r['latitude']; ?>",isOpen:1,icon:{w:40,h:40,l:46,t:21,x:9,lb:12}} ];

    marker_array.push(marker_temp);
<?php
}

?>


   //创建和初始化地图函数：
   function initMap(){
       createMap();//创建地图   
       for(i=0; i<marker_array.length;i++) 
       {
       	temp = marker_array[i];
       	addMarker(temp);
      }
      setMapEvent() 
      addMapControl()
   }   

//创建地图函数：
   function createMap(){
       
       mymap.centerAndZoom(mypoint,14);//设定地图的中心点和坐标并将地图显示在地图容器中
       //mymap.disableDragging();
       //mymap.enableScrollWheelZoom(true);
      
   }
   
      //创建marker
   function addMarker(markerArr){
       for(var i=0;i<markerArr.length;i++){
           var json = markerArr[i];
           var p0 = json.point.split("|")[0];
           var p1 = json.point.split("|")[1];
           var point = new BMap.Point(p0,p1);
  var iconImg = createIcon(json.icon);
           var marker = new BMap.Marker(point,{icon:iconImg});
  var iw = createInfoWindow(markerArr,i);
  var label = new BMap.Label(json.title,{"offset":new BMap.Size(json.icon.lb-json.icon.x+10,-20)});
  marker.setLabel(label);
           mymap.addOverlay(marker);
           label.setStyle({
                       borderColor:"#808080",
                       color:"#333",
                       cursor:"pointer"
           });
  
  (function(){
   var index = i;
   var _iw = createInfoWindow(markerArr,i);
   var _marker = marker;
   _marker.addEventListener("click",function(){
       this.openInfoWindow(_iw);
      });
      _iw.addEventListener("open",function(){
       _marker.getLabel().hide();
      })
      _iw.addEventListener("close",function(){
      // _marker.getLabel().show();
      })
   label.addEventListener("click",function(){
       _marker.openInfoWindow(_iw);
      })
   if(!!json.isOpen){
    label.hide();
    //_marker.openInfoWindow(_iw);
   }
  })()
       }
   }
   //地图事件设置函数：
    
	function setMapEvent()
	{   
		mymap.enableDragging();//启用地图拖拽事件，默认启用(可不写)
		mymap.enableScrollWheelZoom();//启用地图滚轮放大缩小
		mymap.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
		mymap.enableKeyboard();//启用键盘上下左右键移动地图
	}
	    

	//地图控件添加函数：

	function addMapControl()
	{
		//向地图中添加缩放控件
		var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
		mymap.addControl(ctrl_nav);
		//向地图中添加缩略图控件
		var ctrl_ove = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:1});
		mymap.addControl(ctrl_ove);
		//向地图中添加比例尺控件
		var ctrl_sca = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
		mymap.addControl(ctrl_sca);
	}
    
    
   //创建InfoWindow
   function createInfoWindow(markerArr,i){
       var json = markerArr[i];
       var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>"+json.content+"</div>");
       return iw;
   }
   //创建一个Icon
   function createIcon(json){
       var icon = new BMap.Icon("./images/mark.png", new BMap.Size(40,40))
       return icon;
   }
   
   initMap();//创建和初始化地图
</script>
<!-- //footer -->

