<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$insertGoTo = $url_main . "admin/setting.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "marital_submit")) {
  $insertSQL = sprintf("INSERT INTO marital (marital_by, marital_date, marital_name) VALUES (%s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['marital_name'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['maid'])) && ($_GET['maid'] != NULL)) {
  $insertSQL = "UPDATE www.marital SET marital_status = '0' WHERE marital_id='" . $_GET['maid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "rel_submit")) {
  $insertSQL = sprintf("INSERT INTO relationship (relationship_by, relationship_date, relationship_name) VALUES (%s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['relationship_name'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['rid'])) && ($_GET['rid'] != NULL)) {
  $insertSQL = "UPDATE www.relationship SET relationship_status = '0' WHERE relationship_id='" . $_GET['rid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "katmaj_submit")) {
  $insertSQL = sprintf("INSERT INTO employer_type (employertype_by, employertype_date, employertype_name) VALUES (%s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['employertype_name'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['mid'])) && ($_GET['mid'] != NULL)) {
  $insertSQL = "UPDATE www.employer_type SET employertype_status = '0' WHERE employertype_id='" . $_GET['mid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "edu_submit")) {
  $insertSQL = sprintf("INSERT INTO edu_level (edulevel_by, edulevel_date, edulevel_name) VALUES (%s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['edulevel_name'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['eid'])) && ($_GET['eid'] != NULL)) {
  $insertSQL = "UPDATE www.edu_level SET edulevel_status = '0' WHERE edulevel_id='" . $_GET['eid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "location_submit")) {
  $insertSQL = sprintf("INSERT INTO location (location_by, location_date, location_name, state_id) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['location_name'], "text"),
					   GetSQLValueString($_POST['state_id'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['lid'])) && ($_GET['lid'] != NULL)) {
  $insertSQL = "UPDATE www.location SET location_status = '0' WHERE location_id='" . $_GET['lid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "race_submit")) {
  $insertSQL = sprintf("INSERT INTO race (race_by, race_date, race_name) VALUES (%s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['race_name'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['baid'])) && ($_GET['baid'] != NULL)) {
  $insertSQL = "UPDATE www.race SET race_status = '0' WHERE race_id='" . $_GET['baid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "ag_submit")) {
  $insertSQL = sprintf("INSERT INTO religion (religion_by, religion_date, religion_name) VALUES (%s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['religion_name'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['aid'])) && ($_GET['aid'] != NULL)) {
  $insertSQL = "UPDATE www.religion SET religion_status = '0' WHERE religion_id='" . $_GET['aid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sp_submit")) {
  $insertSQL = sprintf("INSERT INTO job_type (jobtype_by, jobtype_date, jobtype_name) VALUES (%s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['jobtype_name'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['jid'])) && ($_GET['jid'] != NULL)) {
  $insertSQL = "UPDATE www.job_type SET jobtype_status = '0' WHERE jobtype_id='" . $_GET['jid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "bank_submit")) {
  $insertSQL = sprintf("INSERT INTO bank (bank_by, bank_date, bank_name) VALUES (%s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
                       GetSQLValueString($_POST['bank_name'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['bid'])) && ($_GET['bid'] != NULL)) {
  $insertSQL = "UPDATE www.bank SET bank_status = '0' WHERE bank_id='" . $_GET['bid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "kewe_submit")) {
  $insertSQL = sprintf("INSERT INTO kewe (kewe_by, kewe_date, kewe_name, kewetype_id) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
                       GetSQLValueString($_POST['kewe_name'], "text"),
                       GetSQLValueString($_POST['kewetype_id'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['kid'])) && ($_GET['kid'] != NULL)) {
  $insertSQL = "UPDATE www.kewe SET kewe_status = '0' WHERE kewe_id='" . $_GET['kid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "source")) {
  $insertSQL = sprintf("INSERT INTO source (source_name) VALUES (%s)",
                       GetSQLValueString($_POST['source_name'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}
if ((isset($_GET['sid'])) && ($_GET['sid'] != NULL)) {
  $insertSQL = "UPDATE www.source SET source_status = '0' WHERE source_id='" . $_GET['sid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "propertytype")) {
  $insertSQL = sprintf("INSERT INTO property_type (propertytype_name) VALUES (%s)",
                       GetSQLValueString($_POST['propertytype_name'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=add";
}
if ((isset($_GET['pid'])) && ($_GET['pid'] != NULL)) {
  $insertSQL = "UPDATE www.property_type SET propertytype_status = '0' WHERE propertytype_id='" . $_GET['pid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}

// baru 9/2/2021
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "hospital_submit")) {
  $insertSQL = sprintf("INSERT INTO hospital (hospital_by, hospital_date, hospital_name, state_id) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['hospital_name'], "text"),
					   GetSQLValueString($_POST['state_id'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
   $insertGoTo .= "?msg=add";
}

if ((isset($_GET['hid'])) && ($_GET['hid'] != NULL)) {
  $insertSQL = "UPDATE www.hospital SET hospital_status = '0' WHERE hospital_id='" . $_GET['hid'] . "'";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
  $insertGoTo .= "?msg=del";
}
// baru 9/2/2021

//baru 18/2/2021
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "keweayat")) {
  // echo $_GET['kewe_ayat'];
  $insertSQL = "UPDATE www.kewe set kewe_desc ='" . $_POST['kewe_ayat'] . "' WHERE kewe_id='" . $_POST['kewe_id'] . "' ";
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
}


//baru 18/2/2021

header(sprintf("Location: %s", $insertGoTo));
?>
