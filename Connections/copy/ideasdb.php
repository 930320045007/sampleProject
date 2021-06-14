<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ideasdb = "localhost";
$database_ideasdb = "ideas";
$username_ideasdb = "root";
$password_ideasdb = "1m@s2ol4";
$ideasdb = mysql_pconnect($hostname_ideasdb, $username_ideasdb, $password_ideasdb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>