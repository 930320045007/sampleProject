<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$insertGoTo = $url_main . "admin/salaryblock.php";

if(checkUserSysAcc($row_user['user_stafid'], '5', '34', 4))
{
  $id = htmlspecialchars(getID($_GET['id'],0), ENT_QUOTES);
	
  $insertSQL = sprintf("UPDATE www.user_salaryblock SET usb_by=%s, usb_date=%s, usb_status = '0' WHERE usb_id=%s",
					   GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($id, "int"));
  
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  
  sys_prorec('hr', 'user_salaryblock', $row_user['user_stafid'], '4', 'id=' . htmlspecialchars(getID($id,0), ENT_QUOTES));
  
  $insertGoTo .= "?msg=del";
  
} else {
	
  $insertGoTo .= "?eul=1";
  
};

header(sprintf("Location: %s", $insertGoTo));
?>
