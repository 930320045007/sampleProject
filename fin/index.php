<?php require_once('../Connections/hrmsdb.php');

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='16';?>
<?php $menu2='66';?>
<?php $menu3='1';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_trans = "SELECT * FROM `transaction` WHERE transactiontype_id = 1 ORDER BY transaction_id ASC";
$trans = mysql_query($query_trans, $hrmsdb) or die(mysql_error());
$row_trans = mysql_fetch_assoc($trans);
$totalRows_trans = mysql_num_rows($trans);
?>
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
                          <th align="center" valign="middle" nowrap="nowrap">Kod</th>
                          <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                          <th align="right" valign="middle" nowrap="nowrap">Tetap (RM)</th>
                          <th align="right" valign="middle" nowrap="nowrap">Kontrak (RM)</th>
                          <th align="right" valign="middle" nowrap="nowrap">Jumlah (RM)</th>
                        </tr>
                          <tr class="back_darkgrey">
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td colspan="4" align="left" valign="middle">Gaji</td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">1</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Gaji Pokok</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $gajikasartetap = getTotalBasicSalaryTetap($d, $m, $y); echo number_format($gajikasartetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $gajikasarkontrak = getTotalBasicSalaryKontrak($d, $m, $y); echo number_format($gajikasarkontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><strong><?php echo number_format($gajikasarkontrak+$gajikasartetap, 2);?></strong></td>
                          </tr>
                          <tr class="back_darkgrey">
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td colspan="4" align="left" valign="middle">Elaun</td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">1</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Elaun Khidmat Awam (ITKA)</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $itkatetap = getTotalEmolumenITKATetap($d, $m, $y); echo number_format($itkatetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $itkakontrak = getTotalEmolumenITKAKontrak($d, $m, $y); echo number_format($itkakontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($itkakontrak + $itkatetap, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">2</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Elaun Keraian (ITKRAI)</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $itkraitetap = getTotalEmolumenITKraiTetap($d, $m, $y); echo number_format($itkraitetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $itkraikontrak = getTotalEmolumenITKraiKontrak($d, $m, $y); echo number_format($itkraikontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($itkraikontrak + $itkraitetap, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">3</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Elaun Perumahan (ITP)</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $itptetap = getTotalEmolumenITPTetap($d, $m, $y); echo number_format($itptetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $itpkontrak = getTotalEmolumenITPKontrak($d, $m, $y); echo number_format($itpkontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($itptetap + $itpkontrak, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">4</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Bantuan Sara Hidup (BSH)</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $bhstetap = getTotalEmolumenBSHTetap($d, $m, $y); echo number_format($bhstetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $bhskontrak = getTotalEmolumenBSHKontrak($d, $m, $y); echo number_format($bhskontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($bhskontrak + $bhstetap, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">5</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Elaun Kritikal (EL KTKL)</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $krkltetap = getTotalEmolumenElKtklTetap($d, $m, $y); echo number_format($krkltetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $krklkontrak = getTotalEmolumenElKtklKontrak($d, $m, $y); echo number_format($krklkontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($krklkontrak + $krkltetap, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">6</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">EL PKSHT</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $pkshttetap = getTotalEmolumenElPkshtTetap($d, $m, $y); echo number_format($pkshttetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $pkshtkontrak = getTotalEmolumenElPkshtTetap($d, $m, $y); echo number_format($pkshtkontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($pkshtkontrak + $pkshttetap, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">7</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">EL PAKAR</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $pakartetap = getTotalEmolumenElPakarTetap($d, $m, $y); echo number_format($pakartetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $pakarkontrak = getTotalEmolumenElPakarKontrak($d, $m, $y); echo number_format($pakarkontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($pakarkontrak + $pakartetap, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">8</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Elaun Memangku </td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $elmemangkutetap = getTotalEmolumenElMemangkuTetap($d, $m, $y); echo number_format($elmemangkutetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $elmemangkukontrak = getTotalEmolumenElMemangkuKontrak($d, $m, $y); echo number_format($elmemangkukontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($elmemangkukontrak + $elmemangkutetap, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">9</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Elaun JUSA Gred Khas (JUSA)</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $jusatetap = getTotalEmolumenJUSATetap($d, $m, $y); echo number_format($jusatetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $jusakontrak = getTotalEmolumenJUSAKontrak($d, $m, $y); echo number_format($jusakontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($jusakontrak + $jusatetap, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">10</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Elaun Pembantu Khas (EL PEM. KHAS)</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $elpemkhastetap = getTotalEmolumenElPemKhasTetap($d, $m, $y); echo number_format($elpemkhastetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $elpemkhaskontrak = getTotalEmolumenElPemKhasKontrak($d, $m, $y); echo number_format($elpemkhaskontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($elpemkhaskontrak + $elpemkhastetap, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">11</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">EL PEM. RMH</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $pemrmhtetap = getTotalEmolumenElPemRmhTetap($d, $m, $y); echo number_format($pemrmhtetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $pemrmhkontrak = getTotalEmolumenElPemRmhKontrak($d, $m, $y); echo number_format($pemrmhkontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($pemrmhkontrak + $pemrmhtetap, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">12</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">EL BHS</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $elbhstetap = getTotalEmolumenElBhsTetap($d, $m, $y); echo number_format($elbhstetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $elbhskontrak = getTotalEmolumenElBhsKontrak($d, $m, $y); echo number_format($elbhskontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($elbhstetap+$elbhskontrak, 2);?></td>
                          </tr>
                          <tr class="on">
                            <td align="center" valign="middle">13</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Lain-lain</td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $otetap = getTotalEmolumenOTetap($d, $m, $y); echo number_format($otetap, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap"><?php $okontrak = getTotalEmolumenOKontrak($d, $m, $y); echo number_format($okontrak, 2);?></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($okontrak+$otetap, 2);?></td>
                          </tr>
                          
                          <tr class="back_lightgrey">
                            <td align="right" valign="middle" class="back_lightgrey">&nbsp;</td>
                            <td align="right" valign="middle" class="back_lightgrey">&nbsp;</td>
                            <td align="left" valign="middle" class="back_lightgrey"><strong>Jumlah (RM)</strong></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><strong>
                            <?php $tetap = getTotalEmolumenTetap($d, $m, $y); echo number_format($tetap, 2);?>
                            </strong></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><strong>
                            <?php $kontrak = getTotalEmolumenKontrak($d, $m, $y); echo number_format($kontrak, 2);?>
                            </strong></td>
                            <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><strong><?php echo number_format(($tetap + $kontrak), 2);?></strong></td>
                          </tr>
                          <tr class="back_darkgrey">
                            <td align="right" valign="middle">&nbsp;</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">Lain-lain</td>
                            <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                            <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                            <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                          </tr>
                          <?php $i = 1; do { ?>
                          <tr class="on">
                              <td align="center" valign="middle"><?php echo $i;?></td>
                              <td align="center" valign="middle"><?php echo getTransactionCode($row_trans['transaction_id']);?></td>
                              <td align="left" valign="middle"><a href="<?php echo $url_main;?>fin/salaryaddlist.php?tt=<?php echo $row_trans['transaction_id'];?>&amp;dmy=<?php echo $m . "/" . $y;?>"><?php echo getTransactionName($row_trans['transaction_id']);?></a></td>
                              <td align="right" valign="middle" nowrap="nowrap"><?php $imbuhantetap = getTotalTransactionSalaryTetap($row_trans['transaction_id'], $d, $m, $y); echo number_format($imbuhantetap, 2);?></td>
                              <td align="right" valign="middle" nowrap="nowrap"><?php $imbuhankontrak = getTotalTransactionSalaryKontrak($row_trans['transaction_id'], $d, $m, $y); echo number_format($imbuhankontrak, 2);?></td>
                              <td align="right" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo number_format($imbuhankontrak + $imbuhantetap, 2);?></td>
                          </tr>
                            <?php $i++; } while ($row_trans = mysql_fetch_assoc($trans)); ?>
                          <tr class="back_lightgrey">
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle"><strong>Jumlah (RM)</strong></td>
                            <td align="right" valign="middle" nowrap="nowrap">
                              <strong>
                            <?php $alltranstetap = getTotalAllTransactionSalaryTetap($d, $m, $y); echo number_format($alltranstetap, 2);?>
                            </strong></td>
                            <td align="right" valign="middle" nowrap="nowrap">
                              <strong>
                            <?php $alltranskontrak = getTotalAllTransactionSalaryKontrak($d, $m, $y); echo number_format($alltranskontrak, 2);?>
                            </strong></td>
                            <td align="right" valign="middle" nowrap="nowrap"><strong><?php echo number_format($alltranskontrak+$alltranstetap, 2);?></strong></td>
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
<?php
mysql_free_result($trans);
?>
<?php include('../inc/footinc.php');?> 