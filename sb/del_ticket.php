<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$insertGoTo = $url_main . "tadbir/ticketadmin.php";

	  $insertSQL = sprintf("UPDATE tadbir.ticket SET ticket_status='0' WHERE ticket_id=%s",
									   GetSQLValueString($_GET['id'], "int"));
				
	  mysql_select_db($database_tadbirdb, $tadbirdb);
	  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
	
	  $insertGoTo .= "?msg=del";

header(sprintf("Location: %s", $insertGoTo));
?>