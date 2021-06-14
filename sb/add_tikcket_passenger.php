<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php

$insertGoTo = $url_main . "tadbir/ticketdetailadmin.php?id=" . htmlspecialchars($_POST['ticket_id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 10, 57, 2))
{
	if(isset($_POST['user_stafid']))
	{
		if(checkStafID($_POST['user_stafid']))
		{
		  $insertSQL = sprintf("INSERT INTO tadbir.isnpassenger (ip_by, ip_date, ticket_id, user_stafid) VALUES (%s, %s, %s, %s)",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/y h:i:s A'), "text"),
							   GetSQLValueString($_POST['ticket_id'], "int"),
							   GetSQLValueString($_POST['user_stafid'], "text"));
		
		  mysql_select_db($database_tadbirdb, $tadbirdb);
		  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
		  
		  $insertGoTo .= "&msg=add";
		} else {
			$insertGoTo .= "&e=2";
		};
		
	} else {
	  $insertSQL = sprintf("INSERT INTO tadbir.nonisnpassenger (nip_by, nip_date, ticket_id, nip_name, nip_noic, nip_passport, nip_notes) VALUES (%s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d/m/y h:i:s A'), "text"),
						   GetSQLValueString($_POST['ticket_id'], "int"),
						   GetSQLValueString($_POST['nip_name'], "text"),
						   GetSQLValueString($_POST['nip_noic'], "text"),
						   GetSQLValueString($_POST['nip_passport'], "text"),
						   GetSQLValueString($_POST['nip_notes'], "text"));
	
	  mysql_select_db($database_tadbirdb, $tadbirdb);
	  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
		  
	  $insertGoTo .= "&msg=add";
	};
	
} else {
	$insertGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>