<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$insertGoTo = $url_main . "admin/salaryblock.php";

if(checkUserSysAcc($row_user['user_stafid'], '5', '34', 2))
{
	if(checkStafID($_POST['user_stafid']))
	{
		if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) 
		{
			$start = explode("/", $_POST['usb_start']);
			$end = explode("/", $_POST['usb_end']);
				
				$insertSQL = sprintf("INSERT INTO www.user_salaryblock (usb_by, usb_date, user_stafid, usb_start_m, usb_start_y, usb_end_m, usb_end_y, usb_note) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
									 GetSQLValueString($row_user['user_stafid'], "text"),
									 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
									 GetSQLValueString($_POST['user_stafid'], "text"),
									 GetSQLValueString($start[0], "text"),
									 GetSQLValueString($start[1], "text"),
									 GetSQLValueString($end[0], "text"),
									 GetSQLValueString($end[1], "text"),
									 GetSQLValueString($_POST['usb_note'], "text"));
			  
				mysql_select_db($database_hrmsdb, $hrmsdb);
				$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
				
				$insertGoTo .= "?msg=add";
				
			
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
