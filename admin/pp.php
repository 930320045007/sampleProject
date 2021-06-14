<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='5';?>
<?php $menu2='62';?>
<?php
$colname_pp = $row_user['user_stafid'];
if (isset($_GET['id'])) {
  $colname_pp = getID($_GET['id'],0);
}

mysql_select_db($database_skt, $skt);
$query_pp = sprintf("SELECT * FROM pp WHERE user_stafid = %s ORDER BY pp_id DESC", GetSQLValueString($colname_pp, "text"));
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
                  <form id="form1" name="form1" method="get" action="pp.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Satf ID</td>
                        <td width="100%">
                        <input name="id" type="text" class="w25" id="id" value="<?php if (isset($colname_pp)) echo getID($colname_pp,0);?>" list="datastaf1" />
                        <?php echo datalistStaf('datastaf1');?>
                        <input name="semak" type="submit" class="submitbutton" id="semak" value="Semak" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php if (isset($colname_pp) && checkStafID($colname_pp)) {?>
                <li><div class="note">Maklumat Pegawai Penilai</div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Pegawai Yang Dinilai (PYD)</td>
                      <td width="90%" class="txt_line">
                      <div><strong class="in_upper"><?php echo getFullNameByStafID($colname_pp); ?></strong></div>
                      <div><span class="txt_color1"><?php echo getJobtitle($colname_pp) . ", "; ?><?php echo getFulldirectoryByUserID($colname_pp);?></span></div>
                      <div class="txt_color1">Email : <?php echo getEmailISNByUserID($colname_pp);?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID($colname_pp);?></div>
                      </td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Pegawai Penilai Pertama (PPP)</td>
                      <td class="txt_line">
					  <?php 
					  if(getPPPByStafID($colname_pp)!=NULL) 
					  {?>
                      <div><strong class="in_upper"><?php echo getFullNameByStafID(getPPPByStafID($colname_pp)); ?></strong></div>
                      <div><span class="txt_color1"><?php echo getJobtitle(getPPPByStafID($colname_pp)) . ", "; ?><?php echo getFulldirectoryByUserID(getPPPByStafID($colname_pp));?></span></div>
                      <div class="txt_color1">Email : <?php echo getEmailISNByUserID(getPPPByStafID($colname_pp));?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID(getPPPByStafID($colname_pp));?></div>
					  <?php } else echo "Tidak dinyatakan"; ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Pegawai Penilai Kedua (PPK)</td>
                      <td class="txt_line">
					  <?php 
					  if(getPPKByStafID($colname_pp)!=NULL) 
					  {?>
                      <div><strong class="in_upper"><?php echo getFullNameByStafID(getPPKByStafID($colname_pp)); ?></strong></div>
                      <div><span class="txt_color1"><?php echo getJobtitle(getPPKByStafID($colname_pp)) . ", "; ?><?php echo getFulldirectoryByUserID(getPPKByStafID($colname_pp));?></span></div>
                      <div class="txt_color1">Email : <?php echo getEmailISNByUserID(getPPKByStafID($colname_pp));?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID(getPPKByStafID($colname_pp));?></div>
					  <?php } else echo "Tidak dinyatakan"; ?></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><input name="button4" type="submit" class="submitbutton" id="button4" value="Kemaskini" onclick="MM_goToURL('parent','ppadd.php?id=<?php echo $colname_pp;?>');return document.MM_returnValue" /></td>
                    </tr>
                  </table>
                </li>
                <?php } else { ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center">Sila masukkan Staf ID untuk melihat maklumat Pegawai Penilai bagi kakitangan tersebut.</td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
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
mysql_free_result($pp);
?>
<?php include('../inc/footinc.php');?> 