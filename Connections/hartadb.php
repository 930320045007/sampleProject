<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_hartadb = "localhost";
$database_hartadb = "harta";
$username_hartadb = "root";
$password_hartadb = "";
$hartadb = mysql_pconnect($hostname_hartadb, $username_hartadb, $password_hartadb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
