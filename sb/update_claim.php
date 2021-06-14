<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$updateGoTo = $url_main . "tadbir/adminclaim.php?id=" . htmlspecialchars($_POST['user_stafid'], ENT_QUOTES); 

if(checkUserSysAcc($row_user['user_stafid'], 10, 70, 3))
{
	if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "cl")) 
	{
		  $updateSQL = sprintf("UPDATE tadbir.claim SET claim_on_d=%s, claim_on_m=%s, claim_on_y=%s, user_stafid=%s, claim_date_d=%s, claim_date_m=%s, claim_date_y=%s, claim_by=%s,  claim_in_h=%s, claim_in_m=%s, claim_in_ap=%s, claim_out_h=%s, claim_out_m=%s, claim_out_ap=%s, claim_from_h=%s, claim_from_m=%s, claim_from_ap=%s, claim_till_h=%s, claim_till_m=%s, claim_till_ap=%s, claim_total_h=%s, claim_total_m=%s, claim_note=%s, claim_siang_h=%s, claim_siang_m=%s, claim_malamsiang_h=%s, claim_malamsiang_m=%s, claim_malamahad_h=%s, claim_malamahad_m=%s, claim_amsiang_h=%s, claim_amsiang_m=%s, claim_ammalam_h=%s, claim_ammalam_m=%s WHERE claim_id=%s",
							   GetSQLValueString($_POST['claim_on_d'], "text"),
							   GetSQLValueString($_POST['claim_on_m'], "text"),
							   GetSQLValueString($_POST['claim_on_y'], "text"),
							   GetSQLValueString($_POST['user_stafid'], "text"),
							   GetSQLValueString(date('d'), "text"),
							   GetSQLValueString(date('m'), "text"),
							   GetSQLValueString(date('Y'), "text"),
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString($_POST['claim_in_h'], "text"),
							   GetSQLValueString($_POST['claim_in_m'], "text"),
							   GetSQLValueString($_POST['claim_in_ap'], "text"),
							   GetSQLValueString($_POST['claim_out_h'], "text"),
							   GetSQLValueString($_POST['claim_out_m'], "text"),
							   GetSQLValueString($_POST['claim_out_ap'], "text"),
							   GetSQLValueString($_POST['claim_from_h'], "text"),
							   GetSQLValueString($_POST['claim_from_m'], "text"),
							   GetSQLValueString($_POST['claim_from_ap'], "text"),
							   GetSQLValueString($_POST['claim_till_h'], "text"),
							   GetSQLValueString($_POST['claim_till_m'], "text"),
							   GetSQLValueString($_POST['claim_till_ap'], "text"),
							   GetSQLValueString($_POST['claim_total_h'], "text"),
							   GetSQLValueString($_POST['claim_total_m'], "text"),
							   GetSQLValueString($_POST['claim_note'], "text"),
							   GetSQLValueString($_POST['claim_siang_h'], "text"),
							   GetSQLValueString($_POST['claim_siang_m'], "text"),
							   GetSQLValueString($_POST['claim_malamsiang_h'], "text"),
							   GetSQLValueString($_POST['claim_malamsiang_m'], "text"),
							   GetSQLValueString($_POST['claim_malamahad_h'], "text"),
							   GetSQLValueString($_POST['claim_malamahad_m'], "text"),
							   GetSQLValueString($_POST['claim_amsiang_h'], "text"),
							   GetSQLValueString($_POST['claim_amsiang_m'], "text"),
							   GetSQLValueString($_POST['claim_ammalam_h'], "text"),
							   GetSQLValueString($_POST['claim_ammalam_m'], "text"),
							   GetSQLValueString($_POST['claim_id'], "int"));
		
		mysql_select_db($database_tadbirdb, $tadbirdb);
		$Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
			
		$updateGoTo .= "&msg=add";
	} else {
		$updateGoTo .= "&msg=error";
	};
	
} else {
	$updateGoTo .= "&msg=error";
};
	
header(sprintf("Location: %s", $updateGoTo));
?>