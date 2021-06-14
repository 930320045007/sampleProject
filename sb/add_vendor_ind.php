<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$insertGoTo = $url_main . "ict/vendorview.php";

if (checkUserSysAcc($row_user['user_stafid'], 6, 31, 2) && (isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
{
  $insertSQL = sprintf("INSERT INTO ict.vendor_ind (vendorind_by, vendorind_date, vendor_id, vendorind_name, vendorind_email, vendorind_notel) VALUES (%s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['vendor_id'], "int"),
					   GetSQLValueString($_POST['vendorind_name'], "text"),
					   GetSQLValueString($_POST['vendorind_email'], "text"),
					   GetSQLValueString($_POST['vendorind_notel'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());

  $insertGoTo .= "?id=" . htmlspecialchars($_POST['vendor_id'], ENT_QUOTES) . "&msg=add";
  
} else if (checkUserSysAcc($row_user['user_stafid'], 6, 31, 4) && isset($_GET['vindid']) && $_GET['vindid']!=NULL) {
	
  $insertSQL = "UPDATE ict.vendor_ind SET vendorind_status = 0 WHERE vendorind_id='" . htmlspecialchars($_GET['vindid'], ENT_QUOTES) . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());

  $insertGoTo .= "?id=" . htmlspecialchars($_GET['vindid'], ENT_QUOTES) . "&msg=del";
  
} else {
	$insertGoTo = $url_main . "ict/vendor.php?msg=error";
};

header(sprintf("Location: %s", $insertGoTo));
?>