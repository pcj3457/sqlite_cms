<?php include('action_endpage.php');
include('function/function.php');
 ?>
<?php
session_start();
//在页首先要开启session,
//error_reporting(2047);
session_destroy();
//将session去掉，以每次都能取新的session值;
//用seesion 效果不错，也很方



 require_once('db/MyDB.php');
 $database = new MyDB();
$type=1;
$currentPage = $_SERVER["PHP_SELF"];



$maxRows_newslist = 15;
$pageNum_newslist = 0;
if (isset($_GET['pageNum_newslist'])) {
  $pageNum_newslist = $_GET['pageNum_newslist'];
}
$startRow_newslist = $pageNum_newslist * $maxRows_newslist;


	
	$query_newslist = sprintf("SELECT * FROM message   ORDER BY messageid DESC");


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
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>给我们留言</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.4.2.js" type="text/javascript"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$("#validate").bind("blur",function()
	{   var xvalidate=$("#validate").val();
	if (xvalidate!==""){
		$.post("../function/serv_validate.php",{validate:xvalidate},function(data){
			if(data==0){
			$("#yanzheng").html("<font color=green>通过验证</font>");
			$("#button").attr("disabled",false)
			}
			if(data==1){
			$("#yanzheng").html("<font color=red>输入有误</font");
			$("#button").attr("disabled",true);}},"text");	}
	})
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
<style>
.bbs {
	FONT-SIZE: 13px;
	LINE-HEIGHT: 18px;
	LETTER-SPACING: 2px;
	BORDER-LEFT-COLOR: #B0D901;
	BORDER-BOTTOM-COLOR: #B0D901;
	BORDER-TOP-COLOR: #B0D901;
	BORDER-COLLAPSE: collapse;
	BORDER-RIGHT-COLOR: #B0D901;
	borderColor: #B0D901;
	cellSpacing: 1;
	cellPadding: 4;
	rules: all
}
#form1 img {
	float: left;
	cursor: pointer;
}
#form1 #validate {
	float: left;
	margin-left: 5px;
	margin-top: 15px;
}
#form1 #yanzheng {
	float: left;
	margin-top: 15px;
}
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include('top.php'); ?>
<!-- 内容-->
<div class="mid">
  <?php include('left.php'); ?>
  <div class="right">
    <div class="dizhi">首页&gt;欢迎留言</div>
    <div class="endpage">
      <h1>
        <form id="form1" name="form1" method="post" action="action_liuyan.php">
          <table width="78%"  id="bbs"  cellpadding="0">
            <tr>
              <td width="14%" align="left">昵 称</td>
              <td align="left"><span id="sprytextfield1">
                <input name="name" type="text" id="name" size="40" />
                <span class="textfieldRequiredMsg">请提供一个昵称。</span></span></td>
            </tr>
            <tr>
              <td align="left">内 容</td>
              <td align="left"><label for="content"></label>
                <span id="sprytextarea1">
                <textarea name="content" id="content" cols="45" rows="5"></textarea>
                <span id="countsprytextarea1">&nbsp;</span><span class="textareaRequiredMsg">需要提供一个值。</span><span class="textareaMinCharsMsg">不符合最小字符数要求。</span></span><br/></td>
            </tr>
            <tr>
              <td align="left">邮 件</td>
              <td align="left"><label for="email"></label>
                <span id="sprytextfield2">
                <input type="text" name="email" id="email" />
                <span class="textfieldRequiredMsg">需要提供一个值。</span><span class="textfieldInvalidFormatMsg">格式无效。</span></span>
                <label for="yanzhengma"></label>
                </img></td>
            </tr>
            <tr>
              <td align="left" valign="middle">验证码</td>
              <td align="left" valign="middle"><img  title="点击刷新" src="../function/captcha.php" align="absbottom" onclick="this.src='../function/captcha.php?'+Math.random();" />
                <input name="validate" type="text" id="validate" size="6" maxlength="6" />
                <div id="yanzheng" >请输入验证码</div></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><input type="submit" name="button" id="button" value="提交"  /></td>
            </tr>
          </table>
        </form>
      </h1>
      <ul>
        <?php do { ?>
        <li>
          <TABLE cellSpacing=1 cellPadding=0 width=95% align=center bgColor=#E4ECD7 border=0>
            <TR>
                                 <TD align=middle width=24><IMG height=12 src="images/rr.gif" width=10></TD>
                    <TD width=435>　<?php echo $row_newslist['name'] ?>在<?php echo date("Y-m-d",$row_newslist['indate']); ?>说：</TD>
                  </TR>
                </TABLE></TD>
            </TR>
            <TR>
              <TD bgColor=#f9f9f9><TABLE width="95%"  border=0 align="center" cellPadding=5 cellSpacing=0 class=ttt>
                  <TR>
                    <TD height=36 align="left" style="WORD-BREAK: break-all"><p><?php echo $row_newslist['content'] ?></p>
                      <?php if ($row_newslist['recontent']<>""){ ?>
                      <TABLE style='BORDER-RIGHT: #cccccc 1px dotted;TABLE-LAYOUT: fixed; BORDER-TOP: #cccccc 1px dotted; BORDER-LEFT: #cccccc 1px dotted; BORDER-BOTTOM: #cccccc 1px dotted' cellSpacing=0 cellPadding=6 width='95%' align=center border=0>
                        <TR>
                          <TD style='WORD-WRAP: break-word' bgColor=#f3f3f3><FONT color=#990000><FONT face=Verdana>管理员在
                            <?php echo date("Y-m-d",$row_newslist['redate']);  ?>
                            回复:<FONT style="FONT-SIZE: 12px"><?php echo  $row_newslist['recontent']; ?> </FONT></FONT></FONT></TD>
                        </TR>
                      </TABLE></TD>
                  </TR>
                </TABLE>
                <?php }?></TD>
            </TR>
          </TABLE>
        </li>
        <?php } while ($row_newslist = $newslist->fetchArray(SQLITE3_ASSOC)); ?>
        <li>
          <TABLE cellSpacing=0 cellPadding=0 width=95% border=0 bgcolor="#f3f3f3" align="center">
            <tr>
              <td><?php if ($pageNum_newslist > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, 0, $queryString_newslist); ?>">第一页</a>
                  <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_newslist > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, max(0, $pageNum_newslist - 1), $queryString_newslist); ?>">前一页</a>
                  <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_newslist < $totalPages_newslist) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, min($totalPages_newslist, $pageNum_newslist + 1), $queryString_newslist); ?>">下一页</a>
                  <?php } // Show if not last page ?></td>
              <td><?php if ($pageNum_newslist < $totalPages_newslist) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_newslist=%d%s", $currentPage, $totalPages_newslist, $queryString_newslist); ?>">最后一页</a>
                  <?php } // Show if not last page ?></td>
              <td> 记录  到 <?php echo min($startRow_newslist + $maxRows_newslist, $totalRows_newslist) ?> (总共 <?php echo $totalRows_newslist ?>)</td>
            </tr>
          </TABLE>
        </li>
      </ul>
    </div>
  </div>
</div>
<?php include('bottom.php'); ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {counterId:"countsprytextarea1", counterType:"chars_count", minChars:10});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email");
</script>
</body>
</html>
