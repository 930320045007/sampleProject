<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/sportsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sportsfunc.php');?>
<?php

$insertGoTo = $url_main . "sports/item.php";

if(checkUserSysAcc($row_user['user_stafid'], 19, 102, 2)){
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formitem")) {
		if(isset($_POST['itemnosiri']))
		{
		  foreach($_POST['itemnosiri'] AS $key => $value)
		  {
				$insertSQL = sprintf("INSERT INTO sports.item (item_by, item_date, item_isnsirihi, item_isnsiriyear, item_isnsiri, item_borrow, category_id, subcategory_id, brand_id, item_model, item_nosiri, item_price, item_getdate_d, item_getdate_m, item_getdate_y, item_nofile, item_warranty, warrantytype_id, vendor_id, item_app, item_appby, item_appdate) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
									 GetSQLValueString($row_user['user_stafid'], "text"),
									 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
									 GetSQLValueString($_POST['item_isnsirihi'], "text"),
									 GetSQLValueString($_POST['item_isnsiriyear'], "text"),
									 GetSQLValueString($_POST['item_isnsiri'], "text"),
									 GetSQLValueString($_POST['item_borrow'], "int"),
									 GetSQLValueString($_POST['category_id'], "int"),
									 GetSQLValueString($_POST['subcategory_id'], "int"),
									 GetSQLValueString($_POST['brand_id'], "int"),
									 GetSQLValueString($_POST['item_model'], "text"),
									 GetSQLValueString($value, "text"),
									 GetSQLValueString($_POST['item_price'], "double"),
									 GetSQLValueString($_POST['item_getdate_d'], "text"),
									 GetSQLValueString($_POST['item_getdate_m'], "text"),
									 GetSQLValueString($_POST['item_getdate_y'], "text"),
									 GetSQLValueString($_POST['item_nofile'], "text"),
									 GetSQLValueString($_POST['item_warranty'], "int"),
									 GetSQLValueString($_POST['warrantytype_id'], "int"),
									 GetSQLValueString($_POST['vendor_id'], "text"),
									 GetSQLValueString('1', "int"),
									 GetSQLValueString($row_user['user_stafid'], "text"),
									 GetSQLValueString(date('d/m/Y h:i:s A'), "text"));
			  
				mysql_select_db($database_sportsdb, $sportsdb);
				$Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
			  
				$insertGoTo = $url_main . "sports/item.php?msg=add";
		  };
		} else {
			$insertGoTo = $url_main . "sports/item.php?e=1";
		};
	} else if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formitem")){
				$insertSQL = sprintf("UPDATE sports.item SET item_by=%s, item_date=%s, item_isnsirihi=%s, item_isnsiriyear=%s, item_isnsiri=%s, item_borrow=%s, category_id=%s, subcategory_id=%s, brand_id=%s, item_model=%s, item_nosiri=%s, item_price=%s, item_getdate_d=%s, item_getdate_m=%s, item_getdate_y=%s, item_nofile=%s, item_warranty=%s, warrantytype_id=%s, vendor_id=%s WHERE item_id=%s",
									 GetSQLValueString($row_user['user_stafid'], "text"),
									 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
									 GetSQLValueString($_POST['item_isnsirihi'], "int"),
									 GetSQLValueString($_POST['item_isnsiriyear'], "int"),
									 GetSQLValueString($_POST['item_isnsiri'], "int"),
									 GetSQLValueString($_POST['item_borrow'], "int"),
									 GetSQLValueString($_POST['category_id'], "int"),
									 GetSQLValueString($_POST['subcategory_id'], "int"),
									 GetSQLValueString($_POST['brand_id'], "int"),
									 GetSQLValueString($_POST['item_model'], "text"),
									 GetSQLValueString($_POST['item_nosiri'], "text"),
									 GetSQLValueString($_POST['item_price'], "double"),
									 GetSQLValueString($_POST['item_getdate_d'], "text"),
									 GetSQLValueString($_POST['item_getdate_m'], "text"),
									 GetSQLValueString($_POST['item_getdate_y'], "text"),
									 GetSQLValueString($_POST['item_nofile'], "text"),
									 GetSQLValueString($_POST['item_warranty'], "int"),
									 GetSQLValueString($_POST['warrantytype_id'], "int"),
									 GetSQLValueString($_POST['vendor_id'], "text"),
									 GetSQLValueString($_POST['item_id'], "int"));
			  
				mysql_select_db($database_sportsdb, $sportsdb);
				$Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
			  
				$insertGoTo = $url_main . "sports/itemdetail.php?id=" . $_POST['item_id'] . "&msg=add";
	}
} else {
	$insertGoTo = $url_main . "sports/item.php?eul=1";
};
header(sprintf("Location: %s", $insertGoTo));
?>