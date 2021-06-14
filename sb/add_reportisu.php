<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$GoTo = $url_main . "ict/isu.php?rt=" . htmlspecialchars($_POST['reporttype_id'], ENT_QUOTES) . "&rst=" . htmlspecialchars($_POST['reportsubtype_id'], ENT_QUOTES);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "isu")) 
{
	  $insertSQL = sprintf("INSERT INTO ict.report_symptom (reportsymptom_by, reportsymptom_date, reporttype_id, reportsubtype_id, reportsymptom_question) VALUES (%s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['reporttype_id'], "int"),
						   GetSQLValueString($_POST['reportsubtype_id'], "int"),
						   GetSQLValueString($_POST['reportsymptom_question'], "text"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $GoTo .= "&msg=add";
	  
} else {
	$GoTo .= "&msg=error";
};

header(sprintf("Location: %s", $GoTo));
?>
