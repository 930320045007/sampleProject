<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php include('../sb/email.php');?>
<?php

$updateGoTo = $url_main . "fin/adminjkbdetail.php?id=" . htmlspecialchars($_POST['jkb_id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 16, 89, 3))
{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
	{
		  $updateSQL = sprintf("UPDATE jkb SET jkb_appupdateby=%s, jkb_appupdatedate=%s, jkb_appby=%s,bil_id=%s, jkb_appdate_d=%s, jkb_appdate_m=%s, jkb_appdate_y=%s, jkb_appnote=%s WHERE jkb_id=%s",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($_POST['jkb_appby'], "text"),							   							   GetSQLValueString($_POST['bil_id'], "int"),
							   GetSQLValueString($_POST['jkb_appdate_d'], "text"),
							   GetSQLValueString($_POST['jkb_appdate_m'], "text"),
							   GetSQLValueString($_POST['jkb_appdate_y'], "text"),
							   GetSQLValueString($_POST['jkb_appnote'], "text"),
							   GetSQLValueString($_POST['jkb_id'], "int"));
		
		  mysql_select_db($database_financedb, $financedb);
		  $Result1 = mysql_query($updateSQL, $financedb) or die(mysql_error());
		  
		  $updateGoTo .= "&msg=edit";
		  
		  $emailto = array();
		  $emailto[] = $row_user['user_stafid'];
		  $emailto = array_merge($emailto,getUserIDSysAcc(16,89));
		  emailAppJKB($emailto, 0, 0, 1, $_POST['jkb_id']);
	  
	} else {
		$updateGoTo .= "&msg=error";
	};
	
} else {
	$updateGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>