<?php require_once('../function/GetSQLValueString.php');
 require_once('../db/MyDB.php');
 
if ((isset($_GET['KindID'])) && ($_GET['KindID'] != "")) { 
$kindid=$_GET['KindID'];
$database = new MyDB();
$query_Recordset1 = "SELECT * FROM newskind WHERE KindID=$kindid ";
$Recordset1 =  $database->query($query_Recordset1);
$row_Recordset1 = $Recordset1->fetchArray(SQLITE3_ASSOC);

if ($row_Recordset1['ParentID']===0){



  $deleteSQL = sprintf("DELETE FROM newskind WHERE KindID=%s or ParentID=%s",
                       GetSQLValueString($_GET['KindID'], "int"), GetSQLValueString($_GET['KindID'], "int"));

//$database = new MyDB();
  $ret = $database->exec($deleteSQL);
  
  
  
}
else
{
	
	
  $deleteSQL = sprintf("DELETE FROM newskind WHERE KindID=%s",
                       GetSQLValueString($_GET['KindID'], "int"));

   $ret = $database->exec($deleteSQL);
	
	}
	
	unset($Recordset1);
	$database->close();
  $deleteGoTo = "KindList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}


?>
