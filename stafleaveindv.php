<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='79';?>
<?php

if(isset($_GET['dmy']))
{
	$dmy = explode("/", htmlspecialchars($_GET['dmy'], ENT_QUOTES));
	$dm = $dmy[0];
	$dy = $dmy[1];
} else {
	$dm = date('m');
	$dy = date('Y');
}

if(isset($_GET['id']))
{
	$sid = htmlspecialchars($_GET['id'], ENT_QUOTES);
} else {
	$sid = $row_user['user_stafid'];
}

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
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="stafleaveindv.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Staf ID</td>
                        <td width="100%">
                        <input name="id" type="text" class="w30" id="id" value="<?php echo $sid;?>" list="datastaflist" />
                        <?php echo datalistStaf('datastaflist');?>
                        <select name="dmy" id="dmy">
                        <?php for($i=1; $i<=12; $i++){?>
                          <option <?php if($i==$dm) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo date('m/Y', mktime(0, 0, 0, $i, 1, date('Y')));?>"><?php echo date('M Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>
                        <?php }; ?>
                        </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php if(getStatusByStafID($sid)==1){?>
                <li>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td align="center" valign="middle"><?php echo viewProfilePic($sid);?></td>
                      <td width="100%" align="left" valign="middle">
                        <div><strong><?php echo getFullNameByStafID($sid) . " (" . $sid . ")"; ?></strong></div>
                        <div class="txt_color1"><?php echo getJobtitle($sid) . " (" . getGred($sid) . ")";?></div>
                        <div class="txt_color1"><?php echo getFulldirectoryByUserID($sid);?></div>
                      </td>
                    </tr>
                  </table>
                  <div class="note">Rekod cuti bagi bulan <strong><?php echo date('F Y', mktime(0, 0, 0, $dm, 1, $dy));?></strong></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th align="left" valign="middle">Tarikh</th>
                      <th width="30%" align="center" valign="middle" class="line_l line_r line_t">Cuti</th>
                      <th width="30%" align="center" valign="middle">Kehadiran</th>
                    </tr>
                    <?php 
					for($dd = 1; $dd<=date('t', mktime(0, 0, 0, $dm, 1, $dy)); $dd++)
					{
						if($dd<10)
							$dd = '0' . $dd;
					?>
                    <tr class="<?php if(!checkStateWeekendByDate($sid, $dd, $dm, $dy)) echo "back_darkgrey"; else echo "on"; ?>">
                      <td align="left" valign="middle"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $dm, $dd, $dy));?></td>
                      <td align="left" valign="middle" nowrap="nowrap" class="txt_line line_r line_l">
                      <?php if(checkHolidayByDate($dd, $dm, $dy)) echo "<div> &bull; " . getHolidayName($dd, $dm, $dy) . "</div>";?>
                      <?php if(checkDayLeave($sid, 0, $dd, $dm, $dy)) {?>
                      <div>
                      <?php echo getLeaveType(getLeaveTypeByLeaveID(getLeaveID($sid, 0, $dd, $dm, $dy, 0)));?> &nbsp;
					  <?php echo viewIconLeave($sid, getLeaveID($sid, 0, $dd, $dm, $dy, 0), 0, 0, 0, 0); ?>
                      </div>
                      <?php }; ?>
                      </td>
                      <td align="left" valign="middle" nowrap="nowrap" class="txt_line">
                      <?php $id = getleaveOfficeIDByDate($sid, 0, $dd, $dm, $dy); ?>
                      <?php if(count($id)>0){?>
						  <?php $i=1; foreach($id AS $key => $value){?>
                              <div <?php if($i>1) echo "class=\"padt\"";?>><?php iconApplyLeaveStatus($value);?> &nbsp; <strong><?php echo getReasonNameByID(getReasonByLeaveOfficeID($value));?></strong> 
                              <?php if(getReasonType(getReasonByLeaveOfficeID($value))=='0') { ?>
                              &nbsp; &bull; &nbsp; <?php echo getTimeLeaveByLeaveOfficeID($value);?> - <?php echo getTimeBackByLeaveOfficeID($value);?>
							  <?php }; ?>
                              </div>
                              <div class="txt_color1"><?php echo getLeaveNoteByLeaveOfficeID($value);?></div>
                          <?php $i++; }; ?>
                      <?php }; ?>
                      </td>
                    </tr>
                    <?php }; ?>
                    </table>
                </li>
                <li class="gap">&nbsp;</li>
                <?php } else { ?>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                  </tr>
                </table>
                </li>
                <?php }; ?>
            <?php } ; ?>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php include('../inc/footinc.php');?> 