<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='58';?>
<?php
$colname_uskt = "-1";

if (isset($_GET['id'])) {
  $colname_uskt = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
}

mysql_select_db($database_skt, $skt);
$query_uskt = sprintf("SELECT * FROM user_skt WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND uskt_id = %s", GetSQLValueString($colname_uskt, "int"));
$uskt = mysql_query($query_uskt, $skt) or die(mysql_error());
$row_uskt = mysql_fetch_assoc($uskt);
$totalRows_uskt = mysql_num_rows($uskt);

mysql_select_db($database_skt, $skt);
$query_sktf = "SELECT * FROM sktfeedback WHERE sktf_status = 1 AND uskt_id = '" . $colname_uskt . "' ORDER BY sktf_id ASC";
$sktf = mysql_query($query_sktf, $skt) or die(mysql_error());
$row_sktf = mysql_fetch_assoc($sktf);
$totalRows_sktf = mysql_num_rows($sktf);

if(getFeedbackTypeSubIDLatestBySKTID($row_uskt['uskt_id'])>=100)
	$wsql = " AND feedbacktype_id != '3'";
else
	$wsql = "";

mysql_select_db($database_skt, $skt);
$query_ft = "SELECT * FROM feedbacktype WHERE feedbacktype_status = 1 AND (feedbacktype_view = 0 OR feedbacktype_view = 1) " . $wsql . " ORDER BY feedbacktype_id ASC";
$ft = mysql_query($query_ft, $skt) or die(mysql_error());
$row_ft = mysql_fetch_assoc($ft);
$totalRows_ft = mysql_num_rows($ft);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<?php include('../inc/liload.php');?>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
      	<?php include('../inc/menu_skt.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <div class="note">Sasaran Kerja Tahunan bagi tahun <?php echo $row_uskt['uskt_date_y']; ?></div>
            <ul>
                <li class="title">Aktiviti / Projek / Keterangan </li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="txt_line noline" width="100%"><?php echo $row_uskt['uskt_aktiviti']; ?></td>
                      <?php if(getSKTTahun($row_uskt['uskt_id'])==date('Y') && !checkFeedbackCancel($row_uskt['uskt_id']) && !checkFeedbackLatest(0, $row_uskt['uskt_id'], 0)){?>
                      <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Edit" onClick="MM_goToURL('parent','sktedit.php?id=<?php echo $_GET['id'];?>');return document.MM_returnValue" /></td>
                      <?php }; ?>
                    </tr>
                  </table>
                  </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Petunjuk Pretasi </li>
                <li class="gap">&nbsp;</li>
                <li>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th nowrap>&nbsp;</th>
                      <th width="50%" align="left" valign="middle" nowrap>Penerangan</th>
                      <th width="50%" align="left" valign="middle" nowrap>Sasaran Kerja</th>
                    </tr>
                    <tr class="on">
                      <td nowrap="nowrap" class="label">Kuantiti</td>
                      <td align="left" valign="middle" class="txt_line"><?php echo $row_uskt['uskt_kuantiti']; ?></td>
                      <td align="left" valign="middle" class="txt_line"><?php echo $row_uskt['uskt_kuantiti_sk']; ?></td>
                    </tr>
                    <tr class="on">
                      <td nowrap="nowrap" class="label">Masa</td>
                      <td align="left" valign="middle" class="txt_line"><?php echo $row_uskt['uskt_masa']; ?></td>
                      <td align="left" valign="middle" class="txt_line"><?php echo $row_uskt['uskt_masa_sk']; ?></td>
                    </tr>
                    <tr class="on">
                      <td nowrap="nowrap" class="label">Tempoh</td>
                      <td align="left" valign="middle" class="txt_line">&nbsp;</td>
                      <td align="left" valign="middle" class="txt_line"><?php echo date('M Y', mktime(0, 0, 0, getSKTMasaMula($row_uskt['uskt_id']), 1, $row_uskt['uskt_date_y']));?> - <?php echo date('M Y', mktime(0, 0, 0, getSKTMasaTamat($row_uskt['uskt_id']), 1, $row_uskt['uskt_date_y']));?> &nbsp; (<?php echo getSKTTempoh($row_uskt['uskt_id']);?> Bulan)</td>
                    </tr>
                    <tr class="on">
                      <td nowrap="nowrap" class="label">Kualiti</td>
                      <td align="left" valign="middle" class="txt_line"><?php echo $row_uskt['uskt_kualiti']; ?></td>
                      <td align="left" valign="middle" class="txt_line"><?php echo $row_uskt['uskt_kualiti_sk']; ?></td>
                    </tr>
                    <tr class="on">
                      <td nowrap="nowrap" class="label">Kos</td>
                      <td align="left" valign="middle" class="txt_line"><?php echo $row_uskt['uskt_kos']; ?></td>
                      <td align="left" valign="middle" class="txt_line"><?php echo $row_uskt['uskt_kos_sk']; ?></td>
                    </tr>
                    <tr class="on">
                      <td nowrap="nowrap" class="label">Lain-lain</td>
                      <td align="left" valign="middle" class="txt_line"><?php echo $row_uskt['uskt_lain']; ?></td>
                      <td align="left" valign="middle" class="txt_line"><?php echo $row_uskt['uskt_lain_sk']; ?></td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Maklum Balas <?php if(getSKTTahun($row_uskt['uskt_id'])==date('Y') && getFeedbackTypeSubIDLatestBySKTID($row_uskt['uskt_id'])<100 && !checkFeedbackCancel($row_uskt['uskt_id'])){?><span class="fr add" onClick="toggleview2('forminfeedback'); return false;">+ Tambah</span><?php }; ?></li>
                <?php if(getSKTTahun($row_uskt['uskt_id'])==date('Y') && getFeedbackTypeSubIDLatestBySKTID($row_uskt['uskt_id'])<100 && !checkFeedbackCancel($row_uskt['uskt_id'])){?>
                <div id="forminfeedback" class="hidden">
                  <li>
                      <form id="form2" name="form2" method="POST" action="../sb/add_sktfeedback.php">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td nowrap="nowrap" class="label noline">Kategori</td>
                            <td width="100%" class="noline" >
                              <select name="feedbacktype_id" id="feedbacktype_id" onChange="dochange('15', 'sktf_sub', this.value, '<?php echo $row_uskt['uskt_id'];?>');">
                                <?php
                                do {  
                                ?>
                                <?php if($row_ft['feedbacktype_id']!='5' || ($row_ft['feedbacktype_id']=='5' && getSKTMasaTamat($row_uskt['uskt_id'])!=12)){?>
                                	<option value="<?php echo $row_ft['feedbacktype_id']?>"><?php echo $row_ft['feedbacktype_name']?></option>
                                <?php }; ?>
                                <?php
                                } while ($row_ft = mysql_fetch_assoc($ft));
                                  $rows = mysql_num_rows($ft);
                                  if($rows > 0) {
                                      mysql_data_seek($ft, 0);
                                      $row_ft = mysql_fetch_assoc($ft);
                                  }
                                ?>
                            </select>
                            <select name="sktf_sub" id="sktf_sub">
                                <option value="0">&laquo; Sila pilih kategori</option>
                            </select>
                            </td>
                          </tr>
                          <tr>
                            <td nowrap="nowrap" class="label noline">Catatan *</td>
                            <td class="noline">
                            <span id="c"><span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                              <textarea name="sktf_note" id="sktf_note" cols="45" rows="5"></textarea>
                            </span>
                            </td>
                          </tr>
                          <tr>
                            <td nowrap="nowrap" class="label noline">&nbsp;</td>
                            <td class="noline"><span id="pengesahan">
                            <span class="fl w10"><input type="checkbox" name="sah" id="sah" /></span>
                              <span class="w70 fl"><span class="checkboxRequiredMsg">Sila buat pengesahan.<br/></span>Saya ambil maklum bahawa setiap perkara yang dikemaskini telah dibincangkan bersama Pegawai Penilai Pertama (PPP)</span>
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td nowrap="nowrap" class="noline">
                            <input name="uskt_id" type="hidden" id="uskt_id" value="<?php echo $colname_uskt; ?>" />
                            <input type="hidden" name="MM_insert" value="form2" />
                            </td>
                            <td class="noline">
                            <input name="button4" type="submit" class="submitbutton" id="button4" value="Hantar" />
                            <input name="button5" type="button" class="cancelbutton" id="button5" value="Kembali" onClick="toggleview2('forminfeedback'); return false;" />
                            </td>
                          </tr>
                        </table>
                    </form>
                </li>
                </div>
                <?php }; ?>
                <?php if ($totalRows_sktf > 0) { // Show if recordset not empty ?>
                <?php do { ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="100" rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic($row_sktf['sktf_by']);?></td>
                      <td width="<?php if($row_sktf['feedbacktype_id']=='3') echo "85%"; else echo "100%"; ?>" class="noline"><strong><?php echo getFeedbackType($row_sktf['feedbacktype_id']); ?></strong>
					  <?php 
					  if($row_sktf['sktf_sub']!=NULL && $row_sktf['sktf_sub']!='0') { 
					  	if($row_sktf['feedbacktype_id']=='2' && $row_sktf['sktf_sub']!=NULL) 
							echo  " &nbsp; &bull; &nbsp; " . getPetunjukPretasi(getFeedbackTypeSub($row_sktf['sktf_id']));
						else if($row_sktf['feedbacktype_id']=='5' && $row_sktf['sktf_sub']!=NULL) 
							echo " &nbsp; &bull; &nbsp; " . getFeedbackTypeSub($row_sktf['sktf_id']) . " bulan"; 
						else if($row_sktf['feedbacktype_id']!='3' && $row_sktf['sktf_sub']!=NULL) 
							echo " &nbsp; &bull; &nbsp; " . getFeedbackTypeSub($row_sktf['sktf_id']);
					  }; ?>
                      </td>
                      <?php if($row_sktf['feedbacktype_id']=='3'){?>
                      <td width="100%" class="noline">
                        <div class="barcolor_red">
                            <div class="barcolor_blue" style="width: <?php echo getFeedbackTypeSub($row_sktf['sktf_id']);?>%;">&nbsp;</div>
                            <div class="barcolor_percent"><?php echo getFeedbackTypeSub($row_sktf['sktf_id']);?>%</div>
                        </div>
                        </td>
                      <?php }; ?>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="noline txt_line" <?php if($row_sktf['feedbacktype_id']=='3') echo "colspan=\"2\"";?>><?php echo $row_sktf['sktf_note']; ?></td>
                    </tr>
                  </table>
              </li>
                <li class="form_back2 line_b3">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Oleh <?php echo getPPType(getPPTypeByStafID($row_user['user_stafid'], $row_sktf['sktf_by']));?> : <strong><?php echo getFullNameByStafID($row_sktf['sktf_by']) . " (" . $row_sktf['sktf_by'] . ")"; ?></strong> &nbsp; &bull; &nbsp; <?php echo getFeedbackDate($row_sktf['sktf_id']);?></td>
                    </tr>
                  </table>
                </li>
              <?php } while ($row_sktf = mysql_fetch_assoc($sktf)); ?>
                <?php } else {?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle">Tiada rekod dijumpai</td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
            </ul>
            </div>
        </div>
        <?php echo noteFooter(1);?>
        <?php echo noteEmail('1'); ?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("c");
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("pengesahan");
</script>
</body>
</html>
<?php
mysql_free_result($uskt);

mysql_free_result($sktf);

mysql_free_result($ft);
?>
<?php include('../inc/footinc.php');?> 