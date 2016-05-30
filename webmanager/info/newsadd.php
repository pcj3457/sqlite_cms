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

$MM_restrictGoTo = "../../gl/index.php";
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
<?php require_once('../../Connections/mysql.php'); 
require_once('../getSQLvalueString.php'); 
if (!isset($_SESSION)) {
  session_start();
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if ($_POST["newsid"] ==="") {
  $insertSQL = sprintf("INSERT INTO news (KindID, title, content, ImgUrl, IfShow, indate,userid,IfCheck,IfUsed) VALUES (%s, %s, %s, %s, %s, %s,%s,1,%s)",
                       GetSQLValueString($_POST['type'], "int"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['FCKeditor1'], "text"),
                       GetSQLValueString($_POST['txtImg'], "text"),
                       GetSQLValueString($_POST['mustfirst'], "int"),
                       GetSQLValueString($_POST['datetime'], "int"),
					   GetSQLValueString($_POST['userid'], "int"),
					   GetSQLValueString($_POST['ifused'], "int"));

  mysql_select_db($database_mysql, $mysql);
  $Result1 = mysql_query($insertSQL, $mysql) or die(mysql_error());
  
   mysql_select_db($database_mysql, $mysql);
$query_s = "SELECT news.*,newskind.ParentID FROM news left join newskind on news.KindID=newskind.KindID order by news.NewsID DESC limit 1";
$s = mysql_query($query_s, $mysql) or die(mysql_error());
$row_s = mysql_fetch_assoc($s);

  $insertGoTo = "../../index2html.php?NewsID=".$row_s['NewsID']."&ParentID=".$row_s['ParentID']."&KindID=".$row_s['KindID']."&info=1";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
 
	header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["newsid"] <> "")) {
  $updateSQL = sprintf("UPDATE news SET IfCheck=1,KindID=%s, title=%s, content=%s, ImgUrl=%s, IfShow=%s, indate=%s,userid=%s,IfUsed=%s WHERE NewsID=%s",
                       GetSQLValueString($_POST['type'], "int"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['FCKeditor1'], "text"),
                       GetSQLValueString($_POST['txtImg'], "text"),
                       GetSQLValueString($_POST['mustfirst'], "int"),
                       GetSQLValueString($_POST['datetime'], "int"),
					   GetSQLValueString($_POST['userid'], "int"),
					   GetSQLValueString($_POST['ifused'], "int"),
                       GetSQLValueString($_POST['newsid'], "int"));

  mysql_select_db($database_mysql, $mysql);
  $Result1 = mysql_query($updateSQL, $mysql) or die(mysql_error());

  $colname_rs = "-1";
if (isset($_GET['newsid'])) {
  $colname_rs = $_GET['newsid'];
}
  mysql_select_db($database_mysql, $mysql);
$query_rs = sprintf("SELECT news.*,newskind.ParentID FROM news left join newskind on news.KindID=newskind.KindID WHERE  news.NewsID = %s", GetSQLValueString($colname_rs, "int"));
$rs = mysql_query($query_rs, $mysql) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);

  $updateGoTo ="../../index2html.php?NewsID=".$row_rs['NewsID']."&ParentID=".$row_rs['ParentID']."&KindID=".$row_rs['KindID']."&info=1";
  
  mysql_free_result($rs); 
	 
	header(sprintf("Location: %s", $updateGoTo));
	
}


mysql_select_db($database_mysql, $mysql);
$query_kinds = "SELECT * FROM newskind where ParentID <>0 ORDER BY KindID DESC";
$kinds = mysql_query($query_kinds, $mysql) or die(mysql_error());
$row_kinds = mysql_fetch_assoc($kinds);
$totalRows_kinds = mysql_num_rows($kinds);

