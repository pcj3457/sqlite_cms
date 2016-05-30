<?php 
 require_once('../function/GetSQLValueString.php');
 require_once('../db/MyDB.php');

if (!isset($_SESSION)) {
  session_start();
 }
//$_SESSION['edittext']="欢迎登陆后台管理系统";

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
$_SESSION['edittext']="欢迎登陆后台管理系统";
}


//$_SESSION['edittext']="欢迎登陆后台管理系统";
if (isset($_POST['loginname'])) {
  $loginUsername=$_POST['loginname'];
  $password=$_POST['loginpassword'];
  $MM_fldUserAuthorization = "";
   $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = true;
   //$yourfile=dirname(dirname(__FILE__)).'/db/webdb.db';
 $database = new MyDB();
if (!$database) {
    $error = (file_exists($yourfile)) ? "Impossible to open, check permissions" : "Impossible to create, check permissions";
    echo $db->lastErrorMsg();
	die($error);
}else {
     // echo "Opened database successfully\n";
   
/*$query = $database->query("select user.* from user where user.name= '".$loginUsername."' and user.password=$password", SQLITE_ASSOC, $query_error); 
 if(!$db){
      
   } 
  */
  $sql=sprintf("select user.*,juese.juesecode from user left join juese on juese.jueseid=user.jueseid where user.name= %s and user.password= %s",GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   $ret = $database->query($sql);
 $row_LoginRS  = $ret->fetchArray(SQLITE3_ASSOC);
      
   
  if ($ret->numColumns() && $ret->columnType(0) != SQLITE3_NULL) { 
	/*  if(($row_LoginRS['ip']=="") or ($row_LoginRS['ip']==$clientip)){*/
     $loginStrGroup = "";

    //declare two session variables and assign them
	$MM_redirectLoginSuccess = $row_LoginRS['juesecode'];
	 $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
    $_SESSION['userid']=$row_LoginRS['userid'];
    $_SESSION['name']=$row_LoginRS['username'];
   /* $_SESSION['villageid']=$row_LoginRS['villageid'];
	$_SESSION['villagename']=$row_LoginRS['villagename'];
    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }*/
    header("Location: " . $MM_redirectLoginSuccess );
 /* }
  else
  { $_SESSION['edittext']="请检查您的用户ip是否受限。";
    header("Location: ". $MM_redirectLoginFailed );
	  }*/
  }
  else
   {
	  $_SESSION['edittext']="请检查您的用户名和密码。";
    header("Location: ". $MM_redirectLoginFailed );
  }
  }
  unset( $ret);
  $database->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script type="text/javascript" src="../jquery/jquery-1.11.2.min.js"></script>
<script type="application/javascript">
function keyLogin(){
 if (event.keyCode==13)  //回车键的键值为13
 {
  formsubmit(); //调用登录按钮的登录事件
}
}
function formsubmit()
{
	$("#form1").submit();}

</script>
<title>欢迎登陆管理系统</title>

<style type="text/css">
TABLE {
	FONT-SIZE: 13px;
	LINE-HEIGHT: 18px;
	LETTER-SPACING: 0px;
	BORDER-LEFT-COLOR: lightgrey;
	BORDER-BOTTOM-COLOR: lightgrey;
	BORDER-TOP-COLOR: lightgrey;
	BORDER-COLLAPSE: collapse;
	BORDER-RIGHT-COLOR: lightgrey;
	borderColor: lightgrey;
	cellSpacing: 0;
	cellPadding: 4;
	rules: all
}

input {
	BORDER-RIGHT: #000000 1px inset;
	BORDER-TOP: #000000 1px inset;
	FONT-SIZE: 12px;
	BACKGROUND: #ffffff;
	BORDER-LEFT: #000000 1px inset;
	BORDER-BOTTOM: #000000 1px inset
}

BODY {
	background: #00498f no-repeat url(../images/background.jpg) fixed
		content-box;
}
</style>
</head>

<body onload="$('#loginname').focus();">
	<div
		style="background: url(../images/divbg.jpg) center; width: 1024px; height: 626px; position: relative; alignment-adjust: central; MARGIN-RIGHT: auto; MARGIN-LEFT: auto; margin-top: auto; margin-bottom: auto;">
		<div
			style="background: url(../images/word.png); width: 475px; height: 47px; position: absolute; left: 255px; top: 242px;">
		</div>


		<div
			style="position: absolute; left: 283px; top: 294px; width: 360px; height: 24px;">
			<form id="form1" name="form1" method="post" action="">
				<table width="100%" border="0">
					<tr>
						<td width="26%" height="26" align="right" valign="middle">&nbsp;用户</td>
						<td width="7%" align="left"><img src="../images/name.png" /></td>
						<td width="67%" align="left"><input type="text" name="loginname"
							id="loginname" size="16" /></td>
					</tr>
					<tr>
						<td height="30" align="right" valign="middle">&nbsp;密码</td>
						<td align="left"><img src="../images/password.png" /></td>
						<td align="left"><input name="loginpassword" type="password"
							onkeydown="keyLogin();" size="16" /></td>
					</tr>
					<tr>
						<td colspan="3" align="center"><div>
								<font color="red"><?php
if(isset($_SESSION['edittext']))
{
echo $_SESSION['edittext']; }?></font>
							</div></td>
					</tr>
					<tr>
						<td colspan="3" align="center"><img src="../images/denglu.png"
							width="63" height="64" style="cursor: pointer;" id="imgSubmit"
							onclick="formsubmit();" /></td>
					</tr>
				</table>

			</form>
		</div>
	</div>
</body>
</html>