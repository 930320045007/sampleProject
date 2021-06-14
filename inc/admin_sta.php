<?php
function totalStaff($d=0, $m=0, $y=0)
{
	if($d == 0)
		$d = date('d');
	if($m == 0)
		$m = date('m');
	if($y == 0)
		$y = date('Y');
		
	$sql_where = " ((user_job.userjob_start_m <= '" . $m . "' AND user_job.userjob_start_y = '" . $y . "') OR (user_job.userjob_start_y < '" . $y . "')) AND (login_date_m IS NULL AND login_date_y IS NULL AND login.login_status = '1') OR ((login.login_status = '0' AND login.login_date_m >= '" . $m . "' AND login.login_date_y = '" . $y . "') OR (login.login_status = '0' AND login.login_date_y > '" . $y . "'))";
	$query_user_all = sqlAllStaf($sql_where);
	$user_all = mysql_query($query_user_all);
	$row_all = mysql_fetch_assoc($user_all);
	
	$total = mysql_num_rows($user_all);
	
	return $total;	
}

function totalGender($gender) 
{
	$sql_where = " login.login_status = '1' AND user.user_gender = '" . htmlspecialchars($gender, ENT_QUOTES) . "'";
	$query_user_gender = sqlAllStaf($sql_where);
	$user_gender = mysql_query($query_user_gender);
	$row_gender = mysql_fetch_assoc($user_gender);
	
	$total = mysql_num_rows($user_gender);
	
	return $total;	
}

function percentGender($gender)
{	
	return round((totalGender(htmlspecialchars($gender, ENT_QUOTES))/totalStaff())*100);	
}

function totalRace($race, $gender)
{
	if($gender != '0')
		$sqlWHERE =  " AND user.user_gender = '" . htmlspecialchars($gender, ENT_QUOTES) . "'"; 
	else
		$sqlWHERE = "";
		
	$sql_where = " login.login_status = '1' AND user.user_race = '" . htmlspecialchars($race, ENT_QUOTES) . "'" . $sqlWHERE;
	$query_user_race = sqlAllStaf($sql_where);
	$user_race = mysql_query($query_user_race);
	$row_race = mysql_fetch_assoc($user_race);
	
	$total = mysql_num_rows($user_race);
	
	return $total;	
}


function percentRace($race, $gender)
{	
	return round((totalRace(htmlspecialchars($race, ENT_QUOTES), htmlspecialchars($gender, ENT_QUOTES))/totalStafF())*100);	
}

function totalJobType($jt, $gender)
{
	if($gender != '0')
		$sqlWHERE =  " AND user.user_gender = '" . htmlspecialchars($gender, ENT_QUOTES) . "'"; 
	else
		$sqlWHERE = "";
		
	$sql_where = " login.login_status = '1' AND jobtype_id = '" . htmlspecialchars($jt, ENT_QUOTES) . "' AND userdesignation_status = '1' AND user_designation.userdesignation_status = '1'" . $sqlWHERE;
	$query_user_jt = sqlAllStaf($sql_where);
	$user_jt = mysql_query($query_user_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	$total = mysql_num_rows($user_jt);
	
	return $total;	
}

function percentJobType($jt, $gender)
{	
	return round((totalJobType($jt, $gender)/totalStafF())*100);	
}

function totalUserByDirSub($dir, $gender)
{
	//mendapatkan jumlah Staf mengikut Bahagian ID
	$wsql = " login.login_status = '1' AND dir.dir_sub = '" . htmlspecialchars($dir, ENT_QUOTES) . "'";
	
	if($gender != '0')
		$wsql .=  "AND user.user_gender = '" . htmlspecialchars($gender, ENT_QUOTES) . "'"; 
		
	$query_user_jt = sqlAllStaf($wsql);
	$user_jt = mysql_query($query_user_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	$total = mysql_num_rows($user_jt);
	
	return $total;
}

function totalUserByDirID($dir, $gender)
{
	//mendapatkan jumlah Staf mengikut Bahagian ID
	if($dir!=0)
		$wsql = " login.login_status = '1' AND dir.dir_id = '" . htmlspecialchars($dir, ENT_QUOTES) . "'";
	else
		$wsql = " login.login_status = '1'";
	
	if($gender != '0')
		$wsql .=  "AND user.user_gender = '" . htmlspecialchars($gender, ENT_QUOTES) . "'"; 
		
	$query_user_jt = sqlAllStaf($wsql);
	$user_jt = mysql_query($query_user_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	$total = mysql_num_rows($user_jt);
	
	return $total;
}

function totalUserByGroupGred($ggred, $gender)
{
	//mendapatkan jumlah Staf mengikut Kumpulan ID
	$query_user_gg = "SELECT group_gred FROM www.group WHERE group_id = '" . htmlspecialchars($ggred, ENT_QUOTES) . "' OR group_id = '" . (htmlspecialchars($ggred, ENT_QUOTES)-1) . "' ORDER BY group_id ASC";
	$user_gg = mysql_query($query_user_gg);
	$row_gg = mysql_fetch_assoc($user_gg);
	
	$total2 = mysql_num_rows($user_gg);
	
	do {
		$gred[] = $row_gg['group_gred']; //[0] = 52, [1] = 41
	} while ($row_gg = mysql_fetch_assoc($user_gg));
	
	if($total2==1)
		$gred[1] = '100';
		
	$wsql = " login.login_status = '1' AND user_scheme.userscheme_gred < '" . $gred[0] . "' AND user_scheme.userscheme_gred >= '" . $gred[1] . "'";
	
	if($gender != '0')
		$wsql .=  "AND user.user_gender = '" . htmlspecialchars($gender, ENT_QUOTES) . "'"; 
		
	$query_user_jt = sqlAllStaf($wsql);
	$user_jt = mysql_query($query_user_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	$total = mysql_num_rows($user_jt);
	
	return $total;
}

function percentGroupGred($ggred, $gender)
{	
	return round((totalUserByGroupGred($ggred, $gender)/totalStafF())*100);	
}

function totalUserByDirAndGroupGred($dir, $ggred, $gender)
{
	//mendapatkan jumlah Staf mengikut Bahagian ID dan Kumpulan ID
	$query_user_gg = "SELECT group_gred FROM www.group WHERE group_id = '" . htmlspecialchars($ggred, ENT_QUOTES) . "' OR group_id = '" . (htmlspecialchars($ggred, ENT_QUOTES)-1) . "' ORDER BY group_id ASC";
	$user_gg = mysql_query($query_user_gg);
	$row_gg = mysql_fetch_assoc($user_gg);
	
	$total2 = mysql_num_rows($user_gg);
	
	do {
		$gred[] = $row_gg['group_gred']; //[0] = 52, [1] = 41
	} while ($row_gg = mysql_fetch_assoc($user_gg));
	
	if($total2==1)
		$gred[1] = '100';
		
	$wsql = " login.login_status = '1' AND dir.dir_sub = '" . htmlspecialchars($dir, ENT_QUOTES) . "' AND user_scheme.userscheme_gred < '" . $gred[0] . "' AND user_scheme.userscheme_gred >= '" . $gred[1] . "'";
	
	if($gender != '0')
		$wsql .=  "AND user.user_gender = '" . htmlspecialchars($gender, ENT_QUOTES) . "'"; 
		
	$query_user_jt = sqlAllStaf($wsql);
	$user_jt = mysql_query($query_user_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	$total = mysql_num_rows($user_jt);
	
	return $total;
}
?>
