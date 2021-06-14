<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='2';?>
<?php $menu2='36';?>
<?php

if(isset($_POST['bulan']))
{
	$dy = explode("/", htmlspecialchars($_POST['bulan'], ENT_QUOTES));
} else {
	$dy[0] = date('m');
	$dy[1] = date('Y');
}

if($dy[0]== date('m') && $dy[1] == date('Y'))
{
	$dd = date('d');
} else {
	$dd = 1;
};

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_pemotongan = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE transactiontype_id = 2 AND user_salary.user_stafid = '" . $row_user['user_stafid'] . "' AND ((user_salary.usersalary_date_m <= '" . $dy[0] . "' AND user_salary.usersalary_date_y = '" . $dy[1] . "') OR (user_salary.usersalary_date_m <= '" . $dy[0] . "' AND user_salary.usersalary_date_y < '" . $dy[1] . "') OR (user_salary.usersalary_date_y < '" . $dy[1] . "')) AND (((user_salary.usersalary_end_m >= '" . $dy[0] . "' AND user_salary.usersalary_end_y = '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) AND user_salary.usersalary_status = 1 ORDER BY user_stafid ASC";
$pemotongan = mysql_query($query_pemotongan, $hrmsdb) or die(mysql_error());
$row_pemotongan = mysql_fetch_assoc($pemotongan);
$totalRows_pemotongan = mysql_num_rows($pemotongan);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_pendapatan = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE transactiontype_id = 1 AND user_salary.user_stafid = '" . $row_user['user_stafid'] . "' AND ((user_salary.usersalary_date_m <= '" . $dy[0] . "' AND user_salary.usersalary_date_y = '" . $dy[1] . "')OR(user_salary.usersalary_date_m <= '" . $dy[0] . "' AND user_salary.usersalary_date_y < '" . $dy[1] . "')OR(user_salary.usersalary_date_y < '" . $dy[1] . "')) AND (((user_salary.usersalary_end_m >= '" . $dy[0] . "' AND user_salary.usersalary_end_y = '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) AND user_salary.usersalary_status = 1 ORDER BY user_stafid ASC";
$pendapatan = mysql_query($query_pendapatan, $hrmsdb) or die(mysql_error());
$row_pendapatan = mysql_fetch_assoc($pendapatan);
$totalRows_pendapatan = mysql_num_rows($pendapatan);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_emo = "SELECT * FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . $dy[1] . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . $dy[0] . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . $dy[1] . "')) AND useremolumen_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC";
$emo = mysql_query($query_emo, $hrmsdb) or die(mysql_error());
$row_emo = mysql_fetch_assoc($emo);
$totalRows_emo = mysql_num_rows($emo);

$month = date('m', mktime(0, 0, 0, date('m')-3, 1, date('Y')));
$year = date('Y', mktime(0, 0, 0, date('m')-3, 1, date('Y')));

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jadual = "SELECT salarysch_d, salarysch_m, salarysch_y FROM www.salary_sch WHERE salarysch_status = 1 AND ((salarysch_m >= '" . $month . "' AND salarysch_y = '" . $year . "') OR (salarysch_m < '".$month . "'  AND salarysch_y > '" . (date('Y')-1) . "')) AND ((salarysch_y = '" . getStartDayDate($row_user['user_stafid'], 3) . "' AND salarysch_m >= '" . getStartDayDate($row_user['user_stafid'], 2) . "') OR (salarysch_y > '" . getStartDayDate($row_user['user_stafid'], 3) . "')) ORDER BY salarysch_y ASC, salarysch_m ASC LIMIT 5";
$jadual = mysql_query($query_jadual, $hrmsdb) or die(mysql_error());
$row_jadual = mysql_fetch_assoc($jadual);
$totalRows_jadual = mysql_num_rows($jadual);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
</head>
<body <?php include('inc/bodyinc.php');?>>
<?php if(!checkSalaryErrorID($row_user['user_stafid'], $dy[0], $dy[1])) echo getPassBoxC('formPasswordc', $url_main . 'sb/salary_error.php?m=' . $dy[0] . '&y=' . $dy[1], $url_main . "salarystatement.php");?>
<div>
	<div>
		<?php include('inc/header.php');?>
        <?php include('inc/menu.php');?>
        
      	<div class="content">
        <?php include('inc/menu_profail.php');?>
        <div class="tabbox">        	
        <?php include('inc/profile.php');?>
        <div class="profilemenu">
            <ul>
                <li class="title">Penyata Gaji Bulanan</li>
            </ul>
          </div> 
          <?php if(checkWaris($row_user['user_stafid']) && checkEdu($row_user['user_stafid']) && checkAddressByStafID($row_user['user_stafid']) && checkTelMByStafID($row_user['user_stafid']) && checkAccBankByUserID($row_user['user_stafid']) && checkBankByUserID($row_user['user_stafid']) && checkPERKESOByUserID($row_user['user_stafid']) && checkKWSPByUserID($row_user['user_stafid']) && !$maintenance){?>
        <div class="profilemenu">
          	<ul>
                <li class="form_back">
                  <form id="form1" name="form1" method="post" action="salarystatement.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Bulan </td>
                        <td width="100%" align="left" valign="middle"><label for="bulan"></label>
                          <select name="bulan" id="bulan">
                            <?php
							do {  
							?>
                            <option <?php if($dy[0] == $row_jadual['salarysch_m'] && $dy[1] == $row_jadual['salarysch_y']) echo "selected=\"selected\"";?> value="<?php echo $row_jadual['salarysch_m'] . "/" . $row_jadual['salarysch_y']?>"><?php echo date('M Y', mktime(0, 0, 0, $row_jadual['salarysch_m'], $row_jadual['salarysch_d'], $row_jadual['salarysch_y']));?></option>
                            <?php
								} while ($row_jadual = mysql_fetch_assoc($jadual));
								  $rows = mysql_num_rows($jadual);
								  if($rows > 0) {
									  mysql_data_seek($jadual, 0);
									  $row_jadual = mysql_fetch_assoc($jadual);
								  }
								?>
                               
                          </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                        
                        <?php if(checkSalarySchDatePast($dd, $dy[0], $dy[1]) && checkSalarySchDate($dy[0], $dy[1]) && !checkSalaryBlockByUserID($row_user['user_stafid'],$dy[0], $dy[1]) && getBasicSalaryByUserID($row_user['user_stafid'], 1, $dy[0], $dy[1])!='0'){?>
                        <td align="left" valign="middle">
                        <input name="button5" type="button" class="submitbutton" id="button5" value="Cetak" onclick="MM_openBrWindow('<?php echo $url_main;?>printsalary.php?m=<?php echo $dy[0];?>&y=<?php echo $dy[1];?>','salary','status=yes,scrollbars=yes,width=800,height=600')" /></td>
                        <?php }; ?>
                        <td align="left" valign="middle"><input name="button6" type="button" class="submitbutton" id="button6" value="Tahunan" onclick="MM_goToURL('parent','salarystatementyear.php');return document.MM_returnValue" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php if(checkSalarySchDate($dy[0], $dy[1]) && !checkSalaryBlockByUserID($row_user['user_stafid'],$dy[0], $dy[1]) && getBasicSalaryByUserID($row_user['user_stafid'], 1, $dy[0], $dy[1])!='0'){?>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Bulan</td>
                      <td width="50%"><?php echo date('F Y', mktime(0, 0, 0, $dy[0], getDateBySchDate($dy[0], $dy[1]), $dy[1]));?></td>
                      <td nowrap="nowrap" class="label">Bank</td>
                      <td width="50%"><?php echo getBankNameByUserID($row_user['user_stafid']);?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Dikreditkan pada</td>
                      <td class="noline"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $dy[0], getDateBySchDate($dy[0], $dy[1]), $dy[1]));?></td>
                      <td nowrap="nowrap" class="label noline">Akaun</td>
                      <td class="noline"><?php echo getAccBankByUserID($row_user['user_stafid']);?></td>
                    </tr>
                  </table>
              </li>
              <li class="gap">&nbsp;</li>
              <?php }; ?>
            </ul>
            </div>
          </div> 
        <div class="tabbox profilemenu">
       	  <ul>
            <?php if(checkSalarySchDate($dy[0], $dy[1]) && !checkSalaryBlockByUserID($row_user['user_stafid'],$dy[0], $dy[1]) && getBasicSalaryByUserID($row_user['user_stafid'], 1, $dy[0], $dy[1])!='0'){?>
        	<li style="margin: 0px; padding: 0px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr class="back_darkgrey line_t">
                <td width="50%" nowrap="nowrap" class="line_r"><strong>Pendapatan</strong></td>
                <td width="50%" nowrap="nowrap"><strong>Potongan</strong></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="line_r">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr >
                    <td width="70%" class="noline in_upper">Gaji Pokok (<?php echo getSalarySkill($row_user['user_stafid'], 0, $dy[0], $dy[1]); ?>)</td>
                    <td width="20%" align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getBasicSalaryByUserID($row_user['user_stafid'], 1, $dy[0], $dy[1]), 2);?></td>
                  </tr>
                  <?php if($row_emo['useremolumen_itka']!=0 && $row_emo['useremolumen_itka']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">Imbuhan Tetap Khidmat Awam (ITKA)</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><span class="noline"><?php echo number_format(getEmolumenITKAByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></span></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_itkrai']!=0 && $row_emo['useremolumen_itkrai']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">IT KRAI</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenITKraiByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_itp']!=0 && $row_emo['useremolumen_itp']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">Imbuhan Tetap Perumahan (ITP)</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenITPByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_bsh']!=0 && $row_emo['useremolumen_bsh']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">Bantuan Sara Hidup (BSH)</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenBSHByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_elktkl']!=0 && $row_emo['useremolumen_elktkl']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">EL KTKL</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElKtklByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_elpksht']!=0 && $row_emo['useremolumen_elpksht']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">EL PKSHT</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPkshtByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_elpakar']!=0 && $row_emo['useremolumen_elpakar']!=NULL){?>
                  <tr>
                    <td class="noline in_upper">EL PAKAR</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPakarByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_elmemangku']!=0 && $row_emo['useremolumen_elmemangku']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">Elaun Memangku</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElMemangkuByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_jusa']!=0 && $row_emo['useremolumen_jusa']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">JUSA</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenJUSAByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_elpemkhas']!=0 && $row_emo['useremolumen_elpemkhas']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">EL PEMBANTU KHAS</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPemKhasByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_elpemrmh']!=0 && $row_emo['useremolumen_elpemrmh']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">EL PEMBANTU RUMAH</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPemRmhByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_elbhs']!=0 && $row_emo['useremolumen_elbhs']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">EL BAHASA</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElBhsByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if($row_emo['useremolumen_o']!=0 && $row_emo['useremolumen_o']!=NULL){?>
                  <tr >
                    <td class="noline in_upper">Lain-lain</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenOByUserID($row_user['user_stafid'], 0, $dy[0], $dy[1]),2); ?></td>
                  </tr>
                  <?php }; ?>
                  <?php if ($totalRows_pendapatan > 0) { // Show if recordset not empty ?>
                  <?php do { ?>
                    <tr >
                        <td class="noline in_upper"><?php echo getTransactionName($row_pendapatan['transaction_id']); ?></td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format($row_pendapatan['usersalary_value'],2); ?></td>
                    </tr>
                   <?php } while ($row_pendapatan = mysql_fetch_assoc($pendapatan)); ?>
                   <?php } // Show if recordset not empty ?>
                </table></td>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if(checkKWSPByStafID($row_user['user_stafid'], date('d'), $dy[0], $dy[1])) {?>
                  <tr >
                    <td width="70%" class="noline">KWSP (<?php echo getKWSPStafPercByStafID($row_user['user_stafid'], date('d'), $dy[0], $dy[1]);?>%)</td>
                    <td width="20%" align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getKWSPStafRM($row_user['user_stafid'], date('d'), $dy[0], $dy[1], 1, 0), 2);?></td>
                  </tr>
                 <?php }; ?>
                  <tr >
                    <td class="noline">PERKESO </td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getPERKESOStafRM($row_user['user_stafid'], date('d'), $dy[0], $dy[1]),2);?></td>
                  </tr>
                  <?php if(checkKelabMSNRM($row_user['user_stafid'])){?>
                  <tr >
                    <td class="noline">KELAB ISN</td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getKelabMSNRM($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></td>
                  </tr>
                  <?php }; ?>
                  <?php if ($totalRows_pemotongan > 0) { // Show if recordset not empty ?>
                  <?php do { ?>
                    <tr >
                    	<td class="noline"><?php echo strtoupper(getTransactionName($row_pemotongan['transaction_id'])); ?></td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format($row_pemotongan['usersalary_value'],2); ?></td>
                    </tr>
                   <?php } while ($row_pemotongan = mysql_fetch_assoc($pemotongan)); ?>
                   <?php } // Show if recordset not empty ?>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="line_r">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70%" align="left" valign="middle" class="noline">Jumlah Pendapatan</td>
                    <td width="20%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getTotalSalaryByUserID($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></strong></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="noline">Baki Bersih </td>
                    <td align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getGajiBersihByUserID($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></strong></td>
                  </tr>
                </table></td>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70%" align="left" valign="middle" class="noline">Jumlah Potongan</td>
                    <td width="20%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getTotalCutByUserID($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></strong></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td colspan="2" class="back_darkgrey"><strong>Caruman oleh Majikan</strong></td>
                </tr>
              <tr>
                <td colspan="2" class="noline">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="30%" class="noline">KWSP (<?php echo getKWSPEmpPercByStafID($row_user['user_stafid'], date('d'), $dy[0], $dy[1]);?>%)</td>
                    <td width="3%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getKWSPEmpRM($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></strong></td>
                    <td width="30%" class="noline">PERKESO </td>
                    <td width="3%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getPERKESOEmpRM($row_user['user_stafid'], date('d'), $dy[0], $dy[1]), 2);?></strong></td>
                    <td width="30%" class="noline">PENCEN</td>
                    <td width="3%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getPencenByStafID($row_user['user_stafid'], $dy[0], $dy[1]),2);?></strong></td>
                  </tr>
                </table>
                </td>
              </tr>
            </table>
            </li>
            <?php if(!checkSalaryErrorID($row_user['user_stafid'], $dy[0], $dy[1]) && !checkSalaryBlockByUserID($row_user['user_stafid'],$dy[0], $dy[1]) && getBasicSalaryByUserID($row_user['user_stafid'], 1, $dy[0], $dy[1])!='0'){?>
            <li class="form_back2 line_t">
              <form id="form2" name="form2" method="post" action="">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="middle">
                    <div class="txt_line">
                      <div><strong class="txt_color2">Jika ada pindaan kepada senarai pendapatan dan pemotongan dengan nilai yang dinyatakan sahaja</strong>, sila klik butang 'Pindaan' disebelah kanan untuk maklum balas daripada <?php echo $adname;?> berkaitan pindaan ini. Sila abaikan jika tiada sebarang pindaan pada penyata yang dinyatakan diatas. Terima kasih.
                      </div>
                    </div></td>
                    <td align="left" valign="middle"><input name="button4" type="button" class="submitbutton" id="button4" value="Pindaan" onClick="toggleview2('formPasswordc'); return false;" />
                    </td>
                  </tr>
                </table>
              </form>
            </li>
            <?php }; ?>
            <?php } else { ?>
            <li>
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="middle">Tiada penyata bagi bulan <strong><?php echo date('F Y', mktime(0,0,0, $dy[0], 1, $dy[1]));?></strong>. Sila berhubung dengan <?php echo $adname;?> untuk maklumat lanjut.</td>
                  </tr>
                </table>
            </li>
            <?php }; ?>
          </ul>
        </div>
        <div class="inputlabel2 padt">* Pendapatan tidak dikira dalam potongan KWSP & PERKESO</div>
        </div>
            
          <?php } else { ?>
          
        <div class="profilemenu">
			<ul>
          	<?php if(!checkAccBankByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>No. Akaun Bank</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkBankByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>Nama Bank</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkKWSPByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>No. KWSP</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkPERKESOByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>No. PERKESO</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; if(!checkAddressByStafID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>Alamat Terkini</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; if(!checkTelMByStafID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>No. Tel (Mobile)</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkWaris($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>Waris / Rujukan Kecemasan</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; if(!checkEdu($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>Rekod Pendidikan</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; if($maintenance){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sistem dalam proses pengemaskinian dan penambahbaikkan buat sementara waktu.</div></li>
          	<?php }; ?>
			</ul>
          </div>
          <?php } ?>
        </div>
        </div>
		<?php include('inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($pemotongan);

mysql_free_result($pendapatan);

mysql_free_result($emo);

mysql_free_result($jadual);
?>
<?php include('inc/footinc.php');?> 