 <div class="left">
    <div class="znew">
      <div class="tit1">
      <h1>园内动态</h1>
      <div class="mor"><a href="../list.php?kindid=25">更多</a></div>
      </div>
      <ul><?php  
	  
	  $data=getNewsByNewsid(25,0,5);
	  
	  foreach($data as $row_25 ){?>
      <li><a href="endpage.php?NewsID=<?php echo $row_25['NewsID'];  ?>"><?php echo cnSubStr($row_25['title'],40); ?></a></li><?php } ?>
    
      </ul>
    </div>
    <div class="znew">
      <div class="tit1b">
      <h1>采摘套餐</h1>
      <div class="mor"><a href="../list.php?kindid=10">更多</a></div>
      </div>
      <ul><?php   $data=getNewsByNewsid(10,0,5);
	  
	  foreach($data as $row_10  ){?>
    <li><a href="endpage.php?NewsID=<?php echo $row_10['NewsID'];  ?>"><?php echo cnSubStr($row_10['title'],40); ?></a></li><?php }?>
      </ul>
    </div>
    <div class="ztel">
     <div class="tit3">
      <h1>联系我们</h1>
      <div class="mor"><a href="../list.php?kindid=12">更多</a></div>
      </div>
      <ul><?php  
	  
	  $data=getNewsByNewsid(14,0,1);
	  
	  foreach($data as $row_14 ){ ?>
      <li><?php echo $row_14['content']; ?></li><?php }?>
      </ul>
    </div>
  </div>