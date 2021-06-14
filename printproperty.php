<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php include ('qr/qrlib.php');?>
<?php $menu='2';?>
<?php $menu2='83';?>
<?php

$wsql = "";

if(isset($_GET['y']))
{
	$wsql .= " AND userproperty_date_y = '" . htmlspecialchars($_GET['y'], ENT_QUOTES) . "'";
	$dy = htmlspecialchars($_GET['y'], ENT_QUOTES);
} else {
	$wsql .= " AND userproperty_date_y = '" . date('Y') . "'";
	$dy = date('Y');
};

$userproperty = "-1";

if(isset($_POST['id']))
	$userproperty = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES));
else if(isset($_GET['id']))
	$userproperty = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
else
	$userproperty = $row_user['user_stafid'];
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_property = "SELECT * FROM user_property WHERE userproperty_date_y = '" . $dy . "' AND userproperty_status = 1 AND user_stafid = '" . $userproperty . "' ORDER BY userproperty_date_y DESC";
$property = mysql_query($query_property, $hrmsdb) or die(mysql_error());
$row_property = mysql_fetch_assoc($property);
$totalRows_property = mysql_num_rows($property);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_ec = "SELECT * FROM user_ec WHERE user_stafid ='". $userproperty ."' AND userec_status = '1' ORDER BY userec_name ASC";
$user_ec = mysql_query($query_user_ec, $hrmsdb) or die(mysql_error());
$row_user_ec = mysql_fetch_assoc($user_ec);
$totalRows_user_ec = mysql_num_rows($user_ec);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_dependents = "SELECT * FROM user_dependents WHERE user_stafid = '". $userproperty ."' AND userdependents_status = '1' ORDER BY userdependents_relation ASC";
$user_dependents = mysql_query($query_user_dependents, $hrmsdb) or die(mysql_error());
$row_user_dependents = mysql_fetch_assoc($user_dependents);
$totalRows_user_dependents = mysql_num_rows($user_dependents);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_salary = "SELECT * FROM user_salaryskill WHERE user_stafid = '". $userproperty ."' AND usersalaryskill_status = '1' ORDER BY usersalaryskill_date_y DESC, usersalaryskill_date_m DESC, usersalaryskill_date_d DESC, usersalaryskill_id DESC";
$salary = mysql_query($query_salary, $hrmsdb) or die(mysql_error());
$row_salary = mysql_fetch_assoc($salary);
$totalRows_salary = mysql_num_rows($salary);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_emo = "SELECT * FROM user_emolumen WHERE user_stafid ='". $userproperty ."' AND useremolumen_status = '1' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC";
$emo = mysql_query($query_emo, $hrmsdb) or die(mysql_error());
$row_emo = mysql_fetch_assoc($emo);
$totalRows_emo = mysql_num_rows($emo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300' rel='stylesheet' type='text/css'>
<link href="css/print.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
<tr>
    <td align="center" valign="middle" nowrap="nowrap"><img src="<?php echo $url_main;?>img/isn.png" width="75" height="70" alt="isn" /></td>
    <td width="100%" align="left" valign="middle" nowrap="nowrap" class="fsize2"><strong>INSTITUT SUKAN NEGARA</strong><br />
    Senarai Pengistiharan Harta</td>
    <td align="left" valign="middle" nowrap="nowrap">Tarikh : <?php echo date('d / m / Y (D)', mktime(0 , 0, 0, date('m'), date('d'), date('Y')));?></td>
</tr>
</table>
  
<?php if ($totalRows_property > 0) { // Show if recordset not empty ?>       

       <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
            <td align="left" valign="middle" nowrap="nowrap">Maklumat Pegawai</td>
        </tr>    
         <tr>
          <td>&nbsp;</td>
        </tr>
	</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
    <tr>
     <td width="30%" valign="middle" nowrap="nowrap">Nama </td>
    <td width = 70% nowrap="nowrap"><strong><?php echo strtoupper(getFullNameByStafID($userproperty)); ?></strong></td>
    </tr>
    <tr>
     <td  valign="middle" nowrap="nowrap">No. Kad Pengenalan  </td>
     <td width = 100% nowrap="nowrap"><strong><?php echo getICNoByStafID($userproperty); ?></strong></td>
    </tr>
    <tr>
     <td valign="middle" nowrap="nowrap">Jawatan /Gred </td>
     <td width = 100% nowrap="nowrap"><strong><?php echo getJobtitleReal($userproperty);?> (<?php echo getGred($userproperty); ?>)</strong></td>
    </tr>
     <tr>
     <td valign="middle" nowrap="nowrap">Alamat Bertugas </td>
    <td width = 100% nowrap="nowrap"><strong><?php echo getLocationByUserID($userproperty); ?></strong></td>
    </tr>
     </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
            <td align="left" valign="middle" nowrap="nowrap">Maklumat Suami/Isteri</td>
        </tr>    
	</table>     
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
     <tr>
          <th width="25%" align="center" valign="middle" nowrap="nowrap">Nama</th>
          <th width="25%" align="center" valign="middle" nowrap="nowrap">No. Kad Pengenalan</th>
          <th width="25%" align="center" valign="middle" nowrap="nowrap">Pekerjaan</th>
          <th width="25%" align="center" valign="middle" nowrap="nowrap">Alamat Majikan</th>
        </tr>
          <tr class="line_b">
            <td align="center" valign="middle">-</td>
            <td align="center" valign="middle">-</td>
            <td align="center" valign="middle">-</td>
            <td align="center" valign="middle">-</td>
          </tr>
    </table>
     <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
       </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Maklumat Anak/Tanggungan</td>
        </tr>
</table>
    
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
     
     <?php if ($totalRows_user_dependents > 0) { // Show if recordset not empty ?>
<tr>
      <th align="center" valign="middle">Nama</th>
      <th align="center" valign="middle">Umur</th>
      <th align="center" valign="middle">No. Kad Pengenalan</th>
    </tr>
    <?php do { ?>
      <tr class="line_b">
        <td align="left" valign="middle" class="in_cappitalize"><?php echo $row_user_dependents['userdependents_name']; ?></td>
        <td align="center" valign="middle"></td>
        <td align="right">
        </td>
      </tr>
      <?php } while ($row_user_dependents = mysql_fetch_assoc($user_dependents)); ?>
  <?php } else { ?>
    <tr>
      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
    </tr>
    <?php }; ?>
  </table>
     <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">Pendapatan Bulanan</td>
      </tr>  
      </table>
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
        <tr>
          <th width="25%" align="left" valign="middle" nowrap="nowrap">&nbsp;</th>
          <th width="25%" align="left" valign="middle" nowrap="nowrap">Pegawai</th>
          <th width="25%" align="center" valign="middle" nowrap="nowrap">Suami/Isteri</th>
        </tr>
          <tr class="line_b">
            <td align="left" valign="middle">Gaji</td>
            <td align="left" valign="middle">RM <?php echo number_format($row_salary['usersalaryskill_basicsalary'],2); ?></td>
            <td align="center" valign="middle">-</td>
          </tr>
          <tr class="line_b">
            <td align="left" valign="middle">Jumlah Imbuhan</td>
            <td align="left" valign="middle">RM <?php echo number_format(getEmolumenByUserID($userproperty, 1, $row_property['userproperty_date_m'], $dy), 2);?></td>
            <td align="center" valign="middle">-</td>
          </tr>
    </table>
       <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">Senarai Harta bagi tahun <?php echo date('Y', mktime(0, 0, 0, 1, 1, $dy));?></td>
      </tr>  
      </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder"> 
    <tr>
      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
      <th width="50%" align="left" valign="middle" nowrap="nowrap">Tarikh</th>
      <th align="left" valign="middle" nowrap="nowrap">Harta</th>
      <th align="center" valign="middle" nowrap="nowrap">Pemilik</th>
      <th align="center" valign="middle">No Sijil/ Pendaftaran</th>
      <th align="center" valign="middle" nowrap="nowrap">Alamat</th>
      <th align="center" valign="middle">Tarikh Pemilikan</th>
      <th align="center" valign="middle" nowrap="nowrap">Kuantiti</th>
      <th align="center" valign="middle">Nilai Perolehan (RM)</th>
      <th align="center" valign="middle">Sumber Perolehan</th>
      <th align="center" valign="middle">Institusi Pinjaman</th>
      <th align="center" valign="middle">Tarikh Pembayaran</th>
      <th align="center" valign="middle">Tempoh Pembayaran (bulan)</th>
      <th align="center" valign="middle">Jumlah Pinjaman (RM)</th>
      <th align="center" valign="middle">Ansuran Bulanan (RM)</th>
      <th align="center" valign="middle" nowrap="nowrap">Keterangan Lain</th>
    </tr>
    <?php $i=1; do { ?>
    <tr class="line_b">
      <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
      <td align="left" valign="middle" nowrap="nowrap"><?php echo getSubmitDate($row_property['userproperty_id'],1);?></td>
      <td align="left" valign="middle" nowrap="nowrap"><?php echo getPropertyTypeByPropertyID($row_property['userproperty_id']); ?><br />&nbsp; &bull; &nbsp; <?php echo getPropertyDetailByID($row_property['userproperty_id']);?></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php echo getOwnerByPropertyID($row_property['userproperty_id']);?></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php if(getRegNoByPropertyID($row_property['userproperty_id'])!='') echo getRegNoByPropertyID($row_property['userproperty_id']); else echo "-"; ?></td>
      <td align="center" valign="middle" nowrap="nowrap"><div class="txt_line in_cappitalize"><?php if((getAddressByPropertyID($row_property['userproperty_id']))!=NULL) {echo getAddressByPropertyID($row_property['userproperty_id']);?><br/><?php echo getCityByPropertyID($row_property['userproperty_id']); ?><br /><?php echo getPoscodeByPropertyID($row_property['userproperty_id']); ?> <?php echo getState(getStateIDByPropertyID($row_property['userproperty_id']));?><?php }else echo "-";?><br /></div></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php echo getOwnedDateByPropertyID($row_property['userproperty_id']); ?></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php echo getQuantityByPropertyID($row_property['userproperty_id']); ?></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php if(getAmountByPropertyID($row_property['userproperty_id'])!='') echo number_format(getAmountByPropertyID($row_property['userproperty_id']),2); else echo "-"; ?></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php echo getSourceNameByID(getSourceIDByPropertyID($row_property['userproperty_id'])); ?></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php if(checkLoanOrNotByPropertyID($row_property['userproperty_id'])=='4') echo getInstituteLoanByPropertyID($row_property['userproperty_id']); else echo "-"; ?></td>
      <td align="center" valign="middle"><?php if(checkLoanOrNotByPropertyID($row_property['userproperty_id'])=='4') echo getPayDateByPropertyID($row_property['userproperty_id']); else echo "-"; ?></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php if(checkLoanOrNotByPropertyID($row_property['userproperty_id'])=='4') echo getDurationLoanByPropertyID($row_property['userproperty_id']); else echo "-"; ?></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php if(checkLoanOrNotByPropertyID($row_property['userproperty_id'])=='4') echo number_format(getTotalLoanByPropertyID($row_property['userproperty_id']),2); else echo "-"; ?></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php if(checkLoanOrNotByPropertyID($row_property['userproperty_id'])=='4') echo number_format(getMonthlyLoanByPropertyID($row_property['userproperty_id']),2); else echo "-"; ?></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php if(getNoteByPropertyID($row_property['userproperty_id'])!='') echo getNoteByPropertyID($row_property['userproperty_id']); else echo "-"; ?></td>
    </tr>
       <?php $i++; } while ($row_property = mysql_fetch_assoc($property)); ?>
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
            <td align="left" valign="top"><img src="qr/qrharta.php?id=<?php echo getID($userproperty);?>" alt="QR Code" /></td>
            <td width="100%" align="left" valign="middle" nowrap="nowrap">
            <div>Jumlah Pinjaman (Peribadi)= <strong>RM <?php echo number_format(getTotalAmountIndLoanByUser($userproperty),2);?></strong></div>
            <div>Jumlah Bayaran Bulanan (Peribadi)= <strong>RM <?php echo number_format(getTotalMonthlyAmountIndLoanByUser($userproperty),2);?></strong></div>
            <div>Jumlah Pinjaman (Suami/Isteri) = <strong>RM <?php echo number_format(getTotalAmountHusWifeLoanByUser($userproperty),2);?></strong></div>
            <div>Jumlah Bayaran Bulanan (Suami/Isteri) = <strong>RM <?php echo number_format(getTotalMonthlyAmountHusWifeLoanByUser($userproperty),2);?></strong></div>
            <br />
            <div>Borang ini adalah cetakan melalui <?php echo $systitle_full;?><br /><?php echo time();?></div></td>
            </tr>
            </table>
            </td>
         <td width="50%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
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
            <td nowrap="nowrap" ><strong><?php echo getFullNameByStafID($userproperty) . "(" . $userproperty . ")"; ?></strong></td>
            <td nowrap="nowrap" ><strong>(KETUA JABATAN)</strong></td>
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
</body>
</html>
<?php
mysql_free_result($property);
?>
<?php include('inc/footinc.php');?> 
              