<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php

$updateGoTo = $url_main . "tadbir/adminmaintenancedetail.php?id=" . htmlspecialchars($_POST['maintenance_id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 10, 86, 3))
{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
	{
		  $updateSQL = sprintf("UPDATE maintenance SET maintenance_adminby=%s, maintenance_admindate=%s, maintenance_adminnote=%s, maintenance_adminstatus=%s WHERE maintenance_id=%s",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($_POST['maintenance_adminnote'], "text"),
							   GetSQLValueString($_POST['maintenance_adminstatus'], "int"),
							   GetSQLValueString($_POST['maintenance_id'], "int"));
		
		  mysql_select_db($database_tadbirdb, $tadbirdb);
		  $Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
		  
		  $updateGoTo .= "&msg=edit";
	  
	} else {
		$updateGoTo .= "&msg=error";
	};
	
} else {
	$updateGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>