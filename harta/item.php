<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php $menu='12';?>
<?php $menu2='50';?>
<?php
if(isset($_POST['catid']))
{
	$catid = $_POST['catid'];
} else {
	$catid = '1';
}

mysql_select_db($database_hartadb, $hartadb);
$query_kat = "SELECT * FROM harta.category WHERE category_status = 1 ORDER BY category_name ASC";
$kat = mysql_query($query_kat, $hartadb) or die(mysql_error());
$row_kat = mysql_fetch_assoc($kat);
$totalRows_kat = mysql_num_rows($kat);

mysql_select_db($database_hartadb, $hartadb);
$query_itemlist = "SELECT * FROM item WHERE category_id = '" . $catid . "' AND item_status = 1 ORDER BY item_name ASC";
$itemlist = mysql_query($query_itemlist, $hartadb) or die(mysql_error());
$row_itemlist = mysql_fetch_assoc($itemlist);
$totalRows_itemlist = mysql_num_rows($itemlist);

mysql_select_db($database_hartadb, $hartadb);
$query_setlist = "SELECT * FROM `set` WHERE set_status = 1 ORDER BY set_name ASC";
$setlist = mysql_query($query_setlist, $hartadb) or die(mysql_error());
$row_setlist = mysql_fetch_assoc($setlist);
$totalRows_setlist = mysql_num_rows($setlist);
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li class="form_back">
                  <form id="form1" name="form1" method="post" action="item.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Kategori</td>
                        <td width="100%">
                        <select name="catid" id="catid">
                          <?php
							do {  
							?>
                          <option <?php if($catid==$row_kat['category_id']) echo "selected=\"selected\"";?> value="<?php echo $row_kat['category_id']?>"><?php echo $row_kat['category_name']?></option>
                          <?php
							} while ($row_kat = mysql_fetch_assoc($kat));
							  $rows = mysql_num_rows($kat);
							  if($rows > 0) {
								  mysql_data_seek($kat, 0);
								  $row_kat = mysql_fetch_assoc($kat);
							  }
							?>
                        </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                <div class="note">Item bagi kategori<strong> <?php echo getCategoryNameByID($catid);?></strong></div>
                </li>
                <li class="title">Senarai Item <span class="fr add" onClick="toggleview2('formitem'); return false;">Tambah</span></li>
                <div id="formitem" class="hidden">
                <li>
                  <form id="form2" name="form2" method="POST" action="../sb/add_harta_item.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Item</td>
                        <td width="100%" class="noline">
                        <input name="category_id" type="hidden" id="category_id" value="<?php echo $catid;?>" />
                        <input name="item_name" type="text" class="w50" id="item_name" />
                          <select name="set_id" id="set_id">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_setlist['set_id']?>"><?php echo $row_setlist['set_name']?></option>
                            <?php
							} while ($row_setlist = mysql_fetch_assoc($setlist));
							  $rows = mysql_num_rows($setlist);
							  if($rows > 0) {
								  mysql_data_seek($setlist, 0);
								  $row_setlist = mysql_fetch_assoc($setlist);
							  }
							?>
                          </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input type="hidden" name="MM_insert" value="form2" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_itemlist > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center">Bil</th>
                      <th width="100%" align="left" valign="middle">Item</th>
                      <th align="center" nowrap="nowrap">Baki Kuantiti</th>
                      <th align="center">Unit</th>
                      <th>&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center"><?php echo $i;?></td>
                        <td align="left" valign="middle"><a href="itemadd.php?id=<?php echo $row_itemlist['item_id']; ?>"><?php echo $row_itemlist['item_name']; ?></a></td>
                        <td align="center" nowrap="nowrap"><?php echo getItemBalByItemID($row_itemlist['item_id']);?></td>
                        <td align="center" nowrap="nowrap"><?php echo getUnitName($row_itemlist['set_id']); ?></td>
                        <td nowrap="nowrap"><?php if(getItemBalByItemID($row_itemlist['item_id'])==getItemKuantiti($row_itemlist['item_id'])){?><ul class="func"><li><a onclick="return confirm('Anda mahu item berikut dipadam? \r\n\n <?php echo $row_itemlist['item_name']; ?>')" href="../sb/del_harta_item.php?itemid=<?php echo $row_itemlist['item_id']; ?>&amp;cat=<?php echo $row_itemlist['category_id']; ?>">X</a></li></ul><?php }; ?></td>
                      </tr>
                      <?php $i++; } while ($row_itemlist = mysql_fetch_assoc($itemlist)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_itemlist ?> rekod dijumpai</td>
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
</body>
</html>
<?php
mysql_free_result($kat);

mysql_free_result($itemlist);

mysql_free_result($setlist);
?>
<?php include('../inc/footinc.php');?> 