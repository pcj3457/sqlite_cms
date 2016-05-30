<?php 
 require_once('function/GetSQLValueString.php');
 require_once('db/MyDB.php');
$database = new MyDB();



//newsid
if(isset($_GET['NewsID']))
{

$query_news = sprintf("SELECT news.*,newskind.KindTitle FROM news left join newskind on news.KindID=newskind.KindID  WHERE news.NewsID=%s",GetSQLValueString($_GET['NewsID'], "int"));



$Recordset =  $database->query($query_news);
$row_news = $Recordset->fetchArray(SQLITE3_ASSOC);
}

//返回值 根据newsid limit 
function getNewsByNewsid($kindid,$limitStart,$limitEnd) {
   $db = new MyDB();
   if (($limitStart=="")&&($limitEnd==""))
   { $stmt = $db->prepare("SELECT news.*,newskind.KindTitle,newskind.ParentID FROM news left join newskind  on news.KindID=newskind.KindID  WHERE news.KindID=:kindid  ORDER BY news.xuhao ASC ");
   $stmt->bindValue(":kindid", $kindid, SQLITE3_INTEGER);
	   }
	   else
	   {
    $stmt = $db->prepare("SELECT news.*,newskind.KindTitle,newskind.ParentID FROM news left join newskind  on news.KindID=newskind.KindID  WHERE news.KindID=:kindid  ORDER BY news.xuhao DESC limit :limitStart,:limitEnd");
    $stmt->bindValue(":kindid", $kindid, SQLITE3_INTEGER);
	$stmt->bindValue(":limitStart", $limitStart, SQLITE3_INTEGER);
     $stmt->bindValue(":limitEnd", $limitEnd, SQLITE3_INTEGER);
	   }
	 $result = $stmt->execute();
    if ($result === false) {
        return null;
    }   

    $array = array();
    while($data = $result->fetchArray(SQLITE3_ASSOC))
    {
         $array[] = $data;
    }
$db->close();
    return $array;
}

$database->close();
?>