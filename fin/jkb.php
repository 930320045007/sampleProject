<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='17';?>
<?php $menu2='87';?>
<?php	
 $_SESSION['description'][] = NULL;
  unset($_SESSION['description']);
  
  $_SESSION['quantity'][] = NULL;
  unset($_SESSION['quantity']);
  
  $_SESSION['calculation'][] = NULL;
  unset($_SESSION['calculation']);
  
  $_SESSION['amount'][] = NULL;
  unset($_SESSION['amount']);
  
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT * FROM dir WHERE dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);
$totalRows_dir = mysql_num_rows($dir);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../js/disenter.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
	<div>
		<?php include('../inc/header.php');?>
      <?php include('../inc/menu.php');?>
      	<div class="content">
         <?php include('../inc/menu_fin_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu"> 
            <form action="../sb/add_jkb.php" method="POST" id="form2" name="jkb">
            <ul>
            	<li>
            	  <div class="note">Borang Permohonan Jawatankuasa Bantuan Pelaksanaan Program/Aktiviti Institut Sukan Negara</div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                        <td align="left" valign="middle" class="label">Kategori</td>
                        <td align="left" valign="middle" nowrap="nowrap" class="noline">
                        <ul class="inputradio">
                          <li><input name="category" type="radio" value="1" /> Baru</li>
                          <li><input name="category" type="radio" value="2" checked="checked" /> Penambahan</li>
                        </ul>
                        </td>
                  </tr>
                  <tr>
                      <td nowrap="nowrap" class="label">Cawangan / <br />Pusat / Unit</td>
                      <td colspan="4"><select name="dir_id" id="dir_id">
					  <?php
                      do {  
					  ?>
      <option value="<?php echo $row_dir['dir_id']?>"><?php echo getFulldirectory($row_dir['dir_id'], 0);?></option>
      <?php
} while ($row_dir = mysql_fetch_assoc($dir));
  $rows = mysql_num_rows($dir);
  if($rows > 0) {
      mysql_data_seek($dir, 0);
	  $row_dir = mysql_fetch_assoc($dir);
  }
?>
				</select></td>
                </tr>
                <tr>
                    <td nowrap="nowrap" class="label">No. Rujukan *</td>
                    <td>
                    <span id="rujukan"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                      <input required="required" name="jkb_ref" type="text" class="w50" id="jkb_ref" onkeypress="return handleEnter(this, event)" maxlength="25" />
                    <div class="inputlabel2">Merujuk kepada Minit Permohonan </div>
                    </span>
                    </td>
                </tr>
                <tr>
                    <td nowrap="nowrap" class="label">Aktiviti *</td>
                    <td>
                    <span id="aktiviti"><span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                      <textarea name="jkb_activity" required="required" cols="60" rows="5" id="jkb_activity" autofocus="autofocus"></textarea>
                    </span>
                    </td>
                </tr>
                <tr>
                    <td nowrap="nowrap" class="label">Perihal </td>
                    <td>
                      <textarea name="jkb_detail" cols="60" rows="5" id="jkb_detail" autofocus="autofocus"></textarea>
                      <div class="inputlabel2">&nbsp;Permohonan yang melibatkan program sila isi Tempat, Tarikh, Peserta dan Pegawai</div>
                    </td>
               </tr>
          </table>
          <div class="note">2. Maklumat Permohonan</div>
          		<ul>
                	<li class="form_back line_t line_l line_r">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10%" align="left" valign="middle" nowrap="nowrap"><div class="inputlabel2">Deskripsi/Perbelanjaan dipohon</div>
                       <textarea name="apply_description" required="required" cols="50" rows="3" id="apply_description" autofocus="autofocus"></textarea>
                         <div class="inputlabel2">&nbsp;</div>
                        </td>
                        <td width="20%" align="left" valign="middle" nowrap="nowrap">
                        <div class="inputlabel2">Kuantiti</div>
                        <input type="text" name="apply_quantity" id="apply_quantity" onkeypress="return handleEnter(this, event)" />
                        <div class="inputlabel2">&nbsp;unit/orang</div>
                        </td>
                        <td width="20%" align="left" valign="middle" nowrap="nowrap"><div class="inputlabel2">Pengiraan</div>
                        <textarea name="apply_calculation" required="required" cols="50" rows="3" id="apply_calculation" autofocus="autofocus"></textarea>
                         <div class="inputlabel2">harga seunit x kuantiti dipohon</div>
                        </td>
                        <td width="20%" align="left" valign="middle" nowrap="nowrap">
                        <div class="inputlabel2">Jumlah (RM)</div>
                        <input type="text" name="apply_amount" id="apply_amount" onkeypress="return handleEnter(this, event)" />
                        <div class="inputlabel2">&nbsp;Cth: 2500.00</div>
                        </td>
                        <td width="20%" align="left" valign="middle"><div class="inputlabel2">&nbsp;</div>
                        <input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="xmlhttpPost('addapply.php?add=1', 'form2', 'senaraiapply', 'Proses penambahan ...'); return false;" />
                        </td>
                      </tr>
                    </table>
                      </li>
                		<li class="line_b line_l line_r">
                    	<div id="senaraiapply">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="100" align="center" valign="middle" class="noline txt_line">
                              <div>Sila isi maklumat yang dikehendaki dan klik 'Tambah'.</div>
                              <div>Ulangi langkah ini untuk tambahan maklumat seterusnya.</div>
                              </td>
                            </tr>
                          </table>
                      	</div>
                        </li>  
                  </ul>
                   <li class="gap">&nbsp;</li>
                <li>
                <div class="note">3. Pengesahan Permohonan</div>
                <span id="sah">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="top" class="w5 noline">
                      <input type="checkbox" name="checkbox" id="checkbox" required="required" />
                    </td>
                    <td class="noline txt_line">
                    <div class="checkboxRequiredMsg">Sila buat pengesahan.</div>
                    <div>Saya dengan ini mengesahkan bahawa segala maklumat yang diberikan adalah benar.
                    </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="noline">
                     <input type="hidden" name="MM_insert" value="jkb" />
                      <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" />
                     </td>
                    <td class="noline"><input name="button5" type="submit" class="submitbutton" id="button5" value="Hantar" /></td>
                  </tr>
                </table>
                </span>
                </li>
                <li class="line_t txt_line">
                <div class="note">
                    <div>Perhatian:-</div>
                    <div>
                        <ol>
                            <li>Permohonan yang kurang <strong>RM 5000 </strong> akan diluluskan oleh Pengarah Bahagian.</li>
                            <li>Permohonan yang melebihi <strong>RM 5000 </strong> akan diluluskan oleh Ketua Pegawai Eksekutif.</li>
                            <li>Permohonan yang diluluskan akan dibawa masuk ke Mesyuarat Jawatankuasa Bantuan.</li>
                            <li>Permohonan yang diluluskan perlu dilaksanakan <strong>selewat-lewatnya 3 bulan </strong>selepas kelulusan.</li>
                            <li>Sila berhubung dengan <?php echo getDirSubName(getDirIDByMenuID($menu));?> untuk maklumat lanjut berkaitan permohonan jawatankuasa bantuan kewangan.</li>
                       </ol>
                    </div>
                </div>
                </li>
              </li>
            </ul>
            </form>
            </div>
        </div>
        <?php echo noteFooter('1'); ?>
        </div>
		<?php include('../inc/footer.php');?>
	</div>   
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("rujukan");
var sprytextfield2 = new Spry.Widget.ValidationTextarea("aktiviti");
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sah");
</script>
</body>
</html>
<?php
mysql_free_result($dir); 
?>
<?php include('../inc/footinc.php');?> 