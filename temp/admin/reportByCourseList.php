<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='14';?>
<?php $menu3='4';?> 
<?php
$wsql = "";

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
$query_kursus = "SELECT * FROM courses WHERE courses_status = 1 " . $wsql . " ORDER BY courses_start_y ASC, courses_start_m ASC, courses_start_d ASC, courses_id ASC";
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>
            	<li class="form_back">
            	  <form id="sort" name="sort" method="post" action="reportByCourseList.php">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td class="noline label">Bulan </td>
            	        <td width="100%" nowrap="nowrap" class="noline">
                        <select name="bulan" id="bulan">
                        	<option value="0/<?php echo date('Y');?>"><?php echo date('Y');?></option>
                            <?php for($i=0; $i<=12; $i++){?>
                        	<option value="<?php echo date('m', mktime(0, 0, 0, ((date('m'))-$i), 1, date('Y'))) . "/" . date('Y', mktime(0, 0, 0, ((date('m'))-$i), 1, date('Y')));?>"><?php echo date('M Y', mktime(0, 0, 0, ((date('m'))-$i), 1, date('Y')));?></option>
                            <?php }; ?>
                        </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>	        
           	          </tr>
          	      </table>
          	      </form>
            	</li>
                <li>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_kursus > 0) { // Show if recordset not empty ?>
    <tr>
      <th nowrap="nowrap">Bil</th>
       <th align="left" valign="middle" nowrap="nowrap">Anjuran</th> 
       <th align="left" valign="middle" nowrap="nowrap">Nama Kursus</th>
      <th align="left" valign="middle" nowrap="nowrap">Tarikh</th>
     
      <th align="center" valign="middle" nowrap="nowrap">Perancangan</th>
      <th align="center" valign="middle" nowrap="nowrap">Hadir</th>
      <th align="center" valign="middle" nowrap="nowrap">Peratus (%)</th>
      <th nowrap="nowrap">Kos</th>
      <th nowrap="nowrap">Jumlah Keseluruhan</th>
    </tr>
    <?php $rownum = ($pageNum_kursus*$maxRows_kursus)+1; do { ?>
      <tr class="on">
        <td valign="middle"><?php echo $rownum; ?></td>
        <td valign="middle"><?php echo getOrganizedBy($row_kursus['organizedby_id'],$row_kursus['courses_id']); ?> </td>
        <td valign="middle" class="in_upper"><?php echo $row_kursus['courses_name']; ?>
</td>
          <td align="left" valign="middle" nowrap="nowrap"><div class="txt_line"><?php echo getCoursesDate($row_kursus['courses_id']);?></div></td>
          <?php $tt = getTotalAttendence($row_kursus['courses_id']);?>
        <td align="center" valign="middle" nowrap="nowrap"><?php echo $tt['1'];?></td>
        <td align="center" valign="middle" nowrap="nowrap"><?php echo $tt['0'];?></td>
        <td align="center" valign="middle" nowrap="nowrap"><?php if($tt['1']!=0) echo ceil(($tt['0']/$tt['1'])*100); else echo '0'; ?></td>
        <td align="center" valign="middle" nowrap="nowrap"></td>
        <td align="center" valign="middle" nowrap="nowrap"></td>
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

?>
<?php include('../inc/footinc.php');?> 