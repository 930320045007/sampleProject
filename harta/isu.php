<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php $menu='12';?>
<?php $menu2='45';?>
<?php
if(isset($_GET['category_id']) && $_GET['category_id']!=NULL)
{
	$catid = $_GET['category_id'];
} else {
	$catid = 0;
}

if(isset($_GET['subcategory_id']) && $_GET['subcategory_id']!=NULL)
{
	$scatid = $_GET['subcategory_id'];
} else {
	$scatid = 0;
}

mysql_select_db($database_hartadb, $hartadb);
$query_kat = "SELECT * FROM harta.category WHERE category_status = 1 ORDER BY category_name ASC";
$kat = mysql_query($query_kat, $hartadb) or die(mysql_error());
$row_kat = mysql_fetch_assoc($kat);
$totalRows_kat = mysql_num_rows($kat);

mysql_select_db($database_hartadb, $hartadb);
$query_skat = "SELECT * FROM harta.subcategory WHERE subcategory_status = 1 AND category_id = '" . $catid . "' ORDER BY subcategory_name ASC";
$skat = mysql_query($query_skat, $hartadb) or die(mysql_error());
$row_skat = mysql_fetch_assoc($skat);
$totalRows_skat = mysql_num_rows($skat);

mysql_select_db($database_hartadb, $hartadb);
$query_rcskat = "SELECT * FROM harta.report_case WHERE rc_status = 1 AND subcategory_id = '" . $scatid . "' ORDER BY rc_id DESC";
$rcskat = mysql_query($query_rcskat, $hartadb) or die(mysql_error());
$row_rcskat = mysql_fetch_assoc($rcskat);
$totalRows_rcskat = mysql_num_rows($rcskat);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<?php include('../inc/liload.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_harta_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            <?php if($totalRows_kat>0){?>
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="isu.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Kategori</td>
                        <td width="100%">
                        <select name="category_id" id="category_id" onchange="dochange('12', 'subcategory_id', this.value, '0');">
                          <option value="0">Sila pilih Kategori</option>
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
                          <select name="subcategory_id" id="subcategory_id">
                          <?php if($scatid==0){?>
                          <option value="0">&laquo; Sila pilih Kategori</option>
                          <?php } else { ?>
                            <?php
							do {  
							?>
                            <option <?php if($scatid==$row_skat['subcategory_id']) echo "selected=\"selected\"";?> value="<?php echo $row_skat['subcategory_id']?>"><?php echo $row_skat['subcategory_name']?></option>
                            <?php
							} while ($row_skat = mysql_fetch_assoc($skat));
							  $rows = mysql_num_rows($skat);
							  if($rows > 0) {
								  mysql_data_seek($skat, 0);
								  $row_skat = mysql_fetch_assoc($skat);
							  }
							?>
                            <?php }; ?>
                        </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php if($catid != 0 && $scatid != 0){?>
                <li><div class="note">Berikut senarai isu bagi <strong><?php echo getCategoryNameByID($catid); ?> > <?php echo getSubCategoryNameByID($scatid); ?></strong></div></li>
                <li class="title">Senarai Isu<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('forminisu'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $scatid!=0){?>  
              <div id="forminisu" class="hidden">              
                <li>
                  <form id="form2" name="form2" method="post" action="../sb/add_harta_isu.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Isu</td>
                        <td width="100%" class="noline">
                        <span id="isutitle"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                        <input name="rc_title" type="text" class="w70" id="rc_title" maxlength="300" />
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        </span>
                        <input name="MM_insert" type="hidden" id="MM_insert" value="isu" />
                        <input name="subcategory_id" type="hidden" id="subcategory_id" value="<?php echo $scatid;?>" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <?php }; ?>
                <?php if($scatid!=0){?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_rcskat > 0) { // Show if recordset not empty ?>
                      <tr>
                        <td width="100%" class="noline">
                        <ul class="li2c">
                        <?php do { ?>
                            <li><span class="name"><?php echo $row_rcskat['rc_title']; ?></span><span class="del fr">X</span></li>
                          <?php } while ($row_rcskat = mysql_fetch_assoc($rcskat)); ?>
                        </ul>						
                        </td>
                      </tr>
                    <tr>
                      <td align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_rcskat ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
            <?php } else {?>
            <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  </table>
            </li>
            <?php }; ?>
            <?php } else { ?>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle" class="noline">Sila buat penambahan pada Kategori atau Sub Kategori dalam ruangan Tatacara.</td>
                    </tr>
                  </table>
                </li>
            <?php };?>
            <?php } ; ?>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("isutitle");
</script>
</body>
</html>
<?php
mysql_free_result($kat);

mysql_free_result($skat);

mysql_free_result($rcskat);
?>
<?php include('../inc/footinc.php');?> 