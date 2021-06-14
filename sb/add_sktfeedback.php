<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='59';?>
<?php

if(getSKTStafID($_POST['uskt_id'])!=$row_user['user_stafid']) // ppp skt detail
	$insertGoTo = $url_main . "skt/pppdetail.php?id=" . getID(htmlspecialchars($_POST['uskt_id'], ENT_QUOTES));
else // pyd skt detail
	$insertGoTo = $url_main . "skt/sktdetail.php?id=" . getID(htmlspecialchars($_POST['uskt_id'], ENT_QUOTES));

if(checkPPPByStafID($row_user['user_stafid']) || $row_user['user_stafid']==getSKTStafID($_POST['uskt_id']))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) 
	{
	  $insertSQL = sprintf("INSERT INTO sktfeedback (sktf_by, sktf_date_d, sktf_date_m, sktf_date_y, sktf_date_h, uskt_id, feedbacktype_id, sktf_sub, sktf_note) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d'), "text"),
						   GetSQLValueString(date('m'), "text"),
						   GetSQLValueString(date('Y'), "text"),
						   GetSQLValueString(date('h:i:s A'), "text"),
						   GetSQLValueString($_POST['uskt_id'], "int"),
						   GetSQLValueString($_POST['feedbacktype_id'], "int"),
						   GetSQLValueString($_POST['sktf_sub'], "text"),
						   GetSQLValueString($_POST['sktf_note'], "text"));
	
	  mysql_select_db($database_skt, $skt);
	  $Result1 = mysql_query($insertSQL, $skt) or die(mysql_error());
	  
	  $insertGoTo .= "&msg=add";
	  
//	  if(getSKTStafID($_POST['uskt_id'])!=$row_user['user_stafid'])
//	  {
//		  $emailtoAct = array();
//		  $emailtoAct[] = getSKTStafID($_POST['uskt_id']); // array emailstafid[0] = Staf ID yg memohon
//		  emailSKTFeedback($emailtoAct, 0, 0, 1, $_POST['uskt_id']);
//	  }

	} else {
		$insertGoTo .= "&msg=error";
	};
	
} else {
	$insertGoTo .= "&eskt=2";
};

header(sprintf("Location: %s", $insertGoTo));
?>