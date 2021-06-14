<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$insertGoTo = $url_main . "admin/holiday.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 23, 2))
{
	if(!checkHolidayByDate($_POST['holiday_date_d'], $_POST['holiday_date_m'], $_POST['holiday_date_y']))
	{
		if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
		{
		  $insertSQL = sprintf("INSERT INTO www.holiday (holiday_by, holiday_date, holiday_date_d, holiday_date_m, holiday_date_y, holidaycategory_id, holiday_name, holiday_note, holiday_state) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($_POST['holiday_date_d'], "text"),
							   GetSQLValueString($_POST['holiday_date_m'], "text"),
							   GetSQLValueString($_POST['holiday_date_y'], "text"),
							   GetSQLValueString($_POST['holidaycategory_id'], "int"),
							   GetSQLValueString($_POST['holiday_name'], "text"),
							   GetSQLValueString($_POST['holiday_note'], "text"),
							   GetSQLValueString(implode(",", $_POST['negeri']), "text"));
		
		  mysql_select_db($database_hrmsdb, $hrmsdb);
		  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
		  
		  $insertGoTo .= "?msg=add";
		  
		} else {
			$insertGoTo .= "?msg=error";
		};
		
	} else {
		$insertGoTo .= "?msg=error";
	};
	
} else {
	$insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>
