<?php
//Email akses
function countDeActEmail()
{
	$query_mbjitem = "SELECT user.* FROM user LEFT JOIN (SELECT * FROM user_unit WHERE user_unit.userunit_status = '1' ORDER BY user_unit.userunit_id) AS user_unit ON user_unit.user_stafid = user.user_stafid WHERE NOT EXISTS (SELECT * FROM login WHERE user.user_stafid = login.user_stafid) AND user_unit.userunit_status = '1' GROUP BY user.user_stafid ORDER BY user.user_firstname ASC, user.user_lastname ASC";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	$total = mysql_num_rows($mbjitem);
	
	return $total;
}

function getReportID($catid, $userid, $d, $m, $y)
{
	$query_ss = "SELECT user_report.* FROM mbj.user_report WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND category_id = '" . htmlspecialchars($catid, ENT_QUOTES) . "' AND userreport_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' ORDER BY userreport_date_y DESC, userreport_date_m DESC, userreport_date_d DESC, userreport_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return $row_ss['userreport_id'];
	else
		return 0;
}

function checkReportTodayByUserID($userid, $reportcategory)
{
	$query_mbjitem = "SELECT COUNT(userreport_id) AS count FROM mbj.user_report WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userreport_id = '" . htmlspecialchars($reportcategory, ENT_QUOTES) . "' AND userreport_date_d = '" . date('d') . "' AND userreport_date_m = '" . date('m') . "' AND userreport_date_y = '" . date('Y') . "' AND userreport_status = 1 GROUP BY user_stafid";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
	if($row_mbjitem['count']>0)
		return true;
	else
		return false;
}

function checkTotalReportPerDayByUserID($userid)
{
	$query_mbjitem = "SELECT COUNT(userreport_id) AS count FROM mbj.user_report WHERE userreport_status = '1' AND user_stafid='" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userreport_date_d = '" . date('d') . "' AND userreport_date_m = '" . date('m') . "' AND userreport_date_y = '" . date('Y') . "' GROUP BY user_stafid";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
	if($row_mbjitem['count']<5) //3kali aduan per day
	{
		return true;
	} else {
		return false;
	}
}


function checkFeedbackApprovalByUserID($userid)
{
	$query_mbjitem = "SELECT user_report.userreport_id FROM mbj.user_report LEFT JOIN mbj.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_reportfeedback.feedbacktype_id = '0' AND user_report.userreport_star = '0' AND user_report.userreport_status = '1' AND user_report.user_stafid='" . htmlspecialchars($userid, ENT_QUOTES) . "'";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	$total = mysql_num_rows($mbjitem);
	
	return $total;
}

//Aduan
function countReportNeedApproval($d, $m, $y)
{
	$wsql = "";
	if($d!=0)
		$wsql .= " AND userreport_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_mbjitem = "SELECT * FROM mbj.userreport WHERE userreport.userreport_status = 1 AND NOT EXISTS (SELECT userreportfeedback.* FROM mbj.userreportfeedback WHERE userreportfeedback.feedbacktype_id = 0 AND userreportfeedback.userreport_id = userreport.userreport_id GROUP BY userreportfeedback.userreport_id) " . $wsql;
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	$total = mysql_num_rows($mbjitem);
	
	return $total;
}

function countTotalReport($d, $m, $y)
{
	$wsql = "";
	if($d!=0)
		$wsql .= " AND userreport_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_mbjitem = "SELECT * FROM mbj.userreport WHERE  user_report.userreport_status = 1 " . $wsql;
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	$total = mysql_num_rows($mbjitem);
	
	return $total;
}



function checkLimitReport($userid, $d, $m, $y)
{
	// Semakkan aduan hanya sebanyak 5 kali sehari
	$query_ss = "SELECT user_report.* FROM mbj.user_report WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userreport_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' ORDER BY userreport_date_y DESC, userreport_date_m DESC, userreport_date_d DESC, userreport_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total <= 5)
		return true;
	else
		return false;
}

function getReportTypeByCategoryID($id)
{
	$query_mbjitem = "SELECT category_id FROM mbj.category WHERE category_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
	return $row_mbjitem['category_id'];
}

function getCategoryNameByID($id)
{
		$query_mbjitem = "SELECT category_name FROM mbj.category WHERE category_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
		$mbjitem = mysql_query($query_mbjitem);
		$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
		$view = $row_mbjitem['category_name'];
	
	return $view;
}

