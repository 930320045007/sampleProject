<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='8';?>
<?php $menu2='33';?>
<?php
mysql_select_db($database_ictdb, $ictdb);
$query_itemborrow2 = "SELECT item_borrow.* FROM ict.item_borrow WHERE itemborrow_status = 1 AND userborrow_type = 1 AND item_borrow.user_stafid = '" . $row_user['user_stafid'] . "' ORDER BY itemborrow_id DESC";
$itemborrow2 = mysql_query($query_itemborrow2, $ictdb) or die(mysql_error());
$row_itemborrow2 = mysql_fetch_assoc($itemborrow2);
$totalRows_itemborrow2 = mysql_num_rows($itemborrow2);
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
        <?php include('../inc/menu_ict_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <div class="note">Berikut rekod pegangan aset :</div>
            <ul>
                <li class="title">Rekod pegangan aset</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_itemborrow2 > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh Mula</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh Tamat</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Item</th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i; ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_itemborrow2['itemborrow_date']; ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php if($row_itemborrow2['ict_return'] == 1) echo $row_itemborrow2['ict_returndate']; else echo "-"; ?></td>
                        <td align="left" valign="middle"><?php echo getItemCategoryBySubCatID($row_itemborrow2['subcategory_id']);?> &nbsp; &bull; &nbsp; <?php echo getItemSubCategoryByID($row_itemborrow2['subcategory_id']);?> &nbsp; &bull; &nbsp; <?php echo getItemISNSiriByID($row_itemborrow2['item_id']); ?> &nbsp; &bull; &nbsp; <?php echo getItemBrandNameByItemID($row_itemborrow2['item_id']);?> <?php echo getModelByItemID($row_itemborrow2['item_id']); ?></td>
                        <td>&nbsp;</td>
                      </tr>
                      <?php $i++; } while ($row_itemborrow2 = mysql_fetch_assoc($itemborrow2)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_itemborrow2 ?>  rekod dijumpai</td>
                    </tr>
                  	<?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
            </ul>
            </div>
        </div>
            <div class="inputlabel2 padt fl">Setiap aset ICT yang dipegang perlu dipulangkan kembali ke <?php echo getDirSubName(getDirIDByMenuID($menu));?> setelah tamat perkhidmatan.</div>
        <?php echo noteMade($menu);?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($itemborrow2);
 ?>
<?php include('../inc/footinc.php');?> 