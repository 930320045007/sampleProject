<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='34';?>
<?php $menu3 = '11';?>
<?php

if(isset($_POST['y']))
	$y = htmlspecialchars($_POST['y'], ENT_QUOTES);
elseif(isset($_GET['y']))
	$y = htmlspecialchars($_GET['y'], ENT_QUOTES);
else
	$y = date('Y');
	

$sql_where = " (login.login_status = '1' OR (login.login_date_y >= '" . $y . "'))";
$orderby = "user_firstname ASC, user_lastname ASC";

$maxRows_staf = 100;
$pageNum_staf = 0;

if (isset($_GET['pageNum_staf'])) {
  $pageNum_staf = $_GET['pageNum_staf'];
}

$startRow_staf = $pageNum_staf * $maxRows_staf;
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_staf = sqlAllStaf($sql_where, $orderby);
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
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
?>
<?php
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
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <?php include('../inc/menu_senaraigaji.php');?>
          		<ul>
                <li class="line_b">
                <form id="form1" name="form1" method="get" action="pcblist.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td nowrap="nowrap" class="label noline">Tahun</td>
                    <td width="100%" class="noline">
                      <select name="y" id="y">
                    <?php for($i=2012; $i<=date('Y'); $i++){?>
                      <option <?php if($i==$y) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php }; ?>
                    </select>
                      <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" />
                    </td>
                  </tr>
                </table>
                </form>
                <li>
                <li>
                  <div class="note">Senarai <strong>PCB</strong> kakitangan bagi tahun <strong><?php echo $y;?></strong></div>
                </li>
                <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>
                <li>
                <div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="left" valign="middle" nowrap="nowrap">Nama</th>
                      <th align="center" valign="middle" nowrap="nowrap">No Cukai<br/>Pendapatan</th>
                      <th align="center" valign="middle" nowrap="nowrap">No. KP</th>
                      
                      <th align="center" valign="middle" nowrap="nowrap">Jumlah Saraan<br/>Kasar (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Elaun/Perkuisit/<br />
                      Pemberian Manfaat Yang<br/> Dikecualikan Cukai(RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">PCB<br />
                      (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">CP 38<br />
                      (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Gaji Kasar<br />
                      (RM)</th>
                    </tr>
                    <?php $i=(($pageNum_staf*100)+1); do{ ?>
                    <tr class="on">
                      <td align="center" valign="middle"><?php echo $i;?></td>
                      <td align="left" valign="middle" nowrap="nowrap"><?php echo getFullNameByStafID($row_staf['user_stafid'],1); ?></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php if(checkLHDNByUserID($row_staf['user_stafid'])){ echo getLHDNByUserID($row_staf['user_stafid']); ?><?php } else echo "Tidak dinyatakan";?></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo getICNoByStafID($row_staf['user_stafid']);?></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTotalSaraanByUserID($row_staf['user_stafid'], $y), 2);?></td>
                      <td align="center" valign="middle" nowrap="nowrap"></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTotalTransactionYearByUserID($row_staf['user_stafid'], 32, $y),2);?></td>
                      <td align="center" valign="middle" nowrap="nowrap"></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo getTotalSalaryPerYearByUserID($row_staf['user_stafid'],$y);?></td>
                    </tr>
      				<?php $i++; } while ($row_staf = mysql_fetch_assoc($staf)); ?>
                  </table>
                </div>
                </li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle" class="noline txt_color1">
                      	<ul class="func">
                        	<li>
							<?php if ($pageNum_staf > 0) { // Show if not first page ?>
                            	<a href="<?php printf("%s?pageNum_staf=%d%s", $currentPage, max(0, $pageNum_staf - 1), $queryString_staf); ?>">Prev</a>
                            <?php } // Show if not first page ?>
                            </li>
                            <li><?php echo $totalRows_staf; ?> rekod dijumpai</li>
                            <li>
                            <?php if ($pageNum_staf < $totalPages_staf) { // Show if not last page ?>
                            	<a href="<?php printf("%s?pageNum_staf=%d%s", $currentPage, min($totalPages_staf, $pageNum_staf + 1), $queryString_staf); ?>">Next</a>
                            <?php } // Show if not last page ?>
                            </li>
                         </ul>
                      </td>
                    </tr>
                  </table>
                </li>
				<?php } else { ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="12" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  </table>
                 </li>
                <?php }; ?>
            </ul>
            <?php } ; ?>
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
mysql_free_result($staf);
?>