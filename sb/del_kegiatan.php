<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php
$deleteGoTo = $url_main . "skt/kegiatan.php";

	if(isset($_GET['id'])){
	  $deleteSQL = sprintf("UPDATE skt.user_aktiviti SET useraktiviti_status = '0' WHERE useraktiviti_id=%s",
						   GetSQLValueString($_GET['id'], "int"));
	
	  mysql_select_db($database_skt, $skt);
	  $Result1 = mysql_query($deleteSQL, $skt) or die(mysql_error());
	
	 
  		$deleteGoTo .= "?msg=del";
	}
	
	else {
	$deleteGoTo .= "?del=1";
}
header(sprintf("Location: %s", $deleteGoTo));
?>