<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='93';?>
<?php
$wsql = "";

if(isset($_GET['m']))
{
	$m = htmlspecialchars($_GET['m'], ENT_QUOTES);
} else {
	$m = date('m');
};

if(isset($_POST['backlog_date_y']))
{
	$wsql .= " AND backlog_date_y = '" . $_POST['backlog_date_y'] . "'";
	$y = $_POST['backlog_date_y'];
} else {
	$wsql .= " AND backlog_date_y = '" . date('Y') . "'";
	$y = date('Y');
}

if($m==date('m') && $y == date('Y'))
{
	$d = date('d');
} else {
	$d = 1;
};

if(isset($_POST['id']))
	$userpcb = strtoupper($_POST['id']);
else if(isset($_GET['id']))
	$userpcb = getID($_GET['id'],0);
else
	$userpcb = $row_user['user_stafid'];
	
$tpd = 0;

$total = 0;

$trans = 0;

$pcb = 0;

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_job = "SELECT user_job.*, jobs_sub.jobss_name, jobs_sub.jobss_shortname FROM user_job LEFT JOIN user_job2 ON user_job.user_stafid = user_job2.user_stafid LEFT JOIN jobs_sub ON jobs_sub.jobss_id = user_job2.jobss_id WHERE user_job.user_stafid = '". $userpcb ."' ORDER BY user_job.userjob_id DESC";
$user_job = mysql_query($query_user_job, $hrmsdb) or die(mysql_error());
$row_user_job = mysql_fetch_assoc($user_job);
$totalRows_user_job = mysql_num_rows($user_job);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_backlog = "SELECT * FROM backlog WHERE backlog.user_stafid = '".$userpcb ."' ".$wsql."  AND backlog_status =1 ORDER BY backlog.backlog_id DESC";
$backlog = mysql_query($query_backlog, $hrmsdb) or die(mysql_error());
$row_backlog = mysql_fetch_assoc($backlog);
$totalRows_backlog = mysql_num_rows($backlog);
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
          <?php include('../inc/menu_ict.php');?>
        <div class="tabbox"> 
        <div class="profilemenu">
          	<ul>
             <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
              <li class="form_back">
              <form id="formcheckstaf" name="formcheckstaf" method="post" action="pcb.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td nowrap="nowrap" class="label">Staf ID</td>
                    <td width="100%">
                    <input name="id" type="text" class="w30" id="id" value="<?php echo $userpcb;?>" list="datastaf" />
                    <?php echo datalistStaf('datastaf');?>
                    <select name="backlog_date_y" id="backlog_date_y">
                    <?php for($i=2012; $i<=date('Y'); $i++){?>
                      <option <?php if($i==$y) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php }; ?>
                    </select>
                    <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                    <td align="left" valign="middle"><input name="button5" type="button" class="submitbutton" id="button5" value="Cetak" onclick="MM_openBrWindow('<?php echo $url_main;?>pcbstatement.php?id=<?php echo getID(htmlspecialchars($userpcb,ENT_QUOTES));?>&y=<?php echo $y;?>','pcb','status=yes,scrollbars=yes,width=800,height=600')" /></td> 
                  </tr>
                </table>
              </form>
            </li>
                <li class="noline">
                 <table width="100%" border="0" cellpadding="0" cellspacing="0">
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
    <td align="center" valign="middle" nowrap="nowrap">Cawangan LHDNM....................</td>
</tr>
<tr>
    <td colspan="3" align="center">BORANG EC INI PERLU DISEDIAKAN UNTUK DISERAHKAN KEPADA PEKERJA <br />BAGI TUJUAN CUKAI PENDAPATANNYA</td>
</tr>


