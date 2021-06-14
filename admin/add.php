<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='6';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jobs = "SELECT * FROM jobs ORDER BY jobscode_id ASC";
$jobs = mysql_query($query_jobs, $hrmsdb) or die(mysql_error());
$row_jobs = mysql_fetch_assoc($jobs);
$totalRows_jobs = mysql_num_rows($jobs);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT * FROM dir WHERE dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);
$totalRows_dir = mysql_num_rows($dir);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_country = "SELECT * FROM countrylist ORDER BY Name ASC";
$country = mysql_query($query_country, $hrmsdb) or die(mysql_error());
$row_country = mysql_fetch_assoc($country);
$totalRows_country = mysql_num_rows($country);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_race = "SELECT * FROM race ORDER BY race_short ASC";
$race = mysql_query($query_race, $hrmsdb) or die(mysql_error());
$row_race = mysql_fetch_assoc($race);
$totalRows_race = mysql_num_rows($race);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_location = "SELECT * FROM location ORDER BY location_name ASC";
$location = mysql_query($query_location, $hrmsdb) or die(mysql_error());
$row_location = mysql_fetch_assoc($location);
$totalRows_location = mysql_num_rows($location);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_marital = "SELECT * FROM marital ORDER BY marital_id ASC";
$marital = mysql_query($query_marital, $hrmsdb) or die(mysql_error());
$row_marital = mysql_fetch_assoc($marital);
$totalRows_marital = mysql_num_rows($marital);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jobss = "SELECT * FROM jobs_sub ORDER BY jobss_name ASC";
$jobss = mysql_query($query_jobss, $hrmsdb) or die(mysql_error());
$row_jobss = mysql_fetch_assoc($jobss);
$totalRows_jobss = mysql_num_rows($jobss);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jobstype = "SELECT * FROM job_type ORDER BY jobtype_name ASC";
$jobstype = mysql_query($query_jobstype, $hrmsdb) or die(mysql_error());
$row_jobstype = mysql_fetch_assoc($jobstype);
$totalRows_jobstype = mysql_num_rows($jobstype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_bank = "SELECT * FROM bank ORDER BY bank_name ASC";
$bank = mysql_query($query_bank, $hrmsdb) or die(mysql_error());
$row_bank = mysql_fetch_assoc($bank);
$totalRows_bank = mysql_num_rows($bank);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_rel = "SELECT * FROM religion ORDER BY religion_id ASC";
$rel = mysql_query($query_rel, $hrmsdb) or die(mysql_error());
$row_rel = mysql_fetch_assoc($rel);
$totalRows_rel = mysql_num_rows($rel);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_klas = "SELECT * FROM classification ORDER BY classification_code ASC";
$klas = mysql_query($query_klas, $hrmsdb) or die(mysql_error());
$row_klas = mysql_fetch_assoc($klas);
$totalRows_klas = mysql_num_rows($klas);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_ske = "SELECT * FROM scheme ORDER BY group_id ASC";
$ske = mysql_query($query_ske, $hrmsdb) or die(mysql_error());
$row_ske = mysql_fetch_assoc($ske);
$totalRows_ske = mysql_num_rows($ske);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_tit = "SELECT * FROM title ORDER BY title_id ASC";
$tit = mysql_query($query_tit, $hrmsdb) or die(mysql_error());
$row_tit = mysql_fetch_assoc($tit);
$totalRows_tit = mysql_num_rows($tit);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<?php include('../inc/liload.php');?>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
<?php include('../inc/header.php');?>
  	  <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_admin.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
            <div class="note">Setiap akaun baru perlu memiliki email rasmi MSN sebelum dapat mengakses maklumat dalam sistem ini. Sila berhubung dengan Cawangan ICT untuk maklumat berkaitan email.</div>
            <form id="addstaff" name="addstaff" method="POST" action="<?php echo $url_main;?>sb/profile_admin.php?url=add">
            <ul>
           	  <li class="title">Maklumat Peribadi</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap="nowrap" class="label">Nama * <br/><span class="txt_it">First Name</span></td>
    <td colspan="3" width="100%"><span id="firstname"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>
        <select name="title_id" id="title_id">
        <option value="0">Tuan / Puan</option>
          <?php
do {  
?>
          <option value="<?php echo $row_tit['title_id']?>"><?php echo $row_tit['title_name']?></option>
          <?php
} while ($row_tit = mysql_fetch_assoc($tit));
  $rows = mysql_num_rows($tit);
  if($rows > 0) {
      mysql_data_seek($tit, 0);
	  $row_tit = mysql_fetch_assoc($tit);
  }
?>
        </select>
        <input type="text" name="user_firstname" id="user_firstname" class="in_cappitalize w50" /></span><div class="inputlabel2">Tanpa 'Bin / Binti'. Cth: Ali</div>
        </td>
    </tr>
  <tr>
    <td nowrap="nowrap" class="label">Nama Bapa / Penjaga* <br/><span class="txt_it">Last Name</span></td>
    <td colspan="3">
      <span id="lastname"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>
      <input name="user_lastname" type="text" class="in_cappitalize w50" id="textfield5" /></span><div class="inputlabel2">Tanpa 'Bin / Binti'. Cth: Ahmad <br/> Sekiranya tiada 'Bin / Binti' hanya meletakkan '.' sahaja</div></td>
  </tr>
  <tr>
    <td class="label">Staf ID *</td>
    <td colspan="3"><div>Sila semak Staf ID sekali lagi bagi mengelakkan sebarang kesilapan</div>
      <span id="userstafid">
      
        <span class="textfieldRequiredMsg">
        Maklumat diperlukan.
        </span>
        <span id="id_exist">
          
        </span>
          <input name="user_stafid" type="text" class="w10 in_upper" id="user_stafid" onchange="dochange('26', 'id_exist', this.value, '0');"></input>
          <!-- <input name="user_stafid" type="text" class="w10 in_upper" id="user_stafid"></input> -->
        
      </span>
      <div class="inputlabel2">Cth: P2020</div></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="label">No. Kad Pengenalan</td>
    <td colspan="3"><input name="user_noic" type="text" class="w50" id="user_noic" onchange="dochange('27', 'ic_exist', this.value, '0');"></input>
          <span id="ic_exist">
          
          </span>
      <div class="inputlabel2">Tanpa simbol '-'. Cth: 881203065595</div></td>
    </tr>
  <tr>
    <td class="label">Tarikh Lahir *</td>
    <td colspan="3">
      <select name="user_dob_d" id="user_dob_d">
        <?php for($i=1; $i<=31; $i++){?>
        <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
        <?php }; ?>
      </select>
      <span class="inputlabel">/ </span>
      <select name="user_dob_m" id="user_dob_m">
      <?php for($j=1; $j<=12; $j++){?>
        <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>
        <?php }; ?>
      </select>
      <span class="inputlabel">/ </span><span id="dob_year">
      <span class="textfieldRequiredMsg">Maklumat diperlukan</span><span class="textfieldInvalidFormatMsg">Sila pastikan Format Tahun dimasukkan dengan betul.</span>
      <input name="user_dob_y" type="text" class="w25" id="user_dob_y" value="<?php echo date('Y');?>" size="4" /></span></td>
    </tr>
  <tr>
    <td nowrap="nowrap" class="label">Jantina</td>
    <td nowrap="nowrap">
      <select name="user_gender" id="user_gender">
        <option value="1">Lelaki</option>
        <option value="2">Perempuan</option>
      </select></td>
    <td nowrap="nowrap" class="label">Kaum</td>
    <td width="100%" nowrap="nowrap"><select name="user_race" id="user_race">
      <?php
do {  
?>
      <option value="<?php echo $row_race['race_id']?>"><?php echo $row_race['race_name']?></option>
      <?php
} while ($row_race = mysql_fetch_assoc($race));
  $rows = mysql_num_rows($race);
  if($rows > 0) {
      mysql_data_seek($race, 0);
	  $row_race = mysql_fetch_assoc($race);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="label">Kewarganegaraan</td>
    <td nowrap="nowrap"><label for="user_nationality"></label>
      <select name="user_nationality" id="user_nationality">
        <?php
do {  
?>
        <option value="<?php echo $row_country['CountryID']?>"<?php if (!(strcmp($row_country['CountryID'], 130))) {echo "selected=\"selected\"";} ?>><?php echo $row_country['Name']?></option>
        <?php
} while ($row_country = mysql_fetch_assoc($country));
  $rows = mysql_num_rows($country);
  if($rows > 0) {
      mysql_data_seek($country, 0);
	  $row_country = mysql_fetch_assoc($country);
  }
?>
      </select></td>
    <td nowrap="nowrap" class="label">Agama</td>
    <td nowrap="nowrap"><label for="religion_id"></label>
      <select name="religion_id" id="religion_id">
        <?php
do {  
?>
        <option value="<?php echo $row_rel['religion_id']?>"><?php echo $row_rel['religion_name']?></option>
        <?php
} while ($row_rel = mysql_fetch_assoc($rel));
  $rows = mysql_num_rows($rel);
  if($rows > 0) {
      mysql_data_seek($rel, 0);
	  $row_rel = mysql_fetch_assoc($rel);
  }
?>
      </select></td>
  </tr>
                </table>

        </li>
                <li class="title">Penjawatan</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap="nowrap" class="label">Jawatan<span class="noline">
      <input name="MM_insert_job1" type="hidden" id="MM_insert_job1" value="formjob1" />
    </span></td>
    <td nowrap="nowrap">
    <span id="jwtkla">
      <span class="selectRequiredMsg">Sila pilih Klasifikasi <br/></span>
      <select name="klas" id="klas" onchange="dochange('1', 'scheme_id', this.value, '0');">
        <option value="0" disabled="disabled">Pilih Klasifikasi</option>
        <?php
            do {  
            ?>
        <option value="<?php echo $row_klas['classification_id']?>"><?php echo $row_klas['classification_code'] . " - " . $row_klas['classification_name'];?></option>
        <?php
            } while ($row_klas = mysql_fetch_assoc($klas));
              $rows = mysql_num_rows($klas);
              if($rows > 0) {
                  mysql_data_seek($klas, 0);
                  $row_klas = mysql_fetch_assoc($klas);
              }
            ?>
      </select>
      </span>
      </td>
    <td nowrap="nowrap">
      <span id="jwtskim">
      <span class="selectRequiredMsg">Sila pilih Skim <br/></span>
      <select name="scheme_id" id="scheme_id" onchange="dochange('2', 'userscheme_gred', this.value, '0');">
        <option value="0" disabled="disabled">&laquo; Pilih Klasifikasi</option>
      </select></span>
      </td>
    <td nowrap="nowrap">
      <span id="jwtgred">
      <span class="selectRequiredMsg">Sila pilih Gred <br/></span>
      <select name="userscheme_gred" id="userscheme_gred">
        <option value="0" disabled="disabled">&laquo; Pilih Skim</option>
      </select></span>
      </td>
    <td nowrap="nowrap"><ul class="inputradio"><li><input name="userscheme_no" type="checkbox" id="userscheme_no" value="1" /> Tidak Berskim</li></ul></td>
     <td nowrap="nowrap"><ul class="inputradio"><li><input name="userscheme_no" type="checkbox" id="userscheme_no" value="2" /> Terbuka</li></ul></td>
    </tr>
  <tr>
    <td nowrap="nowrap" class="label">Cawangan / <br />
      Program / Unit<span class="noline">
      <input name="MM_insert_pen" type="hidden" id="MM_insert_pen" value="formpen" />
    </span></td>
    <td colspan="4"><select name="dir_id" id="dir_id">
      <?php
do {  
?>
      <option value="<?php echo $row_dir['dir_id']?>"><?php echo getFulldirectory($row_dir['dir_id'], 0);?></option>
      <?php
} while ($row_dir = mysql_fetch_assoc($dir));
  $rows = mysql_num_rows($dir);
  if($rows > 0) {
      mysql_data_seek($dir, 0);
	  $row_dir = mysql_fetch_assoc($dir);
  }
?>
      </select></td>
  </tr>
    <tr>
    <td nowrap="nowrap" class="label">Penempatan</td>
    <td colspan="4"><select name="location_id" id="location_id">
      <?php
do {  
?>
      <option value="<?php echo $row_location['location_id']?>"><?php echo getLocation($row_location['location_id']);?></option>
      <?php
} while ($row_location = mysql_fetch_assoc($location));
  $rows = mysql_num_rows($location);
  if($rows > 0) {
      mysql_data_seek($location, 0);
	  $row_location = mysql_fetch_assoc($location);
  }
?>
    </select></td>
    </tr>
  <tr>
    <td nowrap="nowrap" class="label">Status<span class="noline">
      <input name="MM_insert_dgn" type="hidden" id="MM_insert_dgn" value="formdgn" />
    </span></td>
    <td colspan="4">
    <ul class="inputradio">
    	<?php do { ?>
    	  <li>
    	    <input name="jobtype_id" type="radio" class="inputradio" id="RadioGroup1_<?php echo $row_jobstype['jobtype_id']; ?>" value="<?php echo $row_jobstype['jobtype_id']; ?>" <?php if($row_jobstype['jobtype_name']=='Kontrak') echo "checked=\"checked\""; ?> /> <?php echo $row_jobstype['jobtype_name']; ?>
  	    </li>
    	  <?php } while ($row_jobstype = mysql_fetch_assoc($jobstype)); ?>
      </ul></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="label">Tempoh</td>
    <td colspan="4"><span id="tempohkontrak"> <span class="textfieldInvalidFormatMsg">Maklumat tidak mengikut format.</span><span class="textfieldMinValueMsg">Nilai minimum adalah 0.</span>
        <span class="textfieldRequiredMsg">Maklumat diperlukan</span>
        <input name="userdesignation_period" type="text" class="w10 txt_right" id="userdesignation_period" value="12" />
        <span class="inputlabel"> bulan</span>
        <div class="inputlabel2">Jika kontrak, isi tempoh bulan. Jika tetap, isi 0.</div></span></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="label">Tarikh Mula <br />
      Dilantikan Ke MSN*</td>
    <td nowrap="nowrap">
      <select name="userjob_start_d" id="userjob_start_d">
        <?php for($i=1; $i<=31; $i++){?>
        <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
        <?php }; ?>
        </select>
      <span class="inputlabel">/ </span>
      <select name="userjob_start_m" id="userjob_start_m">
        <?php for($j=1; $j<=12; $j++){?>
        <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>
        <?php }; ?>
        </select>
      <span class="inputlabel">/ </span><span id="date_in">
        <span class="textfieldRequiredMsg">Maklumat diperlukan</span><span class="textfieldInvalidFormatMsg">Sila pastikan Format Tahun dimasukkan dengan betul</span>
        <input name="userjob_start_y" type="text" class="w10" id="userjob_start_y" value="<?php echo date('Y');?>" size="4" placeholder="Tahun"/></span></td>
  </tr>

  <tr>
    <td nowrap="nowrap" class="label">Tarikh Mula <br />
      Kontrak/Pinjaman</td>
    <td colspan="1" nowrap="nowrap">
      <select name="userjob_kontrak_start_d" id="userjob_start_d">
      	<option value="-" selected="selected">--Sila Pilih--</option>
        <?php for($i=1; $i<=31; $i++){?>
        <option  value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
        <?php }; ?>
        </select>
      <span class="inputlabel">/ </span>
      <select name="userjob_kontrak_start_m" id="userjob_start_m">
      	<option value="-" selected="selected">--Sila Pilih--</option>
        <?php for($j=1; $j<=12; $j++){?>
        <option  value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>
        <?php }; ?>
        </select>
      <span class="inputlabel">/ </span><span id="date_in">
        <span class="textfieldRequiredMsg">Maklumat diperlukan</span><span class="textfieldInvalidFormatMsg">Sila pastikan Format Tahun dimasukkan dengan betul</span>
        <input name="userjob_kontrak_start_y" type="text" class="w10" id="userjob_kontrak_start_y" size="4" placeholder="Tahun"/></span>
    </td>


    <td nowrap="nowrap" class="label">Tarikh Tamat <br />
      Kontrak/Pinjaman</td>
    <td colspan="3"nowrap="nowrap">
      <select name="userjob_kontrak_end_d" id="userjob_start_d">
      	<option value="-" selected="selected">--Sila Pilih--</option>
        <?php for($i=1; $i<=31; $i++){?>
        <option  value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
        <?php }; ?>
        </select>
      <span class="inputlabel">/ </span>
      <select name="userjob_kontrak_end_m" id="userjob_start_m">
      	<option value="-" selected="selected">--Sila Pilih--</option>
        <?php for($j=1; $j<=12; $j++){?>
        <option  value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>
        <?php }; ?>
        </select>
      <span class="inputlabel">/ </span><span id="date_in">
        <span class="textfieldRequiredMsg">Maklumat diperlukan</span><span class="textfieldInvalidFormatMsg">Sila pastikan Format Tahun dimasukkan dengan betul</span>
        <input name="userjob_kontrak_end_y" type="text" class="w10" id="userjob_kontrak_end_y" size="4" placeholder="Tahun"/></span>
    </td>
  </tr>

  <tr>
    <td nowrap="nowrap" class="label">Tarikh Lantikan <br />Tetap </td>
    <td colspan="1" nowrap="nowrap">
    <select name="userjob_in_d" id="userjob_start_d">
    	<option value="-" selected="selected">--Sila Pilih--</option>
        <?php for($i=1; $i<=31; $i++){?>

        
        <option  value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
        <?php }; ?>
      </select>
      <span class="inputlabel">/ </span>
      <select name="userjob_in_m" id="userjob_start_m">
      	<option value="-" selected="selected">--Sila Pilih--</option>
      <?php for($j=1; $j<=12; $j++){?>
        <!-- <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option> -->

        <option  value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>
        <?php }; ?>
      </select>
      <span class="inputlabel">/ </span><span id="in_year"><span class="textfieldInvalidFormatMsg">Sila pastikan Format Tahun dimasukkan dengan betul</span>
      <input name="userjob_in_y" type="text" class="w10" id="userjob_in_y" size="4" placeholder="Tahun"/>
</span></td>
  </tr>

  <tr>
    <td nowrap="nowrap" class="label">Tarikh Sah Jawatan</td>
    <td colspan="1">
    <select name="userjob_promoted_d" id="userjob_start_d">
    	<option value="-" selected="selected">--Sila Pilih--</option>
        <?php for($i=1; $i<=31; $i++){?>
        

        <option  value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
        <?php }; ?>
      </select>
      <span class="inputlabel">/ </span>
      <select name="userjob_promoted_m" id="userjob_start_m">
      	<option value="-" selected="selected">--Sila Pilih--</option>
      <?php for($j=1; $j<=12; $j++){?>
        <!--<option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option> -->

        <option  value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>
        <?php }; ?>
      </select>
      <span class="inputlabel">/ </span><span id="sah_year">
      <span class="textfieldInvalidFormatMsg">Sila pastikan Format Tahun dimasukkan dengan betul</span>
      <!--<input name="userjob_promoted_y" type="text" class="w25" id="userjob_promoted_y" value="<?php echo date('Y');?>" size="4" /></span></td> -->

      <input name="userjob_promoted_y" type="text" class="w10" id="userjob_promoted_y"  size="4" placeholder="Tahun" /></span></td>
  </tr>

  <tr>
    <td class="noline">
    <input name="user_by" type="hidden" id="user_by" value="<?php echo $row_user['user_stafid'];?>" />
    <input type="hidden" name="MM_insert" value="addstaff" />
    </td>
    <td colspan="4" class="noline">
    <input name="button" type="submit" class="submitbutton" id="button" value="Daftar" />
    <input name="button2" type="button" class="cancelbutton" id="button2" value="Batal" onclick="MM_goToURL('parent','stafflist.php');return document.MM_returnValue"/></td>
    </tr>
  </table>
  </li>
  <?php /* ?>
  <li class="title">Gaji dan Emolumen</li>
  <li>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="label">Tangga Gaji Permulaan<span class="label noline">
          <input name="MM_insert_tg" type="hidden" id="MM_insert_tg" value="formtg" />
        </span></td>
        <td><label for="usersalaryskill_code2"></label>
          <label for="usersalaryskill_code"></label>
          <select name="usersalaryskill_code" id="usersalaryskill_code">
            <?php for($j=1; $j<=setSalarySkimP(); $j++){?>
              <option value="P<?php echo $j;?>">P<?php echo $j;?></option>
            <?php }; ?>
          </select>
	<select name="usersalaryskill_code2" id="usersalaryskill_code2">
	<?php for($i=1; $i<=setSalarySkimT(); $i++){?>
  		<option value="T<?php echo $i;?>">T<?php echo $i;?></option>
  	<?php }; ?>
	</select></td>
        <td class="label">Gaji Pokok *</td>
        <td><span id="gajipokok"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="inputlabel">RM</span>
          <input name="usersalaryskill_basicsalary" type="text" class="w50" id="usersalaryskill_basicsalary" />
          </span></td>
      </tr>
      <tr>
        <td class="label">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="label">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="label">ITKA</td>
        <td><span id="itka"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
        <input name="useremolumen_itka" type="text" class="w50" id="useremolumen_itka" />
</span></td>
        <td class="label">IT KRAI</td>
        <td><span id="itkrai"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
          <input name="useremolumen_itkrai" type="text" class="w50" id="useremolumen_itkrai" />
          </span></td>
      </tr>
      <tr>
        <td class="label">ITP</td>
        <td><span id="itp"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
          <input name="useremolumen_itp" type="text" class="w50" id="useremolumen_itp" />
          </span></td>
        <td class="label">BSH</td>
        <td><span id="bsh"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
        <input name="useremolumen_bsh" type="text" class="w50" id="textfield6" />
</span></td>
      </tr>
      <tr>
        <td class="label">EL KTKL</td>
        <td><span id="elktkl"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
          <input name="useremolumen_elktkl" type="text" class="w50" id="textfield7" />
          </span></td>
        <td class="label">EL PKSHT</td>
        <td><span id="elpksht"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
        <input name="useremolumen_elpksht" type="text" class="w50" id="textfield8" />
</span></td>
      </tr>
      <tr>
        <td class="label">EL PAKAR</td>
        <td><span id="elpakar"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
        <input name="useremolumen_elpakar" type="text" class="w50" id="textfield9" />
</span></td>
        <td class="label">Elauan Memangku</td>
        <td><span id="elmemangku"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
        <input name="useremolumen_elmemangku" type="text" class="w50" id="textfield10" />
</span></td>
      </tr>
      <tr>
        <td class="label">JUSA</td>
        <td><span id="jusa"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
        <input name="useremolumen_jusa" type="text" class="w50" id="textfield11" />
</span></td>
        <td class="label">EL PEM. KHAS</td>
        <td><span id="elpemkhas"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
        <input name="useremolumen_elpemkhas" type="text" class="w50" id="textfield12" />
</span></td>
      </tr>
      <tr>
        <td class="label">EL PEM. RMH</td>
        <td><span id="elpemrmh"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
        <input name="useremolumen_elpemrmh" type="text" class="w50" id="textfield13" />
</span></td>
        <td class="label">EL BHS</td>
        <td><span id="bhs"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
        <input name="useremolumen_elbhs" type="text" class="w50" id="textfield14" />
</span></td>
      </tr>
      <tr>
        <td class="label">Lain-lain<span class="label noline">
          <input name="MM_insert_eml" type="hidden" id="MM_insert_eml" value="formeml" />
        </span></td>
        <td colspan="3"><span id="el_o"><span class="textfieldInvalidFormatMsg">Format salah.</span><span class="inputlabel">RM</span>
        <input name="useremolumen_o" type="text" class="w50" id="useremolumen_o" />
</span></td>
      </tr>
    </table>
  </li>
  ?>
  <li class="title">Maklumat Tambahan</li>
  <li>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  <tr>
    <td class="label">Cuti Tahunan *<span class="noline">
      <input name="leavetype_id" type="hidden" id="leavetype_id" value="1" />
      <input name="MM_insert_cuti" type="hidden" id="MM_insert_cuti" value="formcuti" />
    </span></td>
    <td><span id="leave">
    <span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="textfieldInvalidFormatMsg">Sila pastikan Format Hari dimasukkan dengan betul</span>
    <input name="userleave_annual" type="text" class="w25 txt_right" id="userleave_annual" value="25" size="3" /><span class="inputlabel"> hari</span></span></td>
    <td class="label">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 ?>
  <tr>
    <td class="label">No. KWSP</td>
    <td><input name="userjob_kwsp" type="text" class="in_upper" id="userjob_kwsp" /></td>
    <td class="label">No. PERKESO</td>
    <td><input name="userjob_perkeso" type="text" class="in_upper" id="userjob_perkeso" /></td>
  </tr>
  <tr>
    <td class="label">No. LHDN</td>
    <td><input name="userjob_lhdn" type="text" class="in_upper" id="userjob_lhdn" /></td>
    <td class="label">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="label">Bank</td>
    <td><label for="bank_id"></label>
      <select name="bank_id" id="bank_id">
        <?php
do {  
?>
        <option value="<?php echo $row_bank['bank_id']?>"><?php echo $row_bank['bank_name']?></option>
        <?php
} while ($row_bank = mysql_fetch_assoc($bank));
  $rows = mysql_num_rows($bank);
  if($rows > 0) {
      mysql_data_seek($bank, 0);
	  $row_bank = mysql_fetch_assoc($bank);
  }
?>
      </select></td>
    <td class="label">No. Akaun Bank</td>
    <td><input name="userjob_nobank" type="text" class="in_upper" id="userjob_nobank" /></td>
  </tr>
  <tr>
    <td class="noline"><input name="user_by" type="hidden" id="user_by" value="<?php echo $row_user['user_stafid'];?>" />
      <input type="hidden" name="MM_insert" value="addstaff" /></td>
    <td colspan="3" class="noline"><input name="button" type="submit" class="submitbutton" id="button" value="Daftar" />
      <input name="button2" type="button" class="cancelbutton" id="button2" value="Batal" onclick="MM_goToURL('parent','stafflist.php');return document.MM_returnValue"/></td>
    </tr>
                </table>
  */ ?>
              </li>
            </ul>
            </form>
                <?php } else { // semakkan user akses?>
            	<ul>
                    <li>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" class="noline"><?php echo noteError(1);?></td>
                          </tr>
                        </table>
                    </li>
                </ul>
                <?php }; ?>
          </div>
        </div>
        <?php echo noteEmail('1');?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield3 = new Spry.Widget.ValidationTextField("firstname");
var sprytextfield4 = new Spry.Widget.ValidationTextField("lastname");
<?php //var sprytextfield7 = new Spry.Widget.ValidationTextField("leave", "integer"); ?>
var sprytextfield9 = new Spry.Widget.ValidationTextField("dob_year", "integer");
var sprytextfield10 = new Spry.Widget.ValidationTextField("date_in", "integer");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sah_year", "integer", {isRequired:false});
var sprytextfield12 = new Spry.Widget.ValidationTextField("in_year", "integer", {isRequired:false});
var sprytextfield1 = new Spry.Widget.ValidationTextField("userstafid");
var sprytextfield99 = new Spry.Widget.ValidationTextField("id_exist");
<?php /* ?>
var sprytextfield2 = new Spry.Widget.ValidationTextField("itka", "currency", {isRequired:false, hint:"0"});
var sprytextfield5 = new Spry.Widget.ValidationTextField("itkrai", "currency", {isRequired:false, hint:"0"});
var sprytextfield6 = new Spry.Widget.ValidationTextField("itp", "currency", {isRequired:false, hint:"0"});
var sprytextfield13 = new Spry.Widget.ValidationTextField("bsh", "currency", {isRequired:false, hint:"0"});
var sprytextfield14 = new Spry.Widget.ValidationTextField("elktkl", "currency", {isRequired:false, hint:"0"});
var sprytextfield15 = new Spry.Widget.ValidationTextField("elpksht", "currency", {isRequired:false, hint:"0"});
var sprytextfield16 = new Spry.Widget.ValidationTextField("elpakar", "currency", {isRequired:false, hint:"0"});
var sprytextfield17 = new Spry.Widget.ValidationTextField("elmemangku", "currency", {isRequired:false, hint:"0"});
var sprytextfield18 = new Spry.Widget.ValidationTextField("jusa", "currency", {isRequired:false, hint:"0"});
var sprytextfield19 = new Spry.Widget.ValidationTextField("elpemkhas", "currency", {isRequired:false, hint:"0"});
var sprytextfield20 = new Spry.Widget.ValidationTextField("elpemrmh", "currency", {isRequired:false, hint:"0"});
var sprytextfield21 = new Spry.Widget.ValidationTextField("bhs", "currency", {hint:"0", isRequired:false});
var sprytextfield22 = new Spry.Widget.ValidationTextField("el_o", "currency", {isRequired:false, hint:"0"});
var sprytextfield23 = new Spry.Widget.ValidationTextField("gajipokok", "none", {hint:"0"});
*/?>
var sprytextfield8 = new Spry.Widget.ValidationTextField("tempohkontrak", "integer", {minValue:0});
var spryselect1 = new Spry.Widget.ValidationSelect("jwtkla");
var spryselect2 = new Spry.Widget.ValidationSelect("jwtskim");
var spryselect3 = new Spry.Widget.ValidationSelect("jwtgred");
</script>
</body>
</html>
<?php
mysql_free_result($jobs);

mysql_free_result($dir);

mysql_free_result($country);

mysql_free_result($race);

mysql_free_result($location);

mysql_free_result($marital);

mysql_free_result($jobss);

mysql_free_result($jobstype);

mysql_free_result($bank);

mysql_free_result($rel);

mysql_free_result($klas);

mysql_free_result($ske);

mysql_free_result($tit);
?>
<?php include('../inc/footinc.php');?> 