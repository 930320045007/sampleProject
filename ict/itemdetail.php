<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='26';?>
<?php
	$colname_item = "-1";
	if (isset($_GET['id'])) {
	  $colname_item = htmlspecialchars($_GET['id'], ENT_QUOTES);
	}
	
	mysql_select_db($database_ictdb, $ictdb);
	$query_item = sprintf("SELECT * FROM ict.item WHERE item_id = %s ORDER BY item_id DESC", GetSQLValueString($colname_item, "int"));
	$item = mysql_query($query_item, $ictdb) or die(mysql_error());
	$row_item = mysql_fetch_assoc($item);
	$totalRows_item = mysql_num_rows($item);

	mysql_select_db($database_ictdb, $ictdb);
	$query_durtype = "SELECT * FROM ict.duration_type ORDER BY durationtype_id ASC";
	$durtype = mysql_query($query_durtype, $ictdb) or die(mysql_error());
	$row_durtype = mysql_fetch_assoc($durtype);
	$totalRows_durtype = mysql_num_rows($durtype);

	mysql_select_db($database_ictdb, $ictdb);
	$query_cat = "SELECT category.* FROM ict.category";
	$cat = mysql_query($query_cat, $ictdb) or die(mysql_error());
	$row_cat = mysql_fetch_assoc($cat);
	$totalRows_cat = mysql_num_rows($cat);

	mysql_select_db($database_ictdb, $ictdb);
	$query_subcat = "SELECT subcategory.* FROM ict.subcategory WHERE category_id='" . $row_item['category_id'] . "'";
	$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
	$row_subcat = mysql_fetch_assoc($subcat);
	$totalRows_subcat = mysql_num_rows($subcat);
  
	mysql_select_db($database_ictdb, $ictdb);
	$query_brandlist = "SELECT brand.* FROM ict.brand";
	$brandlist = mysql_query($query_brandlist, $ictdb) or die(mysql_error());
	$row_brandlist = mysql_fetch_assoc($brandlist);
	$totalRows_brandlist = mysql_num_rows($brandlist);

	mysql_select_db($database_ictdb, $ictdb);
	$query_vendor = "SELECT * FROM ict.vendor WHERE vendor_status = 1 ORDER BY vendor_name ASC";
	$vendor = mysql_query($query_vendor, $ictdb) or die(mysql_error());
	$row_vendor = mysql_fetch_assoc($vendor);
	$totalRows_vendor = mysql_num_rows($vendor);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
            
            <div class="note">Maklumat dan status item</div>
            <ul>
            	<li class="title">Urusan ICT <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?><span class="fr add" onClick="toggleview('itemupdate','fulldetail'); return false;">Kemaskini</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                <div id="itemupdate" class="hidden">
                <li>
                  <form id="form1" name="form1" method="post" action="../sb/add_ictitem.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">No. Siri MSN</td>
                        <td><span class="inputlabel">MSN/ICT/</span>
                          <select name="item_isnsirihi" id="item_isnsirihi">
                            <option value="H" <?php if (!(strcmp("H", $row_item['item_isnsirihi']))) {echo "selected=\"selected\"";} ?>>Harta Modal</option>
                            <option value="I" <?php if (!(strcmp("I", $row_item['item_isnsirihi']))) {echo "selected=\"selected\"";} ?>>Inventori</option>
                          </select>
                          <span class="inputlabel">/</span>
                          <select name="item_isnsiriyear" id="item_isnsiriyear">
                            <?php for($m=(date('Y')-10); $m<=date('Y'); $m++){?>
                            <option value="<?php echo $m;?>" <?php if (!(strcmp($row_item['item_isnsiriyear'], $m))) {echo "selected=\"selected\"";} ?>><?php echo $m;?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/</span>
                          <label for="item_isnsiri2"></label>
                          <input name="item_isnsiri" type="text" class="w35" id="item_isnsiri" value="<?php echo $row_item['item_isnsiri']; ?>" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Pinjaman</td>
                        <td><ul class="inputradio">
                          <li><input <?php if ($row_item['item_borrow']=="1") echo "checked=\"checked\""; ?> name="item_borrow" type="radio" id="pinjaman_0"  value="1" />Ya</li>
                          <li><input <?php if ($row_item['item_borrow']=="0") echo "checked=\"checked\""; ?> name="item_borrow" type="radio" id="pinjaman_1" value="0" />Tidak</li>
                        </ul></td>
                      </tr>
                      <tr>
                        <td class="label">Kategori *</td>
                        <td><span id="cat">
                          <span class="selectInvalidMsg">Sila pilih Kategori.</span><span class="selectRequiredMsg">Sila pilih Kategori.</span>
                          <select name="category_id" id="category_id" onChange="dochange('5', 'subcategory_id', this.value, '0');">
                            <option value="0">Pilih Kategori</option>
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_cat['category_id'];?>" <?php if (!(strcmp($row_cat['category_id'], $row_item['category_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_cat['category_name'];?></option>
                            <?php
                            } while ($row_cat = mysql_fetch_assoc($cat));
                              $rows = mysql_num_rows($cat);
                              if($rows > 0) {
                                  mysql_data_seek($cat, 0);
                                  $row_cat = mysql_fetch_assoc($cat);
                              }
                            ?>
                          </select>
                        <select name="subcategory_id" id="subcategory_id">
                            <option value="0" <?php if (!(strcmp(0, $row_item['subcategory_id']))) {echo "selected=\"selected\"";} ?>>Pilih Kategori</option>
                            <?php
							do {  
							?>
							<option value="<?php echo $row_subcat['subcategory_id']?>"<?php if (!(strcmp($row_subcat['subcategory_id'], $row_item['subcategory_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_subcat['subcategory_name']?></option>
														<?php
							} while ($row_subcat = mysql_fetch_assoc($subcat));
							  $rows = mysql_num_rows($subcat);
							  if($rows > 0) {
								  mysql_data_seek($subcat, 0);
								  $row_subcat = mysql_fetch_assoc($subcat);
							  }
							?>
                          </select>
                        </span></td>
                      </tr>
                      <tr>
                        <td class="label noline">Jenama *</td>
                        <td class="noline">
                          <span id="model"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <select name="brand_id" id="brand_id">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_brandlist['brand_id']?>" <?php if (!(strcmp($row_brandlist['brand_id'], $row_item['brand_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_brandlist['brand_name'];?></option>
                          <?php
							} while ($row_brandlist = mysql_fetch_assoc($brandlist));
							  $rows = mysql_num_rows($brandlist);
							  if($rows > 0) {
								  mysql_data_seek($brandlist, 0);
								  $row_brandlist = mysql_fetch_assoc($brandlist);
							  }
							?>
                        </select>
                          <input name="item_model" type="text" class="w50" id="item_model" value="<?php echo $row_item['item_model']; ?>" />
                        </span></td>
                      </tr>
                      <tr>
                        <td class="label noline">No. Siri</td>
                        <td class="noline"><label for="item_nosiri"></label>
                        <input name="item_nosiri" type="text" class="w50" id="item_nosiri" value="<?php echo $row_item['item_nosiri']; ?>" /></td>
                      </tr>
                      <tr>
                        <td class="label">Harga Perolehan *</td>
                        <td><span id="price"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="inputlabel">RM</span>
                          <input name="item_price" type="text" class="w50" id="item_price" value="<?php echo $row_item['item_price']; ?>" />
                        <div class="inputlabel2">Cth: 700.00</div></span></td>
                      </tr>
                      <tr>
                        <td class="label">Tarikh Diterima</td>
                        <td><select name="item_getdate_d" id="item_getdate_d">
                          <?php for($i=1; $i<=31; $i++){?>
                          <option value="<?php if($i<10) $i = "0" . $i; echo $i;?>" <?php if ($row_item['item_getdate_d']==$i) echo "selected=\"selected\""; ?>><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                          <span class="inputlabel">/</span>
                          <select name="item_getdate_m" id="item_getdate_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option value="<?php if($j<10) $j = "0" . $j; echo $j;?>" <?php if ($row_item['item_getdate_m']==$j) echo "selected=\"selected\""; ?>><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/</span>
                          <select name="item_getdate_y" id="item_getdate_y">
                            <?php for($k=(date('Y')-10); $k<=date('Y'); $k++){?>
                            <option value="<?php echo $k;?>" <?php if ($row_item['item_getdate_y']==$k) echo "selected=\"selected\""; ?>><?php echo $k;?></option>
                            <?php }; ?>
                          </select></td>
                      </tr>
                      <tr>
                        <td class="label">No. Pesanan Rasmi Kerajaan *</td>
                        <td><span id="nofile"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="item_nofile" type="text" class="w50" id="item_nofile" value="<?php echo $row_item['item_nofile']; ?>" />
                        <div class="inputlabel2">Rujuk No. Surat</div>
                        </span></td>
                      </tr>
                      <tr>
                        <td class="label">No. Ruj Kewangan  *</td>
                        <td>Maklumat diperlukan.</span>
                          <input name="item_voucher" type="text" class="w50" id="item_voucher" value="<?php echo $row_item['item_voucher']; ?>" />
                        <div class="inputlabel2">Rujuk No. Surat</div>
                        </span></td>
                      </tr>
                      <tr>
                        <td class="label">Tempoh Jaminan</td>
                        <td><select name="item_warranty" id="item_warranty">
                          <?php for($l=1; $l<=10; $l++){?>
                          <option value="<?php echo $l;?>" <?php if (!(strcmp($l, $row_item['item_warranty']))) {echo "selected=\"selected\"";} ?>><?php echo $l;?></option>
                          <?php }; ?>
                        </select>
                          <select name="warrantytype_id" id="warrantytype_id">
                            <?php do { ?>
                            <option value="<?php echo $row_durtype['durationtype_id']?>" <?php if (!(strcmp($row_durtype['durationtype_id'], $row_item['warrantytype_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_durtype['durationtype_name']?></option>
                            <?php
							} while ($row_durtype = mysql_fetch_assoc($durtype));
							  $rows = mysql_num_rows($durtype);
							  if($rows > 0) {
								  mysql_data_seek($durtype, 0);
								  $row_durtype = mysql_fetch_assoc($durtype);
							  }
							?>
                          </select></td>
                      </tr>
                      <tr>
                        <td class="label">Nama Pembekal</td>
                        <td><select name="vendor_id" id="vendor_id">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_vendor['vendor_id']?>"<?php if (!(strcmp($row_vendor['vendor_id'], $row_item['vendor_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_vendor['vendor_name']?></option>
                          <?php
							} while ($row_vendor = mysql_fetch_assoc($vendor));
							  $rows = mysql_num_rows($vendor);
							  if($rows > 0) {
								  mysql_data_seek($vendor, 0);
								  $row_vendor = mysql_fetch_assoc($vendor);
							  }
							?>
                        </select></td>
                      </tr>
                      <tr>
                        <td class="label noline"><input name="MM_update" type="hidden" id="MM_update" value="formitem" />                          <input name="item_id" type="hidden" id="item_id" value="<?php echo $row_item['item_id']; ?>" /></td>
                        <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                          <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onClick="toggleview('itemupdate','fulldetail'); return false;" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <div id="fulldetail">
                <li class="gao">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">No. Siri MSN</td>
                      <td colspan="3"><?php echo getItemISNSiriByID($row_item['item_id']); ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Pinjaman</td>
                      <td width="30%" class="noline"><?php if($row_item['item_borrow']=='1') echo "Ya"; else echo "Tidak"; ?></td>
                      <td nowrap="nowrap" class="label">&nbsp;</td>
                      <td width="30%" class="noline">&nbsp;</td>
                    </tr>
                  </table>
                </li>
                <li class="gao">&nbsp;</li>
            	<li class="title">Maklumat Item<span class="fr add" onClick="toggleview2('itemdetail'); return false;">Lengkap</span></li>
                <li class="gao">&nbsp;</li>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Kategori</td>
                      <td width="30%"><?php echo getItemCategoryByID($row_item['category_id']);?> &nbsp; &bull; &nbsp; <?php echo getItemSubCategoryByID($row_item['subcategory_id']);?></td>
                      <td nowrap="nowrap" class="label">Model</td>
                      <td width="30%"><?php echo getItemBrandNameByID($row_item['brand_id']);?> &nbsp; &bull; &nbsp; <?php echo $row_item['item_model']; ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">No. Siri</td>
                      <td colspan="3" class="noline"><?php echo $row_item['item_nosiri']; ?></td>
                    </tr>
                  </table>
                </li>
                <li class="gao">&nbsp;</li>
                <div id="itemdetail" class="hidden2">
                <li class="title">Maklumat Pesanan</li>
                <li class="gao">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Harga Perolehan</td>
                      <td width="30%">RM <?php echo $row_item['item_price']; ?></td>
                      <td nowrap="nowrap" class="label">No. Pesanan Rasmi Kerajaan</td>
                      <td width="30%"><?php echo $row_item['item_nofile']; ?></td>
                      <td nowrap="nowrap" class="label">No. Ruj. Kewangan</td>
                      <td width="30%"><?php echo $row_item['item_voucher']; ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Tarikh Diterima</td>
                      <td class="noline"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_item['item_getdate_m'], $row_item['item_getdate_d'], $row_item['item_getdate_y'])); ?></td>
                      <td nowrap="nowrap" class="label noline">Tempoh Jaminan</td>
                      <td class="noline"><?php echo $row_item['item_warranty']; ?> <?php echo getDurationTypeByID($row_item['warrantytype_id']); ?></td>
                    </tr>
                  </table>
                </li>
                <li class="gao">&nbsp;</li>
                <li class="title">Maklumat Pembekal</li>
                <li class="gao">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Nama</td>
                      <td colspan="3"><?php echo getVendorNameByID($row_item['vendor_id']); ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Alamat</td>
                      <td colspan="3"><?php echo getVendorAddByID($row_item['vendor_id']);?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">No. Tel</td>
                      <td width="30%"><?php echo getVendorNoTelByID($row_item['vendor_id']);?></td>
                      <td nowrap="nowrap" class="label">No. Fax</td>
                      <td width="30%"><?php echo getVendorNoFaxByID($row_item['vendor_id']);?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Email</td>
                      <td class="noline"><?php echo getVendorEmailByID($row_item['vendor_id']);?></td>
                      <td nowrap="nowrap" class="label noline">Website</td>
                      <td class="noline"><?php echo getVendorWebByID($row_item['vendor_id']);?></td>
                    </tr>
                  </table>
                </li>
                <li class="gao">&nbsp;</li>
                </div>
                </div>
                <?php if($row_item['category_id']=='1'){?>
        <li class="title">Komponen / Aksesori <?php if(checkItemComponentByItemID($row_item['item_id']) && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){ ?><span class="fr add" onClick="toggleview('formaksesori', 'aksesori'); return false;">Kemaskini</span><?php }; ?></li>
                <?php
					mysql_select_db($database_ictdb, $ictdb);
					$query_itemos = "SELECT * FROM item_os ORDER BY itemos_id ASC";
					$itemos = mysql_query($query_itemos, $ictdb) or die(mysql_error());
					$row_itemos = mysql_fetch_assoc($itemos);
					$totalRows_itemos = mysql_num_rows($itemos);
					
					mysql_select_db($database_ictdb, $ictdb);
					$query_itemram = "SELECT * FROM item_ram ORDER BY itemram_id ASC";
					$itemram = mysql_query($query_itemram, $ictdb) or die(mysql_error());
					$row_itemram = mysql_fetch_assoc($itemram);
					$totalRows_itemram = mysql_num_rows($itemram);

					mysql_select_db($database_ictdb, $ictdb);
					$query_itemadd = "SELECT * FROM item_add ORDER BY itemadd_name ASC";
					$itemadd = mysql_query($query_itemadd, $ictdb) or die(mysql_error());
					$row_itemadd = mysql_fetch_assoc($itemadd);
					$totalRows_itemadd = mysql_num_rows($itemadd);

					mysql_select_db($database_ictdb, $ictdb);
					$query_itemcomponent = "SELECT * FROM item_component WHERE item_id = '" . $row_item['item_id'] . "' ORDER BY itemcomponent_id DESC";
					$itemcomponent = mysql_query($query_itemcomponent, $ictdb) or die(mysql_error());
					$row_itemcomponent = mysql_fetch_assoc($itemcomponent);
					$totalRows_itemcomponent = mysql_num_rows($itemcomponent);
				?>
                <div id="formaksesori" <?php if(checkItemComponentByItemID($row_item['item_id'])) echo "class=\"hidden\"";?>>
                <li class="gao">&nbsp;</li>
                <li>
                  <form name="component" action="../sb/add_ictitemadd.php" method="POST" id="component">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">No. Siri Monitor</td>
                      <td class="w50"><label for="itemcomponent_monitor"></label>
                      <input name="itemcomponent_monitor" type="text" id="itemcomponent_monitor" value="<?php echo $row_itemcomponent['itemcomponent_monitor']; ?>" /></td>
                      <td nowrap="nowrap" class="label">IP Address</td>
                      <td class="w50"><label for="itemcomponent_ip"></label>
                      <input name="itemcomponent_ip" type="text" id="itemcomponent_ip" value="<?php echo $row_itemcomponent['itemcomponent_ip']; ?>" /></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Hard Disk</td>
                      <td class="w30"><label for="itemcomponent_hd"></label>
                      <input name="itemcomponent_hd" type="text" id="itemcomponent_hd" value="<?php echo $row_itemcomponent['itemcomponent_hd']; ?>" /></td>
                      <td nowrap="nowrap" class="label">Mac Address</td>
                      <td class="w30"><input name="itemcomponent_mac" type="text" id="itemcomponent_mac" value="<?php echo $row_itemcomponent['itemcomponent_mac']; ?>" /></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">CPU</td>
                      <td><label for="itemcomponent_cpu"></label>
                      <input name="itemcomponent_cpu" type="text" id="itemcomponent_cpu" value="<?php echo $row_itemcomponent['itemcomponent_cpu']; ?>" /></td>
                      <td nowrap="nowrap" class="label">&nbsp;</td>
                      <td><label for="itemcomponent_mac"></label></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">RAM</td>
                      <td>
                        <select name="itemcomponent_ram1" id="itemcomponent_ram1">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_itemram['itemram_id']?>" <?php if (!(strcmp($row_itemram['itemram_id'], $row_itemcomponent['itemcomponent_ram1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_itemram['itemram_name']?></option>
                          <?php
							} while ($row_itemram = mysql_fetch_assoc($itemram));
							  $rows = mysql_num_rows($itemram);
							  if($rows > 0) {
								  mysql_data_seek($itemram, 0);
								  $row_itemram = mysql_fetch_assoc($itemram);
							  }
							?>
                        </select>
                      <input name="itemcomponent_ram2" type="text" class="w50" id="itemcomponent_ram2" value="<?php echo $row_itemcomponent['itemcomponent_ram2']; ?>" /></td>
                      <td nowrap="nowrap" class="label">OS</td>
                      <td>
                      <select name="itemcomponent_os" id="itemcomponent_os">
                        <?php do { ?>
                        <option value="<?php echo $row_itemos['itemos_id']?>" <?php if (!(strcmp($row_itemos['itemos_id'], $row_itemcomponent['itemcomponent_os']))) {echo "selected=\"selected\"";} ?>><?php echo $row_itemos['itemos_name']?></option>
                        <?php
						} while ($row_itemos = mysql_fetch_assoc($itemos));
						  $rows = mysql_num_rows($itemos);
						  if($rows > 0) {
							  mysql_data_seek($itemos, 0);
							  $row_itemos = mysql_fetch_assoc($itemos);
						  }
						?>
                      </select></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">WLAN / LAN</td>
                      <td><label for="itemcomponent_wlan"></label>
                      <input name="itemcomponent_wlan" type="text" id="itemcomponent_wlan" value="<?php echo $row_itemcomponent['itemcomponent_wlan']; ?>" /></td>
                      <td nowrap="nowrap" class="label">OS CD-Keys</td>
                      <td><label for="itemcomponent_oskey"></label>
                      <input name="itemcomponent_oskey" type="text" id="itemcomponent_oskey" value="<?php echo $row_itemcomponent['itemcomponent_oskey']; ?>" /></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Lain - lain</td>
                      <td colspan="3"><label for="itemcomponent_other"></label>
                      <textarea name="itemcomponent_other" id="itemcomponent_other" cols="45" rows="5"><?php echo $row_itemcomponent['itemcomponent_other']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Tambahan</td>
                      <td colspan="3">
                      	<ul class="inputradio">
                          	<?php do { ?>
                            <li><input type="checkbox" <?php if (in_array($row_itemadd['itemadd_id'], explode(",", $row_itemcomponent['itemcomponent_add']))) { echo "checked=\"checked\""; }; ?> name="itemcomponent_add[]" value="<?php echo $row_itemadd['itemadd_id']; ?>" id="tambahan_<?php echo $row_itemadd['itemadd_id']; ?>" /><?php echo $row_itemadd['itemadd_name']; ?></li>
                            <?php } while ($row_itemadd = mysql_fetch_assoc($itemadd)); ?>
                        </ul>
                      </td>
                    </tr>
                    <tr>
                      <td class="noline"><input name="item_id" type="hidden" id="item_id" value="<?php echo $row_item['item_id']; ?>" /></td>
                      <td colspan="3" class="noline"><input name="button5" type="submit" class="submitbutton" id="button5" value="Kemaskini" />
                      <input name="button6" type="submit" class="cancelbutton" id="button6" value="Batal" />
                  <input type="hidden" name="MM_insert" value="component" /></td>
                    </tr>
                  </table>
                  </form>
                </li>
                </div>
                <div id="aksesori" <?php if(!checkItemComponentByItemID($row_item['item_id'])) echo "class=\"hidden\"";?>>
                <li class="gao">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">No. Siri Monitor</td>
                      <td class="w30"><?php echo $row_itemcomponent['itemcomponent_monitor']; ?></td>
                      <td class="label">IP Address</td>
                      <td class="w30"><?php echo $row_itemcomponent['itemcomponent_ip']; ?></td>
                    </tr>
                    <tr>
                      <td class="label">Hard Disk</td>
                      <td class="w30"><?php echo $row_itemcomponent['itemcomponent_hd']; ?></td>
                      <td class="label">Mac Address</td>
                      <td class="w30"><?php echo $row_itemcomponent['itemcomponent_mac']; ?></td>
                    </tr>
                    <tr>
                      <td class="label">CPU</td>
                      <td><?php echo $row_itemcomponent['itemcomponent_cpu']; ?></td>
                      <td class="label">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="label">RAM</td>
                      <td><?php echo getItemRAMByID($row_itemcomponent['itemcomponent_ram1']); ?> &nbsp; <?php echo $row_itemcomponent['itemcomponent_ram2']; ?></td>
                      <td class="label">OS</td>
                      <td><?php echo getItemOSByID($row_itemcomponent['itemcomponent_os']); ?></td>
                    </tr>
                    <tr>
                      <td class="label">WLAN / LAN</td>
                      <td><?php echo $row_itemcomponent['itemcomponent_wlan']; ?></td>
                      <td class="label">OS CD-Keys</td>
                      <td><?php echo $row_itemcomponent['itemcomponent_oskey']; ?></td>
                    </tr>
                    <tr>
                      <td class="label">Lain - lain</td>
                      <td colspan="3"><?php echo $row_itemcomponent['itemcomponent_other']; ?></td>
                    </tr>
                    <?php if($row_itemcomponent['itemcomponent_add']!=NULL){?>
                    <tr>
                      <td class="label noline">Tambahan</td>
                      <td colspan="3" class="noline"><?php $itemaddlist = explode(",", $row_itemcomponent['itemcomponent_add']); foreach($itemaddlist AS $key => $value) echo " &nbsp; &bull; &nbsp; " . getItemAddByID($value) . " &nbsp; "; ?></td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                  <?php 
				  	mysql_free_result($itemos);
					mysql_free_result($itemram);
					mysql_free_result($itemadd);
					mysql_free_result($itemcomponent);
					mysql_free_result($durtype);
				  ?>
                </div>
          		<?php }; ?>
                <?php
					mysql_select_db($database_ictdb, $ictdb);
					$query_itemborrow = sprintf("SELECT item_borrow.*, user_borrow.userborrow_date_d, user_borrow.userborrow_date_m, user_borrow.userborrow_date_y FROM ict.item_borrow LEFT JOIN ict.user_borrow ON user_borrow.userborrow_id = item_borrow.userborrow_id WHERE item_borrow.itemborrow_status = '1' AND user_borrow.userborrow_status != 0 AND user_borrow.ict_status =1 AND item_id = %s ORDER BY itemborrow_id DESC", GetSQLValueString($colname_item, "int"));
					$itemborrow = mysql_query($query_itemborrow, $ictdb) or die(mysql_error());
					$row_itemborrow = mysql_fetch_assoc($itemborrow);
					$totalRows_itemborrow = mysql_num_rows($itemborrow);
				?>
                <li class="gao">&nbsp;</li>
                <li class="title">Rekod Pinjaman</li>
                <li>
                <div class="off">
  				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_itemborrow > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle">Bil</th>
                      <th align="center" valign="middle">Tarikh</th>
                      <th width="100%" align="left" valign="middle">Nama / Unit</th>
                      <th align="center" valign="middle">Kelulusan</th>
                      <th align="center" valign="middle">Penyerahan</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php if($row_itemborrow['userborrow_type']==2) echo getDateBorrowByUserBorrowID($row_itemborrow['userborrow_id']) . "<br/>" . getTimeBorrowByUserBorrowID($row_itemborrow['userborrow_id']);?></td>
                        <td align="left" valign="middle"><div class="txt_line"><strong><?php echo getFullNameByStafID($row_itemborrow['user_stafid']) . " (" . $row_itemborrow['user_stafid'] . ")";?></strong>
                        <div><?php echo getFulldirectoryByUserID($row_itemborrow['user_stafid']);?><?php echo " &nbsp; &bull; &nbsp; Ext : " . getExtNoByUserID($row_itemborrow['user_stafid']);?></div></div></td>
                        <td align="center" valign="middle"><?php echo iconICTApproval($row_itemborrow['userborrow_id']); ?></td>
                        <td align="center" valign="middle"><?php echo iconICTReturn($row_itemborrow['userborrow_id']);?></td>
                      </tr>
                      <?php $i++; } while ($row_itemborrow = mysql_fetch_assoc($itemborrow)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_itemborrow ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                <?php mysql_free_result($itemborrow); ?>
				
                <?php
				mysql_select_db($database_ictdb, $ictdb);
				$query_itemborrow2 = "SELECT item_borrow.* FROM ict.item_borrow WHERE itemborrow_status = 1 AND userborrow_type = 1 AND item_id = $colname_item ORDER BY itemborrow_id DESC";
				$itemborrow2 = mysql_query($query_itemborrow2, $ictdb) or die(mysql_error());
				$row_itemborrow2 = mysql_fetch_assoc($itemborrow2);
				$totalRows_itemborrow2 = mysql_num_rows($itemborrow2);
				?>
            	<li class="title">Rekod Penama <?php if(checkItemAvailableByItemID($row_item['item_id'])){?><span class="fr add" onClick="toggleview2('formitemborrow2'); return false;">Tambah</span><?php }; ?></li>
                <div id="formitemborrow2" class="hidden">
                <li>
                  <form id="form2" name="form2" method="post" action="../sb/add_itemborrowuser.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Staf ID</td>
                        <td>
                        <input name="user_stafid" type="text" class="w30" id="user_stafid" list="datastaf1" />
                        <?php echo datalistStaf('datastaf1');?>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">Catatan</td>
                        <td><textarea name="itemborrow_note" id="itemborrow_note" cols="45" rows="5"></textarea></td>
                      </tr>
                      <tr>
                        <td class="label noline"><input name="item_id" type="hidden" id="item_id" value="<?php echo $row_item['item_id']; ?>" />
                        <input name="subcategory_id" type="hidden" id="subcategory_id" value="<?php echo $row_item['subcategory_id']; ?>" /></td>
                        <td class="noline"><input name="button7" type="submit" class="submitbutton" id="button7" value="Submit" />
                        <input name="button8" type="button" class="cancelbutton" id="button8" value="Batal" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_itemborrow2 > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh Mula</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh Tamat</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $ip=1; do { ?>
                      <tr class="on">
                        <td align="center"><?php echo $ip;?></td>
                        <td align="center" nowrap="nowrap"><?php echo $row_itemborrow2['itemborrow_date']; ?></td>
                        <td align="center" nowrap="nowrap"><?php if($row_itemborrow2['ict_return'] == 1) echo $row_itemborrow2['ict_returndate']; else echo "-"; ?></td>
                        <td><strong><?php echo getFullNameByStafID($row_itemborrow2['user_stafid']) . " (" . $row_itemborrow2['user_stafid'] . ")"; ?></strong><br/>
                        <?php echo getFulldirectoryByUserID($row_itemborrow2['user_stafid']);?></td>
                        <td nowrap="nowrap">
                        <?php if($row_itemborrow2['ict_return'] != 1){?>
                        <ul class="func">
                        <li><a href="#" onclick="toggleview2('formTamatItem<?php echo $row_itemborrow2['itemborrow_id']; ?>'); return false;">Tamat</a></li>
                        <li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo getFullNameByStafID($row_itemborrow2['user_stafid']) . " (" . $row_itemborrow2['user_stafid'] . ")"; ?>');" href="<?php echo $url_main;?>sb/del_itemborrowuserpenama.php?id=<?php echo $row_itemborrow2['itemborrow_id']; ?>">X</a></li>
                        </ul>
                        <?php }; ?>
                        <?php if($row_itemborrow2['ict_return'] != 1){?>
                        <div id="formTamatItem<?php echo $row_itemborrow2['itemborrow_id']; ?>" class="passbox_back hidden2">
                           <div class="passbox_form">
                              <form id="formTamat" name="formTamat" method="post" action="../sb/update_itemborrowuserpenamatamat.php">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
                                  <tr>
                                    <td class="title" colspan="2">Tamat</td>
                                  </tr>
                                  <tr>
                                    <td class="label">Item</td>
                                    <td><?php echo getItemISNSiriByID($row_item['item_id']); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="label">Penerima</td>
                                    <td><strong><?php echo getFullNameByStafID($row_itemborrow2['user_stafid']) . " (" . $row_itemborrow2['user_stafid'] . ")"; ?></strong><br/>
                                    <?php echo getFulldirectoryByUserID($row_itemborrow2['user_stafid']);?></td>
                                  </tr>
                                  <tr>
                                    <td class="label">Tarikh Tamat</td>
                                    <td>
                                    <select name="d" id="d">
                                    <?php for($i=1; $i<=31; $i++){?>
                                        <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                                    <?php }; ?>
                                    </select>
                                    <select name="m" id="m">
                                    <?php for($j=1; $j<=12; $j++){?>
                                        <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                                    <?php }; ?>
                                    </select>
                                    <select name="y" id="y">
                                    <?php for($k=(date('Y')-5); $k<=(date('Y')+5); $k++){?>
                                        <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                    <?php }; ?>
                                    </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="label">Catatan</td>
                                    <td><textarea name="ict_returnnote" id="ict_returnnote" cols="45" rows="5"></textarea></td>
                                  </tr>
                                  <tr>
                                    <td class="label noline">
                                    <input name="itemborrow_id" type="hidden" id="itemborrow_id" value="<?php echo $row_itemborrow2['itemborrow_id']; ?>" />
                                    <input name="ict_returnuser" type="hidden" id="ict_returnuser" value="<?php echo $row_itemborrow2['user_stafid']; ?>" />
                                    <input name="item_id" type="hidden" id="item_id" value="<?php echo $row_itemborrow2['item_id']; ?>" />
                                    </td>
                                    <td class="noline">
                                    <input name="button7" type="submit" class="submitbutton" id="button7" value="Tamat" />
                                    <input name="button8" type="button" class="cancelbutton" id="button8" value="Batal" onclick="toggleview2('formTamatItem<?php echo $row_itemborrow2['itemborrow_id']; ?>'); return false;" />
                                    </td>
                                  </tr>
                                </table>
                              </form>
                           </div>
                        </div>
                        <?php }; ?>
                        </td>
                      </tr>
                      <?php $ip++;} while ($row_itemborrow2 = mysql_fetch_assoc($itemborrow2)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_itemborrow2 ?>  rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekdo dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <?php mysql_free_result($itemborrow2); ?>
            	<?php }; ?>
                <li class="gap">&nbsp;</li>
                <li class="title">Rekod Penyelenggaraan</li>
                <li>&nbsp;</li>
            	</ul>
            </div>
 		</div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("cat", {invalidValue:"0"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("model");
var sprytextfield2 = new Spry.Widget.ValidationTextField("price");
var sprytextfield3 = new Spry.Widget.ValidationTextField("nofile");
</script>
</body>
</html>
<?php
mysql_free_result($item);
mysql_free_result($cat);
mysql_free_result($brandlist);
mysql_free_result($vendor);
?>
<?php include('../inc/footinc.php');?> 