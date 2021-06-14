<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../sb/email.php');?>
<?php
if(checkJob2View($row_user['user_stafid']))
{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) 
	{
		$cutilist = $_POST['cutiid']; // array
		$i=1;
		
		foreach($cutilist as $key => $value)
		{
			$ccuti2 = 'cuti' . $i;
			$cnotice = 'notice'. $i;
			
			if($_POST[$ccuti2]==2)
			{
				$userleavedatestatus = '0'; //tidak diluluskan
			} else {
				$userleavedatestatus = '1'; // diluluskan
			};
			
			$updateSQL = sprintf("UPDATE www.user_leavedate SET userleavedate_notice=%s, userleavedate_app=%s, userleavedate_appby=%s, userleavedate_appdate=%s, userleavedate_status=%s WHERE userleavedate_id=%s",
				   GetSQLValueString($_POST[$cnotice], "int"),
				   GetSQLValueString($_POST[$ccuti2], "int"),
				   GetSQLValueString($row_user['user_stafid'], "text"),
				   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
				   GetSQLValueString($userleavedatestatus, "int"),
				   GetSQLValueString($value, "int"));
			
			mysql_select_db($database_hrmsdb, $hrmsdb);
			$Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
		
			$i++;
			
			if($_POST[$ccuti2]==1 || $_POST[$ccuti2]==2) 
			{ 
				// 1- diluluskan, 2- Tidak diluluskan, 0- tangguh
				$emailto = array();
				$emailto[] = getStafIDByLeaveID($value);
				$leaveid = $value;
				
				emailLeave($emailto, 0, 0, 2, $leaveid); // 2- email kelulusan
				
				unset($emailto);
			};
			
			if($_POST[$cnotice]=='1' && checkNotice3Time(getStafIDByLeaveID($value)))
			{
				$noticeSend = array();
				
				// send Staf berkaitan amaran
				$noticeSend[] = getStafIDByLeaveID($value);
				
				//Send Head berkaitan amaran
				$noticeSend[] = getHeadIDByUserID(getStafIDByLeaveID($value));
				
				// Send HR berkaitan amaran yg lebih 3 kali oleh Staf ID
				$noticeSend = array_merge($noticeSend,getUserIDSysAcc(5, 23));
				
				emailNotice($noticeSend, 0, 0, 1, getStafIDByLeaveID($value));
				
				unset($noticeSend);
			};
		};
	
	  $updateGoTo = $url_main . "head/leave.php?msg=edit";
	  
	} else {
	  $updateGoTo = $url_main . "head/leave.php?el=1";
	};
	
} else {
  $updateGoTo = $url_main . "head/leave.php?del=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>
