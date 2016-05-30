<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifier
 */
 
/**
 * Smarty truncate modifier plugin
 * 
 * Type:     modifier<br>
 * Name:     truncate<br>
 * Purpose:  Truncate a string to a certain length if necessary,
 *               optionally splitting in the middle of a word, and
 *               appending the $etc string or inserting $etc into the middle.
 * 
 * @link http://smarty.php.net/manual/en/language.modifier.truncate.php truncate (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com> 
 * @param string  $string      input string
 * @param integer $length      length of truncated text
 * @param string  $etc         end string
 * @param boolean $break_words truncate at word boundary
 * @param boolean $middle      truncate in the middle of text
 * @return string truncated string
 */
function smarty_modifier_truncate_cn($string, $length = 80, $etc = '¡­')

{
	$string = strip_tags($string);
  $string = preg_replace ('/\n/is', '', $string);
  $string = preg_replace ('/ |¡¡/is', '', $string);
  $string = preg_replace ('/&nbsp;/is', '', $string);
  
if($length>=strlen($string))    
  {    
  return $string;    
  }    
  $s="";    
  for($i=0;$i<$length;$i++)    
  {    
  if(ord($string{$i})>127)    
  {    
  $s.=$string{$i}.$string{++$i};    
  continue;    
  }else{    
  $s.=$string{$i};    
  continue;    
  }    
  }    
  return $s.$etc;

   

}


?>