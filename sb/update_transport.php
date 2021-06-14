<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$updateGoTo = $url_main . "tadbir/transportlist.php";

if(checkUserSysAcc($row_user['user_stafid'], 10, 81, 3)){
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	  $updateSQL = sprintf("UPDATE transport SET transporttype_id=%s, transport_name=%s, transport_plat=%s WHERE transport_id=%s",
						   GetSQLValueString($_POST['transporttype_id'], "int"),
						   GetSQLValueString($_POST['transport_name'], "text"),
						   GetSQLValueString($_POST['transport_noplat'], "text"),
						   GetSQLValueString($_POST['transport_id'], "int"));
	
	  mysql_select_db($database_tadbirdb, $tadbirdb);
	  $Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
	  
	  $updateGoTo .= "?msg=add&tyid=" . $_POST['transporttype_id'];
	}
}

header(sprintf("Location: %s", $updateGoTo));
?>