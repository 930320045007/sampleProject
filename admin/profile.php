<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='5';?>
<?php $menu3 = '2';?>
<?php
$colname_user_personal = "-1";
if (isset($_GET['id'])) {
  $colname_user_personal = getStafIDByUserID($_GET['id']);
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_personal = sprintf("SELECT * FROM user_personal WHERE user_stafid = %s ORDER BY userpersonal_id DESC", GetSQLValueString($colname_user_personal, "text"));
$user_personal = mysql_query($query_user_personal, $hrmsdb) or die(mysql_error());
$row_user_personal = mysql_fetch_assoc($user_personal);
$totalRows_user_personal = mysql_num_rows($user_personal);

mysql_free_result($user_personal);

$colname_user_ec = "-1";
if (isset($_GET['id'])) {
  $colname_user_ec = getStafIDByUserID($_GET['id']);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_ec = sprintf("SELECT * FROM user_ec WHERE user_stafid = %s ORDER BY userec_name ASC", GetSQLValueString($colname_user_ec, "text"));
$user_ec = mysql_query($query_user_ec, $hrmsdb) or die(mysql_error());
$row_user_ec = mysql_fetch_assoc($user_ec);
$totalRows_user_ec = mysql_num_rows($user_ec);

mysql_free_result($user_ec);

$colname_user_dependents = "-1";
if (isset($_GET['id'])) {
  $colname_user_dependents = getStafIDByUserID($_GET['id']);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_dependents = sprintf("SELECT * FROM user_dependents WHERE user_stafid = %s ORDER BY userdependents_relation ASC", GetSQLValueString($colname_user_dependents, "text"));
$user_dependents = mysql_query($query_user_dependents, $hrmsdb) or die(mysql_error());
$row_user_dependents = mysql_fetch_assoc($user_dependents);
$totalRows_user_dependents = mysql_num_rows($user_dependents);

mysql_free_result($user_dependents);

$colname_user_exwork = "-1";
if (isset($_GET['id'])) {
  $colname_user_exwork = getStafIDByUserID($_GET['id']);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_exwork = sprintf("SELECT * FROM user_exwork WHERE user_stafid = %s ORDER BY userexwork_startdate ASC", GetSQLValueString($colname_user_exwork, "text"));
$user_exwork = mysql_query($query_user_exwork, $hrmsdb) or die(mysql_error());
$row_user_exwork = mysql_fetch_assoc($user_exwork);
$totalRows_user_exwork = mysql_num_rows($user_exwork);

mysql_free_result($user_exwork);

$colname_user_edu = "-1";
if (isset($_GET['id'])) {
  $colname_user_edu = getStafIDByUserID($_GET['id']);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_edu = sprintf("SELECT * FROM user_edu WHERE user_stafid = %s ORDER BY useredu_year ASC", GetSQLValueString($colname_user_edu, "text"));
$user_edu = mysql_query($query_user_edu, $hrmsdb) or die(mysql_error());
$row_user_edu = mysql_fetch_assoc($user_edu);
$totalRows_user_edu = mysql_num_rows($user_edu);

mysql_free_result($user_edu);

$colname_user_passport = "-1";
if (isset($_GET['id'])) {
  $colname_user_passport = getStafIDByUserID($_GET['id']);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_passport = sprintf("SELECT * FROM user_passport WHERE user_stafid = %s ORDER BY userpassport_id DESC", GetSQLValueString($colname_user_passport, "text"));
$user_passport = mysql_query($query_user_passport, $hrmsdb) or die(mysql_error());
$row_user_passport = mysql_fetch_assoc($user_passport);
$totalRows_user_passport = mysql_num_rows($user_passport);

mysql_free_result($user_passport);

$colname_user_med = "-1";
if (isset($_GET['id'])) {
  $colname_user_med = getStafIDByUserID($_GET['id']);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_med = sprintf("SELECT * FROM user_med WHERE user_stafid = %s ORDER BY usermed_id DESC", GetSQLValueString($colname_user_med, "text"));
$user_med = mysql_query($query_user_med, $hrmsdb) or die(mysql_error());
$row_user_med = mysql_fetch_assoc($user_med);
$totalRows_user_med = mysql_num_rows($user_med);

mysql_free_result($user_med);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_relationship = "SELECT * FROM relationship ORDER BY relationship_name ASC";
$relationship = mysql_query($query_relationship, $hrmsdb) or die(mysql_error());
$row_relationship = mysql_fetch_assoc($relationship);
$totalRows_relationship = mysql_num_rows($relationship);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_edu_level = "SELECT * FROM edu_level ORDER BY edulevel_id ASC";
$edu_level = mysql_query($query_edu_level, $hrmsdb) or die(mysql_error());
$row_edu_level = mysql_fetch_assoc($edu_level);
$totalRows_edu_level = mysql_num_rows($edu_level);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_state = "SELECT * FROM `state` ORDER BY state_name ASC";
$state = mysql_query($query_state, $hrmsdb) or die(mysql_error());
$row_state = mysql_fetch_assoc($state);
$totalRows_state = mysql_num_rows($state);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_countrylist = "SELECT * FROM countrylist ORDER BY Name ASC";
$countrylist = mysql_query($query_countrylist, $hrmsdb) or die(mysql_error());
$row_countrylist = mysql_fetch_assoc($countrylist);
$totalRows_countrylist = mysql_num_rows($countrylist);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_marital = "SELECT * FROM marital ORDER BY marital_name ASC";
$marital = mysql_query($query_marital, $hrmsdb) or die(mysql_error());
$row_marital = mysql_fetch_assoc($marital);
$totalRows_marital = mysql_num_rows($marital);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_employertype = "SELECT * FROM employer_type ORDER BY employertype_id ASC";
$employertype = mysql_query($query_employertype, $hrmsdb) or die(mysql_error());
$row_employertype = mysql_fetch_assoc($employertype);
$totalRows_employertype = mysql_num_rows($employertype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sponsor = "SELECT * FROM sponsor ORDER BY sponsor_name ASC";
$sponsor = mysql_query($query_sponsor, $hrmsdb) or die(mysql_error());
$row_sponsor = mysql_fetch_assoc($sponsor);
$totalRows_sponsor = mysql_num_rows($sponsor);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_state2 = "SELECT * FROM www.state ORDER BY state_name ASC";
$state2 = mysql_query($query_state2, $hrmsdb) or die(mysql_error());
$row_state2 = mysql_fetch_assoc($state2);
$totalRows_state2 = mysql_num_rows($state2);

$uploadHandler = $url_main . 'up/upload.processor.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div class="passbox_back hidden2" id="formPic">
<div class="passbox_form">
        <form id="Upload" action="<?php echo $uploadHandler ?>" enctype="multipart/form-data" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
      <tr>
      <td colspan="2" class="title noline">Penukaran Gambar Profil</td>
          </tr>
          <tr>
      <td class="back_white noline txt_line">
              <div class="inputlabel2">Sila pastikan saiz gambar tidak melebihi <strong><?php echo (getImgSize()/1000);?>kb</strong> dan resolusi <strong>50px &times; 50px</strong></div>
                <input id="file" type="file" name="file">
                <input name="id" type="hidden" value="<?php echo $_GET['id'];?>" />
            </td>
          </tr>
          <tr>
            <td class="back_white noline txt_line">
                <input name="submit" type="submit" class="submitbutton" id="submit" value="Kemaskini">
                <input name="Button" type="button" class="cancelbutton" id="submit" value="Batal" onClick="toggleview2('formPic'); return false;">
            </td>
          </tr>
    </table>
      </form> 
</div>
</div>
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
                  <td rowspan="2" align="center" valign="top" class="noline"><div onClick="toggleview2('formPic'); return false;"><?php echo viewProfilePic($colname_user_personal);?></div><div class="cursorpoint" onClick="toggleview2('formPic'); return false;">Edit</div></td>
                    <td nowrap="nowrap" class="label">Nama</td>
                    <td width="100%"><strong><?php echo strtoupper(getFullNameByStafID($colname_user_personal)) . " (" . $colname_user_personal . ")"; ?></strong></td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label noline">Jawatan</td>
                    <td class="noline txt_line"><?php echo getJobtitle($colname_user_personal); ?><br/><?php echo getFulldirectoryByUserID($colname_user_personal);?></td>
                  </tr>
                </table>
                </li>
                <li class="gap">&nbsp;</li>
              <li class="title">Maklumat Peribadi 
              <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 3)){ //semak user level utk update profile?><span class="fr add" onClick="toggleview('formprofile','profile'); return false;">Kemaskini</span><?php }; ?>
              </li>
                
              <div id="formprofile" class="hidden">
                <li>
                	  <form id="personal" name="personal" method="POST" action="../sb/update_personal.php">
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
               	            <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user_personal['user_stafid']; ?>" />
                	          <input type="hidden" name="MM_update" value="personal2" /><input type="hidden" name="idstaff" value="<?php echo $_GET['id']; ?>" /></td>
                	        <td colspan="3" class="noline"><input name="button" type="submit"  class="submitbutton" id="button" value="Kemaskini" /><input name="button" type="button" class="cancelbutton" id="button" value="Batal" onclick="toggleview('formprofile','profile'); return false;" /></td>
               	          </tr>
              	        </table>
                      </form>
                      </li>
                	</div>
                
                <li>
                  <?php include('../view/personal.php');?>
                </li>
              <li class="gap">&nbsp;</li>
              <li class="title">Maklumat Perubatan</li>
                <li>
          <?php include('../view/med.php');?>
              </li>
              <li class="gap">&nbsp;</li>
              <li class="title">Waris / Rujukan Kecemasan</li>
                <li>
                  <?php include('../view/ec.php');?>
              </li>





              <li class="title">Maklumat Keluarga <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?><span class="fr add" onclick="toggleview2('formtanggungan'); return false;">+ Tambah</span><?php }; ?></li>


                <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2)){?>
                <div id="formtanggungan" class="hidden">
                <li>
                  <form id="dep" name="dep" method="POST" action="../sb/add_dep.php?id=<?php echo $_GET['id'] ?>">
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
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_user_personal;?>" /></td>
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
            
              <li>
                  <?php include('../view/dep.php');?>
              </li>







              <li class="title">Rekod Kerjaya</li>
              <li>
                <?php include('../view/exwork.php');?>
                <a name="edu2" id="edu2"></a>
              </li>
              <li class="title">Rekod Pendidikan</li>
              <li>
                  <?php include('../view/edu.php');?>
                <a name="pass2" id="pass2"></a>
              </li>
              <li class="title">Maklumat Passport</li>
              <li>
                  <?php include('../view/passport.php');?>
              </li>
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
        <?php echo noteFooter('1');?>
      </div>
        
    <?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php

mysql_free_result($relationship);

mysql_free_result($edu_level);

mysql_free_result($state);

mysql_free_result($countrylist);

mysql_free_result($marital);

mysql_free_result($employertype);

mysql_free_result($sponsor);
?>
<?php include('../inc/footinc.php');?> 