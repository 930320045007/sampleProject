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
?>
<?php
mysql_select_db($database_ictdb, $ictdb);
$query_vind = "SELECT * FROM vendor_ind WHERE vendor_id = '" . $id . "' AND vendorind_status = '1' ORDER BY vendorind_name ASC";
$vind = mysql_query($query_vind, $ictdb) or die(mysql_error());
$row_vind = mysql_fetch_assoc($vind);
$totalRows_vind = mysql_num_rows($vind);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1) && $id != 0){?>
                <li>
                <div class="note">Maklumat lengkap vendor</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Jenis</td>
                      <td colspan="3"><?php echo getVendorTypeNameByID(getVendorTypeIDByVendorID($id));?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Nama</td>
                      <td colspan="3"><?php echo getVendorNameByID($id); ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Alamat</td>
                      <td colspan="3"><?php echo getVendorAddByID($id); ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">No. Tel</td>
                      <td width="50%"><?php echo getVendorNoTelByID($id); ?></td>
                      <td nowrap="nowrap" class="label">No. Fax</td>
                      <td width="50%"><?php echo getVendorNoFaxByID($id); ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Email</td>
                      <td><?php echo getVendorEmailByID($id); ?></td>
                      <td nowrap="nowrap" class="label">Website</td>
                      <td><?php echo getVendorWebByID($id); ?></td>
                    </tr>
                    <tr>
                      <td class="label">&nbsp;</td>
                      <td colspan="3"><input name="button3" type="button" class="submitbutton" id="button3" value="Kemaskini" onClick="MM_goToURL('parent','vendoredit.php?id=<?php echo $id;?>');return document.MM_returnValue" /></td>
                    </tr>
                  </table>
                </li>
                <li class="title">Individu terlibat <span class="add fr" onclick="toggleview2('formind'); return false;">Tambah</span></li>
                <div id="formind" class="hidden">
                <li>
                  <form id="form1" name="form1" method="post" action="../sb/add_vendor_ind.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Nama</td>
                        <td colspan="3"><input type="text" name="vendorind_name" id="vendorind_name" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Email</td>
                        <td width="50%"><input type="text" name="vendorind_email" id="vendorind_email" /></td>
                        <td nowrap="nowrap" class="label">No. Tel</td>
                        <td width="50%"><input type="text" name="vendorind_notel" id="vendorind_notel" /></td>
                      </tr>
                      <tr>
                        <td class="label"><input name="vendor_id" type="hidden" id="vendor_id" value="<?php echo $id;?>" />                          <input name="MM_insert" type="hidden" id="MM_insert" value="form1" /></td>
                        <td colspan="3"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" onclick="toggleview2('formind'); return false;" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <li>
                	<div class="note">Senarai individu yang bertanggungjawab</div>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_vind > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th nowrap="nowrap">Bil</th>
                          <th width="100%" nowrap="nowrap">Nama</th>
                          <th align="center" valign="middle" nowrap="nowrap">No. Tel</th>
                          <th nowrap="nowrap">&nbsp;</th>
                        </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td nowrap="nowrap"><?php echo $i;?></td>
                            <td class="txt_line"><strong><?php echo $row_vind['vendorind_name']; ?></strong><br />
                              Email : <?php echo $row_vind['vendorind_email']; ?></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_vind['vendorind_notel']; ?></td>
                            <td><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat individu berikut dipadam? \r\n\n <?php echo $row_vind['vendorind_name']; ?>')" href="../sb/add_vendor_ind.php?vindid=<?php echo $row_vind['vendorind_id']; ?>">X</a></li></ul></td>
                          </tr>
                          <?php $i++; } while ($row_vind = mysql_fetch_assoc($vind)); ?>
                        <tr>
                          <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_vind ?>  rekod dijumpai</td>
                        </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                      <?php }; ?>
                      </table>
                </li>
            <?php } else { ?>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle">Tiada rekod dijumpai</td>
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
</body>
</html>
<?php
mysql_free_result($vind);
?>
<?php include('../inc/footinc.php');?> 