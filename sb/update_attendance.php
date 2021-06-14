<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php //include('../sb/email.php');?>
<?php
$updateGoTo = $url_main . "admin/attendance.php";

if(isset($_POST['isnmail']) && $_POST['isnmail']!=NULL)
{
	if(isset($_GET['id']) && checkUserSysAcc($row_user['user_stafid'], 5, 11, 2))
	{
		if(checkEndDate($_GET['id']) && checkStartDate($_GET['id']))
		{
			$ue = strtolower($_POST['isnmail'] . "@nsc.gov.my");
			$userlogin = getStafIDByEmail($ue);
			
			if(!checkAttendence($userlogin, $_GET['id']))
			{
				if(strcasecmp($_POST['kt'],getPassKey(getPassOldByUserID($userlogin),0))==0)
				{
					if(checkUserCoursesEntry($userlogin,$_GET['id']))
					{
					  $updateSQL = "UPDATE user_courses SET usercourses_approvalby = '" . $row_user['user_stafid'] . "', usercourses_approvaldate = '" . date('d/m/Y h:i:s A') . "' WHERE user_stafid = '" . $userlogin . "' AND courses_id='" . GetSQLValueString($_GET['id'], "int") . "'";
					} else {
					  $updateSQL = sprintf("INSERT INTO user_courses (usercourses_by, usercourses_date, user_stafid, courses_id, usercourses_approvalby, usercourses_approvaldate) VALUES (%s, %s, %s, %s, %s, %s)",
											   GetSQLValueString($row_user['user_stafid'], "text"),
											   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
											   GetSQLValueString($userlogin, "text"),
											   GetSQLValueString($_GET['id'], "int"),
											   GetSQLValueString($row_user['user_stafid'], "text"),
											   GetSQLValueString(date('d/m/Y h:i:s A'), "text"));
					};
					
					  mysql_select_db($database_hrmsdb, $hrmsdb);
					  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
							  
					  //$emailto = array(); // array StafID penerima email
					  //$emailto[] = $userlogin; // array emailstafid[0] = pemohon no fail
					  
					  //$usercoursesid = getCoursesID($userlogin, $_GET['id']);
					  
					  //emailCoursesAttendance($emailto, 0, 0, 1, $usercoursesid);
					  
					  $updateGoTo .= "?msg=edit&id=" . $_GET['id'];
					  
				} else {
					$updateGoTo .= "?e=login&id=" . $_GET['id'];
				};
				
			} else { // semakkan stafid sudah membuat pengesahan kehadiran
				$updateGoTo .= "?ec=3&id=" . $_GET['id'];	
			};
			
		} else { // semakkan Start dan End Date kursus
			$updateGoTo .= "?ec=4&id=" . $_GET['id'];	
		};
		
	} else {
	  $updateGoTo .= "?e=logout&id=" . $_GET['id'];
	};

} else {
  $updateGoTo .= "?msg=error&id=" . $_GET['id'];
};

header(sprintf("Location: %s", $updateGoTo));
?>