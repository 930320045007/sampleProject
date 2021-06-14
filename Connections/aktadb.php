<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_aktadb = "localhost";
$database_aktadb = "akta";
$username_aktadb = "";
$password_aktadb = "";
$aktadb = mysql_pconnect($hostname_aktadb, $username_aktadb, $password_aktadb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
