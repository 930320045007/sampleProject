<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php
$insertGoTo = $url_main . "skt/kegiatan.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
{
  $insertSQL = sprintf("INSERT INTO skt.user_aktiviti (useraktiviti_by, useraktiviti_date, user_stafid, useraktiviti_year, useraktiviti_name, orglevel_id, orgarch_id, useraktiviti_jawat) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
                       GetSQLValueString($_POST['id'], "text"),
                       GetSQLValueString($_POST['useraktiviti_year'], "int"),
                       GetSQLValueString($_POST['useraktiviti_name'], "text"),
                       GetSQLValueString($_POST['orglevel_id'], "int"),
                       GetSQLValueString($_POST['orgarch_id'], "int"),
                       GetSQLValueString($_POST['useraktiviti_jawat'], "text"));

  mysql_select_db($database_skt, $skt);
  $Result1 = mysql_query($insertSQL, $skt) or die(mysql_error());

  $insertGoTo .= "?msg=add";
  
} else {
  $insertGoTo .= "?msg=error";
}

header(sprintf("Location: %s", $insertGoTo));
?>