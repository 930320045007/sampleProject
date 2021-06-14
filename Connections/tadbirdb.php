<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_tadbirdb = "localhost";
$database_tadbirdb = "tadbir";
$username_tadbirdb = "root";
$password_tadbirdb = "";
$tadbirdb = mysql_pconnect($hostname_tadbirdb, $username_tadbirdb, $password_tadbirdb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
