<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php $menu='17';?>
<?php $menu2='92';?>
<?php

$bil2 = "";

if(isset($_GET['bil']))
	$bil2 = " AND bil_id = '" . htmlspecialchars($_GET['bil'], ENT_QUOTES) . "' ";
else
	$bil2 = "";
	
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
$query_report="SELECT * FROM finance.apply LEFT JOIN finance.jkb ON jkb.jkb_id = apply.jkb_id WHERE jkb.jkb_status = 1 AND apply.apply_status= 1 AND user_stafid = '" . $row_user['user_stafid'] ."' ". $bil2 ." ORDER BY jkb.jkb_date_y DESC, jkb.jkb_date_m DESC, jkb.jkb_date_d DESC, jkb.jkb_id DESC";
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
    Laporan Aduan Harta</td>
    <td align="left" valign="middle" nowrap="nowrap">Tarikh : <?php echo date('d / m / Y (D)', mktime(0 , 0, 0, date('m'), date('d'), date('Y')));?></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" nowrap="nowrap"><strong>TARIKH : </strong>
          </td>
      </tr>
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
        </tr>
        <tr>
      </tr>
       <tr>
       
      </tr>
 </table>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
                    <?php if ($totalRows_report > 0) { // Show if recordset not empty ?>
                    <tr class="line_b">
                    <th width="6%" align="center" valign="middle" nowrap="nowrap"><strong>BIL</strong></th>
                    <th width="9%" align="center" valign="middle" nowrap="nowrap"><strong>TARIKH</strong></th>
                    <th width="8%" align="center" valign="middle" nowrap="nowrap"><strong>NO TIKET</strong></th>
                    <th width="50%" align="center" valign="middle" nowrap="nowrap"><strong>PERKARA</strong></th>
                    <th width="12%" align="center" valign="middle"><strong>STATUS</strong></th>
                    <th width="15%" align="center" valign="middle"><strong>PENGESAHAN</strong></th>
                    
                    <?php }; ?>
                    </tr>
					<?php $i=1; do { ?>
                  <tr class="line_b">
                       <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="left" valign="middle"><?php echo getReportDate($row_ur['userreport_id'],1);?></td>
                        <td align="center" valign="middle"><?php echo getApplyDescriptionByApplyID($row_report['apply_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getApplyQuantityByApplyID($row_report['apply_id']); ?></td>
                       
                       
                      </tr>
                      <?php $i++; } while ($row_report = mysql_fetch_assoc($report)); ?>
                 
                    <tr>
                      <td colspan="10" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    
                  </table>
  <br />
     <br /><br />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
      <tr>
        <td align="left" valign="top" nowrap="nowrap"><img src="<?php echo $url_main;?>qr/qrreport.php?bil=<?php echo htmlspecialchars($_GET['bil'], ENT_QUOTES);?>" alt="" /></td>
        <td width="100%" align="left" valign="middle">Borang ini adalah cetakan melalui <?php echo $systitle_full;?> (<?php echo $systitle_short;?>)<br/>
              <br />
              <?php echo time();?></td>
      </tr>
    </table>       
</body>
</html>
<?php
mysql_free_result($bil);
mysql_free_result($report);
?>
<?php include('../inc/footinc.php');?> 
              