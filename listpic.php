<?php include('action_endpage.php');
include('function/function.php');

	$database = new MyDB();
$type=1;
$currentPage = $_SERVER["PHP_SELF"];



$maxRows_newslist = 15;
$pageNum_newslist = 0;
if (isset($_GET['pageNum_newslist'])) {
  $pageNum_newslist = $_GET['pageNum_newslist'];
}
$startRow_newslist = $pageNum_newslist * $maxRows_newslist;


$query_newslist = sprintf("SELECT news.*,newskind.KindTitle,newskind.ParentID FROM news left join newskind  on news.KindID=newskind.KindID  where news.KindID=%s and (news.ImgUrl is not null) ORDER BY news.xuhao DESC",
GetSQLValueString($_GET['kindid'],"int"));
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




?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $row_newslist['KindTitle']; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript">
$(function(){
	$("#KinSlideshow").KinSlideshow({
			moveStyle:"left",
			intervalTime:4,<!--设置间隔时间为4秒-->
			mouseEvent:"mouseover",
			isHasTitleBar:true,<!--是否显示标题背景 可选值：【 true | false 】-->
			titleFont:{TitleFont_size:14,TitleFont_color:"#FFFFFF"}
	});
})
var _hmt = _hmt || [];

(function() {

  var hm = document.createElement("script");

  hm.src = "//hm.baidu.com/hm.js?6c3b32ed6b5cbabdf75a18136be88fd6";

  var s = document.getElementsByTagName("script")[0]; 

  s.parentNode.insertBefore(hm, s);

})();
</script>
<!--[if IE 6]>
<script src="js/png.js"></script>
<script>
  DD_belatedPNG.fix('*');
</script>
<![endif]-->
</head>
<body>
<?php include('top.php'); ?>
<!-- 内容-->
<div class="mid">
 <?php include('left.php'); ?>
  <div class="right">
    <div class="dizhi">首页&gt; <?php echo $row_newslist['KindTitle']; ?></div>
    <div class="lpic">
    <ul><?php  
	  
	  do { ?>
    <li><a href="endpage.php?NewsID=<?php echo $row_newslist['NewsID'];  ?>" ><img src="<?php echo $row_newslist['ImgUrl'];  ?>" width="210" height="130"  border="0"class="ppic" /></a><a href="endpage.php?NewsID=<?php echo $row_newslist['NewsID'];  ?>" ><?php echo cnSubStr($row_newslist['title'],40); ?></a></li><?php }
	while($row_newslist =$newslist->fetchArray(SQLITE3_ASSOC))?>
    </ul>
   </div>
   <div class="page"><?php if ($pageNum_newslist > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, 0, $queryString_newslist); ?>">第一页</a>
                    <?php } // Show if not first page ?><?php if ($pageNum_newslist > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, max(0, $pageNum_newslist - 1), $queryString_newslist); ?>">前一页</a>
                    <?php } // Show if not first page ?><?php if ($pageNum_newslist < $totalPages_newslist) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, min($totalPages_newslist, $pageNum_newslist + 1), $queryString_newslist); ?>">下一页面</a>
                    <?php } // Show if not last page ?><?php if ($pageNum_newslist < $totalPages_newslist) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, $totalPages_newslist, $queryString_newslist); ?>">最后一页</a>
                    <?php } // Show if not last page ?> 记录 <?php echo ($startRow_newslist + 1) ?> 到 <?php echo min($startRow_newslist + $maxRows_newslist, $totalRows_newslist) ?> (总共 <?php echo $totalRows_newslist ?>)</div>

  </div>
</div>
<?php include('bottom.php'); ?>
</body>
</html>
