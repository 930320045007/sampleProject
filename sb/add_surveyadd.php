<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/selidikdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/selidikfunc.php');?>
<?php
$insertGoTo = $url_main . "qna/survey.php";

if(checkUserSysAcc($row_user['user_stafid'], 13, 49, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
	{
	  $insertSQL = sprintf("INSERT INTO surveydetail (sd_by, sd_date_d, sd_date_m, sd_date_y, sd_date_h, sd_title, sd_desc, group_id, division_id, sd_end_d, sd_end_m, sd_end_y) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString($_POST['sd_date_d'], "int"),
						   GetSQLValueString($_POST['sd_date_m'], "int"),
						   GetSQLValueString($_POST['sd_date_y'], "int"),
						   GetSQLValueString(date('h:s:i A'), "text"),
						   GetSQLValueString($_POST['sd_title'], "text"),
						   GetSQLValueString($_POST['sd_desc'], "text"),
						   GetSQLValueString($_POST['group_id'], "int"),
						   GetSQLValueString($_POST['division_id'], "int"),
						   GetSQLValueString($_POST['sd_end_d'], "int"),
						   GetSQLValueString($_POST['sd_end_m'], "int"),
						   GetSQLValueString($_POST['sd_end_y'], "int"));
	
	  mysql_select_db($database_selidikdb, $selidikdb);
	  $Result1 = mysql_query($insertSQL, $selidikdb) or die(mysql_error());
	  
	  $insertGoTo .= "?msg=add";
	  
	} else {
		$insertGoTo .= "?msg=error";
	};
	
} else {
	$insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>