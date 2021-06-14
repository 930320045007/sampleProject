<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$insertGoTo = $url_main . "admin/transaction.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 35, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "forminkelab")) 
	{
	  $insertSQL = sprintf("INSERT INTO club (club_date_d, club_date_m, club_date_y, club_by, club_note, club_min, club_max, club_oneemp, club_onestaf) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['club_date_d'], "text"),
						   GetSQLValueString($_POST['club_date_m'], "text"),
						   GetSQLValueString($_POST['club_date_y'], "text"),
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString($_POST['club_note'], "text"),
						   GetSQLValueString($_POST['club_min'], "double"),
						   GetSQLValueString($_POST['club_max'], "double"),
						   GetSQLValueString($_POST['club_oneemp'], "double"),
						   GetSQLValueString($_POST['club_onestaf'], "double"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $insertGoTo .= "?msg=add#kelab";
	} else {
		$insertGoTo .= "?msg=error#kelab";
	};
} else {
	$insertGoTo .= "?eul=1#kelab";
};

header(sprintf("Location: %s", $insertGoTo));
?>