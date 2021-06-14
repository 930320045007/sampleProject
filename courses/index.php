<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='4';?>
<?php $menu2='12';?>
<?php
$wsql = "";
$m = date('m');
$y = date('Y');

if(isset($_POST['jenis']) && $_POST['jenis']!='0')
{
	$wsql .= " AND coursestype_id='" . htmlspecialchars($_POST['jenis'], ENT_QUOTES) . "' ";
}
if(isset($_POST['bulan']) && $_POST['bulan']!='0')
{
	list($dmonth, $dyear) = explode("/", $_POST['bulan'], 2);
	$wsql .= " AND courses_start_m='" . htmlspecialchars($dmonth, ENT_QUOTES) . "' AND courses_start_y='" . htmlspecialchars($dyear, ENT_QUOTES) . "' ";
	$m = $dmonth;
	$y = $dyear;
	
} else {
	$wsql .= " AND courses_start_m='" . date('m') . "' AND courses_start_y='" . date('Y') . "' ";
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_kursus = 100;
$pageNum_kursus = 0;
if (isset($_GET['pageNum_kursus'])) {
  $pageNum_kursus = htmlspecialchars($_GET['pageNum_kursus'], ENT_QUOTES);
}

$startRow_kursus = $pageNum_kursus * $maxRows_kursus;

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kursus = "SELECT * FROM www.courses WHERE courses_view = '1' AND courses_status = 1 " . $wsql . " ORDER BY courses_start_y DESC, courses_start_m DESC, courses_start_d DESC, courses_end_y DESC, courses_end_m DESC, courses_end_d DESC, courses_id DESC";
$query_limit_kursus = sprintf("%s LIMIT %d, %d", $query_kursus, $startRow_kursus, $maxRows_kursus);
$kursus = mysql_query($query_limit_kursus, $hrmsdb) or die(mysql_error());
$row_kursus = mysql_fetch_assoc($kursus);

if (isset($_GET['totalRows_kursus'])) {
  $totalRows_kursus = htmlspecialchars($_GET['totalRows_kursus'], ENT_QUOTES);
} else {
  $all_kursus = mysql_query($query_kursus);
  $totalRows_kursus = mysql_num_rows($all_kursus);
}
$totalPages_kursus = ceil($totalRows_kursus/$maxRows_kursus)-1;

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jenis = "SELECT * FROM www.courses_type WHERE coursestype_status = 1 ORDER BY coursestype_name ASC";
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
<div class="passbox_back hidden2" id="langgan">
    <div class="passbox_form">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
            <tr>
              <td class="title">Langgan Jadual Kursus</td>
            </tr>
            <tr>
              <td class="txt_line">
              <div>Pindah turun atau langgan jadual kursus bagi tahun <?php echo date('Y');?> melalui URL berikut : </div>
              <div><a href="<?php echo $url_main;?>csv/jadualkursus.php"><em><?php echo $url_main;?>csv/jadualkursus.php</em></a></div>
              </td>
            </tr>
            <tr>
              <td>
              <input name="OK" type="button" class="submitbutton" value="OK" onclick="toggleview2('langgan'); return false;" />
              </td>
            </tr>
          </table>
    </div>
</div>

<div>
	<div>
		<?php include('../inc/header.php');?>
      <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_courses.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
            <?php if(!$maintenance){?>
            	<li class="form_back">
            	  <form id="sort" name="sort" method="post" action="index.php">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td class="noline label">Kategori</td>
            	        <td class="noline">
            	          <select name="jenis" id="jenis">
                          <option <?php if(isset($_POST['jenis']) && $_POST['jenis']=='0') echo "selected=\"selected\"";?> value="0">Semua</option>
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
            	        <td width="100%" class="noline">
                          <select name="bulan" id="bulan">
                          <?php for($i=0; $i<=6; $i++) {?>
							<option <?php if(($m . "/" . $y) == date('m/Y', mktime(0, 0, 0, ((date('m')+3)-$i), 1, date('Y')))) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, ((date('m')+3)-$i), 1, date('Y')));?>"><?php echo date('M Y', mktime(0, 0, 0, ((date('m')+3)-$i), 1, date('Y')));?></option>
                          <?php }; ?>
                          </select>
                          <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" />
                          </td>
                        <td class="noline"><span class="txt_right cursorpoint" onclick="toggleview2('langgan'); return false;">Langgan</span></td>
           	          </tr>
          	      </table>
          	      </form>
            	</li>
                <li>
                <div class="note w100">Berikut adalah senarai kursus yang ditawarkan pada bulan <strong><?php echo date('F Y', mktime(0, 0, 0, $m, 1, $y));?></strong> :</div>
                <div class="w100">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_kursus > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th nowrap="nowrap">Bil</th>
                      <th align="left" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                      <th align="center" valign="middle" nowrap="nowrap">Peserta</th>
                      <th nowrap="nowrap">Kiraan</th>
                    </tr>
                    <?php $rownum = ($pageNum_kursus*$maxRows_kursus)+1; do { ?>
                      <tr class="<?php if(checkEndDate($row_kursus['courses_id'])) echo "on"; else echo "offcourses";?>">
                        <td valign="middle"><?php echo $rownum; ?></td>
                        <td align="left" valign="middle" nowrap="nowrap"><div class="txt_line"><?php echo getCoursesDate($row_kursus['courses_id']);?></div></td>
                        <td valign="top" class="txt_line">
                        <a href="coursesdetail.php?id=<?php echo getID($row_kursus['courses_id']); ?>">
                        <div><strong><?php echo $row_kursus['courses_name']; ?></strong></div>
                        <div>Anjuran : <?php echo getOrganizedBy($row_kursus['organizedby_id'],$row_kursus['courses_id']); ?><?php if($row_kursus['courses_time']!=NULL) echo " &nbsp; <span class=\"txt_color1\">&bull;</span> &nbsp; Masa : " . $row_kursus['courses_time']; ?> <?php if($row_kursus['courses_location']!=NULL){ ?>&nbsp; <span class="txt_color1">&bull;</span> &nbsp; Tempat : <?php echo $row_kursus['courses_location']; ?><?php }; ?>
                          <?php if($row_kursus['dir_id']!='0' || $row_kursus['group_id']!='0'){ ?>
                          <?php if($row_kursus['dir_id']!='0') echo "<div><span class=\"txt_color1\">&bull;</span> &nbsp; Pengkhususan : " . getDirSubName($row_kursus['dir_id']) . "</div>"; ?> 
                          <?php if($row_kursus['group_id']!='0') echo "<div><span class=\"txt_color1\">&bull;</span> &nbsp; Kumpulan : " . getGroup($row_kursus['group_id']) . "</div>"; ?>
                          <?php }; ?>
                          </div>
                          </a>
                          </td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php if(checkCoursesNeedAttendence($row_kursus['courses_id'])) echo "&radic;"; else echo "&nbsp;";?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getCoursesEntryorFull($row_kursus['courses_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getCoursesDuration($row_kursus['courses_id']);?> <?php echo getDurationType($row_kursus['durationtype_id']); ?></td>
                      </tr>
                      <?php $rownum++; } while ($row_kursus = mysql_fetch_assoc($kursus)); ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="txt_color1 noline">
                      <ul class="func2">
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
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                <?php } else { ?>
          		<li><div class="note">Sistem dalam proses pengemaskinian dan penambahbaikkan.</div></li>
                <?php }; ?>
            </ul>
          </div>
        </div>
        <?php echo noteCoursesReport('1');?>
        <?php echo noteEmail('1');?>
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
