<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/sportsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sportsfunc.php');?>
<?php //include('../sb/email.php');?>
<?php
$deleteGoTo = $url_main . "sports/loandetail.php?id=" . htmlspecialchars($_POST['id'], ENT_QUOTES);
if(checkUserSysAcc($row_user['user_stafid'], 19, 103, 3))
{

	$deleteSQL = sprintf("UPDATE sports.user_borrow SET ict_status=%s, ict_by=%s, ict_date=%s, ict_note=%s WHERE userborrow_id=%s",
						 GetSQLValueString($_POST['ict_status'], "text"),
						 GetSQLValueString($row_user['user_stafid'], "text"),
						 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						 GetSQLValueString($_POST['ict_note'], "text"),
						 GetSQLValueString($_POST['id'], "int"));
  
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
			  
	$emailto = array();
	$emailto[] = getUserSportsIDByUserBorrowID(htmlspecialchars($_POST['id'], ENT_QUOTES)); // array emailstafid[0] = Staf ID yg memohon
	
	$emailKelulusanPinjamanSainsSukan //($emailto, 0, 0, 1, htmlspecialchars($_POST['id'], ENT_QUOTES)); // 3- email kelulusan daripada Cawangan Sumber Manusia
  
  $deleteGoTo .= "&msg=edit";
} else {
	$deleteGoTo .= "&eul=1";
}
header(sprintf("Location: %s", $deleteGoTo));
?>