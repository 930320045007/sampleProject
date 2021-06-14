<?php
//skt

function getSKTStafID($sktid)
{	
  $query_ss = "SELECT user_stafid FROM skt.user_skt WHERE uskt_status = '1' AND uskt_id = '" . htmlspecialchars($sktid, ENT_QUOTES) . "'";	
  $user_ss = mysql_query($query_ss);
  $row_ss = mysql_fetch_assoc($user_ss);
	
  return $row_ss['user_stafid'];
}

function getSKTMasaMula($sktid)
{	
  $query_ss = "SELECT uskt_masa_mula FROM skt.user_skt WHERE uskt_status = '1' AND uskt_id = '" . htmlspecialchars($sktid, ENT_QUOTES) . "'";	
  $user_ss = mysql_query($query_ss);
  $row_ss = mysql_fetch_assoc($user_ss);
	
  return $row_ss['uskt_masa_mula'];
}

function getSKTMasaTamat($sktid)
{	
  $query_ss = "SELECT uskt_masa_tamat FROM skt.user_skt WHERE uskt_status = '1' AND uskt_id = '" . htmlspecialchars($sktid, ENT_QUOTES) . "'";	
  $user_ss = mysql_query($query_ss);
  $row_ss = mysql_fetch_assoc($user_ss);
  
  $month = getTambahanTempohBySKTID($sktid);
	
  return ($row_ss['uskt_masa_tamat'] + $month);
}

function getSKTTahun($sktid)
{
  $query_ss = "SELECT uskt_date_y FROM skt.user_skt WHERE uskt_status = '1' AND uskt_id = '" . htmlspecialchars($sktid, ENT_QUOTES) . "'";	
  $user_ss = mysql_query($query_ss);
  $row_ss = mysql_fetch_assoc($user_ss);
	
  return $row_ss['uskt_date_y'];
}

function getSKTTempoh($sktid)
{	
  $query_ss = "SELECT uskt_masa_mula, uskt_masa_tamat FROM skt.user_skt WHERE uskt_status = '1' AND uskt_id = '" . htmlspecialchars($sktid, ENT_QUOTES) . "'";	
  $user_ss = mysql_query($query_ss);
  $row_ss = mysql_fetch_assoc($user_ss);
  
  $month = getTambahanTempohBySKTID($sktid);
	
  $masa = ($row_ss['uskt_masa_tamat'] - $row_ss['uskt_masa_mula']) + 1 + $month;
  
  if($masa < 0)
  	$masa = 0;
	
  return $masa;
}

function checkSKTMasaInMonth($sktid, $m)
{
	if(getSKTMasaMula($sktid)<=$m && getSKTMasaTamat($sktid)>=$m)
		return true;
	else
		return false;
}
?>
<?php
//Pegawai Penilai

function getPP($user)
{
	//semak sama ada Staf ID telah ditetapkan PPP atau PPK
  $query_ss = "SELECT pp_id, pp_ppp, pp_ppk FROM skt.pp WHERE pp_status = '1' AND user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
  $user_ss = mysql_query($query_ss);
  $row_ss = mysql_fetch_assoc($user_ss);
  
  $total = mysql_num_rows($user_ss);
  
  if($total > 0)
  
	  	return true;
	  else
	  	return false;
}

function getPPTypeByStafID($user, $ppuser)
{
	//semakkan Pegawai Penilai bagi user terhadap ppuser sama ada 1-PPP atau 2-PPK
	if(getPPPByStafID($user)==$ppuser && getPPPByStafID($user)!=NULL)
		return 1;
	else if(getPPKByStafID($user)==$ppuser && getPPKByStafID($user)!=NULL)
		return 2;
	else if(getPPPByStafID($user)!=NULL || getPPKByStafID($user)==NULL)
		return 0;
	else
		return NULL;
}

function getPPType($id)
{
	if($id==1)
		return "PPP";
	else if($id==2)
		return "PPK";
	else if($id==0)
		return "PYD";
	else
		return "";
}

function getPPPByStafID($user)
{
  $query_ss = "SELECT pp_ppp FROM skt.pp WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'GROUP BY pp_id ORDER BY pp_date_d ASC, pp_date_m ASC, pp_date_y ASC LIMIT 1";	
  $user_ss = mysql_query($query_ss);
  $row_ss = mysql_fetch_assoc($user_ss);
  
  	return $row_ss['pp_ppp'];
}

