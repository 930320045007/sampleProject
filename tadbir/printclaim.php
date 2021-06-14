<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='70';?>
<?php

$wsql = "";

if(isset($_GET['m']))
{
	$wsql .= " AND claim_date_m = '" . htmlspecialchars($_GET['m'], ENT_QUOTES) . "'";
	$dm = htmlspecialchars($_GET['m'], ENT_QUOTES);
	
} else {
	$wsql .= " AND claim_date_m = '" . date('m') . "'";
	$dm = date('m');
};

if(isset($_GET['y']))
{
	$wsql .= " AND claim_date_y = '" . htmlspecialchars($_GET['y'], ENT_QUOTES) . "'";
	$dy = htmlspecialchars($_GET['y'], ENT_QUOTES);
} else {
	$wsql .= " AND claim_date_y = '" . date('Y') . "'";
	$dy = date('Y');
};

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_claim = "SELECT claim.user_stafid, claim.claim_on_m, claim.claim_on_y, claim.claim_date_m, claim.claim_id FROM tadbir.claim LEFT JOIN www.user ON user.user_stafid = claim.user_stafid WHERE claim_date_m= '". $dm."' AND claim.claim_date_y= '". $dy."' AND claim.claim_status= 1 GROUP BY claim.claim_on_m, claim.user_stafid ORDER BY user.user_firstname ASC, user.user_lastname ASC, claim.claim_id ASC";
$claim = mysql_query($query_claim, $tadbirdb) or die(mysql_error());
$row_claim = mysql_fetch_assoc($claim);
$totalRows_claim = mysql_num_rows($claim);
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
<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
<tr>
    <td align="center" valign="middle" nowrap="nowrap"><img src="<?php echo $url_main;?>img/isn.png" width="75" height="70" alt="isn" /></td>
    <td width="100%" align="left" valign="middle" nowrap="nowrap" class="fsize2"><strong>INSTITUT SUKAN NEGARA</strong><br />
    Permohonan Tuntutan Elaun Kerja Lebih Masa</td>
    <td align="left" valign="middle" nowrap="nowrap">Tarikh : <?php echo date('d / m / Y (D)', mktime(0 , 0, 0, date('m'), date('d'), date('Y')));?></td>
</tr>
</table>
  
