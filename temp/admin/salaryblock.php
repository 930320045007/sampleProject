<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='34';?>
<?php
if(isset($_GET['my']))
{
	$dmy = explode('/', $_GET['my']);
	$m = htmlspecialchars($dmy[0], ENT_QUOTES);
	$y = htmlspecialchars($dmy[1], ENT_QUOTES);
} else {
	$m = date('m');
	$y = date('Y');
}

mysql_select_db($database_hrmsdb, $hrmsdb);

$query_usb = "SELECT * FROM www.user_salaryblock LEFT JOIN www.user ON user.user_stafid = user_salaryblock.user_stafid WHERE user_salaryblock.usb_status = 1 AND ((user_salaryblock.usb_start_m <= '" . $m  . "' AND user_salaryblock.usb_start_y = '" . $y . "') AND ((user_salaryblock.usb_end_m >= '" . $m . "' AND user_salaryblock.usb_end_y = '" . $y . "') OR (user_salaryblock.usb_end_m < '" . $m . "' AND user_salaryblock.usb_end_y > '" . $y . "'))) ORDER BY user.user_firstname ASC, user.user_lastname ASC";
$usb = mysql_query($query_usb, $hrmsdb) or die(mysql_error());
$row_usb = mysql_fetch_assoc($usb);
$totalRows_usb = mysql_num_rows($usb);
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="salaryblock.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Bulan</td>
                        <td width="100%">
                          <select name="my" id="my">
                          <?php for($i=0; $i<=12; $i++){?>
                            <option <?php if($m==date('m', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))) && $y==date('Y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y')))) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo date('m/Y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y')));?>"><?php echo date('M Y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y')));?></option>
                          <?php }; ?>
                          </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                        <td><input name="button4" type="button" class="submitbutton" id="button4" value="Tambah" onclick="MM_goToURL('parent','salaryblockadd.php');return document.MM_returnValue" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                	<div class="note">Senarai kakitangan yang ditahan penyata gaji bagi bulan <strong> <?php echo date('M Y', mktime(0, 0, 0, $m, 1, $y));?></strong> </div>
                </li>
                <div id="usb">
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_usb > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Mula</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tamat</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="left" valign="middle" nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getSalaryBlockStartDateByID($row_usb['usb_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getSalaryBlockEndDateByID($row_usb['usb_id']);?></td>
                        <td align="left" valign="middle" class="txt_line">
						<div><strong><?php echo getFullNameByStafID($row_usb['user_stafid']) . " (" . $row_usb['user_stafid'] . ")"; ?></strong></div>
                        <div class="txt_color1"><?php echo getFulldirectoryByUserID($row_usb['user_stafid']);?></div>
                        </td>
                        <td align="left" valign="middle" nowrap="nowrap" class="txt_line">
                        <ul class="func">
                        	<li><a href="salaryblockedit.php?id=<?php echo getID($row_usb['usb_id']);?>">Edit</a></li>
                            <li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n<?php echo getSalaryBlockStartDateByID($row_usb['usb_id']);?> - <?php echo getSalaryBlockEndDateByID($row_usb['usb_id']);?> \r\n\n<?php echo getFullNameByStafID($row_usb['user_stafid']) . " (" . $row_usb['user_stafid'] . ")"; ?>')" href="<?php echo $url_main;?>sb/del_salaryblock.php?id=<?php echo getID($row_usb['usb_id']);?>">X</a></li>
                        </ul>
                        </td>
                      </tr>
                      <?php $i++; } while ($row_usb = mysql_fetch_assoc($usb)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_usb;?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                </div>
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
<?php
mysql_free_result($usb);
?>
<?php include('../inc/footinc.php');?>
