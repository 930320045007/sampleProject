<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$deleteGoTo = $url_main . "profile.php";

if ((isset($_GET['delec'])) && ($_GET['delec'] != ""))
{
	if(getDelEC($_GET['delec'])==$row_user['user_stafid'])
	{
	  $deleteSQL = sprintf("UPDATE user_ec SET userec_status = '0' WHERE userec_id=%s",
						   GetSQLValueString($_GET['delec'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	
	  $deleteGoTo .= "?msg=del#ec2";
	} else {
	  $deleteGoTo .= "?del=1#ec2";
	};

} else {
	$deleteGoTo .= "?msg=error#ec2";
};

header(sprintf("Location: %s", $deleteGoTo));
?>