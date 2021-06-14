<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$updateGoTo = $url_main . "tadbir/adminclinic.php";
  
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
{
	if(checkUserSysAcc($row_user['user_stafid'], 10, 53, 3))
	{
		  $updateSQL = sprintf("UPDATE clinic SET clinic_date=%s, clinic_by=%s, clinic_name=%s, clinic_address=%s, state_id=%s, clinic_notel1=%s, clinic_notel2=%s, clinic_nofax=%s, clinictype_id=%s WHERE clinic_id=%s",
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString($_POST['clinic_name'], "text"),
							   GetSQLValueString($_POST['clinic_address'], "text"),
							   GetSQLValueString($_POST['state_id'], "int"),
							   GetSQLValueString($_POST['clinic_notel1'], "text"),
							   GetSQLValueString($_POST['clinic_notel2'], "text"),
							   GetSQLValueString($_POST['clinic_nofax'], "text"),
							   GetSQLValueString($_POST['clinictype_id'], "int"),
							   GetSQLValueString($_POST['clinic_id'], "int"));
		
		  mysql_select_db($database_tadbirdb, $tadbirdb);
		  $Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
		
		  $updateGoTo .= "?msg=edit";
	} else {
		$updateGoTo .= "?eul=1";
	};
	
} else {
	$updateGoTo .= "?msg=error";
};
 
header(sprintf("Location: %s", $updateGoTo));
 ?>