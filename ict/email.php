<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='6';?>
<?php $menu2='10';?>
<?php

if(isset($_POST['cpulist']) && $_POST['cpulist']!=NULL){
	$wsql = " AND user_unit.dir_id='" . htmlspecialchars($_POST['cpulist'], ENT_QUOTES) . "' AND user_unit.userunit_status = '1'";
}else{
	$wsql = " AND user_unit.userunit_status = '1'"; 
};
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_login = "SELECT user.* FROM www.user LEFT JOIN (SELECT * FROM www.user_unit WHERE user_unit.userunit_status = '1' ORDER BY user_unit.userunit_id) AS user_unit ON user_unit.user_stafid = user.user_stafid WHERE NOT EXISTS (SELECT * FROM www.login WHERE user.user_stafid = login.user_stafid) " . $wsql . " GROUP BY user.user_stafid ORDER BY user.user_firstname ASC, user.user_lastname ASC";
$login = mysql_query($query_login, $hrmsdb) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);
$totalRows_login = mysql_num_rows($login);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT * FROM dir WHERE dir_status = 1 ORDER BY dir_type ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);
$totalRows_dir = mysql_num_rows($dir);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){ ?>
            <li class="form_back">
              <form id="cpu" name="cpu" method="post" action="email.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td nowrap="nowrap" class="label noline">Lokasi</td>
                    <td width="100%" class="noline"><label for="cpulist"></label>
                      <select name="cpulist" id="cpulist">
                        <?php
						do {  
						?>
                        <option <?php if(isset($_POST['cpulist']) && $_POST['cpulist']==$row_dir['dir_id']) echo "selected=\"selected\"";?> value="<?php echo $row_dir['dir_id']?>"><?php echo getFulldirectory($row_dir['dir_id'], 0);?></option>
                        <?php
						} while ($row_dir = mysql_fetch_assoc($dir));
						  $rows = mysql_num_rows($dir);
						  if($rows > 0) {
							  mysql_data_seek($dir, 0);
							  $row_dir = mysql_fetch_assoc($dir);
						  }
						?>
                      </select>
                    <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                    <td class="noline"><input name="button4" type="button" class="submitbutton" id="button4" value="Senarai" onClick="MM_goToURL('parent','listexstaf.php');return document.MM_returnValue" /></td>
                  </tr>
                </table>
              </form>
            </li>
            <?php if ($totalRows_login > 0) { // Show if recordset not empty ?>
            <li>
            <div class="note">Pendaftaran email adalah bertujuan untuk memberi akses kepada pengguna. Pendaftaran email perlu dilakukan setelah profail pengguna telah dikemaskini oleh Cawangan Sumber Manusia</div>
              <form id="daftaremail" name="daftaremail" method="POST" action="../sb/emailactivate_ict.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th align="left" valign="middle" nowrap="nowrap">Nama / Bahagian</th>
                    <th width="100%">&nbsp;</th>
                  </tr>
                  <?php do { ?>
                    <tr class="on">
                      <td nowrap="nowrap" class="txt_line w50"><strong><?php echo $row_login['user_firstname']; ?> <?php echo $row_login['user_lastname']; ?></strong> (<?php echo $row_login['user_stafid']; ?>)<br /><span class="txt_color1"><?php echo getJobtitle($row_login['user_stafid']);?>, <br />
                      <?php echo getFulldirectoryByUserID($row_login['user_stafid']);?></span></td>
                      <td align="right" valign="middle" nowrap="nowrap"><span id="email">
                        <input name="stafid[]" type="hidden" id="stafid[]" value="<?php echo $row_login['user_stafid']; ?>" />
                        <span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                      <input name="login_username[]" type="text" class="w50 txt_right in_lower" id="login_username[]" />
                    </span><span class="inputlabel">@nsc.gov.my</span></td>
                    </tr>
                    <?php } while ($row_login = mysql_fetch_assoc($login)); ?>
                  <tr>
                    <td nowrap="nowrap" class="noline"><input name="MM_insert" type="hidden" id="MM_insert" value="daftaremail" />
                    <input name="login_by" type="hidden" id="login_by" value="<?php echo $row_user['user_stafid'];?>" />
                    </td>
                    <td align="left" valign="middle" nowrap="nowrap" class="noline"><input name="button" type="submit" class="submitbutton" id="button" value="Daftar" /></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="center" valign="middle" class="noline txt_color1">&nbsp;<?php echo $totalRows_login ?> rekod dijumpai</td>
                  </tr>
                </table>
              </form>
              </li>
              <?php } else {?>
              <li>
              	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              	  <tr>
              	    <td align="center" valign="middle" class="noline">Tiada email yang perlu didaftarkan. Sila cuba Cawangan / Pusat / Unit yang lain.</td>
           	      </tr>
           	    </table>
           	  </li>
              <?php }; ?>
                <?php } else { // semakkan user akses?>
                    <li>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" class="noline"><?php echo noteError(1);?></td>
                          </tr>
                        </table>
                    </li>
                <?php }; ?>
            </ul>
            </div>
         </div>
         <?php echo noteEmail('1');?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("email");
</script>
</body>
</html>
<?php
mysql_free_result($login);
mysql_free_result($dir);
?>
<?php include('../inc/footinc.php');?>
