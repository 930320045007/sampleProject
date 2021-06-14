<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

if ((isset($_GET['delsv'])) && ($_GET['delsv'] != "")) {
	if(getDelReport($_GET['delsv'])==$row_user['user_stafid'])
	{
	  $deleteSQL = sprintf("UPDATE user_report SET userreport_status = '0' WHERE userreport_id=%s",
						   GetSQLValueString($_GET['delsv'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	
	  $deleteGoTo = $url_main . "job.php?msg=del#ev2";
	} else {
	  $deleteGoTo = $url_main . "job.php?del=1#ev2";
	};

} else {
	$deleteGoTo = $url_main . "job.php?msg=error#ev2";
};

header(sprintf("Location: %s", $deleteGoTo));
?>