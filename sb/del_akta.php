<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/aktadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$updateGoTo = $url_main . "head/akta.php";

if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4))
{
  $updateSQL = sprintf("UPDATE ap SET ap_status=0 WHERE ap_id=%s",
                       GetSQLValueString($_GET['id'], "int")); 

  mysql_select_db($database_aktadb, $aktadb);
  $Result1 = mysql_query($updateSQL, $aktadb) or die(mysql_error());

  $updateGoTo .= "?msg=del";
  
} else {
	$updateGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>