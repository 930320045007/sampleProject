<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php
$updateGoTo = $url_main . "skt/index.php";

if(isset($_GET['id'])){
  $updateSQL = sprintf("UPDATE user_skt SET uskt_status ='0' WHERE uskt_id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_skt, $skt);
  $Result1 = mysql_query($updateSQL, $skt) or die(mysql_error());
  
  
  $updateGoTo .= "?msg=del";
	}
	
	else {
	$updateGoTo .= "?del=1";
	}
header(sprintf("Location: %s", $updateGoTo));
?>