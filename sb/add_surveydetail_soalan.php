<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/selidikdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/selidikfunc.php');?>
<?php
$insertGoTo = $url_main . "qna/surveydetail.php";

if(checkUserSysAcc($row_user['user_stafid'], 13, 49, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
	{
	  $insertSQL = sprintf("INSERT INTO question (q_by, q_date, sd_id, qg_id, q_title) VALUES (%s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d/m/Y h:s:i A'), "text"),
						   GetSQLValueString($_POST['sd_id'], "int"),
						   GetSQLValueString($_POST['qg_id'], "int"),
						   GetSQLValueString($_POST['q_title'], "text"));
	
	  mysql_select_db($database_selidikdb, $selidikdb);
	  $Result1 = mysql_query($insertSQL, $selidikdb) or die(mysql_error());
	  
	  $insertGoTo .= "?id=" . $_POST['sd_id'] . "&msg=add";
	  
	} else {
		$insertGoTo .= "?id=" . $_POST['sd_id'] . "&msg=error";
	};
	
} else {
	$insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>