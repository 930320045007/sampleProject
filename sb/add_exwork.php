<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$GoTo = $url_main . "profile.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "exwork")) {
	
	  $insertSQL = sprintf("INSERT INTO user_exwork (userexwork_by, userexwork_date, user_stafid, userexwork_title, userexwork_employer, employertype_id, userexwork_location, userexwork_startdate, userexwork_enddate) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['userexwork_by'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"),
						   GetSQLValueString($_POST['userexwork_title'], "text"),
						   GetSQLValueString($_POST['userexwork_employer'], "text"),
						   GetSQLValueString($_POST['employertype_id'], "text"),
						   GetSQLValueString($_POST['userexwork_location'], "text"),
						   GetSQLValueString($_POST['userexwork_startdate'], "text"),
						   GetSQLValueString($_POST['userexwork_enddate'], "text"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $GoTo .= "?msg=add#exwork2";
	  
} else {
	$GoTo .= "?msg=error#exwork2";
};

header(sprintf("Location: %s", $GoTo));
?>