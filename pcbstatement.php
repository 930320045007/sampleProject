<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
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

$userpcb = "-1";

if(isset($_POST['id']))
	$userpcb = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES));
else if(isset($_GET['id']))
	$userpcb = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
else
	$userpcb = $row_user['user_stafid'];

$tpd = 0;

$total = 0;

$trans = 0;

$pcb = 0;

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_job = "SELECT user_job.*, jobs_sub.jobss_name, jobs_sub.jobss_shortname FROM user_job LEFT JOIN user_job2 ON user_job.user_stafid = user_job2.user_stafid LEFT JOIN jobs_sub ON jobs_sub.jobss_id = user_job2.jobss_id WHERE user_job.user_stafid = '".$userpcb ."' ORDER BY user_job.userjob_id DESC";
$user_job = mysql_query($query_user_job, $hrmsdb) or die(mysql_error());
$row_user_job = mysql_fetch_assoc($user_job);
$totalRows_user_job = mysql_num_rows($user_job);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_backlog = "SELECT * FROM backlog WHERE backlog.user_stafid = '".$userpcb."' AND backlog_date_y = '" . date('Y') ."'  AND backlog_status =1 ORDER BY backlog_id DESC";
$backlog = mysql_query($query_backlog, $hrmsdb) or die(mysql_error());
$row_backlog = mysql_fetch_assoc($backlog);
$totalRows_backlog = mysql_num_rows($backlog);
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
                 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
<tr>
    <td align="left" valign="middle" nowrap="nowrap">(C.P. 8C - Pin. 2010)</td>
    <td>&nbsp;</td>
    <td align="center" valign="middle" nowrap="nowrap">Penyata Gaji Pekerja AGENSI KERAJAAN <strong> EC</strong></td></tr>
    <tr>
    <td>&nbsp;</td>
    <td width="100%" align="center" valign="middle" nowrap="nowrap" class="fsize2">MALAYSIA<br /><strong>CUKAI PENDAPATAN</strong></td>
    <td align="center" valign="middle" nowrap="nowrap">No. Cukai Pendapatan Pekerja : <strong><?php echo getLHDNByUserID($userpcb);?></strong></td>
</tr>
<tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td width="100%" align="center" valign="middle" nowrap="nowrap" class="fsize2">PENYATA SARAAN DARIPADA PENGAJIAN<br />BAGI TAHUN BERAKHIR 31 DISEMBER<strong> <?php echo $y;?></strong></td>
    <td align="center" valign="middle" nowrap="nowrap">&nbsp;</td>
</tr>
<tr>
    <td nowrap="nowrap">No. Majikan : <strong>911380300-2</strong></td>
    <td width="100%">&nbsp;</td>
    <td align="center" valign="middle" nowrap="nowrap">Cawangan LHDNM.........................</td>
</tr>
<tr>
    <td colspan="3" align="center">BORANG EC INI PERLU DISEDIAKAN UNTUK DISERAHKAN KEPADA PEKERJA <br />BAGI TUJUAN CUKAI PENDAPATANNYA</td>
