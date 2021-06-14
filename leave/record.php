<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='3';?>
<?php $menu2='78';?>
<?php
$wsql = "";

if(isset($_POST['dmy']))
{
	$rdmy = explode("/", $_POST['dmy']);
} else {
	$rdmy[0] = htmlspecialchars(date('m'), ENT_QUOTES);
	$rdmy[1] = htmlspecialchars(date('Y'), ENT_QUOTES);
};

$wsql .= " AND leaveoffice_on_m = '" . $rdmy[0] . "'";
$wsql .= " AND leaveoffice_on_y = '" . $rdmy[1] . "'";

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_leaveoffice = "SELECT * FROM www.leave_office WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND leaveoffice_status = 1 " . $wsql . " ORDER BY leaveoffice_on_y DESC, leaveoffice_on_m DESC, leaveoffice_on_d DESC, leaveoffice_id DESC";
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
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
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
                <ul>
                	<li class="form_back">
                      <form id="form1" name="form1" method="post" action="record.php">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td class="label">Bulan</td>
                            <td width="100%">
                            <select name="dmy" id="dmy">
                            <?php for($i=(date('m')-3); $i<=(date('m')+1); $i++){?>
                              <option <?php if($rdmy[0]==date('m', mktime(0, 0, 0, $i, 1, date('Y')))) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $i, 1, date('Y')));?>"><?php echo date('M Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>
                            <?php }; ?>
                            </select>
                            <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                          </tr>
                        </table>
                      </form>
                    </li>
                	<li><div class="note">Semakan status permohonan meninggalkan pejabat dalam waktu pejabat bagi bulan <strong><?php echo date('M Y', mktime(0, 0, 0, $rdmy[0], 1, $rdmy[1]));?></strong></div></li>
                    <?php if(checkWarningleaveOfficeByUserID($row_user['user_stafid'], 0, date('Y'))){?>
                    <li class="form_back"><div class="note txt_color2">Satu (1) email berkaitan tiga (3) kali AMARAN telah dihantar kepada <?php echo $adname;?></div></li>
                    <?php }; ?>
					<li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <?php if ($totalRows_leaveoffice > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th align="center" valign="middle">Bil</th>
                          <th align="center" valign="middle">Tarikh</th>
                          <th align="left" valign="middle">Nama / Jawatan</th>
                          <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>
                          <th align="center" valign="middle" nowrap="nowrap">Amaran</th>
                        </tr>
                        <?php $i=1; do { ?>
                        <tr <?php if(getHeadApprovalByLeaveOfficeID($row_leaveoffice['leaveoffice_id'])==4) echo "class=\"offcourses\""; else echo "class=\"on\"";?>>
                          <td align="center" valign="middle"><?php echo $i;?></td>
                          <td align="center" valign="middle" nowrap="nowrap" class="txt_line">
                          <div>
						  <?php echo getDateLeaveByLeaveOfficeID($row_leaveoffice['leaveoffice_id']);?>
                          </div>
                            <?php if(getReasonType(getReasonByLeaveOfficeID($row_leaveoffice['leaveoffice_id']))=='1'){?>
                              <?php echo getLeaveOfficeDayByLeaveOfficeID($row_leaveoffice['leaveoffice_id']); ?> <?php echo getDayType(getLeaveOfficeDayTypeByLeaveOfficeID($row_leaveoffice['leaveoffice_id']));?>
                              <?php }; ?>
                            <div class="txt_color1">
                              <?php if(getReasonType(getReasonByLeaveOfficeID($row_leaveoffice['leaveoffice_id']))=='0'){?>
                              <?php echo getTimeLeaveByLeaveOfficeID($row_leaveoffice['leaveoffice_id']);?> - <?php echo getTimeBackByLeaveOfficeID($row_leaveoffice['leaveoffice_id']);?>
                              <?php }; ?>
                            </div>
                            </td>
                          <td width="100%" class="txt_line">
                          <a href="recorddetail.php?id=<?php echo getID($row_leaveoffice['leaveoffice_id']); ?>">
                            <div><strong><?php echo getReasonNameByID($row_leaveoffice['reason_id']);?></strong></div>
                            <div><?php echo shortText(getLeaveNoteByLeaveOfficeID($row_leaveoffice['leaveoffice_id']));?></div>
                          </a>
                          </td>
                          <td align="center" valign="middle" nowrap="nowrap"><?php iconApplyLeaveStatus($row_leaveoffice['leaveoffice_id']);?></td>
                          <td align="center" valign="middle" nowrap="nowrap"><?php if(getHeadApprovalByLeaveOfficeID($row_leaveoffice['leaveoffice_id'])!=0) echo iconWarning($row_leaveoffice['leaveoffice_id']);?></td>
                        </tr>
                        <?php $i++; } while ($row_leaveoffice = mysql_fetch_assoc($leaveoffice)); ?>
                        <tr>
                          <td colspan="8" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_leaveoffice ?> rekod dijumpai</td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                          <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
        	</li>
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
