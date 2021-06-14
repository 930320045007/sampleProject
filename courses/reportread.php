<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='4';?>
<?php $menu2='13';?>
<?php
$colname_ucr = "-1";
if (isset($_GET['ucrid'])) {
  $colname_ucr = getID(htmlspecialchars($_GET['ucrid'],ENT_QUOTES),0);
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
        <?php include('../inc/menu_courses.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
            	<li class="line_b">
            	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	    <tr>
            	      <td class="noline txt_size3"><strong><?php echo getCoursesName($row_uc['courses_id']);?></strong></td>
          	      </tr>
            	    <tr>
            	      <td class="noline"><strong>Tarikh : </strong><?php echo getCoursesDate($row_uc['courses_id'], 0);?>, <strong>Tempat : </strong><?php echo getCoursesLocation($row_uc['courses_id']);?>, <strong>Penganjur : </strong><?php echo getOrganizedBy(0, $row_uc['courses_id']);?></td>
          	      </tr>
          	    </table>
           	    </li>
                  <li class="line_b">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	    <tr>
            	      <td colspan="4" class="noline txt_size3"><strong>Penceramah  / Modul Kursus / Tentatif Program</strong></td>
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
              	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if($row_ucr['hr_approval'] == 0){?>
				<?php if($row_ucr['hr_comment']!=NULL){?>
              	  <tr>
                  	<td><img src="../icon/comment_warning.png" width="16" height="16" alt="Komen" /></td>
              	    <td width="100%"><strong><?php echo getFullNameByStafID($row_ucr['hr_by']);?></strong> <span class="txt_color1"><?php echo $row_ucr['hr_date']; ?></span></td>
           	      </tr>
                  <tr>
                  	<td></td>
                  	<td><div class="txt_line"><?php echo $row_ucr['hr_comment'];?></div></td>
                  </tr>
                  <?php } else { ?>
                  <tr>
                  	<td><img src="../icon/comment.png" width="16" height="16" alt="Komen" /></td>
                  	<td width="100%" class="noline">Kilk pada butang Kemaskini untuk membuat pembetulan / penambahbaikkan pada laporan.</td>
                  </tr>
                  <?php }; ?>
              	  <tr>
                  	<td></td>
              	    <td class="noline"><input name="edit" type="button" class="submitbutton" id="edit" value="Kemaskini" onclick="MM_goToURL('parent','<?php echo $url_main;?>courses/reportedit.php?id=<?php echo htmlspecialchars($row_ucr['usercourses_id'],ENT_QUOTES);?>&ucrid=<?php echo $row_ucr['usercoursesreport_id'];?>');return document.MM_returnValue" /><input name="back" type="button" class="cancelbutton" id="back" value="Kembali" onclick="MM_goToURL('parent','<?php echo $url_main;?>courses/report.php');return document.MM_returnValue" /></td>
           	      </tr>
                  <?php } else { ?>
                  <tr>
                  	<td><img src="../icon/sign_tick.png" width="16" height="16" alt="Lulus" /></td>
                  	<td width="100%" class="noline">Laporan telah diluluskan oleh <strong><?php echo getFullNameByStafID($row_ucr['hr_by']);?></strong> pada <?php echo $row_ucr['hr_date']; ?></td>
                  </tr>
                  <?php }; ?>
           	    </table>
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