<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include ('../qr/qrlib.php');?>
<?php QRcode::png($row_user['user_stafid'] . " " . $_GET['y'] . " RM" . number_format(getGajiBersihYearByUserID($row_user['user_stafid'], $_GET['y']), 2)); ?>