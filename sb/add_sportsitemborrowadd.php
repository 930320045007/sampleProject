<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/sportsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sportsfunc.php');?>
<?php include('../sb/email.php');?>
<?php
$insertGoTo = $url_main . "sports/loandetail.php?id=" . $_POST['userborrow_id'];
if(checkUserSysAcc($row_user['user_stafid'], 19, 103, 2)){
  $insertSQL = sprintf("INSERT INTO sports.item_borrow (itemborrow_by, itemborrow_date, user_stafid, userborrow_id, subcategory_id, item_id, itemborrow_note) VALUES (%s, %s, %s, %s, %s, %s, %s)",
								   GetSQLValueString($row_user['user_stafid'], "text"),
								   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
								   GetSQLValueString($_POST['user_stafid'], "text"),
								   GetSQLValueString($_POST['userborrow_id'], "int"),
								   GetSQLValueString($_POST['subcategory_id'], "int"),
								   GetSQLValueString($_POST['item_id'], "int"),
								   GetSQLValueString($_POST['itemborrow_note'], "text"));
			
	mysql_select_db($database_sportsdb, $sportsdb);
	$Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());

  $insertGoTo .= "&msg=add";
} else {
  $insertGoTo .= "&eul=1";
}

header(sprintf("Location: %s", $insertGoTo));
?>