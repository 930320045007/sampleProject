<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_h = "SELECT courses_name, courses_start_d, courses_start_m, courses_start_y, courses_end_d, courses_end_m, courses_end_y FROM www.courses WHERE courses_view = '1' AND courses_status = 1 AND courses_end_y = '" . date('Y') . "' ORDER BY courses_start_y DESC, courses_start_m DESC, courses_start_d DESC, courses_end_y DESC, courses_end_m DESC, courses_end_d DESC, courses_id DESC";
$h = mysql_query($query_h, $hrmsdb) or die(mysql_error());
$row_h = mysql_fetch_assoc($h);
?>
<?php
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename="isnjadualkursus.ics"');
?>
<?php 
echo "BEGIN:VCALENDAR
PRODID:-//ISN//Jadual Kursus//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-TIMEZONE:UTC
X-WR-CALDESC:Jadual Kursus";
do {
echo "
BEGIN:VEVENT
DTSTART;VALUE=DATE:" . date('Ymd', mktime(0, 0, 0, $row_h['courses_start_m'], $row_h['courses_start_d'], $row_h['courses_start_y'])) . "
DTEND;VALUE=DATE:" . date('Ymd', mktime(0, 0, 0, $row_h['courses_end_m'], $row_h['courses_end_d'], $row_h['courses_end_y'])) . "
DTSTAMP:" . date('Ymd', mktime(0, 0, 0, $row_h['courses_start_m'], $row_h['courses_start_d'], $row_h['courses_start_y'])) . "T" . date('His', mktime(0, 0, 0, $row_h['courses_start_m'], $row_h['courses_start_d'], $row_h['courses_start_y'])) . "Z
UID:" . md5(uniqid(mt_rand(), true)) . "@isn.gov.my
CLASS:PUBLIC
SUMMARY:SPSM " . $row_h['courses_name'] . "
END:VEVENT";
} while($row_h = mysql_fetch_assoc($h));
echo "
END:VCALENDAR";
exit;
?>
<?php mysql_free_result($h); ?>
