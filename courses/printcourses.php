<?php require_once('../Connections/hrmsdb.php'); ?>

<?php include('../inc/user.php');?>

<?php include('../inc/func.php');?>

<?php $menu='4';?>

<?php $menu2='13';?>
<?php

if(isset($_GET['y']))
{
	$dy = htmlspecialchars($_GET['y'], ENT_QUOTES);
} else {
	$dy = date('Y');
};

  $sid = $row_user['user_stafid'];
  
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_report = "SELECT user_courses.*, courses.durationtype_id, courses_start_y, courses_time, courses_location, courses_status FROM user_courses LEFT JOIN courses ON courses.courses_id = user_courses.courses_id WHERE courses.courses_status = '1' AND user_courses.user_stafid = '" . $sid . "' AND courses.courses_start_y = '" . $dy . "' AND user_courses.usercourses_status = 1 ORDER BY courses_start_y DESC, courses_start_m DESC, courses_start_d DESC, courses_end_y DESC, courses_end_m DESC, courses_end_d DESC, courses.courses_id DESC";
$report = mysql_query($query_report, $hrmsdb) or die(mysql_error());
$row_report = mysql_fetch_assoc($report);
$totalRows_report = mysql_num_rows($report);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300' rel='stylesheet' type='text/css'>
<link href="css/print.css" rel="stylesheet" type="text/css" />
<!-- <?php include('inc/headinc.php');?> -->
</head>
<body onLoad="javascript:window.print()">

<span>
                 <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tabborder">
        <tr>
                      <td align="center" valign="middle"><?php echo viewProfilePic($sid);?></td>
                      <td width="100%" align="left" valign="middle">
                        <div><strong><?php echo getFullNameByStafID($sid) . " (" . $sid . ")"; ?></strong></div>
                        <div class="txt_color1"><?php echo getJobtitle($sid) . " (" . getGred($sid) . ")";?></div>
                        <div class="txt_color1"><?php echo getFulldirectoryByUserID($sid);?></div>
                      </td>
                    </tr>
                    
                  </table>
                  <br />
               <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tabborder">
                  <?php if ($totalRows_report > 0) { // Show if recordset not empty ?>
    <tr>
      <th>Bil</th>
      <th width="100%" align="left" valign="middle">Perkara</th>
      <th align="center" valign="middle" nowrap="nowrap">Laporan</th>
      <th align="center" valign="middle" nowrap="nowrap">Kehadiran</th>
      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan &nbsp; </th>
    </tr>
    <?php $i=1; do { ?>
      <tr class="on">
        <td><?php echo $i;?></td>
        <td><div class="txt_line"><strong class="txt_size3"><?php echo getCoursesName($row_report['courses_id']);?></strong><br/>Tarikh : <?php echo getCoursesDate($row_report['courses_id'],'0');?> &nbsp; <span class="txt_color1">&bull;</span> &nbsp; Masa : <?php echo $row_report['courses_time']; ?> &nbsp; <span class="txt_color1">&bull;</span> &nbsp; Tempat : <?php echo $row_report['courses_location']; ?></div></td>
        <td align="center" valign="middle" nowrap="nowrap">
		<?php 
		if(getUserAsByUserID($row_user['user_stafid'], $row_report['courses_id'])==1) 
			echo "<img src=\"" . $url_main . "/icon/sign_info.png\" alt=\"Pembentang\" align=\"absbottom\" />";
		else if(checkReportNeed($row_report['courses_id'],$row_user['user_stafid'])) 
			if(!checkReportSubmit($row_user['user_stafid'], $row_report['courses_id'])) 
				echo "<a href=\"reportadd.php?id=" . getID($row_report['usercourses_id']) . "\">Hantar</a>"; 
			else 
				echo "<a href=\"reportread.php?id=" . getID($row_report['usercourses_id']) . "&ucrid=" . getID(getUserCoursesReportIDByCoursesID($row_user['user_stafid'], $row_report['courses_id'])) . "\">Lihat</a>"; 
		else 
			echo "&nbsp;";?></td>
        <td align="center" valign="middle" nowrap="nowrap"><?php iconAttendance($row_user['user_stafid'], $row_report['courses_id']);?></td>
        <td align="center" valign="middle" nowrap="nowrap" class="back_lightgrey line_b2"><?php echo viewCountDay($row_report['courses_id'], $row_user['user_stafid']);?></td>
      </tr>
      <?php $i++; } while ($row_report = mysql_fetch_assoc($report)); ?>
    <tr>
      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Jam Kursus</strong></td>
      <td align="center" valign="middle" nowrap="nowrap" class="line_t back_lightgrey"><?php $courses = countCoursesHour($row_user['user_stafid'], $dy);?><?php if($courses[0]!=0) echo $courses[0] . " Hari ";?> <?php if($courses[1]!=0) echo $courses[1] . " Jam";?><?php if($courses[0]==0 && $courses[1]==0) echo "0";?></td>
    </tr>
  <?php } else {?>
    <tr>
      <td colspan="5" align="center" valign="middle" class="noline"><span class="txt_line">Tiada rekod dijumpai, sila pastikan jumlah jam kursus dicapai dalam tempoh yang ditetapkan. <br/> Untuk maklumat / pertanyaan lanjut berkaitan kursus, sila berhubung dengan <?php echo $GLOBALS['adname'];?>.</span></td>
    </tr>
    <?php }; ?>
  </table>
</body>
</html>
<?php
?>
<!-- <?php include('inc/footinc.php');?>  -->