function getLastFeedbackUserIDByUserReportID($id)
{
	$query_mbjitem = "SELECT urf_by FROM mbj.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);

	return $row_mbjitem['urf_by'];
}

function getLastFeedbackToUserIDByUserReportID($id)
{
	$query_mbjitem = "SELECT urf_stafid FROM mbj.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);

	return $row_mbjitem['urf_stafid'];
}
function getLastFeedbackDateByUserReportID($id)
{
	$query_mbjitem = "SELECT urf_date_d, urf_date_m, urf_date_y FROM mbj.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	$total = mysql_num_rows($mbjitem);

	return date('d / m / Y (D)', mktime(0, 0, 0, $row_mbjitem['urf_date_m'], $row_mbjitem['urf_date_d'], $row_mbjitem['urf_date_y']));
}

function getTotalReportTypeByMonth($rtid, $m, $y)
{
	if($rtid != 0)
		$wsql = " AND user_report.reporttype_id = '" . htmlspecialchars($rtid, ENT_QUOTES) . "'";
	else
		$wsql = "";
		
	$query_mbjitem = "SELECT userreport_id FROM mbj.user_report LEFT JOIN mbj.report_type ON report_type.reporttype_id = user_report.reporttype_id WHERE user_report.userreport_date_m='" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_report.userreport_date_y='" . htmlspecialchars($y, ENT_QUOTES) . "' " . $wsql . " AND user_report.userreport_status='1'";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
	$total = mysql_num_rows($mbjitem);
	
	return $total;
}
function getTotalReportByUserID($userid, $m, $y)
{
	$wsql = "";
	if($userid != '0')
		$wsql .= " AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "'";
	if($m != '0')
		$wsql .= " AND user_report.userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y !='0')
		$wsql .= " AND user_report.userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_mbjitem = "SELECT COUNT(user_report.userreport_star) AS totalstar FROM mbj.user_report LEFT JOIN mbj.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_reportfeedback.urf_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_report.userreport_status='1' " . $wsql . " GROUP BY user_reportfeedback.urf_by";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
		return 0;
}



function getReportTypeNameByID($id)
	{
		$query_mbjitem = "SELECT reporttype_name FROM mbj.reporttype WHERE reporttype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
		$mbjitem = mysql_query($query_mbjitem);
		$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
		$view = $row_mbjitem['reporttype_name'];
	
	return $view;
}


function getFeedbackTypeByID($id)
{
	$query_mbjitem = "SELECT feedbacktype_id, feedbacktype_name FROM mbj.feedback_type WHERE feedbacktype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
	if($row_mbjitem['feedbacktype_id']==0)
		$view = "Tamat";
	else
		$view = $row_mbjitem['feedbacktype_name'];
		
	return $view;
}

function getFeedbackDateByUserReportID($urid, $urfid)
{
	$query_mbjitem = "SELECT urf_date_d, urf_date_m, urf_date_y, urf_date_h FROM mbj.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' AND userreport_id = '" . $urid . "'";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_mbjitem['urf_date_m'], $row_mbjitem['urf_date_d'], $row_mbjitem['urf_date_y'])) . " " . $row_mbjitem['urf_date_h'];
}

function checkFeedbackInWeek($urid)
{
	$day = getFeedbackDayLong($urid);
			
	if($day%7==0)
		return true;
	else
		return false;
}

function checkFeedbackEndByUserReportID($id)
{
	$query_mbjitem = "SELECT urf_id FROM mbj.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND feedbacktype_id = '0'";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	$total = mysql_num_rows($mbjitem);
	
	if($total>0)
		return true;
	else
		return false;
}

function checkFeedbackApprovalByUserReportID($id)
{
	$query_mbjitem = "SELECT userreport_id FROM mbj.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userreport_star > '0'";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	$total = mysql_num_rows($mbjitem);
	
	if($total>0 && checkFeedbackEndByUserReportID($id))
		return true;
	else
		return false;
}

function getTotalFeedbackByUserReportID($id)
{
	$query_mbjitem = "SELECT urf_stafid FROM mbj.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	$total = mysql_num_rows($mbjitem);

	return $total;
}


