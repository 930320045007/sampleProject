<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ekad = "localhost";
$database_ekad = "ekad";
$username_ekad = "root";
$password_ekad = "1m@s2ol4";
$ekad = mysql_pconnect($hostname_ekad, $username_ekad, $password_ekad) or trigger_error(mysql_error(),E_USER_ERROR); 
?>