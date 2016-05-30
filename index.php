<?php include('action_endpage.php');
include('function/function.php');
$db =  new MyDB();

//图片锦集
$query_tpjj = "SELECT *   from news WHERE IfShow=2 and ImgUrl is not null  order by NewsID desc limit 0,10";
$Recordset_tpjj =  $db->query($query_tpjj);

// 时令水果及价格

$query_slsg = "SELECT *   from news WHERE IfShow=1 and ImgUrl is not null and KindID=16 order by xuhao desc limit 0,8";
$Recordset_slsg =  $db->query($query_slsg);


// 友情链接
$query_yq = "SELECT * from url order by urlxuhao ";
$Recordset_yq =  $db->query($query_yq);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>怀柔风光采摘园</title>
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
  <div class="news">
    <div class="news2">
      <div class="tit2a">
        <h1>怀柔风光采摘园</h1>
        <div class="mor"><a href="../list.php?kindid=11"  target="_blank" >更多</a></div>        
      </div>
      <div class="about">
       <?php   $data=getNewsByNewsid(11,0,1);
	  
	  foreach($data as $row_11  ){?> 
       <div class="apic"><img src="<?php echo $row_11['ImgUrl']; ?>" width="180" height="136" /></div>
       <ul>
       <h2>怀柔风光采摘园</h2>
       <li>
        <?php  echo cutstr_html($row_11['content'],190);  ?></li>
      </ul></div><?php } ?>
    </div>
    <div class="news11">
      <div class="tit1a">
        <h1>园内动态</h1>
        <div class="mor"><a href="../list.php?kindid=25" target="_blank">更多</a></div>        
      </div>
      <ul>
       <?php  
	  
	  $data=getNewsByNewsid(25,0,5);
	  
	  foreach($data as $row_25 ){?>
      <li><a href="endpage.php?NewsID=<?php echo $row_25['NewsID'];  ?>" class="wen" target="_blank"><?php echo cnSubStr($row_25['title'],40); ?></a></li><?php } ?>
        
        </ul>
    </div>
  </div>

  <div class="wrap gallery">
    <ul id="gallery"><!-- 图片锦集-->
    <?php 
	// 图片锦集
	/*if ($row_tpjj === true) 
	
	{*/
	while ($row_tpjj = $Recordset_tpjj->fetchArray(SQLITE3_ASSOC)) {?>
      <li><a href="endpage.php?NewsID=<?php echo $row_tpjj['NewsID'];  ?>"  target="_blank"><img src="<?php echo $row_tpjj['ImgUrl']; ?>" border="0" /><?php echo cnSubStr($row_tpjj['title'],10); ?></a></li><?php }
	 // }
	  ?>
   
      
 </ul>
  </div>
  <div class="mod">
    <div class="newa">
      <div class="newsp">
        <div class="tit1b">
          <h1>采摘套餐</h1>
          <div class="mor"><a href="../list.php?kindid=10" target="_blank">更多</a></div>        
        </div>
        <ul>
        <?php   $data=getNewsByNewsid(10,0,10);
	  
	  foreach($data as $row_10  ){?>
    <li><a href="endpage.php?NewsID=<?php echo $row_10['NewsID'];  ?>" class="wen" target="_blank"><?php echo cnSubStr($row_10['title'],14); ?></a></li><?php }?>
         
        </ul>
      </div>
    </div>
    <!-- 图片列表-->
    <div class="mright">
      <div class="piclist1">
        <div class="tit2">
        <h1>时令水果及价格</h1>
        <div class="mor"><a  href="../list.php?kindid=16" target="_blank">更多</a></div>        
      </div>
        <div class="piclist">
          <ul><?php while ($row_slsg = $Recordset_slsg->fetchArray(SQLITE3_ASSOC)) {?>
            <li><a href="endpage.php?NewsID=<?php echo $row_slsg['NewsID'];  ?>"  target="_blank"><img src="<?php  echo $row_slsg['ImgUrl']?>" width="169" height="113" /></a><h3><a href="endpage.php?NewsID=<?php echo $row_slsg['NewsID'];  ?>"  target="_blank"><?php echo cnSubStr($row_slsg['title'],8); ?></a></h3><?php  echo cutstr_html($row_slsg['content'],25);  ?></li><?php }?>
            
          </ul>
        </div>
      </div>
    </div>
  </div>
  
    <div class="tulit"><img src="images/306.jpg" width="1004" height="97" /></div>
  <div class="fri">
    <div class="tit5"></div>
    <ul><?php while ($row_yq = $Recordset_yq->fetchArray(SQLITE3_ASSOC)) {?>
    <li><a href="<?php echo $row_yq['url'] ?>" target="_blank"><?php echo  $row_yq['urlname'] ?></a></li><?php }?>
   
    </ul>
  </div>
</div>
<?php include('bottom.php'); ?>
<script src="js/jquery-1.4.2.js" type="text/javascript"></script> 
<script src="js/jquery.bxSlider.min.js" type="text/javascript"></script> 
<script type="text/javascript">

	//nav
	$('li').mousemove(function(){
		$(this).find('div').slideDown("1000");//you can give it a speed
		$(this).find('span a').addClass("cur");
	});
	$('li').mouseleave(function(){
		$(this).find('div').slideUp("fast");
		$(this).find('span a').removeClass("cur");		
	});

	//
  $('#focus').bxSlider({
    mode: "fade",
    auto: true,
	controls: false,
    pager: true
  });
	//
  $('#gallery').bxSlider({
    auto: true,
    autoControls: false,
	controls: false,
	displaySlideQty: 5,
	moveSlideQty: 1
  });
	//
  $('#banner').bxSlider({
    mode: "fade",
    auto: true,
    autoControls: false,
	controls: false,
	displaySlideQty: 1,
	moveSlideQty: 1
  });
		
</script>
</body>
</html>
<?php $db->close();?>