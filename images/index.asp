<%@LANGUAGE="VBSCRIPT"%>
<!--#include file="../Connections/conn.asp" -->
<%
' *** Validate request to log in to this site.
MM_LoginAction = Request.ServerVariables("URL")
If Request.QueryString <> "" Then MM_LoginAction = MM_LoginAction + "?" + Server.HTMLEncode(Request.QueryString)
MM_valUsername = CStr(Request.Form("loginname"))
If MM_valUsername <> "" Then
  Dim MM_fldUserAuthorization
  Dim MM_redirectLoginSuccess
  Dim MM_redirectLoginFailed
  Dim MM_loginSQL
  Dim MM_rsUser
  Dim MM_rsUser_cmd
  
  MM_fldUserAuthorization = ""
  MM_redirectLoginSuccess = "2.asp"
  MM_redirectLoginFailed = "index.asp"

  MM_loginSQL = "SELECT admin_name, admin_pass"
  If MM_fldUserAuthorization <> "" Then MM_loginSQL = MM_loginSQL & "," & MM_fldUserAuthorization
  MM_loginSQL = MM_loginSQL & " FROM tbl_admin WHERE admin_name = ? AND admin_pass = ?"
  Set MM_rsUser_cmd = Server.CreateObject ("ADODB.Command")
  MM_rsUser_cmd.ActiveConnection = MM_conn_STRING
  MM_rsUser_cmd.CommandText = MM_loginSQL
  MM_rsUser_cmd.Parameters.Append MM_rsUser_cmd.CreateParameter("param1", 200, 1, 50, MM_valUsername) ' adVarChar
  MM_rsUser_cmd.Parameters.Append MM_rsUser_cmd.CreateParameter("param2", 200, 1, 50, Request.Form("loginpassword")) ' adVarChar
  MM_rsUser_cmd.Prepared = true
  Set MM_rsUser = MM_rsUser_cmd.Execute

  If Not MM_rsUser.EOF Or Not MM_rsUser.BOF Then 
    ' username and password match - this is a valid user
    Session("MM_Username") = MM_valUsername
    If (MM_fldUserAuthorization <> "") Then
      Session("MM_UserAuthorization") = CStr(MM_rsUser.Fields.Item(MM_fldUserAuthorization).Value)
    Else
      Session("MM_UserAuthorization") = ""
    End If
    if CStr(Request.QueryString("accessdenied")) <> "" And false Then
      MM_redirectLoginSuccess = Request.QueryString("accessdenied")
    End If
    MM_rsUser.Close
    Response.Redirect(MM_redirectLoginSuccess)
  End If
  MM_rsUser.Close
  Response.write("请重新核对用户名和密码!")
End If
%><head>
<style type="text/css">
@import url("2_files/default.css");

.winFrame{
 position:absolute;
 border: outset #E7E193 1px;
 height:275px;
 width:418px;
}
.winTitle{
	position:absolute;
	border-bottom:1px solid black;
	background-color: #E0D97E;
	width:100%;
	height:20px;
	cursor:move;
	left: -1px;
	top: 2px;
	font-size: 12px;
}
.winContent{
	position:absolute;
	top:30px;
 width:100%
 padding: 10px;
	overflow: auto;
	width: 412px;
	height: 239px;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
function dl_close(){                 //功能：“关闭”按钮
			document.all.winFrame.style.display="none";
			document.all.winTilte.style.display="none";}
  function beginDrag(elem,event){
 var deltaX = event.clientX - parseInt(elem.style.left);
 var deltaY = event.clientY - parseInt(elem.style.top);
 document.attachEvent("onmousemove",moveHandler);
 document.attachEvent("onmouseup",upHandler);
 event.cancelBubble = true;
 event.returnValue = false;
 function moveHandler(e){
   if(!e)
       e = window.event;
   elem.style.left = (e.clientX - deltaX) + "px";
   elem.style.top = (e.clientY - deltaY) + "px";
   e.cancelBubble = true;
 }
 function upHandler(e){
  if(!e)
        e = window.event;
     document.detachEvent("onmousemove",moveHandler);
     document.detachEvent("onmouseup",upHandler);
        e.cancelBubble = true;
 }
  }
</SCRIPT>
</head>
<body>
</div>
  <div class=winFrame  id ="winFrame" style="left:250px;top:100px;">
       <div class=winTitle  id="winTitle" onMouseDown="beginDrag(this.parentNode,event);">
         <table width="412" border="0">
           <tr>
             <td width="95">请登陆</td>
             <td width="267"><% if Session("MM_Username")="" then 
			                       response.Write("第一次")
								   end if   %></td>
             <td width="36" align="center"><img src="2_files/del2.GIF" style="CURSOR: hand"  width="17" height="16" onClick= "dl_close()" ></td>
           </tr>
         </table>
       </div>
    <div class=winContent align="center">
           
      <form ACTION=<%=MM_LoginAction%> method="POST"  name="form1" >
<TABLE cellSpacing=0 cellPadding=0 width="90%" border=0>
        <TR>
          <TD align=middle height=35>用户名：
            <INPUT class=input_txt size=14 name=loginname></TD>
        </TR>
        <TR>
          <TD align=middle height=35>密　码：
            <INPUT class=input_txt type=password size=14 name=loginpassword></TD>
        </TR>
        <TR>
          <TD align=middle height=35><INPUT class=input_btn type=submit value="登 录"  onclick="this.form.submit();dl_close()">
            &nbsp;
            <INPUT class=input_btn type=reset value="重 置">
          </TD>
        </TR>
      </TABLE>
      </form>

</div>