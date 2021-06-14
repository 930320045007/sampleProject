<?php require_once('../Connections/hrmsdb.php'); ?>

<?php include('../inc/user.php');?>

<?php include('../inc/func.php');?>

<?php $menu='5';?>

<?php $menu2='5';?>

<?php $menu3 = '1';?>

<?php

$colname_userprofile = "-1";

if (isset($_GET['id'])) {

  $colname_userprofile = getStafIDByUserID($_GET['id']);

}


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_userprofile = sprintf("SELECT user.* FROM www.user WHERE user.user_stafid = %s", GetSQLValueString($colname_userprofile, "text"));

$userprofile = mysql_query($query_userprofile, $hrmsdb) or die(mysql_error());

$row_userprofile = mysql_fetch_assoc($userprofile);

$totalRows_userprofile = mysql_num_rows($userprofile);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_dsg = sprintf("SELECT * FROM www.user_designation WHERE user_stafid = %s ORDER BY userdesignation_date_y DESC, userdesignation_date_m DESC, userdesignation_date_d DESC, userdesignation_id DESC", GetSQLValueString($colname_userprofile, "text"));

$dsg = mysql_query($query_dsg, $hrmsdb) or die(mysql_error());

$row_dsg = mysql_fetch_assoc($dsg);

$totalRows_dsg = mysql_num_rows($dsg);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_sch = sprintf("SELECT user_scheme.*, classification.classification_id FROM www.user_scheme LEFT JOIN www.scheme ON scheme.scheme_id = user_scheme.scheme_id LEFT JOIN www.classification ON classification.classification_id = scheme.classification_id WHERE user_stafid = %s AND user_scheme.userscheme_status = '1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, user_scheme.userscheme_id DESC", GetSQLValueString($colname_userprofile, "text"));

$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());

$row_sch = mysql_fetch_assoc($sch);

$totalRows_sch = mysql_num_rows($sch);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_tg = sprintf("SELECT * FROM www.user_salaryskill WHERE user_stafid = %s ORDER BY usersalaryskill_date_y DESC, usersalaryskill_date_m DESC, usersalaryskill_date_d DESC, usersalaryskill_id DESC", GetSQLValueString($colname_userprofile, "text"));

$tg = mysql_query($query_tg, $hrmsdb) or die(mysql_error());

$row_tg = mysql_fetch_assoc($tg);

$totalRows_tg = mysql_num_rows($tg);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_emo = sprintf("SELECT * FROM www.user_emolumen WHERE user_stafid = %s ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC", GetSQLValueString($colname_userprofile, "text"));

$emo = mysql_query($query_emo, $hrmsdb) or die(mysql_error());

$row_emo = mysql_fetch_assoc($emo);

$totalRows_emo = mysql_num_rows($emo);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cuti = sprintf("SELECT * FROM www.user_leave WHERE user_stafid = %s AND userleave_status = '1' ORDER BY userleave_year DESC, userleave_id DESC", GetSQLValueString($colname_userprofile, "text"));

$cuti = mysql_query($query_cuti, $hrmsdb) or die(mysql_error());

$row_cuti = mysql_fetch_assoc($cuti);

$totalRows_cuti = mysql_num_rows($cuti);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_userjob2 = sprintf("SELECT * FROM www.user_job2 WHERE user_job2.user_stafid = %s AND user_job2.userjob2_status = 1 ORDER BY userjob2_date_y DESC, userjob2_date_m DESC, userjob2_date_d DESC, userjob2_id DESC", GetSQLValueString($colname_userprofile, "text"));

$userjob2 = mysql_query($query_userjob2, $hrmsdb) or die(mysql_error());

$row_userjob2 = mysql_fetch_assoc($userjob2);

$totalRows_userjob2 = mysql_num_rows($userjob2);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_userunit = sprintf("SELECT * FROM www.user_unit WHERE user_stafid = %s ORDER BY userunit_in_y DESC, userunit_in_m DESC, userunit_in_d DESC, userunit_id DESC", GetSQLValueString($colname_userprofile, "text"));

$userunit = mysql_query($query_userunit, $hrmsdb) or die(mysql_error());

$row_userunit = mysql_fetch_assoc($userunit);

$totalRows_userunit = mysql_num_rows($userunit);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_userjobdate = sprintf("SELECT * FROM www.user_job WHERE user_stafid = %s ORDER BY userjob_id DESC", GetSQLValueString($colname_userprofile, "text"));

$userjobdate = mysql_query($query_userjobdate, $hrmsdb) or die(mysql_error());

$row_userjobdate = mysql_fetch_assoc($userjobdate);

$totalRows_userjobdate = mysql_num_rows($userjobdate);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_kewelist = "SELECT user_kewe.* FROM www.user_kewe WHERE userkewe_status = 1 AND user_kewe.user_stafid = '" . $colname_userprofile . "' AND NOT EXISTS (SELECT * FROM www.user_salary WHERE user_stafid ='" . $colname_userprofile . "' AND user_salary.usersalary_kew8 = user_kewe.userkewe_id) AND NOT EXISTS (SELECT * FROM www.user_salaryskill WHERE usersalaryskill_status = 1 AND user_salaryskill.user_stafid ='" . $colname_userprofile . "' AND user_salaryskill.userkewe_id = user_kewe.userkewe_id) AND NOT EXISTS (SELECT * FROM www.user_emolumen WHERE useremolumen_status = 1 AND user_emolumen.user_stafid ='" . $colname_userprofile . "') ";

$kewelist = mysql_query($query_kewelist, $hrmsdb) or die(mysql_error());

$row_kewelist = mysql_fetch_assoc($kewelist);

$totalRows_kewelist = mysql_num_rows($kewelist);

?>

<?php

mysql_select_db($database_hrmsdb, $hrmsdb);

$query_jobs = "SELECT * FROM www.jobs ORDER BY jobscode_id ASC";

$jobs = mysql_query($query_jobs, $hrmsdb) or die(mysql_error());

$row_jobs = mysql_fetch_assoc($jobs);

$totalRows_jobs = mysql_num_rows($jobs);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_dir = "SELECT * FROM www.dir WHERE dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";

$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());

$row_dir = mysql_fetch_assoc($dir);

$totalRows_dir = mysql_num_rows($dir);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_country = "SELECT * FROM www.countrylist ORDER BY Name ASC";

$country = mysql_query($query_country, $hrmsdb) or die(mysql_error());

$row_country = mysql_fetch_assoc($country);

$totalRows_country = mysql_num_rows($country);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_race = "SELECT * FROM www.race ORDER BY race_short ASC";

$race = mysql_query($query_race, $hrmsdb) or die(mysql_error());

$row_race = mysql_fetch_assoc($race);

$totalRows_race = mysql_num_rows($race);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_location = "SELECT * FROM www.location ORDER BY location_name ASC";

$location = mysql_query($query_location, $hrmsdb) or die(mysql_error());

$row_location = mysql_fetch_assoc($location);

$totalRows_location = mysql_num_rows($location);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_marital = "SELECT * FROM www.marital ORDER BY marital_id ASC";

$marital = mysql_query($query_marital, $hrmsdb) or die(mysql_error());

$row_marital = mysql_fetch_assoc($marital);

$totalRows_marital = mysql_num_rows($marital);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_jobss = "SELECT * FROM www.jobs_sub ORDER BY jobss_name ASC";

$jobss = mysql_query($query_jobss, $hrmsdb) or die(mysql_error());

$row_jobss = mysql_fetch_assoc($jobss);

$totalRows_jobss = mysql_num_rows($jobss);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_jobstype = "SELECT * FROM www.job_type ORDER BY jobtype_name ASC";

$jobstype = mysql_query($query_jobstype, $hrmsdb) or die(mysql_error());

$row_jobstype = mysql_fetch_assoc($jobstype);

$totalRows_jobstype = mysql_num_rows($jobstype);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_bank = "SELECT * FROM www.bank ORDER BY bank_name ASC";

$bank = mysql_query($query_bank, $hrmsdb) or die(mysql_error());

$row_bank = mysql_fetch_assoc($bank);

$totalRows_bank = mysql_num_rows($bank);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_rel = "SELECT * FROM www.religion ORDER BY religion_id ASC";

$rel = mysql_query($query_rel, $hrmsdb) or die(mysql_error());

$row_rel = mysql_fetch_assoc($rel);

$totalRows_rel = mysql_num_rows($rel);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_klas = "SELECT * FROM www.classification ORDER BY classification_code ASC";

$klas = mysql_query($query_klas, $hrmsdb) or die(mysql_error());

$row_klas = mysql_fetch_assoc($klas);

$totalRows_klas = mysql_num_rows($klas);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_ske = "SELECT * FROM www.scheme ORDER BY group_id ASC";

$ske = mysql_query($query_ske, $hrmsdb) or die(mysql_error());

$row_ske = mysql_fetch_assoc($ske);

$totalRows_ske = mysql_num_rows($ske);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_j2 = "SELECT * FROM www.jobs_sub ORDER BY jobss_id ASC";

$j2 = mysql_query($query_j2, $hrmsdb) or die(mysql_error());

$row_j2 = mysql_fetch_assoc($j2);

$totalRows_j2 = mysql_num_rows($j2);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_lt = "SELECT * FROM www.leave_type WHERE leavetype_view = 1 ORDER BY leavetype_name ASC";

