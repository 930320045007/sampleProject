<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/aktadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='14';?>
<?php $menu2='47';?>
<?php
mysql_select_db($database_aktadb, $aktadb);
$query_cat = "SELECT * FROM akta.category WHERE category_status = 1 ORDER BY category_name ASC";
$cat = mysql_query($query_cat, $aktadb) or die(mysql_error());
$row_cat = mysql_fetch_assoc($cat);
$totalRows_cat = mysql_num_rows($cat);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_qna.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
            	<li>
                  <form id="form1" name="form1" method="POST" action="../sb/add_akta.php">
                  <div class="note">Perkongsian maklumat berkaitan Akta dan Pekeliling</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Kategori</td>
                        <td>
                        <select name="category_id" id="category_id">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_cat['category_id']?>"><?php echo $row_cat['category_name']?></option>
                            <?php
							} while ($row_cat = mysql_fetch_assoc($cat));
							  $rows = mysql_num_rows($cat);
							  if($rows > 0) {
								  mysql_data_seek($cat, 0);
								  $row_cat = mysql_fetch_assoc($cat);
							  }
							?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">Tahun</td>
                        <td>
                        <span id="tahun">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="textfieldInvalidFormatMsg">Sila pastikan maklumat mengikut format tahun.</span><span class="textfieldMinCharsMsg">Sila pastikan maklumat mengikut format tahun.</span><span class="textfieldMaxCharsMsg">Sila pastikan maklumat mengikut format tahun.</span>
                        <input name="ap_year" type="text" class="w10" id="ap_year" maxlength="4" /></span>                          
                          <div class="inputlabel2">Cth: 2002</div>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">Tajuk</td>
                        <td><span id="tajuk"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input type="text" name="ap_title" id="ap_title" />
                        </span></td>
                      </tr>
                      <tr>
                        <td class="label">Penerangan ringkas</td>
                        <td><span id="nota"><span class="textareaMaxCharsMsg">Melebihi 300 huruf</span>
                          <textarea name="ap_note" id="ap_note" cols="45" rows="5"></textarea>
                        <div class="txt_color1"><span id="countnota">&nbsp;</span> huruf</div></span></td>
                      </tr>
                      <tr>
                        <td class="label">Sumber</td>
                        <td><span id="sumber"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                          <input type="text" name="ap_sumber" id="ap_sumber" />
                          <div class="inputlabel2">Cth: MAMPU</div>
                        </span></td>
                      </tr>
                      <tr>
                        <td class="label">URL Sumber</td>
                        <td><span id="sumberurl"><span class="textfieldRequiredMsg">Maklumat diperlukan</span><span class="textfieldInvalidFormatMsg">Tidak mengikut format</span>
                        <input name="apsumberurl" type="text" id="apsumberurl" value="http://" />
                        </span></td>
                      </tr>
                      <tr>
                        <td class="noline">&nbsp;</td>
                        <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','akta.php');return document.MM_returnValue" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="form1" />
                  </form>
                </li>                
            <?php }; ?>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("tahun", "integer", {minChars:4, maxChars:4, hint:"yyyy"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("tajuk");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sumber");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sumberurl", "url");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("nota", {isRequired:false, maxChars:300, counterId:"countnota", counterType:"chars_remaining"});
</script>
</body>
</html>
<?php
mysql_free_result($cat);
?>
<?php include('../inc/footinc.php');?> 