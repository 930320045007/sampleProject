<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	if(checkUserSysAcc($row_user['user_stafid'], 5, 11, 2)){
	  $insertSQL = sprintf("INSERT INTO courses (courses_by, courses_date, courses_start_d, courses_start_m, courses_start_y, courses_end_d, courses_end_m, courses_end_y, coursescategory_id, coursestype_id, courses_name, courses_location, courses_time, courses_lectureby, courses_lecturename, organizedby_id, courses_duration, durationtype_id, group_id, dir_id, courses_entry, courses_ref, courses_notes, courses_att, courses_report, courses_view) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['courses_start_d'], "text"),
						   GetSQLValueString($_POST['courses_start_m'], "text"),
						   GetSQLValueString($_POST['courses_start_y'], "text"),
						   GetSQLValueString($_POST['courses_end_d'], "text"),
						   GetSQLValueString($_POST['courses_end_m'], "text"),
						   GetSQLValueString($_POST['courses_end_y'], "text"),
						   GetSQLValueString($_POST['coursescategory_id'], "int"),
						   GetSQLValueString($_POST['coursestype_id'], "int"),
						   GetSQLValueString($_POST['courses_name'], "text"),
						   GetSQLValueString($_POST['courses_location'], "text"),
						   GetSQLValueString($_POST['courses_time'], "text"),
						   GetSQLValueString($_POST['courses_lectureby'], "text"),
						   GetSQLValueString($_POST['courses_lecturename'], "text"),
						   GetSQLValueString($_POST['organizedby_id'], "int"),
						   GetSQLValueString($_POST['courses_duration'], "int"),
						   GetSQLValueString($_POST['durationtype_id'], "int"),
						   GetSQLValueString($_POST['group_id'], "int"),
						   GetSQLValueString($_POST['dir_id'], "int"),
						   GetSQLValueString($_POST['courses_entry'], "int"),
						   GetSQLValueString($_POST['courses_ref'], "text"),
						   GetSQLValueString($_POST['courses_notes'], "text"),
						   GetSQLValueString($_POST['courses_att'], "int"),
						   GetSQLValueString($_POST['courses_report'], "int"),
						   GetSQLValueString($_POST['courses_view'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	
	  $insertGoTo = $url_main . "admin/courseslist.php?msg=add";
	} else {
  $insertGoTo = $url_main . "admin/courseslist.php?eul=1";
	}
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formcourses")) {
	if(checkUserSysAcc($row_user['user_stafid'], 5, 11, 3)){
	  $updateSQL = sprintf("UPDATE courses SET courses_date=%s, courses_by=%s, courses_start_d=%s, courses_start_m=%s, courses_start_y=%s, courses_end_d=%s, courses_end_m=%s, courses_end_y=%s, coursescategory_id=%s, coursestype_id=%s, courses_name=%s, courses_location=%s, courses_time=%s, courses_lectureby=%s, courses_lecturename=%s, organizedby_id=%s, courses_duration=%s, durationtype_id=%s, group_id=%s, dir_id=%s, courses_entry=%s, courses_ref=%s, courses_notes=%s, courses_att=%s, courses_report=%s, courses_view=%s WHERE courses_id=%s",
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString($_POST['courses_start_d'], "text"),
						   GetSQLValueString($_POST['courses_start_m'], "text"),
						   GetSQLValueString($_POST['courses_start_y'], "text"),
						   GetSQLValueString($_POST['courses_end_d'], "text"),
						   GetSQLValueString($_POST['courses_end_m'], "text"),
						   GetSQLValueString($_POST['courses_end_y'], "text"),
						   GetSQLValueString($_POST['coursescategory_id'], "int"),
						   GetSQLValueString($_POST['coursestype_id'], "int"),
						   GetSQLValueString($_POST['courses_name'], "text"),
						   GetSQLValueString($_POST['courses_location'], "text"),
						   GetSQLValueString($_POST['courses_time'], "text"),
						   GetSQLValueString($_POST['courses_lectureby'], "text"),
						   GetSQLValueString($_POST['courses_lecturename'], "text"),
						   GetSQLValueString($_POST['organizedby_id'], "int"),
						   GetSQLValueString($_POST['courses_duration'], "int"),
						   GetSQLValueString($_POST['durationtype_id'], "int"),
						   GetSQLValueString($_POST['group_id'], "int"),
						   GetSQLValueString($_POST['dir_id'], "int"),
						   GetSQLValueString($_POST['courses_entry'], "int"),
						   GetSQLValueString($_POST['courses_ref'], "text"),
						   GetSQLValueString($_POST['courses_notes'], "text"),
						   GetSQLValueString($_POST['courses_att'], "int"),
						   GetSQLValueString($_POST['courses_report'], "int"),
						   GetSQLValueString($_POST['courses_view'], "int"),
						   GetSQLValueString($_POST['courses_id'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
	
	  $updateGoTo = $url_main . "admin/coursesdetail.php?msg=edit&id=" . $_POST['courses_id'];
	} else {
  		$updateGoTo = $url_main . "admin/coursesdetail.php?eul=1&id=" . $_POST['courses_id'];
	}
  header(sprintf("Location: %s", $updateGoTo));
}
?>