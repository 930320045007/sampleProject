<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='59';?>
<?php $menu3='2';?>
<?php

$y = date('Y');

$stafid = "-1";
if(isset($_GET['lid']))
{
	$stafid = $_GET['lid'];
} 

mysql_select_db($database_skt, $skt);
$query_staflist = "SELECT * FROM skt.pp WHERE pp_status = '1' AND pp_ppp = '" . $row_user['user_stafid'] . "' ORDER BY user_stafid ASC";
$staflist = mysql_query($query_staflist, $skt) or die(mysql_error());
$row_staflist = mysql_fetch_assoc($staflist);
$totalRows_staflist = mysql_num_rows($staflist);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_report = "SELECT user_courses.*, courses.durationtype_id, courses_start_y, courses_time, courses_location, courses_status FROM user_courses LEFT JOIN courses ON courses.courses_id = user_courses.courses_id WHERE (coursestype_id = '2' OR coursestype_id = '4' OR coursestype_id = '5' OR coursestype_id ='6') AND courses.courses_status = '1' AND user_courses.user_stafid = '" . $stafid . "' AND courses.courses_start_y = '" . $y . "' AND user_courses.usercourses_status = 1 ORDER BY courses_start_y DESC, courses_start_m DESC, courses_start_d DESC, courses_end_y DESC, courses_end_m DESC, courses_end_d DESC, courses.courses_id DESC";
$report = mysql_query($query_report, $hrmsdb) or die(mysql_error());
$row_report = mysql_fetch_assoc($report);
$totalRows_report = mysql_num_rows($report);

mysql_select_db($database_skt, $skt);
$query_uskt = "SELECT user_skt.*, pp.pp_ppp FROM skt.user_skt LEFT JOIN skt.pp ON pp.user_stafid = user_skt.user_stafid WHERE pp_ppp = '" . $row_user['user_stafid'] . "' AND user_skt.user_stafid = '" . $stafid . "' AND uskt_date_y = '" . $y . "' AND user_skt.uskt_status = 1 ORDER BY uskt_masa_mula ASC, uskt_masa_tamat ASC, user_skt.uskt_id ASC";
$uskt = mysql_query($query_uskt, $skt) or die(mysql_error());
$row_uskt = mysql_fetch_assoc($uskt);
$totalRows_uskt = mysql_num_rows($uskt);

mysql_select_db($database_skt, $skt);
$query_akt = "SELECT * FROM skt.user_aktiviti WHERE user_stafid = '" . $stafid . "' AND useraktiviti_status=1 AND useraktiviti_year='" . $y . "' ORDER BY useraktiviti_id ASC";
$akt = mysql_query($query_akt, $skt) or die(mysql_error());
$row_akt = mysql_fetch_assoc($akt);
$totalRows_akt = mysql_num_rows($akt);

