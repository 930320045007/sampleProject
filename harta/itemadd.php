<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php $menu='12';?>
<?php $menu2='50';?>
<?php
if(isset($_GET['id']))
{
	$itemid = $_GET['id'];
} else {
	$itemid = '1';
}
mysql_select_db($database_hartadb, $hartadb);
$query_itemc = "SELECT * FROM harta.item_stock WHERE item_id = '" . $itemid . "' AND itemstock_status = 1 ORDER BY itemstock_date_y DESC, itemstock_date_m DESC, itemstock_date_d DESC";
$itemc = mysql_query($query_itemc, $hartadb) or die(mysql_error());
$row_itemc = mysql_fetch_assoc($itemc);
$totalRows_itemc = mysql_num_rows($itemc);
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
            <div class="note">Senarai rekod kuantiti bagi<strong> <?php echo getItemName($itemid);?></strong></div>
                <li class="title">Rekod stok <span class="fr add" onClick="toggleview2('formitem'); return false;">Tambah</span></li>
                <div id="formitem" class="hidden">
                <li>
                  <form id="form1" name="form1" method="post" action="../sb/add_harta_itemkuantiti.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Kuantiti</td>
                        <td width="100%" class="noline">
                        <input name="MM_insert" type="hidden" id="MM_insert" value="form2" />
                        <input name="item_id" type="hidden" id="item_id" value="<?php echo $itemid;?>" />
                        <span id="kuantiti">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                        <span class="textfieldInvalidFormatMsg">Format tidak mengikut ketetapan</span>
                        <input name="item_kuantiti" type="text" class="w30" id="item_kuantiti" />
                        </span>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_itemc > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th>Bil</th>
                      <th width="100%" align="left" valign="middle">Tarikh</th>
                      <th align="center" valign="middle">Kuantiti</th>
                      <th align="center" valign="middle">Unit</th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td><?php echo $i;?></td>
                        <td align="left" valign="middle"><?php echo date('d / m / Y', mktime(0, 0, 0, $row_itemc['itemstock_date_m'], $row_itemc['itemstock_date_d'], $row_itemc['itemstock_date_y'])); ?></td>
                        <td align="center" valign="middle"><?php echo $row_itemc['item_kuantiti']; ?></td>
                        <td align="center" valign="middle"><?php echo getUnitName(getItemUnit($itemid));?></td>
                        <td nowrap="nowrap"><ul class="func">
                          <li><a onclick="return confirm('Anda mahu kuantiti item berikut dipadam? \r\n\n <?php echo date('d / m / Y', mktime(0, 0, 0, $row_itemc['itemstock_date_m'], $row_itemc['itemstock_date_d'], $row_itemc['itemstock_date_y'])); ?> ( <?php echo $row_itemc['item_kuantiti']; ?> <?php echo getUnitName(getItemUnit($itemid));?> )')" href="../sb/del_harta_itemkuantiti.php?id=<?php echo $row_itemc['itemstock_id']; ?>&amp;itemid=<?php echo $row_itemc['item_id']; ?>">X</a></li>
                        </ul></td>
                      </tr>
                      <?php $i++; } while ($row_itemc = mysql_fetch_assoc($itemc)); ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="left" valign="middle"><strong>Jumlah</strong></td>
                        <td align="center" valign="middle"><strong><?php echo getItemKuantiti($itemid);?></strong></td>
                        <td align="center" valign="middle"><?php echo getUnitName(getItemUnit($itemid));?></td>
                        <td nowrap="nowrap">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_itemc ?>  rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("kuantiti", "integer", {hint:"<?php echo getUnitName(getItemUnit($itemid));?>"});
</script>
</body>
</html>
<?php
mysql_free_result($itemc);
?>
<?php include('../inc/footinc.php');?> 