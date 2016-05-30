<?php require_once('../function/GetSQLValueString.php');
 require_once('../db/MyDB.php');
 $database = new MyDB();
 
$query_newslist = sprintf("SELECT * from message  ORDER BY messageid DESC");
$query_sum="select count(messageid) as sum from message";
$sum=$database->query($query_sum);
$row_sum=$sum->fetchArray(SQLITE3_ASSOC);
$currentPage = $_SERVER["PHP_SELF"];



$maxRows_newslist = 15;
$pageNum_newslist = 0;
if (isset($_GET['pageNum_newslist'])) {
  $pageNum_newslist = $_GET['pageNum_newslist'];
}
$startRow_newslist = $pageNum_newslist * $maxRows_newslist;

 $query_limit_newslist = sprintf("%s LIMIT %d , %d", $query_newslist,  $startRow_newslist,$maxRows_newslist);
$newslist = $database->query($query_limit_newslist);
$row_newslist =$newslist->fetchArray(SQLITE3_ASSOC);

$all_newslist =  $database->query($query_newslist);
$all_row_newslist =$all_newslist->fetchArray(SQLITE3_ASSOC);
 $totalRows_newslist = $row_sum['sum'];

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
 ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script type="text/javascript" src="../jquery/jquery-1.11.2.min.js"></script><script type="text/javascript" src="../jquery/jquery-ui.min.js"></script>
</script><link rel="stylesheet" type="text/css" href="../jquery/jquery-ui.min.css"/>
<link href="../css/StyleGl.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function del(messageid)
{
	 if(confirm("确定删该条留言吗？"))
 {
 window.location.href="delMessage.php?messageid="+messageid;
 }
	
	}
function recon(messageid,content)

{
	$("#content").html(content);  
$("#update_messageid").val(messageid);
	$("#update").dialog({title:"请输入回复内容：",
		width:"600"});
	
	}
/*function update()
{
	var xredate=$("#redate").val();
	var xrecontent=$("#recontent").val();
	var xupdate_messageid=$("#update_messageid");
	$.post("updateliuyan.php",{messageid:xupdate_messageid,recontent:xrecontent,redate:xredate},function(data){
		 $("#update").html(data);},"html");
	}*/
</script>
<title>留言管理</title>
</head>

<body>

<table width="95%" border="1" align="center">
  <tr>
    <td align="center">选择</td>
    <td align="center">昵称</td>
    <td align="center">内容</td>
    <td align="center">日期</td>
    <td align="center">回复内容</td>
    <td align="center">回复日期</td>
    <td align="center">操作</td>
  </tr>
  <?php do {?><tr>
    <td title="<?php echo $all_row_newslist['messageid'];  ?>"><input name="messageid" type="checkbox" value="<?php echo$all_row_newslist['messageid'];  ?>" /></td>
    <td><?php echo $all_row_newslist['name'];  ?></td>
    <td><?php echo $all_row_newslist['content'];  ?></td>
    <td><?php echo date("Y-m-d",$all_row_newslist['indate']);  ?></td>
    <td><?php echo $all_row_newslist['recontent'];  ?></td>
    <td><?php if ($all_row_newslist['redate']<>"") {echo date("Y-m-d",$all_row_newslist['redate']);}  ?></td>
    <td><input name="" type="button" value="回复"  onclick="recon('<?php echo$all_row_newslist['messageid'];  ?>','<?php echo $all_row_newslist['content'];  ?>')" />
    <input type="button" name="del" id="del" value="删除"  onclick="del('<?php echo$all_row_newslist['messageid'];  ?>');"/></td>
  </tr><?php } while($all_row_newslist =$all_newslist->fetchArray(SQLITE3_ASSOC));?>
  <tr>
    <td colspan="2" align="center"><input type="button" name="button" id="button" value="删除选中" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
     <td align="center"><?php if ($pageNum_newslist > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, 0, $queryString_newslist); ?>">第一页</a>
                    <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_newslist > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, max(0, $pageNum_newslist - 1), $queryString_newslist); ?>">前一页</a>
                    <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_newslist < $totalPages_newslist) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, min($totalPages_newslist, $pageNum_newslist + 1), $queryString_newslist); ?>">下一个</a>
                    <?php } // Show if not last page ?></td>
    <td align="center"><?php if ($pageNum_newslist < $totalPages_newslist) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, $totalPages_newslist, $queryString_newslist); ?>">最后一页</a>
                    <?php } // Show if not last page ?></td>
                    <td colspan="3" align="right"> 记录 <?php echo ($startRow_newslist + 1) ?> 到 <?php echo min($startRow_newslist + $maxRows_newslist, $totalRows_newslist) ?> (总共 <?php echo $totalRows_newslist ?>)</td>
  </tr>
</table>
<div id="update" style="display:none;" ><form action="updateliuyan.php" method="post"><table border="1">
  <tr>
    <td width="17%">咨询问题：</td>
    <td width="83%" id="content">&nbsp;</td>
  </tr>
  <tr>
    <td>回复内容</td>
    <td><textarea name="recontent" cols="50" rows="4" id="recontent"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input name="redate"  id="redate" type="hidden" value="<?php echo time(); ?>" /><input name="messageid" type="hidden"  id="update_messageid" value="" /><input name="recen" id="recon"  type="submit"  value="提交回复" />
      
      </td>
    </tr>
</table></form>
<br/></div></body>
</html>