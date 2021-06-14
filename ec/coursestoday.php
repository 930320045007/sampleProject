<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php include('../sb/email.php');?>
<?php
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_kursus = "SELECT courses.* FROM www.courses WHERE courses_start_d='" . date('d') . "' AND courses_start_m = '" . date('m') . "' AND courses_start_y = '" . date('Y') . "' AND courses_status = 1";
	$kursus = mysql_query($query_kursus, $hrmsdb) or die(mysql_error());
	$row_kursus = mysql_fetch_assoc($kursus);
	$total = mysql_num_rows($kursus);
	
	if($total > 0) {
		do{
			mysql_select_db($database_hrmsdb, $hrmsdb);
			$query_ukursus = "SELECT user_courses.* FROM www.user_courses WHERE courses_id = '" . $row_kursus['courses_id'] . "' AND usercourses_status = 1";
			$ukursus = mysql_query($query_ukursus, $hrmsdb) or die(mysql_error());
			$row_ukursus = mysql_fetch_assoc($ukursus);
			$utotal = mysql_num_rows($ukursus);
			
			$emailto = array(); // array StafID penerima email
			
			do {
				$emailto[] = $row_ukursus['user_stafid']; // array emailstafid[0] = staf id berdaftar untuk kursus
			} while($row_ukursus = mysql_fetch_assoc($ukursus));
			
			emailCoursesByDate($emailto, 0, 0, 1, $row_kursus['courses_id']);
			
			mysql_free_result($ukursus);
			
		} while($row_kursus = mysql_fetch_assoc($kursus));
	}
	
	mysql_free_result($kursus);
?>
