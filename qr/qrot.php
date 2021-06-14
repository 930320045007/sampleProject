<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php include ('../qr/qrlib.php');?>
<?php QRcode::png($row_user['user_stafid'] . "/" . htmlspecialchars($_GET['m'], ENT_QUOTES) . "/" . htmlspecialchars($_GET['y'], ENT_QUOTES) . "/" . getTotalStafOverall($_GET['m'],$_GET['y']) . "/RM" . number_format(getTotalOverall($_GET['m'],$_GET['y']),2)); ?>