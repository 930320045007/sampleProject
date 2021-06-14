<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='2';?>
<?php $menu2='3';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_salary = "SELECT * FROM user_salaryskill WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND usersalaryskill_status = '1' ORDER BY usersalaryskill_date_y DESC, usersalaryskill_date_m DESC, usersalaryskill_date_d DESC, usersalaryskill_id DESC";
$salary = mysql_query($query_salary, $hrmsdb) or die(mysql_error());
$row_salary = mysql_fetch_assoc($salary);
$totalRows_salary = mysql_num_rows($salary);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_emo = "SELECT * FROM user_emolumen WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND useremolumen_status = '1' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC";
$emo = mysql_query($query_emo, $hrmsdb) or die(mysql_error());
$row_emo = mysql_fetch_assoc($emo);
$totalRows_emo = mysql_num_rows($emo);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_pendapatan = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE transactiontype_id = 1 AND user_salary.usersalary_status = 1 AND user_salary.user_stafid = '" . $row_user['user_stafid'] . "' ORDER BY user_salary.usersalary_date_y DESC, user_salary.usersalary_date_m DESC, user_salary.usersalary_date_d DESC";
$pendapatan = mysql_query($query_pendapatan, $hrmsdb) or die(mysql_error());
$row_pendapatan = mysql_fetch_assoc($pendapatan);
$totalRows_pendapatan = mysql_num_rows($pendapatan);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_pemotongan = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE transactiontype_id = 2 AND user_salary.usersalary_status = 1 AND user_salary.user_stafid = '" . $row_user['user_stafid'] . "' ORDER BY user_salary.usersalary_date_y DESC, user_salary.usersalary_date_m DESC, user_salary.usersalary_date_d DESC";
$pemotongan = mysql_query($query_pemotongan, $hrmsdb) or die(mysql_error());
$row_pemotongan = mysql_fetch_assoc($pemotongan);
$totalRows_pemotongan = mysql_num_rows($pemotongan);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
</head>
<body <?php include('inc/bodyinc.php');?>>
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
            	<li class="title">Rekod Gaji &sup1;</li>
                <li class="gap">&nbsp;</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_salary > 0) { // Show if recordset not empty ?>
                <tr>
                    <th align="left" valign="middle">Tarikh</th>
                    <th align="center" valign="middle" nowrap="nowrap">Tangga Gaji</th>
                    <th width="100%" align="left" valign="middle"><?php if(!checkNoScheme($row_user['user_stafid'])) echo "Gaji Pokok (RM)"; else echo "Gaji (RM)";?></th>
                </tr>
    			<?php do { ?>
                <tr class="on">
                  <td align="left" valign="middle" nowrap="nowrap"><?php echo $row_salary['usersalaryskill_date_d']; ?> / <?php echo $row_salary['usersalaryskill_date_m']; ?> / <?php echo $row_salary['usersalaryskill_date_y']; ?>  <span class="txt_color1"> &nbsp; &bull; &nbsp; <?php echo getBasicSalaryDateStartByUserID($row_user['user_stafid'], $row_salary['usersalaryskill_id'], 0, 0, 0);?></span></td>
                  <td align="center" valign="middle"><?php echo getSalarySkill($row_user['user_stafid'], $row_salary['usersalaryskill_id'], date('m'), date('Y')); ?></td>
                  <td align="left" valign="middle"><?php echo ($row_salary['usersalaryskill_basicsalary']); ?></td>
                </tr>
                <?php } while ($row_salary = mysql_fetch_assoc($salary)); ?>
                <tr>
                  <td colspan="3" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_salary ?>  rekod dijumpai</td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                </tr>
                <?php }; ?>
              </table>
              </li>
              <li class="gap">&nbsp;</li>
              <li class="title">Rekod Emolumen &sup1;</li>
              <li class="gap">&nbsp;</li>
              <li>
              <div class="off">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_emo > 0) { // Show if recordset not empty ?>
                <tr>
                <th width="50%" align="left" valign="middle" nowrap="nowrap">Tarikh</th>
                  <th align="center" valign="middle" nowrap="nowrap">ITKA (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">ITKRAI (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">ITP (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">BSH (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">EL KTKL (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">Pos Basik (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">EL PAKAR (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">EL Insentif Khas (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">JUSA (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">EL Pembantu Khas (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">EL Pembantu Rumah (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">EL Bahasa (RM)</th>
                  <th align="center" valign="middle" nowrap="nowrap">Lain lain (RM)</th>
                </tr>
                <?php do { ?>
                  <tr class="on">
                    <td align="left" valign="middle" nowrap="nowrap"><?php echo $row_emo['useremolumen_date_d']; ?> / <?php echo $row_emo['useremolumen_date_m']; ?> / <?php echo $row_emo['useremolumen_date_y']; ?> <span class="txt_color1">&nbsp; &bull; &nbsp; <?php echo getEmolumenDateStartByUserID($row_user['user_stafid'], $row_emo['useremolumen_id'], 0, 0, 0);?></span></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_itka']!='') echo number_format($row_emo['useremolumen_itka'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_itkrai']!='') echo number_format($row_emo['useremolumen_itkrai'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_itp']!='') echo number_format($row_emo['useremolumen_itp'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_bsh']!='') echo number_format($row_emo['useremolumen_bsh'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_elktkl']!='') echo number_format($row_emo['useremolumen_elktkl'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_posbasik']!='') echo number_format($row_emo['useremolumen_posbasik'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_elpakar']!='') echo number_format($row_emo['useremolumen_elpakar'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_elinsentif']!='') echo number_format($row_emo['useremolumen_elinsentif'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_jusa']!='') echo number_format($row_emo['useremolumen_jusa'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_elpemkhas']!='') echo  number_format($row_emo['useremolumen_elpemkhas'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_elpemrmh']!='') echo number_format($row_emo['useremolumen_elpemrmh'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_elbhs']!='') echo number_format($row_emo['useremolumen_elbhs'],2); else echo "0"; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($row_emo['useremolumen_o']!='') echo number_format($row_emo['useremolumen_o'],2); else echo "0"; ?></td>
                  </tr>
                  <?php } while ($row_emo = mysql_fetch_assoc($emo)); ?>
                <tr>
                  <td colspan="14" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_emo ?> rekod dijumpai</td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td colspan="14" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                </tr>
                <?php }; ?>
              </table>
              </div>
            </li>
            <li class="gap">&nbsp;</li>
            <li class="title">Pendapatan &sup1;</li>
            <li class="gap">&nbsp;</li>
            <li>
            <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
              	<?php if ($totalRows_pendapatan > 0) { // Show if recordset not empty ?>
                  <tr>
                    <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                    <th nowrap="nowrap">Tarikh Mula</th>
                    <th nowrap="nowrap">Tarikh Tamat</th>
                    <th width="100%" align="left" valign="middle" nowrap="nowrap">Transaksi</th>
                    <th align="center" valign="middle" nowrap="nowrap">Jumlah (RM)</th>
                  </tr>
                  <?php $i=1; do { ?>
                    <tr class="on">
                      <td align="center" valign="middle"><?php echo $i;?></td>
                      <td nowrap="nowrap"><?php echo getTransactionDateStart($row_user['user_stafid'], $row_pendapatan['transaction_id'], $row_pendapatan['usersalary_id']);?></td>
                      <td nowrap="nowrap"><?php echo getTransactionDateEnd($row_user['user_stafid'], $row_pendapatan['transaction_id'], $row_pendapatan['usersalary_id']);?></td>
                      <td align="left" valign="middle"><?php echo getTransactionName($row_pendapatan['transaction_id']);?></td>
                      <td align="center" valign="middle"><?php echo number_format($row_pendapatan['usersalary_value'],2);?></td>
                    </tr>
                    <?php $i++; } while ($row_pendapatan = mysql_fetch_assoc($pendapatan)); ?>
                  <tr>
                    <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_pendapatan ?> rekod dijumpai</td>
                  </tr>
                <?php } else { ?>
                  <tr>
                    <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                  </tr>
                <?php }; ?>
                </table>
            </div>
            </li>
            <li class="gap">&nbsp;</li>
            <li class="title">Potongan &sup1;</li>
            <li class="gap">&nbsp;</li>
            <li>
            <div class="off">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_pemotongan > 0) { // Show if recordset not empty ?>
                <tr>
                  <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                  <th align="center" valign="middle" nowrap="nowrap">Tarikh Mula</th>
                  <th align="center" valign="middle" nowrap="nowrap">Tarikh Tamat</th>
                  <th width="100%" align="left" valign="middle" nowrap="nowrap">Transaksi</th>
                  <th align="center" valign="middle" nowrap="nowrap">Jumlah (RM)</th>
                </tr>
                <?php $i=1; do { ?>
                <tr class="on">
                  <td align="center" valign="middle"><?php echo $i;?></td>
                  <td align="center" valign="middle" nowrap="nowrap"><?php echo getTransactionDateStart($row_user['user_stafid'], $row_pemotongan['transaction_id'], $row_pemotongan['usersalary_id']);?></td>
                  <td align="center" valign="middle" nowrap="nowrap"><?php echo getTransactionDateEnd($row_user['user_stafid'], $row_pemotongan['transaction_id'], $row_pemotongan['usersalary_id']);?></td>
                  <td align="left" valign="middle"><?php echo getTransactionName($row_pemotongan['transaction_id']);?></td>
                  <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format($row_pemotongan['usersalary_value'],2);?></td>
                </tr>
                <?php $i++; } while ($row_pemotongan = mysql_fetch_assoc($pemotongan)); ?>
                <tr>
                  <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_pemotongan; ?> rekod dijumpai</td>
                </tr>
                <?php } else { ?>
                <tr>
                  <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                </tr>
                <?php }; ?>
              </table>
            </div>
            </li>
            <li class="gap">&nbsp;</li>
            </ul>
        </div>
        </div>
    <?php echo noteHR('1'); ?>
  </div>
        
		<?php include('inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($pendapatan);

mysql_free_result($pemotongan);

mysql_free_result($salary);

mysql_free_result($emo);
?>
<?php include('inc/footinc.php');?>
