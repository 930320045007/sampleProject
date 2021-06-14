<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_mbjdb = "localhost";
$database_mbjdb = "mbj";
$username_mbjdb = "root";
$password_mbjdb = "";
$mbjdb = mysql_pconnect($hostname_mbjdb, $username_mbjdb, $password_mbjdb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>