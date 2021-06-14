<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_financedb = "localhost";
$database_financedb = "finance";
$username_financedb = "root";
$password_financedb = "";
$financedb = mysql_pconnect($hostname_financedb, $username_financedb, $password_financedb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>