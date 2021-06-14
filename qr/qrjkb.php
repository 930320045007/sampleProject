<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php include ('../qr/qrlib.php');?>
<?php QRcode::png($row_user['user_stafid'] . "/" . getTotalPermohonan($_GET['jid']). "/" . number_format(getAmountByJkbID($_GET['jid']),2) . "/" . getID(htmlspecialchars($_GET['jid'],0))); ?>