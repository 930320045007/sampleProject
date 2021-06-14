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
};

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = sprintf("SELECT * FROM travel WHERE ticket_id = %s AND travel_status = 1 ORDER BY travel_id ASC", GetSQLValueString($colname_tr, "int"));
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_isnp = sprintf("SELECT * FROM isnpassenger WHERE ticket_id = %s ORDER BY ip_id ASC", GetSQLValueString($colname_tr, "int"));
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
<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300' rel='stylesheet' type='text/css'>
<link href="../css/print.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td colspan="2">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
              <tr>
                  <td align="center" valign="middle" nowrap="nowrap"><img src="<?php echo $url_main;?>img/isn.png" width="75" height="70" alt="isn" /></td>
                  <td width="100%" align="left" valign="middle" nowrap="nowrap" class="fsize2"><strong>INSTITUT SUKAN NEGARA</strong><br />
                  Borang Penempahan Tiket ( <?php echo getTiketType($colname_tr);?> )</td>
                  <td align="left" valign="middle" nowrap="nowrap">Tarikh : <?php echo getTiketDate($colname_tr);?></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td width="100%" height="100%" align="left" valign="top" style="border-right: #999 thin solid;">
          
	
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
        <tr class="line_b">
          <td valign="middle" nowrap="nowrap" class="label">Tujuan / Program</td>
          <td width="100%"><?php echo getTiketTitle($colname_tr);?></td>
        </tr>
        <tr class="line_b">
          <td valign="middle" nowrap="nowrap" class="label">No. Rujukan Kelulusan</td>
          <td><?php echo getTiketRef($colname_tr);?></td>
        </tr>
        <tr class="line_b">
          <td valign="middle" nowrap="nowrap" class="label">Pemohon</td>
          <td>
          <div><strong><?php echo getFullNameByStafID(getTiketBy($colname_tr)) . " (" . getTiketBy($colname_tr) . ")";?></strong></div>
          <div><?php echo getFulldirectoryByUserID(getTiketBy($colname_tr));?></div>
          </td>
        </tr>
      </table>
      
      
      <?php if ($totalRows_tr > 0) { // Show if recordset not empty ?>
  	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="left" valign="middle" nowrap="nowrap">Maklumat Perjalanan</td>
        </tr>
	</table>
        
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
        <tr>
          <th align="center" valign="middle" nowrap="nowrap">Bil</th>
          <th width="25%" align="left" valign="middle" nowrap="nowrap">Dari</th>
          <th width="25%" align="left" valign="middle" nowrap="nowrap">Ke</th>
          <th width="25%" align="center" valign="middle" nowrap="nowrap">Tarikh</th>
          <th width="25%" align="center" valign="middle" nowrap="nowrap">Waktu</th>
        </tr>
        <?php $i=1; do { ?>
          <tr class="line_b">
            <td align="center" valign="middle"><?php echo $i;?></td>
            <td align="left" valign="middle"><?php echo $row_tr['travel_from']; ?></td>
            <td align="left" valign="middle"><?php echo $row_tr['travel_to']; ?></td>
            <td align="center" valign="middle"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_tr['travel_date_m'], $row_tr['travel_date_d'], $row_tr['travel_date_y']));?></td>
            <td align="center" valign="middle"><?php echo $row_tr['travel_time']; ?></td>
          </tr>
          <?php $i++; } while ($row_tr = mysql_fetch_assoc($tr)); ?>
    </table>
      <?php }; ?>
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle" nowrap="nowrap">Jumlah Penumpang : <strong><?php echo getTotalPenumpang($colname_tr);?></strong> orang</td>
        </tr>
      </table>
    
<?php if ($totalRows_isnp > 0) { // Show if recordset not empty ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td align="left" valign="middle" nowrap="nowrap">Senarai Penumpang (Kakitangan ISN)</td>
        </tr>
        </table>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
          <tr>
            <th align="center" valign="middle" nowrap="nowrap">Bil</th>
            <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
            <th align="center" valign="middle" nowrap="nowrap">No. Tel (Ext)</th>
          </tr>
          <?php $i=1; do { ?>
          <tr class="line_b">
              <td><?php echo $i;?></td>
              <td align="left" class="txt_line">
                <div><strong><?php echo getFullNameByStafID($row_isnp['user_stafid']) . " (" . $row_isnp['user_stafid'] . ")";?></strong></div>
                <div><?php echo getJobtitle($row_isnp['user_stafid']) . " (" . getGred($row_isnp['user_stafid']) . ")"; ?></div>
                <div><?php echo getFulldirectoryByUserID($row_isnp['user_stafid']);?></div>
              </td>
            <td align="center" nowrap="nowrap"><?php echo getExtNoByUserID($row_isnp['user_stafid']); ?></td>
          </tr>
          <?php $i++; } while ($row_isnp = mysql_fetch_assoc($isnp)); ?>
        <?php }; ?>
      </table>
        
        
