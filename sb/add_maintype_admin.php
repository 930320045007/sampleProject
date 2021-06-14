<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$insertGoTo = $url_main . "tadbir/adminmaintenancedetail.php?id=" . htmlspecialchars($_POST['maintenance_id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 10, 86, 2))
{		
			 foreach($_POST['jp'] AS $key => $value)
			  {
				  if($value != 0)
				  {
						$insertSQL = sprintf("INSERT INTO maintenance_normalize (maintenance_id, maintenancetype_id) VALUES (%s, %s)",
											   GetSQLValueString($_POST['maintenance_id'], "int"),
											   GetSQLValueString($value, "int"));
						
						  mysql_select_db($database_tadbirdb, $tadbirdb);
						  $Result2 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
 
				  }
			  }
	
	$insertGoTo = $url_main . "tadbir/adminmaintenancedetail.php?id=" . $_POST['maintenance_id'] . "&msg=add";
	
} else {
	$insertGoTo .= "&eul=1";
}

header(sprintf("Location: %s", $insertGoTo));
?>