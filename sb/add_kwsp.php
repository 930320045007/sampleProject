<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$insertGoTo = $url_main . "admin/transaction.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 35, 2))
{
	if ((isset($_POST["MM_insert_kwsp"])) && ($_POST["MM_insert_kwsp"] == "forminkwsp")) 
	{
	  $insertSQL = sprintf("INSERT INTO kwsp (kwsp_date_d, kwsp_date_m, kwsp_date_y, kwsp_by, kwsp_min, kwsp_max, kwsp_oneemp, kwsp_onestaf, kwsp_type) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['kwsp_date_d'], "text"),
						   GetSQLValueString($_POST['kwsp_date_m'], "text"),
						   GetSQLValueString($_POST['kwsp_date_y'], "text"),
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString($_POST['kwsp_min'], "double"),
						   GetSQLValueString($_POST['kwsp_max'], "double"),
						   GetSQLValueString($_POST['kwsp_oneemp'], "double"),
						   GetSQLValueString($_POST['kwsp_onestaf'], "double"),
						   GetSQLValueString($_POST['kwsp_type'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $insertGoTo .= "?msg=add#kwsp";
	} else {
		$insertGoTo .= "?msg=error#kwsp";
	};
	
} else {
	$insertGoTo .= "?eul=1#kwsp";
};

header(sprintf("Location: %s", $insertGoTo));
?>