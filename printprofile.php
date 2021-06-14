<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='2';?>
<?php $menu2='1';?>
<?php

if (isset($_GET['id'])) {
  $colname_user_personal = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_personal = sprintf("SELECT * FROM user_personal WHERE user_stafid = %s ORDER BY userpersonal_id DESC", GetSQLValueString($colname_user_personal, "text"));
$user_personal = mysql_query($query_user_personal, $hrmsdb) or die(mysql_error());
$row_user_personal = mysql_fetch_assoc($user_personal);
$totalRows_user_personal = mysql_num_rows($user_personal);

$colname_user_med = "-1";
if (isset($_GET['id'])) {
	$colname_user_med = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_med = sprintf("SELECT * FROM user_med WHERE user_stafid = %s ORDER BY usermed_id DESC", GetSQLValueString($colname_user_med, "text"));
$user_med = mysql_query($query_user_med, $hrmsdb) or die(mysql_error());
$row_user_med = mysql_fetch_assoc($user_med);
$totalRows_user_med = mysql_num_rows($user_med);

$colname_user_ec = "-1";
if (isset($_GET['id'])) {
  $colname_user_ec = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_ec = sprintf("SELECT * FROM user_ec WHERE user_stafid = %s AND userec_status = '1' ORDER BY userec_name ASC", GetSQLValueString($colname_user_ec, "text"));
$user_ec = mysql_query($query_user_ec, $hrmsdb) or die(mysql_error());
$row_user_ec = mysql_fetch_assoc($user_ec);
$totalRows_user_ec = mysql_num_rows($user_ec);

$colname_user_dependents = "-1";
if (isset($_GET['id'])) {
	$colname_user_dependents = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_dependents = sprintf("SELECT * FROM user_dependents WHERE user_stafid = %s AND userdependents_status = '1' ORDER BY userdependents_relation ASC", GetSQLValueString($colname_user_dependents, "text"));
$user_dependents = mysql_query($query_user_dependents, $hrmsdb) or die(mysql_error());
$row_user_dependents = mysql_fetch_assoc($user_dependents);
$totalRows_user_dependents = mysql_num_rows($user_dependents);

$colname_user_exwork = "-1";
if (isset($_GET['id'])) {
  $colname_user_exwork = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_exwork = sprintf("SELECT * FROM user_exwork WHERE user_stafid = %s AND userexwork_status = '1' ORDER BY userexwork_startdate ASC", GetSQLValueString($colname_user_exwork, "text"));
$user_exwork = mysql_query($query_user_exwork, $hrmsdb) or die(mysql_error());
$row_user_exwork = mysql_fetch_assoc($user_exwork);
$totalRows_user_exwork = mysql_num_rows($user_exwork);

$colname_user_edu = "-1";
if (isset($_GET['id'])) {
  $colname_user_edu = $row_user['user_stafid'];

}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_edu = sprintf("SELECT * FROM user_edu WHERE user_stafid = %s AND useredu_status = '1' ORDER BY useredu_year ASC", GetSQLValueString($colname_user_edu, "text"));
$user_edu = mysql_query($query_user_edu, $hrmsdb) or die(mysql_error());
$row_user_edu = mysql_fetch_assoc($user_edu);
$totalRows_user_edu = mysql_num_rows($user_edu);


$colname_user_passport = "-1";
if (isset($_GET['id'])) {
  $colname_user_passport = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_passport = sprintf("SELECT * FROM user_passport WHERE user_stafid = %s ORDER BY userpassport_id DESC", GetSQLValueString($colname_user_passport, "text"));
$user_passport = mysql_query($query_user_passport, $hrmsdb) or die(mysql_error());
$row_user_passport = mysql_fetch_assoc($user_passport);
$totalRows_user_passport = mysql_num_rows($user_passport);

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

<span>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
        <tr>
                      <td align="center" valign="middle"><?php echo viewProfilePic($colname_user_personal);?></td>
                      <td width="100%" align="left" valign="middle">
                        <div><strong><?php echo getFullNameByStafID($colname_user_personal) . " (" . $colname_user_personal . ")"; ?></strong></div>
                        <div class="txt_color1"><?php echo getJobtitle($colname_user_personal) . " (" . getGred($colname_user_personal) . ")";?></div>
                        <div class="txt_color1"><?php echo getFulldirectoryByUserID($colname_user_personal);?></div>
                      </td>
                    </tr>
                  </table>
                  
               <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>MAKLUMAT PERIBADI</strong></td>
    </tr>
    </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Alamat Terkini</td>
                      <td colspan="3" valign="middle"><div class="txt_line in_cappitalize"><?php if($row_user_personal['userpersonal_address']!=NULL){?><?php echo $row_user_personal['userpersonal_address']; ?><?php }; ?><?php if($row_user_personal['userpersonal_address2']!=NULL){?><br/><?php echo $row_user_personal['userpersonal_address2']; ?><?php };?><?php if($row_user_personal['userpersonal_address3']!=NULL){?><br/><?php echo $row_user_personal['userpersonal_address3']; ?><?php }; ?></div></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Poskod</td>
                      <td width="50%" valign="middle" class="w50"><?php if($row_user_personal['userpersonal_zip']!=NULL) echo $row_user_personal['userpersonal_zip']; else echo "-"; ?></td>
                      <td valign="middle" nowrap="nowrap" class="label">Bandar</td>
                      <td width="50%" valign="middle" class="in_cappitalize w50"><?php echo $row_user_personal['userpersonal_city']; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Negeri</td>
                      <td valign="middle" class="in_cappitalize"><?php echo getState($row_user_personal['userpersonal_state']); ?></td>
                      <td valign="middle" nowrap="nowrap">&nbsp;</td>
                      <td valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">No. Telefon <br />
                      (Rumah)</td>
                      <td valign="middle"><?php if($row_user_personal['userpersonal_telh']!=NULL) echo $row_user_personal['userpersonal_telh']; else echo "-"; ?></td>
                      <td valign="middle" nowrap="nowrap" class="label">No. Telefon <br />
                      (Mobile)</td>
                      <td valign="middle"><?php if($row_user_personal['userpersonal_telm']!=NULL) echo $row_user_personal['userpersonal_telm']; else echo "-"; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">No. Telefon <br />
                      (ISN Ext)</td>
                      <td valign="middle"><?php if($row_user_personal['userpersonal_telw']!=NULL) echo $row_user_personal['userpersonal_telw']; else echo "-"; ?></td>
                      <td valign="middle" nowrap="nowrap" class="label">No. Telefon<br />
(Lain)</td>
                      <td valign="middle"><?php if($row_user_personal['userpersonal_telo']!=NULL) echo $row_user_personal['userpersonal_telo']; else echo "-"; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Email <br />
                      (ISN Mail)</td>
                      <td valign="middle" class="in_lower"><?php echo getEmailISNByUserID($colname_user_personal);?></td>
                      <td valign="middle" nowrap="nowrap" class="label">Email <br />
                      (Lain)</td>
                      <td valign="middle" class="in_lower"><?php if($row_user_personal['userpersonal_emailo']!=NULL) echo $row_user_personal['userpersonal_emailo']; else echo "-"; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">No. Lesen</td>
                      <td valign="middle" class="in_upper"><?php if($row_user_personal['userpersonal_license']!=NULL) echo $row_user_personal['userpersonal_license']; else echo "-"; ?></td>
                      <td valign="middle" nowrap="nowrap" class="label">Jenis Lesen</td>
                      <td valign="middle" class="in_upper"><?php if($row_user_personal['userpersonal_licensetype']!=NULL) echo $row_user_personal['userpersonal_licensetype']; else echo "-"; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Size Baju</td>
                      <td valign="middle" class="in_upper"><?php echo $row_user_personal['userpersonal_size']; ?></td>
                      <td valign="middle" nowrap="nowrap" class="label">Status <br />
                      Perkahwinan</td>
                      <td valign="middle" class="in_capitalize"><?php echo getMarital($row_user_personal['userpersonal_marital']);?></td>
                    </tr>
                  </table>    
         <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>MAKLUMAT PERUBATAN</strong></td>
    </tr>
    </table>
        	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
                    <?php if ($totalRows_user_med > 0) { // Show if recordset not empty ?>
                    <tr>
                      <td class="label">Jenis Darah</td>
                      <td class="in_upper"><?php echo $row_user_med['usermed_blood']; ?></td>
                      <td class="label">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="label">Tinggi (cm) </td>
                      <td><?php if($row_user_med['usermed_height']!=NULL) echo $row_user_med['usermed_height']; else echo "-"; ?></td>
                      <td class="label">Berat (kg) </td>
                      <td><?php if($row_user_med['usermed_weight']!=NULL) echo $row_user_med['usermed_weight']; else echo "-"; ?></td>
                    </tr>
                    <tr>
                      <td class="label">Kecacatan</td>
                      <td colspan="3"><?php if($row_user_med['usermed_disable']!=NULL) echo $row_user_med['usermed_disable']; else echo "Tiada"; ?></td>
                    </tr>                  
                    <tr>
                      <td class="label">Alahan</td>
                      <td colspan="3"><?php if($row_user_med['usermed_allergic']!=NULL) echo $row_user_med['usermed_allergic']; else echo "Tiada"; ?></td>
                    </tr>                  
                    <tr>
                      <td class="label">Penyakit Kritikal</td>
                      <td colspan="3"><?php if($row_user_med['usermed_disease']!=NULL) echo $row_user_med['usermed_disease']; else echo "Tiada"; ?></td>
                    </tr>                  
                    <tr>
                      <td class="label">Maklumat Rawatan</td>
                      <td colspan="3"><?php if($row_user_med['usermed_doctor']!=NULL) echo $row_user_med['usermed_doctor']; else echo "Tiada"; ?></td>
                    </tr>                  
                    <tr>
                      <td class="label">Tarikh Rawatan</td>
                      <td colspan="3"><?php if($row_user_med['usermed_datetreatment']!=NULL) echo $row_user_med['usermed_datetreatment']; else echo "-"; ?></td>
                    </tr>
                      <?php } else { ?>                  
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila kemaskini Maklumat Perubatan</td>
                    </tr>  
                      <?php }; ?>
                  </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>WARIS RUJUKAN KECEMASAN</strong></td>
    </tr>
    </table>
        	 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
    <?php if ($totalRows_user_ec > 0) { // Show if recordset not empty ?>
<tr>
      <td width="50%" align="left" valign="middle">Nama / Hubungan</td>
        <td align="center" valign="middle">No. Kad Pengenalan</td>
        <td align="center" valign="middle">No. Tel (Rumah)</td>
          <td align="center" valign="middle">No. Tel (Mobile)</td>
            <td align="center" valign="middle">No. Tel (Pejabat)</td>                   
              </tr>
    <?php do { ?>
      <tr class="on">
        <td align="left" class="txt_line">
        <div><span class="in_cappitalize"><strong><?php echo $row_user_ec['userec_name']; ?></strong></span></div>
        <div><span class="in_cappitalize"><?php echo getRelation($row_user_ec['userec_relation']); ?></span></div>
        <?php if($row_user_ec['userrec_address']!=NULL){?>
        <div><?php echo shortText($row_user_ec['userrec_address']); ?></div>
        <?php }; ?>
        </td>
         <td align="center" valign="middle"><?php if($row_user_ec['userec_noic']!=NULL)echo $row_user_ec['userec_noic']; else echo "-"; ?></td>
        <td align="center" valign="middle"><?php if($row_user_ec['userec_telh']!=NULL)echo $row_user_ec['userec_telh']; else echo "-"; ?></td>
        <td align="center" valign="middle"><?php if($row_user_ec['userec_telm']!=NULL)echo $row_user_ec['userec_telm']; else echo "-"; ?></td>
        <td align="center" valign="middle"><?php if($row_user_ec['userec_telw']!=NULL)echo $row_user_ec['userec_telw']; else echo "-"; ?></td>
      </tr>
      <?php } while ($row_user_ec = mysql_fetch_assoc($user_ec)); ?>
    <tr>
      <td colspan="5" align="center" class="noline txt_color1">&nbsp;<?php echo $totalRows_user_ec ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="5" align="center" class="noline">Tiada rekod dijumpai, Sila isi Rujukan Kecemasan</td>
    </tr>
    <?php }; ?>
  </table>
       <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>MAKLUMAT TANGGUNGAN</strong></td>
    </tr>
    </table>
               <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
     <?php if ($totalRows_user_dependents > 0) { // Show if recordset not empty ?>
<tr>
      <td width="50%" align="left" valign="middle">Nama</td>
      <td align="center" valign="middle">Hubungan</td>
      <td align="center" valign="middle">No Kad Pengenalan</td>
    </tr>
    <?php do { ?>
      <tr class="on">
        <td align="left" valign="middle" class="in_cappitalize"><?php echo $row_user_dependents['userdependents_name']; ?></td>
        <td align="center" valign="middle" class="in_cappitalize"><?php echo getRelation($row_user_dependents['userdependents_relation']); ?></td>
        <td align="center" valign="middle"><?php echo $row_user_dependents['userdependents_ic']; ?></td>
        
      </tr>
      <?php } while ($row_user_dependents = mysql_fetch_assoc($user_dependents)); ?>
    <tr>
      <td colspan="3" align="center" valign="middle" class="noline txt_color1">&nbsp;<?php echo $totalRows_user_dependents ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila isi Maklumat Tanggungan</td>
    </tr>
    <?php }; ?>
  </table>
               <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>REKOD KERJAYA</strong></td>
    </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
                  <?php if ($totalRows_user_exwork > 0) { // Show if recordset not empty ?>
<tr>
      <td width="50%" align="left" valign="middle">Jawatan / Majikan / Lokasi</td>
      <td>Tarikh Mula</td>
      <td>Tarikh Tamat</td>
    </tr>
    <?php do { ?>
      <tr class="on">
        <td align="left" valign="middle"><div class="txt_line"><strong class="in_cappitalize"><?php echo $row_user_exwork['userexwork_title']; ?></strong><br />
            <span class="in_cappitalize"><?php echo $row_user_exwork['userexwork_employer']; ?></span>
          <?php if($row_user_exwork['userexwork_location']!=NULL){?>
          <br />
          <span class="in_cappitalize"><?php echo $row_user_exwork['userexwork_location']; ?></span>
          <?php }; ?></div></td>
        <td align="center" valign="middle"><?php if($row_user_exwork['userexwork_startdate']!=NULL) echo $row_user_exwork['userexwork_startdate']; else echo "-"; ?></td>
        <td align="center" valign="middle"><?php if($row_user_exwork['userexwork_enddate']!=NULL) echo $row_user_exwork['userexwork_enddate']; else echo "-"; ?></td>
      </tr>
      <?php } while ($row_user_exwork = mysql_fetch_assoc($user_exwork)); ?>
    <tr>
      <td colspan="3" align="center" valign="middle" class="noline txt_color1">&nbsp;<?php echo $totalRows_user_exwork ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila isi Rekod Kerjaya</td>
    </tr>
    <?php };?>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>REKOD PENDIDIKAN</strong></td>
    </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
                  <?php if ($totalRows_user_edu > 0) { // Show if recordset not empty ?>
<tr>
      <td width="100%" align="left" valign="middle">Tahap / Bidang / Institusi / Lokasi</td>
    <td align="left" valign="middle">Penaja</td>
  <td align="center" valign="middle">Tahun<br/>Penganugerahan</td>
      <td align="center" valign="middle" nowrap="nowrap">CGPA / Skor</td>
    </tr>
    <?php do { ?>
      <tr class="on">
        <td align="left" valign="middle"><div class="txt_line"><strong><?php echo getEdulevel($row_user_edu['useredu_level']); ?></strong><br />
            <?php if($row_user_edu['useredu_major']!=NULL){ ?><span class="in_cappitalize"><?php echo $row_user_edu['useredu_major']; ?></span><br /><?php }; ?>
            <?php if($row_user_edu['useredu_institution']!=NULL){ ?><span class="in_cappitalize"><?php echo $row_user_edu['useredu_institution']; ?></span><?php }; ?>
            <?php if($row_user_edu['useredu_location']!=NULL) echo ", " . $row_user_edu['useredu_location']; ?></div></td>
        <td align="left" valign="middle" nowrap="nowrap"><?php echo getEduSponsor($row_user_edu['useredu_id']);?></td>
        <td align="center" valign="middle"><?php echo $row_user_edu['useredu_year']; ?></td>
        <td align="center" valign="middle">
		<?php if(checkEduResultSubmit($colname_user_edu, $row_user_edu['useredu_id'])) {?>
        	<a href="#edu2" onclick="MM_openBrWindow('<?php echo $url_main;?>result.php?ided=<?php echo $row_user_edu['useredu_id'];?>','result','status=yes,scrollbars=yes,width=800,height=600')">Semak</a>
		<?php } else if(checkEduResult($row_user_edu['useredu_level']) && $colname_user_edu == $row_user['user_stafid'] && $menu == '2') {?>
        	<a href="#edu2" onclick="MM_openBrWindow('<?php echo $url_main;?>result.php?ided=<?php echo $row_user_edu['useredu_id'];?>','result','status=yes,scrollbars=yes,width=800,height=600')">Hantar</a>
		<?php } else if($row_user_edu['useredu_cgpa']!=NULL) echo $row_user_edu['useredu_cgpa']; else echo "-"; ?>
        </td> 
      </tr>
      <?php } while ($row_user_edu = mysql_fetch_assoc($user_edu)); ?>
    <tr>
      <td colspan="4" align="center" valign="middle" class="noline txt_color1">&nbsp;<?php echo $totalRows_user_edu ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila isi Rekod Pendidikan</td>
    </tr>
    <?php }; ?>
  </table>
   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>MAKLUMAT PASSPORT</strong></td>
    </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
                  <?php if ($totalRows_user_passport > 0) { // Show if recordset not empty ?>
    <tr>
      <td class="label">Jenis</td>
      <td><?php echo getPassport($row_user_passport['userpassport_type']);?></td>
      <td class="label">Kewarganegaraan</td>
      <td class="in_cappitalize"><?php echo getCitizen($row_user_passport['userpassport_citizen']); ?></td>
      </tr>
    <tr>
      <td class="label">No. Passport</td>
      <td class="in_upper"><?php echo $row_user_passport['userpassport_no']; ?></td>
      <td class="label">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td class="label">Tarikh Mula</td>
      <td><?php echo $row_user_passport['userpassport_start']; ?></td>
      <td class="label">Tarikh Tamat</td>
      <td><?php echo $row_user_passport['userpassport_expire']; ?></td>
    </tr>
    <tr>
      <td class="label">Tarikh Tamat<br/>Permit Kerja</td>
      <td><?php echo $row_user_passport['userpassport_permit']; ?></td>
      <td class="label">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  <?php } else { ?>
   <tr>
      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila kemaskini Maklumat Passport</td>
      </tr>
  <?php }; ?>
  </table>
</body>
</html>
<?php
?>
<?php include('inc/footinc.php');?> 