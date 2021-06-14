<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='86';?>
<?php
$insertGoTo = $url_main . "tadbir/agency.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tadbir.transport_agency (transagency_by, transagency_date, transagency_name, transagency_address, transagency_notel, transagency_nofax, transagency_email) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
                       GetSQLValueString($_POST['transagency_name'], "text"),
                       GetSQLValueString($_POST['transagency_address'], "text"),
                       GetSQLValueString($_POST['transagency_notel'], "text"),
                       GetSQLValueString($_POST['transagency_nofax'], "text"),
                       GetSQLValueString($_POST['transagency_email'], "text"));

  mysql_select_db($database_tadbirdb, $tadbirdb);
  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
  
  $insertGoTo .= "?msg=add";
}

header(sprintf("Location: %s", $insertGoTo));
?>