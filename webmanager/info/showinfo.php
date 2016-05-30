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

mysql_select_db($database_mysql, $mysql);
$query_wqxx = "SELECT count(NewsID) as shuliang FROM wqxx WHERE IfCheck = 0";
$wqxx = mysql_query($query_wqxx, $mysql) or die(mysql_error());
$row_wqxx = mysql_fetch_assoc($wqxx);
$totalRows_wqxx = mysql_num_rows($wqxx);

mysql_select_db($database_mysql, $mysql);
$query_upnews = "SELECT count(news.NewsID) as newsshuliang FROM news left join admin on news.userid=admin.userid where admin.jueseid=2 and news.KindID=70 and news.IfCheck=0";
$upnews = mysql_query($query_upnews, $mysql) or die(mysql_error());
$row_upnews = mysql_fetch_assoc($upnews);
$totalRows_upnews = mysql_num_rows($upnews);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>信息列表</title>
<link href="../../css/default.css" rel="stylesheet" type="text/css" />
</head>

<body><table cellspacing="0" cellpadding="4" align="Center" rules="all" bordercolor="LightGrey" border="1" id="Webcustomdatagrid1" style="border-color:LightGrey;width:75%;border-collapse:collapse;">
			<TR bgcolor="#ACDEFF">
			<TD colspan="3" align="center">待处理信息列表</TD>
			</TR>
		
		
		<?php if ($row_wqxx['shuliang']<>0){ ?>
		
<tr bgcolor=#FFFFFF>
					<TD align=right>应回复邮件事项：</TD>
					<td><?php echo $row_wqxx['shuliang']; ?>件</td>
					<TD> <a href="../letterbox/wqxxlist.php?operation=0">查看</a></TD>
					</tr><?php }?>
		<?php if ($row_upnews['newsshuliang']<>0){ ?><tr bgcolor=#FFFFFF>
					<TD align=right>应审核的上报信息：</TD>
					<td><?php echo $row_upnews['newsshuliang']; ?>件</td>
					<TD><a href="infolist.php?IfCheck=0">查看</a></TD>
  </tr><?php }?>
		
		
		
		
		
		
					</table>
 
 
 

</body>
</html>
<?php
mysql_free_result($wqxx);

mysql_free_result($upnews);
?>
