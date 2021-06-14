<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php

$updateGoTo = $url_main . "skt/sktdetail.php?id=" . getID(htmlspecialchars($_POST['uskt_id'], ENT_QUOTES));

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
{
	if(getSKTStafID($_POST['uskt_id']) == $row_user['user_stafid'])
	{
		if(getSKTTahun($_POST['uskt_id'])==date('Y') && !checkFeedbackCancel($_POST['uskt_id']) && !checkFeedbackLatest(0, $row_uskt['uskt_id'], 0))
		{
		  $updateSQL = sprintf("UPDATE skt.user_skt SET uskt_aktiviti=%s, uskt_kuantiti=%s, uskt_kuantiti_sk=%s, uskt_masa=%s, uskt_masa_sk=%s, uskt_masa_mula=%s, uskt_masa_tamat=%s, uskt_kualiti=%s, uskt_kualiti_sk=%s, uskt_kos=%s, uskt_kos_sk=%s, uskt_lain=%s, uskt_lain_sk=%s WHERE uskt_id=%s",
							   GetSQLValueString($_POST['uskt_aktiviti'], "text"),
							   GetSQLValueString($_POST['uskt_kuantiti'], "text"),
							   GetSQLValueString($_POST['uskt_kuantiti_sk'], "text"),
							   GetSQLValueString($_POST['uskt_masa'], "text"),
							   GetSQLValueString($_POST['uskt_masa_sk'], "text"),
							   GetSQLValueString($_POST['uskt_masa_mula'], "text"),
							   GetSQLValueString($_POST['uskt_masa_tamat'], "text"),
							   GetSQLValueString($_POST['uskt_kualiti'], "text"),
							   GetSQLValueString($_POST['uskt_kualiti_sk'], "text"),
							   GetSQLValueString($_POST['uskt_kos'], "text"),
							   GetSQLValueString($_POST['uskt_kos_sk'], "text"),
							   GetSQLValueString($_POST['uskt_lain'], "text"),
							   GetSQLValueString($_POST['uskt_lain_sk'], "text"),
							   GetSQLValueString($_POST['uskt_id'], "int"));
		
		  mysql_select_db($database_skt, $skt);
		  $Result1 = mysql_query($updateSQL, $skt) or die(mysql_error());
		  
		  $updateGoTo .= "&msg=add";
		  
		} else {
	  		$updateGoTo .= "&msg=error";
		};
		
	} else {
	  $updateGoTo .= "&eul=1";
	};
	
} else {
	$updateGoTo .= "&msg=error";
};

header(sprintf("Location: %s", $updateGoTo));
?>