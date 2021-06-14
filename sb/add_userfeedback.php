<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$insertGoTo = $url_main . "tadbir/record.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formfeedback")) 
{
	if(!checkFeedback($_POST['transbookid']) && checkAdminAppByID($_POST['transbookid']) && checkTransbookEndByTransID($_POST['transbookid'])) 
	{
		foreach($_POST['fid'] AS $key => $value)
		{
			$ja = "jawab" . $value;
			
		  $insertSQL = sprintf("INSERT INTO tadbir.user_feedback (userfeedback_date, userfeedback_by,transbook_id, feedback_id, userfeedback_answer) VALUES (%s, %s, %s, %s, %s)",
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString($_POST['transbookid'], "int"),
							   GetSQLValueString($value, "int"),
							   GetSQLValueString($_POST[$ja], "text"));
		
		  mysql_select_db($database_tadbirdb, $tadbirdb);
		  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
		};
		
		$insertGoTo .= "?msg=add";
		
	} else {
		$insertGoTo .= "?eul=1";
	};
	
} else {
	$insertGoTo .= "?msg=error";
};

header(sprintf("Location: %s", $insertGoTo));
?>