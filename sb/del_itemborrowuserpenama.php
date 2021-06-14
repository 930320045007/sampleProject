<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$insertGoTo = $url_main . "ict/itemdetail.php?id=" . getItemIDByItemBorrowID($_GET['id']);

if(checkUserSysAcc($row_user['user_stafid'], 6, 26, 4))
{
	  $insertSQL = sprintf("UPDATE ict.item_borrow SET itemborrow_status='0' WHERE itemborrow_id=%s",
									   GetSQLValueString($_GET['id'], "int"));
				
	  mysql_select_db($database_ictdb, $ictdb);
	  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
	
	  $insertGoTo .= "&msg=del";

} else {
  $insertGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>