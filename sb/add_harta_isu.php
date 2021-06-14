<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php
$insertGoTo = $url_main . "harta/isu.php";

if(checkUserSysAcc($row_user['user_stafid'], 12, 45, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "isu")) 
	{
	  $insertSQL = sprintf("INSERT INTO harta.report_case (rc_by, rc_date_d, rc_date_m, rc_date_y, rc_date_h, subcategory_id, rc_title) VALUES (%s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d'), "text"),
						   GetSQLValueString(date('m'), "text"),
						   GetSQLValueString(date('Y'), "text"),
						   GetSQLValueString(date('h:i:s A'), "text"),
						   GetSQLValueString($_POST['subcategory_id'], "int"),
						   GetSQLValueString($_POST['rc_title'], "text"));
	
	  mysql_select_db($database_hartadb, $hartadb);
	  $Result1 = mysql_query($insertSQL, $hartadb) or die(mysql_error());
	  
	  $insertGoTo .= "?msg=add&category_id=" . getCategoryIDBySubCategoryID($_POST['subcategory_id']) ."&subcategory_id=" . htmlspecialchars($_POST['subcategory_id'], ENT_QUOTES) . "";
	};
	
} else {
	$insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>