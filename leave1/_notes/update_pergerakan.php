<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$val = strval($_GET['val']);
$id = intval($_GET['id']);

	$sql="update www.pergerakan SET pergerakan_location = '" .$val. "' WHERE pergerakan_id = '" .$id. "'";
	$result = mysql_query($sql,$hrmsdb) or die(mysql_error());
		
?>
