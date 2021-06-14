<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='8';?>
<?php $menu2='25';?>
<?php
mysql_select_db($database_ictdb, $ictdb);
$query_subcat = "SELECT subcategory.subcategory_id, subcategory.subcategory_name FROM ict.item LEFT JOIN ict.subcategory ON subcategory.subcategory_id = item.subcategory_id WHERE item_borrow = 1 AND item_status = '1' GROUP BY subcategory_id ORDER BY subcategory.subcategory_name ASC";
$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
$row_subcat = mysql_fetch_assoc($subcat);
$totalRows_subcat = mysql_num_rows($subcat);

mysql_select_db($database_ictdb, $ictdb);
$query_durationtype = "SELECT * FROM ict.duration_type ORDER BY durationtype_id ASC";
$durationtype = mysql_query($query_durationtype, $ictdb) or die(mysql_error());
$row_durationtype = mysql_fetch_assoc($durationtype);
$totalRows_durationtype = mysql_num_rows($durationtype);
?>
<?php
  $_SESSION['peralatan'] = NULL;
  unset($_SESSION['peralatan']);
  
  $_SESSION['kuantiti'] = NULL;
  unset($_SESSION['kuantiti']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../js/disenter.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
<script>
	window.onload = function ()
	{
		dochange('6', 'kuantiti', document.getElementById('peralatan').value, document.getElementById('dmy').value, 0);
	}
</script>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
      <?php include('../inc/menu.php');?>
        
      	<div class="content">
        
        <?php include('../inc/menu_ict_user.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          <?php if(!$maintenance){?>
          <?php if(!checkUserBorrowReturnDateByUserID($row_user['user_stafid'])){?>
           <?php if ($totalRows_subcat > 0) { // Show if recordset not empty ?>
		   <?php if(getTotalUserBorrowByDate($row_user['user_stafid'], date('d'), date('m'), date('Y'))<=3){;?>
      		<form action="../sb/add_userictborrow.php" method="POST" id="alat" name="alat">
                <ul>
				  <li>
  					<div class="note">Borang Permohonan Pinjaman Peralatan </div>
					<div class="note">1. Sila isi maklumat berikut :</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tujuan *</td>
                        <td width="100" colspan="3"><span id="tujuan">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.<br/>
                        </span>
                        <input autofocus="autofocus" required="required" name="userborrow_title" type="text" id="userborrow_title"  onkeypress="return handleEnter(this, event)" maxlength="300"/>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Lokasi *</td>
                        <td colspan="3"><span id="lokasi"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                          <input name="userborrow_location" required="required" type="text" id="userborrow_location" onkeypress="return handleEnter(this, event)" maxlength="100" /></span>
                        <div class="inputlabel2">Cth : Bilik Rajawali</div></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td width="100%" nowrap="nowrap" class="w50">                          
                          <select name="dmy" id="dmy" onChange="dochange('6', 'kuantiti', document.getElementById('peralatan').value, this.value, 0);">
                          <?php for($dt=date('d'); $dt<=(date('d')+14); $dt++){?>
                          	<option value="<?php echo date('d/m/Y', mktime(0, 0, 0, date('m'), $dt, date('Y')));?>"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, date('m'), $dt, date('Y')));?></option>
                          <?php }; ?>
                        </select>
                        </td>
                        <td nowrap="nowrap" class="label">Masa </td>
                        <td width="30%" class="w50">
                          <select name="userborrow_time_h">
                            <?php for($th = 1; $th<=12; $th++){?>
                            <option <?php if($th==(date('g')+1)) echo "selected=\"selected\"";?> value="<?php echo $th; ?>"><?php echo $th; ?></option>
                            <?php }; ?>
                          </select>
                          <select name="userborrow_time_m">
                            <?php for($tm = 0; $tm<60; $tm+=15){?>
                            <option <?php if($tm==date('i')) echo "selected=\"selected\"";?> value="<?php if($tm==0) $tm = "00"; echo $tm; ?>"><?php echo $tm; ?></option>
                            <?php }; ?>
                          </select>
                          <select name="userborrow_time_ap">
                            <option <?php if(date('A')=='AM') echo "selected=\"selected\"";?> value="AM">AM</option>
                            <option <?php if(date('A')=='PM') echo "selected=\"selected\"";?> value="PM">PM</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tempoh</td>
                        <td colspan="3">
                          <select name="userborrow_duration" id="userborrow_duration">
                            <?php for($i=1; $i<10; $i++){?>
                           	  <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="durationtype_id" id="durationtype_id">
                            <?php
                            do {  
                            ?>
                            <option value="<?php echo $row_durationtype['durationtype_id']?>"><?php echo $row_durationtype['durationtype_name']?></option>
                            <?php
                            } while ($row_durationtype = mysql_fetch_assoc($durationtype));
                              $rows = mysql_num_rows($durationtype);
                              if($rows > 0) {
                                  mysql_data_seek($durationtype, 0);
                                  $row_durationtype = mysql_fetch_assoc($durationtype);
                              }
                            ?>
                          </select></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan *</td>
                        <td colspan="3"><span id="catatan"><span class="textareaRequiredMsg">Maklumat diperlukan.<br/></span><span class="textareaMaxCharsMsg">500 huruf sahaja.<br/></span>
                        <div class="inputlabel2">Sila nyatakan keperluan dengan lebih lengkap.</div>
                            <textarea name="userborrow_note" required="required" id="userborrow_note" cols="45" rows="5"></textarea>
                        <div class="inputlabel2"><span id="countcatatan">&nbsp;</span> huruf sahaja.</div>
                        </span> </td>
                      </tr>
                    </table>
            	</li>
                <li>&nbsp;</li>
                <li>
                <div class="note">2. Pilih peralatan dan kuantiti yang ingin dipinjam :</div>
                <ul>
                	<li class="form_back line_t line_l line_r">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="label noline">Item</td>
                          <td class="noline">
                          <select name="peralatan" id="peralatan" onChange="dochange('6', 'kuantiti', this.value, document.getElementById('dmy').value, 0);">
                            <?php
							do {  
							?>
                            <?php //if(getTotalItemCanBorrow($row_subcat['subcategory_id'])>0){?>
							<option value="<?php echo $row_subcat['subcategory_id'];?>"><?php echo getItemSubCategoryByID($row_subcat['subcategory_id']);?></option>
                            <?php //};?>
							<?php
							} while ($row_subcat = mysql_fetch_assoc($subcat));
							  $rows = mysql_num_rows($subcat);
							  if($rows > 0) {
								  mysql_data_seek($subcat, 0);
								  $row_subcat = mysql_fetch_assoc($subcat);
							  }
							?>
                          </select></td>
                          <td class="label noline">Kuantiti</td>
                          <td width="100%" class="noline">
                          <select name="kuantiti" id="kuantiti">
                          	<option value="0">&laquo; Pilih item</option>
                          </select>
                          <input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="xmlhttpPost('additem.php?add=1', 'alat', 'senaraialat', 'Proses penambahan ...'); return false;"/>
                          <input name="button6" type="button" class="cancelbutton" id="button6" value="Batal Semua" onclick="xmlhttpPost('additem.php?del=1', 'alat', 'senaraialat', 'Proses pembatalan ...'); return false;" /></td>
                        </tr>
                      </table>
                	</li>
                	<li class="line_b line_l line_r">
                    	<div id="senaraialat">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="100" align="center" valign="middle" class="noline">Sila pilih item dan kuantiti yang ingin dipinjam dan klik 'Tambah'</td>
                            </tr>
                          </table>
                      </div>
               	  </li>
                </ul>
                </li>
                <li>&nbsp;</li>
                <li>
                	<div class="note">3. Pengesahan pinjaman :</div>
                    <span id="pengesahan">
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td align="left" valign="top" class="noline">
                        <ul class="inputradio">
                            <li><input name="checkbox" type="checkbox" required="required" id="checkbox" /></li>
                	    </ul>
                        </td>
                	    <td width="100%" align="left" valign="middle" class="noline"><span class="checkboxRequiredMsg">Sila buat pengesahan. <br/></span>Saya mengesahkan setiap peralatan dan kuantiti yang dipohon dan bertanggungjawab terhadap keadaan peralatan sepertimana diserahkan kepada saya. Admin berhak untuk menukar atau membatalkan mana-mana peralatan atau kuantiti yang dipohon tanpa sebarang makluman atau notis.</td>
              	    </tr>
                	  <tr>
                	    <td class="noline">
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" />
                        <input name="userborrow_type" type="hidden" id="userborrow_type" value="2" />
                		<input type="hidden" name="MM_insert" value="alat" />
                        </td>
                	    <td class="noline">
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Hantar" /></td>
              	    </tr>
              	  </table>
                  </span>
                </li>
            </ul>
          </form>
		<?php } else { ?>
        <ul>
        	<li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="noline"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /></td>
                  <td width="100%" class="noline">Modul Pinjaman tidak dapat diproses kerana jumlah pinjaman harian telah melebihi 3 kali.</td>
                </tr>
              </table>
            </li>
        </ul>
        <?php }; ?>
  		<?php } else { ?>
        <ul>
        	<li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="noline"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /></td>
                  <td width="100%" class="noline">Modul Pinjaman tidak dapat diproses buat masa ini kerana semua item yang diperuntukkan telah dipinjam. Maklumat lanjut, sila hubungi <?php echo getDirSubName(getDirIDByMenuID($menu));?>.</td>
                </tr>
              </table>
            </li>
        </ul>
        <?php }; ?>
        <?php } else { ?>
        <ul>
        	<li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="noline"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /></td>
                  <td width="100%" class="noline">Modul Pinjaman tidak dapat dibuat kerana anda masih belum memulangkan item pinjaman sebelum ini. Klik pada 'Rekod' dan semak rekod pinjaman yang masih belum dibuat penyerahan.</td>
                </tr>
              </table>
            </li>
        </ul>
        <?php }; ?>
        <?php } else { ?>
        <ul>
            <li>
            	<div class="note">Sistem dalam proses pengemaskinian dan penambahbaikkan buat sementara waktu</div>
            </li>
        </ul>
        <?php }; ?>
          </div>
        </div>
        <?php echo noteFooter('1');?>
        <?php echo noteEmail('1');?>
        <?php echo noteMade($menu);?>
         
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("tujuan", "none");
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("pengesahan");
var sprytextfield2 = new Spry.Widget.ValidationTextField("lokasi");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("catatan", {counterId:"countcatatan", counterType:"chars_remaining", maxChars:500});
</script>
</body>
</html>
<?php
mysql_free_result($subcat);

mysql_free_result($durationtype);
?>
<?php include('../inc/footinc.php');?> 