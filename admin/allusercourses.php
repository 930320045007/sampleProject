<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='14';?> 
<?php
$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT * FROM dir WHERE dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);
$totalRows_dir = mysql_num_rows($dir);

$maxRows_staf = 100;
$pageNum_staf = 0;

if (isset($_GET['pageNum_staf'])) {
  $pageNum_staf = $_GET['pageNum_staf'];
}
$startRow_staf = $pageNum_staf * $maxRows_staf;

$sql_where = "";

if(isset($_POST['unit']))
{
	$sql_where .= " user_unit.dir_id='" . htmlspecialchars($_POST['unit'], ENT_QUOTES) . "' AND userunit_status = '1' ";
	$orderby = "0";
	
} elseif(isset($_POST['jc']) && $_POST['jc']!=0)
{
	$sql_where .= " AND scheme.group_id = '" . htmlspecialchars($_POST['jc'], ENT_QUOTES) . "' ";
	$orderby = "0";
	
} elseif(isset($_POST['n']) && $_POST['n']!=NULL)
{
	$sql_where .= " (user.user_firstname LIKE '%" . htmlspecialchars($_POST['n'], ENT_QUOTES) . "%' OR user.user_lastname LIKE '%" . htmlspecialchars($_POST['n'], ENT_QUOTES) . "%')";
	$orderby = "user_firstname ASC, user_lastname ASC";
	
} elseif(isset($_POST['si']) && $_POST['si']!=NULL)
{
	$sql_where .= " user.user_stafid = '" . htmlspecialchars($_POST['si'], ENT_QUOTES) . "'";
	$orderby = "user_firstname ASC, user_lastname ASC";
	
} elseif(isset($_POST['kp']) && $_POST['kp']!=NULL)
{
	$sql_where .= " user.user_noic = '" . htmlspecialchars($_POST['kp'], ENT_QUOTES) . "'";
	$orderby = "user_firstname ASC, user_lastname ASC";
	
} elseif(isset($_POST['c']) && $_POST['c']!=NULL)
{
	$sql_where .= " user.user_firstname LIKE '" . htmlspecialchars($_POST['c'], ENT_QUOTES) . "%'";
	$orderby = "user_firstname ASC, user_lastname ASC";

} else {
	$sql_where .= " user_unit.dir_id = '1' AND userunit_status = '1' ";
	$orderby = "0";
};

	
if(isset($_POST['tahun']) && $_POST['tahun']!=0)
{
	$tahun = $_POST['tahun'];
} else {
	$tahun = date('Y');
}

if (isset($_GET['pageNum_staf'])) {
  $pageNum_staf = $_GET['pageNum_staf'];
}

$startRow_staf = $pageNum_staf * $maxRows_staf;

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_staf = sqlAllStaf($sql_where);
$query_limit_staf = sprintf("%s LIMIT %d, %d", $query_staf, $startRow_staf, $maxRows_staf);
$staf = mysql_query($query_limit_staf, $hrmsdb) or die(mysql_error());
$row_staf = mysql_fetch_assoc($staf);

if (isset($_GET['totalRows_staf'])) {
  $totalRows_staf = $_GET['totalRows_staf'];
} else {
  $all_staf = mysql_query($query_staf);
  $totalRows_staf = mysql_num_rows($all_staf);
}
$totalPages_staf = ceil($totalRows_staf/$maxRows_staf)-1;

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jobcode = "SELECT * FROM `group` ORDER BY group_id ASC";
$jobcode = mysql_query($query_jobcode, $hrmsdb) or die(mysql_error());
$row_jobcode = mysql_fetch_assoc($jobcode);
$totalRows_jobcode = mysql_num_rows($jobcode);

