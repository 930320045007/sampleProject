<?php require_once('Connections/hrmsdb.php'); ?>
<?php require_once('Connections/ictdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php include ('qr/qrlib.php');?>
<?php $menu='2';?>
<?php $menu2='36';?>
<?php

if(isset($_GET['m']))
{
	$m = htmlspecialchars($_GET['m'], ENT_QUOTES);
} else {
	$m = date('m');
};

if(isset($_GET['y']))
{
	$y = htmlspecialchars($_GET['y'], ENT_QUOTES);
} else {
	$y = date('Y');
};

if($m==date('m') && $y == date('Y'))
{
	$d = date('d');
} else {
	$d = 1;
};

$tgp = 0;
$tpd = 0;
$tpt = 0;
$tgd = 0;
$te = 0;

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_pendapatan = "SELECT user_salary.transaction_id, transaction.transaction_name FROM www.user_salary LEFT JOIN www.transaction ON transaction.transaction_id = user_salary.transaction_id WHERE user_salary.user_stafid = '" . $row_user['user_stafid'] . "' AND usersalary_status = 1 AND transaction.transactiontype_id = 1 AND ((user_salary.usersalary_end_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' OR user_salary.usersalary_end_y > '" . htmlspecialchars($y, ENT_QUOTES) . "') OR user_salary.usersalary_end_y = 0) GROUP BY user_salary.transaction_id";
$pendapatan = mysql_query($query_pendapatan, $hrmsdb) or die(mysql_error());
$row_pendapatan = mysql_fetch_assoc($pendapatan);
$totalRows_pendapatan = mysql_num_rows($pendapatan);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_pemotongan = "SELECT user_salary.transaction_id, transaction.transaction_name FROM www.user_salary LEFT JOIN www.transaction ON transaction.transaction_id = user_salary.transaction_id WHERE user_salary.user_stafid = '" . $row_user['user_stafid'] . "' AND usersalary_status = 1 AND transaction.transactiontype_id = 2 AND ((user_salary.usersalary_end_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' OR user_salary.usersalary_end_y > '" . htmlspecialchars($y, ENT_QUOTES) . "') OR user_salary.usersalary_end_y = 0) GROUP BY user_salary.transaction_id";
$pemotongan = mysql_query($query_pemotongan, $hrmsdb) or die(mysql_error());
$row_pemotongan = mysql_fetch_assoc($pemotongan);
$totalRows_pemotongan = mysql_num_rows($pemotongan);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_emo = "SELECT * FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . $y . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . $m . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . $y . "')) AND useremolumen_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC";
$emo = mysql_query($query_emo, $hrmsdb) or die(mysql_error());
$row_emo = mysql_fetch_assoc($emo);
$totalRows_emo = mysql_num_rows($emo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300' rel='stylesheet' type='text/css'>
<link href="css/print.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
</head>
<body <?php include('inc/bodyinc.php');?> onLoad="javascript:window.print()">
<div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
  <tr>
    <td width="10%" align="center" valign="middle"><img src="img/isn.png" alt="ISN" /></td>
    <td width="80%" align="left" valign="middle" nowrap="nowrap"><strong class="fsize2">INSTITUT SUKAN NEGARA MALAYSIA</strong><br />
      Kompleks Sukan Negara, Bukit Jalil, <br />
      57000 Kuala Lumpur<br /><br/>
      <strong>PENYATA PENDAPATAN / POTONGAN BAGI TAHUN <?php echo $y;?></strong></td>
    <td align="left" valign="middle" nowrap="nowrap">
      Tel : 03 8991 4400/4800 <br />
      Fax : 03 8996 8748<br />
      www.isn.gov.my
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%" align="center" valign="top"><span class="label"><img src="<?php echo $url_main;?>qr/qrsalaryyear.php?y=<?php echo $y;?>" alt="" /></span></td>
    <td width="90%" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
      <tr>
        <td align="left" valign="top" class="label noline"><div class="fsize3">No. Fail</div>
          <strong><?php echo $row_user['user_stafid'];?></strong></td>
        <td align="left" valign="top" class="label noline"><div class="fsize3">Taraf Perkahwinan</div>
          <?php echo getMarital(getMaritalByUserID($row_user['user_stafid']));?></td>
      </tr>
      <tr >
        <td width="50%" align="left" valign="top" class="label"><div class="fsize3">Nama</div>
          <strong><?php echo strtoupper(getFullNameByStafID($row_user['user_stafid'])); ?></strong></td>
        <td align="left" valign="top" class="label noline"><div class="fsize3">Gred Gaji</div>
          <?php echo getGred($row_user['user_stafid']); ?></td>
      </tr>
      <tr >
        <td align="left" valign="top" class="label"><div class="fsize3">Jawatan</div>
          <?php echo getJobtitleReal($row_user['user_stafid']);?></td>
        <td align="left" valign="top" class="label noline"><div class="fsize3">Pergerakan</div>
          <?php echo getTPGByStafID($row_user['user_stafid']); ?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="label"><div class="fsize3">Bahagian</div>
          <?php echo getFulldirectory(getDirIDByUser($row_user['user_stafid']));?></td>
        <td align="left" valign="top" class="label"><div class="fsize3">Bank</div>
          <?php echo getBankNameByUserID($row_user['user_stafid']);?> &nbsp; <?php echo getAccBankByUserID($row_user['user_stafid']);?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="label"><div class="fsize3">Alamat Kuarters</div>
        <?php echo strtoupper(getAddressByStafID($row_user['user_stafid']));?></td>
        <td align="left" valign="top" class="label noline"><div class="fsize3">No. KWSP</div>
          <?php echo getKWSPByUserID($row_user['user_stafid']); ?></td>
      </tr>
        <td width="50%" align="left" valign="top" class="label"><div class="fsize3">Kad Pengenalan</div>
          <strong><?php echo getICNoByStafID($row_user['user_stafid']);?></strong></td>
        <td align="left" valign="top" class="label noline"><div class="fsize3">No. PERKESO</div>
          <?php echo getPERKESOByUserID($row_user['user_stafid']); ?></td>
        <tr>
          <td align="left" valign="top" class="label"><div class="fsize3">Tarikh Lahir / Jantina</div>
          <?php echo getDobByUserID($row_user['user_stafid']);?> <?php echo strtoupper(getGender(getGenderIDByUserID($row_user['user_stafid'])));?></td>
        <td align="left" valign="top" class="label noline">&nbsp;</td>
        <tr>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
  <tr>
    <td width="30%" align="left" valign="middle"><strong>PENDAPATAN</strong></td>
    <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <th align="right" valign="middle"><strong><?php echo strtoupper(date('M', mktime(0, 0, 0, $i, 1, $y)));?></strong></th>
    <?php }; ?>
    <th align="right" valign="middle">JUMLAH</th>
  </tr>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">Gaji Pokok (<?php echo getSalarySkill($row_user['user_stafid'], 0, $m, $y); ?>)</td>
    <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php $tgp += getBasicSalaryByUserID($row_user['user_stafid'], 1, $i, $y); echo number_format(getBasicSalaryByUserID($row_user['user_stafid'], 1, $i, $y), 2);?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($tgp, 2);?></td>
  </tr>
  <?php if($row_emo['useremolumen_itka']!=0 && $row_emo['useremolumen_itka']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">Imbuhan Tetap Khidmat Awam (ITKA)</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><span class="noline"><?php echo number_format(getEmolumenITKAByUserID($row_user['user_stafid'], 0, $i, $y),2); ?></span></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenITKAByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_itkrai']!=0 && $row_emo['useremolumen_itkrai']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">IT KRAI</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenITKraiByUserID($row_user['user_stafid'], 0, $i, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenITKraiByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_itp']!=0 && $row_emo['useremolumen_itp']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">Imbuhan Tetap Perumahan (ITP)</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenITPByUserID($row_user['user_stafid'], 0, $i, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenITPByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_bsh']!=0 && $row_emo['useremolumen_bsh']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">Bantuan Sara Hidup (BSH)</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenBSHByUserID($row_user['user_stafid'], 0, $i, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenBSHByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_elktkl']!=0 && $row_emo['useremolumen_elktkl']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">EL KTKL</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenElKtklByUserID($row_user['user_stafid'], 0, $i, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenElKtklByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_elpksht']!=0 && $row_emo['useremolumen_elpksht']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">EL PKSHT</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPkshtByUserID($row_user['user_stafid'], 0, $i, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenElPkshtByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_elpakar']!=0 && $row_emo['useremolumen_elpakar']!=NULL){?>
  <tr>
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">EL PAKAR</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPakarByUserID($row_user['user_stafid'], 0, $i, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenElPakarByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_elmemangku']!=0 && $row_emo['useremolumen_elmemangku']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">Elaun Memangku</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenElMemangkuByUserID($row_user['user_stafid'], 0, $i, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenElMemangkuByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_jusa']!=0 && $row_emo['useremolumen_jusa']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">JUSA</td>
    
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenJUSAByUserID($row_user['user_stafid'], 0, $i, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenJUSAByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_elpemkhas']!=0 && $row_emo['useremolumen_elpemkhas']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">EL PEMBANTU KHAS</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPemKhasByUserID($row_user['user_stafid'], 0, $m, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenElPemKhasByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_elpemrmh']!=0 && $row_emo['useremolumen_elpemrmh']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">EL PEMBANTU RUMAH</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPemRmhByUserID($row_user['user_stafid'], 0, $m, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenElPemRmhByUserID($id, $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_elbhs']!=0 && $row_emo['useremolumen_elbhs']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">EL BAHASA</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenElBhsByUserID($row_user['user_stafid'], 0, $m, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenElBhsByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if($row_emo['useremolumen_o']!=0 && $row_emo['useremolumen_o']!=NULL){?>
  <tr >
    <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper">Lain-lain</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getEmolumenOByUserID($row_user['user_stafid'], 0, $m, $y),2); ?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalEmolumenOByUserID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <?php }; ?>
  <?php if ($totalRows_pendapatan > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <tr >
        <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper"><?php echo getTransactionName($row_pendapatan['transaction_id']); ?></td>
         <?php 
		 for($i=1; $i<=12; $i++)
		 { 
		 	if($i<10) $i = '0' . $i;
		 ?>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTransactionByUserID($row_user['user_stafid'], $row_pendapatan['transaction_id'], 1, $i, $y),2); ?></td>
        <?php }; ?>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalTransactionYearByUserID($row_user['user_stafid'], $row_pendapatan['transaction_id'], $y),2);?></td>
    </tr>
   <?php } while ($row_pendapatan = mysql_fetch_assoc($pendapatan)); ?>
   <?php } // Show if recordset not empty ?>
    <tr >
      <td align="left" valign="middle" nowrap="nowrap" class="noline in_upper"><strong>GAJI KASAR</strong></td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
      <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php $tpd += getTotalSalaryByUserID($row_user['user_stafid'], 1, $i, $y); echo number_format(getTotalSalaryByUserID($row_user['user_stafid'], 1, $i, $y), 2);?></td>
      <?php }; ?>
      <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($tpd,2);?></td>
    </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
  <tr>
    <td width="30%"><strong>POTONGAN</strong></td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <th align="right" valign="middle" nowrap="nowrap"><strong><?php echo strtoupper(date('M', mktime(0, 0, 0, $i, 1, $y)));?></strong></th>
    <?php }; ?>
    <th align="right" valign="middle" nowrap="nowrap">JUMLAH</th>
  </tr>
    <?php if(checkKWSPByStafID($row_user['user_stafid'], $d, $m, $y)) {?>
      <tr >
        <td nowrap="nowrap" class="noline">KWSP (<?php echo getKWSPStafPercByStafID($row_user['user_stafid'], $d, $m, $y);?>%)</td>
         <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getKWSPStafRM($row_user['user_stafid'], $d, $i, $y), 2);?></td>
        <?php } ;?>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalKWSPStafRM($row_user['user_stafid'], $y),2);?></td>
      </tr>
     <?php }; ?>
      <tr >
        <td nowrap="nowrap" class="noline">PERKESO </td>
         <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getPERKESOStafRM($row_user['user_stafid'], $d, $i, $y),2);?></td>
        <?php }; ?>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalPERKESOStafRM($row_user['user_stafid'], $y),2);?></td>
      </tr>
      <?php if(checkKelabMSNRM($row_user['user_stafid'])){?>
      <tr >
        <td nowrap="nowrap" class="noline">KELAB ISN</td>
         <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getKelabMSNRM($row_user['user_stafid'], $d, $i, $y), 2);?></td>
        <?php }; ?>
        <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalKelabMSNRM($row_user['user_stafid'], $y),2);?></td>
      </tr>
      <?php }; ?>
      <?php if ($totalRows_pemotongan > 0) { // Show if recordset not empty ?>
      <?php do { ?>
        <tr >
            <td nowrap="nowrap" class="noline"><?php echo strtoupper(getTransactionName($row_pemotongan['transaction_id'])); ?></td>
             <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
            <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTransactionByUserID($row_user['user_stafid'], $row_pemotongan['transaction_id'], $d, $i, $y), 2); ?></td>
            <?php }; ?>
            <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format(getTotalTransactionYearByUserID($row_user['user_stafid'], $row_pemotongan['transaction_id'], $y),2);?></td>
        </tr>
       <?php } while ($row_pemotongan = mysql_fetch_assoc($pemotongan)); ?>
       <?php } // Show if recordset not empty ?>
        <tr >
          <td nowrap="nowrap" class="noline">JUMLAH POTONGAN</td>
           <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
          <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php $tpt += getTotalCutByUserID($row_user['user_stafid'], 1, $i, $y); echo number_format(getTotalCutByUserID($row_user['user_stafid'], 1, $i, $y), 2);?></td>
          <?php }; ?>
          <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($tpt,2);?></td>
        </tr>
        <tr >
          <td nowrap="nowrap" class="noline">GAJI BERSIH</td>
           <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
          <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php $tgd += getGajiBersihByUserID($row_user['user_stafid'], 1, $i, $y); echo number_format(getGajiBersihByUserID($row_user['user_stafid'], 1, $i, $y), 2);?></td>
          <?php }; ?>
          <td align="right" valign="middle" nowrap="nowrap" class="noline back_lightgrey"><?php echo number_format($tgd,2);?></td>
        </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
  <tr>
    <td width="30%" nowrap="nowrap"><strong>CARUMAN MAJIKAN</strong></td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap"><strong><?php echo strtoupper(date('M', mktime(0, 0, 0, $i, 1, $y)));?></strong></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap"><strong>JUMLAH</strong></td>
  </tr>
  <tr>
    <td nowrap="nowrap">KWSP</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getKWSPEmpRM($row_user['user_stafid'], 1, $i, $y), 2);?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getTotalKWSPEmpRM($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <tr>
    <td nowrap="nowrap">PERKESO</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getPERKESOEmpRM($row_user['user_stafid'], 1, $i, $y), 2);?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getTotalPERKESOEmpRM($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <tr>
    <td nowrap="nowrap">PENCEN</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getPencenByStafID($row_user['user_stafid'], $i, $y),2);?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getTotalPencenByStafID($row_user['user_stafid'], $y),2);?></td>
  </tr>
  <tr>
    <td nowrap="nowrap">JUMLAH</td>
     <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
    <td align="right" valign="middle" nowrap="nowrap"><?php $te += getTotalEmpRM($row_user['user_stafid'], 1, $i, $y); echo number_format(getTotalEmpRM($row_user['user_stafid'], 1, $i, $y),2);?></td>
    <?php }; ?>
    <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format($te, 2);?></td>
  </tr>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($pendapatan);

mysql_free_result($emo);
?>
<?php include('inc/footinc.php');?>
