<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../sb/email.php');?>
<?php
$updateGoTo = $url_main . "head/am5babGdetail.php?id=" . getID(htmlspecialchars($_POST['id'], ENT_QUOTES));

if(checkJob2View($row_user['user_stafid']))
{
	
	if(isset($_POST['app_warning']))
		$warning = 1;
	else
		$warning = 0;
		
	$updateSQL = sprintf("UPDATE www.leave_office SET app_warning=%s, app_status=%s, app_by=%s, app_date=%s, app_note=%s WHERE leaveoffice_id=%s",
						 GetSQLValueString($warning, "int"),
						 GetSQLValueString($_POST['app_status'], "int"),
						 GetSQLValueString($row_user['user_stafid'], "text"),
						 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						 GetSQLValueString($_POST['app_note'], "text"),
						 GetSQLValueString($_POST['id'], "int"));
  
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$Result = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
			  
	$emailto = array();
	$emailto[] = getUserIDByLeaveOfficeID($_POST['id']); // array emailstafid[0] = Staf ID yg memohon
	
	emailApprovalLeaveOffice($emailto, 0, 0, 1, $_POST['id']); 
	
	unset($emailto);
	
	if(checkWarningleaveOfficeByUserID(getUserIDByLeaveOfficeID($_POST['id']), 0, date('Y')))
	{
		$noticeSend = array();
		
		// send Staf berkaitan amaran noticeSend[0]
		$noticeSend[] = getUserIDByLeaveOfficeID($_POST['id']);
		
		//Send Head berkaitan amaran noticeSend[1]
		$noticeSend[] = getHeadIDByUserID(getUserIDByLeaveOfficeID($_POST['id']));
		
		// Send HR berkaitan amaran yg lebih 3 kali oleh Staf ID  noticeSend[2]
		$noticeSend = array_merge($noticeSend,getUserIDSysAcc(5, 23));
		
		emailNoticeLeaveOffice($noticeSend, 0, 0, 1, getStafIDByLeaveID($value));
		
		unset($noticeSend);
	};
  
	$updateGoTo .= "&msg=edit";
  
} else {
	$updateGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>
