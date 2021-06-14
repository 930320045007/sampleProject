<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/sportsdb.php'); ?>
<?php  include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sportsfunc.php');?>
<?php $menu='19';?>
<?php $menu2='102';?>
<?php
$insertGoTo = $url_main . "sports/itemdetail.php?id=" . $_POST['item_id'];
if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "component")) {
		if(!checkItemComponentByItemID($_POST['item_id'])){
		  $insertSQL = sprintf("INSERT INTO sports.item_component (itemcomponent_by, itemcomponent_date, item_id, itemcomponent_other, itemcomponent_add) VALUES (%s, %s, %s, %s, %s)",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($_POST['item_id'], "int"),
							   
							   GetSQLValueString($_POST['itemcomponent_other'], "text"),
							   GetSQLValueString(implode(",", $_POST['itemcomponent_add']), "text"));
		
		  mysql_select_db($database_sportsdb, $sportsdb);
		  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
		
		  $insertGoTo .= "&msg=add";
		} else {
		  $insertSQL = sprintf("UPDATE sports.item_component SET itemcomponent_by=%s, itemcomponent_date=%s, itemcomponent_other=%s, itemcomponent_add=%s WHERE item_id=%s",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($_POST['itemcomponent_other'], "text"),
							   GetSQLValueString(implode(",", $_POST['itemcomponent_add']), "text"),
							   GetSQLValueString($_POST['item_id'], "int"));
		
		  mysql_select_db($database_sportsdb, $sportsdb);
		  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
		
		  $insertGoTo .= "&msg=edit";
		}
	} else {
		$insertGoTo .= "&msg=error";
	}
} else {
	$insertGoTo .= "&eul=1";
}

header(sprintf("Location: %s", $insertGoTo));
?>