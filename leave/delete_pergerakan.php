<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$id = strval($_GET['id']);
// $year = intval($_POST['year']);

    $sql = sprintf("DELETE FROM pergerakan WHERE pergerakan.pergerakan_id = '" .$id. "'");

	 $result = mysql_query($sql,$hrmsdb) or die(mysql_error());
		
?>