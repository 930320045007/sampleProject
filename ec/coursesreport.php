<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php include('../sb/email.php');?>
<?php

	$d7 = date('d', mktime(0, 0, 0, date('m'), date('d')-7, date('Y')));
	$m7 = date('m', mktime(0, 0, 0, date('m'), date('d')-7, date('Y')));
	$y7 = date('Y', mktime(0, 0, 0, date('m'), date('d'), date('Y'))); // tahun tidak dikira
	
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_kursus = "SELECT courses.* FROM www.courses WHERE ((courses_end_d < '" . $d7 . "' AND courses_end_m = '" . $m7 . "') OR (courses_end_m < '" . $m7 . "')) AND courses_end_y = '" . $y7 . "' AND courses_report = '1' AND courses_status = 1";
	$kursus = mysql_query($query_kursus, $hrmsdb) or die(mysql_error());
	$row_kursus = mysql_fetch_assoc($kursus);
	$total = mysql_num_rows($kursus);
	
	if($total > 0) {
		do{
	
			$cday = ((mktime(0, 0, 0, date('m'), date('d')-7, date('Y')) - mktime(0, 0, 0, $row_kursus['courses_end_m'], $row_kursus['courses_end_d'], $row_kursus['courses_end_y']))/86400);
			
			if(($cday%7)==1)
			{
				mysql_select_db($database_hrmsdb, $hrmsdb);
				$query_ukursus = "SELECT user_courses.* FROM www.user_courses WHERE courses_id = '" . $row_kursus['courses_id'] . "' AND usercourses_status = 1 AND NOT EXISTS(SELECT * FROM www.user_coursesreport WHERE user_coursesreport.usercourses_id = user_courses.usercourses_id AND user_coursesreport.usercoursesreport_by = user_courses.user_stafid AND usercoursesreport_status = 1)";
				$ukursus = mysql_query($query_ukursus, $hrmsdb) or die(mysql_error());
				$row_ukursus = mysql_fetch_assoc($ukursus);
				$utotal = mysql_num_rows($ukursus);
				
				$emailto = array(); // array StafID penerima email
				
				do {
					$emailto[] = $row_ukursus['user_stafid']; // array emailstafid[0] = staf id berdaftar untuk kursus
				} while($row_ukursus = mysql_fetch_assoc($ukursus));
				
				emailCoursesReportLate($emailto, 0, 0, 1, $row_kursus['courses_id']);
				
				mysql_free_result($ukursus);
			}
			
		} while($row_kursus = mysql_fetch_assoc($kursus));
	}
	
	mysql_free_result($kursus);
?>
