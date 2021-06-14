<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$GoTo = $url_main . "profile.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "ec")) 
{		
	  $insertSQL = sprintf("INSERT INTO user_ec (userec_by, userec_date, user_stafid, userec_name, userec_relation, userrec_address, userec_noic, userec_telh, userec_telm, userec_telw) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['userec_by'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"),
						   GetSQLValueString($_POST['userec_name'], "text"),
						   GetSQLValueString($_POST['userec_relation'], "text"),
						   GetSQLValueString($_POST['userrec_address'], "text"),
						   GetSQLValueString($_POST['userec_noic'], "text"),
						   GetSQLValueString($_POST['userec_telh'], "text"),
						   GetSQLValueString($_POST['userec_telm'], "text"),
						   GetSQLValueString($_POST['userec_telw'], "text"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $GoTo .= "?msg=add#ec2";
	  
} else {
	$GoTo .= "?msg=error#ec2";
};

header(sprintf("Location: %s", $GoTo));
?>