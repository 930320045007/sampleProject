<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_selidikdb = "localhost";
$database_selidikdb = "selidik";
$username_selidikdb = "root";
$password_selidikdb = "1m@s2ol4";
$selidikdb = mysql_pconnect($hostname_selidikdb, $username_selidikdb, $password_selidikdb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>