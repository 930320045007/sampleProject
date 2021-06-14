<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/sportsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sportsfunc.php');?>
<?php

$insertGoTo = $url_main . "sports/setting.php";
if(checkUserSysAcc($row_user['user_stafid'], 19, 104, 2)){
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "brand")) {
  $insertSQL = sprintf("INSERT INTO sports.brand (brand_name) VALUES (%s)",
                       GetSQLValueString($_POST['brand_name'], "text"));

  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['brandid'])) && ($_GET['brandid'] != NULL)) {
  $insertSQL = "UPDATE sports.brand SET brand_status = '0' WHERE brand_id='" . $_GET['brandid'] . "'";
  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "category")) {
  $insertSQL = sprintf("INSERT INTO sports.category (category_name) VALUES (%s)",
                       GetSQLValueString($_POST['category_name'], "text"));

  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['categoryid'])) && ($_GET['categoryid'] != NULL)) {
  $insertSQL = "UPDATE sports.category SET category_status = '0' WHERE category_id='" . $_GET['categoryid'] . "'";
  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "subcategory")) {
  $insertSQL = sprintf("INSERT INTO sports.subcategory (category_id, subcategory_name) VALUES (%s, %s)",
                       GetSQLValueString($_POST['category_id'], "int"),
                       GetSQLValueString($_POST['subcategory_name'], "text"));

  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['subcategoryid'])) && ($_GET['subcategoryid'] != NULL)) {
  $insertSQL = "UPDATE sports.subcategory SET subcategory_status = '0' WHERE subcategory_id='" . $_GET['subcategoryid'] . "'";
  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "itemadd")) {
  $insertSQL = sprintf("INSERT INTO sports.item_add (itemadd_name) VALUES (%s)",
                       GetSQLValueString($_POST['itemadd_name'], "text"));

  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['itemaddid'])) && ($_GET['itemaddid'] != NULL)) {
  $insertSQL = "UPDATE sports.item_add SET itemadd_status = '0' WHERE itemadd_id='" . $_GET['itemaddid'] . "'";
  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "vendortype")) {
  $insertSQL = sprintf("INSERT INTO sports.vendor_type (vendortype_name) VALUES (%s)",
                       GetSQLValueString($_POST['vendortype_name'], "text"));

  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['vtid'])) && ($_GET['vtid'] != NULL)) {
  $insertSQL = "UPDATE sports.vendor_type SET vendortype_status = '0' WHERE vendortype_id='" . $_GET['vtid'] . "'";
  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "servicetype")) {
  $insertSQL = sprintf("INSERT INTO sports.service_type (servicetype_name) VALUES (%s)",
                       GetSQLValueString($_POST['servicetype_name'], "text"));

  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}

if ((isset($_GET['stid'])) && ($_GET['stid'] != NULL)) {
  $insertSQL = "UPDATE sports.service_type SET servicetype_status = '0' WHERE servicetype_id='" . $_GET['stid'] . "'";
  mysql_select_db($database_sportsdb, $sportsdb);
  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}
};
header(sprintf("Location: %s", $insertGoTo));
?>