<?php
//jkb
function getJkbID($userid, $d, $m, $y)
{		
	$query_ss = "SELECT jkb_id FROM finance.jkb WHERE jkb_status = '1' AND user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND jkb_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND jkb_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND jkb_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['jkb_id'];
}

function getDirIDByJkbID($id)
{		
	$query_ss = "SELECT dir_id FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
			
	return $row_ss['dir_id'];
}

function getCategory($id)
{		
	$query_ss = "SELECT category FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['category']=='1')
			$view = 'Baru';
	if($row_ss['category']=='2')
			$view = 'Penambahan';
			
	return $view;
}

function getAmountByJkbID($id)
{
	$query_ss = "SELECT SUM(apply_amount) AS total FROM finance.apply WHERE jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	 $total= $row_ss['total'];
	 
	 return $total;
}

function getAmountNotAppByJkbID($id)
{
	$query_ss = "SELECT SUM(apply_amount) AS total FROM finance.apply WHERE   jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) ."' AND applystatus_id = '2' ORDER BY jkb_id";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total= $row_ss['total'];
	 
	 return $total;
}

function getActualTotalAmountByJkbID($id)
{
	$total = getAmountByJkbID($id) - getAmountNotAppByJkbID($id);
	
	return $total;
}
	


function getJKBDate($id)
{		
	$query_ss = "SELECT jkb_date_d, jkb_date_m, jkb_date_y FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['jkb_date_m'], $row_ss['jkb_date_d'], $row_ss['jkb_date_y']));
}

function iconJKBApp($tid)
{
	if(checkJKBApp($tid))
			$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\"";
		else
			$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\"";
	
	return $view;
}

function checkJKBApp($id)
{		
	$query_ss = "SELECT jkb_appby FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['jkb_appby']!=NULL)
		return true;
	else
		return false;
}

function getBilByBilID($bid)
{		
	$query_ss = "SELECT bil_no, bil_date_d, bil_date_m, bil_date_y FROM finance.bil WHERE bil_status = '1' AND bil_id = '" . htmlspecialchars($bid, ENT_QUOTES) . "' ORDER BY bil_id";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$view = "Bil" . $row_ss['bil_no'] / date('d / m / Y', mktime(0, 0, 0, $row_ss['bil_date_m'], $row_ss['bil_date_d'], $row_ss['bil_date_y']));
	
	return $view;
}

function getJkbActivityByID($id)
{		
	$query_ss = "SELECT jkb_activity FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['jkb_activity'];
}

function getJkbRefByID($id)
{		
	$query_ss = "SELECT jkb_ref FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['jkb_ref'];
}

function getJkbDetailByID($id)
{		
	$query_ss = "SELECT jkb_detail FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['jkb_detail'];
}

function getApplyDescriptionByID($id)
{		
	$query_ss = "SELECT apply_description FROM finance.apply WHERE apply_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['apply_description'];
}

function getApplyQuantityByID($id)
{		
	$query_ss = "SELECT apply_quantity FROM finance.apply WHERE apply_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['apply_quantity'];
}

function getApplyCalculationByID($id)
{		
	$query_ss = "SELECT apply_calculation FROM finance.apply WHERE apply_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['apply_calculation'];
}

function getApplyAmountByID($id)
{		
	$query_ss = "SELECT apply_amount FROM finance.apply WHERE apply_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['apply_amount'];
}

function getJKBAppDate($id)
{		
	$query_ss = "SELECT jkb_appdate_d, jkb_appdate_m, jkb_appdate_y FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['jkb_appdate_m'], $row_ss['jkb_appdate_d'], $row_ss['jkb_appdate_y']));
}

function getJKBAppNote($id)
{		
	$query_ss = "SELECT jkb_appnote FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['jkb_appnote'];
}

function getJKBAppBy($id)
{		
	$query_ss = "SELECT jkb_appby FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['jkb_appby'];
}


