<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php include('../sb/email.php');?>
<?php
	emailFeedbackLateHarta(0, 0, 0, 1, 0);
	emailFeedbackLate24Harta(0, 0, 0, 1, 0);
?>