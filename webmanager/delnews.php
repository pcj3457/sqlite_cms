<?php require_once('../function/GetSQLValueString.php');
 require_once('../db/MyDB.php');
$database = new MyDB();


if ((isset($_GET['NewsID'])) && ($_GET['NewsID'] != "")) {
  $deleteSQL = sprintf("DELETE FROM news WHERE NewsID=%s",
                       GetSQLValueString($_GET['NewsID'], "int"));

 $ret = $database->exec($deleteSQL);
$database->close();
//$deleteGoTo = "../indextohtml.php";
  /* require('../setup.php');
$smarty = new Smarty_cj;
$newscacheid="newsid:{$_GET['NewsID']}";
$kindcacheid="kindid:{$_GET['KindID']}";
$smarty->clearCache('index.tpl');
$smarty->clearCache('endpage.tpl',$newscacheid);
$smarty->clearCache("list.tpl",$kindcacheid);
*/
$deleteGoTo = "newslist.php";
/* $filename='../news/'.$_GET['NewsID'].'.html';
if (file_exists($filename))
{ @unlink($filename);
	}*/
  header(sprintf("Location: %s", $deleteGoTo));
}


?>
