<?php require_once('Connections/hrmsdb.php');?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='2';?>
<?php $menu2='1';?>
<?php
$colname_eduresult = "-1";
if (isset($_GET['ided'])) {
  $colname_eduresult = htmlspecialchars($_GET['ided'], ENT_QUOTES);
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_eduresult = sprintf("SELECT * FROM www.user_edu WHERE useredu_id = %s", GetSQLValueString($colname_eduresult, "int"));
$eduresult = mysql_query($query_eduresult, $hrmsdb) or die(mysql_error());
$row_eduresult = mysql_fetch_assoc($eduresult);
$totalRows_eduresult = mysql_num_rows($eduresult);

$userstafid = $row_eduresult['user_stafid'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "eduresult")) {
  $insertSQL = sprintf("INSERT INTO www.user_eduresult (usereduresult_by, usereduresult_date, user_stafid, useredu_id, edusubjek_id, edugred_id) VALUES (%s, %s, %s, %s, %s, %s)",
				GetSQLValueString($row_user['user_stafid'], "text"),
				GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
				GetSQLValueString($row_eduresult['user_stafid'], "text"),
				GetSQLValueString($_POST['useredu_id'], "int"),
				GetSQLValueString($_POST['edusubjek_id'], "int"),
				GetSQLValueString($_POST['edugred_id'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());

  $insertGoTo = "result.php?msg=add&ided=" . $colname_eduresult . "";
  header(sprintf("Location: %s", $insertGoTo));
  
} else if ((isset($_GET["deledur"])) && ($_GET["deledur"] != NULL)) {
  $insertSQL = sprintf("UPDATE user_eduresult SET usereduresult_status='0' WHERE usereduresult_id=%s", GetSQLValueString($_GET['deledur'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());

  $insertGoTo = "result.php?msg=del&ided=" . $colname_eduresult . "";
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_subjek = "SELECT * FROM www.edu_subjek WHERE (edulevel_id = '0' OR edulevel_id='" . $row_eduresult['useredu_level'] . "') AND NOT EXISTS (SELECT * FROM user_eduresult WHERE user_eduresult.edusubjek_id = edu_subjek.edusubjek_id AND useredu_id = '" . $row_eduresult['useredu_id'] . "' AND user_stafid = '" . $userstafid . "' AND usereduresult_status='1') ORDER BY edusubjek_name ASC";
$subjek = mysql_query($query_subjek, $hrmsdb) or die(mysql_error());
$row_subjek = mysql_fetch_assoc($subjek);
$totalRows_subjek = mysql_num_rows($subjek);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_gred = "SELECT * FROM edu_gred ORDER BY edugred_name ASC";
$gred = mysql_query($query_gred, $hrmsdb) or die(mysql_error());
$row_gred = mysql_fetch_assoc($gred);
$totalRows_gred = mysql_num_rows($gred);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_usereduresult = "SELECT * FROM www.user_eduresult WHERE user_stafid = '" . $userstafid . "' AND useredu_id = $colname_eduresult AND usereduresult_status='1' ORDER BY edusubjek_id ASC";
$usereduresult = mysql_query($query_usereduresult, $hrmsdb) or die(mysql_error());
$row_usereduresult = mysql_fetch_assoc($usereduresult);
$totalRows_usereduresult = mysql_num_rows($usereduresult);
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
      	<div class="content">
        <div class="tabbox">
        <div class="line_t">
        <?php include('inc/profile.php');?>
        </div>
        <div class="profilemenu">
        	<ul>
            	<li class="line_t form_back">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Tahap</td>
                      <td class="w50"><?php echo getEdulevel($row_eduresult['useredu_level']); ?></td>
                      <td nowrap="nowrap" class="label">Tahun Penganugerahan</td>
                      <td class="w50"><?php echo $row_eduresult['useredu_year']; ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Institut</td>
                      <td colspan="3" class="noline w100"><?php echo $row_eduresult['useredu_institution']; ?></td>
                    </tr>
                  </table>
                </li>
                <?php if(checkEduResult($row_eduresult['useredu_level']) && (($userstafid == $row_user['user_stafid'])||(checkUserSysAcc($row_user['user_stafid'], 5, 5, 2)))){?>
            	<li class="title">Keputusan <?php if ($totalRows_subjek > 0  && ($userstafid == $row_user['user_stafid'])) { // Show if recordset not empty ?> <span class="fr add" onclick="toggleview2('formpendidikan'); return false;">+ Tambah</span><?php } // Show if recordset not empty ?>
                </li>
                <?php if ($totalRows_subjek > 0  && ($userstafid == $row_user['user_stafid'])) { // Show if recordset not empty ?>
                <div id="formpendidikan" class="hidden">
                <li>
                  <form id="eduresult" name="eduresult" method="POST" action="result.php?ided=<?php echo $colname_eduresult; ?>">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="100%" nowrap="nowrap" class="noline">
                        <input name="useredu_id" type="hidden" id="useredu_id" value="<?php echo $row_eduresult['useredu_id']; ?>" />
                          <select name="edusubjek_id" id="edusubjek_id">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_subjek['edusubjek_id']?>"><?php echo $row_subjek['edusubjek_name']?></option>
                          <?php
							} while ($row_subjek = mysql_fetch_assoc($subjek));
							  $rows = mysql_num_rows($subjek);
							  if($rows > 0) {
								  mysql_data_seek($subjek, 0);
								  $row_subjek = mysql_fetch_assoc($subjek);
							  }
							?>
                        </select>
                          <select name="edugred_id" id="edugred_id">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_gred['edugred_id']?>"><?php echo $row_gred['edugred_name']?></option>
                            <?php
							} while ($row_gred = mysql_fetch_assoc($gred));
							  $rows = mysql_num_rows($gred);
							  if($rows > 0) {
								  mysql_data_seek($gred, 0);
								  $row_gred = mysql_fetch_assoc($gred);
							  }
							?>
                        </select>
                        <input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="eduresult" />
                  </form>
                </li>
                </div>
                <?php }; ?>
                <div class="pendidikan">
                <li>&nbsp;
  				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_usereduresult > 0) { // Show if recordset not empty ?>
                  <tr>
                      <th width="100%" align="left">Mata Pelajaran</th>
                      <th align="center" valign="middle">Gred</th>
                      <th align="center" valign="middle">&nbsp;</th>
                  </tr>
                    <?php do { ?>
                      <tr class="on">
                        <td align="left" valign="middle"><?php echo getEduSubjek($row_usereduresult['edusubjek_id']); ?></td>
                        <td align="center" valign="middle"><?php echo getEduGred($row_usereduresult['edugred_id']); ?></td>
                        <td align="center" valign="middle"><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat keputusan pendidikan berikut dipadam? \r\n\n <?php echo getEduSubjek($row_usereduresult['edusubjek_id']); ?> - <?php echo getEduGred($row_usereduresult['edugred_id']); ?>')" href="<?php echo $url_main;?>result.php?deledur=<?php echo $row_usereduresult['usereduresult_id']; ?>&id=<?php echo $colname_eduresult;?>">X</a></li></ul></td>
                      </tr>
                      <?php } while ($row_usereduresult = mysql_fetch_assoc($usereduresult)); ?>
<tr>
                    <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_usereduresult ?> rekod dijumpai</td>
                  </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <?php } else { ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai atau Maklumat tidak diperlukan</td>
                    </tr>
                  </table>
                </li>
                <?php };?>
                </div>
            </ul>
        </div>
        </div>
        </div>
   
     </div>
</div>
</body>
</html>
<?php
mysql_free_result($eduresult);

mysql_free_result($subjek);

mysql_free_result($gred);

mysql_free_result($usereduresult);
?>

