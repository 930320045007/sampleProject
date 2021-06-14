<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php include('../sb/email.php');?>
<?php

	//Email kepada user yg tidak memulangkan item melebihi tempoh
	$day2 = date('d', mktime(0, 0, 0, date('m'), date('d')-2, date('y')));
	$month2 = date('m', mktime(0, 0, 0, date('m'), date('d')-2, date('y')));
	$year2 = date('Y', mktime(0, 0, 0, date('m'), date('d')-2, date('y')));

	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_app = "SELECT * FROM ict.user_borrow WHERE userborrow_status = '1' AND ict_status = '1' AND ict_return='0' AND userborrow_date_d <= '" . $day2 . "' AND userborrow_date_m <= '" . $month2 . "' AND userborrow_date_y <= '" . $year2 . "' ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
	$app = mysql_query($query_app, $hrmsdb) or die(mysql_error());
	$row_app = mysql_fetch_assoc($app);
	$total2 = mysql_num_rows($app);
	
	if($total2 > 0) {
		do {
				if($row_app['durationtype_id']==2)
					$day = $row_app['userborrow_duration'];
				else if($row_app['durationtype_id']==3)
					$day = $row_app['userborrow_duration'] * 7;
				else if($row_app['durationtype_id']==4)
					$day = $row_app['userborrow_duration'] * 30;
				else if($row_app['durationtype_id']==5)
					$day = $row_app['userborrow_duration'] * 360;
				else
					$day = 1; // jika duration adalah Jam
					
				$dend = date('d', mktime(0, 0, 0, $row_app['userborrow_date_m'], $row_app['userborrow_date_d']+$day, $row_app['userborrow_date_y']));
				$mend = date('m', mktime(0, 0, 0, $row_app['userborrow_date_m'], $row_app['userborrow_date_d']+$day, $row_app['userborrow_date_y']));
				$yend = date('Y', mktime(0, 0, 0, $row_app['userborrow_date_m'], $row_app['userborrow_date_d']+$day, $row_app['userborrow_date_y']));
				
				$cday = ((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - mktime(0, 0, 0, $mend, $dend, $yend))/86400);
				
				$sendmail = false;
				
				if($cday%2==0 && $cday <= 2 && $cday>0)
				{
					$sendmail = true; // send email jika sehari selepas tempoh pinjaman
					
				} else if($cday%7==0 && $cday>0){
					
					$sendmail = true; // jika tiada pulangan lagi dalam seminggu
				} else {
					$sendmail = false;
				}
				
				if($sendmail)
				{
					$emailto2 = array(); // reset array 
					$emailto2[] = $row_app['user_stafid']; // array emailstafid[0] = Staf ID yang membuat aduan tp masih tak approve
					$emailto2 = array_merge($emailto2,getUserIDSysAcc(6, 27));//ICT yg ada kelulusan Modul
					cronemailICReturnLate($emailto2, 0, 0, 1, $row_app['userborrow_id']);
				}
				
		} while($row_app = mysql_fetch_assoc($app));
	}
	
	mysql_free_result($app);
?>