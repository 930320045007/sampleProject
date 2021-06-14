<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='7';?>
<?php $menu2='18';?>
<?php $menu3 = '4';?>
<?php
if(isset($_POST['tahun']) && $_POST['tahun']!='')
{
	$wsql = "AND courses.courses_start_y = '" . htmlspecialchars($_POST['tahun'], ENT_QUOTES) . "'";
	$year = $_POST['tahun'];
} else {
	$wsql = "";
	$year = date('Y');
}

if(isset($_GET['sid']) && $_GET['sid']!=NULL)
	$staffid = getStafIDByUserID(getID(htmlspecialchars($_GET['sid'], ENT_QUOTES), 0));
else
	$staffid = '0';
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_report = "SELECT user_courses.*, courses.durationtype_id, courses_start_y, courses_time, courses_location, courses_status FROM user_courses LEFT JOIN courses ON courses.courses_id = user_courses.courses_id WHERE courses.courses_status = '1' AND user_courses.user_stafid = '" . $staffid . "' AND courses.courses_start_y = '" . $year . "' AND user_courses.usercourses_status = 1 " . $wsql . " ORDER BY courses_start_y DESC, courses_start_m DESC, courses_start_d DESC, courses_end_y DESC, courses_end_m DESC, courses_end_d DESC, courses.courses_id DESC";
$report = mysql_query($query_report, $hrmsdb) or die(mysql_error());
$row_report = mysql_fetch_assoc($report);
$totalRows_report = mysql_num_rows($report);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_unit.php');?>
        <div class="tabbox">
          <div class="profilemenu">
           <?php if (getUserUnitIDByUserID($row_user['user_stafid'])==getUserUnitIDByUserID($staffid)){?>
            <?php include('../inc/menu_head.php');?>
          	<ul>
            <li class="gap">&nbsp;</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  <td rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic($staffid);?></td>
                    <td nowrap="nowrap" class="label">Nama</td>
                    <td width="100%"><strong><?php echo strtoupper(getFullNameByStafID($staffid)) . " (" . $staffid . ")"; ?></strong></td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label noline">Jawatan</td>
                    <td class="noline txt_line"><?php echo getJobtitle($staffid); ?><br/><?php echo getFulldirectoryByUserID($staffid);?></td>
                  </tr>
                </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Jam Kursus</li>
                <li>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo getCoursesDayByYear($staffid, date('Y'));?></div><div>Hari</div></td>
                      <td align="left" valign="middle" class="txt_line">Jumlah perlu dihadiri<br/> 
                      <span class="txt_color1">bagi tahun <?php echo date('Y');?></span></td>
                    </tr>
                  </table>
                </li>
            	<li>
                <div class="note">Berikut adalah senarai kursus yang dimohon dengan kiraan Jam Kursus :</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                        <td class="txt_line">
                        <div><strong><?php echo getCoursesName($row_report['courses_id']);?></strong></div>
                        <div>Tarikh : <?php echo getCoursesDate($row_report['courses_id'],'0');?> &nbsp; &bull; &nbsp; Masa : <?php echo $row_report['courses_time']; ?> &nbsp; &bull; &nbsp; Tempat : <?php echo $row_report['courses_location']; ?></div>
                        </td>
                        <td align="center" valign="middle" nowrap="nowrap">
						<?php 
							if(getUserAsByUserID($staffid, $row_report['courses_id'])==1) 
								echo "Pembentang<br/>Penceramah";
							else if(checkReportNeed($row_report['courses_id'],$staffid)) 
								if(!checkReportSubmit($staffid, $row_report['courses_id'])) 
									echo "<span class=\"txt_color2\">Tiada Laporan</span>"; 
								else 
									echo "<a href=\"reportread.php?sid=" . getID($_GET['sid']) . "&id=" . $row_report['usercourses_id'] . "&ucrid=" . getUserCoursesReportIDByCoursesID($staffid, $row_report['courses_id']) . "\">Lihat laporan</a>"; 
							else 
								echo "&nbsp;";?>
						</td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php iconAttendance($staffid, $row_report['courses_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap" class="back_lightgrey line_b2"><?php echo viewCountDay($row_report['courses_id'], $staffid);?></td>
                      </tr>
                      <?php $i++; } while ($row_report = mysql_fetch_assoc($report)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Jam Kursus</strong></td>
                      <td align="center" valign="middle" nowrap="nowrap" class="line_t back_lightgrey"><?php $courses = countCoursesHour($staffid, $year);?><?php if($courses[0]!=0) echo $courses[0] . " Hari ";?> <?php if($courses[1]!=0) echo $courses[1] . " Jam";?><?php if($courses[0]==0 && $courses[1]==0) echo "0";?></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_report ?>  rekod dijumpai</td>
                      </tr>
                  <?php } else {?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline"><span class="txt_line">Tiada rekod dijumpai, sila pastikan jumlah jam kursus dicapai dalam tempoh yang ditetapkan. <br/> Untuk maklumat / pertanyaan lanjut berkaitan kursus, sila berhubung dengan <?php echo $GLOBALS['adname'];?>.</span></td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
            </ul>
             <?php }else{ ?>
           <ul><li><div class="note" >Tiada rekod yang dijumpai.</div></li></ul>
           <?php };?>
          </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($report);
?>
<?php include('../inc/footinc.php');?> 