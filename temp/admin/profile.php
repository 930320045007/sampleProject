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
           	  <li class="title">Maklumat Peribadi</li>
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
              <li class="title">Maklumat Tanggungan</li>
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