<?php

include 'ChinesePinyin.class.php';
 
if (isset($_POST["textfield"])&&($_POST["textfield"]!==""))
{
$Pinyin = new ChinesePinyin();

$words = $_POST["textfield"];
echo '<h2>'.$words.'</h2>';



echo '<p>转成带有声调的汉语拼音<br/>';
$result = $Pinyin->TransformWithTone($words);
echo $result,'</p>';



echo '<p>转成带无声调的汉语拼音<br/>';
$result = $Pinyin->TransformWithoutTone($words,' ');
echo($result),'</p>';



echo '<p>转成汉语拼音首字母<br/>';
$result = $Pinyin->TransformUcwords($words);
echo($result),'</p>';
}
else
{ $words="无post";
	
	echo '<h2>'.$words.'</h2>';}
?>

<form id="form1" name="form1" method="post" action="demo.php">
  <label for="textfield"></label>
  <input type="text" name="textfield" id="textfield" />
  <input type="submit" name="button" id="button" value="提交" />
</form>
