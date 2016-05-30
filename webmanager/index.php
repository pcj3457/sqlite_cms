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
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>

<TITLE>后台管理系统</TITLE>

<META http-equiv=Content-Type content="text/html; charset=utf-8"><LINK 
href="../css/StyleGl.css" type=text/css rel=stylesheet><LINK 
href="../css/default.css" type=text/css rel=stylesheet>
<SCRIPT>

		var currentDiv = "";
		var currentUrl = "";
		var preUrl = "";
		var preXtext = "空白页面";
		var currentXtext = "";
  
  		function bt0_over(id,name){           //功能：改变按钮的over状态图片
			id.src="images/"+name+"_02.jpg";
			id.style.cursor="hand";
			thisCurrentDiv = eval(currentDiv);
			//thisCurrentDiv.style.display = "none";
			}
		  
		function bt0_out(id,name){            //功能：改变按钮的out状态图片
			id.src="images/"+name+"_01.jpg";
			id.style.cursor="default";}
			
			
		function bt_over(id,name){           //功能：改变按钮的over状态图片
			id.src="images/"+name+"m1.jpg";
			id.style.cursor="hand";
			thisCurrentDiv = eval(currentDiv);
			//thisCurrentDiv.style.display = "none";
			}
		  
		function bt_out(id,name){            //功能：改变按钮的out状态图片
			id.src="images/"+name+"m0.jpg";
			id.style.cursor="default";}
		  
		function bt_down(id,name){           //功能：改变按钮的down状态图片
			id.src="images/"+name+"_03.jpg";}
		  
		function bt_up(id,name){             //功能：改变按钮的up状态图片
			id.src="images/"+name+"_01.jpg";}

		function bt2_over(id,name){           //功能：改变按钮的over状态图片
			id.style.background = "url"+"(images/"+name+"_02.jpg) no-repeat";
			id.style.cursor="hand";}
		  
		function bt2_out(id,name){            //功能：改变按钮的out状态图片
			id.style.background = "url"+"(images/"+name+"_01.jpg) no-repeat";
			id.style.cursor="default";}
    
		function bt3_over(id){
			id.style.background= "url"+"(/images/button_menu_00_02.jpg) 0% 47% no-repeat";}
		   
		function bt3_out(id){
			id.style.background= "url"+"(/images/button_menu_00_01.jpg) 0% 47% no-repeat";}
				
		  function btover(id)
		  {
		  	thistd = eval (id)
		  	thistd.style.background="#ff8000"
		  	thistd.style.color="#ffffff"
		  } 
		  
		  function btout(id)
		  {
		  	thistd = eval (id)
		  	thistd.style.background=""
		  	thistd.style.color="#000000"
		  } 
  
		function bt_quit(){                  //功能：“退出”按钮
			var truthBeTold = window.confirm("您确定要离开本系统吗？");
			if (truthBeTold) {  logOut(); }}
		  
		function bt_close(){                 //功能：“关闭”按钮
			document.all.xWindow.style.display="none";}
				
		  function bt_open()                 //功能：“显示”按钮
		  {
		    document.all.xWindow.style.display="block";
		  }
		  
		function bt2_pre(){                   //功能：“上一页”按钮
			document.all.yWindow.src = preUrl;
			document.all.xName.innerHTML = preXtext;}
		  
		function bt2_next(){                  //功能：“下一页”按钮
			document.all.yWindow.src = currentUrl;
			document.all.xName.innerHTML = currentXtext;}
		    
		function bt_pre(){                   //功能：“上一页”按钮
			document.frames("yWindow").window.history.back(-1);
		}
		  
		function bt_next(){                  //功能：“下一页”按钮
			document.frames("yWindow").window.history.forward();
		}
		  
		function showDiv(id){                //功能：显示相应菜单
			if(currentDiv != ""){
			thisCurrentDiv = eval(currentDiv);
			thisCurrentDiv.style.display = "none";}
			thisDiv = eval("div"+id);
			thisDiv.style.display = "block";
			currentDiv = "div"+id;}
		  
		function hiddenDiv(id){              //功能：隐藏相应菜单
		    if(currentDiv != ""){
		      thisCurrentDiv = eval(currentDiv);
		      thisCurrentDiv.style.display = "none";}
		  }
		  
		function xChange(url, xtext){         //功能：改变xWindw的标题和内容页面
			document.all.xWindow.style.display = "block";
			preUrl = document.all.yWindow.src;
			preXtext = document.all.xName.innerHTML;
			currentUrl = url;
			currentXtext = xtext;
			document.all.yWindow.src = url;
			document.all.xName.innerHTML = xtext;
        }
        
        function showMessageInfo(url, xtext){         //功能：改变xWindw的标题和内容页面
			document.all.xWindow.style.display = "block";
			preUrl = document.all.yWindow.src;
			preXtext = document.all.xName.innerHTML;
			currentUrl = url;
			currentXtext = xtext;
			document.all.yWindow.src = url;
			document.all.xName.innerHTML = xtext;
        }
		
		function doPrompt(){
			xWidth = window.screen.width;
			xHeight = window.screen.height;
			var today;
				today = new Date();
			var prom;
			var url="";
			
		//	prom=window.open(url,
		//			"PROMPT", 
		//			"resizable=no,menubar=no,directories=no,status=no,location=no,scrollbars=yes,width=456 ,height=205");
		//	prom.moveTo(xWidth/3,xHeight/3);	
			
		}  
		
		function multPrompt(){
		window.setInterval("doPrompt()",10*60*1000);
		} 

		function inita(){                    //功能：使根窗口任意分辨率下屏幕居中
			//xWidth = window.screen.width-1024;
			//xHeight = window.screen.height-768;
			//moveTo(xWidth/2,xHeight/2);
			//doPrompt();
			//multPrompt();
			
			
			showMessageInfo("../webmanager/info/about.php","系统指南")
			
                 //setTimeout('bodyload()',300)
			}
			
		function killerror(){
			return true;}
		
		function logOut(){
			var url = "../gl/loginout.php";
			document.all.logout.action=url;
			document.all.logout.submit();
		}
			
		</SCRIPT>
