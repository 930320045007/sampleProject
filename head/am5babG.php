<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='7';?>
<?php $menu2='77';?>
<?php

$wsql = "";

if(isset($_POST['leaveoffice_date_m']))
{
	$wsql .= " AND leaveoffice_date_m = '" . htmlspecialchars($_POST['leaveoffice_date_m'], ENT_QUOTES) . "'";
	$dm = $_POST['leaveoffice_date_m'];
} else {
	$wsql .= " AND leaveoffice_date_m = '" . date('m') . "'";
	$dm = date('m');
}

if(isset($_POST['leaveoffice_date_y']))
{
	$wsql .= " AND leaveoffice_date_y = '" . htmlspecialchars($_POST['leaveoffice_date_y'], ENT_QUOTES) . "'";
	$dy = $_POST['leaveoffice_date_y'];
} else {
	$wsql .= " AND leaveoffice_date_y = '" . date('Y') . "'";
	$dy = date('Y');
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_leaveoffice = "SELECT * FROM www.leave_office WHERE app_by = '" . $row_user['user_stafid'] . "' AND leaveoffice_status= '1' " . $wsql . " ORDER BY leaveoffice_date_y DESC, leaveoffice_date_m DESC, leaveoffice_date_d DESC, leaveoffice_id DESC";
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
        <?php include('../inc/menu_unit.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkJob2View($row_user['user_stafid'])){?>
            	<li class="form_back">
            	  <form id="form1" name="form1" method="post" action="">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td class="label noline">Tarikh</td>
            	        <td width="100%" class="noline">                          
            	        <select name="leaveoffice_date_m" id="leaveoffice_date_m">
                          <?php for($j=1; $j<=12; $j++){?>
            	            <option <?php if($j==$dm) echo "selected=\"selected\"";?> value="<?php if($j<10) $j= "0" . $j; echo $j;?>"><?php echo $j . " - " . date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                          <?php }; ?>
          	            </select>
            	        <select name="leaveoffice_date_y" id="leaveoffice_date_y">
                          <?php for($k=2012; $k<=date('Y'); $k++){?>
            	            <option <?php if($k==$dy) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                          <?php }; ?>
          	            </select>
           	            <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
          	        </tr>
          	      </table>
          	      </form>
            	</li>
                <li>
                <div class="note">Senarai permohonan kebenaran meninggalkan pejabat dalam waktu pejabat bagi bulan <strong><?php echo date('M Y', mktime(0, 0, 0, $dm, 1, $dy));?></strong></div>
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
					  {?>
						  <?php echo getLeaveOfficeDayByLeaveOfficeID($row_leaveoffice['leaveoffice_id']); ?> <?php echo getDayType(getLeaveOfficeDayTypeByLeaveOfficeID($row_leaveoffice['leaveoffice_id']));?>
                              <?php }; ?>
                    <div class="txt_color1">
                    <?php if(getReasonType(getReasonByLeaveOfficeID($row_leaveoffice['leaveoffice_id']))=='0'){?>
					<?php echo getTimeLeaveByLeaveOfficeID($row_leaveoffice['leaveoffice_id']);?> - <?php echo getTimeBackByLeaveOfficeID($row_leaveoffice['leaveoffice_id']);?>
                    <?php }; ?>
                    </div>
                    </td>
                    <td align="center" valign="middle"><?php echo viewProfilePic($row_leaveoffice['user_stafid']);?></td>
                    <td width="100%" class="txt_line">
                    <a href="am5babGdetail.php?id=<?php echo getID($row_leaveoffice['leaveoffice_id']); ?>">
                    <div><?php echo getReasonNameByID($row_leaveoffice['reason_id']);?></div>
					<div><strong><?php echo getFullNameByStafID($row_leaveoffice['user_stafid']) . " (" . $row_leaveoffice['user_stafid'] . ")"; ?></strong></div>
                    <div><?php echo getFulldirectoryByUserID($row_leaveoffice['user_stafid']);?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID($row_leaveoffice['user_stafid']);?></div>
                    </a>
                    </td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php echo getLeaveFrequencyByLeaveOfficeID($row_leaveoffice['leaveoffice_id'], $row_leaveoffice['leaveoffice_on_m'], $row_leaveoffice['leaveoffice_on_y']);?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php iconApplyLeaveStatus($row_leaveoffice['leaveoffice_id']);?></td>
                    <td align="center" valign="middle" nowrap="nowrap">
                    <?php if(getHeadApprovalByLeaveOfficeID($row_leaveoffice['leaveoffice_id'])!=0) echo iconWarning($row_leaveoffice['leaveoffice_id']);?>
                     <td nowrap="nowrap">
                      <ul class="func">
                      <li><a onclick="return confirm('Anda mahu maklumat kehadiran berikut dipadam? \r\n\n Tarikh : <?php echo getDateLeaveByLeaveOfficeID($row_leaveoffice['leaveoffice_id']);?>\r\n\n Sebab : <?php echo getReasonNameByID($row_leaveoffice['reason_id']);?> \r\n\n Oleh : <?php echo getFullNameByStafID($row_leaveoffice['user_stafid']) . " (" . $row_leaveoffice['user_stafid'] . ")"; ?> ')" href="../sb/del_leaveoffice.php?id=<?php echo $row_leaveoffice['leaveoffice_id'];?>">X</a></li>
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
