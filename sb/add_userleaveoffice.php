<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../sb/email.php');?>
<?php

$insertGoTo = $url_main . "leave/am5babG.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "leaveoffice") && !isset($_POST['xxx'])) 
{
	$dmy = explode('/', htmlspecialchars($_POST['dmy'], ENT_QUOTES));
	
	if(!checkleaveOfficeIDByDate($row_user['user_stafid'], $dmy[0], $dmy[1], $dmy[2], 1))
	{
		
	if(isset($_POST['from']))
	{
		$fy = explode("/", htmlspecialchars($_POST['from'], ENT_QUOTES));
		
	} else {
		
		$fy[0] = date('H');
		$fy[1] = date('i');
		$fy[2] = date('A');
	};

	if(isset($_POST['till']))
	{
		$ty = explode("/", htmlspecialchars($_POST['till'], ENT_QUOTES));
		
	} else {
		
		$ty[0] = date('H');
		$ty[1] = date('i');
		$ty[2] = date('A');
	};
	
	if(isset($_POST['leaveoffice_day']))
	{
		$day = htmlspecialchars($_POST['leaveoffice_day'], ENT_QUOTES);
	} else {
		$day = 0;
	};
	
	if(isset($_POST['leaveoffice_daytype']))
	{
		$daytype = htmlspecialchars($_POST['leaveoffice_daytype'], ENT_QUOTES);
	} else {
		$daytype = 1;
	};

	$insertSQL = sprintf("INSERT INTO leave_office (user_stafid, reason_id, leaveoffice_day, leaveoffice_daytype, leaveoffice_date_d, leaveoffice_date_m, leaveoffice_date_y, leaveoffice_on_d, leaveoffice_on_m, leaveoffice_on_y,  leaveoffice_from_h, leaveoffice_from_m, leaveoffice_from_ap, leaveoffice_till_h, leaveoffice_till_m, leaveoffice_till_ap, leaveoffice_note, app_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString($_POST['sebab'], "int"),
						   GetSQLValueString($day, "int"),
						   GetSQLValueString($daytype, "int"),
						   GetSQLValueString(date('d'), "text"),
						   GetSQLValueString(date('m'), "text"),
						   GetSQLValueString(date('Y'), "text"),
						   GetSQLValueString($dmy[0], "text"),
						   GetSQLValueString($dmy[1], "text"),
						   GetSQLValueString($dmy[2], "text"),
						   GetSQLValueString($fy[0], "text"),
						   GetSQLValueString($fy[1], "text"),
						   GetSQLValueString($fy[2], "text"),
						   GetSQLValueString($ty[0], "text"),
						   GetSQLValueString($ty[1], "text"),
						   GetSQLValueString($ty[2], "text"),
						   GetSQLValueString($_POST['leaveoffice_note'], "text"),
						   GetSQLValueString(getHeadIDByUserID($row_user['user_stafid']), "text"));
							
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $insertGoTo = $url_main . "leave/record.php?msg=add";
	  
	  $leaveofficeID = getNewLeaveOfficeIDByDate($row_user['user_stafid'], $_POST['sebab'], $dmy[0], $dmy[1], $dmy[2]);
			  
	  $emailto = array();
	  $emailto[] = $row_user['user_stafid'];
	  $emailto[] = getHeadIDByUserID($row_user['user_stafid']); // array emailstafid[0] = Head ID yg memohon
	  
	  emailNewLeaveOffice($emailto, 0, 0, 1, $leaveofficeID); 
	  
	} else {
		$insertGoTo .= "?lo=1";
	};
	  
} else {  
	$insertGoTo .= "?msg=error";
};

header(sprintf("Location: %s", $insertGoTo));
?>