<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$updateGoTo = $url_main . "head/am5babG.php";

if(isset($_GET['id'])){
  $updateSQL = sprintf("UPDATE leave_office SET leaveoffice_status='0' WHERE leaveoffice_id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
  
  $updateGoTo .= "?msg=del";
}

header(sprintf("Location: %s", $updateGoTo));
?>