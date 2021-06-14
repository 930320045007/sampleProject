<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='27';?>
<?php
if(isset($_GET['id']))
	$wsql = " AND userborrow_id='" . htmlspecialchars($_GET['id'], ENT_QUOTES) . "'";
else
	$wsql = " AND userborrow_id='-1'";
	
mysql_select_db($database_ictdb, $ictdb);
$query_loan = "SELECT * FROM ict.user_borrow WHERE userborrow_status = 1 " . $wsql . " ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
$loan = mysql_query($query_loan, $ictdb) or die(mysql_error());
$row_loan = mysql_fetch_assoc($loan);
$totalRows_loan = mysql_num_rows($loan);

mysql_select_db($database_ictdb, $ictdb);
$query_itemborrow = "SELECT item_borrow.* FROM ict.item_borrow WHERE user_stafid = '" . $row_loan['user_stafid'] . "' AND userborrow_id = '" . $row_loan['userborrow_id'] . "' AND itemborrow_status = '1' ORDER BY itemborrow_id ASC";
$itemborrow = mysql_query($query_itemborrow, $ictdb) or die(mysql_error());
$row_itemborrow = mysql_fetch_assoc($itemborrow);
$totalRows_itemborrow = mysql_num_rows($itemborrow);

mysql_select_db($database_ictdb, $ictdb);
$query_subcat2 = "SELECT subcategory.subcategory_id, subcategory.subcategory_name FROM ict.item LEFT JOIN ict.subcategory ON subcategory.subcategory_id = item.subcategory_id WHERE item_borrow = 1 AND item_status = '1' GROUP BY subcategory_id ORDER BY subcategory.subcategory_name ASC";
$subcat2 = mysql_query($query_subcat2, $ictdb) or die(mysql_error());
$row_subcat2 = mysql_fetch_assoc($subcat2);
$totalRows_subcat2 = mysql_num_rows($subcat2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){ ?>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td rowspan="2" align="center" valign="top" nowrap="nowrap" class="noline"><?php echo viewProfilePic($row_loan['user_stafid']);?></td>
                      <td nowrap="nowrap" class="label">Peminjam</td>
                      <td colspan="3" width="100%"><div class="txt_line"><strong><?php echo getFullNameByStafID($row_loan['user_stafid']) . " (" . $row_loan['user_stafid'] . ")"; ?></strong><br/><div><?php echo getFulldirectoryByUserID($row_loan['user_stafid']);?></div></div></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Email</td>
                      <td width="50%" class="noline"><?php echo getEmailISNByUserID($row_loan['user_stafid']);?></td>
                      <td nowrap="nowrap" class="label noline">Ext</td>
                      <td width="50%" class="noline"><?php echo getExtNoByUserID($row_loan['user_stafid']);?></td>
                    </tr>
                  </table>
                </li>
      <li class="gap">&nbsp;</li>
                <li class="title">Maklumat Tempahan</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Tujuan</td>
                      <td colspan="3"><?php echo $row_loan['userborrow_title']; ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Lokasi</td>
                      <td colspan="3"><?php echo $row_loan['userborrow_location']; ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Tarikh</td>
                      <td width="50%"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_loan['userborrow_date_m'], $row_loan['userborrow_date_d'], $row_loan['userborrow_date_y'])); ?></td>
                      <td nowrap="nowrap" class="label">Masa</td>
                      <td width="50%"><?php echo $row_loan['userborrow_time_h'];?>.<?php if($row_loan['userborrow_time_m']==0) echo "0" . $row_loan['userborrow_time_m']; else echo $row_loan['userborrow_time_m']; ?> <?php echo $row_loan['userborrow_time_ap']; ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Tempoh</td>
                      <td colspan="3"><?php echo getDurationByUserBorrowID($row_loan['userborrow_id']);?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Catatan</td>
                      <td colspan="3" class="noline"><?php echo $row_loan['userborrow_note']; ?></td>
                    </tr>
                  </table>
          </li>
                <li class="gap">&nbsp;</li>
    <li class="title">Maklumat Item <?php if($row_loan['ict_return']==0 && $row_loan['ict_status']==1){?><span class="fr add" onclick="toggleview2('formitemborrow'); return false;">+ Tambah</span><?php };?></li>
                <?php if($row_loan['ict_return']==0 && $row_loan['ict_status']==1){?>
                <div id="formitemborrow" class="hidden">
                <li>
                  <form id="form4" name="form4" method="post" action="../sb/add_itemborrowadd.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Item</td>
                        <td width="100%" nowrap="nowrap" class="noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_loan['user_stafid'];?>" />
                          <input name="itemborrow_note" type="hidden" id="itemborrow_note" value="Ditambah oleh <?php echo getFullNameByStafID($row_user['user_stafid']) . " (" . $row_user['user_stafid'] . ")";?> " />
                          <select name="subcategory_id" id="subcategory_id" onChange="dochange('7', 'item_id', this.value, '0');">
                          	<option value="0">Sila pilih Kategori</option>
                            <?php
							do {  
							?>
                            <?php if(getTotalItemCanBorrow($row_subcat2['subcategory_id'])>0){?>
                            <option value="<?php echo $row_subcat2['subcategory_id']?>"><?php echo $row_subcat2['subcategory_name']?></option>
                            <?php }; ?>
                            <?php
							} while ($row_subcat2 = mysql_fetch_assoc($subcat2));
							  $rows = mysql_num_rows($subcat2);
							  if($rows > 0) {
								  mysql_data_seek($subcat2, 0);
								  $row_subcat2 = mysql_fetch_assoc($subcat2);
							  }
							?>
                          </select>
                          <select name="item_id" id="item_id">
                          	<option value="0">Sila pilih Kategori</option>
                        </select>
                        <label for="textfield"></label>
                        <input name="button7" type="submit" class="submitbutton" id="button7" value="Tambah" />
                        <input name="userborrow_id" type="hidden" id="userborrow_id" value="<?php echo $row_loan['userborrow_id']; ?>" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
            </div>
            <?php }; ?>
                <li class="gap">&nbsp;</li>