<?php if ($totalRows_nisnp > 0) { // Show if recordset not empty ?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle" nowrap="nowrap">Senarai Penumpang Tanggungan (Bukan Kakitangan ISN)</td>
        </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
            <tr class="line_b">
              <th align="center" valign="middle" nowrap="nowrap">Bil</th>
              <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
            </tr>
            <?php do { ?>
            <tr class="on">
                <td align="center" valign="middle"><?php echo $i;?></td>
                <td align="left" valign="middle" class="txt_line">
                  <div><strong><?php echo strtoupper($row_nisnp['nip_name']); ?></strong></div>
                  <div>No. KP : <?php if($row_nisnp['nip_noic']!=NULL) echo $row_nisnp['nip_noic']; else echo "<span class=\"txt_color2\">Tidak dinyatakan</span>"; ?> &nbsp; &bull; &nbsp; No. Passport : <?php if($row_nisnp['nip_passport']!=NULL) echo $row_nisnp['nip_passport']; else echo "<span class=\"txt_color2\">Tidak dinyatakan</span>"; ?><?php if($row_nisnp['nip_notes']!=NULL){ ?> &nbsp; &bull; &nbsp; Catatan : <?php echo $row_nisnp['nip_notes']; ?><?php }; ?></div>
                  
                </td>
            </tr>
            <?php $i++; } while ($row_nisnp = mysql_fetch_assoc($nisnp)); ?>
        </table>
      <?php }; ?>
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap">Maklumat Tambahan</td>
        </tr>
      </table>
      
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
        <tr class="line_b">
          <td width="100%" nowrap="nowrap">Tambahan Bagasi</td>
          <td nowrap="nowrap"><?php echo getTiketBagasi($colname_tr);?> kg</td>
        </tr>
        <tr class="line_b">
          <td nowrap="nowrap">Insuran Perjalanan</td>
          <td><?php if(getTiketInsuran($colname_tr)==1) echo "Ya"; else echo "Tidak";?></td>
        </tr>
        <tr>
          <td nowrap="nowrap">Visa Perjalanan</td>
          <td><?php if(getTiketVisa($colname_tr)==1) echo "Ya"; else echo "Tidak";?></td>
        </tr>
      </table>
        
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Disertakan bersama lampiran berikut (tanda &radic; pada yang berkenaan)</td>
        </tr>
      </table>
        
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td class="tabborder">&nbsp;</td>
          <td width="100%">Salinan fotokopi Minit Kelulusan / Jemputan (No. Rujukan : <?php echo getTiketRef($colname_tr);?>)</td>
        </tr>
        <tr>
          <td class="tabborder">&nbsp;</td>
          <td>Salinan Jadual Program</td>
        </tr>
        <tr>
          <td class="tabborder">&nbsp;</td>
          <td>Salinan Passport atau Visa</td>
        </tr>
      </table>
      
      </td>
      <td width="10%" align="left" valign="top" class="line_l">
        
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td><strong>Kelulusan </strong></td>
        </tr>
      </table>
    
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
        <tr>
          <td nowrap="nowrap" class="box">&nbsp;</td>
          <td nowrap="nowrap">DILULUSKAN</td>
          <td nowrap="nowrap" class="box">&nbsp;</td>
          <td width="100%" nowrap="nowrap">TIDAK DILULUSKAN</td>
        </tr>
      </table>
      <br/><br/>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td colspan="3" class="tabborder"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        </tr>
        <tr>
          <td colspan="3">Tandatangan &amp; Cop Rasmi</td>
        </tr>
        </table>
          
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>Oleh</td>
        </tr>
        </table>
        
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="box">&nbsp;</td>
              <td>KPE</td>
              <td class="box">&nbsp;</td>
              <td width="100%">PBT</td>
            </tr>
          </table>
          
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Tarikh</td>
        </tr>
        </table>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
              <td>/</td>
              <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
              <td>/</td>
              <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
              <td width="100%">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6" nowrap="nowrap" >&nbsp;</td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
          <tr>
            <td align="left" valign="top" nowrap="nowrap"><img src="<?php echo $url_main;?>qr/qrtiket.php?tid=<?php echo $colname_tr;?>" alt="" /></td>
            <td width="100%" align="left" valign="middle">Borang ini adalah cetakan melalui <?php echo $systitle_full;?> (<?php echo $systitle_short;?>)<br/>
              <br />
              <?php echo time();?></td>
          </tr>
        </table>
          
</table>
</td>
</tr>
</table>
</body>
</html>
<?php
mysql_free_result($tr);

mysql_free_result($isnp);

mysql_free_result($nisnp);
?>
<?php include('../inc/footinc.php');?> 