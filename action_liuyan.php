<?php 
require_once('function/GetSQLValueString.php');
 require_once('db/MyDB.php');
$database = new MyDB();
session_start();
$validate="";
if(isset($_POST["validate"])){
$validate=$_POST["validate"];
//echo "您刚才输入的是：".$_POST["validate"]."<br>状态：";
if($validate!=$_SESSION["authnum_session"]){
	echo "<script language='javacript'>验证码不对！</script> ";
$MM_restrictGoTo="liuyan.php";
 header("Location: ". $MM_restrictGoTo); 
}else{
 $insertSQL = sprintf("INSERT INTO message (content,email, indate, name) VALUES (%s,%s, %s,%s)",
                       GetSQLValueString($_POST['content'], "text"),
					   GetSQLValueString($_POST['email'], "text"),
					   GetSQLValueString(time(), "int"),
                       GetSQLValueString($_POST['name'], "text"));
 
  $ret = $database->exec($insertSQL);


$MM_restrictGoTo="liuyan.php";
 header("Location: ". $MM_restrictGoTo); 
}
} 



?>