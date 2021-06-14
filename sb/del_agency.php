<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$insertGoTo = $url_main . "tadbir/agency.php";
if(checkUserSysAcc($row_user['user_stafid'], 10, 86, 4)){
	if ((isset($_GET['id'])) && ($_GET['id'] != NULL)) {
	   $insertSQL = "UPDATE tadbir.transport_agency SET transagency_status = 0 WHERE transagency_id='" . $_GET['id'] . "'";
	  mysql_select_db($database_tadbirdb, $tadbirdb);
	  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
	
	  $insertGoTo .= "?msg=del";
	} else {
		$insertGoTo .= "?msg=error";
	}
} else {
	$insertGoTo .= "?eul=1";
}

header(sprintf("Location: %s", $insertGoTo));
?>