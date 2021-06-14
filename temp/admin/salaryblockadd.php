<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='34';?>
<?php
	$m = date('m');
	$y = date('Y');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <li>
                <div class="note">Penambahan kakitangan dalam senarai block</div>
                  <form action="../sb/add_salaryblock.php" method="POST" name="form2" id="form2">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Staf ID *</td>
                        <td colspan="3">
                          <span id="stafid">
                          <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="user_stafid" type="text" class="w50" id="user_stafid" list="datastaf1" />
                          <?php echo datalistStaf('datastaf1');?>
                          <div class="inputlabel2">Cth : P1234</div>
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Mula</td>
                        <td nowrap="nowrap">
                          <select name="usb_start" id="usb_start">
                          <?php for($bm=(date('m')-3); $bm<=(date('m')+3); $bm++){?>
                            <option value="<?php echo date('m/Y', mktime(0, 0, 0, $bm, 1, date('Y')));?>" <?php if($bm==date('m')) echo "selected=\"selected\"";?>><?php echo date('M Y', mktime(0, 0, 0, $bm, 1, date('Y')));?></option>
                            <?php }; ?>	
                        	</select>
                        </td>
                        <td nowrap="nowrap" class="label">Tarikh Tamat</td>
                        <td width="50%">
                        <div>
                          <select name="usb_end" id="usb_end">
                          <?php for($bt=(date('m')-3); $bt<=(date('m')+6); $bt++){?>
                            <option value="<?php echo date('m/Y', mktime(0, 0, 0, $bt, 1, date('Y')));?>" <?php if($bt==date('m')) echo "selected=\"selected\"";?>><?php echo date('M Y', mktime(0, 0, 0, $bt, 1, date('Y')));?></option>
                            <?php }; ?>	
                       	  </select>
                          </div>
                          <div class="inputlabel2">Masukkan bulan dan tahun yang sama dengan 'Tarikh Mula'<br />
jika hanya melibatkan satu (1) bulan sahaja.</div>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3"><textarea name="usb_note" id="usb_note" cols="45" rows="5"></textarea></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="noline">&nbsp;</td>
                        <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" onclick="MM_goToURL('parent','salaryblock.php');return document.MM_returnValue" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="form2" />
                  </form>
                </li>
            <?php } ; ?>
            </ul>
            </div>
        </div>
        <?php echo noteFooter(1);?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("stafid");
</script>
</body>
</html>
<?php include('../inc/footinc.php');?> 