function iconFeedbackStatusByUserReportID($id)
{
	if(checkFeedbackEndByUserReportID($id))
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	elseif(getTotalFeedbackByUserReportID($id)==0) 
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Pending\" align=\"absbottom\" />";
	else
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Pending\" align=\"absbottom\" />";
}

function getReportByByID($id)
{
	$query_ss = "SELECT user_stafid FROM mbj.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['user_stafid'];
}

function checkReportID($urid, $userid)
{
	$query_ss = "SELECT userreport_id FROM mbj.user_report WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else

		return false;
}

function iconFeedbackApprovalByUserReportID($id)
{
	if(checkFeedbackApprovalByUserReportID($id))
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Pending\" align=\"absbottom\" />";
}


function getReportTypeByID($id)
{
	if($id!=0)
	{
		$query_mbjitem = "SELECT reporttype_name FROM mbj.report_type WHERE reporttype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		$mbjitem = mysql_query($query_mbjitem);
		$row_mbjitem = mysql_fetch_assoc($mbjitem);
		
		$view = $row_mbjitem['reporttype_name'];
	}
	return $view;
}



function getReportDateDMYByID($id, $dmy)
{
	$query_mbjitem = "SELECT userreport_date_d, userreport_date_m, userreport_date_y FROM mbj.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
	if($dmy==1)
		return date('d', mktime(0, 0, 0, $row_mbjitem['userreport_date_m'], $row_mbjitem['userreport_date_d'], $row_mbjitem['userreport_date_y']));
	elseif($dmy==2)
		return date('m', mktime(0, 0, 0, $row_mbjitem['userreport_date_m'], $row_mbjitem['userreport_date_d'], $row_mbjitem['userreport_date_y']));
	elseif($dmy==3)
		return date('Y', mktime(0, 0, 0, $row_mbjitem['userreport_date_m'], $row_mbjitem['userreport_date_d'], $row_mbjitem['userreport_date_y']));
}

function getReportNoteByID($id)
{
	$query_ss = "SELECT userreport_note FROM mbj.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userreport_note']!=NULL)
		return $row_ss['userreport_note'];
}


function getReportDate($id, $view=0)
{
	$query_ss = "SELECT userreport_date_d, userreport_date_m, userreport_date_y, userreport_date_h FROM mbj.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($view==0)
		$date = date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y'])) . " " . $row_ss['userreport_date_h'];
	else
		$date = date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y'])) . "<br/>" . $row_ss['userreport_date_h'];
	
	return $date;
}


function getReportDateByID($id)
{
	$query_mbjitem = "SELECT userreport_date_d, userreport_date_m, userreport_date_y FROM mbj.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_mbjitem['userreport_date_m'], $row_mbjitem['userreport_date_d'], $row_mbjitem['userreport_date_y']));
}




function getCategoryReportNameByID($id)		
	{
	$query_mbjitem = "SELECT category_name FROM mbj.category WHERE category_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$mbjitem = mysql_query($query_mbjitem);
	$row_mbjitem = mysql_fetch_assoc($mbjitem);
	
	return getCategoryReportNameByID($row_mbjitem['category_name']);
}

function checkReportFeedbackByID($urid)
{
	$query_ss = "SELECT urf_id, urf_date_d, urf_date_m, urf_date_y, urf_date_h FROM (SELECT * FROM mbj.user_reportfeedback ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC) AS user_reportfeedback WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' GROUP BY userreport_id ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
}

function checkReportApprovalmbj($urid)
{
	$query_ss = "SELECT userreport_star FROM mbj.user_report WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userreport_star']!=0 && checkFeedbackEnd($urid))
		return true;
	else
		return false;
}


function iconReportStatus($urid)
{
	if(checkFeedbackEnd($urid))
		return "<img src=\"../icon/sign_tick.png\"/>";
	else
		return "<img src=\"../icon/lock.png\"/>";
}

function iconReportAprrovalStatus($urid)
{
	if(checkReportApprovalmbj($urid))
		return "<img src=\"../icon/sign_tick.png\"/>";
	else
		return "<img src=\"../icon/lock.png\"/>";
}