mysql_select_db($database_skt, $skt);
$query_tr = "SELECT * FROM skt.user_training WHERE usertraining_date_y = '" . $y . "' AND user_stafid = '" . $stafid . "' AND usertraining_status = 1 ORDER BY usertraining_id ASC";
$tr = mysql_query($query_tr, $skt) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);
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
      	<?php include('../inc/menu_skt.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
             <?php include('../inc/menu_senaraiskt.php');?>
          <ul>
            <?php if(checkPPPByStafID($row_user['user_stafid']) && getPPPByStafID($stafid) == $row_user['user_stafid']){?>               
              <li>
                <div class="note"><strong>Bahagian II - Kegiatan &amp; Sumbangan Di Luar Tugas Rasmi/ Latihan</strong></div><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" valign="top" class="icon_pad1"><?php echo viewProfilePic($stafid);?></td>
                    <td width="100%" class="txt_line">
                      <div>Profil Pegawai Yang Dinilai (PYD)</div>
					  <div class="txt_size3"><strong><?php echo getFullNameByStafID($stafid) . " (" . $stafid . ")";?></strong></div>
                      <div><span class="txt_color1"><?php echo getJobtitle($stafid) . ", "; ?><?php echo getFulldirectoryByUserID($stafid);?></span></div>
                      <div class="txt_color1">Email : <?php echo getEmailISNByUserID($stafid);?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID($stafid);?></div>
                    </td>
                  </tr>
                  </table>
                  <li>&nbsp;</li>
              <li><div class="title">Senarai <strong>kegiatan / aktiviti</strong> bagi tahun <strong><?php echo $y;?></strong></div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_akt > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="100%" colspan="2" align="left" valign="middle" nowrap="nowrap">Kegiatan / aktiviti</th>
                  </tr>
                  <?php $i=1; do { ?>
                  <?php
					mysql_select_db($database_skt, $skt);
					$query_prog = "SELECT * FROM skt.user_program WHERE useraktiviti_id = '" . $row_akt['useraktiviti_id'] . "' AND user_stafid = '" . $stafid . "' AND userprogram_status=1 ORDER BY userprogram_id ASC";
					$prog = mysql_query($query_prog, $skt) or die(mysql_error());
					$row_prog = mysql_fetch_assoc($prog);
					$totalRows_prog = mysql_num_rows($prog);
					?>
                  <tr class="on">
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td width="100%" align="left" valign="top" class="txt_line">
                      <div>
                          <div><strong><?php echo $row_akt['useraktiviti_name']; ?></strong></div>
                          <div class="txt_color1">Peringkat : <?php echo getOrgArchByID($row_akt['orgarch_id']); ?></div>
                          <div class="txt_color1">Jawatan : <?php echo getOrgLevelByID($row_akt['orglevel_id']); ?> <?php echo getAktivitiJawatanByAktID($row_akt['useraktiviti_id']);?></div>
                      </div>
                      <?php if ($totalRows_prog > 0) { // Show if recordset not empty ?>
                      <div class="txt_color1"><?php echo $totalRows_prog ?> Program :</div>
                        <div class="txt_color1">
                          <ol>
                            <?php do { ?>
                              <li><?php echo $row_prog['userprogram_name']; ?>, Peringkat <?php echo getOrgArchByID($row_prog['orgarch_id']); ?> sebagai <?php echo getOrgLevelByID($row_prog['orglevel_id']) . " " . getProgramJawatanByProgID($row_prog['userprogram_id']); ?></li>
                              <?php } while ($row_prog = mysql_fetch_assoc($prog)); ?>
                          </ol>
                        </div>
                        <?php } // Show if recordset not empty ?>
                    </td>
                    <td align="left" valign="top" class="txt_line">&nbsp;</td>
                  </tr>
                  <?php
					mysql_free_result($prog);
					?>
                  <?php $i++; } while ($row_akt = mysql_fetch_assoc($akt)); ?>
                  <tr>
                    <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_akt ?> rekod dijumpai</td>
                  </tr>
                  <?php } else { ?>
                  <tr>
                    <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                  </tr>
                  <?php }; ?>
                </table>
                </li>
                <li>&nbsp;</li>
            <li>
                <div class="title">Latihan yang dihadiri</div>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                    <th align="center" valign="middle" nowrap="nowrap">Tarikh / Tempoh</th>
                    <th width="50%" align="left" valign="middle" nowrap="nowrap">Nama Latihan</th>
                    <th width="50%" align="left" valign="middle" nowrap="nowrap">Tempat</th>
                  </tr>
                  <?php if ($totalRows_report > 0) { // Show if recordset not empty ?>
                  <?php $i=1; do{ ?>
                  <tr class="on">
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php echo getCoursesDate($row_report['courses_id'],'1');?></td>
                    <td align="left" valign="middle" class="txt_line">
                    <div><strong><?php echo getCoursesName($row_report['courses_id']);?></strong></div>
					<div><?php echo getOrganizedBy(0,$row_report['courses_id']); ?></div>
                    </td>
                    <td align="left" valign="middle"><?php echo $row_report['courses_location']; ?></td>
                  </tr>
				  <?php $i++; } while ($row_report = mysql_fetch_assoc($report)); ?>
                  <tr>
                    <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_report ?>  rekod dijumpai</td>
                  </tr>
                  <?php } else { ?>
                  <tr>
                    <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                  </tr>
                  <?php }; ?>
                </table>
                </div>
                </li>
                <li>&nbsp;</li>
                <li>
                <div class="title">Senarai <strong>latihan</strong> yang diperlukan bagi tahun <strong><?php echo date('Y', mktime(0, 0, 0, 1, 1, $y+1));?></strong></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_tr > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th>Bil</th>
                      <th width="100%" align="left" valign="middle">Latihan</th>
                      <th>&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td align="left" valign="middle" class="txt_line"><div><b><?php echo $row_tr['usertraining_name']; ?></b></div>
                        <div class="txt_color1"><?php echo $row_tr['usertraining_note']; ?></div></td>
                      <td>&nbsp;</td>
                    </tr>
                    <?php $i++; } while ($row_tr = mysql_fetch_assoc($tr)); ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_tr ?> rekod dijumpai</td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
            <?php } else { ?>
           	  <li>
           	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
               	    <tr>
               	      <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
           	      </tr>
           	    </table>
              </li>
            <?php }; ?>
          </ul>
          </div>
        </div>
        </div>
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($staflist);
mysql_free_result($uskt);
mysql_free_result($akt);
mysql_free_result($report);
mysql_free_result($tr);
?>
<?php include('../inc/footinc.php');?> 