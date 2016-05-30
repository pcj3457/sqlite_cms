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

// 根据不同后缀名，采用不同函数取得图片

 
require_once('../function/GetSQLValueString_no.php');
 require_once('../db/MyDB.php');
$database = new MyDB();

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if (isset($_POST['newsid'])&&($_POST["newsid"] ==="")) {
	
	if($_POST['txtImg']<>""){
	$img_name=$_SERVER['DOCUMENT_ROOT'].$_POST['txtImg']; //取得图片名字
	$sj="/attachment/image/".time().".jpg";//库中记录
	$img_descname=$_SERVER['DOCUMENT_ROOT'].$sj;
	$src_img=imagecreatefromjpeg($img_name); //在内存中取得图片
	$ow=imagesx($src_img);// 老图片宽度
	$oh=imagesy($src_img); //老图片高度
	if ($_POST['mustfirst']=="1"){
	$nw=300; //新图片宽度
	$nh=210; //新图片高度
	}
	else
	{
		$nw=300; //新图片宽度
	$nh=210; //新图片高度
	}
	$desc_img=imagecreatetruecolor($nw,$nh); //建立新图
	imagecopyresampled($desc_img,$src_img,0,0,0,0,$nw,$nh,$ow,$oh);//压缩图片
	imagejpeg($desc_img,$img_descname); //存储到新图片
	}
	else
	{
		$sj="";
		}
  $insertSQL = sprintf("INSERT INTO news (KindID,title, content, ImgUrl, IfShow, indate,userid,infoname,IfCheck,IfUsed,xuhao) VALUES (%s,%s, %s,%s,%s, %s, %s,%s,1,%s,%s)",
                       GetSQLValueString($_POST['type'], "int"),
					   GetSQLValueString($_POST['title'], "text"),
					   GetSQLValueString($_POST['FCKeditor1'], "text"),
                       GetSQLValueString($sj, "text"),
                       GetSQLValueString($_POST['mustfirst'], "int"),
                       GetSQLValueString($_POST['datetime'], "int"),
					   GetSQLValueString($_POST['userid'], "int"),
					    GetSQLValueString($_POST['username'], "text"),
					   GetSQLValueString($_POST['ifused'], "int"),
					   GetSQLValueString($_POST['xuhao'], "int"));
 //$database = new MyDB();
  $ret = $database->exec($insertSQL);
  $insertGoTo="newslist.php";
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["newsid"])) && ($_POST["newsid"] !=="")) {
	
	if (($_POST['txtImg']<>"")&&(strpos($_POST['txtImg'],"upload")!==false)){
		
			
	$img_name=$_SERVER['DOCUMENT_ROOT'].$_POST['txtImg']; //取得图片名字
	$sj="/attachment/image/".time().".jpg";//库中记录
	$img_descname=$_SERVER['DOCUMENT_ROOT'].$sj;
	$src_img=imagecreatefromjpeg($img_name); //在内存中取得图片
	$ow=imagesx($src_img);// 老图片宽度
	$oh=imagesy($src_img); //老图片高度
	if ($_POST['mustfirst']=="1"){
	$nw=300; //新图片宽度
	$nh=210; //新图片高度
	}
	else
	{
		$nw=300; //新图片宽度
	$nh=210; //新图片高度
	}
	$desc_img=imagecreatetruecolor($nw,$nh); //建立新图
	imagecopyresampled($desc_img,$src_img,0,0,0,0,$nw,$nh,$ow,$oh);//压缩图片
	imagejpeg($desc_img,$img_descname); //存储到新图片
	}
	else
	{
		$sj=$_POST['txtImg'];
		}
	
  $updateSQL = sprintf("UPDATE news SET IfCheck=1,KindID=%s,title=%s,infoname=%s, content=%s, ImgUrl='".$sj."', IfShow=%s, indate=%s,userid=%s,IfUsed=%s,xuhao=%s WHERE NewsID=%s",
                       GetSQLValueString($_POST['type'], "int"),
					    GetSQLValueString($_POST['title'], "text"),
					    GetSQLValueString($_POST['username'], "text"),
						  GetSQLValueString($_POST['FCKeditor1'], "text"),
                        GetSQLValueString($_POST['mustfirst'], "int"),
                       GetSQLValueString($_POST['datetime'], "int"),
					   GetSQLValueString($_POST['userid'], "int"),
					   GetSQLValueString($_POST['ifused'], "int"),
					   GetSQLValueString($_POST['xuhao'], "int"),
                       GetSQLValueString($_POST['newsid'], "int"));
 //$database = new MyDB();
  $ret = $database->exec($updateSQL);
 



 $updateGoTo="newslist.php";
 	header(sprintf("Location: %s", $updateGoTo));

	
}