function countNewReport($d=0, $m=0, $y=0, $end=0)
{
	$wsql = "";
	if($d!=0)
		$wsql .= " AND user_report.userreport_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND user_report.userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND user_report.userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
	if($end==1)
	{
		// Ada tindakan tp tidak tamat
		$wsql .= " AND EXISTS (SELECT user_reportfeedback.userreport_id FROM mbj.user_reportfeedback WHERE user_reportfeedback.urf_status = 1 AND user_report.userreport_id = user_reportfeedback.userreport_id AND NOT EXISTS (SELECT user_reportfeedback.userreport_id FROM mbj.user_reportfeedback WHERE user_reportfeedback.feedbacktype_id = 0 AND user_report.userreport_id = user_reportfeedback.userreport_id GROUP BY user_reportfeedback.userreport_id) GROUP BY user_reportfeedback.userreport_id)";
	} else if($end==2) {
		// Tiada tindakan
		$wsql .= " AND NOT EXISTS (SELECT user_reportfeedback.userreport_id FROM mbj.user_reportfeedback WHERE user_reportfeedback.urf_status = 1 AND user_report.userreport_id = user_reportfeedback.userreport_id GROUP BY user_reportfeedback.userreport_id)";
	} else if($end==3) {
		// Tamat
		$wsql .= " AND EXISTS (SELECT user_reportfeedback.userreport_id FROM mbj.user_reportfeedback WHERE user_reportfeedback.feedbacktype_id = 0 AND user_reportfeedback.urf_status = 1 AND user_report.userreport_id = user_reportfeedback.userreport_id GROUP BY user_reportfeedback.userreport_id)";
	};
		
	$query_ss = "SELECT user_report.userreport_id FROM mbj.user_report WHERE user_report.userreport_status = 1 " . $wsql . " ORDER BY user_report.userreport_date_y DESC, user_report.userreport_date_m DESC, user_report.userreport_date_d DESC, user_report.userreport_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return $total;
	else
		return 0;
}


function getTotalmbjStarRatingByUserID($userid, $m, $y)
{
	$wsql = "";
	
	if($m != '0')
		$wsql .= " AND user_report.userreport_date_m='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != '0')
		$wsql .= " AND user_report.userreport_date_y='" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT COUNT(userreport_star) AS totalstar FROM mbj.user_report LEFT JOIN mbj.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_report.userreport_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql . " ORDER BY user_report.userreport_date_y DESC, user_report.userreport_date_m DESC, user_report.userreport_date_d DESC, user_report.userreport_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return ($row_ss['totalstar']*5);
}

