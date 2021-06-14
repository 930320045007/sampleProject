<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='2';?>
<?php $menu2='2';?>
<?php
$colname_user_job = "-1";
if (isset($_SESSION['user_stafid'])) {
  $colname_user_job = $_SESSION['user_stafid'];
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
<link href="css/index.css" rel="stylesheet" type="text/css" />
<script src="js/ajaxsbmt.js" type="text/javascript"></script>
<?php include('inc/headinc.php');?>
</head>
<body <?php include('inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('inc/header.php');?>
        <?php include('inc/menu.php');?>
        
      	<div class="content">
        <?php include('inc/menu_profail.php');?>
        <div class="tabbox">   
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="100%" align="right" valign="middle">
                        <input name="button5" type="button" class="submitbutton" id="button5" value="Cetak" onclick="MM_openBrWindow('<?php echo $url_main;?>printjob.php?id=<?php echo $row_user['user_stafid'];?>','job','status=yes,scrollbars=yes,width=800,height=600')" /></td>
          </tr>
          </table>     	
        <?php include('inc/profile.php');?>
        <div class="profilemenu">
        	<ul>
            	<li class="title">Status Penjawatan &sup1;</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Jawatan</td>
                      <td class="w50"><?php echo getJobtitleReal($row_user['user_stafid']);?> (<?php echo getGred($row_user['user_stafid']); ?>) <br/> <?php echo "(" . getGroupByUserID($row_user['user_stafid']) . ")";?> &nbsp; <span class="inputlabel2">(berkuatkuasa pada <?php echo getSchemeDateByUserID($row_user['user_stafid']);?>)</span></td>
                      <td nowrap="nowrap" class="label">Status</td>
                      <td class="w50" ><?php echo getJobtype($row_user['user_stafid']); ?> <?php if(!getDesignationType($row_user['user_stafid'])){?>(<?php echo getDesignationPeriod($row_user['user_stafid']);?>  <?php if(getDesignationPeriod($row_user['user_stafid'])<=6 && !getDesignationType($row_user['user_stafid'])) echo '&sup2;';?>)<?php }; ?> <br/><span class="inputlabel2">(berkuatkuasa pada <?php echo getDesignationDate($row_user['user_stafid']); ?>)</span> <?php if(getDesignationPeriod($row_user['user_stafid'])<=6 && !getDesignationType($row_user['user_stafid'])) echo noteHR('3'); ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Jawatan 2</td>
                      <td >
					  <div><?php echo getJobtitle2($row_user['user_stafid']);?></div>
                      <?php if(getJobtitle2Date($row_user['user_stafid'])!='') {?><div class="inputlabel2">berkuatkuasa pada <?php echo getJobtitle2Date($row_user['user_stafid']);?></div><?php }; ?>
                      </td>
                      <td nowrap="nowrap" class="label">Tangga Gaji</td>
                      <td ><?php echo getSalarySkill($row_user['user_stafid'],0, date('m'), date('Y')); ?> <br/><span class="inputlabel2">(berkuatkuasa pada <?php echo getSalarySkillDate($row_user['user_stafid']); ?>)</span></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Unit / Cawangan / <br />
                      Pusat / Bahagian</td>
                      <td>
					  <div><?php echo getFulldirectory(getDirIDByUser($row_user['user_stafid']));?></div>
                      <div class="inputlabel2">(berkuatkuasa pada <?php echo getDirDateByUser($row_user['user_stafid']);?>)</div>
                      </td>
                      <td nowrap="nowrap" class="label">Lokasi</td>
                      <td><?php echo getLocationByUserID($row_user['user_stafid']); ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Tarikh Mula <br>
                      Dilantik Ke MSN</td>
                      <td><?php echo $row_user_job['userjob_start_d']; ?> / <?php echo $row_user_job['userjob_start_m']; ?> / <?php echo $row_user_job['userjob_start_y']; ?></td>
                      <td nowrap="nowrap" class="label">Tarikh Sah <br />
                      Jawatan</td>
                      <td><?php echo $row_user_job['userjob_promoted_d']; ?> / <?php echo $row_user_job['userjob_promoted_m']; ?> / <?php echo $row_user_job['userjob_promoted_y']; ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Tarikh Mula Lantikan<br>
                      Tetap </td>
                      <td class="noline"><?php echo $row_user_job['userjob_in_d']; ?> / <?php echo $row_user_job['userjob_in_m']; ?> / <?php echo $row_user_job['userjob_in_y']; ?></td>
                      <td class="label noline">Tarikh Pergerakan Gaji <br />
                      (TPG)</td>
                      <td class="noline"><?php if($row_user_job['userjob_tpg_m']!=0) echo date('m - F', mktime(0, 0, 0, $row_user_job['userjob_tpg_m'], 1, date('Y'))); else echo "Tiada"; ?></td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Maklumat Tambahan &sup1;</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">No. KWSP</td>
                      <td><?php if(checkKWSPByUserID($row_user['user_stafid'])){ echo getKWSPByUserID($row_user['user_stafid']); ?><div class="inputlabel2"><?php if(!checkKWSPByStafID($row_user['user_stafid'], date('d'), date('m'), date('Y'))) echo getKWSPDateByStafID($row_user['user_stafid']);?></div><?php } else { echo "Tidak dinyatakan";}?></td>
                      <td class="label">No. PERKESO</td>
                      <td><?php if(checkPERKESOByUserID($row_user['user_stafid'])){ echo getPERKESOByUserID($row_user['user_stafid']);?><div class="inputlabel2"><?php if(!checkPERKESOByStafID($row_user['user_stafid'], date('d'), date('m'), date('Y'))) echo getPERKESODateByStafID($row_user['user_stafid']);?></div><?php } else { echo "Tidak dinyatakan";}?></td>
                    </tr>
                    <tr>
                      <td class="label">No. LHDN</td>
                      <td><?php if(checkLHDNByUserID($row_user['user_stafid'])){ echo getLHDNByUserID($row_user['user_stafid']);?><div class="inputlabel2"><?php if(!checkLHDNByStafID($row_user['user_stafid'], date('d'), date('m'), date('Y'))) echo getLHDNDateByStafID($row_user['user_stafid']);?></div><?php } else { echo "Tidak dinyatakan";}?></td>
                      <td class="label">Kelab MSN</td>
                      <td><?php if(checkKelabMSNRM($row_user['user_stafid'])) echo "Ya"; else echo "Tidak"; ?></td>
                    </tr>
                    <tr>
                      <td class="label noline">Nama Bank</td>
                      <td class="noline"><?php if(checkBankByUserID($row_user['user_stafid'])) echo getBankNameByUserID($row_user['user_stafid']); else echo "Tidak dinyatakan";?></td>
                      <td class="label noline">No. Akaun</td>
                      <td class="noline"><?php if(checkAccBankByUserID($row_user['user_stafid'])) echo getAccBankByUserID($row_user['user_stafid']); else echo "Tidak dinyatakan";?></td>
                    </tr>
                  </table>
                  <a name="ev2" id="ev2"></a>
                </li>
                <li class="gap">&nbsp;</li>
            </ul>
        </div>
        </div>
        <?php echo noteHR('1'); ?>
        </div>
        
		<?php include('inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php include('inc/footinc.php');?> 
<?php
mysql_free_result($user_job);
?>