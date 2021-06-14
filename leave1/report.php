<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='3';?>
<?php $menu2='17';?>
<?php
if(isset($_POST['tahun']) && $_POST['tahun']!=0)
	$dateyear = htmlspecialchars($_POST['tahun'], ENT_QUOTES);
else
	$dateyear = date('Y');
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cuti = "SELECT * FROM user_leave WHERE userleave_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' AND userleave_year = '" . $dateyear . "' ORDER BY leavetype_id ASC, userleave_year DESC, userleave_month DESC, userleave_day DESC, userleave_id DESC";
$cuti = mysql_query($query_cuti, $hrmsdb) or die(mysql_error());
$row_cuti = mysql_fetch_assoc($cuti);
$totalRows_cuti = mysql_num_rows($cuti);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_usercuti = "SELECT * FROM user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' AND leavetype_id = '1'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC, userleavedate_id DESC";
$usercuti = mysql_query($query_usercuti, $hrmsdb) or die(mysql_error());
$row_usercuti = mysql_fetch_assoc($usercuti);
$totalRows_usercuti = mysql_num_rows($usercuti);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutisakit = "SELECT * FROM user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' AND leavetype_id = '2'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";
$cutisakit = mysql_query($query_cutisakit, $hrmsdb) or die(mysql_error());
$row_cutisakit = mysql_fetch_assoc($cutisakit);
$totalRows_cutisakit = mysql_num_rows($cutisakit);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutitanparekod = "SELECT * FROM user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' AND leavetype_id = '4'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";
$cutitanparekod = mysql_query($query_cutitanparekod, $hrmsdb) or die(mysql_error());
$row_cutitanparekod = mysql_fetch_assoc($cutitanparekod);
$totalRows_cutitanparekod = mysql_num_rows($cutitanparekod);

if(getGenderIDByUserID($row_user['user_stafid'])==2)
{
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutibersalin = "SELECT * FROM user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' AND leavetype_id = '5' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";
$cutibersalin = mysql_query($query_cutibersalin, $hrmsdb) or die(mysql_error());
$row_cutibersalin = mysql_fetch_assoc($cutibersalin);
$totalRows_cutibersalin = mysql_num_rows($cutibersalin);
}


mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutikuarantin= "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $row_user['user_stafid'] ."' AND leavetype_id = '11'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

$cutikuarantin = mysql_query($query_cutikuarantin, $hrmsdb) or die(mysql_error());

$row_cutikuarantin = mysql_fetch_assoc($cutikuarantin);

$totalRows_cutikuarantin = mysql_num_rows($cutikuarantin);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutitanpagaji = "SELECT * FROM user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' AND leavetype_id = '6'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";
$cutitanpagaji = mysql_query($query_cutitanpagaji, $hrmsdb) or die(mysql_error());
$row_cutitanpagaji = mysql_fetch_assoc($cutitanpagaji);
$totalRows_cutitanpagaji = mysql_num_rows($cutitanpagaji);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutimelebihikelayakkan = "SELECT * FROM user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' AND leavetype_id = '7'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";
$cutimelebihikelayakkan = mysql_query($query_cutimelebihikelayakkan, $hrmsdb) or die(mysql_error());
$row_cutimelebihikelayakkan = mysql_fetch_assoc($cutimelebihikelayakkan);
$totalRows_cutimelebihikelayakkan = mysql_num_rows($cutimelebihikelayakkan);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutiseparuhgaji = "SELECT * FROM user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' AND leavetype_id = '10'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";
$cutiseparuhgaji = mysql_query($query_cutiseparuhgaji, $hrmsdb) or die(mysql_error());
$row_cutiseparuhgaji = mysql_fetch_assoc($cutiseparuhgaji);
$totalRows_cutiseparuhgaji = mysql_num_rows($cutiseparuhgaji);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutikuarantin = "SELECT * FROM user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' AND leavetype_id = '11'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";
$cuticutikuarantin = mysql_query($query_cutikuarantin, $hrmsdb) or die(mysql_error());
$row_cutikuarantin = mysql_fetch_assoc($cuticutikuarantin);
$totalRows_cutikuarantin = mysql_num_rows($cuticutikuarantin);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div class="passbox_back hidden2" id="cuti">
    <div class="passbox_form">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
            <tr>
              <td class="title">Langgan Rekod Cuti Rehat Tahun <?php echo date('Y');?></td>
            </tr>
            <tr>
              <td class="txt_line">
              <div>Pindah turun atau langgan rekod Cuti Rehat bagi tahun <?php echo date('Y');?> melalui URL berikut : </div>
              <div><a href="<?php echo $url_main;?>csv/cuti.php?id=<?php echo getID($row_user['user_stafid']);?>&y=<?php echo date('Y');?>"><em><?php echo $url_main;?>csv/cuti.php?id=<?php echo getID($row_user['user_stafid']);?>&y=<?php echo date('Y');?></em></a></div>
              </td>
            </tr>
            <tr>
              <td>
              <input name="OK" type="button" class="submitbutton" value="OK" onclick="toggleview2('cuti'); return false;" />
              </td>
            </tr>
          </table>
    </div>
