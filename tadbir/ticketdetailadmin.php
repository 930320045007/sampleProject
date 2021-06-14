<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='57';?>
<?php
$colname_tr = "-1";
if (isset($_GET['id'])) {
  $colname_tr = htmlspecialchars($_GET['id'], ENT_QUOTES);
}
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = sprintf("SELECT * FROM tadbir.travel WHERE ticket_id = %s AND travel_status = 1 ORDER BY travel_id ASC", GetSQLValueString($colname_tr, "int"));
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_isnp = sprintf("SELECT * FROM tadbir.isnpassenger WHERE ip_status = 1 AND ticket_id = %s ORDER BY ip_id ASC", GetSQLValueString($colname_tr, "int"));
$isnp = mysql_query($query_isnp, $tadbirdb) or die(mysql_error());
$row_isnp = mysql_fetch_assoc($isnp);
$totalRows_isnp = mysql_num_rows($isnp);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_nisnp = sprintf("SELECT * FROM tadbir.nonisnpassenger WHERE nip_status = 1 AND ticket_id = %s ORDER BY nip_id ASC", GetSQLValueString($colname_tr, "int"));
$nisnp = mysql_query($query_nisnp, $tadbirdb) or die(mysql_error());
$row_nisnp = mysql_fetch_assoc($nisnp);
$totalRows_nisnp = mysql_num_rows($nisnp);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_ag = "SELECT * FROM agensi WHERE agensi_status = 1 ORDER BY agensi_name ASC";
$ag = mysql_query($query_ag, $tadbirdb) or die(mysql_error());
$row_ag = mysql_fetch_assoc($ag);
$totalRows_ag = mysql_num_rows($ag);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script type="text/javascript" src="../js/tabber.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
            	<li><div class="note">Maklumat lengkap penempahan tiket</div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Jenis Tiket</td>
                      <td colspan="2"><?php echo getTiketType($colname_tr);?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Tujuan / Program</td>
                      <td colspan="2"><?php echo getTiketTitle($colname_tr);?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">No. Rujukan <br />
                      Kelulusan</td>
                      <td colspan="2"><?php echo getTiketRef($colname_tr);?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Oleh</td>
                      <td align="center" valign="middle" class="txt_line"><?php echo viewProfilePic(getTiketBy($colname_tr));?></td>
                      <td width="100%" class="txt_line">
                      <div><strong><?php echo getFullNameByStafID(getTiketBy($colname_tr)) . " (" . getTiketBy($colname_tr) . ")";?></strong></div>
                      <div><?php echo getFulldirectoryByUserID(getTiketBy($colname_tr));?></div>
                      <div>Email : <?php echo getEmailISNByUserID(getTiketBy($colname_tr));?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID(getTiketBy($colname_tr));?></div>
                      </td>
                    </tr>
                    <?php if(!checkTiketApp($colname_tr)){?>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="noline">&nbsp;</td>
                      <td colspan="2" align="left" valign="middle" class="noline"><input name="button8" type="button" class="submitbutton" id="button8" value="Cetak" onClick="MM_openBrWindow('ticketprint.php?id=<?php echo getID($colname_tr);?>','printticket','scrollbars=yes,width=930,height=600')" /></td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Maklumat Perjalanan<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onclick="toggleview2('formtravel'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formtravel" class="hidden">
                <li>
                  <form id="form3" name="form3" method="post" action="../sb/add_tickettravel_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>
                        <span id="from2">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                        <div class="inputlabel2">Dari / From</div>
                        <input type="text" name="travel_from" id="travel_from" />
                        <div class="inputlabel2">Cth : Kuala Lumpur, Malaysia</div>
                        </span>
                        </td>
                        <td>
                          <span id="to2">
                          <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <div class="inputlabel2">Ke / To</div>
                          <input type="text" name="travel_to" id="travel_to" />
                          <div class="inputlabel2">Cth : Guangzhou, China</div>
                          </span>
                        </td>
                        <td>
                        <div class="inputlabel2">Tarikh / Date</div>
                        <select name="travel_date_d" id="travel_date_d">
                        <?php for($i = 1; $i<=31; $i++){?>
                          <option <?php if($i<10) $i = "0" . $i; if($i==date('d')) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php }; ?>
                        </select>
                          <select name="travel_date_m" id="travel_date_m">
                        <?php for($j = 1; $j<=12; $j++){?>
                          <option <?php if($j<10) $j = "0" . $j; if($j==date('m')) echo "selected=\"selected\"";?> value="<?php echo $j;?>"><?php echo $j;?></option>
                        <?php }; ?>
                          </select>
                          <select name="travel_date_y" id="travel_date_y">
                        <?php for($k = date('Y'); $k<=(date('Y')+2); $k++){?>
                          <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                        <?php }; ?>
                          </select>
                        <div class="inputlabel2">&nbsp;</div>
                        </td>
                        <td><div class="inputlabel2">Masa / Time</div><input type="text" name="travel_time" id="travel_time" /><div class="inputlabel2">Cth : 9.00 AM</div></td>
                        <td>
                        <input name="ticket_id" type="hidden" id="ticket_id" value="<?php echo $colname_tr;?>" />
                        <input name="travel_note" type="hidden" id="travel_note" value="Dimasukkan oleh <?php echo getFullNameByStafID($row_user['user_stafid']) . " (" . $row_user['user_stafid'] . ")" . " pada " . date('d/m/Y h:i:s A');?>" />
                        <input name="button5" type="submit" class="submitbutton" id="button5" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
              <li class="gap">&nbsp;</li>
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
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle"><?php echo $row_tr['travel_from']; ?></td>
                        <td align="center" valign="middle">&raquo;</td>
                        <td align="left" valign="middle"><?php echo $row_tr['travel_to']; ?></td>
                        <td align="center" valign="middle"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_tr['travel_date_m'], $row_tr['travel_date_d'], $row_tr['travel_date_y']));?></td>
                        <td align="center" valign="middle"><?php echo $row_tr['travel_time']; ?></td>
                        <td align="center" valign="middle"><ul class="func"><li><a onclick="return confirm('Anda mahu berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_tr['travel_date_m'], $row_tr['travel_date_d'], $row_tr['travel_date_y']));?> \r\n<?php echo $row_tr['travel_from']; ?> -> <?php echo $row_tr['travel_to']; ?>')" href="../sb/del_tickettravel_admin.php?trid=<?php echo $row_tr['travel_id']; ?>">X</a></li></ul></td>
                      </tr>
                      <?php $i++; } while ($row_tr = mysql_fetch_assoc($tr)); ?>
                    <tr>
                      <td colspan="7" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_tr ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="7" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                <li class="title">Maklumat Penumpang<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onclick="toggleview2('formpenumpang'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formpenumpang" class="hidden">
                <li>
                <div class="tabber">
                  <div class="tabbertab tabbertabdefault" title="Kakitangan ISN">
                  <form id="form4" name="form4" method="post" action="../sb/add_tikcket_passenger.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label noline">Staf ID</td>
                        <td class="noline">
                        <input name="user_stafid" type="text" class="w30" id="user_stafid" list="datalistPenumpang" />
                        <?php echo datalistStaf("datalistPenumpang");?>
                        <input name="button6" type="submit" class="submitbutton" id="button6" value="Tambah" />
                        <input name="ticket_id" type="hidden" id="ticket_id" value="<?php echo $colname_tr;?>" />
                        </td>
                      </tr>
                    </table>
                    </form>
                    </div>
                  <div class="tabbertab" title="Bukan Kakitangan ISN">
                  <form id="form4" name="form4" method="post" action="../sb/add_tikcket_passenger.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="noline"><div class="inputlabel2">Nama Penuh / Full Name</div><input name="nip_name" type="text" id="nip_name" list="datalistPenumpang" /></td>
                        <td class="noline"><div class="inputlabel2">Kad Pengenalan</div><input name="nip_noic" type="text" id="nip_noic" list="datalistPenumpang" /></td>
                        <td class="noline"><div class="inputlabel2">Passport</div><input name="nip_passport" type="text" id="nip_passport" list="datalistPenumpang" /></td>
                        <td class="noline"><div class="inputlabel2">Catatan</div><input name="nip_notes" type="text" id="nip_notes" list="datalistPenumpang" /></td>
                        <td class="noline">
                        <input name="button7" type="submit" class="submitbutton" id="button7" value="Tambah" />
                        <input name="ticket_id" type="hidden" id="ticket_id" value="<?php echo $colname_tr;?>" />
                        </td>
                      </tr>
                    </table>
                    </form>
                    </div>
                </div>
                </li>
                </div>
                <?php }; ?>
              <li>
                <div class="note"><strong>Jumlah Penumpang : <?php echo getTotalPenumpang($colname_tr);?> orang</strong> </div>
                <div class="note">Senarai Penumpang (Kakitangan ISN)</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php if ($totalRows_isnp > 0) { // Show if recordset not empty ?>
<tr>
                        <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                        <th width="100%" colspan="2" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                        <th align="center" valign="middle" nowrap="nowrap">No. Tel (Ext)</th>
                        <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                      </tr>
                      <?php $i=1; do { ?>
                      <tr class="on">
                          <td><?php echo $i;?></td>
                          <td align="left" valign="top" class="txt_line"><?php echo viewProfilePic($row_isnp['user_stafid']);?></td>
                          <td width="100%" align="left" valign="top" class="txt_line">
                          	<div><strong><?php echo getFullNameByStafID($row_isnp['user_stafid']) . " (" . $row_isnp['user_stafid'] . ")";?></strong></div>
                            <div><?php echo getFulldirectoryByUserID($row_isnp['user_stafid']);?></div>
                            <div>No. KP : <?php if(getICNoByStafID($row_isnp['user_stafid'])!=NULL) echo getICNoByStafID($row_isnp['user_stafid']); else echo "<span class=\"txt_color2\">Tidak dinyatakan</span>";?> &nbsp; &bull; &nbsp; No. Passport : <?php if(getPassportByUserID($row_isnp['user_stafid'])!='0')echo getPassportByUserID($row_isnp['user_stafid']); else echo "<span class=\"txt_color2\">Tidak dinyatakan</span>";?> &nbsp; &bull; &nbsp; Email : <?php echo getEmailISNByUserID($row_isnp['user_stafid']);?> &nbsp; &bull; &nbsp; No. Tel : <?php if(checkTelMByStafID($row_isnp['user_stafid'])) echo getTelMByStafID($row_isnp['user_stafid']); else echo "<span class=\"txt_color2\">Tidak dinyatakan</span>";?></div>
                          </td>
               			<td align="center" nowrap="nowrap"><?php echo getExtNoByUserID($row_isnp['user_stafid']); ?></td>
               			<td align="center" nowrap="nowrap"><ul class="func">
               			  <li><a onclick="return confirm('Anda mahu berikut dipadam? \r\n\n <?php echo getFullNameByStafID($row_isnp['user_stafid']) . " (" . $row_isnp['user_stafid'] . ")";?>')" href="../sb/del_ticket_passenger.php?ip=<?php echo $row_isnp['ip_id']; ?>&id=<?php echo $colname_tr;?>">X</a></li>
           			    </ul></td>
                        </tr>
                        <?php $i++; } while ($row_isnp = mysql_fetch_assoc($isnp)); ?>
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_isnp ?>  rekod dijumpai</td>
                      </tr>
                    <?php } else { ?>
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                      </tr>
                    <?php }; ?>
                    </table>
                <div class="note">Senarai Penumpang Tanggungan (Bukan Kakitangan ISN)</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_nisnp > 0) { // Show if recordset not empty ?>
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
                        <td><ul class="func"><li><a onclick="return confirm('Anda mahu berikut dipadam? \r\n\n <?php echo $row_nisnp['nip_name']; ?> <?php if($row_nisnp['nip_noic']!=NULL) echo " " . $row_nisnp['nip_noic'];?> ')" href="../sb/del_ticket_passenger.php?nip=<?php echo $row_nisnp['nip_id']; ?>&id=<?php echo $colname_tr;?>">X</a></li></ul></td>
                      </tr>
                    <?php $i++; } while ($row_nisnp = mysql_fetch_assoc($nisnp)); ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_nisnp ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                <li class="title">Maklumat Tambahan</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle" nowrap="nowrap">Tambahan Bagasi</td>
                      <td nowrap="nowrap"><strong><?php echo getTiketBagasi($colname_tr);?></strong> kg</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" nowrap="nowrap">Insuran Perjalanan</td>
                      <td><?php if(getTiketInsuran($colname_tr)==1) echo "Ya"; else echo "Tidak";?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" nowrap="nowrap">Visa Perjalanan</td>
                      <td><?php if(getTiketVisa($colname_tr)==1) echo "Ya"; else echo "Tidak";?></td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Pengesahan Kelulusan</li>
                <?php if(!checkTiketApp($colname_tr)){?>
                <li class="gap">&nbsp;</li>
                <li>
                  <form id="form1" name="form1" method="POST" action="../sb/update_ticketapp.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Pengesahan</td>
                        <td><ul class="inputradio">
                          <li><input name="ticket_app" type="radio" value="1" checked /> Diluluskan</li>
                          <li><input name="ticket_app" type="radio" value="0" /> Tidak Diluluskan</li>
                        </ul></td>
                      </tr>
                      <tr>
                        <td class="label"> Oleh</td>
                        <td><ul class="inputradio">
                          <li><input name="ticket_appby" type="radio" value="1" checked /><?php echo getJob2Name('2');?></li>
                          <li><input name="ticket_appby" type="radio" value="2" /><?php echo getJob2Name('9');?></li>
                        </ul></td>
                      </tr>
                      <tr>
                        <td class="label">Tarikh Kelulusan</td>
                        <td>
                        <select name="ticket_appdate_d" id="ticket_appdate_d">
                        <?php for($i=1; $i<=31; $i++){?>
                        <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                        <?php }; ?>
                        </select>
                        <select name="ticket_appdate_m" id="ticket_appdate_m">
                        <?php for($j=1; $j<=12; $j++){?>
                        <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                        <?php }; ?>
                        </select>
                        <select name="ticket_appdate_y" id="ticket_appdate_y">
                        <?php for($k=(date('Y')+2); $k>=(date('Y')-2); $k--){?>
                        <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                        <?php }; ?>
                        </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">Catatan</td>
                        <td><textarea name="ticket_appnote" id="ticket_appnote" cols="45" rows="5"></textarea></td>
                      </tr>
                      <tr>
                        <td class="noline"><input type="hidden" name="MM_update" value="form1" />                          <input name="ticket_id" type="hidden" id="ticket_id" value="<?php echo $colname_tr;?>" /></td>
                        <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php } else { ?>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Pengesahan</td>
                      <td><strong><?php if(checkTiketAppOrNot($colname_tr)) echo "Diluluskan"; else echo "Tidak Diluluskan";?></strong> oleh <strong><?php if(getTiketAppBy($colname_tr)==1) echo getJob2Name('2'); else echo getJob2Name('9')?></strong></td>
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
                    <tr>
                      <td colspan="2" class="txt_line noline"><div class="inputlabel2">Dikemaskini oleh <?php echo getFullNameByStafID(getAppUpdateByTiketApp($colname_tr)) . " (" . getAppUpdateByTiketApp($colname_tr) . ")";?> pada <?php echo getAppUpdateDateTiketApp($colname_tr);?></div></td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <?php }; ?>
                <?php if(checkTiketApp($colname_tr) && checkTiketAppOrNot($colname_tr)){?>
                <li class="title">Maklumat Tiket</li>
                <?php if(!checkTiketInv($colname_tr)){?>
                <li class="gap">&nbsp;</li>
                <li>
                  <?php if ($totalRows_ag > 0) { // Show if recordset not empty ?>
                  <form id="form2" name="form2" method="post" action="../sb/update_ticketinfo.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td> 
                        <td colspan="3">
                          <select name="ticket_invdate_d" id="ticket_invdate_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="ticket_invdate_m" id="ticket_invdate_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="ticket_invdate_y" id="ticket_invdate_y">
                            <?php for($k=(date('Y')+2); $k>=(date('Y')-2); $k--){?>
                            <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                      <td nowrap="nowrap" class="label">Syarikat Penerbangan</td>
                      <td colspan="3">
                      <select name="fly_type" id="fly_type">
                      <option value="0">Tiada</option>
                      <option value="1">Malaysia Airlines(MAS)</option>
                      <option value="2">AirAsia</option>
                      <option value="3">Lain-lain</option>
                      </select>
                      </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Agensi</td>
                        <td colspan="3">
                          <select name="agensi_id" id="agensi_id">
                            <?php
                                            do {  
                                            ?>
                            <option value="<?php echo $row_ag['agensi_id']?>"><?php echo $row_ag['agensi_name']?></option>
                            <?php
                                            } while ($row_ag = mysql_fetch_assoc($ag));
                                              $rows = mysql_num_rows($ag);
                                              if($rows > 0) {
                                                  mysql_data_seek($ag, 0);
                                                  $row_ag = mysql_fetch_assoc($ag);
                                              }
                                            ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Rujukan Tiket *</td>
                        <td colspan="3">
                          <span id="ref">
                            <span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                            <input name="ticket_invref" type="text" class="w35" id="ticket_invref" />
                            <div class="inputlabel2">Diperlukan oleh pemohon untuk menuntut tiket dikaunter perlepasan</div>
                            </span>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Jenis Pembayaran</td>
                        <td nowrap="nowrap">
                          <ul class="inputradio">
                            <li><input name="ticket_type" type="radio" id="ticket_type_0" value="1" checked="checked" />Waran</li>
                            <li><input name="ticket_type" type="radio" id="ticket_type_1" value="2" />Invois</li>
                          </ul>
                        </td>
                        <td nowrap="nowrap" class="label">No. Rujukan</td>
                        <td width="100%"><input name="ticket_typeref" type="text" class="w30" id="ticket_typeref" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Jumlah Kos *</td>
                        <td colspan="3">
                          <span id="kos">
                            <span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                            <div class="inputlabel">RM </div>
                            <input name="ticket_invcost" type="text" class="w35" id="ticket_invcost" />
                            <div class="inputlabel2">Merujuk pada Invois yang dihantar</div>
                            </span>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3"><textarea name="ticket_invnote" id="ticket_invnote" cols="45" rows="5"></textarea></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="noline">
                          <input type="hidden" name="MM_update" value="form1" />
                          <input name="ticket_id" type="hidden" id="ticket_id" value="<?php echo $colname_tr;?>" />
                        </td>
                        <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Kemaskini" /></td>
                      </tr>
                    </table>
                  </form>
                  <?php } else { ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline"><img src="<?php echo $url_main;?>icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>Agensi</strong> terlebih dahulu.</td>
                    </tr>
                  </table>
                  <?php };?>
                </li>
                <?php } else { ?>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                    <tr>
                      <td class="label">No. Rujukan Tiket</td>
                      <td><?php echo getTiketInvRef($colname_tr);?></td>
                    </tr>
                    <tr>
                      <td class="label">Jenis Pembayaran</td>
                      <td><?php echo getTiketTypeName(getTiketTypeWI($colname_tr));?><?php if(getTiketTypeRef($colname_tr)!=NULL) echo " &nbsp; &bull; &nbsp; No. Rujukan : " . getTiketTypeRef($colname_tr);?></td>
                    </tr>
                    <tr>
                      <td class="label">Jumlah Kos</td>
                      <td>RM <?php echo number_format(getTiketInvCost($colname_tr),2);?></td>
                    </tr>
                    <?php if(getTiketInvNote($colname_tr)!=NULL){?>
                    <tr>
                      <td class="label">Catatan</td>
                      <td><?php echo getTiketInvNote($colname_tr);?></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="txt_line noline"><div class="inputlabel2">Dikemaskini oleh <?php echo getFullNameByStafID(getTiketInvUpdateByTiketApp($colname_tr)) . " (" . getTiketInvUpdateByTiketApp($colname_tr) . ")";?> pada <?php echo getTiketInvUpdateDateTiketApp($colname_tr);?></div></td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <?php }; ?>
                <li class="gap">&nbsp;</li>
                <?php }; ?>
                <?php /*
                <li class="title">Maklum Balas<span class="fr add">Tambah</span></li>
                <li>
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td align="center" valign="top"><?php echo viewProfilePic($row_user['user_stafid']);?></td>
                	    <td width="100%">&nbsp;</td>
              	    </tr>
              	  </table>
                </li>
                <li class="back_darkgrey">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">Oleh : pada </td>
                    </tr>
                  </table>
                </li>
				*/ ?>
            <?php } else { ?>
                <li>
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td align="center" valign="middle" class="noline"><?php echo noteError();?></td>
              	    </tr>
              	  </table>
                </li>
            <?php }; ?>
            </ul>
            </div>
        </div>
        <?php echo noteFooter('1'); ?>
        <?php echo noteEmail('1'); ?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>

<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("ref");
var sprytextfield2 = new Spry.Widget.ValidationTextField("kos");
var sprytextfield3 = new Spry.Widget.ValidationTextField("to2");
var sprytextfield4 = new Spry.Widget.ValidationTextField("from2");
</script>

<?php }; ?>

</body>
</html>
<?php
mysql_free_result($tr);

mysql_free_result($isnp);

mysql_free_result($nisnp);

mysql_free_result($ag);
?>
<?php include('../inc/footinc.php');?> 