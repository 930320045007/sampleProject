<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$deleteGoTo = $url_main . "admin/staffleavedetail.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 23, 4))
{
	if ((isset($_GET['delgcr'])) && ($_GET['delgcr'] != ""))
	{
	  $deleteSQL = sprintf("UPDATE user_gcr SET uspgcr_status = '0' WHERE uspgcr_id=%s",
						   GetSQLValueString($_GET['delgcr'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	
	  $deleteGoTo .= "?msg=del&id=" . htmlspecialchars($_GET['uid'], ENT_QUOTES);
	
	} else {
	  $deleteGoTo .= "?msg=error&id=" . htmlspecialchars($_GET['uid'], ENT_QUOTES);
	};
	
} else {
	  $deleteGoTo .= "?del=1&id=" . htmlspecialchars($_GET['uid'], ENT_QUOTES);
};

header(sprintf("Location: %s", $deleteGoTo));
?>