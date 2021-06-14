<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='68';?>
<?php
$insertGoTo = $url_main . "skt/latihan.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
{
  $insertSQL = sprintf("INSERT INTO skt.user_training (user_stafid, usertraining_date_d, usertraining_date_m, usertraining_date_y, usertraining_name, usertraining_note) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString(date('d'), "text"),
                       GetSQLValueString(date('m'), "text"),
                       GetSQLValueString(date('Y'), "text"),
                       GetSQLValueString($_POST['usertraining_name'], "text"),
                       GetSQLValueString($_POST['usertraining_note'], "text"));

  mysql_select_db($database_skt, $skt);
  $Result1 = mysql_query($insertSQL, $skt) or die(mysql_error());
  
  $insertGoTo .= "?msg=add";
  
} else {
  $insertGoTo .= "?msg=error";
};

header(sprintf("Location: %s", $insertGoTo));
?>