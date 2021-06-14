<?php require_once('../Connections/hrmsdb.php'); ?>

<?php include('../inc/user.php');?>

<?php include('../inc/func.php');?>

<?php $menu='5';?>

<?php $menu2='34';?>

<?php $menu3 = '3';?>

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

$query_cuttype = "SELECT * FROM www.transaction WHERE transactiontype_id = '1' AND transaction_status = '1' ORDER BY transaction_name ASC";

$cuttype = mysql_query($query_cuttype, $hrmsdb) or die(mysql_error());

$row_cuttype = mysql_fetch_assoc($cuttype);

$totalRows_cuttype = mysql_num_rows($cuttype);


if(isset($_GET['tt']))

	$tt = $_GET['tt'];

else

	$tt = $row_cuttype['transaction_id'];


$sql_where = " login.login_status = '1'";

$orderby = "user_firstname ASC, user_lastname ASC";


$maxRows_staf = 100;

$pageNum_staf = 0;


if (isset($_GET['pageNum_staf'])) {

  $pageNum_staf = $_GET['pageNum_staf'];

}


$startRow_staf = $pageNum_staf * $maxRows_staf;

mysql_select_db($database_hrmsdb, $hrmsdb);

$query_staf = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN www.transaction ON user_salary.transaction_id = transaction.transaction_id  LEFT JOIN www.user ON user.user_stafid = user_salary.user_stafid LEFT JOIN www.login ON login.user_stafid = user_salary.user_stafid WHERE (login.login_status = '1' OR ((login.login_date_m > '" . $m . "' && login.login_date_y = '" . $y . "') OR (login.login_date_y > '" . $y . "'))) AND user_salary.usersalary_status = 1 AND user_salary.transaction_id = '" . $tt . "' AND ((user_salary.usersalary_date_m <= '" . $m . "' AND user_salary.usersalary_date_y = '" . $y . "')OR(user_salary.usersalary_date_y < '" . $y . "')) AND (((user_salary.usersalary_end_m >= '" . $m . "' AND user_salary.usersalary_end_y = '" . $y . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . $y . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) ORDER BY user.user_firstname ASC, user.user_lastname ASC";

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

                <form id="form1" name="form1" method="get" action="salaryaddlist.php">

                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td nowrap="nowrap" class="label noline">Jenis / Bulan</td>

                    <td width="100%" class="noline">

                      <select name="tt" id="tt">

                        <?php

						do {  

						?>

                        <option <?php if($tt==$row_cuttype['transaction_id']) echo "selected=\"selected\"";?> value="<?php echo $row_cuttype['transaction_id']?>"><?php echo $row_cuttype['transaction_name']?></option>

                        <?php

						} while ($row_cuttype = mysql_fetch_assoc($cuttype));

						  $rows = mysql_num_rows($cuttype);

						  if($rows > 0) {

							  mysql_data_seek($cuttype, 0);

							  $row_cuttype = mysql_fetch_assoc($cuttype);

						  }

						?>

                      </select>

                      <select name="dmy" id="dmy">

                      <?php for($i=(date('m')-10); $i<=(date('m')+2); $i++){?>

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

                	<div class="note">Senarai gaji kakitangan bagi <strong><?php echo getTransactionName($tt);?></strong> bulan <strong><?php echo date('M Y', mktime(0, 0, 0, $m, $d, $y));?></strong> </div>

                </li>

                <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>

                <li>

                <div>

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>

                      <th align="left" valign="middle" nowrap="nowrap">Nama</th>

                      <th align="center" valign="middle" nowrap="nowrap">Staf ID</th>

                      <th align="center" valign="middle" nowrap="nowrap">Jawatan</th>

                      <th align="center" valign="middle" nowrap="nowrap">No. KP</th>

                      <th align="center" valign="middle" nowrap="nowrap">Status</th>

                      <th align="center" valign="middle" nowrap="nowrap">No. Rujukan</th>

                      <th align="right" valign="middle" nowrap="nowrap">Pendapatan (RM)</th>

                    </tr>

                    <?php $i=(($pageNum_staf*100)+1); do{ ?>

                    <tr class="on">

                      <td align="center" valign="middle"><?php echo $i;?></td>

                      <td align="left" valign="middle" nowrap="nowrap"><?php echo getFullNameByStafID($row_staf['user_stafid'],1); ?></td>

                      <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_staf['user_stafid'];?></td>

                      <td align="center" valign="middle" nowrap="nowrap"><?php echo getGred($row_staf['user_stafid'],0);?></td>

                      <td align="center" valign="middle" nowrap="nowrap"><?php echo getICNoByStafID($row_staf['user_stafid']);?></td>

                      <td align="center" valign="middle" nowrap="nowrap"><?php echo getJobtype($row_staf['user_stafid']); ?></td>

                      <td align="center" valign="middle" nowrap="nowrap"><?php echo getSalaryRef($row_staf['user_stafid'], $tt);?></td>

                      <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getTransactionByUseriD($row_staf['user_stafid'], $tt, $d, $m, $y), 2);?></td>

                    </tr>

      				<?php $i++; } while ($row_staf = mysql_fetch_assoc($staf)); ?>

                  </table>

                </div>

                </li>

                <li>

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td colspan="11" align="center" valign="middle" class="noline txt_color1">

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

                      <td colspan="11" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>

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

