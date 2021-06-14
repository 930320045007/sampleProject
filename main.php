<?php require_once('Connections/hrmsdb.php'); ?>
<?php require_once('Connections/selidikdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php if(checkUserSysAcc($row_user['user_stafid'], 6, 9, 1)) include('inc/ictfunc.php');?>
<?php if(checkUserSysAcc($row_user['user_stafid'], 12, 44, 1)) include('inc/hartafunc.php');?>
<?php if(checkUserSysAcc($row_user['user_stafid'], 10, 39, 1)) include('inc/tadbirfunc.php');?>
<?php include('inc/selidikfunc.php');?>
<?php $menu = '1';?> 
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_stafleave = "SELECT * FROM www.user_leavedate LEFT JOIN www.user_unit ON user_unit.user_stafid=user_leavedate.user_stafid WHERE user_leavedate.userleavedate_status = 1 AND userunit_status = 1 AND userleavedate_app != 2 AND user_unit.dir_id = '" . getDirIDByUser($row_user['user_stafid']) . "' AND userleavedate_date_y = '" . date('Y') . "' AND userleavedate_date_m = '" . date('m') . "' AND userleavedate_date_d = '" . date('d') . "' ORDER BY userleavedate_id DESC";
$stafleave = mysql_query($query_stafleave, $hrmsdb) or die(mysql_error());
$row_stafleave = mysql_fetch_assoc($stafleave);
$totalRows_stafleave = mysql_num_rows($stafleave);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_stafleave2 = "SELECT * FROM www.user_leavedate LEFT JOIN www.user_unit ON user_unit.user_stafid=user_leavedate.user_stafid WHERE user_leavedate.userleavedate_status = 1 AND userunit_status = 1 AND userleavedate_app != 2 AND user_unit.dir_id = '" . getDirIDByUser($row_user['user_stafid']) . "' AND userleavedate_date_y = '" . date('Y', strtotime('tomorrow')) . "' AND userleavedate_date_m = '" . date('m', strtotime('tomorrow')) . "' AND userleavedate_date_d = '" . date('d', strtotime('tomorrow')) . "' ORDER BY userleavedate_id DESC";
$stafleave2 = mysql_query($query_stafleave2, $hrmsdb) or die(mysql_error());
$row_stafleave2 = mysql_fetch_assoc($stafleave2);
$totalRows_stafleave2 = mysql_num_rows($stafleave2);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_usercourses1 = "SELECT user_courses.* FROM www.user_courses LEFT JOIN www.courses ON courses.courses_id = user_courses.courses_id WHERE courses.courses_start_d >= '" . date('d') . "' AND courses.courses_start_m >= '" . date('m') . "' AND courses.courses_start_y = '" . date('Y') . "' AND courses.courses_end_d <= '" . date('d') . "' AND courses.courses_end_m <= '" . date('m') . "' AND courses.courses_end_y = '" . date('Y') . "' AND user_courses.user_stafid = '" . $row_user['user_stafid'] . "' ORDER BY user_courses.usercourses_id ASC";
$usercourses1 = mysql_query($query_usercourses1, $hrmsdb) or die(mysql_error());
$row_usercourses1 = mysql_fetch_assoc($usercourses1);
$totalRows_usercourses1 = mysql_num_rows($usercourses1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
</head>
<body <?php include('inc/bodyinc.php');?>>
<?php echo getPassBoxC('formPasswordc', $url_main . 'sb/leavehead_ER.php', $url_main . "main.php");?>

<?php $qnaid = checkSurveyMandatory($row_user['user_stafid']);?> 
<?php if($qnaid!=0){ // QnA ?>
<div class="passbox_back" id="formQnA">
<div class="passbox_form">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		  <tr>
			<td colspan="2" class="title noline">Soal selidik</td>
		</tr>
		<tr>
			<td  class="back_white noline txt_line">Kakitangan MSN diminta untuk menjawab soal selidik berikut : <br/><span class="inputlabel2">Klik pada tajuk soal selidik dibawah</span></td>
		</tr>
		<tr>
			<td  class="back_white">
            <ul>
            	<li><a href="<?php echo $url_main;?>qna/surveydetailuser.php?id=<?php echo getID($qnaid);?>"><?php echo getSurveyTitle($qnaid);?></a></li>
            </ul>
            </td>
		</tr>
	  </table>
</div>
</div>
<?php }; ?>
        
<div>
	<div>
		<?php include('inc/header.php');?>
        <?php include('inc/menu.php');?>
        
      	<div class="content">
          <div class="profilemenu">
          	<ul>
            <li <?php if(date('m')>='01'){?>class="hidden"<?php } elseif(date('d')>'07') { ?>class="hidden"<?php };?>>
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                <tr>
                  <td class="icon_pad1"><?php echo viewProfilePic(getHeadIDByUserID($row_user['user_stafid']));?></td>
                  <td width="100%"><div class="txt_color1 padb">Sila semak nama <strong>pegawai yang meluluskan cuti</strong> anda. Jika berlaku kesilapan pada nama yang dinyatakan, sila klik butang 'Ralat' disebelah kanan.</div>
                      <div><strong><?php echo getFullNameByStafID(getHeadIDByUserID($row_user['user_stafid'])) . " (" . getHeadIDByUserID($row_user['user_stafid']) . ")";?></strong></div>
                  <div class="txt_color1"><?php echo getJobtitle2(getHeadIDByUserID($row_user['user_stafid'])) . " " . getFulldirectoryByUserID(getHeadIDByUserID($row_user['user_stafid']));?></div>
                  </td>
                  <td nowrap="nowrap"><input name="button3" type="submit" class="submitbutton" id="button3" value="Ralat" onClick="toggleview2('formPasswordc'); return false;" /></td>
                </tr>
              </table>
            </li>
            <?php if($maintenance){?>
            <li>
              <div class="box padt padb"><img src="icon/sign_error.png" alt="Error" width="16" height="16" align="absbottom" /> &nbsp; Sistem dalam proses pengemaskinian dan penambahbaikkan buat sementara waktu.</div>
            </li>
            <?php }; ?>
            <li>
            <!-- <div class="inputlabel2" style="text-align:right;"> Daftar masuk terakhir : <?php echo htmlspecialchars(getLastLogin($row_user['user_stafid']), ENT_QUOTES);?></div> -->
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
       	      <tr>
       	        <td align="center" valign="middle" nowrap="nowrap" class="icon_pad1"><img src="<?php echo $url_main;?>icon/bag.png" alt="Cuti" /></td>
       	        <td nowrap="nowrap" class="line_r" width="25%">
               	  <div>Baki Cuti  <?php echo date('Y');?></div>
                  <div class="txt_size1"><?php echo countLeaveBalance($row_user['user_stafid'], date('Y'));?> <span class="txt_size2">Hari</span></div>
                </td>
       	        <td align="center" valign="middle" nowrap="nowrap" class="icon_pad1"><img src="<?php echo $url_main;?>icon/health.png" alt="Cuti" /></td>
       	        <td nowrap="nowrap" class="line_r" width="25%">
               	  <div>Baki Cuti Sakit <?php echo date('Y');?></div>
                  <?php if(getDesignationType($row_user['user_stafid'])){ ?>
               	  <div>(Klinik Kerajaan / Swasta)</div>
                      <div class="txt_size1"><?php echo countELBalance($row_user['user_stafid'], date('Y'), 1); ?> <span class="txt_size2">Hari &nbsp; &nbsp; </span><?php echo countELBalance($row_user['user_stafid'], date('Y'), 2); ?> <span class="txt_size2">Hari </span></div> 
                      <div class="txt_size1"></div>
				  <?php } else { ?>
                   	  <div class="txt_size1"><?php echo countELBalance($row_user['user_stafid'], date('Y')); ?> <span class="txt_size2">Hari</span></div>
				  <?php }; ?>
                </td>
       	        <td align="center" valign="middle" nowrap="nowrap" class="icon_pad1"><img src="<?php echo $url_main;?>icon/id.png" alt="Cuti" /></td>
       	        <td nowrap="nowrap" class="line_r" width="25%">
				  <?php $courses = countCoursesHour($row_user['user_stafid'], date('Y'));?>
               	  <div><?php if(checkTotalCoursesByStafID($row_user['user_stafid'], date('Y'))>0) echo "Kursus Di Hadiri"; else echo "Jumlah perlu dihadiri";?></div>
                  <div class="txt_size1">
				  <?php if($courses[0]!=0) echo $courses[0] . "<span class=\"txt_size2\"> &nbsp; Hari </span> &nbsp; ";?>
				  <?php if($courses[1]!=0) echo $courses[1] . "<span class=\"txt_size2\"> &nbsp;Jam </span>"; ?>
				  <?php if(checkTotalCoursesByStafID($row_user['user_stafid'], date('Y'))==0) echo getCoursesDayByYear($row_user['user_stafid'], date('Y')) . "<span class=\"txt_size2\"> &nbsp;  Hari </span>";?></div>
                </td>
       	        <td align="center" valign="middle" nowrap="nowrap" class="icon_pad1"><img src="<?php echo $url_main;?>icon/user.png" alt="Cuti" /></td>
       	        <td nowrap="nowrap" width="25%">
               	  <div>Tempoh Berkhidmat</div>
                  <div class="txt_size1"><?php $service = getService($row_user['user_stafid']); ?><?php if($service[0]!=0) echo $service[0] . "<span class=\"txt_size2\"> &nbsp; Tahun </span> ";?> &nbsp; <?php if($service[1]!=0) echo $service[1] . " <span class=\"txt_size2\"> &nbsp; Bulan </span> ";?> <?php //if($service[2]!=0) echo $service[2] . " <span class=\"txt_size2\"> Hari </span>";?></div>
                </td>
   	          </tr>
           <?php if(checkUserSysAcc($row_user['user_stafid'], 6, 9, 1)){?>
              <tr>
                <td align="center" valign="middle" class="pad1">
                    <div class="txt_icon <?php $totalBorrow = countTotalBorrowNeedApproval(0, 0, 0); if($totalBorrow>=10) echo "txt_color2";?>">
					<?php echo $totalBorrow;?>
                    </div>
                    <div>rekod</div>
                </td>
                <td width="25%" class="line_r">Permohonan Pinjaman<br/><span class="txt_color1">belum dipertimbangkan</span></td>
                <td align="center" valign="middle" class="pad1">
                  <div class="txt_icon <?php $totalReport = countReportNeedApproval(0, 0, 0); if($totalReport>=10) echo "txt_color2";?>">
				  <?php echo $totalReport;?>
                  </div>
                  <div>rekod</div>
                </td>
                <td width="25%" class="line_r">Aduan Pengguna<br/><span class="txt_color1">belum selesai</span></td>
                <td align="center" valign="middle" nowrap="nowrap" class="pad1">
                  <div class="txt_icon <?php $totalEmail = countDeActEmail(); if($totalEmail>=10) echo "txt_color2";?>">
				  <?php echo $totalEmail;?>
                  </div>
                  <div>rekod</div>
                </td>
                <td width="25%" class="line_r">Pengaktifan Email<br/><span class="txt_color1">pengguna</span></td>
                <td align="center" valign="middle" nowrap="nowrap" class="pad1">
                    <div class="txt_icon <?php $totalApply = countTotalApplyNeedApproval(); if($totalApply>=10) echo "txt_color2";?>">
					<?php echo $totalApply;?>
                    </div>
                    <div>rekod</div>
                </td>
                <td width="25%" nowrap="nowrap">Permohonan Peralatan<br/><span class="txt_color1">belum dipertimbangkan</span></td>
              </tr>
           <?php }; ?>
           <?php if(checkUserSysAcc($row_user['user_stafid'], 12, 44, 1)){?>
              <tr>
                <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(0, 0, date('Y'), 0);?></div><div>rekod</div></td>
                <td width="25%" class="line_r"><div>aduan keseluruhan</div>
                  <div class="txt_color1"><?php echo date('Y', mktime(0, 0, 0, date('m'), date('d'), date('Y')));?></div></td>
                <td align="center" valign="middle" class="icon_pad1">
                <div class="txt_icon <?php $hartaReport2 = countNewReport(0, 0, date('Y'), 2); if($hartaReport2>=10) echo "txt_color2";?>">
				<?php echo $hartaReport2;?>
                </div>
                <div>rekod</div>
                </td>
                <td width="25%" class="line_r"><div>aduan keseluruhan</div>
                  <div class="txt_color1">tiada tindakan</div></td>
                <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon <?php $hartaReport1 = countNewReport(0, 0, date('Y'), 1); if($hartaReport1>=10) echo "txt_color2";?>"><?php echo $hartaReport1;?></div><div>rekod</div></td>
                <td width="25%" class="line_r"><div>aduan keseluruhan</div>
                  <div class="txt_color1">belum ditamatkan</div></td>
                <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(0, 0, date('Y'), 3);?></div><div>rekod</div></td>
                <td width="25%" nowrap="nowrap"><div>aduan keseluruhan</div>
                  <div class="txt_color1">ditamatkan</div></td>
              </tr>
           <?php }; ?>
           <?php if(checkUserSysAcc($row_user['user_stafid'], 10, 39, 1)){?>
              <tr>
                <td align="center" valign="middle" class="pad1"><div class="txt_icon"><?php echo getTotalBooking(0, 0, date('m'), date('Y'));?></div><div>rekod</div></td>
                <td class="line_r">
                <div>Tempahan Dewan/Bilik</div>
                <div class="txt_color1"><?php echo date('F Y', mktime(0, 0, 0, date('m'), date('d'), date('Y')));?></div>
                </td>
                <td align="center" valign="middle" class="pad1"><div class="txt_icon <?php $adminTiket = getTotalTiketApp(); if($adminTiket>=10) echo "txt_color2";?>"><?php echo $adminTiket;?></div><div>rekod</div></td>
                <td class="line_r">
                <div>Permohonan Tiket</div>
                <div class="txt_color1">belum diproses</div>
                </td>
                <td align="center" valign="middle" class="pad1"><div class="txt_icon"><?php echo getTotalTransportTypeByMonth(0, date('d'), date('m'), date('Y'));?></div><div>rekod</div></td>
                <td class="line_r">
                <div>Tempahan Kenderaan</div>
                <div class="txt_color1">pada <?php echo date('d / m / Y (D)');?></div>
                </td>
                <td align="center" valign="middle" class="pad1"><div class="txt_icon">*</div><div>rekod</div></td>
                <td>
                <div>****</div>
                <div class="txt_color1">****</div>
                </td>
              </tr>
			<?php }; ?>
            </table>
           </li>
            <?php if ($totalRows_stafleave > 0 || $totalRows_stafleave2 > 0) { // Show if recordset not empty ?>
              <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="icon_table">
                  <tr>
                    <td align="center" valign="top" nowrap="nowrap" class="icon_pad1"><img src="icon/calendar.png" width="48" height="48" alt="Calendar" /></td>
                    <td width="100%" align="left" valign="top">
                    <?php if($totalRows_stafleave > 0){?>
                      <div class="padb">Senarai bercuti pada &nbsp; <strong><?php echo date('d / m / Y (D)');?></strong></div>
                      <?php do { ?>
                        <div class="li3c"><span class="name">&bull; &nbsp; <?php echo getFullNameByStafID($row_stafleave['user_stafid']); ?> - <?php echo  getLeaveType($row_stafleave['leavetype_id']);?></span></div>
                        <?php } while ($row_stafleave = mysql_fetch_assoc($stafleave)); ?>
                      <?php }; ?>
                      <?php if($totalRows_stafleave2 > 0){?>
                      <div class="padb padt">Senarai bercuti pada &nbsp; <strong><?php echo date('d / m / Y (D)', strtotime('tomorrow'));?></strong></div>
                      <?php do { ?>
                        <div class="li3c"><span class="name">&bull; &nbsp; <?php echo getFullNameByStafID($row_stafleave2['user_stafid']); ?> - <?php echo  getLeaveType($row_stafleave2['leavetype_id']);?></span></div>
                        <?php } while ($row_stafleave2 = mysql_fetch_assoc($stafleave2)); ?>
                        <?php }; ?>
                    </td>
                  </tr>
                </table>
            </li>
              <?php } // Show if recordset not empty ?>
              <?php if ($totalRows_usercourses1 > 0) { // Show if recordset not empty ?>
              <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="icon_table">
                  <tr>
                    <td align="center" valign="top" nowrap="nowrap" class="icon_pad1"><img src="icon/calendar.png" width="48" height="48" alt="Calendar" /></td>
                    <td width="100%" align="left" valign="top">
                      <div class="padb">Program hari ini</div>
                      <?php do { ?>
                      <div class="txt_line"><?php echo getCoursesName($row_usercourses1['courses_id']); ?><span class="txt_color1"> &nbsp; &bull; &nbsp; <?php echo getCoursesLocation($row_usercourses1['courses_id']);?> &nbsp; &bull; &nbsp; <?php echo getCoursesTime($row_usercourses1['courses_id']);?></span></div>
                      <?php } while ($row_usercourses1 = mysql_fetch_assoc($usercourses1)); ?>
                    </td>
                  </tr>
                </table>
              </li>
              <?php } // Show if recordset not empty ?>
            </ul>
          </div>
          <?php echo noteEmail('1');?>
        </div>
        
		<?php include('inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($stafleave);

mysql_free_result($stafleave2);

mysql_free_result($usercourses1);

mysql_free_result($user);
?>
<?php include('inc/footinc.php');?>
