<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$deleteGoTo = $url_main . "tadbir/admintransport.php";

	if(isset($_GET['deltrans']) && checkUserSysAcc($row_user['user_stafid'], 10, 81, 4)){
	  $deleteSQL = sprintf("UPDATE tadbir.transport_book SET transbook_status = '0' WHERE transbook_id=%s",
						   GetSQLValueString($_GET['deltrans'], "int"));
	
	  mysql_select_db($database_tadbirdb, $tadbirdb);
	  $Result1 = mysql_query($deleteSQL, $tadbirdb) or die(mysql_error());
	
	 
  		$deleteGoTo .= "?msg=del";
	}
	
	else {
	$deleteGoTo .= "?del=1";
}
header(sprintf("Location: %s", $deleteGoTo));
?>