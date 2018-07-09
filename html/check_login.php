
<?php

session_start();

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {

    

}else{

    echo "你还没有登录，<a href='login.php'>请登录</a>";
    return;

}

?> 