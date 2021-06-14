<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$GoTo = $url_main . "/admin/profile.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "dep")) 
{
	  $insertSQL = sprintf("INSERT INTO user_dependents (userdependents_by, userdependents_date, user_stafid, userdependents_name, userdependents_relation, userdependents_ic) VALUES (%s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['userdependents_by'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"),
						   GetSQLValueString($_POST['userdependents_name'], "text"),
						   GetSQLValueString($_POST['userdependents_relation'], "text"),
						   GetSQLValueString($_POST['userdependents_ic'], "text"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $Goto .= "?msg=add#dep2";
	  
} else {
	$Goto .= "?msg=error#dep2";
};

header(sprintf("Location: %s", $GoTo));
?>
