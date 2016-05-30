<?php  require_once('../../function/GetSQLValueString.php');
 require_once('../../db/MyDB.php');
 $database = new MyDB();
 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST["urlid"])&&($_POST["urlid"] === "")) {
  $insertSQL = sprintf("INSERT INTO url (urlname, url, urlxuhao) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['urlname'], "text"),
                       GetSQLValueString($_POST['url'], "text"),
                       GetSQLValueString($_POST['urlxuhao'], "int"));

   $ret = $database->exec($insertSQL);

  $insertGoTo = "urllist.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["urlid"])) && ($_POST["urlid"] <> "")) {
  $updateSQL = sprintf("UPDATE url SET urlname=%s, url=%s, urlxuhao=%s WHERE urlid=%s",
                       GetSQLValueString($_POST['urlname'], "text"),
                       GetSQLValueString($_POST['url'], "text"),
                       GetSQLValueString($_POST['urlxuhao'], "int"),
                       GetSQLValueString($_POST['urlid'], "int"));
  $ret = $database->exec($updateSQL);


  $updateGoTo = "urllist.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_url = "-1";
if (isset($_GET['urlid'])) {
  $colname_url = $_GET['urlid'];
}

$query_url = sprintf("SELECT * FROM url WHERE urlid = %s", GetSQLValueString($colname_url, "int"));
$url =  $database->query($query_url);
$row_url = $url->fetchArray(SQLITE3_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>无标题文档</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../css/default.css" rel="stylesheet" type="text/css" />
</head>

<body><form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"><table width="95%" border="1">
  <tr>
    <td width="17%">网站名称</td>
    <td width="83%"><span id="sprytextfield1">
      <input type="text" name="urlname" id="urlname"  value="<?php echo $row_url['urlname']; ?>"/>
       <span class="textfieldRequiredMsg">需要提供一个值。</span></span></td>
  
  </tr>
  <tr>
    <td>网站地址</td>
    <td><span id="sprytextfield2">
      <input type="text" name="url" id="url"  value="<?php echo $row_url['url']; ?>"/>
       <span class="textfieldRequiredMsg">需要提供一个值。</span></span></td>
   
  </tr>
  <tr>
    <td>序号<input name="urlid" type="hidden" value="<?php echo $row_url['urlid']; ?>"  />
      </td>
    <td><span id="sprytextfield3">
    <input type="text" name="urlxuhao" id="urlxuhao" value="<?php echo $row_url['urlxuhao']; ?>" />
    <span class="textfieldRequiredMsg">需要提供一个数值。</span><span class="textfieldInvalidFormatMsg">格式无效。</span></span></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="button" id="button" value="提交" /></td>
  </tr>
</table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer");
//-->
</script>
</body>
</html>
<?php
$database->close();
?>
