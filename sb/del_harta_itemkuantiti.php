<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php
$updateGoTo = $url_main . "harta/itemadd.php";

if(checkUserSysAcc($row_user['user_stafid'], 12, 50, 4))
{
	 $updateSQL = sprintf("UPDATE item_stock SET itemstock_status=0 WHERE itemstock_id=%s AND item_id=%s",
						   GetSQLValueString($_GET['id'], "int"),
						   GetSQLValueString($_GET['itemid'], "int")); 
	
	  mysql_select_db($database_hartadb, $hartadb);
	  $Result1 = mysql_query($updateSQL, $hartadb) or die(mysql_error());
	
	  $updateGoTo .= "?id=" . htmlspecialchars($_GET['itemid'], ENT_QUOTES) . "&msg=del";
	  
} else {
	$updateGoTo .= "?id=" . htmlspecialchars($_GET['itemid'], ENT_QUOTES) . "&eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>