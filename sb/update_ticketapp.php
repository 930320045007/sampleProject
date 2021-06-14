<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php include('../sb/email.php');?>
<?php

$updateGoTo = $url_main . "tadbir/ticketdetailadmin.php?id=" . htmlspecialchars($_POST['ticket_id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 10, 57, 3))
{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
	{
		  $updateSQL = sprintf("UPDATE ticket SET ticket_appupdateby=%s, ticket_appupdatedate=%s, ticket_app=%s, ticket_appby=%s, ticket_appdate_d=%s, ticket_appdate_m=%s, ticket_appdate_y=%s, ticket_appnote=%s WHERE ticket_id=%s",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($_POST['ticket_app'], "int"),
							   GetSQLValueString($_POST['ticket_appby'], "text"),
							   GetSQLValueString($_POST['ticket_appdate_d'], "text"),
							   GetSQLValueString($_POST['ticket_appdate_m'], "text"),
							   GetSQLValueString($_POST['ticket_appdate_y'], "text"),
							   GetSQLValueString($_POST['ticket_appnote'], "text"),
							   GetSQLValueString($_POST['ticket_id'], "int"));
		
		  mysql_select_db($database_tadbirdb, $tadbirdb);
		  $Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
		  
		  $updateGoTo .= "&msg=edit";
		  
		  $emailto = array();
		  $emailto[] = getTiketBy(htmlspecialchars($_POST['ticket_id'], ENT_QUOTES));
		  $emailto = array_merge($emailto,getUserIDSysAcc(10, 57));
		  emailAppTicket($emailto, 0, 0, 1, $_POST['ticket_id']);
	  
	} else {
		$updateGoTo .= "&msg=error";
	};
	
} else {
	$updateGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>