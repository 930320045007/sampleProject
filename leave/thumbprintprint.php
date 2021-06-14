<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='3';?>
<?php $menu2='100';?>
<?php
if(isset($_GET['m']))
{
	$dm = htmlspecialchars($_GET['m'], ENT_QUOTES);
} else {
	$dm = date('m');
};

if(isset($_GET['y']))
{
	$dy = htmlspecialchars($_GET['y'], ENT_QUOTES);
} else {
	$dy = date('Y');
};

	$sid = $row_user['user_stafid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/print.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">
<div>
  <?php if(getStatusByStafID($sid)==1){?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
        <tr>
                      <td align="center" valign="middle"><?php echo viewProfilePic($sid);?></td>
                      <td width="100%" align="left" valign="middle">
                        <div><strong><?php echo getFullNameByStafID($sid) . " (" . $sid . ")"; ?></strong></div>
                        <div class="txt_color1"><?php echo getJobtitle($sid) . " (" . getGred($sid) . ")";?></div>
                        <div class="txt_color1"><?php echo getFulldirectoryByUserID($sid);?></div>
                        <div class="txt_color1">Kategori WP : <?php echo getWPByUserID($sid, $dm, $dy);?></div>
                      </td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabborder">
  <tr>
    <td align="left" valign="middle">Rekod cuti bagi bulan <strong><?php echo date('F Y', mktime(0, 0, 0, $dm, 1, $dy));?></strong></td>
  </tr>
</table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
                    <tr>
                      <th align="left" valign="middle">Tarikh</th>
                      <th align="center" valign="middle">Waktu Masuk</th>
                      <th align="center" valign="middle">Waktu Keluar</th>
                      <th width="20%" align="center" valign="middle">Cuti</th>
                      <th width="20%" align="center" valign="middle">Kehadiran</th>
                       <th width="20%" align="center" valign="middle">Catatan</th>
                    </tr>
                    <?php 
					for($dd = 1; $dd<=date('t', mktime(0, 0, 0, $dm, 1, $dy)); $dd++)
					{
						if($dd<10)
							$dd = '0' . $dd;
					?>
                    <tr class="line_b">
                      <td align="left" valign="middle"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $dm, $dd, $dy));?></td>
                      <td align="left" valign="middle">
                           <?php if(getTimeInByDate($sid, $dd, $dm, $dy)!='NULL') echo getTimeInByDate($sid, $dd, $dm, $dy); else echo ' ';?>
					  </td>
                          <td align="left" valign="middle">
                           <?php if(getTimeOutByDate($sid, $dd, $dm, $dy)!='NULL') echo getTimeOutByDate($sid, $dd, $dm, $dy); else echo ' ';?>
					  </td>
                      <td align="left" valign="middle">
                      <?php if(checkHolidayByDate($dd, $dm, $dy)) echo "<div> &bull; " . getHolidayName($dd, $dm, $dy) . "</div>";?>
                      <?php if(checkDayLeave($sid, 0, $dd, $dm, $dy)) {?>
                      <div>
                      <?php echo getLeaveType(getLeaveTypeByLeaveID(getLeaveID($sid, 0, $dd, $dm, $dy, 0)));?> &nbsp;
					  <?php echo viewIconLeave($sid, getLeaveID($sid, 0, $dd, $dm, $dy, 0), 0, 0, 0, 0); ?>
                      </div>
                      <?php }; ?>
                      </td>
                      <td align="left" valign="middle" class="txt_line">
                      <?php $lid = getleaveOfficeIDByDate($sid, $dd, $dm, $dy); ?>
                      <?php if(count($lid)>0){?>
						  <?php $i=1; foreach($lid AS $key => $value){?>
                              <div><strong><?php echo getReasonNameByID(getReasonByLeaveOfficeID($value));?></strong>
                              <?php if(getReasonType(getReasonByLeaveOfficeID($value))=='0') { ?>
                              &nbsp; &bull; &nbsp; <?php echo getTimeLeaveByLeaveOfficeID($value);?> - <?php echo getTimeBackByLeaveOfficeID($value);?>
							  <?php }; ?> 
                              <?php if(getReasonType(getReasonByLeaveOfficeID($value))=='1')  { ?>
                        &nbsp; &bull; &nbsp; <?php echo getLeaveOfficeDayByLeaveOfficeID($value); ?> <?php echo getDayType(getLeaveOfficeDayTypeByLeaveOfficeID($value));?>
                        <?php }; ?>	
                   		</div>				
                              <div class="txt_color1"><?php echo getLeaveNoteByLeaveOfficeID($value);?></div>
                          <?php $i++; }; ?>
                      <?php }; ?>
                      </td>
                       <td align="left" valign="middle"><?php if(getLeaveNoteIDByDate($sid, $dd, $dm, $dy)!='0')?><?php  echo getLeaveNoteHRByID(getLeaveNoteIDByDate($sid, $dd, $dm, $dy));?></td>
                    </tr>
                    <?php }; ?>
                  </table>
                <?php } else { ?>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
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
    </div>
</div>
</body>
</html>
<?php include('../inc/footinc.php');?> 