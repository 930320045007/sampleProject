<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include ('../qr/qrlib.php');?>
<?php QRcode::png($row_user['user_stafid'] . " " . $_GET['m'] . "/" . $_GET['y'] . " RM" . number_format(getGajiBersihByUserID($row_user['user_stafid'], 1, $_GET['m'], $_GET['y']), 2)); ?>