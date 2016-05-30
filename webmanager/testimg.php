

<?php require("../function/resizimg.php");

$src=$_SERVER['DOCUMENT_ROOT']."/attachment/image/1433036676761705.jpg";

	$file_extension=pathinfo($src, PATHINFO_EXTENSION); //取得文件后缀名


$dst="/attachment/image/".time().".".$file_extension;
$width=300;
$height=210;

 
echo (image_resize($src,$dst , $width, $height, $crop=0));



 ?>

