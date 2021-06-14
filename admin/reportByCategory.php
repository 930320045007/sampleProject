<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='14';?> 
<?php $menu3='3';?> 
<?php

if(isset($_GET['tahun']))
	$dateyear = $_GET['tahun'];
else
	$dateyear = date('Y');
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_category = "SELECT * FROM www.courses_type WHERE coursestype_status = 1 ORDER BY coursestype_id ASC";
$category = mysql_query($query_category, $hrmsdb) or die(mysql_error());
$row_category = mysql_fetch_assoc($category);
$totalRows_category = mysql_num_rows($category);

if(isset($_GET['cat']))
	$type = $_GET['cat'];
else
	$type = $row_category['coursestype_id'];
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kump = "SELECT * FROM `group` WHERE group_status = 1 ORDER BY group_id ASC";
$kump = mysql_query($query_kump, $hrmsdb) or die(mysql_error());
$row_kump = mysql_fetch_assoc($kump);
$totalRows_kump = mysql_num_rows($kump);	
	
	if(isset($_GET['group']))
	$g = $_GET['group'];
else
	$g = $row_kump['group_id'];
	
	
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_kursus = 100;
$pageNum_kursus = 0;
if (isset($_GET['pageNum_kursus'])) {
  $pageNum_kursus = $_GET['pageNum_kursus'];
}
$startRow_kursus = $pageNum_kursus * $maxRows_kursus;	

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kursus = "SELECT * FROM courses WHERE courses_status = 1 AND courses_start_y= '" . $dateyear . "' AND coursestype_id = '" .$type. "' AND courses.group_id = '" .$g. "' ORDER BY courses_start_y DESC, courses_start_m DESC, courses_start_d DESC, courses.courses_id DESC";
$query_limit_kursus = sprintf("%s LIMIT %d, %d", $query_kursus, $startRow_kursus, $maxRows_kursus);
$kursus = mysql_query($query_limit_kursus, $hrmsdb) or die(mysql_error());
$row_kursus = mysql_fetch_assoc($kursus);

if (isset($_GET['totalRows_kursus'])) {
  $totalRows_kursus = $_GET['totalRows_kursus'];
} else {
  $all_kursus = mysql_query($query_kursus);
  $totalRows_kursus = mysql_num_rows($all_kursus);
}
$totalPages_kursus = ceil($totalRows_kursus/$maxRows_kursus)-1;

$queryString_kursus = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_kursus") == false && 
        stristr($param, "totalRows_kursus") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_kursus = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_kursus = sprintf("&totalRows_kursus=%d%s", $totalRows_kursus, $queryString_kursus);


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
        <?php include('../inc/menu_ict.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <?php include('../inc/menu_senarailaporan.php');?>
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
              <li class="line_b">
                  <form id="form1" name="form1" method="get" action="reportByCategory.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Kategori</td>
                        <td class="noline">
                          <select name="cat" id="cat">
                            <?php
							do {  
							?>
                            <option <?php if($type == $row_category['coursestype_id']) echo "selected=\"selected\"";?> value="<?php echo $row_category['coursestype_id']?>"><?php echo $row_category['coursestype_name']?></option>
                            <?php
							} while ($row_category = mysql_fetch_assoc($category));
							  $rows = mysql_num_rows($category);
							  if($rows > 0) {
								  mysql_data_seek($category, 0);
								  $row_category = mysql_fetch_assoc($category);
							  }
							?>
                          </select>
                          </td>
                           <td class="label noline">Kumpulan</td>
                        <td class="noline">
                          <select name="group" id="group">
                            <?php
							do {  
							?>
                            <option <?php if($g == $row_kump['group_id']) echo "selected=\"selected\"";?> value="<?php echo $row_kump['group_id']?>"><?php echo $row_kump['group_name']?></option>
                            <?php
							} while ($row_kump = mysql_fetch_assoc($kump));
							  $rows = mysql_num_rows($kump);
							  if($rows > 0) {
								  mysql_data_seek($kump, 0);
								  $row_kump = mysql_fetch_assoc($kump);
							  }
							?>
                          </select>
                          </td>
                          <td class="label noline">Tahun</td>
                        <td width="100%" class="noline">
                           <select name="tahun" id="tahun">
                          <?php for($i=date('Y'); $i>=2011; $i--){?>
                            <option <?php if($dateyear==$i) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                      </tr>
                    </table>
                </form>
                </li>
                <li>
                <div class="note">Kehadiran Pegawai mengikut kategori kursus<strong></strong></div>
               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_kursus > 0) { // Show if recordset not empty ?>
    <tr>
      <th nowrap="nowrap">Bil</th>
      <th align="left" valign="middle" nowrap="nowrap">Tarikh</th>
      <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama Kursus</th>
      <th align="center" valign="middle" nowrap="nowrap">Hadir</th>
      <th align="center" valign="middle" nowrap="nowrap">Peserta</th>
    </tr>
    <?php $rownum = ($pageNum_kursus*$maxRows_kursus)+1; do { ?>
      <tr class="on">
        <td valign="middle"><?php echo $rownum; ?></td>
        <td align="left" valign="middle" nowrap="nowrap"><div class="txt_line"><?php echo getCoursesDate($row_kursus['courses_id']);?></div></td>
        <td valign="top"><div class="txt_line"><strong class="txt_size3"><?php echo $row_kursus['courses_name']; ?></strong><br />Anjuran : <?php echo getOrganizedBy($row_kursus['organizedby_id'],$row_kursus['courses_id']); ?> &nbsp; <span class="txt_color1">&bull;</span> &nbsp; Tempat : <?php echo $row_kursus['courses_location']; ?></div></td>
        <td align="center" valign="middle" nowrap="nowrap"><?php $tt = getTotalAttendence($row_kursus['courses_id']); if(checkCoursesNeedAttendence($row_kursus['courses_id'])) { echo $tt['0'];} else { echo $tt['1'];};?></td>
        <td align="center" valign="middle" nowrap="nowrap"><?php echo getUserCoursesEntryandTotal($row_kursus['courses_id']);?></td>
      </tr>
      <?php $rownum++; } while ($row_kursus = mysql_fetch_assoc($kursus)); ?>
    <tr>
      <td colspan="8" align="center" valign="middle" class="txt_color1 noline">
	  <ul class="func">
        <?php if ($pageNum_kursus > 0) { // Show if not first page ?>
  <li><a href="<?php printf("%s?pageNum_kursus=%d%s", $currentPage, max(0, $pageNum_kursus - 1), $queryString_kursus); ?>">&laquo;</a></li>
  <?php } // Show if not first page ?>
<li><?php echo $totalRows_kursus ?>  rekod dijumpai</li>
        <?php if ($pageNum_kursus < $totalPages_kursus) { // Show if not last page ?>
          <li><a href="<?php printf("%s?pageNum_kursus=%d%s", $currentPage, min($totalPages_kursus, $pageNum_kursus + 1), $queryString_kursus); ?>">&raquo;</a></li>
          <?php } // Show if not last page ?>
      </ul>
      </td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="8" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
    </tr>
    <?php }; ?>
  </table>
      </li>
                <?php } else { ?>
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
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($kursus);

mysql_free_result($jenis);
?>
<?php include('../inc/footinc.php');?>
