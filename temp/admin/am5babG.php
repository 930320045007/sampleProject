<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='79';?>
<?php

if(isset($_GET['id']))
	$wsql = " AND leaveoffice_id='" . getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0) . "'";
else
	$wsql = " AND leaveoffice_id='-1'";

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_leaveoffice = "SELECT * FROM hr.leave_office WHERE leaveoffice_status= '1' " . $wsql . " ORDER BY leaveoffice_date_y DESC, leaveoffice_date_m DESC, leaveoffice_date_d DESC, leaveoffice_id DESC";
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
     <?php include('../inc/menu_ict.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li>
  				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_leaveoffice > 0) { // Show if recordset not empty ?>
                <tr>
                  <th align="center" valign="middle">Bil</th>
                  <th align="center" valign="middle">Tarikh</th>
                  <th colspan="2" align="left" valign="middle">Nama / Jawatan</th>
                  <th align="center" valign="middle" nowrap="nowrap">Kekerapan</th>
                  <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>
                  <th align="center" valign="middle" nowrap="nowrap">Amaran</th>
                  <th align="center" valign="middle"></th>
                </tr>
                <?php $i=1; do { ?>
                  <tr <?php if(getHeadApprovalByLeaveOfficeID($row_leaveoffice['leaveoffice_id'])==4) echo "class=\"offcourses\""; else echo "class=\"on\"";?>>
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td align="center" valign="middle" nowrap="nowrap" class="txt_line">
					<div><?php echo getDateLeaveByLeaveOfficeID($row_leaveoffice['leaveoffice_id']);?></div>
					<?php if(getReasonType(getReasonByLeaveOfficeID($row_leaveoffice['leaveoffice_id']))=='1')
					  {
						  $dmy = getLeaveOfficeDateEndByLeaveOfficeID($row_leaveoffice['leaveoffice_id']);
						  echo "<div> - " . date('d / m / Y (D)', mktime(0, 0, 0, $dmy[1], $dmy[0], $dmy[2])) . "</div>";
					  };
					  ?>
                    <div class="txt_color1">
                    <?php if(getReasonType(getReasonByLeaveOfficeID($row_leaveoffice['leaveoffice_id']))=='0'){?>
					<?php echo getTimeLeaveByLeaveOfficeID($row_leaveoffice['leaveoffice_id']);?> - <?php echo getTimeBackByLeaveOfficeID($row_leaveoffice['leaveoffice_id']);?>
                    <?php } elseif(getReasonType(getReasonByLeaveOfficeID($row_leaveoffice['leaveoffice_id']))=='1') { ?>
                    ( <?php echo getLeaveOfficeDayByLeaveOfficeID($row_leaveoffice['leaveoffice_id']); ?> <?php echo getDayType(getLeaveOfficeDayTypeByLeaveOfficeID($row_leaveoffice['leaveoffice_id']));?> )
                    <?php }; ?>
                    </div>
                    </td>
                    <td align="center" valign="middle"><?php echo viewProfilePic($row_leaveoffice['user_stafid']);?></td>
                    <td width="100%" class="txt_line">
                    <div><?php echo getReasonNameByID($row_leaveoffice['reason_id']);?></div>
					<div><strong><?php echo getFullNameByStafID($row_leaveoffice['user_stafid']) . " (" . $row_leaveoffice['user_stafid'] . ")"; ?></strong></div>
                    <div><?php echo getFulldirectoryByUserID($row_leaveoffice['user_stafid']);?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID($row_leaveoffice['user_stafid']);?></div>
                    </td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php echo getLeaveFrequencyByLeaveOfficeID($row_leaveoffice['leaveoffice_id'], $row_leaveoffice['leaveoffice_on_m'], $row_leaveoffice['leaveoffice_on_y']);?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php iconApplyLeaveStatus($row_leaveoffice['leaveoffice_id']);?></td>
                    <td align="center" valign="middle" nowrap="nowrap">
                    <?php if(getHeadApprovalByLeaveOfficeID($row_leaveoffice['leaveoffice_id'])!=0) echo iconWarning($row_leaveoffice['leaveoffice_id']);?>
                     <td nowrap="nowrap">
                      <ul class="func">
                      <li><a onclick="return confirm('Anda mahu maklumat kehadiran berikut dipadam? \r\n\n Tarikh : <?php echo getDateLeaveByLeaveOfficeID($row_leaveoffice['leaveoffice_id']);?>\r\n\n Sebab : <?php echo getReasonNameByID($row_leaveoffice['reason_id']);?> \r\n\n Oleh : <?php echo getFullNameByStafID($row_leaveoffice['user_stafid']) . " (" . $row_leaveoffice['user_stafid'] . ")"; ?> ')" href="../sb/del_leaveofficehr.php?id=<?php echo $row_leaveoffice['leaveoffice_id'];?>">X</a></li>
                      </ul>
                  </tr>
                  <?php $i++; } while ($row_leaveoffice = mysql_fetch_assoc($leaveoffice)); ?>
                <tr>
                  <td colspan="8" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_leaveoffice ?> rekod dijumpai</td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td colspan="8" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                </tr>
                <?php }; ?>
              </table>
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