$colname_rs = "-1";
if (isset($_GET['newsid'])) {
  $colname_rs = $_GET['newsid'];
}
mysql_select_db($database_mysql, $mysql);
$query_rs = sprintf("SELECT news.*,admin.username FROM news,admin WHERE news.userid=admin.userid and NewsID = %s", GetSQLValueString($colname_rs, "int"));
$rs = mysql_query($query_rs, $mysql) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title>新闻管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<LINK href="../../webmanger/css/Office.css" type="text/css"	rel="stylesheet">
<script type="text/javascript" src="/fckeditor/fckeditor.js"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</HEAD>
<SCRIPT language="JavaScript">
            window.onload = function(){ 
                
var sBasePath = "../../fckeditor/" ;//它指的是编辑器的位置，要正确并注意目录大小写。 
                var oFCKeditor = new FCKeditor('FCKeditor1'); 
                oFCKeditor.BasePath = sBasePath; 
				oFCKeditor.Width = "100%";
                oFCKeditor.Height = "500";//
				 oFCKeditor.ReplaceTextarea();              
            } 
            function FCKeditor_OnComplete( editorInstance ) 
            { 
            editorInstance.Events.AttachEvent( 'OnBlur', onEditorBlur ) ; //重新注册焦点失去事件。 
            } 
            function $(_id) 
            { 
                return document.getElementById(_id); 
            } 
            function onEditorBlur() 
            {  var oCombo = document.getElementById('upimg'); 
                var seindex=oCombo.selectedIndex; 
                oCombo.innerHTML = '' 
                var oEditor = FCKeditorAPI.GetInstance('FCKeditor1'); 
                var images = oEditor.EditorDocument.body.getElementsByTagName("img");//取得所有的img标签。将它们添加到下拉框中 
//var content = oEditor.GetXHTML(true); 
//    var regpic=/ <IMG src=\"([^\"]*?)\">/gi; 
//    var s=content.match(regpic);    
//    for(var i= 0;i <s.length;i++) 
//      { 
//      AddComboOption(oCombo, "Image"+(i+1), RegExp.$1); 
//      } 
//在这里我也想使用RegExp来取得所有的img,可不知道是哪里的问题总是出错，郁闷。。。 
                AddComboOption(oCombo, "选择图片"," "); 
    for(var i= 0;i <images.length;i++) 
      { 
      AddComboOption(oCombo, "图片"+(i+1),images[i].src); 
      } 
            } 
            function selectImg() 
            { 
                var imgDrop = $("upimg").options[$("upimg").selectedIndex].value; 
                if(imgDrop!="")$("txtImg").value=imgDrop; 
            } 
            function AddComboOption(combo, optionText, optionValue){ 
                var oOption = document.createElement("OPTION");                
                combo.options.add(oOption);                
                oOption.innerHTML = optionText; 
                oOption.value = optionValue;                
                return oOption; 
            } 

 function checkValue(){
 	if(document.Form1.title.value.length == 0){
    alert("文章标题不能为空");
    document.Form1.title.focus();
    return false;
   }
   
   if(document.Form1.author.value.length == 0){
    alert("文章作者不能为空");
    document.Form1.author.focus();
    return false;
   }

   if(document.Form1.title.value.length>250){
    alert("文章标题过长");
    document.Form1.title.focus();
    return false;
   }
     
   document.Form1.submit();
 }
