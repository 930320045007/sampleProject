<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='37';?>
<?php
$kewe_id = array(10, 11, 12, 15, 17, 25, 28, 31, 37, 41, 45, 47);

  if(isset($_GET['id']))
	  $id = getID($_GET['id'],0);
  else
	  $id = 0;
	  
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $query_kew8 = "SELECT * FROM user_kewe WHERE userkewe_id = '" . $id . "' AND userkewe_status = 1 LIMIT 1";
  $kew8 = mysql_query($query_kew8, $hrmsdb) or die(mysql_error());
  $row_kew8 = mysql_fetch_assoc($kew8);
  $totalRows_kew8 = mysql_num_rows($kew8);
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $query_sch = sprintf("SELECT user_scheme.*, classification.classification_id FROM www.user_scheme LEFT JOIN www.scheme ON scheme.scheme_id = user_scheme.scheme_id LEFT JOIN www.classification ON classification.classification_id = scheme.classification_id WHERE user_stafid = %s AND user_scheme.userscheme_status = '1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, user_scheme.userscheme_id DESC", GetSQLValueString($row_kew8['user_stafid'], "text"));
  $sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
  $row_sch = mysql_fetch_assoc($sch);
  $totalRows_sch = mysql_num_rows($sch);
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $query_emo = sprintf("SELECT * FROM www.user_emolumen WHERE user_stafid = %s and useremolumen_date_y < %s and useremolumen_status = '1' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC", GetSQLValueString($row_kew8['user_stafid'], "text"), GetSQLValueString(date('Y', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))), "text"));
  $emo = mysql_query($query_emo, $hrmsdb) or die(mysql_error());
  $row_emo = mysql_fetch_assoc($emo);
  $totalRows_emo = mysql_num_rows($emo);
  // echo $row_emo['useremolumen_itkrai'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/print.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">
<style type="text/css">
.display-none {
	display:none;
}
</style>
<div style="padding-right: 7px padding-top:10px">
  <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
  <font size="1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="middle"><?php echo $row_kew8['user_stafid'];?></td>
          <td width="100%" align="center" valign="middle">KERAJAAN MALAYSIA <br /><br />
          <h2>PENYATA PERUBAHAN MENGENAI PENDAPATAN SESEORANG PEGAWAI</h2></td>
          <td align="right" valign="middle" nowrap="nowrap">(Kew. 8 - Pin. 10/96)</td>
        </tr>
        <tr>
          <td colspan="3"><br />Akauntan Negara<br />
            Bendahari Negeri<br />
            Akauntan Perbendaharaan<br />
            Pembantu Kewangan <br /><br /></td>
        </tr>
        
        <tr>
          <td colspan="3">Ketua Pengarah Perkhidmatan Awam, Malaysia<br />
            (U.P. Pusat Sumber Maklumat, Bahagian Khidmat Pengurusan)<br /><br /></td>
        </tr>
        <tr>
          <td colspan="3">Perubahan berikut telah diluluskan. Sila bayar pegawai yang berkenaan seperti berikut :<br /><br /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo" class="">
        <style>
