<?php
//survey
function getSurveyView($sdid)
{
	$query_ss = "SELECT sd_id, sd_view FROM selidik.surveydetail WHERE sd_id = '" . htmlspecialchars($sdid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['sd_view']==1 && (checkStartDateBySDID($row_ss['sd_id'], date('d'), date('m'), date('Y')) && checkEndDateBySDID($row_ss['sd_id'], date('d'), date('m'), date('Y'))))
		return true;
	else
		return false;
};

function getSurveyDivision($sdid)
{
	$query_ss = "SELECT division_id FROM selidik.surveydetail WHERE sd_id = '" . htmlspecialchars($sdid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['division_id'];
};

function getSurveyGroup($sdid)
{
	$query_ss = "SELECT group_id FROM selidik.surveydetail WHERE sd_id = '" . htmlspecialchars($sdid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['group_id'];
};

function getSurveyTitle($sdid)
{
	$query_ss = "SELECT sd_title FROM selidik.surveydetail WHERE sd_id = '" . htmlspecialchars($sdid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['sd_title'];
};

function getSurveyDateStart($id, $dmy=0)
{
	$query_ss = "SELECT sd_date_d, sd_date_m, sd_date_y FROM selidik.surveydetail WHERE sd_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($dmy==1)
		$ds = date('d', mktime(0, 0, 0, $row_ss['sd_date_m'], $row_ss['sd_date_d'], $row_ss['sd_date_y']));
	elseif($dmy==2)
		$ds = date('m', mktime(0, 0, 0, $row_ss['sd_date_m'], $row_ss['sd_date_d'], $row_ss['sd_date_y']));
	elseif($dmy==3)
		$ds = date('Y', mktime(0, 0, 0, $row_ss['sd_date_m'], $row_ss['sd_date_d'], $row_ss['sd_date_y']));
	else
		$ds = date('d / m / Y', mktime(0, 0, 0, $row_ss['sd_date_m'], $row_ss['sd_date_d'], $row_ss['sd_date_y']));
	
	return $ds;
};

function getSurveyDateEnd($id)
{
	$query_ss = "SELECT sd_end_d, sd_end_m, sd_end_y FROM selidik.surveydetail WHERE sd_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$ds = date('d / m / Y', mktime(0, 0, 0, $row_ss['sd_end_m'], $row_ss['sd_end_d'], $row_ss['sd_end_y']));
	
	return $ds;
};

function checkStartDateBySDID($sdid, $d, $m, $y)
{
	$query_ss = "SELECT sd_date_d, sd_date_m, sd_date_y FROM selidik.surveydetail WHERE sd_id = '" . htmlspecialchars($sdid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$day = ((mktime(0, 0, 0, $m, $d, $y) - mktime(0, 0, 0, $row_ss['sd_date_m'], $row_ss['sd_date_d'], $row_ss['sd_date_y']))/86400);
	
	if($day >=0)
		return true;
	else
		return false;
};

function checkEndDateBySDID($sdid, $d, $m, $y)
{
	$query_ss = "SELECT sd_end_d, sd_end_m, sd_end_y FROM selidik.surveydetail WHERE sd_id = '" . htmlspecialchars($sdid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$day = ((mktime(0, 0, 0, $m, $d, $y) - mktime(0, 0, 0, $row_ss['sd_end_m'], $row_ss['sd_end_d'], $row_ss['sd_end_y']))/86400);
	
	if($day <=0)
		return true;
	else
		return false;
};

function checkAnswer($userid, $qid)
{
	$query_ss = "SELECT ua_id FROM selidik.user_answer WHERE q_id = '" . htmlspecialchars($qid, ENT_QUOTES) . "' AND user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
};

function checkAnswerBySDID($userid, $sdid)
{
	$query_ss = "SELECT user_answer.ua_id, question.sd_id FROM selidik.user_answer LEFT JOIN selidik.question ON user_answer.q_id = question.q_id WHERE question.sd_id = '" . htmlspecialchars($sdid, ENT_QUOTES) . "' AND user_answer.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "'";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
};

function countUserAnswer($qid)
{
	$query_ss = "SELECT user_answer.ua_id FROM selidik.user_answer WHERE q_id = '" . htmlspecialchars($qid, ENT_QUOTES) . "'";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	return $total;
};

function countAnswer($qid, $ans)
{
	$query_ss = "SELECT COUNT(ua_id) AS count FROM selidik.user_answer WHERE q_id = '" . htmlspecialchars($qid, ENT_QUOTES) . "' AND ua_answer = '" . htmlspecialchars($ans, ENT_QUOTES) . "' GROUP BY ua_answer";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($row_ss['count']!=NULL)
		return $row_ss['count'];
	else
		return 0;
};

function countAnswerBySDID($sdid)
{
	$query_ss = "SELECT ua_id FROM selidik.user_answer LEFT JOIN selidik.question ON question.q_id = user_answer.q_id WHERE question.sd_id = '" . htmlspecialchars($sdid, ENT_QUOTES) . "' GROUP BY user_answer.user_stafid";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		return $total;
	else
		return 0;
};

function percentUserAnswer($sdid)
{
		
	if(getSurveyDivision($sdid)!=0 && getSurveyGroup($sdid)==0)
		$totalstaff = totalUserByDirSub(getSurveyDivision($sdid), 0);
	else if(getSurveyDivision($sdid) ==0 && getSurveyGroup($sdid)!=0)
		$totalstaff = totalUserByGroupGred(getSurveyGroup($sdid), 0);
	else if(getSurveyDivision($sdid) !=0 && getSurveyGroup($sdid)!=0)
		$totalstaff = totalUserByDirAndGroupGred(getSurveyDivision($sdid), getSurveyGroup($sdid), 0);
	else
		$totalstaff = totalStaff(getSurveyDateStart($sdid, 1), getSurveyDateStart($sdid, 2), getSurveyDateStart($sdid, 3));
		
	if($totalstaff!=0 && $totalstaff!=NULL)
		$p = (countAnswerBySDID($sdid)/$totalstaff)*100;
	else
		$p = 0;
		
	if($p < 1)
		$p = round($p, 1);
	else
		$p = round($p);
		
	return $p;
};

function percentAnswer($qid, $ans)
{
	if(countAnswer($qid, $ans)!=0 && countUserAnswer($qid)!=0)
		return round((countAnswer($qid, $ans)/countUserAnswer($qid))*100);
	else
		return 0;
};

function averageAnswer($qid)
{
	$total = 0;
	$anstotal = 0;
	for($i=1; $i<=5; $i++)
	{
		$anstotal += countAnswer($qid, $i)*$i;
		$total += countAnswer($qid, $i);
	};
	
	if($total>0)
		$ave = round(($anstotal / $total),2);
	else
		$ave = 0;
	
	return $ave;
};

function totalAverage($sqid)
{
	$query_ss = "SELECT ua_answer, COUNT(ua_answer) AS countans, SUM(ua_answer) AS sumans FROM selidik.user_answer LEFT JOIN selidik.question ON question.q_id = user_answer.q_id WHERE question.sd_id = '" . htmlspecialchars($sqid, ENT_QUOTES) . "' GROUP BY question.sd_id";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$tc = 0;
	$ts = 0;
	
	if($row_ss['sumans']>0)
		$p = round(($row_ss['sumans']/$row_ss['countans']), 2);
	else
		$p = 0;
		
	return $p;
}

function checkSurveyMandatory($userid)
{
	$query_ss = "SELECT sd_id FROM selidik.surveydetail WHERE sd_view = 1 AND sd_mandatory = '1' AND sd_status = '1' ORDER BY sd_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$v = 0;
	
	do {
		if((getGroupIDByUserID($userid)==getSurveyGroup($row_ss['sd_id'])) || (getSurveyGroup($row_ss['sd_id'])==0)){
			if((getDirSubIDByUser($userid)==getSurveyDivision($row_ss['sd_id'])) || (getSurveyDivision($row_ss['sd_id'])==0)){
				if(!checkAnswerBySDID($userid, $row_ss['sd_id']) && (checkStartDateBySDID($row_ss['sd_id'], date('d'), date('m'), date('Y')) && checkEndDateBySDID($row_ss['sd_id'], date('d'), date('m'), date('Y'))))
				{
					$v = $row_ss['sd_id'];
				}
			}
		}
	} while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $v;
};
?>