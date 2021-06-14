<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php
$updateGoTo = $url_main . "harta/item.php";

if(checkUserSysAcc($row_user['user_stafid'], 12, 50, 4))
{
	 $updateSQL = sprintf("UPDATE item SET item_status=0 WHERE item_id=%s AND category_id=%s",
						   GetSQLValueString($_GET['itemid'], "int"),
						   GetSQLValueString($_GET['cat'], "int")); 
	
	  mysql_select_db($database_hartadb, $hartadb);
	  $Result1 = mysql_query($updateSQL, $hartadb) or die(mysql_error());
	
	  $updateGoTo .= "?msg=del&cat=" . htmlspecialchars($_GET['cat'], ENT_QUOTES);
	  
} else {
	$updateGoTo .= "?eul=1&cat=" . htmlspecialchars($_GET['cat'], ENT_QUOTES);
};

header(sprintf("Location: %s", $updateGoTo));
?>