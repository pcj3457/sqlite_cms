<?php require_once('../../Connections/mysql.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}



$totalRows_countbs=0;
  $querystring="";
 
if (isset($_POST['startdate']) )
{ 
if ($_POST['startdate']<>"" and $_POST['enddate']<>"")
{ $querystring=$querystring." indate > ".strtotime($_POST['startdate'])." and  indate < ".strtotime($_POST['enddate']) ;
}

if ($_POST['startdate']<>"" && $_POST['enddate']=="")

{ $querystring=$querystring."indate >  '".strtotime($_POST['startdate'])."' and indate <  '".time()."'" ;
}


mysql_select_db($database_mysql, $mysql);
$query_countbs = sprintf("select b.baosongliang,count(NewsID) as caiyongliang,admin.username   from (news as a left join 
(SELECT count(NewsID) as baosongliang,userid
FROM news 
WHERE %s
Group by news.userid) as b on a.userid=b.userid ) left join admin on a.userid=admin.userid
where %s 
Group by a.userid;",$querystring,$querystring);
$countbs = mysql_query($query_countbs, $mysql) or die(mysql_error());
$row_countbs = mysql_fetch_assoc($countbs);
$totalRows_countbs = mysql_num_rows($countbs);


}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<script src="src/js/jscal2.js"></script>
    <script src="src/js/lang/cn.js"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />
<title>统计</title>
<link href="../../css/default.css" rel="stylesheet" type="text/css" />
</head>

<body><form id="form1" name="form1" method="post" action=""><table width="95%" border="1">
  <tr>
    <td>开始时间</td>
    <td><input type="text" name="startdate" id="startdate" value="<?php if (isset($_POST['startdate'])&&($_POST['startdate']<>""))
	{
		echo $_POST['startdate']; }?>"/> <script type="text/javascript">////<![CDATA[
//
    var cal = Calendar.setup({
        onSelect: function(cal) { cal.hide() }
    });
    cal.manageFields("startdate", "startdate", "%Y-%m-%d");
      //cal.manageFields("f_btn2", "f_date2", "%b %e, %Y");
      //cal.manageFields("f_btn3", "f_date3", "%e %B %Y");
      //cal.manageFields("f_btn4", "f_date4", "%A, %e %B, %Y");

    //]]></script>  </td>
    <td>
      截止时间</td>
    <td><input type="text" name="enddate" id="enddate"  value="<?php if (isset($_POST['enddate'])&&($_POST['enddate']<>""))
	{
		echo $_POST['enddate']; }?>"/><script type="text/javascript">////<![CDATA[
//
    var cal = Calendar.setup({
        onSelect: function(cal) { cal.hide() }
    });
    cal.manageFields("enddate", "enddate", "%Y-%m-%d");
      //cal.manageFields("f_btn2", "f_date2", "%b %e, %Y");
      //cal.manageFields("f_btn3", "f_date3", "%e %B %Y");
      //cal.manageFields("f_btn4", "f_date4", "%A, %e %B, %Y");

    //]]></script> </td>
  </tr>
  <tr>
    <td colspan="4" align="center">
      <input type="submit" name="button" id="button" value="提交" />
    </td>
  </tr>
</table></form>
<p><table width="95%" border="1" align="center">
  <tr>
    <td align="center"><strong>姓名</strong></td>
    <td align="center"><strong>报送量</strong></td>
    <td align="center"><strong>采用数</strong></td>
   
  </tr><?php if ($totalRows_countbs>0)
  { do {?>
  <tr>
    <td align="center"><?php echo $row_countbs['username'];  ?></td>
    <td align="center"><?php echo $row_countbs['baosongliang']; ?></td>
    <td align="center"><?php echo $row_countbs['caiyongliang']; ?></td>
    </tr><?php }
  while($row_countbs = mysql_fetch_assoc($countbs));
  }?>
</table>
</p>

</body>

</html>
<?php
if (isset($_POST['startdate']) ){
mysql_free_result($countbs);
}
?>
