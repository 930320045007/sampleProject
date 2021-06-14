<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$insertGoTo = $url_main . "admin/transaction.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 35, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "forminperkeso")) 
	{
	  $insertSQL = sprintf("INSERT INTO perkeso (perkeso_date_d, perkeso_date_m, perkeso_date_y, perkeso_by, perkeso_note, perkeso_min, perkeso_max, perkeso_oneemp, perkeso_onestaf, perkeso_twoemp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['perkeso_date_d'], "text"),
						   GetSQLValueString($_POST['perkeso_date_m'], "text"),
						   GetSQLValueString($_POST['perkeso_date_y'], "text"),
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString($_POST['perkeso_note'], "text"),
						   GetSQLValueString($_POST['perkeso_min'], "double"),
						   GetSQLValueString($_POST['perkeso_max'], "double"),
						   GetSQLValueString($_POST['perkeso_oneemp'], "double"),
						   GetSQLValueString($_POST['perkeso_onestaf'], "double"),
						   GetSQLValueString($_POST['perkeso_twoemp'], "double"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $insertGoTo .= "?msg=add#perkeso";
	} else {
		$insertGoTo .= "?msg=error#perkeso";
	};
	
} else {
	$insertGoTo .= "?eul=1#perkeso";
};

header(sprintf("Location: %s", $insertGoTo));
?>