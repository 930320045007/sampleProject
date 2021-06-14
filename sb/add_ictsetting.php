<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php

$insertGoTo = $url_main . "ict/setting.php";
if(checkUserSysAcc($row_user['user_stafid'], 6, 32, 2)){
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "brand")) {
  $insertSQL = sprintf("INSERT INTO ict.brand (brand_name) VALUES (%s)",
                       GetSQLValueString($_POST['brand_name'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['brandid'])) && ($_GET['brandid'] != NULL)) {
  $insertSQL = "UPDATE ict.brand SET brand_status = '0' WHERE brand_id='" . $_GET['brandid'] . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "category")) {
  $insertSQL = sprintf("INSERT INTO ict.category (category_name) VALUES (%s)",
                       GetSQLValueString($_POST['category_name'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['categoryid'])) && ($_GET['categoryid'] != NULL)) {
  $insertSQL = "UPDATE ict.category SET category_status = '0' WHERE category_id='" . $_GET['categoryid'] . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "subcategory")) {
  $insertSQL = sprintf("INSERT INTO ict.subcategory (category_id, subcategory_name) VALUES (%s, %s)",
                       GetSQLValueString($_POST['category_id'], "int"),
                       GetSQLValueString($_POST['subcategory_name'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['subcategoryid'])) && ($_GET['subcategoryid'] != NULL)) {
  $insertSQL = "UPDATE ict.subcategory SET subcategory_status = '0' WHERE subcategory_id='" . $_GET['subcategoryid'] . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "feedbacktype")) {
  $insertSQL = sprintf("INSERT INTO ict.feedback_type (feedbacktype_name) VALUES (%s)",
                       GetSQLValueString($_POST['feedbacktype_name'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['fbtypeid'])) && ($_GET['fbtypeid'] != NULL)) {
  $insertSQL = "UPDATE ict.feedback_type SET feedbacktype_status = '0' WHERE feedbacktype_id='" . $_GET['fbtypeid'] . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "itemadd")) {
  $insertSQL = sprintf("INSERT INTO ict.item_add (itemadd_name) VALUES (%s)",
                       GetSQLValueString($_POST['itemadd_name'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['itemaddid'])) && ($_GET['itemaddid'] != NULL)) {
  $insertSQL = "UPDATE ict.item_add SET itemadd_status = '0' WHERE itemadd_id='" . $_GET['itemaddid'] . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "itemos")) {
  $insertSQL = sprintf("INSERT INTO ict.item_os (itemos_name) VALUES (%s)",
                       GetSQLValueString($_POST['itemos_name'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['itemosid'])) && ($_GET['itemosid'] != NULL)) {
  $insertSQL = "UPDATE ict.item_os SET itemos_status = '0' WHERE itemos_id='" . $_GET['itemosid'] . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "itemram")) {
  $insertSQL = sprintf("INSERT INTO ict.item_ram (itemram_name) VALUES (%s)",
                       GetSQLValueString($_POST['itemram_name'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['itemramid'])) && ($_GET['itemramid'] != NULL)) {
  $insertSQL = "UPDATE ict.item_ram SET itemram_status = '0' WHERE itemram_id='" . $_GET['itemramid'] . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "reporttype")) {
  $insertSQL = sprintf("INSERT INTO ict.report_type (reporttype_name) VALUES (%s)",
                       GetSQLValueString($_POST['reporttype_name'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['rtid'])) && ($_GET['rtid'] != NULL)) {
  $insertSQL = "UPDATE ict.report_type SET reporttype_status = '0' WHERE reporttype_id='" . $_GET['rtid'] . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "reportsubtype")) {
  $insertSQL = sprintf("INSERT INTO ict.report_subtype (reporttype_id, reportsubtype_name) VALUES (%s, %s)",
                       GetSQLValueString($_POST['reporttype_id'], "text"),
                       GetSQLValueString($_POST['reportsubtype_name'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['rstid'])) && ($_GET['rstid'] != NULL)) {
  $insertSQL = "UPDATE ict.report_subtype SET reportsubtype_status = '0' WHERE reportsubtype_id='" . $_GET['rstid'] . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "vendortype")) {
  $insertSQL = sprintf("INSERT INTO ict.vendor_type (vendortype_name) VALUES (%s)",
                       GetSQLValueString($_POST['vendortype_name'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['vtid'])) && ($_GET['vtid'] != NULL)) {
  $insertSQL = "UPDATE ict.vendor_type SET vendortype_status = '0' WHERE vendortype_id='" . $_GET['vtid'] . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "servicetype")) {
  $insertSQL = sprintf("INSERT INTO ict.service_type (servicetype_name) VALUES (%s)",
                       GetSQLValueString($_POST['servicetype_name'], "text"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['stid'])) && ($_GET['stid'] != NULL)) {
  $insertSQL = "UPDATE ict.service_type SET servicetype_status = '0' WHERE servicetype_id='" . $_GET['stid'] . "'";
  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}
};
header(sprintf("Location: %s", $insertGoTo));
?>