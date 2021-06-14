<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/sportsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sportsfunc.php');?>
<?php
$insertGoTo = $url_main . "sports/vendor.php";

if(checkUserSysAcc($row_user['user_stafid'], 19, 106, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
	{
	  $insertSQL = sprintf("INSERT INTO vendor (vendortype_id, vendor_name, vendor_add, vendor_notel,vendor_nofax, vendor_email, vendor_web) VALUES (%s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['vendortype_id'], "int"),
						   GetSQLValueString($_POST['vendor_name'], "text"),
						   GetSQLValueString($_POST['vendor_add'], "text"),
						   GetSQLValueString($_POST['vendor_notel'], "text"),
						   GetSQLValueString($_POST['vendor_nofax'], "text"),
						   GetSQLValueString($_POST['vendor_email'], "text"),
						   GetSQLValueString($_POST['vendor_web'], "text"));
	
	  mysql_select_db($database_sportsdb, $sportsdb);
	  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
	
	  $insertGoTo .= "?msg=add";
	  
	} else if (checkUserSysAcc($row_user['user_stafid'], 19, 106, 3) && (isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
		
	  $insertSQL = sprintf("UPDATE sports.vendor SET vendortype_id=%s, vendor_name=%s, vendor_add=%s, vendor_notel=%s,vendor_nofax=%s, vendor_email=%s, vendor_web=%s WHERE vendor_id=%s",
						   GetSQLValueString($_POST['vendortype_id'], "int"),
						   GetSQLValueString($_POST['vendor_name'], "text"),
						   GetSQLValueString($_POST['vendor_add'], "text"),
						   GetSQLValueString($_POST['vendor_notel'], "text"),
						   GetSQLValueString($_POST['vendor_nofax'], "text"),
						   GetSQLValueString($_POST['vendor_email'], "text"),
						   GetSQLValueString($_POST['vendor_web'], "text"),
						   GetSQLValueString($_POST['vendor_id'], "int"));
	  mysql_select_db($database_sportsdb, $sportsdb);
	  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
	
	  $insertGoTo .= "?msg=edit";
	  
	} else if (checkUserSysAcc($row_user['user_stafid'], 19, 106, 4) && isset($_GET['vid']) && $_GET['vid']!=NULL) {
		
	  $insertSQL = "UPDATE sports.vendor SET vendor_status = 0 WHERE vendor_id='" . htmlspecialchars($_GET['vid'], ENT_QUOTES) . "'";
	  mysql_select_db($database_sportsdb, $sportsdb);
	  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
	
	  $insertGoTo .= "?msg=del";
	  
	} else {
		$insertGoTo .= "?msg=error";
	};
	
} else {
	$insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>