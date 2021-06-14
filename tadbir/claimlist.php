<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='70';?>
<?php 

if(isset($_GET['dmy']))
{
	$dmy = explode("/", htmlspecialchars($_GET['dmy'], ENT_QUOTES));
	$dm = $dmy[0];
	$dy = $dmy[1];
} else {
	$dy = date('Y');
	$dm = date('m');
}

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_claim = "SELECT claim.user_stafid, claim.claim_on_m, claim.claim_on_y, claim.claim_date_m, claim.claim_id FROM tadbir.claim LEFT JOIN www.user ON user.user_stafid = claim.user_stafid WHERE claim_date_m= '". $dm."' AND claim.claim_date_y= '". $dy."' AND claim.claim_status= 1 GROUP BY claim.claim_on_m, claim.user_stafid ORDER BY user.user_firstname ASC, user.user_lastname ASC, claim.claim_id ASC";
$claim = mysql_query($query_claim, $tadbirdb) or die(mysql_error());
$row_claim = mysql_fetch_assoc($claim);
$totalRows_claim = mysql_num_rows($claim);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
<div>
<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
      	<div class="content">
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
             <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
              <li class="line_b form_back">
              <form id="form1" name="form1" method="get" action="claimlist.php">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                   	<td class="label noline">Bulan/Tahun</td>
                    <td width="100%" class="noline">
                    <select name="dmy" id="dmy">
                          <?php for($j=1; $j<=12; $j++){?>
            	            <option <?php if($j<10) $j= "0" . $j;  if($j==$dm) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $j, 1, date('Y')));?>"><?php echo date('M Y', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                          <?php }; ?>
       	              </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" />
                  </td>  
                  <td><input name="button5" type="button" class="submitbutton" id="button5" value="Cetak" onclick="MM_openBrWindow('printclaim.php?m=<?php echo $row_claim['claim_date_m'];?>&y=<?php echo $dy;?>','claimprint','status=yes,scrollbars=yes,width=800,height=600')" />
                  </td>      
              </tr>
              </table>
              </form>
              </li>
              <li>  
           	  <div class="note">Senarai maklumat kakitangan berdasarkan <b>tuntutan kerja lebih masa.</b></div>
              <div class="off2">          
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <?php if ($totalRows_claim > 0) { // Show if recordset not empty ?>
                <tr>
                  <th align="center" valign="middle">Bil</th>
                  <th align="center" valign="middle">Nama</th>
                  <th align="center" valign="middle">Bulan</th>
                  <th align="center" nowrap="nowrap" valign="middle">Gaji Pokok<br />(RM)</th>
                  <th align="center" nowrap="nowrap" class="line_l line_t line_r" valign="middle">Kadar 1 Jam<br />(RM)</th>
                  <th align="center" nowrap="nowrap" valign="middle">1 1/8</th>
                  <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Jumlah<br />(RM)</th>
                  <th align="center" nowrap="nowrap" valign="middle">1 1/4</th>
                  <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Jumlah<br />(RM)</th>
                  <th align="center" nowrap="nowrap" valign="middle">1 1/2</th>
                  <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Jumlah<br />(RM)</th>
                  <th align="center" nowrap="nowrap" valign="middle">1 3/4</th>
                  <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Jumlah<br />(RM)</th>
                  <th align="center" nowrap="nowrap" valign="middle">2</th>
                  <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Jumlah<br />(RM)</th>
                  <th width="100" align="center" valign="middle" nowrap="nowrap">Tetap</th>
                  <th width="100" align="center" valign="middle" nowrap="nowrap">Kontrak</th>
                  <th align="center" nowrap="nowrap" class="back_darkgrey" valign="middle">Keseluruhan <br />(RM)</th>
                </tr>
                 <?php $i=1; do { ?>
                <tr class="on">
                  <td align="center" valign="middle"><?php echo $i;?></td>
                  <td align="left" valign="middle" nowrap="nowrap">
                  <a href="<?php echo $url_main;?>tadbir/claimbydate.php?id=<?php echo $row_claim['user_stafid'];?>&dmy=<?php echo $row_claim['claim_on_m'] . "/" . $row_claim['claim_on_y'];?>">
				  <div><strong><?php echo getFullNameByStafID($row_claim['user_stafid']) . " (" . $row_claim['user_stafid'] . ")";?></strong></div>
                  <div class="inputlabel2">Gred : <?php echo getGredByStafID($row_claim['user_stafid']);?> &nbsp; &nbsp; <?php echo getJobtype($row_claim['user_stafid']); ?></div>
                  </a>
                  </td>
                  <td align="center" valign="middle" nowrap="nowrap"><?php echo date('M Y',mktime(0, 0, 0, $row_claim['claim_on_m'], 1, $row_claim['claim_on_y']));?> </td>
                  <td align="center" valign="middle"><?php echo getBasicSalaryByUserID($row_claim['user_stafid'], 0, $row_claim['claim_on_m'], $row_claim['claim_on_y']); ?></td>
                 <td align="center" valign="middle" class="line_l line_r"><?php echo getRate1h($row_claim['user_stafid'],1, $row_claim['claim_on_m'], $row_claim['claim_on_y']); ?></td>
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
                  <td colspan="19" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_claim ?> rekod dijumpai</td>
                </tr>
                  <?php }else { ?>
                <tr>
                  <td colspan="19" align="center" valign="middle" class="txt_color1 noline">Tiada rekod dijumpai</td>
                </tr>
                  <?php };?>
              </table>
              </div>
              </li> 
            <?php } else { ?>
             <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
                  </tr>
                </table>
			  </li>
              <?php };?>
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
mysql_free_result($claim);
?>
<?php include('../inc/footinc.php');?> 
              
