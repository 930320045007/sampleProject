<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../sb/email.php');?>
<?php
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formreport"))
{
	$insertGoTo = $url_main . "courses/report.php"; 
	
	if(!checkReportSubmit($_POST['user_stafid'], $_POST['courses_id']))
	{
	  $insertSQL = sprintf("INSERT INTO www.user_coursesreport (usercoursesreport_date, usercoursesreport_by, usercourses_id, usercoursesreport_modul, usercoursesreport_implementation, usercoursesreport_newinput, usercoursesreport_review, usercoursesreport_actionplan, usercoursesreport_rating, usercoursesreport_comment, usercoursesreport_nextyear) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString($_POST['usercourses_id'], "int"),
						   GetSQLValueString($_POST['usercoursesreport_modul'], "text"),
						   GetSQLValueString($_POST['usercoursesreport_implementation'], "text"),
						   GetSQLValueString($_POST['usercoursesreport_newinput'], "text"),
						   GetSQLValueString($_POST['usercoursesreport_review'], "text"),
						   GetSQLValueString($_POST['usercoursesreport_actionplan'], "text"),
						   GetSQLValueString($_POST['usercoursesreport_rating'], "int"),
						   GetSQLValueString($_POST['usercoursesreport_comment'], "text"),
						   GetSQLValueString($_POST['usercoursesreport_nextyear'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
			  
	  $coursesid = getUserCoursesReportIDByUserCoursesID($_POST['user_stafid'], $_POST['usercourses_id']);
	  
	  emailCoursesReport(getCoursesHRID(), 0, 0, 1, $coursesid);
	  $insertGoTo .= "?msg=add";
	  
	} else {
		$insertGoTo .= "?msg=error";
	};
	
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "userreport")) 
{
	if(checkReportApproval($row_user['user_stafid'], $row_report['courses_id'])==0) 
	{
	  $updateSQL = sprintf("UPDATE www.user_coursesreport SET usercoursesreport_date=%s, usercoursesreport_by=%s, usercourses_id=%s, usercoursesreport_modul=%s, usercoursesreport_implementation=%s, usercoursesreport_newinput=%s, usercoursesreport_review=%s, usercoursesreport_actionplan=%s WHERE usercoursesreport_id=%s",
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString($_POST['usercourses_id'], "int"),
						   GetSQLValueString($_POST['usercoursesreport_modul'], "text"),
						   GetSQLValueString($_POST['usercoursesreport_implementation'], "text"),
						   GetSQLValueString($_POST['usercoursesreport_newinput'], "text"),
						   GetSQLValueString($_POST['usercoursesreport_review'], "text"),
						   GetSQLValueString($_POST['usercoursesreport_actionplan'], "text"),
						   GetSQLValueString($_POST['usercoursesreport_id'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
			  
	  $coursesid = getUserCoursesReportIDByUserCoursesID($_POST['user_stafid'], $_POST['usercourses_id']);
	  
	  emailCoursesReport(getCoursesHRID(), 0, 0, 3, $coursesid);
		
	  $updateGoTo = $url_main . "courses/reportread.php?id=" . htmlspecialchars($_POST['usercourses_id'], ENT_QUOTES) . "&ucrid=" . htmlspecialchars($_POST['usercoursesreport_id'], ENT_QUOTES) . "&msg=edit";
	  
	} else {
	  $updateGoTo = $url_main . "courses/reportread.php?id=" . htmlspecialchars($_POST['usercourses_id'], ENT_QUOTES) . "&ucrid=" . htmlspecialchars($_POST['usercoursesreport_id'], ENT_QUOTES) . "&er=1";
	};
	
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update_hr"])) && ($_POST["MM_update_hr"] == "formhr")) 
{
  $updateSQL = sprintf("UPDATE www.user_coursesreport SET hr_date=%s, hr_by=%s, hr_comment=%s, hr_approval=%s WHERE usercoursesreport_id=%s",
                       GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString($_POST['hr_comment'], "text"),
                       GetSQLValueString($_POST['hr_approval'], "int"),
                       GetSQLValueString($_POST['usercoursesreport_id'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
			  
  $emailto = array(); // Staf ID
  $emailto[] = getCoursesReportUserID($_POST['usercoursesreport_id']); // array emailstafid[0] = Staf ID 
	
  $coursesid = htmlspecialchars($_POST['usercoursesreport_id'], ENT_QUOTES);
  
  emailCoursesReport($emailto, 0, 0, 2, $coursesid);

  $updateGoTo = $url_main . "admin/coursesdetail.php?id=" . getCoursesIDbyReportID($_POST['usercoursesreport_id']) . "&msg=edit";
  
  header(sprintf("Location: %s", $updateGoTo));
}
?>
