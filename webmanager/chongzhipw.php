<?php require_once('../Connections/mysql.php'); ?>
<?php
require_once('getSQLvalueString.php');
if (!isset($_SESSION)) {
  session_start();
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE admin SET password=password(%s) WHERE name=%s",
                       GetSQLValueString($_POST['password'], "text"),
					    GetSQLValueString($_POST['name'], "text"));

  mysql_select_db($database_mysql, $mysql);
  $Result1 = mysql_query($updateSQL, $mysql) or die(mysql_error());

  $updateGoTo = "ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ޱ����ĵ�</title>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"><table width="84%" border="1">
  <tr>
    <td align="center"><strong>����������</strong></td>
    <td>
      <input type="text" name="password" id="password" />
      <input type="hidden" name="userid" id="userid" value=" <?php echo $_SESSION['userid']; ?>" /></td>
  </tr>
  <tr>
  <td align="center"><strong>�û���</strong></td>
  <td><label for="textfield"></label>
    <input type="text" name="name" id="name" value="admin" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="button" id="button" value="�ύ" /> &nbsp;
      <input type="reset" name="button2" id="button2" value="����" /></td>
    </tr>
</table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>