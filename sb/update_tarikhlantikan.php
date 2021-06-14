<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$GoTo = $url_main . "admin/edit.php?id=" . getUserIDByStafID(htmlspecialchars($_POST['id'], ENT_QUOTES));

if ((isset($_POST["MM_update_tarikhlantikan"])) && ($_POST["MM_update_tarikhlantikan"] == "updateLantikan"))
{
	if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2))
	{
	  $updateSQL = sprintf("UPDATE www.user_job SET userjob_start_d=%s, userjob_start_m=%s, userjob_start_y=%s, userjob_kontrak_start_d=%s, userjob_kontrak_start_m=%s, userjob_kontrak_start_y=%s, userjob_kontrak_end_d=%s, userjob_kontrak_end_m=%s, userjob_kontrak_end_y=%s, userjob_promoted_d=%s, userjob_promoted_m=%s, userjob_promoted_y=%s, userjob_in_d=%s, userjob_in_m=%s, userjob_in_y=%s, userjob_tpg_m=%s, userjob_tpg_note=%s WHERE user_stafid=%s",
							 GetSQLValueString($_POST['userjob_start_d'], "text"),
							 GetSQLValueString($_POST['userjob_start_m'], "text"),
							 GetSQLValueString($_POST['userjob_start_y'], "text"),
							 GetSQLValueString($_POST['userjob_kontrak_start_d'], "text"),
							 GetSQLValueString($_POST['userjob_kontrak_start_m'], "text"),
							 GetSQLValueString($_POST['userjob_kontrak_start_y'], "text"),
							 GetSQLValueString($_POST['userjob_kontrak_end_d'], "text"),
							 GetSQLValueString($_POST['userjob_kontrak_end_m'], "text"),
							 GetSQLValueString($_POST['userjob_kontrak_end_y'], "text"),
							 GetSQLValueString($_POST['userjob_promoted_d'], "text"),
							 GetSQLValueString($_POST['userjob_promoted_m'], "text"),
							 GetSQLValueString($_POST['userjob_promoted_y'], "text"),
							 GetSQLValueString($_POST['userjob_in_d'], "text"),
							 GetSQLValueString($_POST['userjob_in_m'], "text"),
							 GetSQLValueString($_POST['userjob_in_y'], "text"),
							 GetSQLValueString($_POST['userjob_tpg_m'], "text"),
							 GetSQLValueString($_POST['userjob_tpg_note'], "text"),
							 GetSQLValueString(htmlspecialchars($_POST['id'], ENT_QUOTES), "text"));
							 
	   mysql_select_db($database_hrmsdb, $hrmsdb);
	   $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
	   
	   $GoTo .= "&msg=edit";
		
	} else {
		$GoTo .= "&eul=1";
	};
	
} else {
	$GoTo .= "&msg=error";
};

header(sprintf("Location: %s", $GoTo));
?>
