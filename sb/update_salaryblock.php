<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$insertGoTo = $url_main . "admin/salaryblock.php";

if(checkUserSysAcc($row_user['user_stafid'], '5', '34', 3))
{
	if(checkStafID($_POST['user_stafid']))
	{
		if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) 
		{
				$insertSQL = sprintf("UPDATE www.user_salaryblock SET usb_by=%s, usb_date=%s, user_stafid=%s, usb_start_m=%s, usb_start_y=%s, usb_end_m=%s, usb_end_y=%s, usb_note=%s WHERE usb_id=%s",
									 GetSQLValueString($row_user['user_stafid'], "text"),
									 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
									 GetSQLValueString($_POST['user_stafid'], "text"),
									 GetSQLValueString($_POST['usb_start_m'], "text"),
									 GetSQLValueString($_POST['usb_start_y'], "text"),
									 GetSQLValueString($_POST['usb_end_m'], "text"),
									 GetSQLValueString($_POST['usb_end_y'], "text"),
									 GetSQLValueString($_POST['usb_note'], "text"),
									 GetSQLValueString($_POST['usb_id'], "int"));
			  
				mysql_select_db($database_hrmsdb, $hrmsdb);
				$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
				
				sys_prorec('hr', 'user_salaryblock', $row_user['user_stafid'], '3', 'id=' . htmlspecialchars(getID($_POST['usb_id'],0), ENT_QUOTES));
				
				$insertGoTo .= "?msg=edit";
		  	
				
		} else {
			$insertGoTo .= "?msg=error";
		};
		
	} else {
  		$insertGoTo .= "?e=2";
	};
	
} else {
  $insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>