</tr>
</table>
                  
               <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>A. BUTIRAN PEKERJA</strong></td>
    </tr>
    </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
                    <tr>
                      <td nowrap="nowrap" class="noline back_lightgrey">1. Nama Penuh Pekerja/ Pesara (En./Cik/Puan) :</td>
                      <td width="50%" class="noline in_upper"><strong><?php echo getFullNameByStafID($userpcb);?></strong></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="noline back_lightgrey">2. Jabatan :</td>
                      <td class="noline in_upper"><strong><?php echo getJobtype($userpcb); ?>[ISN]</strong></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                     <tr>
                      <td nowrap="nowrap" class="noline back_lightgrey">3. Jawatan :</td>
                      <td class="noline in_upper"><strong><?php echo getJobtitleReal($userpcb);?> (<?php echo getGred($userpcb); ?>)</strong></td>
                      <td nowrap="nowrap" class="noline back_lightgrey">4. No. Kakitangan/No. Gaji :</td>
                      <td width="50%" class="noline in_upper"><strong><?php echo $userpcb;?></strong></td>
                    </tr>
                     <tr>
                      <td nowrap="nowrap" class="noline back_lightgrey">5. No. Kad Pengenalan/Polis/Tentera/Pasport :</td>
                      <td class="noline in_upper"><strong><?php echo getICNoByStafID($userpcb); ?></strong></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="noline back_lightgrey">6. No. KWSP :</td>
                      <td class="noline in_upper"><strong><?php echo getKWSPByUserID($userpcb); ?></strong></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="noline back_lightgrey">7. Jika bekerja tidak genap setahun, nyatakan :</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="noline back_lightgrey">(a) Tarikh mula bekerja :</td>
                      <td class="noline in_upper"
                      <?php $service = getService($userpcb); ?><?php if($service['0']==0 && $service['1']>=1) {?>
                      ><?php echo date('d / m/ Y',mktime(0,0,0,$row_user_job['userjob_in_m'],$row_user_job['userjob_in_d'],$row_user_job['userjob_in_y']));?><?php };?></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="noline back_lightgrey">(b) Tarikh berhenti bekerja :</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>B. PENDAPATAN PENGGAJIAN, MANFAAT DAN TEMPAT KEDIAMAN</strong></td>
    </tr>
    </table>
        	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
             <tr>
                <td class="noline back_lightgrey">1. Gaji/Emolumen (tidak termasuk B2 di bawah)</td>
                <td><strong><?php echo number_format(getTotalSaraanByUserID($userpcb, $y), 2);?></strong></td>
              </tr>
              <tr>
                <td class="noline back_lightgrey">(a) Gaji, termasuk Gaji Cuti, Bonus, dan lain-lain</td>    
                <td>&nbsp;</td>
              </tr>
               <tr>
                  <td class="noline back_lightgrey">(b) Ganjaran bagi tempoh dari .......... hingga ..........</td>    
                <td>&nbsp;</td>
              </tr>
              <tr>
                 <td class="noline back_lightgrey">2. Manfaat Berupa Barangan (Nyatakan butiran ..........)</td>    
                <td>&nbsp;</td>
              </tr>
               <tr>
                 <td class="noline back_lightgrey">3. Manfaat Tambang Percutian (jika berkenaan)</td>    
                <td><strong>0.00</strong></td>
              </tr>
               <tr>
                  <td class="noline in_upper"><strong>PENDAPATAN BOLEH DICUKAI (B1 + B2 + B3)</strong></td>
                  <td><strong><?php echo number_format(getTotalSaraanByUserID($userpcb, $y), 2);?></strong></td>
              </tr>
              </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>C. JUMLAH POTONGAN</strong></td>
    </tr>
    </table>
        	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
             <tr>
                <td width="80%" class="noline back_lightgrey">1. Potongan Cukai Bulanan (PCB) tahun semasa yang dibayar kepada LHDNM</td>
                <td width="20%">
				<?php if(getTransactionIDByUserID($userpcb)=='32') {?>
                 <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
                 <?php $pcb += getTransactionByUserID($userpcb, getTransactionIDByUserID($pcb), $d, $i, $y); ?> <?php }; ?><strong><?php echo number_format($trans,2);?></strong>
                 <?php } else {?>
                 <strong>0.00</strong>
                 <?php };?>
                 </td>
              </tr>
              <tr>
                <td class="noline back_lightgrey">2. Arahan Potongan CP 38</td>
                <td><strong>0.00</strong></td>
              </tr>
               <tr>
                <td class="noloine back_lightgrey">3. Potongan Zakat yang diremit kepada Pusat Pungutan Zakat</td>
               <td>
				<?php if(getTransactionIDByUserID($userpcb)=='27' || getTransactionIDByUserID($userpcb)=='49') {?>
                 <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
                 <?php $trans += getTransactionByUserID($userpcb, getTransactionIDByUserID($userpcb), $d, $i, $y); ?> <?php }; ?><strong><?php echo number_format($trans,2);?></strong>
                 <?php } else {?>
                 <strong>0.00</strong></td>
                 <?php };?>
              </tr>
              </table>
       <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>D. CARUMAN KEPADA KUMPULAN WANG SIMPANAN PEKERJA</strong></td>
    </tr>
    </table>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
             <tr>
                <td width="80%" class="noline back_lightgrey">1. Caruman KWSP (nyatakan bahagian pekerja sahaja)</td>
                <td width="20%"><strong><?php echo number_format(getTotalKWSPStafRM($userpcb, $y),2);?></strong></td>
                </tr>
                </table>
               <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>E. BUTIRAN PEMBAYARAN TUNGGAKAN DAN LAIN-LAIN BAGI TAHUN-TAHUN TERDAHULU</strong></td>
    </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
    <?php if ($totalRows_backlog > 0) { // Show if recordset not empty ?>
<tr>
 		<th align="center" valign="middle" nowrap="nowrap">Bil</th>
        <th align="center" valign="middle">Bayaran Bagi Tahun</td>
        <th align="center" valign="middle">Jenis Pendapatan</td>
        <th align="center" valign="middle">Jumlah Bayaran (RM)</td>
        <th align="center" valign="middle">Caruman KWSP (RM)</td>
        <th align="center" valign="middle">Potongan Cukai Berjadual (PCB) (RM)</td>                      
              </tr>
   <?php $i=1; do { ?>
      <tr class="on">
       <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
        <td align="center"><?php echo $row_backlog['backlog_y']; ?></td>
        <td align="center" valign="middle"><?php echo $row_backlog['backlog_type'];?></td>
       <td align="center" valign="middle"><?php echo $row_backlog['backlog_total'];?></td>
        <td align="center" valign="middle"><?php echo $row_backlog['backlog_kwsp'];?></td>
         <td align="center" valign="middle"><?php echo $row_backlog['backlog_pcb'];?></td>
      </tr>
      <?php } while ($row_backlog = mysql_fetch_assoc($backlog)); ?>
   
  <?php } else { ?>
    <tr>
      <td colspan="6" align="center" class="noline">Tiada rekod dijumpai</td>
    </tr>
    <?php }; ?>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>SENARAI ELAUN/PERKUISIT/PEMBERIAN/MANFAAT YANG DIKECUALIKAN CUKAI SERTA AMAUN MASING-MASING</strong></td>
    </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
             <tr>
                <td width="50%" class="noline back_lightgrey">Jenis Elaun/Perkuisit/Pemberian/Manfaat</td>
                <td>Jumlah Dikecualikan (RM)</td>
                </tr>
                 <tr>
                <th width="50%" align="left">IMBUHAN TETAP KHIDMAT AWAM (ITKA)</th>
                <th align="left"><strong><?php echo number_format(getTotalEmolumenITKAByUserID($userpcb, $y),2);?></strong></th>
                </tr>
                 <tr>
                <th width="50%" align="left" class="noline in_upper">BANTUAN SARA HIDUP (BSH)</th>
                <th align="left"><strong><?php echo number_format(getTotalEmolumenBSHByUserID($userpcb, $y),2);?></strong></th>
                </tr>
                 <tr>
                <th width="50%" align="left" class="noline in_upper">ELAUN PERUMAHAN (ITP)</th>
                <th align="left"><strong><?php echo number_format(getTotalEmolumenITPByUserID($userpcb, $y),2);?></strong></th>
                </tr>
                </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding=
           <tr> 
            <td width="50%" align="left" valign="middle" nowrap="nowrap">TARIKH : <?php echo date('d / m / Y (D)', mktime(0 , 0, 0, date('m'), date('d'), date('Y')));?></td>
      <td align="left">
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="box2">
          <tr>
            <td nowrap="nowrap">Nama Pegawai</td>
            <td class="noline in_upper" nowrap="nowrap"><strong>PN. NOR AZIAN  BINTI KHALID@ABD MALEK</strong></td>
          </tr>
          <tr>
            <td nowrap="nowrap">Jawatan</td>
            <td class="noline in_upper" nowrap="nowrap"><strong>kETUA JABATAN <br />
            <?php echo getDirSubName(128);?></strong></td>
           </tr>
           <tr>
            <td nowrap="nowrap">Nama dan Alamat Majikan</td>
            <td class="noline in_upper" nowrap="nowrap"><strong>INSTITUT SUKAN NEGARA MALAYSIA<br />KOMPLEKS SUKAN NEGARA<br />
            bUKIT JALIL, 57000 K.LUMPUR</strong></td>
           </tr>
            </table>
            </td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
  <tr>
    <td align="center" valign="middle" class="fsize3">-Penyata ini adalah cetakan komputer, tandatangan tidak diperlukan-<br/>
      <?php echo time();?></td>
  </tr>
</table>
</span>
</body>
</html>
<?php

mysql_free_result($user_job);

mysql_free_result($backlog);
?>
<?php include('inc/footinc.php');?> 