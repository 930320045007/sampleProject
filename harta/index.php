<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php $menu='11';?>
<?php $menu2='42';?>
<?php 
if(isset($_POST['category_id']))
{
	$catid2 = $_POST['category_id'];
} else {
	$catid2 = 0;
};

if(isset($_POST['subcategory_id']))
{
	$scatid2 = $_POST['subcategory_id'];
} else {
	$scatid2 = 0;
};

mysql_select_db($database_hartadb, $hartadb);
$query_kat = "SELECT * FROM harta.category WHERE category_status = 1 ORDER BY category_name ASC";
$kat = mysql_query($query_kat, $hartadb) or die(mysql_error());
$row_kat = mysql_fetch_assoc($kat);
$totalRows_kat = mysql_num_rows($kat);

mysql_select_db($database_hartadb, $hartadb);
$query_rcskat = "SELECT * FROM harta.report_case WHERE rc_status = 1 AND subcategory_id = '" . $scatid2 . "' ORDER BY rc_id DESC";
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
<script language="javascript">
function checkForm(form)
{
	form.button3.disabled=true;
	form.button3.value="Proses...";
	return true;
}
</script>
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
            <?php if(!$maintenance || checkUserSysAcc($row_user['user_stafid'], 12, 45, 2)){?>
            <?php if(!checkAllReportEndApprovalByUserID($row_user['user_stafid'])){?>
            <?php if(checkLimitReport($row_user['user_stafid'], date('d'), date('m'), date('Y'))){?>
            	<li class="form_back">
                  <form id="formkategori" name="formkategori" method="post" action="index.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Kategori</td>
                        <td width="100%">
                          <select name="category_id" id="category_id" onChange="dochange('12', 'subcategory_id', this.value, '0');">
                          <option value="0">Sila pilih Kategori</option>
                            <?php $catid = $row_kat['category_id'];?>
                            <?php
							do {
							?>
                            <option <?php if($catid2 == $row_kat['category_id']) echo "selected=\"selected\"";?> value="<?php echo $row_kat['category_id']?>"><?php echo $row_kat['category_name']?></option>
                            <?php
							} while ($row_kat = mysql_fetch_assoc($kat));
							  $rows = mysql_num_rows($kat);
							  if($rows > 0) {
								  mysql_data_seek($kat, 0);
								  $row_kat = mysql_fetch_assoc($kat);
							  }
							?>
                          </select>
                          <select id="subcategory_id" name="subcategory_id">
                          <?php if($scatid2==0){?>
                          	<option value="0">&laquo; Sila pilih Kategori</option>
                          <?php } else if($catid2!=0){ ?>
							  <?php  
                                    mysql_select_db($database_hartadb, $hartadb);
                                    $query_skat = "SELECT * FROM harta.subcategory WHERE subcategory_status = 1 AND category_id = '" . $catid2 . "' ORDER BY subcategory_name ASC";
                                    $skat = mysql_query($query_skat, $hartadb) or die(mysql_error());
                                    $row_skat = mysql_fetch_assoc($skat);
                                    $totalRows_skat = mysql_num_rows($skat);
                                ?>
                                <?php $scatid = $row_skat['subcategory_id'];?>
                                <?php if($totalRows_skat>0){?>
									<?php do{ ?>
                                    <option <?php if($scatid2 == $row_skat['subcategory_id']) echo "selected=\"selected\"";?> value="<?php echo $row_skat['subcategory_id']; ?>"><?php echo $row_skat['subcategory_name']; ?></option>
                              		<?php } while ($row_skat = mysql_fetch_assoc($skat));?>
                                <?php }; ?>
                                <?php
                                	mysql_free_result($skat);
                                ?>
                            <?php }; ?>
                          </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                <div class="note">Borang aduan kerosakkan harta / kemudahan </div>
                <?php if($catid2!=0 && $scatid2!=0){?>
            	<?php if($totalRows_kat>0 && $totalRows_rcskat>0){?>
                  <?php if ($totalRows_rcskat > 0) { // Show if recordset not empty ?>
                  <form id="aduanform" name="aduanform" method="POST" action="../sb/add_harta_userreport.php" onSubmit="return checkForm(this) && true;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle" nowrap="nowrap" class="label">Katgeori</td>
                      <td width="100%"><?php echo getCategoryNameByID($catid2); ?> &nbsp; &bull; &nbsp; <?php echo getSubCategoryNameByID($scatid2); ?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" nowrap="nowrap" class="label">Isu</td>
                      <td>
                        <div class="off">
                          <ul class="li2c">
                            <?php do { ?>
                              <li> <input name="rc_id" type="radio" class="w10" id="rc_id_0" value="<?php echo $row_rcskat['rc_id']; ?>" checked="checked" /> &nbsp; <?php echo $row_rcskat['rc_title']; ?></li>
                              <?php } while ($row_rcskat = mysql_fetch_assoc($rcskat)); ?>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" nowrap="nowrap" class="label">Lokasi *</td>
                      <td><input name="userreport_location" type="text" class="w50" id="userreport_location" value="<?php echo getFulldirectoryByUserID($row_user['user_stafid']);?>" /><div class="inputlabel2">Cth : Dewan Perdana</div></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="noline">&nbsp;</td>
                      <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Hantar" /></td>
                    </tr>
                  </table>
                <input type="hidden" name="MM_insert" value="aduanform" />
                  </form>
                  <?php } else { ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle" class="noline">Tiada isu dijumpai berdasarkan kategori yang dipilih. Maklumat masih dalam proses kemaskini.</td>
                    </tr>
                  </table>
				<?php }; ?>
                <?php } else { ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle" class="noline">Maklumat masih dalam proses kemaskini. Sila cuba 'Kategori' &amp; 'Sub Kategori' yang lain.</td>
                    </tr>
                  </table>
                <?php }; ?>
                <?php } else {?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle" class="noline">Sila pilih 'Kategori' &amp; 'Sub Kategori' terlebih dahulu dan klik pada butang 'Semak'.</td>
                    </tr>
                  </table>
                <?php }; ?>
                </li>
                <?php } else { ?>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle" class="noline"><img src="../icon/sign_error.png" /> &nbsp; &nbsp; Jumlah aduan harian telah melebihi daripada yang ditetapkan. Sila semak senarai aduan harian dalam 'Rekod'.</td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
            <?php } else { ?>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle" class="noline"><img src="../icon/sign_error.png" /> &nbsp; &nbsp; Sila buat pengesahan kepada aduan sebelum ini. Klik pada 'Rekod' dan semak rekod aduan yang masih belum dibuat pengesahan</td>
                    </tr>
                  </table>
                </li>
            <?php }; ?>
            <?php } else { ?>
            	<li>
                <div class="note">Sistem dalam proses pengemaskinian dan penambahbaikkan buat sementara waktu</div>
                </li> 
            <?php }; ?>
            </ul>
            </div>
        </div>
        <?php echo noteFooter('1');?>
        <?php echo noteEmail('1');?>
        <?php echo noteMade($menu);?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($kat);
mysql_free_result($rcskat);
?>
<?php include('../inc/footinc.php');?>