function getmbjRespondByUserID($userid, $m, $y, $daytype)
{
	$wsql = "";
	
	if($m != '0')
		$wsql .= " AND user_report.userreport_date_m='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != '0')
		$wsql .= " AND user_report.userreport_date_y='" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT userreport_date_d, userreport_date_m, userreport_date_y, urf_date_d, urf_date_m, urf_date_y FROM mbj.user_report LEFT JOIN mbj.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_report.userreport_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql . " ORDER BY user_report.userreport_date_y DESC, user_report.userreport_date_m DESC, user_report.userreport_date_d DESC, user_report.userreport_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$totalall = mysql_num_rows($user_ss);
	
	$total = 0;
	
	if($totalall>0)
	{
		do {
		$day = round(abs(mktime(0, 0, 0, $row_ss['urf_date_m'], $row_ss['urf_date_d'], $row_ss['urf_date_y']) - mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y'])) / 86400);
		
		if($daytype=='1' && $day==0)
			$total+=1;
		else if($daytype=='3' && ($day>0 && $day<=2))
			$total+=1;
		else if($daytype=='7' && ($day>2 && $day<=6))
			$total+=1;
		else if($daytype=='8' && $day>=7)
			$total+=1;
		} while($row_ss = mysql_fetch_assoc($user_ss));
	};
	
	return $total;
}

function getmbjTotalReportByUserID($userid, $m, $y)
{
	$wsql = "";
	
	if($m != '0')
		$wsql .= " AND user_report.userreport_date_m='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != '0')
		$wsql .= " AND user_report.userreport_date_y='" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT COUNT(userreport_star) AS totalstar FROM mbj.user_report LEFT JOIN mbj.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_report.userreport_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql . " ORDER BY user_report.userreport_date_y DESC, user_report.userreport_date_m DESC, user_report.userreport_date_d DESC, user_report.userreport_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['totalstar'];
}

function getmbjPercStarRatingByUserID($userid, $m, $y)
{
	$total = getTotalmbjStarRatingByUserID($userid, $m, $y);
	
	if($total>0)
		$perc = ((getmbjStarRatingByUserID($userid, $m, $y)/$total)*100);
	else
		$perc = 0;
		
	return $perc;
}
?>
<?php
//feedback
function checkFeedbackEnd($urid)
{
	$query_ss = "SELECT feedbacktype_id FROM mbj.user_reportfeedback WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' AND feedbacktype_id = 0 LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		return true;
	else
		return false;
}

function getReportTypeName($id)
{
	$query_ss = "SELECT reporttype_name FROM mbj.report_type WHERE reporttype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
		return $row_ss['reporttype_name'];
}

function getFeedbackTypeName($id)
{
	$query_ss = "SELECT feedbacktype_name FROM mbj.feedback_type WHERE feedbacktype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($id!=0)
		return $row_ss['feedbacktype_name'];
	else
		return "Tamat";
}

function getReportTypeByURFID($urfid)
{
	$query_ss = "SELECT reporttype_id FROM mbj.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['reporttype_id'];
}

function getFeedbackTypeByURFID($urfid)
{
	$query_ss = "SELECT feedbacktype_id FROM mbj.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['feedbacktype_id'];
}

function getFeedbackNoteByURFID($urfid)
{
	$query_ss = "SELECT urf_note FROM mbj.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['urf_note'];
}

function getFeedbackByByURFID($urfid)
{
	$query_ss = "SELECT urf_by FROM mbj.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['urf_by'];
}

function getFeedbackDateByURFID($urfid)
{
	$query_ss = "SELECT urf_date_d, urf_date_m, urf_date_y, urf_date_h FROM mbj.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['urf_date_m'], $row_ss['urf_date_d'], $row_ss['urf_date_y'])) . " " . $row_ss['urf_date_h'];
}

function checkFeedbackActionByURFID($urfid)
{
	$query_ss = "SELECT urf_stafid FROM mbj.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['urf_stafid']!='0')
		return true;
	else 
		return false;
}

function getFeedbackActionStafIDByURFID($urfid)
{
	$query_ss = "SELECT urf_stafid FROM mbj.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['urf_stafid']!='0')
		return $row_ss['urf_stafid'];
	else 
		return 0;
}

function getFeedbackLastDate($urid)
{
	$query_ss = "SELECT urf_id, urf_date_d, urf_date_m, urf_date_y, urf_date_h FROM (SELECT * FROM mbj.user_reportfeedback ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC) AS user_reportfeedback WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' GROUP BY userreport_id ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['urf_date_m'], $row_ss['urf_date_d'], $row_ss['urf_date_y'])) . " " . $row_ss['urf_date_h'];
	else
		return 0;
}

function getFeedbackLastStafID($urid)
{
	$query_ss = "SELECT urf_by FROM (SELECT * FROM mbj.user_reportfeedback ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC) AS user_reportfeedback WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' GROUP BY userreport_id ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	return $row_ss['urf_by'];
}

function getFeedbackLastNote($urid)
{
	$query_ss = "SELECT urf_note FROM (SELECT * FROM mbj.user_reportfeedback ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC) AS user_reportfeedback WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' GROUP BY userreport_id ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	return $row_ss['urf_note'];
}

function countFeedbackLastDate($urid)
{
	$query_ss = "SELECT user_reportfeedback.urf_id, user_reportfeedback.urf_date_d, user_reportfeedback.urf_date_m, user_reportfeedback.urf_date_y, user_reportfeedback.urf_date_h FROM (SELECT * FROM mbj.user_reportfeedback ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC) AS user_reportfeedback WHERE user_reportfeedback.userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' GROUP BY user_reportfeedback.userreport_id ORDER BY user_reportfeedback.urf_date_y DESC, user_reportfeedback.urf_date_m DESC, user_reportfeedback.urf_date_d DESC, user_reportfeedback.urf_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
	{
		$cday = (mktime(0, 0, 0, date('m'), date('d'), date('Y')) - mktime(0, 0, 0, $row_ss['urf_date_m'], $row_ss['urf_date_d'], $row_ss['urf_date_y']));
		return ($cday/86400);
	} else {
		$cday = (mktime(0, 0, 0, date('m'), date('d'), date('Y')) - mktime(0, 0, 0, getReportDateDMYByID($urid, 2), getReportDateDMYByID($urid, 1), getReportDateDMYByID($urid, 3)));
		return ($cday/86400);
	}
}