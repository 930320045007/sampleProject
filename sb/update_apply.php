<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php
$updateGoTo = $url_main . "fin/adminjkbdetail.php?id=" . getID(htmlspecialchars($_POST['jkb_id'],ENT_QUOTES));
if(checkUserSysAcc($row_user['user_stafid'], 16, 89, 3)){
	
	if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) 
	{

	$updateSQL = sprintf("UPDATE finance.apply SET apply_description=%s, apply_quantity=%s, apply_calculation=%s, apply_amount=%s WHERE jkb_id=%s AND apply_id=%s",
						 GetSQLValueString($_POST['apply_description'], "text"),
						 GetSQLValueString($_POST['apply_quantity'], "text"),
						 GetSQLValueString($_POST['apply_calculation'], "text"),
						 GetSQLValueString($_POST['apply_amount'], "text"),
						 GetSQLValueString($_POST['jkb_id'], "int"),
						  GetSQLValueString($_POST['apply_id'], "int"));
  
	mysql_select_db($database_financedb, $financedb);
	$Result1 = mysql_query($updateSQL, $financedb) or die(mysql_error());	
  $updateGoTo .= "&msg=edit";
} else {
		$updateGoTo .= "&msg=error";
	};
	
}else {
	$updateGoTo .= "&eul=1";
}
header(sprintf("Location: %s", $updateGoTo));
?>