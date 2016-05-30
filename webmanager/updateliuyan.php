<?php require_once('../function/GetSQLValueString.php');
 require_once('../db/MyDB.php');
 $database = new MyDB();
 
 $del=sprintf("update message set recontent =%s ,redate=%s where messageid=%s",
  GetSQLValueString($_POST['recontent'],"text"),
 GetSQLValueString($_POST['redate'],"int"),
 GetSQLValueString($_POST['messageid'],"int"));
  $ret = $database->exec($del);
$database->close();

  if (isset( $_SERVER['HTTP_REFERER'])) {
	  $deleteGoTo= $_SERVER['HTTP_REFERER'];
  
  }
  else
  {
	   $deleteGoTo="editmessage.php";
	   }
  
  header(sprintf("Location: %s", $deleteGoTo));
  
  
  ?>