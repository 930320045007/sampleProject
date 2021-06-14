<?php
//aduan
function getCategoryNameByID($id)
{
	$query_ss = "SELECT category_name FROM harta.category  WHERE category_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['category_name'];
}

function getCategoryIDBySubCategoryID($subcatid)
{
	$query_ss = "SELECT category_id FROM harta.subcategory  WHERE subcategory_id = '" . htmlspecialchars($subcatid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['category_id'];
}

function getCategoryCodeByID($id)
{
	$query_ss = "SELECT category_code FROM harta.category  WHERE category_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['category_code'];
}

function getSubCategoryNameByID($id)
{
	$query_ss = "SELECT subcategory_name FROM harta.subcategory  WHERE subcategory_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['subcategory_name'];
}

function getRCTitleByID($id)
{
	$query_ss = "SELECT rc_title FROM harta.report_case WHERE rc_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['rc_title'];
}

function getCategoryCodeBySubCategoryID($scid)
{
	$query_ss = "SELECT category_id FROM harta.subcategory  WHERE subcategory_id = '" . htmlspecialchars($scid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return getCategoryCodeByID($row_ss['category_id']);
}

function getCategoryNameBySubCategoryID($scid)
{
	$query_ss = "SELECT category_id FROM harta.subcategory  WHERE subcategory_id = '" . htmlspecialchars($scid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return getCategoryNameByID($row_ss['category_id']);
}

function getCategoryIDByRCID($rcid)
{
	$query_ss = "SELECT subcategory.category_id FROM harta.report_case LEFT JOIN harta.subcategory ON subcategory.subcategory_id = report_case.subcategory_id WHERE report_case.rc_id = '" . htmlspecialchars($rcid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['category_id'];
}

function getCategoryCodeByRCID($rcid)
{
	$query_ss = "SELECT subcategory_id FROM harta.report_case WHERE rc_id = '" . htmlspecialchars($rcid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return getCategoryCodeBySubCategoryID($row_ss['subcategory_id']);
}

function getCategoryNameByRCID($rcid)
{
	$query_ss = "SELECT subcategory_id FROM harta.report_case WHERE rc_id = '" . htmlspecialchars($rcid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return getCategoryNameBySubCategoryID($row_ss['subcategory_id']);
}

function getSubCategoryNameByRCID($rcid)
{
	$query_ss = "SELECT subcategory_id FROM harta.report_case WHERE rc_id = '" . htmlspecialchars($rcid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return getSubCategoryNameByID($row_ss['subcategory_id']);
}

function checkLimitReport($userid, $d, $m, $y)
{
	// Semakkan aduan hanya sebanyak 5 kali sehari
	$query_ss = "SELECT user_report.* FROM harta.user_report WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userreport_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' ORDER BY userreport_date_y DESC, userreport_date_m DESC, userreport_date_d DESC, userreport_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total <= 5)
		return true;
	else
		return false;
}

function checkReportID($urid, $userid)
{
	$query_ss = "SELECT userreport_id FROM harta.user_report WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
}



function getReportID($rcid, $userid, $d, $m, $y)
{
	$query_ss = "SELECT user_report.* FROM harta.user_report WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND rc_id = '" . htmlspecialchars($rcid, ENT_QUOTES) . "' AND userreport_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' ORDER BY userreport_date_y DESC, userreport_date_m DESC, userreport_date_d DESC, userreport_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return $row_ss['userreport_id'];
	else
		return 0;
}

function getReportCaseByURID($urid)
{
	$query_ss = "SELECT rc_id FROM harta.user_report WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['rc_id'];
}

function getNewReportTicketByRCID($rcid)
{
	$query_ss = "SELECT userreport_ticket, subcategory.category_id FROM (SELECT * FROM harta.user_report ORDER BY user_report.userreport_ticket DESC) AS user_report LEFT JOIN harta.report_case ON report_case.rc_id = user_report.rc_id LEFT JOIN harta.subcategory ON subcategory.subcategory_id = report_case.subcategory_id WHERE subcategory.category_id = '" . getCategoryIDByRCID(htmlspecialchars($rcid, ENT_QUOTES)) . "' ORDER BY user_report.userreport_ticket DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return ($row_ss['userreport_ticket']+1);
}

function getReportTicketByID($id)
{
	$query_ss = "SELECT userreport_ticket, rc_id FROM harta.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return getCategoryCodeByRCID($row_ss['rc_id']) . " " . $row_ss['userreport_ticket'];
}

function getReportDate($urid, $view=0)
{
	$query_ss = "SELECT userreport_date_d, userreport_date_m, userreport_date_y, userreport_date_h FROM harta.user_report WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($view==0)
		$date = date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y'])) . " " . $row_ss['userreport_date_h'];
	else
		$date = date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y'])) . "<br/>" . $row_ss['userreport_date_h'];
	
	return $date;
}

function getReportDateDMY($urid, $dmy)
{
	$query_ss = "SELECT userreport_date_d, userreport_date_m, userreport_date_y, userreport_date_h FROM harta.user_report WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($dmy==1)
		return $row_ss['userreport_date_d'];
	else if($dmy==2)
		return $row_ss['userreport_date_m'];
	else if($dmy==3)
		return $row_ss['userreport_date_y'];
}

function getReportLocationByID($id)
{
	$query_ss = "SELECT userreport_location FROM harta.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userreport_location']!=NULL)
		return $row_ss['userreport_location'];
	else
		return "Tidak dinyatakan";
}

function getReportByByID($id)
{
	$query_ss = "SELECT user_stafid FROM harta.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['user_stafid'];
}

function checkReportFeedbackByID($urid)
{
	$query_ss = "SELECT urf_id, urf_date_d, urf_date_m, urf_date_y, urf_date_h FROM (SELECT * FROM harta.user_reportfeedback ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC) AS user_reportfeedback WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' GROUP BY userreport_id ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
}

function checkReportApprovalHarta($urid)
{
	$query_ss = "SELECT userreport_star FROM harta.user_report WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userreport_star']!=0 && checkFeedbackEnd($urid))
		return true;
	else
		return false;
}

function checkAllReportEndApprovalByUserID($userid)
{
	$query_ss = "SELECT user_report.userreport_star FROM harta.user_report WHERE user_report.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_report.userreport_status = 1 AND user_report.userreport_star = 0 AND EXISTS(SELECT user_reportfeedback.* FROM harta.user_reportfeedback WHERE user_reportfeedback.feedbacktype_id = 0 AND user_reportfeedback.urf_status = 1 AND user_report.userreport_id = user_reportfeedback.userreport_id GROUP BY user_reportfeedback.userreport_id ORDER BY user_reportfeedback.urf_date_y DESC, user_reportfeedback.urf_date_m DESC, user_reportfeedback.urf_date_d DESC, user_reportfeedback.urf_id DESC) GROUP BY user_report.rc_id";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
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
	if(checkReportApprovalHarta($urid))
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
		$wsql .= " AND EXISTS (SELECT user_reportfeedback.userreport_id FROM harta.user_reportfeedback WHERE user_reportfeedback.urf_status = 1 AND user_report.userreport_id = user_reportfeedback.userreport_id AND NOT EXISTS (SELECT user_reportfeedback.userreport_id FROM harta.user_reportfeedback WHERE user_reportfeedback.feedbacktype_id = 0 AND user_report.userreport_id = user_reportfeedback.userreport_id GROUP BY user_reportfeedback.userreport_id) GROUP BY user_reportfeedback.userreport_id)";
	} else if($end==2) {
		// Tiada tindakan
		$wsql .= " AND NOT EXISTS (SELECT user_reportfeedback.userreport_id FROM harta.user_reportfeedback WHERE user_reportfeedback.urf_status = 1 AND user_report.userreport_id = user_reportfeedback.userreport_id GROUP BY user_reportfeedback.userreport_id)";
	} else if($end==3) {
		// Tamat
		$wsql .= " AND EXISTS (SELECT user_reportfeedback.userreport_id FROM harta.user_reportfeedback WHERE user_reportfeedback.feedbacktype_id = 0 AND user_reportfeedback.urf_status = 1 AND user_report.userreport_id = user_reportfeedback.userreport_id GROUP BY user_reportfeedback.userreport_id)";
	};
		
	$query_ss = "SELECT user_report.userreport_id FROM harta.user_report WHERE user_report.userreport_status = 1 " . $wsql . " ORDER BY user_report.userreport_date_y DESC, user_report.userreport_date_m DESC, user_report.userreport_date_d DESC, user_report.userreport_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return $total;
	else
		return 0;
}

function countByCategory($d, $m, $y, $cat)
{
	$wsql = "";
	if($d != '0')
		$wsql .= " AND user_report.userreport_date_d='" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m != '0')
		$wsql .= " AND user_report.userreport_date_m='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != '0')
		$wsql .= " AND user_report.userreport_date_y='" . htmlspecialchars($y, ENT_QUOTES) . "'";
	if($cat != '0')
		$wsql .= " AND subcategory.category_id = '" . htmlspecialchars($cat, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT userreport_id FROM harta.user_report LEFT JOIN harta.report_case ON report_case.rc_id = user_report.rc_id LEFT JOIN harta.subcategory ON subcategory.subcategory_id = report_case.subcategory_id WHERE user_report.userreport_status = 1 " . $wsql . " ORDER BY user_report.userreport_date_y DESC, user_report.userreport_date_m DESC, user_report.userreport_date_d DESC, user_report.userreport_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	return $total;
}

function getHartaStarRatingByUserID($userid, $m, $y)
{
	$wsql = "";
	
	if($m != '0')
		$wsql .= " AND user_report.userreport_date_m='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != '0')
		$wsql .= " AND user_report.userreport_date_y='" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT SUM(userreport_star) AS totalstar FROM harta.user_report LEFT JOIN harta.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_report.userreport_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_report.userreport_star > 0 AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql . " ORDER BY user_report.userreport_date_y DESC, user_report.userreport_date_m DESC, user_report.userreport_date_d DESC, user_report.userreport_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['totalstar'];
}

function getTotalHartaStarRatingByUserID($userid, $m, $y)
{
	$wsql = "";
	
	if($m != '0')
		$wsql .= " AND user_report.userreport_date_m='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != '0')
		$wsql .= " AND user_report.userreport_date_y='" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT COUNT(userreport_star) AS totalstar FROM harta.user_report LEFT JOIN harta.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_report.userreport_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql . " ORDER BY user_report.userreport_date_y DESC, user_report.userreport_date_m DESC, user_report.userreport_date_d DESC, user_report.userreport_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return ($row_ss['totalstar']*5);
}

function getHartaRespondByUserID($userid, $m, $y, $daytype)
{
	$wsql = "";
	
	if($m != '0')
		$wsql .= " AND user_report.userreport_date_m='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != '0')
		$wsql .= " AND user_report.userreport_date_y='" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT userreport_date_d, userreport_date_m, userreport_date_y, urf_date_d, urf_date_m, urf_date_y FROM harta.user_report LEFT JOIN harta.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_report.userreport_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql . " ORDER BY user_report.userreport_date_y DESC, user_report.userreport_date_m DESC, user_report.userreport_date_d DESC, user_report.userreport_id DESC";	
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

function getHartaTotalReportByUserID($userid, $m, $y)
{
	$wsql = "";
	
	if($m != '0')
		$wsql .= " AND user_report.userreport_date_m='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != '0')
		$wsql .= " AND user_report.userreport_date_y='" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT COUNT(userreport_star) AS totalstar FROM harta.user_report LEFT JOIN harta.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_report.userreport_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql . " ORDER BY user_report.userreport_date_y DESC, user_report.userreport_date_m DESC, user_report.userreport_date_d DESC, user_report.userreport_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['totalstar'];
}

function getHartaPercStarRatingByUserID($userid, $m, $y)
{
	$total = getTotalHartaStarRatingByUserID($userid, $m, $y);
	
	if($total>0)
		$perc = ((getHartaStarRatingByUserID($userid, $m, $y)/$total)*100);
	else
		$perc = 0;
		
	return $perc;
}
?>
<?php
//feedback
function checkFeedbackEnd($urid)
{
	$query_ss = "SELECT feedbacktype_id FROM harta.user_reportfeedback WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' AND feedbacktype_id = 0 LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		return true;
	else
		return false;
}

function getFeedbackTypeName($id)
{
	$query_ss = "SELECT feedbacktype_name FROM harta.feedback_type WHERE feedbacktype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($id!=0)
		return $row_ss['feedbacktype_name'];
	else
		return "Tamat";
}

function getFeedbackTypeByURFID($urfid)
{
	$query_ss = "SELECT feedbacktype_id FROM harta.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['feedbacktype_id'];
}

function getFeedbackNoteByURFID($urfid)
{
	$query_ss = "SELECT urf_note FROM harta.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['urf_note'];
}

function getFeedbackByByURFID($urfid)
{
	$query_ss = "SELECT urf_by FROM harta.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['urf_by'];
}

function getFeedbackDateByURFID($urfid)
{
	$query_ss = "SELECT urf_date_d, urf_date_m, urf_date_y, urf_date_h FROM harta.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['urf_date_m'], $row_ss['urf_date_d'], $row_ss['urf_date_y'])) . " " . $row_ss['urf_date_h'];
}

function checkFeedbackActionByURFID($urfid)
{
	$query_ss = "SELECT urf_stafid FROM harta.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['urf_stafid']!='0')
		return true;
	else 
		return false;
}

function getFeedbackActionStafIDByURFID($urfid)
{
	$query_ss = "SELECT urf_stafid FROM harta.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['urf_stafid']!='0')
		return $row_ss['urf_stafid'];
	else 
		return 0;
}

function getFeedbackLastDate($urid)
{
	$query_ss = "SELECT urf_id, urf_date_d, urf_date_m, urf_date_y, urf_date_h FROM (SELECT * FROM harta.user_reportfeedback ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC) AS user_reportfeedback WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' GROUP BY userreport_id ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";	
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
	$query_ss = "SELECT urf_by FROM (SELECT * FROM harta.user_reportfeedback ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC) AS user_reportfeedback WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' GROUP BY userreport_id ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	return $row_ss['urf_by'];
}

function getFeedbackLastNote($urid)
{
	$query_ss = "SELECT urf_note FROM (SELECT * FROM harta.user_reportfeedback ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC) AS user_reportfeedback WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' GROUP BY userreport_id ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	return $row_ss['urf_note'];
}

function countFeedbackLastDate($urid)
{
	$query_ss = "SELECT user_reportfeedback.urf_id, user_reportfeedback.urf_date_d, user_reportfeedback.urf_date_m, user_reportfeedback.urf_date_y, user_reportfeedback.urf_date_h FROM (SELECT * FROM harta.user_reportfeedback ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC) AS user_reportfeedback WHERE user_reportfeedback.userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' GROUP BY user_reportfeedback.userreport_id ORDER BY user_reportfeedback.urf_date_y DESC, user_reportfeedback.urf_date_m DESC, user_reportfeedback.urf_date_d DESC, user_reportfeedback.urf_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
	{
		$cday = (mktime(0, 0, 0, date('m'), date('d'), date('Y')) - mktime(0, 0, 0, $row_ss['urf_date_m'], $row_ss['urf_date_d'], $row_ss['urf_date_y']));
		return ($cday/86400);
	} else {
		$cday = (mktime(0, 0, 0, date('m'), date('d'), date('Y')) - mktime(0, 0, 0, getReportDateDMY($urid, 2), getReportDateDMY($urid, 1), getReportDateDMY($urid, 3)));
		return ($cday/86400);
	}
}
/*
function getStafIDHarta()
{
	$query_ss = "SELECT urf_date_d, urf_date_m, urf_date_y, urf_date_h FROM harta.user_reportfeedback WHERE urf_id = '" . $urfid . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['urf_date_m'], $row_ss['urf_date_d'], $row_ss['urf_date_y'])) . " " . $row_ss['urf_date_h'];
}*/
?>
<?php
//item
function getUnitName($id)
{
	$query_ss = "SELECT set_name FROM harta.set WHERE set_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND set_status = 1 LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['set_name'];
}

function getUnitByItemID($id)
{
	$query_ss = "SELECT set_id FROM harta.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND item_status = 1 LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['set_id'];
}

function getItemName($id)
{
	$query_ss = "SELECT item_name FROM harta.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND item_status = 1 LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['item_name'];
}

function getItemUnit($id)
{
	$query_ss = "SELECT set_id FROM harta.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND item_status = 1 LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['set_id'];
}

function getItemKuantiti($id)
{
	$query_ss = "SELECT SUM(item_kuantiti) AS count FROM harta.item_stock WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND itemstock_status = 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['count']!=NULL)
		return $row_ss['count'];
	else
		return 0;
}

function getUserReportItemKuantiti($id)
{
	$query_ss = "SELECT SUM(useritem_kuantiti) AS count FROM harta.user_item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND useritem_status = 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['count']!=NULL)
		return $row_ss['count'];
	else
		return 0;
}

function getItemBalByItemID($id)
{
	return getItemKuantiti($id) - getUserReportItemKuantiti($id);
}
?>