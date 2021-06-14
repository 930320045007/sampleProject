<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='80';?>
<?php

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_driver = "SELECT driver.* FROM tadbir.driver LEFT JOIN www.login ON login.user_stafid = driver.user_stafid LEFT JOIN www.user ON user.user_stafid = driver.user_stafid WHERE login.login_status = 1 AND driver_status = 1 ORDER BY user_firstname ASC, user_lastname DESC";
$driver = mysql_query($query_driver, $tadbirdb) or die(mysql_error());
$row_driver = mysql_fetch_assoc($driver);
$totalRows_driver = mysql_num_rows($driver);

$wsql = "";

if(isset($_POST['driver']) && $_POST['driver']!=0)
{
	$wsql .= " AND transdriver.driver_id='" . htmlspecialchars($_POST['driver'],ENT_QUOTES) . "' ";
	$dr = htmlspecialchars($_POST['driver'],ENT_QUOTES);
} else {
	$wsql .= " AND transdriver.driver_id='" . $row_driver['driver_id'] . "' ";
	$dr = $row_driver['driver_id'];
};

if(isset($_POST['bulan']) && $_POST['bulan']!='0')
{
	list($dday, $dmonth, $dyear) = explode("/", $_POST['bulan'], 3);
	
} else {
	
	$dday = date('d');
	$dmonth = date('m');
	$dyear = date('Y');
};
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
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li class="form_back">
                  <form id="form1" name="form1" method="post" action="driverlist.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="noline label">Tarikh</td>
                          <td width="100%" nowrap="nowrap" class="noline">
                           <select name="bulan" id="bulan">
                           <?php for($i=date('d'); $i<=(date('d')+90); $i+=15){?>
                             <option value="<?php echo date('d/m/Y', mktime(0, 0, 0, date('m')-2, $i, date('Y')));?>"><?php echo date('d/m/Y', mktime(0, 0, 0, date('m')-2, $i, date('Y')));?> - <?php echo date('d/m/Y', mktime(0, 0, 0, date('m')-2, $i+14, date('Y')));?></option>
                           <?php }; ?>
                           </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                          <td nowrap="nowrap" class="noline"><input name="button3" type="button" class="submitbutton" id="button3" value="Individu" onclick="MM_goToURL('parent','driver.php');return document.MM_returnValue" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                <div class="note">Senarai Jadual Tugasan  pada <?php echo "<strong>" . strtoupper(date('F Y', mktime(0, 0, 0, $dmonth, 1, $dyear))) . "</strong>";?></div>
                <div class="off2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="line_r">
                  <tr>
                    <td colspan="2">&nbsp;</td>
                    <?php for($i=$dday; $i<=($dday+14); $i++){?>
                    <td align="center" valign="middle" class="line_l line_t txt_line back_lightgrey">
					<div><?php echo date('d/m', mktime(0, 0, 0, $dmonth, $i, $dyear));?></div>
                    <div><?php echo date('D', mktime(0, 0, 0, $dmonth, $i, $dyear));?></div>
                    </td>
                    <?php }; ?>
                  </tr>
                  <?php do { ?>
                  <tr class="on">
                    <td class="line_l"><?php echo viewProfilePic(getStafIDByID($row_driver['driver_id']));?></td>
                    <td width="100%" nowrap="nowrap"><?php echo shortText(getDriverNameByID($row_driver['driver_id']),15); ?></td>
                    <?php for($i=$dday; $i<=($dday+14); $i++){?>
                    <td align="center" valign="middle" class="line_l" <?php echo color(getPercJourneyByDriverID($row_driver['driver_id'], date('d', mktime(0, 0, 0, $dmonth, $i, $dyear)), date('m', mktime(0, 0, 0, $dmonth, $i, $dyear)), date('Y', mktime(0, 0, 0, $dmonth, $i, $dyear))));?>>
                    <a <?php echo color(getPercJourneyByDriverID($row_driver['driver_id'], date('d', mktime(0, 0, 0, $dmonth, $i, $dyear)), date('m', mktime(0, 0, 0, $dmonth, $i, $dyear)), date('Y', mktime(0, 0, 0, $dmonth, $i, $dyear))));?> href="<?php echo $url_main;?>tadbir/driver.php?driver=<?php echo getID($row_driver['driver_id']);?>&bulan=<?php echo date('m/Y', mktime(0, 0, 0, $dmonth, $i, $dyear));?>">
					<?php echo getTotalJourneyByDriverID($row_driver['driver_id'], date('d', mktime(0, 0, 0, $dmonth, $i, $dyear)), date('m', mktime(0, 0, 0, $dmonth, $i, $dyear)), date('Y', mktime(0, 0, 0, $dmonth, $i, $dyear)));?>
                    </a>
                    </td>
                    <?php }; ?>
                  </tr>
                    <?php } while ($row_driver = mysql_fetch_assoc($driver)); ?>
                  <tr>
                    <td colspan="2" class="noline">&nbsp;</td>
                    <?php for($i=$dday; $i<=($dday+14); $i++){?>
                    <td align="center" valign="middle" class="line_l line_b back_darkgrey">
                    <?php echo getTotalJourneyByDriverID(0, date('d', mktime(0, 0, 0, $dmonth, $i, $dyear)), date('m', mktime(0, 0, 0, $dmonth, $i, $dyear)), date('Y', mktime(0, 0, 0, $dmonth, $i, $dyear)));?>
                    </td>
                    <?php }; ?>
                  </tr>
                </table>
                <div class="gap">&nbsp;</div>
                </div>
                </li>
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
mysql_free_result($driver);
mysql_free_result($title);

?>
<?php include('../inc/footinc.php');?>