//$database = new MyDB();
$query_kinds = "SELECT * FROM newskind where ParentID <>0 ORDER BY KindID DESC";
$kinds =  $database->query($query_kinds);
$row_kinds = $kinds->fetchArray(SQLITE3_ASSOC);
$totalRows_kinds =$kinds->numColumns();





$colname_rs = "-1";
if (isset($_GET['newsid'])) {
  $colname_rs = $_GET['newsid'];

//$database = new MyDB();
$query_rs = sprintf("SELECT news.*,user.username FROM news,user WHERE  NewsID = %s", GetSQLValueString($colname_rs, "int"));
$rs = $database->query($query_rs);
$row_rs =$rs->fetchArray(SQLITE3_ASSOC);
$totalRows_rs =$rs->numColumns();
if ($rs)
{ $title=$row_rs['title']; 
  $infoname=$row_rs['infoname']; 
  $content=$row_rs['content'];
  $imgurl=$row_rs['ImgUrl'];
  $userid=$_SESSION['userid'];
	$ifused=$row_rs['IfUsed'];
	$xuhao=$row_rs['xuhao'];}
}
else
{ 
$ifused=1;
$userid=$_SESSION['userid'];
$title="";
$infoname=$_SESSION['name'];
$content="";
$imgurl="";
$xuhao="";
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title>新闻管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" charset="utf-8" src="../ueditor/ueditor.config.js"></script><script type="text/javascript" charset="utf-8"  src="../ueditor/ueditor.all.min.js"></script>

<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="../ueditor/lang/zh-cn/zh-cn.js"></script>

<link href="../css/default.css" rel="stylesheet" type="text/css">

</HEAD>
<SCRIPT language="JavaScript">
            window.onload = function(){ 
   var editor = UE.getEditor('FCKeditor1',{
        initialFrameWidth : 800,
        initialFrameHeight: 600
    })
  ;
    editor.addListener('contentChange', function () {
		        var oCombo = document.getElementById('upimg'); 
                var seindex=oCombo.selectedIndex; 
                oCombo.innerHTML = '' 
        var content = editor.getContent(); 
// alert(content);
 
 var b=/src=\"([^\"]*?)\"/gi
 var s=content.match(b);
 if (s)
{
    
AddComboOption(oCombo, "选择图片","");
  for(var i= 0;i<s.length;i++)
{
var tu=i+1;
s[i].replace(b,"$1");

AddComboOption(oCombo, "图片"+tu, RegExp.$1);  
  }}  });
	      }  
           
            function selectImg() 
            { 
                var imgDrop = document.getElementById("upimg").options[document.getElementById("upimg").selectedIndex].value; 
                if(imgDrop!="")
				{document.getElementById("txtImg").value=imgDrop; 
            } 
			}
            function AddComboOption(combo, optionText, optionValue){ 
                var oOption = document.createElement("OPTION");                
                combo.options.add(oOption);                
                oOption.innerHTML = optionText; 
                oOption.value = optionValue;                
                return oOption; 
            } 
 
</SCRIPT>
<body bottomMargin="0" leftMargin="0" topMargin="0" rightMargin="0">
<form name="Form1" method="POST" action="<?php echo $editFormAction; ?>" id="Form1">
  <TABLE id="Table1" style="WIDTH: 95%;" cellSpacing="0"
	cellPadding="0" width="760" align="center" border="0">
    <TR>
      <TD vAlign="top"><TABLE id="Table4" cellSpacing="0" cellPadding="0" width="100%"
			border="0" align="center">
          <TR>
            <TD><TABLE id="Table5" cellSpacing="0" cellPadding="0" width="100%"
					align="center" border="0">
                <TR>
                  <TD style="WIDTH: 92px" align="center"><span id="Label1"
							style="height:18px;width:80px;">文章标题：</span></TD>
                  <TD><span id="sprytextfield1">
                    <input name="title" type="text" id="TextBox1" class="input"
							style="height:24px;width:300px;" value="<?php echo  $title;?>" />
                    序号
                    <input name="xuhao" type="text" id="xuhao" size="4" value="<?php echo $xuhao; ?>">
                  </span>
                    <input type="hidden" name="userid" id="userid" value="<?php echo $userid;?>">
                    作者
                    <input name="username" type="text" id="username" value="<?php  echo $infoname;?>" size="16" >
                    <input name="ifused" type="radio" id="ifused" value="1" <?php if ($ifused==1)
					  { echo "checked"; } 
					  else
					  { echo "";} 
					   ?> >
                    非首页
                    <input name="ifused" type="radio" id="ifused" value="0" <?php if ($ifused==0)
					  { echo "checked"; } 
					  else
					  { echo "";} 
					   ?>  >
                    首页</TD>
                </TR>
              </TABLE>
              <TABLE id="Table6" cellSpacing="0" cellPadding="0" width="100%"
					align="center" border="0">
                <TR>
                  <TD width="74" align="center" ><span id="Label2"
							style="width:88px;">文章分类：</span></TD>
                  <td width="90" bgColor="#ffffff" style="WIDTH: 90px"><select name="type" id="DropDownList1"
								style="height:22px;width:89px;">
                      <?php if (isset($row_rs['KindID'])){
do {  
?>
                      <option value="<?php echo $row_kinds['KindID']?>"<?php if (!(strcmp($row_kinds['KindID'],$row_rs['KindID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_kinds['KindTitle']?></option>
                      <?php
} while ($row_kinds = $kinds->fetchArray(SQLITE3_ASSOC));
					  }
					  else
					  {
						  do {  
?>
                      <option value="<?php echo $row_kinds['KindID']?>"><?php echo $row_kinds['KindTitle']?></option>
                      <?php
} while ($row_kinds = $kinds->fetchArray(SQLITE3_ASSOC));
					  }

?>
                    </select></td>
                  <TD height="5" align="left" > 优先级：
                    <select name="mustfirst" id="DropDownList2"
								style="height:22px;width:89px;">
                      <option  value="1" <?php if ((isset( $row_rs['IfShow']))&& $row_rs['IfShow']==1) {echo "selected=\"selected\"";} ?>>放在首页</option>
                      <option value="0" <?php if ((isset( $row_rs['IfShow']))&& $row_rs['IfShow']==0) {echo "selected=\"selected\"";} ?>> 普通 </option>
                      <option value="2" <?php if ((isset( $row_rs['IfShow']))&& $row_rs['IfShow']==2) {echo "selected=\"selected\"";} ?>>图片集锦</option>
                    </select>
                    <input type="hidden" name="datetime" value="<?php echo time();?>">
                    <select id="upimg" name="upimg" onChange="selectImg();">
                      <option value="" selected="selected">选择图片</option>
                    </select>
                    <input type="text"  size="40" name="txtImg" id="txtImg" value="<?php echo $imgurl; ?>" ></TD>
                </TR>
              </TABLE>
              <TABLE id="Table8" cellSpacing="0" cellPadding="0" width="100%"
					align="center" border="0">
              </TABLE>
              <TABLE id="Table10" cellSpacing="0" cellPadding="3" width="100%"
					align="center" border="0" height="400">
                <TR>
                  <TD vAlign="top" colspan="2"><P>
                      <textarea id="FCKeditor1" name="FCKeditor1" ><?php echo $content; ?></textarea>
                    </P></TD>
                </TR>
              </TABLE>
              <table id="Table14" style="WIDTH: 467px; HEIGHT: 8px"
					cellSpacing="0" cellPadding="0" width="467" align="center"
					border="0">
                <tr>
                  <td align="center"><input type="submit" name="Button1"
							value=" 确  定 " id="Button1" class="myButton"/></td>
                  <td align="center"><input type="button" name="Button2"
							value=" 返  回 " id="Button2" class="myButton" onClick="javascript:history.back()"/></td>
                </tr>
              </table></TD>
          </TR>
        </TABLE></TD>
    </TR>
  </TABLE>
  <input type="hidden" name="MM_insert" value="Form1">
  <input type="hidden" name="newsid" value="<?php if (isset($_GET['newsid'])&&($_GET['newsid'])!==""){echo $_GET['newsid'];} ?>">
  <input type="hidden" name="MM_update" value="Form1">
</form>

</body>
</HTML>
<?php
unset($kinds);

if (isset($_GET["newsid"]))
{
unset($rs);
}

if (isset($_POST["newsid"])&&($_POST["newsid"] ==="")) {
unset($s);
}
$database->close();
?>
