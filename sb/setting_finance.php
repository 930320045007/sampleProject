<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php

$insertGoTo = $url_main . "fin/setting.php";
if(checkUserSysAcc($row_user['user_stafid'], 16, 90, 2)){
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "bil_submit")) {
  $insertSQL = sprintf("INSERT INTO bil (bil_by, bil_date, bil_no, bil_date_d, bil_date_m, bil_date_y) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['bil_no'], "int"),
					   GetSQLValueString($_POST['bil_date_d'], "text"),
					   GetSQLValueString($_POST['bil_date_m'], "text"),
					   GetSQLValueString($_POST['bil_date_y'], "text"));

  mysql_select_db($database_financedb, $financedb);
  $Result1 = mysql_query($insertSQL, $financedb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['bid'])) && ($_GET['bid'] != NULL)) {
  $insertSQL = "UPDATE finance.bil SET bil_status = '0' WHERE bil_id='" . htmlspecialchars($_GET['bid'], ENT_QUOTES) . "'";
  mysql_select_db($database_financedb, $financedb);
  $Result1 = mysql_query($insertSQL, $financedb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}
}
header(sprintf("Location: %s", $insertGoTo));
?>