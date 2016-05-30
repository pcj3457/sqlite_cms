<?php 
session_unset();
session_destroy();
$MM_restrictGoTo="index.php";
 header("Location: ". $MM_restrictGoTo); 


?>