<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php  include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='26';?>
<?php
$insertGoTo = $url_main . "ict/itemdetail.php?id=" . htmlspecialchars($_POST['item_id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "component")) 
	{
		if(!checkItemComponentByItemID($_POST['item_id']))
		{
		  $insertSQL = sprintf("INSERT INTO ict.item_component (itemcomponent_by, itemcomponent_date, item_id, itemcomponent_monitor, itemcomponent_hd, itemcomponent_cpu, itemcomponent_ram1, itemcomponent_ram2, itemcomponent_wlan, itemcomponent_ip, itemcomponent_mac, itemcomponent_os, itemcomponent_oskey, itemcomponent_other, itemcomponent_add) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($_POST['item_id'], "int"),
							   GetSQLValueString($_POST['itemcomponent_monitor'], "text"),
							   GetSQLValueString($_POST['itemcomponent_hd'], "text"),
							   GetSQLValueString($_POST['itemcomponent_cpu'], "text"),
							   GetSQLValueString($_POST['itemcomponent_ram1'], "int"),
							   GetSQLValueString($_POST['itemcomponent_ram2'], "text"),
							   GetSQLValueString($_POST['itemcomponent_wlan'], "text"),
							   GetSQLValueString($_POST['itemcomponent_ip'], "text"),
							   GetSQLValueString($_POST['itemcomponent_mac'], "text"),
							   GetSQLValueString($_POST['itemcomponent_os'], "int"),
							   GetSQLValueString($_POST['itemcomponent_oskey'], "text"),
							   GetSQLValueString($_POST['itemcomponent_other'], "text"),
							   GetSQLValueString(implode(",", $_POST['itemcomponent_add']), "text"));
		
		  mysql_select_db($database_ictdb, $ictdb);
		  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
		
		  $insertGoTo .= "&msg=add";
		  
		} else {
		  $insertSQL = sprintf("UPDATE ict.item_component SET itemcomponent_by=%s, itemcomponent_date=%s, itemcomponent_monitor=%s, itemcomponent_hd=%s, itemcomponent_cpu=%s, itemcomponent_ram1=%s, itemcomponent_ram2=%s, itemcomponent_wlan=%s, itemcomponent_ip=%s, itemcomponent_mac=%s, itemcomponent_os=%s, itemcomponent_oskey=%s, itemcomponent_other=%s, itemcomponent_add=%s WHERE item_id=%s",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($_POST['itemcomponent_monitor'], "text"),
							   GetSQLValueString($_POST['itemcomponent_hd'], "text"),
							   GetSQLValueString($_POST['itemcomponent_cpu'], "text"),
							   GetSQLValueString($_POST['itemcomponent_ram1'], "int"),
							   GetSQLValueString($_POST['itemcomponent_ram2'], "text"),
							   GetSQLValueString($_POST['itemcomponent_wlan'], "text"),
							   GetSQLValueString($_POST['itemcomponent_ip'], "text"),
							   GetSQLValueString($_POST['itemcomponent_mac'], "text"),
							   GetSQLValueString($_POST['itemcomponent_os'], "int"),
							   GetSQLValueString($_POST['itemcomponent_oskey'], "text"),
							   GetSQLValueString($_POST['itemcomponent_other'], "text"),
							   GetSQLValueString(implode(",", $_POST['itemcomponent_add']), "text"),
							   GetSQLValueString($_POST['item_id'], "int"));
		
		  mysql_select_db($database_ictdb, $ictdb);
		  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
		
		  $insertGoTo .= "&msg=edit";
		};
		
	} else {
		$insertGoTo .= "&msg=error";
	};
	
} else {
	$insertGoTo .= "&eul=1";
};


header(sprintf("Location: %s", $insertGoTo));
?>