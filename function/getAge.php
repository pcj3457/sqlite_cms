<?php function getAge($birthday) { 
$age = 0; 
$year = $month = $day = 0; 
if (is_array($birthday)) { 
extract($birthday); 
} else { 
if (strpos($birthday, '-') !== false) { 
list($year, $month, $day) = explode('-', $birthday); 
$day = substr($day, 0, 2); //get the first two chars in case of '2000-11-03 12:12:00'
} 
} 
$age = date('Y') - $year; 
if (date('m') < $month || (date('m') == $month && date('d') < $day)) $age--; 
return $age; 
} ?>