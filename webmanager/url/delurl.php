<?php require_once('../../function/GetSQLValueString.php');
 require_once('../../db/MyDB.php');
 $database = new MyDB();
 

if ((isset($_GET['urlid'])) && ($_GET['urlid'] != "")) {
  $deleteSQL = sprintf("DELETE FROM url WHERE urlid=%s",
                       GetSQLValueString($_GET['urlid'], "int"));

  $ret = $database->exec($deleteSQL);

  $deleteGoTo = "urllist.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>无标题文档</title>
</head>

<body>
</body>
</html><?php $database->close();?>