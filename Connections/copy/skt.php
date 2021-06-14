<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_skt = "localhost";
$database_skt = "skt";
$username_skt = "root";
$password_skt = "1m@s2ol4";
$skt = mysql_pconnect($hostname_skt, $username_skt, $password_skt) or trigger_error(mysql_error(),E_USER_ERROR); 
?>