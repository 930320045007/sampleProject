<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='2';?>
<?php $menu2='1';?>
<?php
$colname_user_personal = "-1";
if (isset($_SESSION['user_stafid'])) {
  $colname_user_personal = $_SESSION['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_personal = sprintf("SELECT * FROM www.user_personal WHERE user_stafid = %s ORDER BY userpersonal_id DESC", GetSQLValueString($colname_user_personal, "text"));
$user_personal = mysql_query($query_user_personal, $hrmsdb) or die(mysql_error());
$row_user_personal = mysql_fetch_assoc($user_personal);
$totalRows_user_personal = mysql_num_rows($user_personal);

mysql_free_result($user_personal);

$colname_user_ec = "-1";
if (isset($_SESSION['user_stafid'])) {
  $colname_user_ec = $_SESSION['user_stafid'];
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_ec = sprintf("SELECT * FROM www.user_ec WHERE user_stafid = %s ORDER BY userec_name ASC", GetSQLValueString($colname_user_ec, "text"));
$user_ec = mysql_query($query_user_ec, $hrmsdb) or die(mysql_error());
$row_user_ec = mysql_fetch_assoc($user_ec);
$totalRows_user_ec = mysql_num_rows($user_ec);

mysql_free_result($user_ec);

$colname_user_dependents = "-1";
if (isset($_SESSION['user_stafid'])) {
  $colname_user_dependents = $_SESSION['user_stafid'];
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_dependents = sprintf("SELECT * FROM www.user_dependents WHERE user_stafid = %s ORDER BY userdependents_relation ASC", GetSQLValueString($colname_user_dependents, "text"));
$user_dependents = mysql_query($query_user_dependents, $hrmsdb) or die(mysql_error());
$row_user_dependents = mysql_fetch_assoc($user_dependents);
$totalRows_user_dependents = mysql_num_rows($user_dependents);

mysql_free_result($user_dependents);

$colname_user_exwork = "-1";
if (isset($_SESSION['user_stafid'])) {
  $colname_user_exwork = $_SESSION['user_stafid'];
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_exwork = sprintf("SELECT * FROM www.user_exwork WHERE user_stafid = %s ORDER BY userexwork_startdate ASC", GetSQLValueString($colname_user_exwork, "text"));
$user_exwork = mysql_query($query_user_exwork, $hrmsdb) or die(mysql_error());
$row_user_exwork = mysql_fetch_assoc($user_exwork);
$totalRows_user_exwork = mysql_num_rows($user_exwork);

mysql_free_result($user_exwork);

$colname_user_edu = "-1";

if (isset($_SESSION['user_stafid'])) {
  $colname_user_edu = $_SESSION['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_edu = sprintf("SELECT * FROM www.user_edu WHERE user_stafid = %s ORDER BY useredu_year ASC", GetSQLValueString($colname_user_edu, "text"));
$user_edu = mysql_query($query_user_edu, $hrmsdb) or die(mysql_error());
$row_user_edu = mysql_fetch_assoc($user_edu);
$totalRows_user_edu = mysql_num_rows($user_edu);

mysql_free_result($user_edu);

$colname_user_passport = "-1";
if (isset($_SESSION['user_stafid'])) {
  $colname_user_passport = $_SESSION['user_stafid'];
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_passport = sprintf("SELECT * FROM www.user_passport WHERE user_stafid = %s ORDER BY userpassport_id DESC", GetSQLValueString($colname_user_passport, "text"));
$user_passport = mysql_query($query_user_passport, $hrmsdb) or die(mysql_error());
$row_user_passport = mysql_fetch_assoc($user_passport);
$totalRows_user_passport = mysql_num_rows($user_passport);

mysql_free_result($user_passport);

$colname_user_med = "-1";
if (isset($_SESSION['user_stafid'])) {
  $colname_user_med = $_SESSION['user_stafid'];
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_med = sprintf("SELECT * FROM www.user_med WHERE user_stafid = %s ORDER BY usermed_id DESC", GetSQLValueString($colname_user_med, "text"));
$user_med = mysql_query($query_user_med, $hrmsdb) or die(mysql_error());
$row_user_med = mysql_fetch_assoc($user_med);
$totalRows_user_med = mysql_num_rows($user_med);

mysql_free_result($user_med);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_relationship = "SELECT * FROM www.relationship ORDER BY relationship_name ASC";
$relationship = mysql_query($query_relationship, $hrmsdb) or die(mysql_error());
$row_relationship = mysql_fetch_assoc($relationship);
$totalRows_relationship = mysql_num_rows($relationship);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_edu_level = "SELECT * FROM www.edu_level ORDER BY edulevel_id ASC";
$edu_level = mysql_query($query_edu_level, $hrmsdb) or die(mysql_error());
$row_edu_level = mysql_fetch_assoc($edu_level);
$totalRows_edu_level = mysql_num_rows($edu_level);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_state = "SELECT * FROM www.state ORDER BY state_name ASC";
$state = mysql_query($query_state, $hrmsdb) or die(mysql_error());
$row_state = mysql_fetch_assoc($state);
$totalRows_state = mysql_num_rows($state);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_state2 = "SELECT * FROM www.state ORDER BY state_name ASC";
$state2 = mysql_query($query_state2, $hrmsdb) or die(mysql_error());
$row_state2 = mysql_fetch_assoc($state2);
$totalRows_state2 = mysql_num_rows($state2);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_countrylist = "SELECT * FROM www.countrylist ORDER BY Name ASC";
$countrylist = mysql_query($query_countrylist, $hrmsdb) or die(mysql_error());
$row_countrylist = mysql_fetch_assoc($countrylist);
$totalRows_countrylist = mysql_num_rows($countrylist);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_marital = "SELECT * FROM www.marital ORDER BY marital_name ASC";
$marital = mysql_query($query_marital, $hrmsdb) or die(mysql_error());
$row_marital = mysql_fetch_assoc($marital);
$totalRows_marital = mysql_num_rows($marital);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_employertype = "SELECT * FROM www.employer_type ORDER BY employertype_id ASC";
$employertype = mysql_query($query_employertype, $hrmsdb) or die(mysql_error());
$row_employertype = mysql_fetch_assoc($employertype);
$totalRows_employertype = mysql_num_rows($employertype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sponsor = "SELECT * FROM www.sponsor ORDER BY sponsor_name ASC";
$sponsor = mysql_query($query_sponsor, $hrmsdb) or die(mysql_error());
$row_sponsor = mysql_fetch_assoc($sponsor);
$totalRows_sponsor = mysql_num_rows($sponsor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<script src="js/ajaxsbmt.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<?php include('inc/headinc.php');?>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('inc/bodyinc.php');?>>
<div>
	<div>
	  <?php include('inc/header.php');?>
      <?php include('inc/menu.php');?>
        
      	<div class="content">
		<?php include('inc/menu_profail.php');?>
        <div class="tabbox">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="100%" align="right" valign="middle">
                        <input name="button5" type="button" class="submitbutton" id="button5" value="Cetak" onclick="MM_openBrWindow('<?php echo $url_main;?>printprofile.php?id=<?php echo $row_user['user_stafid'];?>','profile','status=yes,scrollbars=yes,width=800,height=600')" /></td>
                        </tr>
                        </table>
        <?php include('inc/profile.php');?>
        <div class="profilemenu">
        	<ul>
            	<li class="title">Maklumat Peribadi <?php if(!$maintenance){?><span class="fr add" onclick="toggleview('formprofile','profile'); return false;">Kemaskini</span><?php }; ?></li>
                <?php if(!$maintenance){?>
                <div id="formprofile" class="hidden">
                <li>
                	  <form id="personal" name="personal" method="POST" action="sb/update_personal.php">
                	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	      <tr>
                	        <td class="label">Alamat Terkini *</td>
                	        <td colspan="3">
                            <div class="inputlabel2">Sila masukkan alamat terkini dalam ruang * terlebih dahulu.</div>
               	            <div>
                             <input name="userpersonal_address" autofocus="autofocus" required="required" type="text" id="userpersonal_address" value="<?php echo $row_user_personal['userpersonal_address']; ?>" size="50" maxlength="100" /><span class="inputlabel">*</span>
                            </div>
                            <div>
               	            <input name="userpersonal_address2" type="text" id="userpersonal_address2" value="<?php echo $row_user_personal['userpersonal_address2']; ?>" size="50" maxlength="100" />
                            </div>
                            <div>
               	            <input name="userpersonal_address3" type="text" id="userpersonal_address3" value="<?php echo $row_user_personal['userpersonal_address3']; ?>" size="50" maxlength="100" />
                            </div>
                            </td>
              	        </tr>
                	      <tr>
                	        <td class="label">Poskod *</td>
                	        <td><input name="userpersonal_zip" type="text" class="w50" id="textfield" value="<?php echo $row_user_personal['userpersonal_zip']; ?>" size="5" maxlength="5" /><div class="inputlabel2">Cth: 57000</div></td>
                	        <td class="label">Bandar *</td>
                	        <td><input name="userpersonal_city" class="in_cappitalize" type="text" id="textfield2" value="<?php echo $row_user_personal['userpersonal_city']; ?>" /></td>
              	        </tr>
                	      <tr>
                	        <td class="label">Negeri</td>
                	        <td>
                            <select name="userpersonal_state" id="userpersonal_state">
                	          <?php
								do {  
								?>
                	          <option value="<?php echo $row_state['state_id']?>"<?php if (!(strcmp($row_state['state_id'], $row_user_personal['userpersonal_state']))) {echo "selected=\"selected\"";} ?>><?php echo $row_state['state_name']?></option>
                	          <?php
								} while ($row_state = mysql_fetch_assoc($state));
								  $rows = mysql_num_rows($state);
								  if($rows > 0) {
									  mysql_data_seek($state, 0);
									  $row_state = mysql_fetch_assoc($state);
								  }
								?>
                            </select>
                            </td>
                	        <td class="label">Negeri Kelahiran</td>
                	        <td><select name="userpersonal_dob_state" id="userpersonal_dob_state">
                	          <?php
								do {  
								?>
                	          <option value="<?php echo $row_state2['state_id']?>"<?php if (!(strcmp($row_state2['state_id'], $row_user_personal['userpersonal_dob_state']))) {echo "selected=\"selected\"";} ?>><?php echo $row_state2['state_name']?></option>
                	          <?php
								} while ($row_state2 = mysql_fetch_assoc($state2));
								  $rows = mysql_num_rows($state2);
								  if($rows > 0) {
									  mysql_data_seek($state2, 0);
									  $row_state2 = mysql_fetch_assoc($state2);
								  }
								?>
              	          </select></td>
              	        </tr>
                	      <tr>
                	        <td class="label">No. Telefon (Rumah)</td>
                	        <td><span id="telr"><span class="textfieldInvalidFormatMsg">Format salah.</span>
                            <input name="userpersonal_telh" type="text" id="userpersonal_telh" value="<?php echo $row_user_personal['userpersonal_telh']; ?>" maxlength="12" />
</span>                	          
               	            <div class="inputlabel2">Cth: 0389929915</div></td>
                	        <td class="label">No. Telefon (Mobile) *</td>
                	        <td><input name="userpersonal_telm" required="required" type="text" id="userpersonal_telm" value="<?php echo $row_user_personal['userpersonal_telm']; ?>" maxlength="12" /><div class="inputlabel2">Cth: 01389929915</div></td>
              	        </tr>
                	      <tr>
                	        <td class="label">No. Telefon (MSN Ext)</td>
                	        <td><input name="userpersonal_telw" type="text" id="userpersonal_telw" value="<?php echo $row_user_personal['userpersonal_telw']; ?>" maxlength="4" /><div class="inputlabel2">Cth: 9915</div></td>
                	        <td class="label">No. Telefon (Lain)</td>
                	        <td><input name="userpersonal_telo" type="text" id="userpersonal_telo" value="<?php echo $row_user_personal['userpersonal_telo']; ?>" maxlength="12" /><div class="inputlabel2">Cth: 0389929915</div></td>
              	        </tr>
                	      <tr>
                	        <td class="label">Email (Lain)</td>
                	        <td><span id="emailo"><span class="textfieldInvalidFormatMsg">Format salah.</span>
                            <input name="userpersonal_emailo" class="in_lower" type="text" id="userpersonal_emailo" value="<?php echo $row_user_personal['userpersonal_emailo']; ?>" />
</span>                	          
               	            <div class="inputlabel2">Cth: user@email.com</div></td>
                	        <td class="label">&nbsp;</td>
                	        <td>&nbsp;</td>
              	        </tr>
                	      <tr>
                	        <td class="label">No. Lesen</td>
                	        <td><input name="userpersonal_license" type="text" class="in_upper" id="userpersonal_license" value="<?php echo $row_user_personal['userpersonal_license']; ?>" /></td>
                	        <td class="label">Jenis Lesen</td>
                	        <td><input name="userpersonal_licensetype" class="in_upper" type="text" id="userpersonal_licensetype" value="<?php echo $row_user_personal['userpersonal_licensetype']; ?>" /><div class="inputlabel2">Cth: B2, D</div></td>
              	        </tr>
                	      <tr>
                	        <td class="label">Size Baju</td>
                	        <td><span class="label">
                	          <select name="userpersonal_size" id="userpersonal_size">
                	            <option value="XS" <?php if (!(strcmp("XS", $row_user_personal['userpersonal_size']))) {echo "selected=\"selected\"";} ?>>XS</option>
                	            <option value="S" <?php if (!(strcmp("S", $row_user_personal['userpersonal_size']))) {echo "selected=\"selected\"";} ?>>S</option>
                	            <option value="M" <?php if (!(strcmp("M", $row_user_personal['userpersonal_size']))) {echo "selected=\"selected\"";} ?>>M</option>
                	            <option value="L" <?php if (!(strcmp("L", $row_user_personal['userpersonal_size']))) {echo "selected=\"selected\"";} ?>>L</option>
                	            <option value="XL" <?php if (!(strcmp("XL", $row_user_personal['userpersonal_size']))) {echo "selected=\"selected\"";} ?>>XL</option>
                	            <option value="XXL" <?php if (!(strcmp("XXL", $row_user_personal['userpersonal_size']))) {echo "selected=\"selected\"";} ?>>XXL</option>
                	            <option value="XXXL" <?php if (!(strcmp("XXXL", $row_user_personal['userpersonal_size']))) {echo "selected=\"selected\"";} ?>>XXXL</option>
                              <option value="XXXL" <?php if (!(strcmp("XXXL", $row_user_personal['userpersonal_size']))) {echo "selected=\"selected\"";} ?>>4XL</option>
              	            </select>
                	        </span></td>
                	        <td class="label">Status Perkahwinan</td>
                	        <td><select name="userpersonal_marital" id="userpersonal_marital">
                	          <?php
								do {  
								?>
                	          <option value="<?php echo $row_marital['marital_id']?>"<?php if (!(strcmp($row_marital['marital_id'], $row_user_personal['userpersonal_marital']))) {echo "selected=\"selected\"";} ?>><?php echo $row_marital['marital_name']?></option>
                	          <?php
								} while ($row_marital = mysql_fetch_assoc($marital));
								  $rows = mysql_num_rows($marital);
								  if($rows > 0) {
									  mysql_data_seek($marital, 0);
									  $row_marital = mysql_fetch_assoc($marital);
								  }
								?>
                            </select></td>
              	        </tr>
                	      <tr>
                	        <td class="noline"><input name="userpersonal_by" type="hidden" id="userpersonal_by" value="<?php echo $_SESSION['user_stafid'];?>" />
               	            <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid']; ?>" />
                	    <input type="hidden" name="MM_update" value="personal" /></td>
                	        <td colspan="3" class="noline"><input name="button" type="submit"  class="submitbutton" id="button" value="Kemaskini" /><input name="button" type="button" class="cancelbutton" id="button" value="Batal" onclick="toggleview('formprofile','profile'); return false;" /></td>
               	          </tr>
              	        </table>
                      </form>
                      </li>
                	</div>
                    <?php }; ?>
                  <div id="profile">
                  <li class="gap">&nbsp;</li> 
                  <li>
                  <?php include('view/personal.php');?>
                  <a name="med2" id="ec3"></a>
                  </li>
                  <li class="gap">&nbsp;</li> 
                  </div>
                  <li class="title">Maklumat Perubatan <?php if(!$maintenance){?><span class="fr add" onclick="toggleview('formperubatan','perubatan'); return false;">Kemaskini</span><?php }; ?></li>
                  <?php if(!$maintenance){?>
                  <div id="formperubatan" class="hidden">
                  <li>
                    <form id="med" name="med" method="POST" action="sb/update_med.php">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="label">Jenis Darah</td>
                          <td><select name="usermed_blood" id="usermed_blood">
                            <option value="A" <?php if (!(strcmp("A", $row_user_med['usermed_blood']))) {echo "selected=\"selected\"";} ?>>A</option>
                            <option value="B" <?php if (!(strcmp("B", $row_user_med['usermed_blood']))) {echo "selected=\"selected\"";} ?>>B</option>
                            <option value="AB" <?php if (!(strcmp("AB", $row_user_med['usermed_blood']))) {echo "selected=\"selected\"";} ?>>AB</option>
                            <option value="O" <?php if (!(strcmp("O", $row_user_med['usermed_blood']))) {echo "selected=\"selected\"";} ?>>O</option>
                          </select></td>
                          <td class="label">&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td class="label">Tinggi (cm) *</td>
                          <td><span id="med_height"><span class="textfieldRequiredMsg">Maklumat diperlukan</span><span class="textfieldInvalidFormatMsg">Sila pastikan format dimasukkan dengan betul.</span>
                          <input name="usermed_height" required="required" type="number" id="usermed_height" value="<?php echo $row_user_med['usermed_height']; ?>" />
                          </span>               	          
                            <div class="inputlabel2">Cth: 160</div>
                          </td>
                          <td class="label">Berat (kg) *</td>
                          <td><span id="med_weight"><span class="textfieldRequiredMsg">Maklumat diperlukan</span><span class="textfieldInvalidFormatMsg">Sila pastikan format dimasukkan dengan betul.</span>
                          <input name="usermed_weight" required="required" type="number" id="usermed_weight" value="<?php echo $row_user_med['usermed_weight']; ?>" />
                          </span>               	          
                            <div class="inputlabel2">Cth: 55</div>
                          </td>
                        </tr>
                        <tr>
                          <td class="label">Kecacatan</td>
                          <td colspan="3"><textarea name="usermed_disable" id="usermed_disable" rows="5"><?php echo $row_user_med['usermed_disable']; ?></textarea><div class="inputlabel2">Biarkan kosong jika tiada kecacatan</div></td>
                        </tr>
                        <tr>
                          <td class="label">Alahan</td>
                          <td colspan="3"><textarea name="usermed_allergic" id="usermed_allergic" rows="5"><?php echo $row_user_med['usermed_allergic']; ?></textarea><div class="inputlabel2">Biarkan kosong jika tiada alahan</div></td>
                        </tr>
                        <tr>
                          <td class="label">Penyakit Kritikal</td>
                          <td colspan="3"><textarea name="usermed_disease" id="usermed_doctor" rows="5"><?php echo $row_user_med['usermed_doctor']; ?></textarea><div class="inputlabel2">Biarkan kosong jika tiada penyakit kritikal</div></td>
                        </tr>
                        <tr>
                          <td class="label">Maklumat Rawatan</td>
                          <td colspan="3"><textarea name="usermed_doctor" id="usermed_disease" rows="5"><?php echo $row_user_med['usermed_disease']; ?></textarea>
                          <div class="inputlabel2">Alamat Hospital, No. Telefon Doktor Rujukan dan sebagainya yang berkaitan</div></td>
                        </tr>
                        <tr>
                          <td class="label">Tarikh Rawatan</td>
                          <td colspan="3"><span id="tarikhrawatan"><span class="textfieldInvalidFormatMsg">Format salah.</span>
                          <input name="usermed_datetreatment" class="w25" id="usermed_datetreatment" value="<?php echo $row_user_med['usermed_datetreatment']; ?>" maxlength="10"/>
  </span>               	          
                          <div class="inputlabel2">dd/mm/yyy. Cth: 12/03/2010</div></td>
                        </tr>
                        <tr>
                          <td class="label noline"><span class="noline">
                            <input type="hidden" name="user_stafid" id="user_stafid" value="<?php echo $_SESSION['user_stafid'];?>" />
                            <input name="usermed_by" type="hidden" id="usermed_by" value="<?php echo $_SESSION['user_stafid']; ?>" />
                            <input name="usermed_date" type="hidden" id="usermed_date" value="<?php echo date('d/m/Y');?>" />
                          </span></td>
                          <td colspan="3" class="noline"><input name="button2" type="submit" class="submitbutton" id="button2"  value="Kemaskini" />
                          <input name="button3" type="button" class="cancelbutton" id="button3" value="Batal"  onclick="toggleview('formperubatan','perubatan'); return false;" /></td>
                        </tr>
                      </table>
                      <input type="hidden" name="MM_update" value="med" />
                    </form>
                    </li>
                  </div>
                  <?php }; ?>
                  <div id="perubatan">
                  <li class="gap">&nbsp;</li> 
                  <li>
					<?php include('view/med.php');?>
                	<a name="ec2" id="ec2"></a>
                </li>
                <li class="gap">&nbsp;</li> 
                </div>
          		<li class="title">Waris / Rujukan Kecemasan <?php if(!$maintenance){?><span class="fr add" onclick="toggleview2('formkecemasan'); return false;">+ Tambah</span><?php }; ?></li>
                <?php if(!$maintenance){?>
                <div id="formkecemasan" class="hidden">
                <li>
               	  <form id="ec" name="ec" method="POST" action="sb/add_ec.php">
               	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
               	      <tr>
               	        <td class="label">Nama *</td>
               	        <td colspan="3"><span id="ec_name"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>
               	          <input type="text" name="userec_name" id="userec_name" class="in_cappitalize" />
           	            </span></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Hubungan</td>
               	        <td colspan="3"><select name="userec_relation" id="userec_relation">
               	          <?php
							do {  
							?>
               	          <option value="<?php echo $row_relationship['relationship_id']?>"><?php echo $row_relationship['relationship_name']?></option>
               	          <?php
							} while ($row_relationship = mysql_fetch_assoc($relationship));
							  $rows = mysql_num_rows($relationship);
							  if($rows > 0) {
								  mysql_data_seek($relationship, 0);
								  $row_relationship = mysql_fetch_assoc($relationship);
							  }
							?>
                        </select></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Alamat</td>
               	        <td colspan="3">
                        <textarea name="userrec_address" id="userrec_address" cols="45" rows="5"></textarea>
                        <div class="inputlabel2">Untuk maklumat Suami / Isteri, sila masukkan alamat pejabat.</div>
                        </td>
           	          </tr>
                      <tr>
               	        <td class="label">No. Kad Pengenalan</td>
               	        <td><input name="userec_noic" type="text" id="userec_noic" maxlength="12" /><div class="inputlabel2">Tanpa simbol '-'. Cth: 881203065595</div></td>
               	        <td class="label">&nbsp;</td>
               	        <td>&nbsp;</td>
           	          </tr>
               	      <tr>
               	        <td class="label">No. Telefon (Rumah)</td>
               	        <td><input name="userec_telh" type="text" id="userec_telh" maxlength="12" /><div class="inputlabel2">Cth: 0389929915</div></td>
               	        <td class="label">No. Telefon (Mobile)</td>
               	        <td><input name="userec_telm" type="text" id="userec_telm" maxlength="12" /><div class="inputlabel2">Cth: 01389929915</div></td>
           	          </tr>
               	      <tr>
               	        <td class="label">No. Telefon (Pejabat)</td>
               	        <td><input name="userec_telw" type="text" id="userec_telw" maxlength="12" /><div class="inputlabel2">Cth: 0389929915</div></td>
               	        <td class="label">&nbsp;</td>
               	        <td>&nbsp;</td>
           	          </tr>
               	      <tr>
               	        <td class="noline">
                        <input type="hidden" name="userec_by" id="userec_by" value="<?php echo $_SESSION['user_stafid']; ?>" />
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid']; ?>" /></td>
               	        <td colspan="3" class="noline">
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal"  onclick="toggleview2('formkecemasan'); return false;" />
                        </td>
           	          </tr>
           	        </table>
               	    <input type="hidden" name="MM_insert" value="ec" />
                  </form>
                  </li>
                </div>
                <?php }; ?>
                <div id="kecemasan">
                <li class="gap">&nbsp;</li> 
                <li>
                	<?php include('view/ec.php');?>
                	<a name="dep2" id="dep2"></a>
                </li>
                <li class="gap">&nbsp;</li>
                </div>
                <li class="title">Maklumat Keluarga <?php if(!$maintenance){?><span class="fr add" onclick="toggleview2('formtanggungan'); return false;">+ Tambah</span><?php }; ?></li>
                <?php if(!$maintenance){?>
                <div id="formtanggungan" class="hidden">
                <li>
                  <form id="dep" name="dep" method="POST" action="sb/add_dep.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Nama *</td>
                        <td><span id="dep_name"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                          <input type="text" name="userdependents_name" id="userdependents_name" class="in_cappitalize" />
                        </span></td>
                      </tr>
                      <tr>
                        <td class="label">Hubungan</td>
                        <td><select name="userdependents_relation" id="userdependents_relation">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_relationship['relationship_id']?>"><?php echo $row_relationship['relationship_name']?></option>
                          <?php
							} while ($row_relationship = mysql_fetch_assoc($relationship));
							  $rows = mysql_num_rows($relationship);
							  if($rows > 0) {
								  mysql_data_seek($relationship, 0);
								  $row_relationship = mysql_fetch_assoc($relationship);
							  }
							?>
                        </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">No Kad Pengenalan</td>
                        <td><span id=""><span class="textfieldInvalidFormatMsg">Sila pastikan format dimasukkan dengan betul.</span>
                          <input name="userdependents_ic" type="text" class="miniinput" id="userdependents_ic" maxlength="12" />
                          </span>                          
                        <div class="inputlabel2">Tanpa simbol '-'. Cth: 881203065595</div></td>
                      </tr>
                      <tr>
                        <td class="noline"><input type="hidden" name="userdependents_by" id="userdependents_by" value="<?php echo $_SESSION['user_stafid'];?>" />
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" /></td>
                        <td class="noline"><input name="button6" type="submit" class="submitbutton" id="button6" value="Tambah" />
                        <input name="button7" type="submit" class="cancelbutton" id="button7" value="Batal" onclick="toggleview2('formtanggungan'); return false;" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="dep" />
                  </form>
                  </li>
                </div>
                <?php }; ?>
                <div id="tanggungan">
                <li class="gap">&nbsp;</li>
                <li>
  					<?php include('view/dep.php');?>
				  <a name="exwork2" id="exwork2"></a>
                </li>
                <li class="gap">&nbsp;</li>
                </div>
                <li class="title">Rekod Kerjaya <?php if(!$maintenance){?><span class="fr add" onclick="toggleview2('formkerjaya'); return false;">+ Tambah</span><?php }; ?></li>
                <?php if(!$maintenance){?>
                <div id="formkerjaya" class="hidden">
                <li>
               	  <form id="exwork" name="exwork" method="POST" action="sb/add_exwork.php">
               	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
               	      <tr>
               	        <td class="label">Jawatan</td>
               	        <td colspan="3"><input type="text" name="userexwork_title" id="userexwork_title" class="in_cappitalize" /></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Majikan *</td>
               	        <td colspan="3"><span id="sprytextfield5"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
               	          <input type="text" name="userexwork_employer" id="userexwork_employer" class="in_cappitalize" />
           	            </span>               	          <div class="inputlabel2">Nama Jabatan Kerajaan / Syarikat. Cth : Kementerian Belia dan Sukan atau Persendirian</div></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Kategori Majikan</td>
               	        <td colspan="3">
               	          <select name="employertype_id" id="employertype_id">
               	            <?php
							do {  
							?>
               	            <option value="<?php echo $row_employertype['employertype_id']?>"><?php echo $row_employertype['employertype_name']?></option>
               	            <?php
							} while ($row_employertype = mysql_fetch_assoc($employertype));
							  $rows = mysql_num_rows($employertype);
							  if($rows > 0) {
								  mysql_data_seek($employertype, 0);
								  $row_employertype = mysql_fetch_assoc($employertype);
							  }
							?>
                        </select></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Lokasi / Alamat</td>
               	        <td colspan="3"><input type="text" name="userexwork_location" id="userexwork_location" class="in_cappitalize" /></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Tarikh Mula</td>
               	        <td><span id="exwork_date_in"><span class="textfieldInvalidFormatMsg">Sila pastikan format dimasukkan dengan betul.</span>
                        <input name="userexwork_startdate" type="text" id="userexwork_startdate" maxlength="10" />
</span>               	          
           	            <div class="inputlabel2">Format: dd/mm/yyyy Cth: 23/05/1980</div></td>
               	        <td class="label">Tarikh Tamat</td>
               	        <td><span id="exwork_date_out"><span class="textfieldInvalidFormatMsg">Sila pastikan format dimasukkan dengan betul.</span>
                        <input name="userexwork_enddate" type="text" id="userexwork_enddate" maxlength="10" />
</span>               	          
           	            <div class="inputlabel2">Format: dd/mm/yyyy Cth: 23/05/1980</div></td>
           	          </tr>
               	      <tr>
               	        <td class="noline"><input name="userexwork_by" type="hidden" id="userexwork_by" value="<?php echo $_SESSION['user_stafid']; ?>" />
               	          <input name="userexwork_date" type="hidden" id="userexwork_date" value="<?php echo date('d/m/Y');?>" />
<input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid']; ?>" /></td>
               	        <td colspan="3" class="noline"><input name="button8" type="submit" class="submitbutton" id="button8" value="Tambah"/>
           	            <input name="button9" type="button" class="cancelbutton" id="button9" value="Batal" onclick="toggleview2('formkerjaya'); return false;" /></td>
           	          </tr>
           	        </table>
               	    <input type="hidden" name="MM_insert" value="exwork" />
                  </form>
                  <li>
                </div>
                <?php }; ?>
                <div id="kerjaya">
                <li class="gap">&nbsp;</li>
                <li>
				  <?php include('view/exwork.php');?>
				  <a name="edu2" id="edu2"></a>
                </li>
                <li class="gap">&nbsp;</li>
                </div>
            	<li class="title">Rekod Pendidikan <?php if(!$maintenance){?><span class="fr add" onclick="toggleview2('formpendidikan'); return false;">+ Tambah</span><?php }; ?></li>
                <?php if(!$maintenance){?>
                <div id="formpendidikan" class="hidden">
                <li>
               	  <form id="edu" name="edu" method="POST" action="sb/add_edu.php">
               	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
               	      <tr>
               	        <td class="label">Tahap</td>
               	        <td><select name="useredu_level" id="useredu_level">
               	          <?php
							do {  
							?>
               	          <option value="<?php echo $row_edu_level['edulevel_id']?>"><?php echo $row_edu_level['edulevel_name']?></option>
               	          <?php
							} while ($row_edu_level = mysql_fetch_assoc($edu_level));
							  $rows = mysql_num_rows($edu_level);
							  if($rows > 0) {
								  mysql_data_seek($edu_level, 0);
								  $row_edu_level = mysql_fetch_assoc($edu_level);
							  }
							?>
							<option value="">Lain-lain</option>
                        </select></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Bidang (Major)</td>
               	        <td><input type="text" name="useredu_major" id="useredu_major" class="in_cappitalize" /></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Bidang (Minor)</td>
               	        <td><input type="text" name="useredu_minor" id="useredu_minor" class="in_cappitalize" /></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Institut *</td>
               	        <td>
                        <span id="edu_name">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan</span>
               	          <input type="text" name="useredu_institution" id="useredu_institution" class="in_cappitalize" />
           	            </span>
                        <div class="inputlabel2">Nama Sekolah / Kolej / Universiti. Cth: Sek. Sukan Bukit Jalil</div>
                        </td>
           	          </tr>
               	      <tr>
               	        <td class="label">Lokasi</td>
               	        <td><input type="text" name="useredu_location" id="useredu_location" class="in_cappitalize" /><div class="inputlabel2">Cth: Kuala Lumpur</div></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Tahun<br/>Penganugerahan</td>
               	        <td>
                        <span id="edu_year">
                        <span class="textfieldInvalidFormatMsg">Invalid format.</span>
                        <input name="useredu_year" type="text" class="miniinput" id="useredu_year" maxlength="4" />
</span>               	          
           	            <div class="inputlabel2">Format: yyyy Cth: 1980</div>
                        </td>
           	          </tr>
               	      <tr>
               	        <td class="label">CGPA</td>
               	        <td><input name="useredu_cgpa" type="text" class="miniinput" id="useredu_cgpa" class="in_upper" maxlength="4" /><div class="inputlabel2">Cth: 3.0</div></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Pencapaian</td>
               	        <td><input name="useredu_achievement" rows="5" id="useredu_achievement" type="text" /><div class="inputlabel2">Cth: Anugerah Dekan atau Peringkat Kebangsaan</div></td>
           	          </tr>
               	      <tr>
               	        <td class="label">Penaja</td>
               	        <td><label for="sponsor_id"></label>
               	          <select name="sponsor_id" id="sponsor_id">
               	            <?php
								do {  
								?>
															<option value="<?php echo $row_sponsor['sponsor_id']?>"><?php echo $row_sponsor['sponsor_name']?></option>
															<?php
								} while ($row_sponsor = mysql_fetch_assoc($sponsor));
								  $rows = mysql_num_rows($sponsor);
								  if($rows > 0) {
									  mysql_data_seek($sponsor, 0);
									  $row_sponsor = mysql_fetch_assoc($sponsor);
								  }
								?>
               	            <option value="0" selected="selected">Lain - lain</option>
           	              </select>
           	            <input name="useredu_sponsor" type="text" class="in_cappitalize w35" id="useredu_sponsor" maxlength="20"/>
           	            <div class="inputlabel2">Isi nama penaja jika perlu / tiada dalam senarai yang dinyatakan.</div></td>
           	          </tr>
               	      <tr>
               	        <td class="noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" />
               	          <input name="useredu_date" type="hidden" id="useredu_date" value="<?php echo date('d/m/Y');?>" />
                          <input name="useredu_by" type="hidden" id="useredu_by" value="<?php echo $_SESSION['user_stafid'];?>" />
                          <input type="hidden" name="MM_insert" value="edu" /></td>
               	        <td class="noline"><input name="button10" type="submit" class="submitbutton" id="button10" value="Tambah" />
           	            <input name="button11" type="button" class="cancelbutton" id="button11" value="Batal" onclick="toggleview2('formpendidikan'); return false;" /></td>
           	          </tr>
           	        </table>
               	  </form>
                  </li>
                </div>
                <?php }; ?>
                <div id="pendidikan">
                <li class="gap">&nbsp;</li> 
                <li>
                <?php include('view/edu.php');?>
                <a name="pass2" id="pass2"></a>
                </li>
                <li class="gap">&nbsp;</li> 
                </div>
                <li class="title">Maklumat Passport <?php if(!$maintenance){?><span class="fr add" onclick="toggleview('formpassport','passport'); return false;">Kemaskini</span><?php }; ?></li>
                <?php if(!$maintenance){?>
                <div id="formpassport" class="hidden">
                <li>
                  <form id="passport2" name="passport2" method="POST" action="sb/update_passport.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Jenis</td>
                        <td>
                        	<ul class="inputradio">
                            	<li><input <?php if (!(strcmp($row_user_passport['userpassport_type'],"1"))) {echo "checked=\"checked\"";} ?> name="userpassport_type" type="radio" id="passporttype_0" value="1" checked="checked" /> Passport</li>
                            </ul>
                        </td>
                        <td class="label">Kewarganegaraan</td>
                        <td>
                        <select name="userpassport_citizen" id="userpassport_citizen">
                          <option value="60" <?php if (!(strcmp(60, $row_user_passport['userpassport_citizen']))) {echo "selected=\"selected\"";} ?>>Malaysia</option>
                          <?php
							do {  
							?>
							<option value="<?php echo $row_countrylist['CountryID']?>"<?php if (!(strcmp($row_countrylist['CountryID'], $row_user_passport['userpassport_citizen']))) {echo "selected=\"selected\"";} ?>><?php echo $row_countrylist['Name']?></option>
                          <?php
							} while ($row_countrylist = mysql_fetch_assoc($countrylist));
							  $rows = mysql_num_rows($countrylist);
							  if($rows > 0) {
								  mysql_data_seek($countrylist, 0);
								  $row_countrylist = mysql_fetch_assoc($countrylist);
							  }
							?>
                        </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">No. Passport *</td>
                        <td>
                        <span id="pass_no">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                          <input name="userpassport_no" class="in_upper" type="text" id="userpassport_no" value="<?php echo $row_user_passport['userpassport_no']; ?>" />
                        </span>
                        </td>
                        <td class="label">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="label">Tarikh Mula *</td>
                        <td>
                        <span id="pass_date_in">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                        <input name="userpassport_start" type="text" id="userpassport_start" value="<?php echo $row_user_passport['userpassport_start']; ?>" maxlength="7" />
                        </span>                          
                        <div class="inputlabel2">Format: mm/yyyy Cth: 12/1980</div>
                        </td>
                        <td class="label">Tarikh Tamat *</td>
                        <td>
                        <span id="pass_date_out">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                        <input name="userpassport_expire" type="text" id="userpassport_expire" value="<?php echo $row_user_passport['userpassport_expire']; ?>" maxlength="7" />
                        </span>                          
                        <div class="inputlabel2">Format: mm/yyyy Cth: 12/1980</div>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">Tarikh Tamat<br/>Permit Kerja</td>
                        <td>
                        <span id="pass_kerja">
                        <span class="textfieldInvalidFormatMsg">Invalid format.</span>
                        <input name="userpassport_permit" type="text" id="userpassport_permit" value="<?php echo $row_user_passport['userpassport_permit']; ?>" maxlength="10" />
                        </span>                          
                        <div class="inputlabel2">Format: dd/mm/yyyy Cth:03/12/1980</div></td>
                        <td class="label">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="noline">
                        <input name="userpassport_by" type="hidden" id="userpassport_by" value="<?php echo $_SESSION['user_stafid']; ?>" />
                        <input name="userpassport_date" type="hidden" id="userpassport_date" value="<?php echo date('d/m/Y');?>" />
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid']; ?>" />
                        <input type="hidden" name="MM_update" value="passport" />
                        </td>
                        <td colspan="3" class="noline">
                        <input name="button12" type="submit" class="submitbutton" id="button12" value="Kemaskini" />
                        <input name="button13" type="button" class="cancelbutton" id="button13" value="Batal" onclick="toggleview('formpassport','passport'); return false;" />
                        </td>
                      </tr>
                    </table>
                  </form>
                  </li>
                </div>
                <?php }; ?>
                <div id="passport">
                <li>
                <?php include('view/passport.php');?>
                </li>
                </div>
            </ul>
        </div>
        
        </div>
        <?php echo noteFooter('1');?>
      </div>
        
	  <?php include('inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("ec_name");
var sprytextfield3 = new Spry.Widget.ValidationTextField("dep_name");
var sprytextfield4 = new Spry.Widget.ValidationTextField("dep_dob", "date", {isRequired:false, format:"dd/mm/yyyy", hint:"dd/mm/yyyy", useCharacterMasking:true});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("exwork_date_in", "date", {isRequired:false, format:"dd/mm/yyyy", hint:"dd/mm/yyyy"});
var sprytextfield7 = new Spry.Widget.ValidationTextField("exwork_date_out", "date", {hint:"dd/mm/yyyy", format:"dd/mm/yyyy", isRequired:false});
var sprytextfield8 = new Spry.Widget.ValidationTextField("edu_name");
var sprytextfield9 = new Spry.Widget.ValidationTextField("edu_year", "integer", {hint:"yyyy", isRequired:false});
var sprytextfield10 = new Spry.Widget.ValidationTextField("pass_no");
var sprytextfield11 = new Spry.Widget.ValidationTextField("pass_date_in", "none", {hint:"mm/yyyy"});
var sprytextfield12 = new Spry.Widget.ValidationTextField("pass_date_out", "none", {hint:"mm/yyyy"});
var sprytextfield13 = new Spry.Widget.ValidationTextField("pass_kerja", "date", {format:"dd/mm/yyyy", hint:"dd/mm/yyyy", isRequired:false});
var sprytextfield14 = new Spry.Widget.ValidationTextField("med_height", "integer");
var sprytextfield15 = new Spry.Widget.ValidationTextField("med_weight", "integer");
var sprytextfield1 = new Spry.Widget.ValidationTextField("telr", "integer", {isRequired:false});
var sprytextfield16 = new Spry.Widget.ValidationTextField("emailo", "email", {isRequired:false});
var sprytextfield17 = new Spry.Widget.ValidationTextField("tarikhrawatan", "date", {format:"dd/mm/yyyy", isRequired:false});
</script>
</body>
</html>
<?php

mysql_free_result($relationship);

mysql_free_result($edu_level);

mysql_free_result($state);

mysql_free_result($state2);

mysql_free_result($countrylist);

mysql_free_result($marital);

mysql_free_result($employertype);

mysql_free_result($sponsor);
?>
<?php include('inc/footinc.php');?>
