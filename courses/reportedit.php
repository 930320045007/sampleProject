<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='4';?>
<?php $menu2='13';?>
<?php

$colname_ucr = "-1";
if (isset($_GET['ucrid'])) {
  $colname_ucr = getID(htmlspecialchars($_GET['ucrid'], ENT_QUOTES),0);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_ucr = sprintf("SELECT * FROM user_coursesreport WHERE usercoursesreport_id = %s", GetSQLValueString($colname_ucr, "int"));
$ucr = mysql_query($query_ucr, $hrmsdb) or die(mysql_error());
$row_ucr = mysql_fetch_assoc($ucr);
$totalRows_ucr = mysql_num_rows($ucr);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_uc = sprintf("SELECT * FROM user_courses WHERE usercourses_id = %s ORDER BY usercourses_id ASC", GetSQLValueString($row_ucr['usercourses_id'], "int"));
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
            	        <td width="50%"><?php echo getCoursesDate($row_uc['courses_id'], 0);?></td>
            	        <td class="label">Tempat</td>
            	        <td width="50%"><?php echo getCoursesLocation($row_uc['courses_id']);?></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Penganjur</td>
            	        <td colspan="3"><?php echo getOrganizedBy(0, $row_uc['courses_id']);?></td>
           	          </tr>
            	      <tr>
            	        <td colspan="4" nowrap="nowrap" class="label noline">Penceramah  / Modul Kursus / Tentatif Program*</td>
                      </tr>
                      <tr>
            	        <td colspan="4" class="noline">
            	          <textarea name="usercoursesreport_modul" id="usercoursesreport_modul" cols="45" rows="7"><?php echo $row_ucr['usercoursesreport_modul']; ?></textarea>
							<?php getEditor('usercoursesreport_modul', '1'); ?>
           	            </td>
          	        </tr>
            	      <tr>
            	        <td class="label noline" colspan="4">Pelaksanaan Kursus *</td>
                      </tr>
                      <tr>
            	        <td colspan="4" class="noline">
                          <span id="pelaksanaan">
                        <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
            	          <textarea name="usercoursesreport_implementation" id="usercoursesreport_implementation" cols="45" rows="7"><?php echo $row_ucr['usercoursesreport_implementation']; ?></textarea><?php getEditor('usercoursesreport_implementation', '1'); ?>
                          </span>
           	            </td>
          	        </tr>
            	      <tr>
            	        <td class="label noline" colspan="4">Input Baru yang dipelajari *</td>
                      </tr>
                      <tr>
            	        <td colspan="4" class="noline">
            	          <textarea name="usercoursesreport_newinput" id="usercoursesreport_newinput" cols="45" rows="15"><?php echo $row_ucr['usercoursesreport_newinput']; ?></textarea><?php getEditor('usercoursesreport_newinput', '1'); ?>
           	            </td>
          	        </tr>
            	      <tr>
            	        <td class="label noline" colspan="4">Ulasan / Pandangan &amp; Cadangan *</td>
                      </tr>
                      <tr>
            	        <td colspan="4" class="noline">
            	          <textarea name="usercoursesreport_review" id="usercoursesreport_review" cols="45" rows="7"><?php echo $row_ucr['usercoursesreport_review']; ?></textarea><?php getEditor('usercoursesreport_review', '1'); ?>
           	            </td>
          	        </tr>
            	      <tr>
            	        <td class="label noline" colspan="4">Pelan Tindakan Selepas Kursus *</td>
                      </tr>
                      <tr>
            	        <td colspan="4" class="noline">
                          <span id="pelan">
                        <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
            	          <textarea name="usercoursesreport_actionplan" id="usercoursesreport_actionplan" cols="45" rows="15"><?php echo $row_ucr['usercoursesreport_actionplan']; ?></textarea><?php getEditor('usercoursesreport_actionplan', '1'); ?></span>
           	           </td>
          	        </tr>
                    <tr>
                      <td colspan="4" class="noline"><input name="usercourses_id" type="hidden" id="usercourses_id" value="<?php echo $row_uc['usercourses_id']; ?>" />
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_uc['user_stafid']; ?>" />
<input name="courses_id" type="hidden" id="courses_id" value="<?php echo $row_uc['courses_id']; ?>" />
<input name="usercoursesreport_id" type="hidden" id="usercoursesreport_id" value="<?php echo $row_ucr['usercoursesreport_id']; ?>" />
<input type="hidden" name="MM_update" value="userreport" />
<input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                      <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','<?php echo $url_main;?>courses/reportread.php?id=<?php echo htmlspecialchars($row_ucr['usercourses_id'],ENT_QUOTES);?>&ucrid=<?php echo $row_ucr['usercoursesreport_id'];?>');return document.MM_returnValue" /></td>
                      </tr>
                  </table>
                </li>
            </ul>
           </form>
          </div>
        </div>
        <?php echo noteFooter('1');?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">

var sprytextarea = new Spry.Widget.ValidationTextarea("pelaksanaan");

var sprytextarea = new Spry.Widget.ValidationTextarea("pelan");
</script>
</body>
</html>
<?php
mysql_free_result($uc);

mysql_free_result($ucr);
?>
<?php include('../inc/footinc.php');?> 