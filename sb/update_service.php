<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php

$updateGoTo = $url_main . "ict/servicelist.php";

if(checkUserSysAcc($row_user['user_stafid'], 6, 31, 3))
{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
	{
	  $updateSQL = sprintf("UPDATE service SET service_date_d=%s, service_date_m=%s, service_date_y=%s, servicetype_id=%s, service_title=%s, service_duration_m=%s, service_duration_y=%s, service_start_date_d=%s, service_start_date_m=%s, service_start_date_y=%s, service_end_date_d=%s, service_end_date_m=%s, service_end_date_y=%s, service_lono=%s, service_amount=%s, service_refno=%s, vendor_id=%s, service_note=%s, service_username=%s, service_password=%s WHERE service_id=%s",
	  					   GetSQLValueString(date('d'), "text"),
						   GetSQLValueString(date('m'), "text"),
						   GetSQLValueString(date('Y'), "text"),
						   GetSQLValueString($_POST['servicetype_id'], "int"),
						   GetSQLValueString($_POST['service_title'], "text"),
						   GetSQLValueString($_POST['service_duration_m'], "text"),
						   GetSQLValueString($_POST['service_duration_y'], "text"),
						   GetSQLValueString($_POST['service_start_date_d'], "text"),
						   GetSQLValueString($_POST['service_start_date_m'], "text"),
						   GetSQLValueString($_POST['service_start_date_y'], "text"),
						   GetSQLValueString($_POST['service_end_date_d'], "text"),
						   GetSQLValueString($_POST['service_end_date_m'], "text"),
						   GetSQLValueString($_POST['service_end_date_y'], "text"),
						   GetSQLValueString($_POST['service_lono'], "text"),
						   GetSQLValueString($_POST['service_amount'], "text"),
						   GetSQLValueString($_POST['service_refno'], "text"),
						   GetSQLValueString($_POST['vendor_id'], "int"),
						   GetSQLValueString($_POST['service_note'], "text"),
						   GetSQLValueString($_POST['service_username'], "text"),
						   GetSQLValueString($_POST['service_password'], "text"),
						   GetSQLValueString($_POST['service_id'], "int"));
	
	  mysql_select_db($database_ictdb, $ictdb);
	  $Result1 = mysql_query($updateSQL, $ictdb) or die(mysql_error());
	  
	  $updateGoTo .= "?msg=edit&id=" . getID(htmlspecialchars($_POST['service_id'],ENT_QUOTES));
	  
	} else {
		$updateGoTo .= "?msg=error";
	};
	
} else {
	$updateGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>