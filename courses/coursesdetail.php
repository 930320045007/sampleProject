<?php require_once('../Connections/hrmsdb.php');?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='4';?>
<?php $menu2='12';?> 
<?php
$colname_kursus = "-1";
if (isset($_GET['id'])) {
  $colname_kursus = getID(htmlspecialchars($_GET['id'], ENT_QUOTES), 0);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kursus = sprintf("SELECT * FROM courses WHERE courses_id = %s", GetSQLValueString($colname_kursus, "int"));
$kursus = mysql_query($query_kursus, $hrmsdb) or die(mysql_error());
$row_kursus = mysql_fetch_assoc($kursus);
$totalRows_kursus = mysql_num_rows($kursus);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
      <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_courses.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
            	<li>
                &nbsp;
            	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
            	    <tr>
            	      <td align="center" class="icon_pad1"><img src="../icon/user.png" width="39" height="48" alt="User" /></td>
            	      <td class="line_r w50"><div>Jumlah Peserta Berdaftar</div>
                      <div class="txt_size1"><?php echo getUserCoursesEntryandTotal($row_kursus['courses_id']);?></div></td>
            	      <td class="icon_pad1"><img src="../icon/calculator.png" width="33" height="48" alt="iD" /></td>
            	      <td class="w50"><div>Kiraan jam kursus</div>
                      <div class="txt_size1"><?php echo $row_kursus['courses_duration']; ?> <span class="txt_size2"><?php echo getDurationType($row_kursus['durationtype_id']); ?></span></div></td>
          	      </tr>
          	    </table>
            	</li>
                <li class="line_b">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Tajuk</td>
                      <td colspan="3"><strong class="txt_size3"><?php echo $row_kursus['courses_name']; ?></strong></td>
                    </tr>
                    <tr>
                      <td class="label">Anjuran</td>
                      <td colspan="3"><?php echo getOrganizedBy($row_kursus['organizedby_id'], $row_kursus['courses_id']); ?></td>
                    </tr>
                    <tr>
                      <td class="label">Tarikh</td>
                      <td class="w50"><?php echo getCoursesDate($row_kursus['courses_id'],'0');?></td>
                      <td class="label">Masa</td>
                      <td class="w50"><?php if($row_kursus['courses_time']!=NULL) echo $row_kursus['courses_time']; else echo "Tidak dinyatakan"; ?></td>
                    </tr>
                    <tr>
                      <td class="label">Tempat</td>
                      <td colspan="3"><?php if($row_kursus['courses_location']!=NULL) echo $row_kursus['courses_location']; else echo "Tidak dinyatakan"; ?></td>
                    </tr>
                    <?php if($row_kursus['courses_notes']){ ?>
                    <tr>
                      <td valign="top" nowrap="nowrap" class="label noline">Maklumat lanjut</td>
                       <td colspan="3" class="noline"><div class="txt_line"><?php echo htmlspecialchars_decode($row_kursus['courses_notes'], ENT_QUOTES); ?></div></td>
                    </tr>
                    <?php }; ?>
                  </table>
                  <?php if(checkReportNeed($row_kursus['courses_id'])) {?>
                  	<div class="note"><img src="../icon/comment_warning.png" width="16" height="16" alt="Notes" /> &nbsp <strong><?php echo getCourseType($row_kursus['coursestype_id']); ?></strong> ini memerlukan peserta untuk menghantar laporan setelah selesai menghadirinya.</div>
                  <?php }; ?>
                  <?php if(checkCoursesNeedAttendence($row_kursus['courses_id'])) {?>
                  	<div class="note"><img src="../icon/comment_warning.png" width="16" height="16" alt="Notes" /> &nbsp <strong><?php echo getCourseType($row_kursus['coursestype_id']); ?></strong> ini memerlukan peserta untuk membuat pengesahan kehadiran sebagai syarat  kiraan Jam Kursus.</div>
                  <?php }; ?>
              </li>
                <?php if(checkEndDate($row_kursus['courses_id'])){?>
        		<?php if(!checkUserCoursesEntry($row_user['user_stafid'],$row_kursus['courses_id'])){?>
                <?php if(checkUserInCoursesDir($row_user['user_stafid'],$row_kursus['courses_id'],$row_kursus['dir_id'])){ ?>
                <?php if(checkUserInCoursesGroup($row_user['user_stafid'],$row_kursus['courses_id'],$row_kursus['group_id'])){ ?>
                <?php if(checkFullEntry($row_kursus['courses_id'])){ ?>
                <li class="form_back2">
                  <form id="apply" name="apply" method="POST" action="../sb/add_usercourses.php">
                   <span id="applyform">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                      	<td width="25" align="center" valign="top" class="noline"><input type="checkbox" name="coursesentry" value="1" id="coursesentry_0"/></td>
                        <td align="left" valign="top" class="noline">
                  <div class="txt_line"><span class="checkboxRequiredMsg">&laquo; Sila sahkan penyertaan anda.<br/></span>
                            <div class="padb">Saya memilih untuk menyertai <strong><?php echo getCourseType($row_kursus['coursestype_id']); ?></strong> ini mengikut kelulusan dan kebenaran. <?php echo $adname; ?> berhak untuk menolak atau mengubah maklumat berkaitan yang dinyatakan tanpa sebarang notis atau makluman.</div>
                            <div class="padt"><input name="courses_id" type="hidden" id="courses_id" value="<?php echo $row_kursus['courses_id']; ?>" />
                              <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" />
<input type="hidden" name="MM_insert" value="apply" />
<input name="url" type="hidden" id="url" value="1" />
<input name="button3" type="submit" class="submitbutton" id="button3" value="Daftar" /><input name="button4" type="button" class="cancelbutton" id="button4" value="Kembali" onclick="MM_goToURL('parent','<?php echo $url_main;?>courses/index.php');return document.MM_returnValue"/></div>
                        </div>
                        </td>
                      </tr>
                    </table>
                    </span>
                  </form>
                </li>
                <?php } else { //error jika kursus telah penuh kecuali TERBUKA (0)?>
                <li class="form_back2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" class="noline"><img src="../icon/sign_error.png" alt="Error" width="16" height="16" border="0" align="bottom" /></td>
                      <td width="100%" valign="middle" class="noline"><div class="txt_line"><strong><?php echo getCourseType($row_kursus['coursestype_id']); ?></strong> telah penuh. Sila pilih <?php echo getCourseType($row_kursus['coursestype_id']); ?> lain.</div></td>
                      <td valign="middle" class="noline"><input name="button5" type="button" class="cancelbutton" id="button5" value="Kembali" onclick="MM_goToURL('parent','<?php echo $url_main;?>courses/index.php');return document.MM_returnValue"/></td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
                <?php } else { // kursus utk kumpulan tertentu?>
                <li class="form_back2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle" class="noline"><img src="../icon/lock.png" alt="Lock" width="16" height="16" border="0" align="bottom" /></td>
                      <td width="100%" valign="middle" class="noline"><div class="txt_line"><strong><?php echo getCourseType($row_kursus['coursestype_id']); ?></strong> ini hanya dibuka untuk kumpulan <strong><?php echo getGroup($row_kursus['group_id']); ?></strong> sahaja.</div></td>
                      <td valign="middle" class="noline"><input name="button4" type="button" class="cancelbutton" id="button4" value="Kembali" onclick="MM_goToURL('parent','<?php echo $url_main;?>courses/index.php');return document.MM_returnValue"/></td>
                  </table>
                </li>					
				<?php };?>
                <?php } else { // kursus untuk Bahagian tertentu?>
                <li class="form_back2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" class="noline"><img src="../icon/lock.png" alt="Lock" width="16" height="16" border="0" align="bottom" /></td>
                      <td width="100%" valign="middle" class="noline"><div class="txt_line"><strong><?php echo getCourseType($row_kursus['coursestype_id']); ?></strong> ini hanya dibuka untuk <strong><?php echo getDirSubName($row_kursus['dir_id']); ?></strong> sahaja.</div></td>
                      <td valign="middle" class="noline"><input name="button5" type="button" class="cancelbutton" id="button5" value="Kembali" onclick="MM_goToURL('parent','<?php echo $url_main;?>courses/index.php');return document.MM_returnValue"/></td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
                <?php } else { //error jika pernah berdaftar utk kursus tersebut?>
                <li class="form_back2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" class="noline"><img src="../icon/sign_tick.png" alt="Error" width="16" height="16" border="0" align="bottom" /></td>
                      <td width="100%" valign="middle" class="noline"><div class="txt_line">Anda telah berdaftar untuk menyertai <strong><?php echo getCourseType($row_kursus['coursestype_id']); ?></strong> ini. Sebarang perubahan / penarikkan diri, sila maklum pada <?php echo $adname; ?>.</div></td>
                      <td valign="middle" class="noline"><input name="button5" type="button" class="cancelbutton" id="button5" value="Kembali" onclick="MM_goToURL('parent','<?php echo $url_main;?>courses/index.php');return document.MM_returnValue"/></td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
                <?php } else { //error jika tarikh kursus sudah tamat?>
                <li class="form_back2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" class="noline"><img src="../icon/sign_error.png" alt="Error" width="16" height="16" border="0" align="bottom" /></td>
                      <td width="100%" valign="middle" class="noline"><div class="txt_line"><strong><?php echo getCourseType($row_kursus['coursestype_id']); ?></strong> ini telah tamat.</div></td>
                      <td valign="middle" class="noline"><input name="button5" type="button" class="cancelbutton" id="button5" value="Kembali" onclick="MM_goToURL('parent','<?php echo $url_main;?>courses/index.php');return document.MM_returnValue"/></td>
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
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("applyform");
</script>
</body>
</html>
<?php
mysql_free_result($kursus);
?>
<?php include('../inc/footinc.php');?> 