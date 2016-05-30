<?php require_once('../function/GetSQLValueString.php');
 require_once('../db/MyDB.php');



$database = new MyDB();
$query_bigkind = "SELECT * FROM newskind WHERE ParentID = 0 ORDER BY KindID ASC";
/*$bigkind = mysql_query($query_bigkind, $mysql) or die(mysql_error());
$row_bigkind = mysql_fetch_assoc($bigkind);
$totalRows_bigkind = mysql_num_rows($bigkind);*/
$bigkind = $database->query($query_bigkind);
$row_bigkind =$bigkind->fetchArray(SQLITE3_ASSOC);
 $totalRows_bigkind = $bigkind->numColumns();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>类型</title>
<link href="../css/default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
$m=1;
 do { ?><table width="95%" border="1" align="center">
  
    <tr>
      <td bgcolor="#66FFFF" width="10%"><?php echo $m; ?></td>
      <td bgcolor="#66FFFF" width="50%"><?php echo $row_bigkind['KindTitle']; ?>--[<?php if($row_bigkind['KindType']==2)
	  {echo "单独页面";}
	  if($row_bigkind['KindType']==0)
	  {echo "文字列表";}
	   if($row_bigkind['KindType']==1)
	  {echo "图片列表";};  ?>]</td>
      <td align="center" valign="middle" bgcolor="#66FFFF" width="20%"><a href="AddType.php?ParentID=<?php echo $row_bigkind['ParentID']; ?>">|添加</a><a href="AddType.php?KindID=<?php echo $row_bigkind['KindID']; ?>">|编辑|</a><a href="DelKind.php?KindID=<?php echo $row_bigkind['KindID']; ?>" onclick="return confirm('您真的要删除此行吗？')" >删除</a></td>
      <td align="center" valign="middle" bgcolor="#66FFFF" width="20%"><?php echo $row_bigkind['KindID']; ?></td>
    </tr>
   </table>
   
   
   <?php
   $parentid=$row_bigkind['KindID'];
   $database = new MyDB();
$query_Recordset1 = "SELECT * FROM newskind WHERE ParentID =$parentid ORDER BY KindID DESC";
$Recordset1 =$database->query($query_Recordset1);
$row_Recordset1 =$Recordset1->fetchArray(SQLITE3_ASSOC);
   ?>
   

 <?php $n=1;
 do { ?><table width="95%" border="1" align="center" > <tr>
    
      <td align="center" width="5%"><?php echo $n; ?></td>
      <td width="45%"><?php echo $row_Recordset1['KindTitle']; ?>--【<?php if($row_Recordset1['KindType']==2)
	  {echo "单独页面";}
	  if($row_Recordset1['KindType']==0)
	  {echo "文字列表";}
	   if($row_Recordset1['KindType']==1)
	  {echo "图片列表";};  ?>】</td>
      <td align="center" width="25%"><a href="AddType.php?ParentID=<?php echo $row_bigkind['KindID']; ?>">|添加</a><a href="AddType.php?KindID=<?php echo $row_Recordset1['KindID']; ?>">|编辑</a>| <a href="DelKind.php?KindID=<?php echo $row_Recordset1['KindID']; ?>" onclick="return confirm('您真的要删除此行吗？')" >删除</a></td>
      <td align="center" width="25%"><?php echo $row_Recordset1['KindID']; ?></td>
      
  </tr>
 </table>
  <?php 
  $n++;
  } while ($row_Recordset1 =$Recordset1->fetchArray(SQLITE3_ASSOC)); ?>
 

   
   
    <?php 
	$m++;
	} while ($row_bigkind =$bigkind->fetchArray(SQLITE3_ASSOC)); ?>


</body>
</html>
<?php
unset($Recordset1);

unset($bigkind);
$database->close();
?>