function getAppUpdateByJKBApp($id)
{		
	// kemaskini oleh
	$query_ss = "SELECT jkb_appupdateby FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['jkb_appupdateby'];
}

function getAppUpdateDateJKBApp($id)
{
	// Tarikh kemaskini
	$query_ss = "SELECT jkb_appupdatedate FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['jkb_appupdatedate'];
}

function getClassificationByID($id)
{		
	$query_ss = "SELECT classification FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['classification'];
}
//Status Lulus atau Tidak Lulus
function getStatusNameByID($id)
{
	if($id!=0)
	{
		$query_status = "SELECT applystatus_name FROM finance.apply_status WHERE applystatus_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		$status = mysql_query($query_status);
		$row_status = mysql_fetch_assoc($status);
	
		$view = $row_status['applystatus_name'];
	} else {
		$view = "Dalam Proses";
	}
	
	return $view;
}

function getStatusByID($id)
{
	$query_status = "SELECT applystatus_id FROM finance.apply WHERE apply_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$status = mysql_query($query_status);
	$row_status = mysql_fetch_assoc($status);
	
	if($row_status['applystatus_id']!=0)
		return $row_status['applystatus_id'];
	else
		return 0;
}

function checkJKBAppStatusByID($id)
{
	$query_jkb = "SELECT jkb_appstatus FROM finance.jkb WHERE jkb_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$jkb = mysql_query($query_jkb);
	$row_jkb = mysql_fetch_assoc($jkb);
	
	return $row_jkb['jkb_appstatus'];
}

function getFinNoteByApplyID($id)
{		
	$query_ss = "SELECT fin_note FROM finance.apply WHERE apply_status = '1' AND apply_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY apply_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['fin_note'];
}

function getApplyDescriptionByApplyID($id)
//Jana Laporan
{		
	$query_ss = "SELECT apply_description FROM finance.apply WHERE apply_status = '1' AND apply_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['apply_description'];
}

function getApplyQuantityByApplyID($id)
{		
	$query_ss = "SELECT apply_quantity FROM finance.apply WHERE apply_status = '1' AND apply_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['apply_quantity'];
}

function getApplyCalculationByApplyID($id)
{		
	$query_ss = "SELECT apply_calculation FROM finance.apply WHERE apply_status = '1' AND apply_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['apply_calculation'];
}

function getApplyAmountByApplyID($id)
{		
	$query_ss = "SELECT apply_amount FROM finance.apply WHERE apply_status = '1' AND apply_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['apply_amount'];
}

function getTotalPermohonan($jid)
{
	$query_tot = "SELECT * FROM finance.apply WHERE apply_status = 1 AND jkb_id = '" . htmlspecialchars($jid, ENT_QUOTES) . "' ORDER BY jkb_id ASC";
	$tot = mysql_query($query_tot);
	$row_tot = mysql_fetch_assoc($tot);
	
	$totalRows_tot = mysql_num_rows($tot);
	
	return $totalRows_tot;
}

function getDateJKB($id)
{
	$query_ss = "SELECT bil_date_d, bil_date_m, bil_date_y FROM finance.bil WHERE bil_status = '1' AND bil_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY bil_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y', mktime(0, 0, 0, $row_ss['bil_date_m'], $row_ss['bil_date_d'], $row_ss['bil_date_y']));
}

function getBilIDByJkbID($id)
{		
	$query_ss = "SELECT bil_id FROM finance.jkb WHERE jkb_status = '1' AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY jkb_id";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['bil_id'];
}

function getBilNoByBilID($bid)
{		
	$query_ss = "SELECT bil_no, bil_date_y FROM finance.bil WHERE bil_status = '1' AND bil_id = '" . htmlspecialchars($bid, ENT_QUOTES) . "' ORDER BY bil_id";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$view = "Bil "  . $row_ss['bil_no'] ."/". date('Y', mktime(0, 0, 0, 1,1, $row_ss['bil_date_y']));
	return $view;
}
?>