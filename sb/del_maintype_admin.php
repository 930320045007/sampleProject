<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$deleteGoTo = $url_main . "tadbir/adminmaintenancedetail.php?id=" .getMaintenanceIDByMainTypeID(htmlspecialchars($_GET['mtid'],ENT_QUOTES));

if(checkUserSysAcc($row_user['user_stafid'], 10, 86, 4))
{	
	
						$deleteSQL = sprintf("UPDATE tadbir.maintenance_normalize SET mainnormalize_status = '0' WHERE  maintenancetype_id=%s",
						
						GetSQLValueString($_GET['mtid'], "int"));
	
						  mysql_select_db($database_tadbirdb, $tadbirdb);
						  $Result = mysql_query($deleteSQL, $tadbirdb) or die(mysql_error());

  $deleteGoTo .= "&msg=del";
	  
} else {
  $deleteGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $deleteGoTo));

?>