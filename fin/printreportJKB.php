<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php $menu='16';?>
<?php $menu2='89';?>
<?php $menu3='4';?>
<?php

$bil2 = "";
$dir2 = "";

if(isset($_GET['bil']))
	$bil2 = " AND bil_id = '" . htmlspecialchars($_GET['bil'], ENT_QUOTES) . "' ";
else
	$bil2 = "";
	
	if(isset($_GET['dir']))
	$dir2 = " AND dir_id = '" . htmlspecialchars($_GET['dir'], ENT_QUOTES) . "' ";
else
	$dir2 = "";
	
mysql_select_db($database_financedb, $financedb);
$query_bil = "SELECT * FROM finance.bil WHERE bil_status = 1 AND EXISTS (SELECT * FROM finance.jkb WHERE jkb.bil_id = bil.bil_id AND jkb.jkb_status = 1) ORDER BY bil_no ASC";
$bil = mysql_query($query_bil, $financedb) or die(mysql_error());
$row_bil = mysql_fetch_assoc($bil);
$totalRows_bil = mysql_num_rows($bil);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT * FROM dir WHERE dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);
$totalRows_dir = mysql_num_rows($dir);

mysql_select_db($database_financedb, $financedb);
$query_report="SELECT * FROM finance.apply LEFT JOIN finance.jkb ON jkb.jkb_id = apply.jkb_id WHERE jkb.jkb_status = 1 AND apply.apply_status= 1 " . $dir2 . " ". $bil2 ." ORDER BY jkb.jkb_date_y DESC, jkb.jkb_date_m DESC, jkb.jkb_date_d DESC, jkb.jkb_id DESC";
$report = mysql_query($query_report, $financedb) or die(mysql_error());
$row_report = mysql_fetch_assoc($report);
$totalRows_report = mysql_num_rows($report);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300' rel='stylesheet' type='text/css'>
<link href="../css/print.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
<tr>
    <td align="center" valign="middle" nowrap="nowrap"><img src="<?php echo $url_main;?>img/isn.png" width="75" height="70" alt="isn" /></td>
    <td width="100%" align="left" valign="middle" nowrap="nowrap" class="fsize2"><strong>INSTITUT SUKAN NEGARA</strong><br />
    Laporan Keputusan Mesyuarat Jawatankuasa Bantuan</td>
    <td align="left" valign="middle" nowrap="nowrap">Tarikh : <?php echo date('d / m / Y (D)', mktime(0 , 0, 0, date('m'), date('d'), date('Y')));?></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" nowrap="nowrap"><strong>BILANGAN MESYUARAT : </strong><?php if(isset($_GET['bil'])) echo getBilNoByBilID($_GET['bil']); ?></td>
      </tr>
      <tr>
        <td align="left" valign="middle" nowrap="nowrap"><strong>TARIKH MESYUARAT : </strong><?php if(isset($_GET['bil'])) echo  getDateJKB($_GET['bil']); ?></td>
        </tr>
        <tr>
      </tr>
       <tr>
        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
      </tr>
 </table>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
                    <?php if ($totalRows_report > 0) { // Show if recordset not empty ?>
                    <tr class="line_b">
                    <th align="center" valign="middle" nowrap="nowrap"><strong>BIL</strong></th>
                    <th align="center" valign="middle" nowrap="nowrap"><strong>PERMOHONAN</strong></th>
                     <th align="center" valign="middle" nowrap="nowrap"><strong>CAWANGAN</strong></th>
                    <th align="center" valign="middle" nowrap="nowrap"><strong>PERIHAL</strong></th>
                    <th align="center" valign="middle"><strong>DESKRIPSI / <br />PERBELANJAAN DIPOHON</strong></th>
                    <th align="center" valign="middle"><strong>KUANTITI</strong></th>
                    <th align="center" valign="middle" nowrap="nowrap"><strong>PENGIRAAN</strong></th>
                    <th align="center" valign="middle"><strong>JUMLAH (RM)</strong></th>
                    <th align="center" valign="middle" nowrap="nowrap"><strong>KEPUTUSAN</strong></th>
                    <th align="center" valign="middle"><strong>CATATAN</strong></th>
                    <?php if (getJob2ID($row_user['user_stafid'])){?><th align="center" valign="middle"><strong>PROSES KEWANGAN</strong></th><?php }; ?>
                    </tr>
					<?php $i=1; do { ?>
                  <tr class="line_b">
                       <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="left" valign="middle"><?php echo getJkbActivityByID($row_report['jkb_id']);?></td>
                         <td align="center" valign="middle"><?php echo getFullDirectory(getDirIDByJkbID($row_report['jkb_id']),0);?></td>
                        <td align="center" valign="middle"><?php if(getJkbDetailByID($row_report['jkb_id'])!='') echo getJkbDetailByID($row_report['jkb_id']); else echo "-"; ?></td>
                        <td align="center" valign="middle"><?php echo getApplyDescriptionByApplyID($row_report['apply_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getApplyQuantityByApplyID($row_report['apply_id']); ?></td>
                        <td align="center" valign="middle"><?php echo getApplyCalculationByApplyID($row_report['apply_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getApplyAmountByApplyID($row_report['apply_id']); ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getStatusNameByID(getStatusByID($row_report['apply_id'])); ?></td>
                        <td align="center" valign="middle"><?php if(getFinNoteByApplyID($row_report['apply_id'])!='') echo getFinNoteByApplyID($row_report['apply_id']); else echo "-"; ?></td>
                        <?php if (getJob2ID($row_user['user_stafid'])){?><td align="center" nowrap="nowrap">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td><?php }; ?>
                      </tr>
                      <?php $i++; } while ($row_report = mysql_fetch_assoc($report)); ?>
                  <?php } else { ?>
                    <tr>
                      <td colspan="10" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
  <br />
     <br /><br />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
      <tr>
        <td align="left" valign="top" nowrap="nowrap"><img src="<?php echo $url_main;?>qr/qrreportjkb.php?dir=<?php echo $_GET['dir'];?>&bil=<?php echo $_GET['bil'];?>" alt="" /></td>
        <td width="100%" align="left" valign="middle">Borang ini adalah cetakan melalui <?php echo $systitle_full;?> (<?php echo $systitle_short;?>)<br/>
              <br />
              <?php echo time();?></td>
      </tr>
    </table>       
</body>
</html>
<?php
mysql_free_result($bil);
mysql_free_result($dir);
mysql_free_result($report);
?>
<?php include('../inc/footinc.php');?> 
              