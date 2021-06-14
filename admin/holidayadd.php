<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='23';?> 
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sta = "SELECT * FROM `state` WHERE state_status = 1 ORDER BY state_name ASC";
$sta = mysql_query($query_sta, $hrmsdb) or die(mysql_error());
$row_sta = mysql_fetch_assoc($sta);
$totalRows_sta = mysql_num_rows($sta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
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
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <li>
                  <form id="form1" name="form1" method="POST" action="../sb/add_holiday.php">
                  <div class="note">Penambahan Cuti Umum baru</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="label">Nama Cuti *</td>
                        <td width="100%"><label for="holiday_name"></label>
                          <span id="nama"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                        <input type="text" name="holiday_name" id="holiday_name" /></span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="label">Tarikh</td>
                        <td><label for="holiday_date_d"></label>
                          <select name="holiday_date_d" id="holiday_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i; ?>"><?php echo $i; ?></option>
                          <?php }; ?>
                          </select>
                          <select name="holiday_date_m" id="holiday_date_m">
                          <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j; ?>"><?php echo date('F', mktime(0, 0, 0, $j, 1, date('Y'))); ?></option>
                          <?php }; ?>
                          </select>
                          <select name="holiday_date_y" id="holiday_date_y">
                          <?php for($k=date('Y'); $k<=(date('Y')+2); $k++){?>
                            <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k; ?>"><?php echo $k; ?></option>
                          <?php }; ?>
                        </select>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="label">Catatan</td>
                        <td><textarea name="holiday_note" id="holiday_note" cols="45" rows="5"></textarea></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="label">Negeri</td>
                        <td>
                        <span id="negeri">
                        <span class="checkboxMinSelectionsMsg">Sila pilih satu (1) daripada senarai Negeri.</span>
                        <ul class="li2c">
                        	<li>
                            <input name="negeri[]2" type="checkbox" class="w10" id="negeri[]2" value="0" />&nbsp; Semua Negeri</li>
                        </ul>
              			<ul class="li2c line_dot">
                       	<?php do { ?>
                       	    	<li><input name="negeri[]" type="checkbox" class="w10" id="negeri[]" value="<?php echo $row_sta['state_id']; ?>" /> &nbsp; <?php echo $row_sta['state_name']; ?></li>
                        	<?php } while ($row_sta = mysql_fetch_assoc($sta)); ?>
                        </ul>
                        </span>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" class="label noline"><input name="holidaycategory_id" type="hidden" id="holidaycategory_id" value="1" />                          <input type="hidden" name="MM_insert" value="form1" /></td>
                        <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" /> <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','holiday.php');return document.MM_returnValue"/></td>
                      </tr>
                    </table>
                    
                  </form>
                </li>
            <?php } ; ?>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("nama");
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("negeri", {isRequired:false, minSelections:1});
</script>
</body>
</html>
<?php
mysql_free_result($sta);
?>
<?php include('../inc/footinc.php');?> 