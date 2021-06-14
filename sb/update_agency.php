<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
  $updateGoTo = $url_main . "tadbir/agency.php";
  
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	if(checkUserSysAcc($row_user['user_stafid'], 10, 86, 3)){
		  $updateSQL = sprintf("UPDATE transport_agency SET transagency_date=%s, transagency_by=%s, transagency_name=%s, transagency_address=%s, transagency_notel=%s, transagency_nofax=%s, transagency_email=%s WHERE transagency_id=%s",
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString($_POST['transagency_name'], "text"),
							   GetSQLValueString($_POST['transagency_address'], "text"),
							   GetSQLValueString($_POST['transagency_notel'], "text"),
							   GetSQLValueString($_POST['transagency_nofax'], "text"),
							   GetSQLValueString($_POST['transagency_email'], "text"),
							   GetSQLValueString($_POST['transagency_id'], "int"));
		
		  mysql_select_db($database_tadbirdb, $tadbirdb);
		  $Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
		
		  $updateGoTo .= "?msg=edit";
	} else {
		$updateGoTo .= "?eul=1";
	};
}
  header(sprintf("Location: %s", $updateGoTo));
 ?>