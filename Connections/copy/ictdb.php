<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ictdb = "localhost";
$database_ictdb = "ict";
$username_ictdb = "root";
$password_ictdb = "1m@s2ol4";
$ictdb = mysql_pconnect($hostname_ictdb, $username_ictdb, $password_ictdb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>