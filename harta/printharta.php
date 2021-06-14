<?php require_once('../Connections/hrmsdb.php'); ?>

<?php include('../inc/user.php');?>

<?php include('../inc/func.php');?>

<?php $menu='4';?>

<?php $menu2='13';?>

<?php

if(isset($_POST['userreport_date_m']))
{
	$wsql .= " AND userreport_date_m = '" . $_POST['userreport_date_m'] . "'";
	$dm = $_POST['userreport_date_m'];
} else {
	$wsql .= " AND userreport_date_m = '" . date('m') . "'";
	$dm = date('m');
}

if(isset($_POST['userreport_date_y']))
{
	$wsql .= " AND userreport_date_y = '" . $_POST['userreport_date_y'] . "'";
	$dy = $_POST['userreport_date_y'];
} else {
	$wsql .= " AND userreport_date_y = '" . date('Y') . "'";
	$dy = date('Y');
}

mysql_select_db($database_hartadb, $hartadb);
$query_ur = "SELECT * FROM harta.user_report WHERE userreport_status = 1 " . $wsql . " ORDER BY userreport_date_y DESC, userreport_date_m DESC, userreport_date_d DESC, userreport_id DESC";
$ur = mysql_query($query_ur, $hartadb) or die(mysql_error());
$row_ur = mysql_fetch_assoc($ur);
$totalRows_ur = mysql_num_rows($ur);
?>


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300' rel='stylesheet' type='text/css'>
<link href="css/print.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">

<span>
                 <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tabborder">
        <tr>
                      <td align="center" valign="middle"><?php echo viewProfilePic($sid);?></td>
                      <td width="100%" align="left" valign="middle">
                        <div><strong><?php echo getFullNameByStafID($sid) . " (" . $sid . ")"; ?></strong></div>
                        <div class="txt_color1"><?php echo getJobtitle($sid) . " (" . getGred($sid) . ")";?></div>
                        <div class="txt_color1"><?php echo getFulldirectoryByUserID($sid);?></div>
                      </td>
                    </tr>
                    
                  </table>
                  <br />
               <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tabborder">
                  <?php if ($totalRows_report > 0) { // Show if recordset not empty ?>
                  <span class="note"><strong><?php echo date('M Y', mktime(0, 0, 0, $dm, 1, $dy));?></strong></span>
<div class="note"> Rekod aduan pada bulan</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_ur > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th align="center" valign="middle" nowrap="nowrap">No. Tiket</th>
                      <th width="100%" colspan="2" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                      <th align="center" valign="middle" nowrap="nowrap">Status</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pengesahan</th>
                    </tr>
                    <?php $i=1; do { ?>
                  <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap" class="txt_line"><?php echo getReportDate($row_ur['userreport_id'],1);?></td>
                    <td align="center" valign="middle"><?php echo getReportTicketByID($row_ur['userreport_id']); ?></td>
                        <td align="center" valign="top" class="txt_line"><?php echo viewProfilePic($row_ur['user_stafid']);?></td>
                        <td width="100%" align="left" valign="middle" class="txt_line">
                        <a href="reportdetail_admin.php?id=<?php echo $row_ur['userreport_id']; ?>">
                        <div><?php echo getCategoryNameByRCID($row_ur['rc_id']); ?> &nbsp; &bull; &nbsp; <?php echo getSubCategoryNameByRCID($row_ur['rc_id']); ?> &nbsp; &bull; &nbsp; <?php echo getRCTitleByID($row_ur['rc_id']);?></div>
                        <div>Lokasi : <?php echo getReportLocationByID($row_ur['userreport_id']);?></div>
                        <div>Oleh : <?php echo getFullNameByStafID($row_ur['user_stafid']) . " (" . $row_ur['user_stafid'] . ")"; ?>, Ext : <?php echo getExtNoByUserID($row_ur['user_stafid']);?></div>
                        <?php if(checkReportFeedbackByID($row_ur['userreport_id'])){?><div class="inputlabel2">Tindakan oleh <?php echo getFullNameByStafID(getFeedbackLastStafID($row_ur['userreport_id'])) . " (" . getFeedbackLastStafID($row_ur['userreport_id']) . ")";?> pada <?php echo getFeedbackLastDate($row_ur['userreport_id']);?></div><?php }; ?>
                        </a>
                        </td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php if(!checkReportFeedbackByID($row_ur['userreport_id'])) echo "<img src=\"" . $url_main . "icon/sign_error.png\" />";?></td>
                        <td align="center" valign="middle" nowrap="nowrap">
						<?php echo iconReportStatus($row_ur['userreport_id']);?>
						<?php if(countFeedbackLastDate($row_ur['userreport_id'])>0 && !checkFeedbackEnd($row_ur['userreport_id'])) 
						echo "<div class=\"txt_size2\">" . countFeedbackLastDate($row_ur['userreport_id']) . " Hari</div>";?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo iconReportAprrovalStatus($row_ur['userreport_id']);?></td>
                    </tr>
                    <?php $i++; } while ($row_ur = mysql_fetch_assoc($ur)); ?>
                    <tr>
                      <td colspan="8" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_ur ?>  rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="8" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
 <tr>
      <td colspan="5" align="center" valign="middle" class="noline"><span class="txt_line">Tiada rekod dijumpai, sila pastikan jumlah jam kursus dicapai dalam tempoh yang ditetapkan. <br/> Untuk maklumat / pertanyaan lanjut berkaitan kursus, sila berhubung dengan <?php echo $GLOBALS['adname'];?>.</span></td>
  </tr>
    <?php }; ?>
  </table>
</body>
</html>
<?php
?>
<?php include('inc/footinc.php');?> 
