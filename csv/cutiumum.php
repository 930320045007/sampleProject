<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_h = "SELECT * FROM www.holiday WHERE holiday_status = 1 ORDER BY holiday_date_y ASC, holiday_date_m ASC, holiday_date_d ASC";
$h = mysql_query($query_h, $hrmsdb) or die(mysql_error());
$row_h = mysql_fetch_assoc($h);
?>
<?php
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename="isncutiumum.ics"');
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
DTSTART;VALUE=DATE:" . date('Ymd', mktime(0, 0, 0, $row_h['holiday_date_m'], $row_h['holiday_date_d'], $row_h['holiday_date_y'])) . "
DTEND;VALUE=DATE:" . date('Ymd', mktime(0, 0, 0, $row_h['holiday_date_m'], $row_h['holiday_date_d'], $row_h['holiday_date_y'])) . "
DTSTAMP:" . date('Ymd', mktime(0, 0, 0, $row_h['holiday_date_m'], $row_h['holiday_date_d'], $row_h['holiday_date_y'])) . "T" . date('His', mktime(0, 0, 0, $row_h['holiday_date_m'], $row_h['holiday_date_d'], $row_h['holiday_date_y'])) . "Z
UID:" . md5(uniqid(mt_rand(), true)) . "@isn.gov.my
CLASS:PUBLIC
SUMMARY: SPSM " . $row_h['holiday_name'] . "
END:VEVENT";
} while($row_h = mysql_fetch_assoc($h));
echo "
END:VCALENDAR";
exit;
?>
<?php mysql_free_result($h); ?>
