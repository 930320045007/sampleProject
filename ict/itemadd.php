<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='26';?>
<?php

  $_SESSION['siri'] = NULL;
  unset($_SESSION['siri']);
  
	mysql_select_db($database_ictdb, $ictdb);
	$query_cat = "SELECT category.* FROM ict.category";
	$cat = mysql_query($query_cat, $ictdb) or die(mysql_error());
	$row_cat = mysql_fetch_assoc($cat);
	$totalRows_cat = mysql_num_rows($cat);
  
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
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/disenter.js"></script>
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
        	<form action="../sb/add_ictitem.php" method="POST" name="formitem" id="formitem">
           	  <div class="note">Penambahan item </div>
            <ul>
                <li class="title">Maklumat Item</li>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Kategori *</td>
                        <td><span id="cat">
                          <span class="selectInvalidMsg">Sila pilih Kategori.<br/></span><span class="selectRequiredMsg">Sila pilih Kategori.<br/></span>
                          <select name="category_id" id="category_id" onchange="dochange('5', 'subcategory_id', this.value, '0');">
                            <option value="0">Pilih Kategori</option>
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_cat['category_id'];?>"><?php echo $row_cat['category_name'];?></option>
                            <?php
                            } while ($row_cat = mysql_fetch_assoc($cat));
                              $rows = mysql_num_rows($cat);
                              if($rows > 0) {
                                  mysql_data_seek($cat, 0);
                                  $row_cat = mysql_fetch_assoc($cat);
                              }
                            ?>
                          </select>
                          </span>
                          <select name="subcategory_id" id="subcategory_id">
                            <option value="0">Pilih Kategori</option>
                        </select></td>
                      </tr>
                      <tr>
                        <td class="label noline">Jenama *</td>
                        <td class="noline"><span id="brand">
                    <span class="selectRequiredMsg">Sila pilih jenama.<br/></span>
                          <select name="brand_id" id="brand_id">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_brandlist['brand_id']?>"><?php echo $row_brandlist['brand_name'];?></option>
                            <?php
							} while ($row_brandlist = mysql_fetch_assoc($brandlist));
							  $rows = mysql_num_rows($brandlist);
							  if($rows > 0) {
								  mysql_data_seek($brandlist, 0);
								  $row_brandlist = mysql_fetch_assoc($brandlist);
							  }
							?>
                          </select></span>
                        <input name="item_model" type="text" class="w50" id="item_model" onkeypress="return handleEnter(this, event)" /></td>
                      </tr>
                  </table>
              </li>
                <li class="title">Pendaftaran</li>
                <li class="form_back">
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td class="label">No. Siri Pendaftaran *</td>
                	    <td><span id="nosiri">
               	        <span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                	      <input name="siri" type="text" class="w50" id="siri"  onkeypress="return handleEnter(this, event)"/>
                          </span>
                        <input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="xmlhttpPost('addsiriitem.php?add=1', 'formitem', 'senaraisiri', 'Proses penambahan ...'); return false;"/></td>
              	    </tr>
              	  </table>
                </li>
                <li>
                <div id="senaraisiri">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="noline">Masukkan No. Siri Pendaftaran dan klik 'Tambah'</td>
                    </tr>
                  </table>
                  </div>
                </li>
                <li class="title">Maklumat Pesanan</li>
                <li>
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td class="label">Harga Perolehan *</td>
                	    <td><span id="price"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                        <span class="inputlabel">RM</span>
                	      <input name="item_price" type="text" class="w50" id="item_price"  onkeypress="return handleEnter(this, event)"/>
               	           <div class="inputlabel2">Cth: 700.00</div></span></td>
               	    </tr>
                	  <tr>
                	    <td class="label">Tarikh Diterima</td>
                	    <td>
                	      <select name="item_getdate_d" id="item_getdate_d">
                          <?php for($i=1; $i<=31; $i++){?>
                	        <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = "0" . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
           	            </select>
                	      <span class="inputlabel">/</span>
                	      <select name="item_getdate_m" id="item_getdate_m">
                          <?php for($j=1; $j<=12; $j++){?>
                	        <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                          <?php }; ?>
           	            </select>
                	      <span class="inputlabel">/</span>
                	      <select name="item_getdate_y" id="item_getdate_y">
                          <?php for($k=(date('Y')-10); $k<=date('Y'); $k++){?>
                	        <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
           	            </select></td>
               	    </tr>
                	  <tr>
                	    <td class="label">No. Pesanan Rasmi Kerajaan *</td>
                	    <td><span id="nofile"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span> 
                	      <input name="item_nofile" type="text" class="w50" id="item_nofile"  onkeypress="return handleEnter(this, event)"/>
               	          <div class="inputlabel2">Rujuk No. Surat</div></span> </td>
               	    </tr>
                     <tr>
                	    <td class="label">No. Ruj. Kewangan *</td>
                	    <td>Maklumat diperlukan.<br/></span> 
                	      <input name="item_voucher" type="text" class="w50" id="item_voucher"  onkeypress="return handleEnter(this, event)"/>
               	          <div class="inputlabel2">Rujuk Voucher</div></span> </td>
               	    </tr>
                	  <tr>
                	    <td class="label">Tempoh Jaminan</td>
                	    <td>
                	      <select name="item_warranty" id="item_warranty">
                          <?php for($l=1; $l<=10; $l++){?>
                	        <option value="<?php echo $l;?>"><?php echo $l;?></option>
                          <?php }; ?>
              	          </select>
                	      <select name="warrantytype_id" id="warrantytype_id">
                	        <option value="1">Hari</option>
                	        <option value="2">Minggu</option>
                	        <option value="3">Bulan</option>
                	        <option value="4">Tahun</option>
           	            </select></td>
               	    </tr>
                	  <tr>
                	    <td class="label">Nama Pembekal</td>
                	    <td>
                	      <select name="vendor_id" id="vendor_id">
                	        <?php
							do {  
							?>
							<option value="<?php echo $row_vendor['vendor_id']?>"><?php echo $row_vendor['vendor_name']?></option>
														<?php
							} while ($row_vendor = mysql_fetch_assoc($vendor));
							  $rows = mysql_num_rows($vendor);
							  if($rows > 0) {
								  mysql_data_seek($vendor, 0);
								  $row_vendor = mysql_fetch_assoc($vendor);
							  }
							?>
                          </select>
                        </td>
               	    </tr>
              	  </table>
                </li>
                <li class="title">Urusan ICT</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">No. Siri MSN</td>
                      <td>
                        <span id="nosiriisn"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                      	<span class="inputlabel">MSN/ICT/</span>
                        <select name="item_isnsirihi" id="item_isnsirihi">
                          <option value="H">Harta Modal</option>
                          <option value="I">Inventori</option>
                      	</select>
                        <span class="inputlabel">/</span>
                        <select name="item_isnsiriyear" id="item_isnsiriyear">
                        <?php for($m=(date('Y')-10); $m<=date('Y'); $m++){?>
                          <option value="<?php echo $m;?>" <?php if($m==date('Y')) echo "selected=\"selected\"";?>><?php echo $m;?></option>
                        <?php }; ?>
                      	</select>
                        <span class="inputlabel">/</span>
                        <label for="item_isnsiri"></label>
                        <input name="item_isnsiri" type="text" class="w35" id="item_isnsiri"  onkeypress="return handleEnter(this, event)"/>
                        </span></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Pinjaman</td>
                      <td>
                      <ul class="inputradio">
                      	<li><input type="radio" name="item_borrow" value="1" id="pinjaman_0" />Ya</li>
                        <li><input name="item_borrow" type="radio" id="pinjaman_1" value="0" checked="checked" />Tidak</li>
                      </ul>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                      <span id="pinjaman"><span class="checkboxRequiredMsg">Sila buat pengesahan berikut.</span>
                      <ul class="inputradio">
                      	<li>
                      	  <input name="pengesahan" type="checkbox" value="1"/>
                   	     Saya mengesahkan penerimaan dan maklumat yang dinyatakan adalah benar.</li>
                      </ul>
                      </span></td>
                    </tr>
                	  <tr>
                	    <td class="noline"><input type="hidden" name="MM_insert" value="formitem" /></td>
                	    <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onClick="MM_goToURL('parent','item.php');return document.MM_returnValue"/></td>
              	    </tr>
                  </table>
                </li>
            </ul>
            </form>
                <?php } else { ?>
                <ul>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
                  </tr>
                </table>
				</li>
                </ul>
                <?php }; ?>
            </div>
        </div>
        <?php echo noteICT('1');?>
    </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("cat", {invalidValue:"0"});
var spryselect2 = new Spry.Widget.ValidationSelect("brand");
var sprytextfield1 = new Spry.Widget.ValidationTextField("nosiri");
var sprytextfield2 = new Spry.Widget.ValidationTextField("price");
var sprytextfield3 = new Spry.Widget.ValidationTextField("nofile");
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("pinjaman");
var sprytextfield4 = new Spry.Widget.ValidationTextField("nosiriisn");
</script>
</body>
</html>
<?php
mysql_free_result($cat);
mysql_free_result($brandlist);

mysql_free_result($vendor);
?>
<?php include('../inc/footinc.php');?> 