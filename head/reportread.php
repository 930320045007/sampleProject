<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='7';?>
<?php $menu2='18';?>
<?php $menu3 = '4';?>
<?php

if (isset($_GET['ucrid'])) {
  $colname_ucr = htmlspecialchars($_GET['ucrid'], ENT_QUOTES);
} else {
	$colname_ucr = "-1";
};

if(isset($_GET['sid']))
{
	$staffid = getStafIDByUserID(getID($_GET['sid'],0));
} else {
	$staffid = $row_user['user_stafid'];
};

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
        <?php include('../inc/menu_unit.php');?>
        <div class="tabbox">
          <div class="profilemenu">
           <?php if (getUserUnitIDByUserID($row_user['user_stafid'])==getUserUnitIDByUserID($staffid)){?>
            <?php include('../inc/menu_head.php');?>
          	<ul>
            	<li class="line_b">
            	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	    <tr>
            	      <td class="noline txt_size3"><strong><?php echo getCoursesName($row_uc['courses_id']);?></strong></td>
          	      </tr>
            	    <tr>
            	      <td class="noline txt_line"><strong>Tarikh : </strong><?php echo getCoursesDate($row_uc['courses_id'], 0);?>, <strong> &nbsp; &bull; &nbsp; Tempat : </strong><?php echo getCoursesLocation($row_uc['courses_id']);?>, <strong> &nbsp; &bull; &nbsp; Penganjur : </strong><?php echo getOrganizedBy(0, $row_uc['courses_id']);?></td>
          	      </tr>
          	    </table>
           	    </li>
                  <li class="line_b">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	    <tr>
            	      <td colspan="4" class="noline txt_size3"><strong>Penceramah dan tajuk / Kertas Kerja / Modul Kursus</strong></td>
           	        </tr>
            	    <tr>
            	      <td colspan="4" class="noline txt_line"><?php echo htmlspecialchars_decode($row_ucr['usercoursesreport_modul'], ENT_QUOTES); ?></td>
           	        </tr>
                  </table>
                  </li>
                  <li class="line_b">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	    <tr>
            	      <td colspan="4" class="noline txt_size3"><strong>Perlaksanaan Kursus</strong></td>
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
            	      <td colspan="4" class="noline txt_size3"><strong>Pelan Tindakan / Tugasan </strong></td>
           	        </tr>
            	    <tr>
            	      <td colspan="4" class="noline txt_line"><?php echo htmlspecialchars_decode($row_ucr['usercoursesreport_actionplan'], ENT_QUOTES); ?></td>
           	        </tr>
          	      </table>
                  </li>
            </ul>
             <?php }else{ ?>
           <ul><li><div class="note" >Tiada rekod yang dijumpai.</div></li></ul>
           <?php };?>
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