<?php if ($totalRows_claim > 0) { // Show if recordset not empty ?>       
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">Senarai Permohonan Tuntutan Elaun Kerja Lebih Masa yang diproses pada bulan <?php echo date('M Y', mktime(0, 0, 0, $dm, 1, $dy));?></td>
      </tr>
 </table>
 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
    <tr>
      <th align="center" valign="middle">Bil</th>
      <th align="center" valign="middle">Nama</th>
      <th align="center" valign="middle">Bulan</th>
      <th align="center" nowrap="nowrap" valign="middle">Gaji Pokok<br />(RM)</th>
      <th align="center" nowrap="nowrap" valign="middle">Kadar 1 Jam<br />(RM)</th>
      <th align="center" valign="middle">1 1/8</th>
      <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Jumlah<br />(RM)</th>
      <th align="center" valign="middle">1 1/4</th>
      <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Jumlah<br />(RM)</th>
      <th align="center" valign="middle">1 1/2</th>
      <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Jumlah<br />(RM)</th>
      <th align="center" valign="middle">1 3/4</th>
      <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Jumlah<br />(RM)</th>
      <th align="center" valign="middle">2</th>
      <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Jumlah<br />(RM)</th>
      <th width="100" align="center" valign="middle" nowrap="nowrap">Tetap</th>
      <th width="100" align="center" valign="middle" nowrap="nowrap">Kontrak</th>
      <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Keseluruhan <br />(RM)</th>
    </tr>
    <?php $i=1; do { ?>
    <tr class="line_b">
      <td align="center" valign="middle"><?php echo $i;?></td>
      <td align="left" valign="middle" nowrap="nowrap">
      <div><strong><?php echo getFullNameByStafID($row_claim['user_stafid']) . " (" . $row_claim['user_stafid'] . ")";?></strong></div>
      <div class="inputlabel2">Gred : <?php echo getGredByStafID($row_claim['user_stafid']);?> &nbsp; &nbsp; <?php echo getJobtype($row_claim['user_stafid']); ?></div>
      </a>
      </td>
      <td align="center" valign="middle" nowrap="nowrap"><?php echo date('M Y',mktime(0,0,0, $row_claim['claim_on_m'],1,$dy));?> </td>
      <td align="center" valign="middle"><?php echo getBasicSalaryByUserID($row_claim['user_stafid'], 0, $row_claim['claim_on_m'], $row_claim['claim_on_y']); ?></td>
      <td align="center" valign="middle"><?php echo getRate1h($row_claim['user_stafid'],1, $row_claim['claim_date_m'], $dy); ?></td>
      <td align="right" valign="middle" nowrap="nowrap"><?php $siang = getSiangHourMonAfterDeduc($row_claim['user_stafid'],$row_claim['claim_on_m'],0); echo $siang[0].".".$siang[1];?></td>
      <td class="back_darkgrey" align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getAmountSiang($row_claim['user_stafid'], $row_claim['claim_date_m'],$dy,$row_claim['claim_on_m'],0),2);?></td>
      <td align="right" valign="middle" nowrap="nowrap"><?php $siang = getMalamSiangHourMonAfterDeduc($row_claim['user_stafid'],$row_claim['claim_on_m'],0); echo $siang[0].".".$siang[1];?></td>
      <td class="back_darkgrey" align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getAmountMalamSiang($row_claim['user_stafid'], $row_claim['claim_date_m'], $dy,$row_claim['claim_on_m'],0),2);?></td>
      <td align="right" valign="middle" nowrap="nowrap"><?php $siang = getMalamAhadHourMonAfterDeduc($row_claim['user_stafid'],$row_claim['claim_on_m'],0); echo $siang[0].".".$siang[1];?></td>
      <td class="back_darkgrey" align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getAmountMalamAhad($row_claim['user_stafid'], $row_claim['claim_date_m'], $dy,$row_claim['claim_on_m'],0),2);?></td>
      <td align="right" valign="middle" nowrap="nowrap"><?php $siang = getAmSiangHourMonAfterDeduc($row_claim['user_stafid'],$row_claim['claim_on_m'],0); echo $siang[0].".".$siang[1];?></td>
      <td class="back_darkgrey" align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getAmountAmSiang($row_claim['user_stafid'], $row_claim['claim_date_m'],$dy,$row_claim['claim_on_m'],0),2);?></td>
      <td align="right" valign="middle" nowrap="nowrap"><?php $siang = getAmMalamHourMonAfterDeduc($row_claim['user_stafid'],$row_claim['claim_on_m'],0); echo $siang[0].".".$siang[1];?></td>
      <td class="back_darkgrey" align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getAmountAmMalam($row_claim['user_stafid'], $row_claim['claim_date_m'],$dy,$row_claim['claim_on_m'],0),2);?></td>
      <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getTotalByUserDesignation($row_claim['user_stafid'], $row_claim['claim_date_m'], $dy, $row_claim['claim_on_m'], 0,1),2)?></td>
      <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(getTotalByUserDesignation($row_claim['user_stafid'], $row_claim['claim_date_m'], $dy, $row_claim['claim_on_m'], 0,2),2)?></td>
       <td class="back_darkgrey" align="right" valign="middle" nowrap="nowrap"><strong><?php echo number_format(getOverall($row_claim['user_stafid'],$row_claim['claim_date_m'],$dy,$row_claim['claim_on_m'],0),2);?></strong></td>
    </tr>
       <?php $i++; } while ($row_claim = mysql_fetch_assoc($claim)); ?>
    <tr>
       <td colspan="15" align="right" valign="middle" class="noline"><strong>Jumlah</strong></td>
       <td align="right" valign="middle" class="line_l"><strong><?php echo number_format(getTotalClaimTetap($dm,$dy),2);?></strong></td>
       <td align="right" valign="middle"><strong><?php echo number_format(getTotalClaimKontrak($dm,$dy),2);?></strong></td>
       <td align="right" valign="middle" class="back_darkgrey line_l"><strong><?php echo number_format(getTotalOverall($dm,$dy),2);?></strong></td>
    </tr>
    </table>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="50%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
          <tr>
            <td colspan="2"&nbsp;></td>
          </tr>
          <tr>
            <td align="left" valign="top"><img src="../qr/qrot.php?m=<?php echo $dm;?>&amp;y=<?php echo $dy;?>" alt="QR Code" /></td>
            <td width="100%" align="left" valign="middle" nowrap="nowrap">
            <div>Jumlah Kakitangan = <strong><?php echo getTotalStafOverall($dm, $dy);?> orang</strong></div>
            <div>Jumlah Tetap = <strong>RM <?php echo number_format(getTotalClaimTetap($dm, $dy),2);?></strong></div>
            <div>Jumlah Kontrak = <strong>RM <?php echo number_format(getTotalClaimKontrak($dm, $dy),2);?></strong></div>
            <div>Jumlah Keseluruhan = <strong>RM <?php echo number_format(getTotalOverall($dm,$dy),2);?></strong></div>
            <br />
            <div>Borang ini adalah cetakan melalui <?php echo $systitle_full;?><br /><?php echo time();?></div></td>
          </tr>
          </table>
        </td>
        <td width="50%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
          <tr>
            <td>Disediakan oleh</td>
            <td>Disahkan oleh</td>
          </tr>
          <tr>
            <td width="50%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabborder">
              <tr>
                <td><br />
                  <br />
                  <br />
                  <br /></td>
              </tr>
            </table></td>
            <td width="50%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabborder">
              <tr>
                <td><br />
                  <br />
                  <br />
                  <br /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td nowrap="nowrap" ><strong><?php echo getFullNameByStafID($row_user['user_stafid']) . "(" . $row_user['user_stafid'] . ")"; ?></strong></td>
            <td nowrap="nowrap" ><strong>(PEGAWAI PENGESAH)</strong></td>
          </tr>
          <tr>
            <td >Tarikh : </td>
            <td >Tarikh : </td>
          </tr>
        </table></td>
      </tr>
    </table>
    <?php } else { ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
    <tr>
        <td align="center" valign="middle" nowrap="nowrap">Tiada rekod dijumpai</td>
    </tr>
</table>
    <?php }; ?>
<?php } else {?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
<tr>
	<td align="center" valign="middle" nowrap="nowrap">Tiada rekod dijumpai</td>
</tr>
</table>
<?php }; ?>
</body>
</html>
<?php
mysql_free_result($claim);
?>
<?php include('../inc/footinc.php');?> 
              
