<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/sportsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sportsfunc.php');?>
<?php
$insertGoTo = $url_main . "sports/item.php";

if(checkUserSysAcc($row_user['user_stafid'], 19, 102, 4))
{
	  $insertSQL = sprintf("UPDATE sports.item SET item_status='0' WHERE item_id=%s",
									   GetSQLValueString($_GET['id'], "int"));
				
	  mysql_select_db($database_sportsdb, $sportsdb);
	  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
	
	  $insertGoTo .= "?msg=del";

} else {
  $insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>