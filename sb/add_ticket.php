<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php include('../sb/email.php');?>
<?php

  $status = 0; 
  $status2 = 0; 

  $_SESSION['from'] = NULL;
  unset($_SESSION['from']);
  
  $_SESSION['to'] = NULL;
  unset($_SESSION['to']);
  
  $_SESSION['dated'] = NULL;
  unset($_SESSION['dated']);
  
  $_SESSION['datem'] = NULL;
  unset($_SESSION['datem']);
  
  $_SESSION['datey'] = NULL;
  unset($_SESSION['datey']);
  
  $_SESSION['dateh'] = NULL;
  unset($_SESSION['dateh']);
  
  $_SESSION['stafidt'] = NULL;
  unset($_SESSION['stafidt']);
  
  $_SESSION['name'][] = NULL;
  unset($_SESSION['name']);
  
  $_SESSION['ic'][] = NULL;
  unset($_SESSION['ic']);
  
  $_SESSION['pp'][] = NULL;
  unset($_SESSION['pp']);
  
  $_SESSION['ct'][] = NULL;
  unset($_SESSION['ct']);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
{
	
	if((isset($_POST['tfrom']) && count($_POST['tfrom'])>0) && (isset($_POST['isnp']) && count($_POST['isnp'])>0))
	{
	
		$insertSQL = sprintf("INSERT INTO tadbir.ticket (ticket_by, ticket_date_d, ticket_date_m, ticket_date_y, ticket_date_h, tickettype_id, ticket_title, ticket_ref, ticket_bagasi, ticket_insuran, ticket_visa) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							 GetSQLValueString($row_user['user_stafid'], "text"),
							 GetSQLValueString(date('d'), "text"),
							 GetSQLValueString(date('m'), "text"),
							 GetSQLValueString(date('Y'), "text"),
							 GetSQLValueString(date('h:i:s A'), "text"),
							 GetSQLValueString($_POST['tickettype_id'], "int"),
							 GetSQLValueString($_POST['ticket_title'], "text"),
							 GetSQLValueString($_POST['ticket_ref'], "text"),
							 GetSQLValueString($_POST['ticket_bagasi'], "int"),
							 GetSQLValueString($_POST['ticket_insuran'], "int"),
							 GetSQLValueString($_POST['ticket_visa'], "int"));
	  
		mysql_select_db($database_tadbirdb, $tadbirdb);
		$Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
		
		$ticketID = getTiketID($row_user['user_stafid'], date('d'), date('m'), date('Y'));
	
		if(isset($_POST['tfrom']) && count($_POST['tfrom'])!=0)
		{
			foreach($_POST['tfrom'] AS $key => $value)
			{
			  $insertSQL = sprintf("INSERT INTO tadbir.travel (ticket_id, travel_from, travel_to, travel_date_d, travel_date_m, travel_date_y, travel_time) VALUES (%s, %s, %s, %s, %s, %s, %s)",
								   GetSQLValueString($ticketID, "int"),
								   GetSQLValueString($value, "text"),
								   GetSQLValueString($_POST['tto'][$key], "text"),
								   GetSQLValueString($_POST['td'][$key], "int"),
								   GetSQLValueString($_POST['tm'][$key], "int"),
								   GetSQLValueString($_POST['ty'][$key], "int"),
								   GetSQLValueString($_POST['th'][$key], "text"));
			
			  mysql_select_db($database_tadbirdb, $tadbirdb);
			  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
			};
		};
	
		if(isset($_POST['isnp']) && count($_POST['isnp'])!=0)
		{
			foreach($_POST['isnp'] AS $key => $value)
			{
			  $insertSQL = sprintf("INSERT INTO tadbir.isnpassenger (ticket_id, user_stafid) VALUES (%s, %s)",
								   GetSQLValueString($ticketID, "int"),
								   GetSQLValueString($value, "text"));
			
			  mysql_select_db($database_tadbirdb, $tadbirdb);
			  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
			};
		};
	
		if(isset($_POST['nispname']) && count($_POST['nispname'])!=0)
		{
			foreach($_POST['nispname'] AS $key => $value)
			{
			  $insertSQL = sprintf("INSERT INTO tadbir.nonisnpassenger (ticket_id, nip_name, nip_noic, nip_passport, nip_notes) VALUES (%s, %s, %s, %s, %s)",
								   GetSQLValueString($ticketID, "int"),
								   GetSQLValueString($value, "text"),
								   GetSQLValueString($_POST['nispic'][$key], "text"),
								   GetSQLValueString($_POST['nisppp'][$key], "text"),
								   GetSQLValueString($_POST['nispnote'][$key], "text"));
			
			  mysql_select_db($database_tadbirdb, $tadbirdb);
			  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
			};
		};
		
		$emailto = array();
		$emailto[] = $row_user['user_stafid'];
		$emailto = array_merge($emailto,getUserIDSysAcc(10, 57));
		
		emailNewTicket($emailto, 0, 0, 1, $ticketID);
		
		$insertGoTo = $url_main . "tadbir/ticketdetail.php?id=" . $ticketID . "&msg=add";
		
	} else {
		$insertGoTo = $url_main . "tadbir/ticket.php?etic=1";
	};
	
} else {
	$insertGoTo = $url_main . "tadbir/ticket.php?msg=error";
};

header(sprintf("Location: %s", $insertGoTo));
?>