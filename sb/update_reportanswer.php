<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$GoTo = $url_main . "ict/isu.php?rt=" . htmlspecialchars($_POST['reporttype_id'], ENT_QUOTES) . "&rst=" . htmlspecialchars($_POST['reportsubtype_id'], ENT_QUOTES);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "ans"))
{
	  $insertSQL = sprintf("UPDATE ict.report_answer SET reportanswer_by=%s, reportanswer_date=%s, reportanswer_title=%s, reportanswer_detail=%s WHERE reportanswer_id=%s",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['reportanswer_title'], "text"),
						   GetSQLValueString($_POST['reportanswer_detail'], "text"),
						   GetSQLValueString($_POST['reportanswer_id'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $GoTo .= "&msg=edit";
	  
} else {
	$GoTo .= "&msg=error";
};

header(sprintf("Location: %s", $GoTo));
?>
