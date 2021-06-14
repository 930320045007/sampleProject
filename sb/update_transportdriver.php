<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$updateGoTo = $url_main . "tadbir/admintransportdetail.php";

if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {

	$updateSQL = sprintf("UPDATE transdriver SET transport_id=%s, driver_id=%s WHERE transdriver_id=%s",

	  					 GetSQLValueString($_POST['transport1'], "int"),
						 GetSQLValueString($_POST['driver1'], "int"),
					     GetSQLValueString($_POST['transdriver_id'], "int"));
						
	mysql_select_db($database_tadbirdb, $tadbirdb);
	$Result = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
   $updateGoTo .=  "?msg=add&cid=" . htmlspecialchars($_POST['transport1'],ENT_QUOTES);
	}
}

header(sprintf("Location: %s", $updateGoTo));
?>