</SCRIPT>
<body bottomMargin="0" leftMargin="0" topMargin="0" rightMargin="0">
<form name="Form1" method="POST" action="<?php echo $editFormAction; ?>" id="Form1">
<TABLE id="Table1" style="WIDTH: 95%;" cellSpacing="0"
	cellPadding="0" width="760" align="center" border="0">
	<TR>
		<TD vAlign="top">
		<TABLE id="Table4" cellSpacing="0" cellPadding="0" width="100%"
			border="0" align="center">
			<TR>
				<TD>
				<TABLE id="Table5" cellSpacing="0" cellPadding="0" width="100%"
					align="center" border="0">
					<TR>
						<TD style="WIDTH: 92px" align="center"><span id="Label1"
							style="height:18px;width:80px;">文章标题：</span></TD>
						<TD><span id="sprytextfield1">
						  <input name="title" type="text" id="TextBox1" class="input"
							style="height:24px;width:323px;" value="<?php echo $row_rs['title']; ?>" />
					    <span class="textfieldRequiredMsg">需要提供一个值。</span></span>
						  <input type="hidden" name="userid" id="userid" value="<?php
						   if (($row_rs['userid']) <>"")
						{echo $row_rs['userid']; 
						}
						else
						  {
						  echo $_SESSION['userid'];
						  }?>">
						  作者
						  <input name="username" type="text" id="username" value="<?php if (($row_rs['username']) <>"")
						{echo $row_rs['username']; 
						}
						else
						  {
						  echo $_SESSION['name'];
						  } ?>" size="8" readonly="readonly">
					  <input name="ifused" type="radio" id="ifused" value="1" checked>
					  采用 <input name="ifused" type="radio" id="ifused" value="0" >
					  不采用</TD>
					</TR>
				</TABLE>
				<TABLE id="Table6" cellSpacing="0" cellPadding="0" width="100%"
					align="center" border="0">
			  <TR>
						<TD width="74" align="center" ><span id="Label2"
							style="width:88px;">文章分类：</span></TD>
						<td width="90" bgColor="#ffffff" style="WIDTH: 90px"><select name="type" id="DropDownList1"
								style="height:22px;width:89px;">
						  <?php
do {  
?>
						  <option value="<?php echo $row_kinds['KindID']?>"<?php if (!(strcmp($row_kinds['KindID'],$row_rs['KindID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_kinds['KindTitle']?></option>
						  <?php
} while ($row_kinds = mysql_fetch_assoc($kinds));
  $rows = mysql_num_rows($kinds);
  if($rows > 0) {
      mysql_data_seek($kinds, 0);
	  $row_kinds = mysql_fetch_assoc($kinds);
  }
?>
                        </select>
				      </td>
						<TD width="60" align="right" >
							优先级：</TD>
					  <td height="5" bgColor="#ffffff">
							<select name="mustfirst" id="DropDownList2"
								style="height:22px;width:89px;">
						    <option  value="1" <?php if (!(strcmp(1, $row_rs['IfShow']))) {echo "selected=\"selected\"";} ?>>放在首页</option>
						    <option value="0" selected="selected" <?php if (!(strcmp(0, $row_rs['IfShow']))) {echo "selected=\"selected\"";} ?>>
						    普通
						    </option>
                        </select>
						<input type="hidden" name="datetime" value="<?php echo $time=time()+(8*60*60); ?>">
						<select id="upimg" name="upimg" onChange="selectImg();">
                         <option value="" selected="selected">选择图片</option>  
						</select>
						<input type="text"  size="40" name="txtImg" id="txtImg" value="<?php if (($row_rs['ImgUrl']) <>"")
						{echo $row_rs['ImgUrl']; 
						}
						else
						echo "";?>" ></td>
					</TR>
				</TABLE>
				<TABLE id="Table8" cellSpacing="0" cellPadding="0" width="100%"
					align="center" border="0">
					
				</TABLE>
								<TABLE id="Table10" cellSpacing="0" cellPadding="3" width="100%"
					align="center" border="0" height="400">
						<TR>
						<TD vAlign="top" colspan="2">
						<P><textarea id="FCKeditor1" name="FCKeditor1" ><?php echo $row_rs['content']; ?></textarea>
						</P>
						</TD>
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
				</table>
				</TD>
			</TR>
		</TABLE>
		</TD>
	</TR>
</TABLE>
<input type="hidden" name="MM_insert" value="Form1">
<input type="hidden" name="newsid" value="<?php echo $_GET[newsid]; ?>">
<input type="hidden" name="MM_update" value="Form1">
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
</body>
</HTML>
<?php
mysql_free_result($kinds);

mysql_free_result($rs);
if ($_POST["newsid"] ==="") {
mysql_free_result($s);
}
?>
