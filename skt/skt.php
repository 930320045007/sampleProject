<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='59';?>
<?php

$y = date('Y');

if(isset($_GET['sid']))
{
	$stafid = getID(htmlspecialchars($_GET['sid'], ENT_QUOTES),0);
} else {
	$stafid = '0';
}

mysql_select_db($database_skt, $skt);
$query_uskt = "SELECT user_skt.*, pp.pp_ppp FROM skt.user_skt LEFT JOIN skt.pp ON pp.user_stafid = user_skt.user_stafid WHERE pp_ppp = '" . $row_user['user_stafid'] . "' AND user_skt.user_stafid = '" . $stafid . "' AND uskt_date_y = '" . $y . "' AND user_skt.uskt_status = 1 GROUP BY uskt_id ORDER BY uskt_masa_mula ASC, uskt_masa_tamat ASC, user_skt.uskt_id ASC";
$uskt = mysql_query($query_uskt, $skt) or die(mysql_error());
$row_uskt = mysql_fetch_assoc($uskt);
$totalRows_uskt = mysql_num_rows($uskt);
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
            <ul>
            <?php if(checkPPPByStafID($row_user['user_stafid']) && getPPPByStafID($stafid) == $row_user['user_stafid']){?>
                <li class="form_back">              
                </li>
                <li>
                <div class="note">Senarai <strong>Sasaran Kerja Tahunan (SKT)</strong> bagi tahun <strong><?php echo $y;?></strong></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_uskt > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="100%" align="left" nowrap="nowrap">Aktiviti / Projek / Keterangan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tempoh</th>
                      <th align="center" valign="middle" nowrap="nowrap">Peratusan</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                    <tr class="<?php if(checkFeedbackCancel($row_uskt['uskt_id'])) echo "offcourses"; else echo "on";?>">
                      <td align="center" valign="middle"><?php echo $i;?></td>
                      <td align="left" class="txt_line">
                      <div>
                      <a href="pppdetail.php?id=<?php echo getID($row_uskt['uskt_id']); ?>"><?php echo substr($row_uskt['uskt_aktiviti'], 0, 100); if(strlen($row_uskt['uskt_aktiviti'])>100) echo "..."; ?></a>
                      </div>
                        <?php $ftid = getFeedbackIDLatest($stafid, $row_uskt['uskt_id']); if($ftid!=NULL){?>
                        <div class="inputlabel2 txt_color3">Kemaskini : <?php echo getFeedbackDate($ftid);?> oleh <?php echo getFullNameByStafID(getFeedbackBy($ftid)) . " (" . getFeedbackBy($ftid) . ")";?> <?php echo getPPType(getPPTypeByStafID($stafid, getFeedbackBy($ftid)));?></div>
                        <?php }; ?>
                        </td>
                      <td align="center" valign="middle" nowrap="nowrap" class="txt_line"><?php echo date('M Y', mktime(0, 0, 0, getSKTMasaMula($row_uskt['uskt_id']), 1, $row_uskt['uskt_date_y']));?> - <?php echo date('M Y', mktime(0, 0, 0, getSKTMasaTamat($row_uskt['uskt_id']), 1, $row_uskt['uskt_date_y']));?> <br />
                        (<?php echo getSKTTempoh($row_uskt['uskt_id']);?> Bulan)</td>
                      <td align="center" valign="middle">
                      <?php if(getFeedbackLatest($row_uskt['user_stafid'], $row_uskt['uskt_id'], '3')==100){?>
                        <img src="<?php echo $url_main;?>icon/sign_tick.png" width="16" height="16" alt="Sukses" />
                      <?php } elseif(checkFeedbackCancel($row_uskt['uskt_id'])){?>
                        <img src="<?php echo $url_main;?>icon/sign_error.png" width="16" height="16" alt="Gugur" />
                      <?php } else {?>
                        <div class="barcolor_red">
                            <div class="barcolor_blue" style="width: <?php echo getFeedbackLatest($row_uskt['user_stafid'], $row_uskt['uskt_id'], '3');?>%;">&nbsp;</div>
                            <div class="barcolor_percent"><?php echo getFeedbackLatest($row_uskt['user_stafid'], $row_uskt['uskt_id'], '3');?>%</div>
                        </div>
                        <?php }; ?>
                        </td>
                      <td align="center" valign="middle" nowrap="nowrap">&nbsp;</td>
                    </tr>
                    <?php $i++; } while ($row_uskt = mysql_fetch_assoc($uskt)); ?>
                      <tr class="back_lightgrey">
                        <td align="center" valign="middle" class="line_t">&nbsp;</td>
                        <td align="left" class="txt_line line_t"><strong>Purata</strong></td>
                        <td align="center" valign="middle" nowrap="nowrap" class="txt_line line_t">&nbsp;</td>
                        <td align="center" valign="middle" class="line_t">
                        <div class="barcolor_red">
                            <div class="barcolor_blue" style="width: <?php echo getSKTAveragePercent($stafid, date('Y'));?>%;">&nbsp;</div>
                            <div class="barcolor_percent"><?php echo getSKTAveragePercent($stafid, date('Y'));?>%</div>
                        </div>
                        </td>
                        <td align="center" valign="middle" nowrap="nowrap" class="line_t">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_uskt ?> rekod dijumpai</td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai.</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <li>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td align="center" valign="top" class="icon_pad1"><?php echo viewProfilePic(getPPPByStafID($stafid));?></td>
                      <td width="50%" align="left" valign="top" class="line_r txt_line">
                      <div>Pegawai Penilai Pertama (PPP)</div>
                      <div><strong><?php echo getFullNameByStafID(getPPPByStafID($stafid)) . " (" . getPPPByStafID($stafid) . ")"; ?></strong></div>
                      <div><span class="txt_color1"><?php echo getJobtitle(getPPPByStafID($stafid)) . ", "; ?><?php echo getFulldirectoryByUserID(getPPPByStafID($stafid));?></span></div>
                      <div class="txt_color1">Email : <?php echo getEmailISNByUserID(getPPPByStafID($stafid));?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID(getPPPByStafID($stafid));?></div>
                      </td>
                      <td align="center" valign="top" class="icon_pad1"><?php echo viewProfilePic(getPPKByStafID($stafid));?></td>
                      <td width="50%" align="left" valign="top" class="line_r txt_line">
                      <div>Pegawai Penilai Kedua (PPK)</div>
                      <div><strong><?php echo getFullNameByStafID(getPPKByStafID($stafid)) . " (" . getPPKByStafID($stafid) . ")"; ?></strong></div>
                      <div><span class="txt_color1"><?php echo getJobtitle(getPPKByStafID($stafid)) . ", "; ?><?php echo getFulldirectoryByUserID(getPPKByStafID($stafid));?></span></div>
                      <div class="txt_color1">Email : <?php echo getEmailISNByUserID(getPPKByStafID($stafid));?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID(getPPKByStafID($stafid));?></div>
                      </td>
                    </tr>
                  </table>
                </li>
            <?php } else { ?>
            	<li>
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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
?>
<?php include('../inc/footinc.php');?> 