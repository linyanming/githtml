<?php
session_start();
if (isset($_POST['user'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];
    if ($user == 'admin' && $password == '123456') {//验证正确
        $_SESSION['user'] = $user;
        //跳转到首页
        header('location:index.php');
    }else{
        echo "<script>alert('登录失败，用户名或密码不正确');</script>";
 //       exit();
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>智能环境监测系统登录</title>
<link href="./css/login.css" rel="stylesheet" type="text/css" />
</head>
<body class="Login">
<!--Login-开始-->

<div class="Login_heand dk">
    <a href="#" class="Login_logo fl">
        <img src="images/logo.png" class="fl"/><p class="fl">智能环境监测系统</p><div class="clear"></div>
    </a>
    <div class="clear"></div>
</div>

<div class="Login_k">
	<div class="Login_T">密码登录<p></p></div>
    <!--登录-开始-->
    <form class="Login_dl" method="POST" id="subForm">
        <div class="Login_row">
            <input name="user" type="text" value="" class="Login_input Login_inp1" placeholder="用户名" />
        </div> 
        <div class="Login_row">
            <input name="password" type="password" value="" class="Login_input Login_inp2" placeholder="密码" />
        </div> 
       <a onclick="subForm()" class="Login_dla">登录</a>  


   </form>
    <!--登录-结束-->
	<script>
	    function subForm(){
	        document.getElementById("subForm").submit();
	    }
	</script>
</div>

<div class="Login_foot">
    <p>本站由海韦斯智能技术公司技术支持</p>
</div>
<!--Login-结束-->
    
</body>
</html>

<!--
<form method="POST">

    用户名: <input type="text" name="user"><br />

    密码: <input type="text" name="password"><br />

    <input type="submit" value="提交">

</form>
-->
