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
	  $updateSQL = sprintf("UPDATE ticket SET ticket_invupdateby=%s, ticket_invupdatedate=%s, ticket_invdate_d=%s, ticket_invdate_m=%s, ticket_invdate_y=%s, fly_type=%s, agensi_id=%s, ticket_type=%s, ticket_typeref=%s, ticket_invref=%s, ticket_invcost=%s, ticket_invnote=%s WHERE ticket_id=%s",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['ticket_invdate_d'], "text"),
						   GetSQLValueString($_POST['ticket_invdate_m'], "text"),
						   GetSQLValueString($_POST['ticket_invdate_y'], "text"),
						   GetSQLValueString($_POST['fly_type'], "int"),
						   GetSQLValueString($_POST['agensi_id'], "int"),
						   GetSQLValueString($_POST['ticket_type'], "int"),
						   GetSQLValueString($_POST['ticket_typeref'], "text"),
						   GetSQLValueString($_POST['ticket_invref'], "text"),
						   GetSQLValueString($_POST['ticket_invcost'], "text"),
						   GetSQLValueString($_POST['ticket_invnote'], "text"),
						   GetSQLValueString($_POST['ticket_id'], "int"));
	
	  mysql_select_db($database_tadbirdb, $tadbirdb);
	  $Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
	  
	  $updateGoTo .= "&msg=edit";

	  $query_isnp = "SELECT user_stafid FROM tadbir.isnpassenger WHERE ip_status = 1 AND ticket_id = '" . htmlspecialchars($_POST['ticket_id'], ENT_QUOTES) . "' ORDER BY ip_id ASC";	
	  $user_isnp = mysql_query($query_isnp);
	  $row_isnp = mysql_fetch_assoc($user_isnp);
	  $total_isnp = mysql_num_rows($user_isnp);
	  
	  $emailto = array();
	  $emailto[] = getTiketBy(htmlspecialchars($_POST['ticket_id'], ENT_QUOTES));
	  
	  if($total_isnp > 0)
	  {
		  do{
			  $emailto[] = $row_isnp['user_stafid'];
		  }while($row_isnp = mysql_fetch_assoc($user_isnp));
	  };
	  
	  mysql_free_result($user_isnp);
	  
	  $emailto = array_merge($emailto,getUserIDSysAcc(10, 57));
	  
	  emailInvTicket($emailto, 0, 0, 1, htmlspecialchars($_POST['ticket_id'], ENT_QUOTES));
	  
	} else {
		$updateGoTo .= "&msg=error";
	};
	
} else {
	$updateGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>