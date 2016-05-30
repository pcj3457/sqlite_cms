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

if (isset($_GET['operation'])&&($_GET['operation']==0)) {
	$operation=0;
}
else
{
	$operation=1;
	}
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_letter = 10;
$pageNum_letter = 0;
if (isset($_GET['pageNum_letter'])) {
  $pageNum_letter = $_GET['pageNum_letter'];
}
$startRow_letter = $pageNum_letter * $maxRows_letter;

$colname_letter = "0";
if (isset($_GET['IfCheck'])) {
  $colname_letter = $_GET['IfCheck'];
}


mysql_select_db($database_mysql, $mysql);
$query_letter = sprintf("SELECT news.title,news.NewsID,admin.username,news.indate,news.IfCheck,case 
						when news.IfUsed=1 then  '采用' 
						when news.IfUsed=0 then '没采用' 
						end
						as IfUsed 
FROM news left join admin on news.userid=admin.userid
WHERE admin.jueseid=2 and news.shangbao='1'  and news.IfCheck=%s ORDER BY news.NewsID DESC", GetSQLValueString($colname_letter, "int"));
$query_limit_letter = sprintf("%s LIMIT %d, %d", $query_letter, $startRow_letter, $maxRows_letter);
$letter = mysql_query($query_limit_letter, $mysql) or die(mysql_error());
$row_letter = mysql_fetch_assoc($letter);

if (isset($_GET['totalRows_letter'])) {
  $totalRows_letter = $_GET['totalRows_letter'];
} else {
  $all_letter = mysql_query($query_letter);
  $totalRows_letter = mysql_num_rows($all_letter);
}
$totalPages_letter = ceil($totalRows_letter/$maxRows_letter)-1;

$queryString_letter = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_letter") == false && 
        stristr($param, "totalRows_letter") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_letter = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_letter = sprintf("&totalRows_letter=%d%s", $totalRows_letter, $queryString_letter);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>信息列表</title>

<link href="../../css/StyleGl.css" rel="stylesheet" type="text/css" />
</head>
<script language="javascript"> 
	/*
	function openProcessWin(_url) {
    	window.open(_url, "_blank", "width=805,height=580,left=20,top=10,toolbar=0,location=0,directories=0,resizable=1,scrollbars=1");
	}
			*/
	function showList(lyfkh) {
		childWin = window.open("reletter.php?NewsID="+lyfkh, "win", "width=660,height=520,"+
				"left=20,top=10,toolbar=0,location=0,directories=0,resizable=1,scrollbars=1");
		childWin.focus();
	/*
    	var sForm = document.frm;
    	sForm.target="_blank";
    	sForm.action = "/hrapp/communion/CommunionServlet?operation=noteDetail&fkh="+lyfkh;
    	sForm.submit();
    	sForm.target="_self";
    */
	}
	function delNote(lyfkh) {
	    if(!confirm("确定要删除吗？"))
	      return false;
    		}

</script>

<body>
<table id="Table1" border="0" cellspacing="0" cellpadding="0" width="770" align="center">
  <tbody>
    <tr>
      <td valign="top" background="../../images/back_nleft02.jpg" width="80" align="middle"><table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tbody>
          <tr>
            <td height="10" background="../../images/back_nleft01.jpg" width="115"></td>
          </tr>
          <tr>
            <td height="18" align="middle"></td>
          </tr>
          <tr align="middle">
            <td height="28"><?php if ($colname_letter==0) {?>未审核信息<?php } 
			else
			{?> <a href="infolist.php?IfCheck=0" >未审核信息</a><?php }?></td>
          </tr>
          <tr align="middle">
            <td height="28"><?php if ($colname_letter==1) {?>已审核信息<?php } 
			else
			{?> <a href="infolist.php?IfCheck=1" >已审核信息</a><?php }?></td>
          </tr>
        </tbody>
      </table></td>
      <td valign="top"><table border="0" cellspacing="0" cellpadding="0" width="100%">
          <tbody>
            <tr>
              <td><table id="CustomDataGrid" border="1" rules="all" cellspacing="0" bordercolor="lightgrey" cellpadding="4" align="center">
                <tbody>
                  <tr align="middle" bgcolor="#acdeff">
                    <td width="40%">主题</td>
                    <td width="10%">信息员姓名</td>
                    <td width="10%">是否采用</td>
                    <td width="20%">上报时间</td>
                    <td width="10%" align="middle">查看</td>
                            </tr>
                  <?php 
				  if ($totalRows_letter >0){
				  
				  
				  do { ?>
                    <tr height="22" align="middle" bgcolor="#ffffff">
    <td title="<?php echo $row_letter['title']; ?>" align="left"><?php echo $row_letter['title']; ?></td>
    <td  align="middle"><?php echo $row_letter['username']; ?></td>
    <td  align="middle"><?php echo $row_letter['IfUsed']; ?></td>
    <td><?php echo date("Y-m-d h:i:s",$row_letter['indate']); ?></td>
        <td align="middle"><input onclick="window.location.href='newsadd.php?newsid=<?php echo $row_letter['NewsID']; ?>';" value="查看" type="button" name="btnBl2" />
      </td>
      </tr>
                    <?php } while ($row_letter = mysql_fetch_assoc($letter));
				  }
							
					
					?>
                </tbody>
              </table></td>
            </tr>
            <!-- 翻页 begin -->
            <tr>
              <td><div align="center">
                <table border="0">
                  <tr>
                    <td><?php if ($pageNum_letter > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_letter=%d%s", $currentPage, 0, $queryString_letter); ?>">第一页</a>
                        <?php } // Show if not first page ?></td>
                    <td><?php if ($pageNum_letter > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_letter=%d%s", $currentPage, max(0, $pageNum_letter - 1), $queryString_letter); ?>">前一页</a>
                        <?php } // Show if not first page ?></td>
                    <td><?php if ($pageNum_letter < $totalPages_letter) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_letter=%d%s", $currentPage, min($totalPages_letter, $pageNum_letter + 1), $queryString_letter); ?>">下一个</a>
                        <?php } // Show if not last page ?></td>
                    <td><?php if ($pageNum_letter < $totalPages_letter) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_letter=%d%s", $currentPage, $totalPages_letter, $queryString_letter); ?>">最后一页</a>
                        <?php } // Show if not last page ?></td>
                        <td width="160"> 记录 <?php echo ($startRow_letter + 1) ?> 到 <?php echo min($startRow_letter + $maxRows_letter, $totalRows_letter) ?> (总共 <?php echo $totalRows_letter ?>条）</td>
                  </tr>
                </table>
              </div></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>
</body>
</html>
<?php
mysql_free_result($letter);
?>
