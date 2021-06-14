<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php

$insertGoTo = $url_main . "admin/transaction.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 35, 2))
{
	$insertSQL = sprintf("INSERT INTO www.transaction (transaction_date_d, transaction_date_m, transaction_date_y, transaction_by, transactiontype_id, transaction_name) VALUES (%s, %s, %s, %s, %s, %s)",
						 GetSQLValueString(date('d'), "text"),
						 GetSQLValueString(date('m'), "text"),
						 GetSQLValueString(date('Y'), "text"),
						 GetSQLValueString($row_user['user_stafid'], "text"),
						 GetSQLValueString($_POST['transactiontype_id'], "int"),
						 GetSQLValueString($_POST['tansaction_name'], "text"));
  
	mysql_select_db($database_ictdb, $ictdb);
	$Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
	
	$insertGoTo .= "?msg=add";
	
} else {
	$insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>