</table>
                  
                </li>
                <div class="profilemenu">  
            <ul>
                <li class="title">A. BUTIRAN PEKERJA</li>
            </ul>
          </div> 
              <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap">1. Nama Penuh Pekerja/ Pesara (En./Cik/Puan) :</td>
                      <td width="50%"><strong><?php echo getFullNameByStafID($userpcb);?></strong></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap">2. Jabatan :</td>
                      <td><strong><?php echo getJobtype($userpcb); ?>[ISN]</strong></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                     <tr>
                      <td nowrap="nowrap">3. Jawatan :</td>
                      <td><strong><?php echo getJobtitleReal($userpcb);?> (<?php echo getGred($userpcb); ?>)</strong></td>
                      <td nowrap="nowrap">4. No. Kakitangan/No. Gaji :</td>
                      <td width="50%"><strong><?php echo $userpcb;?></strong></td>
                    </tr>
                     <tr>
                      <td nowrap="nowrap">5. No. Kad Pengenalan/Polis/Tentera/Pasport :</td>
                      <td><strong><?php echo getICNoByStafID($userpcb); ?></strong></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap">6. No. KWSP :</td>
                      <td><strong><?php echo getKWSPByUserID($userpcb); ?></strong></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap">7. Jika bekerja tidak genap setahun, nyatakan :</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap">(a) Tarikh mula bekerja :</td>
                      <td>
                      <?php $service = getService($userpcb); ?><?php if($service['0']==0 && $service['1']>=1) {?>
                      <?php echo date('d / m/ Y',mktime(0,0,0,$row_user_job['userjob_in_m'],$row_user_job['userjob_in_d'],$row_user_job['userjob_in_y']));?><?php };?></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap">(b) Tarikh berhenti bekerja :</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
              </li>
              <li class="gap">&nbsp;</li>

        <div class="tabbox profilemenu">
          <ul>
                <li class="title">B. PENDAPATAN PENGGAJIAN, MANFAAT DAN TEMPAT KEDIAMAN</li>
            </ul>
            </div>
             <li class="gap">&nbsp;</li>
            <li>
        	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
                <td nowrap="nowrap">1. Gaji/Emolumen (tidak termasuk B2 di bawah)</td>
               <td><?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
                <?php $tpd += getTotalSalaryByUserID($userpcb, 1, $i, $y);?> <?php }; ?><strong><?php echo number_format($tpd,2);?></strong></td>
              </tr>
              <tr>
                <td nowrap="nowrap">(a) Gaji, termasuk Gaji Cuti, Bonus, dan lain-lain</td>    
                <td>&nbsp;</td>
              </tr>
               <tr>
                <td nowrap="nowrap">(b) Ganjaran bagi tempoh dari .......... hingga ..........</td>    
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td nowrap="nowrap">2. Manfaat Berupa Barangan (Nyatakan butiran ..........)</td>    
                <td>&nbsp;</td>
              </tr>
               <tr>
                <td>3. Manfaat Tambang Percutian (jika berkenaan)</td>    
                <td><strong>0.00</strong></td>
              </tr>
               <tr>
                <td nowrap="nowrap"><strong>PENDAPATAN BOLEH DICUKAI (B1 + B2 + B3)</strong></td>
                <td>    
                 <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
                <?php $total += getTotalSalaryByUserID($userpcb, 1, $i, $y);?> <?php }; ?><strong><?php echo number_format($total,2);?></strong></td>
              </tr>
              </table>
              </li>
               <li class="gap">&nbsp;</li>

        <div class="tabbox profilemenu">
          <ul>
                <li class="title">C. JUMLAH POTONGAN</li>
            </ul>
            </div>
             <li class="gap">&nbsp;</li>
             <li>
        	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
                <td width="80%" nowrap="nowrap">1. Potongan Cukai Bulanan (PCB) tahun semasa yang dibayar kepada LHDNM</td>
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
                <td nowrap="nowrap">2. Arahan Potongan CP 38</td>
                <td><strong>0.00</strong></td>
              </tr>
               <tr>
                <td nowrap="nowrap">3. Potongan Zakat yang diremit kepada Pusat Pungutan Zakat</td>
                <td>
				<?php if(getTransactionIDByUserID($userpcb)=='27' || getTransactionIDByUserID($userpcb)=='49') {?>
                 <?php for($i=1; $i<=12; $i++){ if($i<10) $i = '0' . $i;?>
                 <?php $trans += getTransactionByUserID($userpcb, getTransactionIDByUserID($userpcb), $d, $i, $y); ?> <?php }; ?><strong><?php echo number_format($trans,2);?></strong>
                 <?php } else {?>
                 <strong>0.00</strong>
                 <?php };?>
                 </td>
              </tr>
              </table>
              </li>
              <li class="gap">&nbsp;</li>

        <div class="tabbox profilemenu">
          <ul>
                <li class="title">D. CARUMAN KEPADA KUMPULAN WANG SIMPANAN PEKERJA (nyatakan bahagian pekerja sahaja)</li>
                </ul>
                </div>
             <li class="gap">&nbsp;</li>
                <li>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
                <td width="80%">1. Caruman KWSP</td>
                <td width="20%"><strong><?php echo number_format(getTotalKWSPStafRM($userpcb, $y),2);?></strong></td>
                </tr>
                </table>
                </li>
                 <li class="gap">&nbsp;</li>

        <div class="tabbox profilemenu">
          <ul>
                <li class="title">E. BUTIRAN PEMBAYARAN TUNGGAKAN DAN LAIN-LAIN BAGI TAHUN-TAHUN TERDAHULU (SEBELUM TAHUN SEMASA) <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $row_user['user_stafid']!=$userpcb){?><span class="fr add" onClick="toggleview2('formtunggakan'); return false;">Tambah</span><?php }; ?></li>
				<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $row_user['user_stafid']!=$userpcb){?>
              <div id="formtunggakan" class="hidden">
                <li>
                  <form id="form2" name="form2" method="post" action="../sb/add_backlog.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label noline">Tahun</td>
                        <td width="50%" class="noline">   
                          <select name="backlog_y" id="backlog_y">
                          <?php $year = (date('Y')+2); for($k=(date('Y')-2); $k<$year; $k++){?>
                            <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                          <?php }; ?>
                        </select></td>   
                      </tr>
                      <tr>
                       <td nowrap="nowrap" class="label noline">Jenis Pendapatan</td>
                      <td width="50%" nowrap="nowrap" class="noline"><label for="backlog_type"></label>
                        <input type="text" name="backlog_type" id="backlog_type" /></td>
                        <td nowrap="nowrap" class="label noline">Jumlah Bayaran</td>
                        <td width="50%" class="noline"><span class="inputlabel">RM</span> <input name="backlog_total" type="text" class="w50" id="backlog_total" /><div class="inputlabel2">Cth : 0.00</div></td>
                      </tr>
                      <tr>
                      <td nowrap="nowrap" class="label noline">Caruman KWSP</td>
                        <td width="50%" class="noline"><span class="inputlabel">RM</span> <input name="backlog_kwsp" type="text" class="w50" id="backlog_kwsp" /><div class="inputlabel2">Cth : 0.00</div></td>
                        <td nowrap="nowrap" class="label noline">Potongan Cukai Berjadual (PCB)</td>
                        <td width="50%" class="noline"><span class="inputlabel">RM</span> <input name="backlog_pcb" type="text" class="w50" id="backlog_pcb" /><div class="inputlabel2">Cth : 0.00</div></td>
                        </tr>
                      <tr>
                        <td class="label noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $userpcb;?>" /></td>
                        <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" /> <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal"  onclick="toggleview2('formtunggakan'); return false;" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
              </div>
              <?php }; ?>
                <li class="gap">&nbsp;</li>
                <li>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <?php if ($totalRows_backlog > 0) { // Show if recordset not empty ?>
<tr>
 		<th align="center" valign="middle" nowrap="nowrap">Bil</th>
        <th align="left" valign="middle">Bayaran<br /> (Tahun)</td>
        <th align="center" valign="middle">Jenis Pendapatan</td>
        <th align="center" valign="middle">Jumlah Bayaran <br />(RM)</td>
        <th align="center" valign="middle">Caruman KWSP <br />(RM)</td>
        <th align="center" valign="middle">Potongan Cukai Berjadual (PCB) <br />(RM)</td>
              <th align="center" valign="middle">&nbsp;</th>                      
              </tr>
   <?php $i=1; do { ?>
      <tr class="on">
       <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
        <td align="left"><?php echo $row_backlog['backlog_y']; ?></td>
        <td align="center" valign="middle"><?php echo $row_backlog['backlog_type'];?></td>
       <td align="center" valign="middle"><?php echo $row_backlog['backlog_total'];?></td>
        <td align="center" valign="middle"><?php echo $row_backlog['backlog_kwsp'];?></td>
         <td align="center" valign="middle"><?php echo $row_backlog['backlog_pcb'];?></td>
        <td align="right" valign="middle">
        <ul class="func">
        <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)&& $row_user['user_stafid']!=$userpcb){?>
        <li><a onclick="return confirm('Anda mahu maklumat pembayaran berikut dipadam? \r\n\n <?php echo $row_backlog['backlog_type']; ?> (<?php echo $row_backlog['backlog_y']; ?>)')" href="../sb/del_backlog.php?id=<?php echo $row_backlog['backlog_id']; ?>&usid=<?php echo getID($userpcb);?>">X</a></li><?php }; ?></ul>
        </td>
      </tr>
      <?php } while ($row_backlog = mysql_fetch_assoc($backlog)); ?>
    <tr>
      <td colspan="7" align="center" class="noline txt_color1">&nbsp;<?php echo $totalRows_backlog ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="7" align="center" class="noline">Tiada rekod dijumpai</td>
    </tr>
    <?php }; ?>
  </table>
  </li>
                 <li class="gap">&nbsp;</li>
  <div class="tabbox profilemenu">
          <ul>
                <li class="title">SENARAI ELAUN/PERKUISIT/PEMBERIAN/MANFAAT YANG DIKECUALIKAN CUKAI SERTA AMAUN MASING-MASING</li>
                </ul>
                </div>
             <li class="gap">&nbsp;</li>
                <li>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="50%">Jenis Elaun/Perkuisit/Pemberian/Manfaat</th>
                <th>Jumlah Dikecualikan (RM)</th>
                </tr>
                 <tr>
                <td width="50%" align="left">IMBUHAN TETAP KHIDMAT AWAM (ITKA)</td>
                <td width="50%"><?php echo number_format(getTotalEmolumenITKAByUserID($userpcb, $y),2);?></td>
                </tr>
                 <tr>
                <td width="50%" align="left" class="noline in_upper">BANTUAN SARA HIDUP (BSH)</td>
                <td><?php echo number_format(getTotalEmolumenBSHByUserID($userpcb, $y),2);?></td>
                </tr>
                 <tr>
                <td width="50%" align="left" class="noline in_upper">ELAUN PERUMAHAN (ITP)</td>
                <td><?php echo number_format(getTotalEmolumenITPByUserID($userpcb, $y),2);?></td>
                </tr>
             </table>
        </ul>
              </div>
             <li class="gap">&nbsp;</li>
                <li>
             <?php } else { ?>
              <li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" valign="middle" class="noline">Tiada rekod dijumpai / Staf ID tidak aktif.</td>
                </tr>
              </table>
              </li>
            <?php } ; ?>
          </ul>
            </div>
         </div>
            
        </div>
        </div>
        </div>
        </div>
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php

mysql_free_result($user_job);

mysql_free_result($backlog);

?>
<?php include('../inc/footinc.php');?> 