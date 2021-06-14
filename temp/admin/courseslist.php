<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='11';?>
<?php
$wsql = "";
if(isset($_POST['jenis']) && $_POST['jenis']!=0)
{
	$wsql .= " AND coursestype_id='" . $_POST['jenis'] . "' ";
}
if(isset($_POST['bulan']) && $_POST['bulan']!='0')
{
	list($dmonth, $dyear) = explode("/", $_POST['bulan'], 2);
	
	if($dmonth != 0)
	$wsql .= " AND courses_start_m='" . $dmonth . "'";
	
	$wsql .= " AND courses_start_y='" . $dyear . "' ";
} else {
	$wsql .= " AND courses_start_m='" . date('m') . "' AND courses_start_y='" . date('Y') . "' ";
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_kursus = 100;
$pageNum_kursus = 0;
if (isset($_GET['pageNum_kursus'])) {
  $pageNum_kursus = $_GET['pageNum_kursus'];
}
$startRow_kursus = $pageNum_kursus * $maxRows_kursus;

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kursus = "SELECT * FROM courses WHERE courses_status = 1 " . $wsql . " ORDER BY courses_start_y DESC, courses_start_m DESC, courses_start_d DESC, courses_id DESC";
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

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jenis = "SELECT * FROM courses_type WHERE coursestype_status = 1 ORDER BY coursestype_name ASC";
$jenis = mysql_query($query_jenis, $hrmsdb) or die(mysql_error());
$row_jenis = mysql_fetch_assoc($jenis);
$totalRows_jenis = mysql_num_rows($jenis);

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
        <?php include('../inc/menu_admin.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
        <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){ ?>
            	<li class="form_back">
            	  <form id="sort" name="sort" method="post" action="courseslist.php">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td class="noline label">Kategori</td>
            	        <td class="noline">
            	          <select name="jenis" id="jenis">
                            <option value="0" <?php if(isset($_POST['jenis']) && $_POST['jenis']==0) echo "selected=\"selected\"";?>>Semua</option>
            	            <?php
							do {  
							?>
            	            <option <?php if(isset($_POST['jenis']) && $_POST['jenis']==$row_jenis['coursestype_id']) echo "selected=\"selected\"";?> value="<?php echo $row_jenis['coursestype_id']?>"><?php echo $row_jenis['coursestype_name']?></option>
            	            <?php
							} while ($row_jenis = mysql_fetch_assoc($jenis));
							  $rows = mysql_num_rows($jenis);
							  if($rows > 0) {
								  mysql_data_seek($jenis, 0);
								  $row_jenis = mysql_fetch_assoc($jenis);
							  }
							?>
                        </select></td>
            	        <td class="noline label">Bulan </td>
            	        <td width="100%" nowrap="nowrap" class="noline">
                        <select name="bulan" id="bulan">
                        	<option value="0/<?php echo date('Y');?>"><?php echo date('Y');?></option>
                            <?php for($i=0; $i<=12; $i++){?>
                        	<option value="<?php echo date('m', mktime(0, 0, 0, ((date('m')+1)-$i), 1, date('Y'))) . "/" . date('Y', mktime(0, 0, 0, ((date('m')+1)-$i), 1, date('Y')));?>"><?php echo date('M Y', mktime(0, 0, 0, ((date('m')+1)-$i), 1, date('Y')));?></option>
                            <?php }; ?>
                        </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
            	        <td nowrap="nowrap" class="noline"><input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="MM_goToURL('parent','coursesadd.php');return document.MM_returnValue"/></td>
           	          </tr>
          	      </table>
          	      </form>
            	</li>
                <li>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_kursus > 0) { // Show if recordset not empty ?>
    <tr>
      <th nowrap="nowrap">Bil</th>
      <th align="left" valign="middle" nowrap="nowrap">Tarikh</th>
      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
      <th align="center" valign="middle" nowrap="nowrap">Pengesahan<br/>Kehadiran</th>
      <th align="center" valign="middle" nowrap="nowrap">Hadir</th>
      <th align="center" valign="middle" nowrap="nowrap">Peserta</th>
      <th nowrap="nowrap">Kiraan</th>
      <th nowrap="nowrap">&nbsp;</th>
    </tr>
    <?php $rownum = ($pageNum_kursus*$maxRows_kursus)+1; do { ?>
      <tr class="on">
        <td valign="middle"><?php echo $rownum; ?></td>
        <td align="left" valign="middle" nowrap="nowrap"><div class="txt_line"><?php echo getCoursesDate($row_kursus['courses_id']);?></div></td>
        <td valign="top"><div class="txt_line"><strong class="txt_size3"><a href="coursesdetail.php?id=<?php echo $row_kursus['courses_id']; ?>"><?php echo $row_kursus['courses_name']; ?></a></strong><br />Anjuran : <?php echo getOrganizedBy($row_kursus['organizedby_id'],$row_kursus['courses_id']); ?> &nbsp; <span class="txt_color1">&bull;</span> &nbsp; Tempat : <?php echo $row_kursus['courses_location']; ?>
          <?php if($row_kursus['dir_id']!='0' || $row_kursus['group_id']!='0'){ ?>
		  <?php if($row_kursus['dir_id']!='0') echo "<div><span class=\"txt_color1\">&bull;</span> &nbsp; Pengkhususan : " . getDirSubName($row_kursus['dir_id']) . "</div>"; ?> 
		  <?php if($row_kursus['group_id']!='0') echo "<div><span class=\"txt_color1\">&bull;</span> &nbsp; Kumpulan : " . getGroup($row_kursus['group_id']) . "</div>"; ?>
		  <?php }; ?>
          </div></td>
        <td align="center" valign="middle" nowrap="nowrap"><?php if(checkCoursesNeedAttendence($row_kursus['courses_id'])) echo "&radic;"; else echo "&nbsp;";?></td>
        <td align="center" valign="middle" nowrap="nowrap"><?php $tt = getTotalAttendence($row_kursus['courses_id']); if(checkCoursesNeedAttendence($row_kursus['courses_id'])) { echo $tt['0'];} else { echo $tt['1'];};?></td>
        <td align="center" valign="middle" nowrap="nowrap"><?php echo getUserCoursesEntryandTotal($row_kursus['courses_id']);?></td>
        <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_kursus['courses_duration']; ?> <?php echo getDurationType($row_kursus['durationtype_id']); ?></td>
        <td align="center" valign="middle" nowrap="nowrap"><ul class="func"><li><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){ ?><a onclick="return confirm('PERINGATAN! Kakitangan yang sudah berdaftar tidak akan dimaklumkan berkaitan pembatalan <?php echo getCourseType(getCoursesTypeID($row_kursus['courses_id']));?> ini. Anda mahu <?php echo getCourseType(getCoursesTypeID($row_kursus['courses_id']));?> berikut dipadam? \r\n\n <?php echo getCoursesDate($row_kursus['courses_id'], 0);?> \r\n\n <?php echo getCoursesName($row_kursus['courses_id']); ?>')" href="../sb/del_coursesadmin.php?delc=1&cid=<?php echo $row_kursus['courses_id']; ?>">X</a><?php }; ?></li></ul></td>
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