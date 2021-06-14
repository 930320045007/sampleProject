<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php

	if(isset($_GET['id']) && $_GET['id']!=NULL)
		$id = $_GET['id'];
	else
		$id = '-1';
	
	$sql_where = " user_unit.dir_id = '" . getUserUnitIDByUserID(getID($id,0)) . "' AND login.login_status = 1";
	
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_userunit = sqlAllStaf($sql_where);
	$userunit = mysql_query($query_userunit, $hrmsdb) or die(mysql_error());
	$row_userunit = mysql_fetch_assoc($userunit);
	
?>
<?php
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename="isndir.ics"');
?>
<?php
echo "BEGIN:VCALENDAR
PRODID:-//ISN//Cuti Kakitangan//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-TIMEZONE:UTC
X-WR-CALDESC:Cuti Kakitangan " . getFulldirectory(getUserUnitIDByUserID(getID($id,0)),0);
	$wsql = " AND (";
	$i= 1;
	do{
		if($i!=1)
			$wsql .= " OR ";
		$wsql .= " user_stafid = '" . $row_userunit['user_stafid'] . "' ";
		$i++;
	}while($row_userunit = mysql_fetch_assoc($userunit)); 
	
	$wsql .= " )";

	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_h = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND userleavedate_date_y = '" . date('Y') . "' " . $wsql . " ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC, userleavedate_id DESC LIMIT 50";
	$h = mysql_query($query_h, $hrmsdb) or die(mysql_error());
	$row_h = mysql_fetch_assoc($h);
do{
echo "
BEGIN:VEVENT
DTSTART;VALUE=DATE:" . date('Ymd', mktime(0, 0, 0, $row_h['userleavedate_date_m'], $row_h['userleavedate_date_d'], $row_h['userleavedate_date_y'])) . "
DTEND;VALUE=DATE:" . date('Ymd', mktime(0, 0, 0, $row_h['userleavedate_date_m'], $row_h['userleavedate_date_d'], $row_h['userleavedate_date_y'])) . "
DTSTAMP:" . date('Ymd', mktime(0, 0, 0, $row_h['userleavedate_date_m'], $row_h['userleavedate_date_d'], $row_h['userleavedate_date_y'])) . "T" . date('His', mktime(0, 0, 0, $row_h['userleavedate_date_m'], $row_h['userleavedate_date_d'], $row_h['userleavedate_date_y'])) . "Z
UID:" . md5(uniqid(mt_rand(), true)) . "@isn.gov.my
CLASS:PUBLIC
SUMMARY: SPSM " . getFullNameByStafID($row_h['user_stafid']) . "
END:VEVENT";
} while($row_h = mysql_fetch_assoc($h));
echo "
END:VCALENDAR";
exit;
?>
<?php mysql_free_result($h); ?>
<?php mysql_free_result($userunit); ?>
