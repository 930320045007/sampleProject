<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='80';?>
<?php

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_maintype = "SELECT * FROM tadbir.maintenance_type WHERE maintenancetype_status = 1 ORDER BY maintenancetype_id DESC";
$maintype = mysql_query($query_maintype, $tadbirdb) or die(mysql_error());
$row_maintype = mysql_fetch_assoc($maintype);
$totalRows_maintype = mysql_num_rows($maintype);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_type = "SELECT * FROM tadbir.transport_type WHERE transporttype_status = 1 ORDER BY transporttype_name ASC";
$type = mysql_query($query_type, $tadbirdb) or die(mysql_error());
$row_type = mysql_fetch_assoc($type);
$totalRows_type = mysql_num_rows($type);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = "SELECT transport.transport_id, transport.transport_name FROM tadbir.maintenance LEFT JOIN tadbir.transport ON transport.transport_id = maintenance.transport_id WHERE  maintenance_status = '1' GROUP BY transport_id ORDER BY transport.transport_name ASC";
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/disenter.js"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
        	<form action="../sb/add_maintenance.php" method="POST" name="formmaintenance" id="formmaintenance">
           	  <div class="note">Borang Permohonan Penyelenggaraan Kenderaan</div>
            <ul>    
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Jenis Kenderaan</td><td align="left" valign="middle" nowrap="nowrap">
                      <select name="typeid" id="typeid" onChange="dochange('18', 'transportid', this.value, '0');">
           	                <option value="0">Sila Pilih Jenis</option>
            	            <?php
							do {  
							?>
							<option value="<?php echo $row_type['transporttype_id']?>"><?php echo $row_type['transporttype_name']?></option>
														<?php
							} while ($row_type = mysql_fetch_assoc($type));
							  $rows = mysql_num_rows($type);
							  if($rows > 0) {
								  mysql_data_seek($type, 0);
								  $row_type = mysql_fetch_assoc($type);
							  }
							?>
                    </select></td></tr>
                <tr>
                 <td class="label">Nama Kenderaan</td>
                 <td align="left" valign="middle" nowrap="nowrap">
                 <select name="transportid" id="transportid">
           	               <option value="0">Sila Pilih Kenderaan</option>
       	         </select>

                 </td>
              </tr>
              <tr>
                <td class="label">Bacaan Odometer*</td>
                <td class="noline">
            <span id="odometer">
            <input name="maintenance_odometer" type="text" class="w50" id="maintenance_odometer" onkeypress="return handleEnter(this, event)" />
            <span class="textfieldRequiredMsg">Maklumat diperlukan.</span></span></td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="label noline"> Jenis Penyelenggaraan*</td>
              <td width="100%">
              <?php do { ?>
                <ul class="inputradio">
                <li>
                  <label>
                    <input name="jp[]" type="checkbox" id="jp[]" value="<?php echo $row_maintype['maintenancetype_id']; ?>" />
                  <?php echo $row_maintype['maintenancetype_name']; ?>
                  </label>
                </li>
                </ul>
		      <?php } while ($row_maintype = mysql_fetch_assoc($maintype)); ?></td>
          </tr>
          <tr>
            <td nowrap="nowrap" class="label">Ulasan *</td>
           <td> 
            <div class="inputlabel2">Sila nyatakan keperluan penyelenggaraan</div>
            <span id="note">
            <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
            <span class="textareaMaxCharsMsg">Melebihi had yang dibenarkan.</span>
            <textarea name="maintenance_note" cols="45" rows="5" id="maintenance_note" onkeypress="return handleEnter(this, event)"></textarea>
            <div class="inputlabel2"><span id="countcatatan">&nbsp;</span> huruf</div>
            </span>
            </td>
        </tr>
        <tr>
           <td>
            </td>
             <td width="100%" align="left" valign="middle" class="noline txt_line"> 
             <ul class="inputradio">
            <li>
            <span id="pengesahan">
            <input name="checkbox" type="checkbox" id="checkbox" />
             <span class="checkboxRequiredMsg"><div>Sila buat pengesahan. </div></span></span>
             <div>Saya mengesahkan setiap maklumat penyelenggaraan kenderaan yang diberikan adalah benar.</div> 
             </li>
            </ul>
            </td>
         </tr>
        <tr>
            <td class="noline"><input type="hidden" name="MM_insert" value="formmaintenance" /></td>
            <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
            <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onClick="MM_goToURL('parent','maintenancelist.php');return document.MM_returnValue"/></td>
      </tr>
    </table>
  </li>
</ul>
</form>
	<?php } else { ?>
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
 </div>
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield3 = new Spry.Widget.ValidationTextField("odometer");
var SpryValidationCheckbox1= new Spry.Widget.ValidationCheckbox("pengesahan");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("note", {counterId:"countcatatan", counterType:"chars_remaining", maxChars:300});
</script>
</body>
</html>
<?php
mysql_free_result($type);

mysql_free_result($maintype);

mysql_free_result($tr);
?>
<?php include('../inc/footinc.php');?> 