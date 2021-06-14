<?php
//IDEAS

function getAllIdeasID($d=0, $m=0, $y=0, $idstype=0, $limit=0, $orderby=0)
{
	$wsql = "";
	
	if($d != 0)
		$wsql .= " AND ids_date_d ='" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m != 0)
		$wsql .= " AND ids_date_m ='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != 0)
		$wsql .= " AND ids_date_y ='" . htmlspecialchars($y, ENT_QUOTES) . "'";
	if($idstype != 0)
		$wsql .= " AND idstype_id ='" . htmlspecialchars($idstype, ENT_QUOTES) . "'";
		
	if($orderby!=0 && $orderby==1)
		$ob = " ORDER BY total DESC";
	elseif($orderby!=0 && $orderby==2)
		$ob = " ORDER BY total ASC";
	else
		$ob = " ORDER BY ids_id DESC";
	
	if($limit==0)
		$lsql = " LIMIT 50";
		
	$query_ss = "SELECT ids.ids_id, total FROM ideas.ids LEFT JOIN (SELECT ids_support.ids_id, COUNT(idss_id) AS total FROM ideas.ids_support WHERE idss_status = 1 GROUP BY ids_support.ids_id) AS idss ON idss.ids_id = ids.ids_id WHERE ids_status = 1 " . $wsql . " " . $ob  . " " . $lsql;	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$idid = array();
	
	do {
		$idid[] = $row_ss['ids_id'];
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $idid;
};

function countAllIdeasID($d=0, $m=0, $y=0, $idstype=0)
{
	if(array_filter(getAllIdeasID($d, $m, $y, $idstype)))
		return count(getAllIdeasID($d, $m, $y, $idstype));
	else
		return 0;
};

function getIdeasDetailByID($idsid)
{
	$query_ss = "SELECT ids_detail FROM ideas.ids WHERE ids_status = 1 AND ids_id = '" . htmlspecialchars($idsid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ids_detail'];
};

function getIdeasDateByID($idsid)
{
	$query_ss = "SELECT ids_date_d, ids_date_m, ids_date_y, ids_date_hms FROM ideas.ids WHERE ids_status = 1 AND ids_id = '" . htmlspecialchars($idsid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y', mktime(0, 0, 0, $row_ss['ids_date_m'], $row_ss['ids_date_d'], $row_ss['ids_date_y'])) . " " . $row_ss['ids_date_hms'];
};

function getIdeasTypeByIdeasID($idsid)
{
	$query_ss = "SELECT idstype_id FROM ideas.ids WHERE ids_status = 1 AND ids_id = '" . htmlspecialchars($idsid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['idstype_id'];
};

function checkUserByDate($userid, $d=0, $m=0, $y=0)
{
	if($d==0)
		$d = date('d');
	if($m==0)
		$m = date('m');
	if($y==0)
		$y = date('Y');
		
	$query_ss = "SELECT ids_id FROM ideas.ids WHERE ids_status = 1 AND ids_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND ids_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND ids_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND ids_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		return true;
	else
		return false;
};

function countExpiredByIdeasID($idsid)
{
	$query_ss = "SELECT ids_date_d, ids_date_m, ids_date_y, ids_date_hms FROM ideas.ids WHERE ids_status = 1 AND ids_id = '" . htmlspecialchars($idsid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$bal = mktime(0, 0, 0, $row_ss['ids_date_m'], $row_ss['ids_date_d']+14, $row_ss['ids_date_y']) - mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	
	$day = $bal / (60 * 60 * 24);
	
	return $day;
	
}

function checkExpiredByIdeasID($idsid)
{
	if(countExpiredByIdeasID($idsid)>0)
		return true;
	else
		return false;
}

//IDEAS type
function getAllIdeasTypeID()
{
	$query_ss = "SELECT idstype_id FROM ideas.ids_type WHERE idstype_status = 1 ORDER BY idstype_name ASC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$idid = array();
	
	do {
		$idid[] = $row_ss['idstype_id'];
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $idid;
};

function getIdeasTypeNameByID($idstypeid)
{
	$query_ss = "SELECT idstype_name FROM ideas.ids_type WHERE idstype_status = 1 AND idstype_id = '" . htmlspecialchars($idstypeid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['idstype_name'];
};

// IDEAS Support
function getAllIdeasSupportByIdeasID($idsid)
{
	$query_ss = "SELECT idss_id FROM ideas.ids_support WHERE idss_status = 1 AND ids_id='" . htmlspecialchars($idsid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$idssid = array();
	
	do {
		$idssid[] = $row_ss['idss_id'];
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $idssid;
};

function countAllIdeasSupportByIdeasID($idsid)
{
	if(array_filter(getAllIdeasSupportByIdeasID($idsid)))
		return count(getAllIdeasSupportByIdeasID($idsid));
	else
		return 0;
};

function getPercentageUserVoteByIdeasID($idsid)
{
	$query_ss = "SELECT ids_date_d, ids_date_m, ids_date_y, ids_date_hms FROM ideas.ids WHERE ids_status = 1 AND ids_id = '" . htmlspecialchars($idsid, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return round(countAllIdeasSupportByIdeasID($idsid)/totalStaff($row_ss['ids_date_d'], $row_ss['ids_date_m'], $row_ss['ids_date_y']),1);
};

function checkUserVoteByIdeasID($userid, $idsid)
{
	$query_ss = "SELECT idss_id FROM ideas.ids_support WHERE idss_status = 1 AND user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND ids_id='" . htmlspecialchars($idsid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		return true;
	else
		return false;
}
?>