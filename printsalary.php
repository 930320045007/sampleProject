<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php include ('qr/qrlib.php');?>
<?php $menu='2';?>
<?php $menu2='36';?>
<?php

if(isset($_GET['m']))
{
	$dy[0] = htmlspecialchars($_GET['m'], ENT_QUOTES);
} else {
	$dy[0] = date('m');
};

if(isset($_GET['y']))
{
	$dy[1] = htmlspecialchars($_GET['y'], ENT_QUOTES);
} else {
	$dy[1] = date('Y');
};

if($dy[0]==date('m') && $dy[1] == date('Y'))
{
	$dd = date('d');
} else {
	$dd = 1;
};

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_pemotongan = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE transactiontype_id = 2 AND user_salary.user_stafid = '" . $row_user['user_stafid'] . "' AND ((user_salary.usersalary_date_m <= '" . $dy[0] . "' AND user_salary.usersalary_date_y = '" . $dy[1] . "')OR(user_salary.usersalary_date_m <= '" . $dy[0] . "' AND user_salary.usersalary_date_y < '" . $dy[1] . "')OR(user_salary.usersalary_date_y < '" . $dy[1] . "')) AND (((user_salary.usersalary_end_m >= '" . $dy[0] . "' AND user_salary.usersalary_end_y = '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) AND user_salary.usersalary_status = 1 ORDER BY user_stafid ASC";
$pemotongan = mysql_query($query_pemotongan, $hrmsdb) or die(mysql_error());
$row_pemotongan = mysql_fetch_assoc($pemotongan);
$totalRows_pemotongan = mysql_num_rows($pemotongan);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_pendapatan = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE transactiontype_id = 1 AND user_salary.user_stafid = '" . $row_user['user_stafid'] . "' AND ((user_salary.usersalary_date_m <= '" . $dy[0] . "' AND user_salary.usersalary_date_y = '" . $dy[1] . "')OR(user_salary.usersalary_date_m <= '" . $dy[0] . "' AND user_salary.usersalary_date_y < '" . $dy[1] . "')OR(user_salary.usersalary_date_y < '" . $dy[1] . "')) AND (((user_salary.usersalary_end_m >= '" . $dy[0] . "' AND user_salary.usersalary_end_y = '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) AND user_salary.usersalary_status = 1 ORDER BY user_stafid ASC";
$pendapatan = mysql_query($query_pendapatan, $hrmsdb) or die(mysql_error());
$row_pendapatan = mysql_fetch_assoc($pendapatan);
$totalRows_pendapatan = mysql_num_rows($pendapatan);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_emo = "SELECT * FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . $dy[1] . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . $dy[0] . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . $dy[1] . "')) AND useremolumen_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC";
$emo = mysql_query($query_emo, $hrmsdb) or die(mysql_error());
$row_emo = mysql_fetch_assoc($emo);
$totalRows_emo = mysql_num_rows($emo);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jadual = "SELECT * FROM salary_sch WHERE salarysch_status = 1 AND (salarysch_m <= '" . date('m') . "' AND salarysch_y <= '" . date('Y') . "') AND ((salarysch_y = '" . getStartDayDate($row_user['user_stafid'], 3) . "' AND salarysch_m >= '" . getStartDayDate($row_user['user_stafid'], 2) . "') OR (salarysch_y > '" . getStartDayDate($row_user['user_stafid'], 3) . "')) ORDER BY salarysch_y DESC, salarysch_m DESC LIMIT 4";
$jadual = mysql_query($query_jadual, $hrmsdb) or die(mysql_error());
$row_jadual = mysql_fetch_assoc($jadual);
$totalRows_jadual = mysql_num_rows($jadual);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300' rel='stylesheet' type='text/css'>
<link href="css/print.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
</head>
<body <?php if(checkSalarySchDate($dy[0], $dy[1]) && checkSalarySchDatePast($dd, $dy[0], $dy[1]) && !checkSalaryBlockByUserID($row_user['user_stafid'],$dy[0], $dy[1])) echo "class=\"backlogo\"";?> onLoad="javascript:window.print()">

<?php if(checkSalarySchDate($dy[0], $dy[1]) && checkSalarySchDatePast($dd, $dy[0], $dy[1]) && !checkSalaryBlockByUserID($row_user['user_stafid'],$dy[0], $dy[1])){?>
<span>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
  <tr>
    <td align="left" valign="middle"><img src="img/isn.png" alt="ISN" /></td>
    <td width="70%" align="left" valign="middle" nowrap="nowrap"><strong class="fsize2">INSTITUT SUKAN NEGARA MALAYSIA</strong><br />
      Kompleks Sukan Negara, Bukit Jalil, <br />
      57000 Kuala Lumpur<br /></td>
    <td width="30%" align="left" valign="middle" nowrap="nowrap">
      Tel : 03 8991 4400/4800<br />
      Fax : 03 8996 8748<br />
      www.isn.gov.my
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top"><span class="label"><img src="<?php echo $url_main;?>qr/qrsample.php?m=<?php echo $dy[0];?>&y=<?php echo $dy[1];?>" /></span></td>
    <td width="100%" align="left" valign="middle">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
      <tr >
        <td width="50%" align="left" valign="top" class="label"><div class="fsize3">Nama</div><strong><?php echo strtoupper(getFullNameByStafID($row_user['user_stafid'])); ?></strong></td>
        <td width="50%" align="left" valign="top" class="label"><div class="fsize3">Kad Pengenalan</div><strong><?php echo getICNoByStafID($row_user['user_stafid']);?></strong></td>
        </tr>
      <tr >
        <td align="left" valign="top" class="label"><div class="fsize3">Jawatan</div><?php echo getJobtitleReal($row_user['user_stafid']);?> (<?php echo getGred($row_user['user_stafid']); ?>)</td>
        <td align="left" valign="top" class="label"><div class="fsize3">Bahagian</div><?php echo getFulldirectory(getDirIDByUser($row_user['user_stafid']));?></td>
        </tr>
      <tr >
        <td align="left" valign="top" class="label noline"><div class="fsize3">No. Fail</div><?php echo $row_user['user_stafid'];?></td>
        <td align="left" valign="top" class="label"><div class="fsize3">Bank</div><strong><?php echo getBankNameByUserID($row_user['user_stafid']);?><span class="noline"> &nbsp; <?php echo getAccBankByUserID($row_user['user_stafid']);?></span></strong></td>
        </tr>
      <tr>
        <td align="left" valign="top" class="label"><div class="fsize3">Bulan</div><strong><?php echo strtoupper(date('F Y', mktime(0, 0, 0, $dy[0], getDateBySchDate($dy[0], $dy[1]), $dy[1])));?></strong></td>
        <td align="left" valign="top" class="label noline"><div class="fsize3">Dikreditkan pada</div><strong><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $dy[0], getDateBySchDate($dy[0], $dy[1]), $dy[1]));?></strong></td>
        </tr>
    </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td width="50%" nowrap="nowrap" class="line_b line_r"><strong>Pendapatan</strong></td>
    <td width="50%" nowrap="nowrap" class="line_b"><strong>Potongan</strong></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap" class="line_b line_r">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="70%" nowrap="nowrap" class="line_rw in_upper">Gaji Pokok (<?php echo getSalarySkill($row_user['user_stafid'], 0, $dy[0], $dy[1]); ?>)</td>
        <td width="20%" align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getBasicSalaryByUserID($row_user['user_stafid'], 1, $dy[0], $dy[1]), 2);?></td>
      </tr>
      <?php if($row_emo['useremolumen_itka']!=0 && $row_emo['useremolumen_itka']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">Imbuhan Tetap Khidmat Awam (ITKA)</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><span class="noline"><?php echo number_format($row_emo['useremolumen_itka'],2); ?></span></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_itkrai']!=0 && $row_emo['useremolumen_itkrai']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">IT KRAI</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_itkrai'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_itp']!=0 && $row_emo['useremolumen_itp']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">Imbuhan Tetap Perumahan (ITP)</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_itp'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_bsh']!=0 && $row_emo['useremolumen_bsh']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">Bantuan Sara Hidup (BSH)</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_bsh'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_elktkl']!=0 && $row_emo['useremolumen_elktkl']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">EL KTKL</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_elktkl'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_elpksht']!=0 && $row_emo['useremolumen_elpksht']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">EL PKSHT</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_elpksht'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_elpakar']!=0 && $row_emo['useremolumen_elpakar']!=NULL){?>
      <tr>
        <td nowrap="nowrap" class="noline in_upper">EL PAKAR</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_elpakar'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_elmemangku']!=0 && $row_emo['useremolumen_elmemangku']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">Elaun Memangku</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_elmemangku'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_jusa']!=0 && $row_emo['useremolumen_jusa']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">JUSA</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_jusa'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_elpemkhas']!=0 && $row_emo['useremolumen_elpemkhas']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">EL PEMBANTU KHAS</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_elpemkhas'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_elpemrmh']!=0 && $row_emo['useremolumen_elpemrmh']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">EL PEMBANTU RUMAH</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_elpemrmh'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_elbhs']!=0 && $row_emo['useremolumen_elbhs']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">EL BAHASA</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_elbhs'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if($row_emo['useremolumen_o']!=0 && $row_emo['useremolumen_o']!=NULL){?>
      <tr >
        <td nowrap="nowrap" class="noline in_upper">Lain-lain</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_emo['useremolumen_o'],2); ?></td>
      </tr>
      <?php }; ?>
      <?php if ($totalRows_pendapatan > 0) { // Show if recordset not empty ?>
      <?php do { ?>
        <tr >
            <td nowrap="nowrap" class="noline in_upper"><?php echo getTransactionName($row_pendapatan['transaction_id']); ?></td>
            <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_pendapatan['usersalary_value'],2); ?></td>
        </tr>
       <?php } while ($row_pendapatan = mysql_fetch_assoc($pendapatan)); ?>
       <?php } // Show if recordset not empty ?>
    </table></td>
    <td align="left" valign="top" nowrap="nowrap" class="line_b"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <?php if(checkKWSPByStafID($row_user['user_stafid'], date('d'), $dy[0], $dy[1])) {?>
      <tr >
        <td width="70%" nowrap="nowrap" class="noline">KWSP (<?php echo getKWSPStafPercByStafID($row_user['user_stafid'], date('d'), $dy[0], $dy[1]);?>%)</td>
        <td width="20%" align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getKWSPStafRM($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></td>
      </tr>
     <?php }; ?>
      <tr >
        <td nowrap="nowrap" class="noline">PERKESO </td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getPERKESOStafRM($row_user['user_stafid'], date('d'), $dy[0], $dy[1]),2);?></td>
      </tr>
      <?php if(checkKelabMSNRM($row_user['user_stafid'])){?>
      <tr >
        <td nowrap="nowrap" class="noline">KELAB ISN</td>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getKelabMSNRM($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></td>
      </tr>
      <?php }; ?>
      <?php if ($totalRows_pemotongan > 0) { // Show if recordset not empty ?>
      <?php do { ?>
        <tr >
<td nowrap="nowrap" class="noline"><?php echo strtoupper(getTransactionName($row_pemotongan['transaction_id'])); ?></td>
            <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($row_pemotongan['usersalary_value'], 2); ?></td>
        </tr>
       <?php } while ($row_pemotongan = mysql_fetch_assoc($pemotongan)); ?>
       <?php } // Show if recordset not empty ?>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap" class="line_b line_r">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%" align="left" valign="middle" class="noline">Jumlah Pendapatan</td>
        <td width="20%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getTotalSalaryByUserID($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></strong></td>
      </tr>
      <tr>
        <td align="left" valign="middle" class="noline">Baki Bersih </td>
        <td align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getGajiBersihByUserID($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></strong></td>
      </tr>
    </table></td>
    <td align="left" valign="top" nowrap="nowrap" class="line_b">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%" align="left" valign="middle" class="noline">Jumlah Potongan</td>
        <td width="20%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getTotalCutByUserID($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" nowrap="nowrap" class="line_b"><strong>Caruman oleh Majikan</strong></td>
    </tr>
  <tr>
    <td colspan="2" nowrap="nowrap" class="noline">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="30%" nowrap="nowrap">KWSP (<?php echo getKWSPEmpPercByStafID($row_user['user_stafid'], date('d'), $dy[0], $dy[1]);?>%)</td>
        <td width="3%" align="right" valign="middle" nowrap="nowrap"><strong><?php echo number_format(getKWSPEmpRM($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></strong></td>
        <td width="30%" nowrap="nowrap" class="noline">PERKESO </td>
        <td width="3%" align="right" valign="middle" nowrap="nowrap"><strong><?php echo number_format(getPERKESOEmpRM($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></strong></td>
        <td width="30%" nowrap="nowrap" class="noline">PENCEN</td>
        <td width="3%" align="right" valign="middle" nowrap="nowrap"><strong><?php echo number_format(getPencenByStafID($row_user['user_stafid'], $dy[0], $dy[1]),2);?></strong></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
  <tr>
    <td align="center" valign="middle" class="fsize3">Penyata gaji ini dijana secara cetakkan berkomputer<br/><?php echo time();?></td>
  </tr>
</table>
</span>
<?php }; ?>
</body>
</html>
<?php
mysql_free_result($pemotongan);

mysql_free_result($pendapatan);

mysql_free_result($emo);

mysql_free_result($jadual);
?>