<li>
                  <form id="form2" name="form2" method="post" action="../sb/update_itemborrow.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php if ($totalRows_itemborrow > 0) { // Show if recordset not empty ?>
                      <tr>
                        <th align="center" valign="middle">Bil</th>
                        <th align="left" valign="middle">Item</th>
                        <th align="left" valign="middle">No. Siri MSN</th>
                        <th align="left" valign="middle" class="w50">Catatan</th>
                        <th>&nbsp;</th>
                      </tr>
                      <?php $i=1; do { ?>
                      <?php
                        mysql_select_db($database_ictdb, $ictdb);
						$query_subcat = "SELECT item.item_id, item.item_isnsiri, item_nosiri, item.brand_id, item.item_model FROM ict.item LEFT JOIN ict.subcategory ON subcategory.subcategory_id = item.subcategory_id WHERE item_borrow = 1 AND item_status = '1' AND item.subcategory_id = '" . $row_itemborrow['subcategory_id'] . "' AND NOT EXISTS (SELECT * FROM ict.item_borrow LEFT JOIN ict.user_borrow ON user_borrow.userborrow_id = item_borrow.userborrow_id WHERE item_borrow.item_id = item.item_id AND item_borrow.itemborrow_status = 1 AND item_borrow.ict_return != 1 AND user_borrow.ict_status != 2) ORDER BY subcategory.subcategory_name ASC";
						$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
						$row_subcat = mysql_fetch_assoc($subcat);
						$totalRows_subcat = mysql_num_rows($subcat);
						?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td nowrap="nowrap"><?php echo getItemCategoryBySubCatID($row_itemborrow['subcategory_id']) . " &nbsp; &bull; &nbsp; " . getItemSubCategoryByID($row_itemborrow['subcategory_id']); ?></td>
                        <td>
                        <?php if($row_loan['ict_item']==0 && $row_loan['ict_status']==1 && $row_itemborrow['item_id']==0){?>
                        <input name="itemborrow_id[]" type="hidden" id="itemborrow_id[]" value="<?php echo $row_itemborrow['itemborrow_id']; ?>" />
                        <select name="item_id[]" id="item_id[]">
                          <?php do { ?>
                        <option value="<?php echo $row_subcat['item_id'];?>"><?php echo getItemISNSiriByID($row_subcat['item_id']) . " &nbsp; &bull; &nbsp; " . getItemBrandNameByID($row_subcat['brand_id']) . " " . $row_subcat['item_model'];?></option>
                            <?php } while ($row_subcat = mysql_fetch_assoc($subcat)); ?>
                        </select>
                      	<?php mysql_free_result($subcat); ?>
                        <?php } else if($row_loan['ict_status']!=2 && $row_loan['ict_status']==1 && $row_itemborrow['item_id']!=0){?>
                        <?php echo getItemISNSiriByID($row_itemborrow['item_id']) . " &nbsp; &bull; &nbsp; " . getItemBrandNameByItemID($row_itemborrow['item_id']) . " " . getModelByItemID($row_itemborrow['item_id']);?>
                        <?php }; ?>
                        </td>
                        <td align="left" valign="middle">
                        <?php if($row_loan['ict_item']==0 && $row_loan['ict_status']==1 && $row_itemborrow['itemborrow_note']==NULL){?>
                        <input type="text" name="itemborrow_note[]" id="itemborrow_note[]" />
                        <?php } else if($row_loan['ict_status']!=2){?>
						<?php echo $row_itemborrow['itemborrow_note']; ?>
                        <?php };?>
                        </td>
                        <td><?php if($row_loan['ict_item']==0 && $row_loan['ict_return']==0 && $row_loan['ict_status']==1){?>
                        <ul class="func">
                          <li>
                          <a onclick="return confirm('Anda mahu maklumat item berikut dipadam? \r\n\n <?php echo getItemCategoryBySubCatID($row_itemborrow['subcategory_id']) . " " . getItemSubCategoryByID($row_itemborrow['subcategory_id']); ?>')" href="../sb/del_itemborrow.php?delitemborrow=<?php echo $row_itemborrow['itemborrow_id']; ?>&amp;id=<?php echo $row_loan['userborrow_id']; ?>">X</a>
                          </li>
                        </ul>
                        <?php }; ?></td>
                      </tr>
                      <?php $i++; } while ($row_itemborrow = mysql_fetch_assoc($itemborrow)); ?>
                      <?php if($row_loan['ict_item']==0 && $row_loan['ict_status']==1){?>
                      <tr>
                        <td class="noline">&nbsp;</td>
                        <td class="noline"><input name="id" type="hidden" id="id" value="<?php echo $row_loan['userborrow_id']; ?>" />                          <input name="ict_item" type="hidden" id="ict_item" value="1" /></td>
                        <td class="noline"><input name="button5" type="submit" class="submitbutton" id="button5" value="Simpan" /></td>
                        <td class="noline">&nbsp;</td>
                        <td class="noline">&nbsp;</td>
                      </tr>
                      <?php }; ?>
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_itemborrow ?> rekod dijumpai</td>
                      </tr>
                      <?php } else { ?>
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                      </tr>
                      <?php }; ?>
                    </table>
                  </form>
                </li>
                <?php if($row_loan['ict_status']==0){?>
                <li class="form_back2 line_t">
                  <form id="form1" name="form1" method="post" action="../sb/update_userborrow.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Kelulusan?</td>
                        <td width="100%">
                        <ul class="inputradio">
                            <li><input name="ict_status" type="radio" id="ict_status_0" value="1" checked="checked" />Ya</li>
                            <li><input type="radio" name="ict_status" value="2" id="ict_status_1" />Tidak</li>
                        </ul>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">Pengesahan tempahan berdasarkan maklumat yang dinyatakan seperti diatas oleh <strong><?php echo getFullNameByStafID($row_user['user_stafid']) . " (" . $row_user['user_stafid'] . ")";?></strong> dengan catatan</td>
                      </tr>
                      <tr>
                        <td colspan="2">
                        <textarea name="ict_note" rows="7" id="ict_note"></textarea>
                        <div class="inputlabel2">Catatan ini akan dinyatakan dalam email</div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <input name="id" type="hidden" id="id" value="<?php echo $row_loan['userborrow_id']; ?>" />
                          <input name="button3" type="submit" class="submitbutton" id="button3" value="Hantar" />
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" /></td>
                      </tr>
                    </table>
                  </form>
              </li>
                <?php } else if($row_loan['ict_status']==1){?>
                <li class="gap">&nbsp;</li>
<li class="form_back2 line_t">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>Pengesahan tempahan berdasarkan maklumat yang dinyatakan seperti diatas <strong>DILULUSKAN</strong> pada <strong><?php echo $row_loan['ict_date']; ?></strong></td>
                      </tr>
                    <tr>
                      <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center" valign="top"><?php echo viewProfilePic($row_loan['ict_by']);?></td>
                          <td width="100%" class="txt_line">
                          <div class="txt_size2">Diluluskan oleh</div>
                          <div><strong><?php echo getFullNameByStafID($row_loan['ict_by']) . " (" . $row_loan['ict_by'] . ")"; ?></strong></div>
                          <div><?php echo getFulldirectoryByUserID($row_loan['ict_by']);?></div>
                          </td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                    <?php if($row_loan['ict_note']!=NULL){?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Catatan</td>
                      <td width="100%"><?php echo $row_loan['ict_note']; ?></td>
                    </tr>
                  </table>
                    <?php }; ?>
              </li>
              <?php if($row_loan['ict_return']==0 && $row_loan['ict_item']==1){?>
                <li class="form_back2 line_t">
                  <form id="form3" name="form3" method="post" action="../sb/update_userborrowreturn.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="2">Pengesahan penyerahan kembali item dengan kuantiti yang dinyatakan diatas dalam keadaan baik sebagaimana sewaktu penyerahan.</td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Penyerahan oleh</td>
                        <td width="100%">
                  <span id="penyerahanoleh"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                          <input name="ict_returnuser" type="text" class="w35" id="ict_returnuser" list="datastaf" />
                          <?php echo datalistStaf('datastaf');?>
                        <div class="inputlabel2">No Staf ID</div></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Diterima oleh</td>
                        <td><?php echo getFullNameByStafID($row_user['user_stafid']) . " (" . $row_user['user_stafid'] . ")"; ?></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td><?php echo date('d/m/Y h:i:s A');?></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td><label for="ict_returnnote"></label>
                        <textarea name="ict_returnnote" id="ict_returnnote" cols="45" rows="7"></textarea></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="noline"><input name="id" type="hidden" id="id" value="<?php echo $row_loan['userborrow_id']; ?>" /></td>
                        <td class="noline"><input name="button6" type="submit" class="submitbutton" id="button6" value="Hantar" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php } else if($row_loan['ict_item']==1){ ?>
                <li class="form_back2 line_t">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="2">Pengesahan penyerahan balik item pada <strong><?php echo $row_loan['ict_returndate']; ?></strong> dengan jumlah kuantiti yang dinyatakan diatas dalam keadaan baik sebagaimana sewaktu penyerahan.</td>
                      </tr>
                    <tr>
                      <td width="50%">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" valign="top"><?php echo viewProfilePic($row_loan['ict_returnuser']);?></td>
                            <td width="100%">
                            <div class="txt_size2">Penyerahan oleh</div>
                            <div><strong><?php echo getFullNameByStafID($row_loan['ict_returnuser']) . " (" . $row_loan['ict_returnuser'] . ")"; ?></strong></div>
                            <div><?php echo getFulldirectoryByUserID($row_loan['ict_returnuser']);?></div>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center" valign="top"><?php echo viewProfilePic($row_loan['ict_returnby']);?></td>
                          <td width="100%">
                            <div class="txt_size2">Diterima oleh</div>
                            <div><strong><?php echo getFullNameByStafID($row_loan['ict_returnby']) . " (" . $row_loan['ict_returnby'] . ")"; ?></strong></div>
                            <div><?php echo getFulldirectoryByUserID($row_loan['ict_returnby']);?></div></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                    <?php if($row_loan['ict_returnnote']!=NULL){?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Catatan</td>
                      <td colspan="2"><?php echo $row_loan['ict_returnnote']; ?></td>
                    </tr>
                  </table>
                    <?php }; ?>
        </li>
                <?php }; ?>
        <?php } else if($row_loan['ict_status']==2){ ?>
                <li class="form_back2 line_t">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Pengesahan tempahan berdasarkan maklumat yang dinyatakan seperti diatas <strong>TIDAK DILULUSKAN</strong> pada <strong><?php echo $row_loan['ict_date']; ?></strong></td>
                    </tr>
                    <tr>
                      <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center" valign="top"><?php echo viewProfilePic($row_loan['ict_by']);?></td>
                          <td width="100%" class="txt_line"><div class="txt_size2">Tidak diluluskan oleh</div>
                            <div><strong><?php echo getFullNameByStafID($row_loan['ict_by']) . " (" . $row_loan['ict_by'] . ")"; ?></strong></div>
                            <div><?php echo getFulldirectoryByUserID($row_loan['ict_by']);?></div></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                  <?php if($row_loan['ict_note']!=NULL){?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Catatan</td>
                      <td width="100%"><?php echo $row_loan['ict_note']; ?></td>
                    </tr>
                  </table>
                  <?php }; ?>
                </li>
                  <?php }; ?>
                <?php } else { ?>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
                  </tr>
                </table>
				</li>
                <?php }; ?>
            </ul>
            </div>
        </div>
        <?php echo noteEmail('1');?>
      </div>
        
		<?php include('../inc/footer.php');?>
  </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("penyerahanoleh");
</script>
</body>
</html>
<?php
mysql_free_result($subcat2);
mysql_free_result($loan);
mysql_free_result($itemborrow);
?>
<?php include('../inc/footinc.php');?> 