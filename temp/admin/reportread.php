<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='11';?>
<?php
$colname_ucr = "-1";
if (isset($_GET['ucrid'])) {
  $colname_ucr = htmlspecialchars($_GET['ucrid'], ENT_QUOTES);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_ucr = sprintf("SELECT * FROM user_coursesreport WHERE usercoursesreport_id = %s", GetSQLValueString($colname_ucr, "int"));
$ucr = mysql_query($query_ucr, $hrmsdb) or die(mysql_error());
$row_ucr = mysql_fetch_assoc($ucr);
$totalRows_ucr = mysql_num_rows($ucr);
?>
<?php
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
            	<li class="form_back">
            	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	    <tr>
            	      <td nowrap="nowrap" class="label">Nama</td>
            	      <td colspan="3"><div class="txt_line"><strong><?php echo getFullNameByStafID($row_uc['user_stafid']);?></strong><br /><?php echo getJobtitle($row_uc['user_stafid']);?>, &nbsp; <?php echo getFulldirectoryByUserID($row_uc['user_stafid']);?></div></td>
           	        </tr>
            	    <tr>
            	      <td class="label">Tajuk</td>
            	      <td colspan="3"><strong><?php echo getCoursesName($row_uc['courses_id']);?></strong></td>
          	        </tr>
            	    <tr>
            	      <td class="label">Tarikh</td>
            	      <td width="50%"><?php echo getCoursesDate($row_uc['courses_id'], 0);?></td>
            	      <td class="label">Tempat</td>
            	      <td width="50%"><?php echo getCoursesLocation($row_uc['courses_id']);?></td>
          	      </tr>
            	    <tr>
            	      <td class="label noline">Penganjur</td>
            	      <td colspan="3" class="noline"><?php echo getOrganizedBy(0, $row_uc['courses_id']);?></td>
           	        </tr>
                   </table>
                   </li>
                   <li class="line_b">
            	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	    <tr>
            	      <td colspan="4" class="noline txt_size3"><strong>Penceramah / Modul Kursus / Tentatif Program</strong></td>
           	        </tr>
            	    <tr>
            	     <td colspan="4" class="noline txt_line"><?php echo htmlspecialchars_decode($row_ucr['usercoursesreport_modul'], ENT_QUOTES); ?></td>
           	        </tr>
                   </table>
                   </li>
                   <li class="line_b">
            	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	    <tr>
            	      <td colspan="4" class="noline txt_size3"><strong>Pelaksanaan Kursus</strong></td>
           	        </tr>
            	    <tr>
            	      <td colspan="4" class="noline txt_line"><?php echo htmlspecialchars_decode($row_ucr['usercoursesreport_implementation'], ENT_QUOTES); ?></td>
           	        </tr>
                   </table>
                   </li>
                   <li class="line_b">
            	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	    <tr>
            	      <td colspan="4" class="noline txt_size3"><strong>Input Baru yang dipelajari</strong></td>
           	        </tr>
            	    <tr>
            	      <td colspan="4" class="noline txt_line"><?php echo htmlspecialchars_decode($row_ucr['usercoursesreport_newinput'], ENT_QUOTES); ?></td>
           	        </tr>
                   </table>
                   </li>
                   <li class="line_b">
            	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	    <tr>
            	      <td colspan="4" class="noline txt_size3"><strong>Ulasan / Pandangan &amp; Cadangan</strong></td>
           	        </tr>
            	    <tr>
            	      <td colspan="4" class="noline txt_line"><?php echo htmlspecialchars_decode($row_ucr['usercoursesreport_review'], ENT_QUOTES); ?></td>
           	        </tr>
                   </table>
                   </li>
                   <li class="line_b">
            	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	    <tr>
            	      <td colspan="4" class="noline txt_size3"><strong>Pelan Tindakan Selepas Kursus</strong></td>
           	        </tr>
            	    <tr>
            	     <td colspan="4" class="noline txt_line"><?php echo htmlspecialchars_decode($row_ucr['usercoursesreport_actionplan'], ENT_QUOTES); ?></td>
           	        </tr>
          	      </table>
                  </li>
              <li class="form_back2">
                <form id="formhr" name="formhr" method="POST" action="../sb/add_userreport.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Kelulusan</td>
                      <td width="100%">
                      <ul class="inputradio">
                      	<li><input <?php if (!(strcmp($row_ucr['hr_approval'],"1"))) {echo "checked=\"checked\"";} ?> name="hr_approval" type="radio" id="lulus_0" value="1" checked="checked" /> Lulus</li>
                        <li><input <?php if (!(strcmp($row_ucr['hr_approval'],"0"))) {echo "checked=\"checked\"";} ?> type="radio" name="hr_approval" value="0" id="lulus_1" />Penambahbaikkan</li>
                      </ul>
                      </td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Maklum Balas</td>
                      <td><label for="hr_comment"></label>
                      <textarea name="hr_comment" id="hr_comment" cols="45" rows="5"><?php echo $row_ucr['hr_comment']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td><input name="MM_update_hr" type="hidden" id="MM_update_hr" value="formhr" />
                      <input name="usercoursesreport_id" type="hidden" id="usercoursesreport_id" value="<?php echo $row_ucr['usercoursesreport_id']; ?>" /></td>
                      <td><input name="edit" type="submit" class="submitbutton" id="edit" value="Hantar"/>
                      <input name="back" type="button" class="cancelbutton" id="back" value="Kembali" onclick="MM_goToURL('parent','<?php echo $url_main;?>admin/coursesdetail.php?id=<?php echo htmlspecialchars($row_uc['courses_id'],ENT_QUOTES); ?>');return document.MM_returnValue" /></td>
                    </tr>
                  </table>
                </form>
              </li>
            </ul>
          </div>
        </div>
</div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($uc);

mysql_free_result($ucr);
?>
<?php include('../inc/footinc.php');?> 