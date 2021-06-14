<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='3';?>
<?php $menu2='17';?>
<?php
$colname_cutidate = "-1";
if (isset($_GET['id'])) {
  $colname_cutidate = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutidate = sprintf("SELECT * FROM user_leavedate WHERE userleavedate_id = %s ORDER BY userleavedate_id DESC", GetSQLValueString($colname_cutidate, "int"));
$cutidate = mysql_query($query_cutidate, $hrmsdb) or die(mysql_error());
$row_cutidate = mysql_fetch_assoc($cutidate);
$totalRows_cutidate = mysql_num_rows($cutidate);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<?php echo getPassBoxC('formPasswordc', $url_main . "sb/leave_ER.php?id=" . $colname_cutidate, $url_main . "leave/detail.php?id=" . $colname_cutidate);?>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_leave.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
            	<li>
                <div class="note">Maklumat lengkap berkaitan permohonan cuti</div>
                </li>
            	<?php if($totalRows_cutidate>0 && $row_cutidate['user_stafid']==$row_user['user_stafid']){?>
                <li class="line_b">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Tarikh</td>
                      <td><?php echo $row_cutidate['userleavedate_date_d']; ?>/<?php echo $row_cutidate['userleavedate_date_m']; ?>/<?php echo $row_cutidate['userleavedate_date_y']; ?> (<?php echo date("D", mktime(0, 0, 0, $row_cutidate['userleavedate_date_m'], $row_cutidate['userleavedate_date_d'], $row_cutidate['userleavedate_date_y']));?>)</td>
                    </tr>
                    <tr>
                      <td class="label">Perkara</td>
                      <td><?php echo getLeaveTitle($row_cutidate['user_stafid'], 1, $row_cutidate['userleavedate_date_d'], $row_cutidate['userleavedate_date_m'], $row_cutidate['userleavedate_date_y'], $colname_cutidate);?></td>
                    </tr>
                    <tr>
                      <td class="label noline">Catatan</td>
                      <td class="noline"><?php echo getLeaveNote($row_cutidate['user_stafid'], 1, $row_cutidate['userleavedate_date_d'], $row_cutidate['userleavedate_date_m'], $row_cutidate['userleavedate_date_y'], $colname_cutidate);?></td>
                    </tr>
                  </table>
                </li>
            <?php if($row_cutidate['userleavedate_app']==1){?>
                <li class="form_back2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline"><img src="../icon/sign_tick.png" width="16" height="16" alt="Not Approval" /></td>
                      <td width="100%" class="noline">Permohonan cuti telah diluluskan oleh <strong><?php echo getFullNameByStafID($row_cutidate['userleavedate_appby']); ?></strong> pada <?php echo $row_cutidate['userleavedate_appdate']; ?></td>
                      <td class="noline"><input name="button3" type="button" class="cancelbutton" id="button3" value="Kembali" onclick="MM_goToURL('parent','<?php echo $url_main;?>leave/report.php');return document.MM_returnValue"/></td>
                    </tr>
                  </table>
                </li>
                <?php } else if ($row_cutidate['userleavedate_app']==0){?>
                <li class="form_back2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline"><img src="../icon/lock.png" width="16" height="16" alt="Not Approval" /></td>
                      <td width="100%" class="noline">Permohonan cuti masih belum diluluskan oleh <?php echo "<strong>" . getFullNameByStafID($row_cutidate['userleavedate_head']) . " (" . $row_cutidate['userleavedate_head'] . ")</strong>, " . getFulldirectoryByUserID($row_cutidate['userleavedate_head']); ?></td>
                      <td class="noline"><input name="button3" type="button" class="cancelbutton" id="button3" value="Kembali" onclick="MM_goToURL('parent','<?php echo $url_main;?>leave/report.php');return document.MM_returnValue"/></td>
                    </tr>
                  </table>
                </li>
                <?php } else if($row_cutidate['userleavedate_app']==2){ ?>
                <li class="form_back2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline"><img src="../icon/sign_error.png" width="16" height="16" alt="Not Approval" /></td>
                      <td width="100%" class="noline">Permohonan cuti tidak diluluskan oleh <strong><?php echo getFullNameByStafID($row_cutidate['userleavedate_appby']); ?></strong> pada <?php echo $row_cutidate['userleavedate_appdate']; ?></td>
                      <td class="noline"><input name="button3" type="button" class="cancelbutton" id="button3" value="Kembali" onclick="MM_goToURL('parent','<?php echo $url_main;?>leave/report.php');return document.MM_returnValue"/></td>
                    </tr>
                  </table>
                </li>
                <?php } else if($row_cutidate['userleavedate_head']==NULL && $row_cutidate['userleavedate_app']==0) { ?>
                <li class="form_back2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline"><img src="../icon/sign_error.png" width="16" height="16" alt="Not Approval" /></td>
                      <td width="100%" class="noline">Kelulusan tidak dapat dikenal pasti. <?php if($sendemailfunc){?> Hantar laporan berkaitan perkara ini kepada <?php echo $adname;?>, klik butang 'Error Report' disebelah kanan.<?php }; ?></td>
                       <?php if($sendemailfunc){?>
                      <td class="noline"><input name="button3" type="button" class="submitbutton" id="button3" value="Error Report" onclick="toggleview2('formPasswordc'); return false;"/></td>
                      <?php }; ?>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
                <?php } else { ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle" class="noline"> Tiada rekod dijumpai</td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
          	</ul>
          </div>
        </div>
        <?php if($row_cutidate['userleavedate_head']==NULL) { ?>
        	<?php echo noteEmail('1'); ?>
        <?php }; ?>
        </div>
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($cutidate);
?>
<?php include('../inc/footinc.php');?> 