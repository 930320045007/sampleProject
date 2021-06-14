<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php

$insertGoTo = $url_main . "admin/adminclinic.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if(checkUserSysAcc($row_user['user_stafid'], 10, 53, 2)){
		  $insertSQL = sprintf("INSERT INTO clinic (clinic_date, clinic_by, clinic_name, clinic_address, state_id, clinic_notel1, clinic_notel2, clinic_nofax, clinictype_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString($_POST['clinic_name'], "text"),
							   GetSQLValueString($_POST['clinic_address'], "text"),
							   GetSQLValueString($_POST['state_id'], "int"),
							   GetSQLValueString($_POST['clinic_notel1'], "text"),
							   GetSQLValueString($_POST['clinic_notel2'], "text"),
							   GetSQLValueString($_POST['clinic_nofax'], "text"),
							   GetSQLValueString($_POST['clinictype_id'], "int"));
		
		  mysql_select_db($database_tadbirdb, $tadbirdb);
		  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
		
		  $insertGoTo .= "?msg=add";
	} else {
		$insertGoTo .= "?eul=1";
	};
}

header(sprintf("Location: %s", $insertGoTo));
?>