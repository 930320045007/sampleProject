<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php $menu='17';?>
<?php $menu2='87';?>
<?php
$id = "-1";
if (isset($_GET['id'])) {
  $id = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
}
	
mysql_select_db($database_financedb, $financedb);
$query_jkb = "SELECT * FROM finance.jkb WHERE jkb_id = '" . $id . "' AND user_stafid = '" . $row_user['user_stafid'] . "' AND jkb_status = 1";
$jkb = mysql_query($query_jkb, $financedb) or die(mysql_error());
$row_jkb = mysql_fetch_assoc($jkb);
$totalRows_jkb = mysql_num_rows($jkb);

mysql_select_db($database_financedb, $financedb);
$query_apply = "SELECT * FROM finance.apply WHERE apply_status = '1' AND jkb_id = '" . $id . "' ORDER BY apply_id ASC";
$apply = mysql_query($query_apply, $financedb) or die(mysql_error());
$row_apply = mysql_fetch_assoc($apply);
$totalRows_apply = mysql_num_rows($apply);
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
     <?php include('../inc/menu_fin_user.php');?>
        <div class="tabbox">
          <div class="profilemenu">
           <div class="note">Maklumat permohonan Jawatankuasa Bantuan Pelaksanaan Program / Aktiviti Institut Sukan Negara <strong><?php if($row_jkb['bil_id']!=0) echo getBilNoByBilID(getBilIDByJkbID($row_jkb['jkb_id']));?></strong></div></li>
                <ul>
                	<li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="label">Kategori</td>
                          <td><?php echo getCategory($row_jkb['jkb_id']); ?></td>
                        </tr>
                        <tr>
                          <td nowrap="nowrap" class="label">Cawangan / <br />
      Pusat / Unit</td>
                          <td><?php echo getFullDirectory(getDirIDByJkbID($row_jkb['jkb_id'])); ?></td>
                        </tr>

                        <tr>
                          <td class="label">No. Rujukan</td>
                          <td><?php echo $row_jkb['jkb_ref']; ?></td>
                        </tr>
                        <tr>
                          <td class="label">Aktiviti</td>
                          <td><?php echo $row_jkb['jkb_activity']; ?></td>
                        </tr>
                        <tr>
                          <td class="label">Perihal</td>
                          <td><?php if($row_jkb['jkb_detail']!=NULL) echo $row_jkb['jkb_detail']; else echo '-';?></td>
                        </tr>
                      </table>
                    </li>
                    <li class="gap">&nbsp;</li>
                	<li class="title">Maklumat Permohonan</li>
                    <li class="gap">&nbsp;</li>
                    <li>
  					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php if ($totalRows_apply > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th nowrap="nowrap">Bil</th>
                          <th align="left" nowrap="nowrap">Deskripsi/Perbelanjaan Dipohon</th>
                          <th width="50%" align="center" valign="middle" nowrap="nowrap">Kuantiti</th>
                           <th align="left" nowrap="nowrap">Pengiraan </th>
                          <th width="50%" align="center" valign="middle" nowrap="nowrap">Jumlah (RM)</th>
                          <th width="50%" align="center" valign="middle" nowrap="nowrap">Status</th>
                          <th width="50%" align="center" valign="middle" nowrap="nowrap">Catatan</th>
                        </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td><?php echo $i;?></td>
                            <td align="left" nowrap="nowrap"><?php echo $row_apply['apply_description']; ?></td>
                            <td align="center" nowrap="nowrap"><?php echo $row_apply['apply_quantity']; ?></td>
                            <td align="left" nowrap="nowrap"><?php echo $row_apply['apply_calculation']; ?></td>
                            <td align="center" nowrap="nowrap"><?php if($row_apply['applystatus_id']==2) echo "( - ) "  . number_format($row_apply['apply_amount'],2); else echo number_format($row_apply['apply_amount'],2); ?></td>
                             <td align="left" valign="middle" nowrap="nowrap">
							<?php if($row_apply['applystatus_id']==0) echo "Dalam Proses"; else echo getStatusNameByID(getStatusByID($row_apply['apply_id']));?>
                        </td>
                             <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_apply['fin_note'];?>
                        </tr>
                          <?php $i++; } while ($row_apply = mysql_fetch_assoc($apply)); ?>
                           <tr>
                        <td colspan="4" align="right"></td>
                        <td align="center" class="back_darkgrey"><strong><?php echo number_format(getActualTotalAmountByJkbID($row_jkb['jkb_id']),2);?></strong></td>
                      </tr> 
                        <tr>
                          <td colspan="7" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_apply ?> rekod dijumpai</td>
                        </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="7" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
                    </li>
                    <li class="gap">&nbsp;</li>
                    <?php if (getAmountByJkbID($id)<5000 && $row_jkb['jkb_appby']==0){ ?>
                    <li class="form_back">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">Bersama-sama ini disertakan dokumen-dokumen untuk permohonan kelulusan Pengarah Bahagian :</td>
                    </tr>
                    <tr>
                      <td class="noline txt_line">
                      <ol>
                      	<li>Borang Permohonan Jawatankuasa Bantuan Pelaksanaan Program / Aktiviti ISN (Sila klik pada butang 'Cetak' dibawah)</li>
                    	<li>Dokumen sokongan yang berkaitan dengan permohonan JKB</li> 
                      </ol>
                      </td>
                    </tr>
                    <tr>
                      <td><input name="button3" type="button" class="submitbutton" id="button3" value="Cetak" onClick="MM_openBrWindow('printJKB.php?id=<?php echo getID($id);?>','jkbprint','scrollbars=yes,width=930,height=600')" /></td>
                    </tr>
                  </table>
                </li>
                    <?php }; 
					 if(getAmountByJkbID($id)>=5000 && $row_jkb['classification']==0){?>
                    <form id="form1" name="form1" method="POST" action="../sb/update_classification.php">
                    <li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="left" valign="middle" class="label">Klasifikasi Permohonan</td>
                            <td align="left" valign="middle" nowrap="nowrap" class="noline">
                                <ul class="inputradio">
                                    <li><input name="classification" type="radio" value="1" /> Biasa</li>
                                    <li><input name="classification" type="radio" value="2" checked="checked" /> Segera</li>
                                      <li class="gap">&nbsp;</li>
                              </ul>
                     </td>
                        <td width="80%" class="noline"><input type="hidden" name="MM_update" value="form1" /> 
                        <input name="jkb_id" type="hidden" id="jkb_id" value="<?php echo $id;?>" /><input name="button5" type="submit" class="submitbutton" id="button5" value="Hantar" /></td>
                        </tr>
                      </table>
                    </li>
                    </form>
                    <?php }; 
					if($row_jkb['classification']==2 && $row_jkb['jkb_appby']==0){?>
                     <li class="form_back">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">Bersama-sama ini disertakan dokumen-dokumen untuk permohonan kelulusan  Ketua Pengarah Eksekutif (KPE):</td>
                    </tr>
                    <tr>
                      <td class="noline txt_line">
                      <ol>
                      	<li>Borang Permohonan Jawatankuasa Bantuan Pelaksanaan Program / Aktiviti ISN (Sila klik pada butang 'Cetak' dibawah)</li>
                    	<li>Dokumen sokongan yang berkaitan dengan permohonan JKB</li> 
                      </ol>
                      </td>
                    </tr>
                    <tr>
                      <td><input name="button3" type="button" class="submitbutton" id="button3" value="Cetak" onClick="MM_openBrWindow('printJKB.php?id=<?php echo getID($id);?>','jkbprint','scrollbars=yes,width=930,height=600')" /></td>
                    </tr>
                  </table>
                  </li>
                    <?php } else if($row_jkb['classification']==1 && $row_jkb['jkb_appby']==0){ ?>
                   <li class="form_back2 line_t">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline txt_line"><img src="../icon/lock.png" alt="Pending" width="16" height="16" border="0" align="absbottom"> &nbsp; Permohonan Jawatankuasa Bantuan Pelaksanaan Program / Aktiviti ISN ini akan di bawa masuk ke dalam Mesyuarat JKB untuk diputuskan kelulusan permohonan . Sebarang penukaran maklumat perlu dimaklumkan kepada <?php echo getDirSubName(getDirIDByMenuID($menu));?>.</td>
                    </tr>
                  </table>
                </li>
                
                   <?php } else if($row_jkb['jkb_appby']!=NULL){?>
                     <li class="title">Pengesahan</li>
                    <li class="form_back2 line_t">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Pengesahan oleh</td>
                      <td><strong><?php if(getJKBAppBy($id)==1) echo getJob2Name('2'); if (getJKBAppBy($id)==2) echo "Pengarah Bahagian"; if(getJKBAppBy($id)==3) echo "Ahli Mesyuarat"; ?></strong></td>
                    </tr>
                    <tr>
                      <td class="label">Tarikh</td>
                      <td><?php echo getJKBAppDate($id);?></td>
                    </tr>
                    <?php if(getJKBAppNote($id)!=NULL){?>
                    <tr>
                      <td class="label">Catatan</td>
                      <td><?php echo getJKBAppNote($id);?></td>
                    </tr>
                    <?php }; ?>
                    <tr>
                      <td colspan="2" class="txt_line noline"><div class="inputlabel2">Dikemaskini oleh <?php echo getFullNameByStafID(getAppUpdateByJKBApp($id)) . " (" . getAppUpdateByJKBApp($id) . ")";?> pada <?php echo getAppUpdateDateJKBApp($id);?></div></td>
                    </tr>
                  </table>
                     
           		  </li>
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
mysql_free_result($jkb);

mysql_free_result($apply);
?>
<?php include('../inc/footinc.php');?> 