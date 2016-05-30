<?php require_once('../function/GetSQLValueString.php');
 require_once('../db/MyDB.php');


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["ParentID"])) && ($_POST["ParentID"]<>"")) {
  $insertSQL = sprintf("INSERT INTO newskind (KindTitle, ParentID,KindType) VALUES (%s, %s,%s)",
                       GetSQLValueString($_POST['KindTitle'], "text"),
                       GetSQLValueString($_POST['ParentID'], "int"),
					   GetSQLValueString($_POST['kindtype'], "int"));

  $database = new MyDB();
  $ret = $database->exec($insertSQL);
  
  $insertGoTo = "KindList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["ParentID"])) && ($_POST["ParentID"]==="")) {
  $updateSQL = sprintf("UPDATE newskind SET KindTitle=%s,KindType=%s  WHERE KindID=%s",
                       GetSQLValueString($_POST['KindTitle'], "text"),                       GetSQLValueString($_POST['kindtype'], "int"),
                       GetSQLValueString($_POST['KindID'], "int"));

   $database = new MyDB();
  $ret = $database->exec($updateSQL);

  $updateGoTo = "KindList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs = "-1";
if (isset($_GET['KindID'])) {
  $colname_rs = $_GET['KindID'];
}
$database = new MyDB();
$query_rs = sprintf("SELECT * FROM newskind WHERE KindID = %s", GetSQLValueString($colname_rs, "int"));
$rs =$database->query($query_rs);
$row_rs = $rs->fetchArray(SQLITE3_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加类别</title>
</head>

<body><form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"><table width="95%" border="1">
  <tr>
    <td width="20%" align="center"><strong>类别名称</strong></td>
    <td width="80%">
      <input type="text" name="KindTitle" id="KindTitle"  value="<?php echo $row_rs['KindTitle']; ?>" />
      
<input type="hidden" name="KindID" id="KindID"  value="<?php if (isset($_GET['KindID'])&&($_GET['KindID']<>"") ) {echo $_GET['KindID'];} ?>"/>
<input type="hidden" name="ParentID" id="ParentID"  value="<?php if (isset($_GET['ParentID'])&&($_GET['ParentID']<>"") )
{ echo $_GET['ParentID']; } ?>"/></td>
  </tr>
  <tr>
  <td align="center"><strong>类别
  </strong></td> 
  <td>
    <select name="kindtype" id="kindtype">
      <option value="0" <?php if (!(strcmp(0, $row_rs['KindType']))) {echo "selected=\"selected\"";} ?>>文字列表</option>
      <option value="1" <?php if (!(strcmp(1, $row_rs['KindType']))) {echo "selected=\"selected\"";} ?>>图片列表</option>
       <option value="2" <?php if (!(strcmp(2, $row_rs['KindType']))) {echo "selected=\"selected\"";} ?>>单独页面</option>
    
    </select>
  </td>
  </tr>
   <tr>
    <td colspan="2" align="center"><input type="submit" name="button" id="button" value="提交" /></td>
  </tr>
</table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>

</body>
</html>
<?php
unset($rs);
$database->close();
?>
