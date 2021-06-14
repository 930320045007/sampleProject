<?php require_once('../Connections/hrmsdb.php'); ?>

<?php require_once('../Connections/tadbirdb.php'); ?>

<?php include('../inc/user.php');?>

<?php include('../inc/func.php');?>

<?php include('../inc/tadbirfunc.php');?>

<?php

$insertGoTo = $url_main . "tadbir/setting.php";

if ((isset($_POST["MM_insert_hall"])) && ($_POST["MM_insert_hall"] == "hall_submit")) {

  $insertSQL = sprintf("INSERT INTO tadbir.hall (hall_by, hall_date, halltype_id, hall_name) VALUES (%s, %s, %s, %s)",

                       GetSQLValueString($row_user['user_stafid'], "text"),

					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),

					   GetSQLValueString($_POST['halltype_id'], "int"),

					   GetSQLValueString($_POST['hall_name'], "text"));



  mysql_select_db($database_hrmsdb, $hrmsdb);

  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());



$insertGoTo = $url_main . "tadbir/setting.php?msg=add";

}

if ((isset($_GET['hid'])) && ($_GET['hid'] != NULL)) {

  $insertSQL = "UPDATE tadbir.hall SET hall_status = '0' WHERE hall_id='" . htmlspecialchars($_GET['hid'],ENT_QUOTES) . "'";

  mysql_select_db($database_tadbirdb, $tadbirdb);

  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

  $insertGoTo .= "?msg=del";

}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "transport"))

{

	 $insertSQL = sprintf("INSERT INTO tadbir.transport (transport_name, transport_plat) VALUES (%s, %s)",

	  				GetSQLValueString($_POST['transport_name'], "text"),

					GetSQLValueString($_POST['transport_plat'], "text"));

					   

	   mysql_select_db($database_tadbirdb, $tadbirdb);

  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

  $insertGoTo .= "?msg=add";

}

if ((isset($_GET['tid'])) && ($_GET['tid'] != NULL)) {

  $insertSQL = "UPDATE tadbir.transport SET transport_status = '0' WHERE transport_id='" . htmlspecialchars($_GET['tid'],ENT_QUOTES) . "'";

  mysql_select_db($database_tadbirdb, $tadbirdb);

  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

  $insertGoTo .= "?msg=del";

}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "driver"))

{

	 $insertSQL = sprintf("INSERT INTO tadbir.driver (user_stafid) VALUES (%s)",

	  				GetSQLValueString($_POST['user_stafid'], "text"));

					   

	   mysql_select_db($database_tadbirdb, $tadbirdb);

  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

  $insertGoTo .= "?msg=add";

}

if ((isset($_GET['drid'])) && ($_GET['drid'] != NULL)) {

  $insertSQL = "UPDATE tadbir.driver SET driver_status = '0' WHERE driver_id='" . htmlspecialchars($_GET['drid'],ENT_QUOTES) . "'";

  mysql_select_db($database_tadbirdb, $tadbirdb);

  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

  $insertGoTo .= "?msg=del";

}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "feedback"))

{

	 $insertSQL = sprintf("INSERT INTO tadbir.feedback (feedback_name) VALUES (%s)",

	  				GetSQLValueString($_POST['feedback_name'], "text"));

					   

	   mysql_select_db($database_tadbirdb, $tadbirdb);

  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

  $insertGoTo .= "?msg=add";

}

if ((isset($_GET['fid'])) && ($_GET['fid'] != NULL)) {

  $insertSQL = "UPDATE tadbir.feedback SET feedback_status = '0' WHERE feedback_id='" . htmlspecialchars($_GET['fid'],ENT_QUOTES) . "'";

  mysql_select_db($database_tadbirdb, $tadbirdb);

  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

  $insertGoTo .= "?msg=del";

}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "maintenance"))

{

	 $insertSQL = sprintf("INSERT INTO tadbir.description (desc_name) VALUES (%s)",

	  				GetSQLValueString($_POST['desc_name'], "text"));

					   

	   mysql_select_db($database_tadbirdb, $tadbirdb);

  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

  $insertGoTo .= "?msg=add";

}

if ((isset($_GET['did'])) && ($_GET['did'] != NULL)) {

  $insertSQL = "UPDATE tadbir.description SET desc_status = '0' WHERE desc_id='" . htmlspecialchars($_GET['did'],ENT_QUOTES) . "'";

  mysql_select_db($database_tadbirdb, $tadbirdb);

  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

  $insertGoTo .= "?msg=del";

}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "transporttype"))

{

	 $insertSQL = sprintf("INSERT INTO tadbir.transport_type (transporttype_name) VALUES (%s)",

	  				GetSQLValueString($_POST['transporttype_name'], "text"));

					   

	   mysql_select_db($database_tadbirdb, $tadbirdb);

  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

  $insertGoTo .= "?msg=add";

}

if ((isset($_GET['ttid'])) && ($_GET['ttid'] != NULL)) {

  $insertSQL = "UPDATE tadbir.transport_type SET transporttype_status = '0' WHERE transporttype_id='" . htmlspecialchars($_GET['ttid'],ENT_QUOTES) . "'";

  mysql_select_db($database_tadbirdb, $tadbirdb);

  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

  $insertGoTo .= "?msg=del";

}




header(sprintf("Location: %s", $insertGoTo));

?>