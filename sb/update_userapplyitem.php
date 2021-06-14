<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$deleteGoTo = $url_main . "ict/applyadmindetail.php?id=" .$_POST['userapply_id'] ."&uaid=" .$_POST['uai_id'];

if(checkUserSysAcc($row_user['user_stafid'], 10, 81, 3)){
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$deleteSQL = sprintf("UPDATE ict.user_applyitem SET applystatus_id=%s, ict_by=%s, ict_date=%s, ict_note=%s WHERE uai_id=%s",
						 GetSQLValueString($_POST['ict_status'], "text"),
						 GetSQLValueString($row_user['user_stafid'], "text"),
						 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						 GetSQLValueString($_POST['ict_note'], "text"),
						 GetSQLValueString($_POST['uai_id'], "int"));
  
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());	
}
  $deleteGoTo .= "&msg=edit";
  } else {
		$deleteGoTo .= "?eul=1";
	};

header(sprintf("Location: %s", $deleteGoTo));
?>