<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='11';?>
<?php

if (isset($_GET['id']))
	$id = htmlspecialchars($_GET['id'], ENT_QUOTES);
else
	$id = "-1";

if(isset($_GET['by']))
	$by = htmlspecialchars($_GET['by'], ENT_QUOTES);
else
	$by = '1';

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_durtype = "SELECT * FROM www.duration_type WHERE durationtype_status = 1 ORDER BY durationtype_id ASC";
$durtype = mysql_query($query_durtype, $hrmsdb) or die(mysql_error());
$row_durtype = mysql_fetch_assoc($durtype);
$totalRows_durtype = mysql_num_rows($durtype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_ccategory = "SELECT * FROM courses_category WHERE coursescategory_status = 1 ORDER BY coursescategory_name ASC";
$ccategory = mysql_query($query_ccategory, $hrmsdb) or die(mysql_error());
$row_ccategory = mysql_fetch_assoc($ccategory);
$totalRows_ccategory = mysql_num_rows($ccategory);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_ctype = "SELECT * FROM www.courses_type WHERE coursestype_status = 1 ORDER BY coursestype_name ASC";
$ctype = mysql_query($query_ctype, $hrmsdb) or die(mysql_error());
$row_ctype = mysql_fetch_assoc($ctype);
$totalRows_ctype = mysql_num_rows($ctype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_anjuran = "SELECT * FROM www.organized_by WHERE organizedby_status = 1 ORDER BY organizedby_name ASC";
$anjuran = mysql_query($query_anjuran, $hrmsdb) or die(mysql_error());
$row_anjuran = mysql_fetch_assoc($anjuran);
$totalRows_anjuran = mysql_num_rows($anjuran);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kumpsasaran = "SELECT * FROM www.group WHERE group_status = 1 AND group_view = 1 ORDER BY group_id ASC";
$kumpsasaran = mysql_query($query_kumpsasaran, $hrmsdb) or die(mysql_error());
$row_kumpsasaran = mysql_fetch_assoc($kumpsasaran);
$totalRows_kumpsasaran = mysql_num_rows($kumpsasaran);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_khusus = "SELECT dir_id, dir_name FROM www.dir WHERE dir_type = 1 AND dir_status = 1 ORDER BY dir_sort ASC";
$khusus = mysql_query($query_khusus, $hrmsdb) or die(mysql_error());
$row_khusus = mysql_fetch_assoc($khusus);
$totalRows_khusus = mysql_num_rows($khusus);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cv = sprintf("SELECT * FROM www.courses WHERE courses_id = %s AND courses_status = '1'", GetSQLValueString($id, "int"));
$cv = mysql_query($query_cv, $hrmsdb) or die(mysql_error());
$row_cv = mysql_fetch_assoc($cv);
$totalRows_cv = mysql_num_rows($cv);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_entry = sprintf("SELECT user_courses.*, user.user_firstname FROM www.user_courses LEFT JOIN user ON user.user_stafid = user_courses.user_stafid WHERE courses_id = %s AND user_courses.usercourses_status = '1' ORDER BY user.user_firstname ASC", GetSQLValueString($id, "int"));
$entry = mysql_query($query_entry, $hrmsdb) or die(mysql_error());
$row_entry = mysql_fetch_assoc($entry);
$totalRows_entry = mysql_num_rows($entry);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
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
            <div class="note">Mengemaskini maklumat kursus dan pengesahan peserta.</div>
          	<ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){ ?>
            	<li class="title">Maklumat Kursus 
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){ ?><span class="fr add" onclick="toggleview('formcourses','courses'); return false;">Kemaskini</span><?php }; ?><?php if(checkCoursesNeedAttendence($row_cv['courses_id']) && checkEndDate($row_cv['courses_id']) && checkStartDate($row_cv['courses_id'])){?><span class="fr add"><a onclick="MM_openBrWindow('<?php echo $url_main;?>admin/attendance.php?id=<?php echo $row_cv['courses_id'];?>','attendance','status=yes,scrollbars=yes,width=1000,height=600')">Kehadiran</a></span><?php }; ?></li>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){ ?>
           	  	<div id="formcourses" class="hidden">
                <li>
            	  <form id="form1" name="form1" method="POST" action="../sb/coursesadd_admin.php">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
            	        <td class="label">Klasifikasi Kursus</td>
            	        <td colspan="3">
            	          <select name="coursescategory_id" id="coursescategory_id">
            	            <?php
							do {  
							?>
            	            <option value="<?php echo $row_ccategory['coursescategory_id']?>"<?php if (!(strcmp($row_ccategory['coursescategory_id'], $row_cv['coursescategory_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_ccategory['coursescategory_name']?></option>
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
            	        <td class="label">Jenis Kursus</td>
            	        <td colspan="3">
            	          <select name="coursestype_id" id="coursestype_id">
            	            <?php
							do {  
							?>
            	            <option value="<?php echo $row_ctype['coursestype_id']?>"<?php if (!(strcmp($row_ctype['coursestype_id'], $row_cv['coursestype_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_ctype['coursestype_name']?></option>
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
            	            <option value="<?php echo $row_anjuran['organizedby_id']?>"<?php if (!(strcmp($row_anjuran['organizedby_id'], $row_cv['organizedby_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_anjuran['organizedby_name']?></option>
            	            <?php
							} while ($row_anjuran = mysql_fetch_assoc($anjuran));
							  $rows = mysql_num_rows($anjuran);
							  if($rows > 0) {
								  mysql_data_seek($anjuran, 0);
								  $row_anjuran = mysql_fetch_assoc($anjuran);
							  }
							?>
            	            <option value="0" <?php if (!(strcmp(0, $row_cv['organizedby_id']))) {echo "selected=\"selected\"";} ?>>Lain-lain</option>
                        </select>
                        <div class="inputlabel2">Untuk 'Lain-lain', sila masukkan maklumat Nama Syarikat / Organisasi</div></td>
          	        </tr>
                     <tr>
            	        <td class="label">Penceramah</td>
            	        <td colspan="3"><span id="namapenceramah">
            	          <input name="courses_lecturename" type="text" id="courses_lecturename" value="<?php echo $row_cv['courses_lecturename']; ?>" />
</span>
            	          <label for="courses_lectureby"></label>
            	          <span id="namaorganisasi">
            	          <input name="courses_lectureby" type="text" id="courses_lectureby" value="<?php echo $row_cv['courses_lectureby']; ?>" />
</span></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Kumpulan sasaran</td>
            	        <td colspan="3">
            	          <select name="group_id" id="group_id">
            	            <option value="0" <?php if (!(strcmp(0, $row_cv['group_id']))) {echo "selected=\"selected\"";} ?>>Semua</option>
            	            <?php
							do {  
							?>
            	            <option value="<?php echo $row_kumpsasaran['group_id']?>"<?php if (!(strcmp($row_kumpsasaran['group_id'], $row_cv['group_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_kumpsasaran['group_name']?></option>
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
            	            <option value="0" <?php if (!(strcmp(0, $row_cv['dir_id']))) {echo "selected=\"selected\"";} ?>>Semua</option>
            	            <?php
							do {  
							?>
            	            <option value="<?php echo $row_khusus['dir_id']?>"<?php if (!(strcmp($row_khusus['dir_id'], $row_cv['dir_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_khusus['dir_name']?></option>
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
           	            <input name="courses_entry" type="text" class="w10 txt_right" id="courses_entry" value="<?php echo $row_cv['courses_entry']; ?>" maxlength="3" /> <span class="inputlabel">orang</span><div class="inputlabel2">Isi '0' jika kursus terbuka untuk semua. Cth: 20 merujuk pada 20 org</div></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Tempoh *</td>
            	        <td colspan="3"><span id="tempoh"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="textfieldInvalidFormatMsg">Format salah.</span>
                        <input name="courses_duration" type="text" class="w10 txt_right" id="courses_duration" value="<?php echo $row_cv['courses_duration']; ?>" maxlength="2" />
            	          <select name="durationtype_id" id="durationtype_id">
            	            <?php
							do {  
							?>
            	            <option value="<?php echo $row_durtype['durationtype_id']?>"<?php if (!(strcmp($row_durtype['durationtype_id'], $row_cv['durationtype_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_durtype['durationtype_name']?></option>
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
                            <option <?php if($i==$row_cv['courses_start_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                            </select>
                          <span class="inputlabel">/ </span>
                          <select name="courses_start_m" id="courses_start_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==$row_cv['courses_start_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                            </select>
                          <span class="inputlabel">/ </span>
                          <input name="courses_start_y" type="text" class="w25" id="courses_start_y" value="<?php echo $row_cv['courses_start_y']; ?>" size="4" />
                            </td>
            	        <td class="label">Tarikh Tamat</td>
            	        <td>
                          <select name="courses_end_d" id="courses_end_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==$row_cv['courses_end_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                            </select>
                          <span class="inputlabel">/ </span>
                          <select name="courses_end_m" id="courses_end_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==$row_cv['courses_end_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                            </select>
                          <span class="inputlabel">/ </span>
                          <input name="courses_end_y" type="text" class="w25" id="courses_end_y" value="<?php echo $row_cv['courses_end_y']; ?>" size="4" />
                            </td>
          	        </tr>
            	      <tr>
            	        <td class="label">Tajuk *</td>
            	        <td colspan="3"><span id="tajuk"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
            	          <input name="courses_name" type="text" id="courses_name" value="<?php echo $row_cv['courses_name']; ?>" />
           	            </span></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Maklumat Lanjut</td>
            	        <td colspan="3">
           	            <textarea name="courses_notes" id="courses_notes" cols="45" rows="5"><?php echo $row_cv['courses_notes']; ?></textarea>
                        <?php getEditor('courses_notes', '1'); ?>
                        </td>
          	        </tr>
            	      <tr>
            	        <td class="label">Lokasi</td>
            	        <td colspan="3">
           	            <textarea name="courses_location" id="courses_location" cols="45" rows="5"><?php echo $row_cv['courses_location']; ?></textarea>
                        <div class="inputlabel2">Cth : Dewan Perdana, ISN</div></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Masa</td>
            	        <td colspan="3">
           	            <input name="courses_time" type="text" class="w35" id="courses_time" value="<?php echo $row_cv['courses_time']; ?>" />
      <div class="inputlabel2">Cth : 2.00 - 5.00 ptg</div></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Rujukan</td>
            	        <td colspan="3"><input name="courses_ref" type="text" id="courses_ref" value="<?php echo $row_cv['courses_ref']; ?>" size="45" />
                        <div class="inputlabel2">Cth: 01-02-05 jld 14 (54)</div></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Pengesahan Kehadiran</td>
            	        <td colspan="3"><ul class="inputradio">
            	          <li><input <?php if (!(strcmp($row_cv['courses_att'],"1"))) {echo "checked=\"checked\"";} ?> name="courses_att" type="radio" id="courses_att" value="1" /> Ya</li><li><input <?php if (!(strcmp($row_cv['courses_att'],"0"))) {echo "checked=\"checked\"";} ?> name="courses_att" type="radio" id="courses_att" value="0" /> Tidak</li></ul></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Laporan</td>
            	        <td colspan="3"><ul class="inputradio">
            	          <li><input <?php if (!(strcmp($row_cv['courses_report'],"1"))) {echo "checked=\"checked\"";} ?> name="courses_report" type="radio" id="courses_report" value="1" /> Ya</li>
                          <li><input <?php if (!(strcmp($row_cv['courses_report'],"0"))) {echo "checked=\"checked\"";} ?> name="courses_report" type="radio" id="courses_report" value="0" /> Tidak</li></ul></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Paparan</td>
            	        <td colspan="3">
                        <ul class="inputradio">
            	          <li><input <?php if (!(strcmp($row_cv['courses_view'],"1"))) {echo "checked=\"checked\"";} ?> name="courses_view" type="radio" id="courses_view" value="1" checked="checked" /> Ya</li>
                          <li><input <?php if (!(strcmp($row_cv['courses_view'],"0"))) {echo "checked=\"checked\"";} ?> name="courses_view" type="radio" id="courses_view" value="0" /> Tidak</li>
                          </ul>
                          <div class="inputlabel2">Pilih YA untuk dilihat dalam senarai kursus yang boleh dipohon.</div></td>
          	        </tr>
            	      <tr>
            	        <td class="noline">
                        <input type="hidden" name="MM_update" value="formcourses" />
                        <input name="courses_id" type="hidden" id="courses_id" value="<?php echo $row_cv['courses_id']; ?>" /></td>
            	        <td colspan="3" class="noline">
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
           	            <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal"  onclick="toggleview('formcourses','courses'); return false;" /></td>
          	        </tr>
          	        </table>
            	  </form>
            	</li>
                </div>
                <?php }; ?>
                <div id="courses">
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Tajuk</td>
                      <td colspan="3"><?php echo $row_cv['courses_name']; ?></td>
                    </tr>
                    <tr>
                      <td class="label">Anjuran</td>
                      <td colspan="3"><?php echo getOrganizedBy($row_cv['organizedby_id'],$row_cv['courses_id']); ?></td>
                    </tr>
                    <tr>
                      <td class="label">Tarikh</td>
                      <td width="50%"><?php echo getCoursesDate($row_cv['courses_id'],'0');?> (<?php echo $row_cv['courses_duration']; ?> <?php echo getDurationType($row_cv['durationtype_id']); ?>)</td>
                      <td class="label">Masa</td>
                      <td width="50%"><?php echo $row_cv['courses_time']; ?></td>
                    </tr>
                    <tr>
                      <td class="label">Tempat</td>
                      <td><?php echo $row_cv['courses_location']; ?></td>
                      <td class="label">Peserta</td>
                      <td><?php if($row_cv['courses_entry']!=0) echo $row_cv['courses_entry']; else echo "Terbuka"; ?></td>
                    </tr>
                    <?php if($row_cv['courses_notes']){ ?>
                    <tr>
                      <td align="left" valign="top" class="label">Maklumat Lanjut</td>
                      <td colspan="3" align="left" valign="top" class="txt_line"><?php echo htmlspecialchars_decode($row_cv['courses_notes'], ENT_QUOTES); ?></td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                </div>
                <li class="title">Senarai Penyertaan <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){ ?><span class="fr add" onclick="toggleview2('formentry'); return false;">+ Tambah</span><span class="fr add" onclick="toggleview2('formnote'); return false;">Note</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){ ?>
                <div id="formnote" class="hidden">
                <li>
                  <form id="note" name="note" method="post" action="../sb/courses_sendnote.php?id=<?php echo $row_cv['courses_id']; ?>">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="noline">Pesanan akan dihantar kepada semua yang berdaftar bagi Kursus ini. Pesanan ini tidak disimpan dalam sistem.</td>
                      </tr>
                      <tr>
                        <td class="noline">
                        <textarea name="notemsg" id="notemsg" cols="45" rows="10"></textarea>
                        <div class="note">Oleh <?php echo getFullNameByStafID($row_user['user_stafid']) . " (" . $row_user['user_stafid'] . ")";?></div></td>
                      </tr>
                      <tr>
                        <td class="noline"><input name="button7" type="submit" class="submitbutton" id="button7" value="Hantar" />
                        <input name="button8" type="button" class="cancelbutton" id="button8" value="Batal" onclick="toggleview2('formnote'); return false;"/></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
              <div id="formentry" class="hidden">
                <li>
                <form id="entry" name="entry" method="post" action="../sb/add_usercourses.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label noline">Staf ID *</td>
                      <td width="100%" class="noline">
                      <input type="hidden" name="MM_insert" value="apply" />
                      <input name="courses_id" type="hidden" id="courses_id" value="<?php echo $row_cv['courses_id']; ?>" />
                      <input name="url" type="hidden" id="url" value="2" />
                      <span id="stafidentry"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                      <input name="user_stafid" type="text" class="w30" id="user_stafid" list="datastaf" />
                      <?php echo datalistStaf('datastaf');?>
                      </span>
                      <select name="usercourses_as" id="usercourses_as">
                        <option value="0">Peserta</option>
                        <option value="1">Pembentang</option>
                      </select>
                      <input name="button5" type="submit" class="submitbutton" id="button5" value="Tambah" />
                      <input name="button6" type="button" class="cancelbutton" id="button6" value="Batal" onclick="toggleview2('formentry'); return false;" /></td>
                    </tr>
                  </table>
                </form>
                </li>
                </div>
                <?php }; ?>
                <?php if(checkCoursesNeedAttendence($row_cv['courses_id']) || checkReportNeed($row_cv['courses_id'], 0)){?>
                <li>
				<?php $tt = getTotalAttendence($row_cv['courses_id']);?>
               	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                	  <tr>
                	    <td class="icon_pad1"><img src="../icon/user.png" width="39" height="48" alt="User" /></td>
                	    <td class="line_r w50">
                        	<div>Pengesahan kehadiran</div>
                		<?php if(checkCoursesNeedAttendence($row_cv['courses_id'])){?>
                       	  <div class="txt_size1"><?php echo $tt['0'] . " / " . $tt['1']; // Jumlah Hadir?> <span class="txt_size2">org</span></div>
                          <div class="txt_size2"><?php if($tt['1']!=0) echo ceil(($tt['0']/$tt['1'])*100); else echo '0'; ?> %</div>
                		<?php } else { ?>
                        	<div class="txt_size1">Tiada</div>
                        <?php };?>
                        </td>
                	    <td class="icon_pad1"><img src="../icon/clip.png" width="39" height="48" alt="Report" /></td>
                	    <td class="w50">
                        	<div>Laporan</div>
                        <?php if(checkReportNeed($row_cv['courses_id'], 0)){?>
                        	<div class="txt_size1"><?php echo getTotalReport($row_cv['courses_id']);?> <span class="txt_size2">org</span></div>
                        <?php } else { ?>
                        	<div class="txt_size1">Tiada</div>
                        <?php }; ?>
                        </td>
              	    </tr>
              	  </table>
                </li>
                <?php }; ?>
                </ul>
                <div class="funcmenu">
                <ul>
                <li <?php if($by == '1') echo "class=\"funcon\"";?>><a href="?id=<?php echo $id;?>&by=1">Nama</a></li>
                <li <?php if($by == '2') echo "class=\"funcon\"";?>><a href="?id=<?php echo $id;?>&by=2">Bahagian</a></li>
                <li <?php if(checkCoursesTypeID($id) && $by == '3') echo "class=\"funcon\"";?>><a href="?id=<?php echo $id;?>&by=3">Ketidakhadiran</a></li>
                </ul>
                </div>
                <ul>  
                <?php if($by == '1') {?>
                <li>
                <div class="note">Senarai yang hadir</div>
                </li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_entry > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th nowrap="nowrap">Bil</th>
                      <th width="100%" align="left" valign="middle">Nama / Jawatan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Laporan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Kelulusan<br />Laporan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Kehadiran</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="left" valign="middle"><div class="txt_line"><a href="coursesstaffdetail.php?sid=<?php echo getID($row_entry['user_stafid']);?>"><strong><?php echo getFullNameByStafID($row_entry['user_stafid']);?></strong> (<?php echo $row_entry['user_stafid'];?>)</a></div><div class="txt_color1"><?php echo getJobtitle($row_entry['user_stafid']) . " (" . getGred($row_entry['user_stafid']) . "), " . getFulldirectoryByUserID($row_entry['user_stafid']);?></div></td>
                        <td align="center" valign="middle"><?php 
                        if(getUserAsByUserID($row_entry['user_stafid'], $row_entry['courses_id'])==1) 
                            echo "<img src=\"" . $url_main . "/icon/sign_info.png\" alt=\"Pembentang\" align=\"absbottom\" />"; 
                        else if(checkReportNeed($row_entry['courses_id'])) 
                            if(!checkReportSubmit($row_entry['user_stafid'], $row_entry['courses_id'])) 
                                echo "<span class=\"txt_color2\">X</span>"; else echo "<a href=\"" . $url_main . "admin/reportread.php?ucrid=" . getUserCoursesReportIDByCoursesID($row_entry['user_stafid'], $row_entry['courses_id']) . "\"><img src=\"../icon/page_edit.png\" width=\"16\" height=\"16\" alt=\"Lihat\" /></a>"; 
                            else echo "&nbsp;";?>
                          </td>
                        <td align="center" valign="middle">
						<?php 
                        if(getUserAsByUserID($row_entry['user_stafid'], $row_entry['courses_id'])==1)
						{ 
                            echo "<img src=\"" . $url_main . "/icon/sign_info.png\" alt=\"Pembentang\" align=\"absbottom\" />"; 
						} else if(checkReportNeed($row_entry['courses_id'])) 
						{
                            if(checkReportApproval($row_entry['user_stafid'], $row_entry['courses_id'])!=0)
							{ 
                                echo "<a href=\"" . $url_main . "admin/reportread.php?ucrid=" . getUserCoursesReportIDByCoursesID($row_entry['user_stafid'], $row_entry['courses_id']) . "\"><img src=\"../icon/sign_tick.png\" width=\"16\" height=\"16\" alt=\"Lulus\" /></a>"; 
							} else { 
								echo "X";
							};
						}; ?>
                          </td>
                        <td align="center" valign="middle"><?php iconAttendance($row_entry['user_stafid'], $row_entry['courses_id']);?></td>
                        <td align="center" valign="middle"><ul class="func"><li><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){ ?><a onclick="return confirm('Anda mahu maklumat kehadiran berikut dipadam? \r\n\n <?php echo getFullNameByStafID($row_entry['user_stafid']);?> (<?php echo $row_entry['user_stafid'];?>)')" href="../sb/del_coursesattendadmin.php?cid=<?php echo $row_entry['usercourses_id']; ?>&deluc=<?php echo $id;?>&id=<?php echo getID($row_entry['user_stafid']); ?>">X</a><?php }; ?></li></ul></td>
                      </tr>
                      <?php $i++; } while ($row_entry = mysql_fetch_assoc($entry)); ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_entry ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <?php } elseif($by == '2'){ ?>
                <li>
                <div class="note">Senarai yang hadir</div>
                </li>
                <?php $dirlist = getDirIDAttendanceByCoursesID($id); ?>
                <li>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php foreach($dirlist AS $key => $value) { ?>
                  <tr class="back_darkgrey">
                    <td width="100%"><?php echo getFulldirectory($value, 0);?></td>
                    <td nowrap="nowrap"><?php echo totalAttendanceByDirID($id, $value);?></td>
                  </tr>
                  <?php $staflist = getStafIDByDirID($id, $value); ?>
                  <?php foreach($staflist AS $key2 => $value2) { ?>
                  <tr>
                    <td width="100%" colspan="2"><?php echo getFullNameByStafID($value2);?></td>
                  </tr>
                  <?php }; ?>
				<?php } ?>
                </table>
                </li>
                <?php }elseif(checkCoursesTypeID($id) && $by == '3'){ ?>
                <li>
                <div class="note">Senarai yang tidak hadir</div>
                </li>
                <?php $dirlist1 = getDirIDNotAttendByCoursesID($id); ?>
                <li>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php foreach($dirlist1 AS $key => $value1) { ?>
                  <tr class="back_darkgrey">
                    <td width="100%"><?php echo getFulldirectory($value1, 0);?></td>
                    <td align="center" nowrap="nowrap"><?php echo totalNotAttendByDirID($id, $value1);?></td>
                  </tr>
                  <?php $staflist = getStafIDNotAttendByDirID($id, $value1); ?>
                  <?php foreach($staflist AS $key3 => $value3) { ?>
                  <tr>
                    <td width="100%"><?php echo getFullNameByStafID($value3);?> ( <?php echo $value3; ?> )</td>
                    <td nowrap="nowrap"><?php echo getStatusStaffByID($value3,$row_cv['courses_start_d'], $row_cv['courses_start_m'], $row_cv['courses_start_y']);?>
                  </tr>
                  <?php }; ?>
				<?php } ?>
                </table>
                </li>
               <?php } else { ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>  
                      <td colspan="6" align="center" valign="middle" class="noline">&nbsp;</td>
                    </tr>
                    <tr>  
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod.</td>
                    </tr></table>
                    <?php }; ?>
                <li class="gap">&nbsp;</li>     
                <?php } else { // semakkan user akses?>
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
        <?php echo noteFooter('1');?>
        <?php echo noteEmail('1');?>
</div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("tajuk");
var sprytextfield2 = new Spry.Widget.ValidationTextField("tempoh", "integer");
var sprytextfield3 = new Spry.Widget.ValidationTextField("namapenceramah", "none", {isRequired:false, hint:"Nama Penceramah"});
var sprytextfield4 = new Spry.Widget.ValidationTextField("namaorganisasi", "none", {isRequired:false, hint:"Nama Syarikat / Organisasi"});
var sprytextfield5 = new Spry.Widget.ValidationTextField("stafidentry");
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

mysql_free_result($cv);

mysql_free_result($entry);
?>
<?php include('../inc/footinc.php');?>

