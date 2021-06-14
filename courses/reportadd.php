<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='4';?>
<?php $menu2='13';?>
<?php
$colname_uc = "-1";
if (isset($_GET['id'])) {
  $colname_uc = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_uc = sprintf("SELECT * FROM user_courses WHERE usercourses_id = %s ORDER BY usercourses_id ASC", GetSQLValueString($colname_uc, "int"));
$uc = mysql_query($query_uc, $hrmsdb) or die(mysql_error());
$row_uc = mysql_fetch_assoc($uc);
$totalRows_uc = mysql_num_rows($uc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
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
        <?php include('../inc/menu_courses.php');?>
        <div class="tabbox">
          <div class="profilemenu">
           <?php if(!checkReportSubmit($row_uc['user_stafid'], $row_uc['courses_id'])){ ?>
           <form id="userreport" name="userreport" method="POST" action="../sb/add_userreport.php">
          	<ul>
                <li>
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td class="label">Tajuk</td>
            	        <td colspan="3"><strong><?php echo getCoursesName($row_uc['courses_id']);?> </strong></td>
           	          </tr>
            	      <tr>
            	        <td class="label">Tarikh</td>
            	        <td><?php echo getCoursesDate($row_uc['courses_id'], 0);?></td>
            	        <td class="label">Tempat</td>
            	        <td><?php echo getCoursesLocation($row_uc['courses_id']);?></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Penganjur</td>
            	        <td colspan="3"><?php echo getOrganizedBy(0, $row_uc['courses_id']);?></td>
           	          </tr>
            	      <tr>
            	        <td class="label noline" colspan="4">Penceramah  / Modul Kursus /Tentatif Program</td>
                        </tr>
                        <tr>
            	        <td colspan="4" class="noline">
            	          <textarea name="usercoursesreport_modul" id="usercoursesreport_modul" cols="45" rows="7"></textarea>
                          <?php getEditor('usercoursesreport_modul', '1'); ?>
           	            </td>
          	        </tr>
            	      <tr>
            	        <td class="label noline" colspan="4">Pelaksanaan Kursus </td>
                        </tr>
                        <tr>
            	        <td colspan="4" class="noline">
                          <span id="pelaksanaan">
                        <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
            	          <textarea name="usercoursesreport_implementation" id="usercoursesreport_implementation" cols="45" rows="7"></textarea>
                          <?php getEditor('usercoursesreport_implementation', '1'); ?></span>
           	            </td>
          	        </tr>
            	      <tr>
            	        <td class="label noline" colspan="4">Input Baru yang dipelajari </td>
                        </tr>
                        <tr>
            	        <td colspan="4" class="noline">
            	          <textarea name="usercoursesreport_newinput" id="usercoursesreport_newinput" cols="45" rows="15"></textarea>
                          <?php getEditor('usercoursesreport_newinput', '1'); ?>
           	            </td>
          	        </tr>
            	      <tr>
            	        <td class="label noline" colspan="4">Ulasan / Pandangan &amp; Cadangan </td>
                        </tr>
                        <tr>
            	        <td colspan="4" class="noline">
            	          <textarea name="usercoursesreport_review" id="usercoursesreport_review" cols="45" rows="7"></textarea>
                          <?php getEditor('usercoursesreport_review', '1'); ?>
           	            </td>
          	        </tr>
            	      <tr>
            	        <td class="label noline" colspan="4">Pelan Tindakan Selepas Kursus</td>
                        </tr>
                        <tr>
            	        <td colspan="4" class="noline">
                        <span id="pelan">
                        <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
            	          <textarea name="usercoursesreport_actionplan" id="usercoursesreport_actionplan" cols="45" rows="15"></textarea>
                          <?php getEditor('usercoursesreport_actionplan', '1'); ?>
                          </span>
           	            </td>
          	        </tr>
          	      </table>
           	  </li>
                <li class="title">Maklum balas</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Penilaian</td>
                      <td>
                        <ul class="inputradio">
                       	  <li class="txt_color1">Tidak Memuaskan</li>
                       	  <li><input name="usercoursesreport_rating" type="radio" id="rating_0" value="1" />1</li>
                       	  		<li><input name="usercoursesreport_rating" type="radio" id="rating_1" value="2" />2</li>
                            	<li><input name="usercoursesreport_rating" type="radio" id="rating_2" value="3" checked="checked" />3</li>
                            	<li><input name="usercoursesreport_rating" type="radio" id="rating_3" value="4" />4</li>
                            	<li><input name="usercoursesreport_rating" type="radio" id="rating_4" value="5" />5</li>
                        	<li class="txt_color1">Sangat Baik</li>
                        </ul>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="middle" >
                        <ul class="inputradio">
                           	<li class="labelli">Perlukah kursus ini diteruskan pada masa akan datang?</li>
                            	<li><input name="usercoursesreport_nextyear" type="radio" id="nextyear_0" value="1" checked="checked" />Ya</li>
                            	<li><input type="radio" name="usercoursesreport_nextyear" value="0" id="nextyear_1" />Tidak</li>
                        </ul>
                      </td>
                    </tr>
                    <tr>
                      <td class="label">Maklum balas</td>
                      <td><label for="usercoursesreport_comment"></label>
                        <span id="usercomment"><span class="textareaMaxCharsMsg">Pastikan had dalam 300 huruf.</span>
                        <textarea name="usercoursesreport_comment" id="usercoursesreport_comment" cols="45" rows="5"></textarea>
                      <div class="txt_color1"><span id="countusercomment">&nbsp;</span> huruf</div></span></td>
                    </tr>
                    <tr>
                      <td class="noline"><input type="hidden" name="MM_insert" value="formreport" />
                        <input name="usercourses_id" type="hidden" id="usercourses_id" value="<?php echo $row_uc['usercourses_id']; ?>" />
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_uc['user_stafid']; ?>" />
<input name="courses_id" type="hidden" id="courses_id" value="<?php echo $row_uc['courses_id']; ?>" /></td>
                      <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Hantar" />
                      <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','<?php echo $url_main;?>courses/report.php');return document.MM_returnValue" /></td>
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
           	      <td align="center" valign="middle" class="noline"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /></td>
           	      <td width="100%" align="left" valign="middle" class="noline">Laporan telah dihantar bagi kursus ini. </td>
       	        </tr>
       	      </table>
           	</li>
           </ul>
           <?php }; ?>
          </div>
        </div>
        <?php echo noteFooter('1');?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("usercomment", {counterId:"countusercomment", counterType:"chars_remaining", isRequired:false, maxChars:300});

var sprytextarea = new Spry.Widget.ValidationTextarea("pelaksanaan");

var sprytextarea = new Spry.Widget.ValidationTextarea("pelan");
</script>
</body>
</html>
<?php
mysql_free_result($uc);
?>
<?php include('../inc/footinc.php');?> 