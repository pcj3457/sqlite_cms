<?php
session_start();
//在页首先要开启session,
//error_reporting(2047);
//session_destroy();
//将session去掉，以每次都能取新的session值;
//用seesion 效果不错，也很方便
//打印上一个session;
//echo "上一个session：<b>".$_SESSION["authnum_session"]."</b><br>";
$validate="";
if(isset($_POST["validate"])){
$validate=$_POST["validate"];
//echo "您刚才输入的是：".$_POST["validate"]."<br>状态：";
if($validate!=$_SESSION["authnum_session"]){
//判断session值与用户输入的验证码是否一致;
//echo "<font color=red>输入有误</font>";
 echo 1;
}else{
//echo "<font color=green>通过验证</font>";
echo 0; 
}
} 
?>