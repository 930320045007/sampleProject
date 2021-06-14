<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$updateGoTo = $url_main . "admin/head.php";
		
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formhead")) 
{
	if(checkStafID($_POST['user_stafid']))
	{
	  $updateSQL = sprintf("UPDATE dir SET user_stafid=%s WHERE dir_id=%s",
						   GetSQLValueString($_POST['user_stafid'], "text"),
						   GetSQLValueString($_POST['dir_id'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
	  
	  $updateGoTo .= "?msg=add";
	} else {
		$updateGoTo .= "?e=2";
	};
	
} else {
	$updateGoTo .= "?msg=error";
};

header(sprintf("Location: %s", $updateGoTo));
?>