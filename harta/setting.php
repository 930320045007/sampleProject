<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php $menu='12';?>
<?php $menu2='46';?>
<?php
mysql_select_db($database_hartadb, $hartadb);
$query_kat = "SELECT * FROM harta.category WHERE category_status = 1 ORDER BY category_name ASC";
$kat = mysql_query($query_kat, $hartadb) or die(mysql_error());
$row_kat = mysql_fetch_assoc($kat);
$totalRows_kat = mysql_num_rows($kat);

mysql_select_db($database_hartadb, $hartadb);
$query_kat2 = "SELECT * FROM harta.category WHERE category_status = 1 ORDER BY category_name ASC";
$kat2 = mysql_query($query_kat2, $hartadb) or die(mysql_error());
$row_kat2 = mysql_fetch_assoc($kat2);
$totalRows_kat2 = mysql_num_rows($kat2);

mysql_select_db($database_hartadb, $hartadb);
$query_skat = "SELECT * FROM harta.subcategory WHERE subcategory_status = 1 ORDER BY category_id ASC, subcategory_name ASC";
$skat = mysql_query($query_skat, $hartadb) or die(mysql_error());
$row_skat = mysql_fetch_assoc($skat);
$totalRows_skat = mysql_num_rows($skat);

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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            	<li><div class="note">Konfigurasi untuk senarai diperlukan</div></li>
                <li class="title">Kategori<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('forminkat'); return false;">Tambah</span><?php }; ?></li>
                <div id="forminkat" class="hidden">
                <li class="form_back">
                  <form id="form1" name="form1" method="post" action="../sb/add_harta_setting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Nama</td>
                        <td width="100%">
                        <span id="kod">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="category_code" type="text" class="w10" id="category_code" maxlength="2" />
                          </span>
                          <span id="nama">
                          <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="category_name" type="text" class="w50" id="category_name" maxlength="20" />
                          <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                          </span>
                          <input name="MM_insert" type="hidden" id="MM_insert" value="kat" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_kat > 0) { // Show if recordset not empty ?>
<tr>
                      <td class="noline">
                        <ul class="li2c">
                          <?php do { ?>
                            <li>
                            <span class="name"><?php echo $row_kat['category_code']; ?> - <?php echo $row_kat['category_name']; ?></span>
							<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>
                            <span class="del">
                            <a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo $row_kat['category_name']; ?>')" href="../sb/del_harta_setting.php?id=<?php echo getID($row_kat['category_id']);?>&type=<?php echo getID('1');?>">&times;</a>
                            </span>
							<?php }; ?>
                            </li>
                            <?php } while ($row_kat = mysql_fetch_assoc($kat)); ?>
                        </ul>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_kat ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                <li class="title">Sub Kategori<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $totalRows_kat2>0){?><span class="fr add" onClick="toggleview2('forminskat'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $totalRows_kat2>0){?>
                <div id="forminskat" class="hidden">
                <li>
                  <form id="form2" name="form2" method="post" action="../sb/add_harta_setting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Nama</td>
                        <td width="100%" class="noline">
                        <span id="scatname"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                        <select name="category_id" id="category_id">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_kat2['category_id']?>"><?php echo $row_kat2['category_name']?></option>
                          <?php
							} while ($row_kat2 = mysql_fetch_assoc($kat2));
							  $rows = mysql_num_rows($kat2);
							  if($rows > 0) {
								  mysql_data_seek($kat2, 0);
								  $row_kat2 = mysql_fetch_assoc($kat2);
							  }
							?>
                        </select>
                        <input name="subcategory_name" type="text" class="w50" id="subcategory_name" />
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                          <input name="MM_insert" type="hidden" id="MM_insert" value="skat" />
                        </span>
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_skat > 0) { // Show if recordset not empty ?>
<tr>
                      <td class="noline">
                        <ul class="li2c">
                          <?php do { ?>
                            <li>
                            <span class="name"><?php echo getCategoryNameByID($row_skat['category_id']); ?> &nbsp; &bull; &nbsp; <?php echo $row_skat['subcategory_name']; ?></span>
							<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>
                            <span class="del">
                            <a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo $row_skat['subcategory_name']; ?>')" href="../sb/del_harta_setting.php?id=<?php echo getID($row_skat['subcategory_id']);?>&type=<?php echo getID('2');?>">&times;</a>
                            </span>
							<?php }; ?>
                            </li>
                            <?php } while ($row_skat = mysql_fetch_assoc($skat)); ?>
                        </ul>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_skat ?> rekod dijumpai</td>
                    </tr>
                  <?php } else {?>
                    <tr>
                      <td align="center" valign="middle" class="noline"><?php if($totalRows_kat2>0) echo "Tiada rekod dijumpai"; else echo "Sila buat penambahan pada Kategori.";?></td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
              <li class="title">Unit<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formunit'); return false;">Tambah</span><?php }; ?></li>
              <div id="formunit" class="hidden">
              <li>
                <form id="form3" name="form3" method="post" action="../sb/add_harta_setting.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label noline">Jenis</td>
                      <td width="100%" class="noline"><input name="MM_insert" type="hidden" id="MM_insert" value="unit" />
                        <input name="set_name" type="text" class="w50" id="set_name" />
                      <input name="button5" type="submit" class="submitbutton" id="button5" value="Tambah" /></td>
                    </tr>
                  </table>
                </form>
              </li>
              </div>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_setlist > 0) { // Show if recordset not empty ?>
                    <tr>
                      <td class="noline">
                        <ul class="li2c">
                          <?php do { ?>
                            <li><span class="name"><?php echo $row_setlist['set_name']; ?></span>
							<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>
                            <span class="del">
                            <a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo $row_setlist['set_name'];?>');" href="../sb/del_harta_setting.php?id=<?php echo getID($row_setlist['set_id']);?>&type=<?php echo getID('3');?>">&times;</a>
                            </span>
							<?php }; ?></li>
                            <?php } while ($row_setlist = mysql_fetch_assoc($setlist)); ?>
                        </ul>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_setlist ?> rekod dijumpai</td>
                    </tr>
                  <?php } else {?>
                    <tr>
                      <td align="center" valign="middle" class="noline"><?php if($totalRows_kat2>0) echo "Tiada rekod dijumpai"; else echo "Sila buat penambahan pada Kategori.";?></td>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("kod", "none", {hint:"Kod"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("nama", "none", {hint:"Kategori"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("scatname");
</script>
</body>
</html>
<?php
mysql_free_result($kat);
mysql_free_result($kat2);
mysql_free_result($skat);
mysql_free_result($setlist);
?>
<?php include('../inc/footinc.php');?>
