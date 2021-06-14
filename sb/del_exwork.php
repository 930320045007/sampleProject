<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$deleteGoTo = $url_main . "profile.php";

if ((isset($_GET['delexwork'])) && ($_GET['delexwork'] != ""))
{
	if(getDelExwork($_GET['delexwork'])==$row_user['user_stafid'])
	{
	  $deleteSQL = sprintf("UPDATE user_exwork SET userexwork_status = '0' WHERE userexwork_id=%s",
						   GetSQLValueString($_GET['delexwork'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	
	  $deleteGoTo .= "?msg=del#exwork2";
	} else {
	  $deleteGoTo .= "?del=1#exwork2";
	};
  
} else {
	$deleteGoTo .= "?msg=error#exwork2";
};

header(sprintf("Location: %s", $deleteGoTo));
?>