$queryString_staf = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_staf") == false && 
        stristr($param, "totalRows_staf") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_staf = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_staf = sprintf("&totalRows_staf=%d%s", $totalRows_staf, $queryString_staf);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
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
            	  <form id="shortby" name="shortby" method="post" action="">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td width="100%" class="noline">
                        <select name="tahun" id="tahun">
                        <?php for($i=date('Y'); $i>=2012; $i--){?>
                          <option value="<?php echo $i;?>" <?php if($tahun==$i) echo "selected=\"selected\"";?>><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                        <select name="select" id="select" onchange="dochange('17', 'stype', this.value, '0');">
                          <option value="0">Jenis Carian</option>
                          <option value="1">Bhg/Cwg/Pusat/Unit</option>
                          <option value="2">Nama</option>
                          <option value="3">Staf ID</option>
                          <option value="4">No. Kad Pengenalan</option>
                          <option value="5">Alphabet</option>
                        </select>
                        <div id="stype">
                        </div>
                        </td>
                        <td><input name="button3" type="button" class="submitbutton" id="button3" value="Senarai" onclick="MM_goToURL('parent','reportByJobType.php');return document.MM_returnValue" /></td>
            	        <td class="noline">&nbsp;</td>
          	          </tr>
          	      </table>
          	      </form>
            	</li>
                <li>
                <div class="note">Laporan kursus bagi setiap kakitangan bagi tahun <?php echo $tahun;?></div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>
    <tr>
      <th align="left" valign="middle">Bil</th>
      <th width="100%" align="left" valign="middle">Nama / Jawatan</th>
      <th width="100%" align="left" valign="middle">Gred</th>
      <th width="100%" align="left" valign="middle">Status Jawatan</th>
      <th width="100%" align="left" valign="middle">Tiada Laporan</th>
      <th align="center" valign="middle" nowrap="nowrap">Jam Kursus</th>
      <th align="center" valign="middle" nowrap="nowrap">Status</th>
    </tr>
    <?php $i=1; do { ?>
      <tr class="on">
      	<td align="left" valign="middle"><?php echo $i; ?></td>
        <td class="txt_line"><a href="coursesstaffdetail.php?sid=<?php echo getID($row_staf['user_stafid']);?>"><strong class="in_upper"><?php echo getFullNameByStafID($row_staf['user_stafid']); ?></strong> (<?php echo $row_staf['user_stafid'];?>)</a><br/>
        <span class="txt_color1">
        <div><?php echo getJobtitle($row_staf['user_stafid']); ?>, <?php echo getFulldirectoryByUserID($row_staf['user_stafid']);?></div>
        <div class="txt_color1">Email : <?php echo getEmailISNByUserID($row_staf['user_stafid']);?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID($row_staf['user_stafid']);?></div>
        </span></td>
        <td align="center" valign="middle" nowrap="nowrap"><?php echo getGred($row_staf['user_stafid']);?></td>
        <td align="center" valign="middle"><?php echo getJobtype($row_staf['user_stafid']);?></td>
        <td align="center" valign="middle" nowrap="nowrap" class="back_lightgrey">
		<?php $courseshourUnsubmitReport = countCoursesHourUnsubmitReport($row_staf['user_stafid'], $tahun);?>
		<?php 
			if($courseshourUnsubmitReport['0']>0) 
				echo $courseshourUnsubmitReport['0'] . " Hari &nbsp; "; 
			else if($courseshourUnsubmitReport['1']<0) 
				echo ""; 
			if($courseshourUnsubmitReport['1']>0) 
				echo $courseshourUnsubmitReport['1'] . " Jam"; 
			else 
				echo "";
		?>
        </td>
      	<td align="center" valign="middle" nowrap="nowrap" class="back_lightgrey">
		<?php $courseshour = countCoursesHour($row_staf['user_stafid'], $tahun);?>
		<?php 
			if($courseshour['0']>0) 
				echo $courseshour['0'] . " Hari &nbsp; "; 
			else if($courseshour['1']<0) 
				echo ""; 
			if($courseshour['1']>0) 
				echo $courseshour['1'] . " Jam"; 
			else 
				echo "";
		?>
        </td>
        <td align="center" valign="middle" nowrap="nowrap"><?php echo getStatusIcon(getStatusByStafID($row_staf['user_stafid'])); ?></td>
      </tr>
      <?php $i++; } while ($row_staf = mysql_fetch_assoc($staf)); ?>
    <tr>
      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><ul class="func">
        <?php if ($pageNum_staf > 0) { // Show if not first page ?>
          <li><a href="<?php printf("%s?pageNum_staf=%d%s", $currentPage, max(0, $pageNum_staf - 1), $queryString_staf); ?>">&laquo;</a></li>
          <?php } // Show if not first page ?>
<li><?php echo $totalRows_staf ?>  rekod dijumpai.</li>
<?php if ($pageNum_staf < $totalPages_staf) { // Show if not last page ?>
  <li><a href="<?php printf("%s?pageNum_staf=%d%s", $currentPage, min($totalPages_staf, $pageNum_staf + 1), $queryString_staf); ?>">&raquo;</a></li>
  <?php } // Show if not last page ?>
      </ul></td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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
<?php include('../inc/footinc.php');?> 
<?php
mysql_free_result($dir);

mysql_free_result($staf);

mysql_free_result($jobcode);
?>