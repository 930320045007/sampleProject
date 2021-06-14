<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php
$updateGoTo = $url_main . "fin/adminjkbdetail.php?id=" . htmlspecialchars($_POST['jkb_id'],ENT_QUOTES);
if(checkUserSysAcc($row_user['user_stafid'], 16, 89, 3)){

foreach ($_POST['id'] as $key => $value){
	
	$updateSQL = sprintf("UPDATE finance.apply SET applystatus_id=%s, fin_note=%s WHERE apply_id=%s",
						 GetSQLValueString($_POST['fin_status'][$key], "text"),
						 GetSQLValueString($_POST['fin_note'][$key], "text"),
						 GetSQLValueString($value, "int"));
  
	mysql_select_db($database_financedb, $financedb);
	$Result1 = mysql_query($updateSQL, $financedb) or die(mysql_error());	
}
  $updateGoTo .= "&msg=edit";
} else {
	$updateGoTo .= "&eul=1";
}
header(sprintf("Location: %s", $updateGoTo));
?>