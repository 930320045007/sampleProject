<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='3';?>
<?php $menu2='78';?>
<?php
if(isset($_GET['id']))
	$wsql = " AND leaveoffice_id='" . getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0) . "'";
else
	$wsql = " AND leaveoffice_id='-1'";

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_leaveoffice = "SELECT * FROM www.leave_office WHERE leaveoffice_status = 1 " . $wsql . " ORDER BY leaveoffice_date_y DESC, leaveoffice_date_m DESC, leaveoffice_date_d DESC, leaveoffice_id DESC";
$leaveoffice = mysql_query($query_leaveoffice, $hrmsdb) or die(mysql_error());
$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
$totalRows_leaveoffice = mysql_num_rows($leaveoffice);

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
        
        <?php include('../inc/menu_leave.php');?>
        <div class="tabbox">
          <div class="profilemenu">
           <div class="note">Maklumat permohonan kebenaran meninggalkan pejabat dalam waktu pejabat</div>
                <ul>
                <?php if($totalRows_leaveoffice > 0 && $row_leaveoffice['user_stafid']==$row_user['user_stafid']) {?>
                	<li>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Tarikh</td>
                      <td width="200%"><?php echo getDateLeaveByLeaveOfficeID($row_leaveoffice['leaveoffice_id']); ?></td>
                    </tr>
                    <?php if(getReasonType(getReasonByLeaveOfficeID($row_leaveoffice['leaveoffice_id']))=='0'){?>
                    <tr>
                      <td nowrap="nowrap" class="label">Masa</td>
                      <td><?php echo getTimeLeaveByLeaveOfficeID($row_leaveoffice['leaveoffice_id']); ?> &nbsp; hingga &nbsp; <?php echo getTimeBackByLeaveOfficeID($row_leaveoffice['leaveoffice_id']); ?></td>
                    </tr>
                    <?php } elseif(getReasonType(getReasonByLeaveOfficeID($row_leaveoffice['leaveoffice_id']))=='1') { ?>
                    <tr>
                      <td nowrap="nowrap" class="label">Tempoh </td>
                      <td><?php echo getLeaveOfficeDayByLeaveOfficeID($row_leaveoffice['leaveoffice_id']); ?> <?php echo getDayType(getLeaveOfficeDayTypeByLeaveOfficeID($row_leaveoffice['leaveoffice_id']));?></td>
                    </tr>
                    <?php }; ?>
                    <tr>
                      <td nowrap="nowrap" class="label">Sebab</td>
                      <td><?php echo getReasonNameByID($row_leaveoffice['reason_id']);?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Catatan</td>
                      <td class="noline"><?php echo $row_leaveoffice['leaveoffice_note']; ?></td>
                    </tr>
                    </table>
                    </li>
                    <li class="gap">&nbsp;</li>
                    <?php if($row_leaveoffice['app_status']==0){?>
                    <li class="form_back2 line_t">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td colspan="3" class="noline"><img src="../icon/lock.png" alt="Pending" width="16" height="16" border="0" align="absbottom"> &nbsp; Permohonan kebenaran meninggalkan pejabat dalam waktu pejabat masih dalam proses menunggu kelulusan.</td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle" class="noline"><?php echo viewProfilePic($row_leaveoffice['app_by']);?></td>
                          <td width="100%" align="left" valign="middle" class="noline">
                              <div class="txt_size2">Keluluskan oleh</div>
                              <div><strong><?php echo getFullNameByStafID($row_leaveoffice['app_by']) . " (" . $row_leaveoffice['app_by'] . ")"; ?></strong></div>
                              <div><?php echo getFulldirectoryByUserID($row_leaveoffice['app_by']);?></div>
                          </td>
                        </tr>
                      </table>
                    </li>
                    <?php } else if($row_leaveoffice['app_status']==1){?>
                    <li class="form_back2 line_t">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td>Pengesahan tempahan berdasarkan maklumat yang dinyatakan seperti diatas <strong>DILULUSKAN</strong> <?php if(checkWarningByLeaveOfficeID($row_leaveoffice['leaveoffice_id'])) echo "dengan <strong>AMARAN</strong>";?> pada <strong><?php echo $row_leaveoffice['app_date']; ?></strong></td>
                        </tr>
                        <tr>
                          <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><?php echo viewProfilePic($row_leaveoffice['app_by']);?></td>
                              <td width="100%" class="txt_line">
                              <div class="txt_size2">Diluluskan oleh</div>
                              <div><strong><?php echo getFullNameByStafID($row_leaveoffice['app_by']) . " (" . $row_leaveoffice['app_by'] . ")"; ?></strong></div>
                              <div><?php echo getFulldirectoryByUserID($row_leaveoffice['app_by']);?></div>
                              </td>
                            </tr>
                          </table></td>
                        </tr>
                      </table>
                        <?php if($row_leaveoffice['app_note']!=NULL){?>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="label">Catatan</td>
                          <td width="100%"><?php echo $row_leaveoffice['app_note']; ?></td>
                        </tr>
                      </table>
                        <?php }; ?>
                    </li>
                    <?php } else if($row_leaveoffice['app_status']==2){ ?>
                    <li class="form_back2 line_t">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Pengesahan tempahan berdasarkan maklumat yang dinyatakan seperti diatas <strong>TIDAK DILULUSKAN</strong> <?php if(checkWarningByLeaveOfficeID($row_leaveoffice['leaveoffice_id'])) echo "dengan <strong>AMARAN</strong>";?> pada <strong><?php echo $row_leaveoffice['app_date']; ?></strong> pada <strong><?php echo $row_leaveoffice['app_date']; ?></strong></td>
                    </tr>
                    <tr>
                      <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center" valign="top"><?php echo viewProfilePic($row_leaveoffice['app_by']);?></td>
                          <td width="100%" class="txt_line"><div class="txt_size2">Tidak diluluskan oleh</div>
                            <div><strong><?php echo getFullNameByStafID($row_leaveoffice['app_by']) . " (" . $row_leaveoffice['app_by'] . ")"; ?></strong></div>
                            <div><?php echo getFulldirectoryByUserID($row_leaveoffice['app_by']);?></div></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                  <?php if($row_leaveoffice['app_note']!=NULL){?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Catatan</td>
                      <td width="100%"><?php echo $row_leaveoffice['app_note']; ?></td>
                    </tr>
                  </table>
                  <?php }; ?>
                </li>
                <?php } else { ?>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
                  </tr>
                </table>
				</li>
				<?php }; ?>
                <?php } else { ?>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline">Tiada rekod dijumpai</td>
                  </tr>
                </table>
                </li>
                <?php }; ?>
                </ul>
           </div>
          </div>
        </div>
  </div>  
		<?php include('../inc/footer.php');?>
</div>
</div>
</body>
</html>
<?php

mysql_free_result($leaveoffice);
?>
<?php include('../inc/footinc.php');?>
