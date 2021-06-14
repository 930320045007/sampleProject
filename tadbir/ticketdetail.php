<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='9';?>
<?php $menu2='56';?>
<?php
$colname_tr = "-1";
if (isset($_GET['id'])) {
  $colname_tr = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
}
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = sprintf("SELECT * FROM tadbir.travel WHERE ticket_id = %s AND travel_status = 1 ORDER BY travel_id ASC", GetSQLValueString($colname_tr, "int"));
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_isnp = sprintf("SELECT * FROM tadbir.isnpassenger WHERE ticket_id = %s AND ip_status = 1 ORDER BY ip_id ASC", GetSQLValueString($colname_tr, "int"));
$isnp = mysql_query($query_isnp, $tadbirdb) or die(mysql_error());
$row_isnp = mysql_fetch_assoc($isnp);
$totalRows_isnp = mysql_num_rows($isnp);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_nisnp = "SELECT * FROM tadbir.nonisnpassenger WHERE nip_status = 1 AND ticket_id = $colname_tr ORDER BY nip_id ASC";
$nisnp = mysql_query($query_nisnp, $tadbirdb) or die(mysql_error());
$row_nisnp = mysql_fetch_assoc($nisnp);
$totalRows_nisnp = mysql_num_rows($nisnp);
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
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(getTiketBy($colname_tr)==$row_user['user_stafid']){?>
                <?php if(!checkTiketApp($colname_tr)){?>
                <li class="form_back">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">Bersama-sama ini disertakan dokumen-dokumen untuk permohonan kelulusan dan tindakan Urusetia Bekalan :</td>
                    </tr>
                    <tr>
                      <td class="noline txt_line">
                      <ol>
                      	<li>Borang Penempahan Tiket Kapal Terbang atau Bas (Sila klik pada butang 'Cetak' dibawah)</li>
                    	<li>Surat Arahan/Jemputan yang telah yang telah disokong oleh Ketua Bahagian/Cawangan/Pusat dan diluluskan oleh Ketua Pegawai Eksekutif (<strong>WAJIB</strong> mendapat kelulusan)</li>
                        <li>Salinan Jadual Program</li>
                        <li>Salinan Passport dan Visa (<strong>WAJIB</strong> bagi perjalanan Luar Negara dan Pegawai Asing)</li>
                      </ol>
                      </td>
                    </tr>
                    <tr>
                      <td><input name="button3" type="button" class="submitbutton" id="button3" value="Cetak" onClick="MM_openBrWindow('ticketprint.php?id=<?php echo getID($colname_tr);?>','printticket','scrollbars=yes,width=930,height=600')" /></td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
            	<li><div class="note">Maklumat lengkap penempahan tiket</div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" class="label">Jenis Tiket</td>
                      <td><?php echo getTiketType($colname_tr);?></td>
                    </tr>
                    <tr>
                      <td valign="middle" class="label">Tujuan / Program</td>
                      <td><?php echo getTiketTitle($colname_tr);?></td>
                    </tr>
                    <tr>
                      <td valign="middle" class="label">No. Rujukan Kelulusan</td>
                      <td><?php echo getTiketRef($colname_tr);?></td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Maklumat Perjalanan</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_tr > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="25%" align="left" valign="middle" nowrap="nowrap">Dari</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                      <th width="25%" align="left" valign="middle" nowrap="nowrap">Ke</th>
                      <th width="25%" align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="25%" align="center" valign="middle" nowrap="nowrap">Waktu</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle"><?php echo $row_tr['travel_from']; ?></td>
                        <td align="center" valign="middle">&raquo;</td>
                        <td align="left" valign="middle"><?php echo $row_tr['travel_to']; ?></td>
                        <td align="center" valign="middle"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_tr['travel_date_m'], $row_tr['travel_date_d'], $row_tr['travel_date_y']));?></td>
                        <td align="center" valign="middle"><?php echo $row_tr['travel_time']; ?></td>
                      </tr>
                      <?php $i++; } while ($row_tr = mysql_fetch_assoc($tr)); ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_tr ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                <li class="title">Maklumat Penumpang</li>
                <li>
                <div class="note">Senarai Penumpang (Kakitangan ISN)</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_isnp > 0) { // Show if recordset not empty ?>
                      <tr>
                        <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                        <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                        <th align="center" valign="middle" nowrap="nowrap">No. Tel (Ext)</th>
                      </tr>
                      <?php $i=1; do { ?>
          <tr class="on">
                          <td><?php echo $i;?></td>
                          <td align="left" class="txt_line">
                          	<div><strong><?php echo getFullNameByStafID($row_isnp['user_stafid']) . " (" . $row_isnp['user_stafid'] . ")";?></strong></div>
                            <div><?php echo getFulldirectoryByUserID($row_isnp['user_stafid']);?> &nbsp; &bull; &nbsp; No. KP : <?php if(getICNoByStafID($row_isnp['user_stafid'])!=NULL) echo "&radic;"; else echo "<span class=\"txt_color2\">Tidak dinyatakan</span>";?> &nbsp; &bull; &nbsp; No. Passport : <?php if(getPassportByUserID($row_isnp['user_stafid'])!='0')echo "&radic;"; else echo "<span class=\"txt_color2\">Tidak dinyatakan</span> * ";?></div>
                          </td>
               			<td align="center" nowrap="nowrap"><?php echo getExtNoByUserID($row_isnp['user_stafid']); ?></td>
                        </tr>
                        <?php $i++; } while ($row_isnp = mysql_fetch_assoc($isnp)); ?>
                      <tr>
                        <td colspan="3" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_isnp ?>  rekod dijumpai</td>
                      </tr>
                    <?php } else { ?>
                      <tr>
                        <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                      </tr>
                    <?php }; ?>
                    </table>
                <?php if ($totalRows_nisnp > 0) { // Show if recordset not empty ?>
                <div class="note">Senarai Penumpang Tanggungan (Bukan Kakitangan ISN)</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
  <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle" class="txt_line"><div><strong><?php echo $row_nisnp['nip_name']; ?></strong></div>
                          <div>No. KP : <?php if($row_nisnp['nip_noic']!=NULL) echo $row_nisnp['nip_noic']; else echo "<span class=\"txt_color2\">Tidak dinyatakan</span>"; ?> &nbsp; &bull; &nbsp; No. Passport : <?php if($row_nisnp['nip_passport']!=NULL) echo $row_nisnp['nip_passport']; else echo "<span class=\"txt_color2\">Tidak dinyatakan</span>"; ?></div>
                          <?php if($row_nisnp['nip_notes']!=NULL){ ?><div class="txt_color1"><?php echo $row_nisnp['nip_notes']; ?></div><?php }; ?>
</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php $i++; } while ($row_nisnp = mysql_fetch_assoc($nisnp)); ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_nisnp ?> rekod dijumpai</td>
                    </tr>
                  </table>
                  <?php }; ?>
                    <div class="note inputlabel2">* Sila pastikan maklumat Passport yang dinyatakan adalah terkini. Untuk kakitangan ISN, sila kemaskini maklumat Passport dalam Modul Profil > Asas > Maklumat Passport bagi melancarkan proses penempahan tiket.</div>
              </li>
                <li class="title">Maklumat Tambahan</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap">Tambahan Bagasi</td>
                      <td nowrap="nowrap"><?php echo getTiketBagasi($colname_tr);?> kg</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap">Insuran Perjalanan</td>
                      <td><?php if(getTiketInsuran($colname_tr)==1) echo "Ya"; else echo "Tidak";?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap">Visa Perjalanan</td>
                      <td><?php if(getTiketVisa($colname_tr)==1) echo "Ya"; else echo "Tidak";?></td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <?php  if(checkTiketApp($colname_tr)){ ?>
                <li class="title">Pengesahan Kelulusan</li>
                <li class="gap">&nbsp;</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Pengesahan</td>
                    <td><strong>
                      <?php if(checkTiketAppOrNot($colname_tr)) echo "Diluluskan"; else echo "Tidak Diluluskan";?>
                      </strong> oleh <strong>
                        <?php if(getTiketAppBy($colname_tr)==1) echo getJob2Name('2'); else echo getJob2Name('9')?>
                      </strong></td>
                  </tr>
                  <tr>
                    <td class="label">Tarikh</td>
                    <td><?php echo getTiketAppDate($colname_tr);?></td>
                  </tr>
                  <?php if(getTiketAppNote($colname_tr)!=NULL){?>
                  <tr>
                    <td class="label">Catatan</td>
                    <td><?php echo getTiketAppNote($colname_tr);?></td>
                  </tr>
                  <?php }; ?>
                </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Maklumat Tiket</li>
                <li class="gap">&nbsp;</li>
                <?php if(checkTiketApp($colname_tr) && checkTiketAppOrNot($colname_tr)){?>
                <?php if(checkTiketInv($colname_tr)){?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">No. Rujukan</td>
                      <td><?php echo getTiketInvRef($colname_tr);?></td>
                    </tr>
                    <tr>
                      <td class="label">Tarikh</td>
                      <td><?php echo getTiketInvDate($colname_tr);?></td>
                    </tr>
                    <tr>
                      <td class="label">Syarikat Penerbangan</td>
                      <td><?php if(getFlyTypeWI($colname_tr)==NULL) echo "Tiada";else echo getFlyTypeName(getFlyTypeWI($colname_tr));?></td>
                    </tr>
                    <tr>
                      <td class="label">Agensi</td>
                      <td class="txt_line">
					  	<div><strong><?php echo getAgensiName(getAgensiIDByTiketID($colname_tr));?></strong></div>
                        <div><?php if(getAgensiNoTel(getAgensiIDByTiketID($colname_tr))!=NULL) echo "Tel : " . getAgensiNoTel(getAgensiIDByTiketID($colname_tr));?><?php if(getAgensiNoFax(getAgensiIDByTiketID($colname_tr))!=NULL) echo " &nbsp; &bull; &nbsp; Fax : " . getAgensiNoFax(getAgensiIDByTiketID($colname_tr));?><?php if(getAgensiEmail(getAgensiIDByTiketID($colname_tr))!=NULL) echo " &nbsp; &bull; &nbsp; Email : " . getAgensiEmail(getAgensiIDByTiketID($colname_tr));?></div>
                      </td>
                    </tr>
                    <?php if(getTiketInvNote($colname_tr)!=NULL){?>
                    <tr>
                      <td class="label">Catatan</td>
                      <td><?php echo getTiketInvNote($colname_tr);?></td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <?php } else { ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle" class="noline">Masih dalam proses</td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <?php }; ?>
                <?php }; ?>
			<?php }; ?>
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
mysql_free_result($tr);

mysql_free_result($isnp);

mysql_free_result($nisnp);
?>
<?php include('../inc/footinc.php');?> 