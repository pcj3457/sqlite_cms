<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_mysql = "localhost:3306";
$database_mysql = "letfit";
$username_mysql = "root";
$password_mysql = "huairou@123";
$mysql = mysql_pconnect($hostname_mysql, $username_mysql, $password_mysql) or trigger_error(mysql_error(),E_USER_ERROR); 
?>