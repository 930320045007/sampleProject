<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='7';?>
<?php $menu2='18';?>
<?php $menu3 = '3';?>

<?php
if(isset($_POST['tahun']) && $_POST['tahun']!=0)
	$dateyear = htmlspecialchars($_POST['tahun'], ENT_QUOTES);
else
	$dateyear = date('Y');
	
if(isset($_GET['sid']) && $_GET['sid']!=NULL)
	$staffid = getStafIDByUserID(getID(htmlspecialchars($_GET['sid'], ENT_QUOTES), 0));
else
	$staffid = '0';
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cuti = "SELECT * FROM user_leave WHERE userleave_status = '1' AND user_stafid = '" . $staffid . "' AND userleave_status = '1' AND userleave_year = '" . $dateyear . "' ORDER BY leavetype_id ASC, userleave_year DESC, userleave_month DESC, userleave_day DESC, userleave_id DESC";
$cuti = mysql_query($query_cuti, $hrmsdb) or die(mysql_error());
$row_cuti = mysql_fetch_assoc($cuti);
$totalRows_cuti = mysql_num_rows($cuti);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_usercuti = "SELECT * FROM user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $staffid . "' AND leavetype_id = '1'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC, userleavedate_id DESC";
$usercuti = mysql_query($query_usercuti, $hrmsdb) or die(mysql_error());
$row_usercuti = mysql_fetch_assoc($usercuti);
$totalRows_usercuti = mysql_num_rows($usercuti);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutisakit = "SELECT * FROM user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" .$staffid . "' AND leavetype_id = '2'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";
$cutisakit = mysql_query($query_cutisakit, $hrmsdb) or die(mysql_error());
$row_cutisakit = mysql_fetch_assoc($cutisakit);
$totalRows_cutisakit = mysql_num_rows($cutisakit);

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
        <?php include('../inc/menu_unit.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          
          <?php if (getUserUnitIDByUserID($row_user['user_stafid'])==getUserUnitIDByUserID($staffid)){?>
            <?php include('../inc/menu_head.php');?>
          	<ul>
                <li class="gap">&nbsp;</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  <td rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic($staffid);?></td>
                    <td nowrap="nowrap" class="label">Nama</td>
                    <td width="100%"><strong><?php echo strtoupper(getFullNameByStafID($staffid)) . " (" . $staffid . ")"; ?></strong></td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label noline">Jawatan</td>
                    <td class="noline txt_line"><?php echo getJobtitle($staffid); ?><br/><?php echo getFulldirectoryByUserID($staffid);?></td>
                  </tr>
                </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Jumlah Peruntukan Cuti Rehat / Tahunan &sup1;</li>
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
                        <td align="center" valign="middle" nowrap="nowrap" class="back_lightgrey line_t"><strong><?php echo getLeave($staffid,$dateyear)+getTotalLeaveGanti($staffid,$dateyear);?></strong></td>
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
                <li class="title">Permohonan Cuti Rehat / Tahunan</li>
                <li>
                <div class="note">Beriku merupakan rekod permohonan cuti sepanjang tahun <?php echo $dateyear;?></div>
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
                        <td><?php echo getLeaveCategory($row_usercuti['leavecategory_id']); ?> - <?php echo getLeaveTitle($row_usercuti['user_stafid'], 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y'], $row_usercuti['userleavedate_id']);?> &nbsp; <span class="txt_color1"><?php echo shortText(getLeaveNote($staffid, 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y'], $row_usercuti['userleavedate_id']));?> <?php if($row_usercuti['userleavedate_app']==1){?> &nbsp; &bull; &nbsp; Diluluskan oleh <?php echo getFullNameByStafID($row_usercuti['userleavedate_appby']); ?> pada <?php echo $row_usercuti['userleavedate_appdate']; ?><?php } else if($row_usercuti['userleavedate_app']==2){?> &nbsp; &bull; &nbsp; Tidak diluluskan oleh <?php echo getFullNameByStafID($row_usercuti['userleavedate_appby']); ?> pada <?php echo $row_usercuti['userleavedate_appdate']; ?><?php }; ?></span></td>
                        <td align="center" valign="middle"><?php viewIconLeave($staffid, $row_usercuti['userleavedate_id'], 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y']);?></td>
                        <td align="center" valign="middle"><?php viewIconNotice($staffid, $row_usercuti['userleavedate_id'], 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y']);?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php if($row_usercuti['userleavedate_app']==0) echo "1 **"; else if($row_usercuti['userleavedate_app']==1) echo "1"; else if($row_usercuti['userleavedate_app']==2) echo "-";?></td>
                      </tr>
                      <?php $i++; } while ($row_usercuti = mysql_fetch_assoc($usercuti)); ?>
                      <tr>
                        <td colspan="5" align="right" valign="middle" class="line_t noline"><strong>Jumlah Terkumpul</strong></td>
                        <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo calAllLeave($staffid, $dateyear);?></strong></td>
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
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Cuti Sakit &sup1;</li>
                <li>
                  <div class="note">Cuti Sakit yang diperuntukan sebanyak <strong><?php echo getEL($row_user['user_stafid'], $dateyear);?> Hari</strong> bagi tahun <?php echo date('Y');?></div>
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
                        <td align="left" valign="middle"><?php echo getLeaveTitle($staffid,2,$row_cutisakit['userleavedate_date_d'],$row_cutisakit['userleavedate_date_m'],$row_cutisakit['userleavedate_date_y']); ?> <span class="txt_color1"> &nbsp; &bull; &nbsp; Oleh <?php echo getFullNameByStafID($row_cutisakit['userleavedate_by']); ?> pada <?php echo $row_cutisakit['userleavedate_date']; ?></span></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutisakit['userleavedate_day']; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutisakit = mysql_fetch_assoc($cutisakit)); ?>
                      <tr>
                        <td colspan="3" align="right" class="noline"><strong>Jumlah Terkumpul</strong></td>
                        <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo countEL($staffid, $dateyear);?></strong></td>
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
                <li class="gap">&nbsp;</li>
            </ul>
            <?php }else{ ?>
           <ul><li><div class="note" >Tiada rekod yang dijumpai.</div></li></ul>
           <?php };?>
          </div>
         </div>
  	</div>
    <?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($cuti);
?>
<?php include('../inc/footinc.php');?> 