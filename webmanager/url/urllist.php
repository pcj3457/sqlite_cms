<?php require_once('../../function/GetSQLValueString.php');
 require_once('../../db/MyDB.php');
 $database = new MyDB();
 
$query_Recordset1 = "SELECT * FROM url ORDER BY urlxuhao ASC";
$Recordset1 = $database->query($query_Recordset1);
$row_Recordset1 = $Recordset1->fetchArray(SQLITE3_ASSOC);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>无标题文档</title>
<link href="../../css/default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="95%" border="1">
  <tr>
    <td>序号</td>
    <td>名称</td>
    <td>地址</td>
    <td>操作</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['urlxuhao']; ?></td>
      <td><?php echo $row_Recordset1['urlname']; ?></td>
      <td><?php echo $row_Recordset1['url']; ?></td>
      <td><a href="addurl.php">添加</a>|<a href="addurl.php?urlid=<?php echo $row_Recordset1['urlid']; ?>">修改</a>|<a href="delurl.php?urlid=<?php echo $row_Recordset1['urlid']; ?>">删除</a></td>
    </tr>
    <?php } while ($row_Recordset1 = $Recordset1->fetchArray(SQLITE3_ASSOC)); ?>
</table>
</body>
</html>
<?php
$database->close();
?>