function getPPKByStafID($user)
{
  $query_ss = "SELECT pp_ppk FROM skt.pp WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' GROUP BY pp_id ORDER BY pp_date_d ASC, pp_date_m ASC, pp_date_y ASC LIMIT 1 ";	
  $user_ss = mysql_query($query_ss);
  $row_ss = mysql_fetch_assoc($user_ss);
  
  	return $row_ss['pp_ppk'];
}

function checkPPPByStafID($user)
{ 
	//semak status User adakah sebagai PPP
  $query_ss = "SELECT pp_ppp FROM skt.pp WHERE pp_status = '1' AND pp_ppp = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
  $user_ss = mysql_query($query_ss);
  $row_ss = mysql_fetch_assoc($user_ss);
  
  $total = mysql_num_rows($user_ss);
  
  if($total > 0)
  	return true;
  else
	  return false;
}

function checkPPKByStafID($user)
{ //semak status User adakah sebagai PPK
  $query_ss = "SELECT pp_ppk FROM skt.pp WHERE pp_status = '1' AND pp_ppk = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
  $user_ss = mysql_query($query_ss);
  $row_ss = mysql_fetch_assoc($user_ss);
  
  $total = mysql_num_rows($user_ss);
  
  if($total > 0)
  	return true;
  else
	  return false;
}
?>
<?php
//SKT Feedback
function getFeedbackType($id)
{
	if($id!=0)
	{
	  $query_ss = "SELECT feedbacktype_name FROM skt.feedbacktype WHERE feedbacktype_status = '1' AND feedbacktype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['feedbacktype_name'];
	} else
		return "Pengesahan";
}

function getFeedbackDate($id)
{
	  $query_ss = "SELECT sktf_date_d, sktf_date_m, sktf_date_y, sktf_date_h FROM skt.sktfeedback WHERE sktf_status = '1' AND sktf_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['sktf_date_m'], $row_ss['sktf_date_d'], $row_ss['sktf_date_y'])) . " " . $row_ss['sktf_date_h'];
}

function getFeedbackBy($id)
{
	  $query_ss = "SELECT sktf_by FROM skt.sktfeedback WHERE sktf_status = '1' AND sktf_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['sktf_by'];
}

function getFeedbackIDLatest($userid, $usktid)
{
	  $query_ss = "SELECT sktfeedback.sktf_id FROM skt.sktfeedback LEFT JOIN skt.user_skt ON user_skt.uskt_id = sktfeedback.uskt_id WHERE user_skt.user_stafid = '" . $userid . "' AND sktfeedback.sktf_status = '1' AND sktfeedback.uskt_id = '" . htmlspecialchars($usktid, ENT_QUOTES) . "' ORDER BY sktfeedback.sktf_id DESC LIMIT 1";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['sktf_id'];
}

function getFeedbackLatest($userid, $usktid, $ftid)
{
	$wsql = "";
	if($ftid!=0)
		$wsql .= " AND feedbacktype_id = '" . htmlspecialchars($ftid, ENT_QUOTES) . "'";
	
	if($userid!=0)
		$wsql .= " AND sktf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "'";
		
	//mendapatkan feedback sub terkini berdasarkan feedbacktype ID
	  $query_ss = "SELECT * FROM skt.sktfeedback WHERE sktf_status = '1' AND uskt_id = '" . htmlspecialchars($usktid, ENT_QUOTES) . "' " . $wsql . " ORDER BY sktf_id DESC LIMIT 1";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  if($ftid=='3' && $row_ss['sktf_sub']==NULL)
	  	return '0';
	  else
	  	return $row_ss['sktf_sub'];
}

function checkFeedbackLatest($userid, $usktid, $ftid)
{
	$wsql = "";
	if($ftid!=0)
		$wsql = " AND feedbacktype_id = '" . htmlspecialchars($ftid, ENT_QUOTES) . "'";
	
	if($userid!=0)
		$wsql .= " AND sktf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "'";
		
	//mendapatkan feedback sub terkini berdasarkan feedbacktype ID
	  $query_ss = "SELECT * FROM skt.sktfeedback WHERE sktf_status = '1' AND uskt_id = '" . htmlspecialchars($usktid, ENT_QUOTES) . "' " . $wsql . " ORDER BY sktf_id DESC LIMIT 1";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
}

