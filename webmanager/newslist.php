<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../gl/index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
require_once('../function/GetSQLValueString.php');
 require_once('../db/MyDB.php');
 $database = new MyDB();
$type=1;
$currentPage = $_SERVER["PHP_SELF"];



$maxRows_newslist = 15;
$pageNum_newslist = 0;
if (isset($_GET['pageNum_newslist'])) {
  $pageNum_newslist = $_GET['pageNum_newslist'];
}
$startRow_newslist = $pageNum_newslist * $maxRows_newslist;


if ((isset($_POST['type'])) && ($_POST['type']<>""))
{
	$type=$_POST['type'];
$query_newslist = sprintf("SELECT news.*,newskind.KindTitle,newskind.ParentID FROM news left join newskind  on news.KindID=newskind.KindID  where news.KindID=%s ORDER BY news.NewsID DESC",GetSQLValueString($_POST['type'], "int"));
}
else
{
	
	$query_newslist = sprintf("SELECT news.*,newskind.KindTitle,newskind.ParentID FROM news left join newskind  on news.KindID=newskind.KindID   ORDER BY news.NewsID DESC");

	}
$query_limit_newslist = sprintf("%s LIMIT %d , %d", $query_newslist,  $startRow_newslist,$maxRows_newslist);
$newslist = $database->query($query_limit_newslist);
$row_newslist =$newslist->fetchArray(SQLITE3_ASSOC);

$all_newslist =  $database->query($query_newslist);
$all_row_newslist =$all_newslist->fetchArray(SQLITE3_ASSOC);
 $totalRows_newslist = 0;
 do {  $totalRows_newslist++;
 } while($all_row_newslist =$all_newslist->fetchArray(SQLITE3_ASSOC));
// print($totalRows_newslist );

if (isset($_GET['totalRows_newslist'])) {
  $totalRows_newslist = $_GET['totalRows_newslist'];
} 
$totalPages_newslist = ceil($totalRows_newslist/$maxRows_newslist)-1;




$queryString_newslist = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_newslist") == false && 
        stristr($param, "totalRows_newslist") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_newslist = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_newslist = sprintf("&totalRows_newslist=%d%s", $totalRows_newslist, $queryString_newslist);

//$database = new MyDB();
$query_kinds = "SELECT * FROM newskind where ParentID <> '0'";
$kinds = $database->query($query_kinds) ;
$row_kinds = $kinds->fetchArray(SQLITE3_ASSOC);
$totalRows_kinds = $kinds->numColumns();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>文章列表</title>
<link href="../css/default.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<form name="frm" method="post" action="newslist.php">
<table align="center">
 <tr>
	<td  align="center">
	  栏目：
	  <select name= "type" id="DropDownList1" style="height:22px;width:89px;">
	    <option value="" <?php if (!(strcmp("", $type))) {echo "selected=\"selected\"";} ?>>&nbsp;</option>
	    <?php
do {  
?>
	    <option value="<?php echo $row_kinds['KindID']?>"<?php if (!(strcmp($row_kinds['KindID'], $type))) {echo "selected=\"selected\"";} ?>><?php echo $row_kinds['KindTitle']?></option>
	    <?php
} while ($row_kinds = $kinds->fetchArray(SQLITE3_ASSOC));
 

?>
	    </select>	  <input type="submit" name="Button1" value=" 查  询 " onClick="" class="Button" /></td>
	</tr>
</table>
<TABLE id="Table6" cellSpacing="0" cellPadding="0" width="95%"
	align="center" border="0">
<tr>
		<TD vAlign="top">
		<table cellspacing="0" cellpadding="3" align="Center" rules="all"
			bordercolor="DarkSeaGreen" border="1" id="WebCustomDataGrid1"
			style="border-color:DarkSeaGreen;width:100%;border-collapse:collapse;">
			<tr align="Center" valign="Bottom" style="height:20px;">
				<td style="width:45%;">文章标题</td>
				<td style="width:5%;">序号</td>
				<td style="width:10%;">栏目</td>
				
				<td style="width:10%;">图片首页显示</td>
				<td style="width:10%;">首页显示</td>
				<td style="width:10%;">修改</td>
				<td style="width:10%;">删除</td>
			</tr>
			
			<?php do { ?><!author,content,title,mustfirst,type,id,datetime>
			<tr bgcolor="#FFFFFF" align="Center" title="<?php echo strip_tags($row_newslist['title']); ?>">				
				
				  <td align="Left"><a href="../endpage.php?NewsID=<?php echo $row_newslist['NewsID']; ?>" target="_blank"><?php echo $row_newslist['title']; ?></a>(<?php echo date('Y-m-d H:i:s',$row_newslist['indate']); ?>)</td>
				  <td align="Left"><?php echo $row_newslist['xuhao']; ?></td>
				  <td title=<?php echo $row_newslist['KindID']; ?>><?php echo $row_newslist['KindTitle']; ?></td>
							  <td><?php 
				   if (is_null($row_newslist['ImgUrl'])){	echo "无图";			  
				  }
					else
					{ if ($row_newslist['IfShow']==1) {?>
				    <A href="IfShow.php?NewsID=<?php echo $row_newslist['NewsID'] ?>&IfShow=<?php echo 0; ?>">
			        <img src="/images/show.jpg" title="设置非首页显示" style="border:0"></A>		<?php }
					else
					{?>		 <A href="IfShow.php?NewsID=<?php echo $row_newslist['NewsID']; ?>&IfShow=<?php echo 1; ?>">
			        <img src="/images/show_un.jpg" title="设置非首页显示" style="border:0"></A>		<?php }}
					
					?>		</td>
				  <td><?php if ($row_newslist['IfUsed'])
				  {echo "非首页";}
				  else
				  {echo "首页显示";} ?></td>
				  <td><a href="newsadd.php?newsid=<?php echo $row_newslist['NewsID']; ?>">编辑</a></td>
				  <td><a onClick="return confirm('您真的要删除此行吗？')" 
					href="<?php echo "delnews.php?NewsID=".$row_newslist['NewsID']."&ParentID=".$row_newslist['ParentID']."&KindID=".$row_newslist['KindID']; ?>">删除</a></td>
			</tr>
				  <?php } while ($row_newslist = $newslist->fetchArray(SQLITE3_ASSOC)); ?>
			
			
			
		</table>
		</TD>
	</tr>
	<!-- 翻页 begin -->
<tr>
  <td>
    <div align="center">

            <table border="0">
              <tr>
                <td><?php if ($pageNum_newslist > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, 0, $queryString_newslist); ?>">第一页</a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_newslist > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, max(0, $pageNum_newslist - 1), $queryString_newslist); ?>">前一页</a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_newslist < $totalPages_newslist) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, min($totalPages_newslist, $pageNum_newslist + 1), $queryString_newslist); ?>">下一个</a>
                    <?php } // Show if not last page ?></td>
                <td><?php if ($pageNum_newslist < $totalPages_newslist) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, $totalPages_newslist, $queryString_newslist); ?>">最后一页</a>
                    <?php } // Show if not last page ?></td>
                    <td> 记录 <?php echo ($startRow_newslist + 1) ?> 到 <?php echo min($startRow_newslist + $maxRows_newslist, $totalRows_newslist) ?> (总共 <?php echo $totalRows_newslist ?>)</td>
              </tr>
            </table>
	 </div>
   </td>
 </tr>
 <!-- 翻页 end -->
</TABLE>
</form>
</body>
</html>
<?php
unset($newslist);

unset($kinds);

$database->close();
?>
