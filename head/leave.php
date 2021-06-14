<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='7';?>
<?php $menu2='19';?>
<?php	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_mohoncuti = "SELECT user_leavedate.* FROM user_leavedate WHERE user_leavedate.userleavedate_head = '" . $row_user['user_stafid'] . "' AND user_leavedate.user_stafid != '" . $row_user['user_stafid'] . "' AND user_leavedate.leavetype_id = '1' AND userleavedate_app = '0' ORDER BY user_leavedate.userleavedate_date_y DESC, user_leavedate.userleavedate_date_m DESC, user_leavedate.userleavedate_date_d DESC, user_leavedate.userleavedate_id DESC";
$mohoncuti = mysql_query($query_mohoncuti, $hrmsdb) or die(mysql_error());
$row_mohoncuti = mysql_fetch_assoc($mohoncuti);
$totalRows_mohoncuti = mysql_num_rows($mohoncuti);
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
          	<ul>
            <?php if(checkJob2View($row_user['user_stafid'])){?>
                <li>
                <div class="note">Permohonan cuti baru </div>
                <form id="form1" name="form1" method="POST" action="../sb/update_userleave.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_mohoncuti > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle">Bil</th>
                      <th align="center" valign="middle">Tarikh</th>
                      <th colspan="2" align="left" valign="middle">Nama / Jawatan</th>
                      <th align="center" valign="middle">Kelulusan</th>
                    </tr>
                    <?php $i=1; do { ?>
                    <tr class="on">
                      <td align="center" valign="middle"><?php echo $i;?></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d/m/Y (D)', mktime(0,0,0, $row_mohoncuti['userleavedate_date_m'], $row_mohoncuti['userleavedate_date_d'], $row_mohoncuti['userleavedate_date_y']));; ?></td>
                      <td align="center" valign="top"><?php echo viewProfilePic($row_mohoncuti['user_stafid']);?></td>
                      <td width="100%" align="left" valign="top"><div class="txt_line"><div class="txt_size3"><strong><?php echo getLeaveCategory($row_mohoncuti['leavecategory_id']); ?> - <?php echo $row_mohoncuti['userleavedate_name'];?></strong></div>
                      <?php if($row_mohoncuti['userleavedate_note']!=NULL){?><div><?php echo $row_mohoncuti['userleavedate_note'];?></div><?php }; ?>
                      <div><span class="txt_color1">Oleh: <?php echo getFullNameByStafID($row_mohoncuti['user_stafid']); ?> (<?php echo $row_mohoncuti['user_stafid'];?>),<br>
<?php echo getJobtitle($row_mohoncuti['user_stafid']); ?> (<?php echo getGred($row_mohoncuti['user_stafid']);?>)<br/> <?php echo getFulldirectoryByUserID($row_mohoncuti['user_stafid']);?></span></div></div></td>
                      <td align="center" valign="middle" nowrap="nowrap">
                      <ul class="inputradio">
                      	<li><input type="radio" name="cuti<?php echo $i; ?>" id="RadioGroup<?php echo $i;?>_0" value="1" />Ya</li>
                        <?php if($row_mohoncuti['leavetype_id']=='1' && $row_mohoncuti['leavecategory_id']=='9'){ // 9 = Cuti EL?>
                       	  <li><input name="notice<?php echo $i; ?>" type="checkbox" id="userleavedatenotice<?php echo $i; ?>" value="1" /> dengan amaran &curren;</li>
                           
                          <?php } else {?>
                          <input name="notice<?php echo $i; ?>" type="hidden" value="0" />
                          <?php };?>
                          <!-- <?php // if($row_mohoncuti['leavetype_id']=='1' && $row_mohoncuti['leavecategory_id']=='8'){ // 8 = Cuti Rehat / Tahunan?> -->
                        	<li><input type="radio" name="cuti<?php echo $i; ?>" value="2" id="RadioGroup<?php echo $i;?>_1" />Tidak</li>
                        	<li><input type="radio" name="cuti<?php echo $i; ?>" value="0" checked="checked"  id="RadioGroup<?php echo $i;?>_2" />Tangguh</li>
						<!-- <?php //}; ?> -->
                       </ul>
                       <input name="cutiid[]" type="hidden" value="<?php echo $row_mohoncuti['userleavedate_id']; ?>" />
                      </td>
                    </tr>
                    <?php $i++; } while ($row_mohoncuti = mysql_fetch_assoc($mohoncuti)); ?>
                    <tr>
                      <td colspan="4" class="noline"><input type="hidden" name="MM_update" value="form1" /></td>
                      <td nowrap="nowrap" class="noline"><input name="cuticount" type="hidden" value="<?php echo $totalRows_mohoncuti; ?>" /><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" /></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_mohoncuti; ?> rekod dijumpai</td>
                    </tr>
                    <?php } else {?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </form>
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
            </ul>
          </div>
        </div>
        <?php echo noteEmail('1'); ?>
		<?php echo noteLeaveNotice('1'); ?>
	</div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($mohoncuti);
?>
<?php include('../inc/footinc.php');?> 