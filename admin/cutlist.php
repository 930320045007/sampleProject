<?php require_once('../Connections/hrmsdb.php'); ?>

<?php include('../inc/user.php');?>

<?php include('../inc/func.php');?>

<?php $menu='5';?>

<?php $menu2='34';?>

<?php $menu3 = '12';?>

<?php

if(isset($_GET['dmy']))

{

	$dmy = explode("/", $_GET['dmy']);

	$d = 1;

	$m = $dmy['0'];

	$y = $dmy['1'];

} else {

	$d = date('d');

	$m = date('m');

	$y = date('Y');

}


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cuttype = "SELECT * FROM www.transaction WHERE transactiontype_id = '2' AND transaction_status = '1' ORDER BY transaction_name ASC";

$cuttype = mysql_query($query_cuttype, $hrmsdb) or die(mysql_error());

$row_cuttype = mysql_fetch_assoc($cuttype);

$totalRows_cuttype = mysql_num_rows($cuttype);


if(isset($_GET['tt']))

	$tt = htmlspecialchars($_GET['tt'],ENT_QUOTES);

else

	$tt = $row_cuttype['transaction_id'];


$sql_where = " (login.login_status = '1' OR ((login.login_date_m > '" . $m . "' && login.login_date_y = '" . $y . "') OR (login.login_date_y > '" . $y . "')))";

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

                <form id="form1" name="form1" method="get" action="cutlist.php">

                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td class="label noline">Bulan</td>

                    <td width="100%" class="noline"><select name="dmy" id="dmy">

                      <?php for($i=(date('m')-6); $i<=(date('m')+2); $i++){?>

                      <option <?php if($m == $i) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $i, 1, date('Y')));?>"><?php echo date('M Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>

                        <?php }; ?>

                    </select>

                      <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" />

                    </td>

                  </tr>

                </table>

                </form>

                <li>

                <li>

                	<div class="note">Senarai Pemotongan Kakitangan pada bulan <strong><?php echo date('F Y', mktime(0, 0, 0, $m, $d, $y));?> </strong></div>

                </li>

                <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>

                <li>

                <div class="off2">

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>

                      <th align="left" valign="middle" nowrap="nowrap">Nama</th>

                      <th align="center" valign="middle" nowrap="nowrap">Staf ID</th>

                      <th align="center" valign="middle" nowrap="nowrap">Jawatan</th>

                      <th align="center" valign="middle" nowrap="nowrap">Status</th>

                      <th align="center" valign="middle" nowrap="nowrap">Angkasa <br />(RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">ASB <br />

                      (RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">Bank Islam (M)  <br />

                      Berhad (RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">Bank Islam - <br />

                     Pinjaman Perumahan (RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">Bil Air - <br />

                      vista MSN (RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">Coshare Holdings<br />
 
                      Berhad (RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">Etiqa Mini<br />

                       (RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">JPA (Pinjaman) <br />

                      (RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">KPM<br />

                      (RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">Lembaga Biasiswa <br />

                      Negeri Kedah (RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">Lembaga Tabung <br />

                      Haji (RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">PCB <br /> 

                      (RM)</th>

                      <th align="center" valign="middle" nowrap="nowrap">Pelarasan Gaji<br />

                      (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pelarasan Potongan <br />

                      (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pelarasan Tunggakan <br />

                      Gaji/Elaun (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pelbagai Potongan <br />

                      (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pendahuluan Gaji <br />

                      (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pinjaman <br />

                      Kelab ISN(RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pinjaman KPM<br />

                       (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pinjaman <br />

                      Kenderaan (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pinjaman <br />

                      Komputer (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pinjaman <br />

                      Perumahan (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">PTPTN <br />

                      (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pusat <br />

                      Pungutan Zakat (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pusat Pungutan<br />

                      Zakat Johor (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Sewa - Rumah <br />

                      Kerajaan (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Sewa - Vista <br />

                      MSN (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Surau & Pembersihan - <br />

                      Vista MSN (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Syarikat Takaful <br />

                      Malaysia (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tunggakan <br />

                      PERKESO (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">YaPEIM <br />

                       (RM)</th>
                      <th align="center" valign="middle" nowrap="nowrap">Yayasan  <br />

                      Sarawak (RM)</th>

                    </tr>

                    <?php $i=(($pageNum_staf*100)+1); do{ ?>

                    <tr class="on">

                      <td align="center" valign="middle"><?php echo $i;?></td>

                      <td align="left" valign="middle" nowrap="nowrap"><?php echo getFullNameByStafID($row_staf['user_stafid'],1); ?></td>

                      <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_staf['user_stafid'];?></td>

                      <td align="center" valign="middle" nowrap="nowrap"><?php echo getGred($row_staf['user_stafid'],0);?></td>

                      <td align="center" valign="middle" nowrap="nowrap"><?php echo getJobtype($row_staf['user_stafid']); ?></td>

                      <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 18, $d, $m, $y), 2);?></td>

                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 4, $d, $m, $y), 2);?></td>

                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 33, $d, $m, $y), 2);?></td>

                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 64, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 30, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 36, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 35, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 14, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 15, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 34, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 6, $d, $m, $y), 2);?></td>
                        <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 32, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 73, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 3, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 72, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 26, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 20, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 25, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 62, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 23, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 24, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 22, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 16, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 49, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 66, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 56, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 28, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 29, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 31, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 67, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 5, $d, $m, $y), 2);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUserID($row_staf['user_stafid'], 54, $d, $m, $y), 2);?></td>

                    </tr>

      				<?php $i++; } while ($row_staf = mysql_fetch_assoc($staf)); ?>

                  </table>

                </div>

                </li>

                <li>

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td colspan="37" align="center" valign="middle" class="noline txt_color1">

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

                      <td colspan="37" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>

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

<?php

mysql_free_result($cuttype);

?>

<?php include('../inc/footinc.php');?> 

<?php

mysql_free_result($staf);

?>