<META content="MSHTML 6.00.3790.2817" name=GENERATOR>
</HEAD>
<BODY 
style="PADDING-RIGHT: 1px; PADDING-LEFT: 1px; PADDING-BOTTOM: 1px; MARGIN: 1px; OVERFLOW: auto; PADDING-TOP: 1px" 
onclick=hiddenDiv(this)  onLoad="inita()">
<!--<script>
//闪烁的表格边框
function flashit(){if(!document.all)return;if (td123.style.borderColor=="black")td123.style.borderColor="#999999";else td123.style.borderColor="black"}setInterval("flashit()",500)
//渐入的效果,改变alpha值
function high(image){theobject=image,highlighting=setInterval("highlightit(theobject)",100)}function low(image){clearInterval(highlighting),image.filters.alpha.opacity=50}function highlightit(cur2){if (cur2.filters.alpha.opacity<100)cur2.filters.alpha.opacity+=20;else if(window.highlighting)clearInterval (highlighting)}
//拖动层的js
var over=false,down=false,divleft,divtop;function move(){if(down){plane.style.left=event.clientX-divleft;plane.style.top=event.clientY-divtop;}}
//滑动层
function bodyload()
{
if(plane.style.pixelTop!=550)
{
plane.style.pixelTop -=5
setTimeout('bodyload()',300)
}
}
//渐变显示层
function Show(divid) {
divid.filters.revealTrans.apply();
divid.style.visibility = "visible";
divid.filters.revealTrans.play();
}
function Hide(divid) {
divid.filters.revealTrans.apply();
divid.style.visibility = "hidden";
divid.filters.revealTrans.play();
}
</script>-->
</div>
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=1>
  <TBODY>
  <TR bgColor=red>
    <TD colSpan=2 height=24>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" 
      background=../images/top_2bg.jpg border=0>
        <TBODY>
        <TR>
          <TD width=550>&nbsp;</TD>
          <TD align=right><IMG style="CURSOR: hand" onclick=bt_open() alt=显示窗口 
            src="../images/homepage.gif" align=absBottom> <IMG 
            style="CURSOR: hand" onclick=bt_pre() alt=后退到前一页 
            src="../images/history_back.gif" align=absBottom> <IMG 
            style="CURSOR: hand" onclick=bt_next() alt=前进到下一页 
            src="../images/history_forwards.gif" align=absBottom> <IMG 
            style="CURSOR: hand" onclick=bt_quit() alt=注销 
            src="../images/logoff.gif" align=absBottom>　&nbsp; 
    </TD></TR></TBODY></TABLE></TD></TR>
  <TR>
    <TD id=lefttd vAlign=top width=180 name="lefttd"><!--left menu logo-->
      <TABLE cellSpacing=0cellPadding=0 width=100 align=center border=0>
        <TBODY>
         
          <tr>
            <td align="center"><img onMouseOver="showDiv('01')" src="../images/110.jpg"><font 
            face=宋体><br>
             页面管理</font></td>
          </tr>
           <tr>
            <td align="center"><img onMouseOver="showDiv('02')" src="../images/111.jpg"><font 
            face=宋体><br>
             个人资料</font></td>
          </tr>
       
      </TBODY></TABLE></TD>
    <TD id=righttd 
    style="PADDING-RIGHT: 15px; PADDING-LEFT: 15px; BACKGROUND: url(../bmphone/images/desktop.jpg) no-repeat right bottom; PADDING-BOTTOM: 15px; PADDING-TOP: 15px" 
    width="100%" name="righttd"><!--right content window-->
      <TABLE id=xWindow onMouseOver="hiddenDiv('')" style="DISPLAY: none" 
      height="100%" cellSpacing=0 cellPadding=0 width="100%" bgColor=white 
      border=0 name="xWindow">
        <TBODY>
        <TR>
          <TD width=15 height=38><IMG src="../images/window_1_1.jpg"></TD>
          <TD width=34><IMG title=关闭 style="CURSOR: hand" onclick=bt_close() 
            src="../images/window_1_2.jpg"></TD>
          <TD style="PADDING-TOP: 8px" width="100%" 
          background=../images/window_1_3bg.jpg><SPAN class=windowTitle id=xName 
            name="xName">受理登记</SPAN></TD>
          <TD width=18><IMG title=前一页 style="CURSOR: hand" onclick=bt_pre() 
            src="../images/window_1_4.jpg"></TD>
          <TD width=5 background=../images/window_1_3bg.jpg></TD>
          <TD width=18><IMG title=后一页 style="CURSOR: hand" onclick=bt_next() 
            src="../images/window_1_5.jpg"></TD>
          <TD width=5 background=../images/window_1_3bg.jpg></TD>
          <TD width=18><IMG title=关闭 style="CURSOR: hand" onclick=bt_close() 
            src="../images/window_1_6.jpg"></TD>
          <TD width=9><IMG src="../images/window_1_7.jpg"></TD>
          <TD width=9><IMG src="../images/window_1_8.jpg"></TD></TR>
        <TR>
          <TD background=../images/window_2_1bg.jpg></TD>
          <TD bgColor=#f9f9d9 colSpan=8><IFRAME id=yWindow 
            style="WIDTH: 100%; HEIGHT: 100%" name=yWindow 
            src="" frameBorder=0></IFRAME></TD>
          <TD background=../images/window_2_8bg.jpg></TD></TR>
        <TR>
          <TD width=15 height=17><IMG src="../images/window_3_1.jpg"></TD>
          <TD background=../images/window_3_3bg.jpg colSpan=8></TD>
      <TD width=9><IMG 
  src="../images/window_3_8.jpg"></TD></TR></TBODY></TABLE></TD></TR>
  <TR>
    <TD colSpan=2 height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 width="100%" 
      background=../images/status2_2.jpg border=0>
        <TBODY>
        <TR>
          <TD align=left width=43><IMG src="../images/status2_1.jpg"></TD>
          <TD><?php echo $_SESSION['name']; ?>，您好！欢迎使用后台管理系统</TD>
          <TD align=middle width=156><SPAN class=dateText id=xTime 
            name="xTime">2004年08月24日 14:17</SPAN></TD>
          <TD style="PADDING-TOP: 6px" vAlign=top width=68><IMG 
           style="CURSOR: hand" onclick=bt_quit()             
            src="../images/button_quit_01.jpg"></TD>
          <TD align=right width=20></TD></TR>
        <FORM name=logout></FORM></TABLE></TD></TR></TBODY></TABLE>
