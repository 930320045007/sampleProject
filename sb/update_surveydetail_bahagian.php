<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/selidikdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/selidikfunc.php');?>
<?php
$insertGoTo = $url_main . "qna/surveydetail.php";

if(checkUserSysAcc($row_user['user_stafid'], 13, 49, 2))
{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
	{
	  $insertSQL = sprintf("UPDATE selidik.questiongroup SET qg_by=%s, qg_date=%s, qg_title=%s, qg_desc=%s WHERE qg_id=%s",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d/m/Y h:s:i A'), "text"),
						   GetSQLValueString($_POST['qg_title'], "text"),
						   GetSQLValueString($_POST['qg_desc'], "text"),
						   GetSQLValueString($_POST['qg_id'], "int"));
	
	  mysql_select_db($database_selidikdb, $selidikdb);
	  $Result1 = mysql_query($insertSQL, $selidikdb) or die(mysql_error());
	  
	  $insertGoTo .= "?id=" . htmlspecialchars($_POST['sd_id'], ENT_QUOTES) . "&msg=edit";
	} else {
		$insertGoTo .= "?id=" . htmlspecialchars($_POST['sd_id'], ENT_QUOTES) . "&msg=error";
	};
	
} else {
	$insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>