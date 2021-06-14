<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='7';?>
<?php $menu2='77';?>
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
<?php include('../inc/liload.php');?>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
      	<div class="content">
        <?php include('../inc/menu_unit.php');?>
        <div class="tabbox">
            <div class="profilemenu">
            <ul>
             <?php if(checkJob2View($row_user['user_stafid']) && $totalRows_leaveoffice>0){?>
                <li>
                <div class="note">Permohonan kebenaran meninggalkan pejabat dalam wktu pejabat</div>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td rowspan="2" align="center" valign="middle" nowrap="nowrap" class="noline"><?php echo viewProfilePic($row_leaveoffice['user_stafid']);?></td>
                     <td width="100%" align="left" valign="middle" class="noline"><div><strong><a href="am5babGdetail.php?id=<?php echo $row_leaveoffice['leaveoffice_id']; ?>"><?php echo getFullNameByStafID($row_leaveoffice['user_stafid']) . " (" . $row_leaveoffice['user_stafid'] . ")"; ?></a></strong></div>
                      <div><?php echo getFulldirectoryByUserID($row_leaveoffice['user_stafid']);?><?php echo " &nbsp; &bull; &nbsp; Ext : " . getExtNoByUserID($row_leaveoffice['user_stafid']);?></div>
                      </td>
                    </tr>
                  </table>
                </li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if(getReasonByLeaveOfficeID($row_leaveoffice['leaveoffice_id'])=='1' || getReasonByLeaveOfficeID($row_leaveoffice['leaveoffice_id'])=='2'){?>
                    <tr>
                      <td nowrap="nowrap" class="label">Kekerapan</td>
                      <td>kali ke <strong><?php echo getLeaveFrequencyByLeaveOfficeID($row_leaveoffice['leaveoffice_id'], $row_leaveoffice['leaveoffice_on_m'], $row_leaveoffice['leaveoffice_on_y']);?></strong> dalam bulan <?php echo date('M Y', mktime(0, 0, 0, $row_leaveoffice['leaveoffice_on_m'], $row_leaveoffice['leaveoffice_on_d'], $row_leaveoffice['leaveoffice_on_y']));?></td>
                    </tr>
                    <?php }; ?>
                    <tr>
                      <td nowrap="nowrap" class="label">Tarikh</td>
                      <td width="100%">
					  <?php echo getDateLeaveByLeaveOfficeID($row_leaveoffice['leaveoffice_id']); ?> 
                      </td>
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
                  <form id="form1" name="form1" method="post" action="../sb/update_am5babG.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 20px;">
                      <tr>
                        <td nowrap="nowrap" class="label">Kelulusan </td>
                        <td width="100%">
                        <ul class="inputradio">
                            <li><input name="app_status" type="radio" id="app_status_0" value="1" checked="checked" />Ya</li>
                            <li><input type="radio" name="app_status" value="2" id="app_status_1" />Tidak</li>
                            <?php if(($row_leaveoffice['leaveoffice_on_d']<=$row_leaveoffice['leaveoffice_date_d'] && $row_leaveoffice['leaveoffice_on_m']==$row_leaveoffice['leaveoffice_date_m'])||($row_leaveoffice['leaveoffice_on_m']<$row_leaveoffice['leaveoffice_date_m'])){?>
                             <li><input name="app_warning" type="checkbox" id="app_warning_0" value="1" />dengan amaran</li>
						   <?php }; ?>
                        </ul>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">Catatan *</td>
                        <td>
                        <span id="catatan">
                        <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                        <textarea name="app_note" rows="7" id="app_note"></textarea>
                        </span>
                        <div class="inputlabel2">Catatan ini akan dinyatakan dalam email</div>
                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>
                        <input name="id" type="hidden" id="id" value="<?php echo $row_leaveoffice['leaveoffice_id']; ?>" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Hantar" />
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" />
                        </td>
                      </tr>
                    </table>
                  </form>
              </li>

                <?php } else if($row_leaveoffice['app_status']==1){?>
                <li class="gap">&nbsp;</li>
<li class="form_back2 line_t">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>Pengesahan tempahan berdasarkan maklumat yang dinyatakan seperti diatas <strong>DILULUSKAN</strong> <?php if(checkWarningByLeaveOfficeID($row_leaveoffice['leaveoffice_id'])) echo "dengan <strong>AMARAN</strong>";?> pada <strong><?php echo $row_leaveoffice['app_date']; ?></strong></td>
                      </tr>
                    <tr>
                      <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center" valign="top"><?php echo viewProfilePic($row_leaveoffice['app_by']);?></td>
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
                      <td>Pengesahan permohonan kebenaran meninggalkan pejabat dalam waktu pejabat berdasarkan maklumat yang dinyatakan seperti diatas <strong>TIDAK DILULUSKAN </strong> <?php if(checkWarningByLeaveOfficeID($row_leaveoffice['leaveoffice_id'])) echo "dengan <strong>AMARAN</strong>";?> pada <strong><?php echo $row_leaveoffice['app_date']; ?></strong></td>
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
                  <?php }; ?>
                <?php } else { ?>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
                  </tr>
                </table>
				</li>
                <?php }; ?>
            </ul>
            </div>
        </div>
        <?php echo noteEmail('1');?>
      </div>
		<?php include('../inc/footer.php');?>
  </div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("catatan");
</script>
</body>
</html>
<?php
mysql_free_result($leaveoffice);
?>
<?php include('../inc/footinc.php');?> 