<SCRIPT>
          if(navigator.appName!="Microsoft Internet Explorer")
          {
            document.all.yWindow.style.height=document.all.lefttd.scrollHeight-90
          }
        </SCRIPT>

<div class=myDiv id=div01 style="LEFT: 50px; TOP: 110px" name="div01">
  <table class=menuentry_1 cellspacing=3 cellpadding=2 width=60 border=0>
    <tbody>
      <tr>
        <td height=1></td>
      </tr>
      <tr>
        <td class=menuentry_2 onMouseOver=btover(this) 
    onClick="xChange('newsadd.php','添加文章')" 
    onMouseOut=btout(this) align=middle>添加文章</td>
      </tr>
      <tr>
        <td class=menuentry_2 onMouseOver=btover(this) 
    onClick="xChange('newslist.php','文章列表')" 
    onMouseOut=btout(this) align=middle>文章列表</td>
      </tr>
       <tr>
        <td class=menuentry_2 onMouseOver=btover(this) 
    onClick="xChange('KindList.php','类别维护')" 
    onMouseOut=btout(this) align=middle>类别维护</td>
      </tr>
       <tr>
        <td class=menuentry_2 onMouseOver=btover(this) 
    onClick="xChange('url/urllist.php','友情链接')" 
    onMouseOut=btout(this) align=middle>维护链接</td>
      </tr>
           <tr>
        <td class=menuentry_2 onMouseOver=btover(this) 
    onClick="xChange('editmessage.php','管理留言')" 
    onMouseOut=btout(this) align=middle>管理留言</td>
      </tr> <!--  <tr>
        <td class=menuentry_2 onMouseOver=btover(this) 
    onClick="xChange('../action/endpage2html.php','全站静态')" 
    onMouseOut=btout(this) align=middle>全站静态</td>
      </tr> <tr>
       <tr>
        <td class=menuentry_2 onMouseOver=btover(this) 
    onClick="xChange('../action/alllisttohtml.php','列表静态')" 
    onMouseOut=btout(this) align=middle>列表静态</td>
      </tr>--> <tr>
        <td height=1></td>
      </tr>
    </tbody>
  </table>
