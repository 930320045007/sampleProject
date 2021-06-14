<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='37';?>
<?php
$wsql = "";
if(isset($_POST['stafid']) && $_POST['stafid']!=NULL)
	$wsql .= " AND user_kewe.user_stafid = '" . $_POST['stafid'] . "'";

if(isset($_POST['bulan']) && $_POST['bulan']!=0)
{
	$wsql .= " AND userkewe_date_m = '" . $_POST['bulan'] . "'";
	$bulan = $_POST['bulan'];
} else if(isset($_POST['stafid']) && $_POST['stafid']!=NULL && $_POST['bulan']==0){
	$bulan = 0;
} else {
	$bulan = date('m');
	$wsql .= " AND userkewe_date_m = '" . $bulan . "'";
};

if(isset($_POST['tahun']) && $_POST['tahun']!=0)
{
	$wsql .= " AND userkewe_date_y = '" . $_POST['tahun'] . "'";
	$tahun = $_POST['tahun'];
} else if(isset($_POST['stafid']) && $_POST['stafid']!=NULL && $_POST['tahun']==0){
	$tahun = 0;
} else {
	$tahun = date('Y');
	$wsql .= " AND userkewe_date_y = '" . $tahun . "'";
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kew8 = "SELECT * FROM www.user_kewe WHERE userkewe_status = 1 " . $wsql . " ORDER BY userkewe_start_y DESC,  userkewe_start_m DESC,  userkewe_start_d DESC,  userkewe_id DESC";
$kew8 = mysql_query($query_kew8, $hrmsdb) or die(mysql_error());
$row_kew8 = mysql_fetch_assoc($kew8);
$totalRows_kew8 = mysql_num_rows($kew8);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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
                  <form id="form1" name="form1" method="post" action="kew8.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Staf ID / Bulan</td>
                        <td width="100%">
                          <span id="nostaf">
                          <input name="stafid" type="text" class="w25" id="stafid" list="datastaf">
                          <?php echo datalistStaf('datastaf');?>
                          </span>
                          <select name="bulan">
                        <?php for($i=1; $i<=12; $i++){?>
                          <option <?php if($i==$bulan) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo date('m - M', mktime(0, 0, 0, $i, 1, date('Y'))); ?></option>
                        <?php }; ?>
                        <option <?php if($bulan=='0') echo "selected=\"selected\"";?> value="0">Semua</option>
                        </select>
                        <select name="tahun">
                        <?php for($j=date('Y'); $j>=(date('Y')-3); $j--){?>
                          <option <?php if($j==$tahun) echo "selected=\"selected\"";?> value="<?php echo $j;?>"><?php echo $j;?></option>
                        <?php }; ?>
                        <option <?php if($tahun=='0') echo "selected=\"selected\"";?> value="0">Semua</option>
                        </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                        <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?><td><input name="button4" type="button" class="submitbutton" id="button4" value="Tambah" onClick="MM_goToURL('parent','kew8add.php');return document.MM_returnValue" /></td><?php } ; ?>
                      </tr>
                    </table>
                  </form>
                
                </li>
                <li>
                <div class="note">Senarai Penyata perubahan mengenai pendapatan seseorang pegawai (Kew 8 - Pin 10/96) bulan <strong><?php echo date('M Y', mktime(0, 0, 0, $bulan, 1, $tahun));?></strong></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_kew8 > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th align="center" valign="middle" nowrap="nowrap">Siri</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th nowrap="nowrap">&nbsp;</th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getKew8SiriByID($row_kew8['userkewe_id']);?></td>
                        <td align="left" valign="middle">
						            <a href="<?php echo $url_main;?>admin/kew8detail.php?id=<?php echo getID($row_kew8['userkewe_id']); ?>"><?php echo getKew8TypeByKewID($row_kew8['kewe_id']) . " &nbsp; &bull; &nbsp; " . getKew8NameByID($row_kew8['kewe_id']);?><br/><br/>
                        <strong><?php echo getFullNameByStafID($row_kew8['user_stafid']) . " (" . $row_kew8['user_stafid'] . ")"; ?></strong>
                          <br/><?php echo getJobtitleReal($row_kew8['user_stafid']) . " (" . getGred($row_kew8['user_stafid']) . ")";?>, <span class="txt_color1"><?php echo getFulldirectoryByUserID($row_kew8['user_stafid']);?></span>
                          </a>
                        </td>
                        <td>&nbsp;</td>
                        <td><ul class="func"><li>X</li></ul></td>
                      </tr>
                      <?php $i++; } while ($row_kew8 = mysql_fetch_assoc($kew8)); ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_kew8 ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("nostaf", "none", {hint:"Staf ID", isRequired:false});
</script>
</body>
</html>
<?php
mysql_free_result($kew8);
?>
<?php include('../inc/footinc.php');?>
