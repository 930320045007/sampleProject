<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php

$deleteGoTo = $url_main . "tadbir/ticketdetailadmin.php?id=" . getTiketIDByTravelID(htmlspecialchars($_GET['trid'], ENT_QUOTES));

if(checkUserSysAcc($row_user['user_stafid'], 10, 57, 4))
{
	
  $deleteSQL = sprintf("UPDATE tadbir.travel SET travel_status = '0' WHERE travel_id=%s",
					   GetSQLValueString($_GET['trid'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
  
  $deleteGoTo .= "&msg=del";
	  
} else {
  $deleteGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $deleteGoTo));

?>