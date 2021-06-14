<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include ('../qr/qrlib.php');?>
<?php
if(isset($_POST['id']))
	$userproperty = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES));
else if(isset($_GET['id']))
	$userproperty = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
else
	$userproperty = $row_user['user_stafid'];
?>
<?php QRcode::png($userproperty . " RM" . number_format(getTotalAmountIndLoanByUser($userproperty),2)); ?>