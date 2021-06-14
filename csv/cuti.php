<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php
$wsql = "";

if(isset($_GET['id']) && $_GET['id']!=NULL)
	$wsql .= " AND user_stafid = '" . getID($_GET['id'],0) . "'";
else
	$wsql .= " AND user_stafid = '-1'";

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_h = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' " . $wsql . " ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC, userleavedate_id DESC LIMIT 50";
$h = mysql_query($query_h, $hrmsdb) or die(mysql_error());
$row_h = mysql_fetch_assoc($h);
?>
<?php
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename="isncuti.ics"');
?>
<?php 
echo "BEGIN:VCALENDAR
PRODID:-//ISN//Cuti Umum//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-TIMEZONE:UTC
X-WR-CALDESC:Cuti Umum";
do {
echo "
BEGIN:VEVENT
DTSTART;VALUE=DATE:" . date('Ymd', mktime(0, 0, 0, $row_h['userleavedate_date_m'], $row_h['userleavedate_date_d'], $row_h['userleavedate_date_y'])) . "
DTEND;VALUE=DATE:" . date('Ymd', mktime(0, 0, 0, $row_h['userleavedate_date_m'], $row_h['userleavedate_date_d'], $row_h['userleavedate_date_y'])) . "
DTSTAMP:" . date('Ymd', mktime(0, 0, 0, $row_h['userleavedate_date_m'], $row_h['userleavedate_date_d'], $row_h['userleavedate_date_y'])) . "T" . date('His', mktime(0, 0, 0, $row_h['userleavedate_date_m'], $row_h['userleavedate_date_d'], $row_h['userleavedate_date_y'])) . "Z
UID:" . md5(uniqid(mt_rand(), true)) . "@isn.gov.my
CLASS:PUBLIC
SUMMARY: SPSM Cuti Rehat " . getLeaveCategory($row_h['leavecategory_id']) . "
END:VEVENT";
} while($row_h = mysql_fetch_assoc($h));
echo "
END:VCALENDAR";
exit;
?>
<?php mysql_free_result($h); ?>
