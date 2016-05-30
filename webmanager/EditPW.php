<?php require_once('../function/GetSQLValueString.php');
 require_once('../db/MyDB.php');
if (!isset($_SESSION)) {
  session_start();
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE user SET username=%s, name=%s, password=%s WHERE userid=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['userid'], "int"));

$database = new MyDB();
  $ret = $database->exec($updateSQL);
  

  $updateGoTo = "ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['userid'])) {
  $colname_Recordset1 = $_SESSION['userid'];
}
$database = new MyDB();
$query_Recordset1 = sprintf("SELECT * FROM user WHERE userid = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = $database->query($query_Recordset1);
$row_Recordset1 = $Recordset1->fetchArray(SQLITE3_ASSOC);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"><table width="84%" border="1">
  <tr>
    <td align="center"><strong>输入新密码</strong></td>
    <td>
      <input type="text" name="password" id="password" />
      <input type="hidden" name="userid" id="userid" value=" <?php echo $_SESSION['userid']; ?>" /></td>
  </tr>
  <tr>
  <td align="center"><strong>用户名</strong></td>
  <td><label for="name"></label>
    <input type="text" name="name" id="name" value="<?php echo $row_Recordset1['name']; ?>" />
    </td>
  </tr><tr>
  <td align="center"><strong>名称显示</strong></td>
  <td><label for="name"></label>
    <input type="text" name="username" id="username" value="<?php echo $row_Recordset1['username']; ?>" />
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="button" id="button" value="提交" /> &nbsp;
      <input type="reset" name="button2" id="button2" value="重置" /></td>
    </tr>
</table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
unset($Recordset1);
?>
