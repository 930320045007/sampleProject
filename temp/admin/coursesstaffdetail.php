<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='14';?> 
<?php
if(isset($_POST['tahun']) && $_POST['tahun']!='')
{
	$wsql = "AND courses.courses_start_y = '" . $_POST['tahun'] . "'";
	$year = $_POST['tahun'];
} else {
	$wsql = "";
	$year = date('Y');
}
	
if(isset($_GET['sid']) && $_GET['sid']!=NULL)
	$staffid = getID($_GET['sid'], 0);
else
	$staffid = '0';
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_usercourses = "SELECT user_courses.*, courses.coursescategory_id, courses.durationtype_id, courses_start_y, courses_time, courses_location, courses_status FROM user_courses LEFT JOIN courses ON courses.courses_id = user_courses.courses_id WHERE courses.courses_status = '1' AND user_courses.user_stafid = '" . $staffid . "' AND courses.courses_start_y = '" . $year . "' AND user_courses.usercourses_status = '1' " . $wsql . " ORDER BY courses_start_y DESC, courses_start_m DESC, courses_start_d DESC, courses_end_y DESC, courses_end_m DESC, courses_end_d DESC, courses.courses_id DESC";
$usercourses = mysql_query($query_usercourses, $hrmsdb) or die(mysql_error());
$row_usercourses = mysql_fetch_assoc($usercourses);
$totalRows_usercourses = mysql_num_rows($usercourses);
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
        <?php include('../inc/menu_admin.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){ ?>
            <li class="form_back">
                  <form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label noline">Tahun</td>
                        <td width="100%" class="noline"><label for="tahun"></label>
                          <select name="tahun" id="tahun">
                            <?php for($i=date('Y'); $i>=2012; $i--){?>
                            <option <?php if($year==$i) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                        </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
            <li class="gap">&nbsp;</li>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Nama / Jawatan</td>
                      <td><strong><?php echo getFullNameByStafID($staffid);?></strong> (<?php echo $staffid;?>)<br/><?php echo getJobtitle($staffid) . " (" . getGred($staffid) . ")";?></td>
                    </tr>
                    <tr>
                      <td class="label noline">Bahagian / Cawangan / Pusat / Unit</td>
                      <td class="noline"><?php echo getFulldirectoryByUserID($staffid);?></td>
                    </tr>
                  </table>
                </li>
            	<li class="gap">&nbsp;</li>
                <li class="title">Senarai Kursus</li>
            	<li class="gap">&nbsp;</li>
                
                <li>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_usercourses > 0) { // Show if recordset not empty ?>
    <tr>
      <th>Tarikh</th>
      <th width="100%" align="left" valign="middle">Kursus</th>
      <th align="left" valign="middle">Kategori</th>
      <th align="left" valign="middle">Laporan</th>
      <th align="left" valign="middle">Kehadiran</th>
      <th nowrap="nowrap">Jam Kursus</th>
      <th nowrap="nowrap">&nbsp;</th>
    </tr>
    <?php do { ?>
      <tr class="on">
        <td align="left" valign="top" nowrap="nowrap"><?php echo getCoursesDate($row_usercourses['courses_id'], 1);?></td>
        <td><div class="txt_line"><strong class="txt_size3"><?php echo getCoursesName($row_usercourses['courses_id']); ?></strong><br/><div class="txt_color1">Anjuran : <?php echo getOrganizedBy(0, $row_usercourses['courses_id']);?></div></div></td>
        <td align="center" valign="middle"><?php echo getCoursesCategoryName($row_usercourses['coursescategory_id']);?></td>
        <td align="center" valign="middle"><?php 
		if(getUserAsByUserID($staffid, $row_usercourses['courses_id'])==1) 
			echo "<img src=\"" . $url_main . "/icon/sign_info.png\" alt=\"Pembentang\" align=\"absbottom\" />"; 
		else if(checkReportNeed($row_usercourses['courses_id'])) 
			if(!checkReportSubmit($staffid, $row_usercourses['courses_id'])) 
				echo "<span class=\"txt_color2\">X</span>"; 
			else echo "<a href=\"" . $url_main . "admin/reportread.php?ucrid=" . getUserCoursesReportIDByCoursesID($staffid, $row_usercourses['courses_id']) . "\"><img src=\"../icon/page_edit.png\" width=\"16\" height=\"16\" alt=\"Lihat\" /></a>"; 
		else echo "&nbsp;";?></td>
        <td align="center" valign="middle"><?php iconAttendance($staffid, $row_usercourses['courses_id']);?></td>
        <td align="center" valign="middle" class="back_lightgrey">
          <?php echo viewCountDay($row_usercourses['courses_id'], $staffid);?>
        </td>
        <td align="center" valign="middle" ><ul class="func"><li><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){ ?><a onclick="return confirm('Anda mahu maklumat kehadiran berikut dipadam? \r\n\n <?php echo getCoursesName($row_usercourses['courses_id']); ?> \r\n\n <?php echo getFullNameByStafID($staffid);?> (<?php echo $staffid;?>)')" href="../sb/del_coursesattendadmin.php?cid=<?php echo $row_usercourses['usercourses_id']; ?>&deluc=<?php echo $row_usercourses['courses_id'];?>&id=<?php echo getID($staffid); ?>&url=1">X</a><?php }; ?></li></ul></td>
      </tr>
      <?php } while ($row_usercourses = mysql_fetch_assoc($usercourses)); ?>
    <tr>
      <td colspan="5" align="right" valign="middle" class="noline"><strong>Jumlah Jam Kursus</strong></td>
      <td align="center" valign="middle" nowrap="nowrap" class="back_lightgrey line_t"><?php $totalcourses = countCoursesHour($staffid , $year); if($totalcourses['0']!='0') echo $totalcourses['0'] . " Hari "; echo $totalcourses['1'] . " Jam "?></td>
      <td align="center" valign="middle" nowrap="nowrap" class="noline">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_usercourses ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
    </tr>
    <?php }; ?>
  </table>
            </li>
                <?php } else { ?>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
                  </tr>
                </table>
				</li>
                <?php };?>
            </ul>
          </div>
        </div>
        <?php echo noteCoursesReport('1');?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($usercourses);
?>
<?php include('../inc/footinc.php');?> 