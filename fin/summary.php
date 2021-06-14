<?php require_once('../Connections/hrmsdb.php');?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='16';?>
<?php $menu2='66';?>
<?php $menu3='3';?>
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
                <li class="line_b">
               	  <form id="form1" name="form1" method="get" action="index.php">
               	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
               	      <tr>
               	        <td class="label noline">Bulan</td>
               	        <td width="100%" valign="middle" nowrap="nowrap" class="noline">
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
            </ul>
            <ul>
                <li>
               	  <div class="note">Senarai Jumlah Keseluruhan <strong>Gaji / Emolumen</strong> pada bulan<strong> <?php echo date('F Y', mktime(0, 0, 0, $m, $d, $y));?></strong></div>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                          <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                          <th align="right" valign="middle" nowrap="nowrap">Tetap (RM)</th>
                          <th align="right" valign="middle" nowrap="nowrap">Kontrak (RM)</th>
                          <th align="right" valign="middle" nowrap="nowrap">Jumlah (RM)</th>
                          <th align="right" valign="middle" nowrap="nowrap">Bersih (A-B)</th>
                        </tr>
                          <tr class="back_darkgrey">
                            <td align="center" valign="middle">&nbsp;</td>
                            <td colspan="5" align="left" valign="middle">Kakitangan</td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle" class="on">1</td>
                            <td align="left" valign="middle" class="on">Pendapatan (Gaji + Emolumen)</td>
                            <td align="right" valign="middle" nowrap="nowrap" class="on"><?php $salarytetap = getTotalSalaryTetap($d, $m, $y); echo number_format($salarytetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="on"><?php $salarykontrak = getTotalSalaryKontrak($d, $m, $y); echo number_format($salarykontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($salarytetap+$salarykontrak, 2);?> (A)</td>
                            <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle" class="on">2</td>
                            <td align="left" valign="middle" class="on">Pemotongan</td>
                            <td align="right" valign="middle" nowrap="nowrap" class="on"><?php $cuttetap = getTotalCutTetap($d, $m, $y); echo number_format($cuttetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="on"><?php $cutkontrak = getTotalCutKontrak($d, $m, $y); echo number_format($cutkontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($cutkontrak+$cuttetap, 2);?> (B)</td>
                            <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                          </tr>
                          <tr class="back_lightgrey">
                            <td align="center" valign="middle" class="back_lightgrey">&nbsp;</td>
                            <td align="left" valign="middle" class="back_lightgrey"><strong>Jumlah Keseluruhan (RM) </strong></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><strong><?php echo number_format($salarytetap+$cuttetap, 2);?></strong></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><strong><?php echo number_format($salarykontrak + $cutkontrak, 2);?></strong></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><strong><?php echo number_format($salarykontrak+$salarytetap+$cutkontrak+$cuttetap, 2);?></strong></td>
                            <td align="right" valign="middle" nowrap="nowrap"><strong>
                            <?php $bersih = (($salarykontrak+$salarytetap)-($cutkontrak+$cuttetap)); echo number_format($bersih, 2);?>
                            </strong></td>
                          </tr>
                          <tr class="back_darkgrey">
                            <td align="center" valign="middle">&nbsp;</td>
                            <td colspan="5" align="left" valign="middle">Majikan</td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle" class="on">1</td>
                            <td align="left" valign="middle" class="on">KWSP</td>
                            <td align="right" valign="middle" class="on"><?php $kwsptetap = getTotalKWSPEmpTetap($d, $m, $y); echo number_format($kwsptetap, 2);?></td>
                            <td align="right" valign="middle" class="on"><?php $kwspkontrak = getTotalKWSPEmpKontrak($d, $m, $y); echo number_format($kwspkontrak, 2);?></td>
                            <td align="right" valign="middle" class="back_lightgrey"><?php echo number_format($kwspkontrak+$kwsptetap, 2);?></td>
                            <td align="right" valign="middle">&nbsp;</td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle" class="on">2</td>
                            <td align="left" valign="middle" class="on">PERKESO</td>
                            <td align="right" valign="middle" class="on"><?php $perkesotetap = getTotalPERKESOEmpTetap($d, $m, $y); echo number_format($perkesotetap, 2);?></td>
                            <td align="right" valign="middle" class="on"><?php $perkesokontrak = getTotalPERKESOEmpKontrak($d, $m, $y); echo number_format($perkesokontrak, 2);?></td>
                            <td align="right" valign="middle" class="back_lightgrey"><?php echo number_format($perkesokontrak+$perkesotetap, 2);?></td>
                            <td align="right" valign="middle">&nbsp;</td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle" class="on">3</td>
                            <td align="left" valign="middle" class="on">Pencen</td>
                            <td align="right" valign="middle" class="on"><?php $pencentetap = getTotalPencenTetap($d, $m, $y); echo number_format($pencentetap, 2);?></td>
                            <td align="right" valign="middle" class="on"><?php $pencenkontrak = getTotalPencenKontrak($d, $m, $y); echo number_format($pencenkontrak, 2);?></td>
                            <td align="right" valign="middle" class="back_lightgrey"><?php echo number_format($pencenkontrak+$pencentetap, 2);?></td>
                            <td align="right" valign="middle">&nbsp;</td>
                          </tr>
                          <tr class="back_lightgrey">
                            <td align="center" valign="middle" class="back_lightgrey">&nbsp;</td>
                            <td align="left" valign="middle" class="back_lightgrey"><strong>Jumlah Keseluruhan (RM)</strong></td>
                            <td align="right" valign="middle" class="back_lightgrey"><strong><?php echo number_format($kwsptetap+$perkesotetap+$pencentetap, 2);?></strong></td>
                            <td align="right" valign="middle" class="back_lightgrey"><strong><?php echo number_format($kwspkontrak+$perkesokontrak+$pencenkontrak, 2);?></strong></td>
                            <td align="right" valign="middle" class="back_lightgrey"><strong><?php echo number_format($kwsptetap+$perkesotetap+$pencentetap+$kwspkontrak+$perkesokontrak+$pencenkontrak, 2);?></strong></td>
                            <td align="right" valign="middle">&nbsp;</td>
                          </tr>
                      </table>
                </li>
                <li class="gap">&nbsp;</li>
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
<?php include('../inc/footinc.php');?> 