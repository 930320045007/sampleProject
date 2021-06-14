<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$GoTo = $url_main . "head/officer.php";

if(checkJob2View($row_user['user_stafid']))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sv")) 
	{
	  $insertSQL = sprintf("INSERT INTO user_report (userreport_date, userreport_by, user_stafid, userreport_stafid, userreport_type) VALUES (%s, %s, %s, %s, %s)",
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['userreport_by'], "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"),
						   GetSQLValueString($_POST['userreport_stafid'], "text"),
						   GetSQLValueString($_POST['userreport_type'], "text"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $GoTo .= "?msg=add";
	  
	} else {
		$GoTo .= "?msg=error";
	};
	
} else {
	$GoTo .= "?msg=error";
};

header(sprintf("Location: %s", $GoTo));
?>