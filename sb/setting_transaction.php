<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$insertGoTo = $url_main . "admin/transaction.php";

if ((isset($_GET['tid'])) && ($_GET['tid'] != NULL)) {
  $insertSQL = "UPDATE www.transaction SET transaction_status = '0' WHERE transaction_id='" . $_GET['tid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_GET['cid'])) && ($_GET['cid'] != NULL)) {
  $insertSQL = "UPDATE www.club SET club_status = '0' WHERE club_id='" . $_GET['cid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_GET['kid'])) && ($_GET['kid'] != NULL)) {
  $insertSQL = "UPDATE www.kwsp SET kwsp_status = '0' WHERE kwsp_id='" . $_GET['kid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_GET['pid'])) && ($_GET['pid'] != NULL)) {
  $insertSQL = "UPDATE www.perkeso SET perkeso_status = '0' WHERE perkeso_id='" . $_GET['pid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}
header(sprintf("Location: %s", $insertGoTo));
?>
