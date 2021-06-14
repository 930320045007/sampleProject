<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_hrmsdb = "localhost";
$database_hrmsdb = "www";
$username_hrmsdb = "isn";
$password_hrmsdb = "*aD1213141516#";
$hrmsdb = mysql_pconnect($hostname_hrmsdb, $username_hrmsdb, $password_hrmsdb) or trigger_error(mysql_error(),E_USER_ERROR); 


$hostname_sysdb = "localhost";
$database_sysdb = "sysaudit";
$username_sysdb = "root";
$password_sysdb = "1m@s2ol4";
$sysdb = mysql_pconnect($hostname_sysdb, $username_sysdb, $password_sysdb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . htmlspecialchars($theValue, ENT_QUOTES) . "'" : "NULL";
      break;  
    case "login":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;   
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . htmlspecialchars($theValue, ENT_QUOTES) . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? htmlspecialchars($theDefinedValue, ENT_QUOTES) : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php 
$url_main = 'http://imas.isn.gov.my/v1/';
$adname = 'Cawangan Sumber Manusia';
date_default_timezone_set('Asia/Kuala_Lumpur');
$systitle_short = 'SPSM';
$systitle_full = 'Sistem Pengurusan Sumber Manusia';
$sendemailfunc = true; // true : utk kebenaran menghantar email; false : utk tidakmembenarkan penghantaran email
$ext = '6038992';
$leaveform = false;
$maintenance = false; // true : untuk proses pengemaskinian atau DRP; false : utk memberi akses kepada kakitangan

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
?>