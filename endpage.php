<?php include('action_endpage.php');
include('function/function.php');
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $row_news['title']; ?></title>
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
<body><?php include('top.php'); ?>
<!-- 内容-->
<div class="mid">
  <?php include('left.php'); ?>
  <div class="right">
    <div class="dizhi">首页&gt; <?php echo $row_news['KindTitle']; ?></div>
    <div class="endpage">
    <h1> <?php echo $row_news['title']; ?></h1>
    
    <ul>
    <li> <?php echo $row_news['content']; ?></li>
    </ul>
    </div>
  </div>
</div>
<?php include('bottom.php'); ?>

</body>
</html>
