<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$deleteGoTo = $url_main . "profile.php";

if ((isset($_GET['deldep'])) && ($_GET['deldep'] != ""))
{
	if(getDelDependents($_GET['deldep'])==$row_user['user_stafid'])
	{
	  $deleteSQL = sprintf("UPDATE user_dependents SET userdependents_status = '0' WHERE userdependents_id=%s",
						   GetSQLValueString($_GET['deldep'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	
	  $deleteGoTo .= "?msg=del#dep2";
	  
	} else {
	  $deleteGoTo .= "?del=1#dep2";
	};
	
} else {
	$deleteGoTo .= "?msg=error#dep2";
};

header(sprintf("Location: %s", $deleteGoTo));
?>