function getFeedbackTypeSub($ftid)
{
	//mendapatkan feedback sub terkini berdasarkan feedbacktype ID
	  $query_ss = "SELECT * FROM skt.sktfeedback WHERE sktf_status = '1' AND sktf_id = '" . htmlspecialchars($ftid, ENT_QUOTES) . "' ORDER BY sktf_id DESC LIMIT 1";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  if($ftid=='3' && $row_ss['sktf_sub']==NULL)
	  	return '0';
	  else
	  	return $row_ss['sktf_sub'];
}

function getFeedbackTypeSubIDLatestBySKTID($sktid)
{
	//Peratusan terkini
	  $query_ss = "SELECT sktf_sub FROM skt.sktfeedback WHERE sktf_status = '1' AND uskt_id = '" . htmlspecialchars($sktid, ENT_QUOTES) . "' AND feedbacktype_id = '3' ORDER BY sktf_id DESC LIMIT 1";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  if($row_ss['sktf_sub'] == NULL)
	  	return '0';
	  else
	  	return $row_ss['sktf_sub'];
}

function getTambahanTempohBySKTID($sktid)
{  
  if(checkFeedbackLatest(getSKTStafID($sktid), $sktid, '5'))
  	$month = getFeedbackLatest(getSKTStafID($sktid), $sktid, '5'); // jika berlaku penambahan bulan
  else
  	$month = 0;
	
	return $month;
}

function getPetunjukPretasi($id)
{
	  $query_ss = "SELECT * FROM skt.petunjukpretasi WHERE ppskt_status = '1' AND ppskt_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['ppskt_name'];
}

function checkFeedbackCancel($sktid)
{
	$query_ss = "SELECT sktf_sub FROM skt.sktfeedback WHERE sktf_status = '1' AND uskt_id = '" . htmlspecialchars($sktid, ENT_QUOTES) . "' AND feedbacktype_id = '4' ORDER BY sktf_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
	  return true;
	else
		return false;
}

function getSKTAveragePercent($userid, $y)
{
	  $query_ss = "SELECT sktfeedback.sktf_sub FROM skt.user_skt LEFT JOIN (SELECT * FROM (SELECT * FROM skt.sktfeedback ORDER BY sktfeedback.sktf_id DESC) AS sktfeedback WHERE sktfeedback.sktf_status = '1' AND sktfeedback.feedbacktype_id = '3' GROUP BY sktfeedback.uskt_id) AS sktfeedback ON user_skt.uskt_id = sktfeedback.uskt_id WHERE user_skt.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_skt.uskt_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND user_skt.uskt_status = '1' AND NOT EXISTS (SELECT * FROM skt.sktfeedback WHERE user_skt.uskt_id = sktfeedback.uskt_id AND feedbacktype_id='4' AND sktf_status = '1') ORDER BY user_skt.uskt_id DESC";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  $total = mysql_num_rows($user_ss);
	  $count = 0;
	  
	  do{
		  $count = $count + $row_ss['sktf_sub'];
	  } while($row_ss = mysql_fetch_assoc($user_ss));
	  
	  if($count>0)
	  	$av = round($count / $total);
	  else
	  	$av = 0;
		
	  return $av;
}
?>
<?php
//Kegiatan
function getOrgLevelByID($id)
{
	  $query_ss = "SELECT orglevel_name FROM skt.org_level WHERE orglevel_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['orglevel_name'];
}

function getOrgArchByID($id)
{
	  $query_ss = "SELECT orgarch_name FROM skt.org_arch WHERE orgarch_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['orgarch_name'];
}

function getAktivitiNameByAktID($aktid)
{
	  $query_ss = "SELECT useraktiviti_name FROM skt.user_aktiviti WHERE useraktiviti_id  = '" . htmlspecialchars($aktid, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['useraktiviti_name'];
}

function getAktivitiJawatanByAktID($aktid)
{
	  $query_ss = "SELECT useraktiviti_jawat FROM skt.user_aktiviti WHERE useraktiviti_id  = '" . htmlspecialchars($aktid, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['useraktiviti_jawat'];
}

//Program
function getAktivitiNameByProgID($progid)
{
	  $query_ss = "SELECT useraktiviti_id FROM skt.user_program WHERE userprogram_id  = '" . htmlspecialchars($progid, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['useraktiviti_id'];
}

function getProgramJawatanByProgID($progid)
{
	  $query_ss = "SELECT userprogram_jawat FROM skt.user_program WHERE userprogram_id  = '" . htmlspecialchars($progid, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['userprogram_jawat'];
}
?> 