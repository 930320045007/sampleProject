<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='31';?>
<?php
if(isset($_GET['id']))
	$id = htmlspecialchars($_GET['id'], ENT_QUOTES);
else
	$id = 0;
	
mysql_select_db($database_ictdb, $ictdb);
$query_vtype = "SELECT * FROM ict.vendor_type WHERE vendortype_status = 1 ORDER BY vendortype_name ASC";
$vtype = mysql_query($query_vtype, $ictdb) or die(mysql_error());
$row_vtype = mysql_fetch_assoc($vtype);
$totalRows_vtype = mysql_num_rows($vtype);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script type="text/javascript" src="../js/disenter.js"></script>
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $id != 0){?>
                <li>
                	<div class="note">Kemaskini maklumat vendor</div>
                  <form id="form1" name="form1" method="POST" action="../sb/add_vendor.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Jenis</td>
                        <td colspan="3" width="100%"><span class="noline">
                          <select name="vendortype_id" id="vendortype_id">
                            <?php
							do {  
							?>
                            <option <?php if($id == $row_vtype['vendortype_id']) echo "selected=\"selected\"";?> value="<?php echo $row_vtype['vendortype_id'];?>"><?php echo $row_vtype['vendortype_name']?></option>
                            <?php
							} while ($row_vtype = mysql_fetch_assoc($vtype));
							  $rows = mysql_num_rows($vtype);
							  if($rows > 0) {
								  mysql_data_seek($vtype, 0);
								  $row_vtype = mysql_fetch_assoc($vtype);
							  }
							?>
                          </select>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Nama</td>
                        <td colspan="3"><span id="nama"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                          <input name="vendor_name" type="text" id="vendor_name" onkeypress="return handleEnter(this, event)" value="<?php echo getVendorNameByID($id); ?>" />
                       </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Alamat</td>
                        <td colspan="3"><textarea name="vendor_add" id="vendor_add" cols="45" rows="5"><?php echo getVendorAddByID($id); ?></textarea></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Tel</td>
                        <td width="50%"><input name="vendor_notel" type="text" id="vendor_notel" onkeypress="return handleEnter(this, event)" value="<?php echo getVendorNoTelByID($id); ?>" /></td>
                        <td nowrap="nowrap" class="label">No. Fax</td>
                        <td width="50%"><input name="vendor_nofax" type="text" id="vendor_nofax" onkeypress="return handleEnter(this, event)" value="<?php echo getVendorNoFaxByID($id); ?>" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Email</td>
                        <td class="w30"><input name="vendor_email" type="text" id="vendor_email" onkeypress="return handleEnter(this, event)" value="<?php echo getVendorEmailByID($id); ?>" /></td>
                        <td nowrap="nowrap" class="label">Website</td>
                        <td class="w30"><input name="vendor_web" type="text" id="vendor_web" onkeypress="return handleEnter(this, event)" value="<?php echo getVendorWebByID($id); ?>" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline"><input name="vendor_id" type="hidden" id="vendor_id" value="<?php echo $id;?>" />                          <input name="MM_update" type="hidden" id="MM_update" value="form1" /></td>
                        <td colspan="3" class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                        <input name="button4" type="submit" class="cancelbutton" id="button4" value="Batal" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
            <?php } else { ?>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Tiada rekod dijumpai</td>
                    </tr>
                  </table>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("nama");
</script>
</body>
</html>
<?php
mysql_free_result($vtype);
?>
<?php include('../inc/footinc.php');?> 