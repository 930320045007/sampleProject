<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$insertGoTo = $url_main . "ict/itemdetail.php?id=" . getItemIDByItemBorrowID($_POST['itemborrow_id']);

if(checkUserSysAcc($row_user['user_stafid'], 6, 26, 3))
{
	  $dr = date('d/m/Y h:i:s A', mktime(date('h'), date('i'), date('s'), $_POST['m'], $_POST['d'], $_POST['y']));
	
	  $insertSQL = sprintf("UPDATE ict.item_borrow SET ict_return=%s, ict_returnby=%s, ict_returndate=%s, ict_returnnote=%s, ict_returnuser=%s WHERE itemborrow_id=%s",
									   GetSQLValueString('1', "int"),
									   GetSQLValueString($row_user['user_stafid'], "text"),
									   GetSQLValueString($dr, "text"),
									   GetSQLValueString($_POST['ict_returnnote'], "text"),
									   GetSQLValueString($_POST['ict_returnuser'], "text"),
									   GetSQLValueString($_POST['itemborrow_id'], "int"));
				
	  mysql_select_db($database_ictdb, $ictdb);
	  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
	
	  $insertGoTo .= "&msg=edit";

} else {
  $insertGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>