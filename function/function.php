<?php //按照字节数 截取字符串
 function cnSubStr($string,$sublen)    
  {    
  if($sublen>=mb_strlen($string, "utf-8"))    
  {    
  return $string;    
  }    
  else
  {	  $s=mb_substr($string,0,$sublen,"utf-8");    
  return $s."…";    }
  }
  
//PHP清除html、css、js格式并去除空格的PHP函数
  function cutstr_html($string, $sublen)    
 {
  $string = strip_tags($string);
  $string = preg_replace ('/\n/is', '', $string);
  $string = preg_replace ('/ |　/is', '', $string);
  $string = preg_replace ('/&nbsp;/is', '', $string);
  
  preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $t_string);   
 /* if(count($t_string[0]) - 0 > $sublen) $string = join('', array_slice($t_string[0], 0, $sublen))."…";   
  else $string = join('', array_slice($t_string[0], 0, $sublen));*/
  $string=cnSubStr($string,$sublen);
  return $string;
 }

?>