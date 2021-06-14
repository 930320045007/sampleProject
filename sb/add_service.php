<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$insertGoTo = $url_main . "ict/servicelist.php";

if(checkUserSysAcc($row_user['user_stafid'], 6, 31, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
	{
	  $insertSQL = sprintf("INSERT INTO ict.service (service_by, service_date_d, service_date_m, service_date_y,  servicetype_id, service_title, service_duration_m, service_duration_y,service_start_date_d, service_start_date_m, service_start_date_y, service_end_date_d, service_end_date_m, service_end_date_y, service_lono, service_amount, service_refno, vendor_id, service_note, service_username, service_password) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d'), "text"),
						   GetSQLValueString(date('m'), "text"),
						   GetSQLValueString(date('Y'), "text"),
						   GetSQLValueString($_POST['type'], "int"),
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
						   GetSQLValueString($_POST['vendor'], "int"),
						   GetSQLValueString($_POST['service_note'], "text"),
						   GetSQLValueString($_POST['service_username'], "text"),
						   GetSQLValueString($_POST['service_password'], "text"));
	
	  mysql_select_db($database_ictdb, $ictdb);
	  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
	  
	  $insertGoTo .= "?msg=add";
	  
	} else {
		$insertGoTo .= "?msg=error";
	};

} else {
	$insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>