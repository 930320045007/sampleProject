<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php include ('../qr/qrlib.php');?>
<?php QRcode::png($row_user['user_stafid'] . "/" . getMaintenanceDateByID($_GET['mid']) . "/" . getID($_GET['mid'],0)); ?>