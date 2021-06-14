<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$updateGoTo = $url_main . "admin/holiday.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 23, 4))
{
  $updateSQL = sprintf("UPDATE holiday SET holiday_status=0 WHERE holiday_id=%s",
                       GetSQLValueString($_GET['id'], "int")); 

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());

  $updateGoTo .= "?msg=del";
  
} else {
	$updateGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>