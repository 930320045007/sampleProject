<?php require_once('../Connections/hrmsdb.php'); ?>

<?php require_once('../Connections/skt.php'); ?>

<?php include('../inc/user.php');?>

<?php include('../inc/func.php');?>

<?php include('../inc/sktfunc.php');?>

<?php $menu='15';?>

<?php $menu2='58';?>

<?php

if(isset($_GET['y']))

	$y = htmlspecialchars($_GET['y'], ENT_QUOTES);

else

	$y = date('Y');

	

mysql_select_db($database_skt, $skt);

$query_uskt = "SELECT * FROM user_skt WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND uskt_status = 1 AND uskt_date_y = '" . $y . "' ORDER BY uskt_masa_mula ASC, uskt_masa_tamat ASC, uskt_id ASC";

$uskt = mysql_query($query_uskt, $skt) or die(mysql_error());

$row_uskt = mysql_fetch_assoc($uskt);

$totalRows_uskt = mysql_num_rows($uskt);



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

      	<?php include('../inc/menu_skt.php');?>

      	  <div class="tabbox">

        	<div class="profilemenu">

            <ul>

            <?php if(getPP($row_user['user_stafid'])){?>

            	<li class="form_back">
            	</li>

                <li>

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <?php if ($totalRows_uskt > 0) { // Show if recordset not empty ?>

                    <tr>

                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>

                      <th width="100%" align="left" nowrap="nowrap">Aktiviti / Projek / Keterangan</th>

                      <th align="center" valign="middle" nowrap="nowrap">Tempoh</th>

                      <th align="center" valign="middle" nowrap="nowrap">Peratusan</th>

                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                       <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>

                    </tr>

                    <?php $i=1; do { ?>

                      <tr class="<?php if(checkFeedbackCancel($row_uskt['uskt_id'])) echo "offcourses"; else echo "on";?>">

                        <td align="center" valign="middle"><?php echo $i;?></td>

                        <td align="left" class="txt_line">

                        <div><a href="<?php echo $url_main;?>skt/sktdetail.php?id=<?php echo getID($row_uskt['uskt_id']); ?>"><?php echo substr($row_uskt['uskt_aktiviti'], 0, 100); if(strlen($row_uskt['uskt_aktiviti'])>100) echo "..."; ?></a>

                        </div>

                        <?php $ftid = getFeedbackIDLatest($row_user['user_stafid'], $row_uskt['uskt_id']); if($ftid!=NULL){?>

                        <div class="inputlabel2 txt_color3">Kemaskini : <?php echo getFeedbackDate($ftid);?> oleh <?php echo getFullNameByStafID(getFeedbackBy($ftid)) . " (" . getFeedbackBy($ftid) . ")";?> <?php echo getPPType(getPPTypeByStafID($row_user['user_stafid'], getFeedbackBy($ftid)));?></div>

                        <?php }; ?>

                        </td>

                        <td align="center" valign="middle" nowrap="nowrap" class="txt_line"><?php echo date('M Y', mktime(0, 0, 0, getSKTMasaMula($row_uskt['uskt_id']), 1, $row_uskt['uskt_date_y']));?> - <?php echo date('M Y', mktime(0, 0, 0, getSKTMasaTamat($row_uskt['uskt_id']), 1, $row_uskt['uskt_date_y']));?> <br /> (<?php echo getSKTTempoh($row_uskt['uskt_id']);?> Bulan)</td>

                        <td align="center" valign="middle">

                        <?php if(getFeedbackLatest($row_user['user_stafid'], $row_uskt['uskt_id'], '3')==100){?>

                        <img src="<?php echo $url_main;?>icon/sign_tick.png" width="16" height="16" alt="Sukses" />

                        <?php } elseif(checkFeedbackCancel($row_uskt['uskt_id'])) { ?>

                        <img src="<?php echo $url_main;?>icon/sign_error.png" width="16" height="16" alt="Gugur" />

                        <?php } else {?>

                        <div class="barcolor_red">

                            <div class="barcolor_blue" style="width: <?php echo getFeedbackLatest($row_user['user_stafid'], $row_uskt['uskt_id'], '3');?>%;">&nbsp;</div>

                            <div class="barcolor_percent"><?php echo getFeedbackLatest($row_user['user_stafid'], $row_uskt['uskt_id'], '3');?>%</div>

                        </div>

						<?php }; ?>

                        </td>

                        <td align="center" valign="middle" nowrap="nowrap">

                        <ul class="func">

                          <?php if(!checkFeedbackCancel($row_uskt['uskt_id']) && !checkFeedbackLatest(0, $row_uskt['uskt_id'], 0)){?>

                          <li><a href="<?php echo $url_main;?>skt/sktedit.php?id=<?php echo getID($row_uskt['uskt_id']); ?>">Edit</a></li>

                          <?php }; ?>

                        </ul></td>
                        <td><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo $row_uskt['uskt_aktiviti']; ?>')" href="<?php echo $url_main;?>sb/del_skt.php?id=<?php echo $row_uskt['uskt_id'];?>">X</a></li></td>

                      </tr>

                      <?php $i++; } while ($row_uskt = mysql_fetch_assoc($uskt)); ?>

                      <tr class="back_lightgrey">

                        <td align="center" valign="middle" class="line_t">&nbsp;</td>

                        <td align="left" class="txt_line line_t"><strong>Purata</strong></td>

                        <td align="center" valign="middle" nowrap="nowrap" class="txt_line line_t">&nbsp;</td>

                        <td align="center" valign="middle" class="line_t">

                        <div class="barcolor_red">

                            <div class="barcolor_blue" style="width:  <?php echo getSKTAveragePercent($row_user['user_stafid'], $y);?>%;">&nbsp;</div>

                            <div class="barcolor_percent"><?php echo getSKTAveragePercent($row_user['user_stafid'], $y);?>%</div>

                        </div>

                        </td>

                        <td align="center" valign="middle" nowrap="nowrap" class="line_t">&nbsp;</td>
                        <td align="center" valign="middle" nowrap="nowrap" class="line_t">&nbsp;</td>

                      </tr>

                    <tr>

                      <td colspan="7" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_uskt ?> rekod dijumpai</td>

                    </tr>

                  <?php } else { ?>

                    <tr>

                      <td colspan="7" align="center" valign="middle" class="noline">&nbsp;</td>

                    </tr>

                  <?php }; ?>

                  </table>

                </li>

                <li></li>

                <?php } else { ?>

                <li></li>

                <?php }; ?>

                 <li>&nbsp;</li>

                <li class="title">Laporan Penilaian Prestasi Tahunan (LNPT)</li>

                <li>

                 <div class="note">Perhatian:-</div>

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr><td colspan="2">1. Borang LNPT boleh dimuat turun mengikut kategori Gred pada pautan berikut:-</td></tr>

				  <?php if(getGredByStafID($row_user['user_stafid'])>='7JUSA' && getGredByStafID($row_user['user_stafid'])<='7JUSA') { ?>

                <tr>
                
                
                <td><img src="../icon/download.png" alt="Lampiran" title="Lampiran"/></td>

<td width="100%" nowrap="nowrap">-- <a href="LNPTJUSA.pdf" target="_blank"><strong>Borang LNPT (JUSA) (MERAH JAMBU)</strong> --</a></td></tr>

                

				   <?php };

                 if(getGredByStafID($row_user['user_stafid'])>='41' && getGredByStafID($row_user['user_stafid'])<='54') {?>


                <td><img src="../icon/download.png" alt="Lampiran" title="Lampiran"/></td>

<td width="100%" nowrap="nowrap">-- <a href="LNPTProfesional.pdf" target="_blank"><strong>Borang LNPT (Gred 41-54) (HIJAU)</strong> --</a></td></tr>

                

				   <?php };

                 if(getGredByStafID($row_user['user_stafid'])>='17' && getGredByStafID($row_user['user_stafid'])<='38') {?>

                  <tr>
                  
                  

                  <td><img src="../icon/download.png" alt="Lampiran" title="Lampiran"/></td>

                  <td width="100%" nowrap="nowrap">-- <a href="LNPTSokongan1.pdf" target="_blank"><strong> Borang LNPT (Gred 17-38) (KUNING)</strong> --</a></td></tr>

                  <?php };

                 if(getGredByStafID($row_user['user_stafid'])>='1' && getGredByStafID($row_user['user_stafid'])<='16') {?>

                 <tr><td><img src="../icon/download.png" alt="Lampiran" title="Lampiran"/></td> <td width="100%" nowrap="nowrap">-- <a href="LNPTSokong2.pdf" target="_blank"><strong>Borang LNPT (Gred 1-16) (PEACH)</strong> --</a></td></tr>

                 <?php };?>

                <tr><td colspan="2">2. Maklum balas berkaitan LNPT boleh berhubung dengan <?php echo getDirSubName(getDirIDByMenuID($menu));?>.</td></tr>

                </table>

                </li>

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

mysql_free_result($uskt);

?>

<?php include('../inc/footinc.php');?> 