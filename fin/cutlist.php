<?php require_once('../Connections/hrmsdb.php');?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='16';?>
<?php $menu2='66';?>
<?php $menu3='2';?>
<?php 
if(isset($_GET['dmy']))
{
	$dmy = explode("/", $_GET['dmy']);
	$d = '01';
	$m = $dmy['0'];
	$y = $dmy['1'];
} else {
	$d = date('d');
	$m = date('m');
	$y = date('Y');
}
?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_tran = "SELECT * FROM www.transaction WHERE transactiontype_id = 2 AND transaction_status = '1' ORDER BY transaction_name ASC";
$tran = mysql_query($query_tran, $hrmsdb) or die(mysql_error());
$row_tran = mysql_fetch_assoc($tran);
$totalRows_tran = mysql_num_rows($tran);
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
        	<?php include('../inc/menu_finsenarai.php');?>
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li class="form_back">
               	  <form id="form1" name="form1" method="get" action="cutlist.php">
               	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
               	      <tr>
               	        <td class="label">Bulan</td>
               	        <td width="100%" nowrap="nowrap">
               	          <select name="dmy" id="dmy">
                          <?php for($i=(date('m')-5); $i<(date('m')+2); $i++){?>
               	            <option <?php if($i==$m) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $i, 1, $y));?>"><?php echo date('F Y', mktime(0, 0, 0, $i, 1, $y));?></option>
                          <?php }; ?>
       	                  </select>
           	            <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
           	          </tr>
           	        </table>
              	  </form>
                </li>
                <li>
                	<div class="note">Senarai Jumlah Keseluruhan Potongan pada bulan<strong> <?php echo date('F Y', mktime(0, 0, 0, $m, $d, $y));?></strong></div>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_tran > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                          <th align="center" valign="middle" nowrap="nowrap">Kod</th>
                          <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                          <th align="right" valign="middle" nowrap="nowrap">Tetap (RM)</th>
                          <th align="right" valign="middle" nowrap="nowrap">Kontrak (RM)</th>
                          <th align="right" valign="middle" nowrap="nowrap">Jumlah (RM)</th>
                        </tr>
                          <tr class="back_darkgrey">
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Caruman</td>
                            <td align="right" valign="middle">&nbsp;</td>
                            <td align="right" valign="middle">&nbsp;</td>
                            <td align="right" valign="middle" class="back_darkgrey">&nbsp;</td>
                          </tr>
                          <tr class="on">
                              <td align="center" valign="middle">1</td>
                              <td align="center" valign="middle">&nbsp;</td>
                              <td align="left" valign="middle">KWSP (Staf)</td>
                              <td align="right" valign="middle"><?php $kwsptetap = getTotalKWSPStafTetap($d, $m, $y); echo number_format($kwsptetap, 2);?></td>
                              <td align="right" valign="middle"><?php $kwspkontrak = getTotalKWSPStafKontrak($d, $m, $y); echo number_format($kwspkontrak, 2);?></td>
                              <td align="right" valign="middle" class="back_lightgrey"><?php echo number_format($kwspkontrak+$kwsptetap, 2);?></td>
                        </tr>
                          <tr class="on">
                            <td align="center" valign="middle">2</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">PERKESO (Staf)</td>
                              <td align="right" valign="middle"><?php $perkesotetap = getTotalPERKESOStafTetap($d, $m, $y); echo number_format($perkesotetap, 2);?></td>
                              <td align="right" valign="middle"><?php $perkesokontrak = getTotalPERKESOStafKontrak($d, $m, $y); echo number_format($perkesokontrak, 2);?></td>
                            <td align="right" valign="middle" class="back_lightgrey"><?php echo number_format($perkesotetap+$perkesokontrak, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">3</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Kelab ISN</td>
                            <td align="right" valign="middle"><?php $kelabtetap = getTotalKelabMSNTetap($d, $m, $y); echo number_format($kelabtetap, 2);?></td>
                            <td align="right" valign="middle"><?php $kelabkontrak = getTotalKelabMSNKontrak($d, $m, $y); echo number_format($kelabkontrak, 2);?></td>
                            <td align="right" valign="middle" class="back_lightgrey"><?php echo number_format($kelabkontrak+$kelabtetap, 2);?></td>
                          </tr>
                          <tr class="back_darkgrey">
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Pelbagai</td>
                            <td align="right" valign="middle">&nbsp;</td>
                            <td align="right" valign="middle">&nbsp;</td>
                            <td align="right" valign="middle" class="back_darkgrey">&nbsp;</td>
                          </tr>
                        <?php $total = 0; $totalk = 0; $totalt = 0; $i=1; do { ?>
                          <tr class="on">
                            <td align="center" valign="middle"><?php echo $i;?></td>
                            <td align="center" valign="middle"><?php echo getTransactionCode($row_tran['transaction_id']);?></td>
                            <td align="left" valign="middle"><a href="<?php echo $url_main;?>fin/salarycutlist.php?tt=<?php echo $row_tran['transaction_id'];?>&amp;dmy=<?php echo $m . "/" . $y;?>"><?php echo $row_tran['transaction_name']; ?></a></td>
                            <td align="right" valign="middle"><?php $x = getTotalTransactionCutTetap($row_tran['transaction_id'], $d, $m, $y); $totalt += $x; echo number_format($x,2);?></td>
                            <td align="right" valign="middle"><?php $w = getTotalTransactionCutKontrak($row_tran['transaction_id'], $d, $m, $y); $totalk += $w; echo number_format($w,2);?></td>
                            <td align="right" valign="middle" class="back_lightgrey"><?php $v = getTotalTransactionCut($row_tran['transaction_id'], $d, $m, $y); $total += $v; echo number_format($v,2);?></td>
                          </tr>
                          <?php $i++; } while ($row_tran = mysql_fetch_assoc($tran)); ?>
                          <tr>
                            <td align="right" valign="middle" class="back_lightgrey">&nbsp;</td>
                            <td align="right" valign="middle" class="back_lightgrey">&nbsp;</td>
                            <td align="left" valign="middle" class="back_lightgrey"><strong>Jumlah Keseluruhan (RM)</strong></td>
                            <td align="right" valign="middle" class="back_lightgrey"><strong><?php echo number_format($totalt,2);?></strong></td>
                            <td align="right" valign="middle" class="back_lightgrey"><strong><?php echo number_format($totalk,2);?></strong></td>
                            <td align="right" valign="middle" class="back_lightgrey"><strong><?php echo number_format($total,2);?></strong></td>
                          </tr>
                        <tr>
                          <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_tran ?> rekod dijumpai</td>
                        </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                      <?php }; ?>
                      </table>
                </li>
            <?php } ; ?>
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
mysql_free_result($tran);
?>
<?php include('../inc/footinc.php');?>