</div>

<DIV class=myDiv id=div02 style="LEFT: 50px; TOP: 175px" name="div02">
<TABLE class=menuentry_1 cellSpacing=3 cellPadding=2 width=60 border=0>
  <TBODY>
  <TR><tr><TD height=1></TD></TR>
    <TD class=menuentry_2 onmouseover=btover(this) 
    onclick="xChange('EditPW.php','修改密码')" 
    onmouseout=btout(this) align=middle>修改密码</TD></TR>
<tr><TD height=1></TD></TR></TBODY></TABLE></DIV>
 
    
    
    
<SCRIPT>
			  function getTime(){              //功能：获取日期和时间
				var hours, minutes, seconds, xfile;
				var intHours, intMinutes, intSeconds;
				var today;
				today = new Date();
				tempyear=today.getYear().toString()
				if(navigator.appName!="Microsoft Internet Explorer")
				{
				  intYear = today.getYear().toString().substr(1,2);
				}
				else
				{
				  intYear = today.getYear().toString().substr(2,2);
				}				
				intMonth = today.getMonth();
				intDay = today.getDate();
				intHours = today.getHours();
				intMinutes = today.getMinutes();
				intSeconds = today.getSeconds();
				if (intHours == 0) { hours = "0:"; }
				  else if (intHours < 12) { hours = intHours+":"; }
				  else if (intHours == 12) { hours = "12:"; }
				  else { hours = intHours + ":"; }
				if (intMinutes < 10) { minutes = "0"+intMinutes+":"; }
				  else { minutes = intMinutes+":"; }
				if (intSeconds < 10) { seconds = "0"+intSeconds+" "; }
				  else { seconds = intSeconds+" "; }
				timeString = intYear+"年"+(intMonth+1)+"月"+intDay+"日 "+hours+minutes+seconds;
				document.all.xTime.innerHTML = timeString;
				window.setTimeout("getTime();", 100);
			  }
			  window.load = getTime();
			</SCRIPT>
</BODY></HTML>