.underline--dotted {
  border-bottom: 1px black dotted;
}
</style>
        <tr>
          <td nowrap="nowrap" class="">Nama Pegawai</td>
          <td width="100%" class="underline underline--dotted"><strong><?php echo getFullNameByStafIDkew8($row_kew8['user_stafid']) . " (" . getICNoByStafID($row_kew8['user_stafid']) . ")"; ?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class="">Jawatan</td>
          <td class="underline underline--dotted"><strong><?php echo getJobtitleReal($row_kew8['user_stafid']); if(getJobtype($row_kew8['user_stafid']) == "KONTRAK") { echo " (" . $row_kew8['userkewe_gred_memangku'] . ")";} else{echo " (" . getGred($row_kew8['user_stafid']) . ")"; if(isset($row_kew8['userkewe_gred_memangku'])) {echo " (" . $row_kew8['userkewe_gred_memangku'] . ")";}}?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class="">No Gaji Berkomputer</td>
          <td class="underline underline--dotted"><strong><?php echo adjustID($row_kew8['user_stafid']);?></strong></td>
        </tr>
  </table><br>
  
  <div style="height:295px; margin-bottom: -15px;">
      <table style="height:270px" border="0" cellspacing="0" cellpadding="0" class="tabborder" >
        <tr style="height:20px">
          <th style="width:32%" align="center" valign="middle" nowrap="nowrap" class="fsize1">Butir - butir Perubahan</th>
          <th style="width:9%" align="center" valign="middle" nowrap="nowrap" class="fsize1">Tarikh</th>
          <th style="width:25%" align="center" valign="middle" nowrap="nowrap" class="fsize1">Gaji Bulanan</th>
          <th style="width:25%" align="center" valign="middle" nowrap="nowrap" class="fsize1">Catatan</th>
          <th style="width:9%" align="center" valign="middle" nowrap="nowrap" class="fsize1">No. Surat Kebenaran</th>
        </tr>
        <tr class="line_b" style="height:250px">
          <td align="left" valign="top" class="" align="justify"><strong><?php echo nl2br ($row_kew8['userkewe_content'], ENT_QUOTES); ?></strong></td>
          <td align="center" valign="top" nowrap="nowrap" class="">
            <strong><div style="display:<?php if(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']) == "-" && getKew8EndDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']) == null ) {echo "none";} ?>"><?php echo getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']);?></div>

            <div style="display:<?php if(getKew8EndDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']) != null) echo "block";else echo "none" ?>" > hingga 
            <br /><?php echo getKew8EndDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']);?>
            <br/>
            <br/>
            
            </div>
            <div style="display:<?php if(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']) == null || getKew8EndDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']) == null ) {echo "block";} ?>"><?php echo nl2br ($row_kew8['userkewe_note'], ENT_QUOTES);?></div>
            </strong></td>


          <?php 
              setlocale(LC_MONETARY,"ms_MY");
            ?>
          
          
          <td align="center" valign="top" nowrap="nowrap" class="">
          <div style="display:<?php if($row_kew8['kewe_id'] == '25') echo "block"; else echo "none"; ?>"><strong>RM<?php echo getBasicSalaryByUserIDall($row_kew8['user_stafid'], 1, date('m', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))), date('Y', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))-1));?> <br/>Kepada</strong></div>
          <div align="left" style="display:<?php if($row_kew8['kewe_id'] == '87') echo "block"; else echo "none"; ?>"><strong>Telah Terima </br></br>Gred <?php echo getGredByKew8($row_kew8['user_stafid'], date('Y', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))));?> </br></br> RM <?php echo getBasicSalaryByUserIDall($row_kew8['user_stafid'], 1, date('m', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))), date('Y', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))-1));?> <br/></br> ITKA : RM <?php echo $row_emo['useremolumen_itkrai'];?></br>ITP : RM <?php echo $row_emo['useremolumen_itp'];?></br>BSH : RM <?php echo $row_emo['useremolumen_bsh'];?></br>Insentif Peminjam : RM <?php echo $row_emo['useremolumen_elinsentif'];?></br></strong></div>
          <strong style="display:<?php if($row_kew8['kewe_id'] !== '87') echo "block"; else echo "none"; ?>">RM<?php echo $row_kew8['userkewe_salary'];?><br /><br>
          
          <br> 
          </strong></td>
          <td align="left" valign="top" class=""><strong><?php echo nl2br ($row_kew8['userkewe_imbuhan'], ENT_QUOTES); ?></strong></td>
          <td align="left" valign="top" nowrap="nowrap" class="" style="word-break: break-word"><strong><?php echo nl2br($row_kew8['userkewe_ref'],ENT_QUOTES); ?><br /><br />
          bth <?php echo date('d.m.Y', strtotime($row_kew8["userkewe_refdate"])); ?></strong></td>
          
        </tr>
      </table>
    </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
        <tr>
          <td colspan="2"><b><?php echo date('d.m.Y', strtotime($row_kew8["userkewe_refdatekewe"])); ?></b> </td>
        </tr>
        <tr>
          <td width="20%" align="center" valign="top" nowrap="nowrap" class="" style="font-size: 11px;">
          <br /><br/><br/>
            <strong>(<?php echo $row_kew8['userkewe_pelulus'];?>)<br />
            &nbsp; &nbsp; Tarikh : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <?php echo date('/ m / Y', mktime(0, 0, 0, $row_kew8['userkewe_date_m'], $row_kew8['userkewe_date_d'], $row_kew8['userkewe_date_y']));?></strong>
            <br />----------------------------------------<br />
            <strong><?php echo $row_kew8['userkewe_jawatan'];?></strong></td>

          <td width="60%" align="center" valign="top" nowrap="nowrap" class=""></td>
            
          <td width="20%" align="center" valign="top" nowrap="nowrap" class="" style="font-size: 11px;"><br /><br /><br/>
        <strong>(<?php echo $row_kew8['userkewe_pelulus2'];?>)<br />
          &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo date('/ m / Y', mktime(0, 0, 0, $row_kew8['userkewe_date_m'], $row_kew8['userkewe_date_d'], $row_kew8['userkewe_date_y']));?></strong>
          <br />------------------------------------------------<br />
            <h7 style="font-size:9px">TANDATANGAN KETUA JABATAN</h7><br />
            <h7 style="font-size:9px">Cop Rasmi Jabatan</h7><br />
            <strong><?php echo $row_kew8['userkewe_jawatan2'];?></strong><br /><br /></td>
        </tr>
  </table>


  <p width="100%" align="center" valign="middle" style="margin:1px"><strong>PANDUAN</strong></p>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo" align="center" style="margin-left:0px; margin-right:0px;">
    <tr>
      <td>1. Semua perubahan mengenai pendapatan seseorang pegawai hendaklah dinyatakan dalam borang ini. Perubahan-perubahan yang berkaitan adalah seperti berikut : <br /></td>
    </tr>
    <tr style="line-height: 12px;">
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
        <tr> 
          <td width="30%" align="left" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <em>Jawatan </em><br /><br />Perlantikan baru (jawatan tetap)
          <br />Pengesahan dalam perjawatan berpencen
          <br />Memangku
          <br />Naik pangkat
          <br />Melangkah sekatan kecekapan
          <br />Pertukaran
          <br />Pinjaman/pertukaran sementara
          <br />Gantung kerja
          <br />Turun pangkat
          <br />Buang kerja
          <br />Meletak jawatan
          <br />Perlantikan semula
          <br />Meninggal dunia
          <br />Perlantikan sementara/kontrak
          <br />Tamat perkhidmatan sementara/kontrak
          </td>
          <td width="30%" align="left" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <em>Cuti </em><br /><br />
          Separuh gaji
          <br />Tanpa gaji
          <br />Cuti sakit separuh gaji
          <br />atau tanpa gaji
          <br />
          <br />
          <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <em>Bersara
          </em><br />
          <br />
          <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <em>Gaji
          </em><br />
          Kenaikan gaji ditahan
          <br />Kenaikan gaji ditangguh
          <br />Turun gaji
          </td>
          <td width="30%" align="left" valign="top">
          <em>Elaun - elaun </em><br /><br />
          Semua jenis elaun
          </td>
        </tr>
      </table></td>
    </tr>
    <br/>
    <tr>
      <td>2. Satu salinan penyata ini hendaklah dihantar kepada PUSAT SUMBER MAKLUMAT, BAHAGIAN KHIDMAT PENGURUSAN, JABATAN PERKHIDMATAN AWAM MALAYSIA dengan mengisi butir-butir berkenaan dalam borang PR.JPA2(Pin. 1/95) di sebelah belakang penyata ini. Badan-badan Berkanun/Penguasa Tempatan yang tidak menggunakan Laporan Penyata Perubahan (Kew.8) untuk membenarkan sebarang pembayaran hanya dikehendaki menghantar satu salinan Laporan Penyata Perubahan PR.JPA2 (Pin. 1/95) ke Pusat Sumber Maklumat, Bahagian Khidmat Pengurusan, Jabatan Perkhidmatan Awam dan tidak perlu menghantar kepada Akauntan Negara, Bendahari Negeri, Akauntan Perbendaharaan atau Pembantu Kewangan.</td>
    </tr>
  </table>
</table>
<?php } ; ?>
</div>
</body>
</html>
<?php
mysql_free_result($kew8);
?>
<?php include('../inc/footinc.php');?> 