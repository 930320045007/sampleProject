<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='5';?>
<?php $menu2='62';?>
<?php
$colname_pp = "-1";
if (isset($_GET['id'])) {
  $colname_pp = getID($_GET['id'],0);
}

mysql_select_db($database_skt, $skt);
$query_pp = sprintf("SELECT * FROM pp WHERE user_stafid = %s GROUP BY pp_id ORDER BY pp_date_d DESC, pp_date_m DESC, pp_date_y DESC LIMIT 1", GetSQLValueString($colname_pp, "text"));
$pp = mysql_query($query_pp, $skt) or die(mysql_error());
$row_pp = mysql_fetch_assoc($pp);
$totalRows_pp = mysql_num_rows($pp);
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
                <li>
                <div class="note">Kemaskini maklumat Pegawai Penilai</div>
                </li>
                <li>
                  <form id="form1" name="form1" method="POST" action="../sb/add_sktpp.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Pegawai Yang Dinilai (PYD)</td>
                        <td>
                      <div><strong class="in_upper"><?php echo getFullNameByStafID($colname_pp); ?></strong></div>
                      <div><span class="txt_color1"><?php echo getJobtitle($colname_pp) . ", "; ?><?php echo getFulldirectoryByUserID($colname_pp);?></span></div>
                      <div class="txt_color1">Email : <?php echo getEmailISNByUserID($colname_pp);?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID($colname_pp);?></div>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Pegawai Penilai Pertama (PPP)</td>
                        <td><span id="ppp"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="pp_ppp" type="text" class="w35" id="pp_ppp" value="<?php if(getPPKByStafID($colname_pp)!=NULL) echo getPPPByStafID($colname_pp);?>" list="datastaf1" />
                          <?php echo datalistStaf('datastaf1');?>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Pegawai Penilai Kedua (PPK)</td>
                        <td><span id="ppk"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="pp_ppk" type="text" class="w35" id="pp_ppk" value="<?php if(getPPKByStafID($colname_pp)!=NULL) echo getPPKByStafID($colname_pp);?>" list="datastaf2" />
                          <?php echo datalistStaf('datastaf2');?>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_pp;?>" /></td>
                        <td><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="form1" />
                  </form>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("ppp");
var sprytextfield2 = new Spry.Widget.ValidationTextField("ppk");
</script>
</body>
</html>
<?php include('../inc/footinc.php');?> 