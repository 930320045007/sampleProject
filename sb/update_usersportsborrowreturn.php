<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/sportsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$deleteGoTo = $url_main . "sports/loandetail.php?id=" . $_POST['id'];

if(checkUserSysAcc($row_user['user_stafid'], 19, 103, 3)){
	if(checkStafID($_POST['ict_returnuser']))
	{
		$deleteSQL1 = sprintf("UPDATE sports.user_borrow SET ict_return='1', ict_returnby=%s, ict_returndate=%s, ict_returnnote=%s, ict_returnuser=%s WHERE userborrow_id=%s",
							 GetSQLValueString($row_user['user_stafid'], "text"),
							 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							 GetSQLValueString($_POST['ict_returnnote'], "text"),
							 GetSQLValueString($_POST['ict_returnuser'], "text"),
							 GetSQLValueString($_POST['id'], "int"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($deleteSQL1, $hrmsdb) or die(mysql_error());
		
		$query_ictitem = "SELECT item_borrow.* FROM sports.item_borrow WHERE userborrow_id = '" . $_POST['id'] . "' AND itemborrow_status = '1' ORDER BY itemborrow_id ASC";
		$ictitem = mysql_query($query_ictitem);
		$row_ictitem = mysql_fetch_assoc($ictitem);
		
		do {
		$deleteSQL2 = sprintf("UPDATE sports.item_borrow SET ict_return='1', ict_returnby=%s, ict_returndate=%s, ict_returnnote=%s, ict_returnuser=%s WHERE itemborrow_id=%s",
							 GetSQLValueString($row_user['user_stafid'], "text"),
							 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							 GetSQLValueString($_POST['ict_returnnote'], "text"),
							 GetSQLValueString($_POST['ict_returnuser'], "text"),
							 GetSQLValueString($row_ictitem['itemborrow_id'], "int"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result2 = mysql_query($deleteSQL2, $hrmsdb) or die(mysql_error());
		
		} while($row_ictitem = mysql_fetch_assoc($ictitem));
	  
	    $deleteGoTo .= "&msg=edit";
	} else {
  		$deleteGoTo .= "&e=2";
	}
} else {
	$deleteGoTo .= "&eul=1";
}
header(sprintf("Location: %s", $deleteGoTo));
?>