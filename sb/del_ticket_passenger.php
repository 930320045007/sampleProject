<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
if(checkUserSysAcc($row_user['user_stafid'], 10, 57, 4))
{
	if(isset($_GET['ip']))
	{
	  $deleteSQL = sprintf("UPDATE tadbir.isnpassenger SET ip_status = '0' WHERE ip_id=%s",
						   GetSQLValueString($_GET['ip'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	  
	  $deleteGoTo = $url_main . "tadbir/ticketdetailadmin.php?id=" . htmlspecialchars($_GET['id'], ENT_QUOTES) . "&msg=del";
	  
	} else if(isset($_GET['nip'])) {
		
	  $deleteSQL = sprintf("UPDATE tadbir.nonisnpassenger SET nip_status = '0' WHERE nip_id=%s",
						   GetSQLValueString($_GET['nip'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	  
	  $deleteGoTo = $url_main . "tadbir/ticketdetailadmin.php?id=" . htmlspecialchars($_GET['id'], ENT_QUOTES) . "&msg=del";
	  
	};
	  
} else {
  $deleteGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $deleteGoTo));

?>