$lt = mysql_query($query_lt, $hrmsdb) or die(mysql_error());

$row_lt = mysql_fetch_assoc($lt);

$totalRows_lt = mysql_num_rows($lt);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_tit = "SELECT * FROM www.title ORDER BY title_id ASC";

$tit = mysql_query($query_tit, $hrmsdb) or die(mysql_error());

$row_tit = mysql_fetch_assoc($tit);

$totalRows_tit = mysql_num_rows($tit);


?>

<?php 

// make a note of the location of the upload handler script 

$uploadHandler = $url_main . 'up/upload.processor.php'; 


// set a max file size for the html upload form 

$max_file_size = 300000; // size in bytes 


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="../css/index.css" rel="stylesheet" type="text/css" />

<?php include('../inc/headinc.php');?>

<?php include('../inc/liload.php');?>

<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

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

            <?php include('menustaf.php');?>

              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>

            <ul>

                <li class="gap">&nbsp;</li>

                <li>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                  <td rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic($colname_userprofile);?></td>

                    <td nowrap="nowrap" class="label">Nama</td>

                    <td width="100%"><strong><?php echo strtoupper(getFullNameByStafID($colname_userprofile)) . " (" . $colname_userprofile . ")"; ?></strong></td>

                  </tr>

                  <tr>

                    <td nowrap="nowrap" class="label noline">Jawatan</td>

                    <td class="noline txt_line"><?php echo getJobtitle($colname_userprofile); ?><br/><?php echo getFulldirectoryByUserID($colname_userprofile);?></td>

                  </tr>

                </table>

                </li>

                <li class="gap">&nbsp;</li>

           	  <li class="title">Maklumat Peribadi <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 3)){ //semak user level utk update profile?><span class="fr add" onClick="toggleview('formprofile','profile'); return false;">Kemaskini</span><?php }; ?></li>

              <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 3)){ //semak user level utk update profile?>

              <div id="formprofile" class="hidden">

                <li>

                  <form id="formprofile" name="formprofile" method="POST" action="<?php echo $url_main;?>sb/profile_admin.php?id=<?php echo $colname_userprofile;?>&url=edit">

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td class="label">Nama *</td>

    <td colspan="3"><span id="firstname"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>

        <label for="title_id"></label>

        <select name="title_id" id="title_id">

          <option value="0" <?php if (!(strcmp(0, $row_userprofile['title_id']))) {echo "selected=\"selected\"";} ?>>Tuan / Puan</option>

          <?php

			do {  

			?>

			<option value="<?php echo $row_tit['title_id']?>"<?php if (!(strcmp($row_tit['title_id'], $row_userprofile['title_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_tit['title_name']?></option>

					  <?php

			} while ($row_tit = mysql_fetch_assoc($tit));

			  $rows = mysql_num_rows($tit);

			  if($rows > 0) {

				  mysql_data_seek($tit, 0);

				  $row_tit = mysql_fetch_assoc($tit);

			  }

			?>

        </select>

        <input name="user_firstname" type="text" class="in_cappitalize w70" id="user_firstname" value="<?php echo $row_userprofile['user_firstname']; ?>" /></span></td>

    </tr>

  <tr>

    <td class="label">Nama Bapa / Penjaga *</td>

    <td colspan="3">

      <span id="lastname"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>

      <input name="user_lastname" type="text" class="in_cappitalize" id="textfield5" value="<?php echo $row_userprofile['user_lastname']; ?>" /></span></td>

  </tr>

  <tr>

    <td class="label">Staf ID *</td>

    <td colspan="3"><span id="userstafid"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>

      <input name="user_stafid" type="text" class="w50 in_upper" id="user_stafid" value="<?php echo $row_userprofile['user_stafid']; ?>" />

      </span>

      <div class="inputlabel2">Untuk perubahan pada Staf ID perlu melalui Unit ICT</div></td>

  </tr>

  <tr>

    <td class="label">No. Kad Pengenalan</td>

    <td colspan="3"><input name="user_noic" type="text" class="w50" id="user_noic" value="<?php echo $row_userprofile['user_noic']; ?>" /><div class="inputlabel2">Tanpa simbol '-'. Cth: 881203065595</div></td>

    </tr>

  <tr>

    <td class="label">Tarikh Lahir *</td>

    <td colspan="3">

      <select name="user_dob_d" id="user_dob_d">

        <?php for($i=1; $i<=31; $i++){?>

        <option <?php if($i==$row_userprofile['user_dob_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

        <?php }; ?>

      </select>

      <span class="inputlabel">/ </span>

      <select name="user_dob_m" id="user_dob_m">

      <?php for($j=1; $j<=12; $j++){?>

        <option <?php if($j==$row_userprofile['user_dob_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>

        <?php }; ?>

      </select>

      <span class="inputlabel">/ </span><span id="dob_year">

      <span class="textfieldRequiredMsg">Maklumat diperlukan</span><span class="textfieldInvalidFormatMsg">Sila pastikan Format Tahun dimasukkan dengan betul.</span>

      <input name="user_dob_y" type="text" class="w25" id="user_dob_y" value="<?php echo $row_userprofile['user_dob_y']; ?>" size="4" /></span></td>

    </tr>

  <tr>

    <td class="label">Jantina</td>

    <td>

      <select name="user_gender" id="user_gender">

        <option value="1" <?php if (!(strcmp(1, $row_userprofile['user_gender']))) {echo "selected=\"selected\"";} ?>>Lelaki</option>

        <option value="2" <?php if (!(strcmp(2, $row_userprofile['user_gender']))) {echo "selected=\"selected\"";} ?>>Perempuan</option>

      </select></td>

    <td class="label">Kaum</td>

    <td><select name="user_race" id="user_race">

      <?php

do {  

?>

      <option value="<?php echo $row_race['race_id']?>"<?php if (!(strcmp($row_race['race_id'], $row_userprofile['user_race']))) {echo "selected=\"selected\"";} ?>><?php echo $row_race['race_name']?></option>

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

    <td class="label">Kewarganegaraan</td>

    <td><label for="user_nationality"></label>

      <select name="user_nationality" id="user_nationality">

        <?php

do {  

?>

        <option value="<?php echo $row_country['CountryID']?>"<?php if (!(strcmp($row_country['CountryID'], $row_userprofile['user_nationality']))) {echo "selected=\"selected\"";} ?>><?php echo $row_country['Name']?></option>

        <?php

} while ($row_country = mysql_fetch_assoc($country));

  $rows = mysql_num_rows($country);

  if($rows > 0) {

      mysql_data_seek($country, 0);

	  $row_country = mysql_fetch_assoc($country);

  }

?>


      </select></td>

    <td class="label">Agama</td>

    <td>

      <select name="religion_id" id="religion_id">

        <?php

do {  

?>

        <option value="<?php echo $row_rel['religion_id']?>"<?php if (!(strcmp($row_rel['religion_id'], $row_userprofile['religion_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rel['religion_name']?></option>

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

  <tr>

    <td class="label noline"><input type="hidden" name="MM_update" value="formprofile" /></td>

    <td colspan="3" class="noline">

    <input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />

    <input name="batal" type="button" class="cancelbutton" id="batal" value="Batal" onClick="toggleview('formprofile','profile'); return false;" /></td>

    </tr>

                  </table>

                  </form>

                </li>

        </div>

        <?php }; ?>

        <div id="profile">

        <li class="gap">&nbsp;</li>

          <li>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td nowrap="nowrap" class="label">No. Kad Pengenalan</td>

              <td colspan="3" width="100%"><?php echo $row_userprofile['user_noic']; ?></td>

              </tr>

            <tr>

              <td nowrap="nowrap" class="label">Tarikh Lahir</td>

              <td colspan="3"><?php echo $row_userprofile['user_dob_d']; ?> / <?php echo $row_userprofile['user_dob_m']; ?> / <?php echo $row_userprofile['user_dob_y']; ?> (<?php echo getAgeByUserID($row_userprofile['user_stafid']);?> Tahun)</td>

              </tr>

            <tr>

              <td nowrap="nowrap" class="label">Jantina</td>

              <td><?php echo getGender($row_userprofile['user_gender']); ?></td>

              <td nowrap="nowrap" class="label">Kaum</td>

              <td><?php echo getRace($row_userprofile['user_race']); ?></td>

            </tr>

            <tr>

              <td nowrap="nowrap" class="label">Kewarganegaraan</td>

              <td><?php echo getCitizen($row_userprofile['user_nationality']); ?></td>

              <td nowrap="nowrap" class="label">Agama</td>

              <td><?php echo getReligion($row_userprofile['religion_id']); ?></td>

            </tr>

            </table>

        </li>

      </div>

      <li class="gap">&nbsp;</li>

    <li class="title">Tarikh Lantikan <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?><span class="fr add" onClick="toggleview('formLantikan', 'viewLantikan'); return false;">Kemaskini</span><?php }; ?></li>

      <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?>

      <div id="formLantikan" class="hidden">

      <li>

        <form id="formDateLantikan" name="formDateLantikan" method="post" action="../sb/update_tarikhlantikan.php">

          <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td class="label">Tarikh Mula <br /> Dilantik Ke ISN</td>

              <td>

                  <select name="userjob_start_d" id="userjob_start_d">

                  <?php for($i=1; $i<=31; $i++){ if($i<10) $i = '0' . $i;?>

                  <option <?php if($row_userjobdate['userjob_start_d']==$i) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>

                  <?php }; ?>

                  </select>

                  <select name="userjob_start_m" id="userjob_start_m">

                  <?php for($j=1; $j<=12; $j++){ if($j<10) $j = '0' . $j;?>

                  <option <?php if($row_userjobdate['userjob_start_m']==$j) echo "selected=\"selected\"";?> value="<?php echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>

                  <?php }; ?>

                  </select>

                  <select name="userjob_start_y" id="userjob_start_y">

                  <?php for($k=(date('Y')-60); $k<=(date('Y')+1); $k++){?>

                  <option <?php if($row_userjobdate['userjob_start_y']==$k) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>

                  <?php }; ?>

                  </select>

              </td>

            </tr>

<tr>

              <td class="label">Tarikh Mula Lantikan<br /> Tetap / Kontrak</td>

              <td>

                  <select name="userjob_in_d" id="userjob_in_d">

                  <?php for($i=1; $i<=31; $i++){ if($i<10) $i = '0' . $i;?>

                  <option <?php if($row_userjobdate['userjob_in_d']==$i) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>

                  <?php }; ?>

                  </select>

                  <select name="userjob_in_m" id="userjob_in_m">

                  <?php for($j=1; $j<=12; $j++){ if($j<10) $j = '0' . $j;?>

                  <option <?php if($row_userjobdate['userjob_in_m']==$j) echo "selected=\"selected\"";?> value="<?php echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>

                  <?php }; ?>

                  </select>

                  <select name="userjob_in_y" id="userjob_in_y">

                  <?php for($k=(date('Y')-60); $k<=(date('Y')+1); $k++){?>

                  <option <?php if($row_userjobdate['userjob_in_y']==$k) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>

                  <?php }; ?>

                  </select>

              </td>

            </tr>

            <tr>

              <td class="label">Tarikh Sah Jawatan</td>

              <td>

                  <select name="userjob_promoted_d" id="userjob_promoted_d">

                  <?php for($i=1; $i<=31; $i++){ if($i<10) $i = '0' . $i;?>

                  <option <?php if($row_userjobdate['userjob_promoted_d']==$i) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>

                  <?php }; ?>

                  </select>

                  <select name="userjob_promoted_m" id="userjob_promoted_m">

                  <?php for($j=1; $j<=12; $j++){ if($j<10) $j = '0' . $j;?>

                  <option <?php if($row_userjobdate['userjob_promoted_m']==$j) echo "selected=\"selected\"";?> value="<?php echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>

                  <?php }; ?>

                  </select>

                  <select name="userjob_promoted_y" id="userjob_promoted_y">

                  <?php for($k=(date('Y')-60); $k<=(date('Y')+1); $k++){?>

                  <option <?php if($row_userjobdate['userjob_promoted_y']==$k) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>

                  <?php }; ?>

                  </select>

              </td>

            </tr>

            <tr>

              <td class="label">Tarikh Pergerakan Gaji (TPG)</td>

              <td>

              <select name="userjob_tpg_m" id="userjob_tpg_m">

              	<option value="0">Tiada</option>

              <?php for($tpg=1; $tpg<=12; $tpg+=3){ if($tpg<10) $tpg = '0' . $tpg;?>

                <option <?php if($row_userjobdate['userjob_tpg_m']==$tpg) echo "selected=\"selected\"";?> value="<?php echo $tpg;?>"><?php echo date('m - F', mktime(0, 0, 0, $tpg, 1, date('Y')));?></option>

              <?php }; ?>

              </select>

              <select name="userjob_tpg_note" id="userjob_tpg_note">

              	<option value="">Tiada</option>

                <option value="Penukaran Skim">Penukaran Skim</option>

                <option value="Kenaikan Pangkat">Kenaikan Pangkat</option>

                <option value="Penukaran Gred">Penukaran Gred</option>

                <option value="Gaji Maksimum">Gaji Maksimum</option>

                <option value="Gaji tidak Berskim">Gaji tidak Berskim</option>

                <option value="Kontrak 6bulan">Kontrak 6bulan</option>

                <option value="Tatatertib">Tatatertib</option>

              </select>

              </td>

            </tr>

            <tr>

              <td><input name="MM_update_tarikhlantikan" type="hidden" id="MM_update_tarikhlantikan" value="updateLantikan" />

                <input name="id" type="hidden" id="id" value="<?php echo $row_userprofile['user_stafid']; ?>" /></td>

              <td><input name="button18" type="submit" class="submitbutton" id="button18" value="Kemaskini" />

                <input name="button19" type="button" class="cancelbutton" id="button19" value="Batal" onClick="toggleview('formLantikan', 'viewLantikan'); return false;" /></td>

            </tr>

          </table>

        </form>

      </li>

      </div>

      <?php }; ?>

      <div id="viewLantikan">

      <li class="gap">&nbsp;</li>

      

      <li>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td nowrap="nowrap" class="label">Tarikh Mula <br />

              Dilantik Ke ISN</td>

            <td><?php echo $row_userjobdate['userjob_start_d']; ?>/<?php echo $row_userjobdate['userjob_start_m']; ?>/<?php echo $row_userjobdate['userjob_start_y']; ?></td>

            </tr>

	   <tr>

            <td nowrap="nowrap" class="label">Tarikh Mula Lantikan<br />

              Tetap / Kontrak</td>

            <td><?php echo $row_userjobdate['userjob_in_d']; ?>/<?php echo $row_userjobdate['userjob_in_m']; ?>/<?php echo $row_userjobdate['userjob_in_y']; ?></td>

            </tr>

          <tr>

            <td nowrap="nowrap" class="label">Tarikh Sah Jawatan</td>

            <td><?php echo $row_userjobdate['userjob_promoted_d']; ?>/<?php echo $row_userjobdate['userjob_promoted_m']; ?>/<?php echo $row_userjobdate['userjob_promoted_y']; ?></td>

            </tr>

          <tr>

            <td nowrap="nowrap" class="label">Tarikh Pergerakan Gaji (TPG)</td>

            <td><?php if($row_userjobdate['userjob_tpg_m']!=0) echo date('m - F', mktime(0, 0, 0, $row_userjobdate['userjob_tpg_m'], 1, date('Y'))); else echo "Tiada"; ?> <?php if($row_userjobdate['userjob_tpg_note']!="") echo "&nbsp; &bull; &nbsp;" . $row_userjobdate['userjob_tpg_note'];?></td>

          </tr>

        </table>

        </li>

        <li class="gap">&nbsp;</li>

        </div>

                <li class="title">Taraf Penjawatan <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?><span class="fr add" onClick="toggleview2('formdgn'); return false;">+ Tambah</span><?php }; ?></li>

                 <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?>

                <div id="formdgn" class="hidden">

                <li>

                  <form id="formdgn" name="formdgn" method="POST" action="<?php echo $url_main;?>sb/profile_admin.php?id=<?php echo $colname_userprofile;?>&url=edit">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td class="label">Status</td>

                        <td>

                              <select name="jobtype_id" id="jobtype_id">

                                <?php

								do {  

								?>

																<option value="<?php echo $row_jobstype['jobtype_id']?>"><?php echo $row_jobstype['jobtype_name']?></option>

																<?php

								} while ($row_jobstype = mysql_fetch_assoc($jobstype));

								  $rows = mysql_num_rows($jobstype);

								  if($rows > 0) {

									  mysql_data_seek($jobstype, 0);

									  $row_jobstype = mysql_fetch_assoc($jobstype);

								  }

								?>

                              </select>

                         </td>

                      </tr>

                      <tr>

                        <td class="label">Tempoh</td>

                        <td><input name="userdesignation_period" type="text" class="w10 txt_right" id="userdesignation_period" value="12" /><span class="inputlabel"> bulan</span><div class="inputlabel2">Isi 0 jika Tetap</div></td>

                      </tr>

                      <tr>

                        <td class="label">Tarikh Lantikan</td>

                        <td>

                          <select name="userdesignation_date_d" id="userdesignation_date_d">

                            <?php for($i=1; $i<=31; $i++){?>

                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

                            <?php }; ?>

                            </select>

                          <span class="inputlabel">/</span>

                          <select name="userdesignation_date_m" id="userdesignation_date_m">

                            <?php for($j=1; $j<=12; $j++){?>

                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>

                            <?php }; ?>

                            </select>

                            <span class="inputlabel">/</span>

                            <input name="userdesignation_date_y" type="text" class="w25" id="userdesignation_date_y" value="<?php echo date('Y');?>" size="4" />

        				</td>

                      </tr>

                      <tr>

                        <td class="noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_userprofile['user_stafid']; ?>" />

                        <input name="MM_insert_dgn" type="hidden" id="MM_insert_dgn" value="formdgn" /></td>

                        <td class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />

                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" onClick="toggleview2('formdgn'); return false;"/></td>

                      </tr>

                    </table>

                  </form>

              </li>

              </div>

              <?php }; ?>

              <li>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <?php if ($totalRows_dsg > 0) { // Show if recordset not empty ?>

<tr>

      <th align="left">Tarikh</th>

      <th width="100%" align="left">Status</th>

      <th align="center" valign="middle" nowrap="nowrap">Tempoh (Bulan)</th>

      <th align="left">&nbsp;</th>

  </tr>

    <?php do { ?>

      <tr class="<?php if($row_dsg['userdesignation_status']=='1') echo "on"; else echo "offcourses";?>">

        <td align="left" valign="middle" nowrap="nowrap"><?php echo $row_dsg['userdesignation_date_d']; ?>/<?php echo $row_dsg['userdesignation_date_m']; ?>/<?php echo $row_dsg['userdesignation_date_y']; ?></td>

        <td><?php echo getJobtypeByID($row_dsg['jobtype_id']); ?></td>

        <td align="center" valign="middle"><?php echo $row_dsg['userdesignation_period']; ?></td>

        <td><?php if($row_dsg['userdesignation_status']=='1'){?><ul class="func"><li><a onClick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo $row_dsg['userdesignation_date_d']; ?>/<?php echo $row_dsg['userdesignation_date_m']; ?>/<?php echo $row_dsg['userdesignation_date_y']; ?> - <?php echo getJobtypeByID($row_dsg['jobtype_id']); ?>')" href="../sb/del_userdesignationadmin.php?deldes=<?php echo $row_dsg['userdesignation_id']; ?>&amp;id=<?php echo getID($row_dsg['user_stafid']); ?>">X</a></li></ul>

        <?php }; ?></td>

      </tr>

      <?php } while ($row_dsg = mysql_fetch_assoc($dsg)); ?>

    <tr>

      <td colspan="4" align="center" valign="middle" nowrap="nowrap" class="noline txt_color1"><?php echo $totalRows_dsg; ?> rekod dijumpai</td>

    </tr>

  <?php } else { ?>

    <tr>

      <td colspan="4" align="center" valign="middle" nowrap="nowrap" class="noline">Tiada rekod dijumpai</td>

    </tr>

  <?php }; ?>

  </table>

              </li>

              <li class="title">Jawatan <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?><span class="fr add" onClick="toggleview2('formjaw'); return false;">+ Tambah</span><?php }; ?></li>

               <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?>

              <div id="formjaw" class="hidden">

              <li>

                <form id="formjob1" name="formjob1" method="post" action="<?php echo $url_main;?>sb/profile_admin.php?id=<?php echo $colname_userprofile;?>&url=edit">

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td class="label">Jawatan</td>

                      <td nowrap="nowrap"><span id="jwtkla">

                      <span class="selectRequiredMsg">Sila pilih Klasifikasi <br/></span>

                        <select name="klas" id="klas" onChange="dochange('1', 'scheme_id', this.value, '0');">

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

                        </select></span></td>

                      <td nowrap="nowrap"><span id="jwtskim">

                      <span class="selectRequiredMsg">Sila pilih Skim <br/></span>

                        <select name="scheme_id" id="scheme_id" onChange="dochange('2', 'userscheme_gred', this.value, '0');">

                          <option value="0" disabled="disabled">&laquo; Pilih Klasifikasi</option>

                        </select></span></td>

                      <td nowrap="nowrap"><span id="jwtgred">

                      <span class="selectRequiredMsg">Sila pilih Gred <br/></span>

                        <select name="userscheme_gred" id="userscheme_gred" onChange="dochange('4', 'gredkhas_id', this.value, '0');">

                          <option value="0" disabled="disabled">&laquo; Pilih Skim</option>

                        </select></span></td>

                      <td nowrap="nowrap"><ul class="inputradio"><li><input name="userscheme_no" type="checkbox" id="userscheme_no" value="1" /> Tidak Berskim</li></ul></td>

                      <td nowrap="nowrap"><ul class="inputradio"><li><input name="userscheme_no" type="checkbox" id="userscheme_no" value="2" /> Terbuka</li></ul></td>

                    </tr>

                    <tr>

                      <td class="label" nowrap="nowrap">Gred Khas</td>

                      <td colspan="4">

                        <select name="gredkhas_id" id="gredkhas_id">

                        	<option value="0">Tiada</option>

                      </select></td>

                    </tr>

                    <tr>

                      <td class="label" nowrap="nowrap">Tarikh Lantikan</td>

                      <td colspan="4"><select name="userscheme_in_d" id="userscheme_in_d">

                        <?php for($i=1; $i<=31; $i++){?>

                        <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

                        <?php }; ?>

                      </select>

                        <span class="inputlabel">/</span>

                        <select name="userscheme_in_m" id="userscheme_in_m">

                          <?php for($j=1; $j<=12; $j++){?>

                          <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>

                          <?php }; ?>

                        </select>

                        <span class="inputlabel">/</span>

                        <input name="userscheme_in_y" type="text" class="w25" id="userscheme_in_y" value="<?php echo date('Y');?>" size="4" /></td>

                    </tr>

                    <tr>

                      <td class="noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_userprofile['user_stafid']; ?>" />

                      <input name="MM_insert_job1" type="hidden" id="MM_insert_job1" value="formjob1" /></td>

                      <td colspan="4" class="noline"><input name="button6" type="submit" class="submitbutton" id="button6" value="Tambah" />

                      <input name="button7" type="button" class="cancelbutton" id="button7" value="Batal"  onclick="toggleview2('formjaw'); return false;"/></td>

                    </tr>

                  </table>

                </form>

              </li>

              </div>

              <?php }; ?>

              <li>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <?php if ($totalRows_sch > 0) { // Show if recordset not empty ?>

<tr>

      <th align="left">Tarikh</th>

      <th>Gred</th>

      <th width="100%" align="left">Skim</th>

      <th align="left">&nbsp;</th>

  </tr>

    <?php do { ?>

      <tr class="on">

        <td align="left" nowrap="nowrap"><?php echo $row_sch['userscheme_in_d']; ?>/<?php echo $row_sch['userscheme_in_m']; ?>/<?php echo $row_sch['userscheme_in_y']; ?></td>

        <td nowrap="nowrap"><?php echo getGred($colname_userprofile, $row_sch['userscheme_id']); ?></td>

        <td><?php echo getSchemeNameByID($row_sch['scheme_id']);?> <?php if(checkNoSchemeBySchemeID($row_sch['userscheme_id'])){?><span class="txt_color1"> &nbsp; &bull; &nbsp; <?php echo getNoSchemeBySchemeID($row_sch['userscheme_id']);?></span><?php };?></td>

        <td><ul class="func">

          <li><a onClick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo getSchemeNameByID($row_sch['scheme_id']);?> (<?php echo getClassificationAndCode2BySchemeID($row_sch['scheme_id']); echo $row_sch['userscheme_gred']; ?>)')" href="../sb/del_userschemeadmin.php?deljwt=<?php echo $row_sch['userscheme_id']; ?>&amp;id=<?php echo getID($row_sch['user_stafid']); ?>">X</a></li></ul></td>

      </tr>

      <?php } while ($row_sch = mysql_fetch_assoc($sch)); ?>

    <tr>

      <td colspan="4" align="center" valign="middle" nowrap="nowrap" class="noline txt_color1"><?php echo $totalRows_sch ?> rekod dijumpai</td>

    </tr>

  <?php } else { ?>

    <tr>

      <td colspan="4" align="center" valign="middle" nowrap="nowrap" class="noline">Tiada rekod dijumpai</td>

    </tr>

  <?php }; ?>

  </table>

              </li>

              <li class="title">Jawatan 2 <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?><span class="fr add" onClick="toggleview2('formj2'); return false;">+ Tambah</span><?php }; ?></li>

              <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?>

              <div id="formj2" class="hidden">

              <li>

                <form id="formjob2" name="formjob2" method="POST" action="<?php echo $url_main;?>sb/profile_admin.php?id=<?php echo $colname_userprofile;?>&url=edit">

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td class="label noline">Jawatan</td>

                      <td class="noline">

                        <select name="jobss_id" id="jobss_id">

                          <?php

do {  

?>

                          <option value="<?php echo $row_j2['jobss_id']?>"><?php echo $row_j2['jobss_name']?></option>

                          <?php

} while ($row_j2 = mysql_fetch_assoc($j2));

  $rows = mysql_num_rows($j2);

  if($rows > 0) {

      mysql_data_seek($j2, 0);

	  $row_j2 = mysql_fetch_assoc($j2);

  }

?>

                        </select></td>

                    </tr>

                    <tr>

                      <td class="label noline">Tarikh Lantikan</td>

                      <td class="noline"><select name="userjob2_date_d" id="userjob2_date_d">

                        <?php for($i=1; $i<=31; $i++){?>

                        <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

                        <?php }; ?>

                      </select>

                        <span class="inputlabel">/</span>

                        <select name="userjob2_date_m" id="userjob2_date_m">

                          <?php for($j=1; $j<=12; $j++){?>

                          <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>

                          <?php }; ?>

                        </select>

                        <span class="inputlabel">/</span>

                        <input name="userjob2_date_y" type="text" class="w25" id="userjob2_date_y" value="<?php echo date('Y');?>" size="4" />

                        </td>

                    </tr>

                    <tr>

                      <td class="label noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_userprofile['user_stafid']; ?>" />

                      <input name="MM_insert_job2" type="hidden" id="MM_insert_job2" value="formjob2" /></td>

                      <td class="noline"><input name="button16" type="submit" class="submitbutton" id="button16" value="Tambah" />

                      <input name="button17" type="button" class="cancelbutton" id="button17" value="Batal" onClick="toggleview2('formj2'); return false;"/></td>

                    </tr>

                  </table>

                </form>

              </li>

              </div>

              <?php }; ?>

              <li>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <?php if ($totalRows_userjob2 > 0) { // Show if recordset not empty ?>

<tr>

      <th>Tarikh</th>

      <th width="100%" align="left" valign="middle">Jawatan</th>

      <th>&nbsp;</th>

</tr>

    <?php do { ?>

      <tr class="<?php if($row_userjob2['userjob2_status']=='1') echo "on"; else echo "offcourses";?>">

        <td nowrap="nowrap"><?php echo $row_userjob2['userjob2_date_d']; ?>/<?php echo $row_userjob2['userjob2_date_m']; ?>/<?php echo $row_userjob2['userjob2_date_y']; ?></td>

        <td><?php echo getJobtitle2ByID($row_userjob2['userjob2_id']); ?></td>

        <td><?php if($row_userjob2['userjob2_status']=='1'){?><ul class="func"><li><a onClick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo $row_userjob2['userjob2_date_d']; ?>/<?php echo $row_userjob2['userjob2_date_m']; ?>/<?php echo $row_userjob2['userjob2_date_y']; ?> - <?php echo getJobtitle2ByID($row_userjob2['userjob2_id']); ?>')" href="../sb/del_userjobtwoadmin.php?deljobtwo=<?php echo $row_userjob2['userjob2_id']; ?>&amp;id=<?php echo getID($row_userjob2['user_stafid']); ?>">X</a></li></ul>

        <?php }; ?>

        </td>

      </tr>

      <?php } while ($row_userjob2 = mysql_fetch_assoc($userjob2)); ?>

    <tr>

      <td colspan="3" align="center" valign="middle" nowrap="nowrap" class="noline txt_color1"><?php echo $totalRows_userjob2 ?> rekod dijumpai</td>

    </tr>

  <?php } else { ?>

    <tr>

      <td colspan="3" align="center" valign="middle" nowrap="nowrap" class="noline">Tiada rekod dijumpai</td>

    </tr>

  <?php }; ?>

  </table>

              </li>

              <li class="title">Penempatan <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?><span class="fr add" onClick="toggleview2('formpen'); return false;">+ Tambah</span><?php }; ?></li>

              <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?>

              <div id="formpen" class="hidden">

              <li>

                <form id="pen" name="pen" method="POST" action="<?php echo $url_main;?>sb/profile_admin.php?id=<?php echo $colname_userprofile;?>&url=edit">

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td class="noline label"> Unit / Cawangan / Pusat / Bahagian </td>

                      <td class="noline">

                        <select name="dir_id" id="dir_id">

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

  </select>

                        <label for="location_id"></label>

                        <select name="location_id" id="location_id">

                          <?php

do {  

?>

                          <option value="<?php echo $row_location['location_id']?>"><?php echo $row_location['location_name']?></option>

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

                      <td class="noline label">Tarikh</td>

                      <td class="noline"><select name="userunit_in_d" id="userunit_in_d">

                        <?php for($i=1; $i<=31; $i++){?>

                        <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

                        <?php }; ?>

                      </select>

                        <span class="inputlabel">/</span>

                        <select name="userunit_in_m" id="userunit_in_m">

                          <?php for($j=1; $j<=12; $j++){?>

                          <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>

                          <?php }; ?>

                        </select>

                        <span class="inputlabel">/</span>

                        <input name="userunit_in_y" type="text" class="w25" id="userunit_in_y" value="<?php echo date('Y');?>" size="4" /></td>

                    </tr>

                    <tr>

                      <td class="noline label">&nbsp;</td>

                      <td class="noline">

                      <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_userprofile['user_stafid']; ?>" />

                      <input name="MM_insert_pen" type="hidden" id="MM_insert_pen" value="formpen" />

<input name="button8" type="submit" class="submitbutton" id="button8" value="Tambah" />

                      <input name="button11" type="button" class="cancelbutton" id="button11" value="Batal" onClick="toggleview2('formpen'); return false;"></td>

                    </tr>

                  </table>

                </form>

              </li>

              </div>

              <?php }; ?>

              <li>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <?php if ($totalRows_userunit > 0) { // Show if recordset not empty ?>

    <tr>

      <th>Tarikh</th>

      <th width="50%" align="left" valign="middle">Unit / Cawangan / Pusat / Bahagian</th>

      <th width="50%" align="left" valign="middle">Lokasi</th>

      <th align="left" valign="middle">&nbsp;</th>

    </tr>

    <?php do { ?>

      <tr class="<?php if($row_userunit['userunit_status']=='1') echo "on"; else echo "offcourses";?>">

        <td nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_userunit['userunit_in_m'], $row_userunit['userunit_in_d'], $row_userunit['userunit_in_y'])); ?></td>

        <td><?php echo getFulldirectory($row_userunit['dir_id']); ?></td>

        <td><?php echo getLocation($row_userunit['location_id']); ?></td>

        <td><?php if($row_userunit['userunit_status']=='1'){?><ul class="func">

          <li><a onClick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo $row_userunit['userunit_in_d']; ?>/<?php echo $row_userunit['userunit_in_m']; ?>/<?php echo $row_userunit['userunit_in_y']; ?> - <?php echo getFulldirectory($row_userunit['dir_id']); ?>')" href="../sb/del_userunitadmin.php?delunit=<?php echo $row_userunit['userunit_id']; ?>&amp;id=<?php echo getID($row_userunit['user_stafid']); ?>">X</a></li></ul>

          <?php }; ?>

          </td>

      </tr>

      <?php } while ($row_userunit = mysql_fetch_assoc($userunit)); ?>

    <tr>

      <td colspan="4" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_userunit ?>  rekod dijumpai</td>

      </tr>

  <?php } else {?>

    <tr>

      <td colspan="4" align="center" valign="middle"  class="noline">Tiada rekod dijumpai</td>

      </tr>

    <?php }; ?>

  </table>

  </li>

  <li class="title">Tangga Gaji <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){ //&& checkKew8ByUserID($colname_userprofile)){?><span class="fr add" onClick="toggleview2('formtg'); return false;">+ Tambah</span><?php }; ?></li>

  <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){ //&& checkKew8ByUserID($colname_userprofile)){?>

  <div id="formtg" class="hidden">

  <li>

    <form id="formsalary" name="formsalary" method="post" action="<?php echo $url_main;?>sb/profile_admin.php?id=<?php echo $colname_userprofile;?>&url=edit">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td class="label">Rujukan Kew 8</td>

          <td>

          <select name="userkewe_id" id="userkewe_id">

          	<option value="0">Tiada</option>

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

          </select>

          </td>

        </tr>

        <tr>

          <td class="label">Tarikh</td>

          <td><select name="usersalaryskill_date_d" id="usersalaryskill_date_d">

            <?php for($i=1; $i<=31; $i++){?>

            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

            <?php }; ?>

          </select>

            <span class="inputlabel">/</span>

            <select name="usersalaryskill_date_m" id="usersalaryskill_date_m">

              <?php for($j=1; $j<=12; $j++){?>

              <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>

              <?php }; ?>

            </select>

            <span class="inputlabel">/</span>

            <input name="usersalaryskill_date_y" type="text" class="w10" id="usersalaryskill_date_y" value="<?php echo date('Y');?>" size="4" />

            </td>

        </tr>

        <tr>

          <td class="label">Tangga Gaji Baru</td>

          <td>

            <select name="usersalaryskill_code" id="usersalaryskill_code">

            <?php for($j=1; $j<=setSalarySkimP(); $j++){?>

              <option value="P<?php echo $j;?>">P<?php echo $j;?></option>

            <?php }; ?>

            </select>

            <select name="usersalaryskill_code2" id="usersalaryskill_code2">

              <option value="">Tiada</option>

              <option value="1">Max</option>

              

            </select></td>

        </tr>

        <tr>

          <td class="label">Gaji Pokok *</td>

          <td>

          <span id="gajipokok"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>

            <span class="inputlabel">RM</span>

            <input name="usersalaryskill_basicsalary" type="text" class="w50" id="usersalaryskill_basicsalary" />

            </span></td>

        </tr>

        <tr>

          <td class="label">Tarikh Kiraan Gaji</td>

          <td><select name="usersalaryskill_start_d" id="usersalaryskill_start_d">

            <?php for($i=1; $i<=31; $i++){?>

            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

            <?php }; ?>

          </select>

            <span class="inputlabel">/</span>

            <select name="usersalaryskill_start_m" id="usersalaryskill_start_m">

              <?php for($j=1; $j<=12; $j++){?>

              <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>

              <?php }; ?>

            </select>

            <span class="inputlabel">/</span>

            <input name="usersalaryskill_start_y" type="text" class="w10" id="usersalaryskill_start_y" value="<?php echo date('Y');?>" size="4" /></td>

        </tr>

        <tr>

          <td class="noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_userprofile['user_stafid']; ?>" />

            <span class="label noline">

            <input name="MM_insert_tg" type="hidden" id="MM_insert_tg" value="formtg" />

            </span></td>

          <td class="noline"><input name="button9" type="submit" class="submitbutton" id="button9" value="Tambah" />

            <input name="button10" type="button" class="cancelbutton" id="button10" value="Batal"  onclick="toggleview2('formtg'); return false;"/></td>

        </tr>

      </table>

    </form>

  </li>

  </div>

  <?php }; ?>

  <li>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <?php if ($totalRows_tg > 0) { // Show if recordset not empty ?>

    <tr>

      <th align="left" valign="middle">Tarikh</th>

      <th align="center" valign="middle" nowrap="nowrap">Tangga Gaji</th>

      <th width="100%" align="left" valign="middle" nowrap="nowrap">Gaji Pokok &nbsp; &bull; &nbsp; Rujukan Kew 8</th>

      <th align="left" valign="middle">&nbsp;</th>

    </tr>

    <?php do { ?>

      <tr class="<?php if($row_tg['usersalaryskill_status']=='1') echo "on"; else echo "offcourses";?>">

        <td nowrap="nowrap"><?php echo $row_tg['usersalaryskill_date_d']; ?>/<?php echo $row_tg['usersalaryskill_date_m']; ?>/<?php echo $row_tg['usersalaryskill_date_y']; ?> <span class="txt_color1"> &nbsp; &bull; &nbsp; <?php echo getBasicSalaryDateStartByUserID($row_tg['user_stafid'], $row_tg['usersalaryskill_id'], 0, 0, 0);?></span></td>

        <td align="center" nowrap="nowrap"><?php echo getSalarySkill($row_tg['user_stafid'], $row_tg['usersalaryskill_id'], date('m'), date('Y')); ?></td>

        <td align="left" nowrap="nowrap">RM <?php echo $row_tg['usersalaryskill_basicsalary']; ?><span class="txt_color1"> &nbsp; &bull; &nbsp; <?php echo getKew8SiriByID($row_tg['userkewe_id']); ?></span></td>

        <td align="left"><?php if($row_tg['usersalaryskill_status']=='1') {?><ul class="func">

          <li><a onClick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo $row_tg['usersalaryskill_date_d']; ?>/<?php echo $row_tg['usersalaryskill_date_m']; ?>/<?php echo $row_tg['usersalaryskill_date_y']; ?> - <?php echo $row_tg['usersalaryskill_code']; ?> <?php echo $row_tg['usersalaryskill_code2']; ?>')" href="../sb/del_usersalaryskilladmin.php?deltg=<?php echo $row_tg['usersalaryskill_id']; ?>&amp;id=<?php echo getID($row_tg['user_stafid']); ?>">X</a></li></ul>

        <?php }; ?></td>

      </tr>

      <?php } while ($row_tg = mysql_fetch_assoc($tg)); ?>

    <tr>

      <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_tg ?>  rekod dijumpai</td>

    </tr>

  <?php } else { ?>

    <tr>

      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>

    </tr>

  <?php }; ?>

  </table>

  </li>

  <li class="title">Emolumen <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){ //&& checkKew8ByUserID($colname_userprofile)){?><span class="fr add" onClick="toggleview2('formeml'); return false;">+ Tambah</span><?php }; ?></li>

  <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){ //&& checkKew8ByUserID($colname_userprofile)){?>

  <div id="formeml" class="hidden">

  <li>

    <form id="formeml" name="formeml" method="post" action="<?php echo $url_main;?>sb/profile_admin.php?id=<?php echo $colname_userprofile;?>&url=edit">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td class="label">Rujukan Kew 8</td>

          <td colspan="3">

          <select name="userkewe_id" id="userkewe_id">

          	<option value="0">Tiada</option>

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

          </select>

          </td>

        </tr>

        <tr>

          <td class="label">Tarikh</td>

          <td colspan="3"><select name="useremolumen_date_d" id="useremolumen_date_d">

            <?php for($i=1; $i<=31; $i++){?>

            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

            <?php }; ?>

          </select>

            <span class="inputlabel">/</span>

            <select name="useremolumen_date_m" id="useremolumen_date_m">

              <?php for($j=1; $j<=12; $j++){?>

              <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>

              <?php }; ?>

            </select>

            <span class="inputlabel">/</span>

            <input name="useremolumen_date_y" type="text" class="w25" id="useremolumen_date_y" value="<?php echo date('Y');?>" size="4" /></td>

        </tr>

        <tr>

          <td class="label">Tarikh Pembayaran</td>

          <td colspan="3"><select name="useremolumen_start_d" id="useremolumen_start_d">

            <?php for($i=1; $i<=31; $i++){?>

            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

            <?php }; ?>

          </select>

            <span class="inputlabel">/</span>

            <select name="useremolumen_start_m" id="useremolumen_start_m">

              <?php for($j=1; $j<=12; $j++){?>

              <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>

              <?php }; ?>

            </select>

            <span class="inputlabel">/</span>

            <input name="useremolumen_start_y" type="text" class="w25" id="useremolumen_start_y" value="<?php echo date('Y');?>" size="4" /></td>

        </tr>

        <tr>

          <td class="label">ITKA</td>

          <td><span class="inputlabel">RM</span><span id="itka">

            <input name="useremolumen_itka" type="text" class="w50" id="useremolumen_itka" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

          <td class="label">IT KRAI</td>

          <td><span class="inputlabel">RM</span><span id="itkrai">

            <input name="useremolumen_itkrai" type="text" class="w50" id="useremolumen_itkrai" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

</tr>

        <tr>

          <td class="label">ITP</td>

          <td><span class="inputlabel">RM</span><span id="itp">

            <input name="useremolumen_itp" type="text" class="w50" id="useremolumen_itp" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

          <td class="label">BSH</td>

          <td><span class="inputlabel">RM</span><span id="bsh">

            <input name="useremolumen_bsh" type="text" class="w50" id="textfield6" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

</tr>

        <tr>

          <td class="label">EL KTKL</td>

          <td><span class="inputlabel">RM</span><span id="elktkl">

            <input name="useremolumen_elktkl" type="text" class="w50" id="textfield7" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

          <td class="label">EL Pos Basik</td>

          <td><span class="inputlabel">RM</span><span id="elpksht">

            <input name="useremolumen_posbasik" type="text" class="w50" id="textfield8" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

</tr>

        <tr>

          <td class="label">EL PAKAR</td>

          <td><span class="inputlabel">RM</span><span id="elpakar">

            <input name="useremolumen_elpakar" type="text" class="w50" id="textfield9" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

          <td class="label">EL Insentif Khas</td>

          <td><span class="inputlabel">RM</span><span id="elmemangku">

            <input name="useremolumen_elinsentif" type="text" class="w50" id="textfield10" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

</tr>

        <tr>

          <td class="label">JUSA</td>

          <td><span class="inputlabel">RM</span><span id="jusa">

            <input name="useremolumen_jusa" type="text" class="w50" id="textfield11" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

          <td class="label">EL Pembantu Khas</td>

          <td><span class="inputlabel">RM</span><span id="elpemkhas">

            <input name="useremolumen_elpemkhas" type="text" class="w50" id="textfield12" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

</tr>

        <tr>

          <td class="label">EL Pembantu Rumah</td>

          <td><span class="inputlabel">RM</span><span id="elpemrmh">

            <input name="useremolumen_elpemrmh" type="text" class="w50" id="textfield13" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

          <td class="label">EL Bahasa</td>

          <td><span class="inputlabel">RM</span><span id="sprytextfield21">

            <input name="useremolumen_elbhs" type="text" class="w50" id="textfield14" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

</tr>

        <tr>

          <td class="label">Lain-lain</td>

          <td colspan="3"><span class="inputlabel">RM</span><span id="el_o">

            <input name="useremolumen_o" type="text" class="w50" id="useremolumen_o" />

            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>

</tr>

        <tr>

          <td class="noline">

            <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_userprofile['user_stafid']; ?>" />

            <input name="MM_insert_eml" type="hidden" id="MM_insert_eml" value="formeml" />

          </td>

          <td colspan="3" class="noline"><input name="button12" type="submit" class="submitbutton" id="button12" value="Tambah" />

            <input name="button13" type="button" class="cancelbutton" id="button13" value="Batal"  onclick="toggleview2('formeml'); return false;"/></td>

        </tr>

      </table>

    </form>

  </li>

  </div>

  <?php }; ?>

  <li>

  <div class="off">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <?php if ($totalRows_emo > 0) { // Show if recordset not empty ?>

<tr align="center" valign="middle">

            <th width="50%" align="left" valign="middle" nowrap="nowrap">Tarikh</th>

            <th nowrap="nowrap"> ITKA </th>

            <th nowrap="nowrap"> IT KRAI </th>

            <th nowrap="nowrap"> ITP </th>

            <th nowrap="nowrap"> BSH </th>

            <th nowrap="nowrap"> EL <br />

              KTKL </th>

            <th nowrap="nowrap"> EL <br />

              Pos Basik </th>

            <th nowrap="nowrap"> EL <br />

              PAKAR </th>

            <th nowrap="nowrap"> EL<br />

              Insentif Khas </th>

            <th nowrap="nowrap"> JUSA </th>

            <th nowrap="nowrap"> EL <br />

              Pembantu Khas </th>

            <th nowrap="nowrap"> EL <br />

              Pembantu Rumah </th>

            <th nowrap="nowrap"> EL <br />

              Bahasa </th>

            <th nowrap="nowrap"> Lain-lain </th>

            <th>&nbsp;</th>

        </tr>

          <?php do { ?>

          <tr class="<?php if($row_emo['useremolumen_status']=="1") echo "on"; else echo "offcourses";?>">

            <td nowrap="nowrap"><?php echo $row_emo['useremolumen_date_d']; ?>/<?php echo $row_emo['useremolumen_date_m']; ?>/<?php echo $row_emo['useremolumen_date_y']; ?> <span class="txt_color1">&nbsp; &bull; &nbsp; <?php echo $row_emo['useremolumen_start_d'];?>/<?php echo $row_emo['useremolumen_start_m'];?>/<?php echo $row_emo['useremolumen_start_y'];?> &nbsp &bull; &nbsp; <?php echo getKew8SiriByID($row_emo['userkewe_id']); ?></span></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_itka']=="") echo "0"; else echo $row_emo['useremolumen_itka']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_itkrai']=="") echo "0"; else echo $row_emo['useremolumen_itkrai']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_itp']=="") echo "0"; else echo $row_emo['useremolumen_itp']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_bsh']=="") echo "0"; else echo $row_emo['useremolumen_bsh']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_elktkl']=="") echo "0"; else echo $row_emo['useremolumen_elktkl']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_posbasik']=="") echo "0"; else echo $row_emo['useremolumen_posbasik']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_elpakar']=="") echo "0"; else echo $row_emo['useremolumen_elpakar']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_elinsentif']=="") echo "0"; else echo $row_emo['useremolumen_elinsentif']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_jusa']=="") echo "0"; else echo $row_emo['useremolumen_jusa']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_elpemkhas']=="") echo "0"; else echo $row_emo['useremolumen_elpemkhas']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_elpemrmh']=="") echo "0"; else echo $row_emo['useremolumen_elpemrmh']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_elbhs']=="") echo "0"; else echo $row_emo['useremolumen_elbhs']; ?></td>

            <td align="center" valign="middle"><?php if($row_emo['useremolumen_o']=="") echo "0"; else echo $row_emo['useremolumen_o']; ?></td>

            <td><?php if($row_emo['useremolumen_status']=="1"){?><ul class="func">

              <li><a onClick="return confirm('Anda mahu maklumat emolumen bertarikh <?php echo $row_emo['useremolumen_date_d']; ?>/<?php echo $row_emo['useremolumen_date_m']; ?>/<?php echo $row_emo['useremolumen_date_y']; ?> ?')" href="../sb/del_useremolumenadmin.php?delemo=<?php echo $row_emo['useremolumen_id']; ?>&amp;id=<?php echo getID($row_emo['user_stafid']); ?>">X</a></li></ul>

            <?php }; ?></td>

          </tr>

          <?php } while ($row_emo = mysql_fetch_assoc($emo)); ?>

          <tr>

            <td colspan="16" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_emo ?> rekod dijumpai</td>

          </tr>

      <?php } else { ?>

          <tr>

            <td colspan="16" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>

          </tr>

      <?php }; ?>

        </table>

        </div>

  </li>

    <li class="title">Maklumat Tambahan <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 3)){?><span class="fr add" onClick="toggleview('formetc','etc'); return false;">Kemaskini</span><?php }; ?></li>

    <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 3)){?>

    <div id="formetc" class="hidden">

    <li>

      <form id="formlain" name="formlain" method="POST" action="<?php echo $url_main;?>sb/profile_admin.php?id=<?php echo $colname_userprofile;?>&url=edit">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td class="label">No. KWSP</td>

            <td><input name="userjob_kwsp" type="text" class="in_upper" id="userjob_kwsp" value="<?php echo getKWSPByUserID($row_userprofile['user_stafid']); ?>" /></td>

            <td class="label">Tarikh Tamat</td>

            <td>

              <select name="userjob_kwsp_d" id="userjob_kwsp_d">

                <option value="0">0</option>

              <?php for($i=1; $i<=31; $i++){?>

                <option <?php if($i == $row_userjobdate['userjob_kwsp_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

              <?php }; ?>

              </select>

              <select name="userjob_kwsp_m" id="userjob_kwsp_m">

                <option value="0">0</option>

              <?php for($j=1; $j<=12; $j++){?>

                <option <?php if($j == $row_userjobdate['userjob_kwsp_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>

              <?php }; ?>

              </select>

              <select name="userjob_kwsp_y" id="userjob_kwsp_y">

                <option value="0">0</option>

              <?php for($k=2011; $k<=(date('Y')+5); $k++){?>

                <option <?php if($k == $row_userjobdate['userjob_kwsp_y']) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>

              <?php }; ?>

              </select>

              <div class="inputlabel2">0 sekiranya tiada penamatan</div>

            </td>

          </tr>

          <tr>

            <td class="label">No. PERKESO</td>

            <td><input name="userjob_perkeso" type="text" class="in_upper" id="userjob_perkeso" value="<?php echo getPERKESOByUserID($row_userprofile['user_stafid']); ?>" /></td>

            <td class="label">Tarikh Tamat</td>

            <td>

              <select name="userjob_perkeso_d" id="userjob_perkeso_d">

                <option value="0">0</option>

              <?php for($i=1; $i<=31; $i++){?>

                <option <?php if($i == $row_userjobdate['userjob_perkeso_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

              <?php }; ?>

              </select>

              <select name="userjob_perkeso_m" id="userjob_perkeso_m">

                <option value="0">0</option>

              <?php for($j=1; $j<=12; $j++){?>

                <option <?php if($j == $row_userjobdate['userjob_perkeso_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>

              <?php }; ?>

              </select>

              <select name="userjob_perkeso_y" id="userjob_perkeso_y">

                <option value="0">0</option>

              <?php for($k=2011; $k<=(date('Y')+5); $k++){?>

                <option <?php if($k == $row_userjobdate['userjob_perkeso_y']) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>

              <?php }; ?>

              </select>

              <div class="inputlabel2">0 sekiranya tiada penamatan</div>

            </td>

          </tr>

          <tr>

            <td class="label">No. LHDN</td>

            <td><input name="userjob_lhdn" type="text" class="in_upper" id="userjob_lhdn" value="<?php echo getLHDNByUserID($row_userprofile['user_stafid']); ?>" /></td>

            <td class="label">Tarikh Tamat</td>

            <td>

              <select name="userjob_lhdn_d" id="userjob_lhdn_d">

                <option value="0">0</option>

              <?php for($i=1; $i<=31; $i++){?>

                <option <?php if($i == $row_userjobdate['userjob_lhdn_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

              <?php }; ?>

              </select>

              <select name="userjob_lhdn_m" id="userjob_lhdn_m">

                <option value="0">0</option>

              <?php for($j=1; $j<=12; $j++){?>

                <option <?php if($j == $row_userjobdate['userjob_lhdn_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>

              <?php }; ?>

              </select>

              <select name="userjob_lhdn_y" id="userjob_lhdn_y">

                <option value="0">0</option>

              <?php for($k=2011; $k<=(date('Y')+5); $k++){?>

                <option <?php if($k == $row_userjobdate['userjob_lhdn_y']) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>

              <?php }; ?>

              </select>

              <div class="inputlabel2">0 sekiranya tiada penamatan</div>

            </td>

          </tr>

          <tr>

            <td class="label">Kelab ISN</td>

            <td><label for="userjob_club"></label>

              <select name="userjob_club" id="userjob_club">

                <option value="1" <?php if (!(strcmp(1, $row_userjobdate['userjob_club']))) {echo "selected=\"selected\"";} ?>>Ya</option>

                <option value="0" <?php if (!(strcmp(0, $row_userjobdate['userjob_club']))) {echo "selected=\"selected\"";} ?>>Tidak</option>

              </select></td>

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

                <option value="<?php echo $row_bank['bank_id']?>" <?php if (!(strcmp($row_bank['bank_id'], $row_userjobdate['bank_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_bank['bank_name']?></option>

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

            <td><input name="userjob_nobank" type="text" class="in_upper" id="userjob_nobank" value="<?php echo getAccBankByUserID($row_userprofile['user_stafid']); ?>" /></td>

          </tr>

          <tr>

            <td class="noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_userprofile['user_stafid']; ?>" />

              <input name="MM_update_lain" type="hidden" id="MM_update_lain" value="formlain" /></td>

            <td colspan="3" class="noline"><input name="button" type="submit" class="submitbutton" id="button" value="Kemaskini" />

              <input name="button2" type="button" class="cancelbutton" id="button2" value="Batal" onClick="toggleview('formetc','etc'); return false;" /></td>

          </tr>

        </table>

      </form>

    </li>

    </div>

    <?php }; ?>

    <div id="etc">

    <li>

    	<table width="100%" border="0" cellspacing="0" cellpadding="0">

    	  <tr>

    	    <td class="label">No. KWSP</td>

    	    <td><?php if(checkKWSPByUserID($row_userprofile['user_stafid']) && getJobtypeIDByUserID($row_userprofile['user_stafid'])!=1){ echo getKWSPByUserID($row_userprofile['user_stafid']); ?><?php } else echo "Tidak dinyatakan";?> <div class="inputlabel2"><?php echo getKWSPDateByStafID($row_userprofile['user_stafid']);?></div></td>

    	    <td class="label">No. PERKESO</td>

    	    <td><?php if(checkPERKESOByUserID($row_userprofile['user_stafid']) && getJobtypeIDByUserID($row_userprofile['user_stafid'])!=1){ echo getPERKESOByUserID($row_userprofile['user_stafid']); ?><?php } else echo "Tidak dinyatakan";?> <div class="inputlabel2"><?php echo getPERKESODateByStafID($row_userprofile['user_stafid']);?></div></td>

    	    </tr>

    	  <tr>

    	    <td class="label">No. LHDN</td>

    	    <td><?php if(checkLHDNByUserID($row_userprofile['user_stafid']) && getJobtypeIDByUserID($row_userprofile['user_stafid'])!=1){ echo getLHDNByUserID($row_userprofile['user_stafid']); ?><?php } else echo "Tidak dinyatakan";?> <div class="inputlabel2"><?php echo getLHDNDateByStafID($row_userprofile['user_stafid']);?></div></td>

    	    <td class="label">Kelab ISN</td>

    	    <td><?php if(checkKelabMSNRM($row_userprofile['user_stafid'])) echo "Ya"; else echo "Tidak"; ?></td>

    	    </tr>

    	  <tr>

    	    <td class="label noline">Bank</td>

    	    <td class="noline"><?php if(checkBankByUserID($row_userprofile['user_stafid'])) echo getBankNameByUserID($row_userprofile['user_stafid']); else echo "Tidak dinyatakan"; ?></td>

    	    <td class="label noline">No. Akaun Bank</td>

    	    <td class="noline"><?php if(checkAccBankByUserID($row_userprofile['user_stafid'])) echo getAccBankByUserID($row_userprofile['user_stafid']); else echo "Tidak dinyatakan"; ?></td>

    	    </tr>

  	  </table>

    </li>

    </div>

    <li class="title">Maklumat Pencen <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 3)){?><span class="fr add" onClick="toggleview('formpencen','pencen'); return false;">Kemaskini</span><?php }; ?></li>

    <div id="formpencen" class="hidden">

    <li>

      <form id="form1" name="form1" method="post" action="../sb/add_pencen.php">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td nowrap="nowrap" class="label">Tarikh Pencen</td>

            <td width="100%">

            <input name="pencen" type="hidden" value="<?php if(checkPencenByUserID($colname_userprofile)) echo '1'; else echo '0';?>" />

            <input name="id" type="hidden" id="id" value="<?php echo $colname_userprofile;?>" />

              <select name="d" id="d">

              <?php for($pi=1; $pi<=31; $pi++){?>

              <?php if($pi<10) $pi = '0' . $pi;?>

                <option value="<?php echo $pi;?>"><?php echo $pi;?></option>

              <?php }; ?>

              </select>

              <select name="m" id="m">

              <?php for($pj=1; $pj<=12; $pj++){?>

              <?php if($pj<10) $pj = '0' . $pj;?>

                <option value="<?php echo $pj;?>"><?php echo date('M', mktime(0, 0, 0, $pj, 1, date('Y')));?></option>

              <?php }; ?>

              </select>

              <select name="y" id="y">

              <?php for($pk=(date('Y')-10); $pk<=date('Y'); $pk++){?>

                <option value="<?php echo $pk;?>"><?php echo $pk;?></option>

              <?php }; ?>

              </select>

              <input name="button14" type="submit" class="submitbutton" id="button14" value="Kemaskini" /></td>

          </tr>

        </table>

      </form>

    

    </li>

    </div>

    <div id="pencen">

    <li>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <?php if(checkPencenByUserID($colname_userprofile)){?>

        <tr>

          <td class="label">Tarikh Pencen</td>

          <td>

          <div><?php echo getPencenDateByUserID($colname_userprofile,0);?></div>

          <div class="inputlabel2">Kiraan KWSP kepada peratusan Pencen akan diambil kira bermula dari tarikh yang dinyatakan.</div>

          </td>

        </tr>

        <?php } else { ?>

        <tr>

          <td colspan="2" align="center" valign="middle">Tiada rekod dijumpai</td>

          </tr>

        <?php }; ?>

      </table>

    </li>

    </div>

    <li class="title">Pengaktifan Akaun <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 3)){?><span class="fr add" onClick="toggleview('formaktif','aktif'); return false;">Kemaskini</span><?php }; ?></li>

    <div id="formaktif" class="hidden">

    <li>

    <form id="status" name="status" method="POST" action="<?php echo $url_main;?>sb/profile_admin.php?id=<?php echo $colname_userprofile;?>&url=edit">

            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">

            	      <tr>

            	        <td nowrap="nowrap" class="label noline">Status</td>

            	        <td nowrap="nowrap" class="noline"><label for="login_status">

            	          <input name="MM_update_status" type="hidden" id="MM_update_status" value="formstatus" />

            	        </label>

            	          <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_userprofile['user_stafid']; ?>" />

                          <select name="login_status" id="login_status">

            	            <?php if(!getStatusByStafID($row_userprofile['user_stafid'])){?>

                            	<option value="1">Aktif</option>

                            <?php } else { ?>

            	            	<option value="0">Tidak Aktif</option>

                            <?php }; ?>

          	              </select>

                        </td>

            	        <td nowrap="nowrap" class="label noline">Tarikh</td>

            	        <td width="100%" nowrap="nowrap" class="noline">

                          <select name="login_date_d" id="login_date_d">

                            <?php for($i=1; $i<=31; $i++){?>

                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>

                            <?php }; ?>

                            </select>

                          <span class="inputlabel">/</span>

                          <select name="login_date_m" id="login_date_m">

                            <?php for($j=1; $j<=12; $j++){?>

                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m F", mktime(0, 0, 0, $j, 1, 2000));?></option>

                            <?php }; ?>

                            </select>

                            <span class="inputlabel">/</span>

                            <input name="login_date_y" type="text" class="w25" id="login_date_y" value="<?php echo date('Y');?>" size="4" /></td>

            	        <td class="noline"><input name="button15" type="submit" class="submitbutton" id="button15" value="Kemaskini" /></td>

          	        </tr>

          	      </table>

            	  </form>

    </li>

    </div>

    <div id="aktif">

    <li>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td class="label">Status</td>

          <td ><?php if(getStatusByStafID($row_userprofile['user_stafid'])) echo "Aktif"; else echo "Tidak Aktif";?> </td>

        </tr>

        <?php if(!getStatusByStafID($row_userprofile['user_stafid'])){?>

        <tr>

          <td class="label noline">Tarikh</td>

          <td class="noline"><?php echo getStatusDateByStafID($row_userprofile['user_stafid']);?></td>

        </tr>

        <?php }; ?>

      </table>

    </li>

    </div>

            </ul>

              <?php } else { ?>

            <ul>

            	<li>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>

                  </tr>

                </table>

                </li>

            </ul>

            <?php }; ?>

          </div>

        </div>

        </div>

        

		<?php include('../inc/footer.php');?>

    </div>

</div>

<?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?>

<script type="text/javascript">

var sprytextfield3 = new Spry.Widget.ValidationTextField("firstname");

var sprytextfield4 = new Spry.Widget.ValidationTextField("lastname");

var sprytextfield9 = new Spry.Widget.ValidationTextField("dob_year", "integer");

var sprytextfield1 = new Spry.Widget.ValidationTextField("userstafid");

var sprytextfield22 = new Spry.Widget.ValidationTextField("el_o", "currency", {isRequired:false, hint:"0"});

var sprytextfield21 = new Spry.Widget.ValidationTextField("sprytextfield21", "currency", {hint:"0", isRequired:false});

var sprytextfield20 = new Spry.Widget.ValidationTextField("elpemrmh", "currency", {isRequired:false, hint:"0"});

var sprytextfield19 = new Spry.Widget.ValidationTextField("elpemkhas", "currency", {isRequired:false, hint:"0"});

var sprytextfield18 = new Spry.Widget.ValidationTextField("jusa", "currency", {isRequired:false, hint:"0"});

var sprytextfield17 = new Spry.Widget.ValidationTextField("elmemangku", "currency", {isRequired:false, hint:"0"});

var sprytextfield16 = new Spry.Widget.ValidationTextField("elpakar", "currency", {isRequired:false, hint:"0"});

var sprytextfield15 = new Spry.Widget.ValidationTextField("elpksht", "currency", {isRequired:false, hint:"0"});

var sprytextfield14 = new Spry.Widget.ValidationTextField("elktkl", "currency", {isRequired:false, hint:"0"});

var sprytextfield13 = new Spry.Widget.ValidationTextField("bsh", "currency", {isRequired:false, hint:"0"});

var sprytextfield6 = new Spry.Widget.ValidationTextField("itp", "currency", {isRequired:false, hint:"0"});

var sprytextfield5 = new Spry.Widget.ValidationTextField("itkrai", "currency", {isRequired:false, hint:"0"});

var sprytextfield2 = new Spry.Widget.ValidationTextField("itka", "currency", {isRequired:false, hint:"0"});

var sprytextfield10 = new Spry.Widget.ValidationTextField("gajipokok", "none");

var spryselect1 = new Spry.Widget.ValidationSelect("jwtkla");

var spryselect2 = new Spry.Widget.ValidationSelect("jwtskim");

var spryselect3 = new Spry.Widget.ValidationSelect("jwtgred");

</script>

<?php }; ?>

</body>

</html>

<?php


mysql_free_result($dsg);


mysql_free_result($userprofile);


mysql_free_result($sch);


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


mysql_free_result($j2);


mysql_free_result($lt);


mysql_free_result($tit);


mysql_free_result($userjobdate);




mysql_free_result($userunit);


mysql_free_result($userjob2);


mysql_free_result($cuti);


mysql_free_result($emo);


mysql_free_result($tg);


mysql_free_result($kewelist);

?>

<?php include('../inc/footinc.php');?>

