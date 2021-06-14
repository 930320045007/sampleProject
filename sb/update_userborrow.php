<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php include('../sb/email.php');?>
<?php
$deleteGoTo = $url_main . "ict/loandetail.php?id=" . htmlspecialchars($_POST['id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 6, 27, 3))
{

	$deleteSQL = sprintf("UPDATE ict.user_borrow SET ict_status=%s, ict_by=%s, ict_date=%s, ict_note=%s WHERE userborrow_id=%s",
						 GetSQLValueString($_POST['ict_status'], "text"),
						 GetSQLValueString($row_user['user_stafid'], "text"),
						 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						 GetSQLValueString($_POST['ict_note'], "text"),
						 GetSQLValueString($_POST['id'], "int"));
  
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
			  
	$emailto = array();
	$emailto[] = getUserIDByUserBorrowID(htmlspecialchars($_POST['id'], ENT_QUOTES)); // array emailstafid[0] = Staf ID yg memohon
	
	emailKelulusanPinjamanICT ($emailto, 0, 0, 1, htmlspecialchars($_POST['id'], ENT_QUOTES)); // 3- email kelulusan daripada Cawangan Sumber Manusia
  
	$deleteGoTo .= "&msg=edit";
  
} else {
	$deleteGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $deleteGoTo));
?>