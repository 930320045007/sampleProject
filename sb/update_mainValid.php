<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php include('../sb/email.php');?>
<?php

$updateGoTo = $url_main . "tadbir/adminmaintenancedetail.php?id=" . htmlspecialchars($_POST['maintenance_id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 10, 86, 3))
{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
	{
		  $updateSQL = sprintf("UPDATE maintenance SET maintenance_validby=%s, maintenance_validdate=%s, maintenance_validnote=%s, maintenance_validstatus=%s WHERE maintenance_id=%s",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($_POST['maintenance_validnote'], "text"),
							   GetSQLValueString($_POST['maintenance_validstatus'], "int"),
							   GetSQLValueString($_POST['maintenance_id'], "int"));
		
		  mysql_select_db($database_tadbirdb, $tadbirdb);
		  $Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
		  
		  $updateGoTo .= "&msg=edit";
		  
		  $emailto = array();
		  $emailto[] = getMaintenanceBy(htmlspecialchars($_POST['maintenance_id'], ENT_QUOTES));
		  $emailto = array_merge($emailto,getUserIDSysAcc(10, 80));
		  emailValidMaintenance($emailto, 0, 0, 1, $_POST['maintenance_id']);
	  
	} else {
		$updateGoTo .= "&msg=error";
	};
	
} else {
	$updateGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>