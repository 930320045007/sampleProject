<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='34';?>
<?php
if(isset($_POST['bulan']))
{
	$dy = explode("/", $_POST['bulan']);
} else if(isset($_GET['bulan'])){
	$dy = explode("/", $_GET['bulan']);
} else {
	$dy[0] = date('m');
	$dy[1] = date('Y');
};

if(isset($_POST['id']))
	$usersalary = strtoupper($_POST['id']);
else if(isset($_GET['id']))
	$usersalary = getID($_GET['id'],0);
else
	$usersalary = $row_user['user_stafid'];

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_pendapatan = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN www.login ON login.user_stafid = user_salary.user_stafid LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE (login.login_status = '1' OR (login.login_date_m >= '" . $dy[0] . "' && login.login_date_y >= '" . $dy[1] . "')) AND transactiontype_id = 1 AND user_salary.user_stafid = '" . $usersalary . "' AND ((user_salary.usersalary_date_m <= '" . $dy[0] . "' AND user_salary.usersalary_date_y = '" . $dy[1] . "')OR(user_salary.usersalary_date_m <= '" . $dy[0] . "' AND user_salary.usersalary_date_y < '" . $dy[1] . "')OR(user_salary.usersalary_date_y < '" . $dy[1] . "')) AND (((user_salary.usersalary_end_m >= '" . $dy[0] . "' AND user_salary.usersalary_end_y = '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) AND user_salary.usersalary_status = '1' ORDER BY user_salary.user_stafid ASC";
$pendapatan = mysql_query($query_pendapatan, $hrmsdb) or die(mysql_error());
$row_pendapatan = mysql_fetch_assoc($pendapatan);
$totalRows_pendapatan = mysql_num_rows($pendapatan);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_tt = "SELECT * FROM transaction_type WHERE transactiontype_status = 1 ORDER BY transactiontype_id ASC";
$tt = mysql_query($query_tt, $hrmsdb) or die(mysql_error());
$row_tt = mysql_fetch_assoc($tt);
$totalRows_tt = mysql_num_rows($tt);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_emo = "SELECT * FROM www.user_emolumen LEFT JOIN www.login ON login.user_stafid = user_emolumen.user_stafid WHERE (login.login_status = '1' OR (login.login_date_m >= '" . $dy[0] . "' && login.login_date_y >= '" . $dy[1] . "')) AND ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . $dy[1] . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . $dy[0] . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . $dy[1] . "')) AND useremolumen_status = '1' AND user_emolumen.user_stafid = '" . $usersalary . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC";
$emo = mysql_query($query_emo, $hrmsdb) or die(mysql_error());
$row_emo = mysql_fetch_assoc($emo);
$totalRows_emo = mysql_num_rows($emo);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_pemotongan = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN www.login ON login.user_stafid = user_salary.user_stafid LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE (login.login_status = '1' OR ((login.login_date_m > '" . $dy[0] . "' && login.login_date_y = '" . $dy[1] . "') OR (login.login_date_y > '" . $dy[1] . "'))) AND transactiontype_id = 2 AND user_salary.user_stafid = '" . $usersalary . "' AND ((user_salary.usersalary_date_m <= '" . $dy[0] . "' AND user_salary.usersalary_date_y = '" . $dy[1] . "')OR(user_salary.usersalary_date_y < '" . $dy[1] . "')) AND (((user_salary.usersalary_end_m >= '" . $dy[0] . "' AND user_salary.usersalary_end_y = '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . $dy[1] . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) AND user_salary.usersalary_status = '1' ORDER BY user_salary.user_stafid ASC";
$pemotongan = mysql_query($query_pemotongan, $hrmsdb) or die(mysql_error());
$row_pemotongan = mysql_fetch_assoc($pemotongan);
$totalRows_pemotongan = mysql_num_rows($pemotongan);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jadual = "SELECT * FROM www.salary_sch WHERE salarysch_status = 1 ORDER BY salarysch_y DESC, salarysch_m DESC";
$jadual = mysql_query($query_jadual, $hrmsdb) or die(mysql_error());
$row_jadual = mysql_fetch_assoc($jadual);
$totalRows_jadual = mysql_num_rows($jadual);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kewelist = "SELECT user_kewe.* FROM www.user_kewe WHERE userkewe_status = 1 AND user_kewe.user_stafid = '" . $usersalary . "' AND NOT EXISTS (SELECT * FROM www.user_salary WHERE user_stafid ='" . $usersalary . "' AND user_salary.usersalary_kew8 = user_kewe.userkewe_id) AND NOT EXISTS (SELECT * FROM www.user_salaryskill WHERE usersalaryskill_status = 1 AND user_salaryskill.user_stafid ='" . $usersalary . "' AND user_salaryskill.userkewe_id = user_kewe.userkewe_id) AND NOT EXISTS (SELECT * FROM www.user_emolumen WHERE useremolumen_status = 1 AND user_emolumen.user_stafid ='" . $usersalary . "' AND user_emolumen.userkewe_id = user_kewe.userkewe_id)";
$kewelist = mysql_query($query_kewelist, $hrmsdb) or die(mysql_error());
$row_kewelist = mysql_fetch_assoc($kewelist);
$totalRows_kewelist = mysql_num_rows($kewelist);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<?php include('../inc/liload.php');?>
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
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            <li class="form_back">
              <form id="formcheckstaf" name="formcheckstaf" method="post" action="salary.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td nowrap="nowrap" class="label">Staf ID</td>
                    <td width="100%">
                    <input name="id" type="text" class="w30" id="id" value="<?php echo $usersalary;?>" list="datastaf" />
                    <?php echo datalistStaf('datastaf');?>
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
            		<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                    <td><input name="button7" type="button" class="submitbutton" id="button7" value="Senarai" onclick="MM_goToURL('parent','profilelist.php');return document.MM_returnValue" /></td>
                    <td><input name="button3" type="button" class="submitbutton" id="button3" value="Block" onclick="MM_goToURL('parent','salaryblock.php');return document.MM_returnValue" /></td>
                    <?php }; ?>
                  </tr>
                </table>
              </form>
            </li>
            <?php if((isset($_POST['id'])) || (isset($_GET['id']))){?>
              <li class="gap">&nbsp;</li>
              <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic($usersalary);?></td>
                    <td class="label">Nama</td>
                    <td width="100%"><?php echo getFullNameByStafID($usersalary) . " (" . $usersalary . ")"; ?></td>
                  </tr>
                  <tr>
                    <td class="label noline">Lokasi</td>
                    <td class="noline"><?php echo getFulldirectoryByUserID($usersalary);?></td>
                  </tr>
                </table>
              </li>
              <li class="gap">&nbsp;</li>
              <li class="title">Penyata Gaji <span class="fr add"><a href="salaryyearlist.php?id=<?php echo getID($usersalary,1);?>">Tahunan</a></span> 
              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $row_user['user_stafid']!=$usersalary){?><span class="fr add" onClick="toggleview2('formpendapatan'); return false;">Tambah</span><?php }; ?></li>
              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $row_user['user_stafid']!=$usersalary){?>
              <div id="formpendapatan" class="hidden">
                <li>
                  <form id="form2" name="form2" method="post" action="../sb/add_usersalary.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label noline">Tarikh Mula</td>
                        <td width="50%" class="noline">
                          <select name="usersalary_date_d" id="usersalary_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                            <option value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                          </select>
                          <select name="usersalary_date_m" id="usersalary_date_m">
                          <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                          <?php }; ?>
                        </select>
                          <select name="usersalary_date_y" id="usersalary_date_y">
                          <?php $year = (date('Y')+5); for($k=(date('Y')-5); $k<$year; $k++){?>
                            <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                          <?php }; ?>
                        </select></td>
                        <td nowrap="nowrap" class="label noline">Tarikh Tamat</td>
                        <td width="50%" class="noline">
                        <div>
                          <select name="usersalary_end_d" id="usersalary_end_d">
                            <option selected="selected" value="0">0</option>
                          <?php for($l=1; $l<=31; $l++){?>
                            <option value="<?php if($l<10) $l = '0' . $l; echo $l;?>"><?php echo $l;?></option>
                          <?php }; ?>
                          </select>
                          <select name="usersalary_end_m" id="usersalary_end_m">
                            <option selected="selected" value="0">0</option>
                          <?php for($m=1; $m<=12; $m++){?>
                            <option value="<?php if($m<10) $m = '0' . $m; echo $m;?>"><?php echo date('m - M', mktime(0, 0, 0, $m, 1, date('Y')));?></option>
                          <?php }; ?>
                        </select>
                          <select name="usersalary_end_y" id="usersalary_end_y">
                            <option selected="selected" value="0">0</option>
                          <?php for($n=(date('Y')); $n<=$year; $n++){?>
                            <option  value="<?php echo $n;?>"><?php echo $n;?></option>
                          <?php }; ?>
                        </select>
                        </div>
                        <div class="inputlabel2">0 untuk Berterusan</div></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline">Kategori</td>
                        <td width="50%" class="noline">
                          <select name="tt" id="tt" onChange="dochange('10', 'transaction_id', this.value, '<?php echo $usersalary;?>');">
                            <option value="0">Sila pilih Kategori</option>
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_tt['transactiontype_id']?>"><?php echo $row_tt['transactiontype_name']?></option>
                            <?php
							} while ($row_tt = mysql_fetch_assoc($tt));
							  $rows = mysql_num_rows($tt);
							  if($rows > 0) {
								  mysql_data_seek($tt, 0);
								  $row_tt = mysql_fetch_assoc($tt);
							  }
							?>
                          </select>
                          <select name="transaction_id" id="transaction_id">
                            <option value="0">Sila pilih Kategori</option>
                        </select>
                        </td>
                        <td nowrap="nowrap" class="label noline">Rujukan Kew8</td>
                        <td width="50%" class="noline">
                          <select name="usersalary_kew8" id="select2">
                            <option value="0">Tiada</option>
							<?php if ($totalRows_kewelist > 0) { // Show if recordset not empty ?>
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_kewelist['userkewe_id']?>"><?php echo $row_kewelist['userkewe_date_m'] . "/" . $row_kewelist['userkewe_date_y'] . "/" . $row_kewelist['userkewe_siri']?> <?php echo getKew8NameByID($row_kewelist['kewe_id']);?></option>
                            <?php
							} while ($row_kewelist = mysql_fetch_assoc($kewelist));
							  $rows = mysql_num_rows($kewelist);
							  if($rows > 0) {
								  mysql_data_seek($kewelist, 0);
								  $row_kewelist = mysql_fetch_assoc($kewelist);
							  }
							?>
							<?php } // Show if recordset not empty ?>
                          </select>
                          </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline">Jumlah</td>
                        <td width="50%" class="noline"><span class="inputlabel">RM</span> <input name="usersalary_value" type="text" class="w50" id="usersalary_value" /><div class="inputlabel2">Cth : 200.00</div></td>
                        <td nowrap="nowrap" class="label noline">No. Rujukan</td>
                        <td width="50%" nowrap="nowrap" class="noline"><label for="usersalary_ref"></label>
                        <input type="text" name="usersalary_ref" id="usersalary_ref" /></td>
                      </tr>
                      <tr>
                        <td class="label noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $usersalary;?>" /></td>
                        <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" /> <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
              </div>
              <?php }; ?>
              </ul>
          </div>
        	<div class="profilemenu">
            <ul>
              <?php  if(!checkSalaryBlockByUserID($row_user['user_stafid'], $dy[0], $dy[1])){?>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Bulan</td>
                      <td width="50%"><?php echo date('F Y', mktime(0, 0, 0, $dy[0], getDateBySchDate($dy[0], $dy[1]), $dy[1]));?></td>
                      <td nowrap="nowrap" class="label">Bank</td>
                      <td width="50%"><?php echo getBankNameByUserID($usersalary);?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Dikreditkan pada</td>
                      <td class="noline"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $dy[0], getDateBySchDate($dy[0], $dy[1]), $dy[1]));?></td>
                      <td nowrap="nowrap" class="label noline">Akaun</td>
                      <td class="noline"><?php echo getAccBankByUserID($usersalary);?></td>
                    </tr>
                  </table>
                </li>
              <li style="margin: 0px; padding: 0px;">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr class="back_darkgrey line_t">
                    <td width="50%" nowrap="nowrap" class="line_r"><strong>Pendapatan</strong></td>
                    <td width="50%" nowrap="nowrap"><strong>Potongan</strong></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="line_r"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="on">
                        <td width="70%" colspan="2" class="noline">Gaji Pokok  (<?php echo getSalarySkill($usersalary, 0, $dy[0], $dy[1]); ?>)</td>
                        <td width="20%" align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getBasicSalaryByUserID($usersalary, 1, $dy[0], $dy[1]), 2);?></td>
                      </tr>
                      <?php if($row_emo['useremolumen_itka']!=0 && $row_emo['useremolumen_itka']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">Imbuhan Tetap Khidmat Awam (ITKA)</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><span class="noline"><?php echo number_format(getEmolumenITKAByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></span></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_itkrai']!=0 && $row_emo['useremolumen_itkrai']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">IT KRAI</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenITKraiByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_itp']!=0 && $row_emo['useremolumen_itp']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">Imbuhan Tetap Perumahan (ITP)</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenITPByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_bsh']!=0 && $row_emo['useremolumen_bsh']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">Bantuan Sara Hidup (BSH)</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenBSHByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_elktkl']!=0 && $row_emo['useremolumen_elktkl']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">EL KTKL</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElKtklByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_elpksht']!=0 && $row_emo['useremolumen_elpksht']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">EL PKSHT</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPkshtByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_elpakar']!=0 && $row_emo['useremolumen_elpakar']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">EL PAKAR</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPakarByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_elmemangku']!=0 && $row_emo['useremolumen_elmemangku']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">Elaun Memangku</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElMemangkuByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_jusa']!=0 && $row_emo['useremolumen_jusa']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">JUSA</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenJUSAByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_elpemkhas']!=0 && $row_emo['useremolumen_elpemkhas']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">EL PEMBANTU KHAS</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPemKhasByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_elpemrmh']!=0 && $row_emo['useremolumen_elpemrmh']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">EL PEMBANTU RUMAH</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElPemRmhByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_elbhs']!=0 && $row_emo['useremolumen_elbhs']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">EL BAHASA</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenElBhsByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_posbasik']!=0 && $row_emo['useremolumen_posbasik']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">Pos Basik</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenPosBasikByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if($row_emo['useremolumen_o']!=0 && $row_emo['useremolumen_o']!=NULL){?>
                      <tr class="on">
                        <td colspan="2" class="noline">Lain-lain</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getEmolumenOByUserID($usersalary, 0, $dy[0], $dy[1]),2); ?></td>
                      </tr>
                      <?php }; ?>
                      <?php if ($totalRows_pendapatan > 0) { // Show if recordset not empty ?>
                      <?php do { ?>
                      <tr class="on">
                        <td width="100%" class="noline"><?php echo getTransactionName($row_pendapatan['transaction_id']); ?><span class="txt_color1"> &nbsp; &bull; &nbsp; <?php echo getTransactionDateStart($usersalary, $row_pendapatan['transaction_id'], $row_pendapatan['usersalary_id']);?></span></td>
                        <td nowrap="nowrap" class="noline">
                        <ul class="func">
                        <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3) && $row_user['user_stafid']!=$usersalary){?>
                        <li><a href="salarydetail.php?id=<?php echo getID($usersalary,1);?>&tid=<?php echo $row_pendapatan['usersalary_id']; ?>&bulan=<?php echo $dy[0] . "/" . $dy[1];?>">Edit</a></li>
                        <?php }; ?>
                        <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4) && $row_user['user_stafid']!=$usersalary){?>
                        <li><a onclick="return confirm('PERHATIAN! \r\n\n Transaksi yang dipadam tidak akan dinyatakan pada penyata gaji yang lepas. Jika ingin menamatkan Transaksi, sila masukkan tarikh tamat dalam Edit. \r\n\n Anda mahu maklumat berikut dipadam? \r\n\n <?php echo getTransactionName($row_pendapatan['transaction_id']); ?>  = RM <?php echo $row_pendapatan['usersalary_value'];?>')" href="<?php echo $url_main;?>sb/del_usersalary.php?dm=<?php echo $dy[0];?>&dy=<?php echo $dy[1];?>&delus=<?php echo getID($row_pendapatan['usersalary_id']); ?>&usdm=<?php echo getID($row_pendapatan['usersalary_date_m']); ?>&usdy=<?php echo getID($row_pendapatan['usersalary_date_y']); ?>&usid=<?php echo getID($usersalary);?>&tid=<?php echo getID($row_pendapatan['transaction_id']);?>">&times;</a></li>
                        <?php }; ?>
                        </ul>
                        </td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format($row_pendapatan['usersalary_value'],2); ?></td>
                      </tr>
                      <?php } while ($row_pendapatan = mysql_fetch_assoc($pendapatan)); ?>
                      <?php } // Show if recordset not empty ?>
                    </table></td>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="on">
                        <td width="70%" colspan="2" class="noline">KWSP (<?php echo getKWSPStafPercByStafID($usersalary, date('d'), $dy[0], $dy[1]);?>%)</td>
                        <td width="20%" align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getKWSPStafRM($usersalary, date('d'), $dy[0], $dy[1]), 2);?></td>
                      </tr>
                      <tr class="on">
                        <td colspan="2" class="noline">PERKESO </td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getPERKESOStafRM($usersalary, date('d'), $dy[0], $dy[1]),2);?></td>
                      </tr>
                      <tr class="on">
                        <td colspan="2" class="noline">Kelab ISN</td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format(getKelabMSNRM($usersalary, date('d'), $dy[0], $dy[1]), 2);?></td>
                      </tr>
                      <?php if ($totalRows_pemotongan > 0) { // Show if recordset not empty ?>
                      <?php do { ?>
                      <tr class="on">
                        <td width="100%" class="noline"><?php echo getTransactionName($row_pemotongan['transaction_id']); ?><span class="txt_color1"> &nbsp; &bull; &nbsp; <?php echo getTransactionDateStart($usersalary, $row_pemotongan['transaction_id'], $row_pemotongan['usersalary_id']);?></span></td>
                        <td nowrap="nowrap" class="noline">
                        <ul class="func">
                            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3) && $row_user['user_stafid']!=$usersalary){?>
                            <li><a href="salarydetail.php?id=<?php echo getID($usersalary,1);?>&tid=<?php echo $row_pemotongan['usersalary_id']; ?>&bulan=<?php echo $dy[0] . "/" . $dy[1];?>">Edit</a></li>
                            <?php }; ?>
                            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4) && $row_user['user_stafid']!=$usersalary){?>
                            <li><a onclick="return confirm('PERHATIAN! \r\n\n Transaksi yang dipadam tidak akan dinyatakan pada penyata gaji yang lepas. Jika ingin menamatkan Transaksi, sila masukkan tarikh tamat dalam Edit. \r\n\n Anda mahu maklumat berikut dipadam? \r\n\n <?php echo getTransactionName($row_pemotongan['transaction_id']); ?>  = RM <?php echo $row_pemotongan['usersalary_value'];?>')"

 href="<?php echo $url_main;?>sb/del_usersalary.php?dm=<?php echo $dy[0];?>&dy=<?php echo $dy[1];?>&delus=<?php echo getID($row_pemotongan['usersalary_id']); ?>&usdm=<?php echo getID($row_pemotongan['usersalary_date_m']); ?>&usdy=<?php echo getID($row_pemotongan['usersalary_date_y']); ?>&usid=<?php echo getID($usersalary);?>&tid=<?php echo getID($row_pemotongan['transaction_id']);?>">&times;</a></li>
                            <?php }; ?>
                        </ul>
                        </td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><?php echo number_format($row_pemotongan['usersalary_value'],2); ?></td>
                      </tr>
                      <?php } while ($row_pemotongan = mysql_fetch_assoc($pemotongan)); ?>
                      <?php } // Show if recordset not empty ?>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="line_r"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="70%" align="left" valign="middle" class="noline">Jumlah Pendapatan</td>
                        <td width="20%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getTotalSalaryByUserID($usersalary, date('d'), $dy[0], $dy[1]), 2);?></strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" class="noline">Baki Bersih </td>
                        <td align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getGajiBersihByUserID($usersalary, date('d'), $dy[0], $dy[1]), 2);?></strong></td>
                      </tr>
                    </table></td>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="70%" align="left" valign="middle" class="noline">Jumlah Potongan</td>
                        <td width="20%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getTotalCutByUserID($usersalary, date('d'), $dy[0], $dy[1]), 2);?></strong></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="back_darkgrey"><strong>Caruman oleh Majikan</strong></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="noline"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" class="noline">KWSP (<?php echo getKWSPEmpPercByStafID($usersalary, date('d'), $dy[0], $dy[1]);?>%)</td>
                        <td width="3%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getKWSPEmpRM($usersalary, date('d'), $dy[0], $dy[1]), 2);?></strong></td>
                        <td width="30%" class="noline">PERKESO </td>
                        <td width="3%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getPERKESOEmpRM($usersalary, date('d'), $dy[0], $dy[1]), 2);?></strong></td>
                        <td width="30%" class="noline">PENCEN</td>
                        <td width="3%" align="right" valign="middle" class="noline back_lightgrey"><strong><?php echo number_format(getPencenByStafID($usersalary, $dy[0], $dy[1]),2);?></strong></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
              </li>
            <?php } else { ?>
              <li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" valign="middle" class="noline txt_color2">Kakitangan berikut dihalang untuk mendapatkan Penyata Gaji bagi bulan <strong><?php echo date('F Y', mktime(0, 0, 0, $dy[0],1, $dy[1]));?></strong></td>
                </tr>
              </table>
              </li>
            <?php }; ?>
              <?php } else { ?>
              <li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" valign="middle" class="noline">Tiada rekod dijumpai / Staf ID tidak aktif. Sila masukkan Staf ID.</td>
                </tr>
              </table>
              </li>
              <?php }; ?>
            </ul>
            </div>
        <?php }; ?>
        </div>
        <div class="inputlabel2 padt">* Pendapatan tidak dikira dalam potongan KWSP & PERKESO</div>
        <?php echo noteEmail(1);?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($pendapatan);

mysql_free_result($tt);

mysql_free_result($emo);

mysql_free_result($pemotongan);

mysql_free_result($jadual);

mysql_free_result($kewelist);
?>
<?php include('../inc/footinc.php');?>
