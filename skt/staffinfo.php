<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='59';?>
<?php $menu3='1';?>
<?php

$y = date('Y');

$stafid = "-1";
if(isset($_GET['lid']))
{
	$stafid = $_GET['lid'];
} 

mysql_select_db($database_skt, $skt);
$query_staflist = "SELECT * FROM skt.pp WHERE pp_status = '1' AND pp_ppp = '" . $row_user['user_stafid'] . "' ORDER BY user_stafid ASC";
$staflist = mysql_query($query_staflist, $skt) or die(mysql_error());
$row_staflist = mysql_fetch_assoc($staflist);
$totalRows_staflist = mysql_num_rows($staflist);

mysql_select_db($database_skt, $skt);
$query_uskt = "SELECT user_skt.*, pp.pp_ppp FROM skt.user_skt LEFT JOIN skt.pp ON pp.user_stafid = user_skt.user_stafid WHERE pp_ppp = '" . $row_user['user_stafid'] . "' AND user_skt.user_stafid = '" . $stafid . "' AND uskt_date_y = '" . $y . "' AND user_skt.uskt_status = 1 ORDER BY uskt_masa_mula ASC, uskt_masa_tamat ASC, user_skt.uskt_id ASC";
$uskt = mysql_query($query_uskt, $skt) or die(mysql_error());
$row_uskt = mysql_fetch_assoc($uskt);
$totalRows_uskt = mysql_num_rows($uskt);

mysql_select_db($database_skt, $skt);
$query_akt = "SELECT * FROM skt.user_aktiviti WHERE user_stafid = '" . $stafid . "' AND useraktiviti_status=1 AND useraktiviti_year='" . $y . "' ORDER BY useraktiviti_id ASC";
$akt = mysql_query($query_akt, $skt) or die(mysql_error());
$row_akt = mysql_fetch_assoc($akt);
$totalRows_akt = mysql_num_rows($akt);

mysql_select_db($database_skt, $skt);
$query_tr = "SELECT * FROM skt.user_training WHERE usertraining_date_y = '" . $y . "' AND user_stafid = '" . $stafid . "' AND usertraining_status = 1 ORDER BY usertraining_id ASC";
$tr = mysql_query($query_tr, $skt) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/tabber.js"></script>
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
      	<?php include('../inc/menu_skt.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
             <?php include('../inc/menu_senaraiskt.php');?>
            <ul>
            <?php if(checkPPPByStafID($row_user['user_stafid']) && getPPPByStafID($stafid) == $row_user['user_stafid']){?>
                
                <li>
                <div class="note"><strong>Bahagian I - Maklumat Pegawai</strong></div>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td align="center" valign="top" class="icon_pad1"><?php echo viewProfilePic($stafid);?></td>
                      <td width="100%" class="txt_line">
                      <div>Profil Pegawai Yang Dinilai (PYD)</div>
					  <div class="txt_size3"><strong><?php echo getFullNameByStafID($stafid) . " (" . $stafid . ")";?></strong></div>
                      <div><span class="txt_color1"><?php echo getJobtitle($stafid) . ", "; ?><?php echo getFulldirectoryByUserID($stafid);?></span></div>
                      <div class="txt_color1">Email : <?php echo getEmailISNByUserID($stafid);?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID($stafid);?></div>
                      </td>
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
mysql_free_result($staflist);
mysql_free_result($uskt);
mysql_free_result($akt);
mysql_free_result($tr);
?>
<?php include('../inc/footinc.php');?> 