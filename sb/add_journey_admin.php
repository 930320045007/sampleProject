<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$insertGoTo = $url_main . "tadbir/admintransportdetail.php?tid=" . getID(htmlspecialchars($_POST['transbookid'], ENT_QUOTES));

if(checkUserSysAcc($row_user['user_stafid'], 10, 81, 2) && checkAdminAppByID($_POST['transbookid']))
{ 
	if(!checkFeedback($_POST['transbookid']))
	{
		$hmi = explode(':', $_POST['journeytime'], 2);
		$insertSQL = sprintf("INSERT INTO tadbir.journey (transbook_id, journey_from, journey_to, journey_date_d, journey_date_m, journey_date_y, journey_time_h, journey_time_m) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
							 GetSQLValueString($_POST['transbookid'], "int"),
							 GetSQLValueString($_POST['journey_from'], "text"),
							 GetSQLValueString($_POST['journey_to'], "text"),
							 GetSQLValueString($_POST['journey_date_d'], "int"),
							 GetSQLValueString($_POST['journey_date_m'], "int"),
							 GetSQLValueString($_POST['journey_date_y'], "int"),
							 GetSQLValueString($hmi[0], "int"),
							 GetSQLValueString($hmi[1], "int"));
		
		mysql_select_db($database_tadbirdb, $tadbirdb);
		$Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
		
		 $insertGoTo .= "&msg=edit";
	} else {
		$insertGoTo .= "&msg=error";
	};
} else {
	$insertGoTo .= "&eul=1";
}
header(sprintf("Location: %s", $insertGoTo));
?>