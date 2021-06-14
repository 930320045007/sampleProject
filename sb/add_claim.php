<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php

$insertGoTo = $url_main . "tadbir/adminclaim.php?id=" . htmlspecialchars($_POST['user_stafid'], ENT_QUOTES);
if(checkUserSysAcc($row_user['user_stafid'], 10, 70, 2))
{
//	if(!checkDateOT($_POST['user_stafid'], $_POST['claim_on_d'], $_POST['claim_on_m'], $_POST['claim_on_y']))
//	{
		if($_POST['user_stafid']!=$row_user['user_stafid'])
		{
			if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cli")) 
			{
				$insertSQL = sprintf("INSERT INTO tadbir.claim (claim_on_d, claim_on_m, claim_on_y, user_stafid, claim_date_d, claim_date_m, claim_date_y, claim_by,  claim_in_h, claim_in_m, claim_in_ap, claim_out_h, claim_out_m, claim_out_ap, claim_from_h, claim_from_m, claim_from_ap, claim_till_h, claim_till_m, claim_till_ap, claim_total_h, claim_total_m, claim_note, claim_siang_h, claim_siang_m, claim_malamsiang_h, claim_malamsiang_m, claim_malamahad_h, claim_malamahad_m, claim_amsiang_h, claim_amsiang_m, claim_ammalam_h, claim_ammalam_m ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
								   GetSQLValueString($_POST['claim_ammalam_m'], "text"));
			
			  mysql_select_db($database_tadbirdb, $tadbirdb);
			  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
				
			
			  $insertGoTo .= "&msg=add";
			  
			} else {
				$insertGoTo .= "&msg=error";
			};
			
		} else {
			$insertGoTo .= "&eot=2"; // tidak boleh uruskan OT sendiri
		};
	
//	} else {
//		$insertGoTo .= "&eot=1"; // pertindihan tarikh OT
//	};

}else{
	 $insertGoTo .= "&eul=1";
};
	
header(sprintf("Location: %s", $insertGoTo));
?>