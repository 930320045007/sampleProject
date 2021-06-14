<?php require_once('../Connections/hrmsdb.php');?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='23';?>
<?php 
if(isset($_GET['id']))
	$userid = getStafIDByUserID(getID($_GET['id'],0));
else
	$userid = $row_user['user_stafid'];

if(isset($_GET['y']))
	$y = htmlspecialchars($_GET['y'], ENT_QUOTES);
else
	$y = date('Y');
	
$totalcuti = 0;
$totalGanti = 0;
$totalleave = 0;
$totalPLC = 0;

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_allleave = "SELECT userleavedate_id, userleavedate_note, clinictype_id FROM www.user_leavedate WHERE user_stafid = '" . $userid . "' AND userleavedate_date_y = '" . $y . "' AND (leavetype_id = '1' OR leavetype_id = '2' OR leavetype_id = '4' OR leavetype_id = '5' OR leavetype_id = '6' OR leavetype_id = '7') AND userleavedate_status = '1' AND userleavedate_app < '2' ORDER BY userleavedate_date_y ASC, userleavedate_date_m ASC, userleavedate_date_d ASC";
$allleave = mysql_query($query_allleave, $hrmsdb) or die(mysql_error());
$row_allleave = mysql_fetch_assoc($allleave);
$totalRows_allleave = mysql_num_rows($allleave);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300' rel='stylesheet' type='text/css'>
<link href="../css/print.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
                    <tr>
                      <td colspan="3" align="center" valign="middle">Kenyataan Cuti bagi Tahun <strong><?php echo $y;?></strong></td>
                    </tr>
                  </table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
                  <tr>
                    <td rowspan="3" align="center" valign="top" class="noline"><?php echo viewProfilePic($userid);?></td>
                    <td nowrap="nowrap" class="label">Nama Pegawai</td>
                    <td width="100%" colspan="3"><strong><?php echo getFullNameByStafID($userid);?></strong></td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">No. Kad Pengenalan</td>
                    <td nowrap="nowrap"><?php echo getICNoByStafID($userid);?></td>
                    <td nowrap="nowrap" class="label">Tarikh Lantikan</td>
                    <td nowrap="nowrap"><?php echo getStartDayDate($userid, 0);?></td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label noline">Jawatan</td>
                    <td width="50%" class="noline"><?php echo getJobtitleReal($userid);?> (<?php echo getGred($userid); ?>)</td>
                    <td nowrap="nowrap" class="label noline">No. Fail</td>
                    <td width="50%" nowrap="nowrap" class="noline"><?php echo $userid;?></td>
                  </tr>
                </table>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabborder">
                    <tr>
                      <th rowspan="2" align="left" valign="middle" nowrap="nowrap" >Tahun</th>
                      <th colspan="3" align="center" valign="middle" nowrap="nowrap" >Cuti</th>
                      <th rowspan="2" align="center" valign="middle" nowrap="nowrap">GCR</th>
                      <th rowspan="2" align="center" valign="middle" nowrap="nowrap">Bawa Ke Hadapan</th>
                      <th rowspan="2" align="center" valign="middle" nowrap="nowrap">Baki</th>
                    </tr>
                    <tr>
                      <th nowrap="nowrap">Peruntukan</th>
                      <th nowrap="nowrap">Ganti</th>
                      <th nowrap="nowrap" class="line_r">Penggunaan</th>
                    </tr>
                    <?php for($i=$y; $i>=($y-2); $i--){?>
                    <tr class="line_b">
                      <td align="left" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                      <td align="center" valign="middle" nowrap="nowrap""><?php $totalcuti += getLeave($userid, $i); echo getLeave($userid, $i) + countPLC2year($userid, $i);?></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php $totalGanti += getTotalLeaveGanti($userid, $i); echo getTotalLeaveGanti($userid, $i);?></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php $totalleave += calAllLeave($userid, $i); echo calAllLeave($userid, $i);?></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo getGCRPerYearByUserID($userid, $i);?></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php $totalPLC += countPLC($userid, $i); echo countPLC($userid, $i);?></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo countLeaveBalance($userid, $i);?></td>
                    </tr>
                    <?php }; ?>
                    <tr class="line_b">
                      <td align="left" valign="middle">Jumlah</td>
                      <td align="center" valign="middle"><?php echo $totalcuti;?></td>
                      <td align="center" valign="middle"><?php echo $totalGanti;?></td>
                      <td align="center" valign="middle"><?php echo $totalleave;?></td>
                      <td align="center" valign="middle"><?php echo countTotalGCR($userid);?></td>
                      <td align="center" valign="middle"><?php echo $totalPLC;?></td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabborder">
                    <tr>
                      <th width="150" rowspan="<?php if(getDesignationType($userid)) echo "3"; else echo "2"; ?>" align="left" valign="middle" nowrap="nowrap" >Kelulusan</th>
                      <th rowspan="<?php if(getDesignationType($userid)) echo "3"; else echo "2"; ?>" align="left" valign="middle" nowrap="nowrap" >Jenis Cuti</th>
                      <th rowspan="<?php if(getDesignationType($userid)) echo "3"; else echo "2"; ?>" align="center" valign="middle" nowrap="nowrap" >Tarikh</th>
                      <th colspan="<?php if(getDesignationType($userid)) echo "7"; else echo "6"; ?>" align="center" valign="middle" nowrap="nowrap">Baki Peruntukan</th>
                      <th rowspan="<?php if(getDesignationType($userid)) echo "3"; else echo "2"; ?>" align="center" valign="middle" nowrap="nowrap">Catatan</th>
                    </tr>
                    <tr>
                      <th width="100" <?php if(getDesignationType($userid)) echo "rowspan=\"2\""; ?> align="center" valign="middle" nowrap="nowrap">Cuti Rehat +<br />
                        Cuti Ganti</th>
                      <th width="100" <?php if(getDesignationType($userid)) echo "colspan=\"2\"";?> align="center" valign="middle" nowrap="nowrap">Cuti<br />
                        Sakit</th>
                      <th width="100" <?php if(getDesignationType($userid)) echo "rowspan=\"2\""; ?> align="center" valign="middle" nowrap="nowrap">Cuti Tanpa<br />
                        Rekod</th>
                      <th width="100" <?php if(getDesignationType($userid)) echo "rowspan=\"2\""; ?> align="center" valign="middle" nowrap="nowrap">Cuti<br />
                        Bersalin</th>
                      <th width="100" <?php if(getDesignationType($userid)) echo "rowspan=\"2\""; ?> align="center" valign="middle" nowrap="nowrap">Cuti Tanpa<br />
                        Gaji</th>
                      <th width="100" <?php if(getDesignationType($userid)) echo "rowspan=\"2\""; ?> align="center" valign="middle" nowrap="nowrap" class="line_r">Cuti Melebihi<br/>
                        Kelayakkan</th>
                    </tr>
                    <?php if(getDesignationType($userid)){?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Kerajaan</th>
                      <th align="center" valign="middle" nowrap="nowrap" class="line_r">Swasta</th>
                    </tr>
                    <?php }; ?>
                    <tr class="back_lightgrey">
                      <td align="left" valign="middle" class="line_t">&nbsp;</td>
                      <td align="left" valign="middle" class="line_t">&nbsp;</td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                      <td align="center" valign="middle" class="line_t"> <?php $ddCuti = getLeave($userid, $y)+ getTotalLeaveGanti($userid, $y) + countPLC2year($userid, $y);?>
                      <strong><?php echo $ddCuti;?></strong></td>
                      <?php if(getDesignationType($userid)){?>
                      <td align="center" valign="middle" class="line_t"><strong><?php echo getEL($userid, $y, 1);?></strong></td>
                      <td align="center" valign="middle" class="line_t"><strong><?php echo getEL($userid, $y, 2);?></strong></td>
                      <?php } else { ?>
                      <td align="center" valign="middle" class="line_t"><strong><?php echo getEL($userid, $y);?></strong></td>
                      <?php }; ?>
                      <td align="center" valign="middle" class="line_t"><strong>
                        <?php $lwor = getLeaveWOR($userid); echo $lwor;?>
                      </strong></td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                      <td class="line_t">&nbsp;</td>
                    </tr>
                    <?php if ($totalRows_allleave > 0) { // Show if recordset not empty ?>
                    <?php $ddSakit = getEL($userid);?>
                    <?php $ddSakitG = getEL($userid, $y, 1); // Staf Tetap melalui Klinik Kerajaan?>
                    <?php $ddSakitS = getEL($userid, $y, 2); // Staf Tetap melalui Klinik Swasta?>
                    <?php do { ?>
                    <tr class="on">
                      <td align="left" valign="middle" class="line_t"><?php echo shortText(getShortNameByStafID(getLeaveAppBy($row_allleave['userleavedate_id'])), 15);?></td>
                      <td align="left" valign="middle" nowrap="nowrap" class="line_t"><?php echo getLeaveType(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])); ?></td>
                      <td align="center" valign="middle" nowrap="nowrap" class="line_t"><?php echo getLeaveDate($row_allleave['userleavedate_id']);?></td>
                      <td width="70" align="center" valign="middle" nowrap="nowrap" class="line_t"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==1){$ddCuti-=1; echo $ddCuti;}; ?></td>
                      <?php if(getDesignationType($userid)){?>
                      <td width="70" align="center" valign="middle" nowrap="nowrap" class="line_t"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==2 && $row_allleave['clinictype_id']==1){$ddSakitG-=1; echo $ddSakitG;}; ?></td>
                      <td width="70" align="center" valign="middle" nowrap="nowrap" class="line_t"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==2 && $row_allleave['clinictype_id']==2){$ddSakitS-=1; echo $ddSakitS;}; ?></td>
                      <?php } else { ?>
                      <td width="70" align="center" valign="middle" nowrap="nowrap" class="line_t"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==2){$ddSakit-=1; echo $ddSakit;}; ?></td>
                      <?php }; ?>
                      <td width="70" align="center" valign="middle" nowrap="nowrap" class="line_t"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==4){$lwor-=1; echo $lwor;}; ?></td>
                      <td width="70" align="center" valign="middle" nowrap="nowrap" class="line_t"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==5){ echo getLeaveBirthDay($row_allleave['userleavedate_id']);}; ?></td>
                      <td width="70" align="center" valign="middle" nowrap="nowrap" class="line_t"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==6){ echo getDayLeaveWOSByID($row_allleave['userleavedate_id']);}; ?></td>
                      <td width="70" align="center" valign="middle" nowrap="nowrap" class="line_t"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==7){ echo getDayLeaveMTQByID($row_allleave['userleavedate_id']);}; ?></td>
                      <td nowrap="nowrap" class="line_t"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==4 || getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==5 || getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==6 || getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==7) echo shortText($row_allleave['userleavedate_note'], 20);?></td>
                    </tr>
                    <?php } while ($row_allleave = mysql_fetch_assoc($allleave)); ?>
                    <tr>
                      <td colspan="<?php if(getDesignationType($userid)) echo "11"; else echo "10"; ?>" align="center" valign="middle" class="line_t"><?php echo $totalRows_allleave ?> rekod dijumpai</td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                      <td colspan="<?php if(getDesignationType($userid)) echo "11"; else echo "10"; ?>" align="center" valign="middle" class="line_t">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  <?php } ; ?>
</body>
</html>
<?php
mysql_free_result($allleave);
?>
<?php include('../inc/footinc.php');?>
