<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='37';?>
<?php
  if(isset($_GET['id']))
	  $id = getID($_GET['id'],0);
  else
	  $id = 0;
	  
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $query_kew8 = "SELECT * FROM user_kewe WHERE userkewe_id = '" . $id . "' AND userkewe_status = 1 LIMIT 1";
  $kew8 = mysql_query($query_kew8, $hrmsdb) or die(mysql_error());
  $row_kew8 = mysql_fetch_assoc($kew8);
  $totalRows_kew8 = mysql_num_rows($kew8);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/print.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">
<div>
  <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
        <tr>
          <td align="left" valign="middle"><?php echo $row_kew8['user_stafid'];?></td>
          <td width="100%" align="center" valign="middle">KERAJAAN MALAYSIA <br />
          <strong>PENYATA PERUBAHAN MENGENAI PENDAPATAN SESEORANG PEGAWAI</strong></td>
          <td align="right" valign="middle" nowrap="nowrap">(Kew. 8 - Pin. 10/96)</td>
        </tr>
        <tr>
          <td colspan="3">Akauntan Negara<br />
            Bendahari Negeri<br />
            Akauntan Perbendaharaan<br />
            Pembantu Kewangan</td>
        </tr>
        <tr>
          <td colspan="3">Ketua Pengarah Perkhidmatan Awam, Malaysia<br />
            (U.P. Pusat Sumber Maklumat, Bahagian Khidmat Pengurusan)</td>
        </tr>
        <tr>
          <td colspan="3">Perubahan berikut telah diluluskan. Sila bayar pegawai yang berkenaan seperti berikut :</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
        <tr>
          <td nowrap="nowrap">Nama Pegawai</td>
          <td width="100%" class="fsize1"><strong><?php echo getFullNameByStafID($row_kew8['user_stafid']) . " (" . getICNoByStafID($row_kew8['user_stafid']) . ")"; ?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap">Jawatan</td>
          <td class="fsize1"><strong><?php echo getJobtitleReal($row_kew8['user_stafid']) . " (" . getGred($row_kew8['user_stafid']) . ")";?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap">No Gaji Berkomputer</td>
          <td class="fsize1"><strong><?php echo $row_kew8['user_stafid'];?></strong></td>
        </tr>
  </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
        <tr>
          <th align="center" valign="middle" nowrap="nowrap">Butir - butir Perubahan</th>
          <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
          <th align="center" valign="middle" nowrap="nowrap">Gaji Bulanan</th>
          <th align="center" valign="middle" nowrap="nowrap">Catatan</th>
          <th align="center" valign="middle" nowrap="nowrap">No. Surat Kebenaran</th>
        </tr>
        <tr class="line_b">
          <td width="50%" align="left" valign="top" class="fsize1"><strong><?php echo htmlspecialchars_decode($row_kew8['userkewe_content'], ENT_QUOTES); ?></strong></td>
          <td align="center" valign="top" nowrap="nowrap" class="fsize1"><strong><?php echo getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']);?><br/><?php echo getKew8EndDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']);?></strong></td>
          <td align="center" valign="top" nowrap="nowrap" class="fsize1"><strong>RM <?php echo $row_kew8['userkewe_salary']; ?><br />
          (<?php echo $row_kew8['userkewe_salaryskill']; ?>)</strong></td>
          <td width="25%" align="left" valign="top" class="fsize1"><strong><?php echo htmlspecialchars_decode($row_kew8['userkewe_note'], ENT_QUOTES); ?></strong></td>
          <td width="25%" align="left" valign="top" nowrap="nowrap" class="fsize1"><strong><?php echo $row_kew8['userkewe_ref']; ?><br />
          <?php echo $row_kew8['userkewe_refdate']; ?></strong></td>
        </tr>
      </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
        <tr>
          <td colspan="2"><?php echo getKew8Date($row_kew8['userkewe_id']); ?> (<?php echo viewKew8Siri($row_kew8['userkewe_id']);?>)</td>
        </tr>
        <tr>
          <td width="50%" align="center" valign="top" nowrap="nowrap" class="fsize1">
          <br />
            <br />
            <strong>(PN. AZZA NAZARIA MOHD NOR)<br />
            &nbsp; &nbsp; <?php echo date('/ m / Y', mktime(0, 0, 0, $row_kew8['userkewe_date_m'], $row_kew8['userkewe_date_d'], $row_kew8['userkewe_date_y']));?></strong><br />
            (PS(SM2))</td>
          <td width="50%" align="center" valign="top" nowrap="nowrap" class="fsize1"><br />
        <br />
        <strong>(<?php echo getFullNameByStafID(getKetuaUnitByDirID(10));?>)<br />
          &nbsp; &nbsp; <?php echo date('/ m / Y', mktime(0, 0, 0, $row_kew8['userkewe_date_m'], $row_kew8['userkewe_date_d'], $row_kew8['userkewe_date_y']));?></strong><br />
            TANDATANGAN KETUA JABATAN<br />
            Cop Rasmi Jabatan<br />
            (KCT(M))</td>
        </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
    <tr>
      <td>1. Semua perubahan mengenai pendapatan seseorang pegawai hendaklah dinyatakan dalam borang ini. Perubahan-perubahan yang berkaitan adalah seperti berikut :</td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="30%" align="left" valign="top">
          <em>Jawatan </em><br />Perlantikan baru (jawatan tetap)
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
          <td width="30%" align="left" valign="top">
          <em>Cuti </em><br />
          Separuh gaji
          <br />Tanpa gaji
          <br />Cuti sakit separuh gaji
          <br />atau tanpa gaji
          <br />
          <br />
          <br />
          <em>Bersara
          </em><br />
          <br />
          <br />
          <em>Gaji
          </em><br />
          Kenaikan gaji ditahan
          <br />Kenaikan gaji ditangguh
          <br />Turun gaji
          </td>
          <td width="30%" align="left" valign="top">
          <em>Elaun - elaun </em><br />
          Semua jenis elaun
          </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>2. Satu salinan penyata ini hendaklah dihantar kepada PUSAT SUMBER MAKLUMAT, BAHAGIAN KHIDMAT PENGURUSAN, JABATAN PERKHIDMATAN AWAM MALAYSIA dengan mengisi butir-butir berkenaan dalam borang PR.JPA2(Pin. 1/95) di sebelah belakang penyata ini. Badan-badan Berkanun/Penguasa Tempatan yang tidak menggunakan Laporan Penyata Perubahan (Kew.8) untuk membenarkan sebarang pembayaran hanya dikehendaki menghantar satu salinan Laporan Penyata Perubahan PR.JPA2 (Pin. 1/95) ke Pusat Sumber Maklumat, Bahagian Khidmat Pengurusan, Jabatan Perkhidmatan Awam dan tidak perlu menghantar kepada Akauntan Negara, Bendahari Negeri, Akauntan Perbendaharaan atau pembantu Kewangan.</td>
    </tr>
  </table>
<?php } ; ?>
</div>
</body>
</html>
<?php
mysql_free_result($kew8);
?>
<?php include('../inc/footinc.php');?> 