</div>
<div>
	<div>
		<?php include('../inc/header.php');?>
      <?php include('../inc/menu.php');?>
   	  <div class="content">
        <?php include('../inc/menu_leave.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
                <li class="form_back">
                  <form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="noline label">Tahun</td>
                        <td width="100%" class="noline"><label for="tahun"></label>
                          <select name="tahun" id="tahun">
                          <?php for($i=date('Y'); $i>=2011; $i--){?>
                            <option <?php if($dateyear==$i) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li class="title">Jumlah Peruntukan Cuti Rehat &sup1;</li>
                <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_cuti > 0) { // Show if recordset not empty ?>
<tr>
                      <th nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tamat</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="<?php if($row_cuti['leavetype_id']!='1' && !checkDatePast(getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 3), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 2), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'],1))) echo "offcourses"; else echo "on";?>">
                        <td><?php echo $i; ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php if($row_cuti['leavetype_id']!='1'){?><?php echo $row_cuti['userleave_day']; ?>/<?php echo $row_cuti['userleave_month']; ?>/<?php }; ?><?php echo $row_cuti['userleave_year']; ?></td>
                        <td><?php echo getLeaveType($row_cuti['leavetype_id']); ?> &nbsp; <span class="txt_color1"><?php echo shortText($row_cuti['userleave_note']); ?></span></td>
                        <td align="center" valign="middle" nowrap="nowrap"> &nbsp; <?php if($row_cuti['leavetype_id']==3) echo getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id']);?> &nbsp; </td>
                        <td align="center" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo $row_cuti['userleave_annual']; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cuti = mysql_fetch_assoc($cuti)); ?>
                      <tr>
                        <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                        <td align="center" valign="middle" nowrap="nowrap" class="back_lightgrey line_t"><strong><?php echo getTotalAllLeave($row_user['user_stafid'],$dateyear);?></strong></td>
                      </tr>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cuti ?>  rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
               </div>
               <div class="inputlabel2 note">Cuti Ganti hanya sah dalam tempoh tiga (3) bulan dari tarikh kelulusan dalam tahun semasa</div>
            </li>
                <li class="title">Permohonan Cuti Rehat  <span class="fr add cursorpoint" onclick="toggleview2('cuti'); return false;">Langgan</span></li>
                <li>
                <div class="note">Berikut merupakan rekod permohonan sepanjang tahun <?php echo $dateyear;?></div>
                <div>
            	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
            	    <tr>
            	      <td align="center" class="icon_pad1"><img src="../icon/bag.png" width="48" height="48" alt="iD" /></td>
            	      <td class="line_r w50 txt_line"><div>Baki Cuti Rehat / Tahunan + Cuti Ganti<?php if(getDesignationType($row_user['user_stafid'])) echo " + Cuti Dibawa Kehadapan";?>  &sup1;</div>
                      <div class="txt_size1"><?php echo countLeaveBalance($row_user['user_stafid'],date('Y'));?> <span class="txt_size2">Hari</span></div></td>
            	      <td class="icon_pad1"><?php echo viewProfilePic(getHeadIDByUserID($row_user['user_stafid']));?></td>
            	      <td class="w50 txt_line">
                      <div>Kelulusan cuti oleh &sup1;</div>
                      <div><strong><?php echo getFullNameByStafID(getHeadIDByUserID($row_user['user_stafid'])) . " (" . getHeadIDByUserID($row_user['user_stafid']) . ")";?></strong></div>
                      <div class="txt_color1 txt_size2"><?php echo getJobtitle2(getHeadIDByUserID($row_user['user_stafid'])) . " " . getFulldirectoryByUserID(getHeadIDByUserID($row_user['user_stafid']));?></div>
                      </td>
          	      </tr>
          	    </table>
                </div>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_usercuti > 0) { // Show if recordset not empty ?>
<tr>
                      <th nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Amaran *</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                  </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_y'])); ?></td>
                        <td class="txt_line">
                        <a href="detail.php?id=<?php echo getID($row_usercuti['userleavedate_id']); ?>">
						<div>
						<?php echo getLeaveCategory($row_usercuti['leavecategory_id']); ?> - <?php echo getLeaveTitle($row_usercuti['user_stafid'], 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y'], $row_usercuti['userleavedate_id']);?> &nbsp; <span class="txt_color1"><?php echo shortText(getLeaveNote($row_usercuti['user_stafid'], 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y'], $row_usercuti['userleavedate_id']));?> <?php if($row_usercuti['userleavedate_app']==1){?></span>
                        </div>
                        
                        <div>
                        <span class="txt_color1">Diluluskan oleh <?php echo getFullNameByStafID($row_usercuti['userleavedate_appby']); ?> pada <?php echo $row_usercuti['userleavedate_appdate']; ?><?php } else if($row_usercuti['userleavedate_app']==2){?> &nbsp; &bull; &nbsp; Tidak diluluskan oleh <?php echo getFullNameByStafID($row_usercuti['userleavedate_appby']); ?> pada <?php echo $row_usercuti['userleavedate_appdate']; ?><?php }; ?>
                        </span>
                        </div>
                        </a>
                        </td>
                        <td align="center" valign="middle"><?php viewIconLeave($row_usercuti['user_stafid'], $row_usercuti['userleavedate_id'], 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y']);?></td>
                        <td align="center" valign="middle"><?php viewIconNotice($row_usercuti['user_stafid'], $row_usercuti['userleavedate_id'], 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y']);?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php if($row_usercuti['userleavedate_app']==0) echo "1 **"; else if($row_usercuti['userleavedate_app']==1) echo "1"; else if($row_usercuti['userleavedate_app']==2) echo "-";?></td>
                      </tr>
                      <?php $i++; } while ($row_usercuti = mysql_fetch_assoc($usercuti)); ?>
                      <tr>
                        <td colspan="5" align="right" valign="middle" class="line_t noline"><strong>Jumlah Terkumpul</strong></td>
                        <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo calAllLeave($row_user['user_stafid'], $dateyear);?></strong></td>
                      </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_usercuti ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                 </div>
                 <div class="note">
                     <div class="inputlabel2">** Cuti hanya dikira sekiranya kelulusan telah dibuat oleh Pegawai Bertanggungjawab.</div>
                     <div class="inputlabel2">** Cuti yang masih belum mendapat kelulusan hanya dikira untuk permohonan cuti baru sahaja.</div>
                     <div class="inputlabel2">* Satu (1) notis akan dihantar kepada <?php echo $adname;?> bagi 3 kali amaran terkumpul untuk tahunan semasa.</div>
                     <div class="inputlabel2">Sebarang pindaan atau pengemaskinian rekod Cuti Rehat perlu berhubung dengan <?php echo $adname;?>.</div>
                 </div>
                </li>
                <li>&nbsp;</li>
                <li class="title">Cuti Sakit &sup1;</li>
                <li>
                <?php if(getDesignationType($row_user['user_stafid'])){ ?>
                <div>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countELBalance($row_user['user_stafid'], $dateyear, 1);?></div><div>Hari</div></td>
                      <td align="left" valign="middle" class="line_r txt_line"><div>Baki Cuti Sakit</div><div class="txt_color1">Melalui Klinik Kerajaan</div></td>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countELBalance($row_user['user_stafid'], $dateyear, 2);?></div><div>Hari</div></td>
                      <td align="left" valign="middle" class="txt_line"><div>Baki Cuti Sakit</div><div class="txt_color1">Melalui Klinik Swasta</div></td>
                    </tr>
                  </table>
                </div>
                <?php } else { ?>
                <div class="note">Cuti Sakit yang diperuntukan sebanyak <strong><?php echo getEL($row_user['user_stafid']);?> Hari</strong> sahaja bagi tahun <?php echo $dateyear;?></div>
                <?php }; ?>
                  <div class="off">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php if ($totalRows_cutisakit > 0) { // Show if recordset not empty ?>
                      <tr>
                        <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                        <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                        <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                        <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      </tr>
                      <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_cutisakit['userleavedate_date_d']; ?>/<?php echo $row_cutisakit['userleavedate_date_m']; ?>/<?php echo $row_cutisakit['userleavedate_date_y']; ?></td>
                        <td align="left" valign="middle" class="txt_line"><?php echo "Klinik " . getClinicTypeName($row_cutisakit['clinictype_id']); ?> &nbsp; &bull; &nbsp; <?php echo getLeaveTitle($row_cutisakit['user_stafid'],2,$row_cutisakit['userleavedate_date_d'],$row_cutisakit['userleavedate_date_m'],$row_cutisakit['userleavedate_date_y']); ?> <span class="txt_color1"> &nbsp; &bull; &nbsp; Oleh <?php echo getFullNameByStafID($row_cutisakit['userleavedate_by']); ?> pada <?php echo $row_cutisakit['userleavedate_date']; ?></span></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutisakit['userleavedate_day']; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutisakit = mysql_fetch_assoc($cutisakit)); ?>
                      <tr>
                        <td colspan="3" align="right" class="noline"><strong>Jumlah Terkumpul</strong></td>
                        <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo countEL($row_user['user_stafid'], $dateyear);?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center" class="noline txt_color1"><?php echo $totalRows_cutisakit ?> rekod dijumpai</td>
                      </tr>
                      <?php } else { ?>
                      <tr>
                        <td colspan="4" align="center" class="noline">Tiada rekod dijumpai</td>
                      </tr>
                      <?php }; ?>
                    </table>
                  </div>
                </li>
                <li class="title">Cuti Tanpa Rekod &sup1;</li>
                <li>
                  <div class="note">Cuti Tanpa Rekod yang diperuntukan <strong><?php echo getLeaveWOR($row_user['user_stafid'], $dateyear);?> Hari</strong> bagi tahun <?php echo date('Y');?></div>
                  <div class="off">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php if ($totalRows_cutitanparekod > 0) { // Show if recordset not empty ?>
                      <tr>
                        <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                        <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                        <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                        <th nowrap="nowrap">Tamat</th>
                        <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      </tr>
                      <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_cutitanparekod['userleavedate_date_d']; ?>/<?php echo $row_cutitanparekod['userleavedate_date_m']; ?>/<?php echo $row_cutitanparekod['userleavedate_date_y']; ?></td>
                        <td align="left" valign="middle" class="txt_line"><?php echo getLeaveCategory($row_cutitanparekod['leavecategory_id']); ?> &nbsp; <span class="txt_color1"> &nbsp; <?php echo shortText($row_cutitanparekod['userleavedate_note']); ?> &nbsp; &bull; &nbsp; Oleh <?php echo getFullNameByStafID($row_cutitanparekod['userleavedate_by']); ?> pada <?php echo $row_cutitanparekod['userleavedate_date']; ?> </span></td>
                        <td><?php echo countLeaveWOREndDate($row_cutitanparekod['userleavedate_id']);?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo getLeaveWORDay($row_cutitanparekod['userleavedate_id']); ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutitanparekod = mysql_fetch_assoc($cutitanparekod)); ?>
                      <tr>
                        <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                        <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo countLeaveWOR($row_user['user_stafid'], $dateyear);?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutitanparekod ?> rekod dijumpai</td>
                      </tr>
                      <?php } else {?>
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                      </tr>
                      <?php }; ?>
                    </table>
                  </div>
                </li>
    			<?php if(getGenderIDByUserID($row_user['user_stafid'])==2){ ?>
                <li class="title">Cuti Bersalin &sup1;</li>
                <li>
                <div class="note">Cuti Bersalin yang diperuntukan adalah <strong><?php echo getLeaveBirth($row_user['user_stafid']);?> Hari</strong> sepanjang tempoh perkhidmatan.</div>
  				<div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_cutibersalin > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Anak</th>
                      <th nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_cutibersalin['userleavedate_date_d']; ?>/<?php echo $row_cutibersalin['userleavedate_date_m']; ?>/<?php echo $row_cutibersalin['userleavedate_date_y']; ?></td>
                        <td align="left" valign="middle" class="txt_line"><?php echo getLeaveCategory($row_cutibersalin['leavecategory_id']); ?> &nbsp; <span class="txt_color1"> &nbsp; <?php echo shortText($row_cutibersalin['userleavedate_note']); ?> &nbsp; &bull; &nbsp; Oleh <?php echo getFullNameByStafID($row_cutibersalin['userleavedate_by']); ?> pada <?php echo $row_cutibersalin['userleavedate_date']; ?> </span></td>
                        <td align="center" valign="middle"><?php echo $row_cutibersalin['userleavedate_sonby']; ?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo getLeaveBirthDay($row_cutibersalin['userleavedate_id']);?></td>
                      </tr>
                      <?php $i++; } while ($row_cutibersalin = mysql_fetch_assoc($cutibersalin)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo countLeaveBirth($row_user['user_stafid']);?></strong></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutibersalin ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                <?php }; ?>
                
                <li class="title">Cuti Kuarantin &sup1;</li>
                <li>
  				<div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_cutikuarantin > 0) { // Show if recordset not empty ?>
                <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="left" valign="middle" nowrap="nowrap">Amaran</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                  </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date("d/m/Y (D)", mktime(0, 0, 0, $row_cutikuarantin['userleavedate_date_m'], $row_cutikuarantin['userleavedate_date_d'], $row_cutikuarantin['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle" class="txt_line"><?php echo getLeaveCategory($row_cutikuarantin['leavecategory_id']); ?> &nbsp; <span class="txt_color1"><?php echo shortText($row_cutikuarantin['userleavedate_note']); ?> &nbsp; &bull; &nbsp; Oleh <?php echo getFullNameByStafID($row_cutikuarantin['userleavedate_by']); ?> pada <?php echo $row_cutikuarantin['userleavedate_date']; ?> </span></td>
                        <td align="center" valign="middle">
                          <?php if($row_cutikuarantin['userleavedate_notice']==1) echo "<img src=\"" . $url_main . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Notice\" />"; else echo ""; ?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutikuarantin['userleavedate_day']; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutikuarantin = mysql_fetch_assoc($cutikuarantin)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo getLeaveKuarantin($row_user['user_stafid'], $dateyear);?></strong></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutikuarantin ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                   
                <li class="title">Cuti Tanpa Gaji &sup1;</li>
                <li>
  				<div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_cutitanpagaji > 0) { // Show if recordset not empty ?>
                <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="left" valign="middle" nowrap="nowrap">Amaran</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                  </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date("d/m/Y (D)", mktime(0, 0, 0, $row_cutitanpagaji['userleavedate_date_m'], $row_cutitanpagaji['userleavedate_date_d'], $row_cutitanpagaji['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle" class="txt_line"><?php echo getLeaveCategory($row_cutitanpagaji['leavecategory_id']); ?> &nbsp; <span class="txt_color1"><?php echo shortText($row_cutitanpagaji['userleavedate_note']); ?> &nbsp; &bull; &nbsp; Oleh <?php echo getFullNameByStafID($row_cutitanpagaji['userleavedate_by']); ?> pada <?php echo $row_cutitanpagaji['userleavedate_date']; ?> </span></td>
                        <td align="center" valign="middle">
                          <?php if($row_cutitanpagaji['userleavedate_notice']==1) echo "<img src=\"" . $url_main . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Notice\" />"; else echo ""; ?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutitanpagaji['userleavedate_day']; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutitanpagaji = mysql_fetch_assoc($cutitanpagaji)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo getLeaveWOS($row_user['user_stafid'], $dateyear);?></strong></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutitanpagaji ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                <li class="title">Cuti Melebihi Kelayakkan &sup1;</li>
                <li>
  				<div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <?php if ($totalRows_cutimelebihikelayakkan > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="left" valign="middle" nowrap="nowrap">Amaran</th>
                      <th nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date("d/m/Y (D)", mktime(0, 0, 0, $row_cutimelebihikelayakkan['userleavedate_date_m'], $row_cutimelebihikelayakkan['userleavedate_date_d'], $row_cutimelebihikelayakkan['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle" class="txt_line"><?php echo getLeaveCategory($row_cutimelebihikelayakkan['leavecategory_id']); ?> &nbsp; <span class="txt_color1"> &nbsp; <?php echo $row_cutimelebihikelayakkan['userleavedate_note']; ?> &nbsp; &bull; &nbsp; Oleh <?php echo getFullNameByStafID($row_cutimelebihikelayakkan['userleavedate_by']); ?> pada <?php echo $row_cutimelebihikelayakkan['userleavedate_date']; ?> </span></td>
                        <td align="left" valign="middle">
                                    <?php if($row_cutimelebihikelayakkan['userleavedate_notice']==1) echo "<img src=\"" . $url_main . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Notice\" />"; else echo ""; ?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutimelebihikelayakkan['userleavedate_day']; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutimelebihikelayakkan = mysql_fetch_assoc($cutimelebihikelayakkan)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo getLeaveMTQ($row_user['user_stafid'], $dateyear);?></strong></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutimelebihikelayakkan ?> rekod dijumpai</td>
                    </tr>
                  <?php } else {?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                <li class="title">Cuti Separuh Gaji &sup1;</li>
                <li>
  				<div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_cutiseparuhgaji > 0) { // Show if recordset not empty ?>
                <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="left" valign="middle" nowrap="nowrap">Amaran</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                  </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date("d/m/Y (D)", mktime(0, 0, 0, $row_cutiseparuhgaji['userleavedate_date_m'], $row_cutiseparuhgaji['userleavedate_date_d'], $row_cutiseparuhgaji['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle" class="txt_line"><?php echo getLeaveCategory($row_cutiseparuhgaji['leavecategory_id']); ?> &nbsp; <span class="txt_color1"><?php echo shortText($row_cutiseparuhgaji['userleavedate_note']); ?> &nbsp; &bull; &nbsp; Oleh <?php echo getFullNameByStafID($row_cutiseparuhgaji['userleavedate_by']); ?> pada <?php echo $row_cutiseparuhgaji['userleavedate_date']; ?> </span></td>
                        <td align="center" valign="middle">
                          <?php if($row_cutiseparuhgaji['userleavedate_notice']==1) echo "<img src=\"" . $url_main . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Notice\" />"; else echo ""; ?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutiseparuhgaji['userleavedate_day']; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutiseparuhgaji = mysql_fetch_assoc($cutiseparuhgaji)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo getLeaveWOS($row_user['user_stafid'], $dateyear);?></strong></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutiseparuhgaji ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
            </ul>
          </div>
         </div>
        <?php echo noteHR('1'); ?>
        <?php echo noteEmail('1'); ?>
  </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($usercuti);

mysql_free_result($cutisakit);

mysql_free_result($cutitanparekod);

mysql_free_result($cutikuarantin);

if(getGenderIDByUserID($row_user['user_stafid'])==2)
	mysql_free_result($cutibersalin);

mysql_free_result($cutitanpagaji);

mysql_free_result($cutimelebihikelayakkan);

mysql_free_result($cuti);

mysql_free_result($cutiseparuhgaji);
?>
<?php include('../inc/footinc.php');?> 