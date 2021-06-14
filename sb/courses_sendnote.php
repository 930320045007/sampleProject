<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../sb/email.php');?>
<?php
$deleteGoTo = $url_main . "admin/coursesdetail.php?id=" . htmlspecialchars($_GET['id'], ENT_QUOTES);

if(isset($_GET['id']) && $_GET['id']!=NULL)
{
	if(checkUserSysAcc($row_user['user_stafid'], 5, 11, 2))
	{  
				  
		$emailto = array(); // array StafID penerima email
		$emailto[] = $row_user['user_stafid']; // array emailstafid[0] = pemohon no fail
		
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$query_entry = sprintf("SELECT user_courses.*, user.user_firstname FROM user_courses LEFT JOIN user ON user.user_stafid = user_courses.user_stafid WHERE courses_id = %s AND user_courses.usercourses_status = '1' ORDER BY user.user_firstname ASC", GetSQLValueString($_GET['id'], "int"));
		$entry = mysql_query($query_entry, $hrmsdb) or die(mysql_error());
		$row_entry = mysql_fetch_assoc($entry);

		if(getHeadIDByUserID($row_user['user_stafid'])!=NULL)
		  $emailto[] = getHeadIDByUserID($row_user['user_stafid']); // array emailstafid[1] = Ketua Unit No Fail
		
		do {
			$emailto[] = $row_entry['user_stafid']; // array emailstafid[1] = Staf ID mendaftar
		} while ($row_entry = mysql_fetch_assoc($entry));
		
		emailCoursesNote($emailto, 0, 0, 1, $_GET['id'], $_POST['notemsg'], $row_user['user_stafid']);
		
		$deleteGoTo .= "&msg=send";	
		
	} else {
		$deleteGoTo .= "&del=1";
	};
	
} else {
	$deleteGoTo = $url_main . "admin/courseslist.php?ec=1";
};

header(sprintf("Location: %s", $deleteGoTo));
?>