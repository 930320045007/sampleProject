<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='57';?>
<?php
$insertGoTo = $url_main . "tadbir/agensi.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tadbir.agensi (agensi_by, agensi_date, agensi_name, agensi_address, agensi_notel, agensi_nofax, agensi_email) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
                       GetSQLValueString($_POST['agensi_name'], "text"),
                       GetSQLValueString($_POST['agensi_address'], "text"),
                       GetSQLValueString($_POST['agensi_notel'], "text"),
                       GetSQLValueString($_POST['agensi_nofax'], "text"),
                       GetSQLValueString($_POST['agensi_email'], "text"));

  mysql_select_db($database_tadbirdb, $tadbirdb);
  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
  
  $insertGoTo .= "?msg=add";
}

header(sprintf("Location: %s", $insertGoTo));
?>