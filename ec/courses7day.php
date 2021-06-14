<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php //include('../sb/email.php');?>
<?php 

	$y = date('Y');
	
	$sql_where = " login.login_status = '1'";
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_staf = sqlAllStaf($sql_where);
	$staf = mysql_query($query_staf, $hrmsdb) or die(mysql_error());
	$row_staf = mysql_fetch_assoc($staf);
	
	$total = mysql_num_rows($staf);
	
	if($total > 0)
	{		
		do {
			$courseshour = countCoursesHour($row_staf['user_stafid'], $y); //$courseshour[0] = Hari, $courseshour[1] = jam
			
			if($courseshour['0'] < getCoursesDayByYear($row_staf['user_stafid'], $y) && getHourByDayHour($courseshour['0'], $courseshour['1']) < getTotalHourByQ() && getCitizenByUserID($row_staf['user_stafid'])=='130')
			{
				emailCourses7Day($row_staf['user_stafid'], 0, 0, 1, $row_staf['user_stafid']);
				//echo getFullNameByStafID($row_staf['user_stafid']) . " (" . $row_staf['user_stafid'] . ")" . " " . getHourByDayHour($courseshour['0'], $courseshour['1']) . " < " . getTotalHourByQ() . "<br/>";
			};
		} while($row_staf = mysql_fetch_assoc($staf));
	};
	
	mysql_free_result($staf);
?>