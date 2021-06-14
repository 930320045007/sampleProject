<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='2';?>
<?php $menu2='2';?>
<?php

if (isset($_GET['id'])) {
  $colname_user_job = $row_user['user_stafid'];
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_job = sprintf("SELECT user_job.*, jobs_sub.jobss_name, jobs_sub.jobss_shortname FROM user_job LEFT JOIN user_job2 ON user_job.user_stafid = user_job2.user_stafid LEFT JOIN jobs_sub ON jobs_sub.jobss_id = user_job2.jobss_id WHERE user_job.user_stafid = %s ORDER BY user_job.userjob_id DESC", GetSQLValueString($colname_user_job, "text"));
$user_job = mysql_query($query_user_job, $hrmsdb) or die(mysql_error());
$row_user_job = mysql_fetch_assoc($user_job);
$totalRows_user_job = mysql_num_rows($user_job);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300' rel='stylesheet' type='text/css'>
<link href="css/print.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">

<span>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
        <tr>
                      <td align="center" valign="middle"><?php echo viewProfilePic($colname_user_job);?></td>
                      <td width="100%" align="left" valign="middle">
                        <div><strong><?php echo getFullNameByStafID($colname_user_job) . " (" . $colname_user_job . ")"; ?></strong></div>
                        <div class="txt_color1"><?php echo getJobtitle($colname_user_job) . " (" . getGred($colname_user_job) . ")";?></div>
                        <div class="txt_color1"><?php echo getFulldirectoryByUserID($colname_user_job);?></div>
                      </td>
                    </tr>
                  </table>
                  
               <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>STATUS PENJAWATAN</strong></td>
    </tr>
    </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
                    <tr>
                      <th nowrap="nowrap" class="label">Jawatan</tH>
                      <td class="w50"><?php echo getJobtitleReal($row_user['user_stafid']);?> (<?php echo getGred($row_user['user_stafid']); ?>) <br/> <?php echo "(" . getGroupByUserID($row_user['user_stafid']) . ")";?> &nbsp; <span class="inputlabel2">(<?php echo getSchemeDateByUserID($row_user['user_stafid']);?>)</span></td>
                      <th nowrap="nowrap" class="label">Status</th>
                      <td class="w50" ><?php echo getJobtype($row_user['user_stafid']); ?> <?php if(!getDesignationType($row_user['user_stafid'])){?>(<?php echo getDesignationPeriod($row_user['user_stafid']);?>  <?php if(getDesignationPeriod($row_user['user_stafid'])<=6 && !getDesignationType($row_user['user_stafid'])) echo '&sup2;';?>)<?php }; ?> <br/><span class="inputlabel2">(<?php echo getDesignationDate($row_user['user_stafid']); ?>)</span> <?php if(getDesignationPeriod($row_user['user_stafid'])<=6 && !getDesignationType($row_user['user_stafid'])) echo noteHR('3'); ?></td>
                    </tr>
                    <tr>
                      <th nowrap="nowrap" class="label">Jawatan 2</th>
                      <td ><?php echo getJobtitle2($row_user['user_stafid']);?></td>
                      <th nowrap="nowrap" class="label">Tangga Gaji</th>
                      <td ><?php echo getSalarySkill($row_user['user_stafid'],0, date('m'), date('Y')); ?> <br/><span class="inputlabel2">(<?php echo getSalarySkillDate($row_user['user_stafid']); ?>)</span></td>
                    </tr>
                    <tr>
                      <th nowrap="nowrap" class="label">Unit / Cawangan / <br />
                      Pusat / Bahagian</th>
                      <td><?php echo getFulldirectory(getDirIDByUser($row_user['user_stafid']));?></td>
                      <th nowrap="nowrap" class="label">Lokasi</th>
                      <td><?php echo getLocationByUserID($row_user['user_stafid']); ?></td>
                    </tr>
                    <tr>
                      <th nowrap="nowrap" class="label">Tarikh Mula <br>
                      Dilantik Ke ISN</th>
                      <td><?php echo $row_user_job['userjob_start_d']; ?> / <?php echo $row_user_job['userjob_start_m']; ?> / <?php echo $row_user_job['userjob_start_y']; ?></td>
                      <th nowrap="nowrap" class="label">Tarikh Sah <br />
                      Jawatan</th>
                      <td><?php echo $row_user_job['userjob_promoted_d']; ?> / <?php echo $row_user_job['userjob_promoted_m']; ?> / <?php echo $row_user_job['userjob_promoted_y']; ?></td>
                    </tr>
                    <tr>
                      <th nowrap="nowrap" class="label noline">Tarikh Mula Lantikan Tetap</th>
                      <td class="noline"><?php echo $row_user_job['userjob_in_d']; ?> / <?php echo $row_user_job['userjob_in_m']; ?> / <?php echo $row_user_job['userjob_in_y']; ?></td>
                      <td class="label noline">&nbsp;</td>
                      <td class="noline">&nbsp;</td>
                    </tr>
                  </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>MAKLUMAT TAMBAHAN</strong></td>
    </tr>
    </table>
        	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
                    <tr>
                      <th class="label">No. KWSP</th>
                      <td><?php if(checkKWSPByUserID($row_user['user_stafid'])){ echo getKWSPByUserID($row_user['user_stafid']); ?><div class="inputlabel2"><?php if(!checkKWSPByStafID($row_user['user_stafid'], date('d'), date('m'), date('Y'))) echo getKWSPDateByStafID($row_user['user_stafid']);?></div><?php } else { echo "Tidak dinyatakan";}?></td>
                      <th class="label">No. PERKESO</th>
                      <td><?php if(checkPERKESOByUserID($row_user['user_stafid'])){ echo getPERKESOByUserID($row_user['user_stafid']);?><div class="inputlabel2"><?php if(!checkPERKESOByStafID($row_user['user_stafid'], date('d'), date('m'), date('Y'))) echo getPERKESODateByStafID($row_user['user_stafid']);?></div><?php } else { echo "Tidak dinyatakan";}?></td>
                    </tr>
                    <tr>
                      <th class="label">No. LHDN</th>
                      <td><?php if(checkLHDNByUserID($row_user['user_stafid'])){ echo getLHDNByUserID($row_user['user_stafid']);?><div class="inputlabel2"><?php if(!checkLHDNByStafID($row_user['user_stafid'], date('d'), date('m'), date('Y'))) echo getLHDNDateByStafID($row_user['user_stafid']);?></div><?php } else { echo "Tidak dinyatakan";}?></td>
                      <th class="label">Kelab ISN</th>
                      <td><?php if(checkKelabMSNRM($row_user['user_stafid'])) echo "Ya"; else echo "Tidak"; ?></td>
                    </tr>
                    <tr>
                      <th class="label noline">Nama Bank</th>
                      <td class="noline"><?php if(checkBankByUserID($row_user['user_stafid'])) echo getBankNameByUserID($row_user['user_stafid']); else echo "Tidak dinyatakan";?></td>
                      <th class="label noline">No. Akaun</th>
                      <td class="noline"><?php if(checkAccBankByUserID($row_user['user_stafid'])) echo getAccBankByUserID($row_user['user_stafid']); else echo "Tidak dinyatakan";?></td>
                    </tr>
                  </table>
</body>
</html>
<?php
?>
<?php include('inc/footinc.php');?> 