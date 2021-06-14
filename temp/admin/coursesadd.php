<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='11';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_durtype = "SELECT * FROM duration_type WHERE durationtype_status = 1 ORDER BY durationtype_id ASC";
$durtype = mysql_query($query_durtype, $hrmsdb) or die(mysql_error());
$row_durtype = mysql_fetch_assoc($durtype);
$totalRows_durtype = mysql_num_rows($durtype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_ccategory = "SELECT * FROM courses_category WHERE coursescategory_status = 1 ORDER BY coursescategory_name ASC";
$ccategory = mysql_query($query_ccategory, $hrmsdb) or die(mysql_error());
$row_ccategory = mysql_fetch_assoc($ccategory);
$totalRows_ccategory = mysql_num_rows($ccategory);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_ctype = "SELECT * FROM courses_type WHERE coursestype_status = 1 ORDER BY coursestype_name ASC";
$ctype = mysql_query($query_ctype, $hrmsdb) or die(mysql_error());
$row_ctype = mysql_fetch_assoc($ctype);
$totalRows_ctype = mysql_num_rows($ctype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_anjuran = "SELECT * FROM organized_by WHERE organizedby_status = 1 ORDER BY organizedby_name ASC";
$anjuran = mysql_query($query_anjuran, $hrmsdb) or die(mysql_error());
$row_anjuran = mysql_fetch_assoc($anjuran);
$totalRows_anjuran = mysql_num_rows($anjuran);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kumpsasaran = "SELECT * FROM `group` WHERE group_status = 1 AND group_view = 1 ORDER BY group_id ASC";
$kumpsasaran = mysql_query($query_kumpsasaran, $hrmsdb) or die(mysql_error());
$row_kumpsasaran = mysql_fetch_assoc($kumpsasaran);
$totalRows_kumpsasaran = mysql_num_rows($kumpsasaran);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_khusus = "SELECT dir_id, dir_name FROM dir WHERE dir_type = 1 AND dir_status = 1 ORDER BY dir_sort ASC";
$khusus = mysql_query($query_khusus, $hrmsdb) or die(mysql_error());
$row_khusus = mysql_fetch_assoc($khusus);
$totalRows_khusus = mysql_num_rows($khusus);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
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
        <?php include('../inc/menu_admin.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
            	<li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 11, 2)){ ?>
                <div class="note">Pendaftaran kursus baru</div>
            	  <form id="form1" name="form1" method="POST" action="../sb/coursesadd_admin.php">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
            	        <td class="label">Klasifikasi</td>
            	        <td colspan="3">
            	          <select name="coursescategory_id" id="coursescategory_id">
            	            <?php
							do {  
							?>
            	            <option value="<?php echo $row_ccategory['coursescategory_id']?>"><?php echo $row_ccategory['coursescategory_name']?></option>
            	            <?php
							} while ($row_ccategory = mysql_fetch_assoc($ccategory));
							  $rows = mysql_num_rows($ccategory);
							  if($rows > 0) {
								  mysql_data_seek($ccategory, 0);
								  $row_ccategory = mysql_fetch_assoc($ccategory);
							  }
							?>
                        </select></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Kategori</td>
            	        <td colspan="3">
            	          <select name="coursestype_id" id="coursestype_id">
            	            <?php
							do {  
							?>
            	            <option value="<?php echo $row_ctype['coursestype_id']?>"><?php echo $row_ctype['coursestype_name']?></option>
            	            <?php
							} while ($row_ctype = mysql_fetch_assoc($ctype));
							  $rows = mysql_num_rows($ctype);
							  if($rows > 0) {
								  mysql_data_seek($ctype, 0);
								  $row_ctype = mysql_fetch_assoc($ctype);
							  }
							?>
                        </select></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Anjuran</td>
            	        <td colspan="3">
            	          <select name="organizedby_id" id="organizedby_id">
            	            <?php
do {  
?>
            	            <option value="<?php echo $row_anjuran['organizedby_id']?>"><?php echo $row_anjuran['organizedby_name']?></option>
            	            <?php
} while ($row_anjuran = mysql_fetch_assoc($anjuran));
  $rows = mysql_num_rows($anjuran);
  if($rows > 0) {
      mysql_data_seek($anjuran, 0);
	  $row_anjuran = mysql_fetch_assoc($anjuran);
  }
?>
                          <option value="0" selected="selected">Lain-lain</option>
                        </select>
                        <div class="inputlabel2">Untuk 'Lain-lain', sila masukkan maklumat Nama Syarikat / Organisasi</div></td>
          	        </tr>
                    <tr>
            	        <td class="label">Penceramah</td>
            	        <td colspan="3"><span id="namapenceramah">
            	          <input type="text" name="courses_lecturename" id="courses_lecturename" />
</span>
            	          <label for="courses_lectureby"></label>
            	          <span id="namaorganisasi">
            	          <input type="text" name="courses_lectureby" id="courses_lectureby" />
</span></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Kumpulan sasaran</td>
            	        <td colspan="3">
            	          <select name="group_id" id="group_id">
                          <option value="0">Terbuka kepada semua</option>
            	            <?php
do {  
?>
            	            <option value="<?php echo $row_kumpsasaran['group_id']?>"><?php echo $row_kumpsasaran['group_name']?></option>
            	            <?php
} while ($row_kumpsasaran = mysql_fetch_assoc($kumpsasaran));
  $rows = mysql_num_rows($kumpsasaran);
  if($rows > 0) {
      mysql_data_seek($kumpsasaran, 0);
	  $row_kumpsasaran = mysql_fetch_assoc($kumpsasaran);
  }
?>
                        </select></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Pengkhususan</td>
            	        <td colspan="3">
            	          <select name="dir_id" id="dir_id">
                          <option value="0">Terbuka kepada semua</option>
            	            <?php
do {  
?>
            	            <option value="<?php echo $row_khusus['dir_id']?>"><?php echo $row_khusus['dir_name']?></option>
            	            <?php
} while ($row_khusus = mysql_fetch_assoc($khusus));
  $rows = mysql_num_rows($khusus);
  if($rows > 0) {
      mysql_data_seek($khusus, 0);
	  $row_khusus = mysql_fetch_assoc($khusus);
  }
?>
                        </select></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Jumlah Peserta</td>
            	        <td colspan="3"><label for="courses_entry"></label>
           	            <input name="courses_entry" type="text" class="w10 txt_right" id="courses_entry" value="0" maxlength="3" /> <span class="inputlabel">orang</span><div class="inputlabel2">Isi '0' jika kursus terbuka untuk semua. Cth: 20 merujuk pada 20 org</div></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Tempoh *</td>
            	        <td colspan="3"><span id="tempoh"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="textfieldInvalidFormatMsg">Format salah.</span>
                        <input name="courses_duration" type="text" class="w10 txt_right" id="courses_duration" value="1" maxlength="2" />
            	          <select name="durationtype_id" id="durationtype_id">
            	            <?php
do {  
?>
            	            <option value="<?php echo $row_durtype['durationtype_id']?>"><?php echo $row_durtype['durationtype_name']?></option>
            	            <?php
} while ($row_durtype = mysql_fetch_assoc($durtype));
  $rows = mysql_num_rows($durtype);
  if($rows > 0) {
      mysql_data_seek($durtype, 0);
	  $row_durtype = mysql_fetch_assoc($durtype);
  }
?>
                          </select></span>
                        </td>
          	        </tr>
            	      <tr>
            	        <td class="label">Tarikh Mula</td>
            	        <td>
                          <select name="courses_start_d" id="courses_start_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                            </select>
                          <span class="inputlabel">/ </span>
                          <select name="courses_start_m" id="courses_start_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                            </select>
                          <span class="inputlabel">/ </span>
                          <input name="courses_start_y" type="text" class="w25" id="courses_start_y" value="<?php echo date('Y');?>" size="4" />
                            </td>
            	        <td class="label">Tarikh Tamat</td>
            	        <td>
                          <select name="courses_end_d" id="courses_end_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                            </select>
                          <span class="inputlabel">/ </span>
                          <select name="courses_end_m" id="courses_end_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                            </select>
                          <span class="inputlabel">/ </span>
                          <input name="courses_end_y" type="text" class="w25" id="courses_end_y" value="<?php echo date('Y');?>" size="4" />
                            </td>
          	        </tr>
            	      <tr>
            	        <td class="label">Tajuk *</td>
            	        <td colspan="3"><span id="tajuk"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
            	          <input type="text" name="courses_name" id="courses_name" />
           	            </span></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Maklumat Lanjut</td>
            	        <td colspan="3">
                        <div class="inputlabel2 padb">Sila masukkan maklumat lanjt berkaitan kursus</div>
           	            <textarea name="courses_notes" id="courses_notes" cols="45" rows="5"></textarea>
                        <?php getEditor('courses_notes', '1'); ?>
                        </td>
          	        </tr>
            	      <tr>
            	        <td class="label">Lokasi</td>
            	        <td colspan="3">
           	            <textarea name="courses_location" id="courses_location" cols="45" rows="5"></textarea>
                        <div class="inputlabel2">Cth : Dewan Perdana, ISN</div></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Masa</td>
            	        <td colspan="3">
           	            <input name="courses_time" type="text" class="w35" id="courses_time" />
      <div class="inputlabel2">Cth : 2.00 - 5.00 ptg</div></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Rujukan</td>
            	        <td colspan="3"><input name="courses_ref" type="text" id="courses_ref" value="" size="45" />
                        <div class="inputlabel2">Cth: 01-02-05 jld 14 (54)</div></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Pengesahan Kehadiran</td>
            	        <td colspan="3"><ul class="inputradio">
            	          <li><input name="courses_att" type="radio" id="courses_att" value="1" checked="checked" /> Ya</li><li><input name="courses_att" type="radio" id="courses_att" value="0" /> Tidak</li></ul></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Laporan</td>
            	        <td colspan="3"><ul class="inputradio">
            	          <li><input name="courses_report" type="radio" id="courses_report" value="1" /> Ya</li><li><input name="courses_report" type="radio" id="courses_report" value="0" checked="checked" /> Tidak</li></ul></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Paparan</td>
            	        <td colspan="3">
                        <ul class="inputradio"><li><input name="courses_view" type="radio" id="courses_view" value="1" checked="checked" /> Ya</li><li><input name="courses_view" type="radio" id="courses_view" value="0" /> Tidak</li></ul>
                        </td>
          	        </tr>
            	      <tr>
            	        <td class="noline">&nbsp;</td>
            	        <td colspan="3" class="noline">
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
           	            <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','courseslist.php');return document.MM_returnValue" /></td>
          	        </tr>
          	        </table>
            	    <input type="hidden" name="MM_insert" value="form1" />
                  </form>
                <?php } else { // semakkan user akses?>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
                  </tr>
                </table>
				</li>
                <?php }; ?>
            	</li>
            </ul>
          </div>
        </div>
        <?php echo noteFooter('1');?>
</div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("tajuk");
var sprytextfield2 = new Spry.Widget.ValidationTextField("tempoh", "integer");
var sprytextfield3 = new Spry.Widget.ValidationTextField("namapenceramah", "none", {isRequired:false, hint:"Nama Penceramah"});
var sprytextfield4 = new Spry.Widget.ValidationTextField("namaorganisasi", "none", {isRequired:false, hint:"Nama Syarikat / Organisasi"});
</script>
</body>
</html>
<?php
mysql_free_result($durtype);

mysql_free_result($ccategory);

mysql_free_result($ctype);

mysql_free_result($anjuran);

mysql_free_result($kumpsasaran);

mysql_free_result($khusus);
?>
<?php include('../inc/footinc.php');?> 