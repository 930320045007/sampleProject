<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$insertGoTo = $url_main . "tadbir/ticketdetailadmin.php?id=" . htmlspecialchars($_POST['ticket_id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 10, 57, 2))
{
	$insertSQL = sprintf("INSERT INTO tadbir.travel (ticket_id, travel_from, travel_to, travel_date_d, travel_date_m, travel_date_y, travel_time, travel_note) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
						 GetSQLValueString($_POST['ticket_id'], "int"),
						 GetSQLValueString($_POST['travel_from'], "text"),
						 GetSQLValueString($_POST['travel_to'], "text"),
						 GetSQLValueString($_POST['travel_date_d'], "int"),
						 GetSQLValueString($_POST['travel_date_m'], "int"),
						 GetSQLValueString($_POST['travel_date_y'], "int"),
						 GetSQLValueString($_POST['travel_time'], "text"),
						 GetSQLValueString($_POST['travel_note'], "text"));
	
	mysql_select_db($database_tadbirdb, $tadbirdb);
	$Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
	
	$insertGoTo .= "&msg=add";
	
} else {
	$insertGoTo .= "&eul=1";
}

header(sprintf("Location: %s", $insertGoTo));
?>