<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$updateGoTo = $url_main . "tadbir/transportlist.php";

if(isset($_GET['id']) && checkUserSysAcc($row_user['user_stafid'], 10, 81, 4)){
  $updateSQL = sprintf("UPDATE transport SET transport_status='0' WHERE transport_id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_tadbirdb, $tadbirdb);
  $Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
  
  $updateGoTo .= "?msg=del&tyid=" . $_GET['tyid'];
} else {
  $updateGoTo .= "?del=1&tyid=" . $_GET['tyid'];
}

header(sprintf("Location: %s", $updateGoTo));
?>