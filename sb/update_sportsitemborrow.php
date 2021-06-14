<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/sportsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$deleteGoTo = $url_main . "sports/loandetail.php?id=" . $_POST['id'];
if(checkUserSysAcc($row_user['user_stafid'], 19, 103, 3)){
  foreach($_POST['itemborrow_id'] AS $key => $value)
  {
	$deleteSQL = sprintf("UPDATE sports.item_borrow SET itemborrow_by=%s, itemborrow_date=%s, item_id=%s, itemborrow_note=%s WHERE itemborrow_id=%s",
						 GetSQLValueString($row_user['user_stafid'], "text"),
						 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						 GetSQLValueString($_POST['item_id'][$key], "int"),
						 GetSQLValueString($_POST['itemborrow_note'][$key], "text"),
						 GetSQLValueString($value, "int"));
  
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
  }
  
	$deleteSQL1 = sprintf("UPDATE sports.user_borrow SET ict_item='1' WHERE userborrow_id=%s",
						 GetSQLValueString($_POST['id'], "int"));
  
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$Result1 = mysql_query($deleteSQL1, $hrmsdb) or die(mysql_error());
  
  $deleteGoTo .= "&msg=edit";
} else {
	$deleteGoTo .= "&eul=1";
}
header(sprintf("Location: %s", $deleteGoTo));
?>