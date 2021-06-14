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

if(isset($_GET['driver']))
{
	$dr = getID($_GET['driver'],0);
	$wsql .= " AND transdriver.driver_id='" . $dr . "' ";
} else {
	$dr = $row_driver['driver_id'];
	$wsql .= " AND transdriver.driver_id='" . $dr . "' ";
};

if(isset($_GET['bulan']) && $_GET['bulan']!='0')
{
	list($dmonth, $dyear) = explode("/", $_GET['bulan'], 2);
	
	$wsql .= " AND journey.journey_date_m = '" . htmlspecialchars($dmonth,ENT_QUOTES) . "' ";
	
	$wsql .= " AND journey.journey_date_y = '" . htmlspecialchars($dyear,ENT_QUOTES) . "' ";
	
} else {
	
	$dmonth = date('m');
	$dyear = date('Y');
	
	$wsql .= " AND journey.journey_date_m='" . $dmonth . "'  AND journey.journey_date_y='" . $dyear . "'";
};
	
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_title="SELECT journey.*, transport_book.transbook_title, transport_book.transbook_by FROM tadbir.journey LEFT JOIN tadbir.transport_book ON transport_book.transbook_id = journey.transbook_id LEFT JOIN tadbir.transdriver ON transdriver.transbook_id = transport_book.transbook_id WHERE journey.journey_status = 1 " . $wsql . " ORDER BY journey.journey_date_y DESC, journey.journey_date_m DESC, journey.journey_date_d DESC, journey.journey_time_h DESC, journey.journey_time_m DESC, journey.journey_id DESC";
$title = mysql_query($query_title, $tadbirdb) or die(mysql_error());
$row_title = mysql_fetch_assoc($title);
$totalRows_title = mysql_num_rows($title);

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
                <?php if ($totalRows_driver > 0) { // Show if recordset not empty ?>
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="driver.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class=" noline label">Pemandu</td>
                        <td class="noline">
                         <select name="driver" id="driver">
							 <?php
                            do {  
                            ?>
                            <option <?php if($row_driver['driver_id'] == $dr) echo "selected=\"selected\"";?> value="<?php echo getID($row_driver['driver_id'])?>"><?php echo getDriverNameByID($row_driver['driver_id']);?></option>
                            <?php
                            } while ($row_driver = mysql_fetch_assoc($driver));
                              $rows = mysql_num_rows($driver);
                              if($rows > 0) {
                                  mysql_data_seek($driver, 0);
                                  $row_driver = mysql_fetch_assoc($driver);
                              }
                            ?>
                          </select>
                          </td>
                          <td class="noline label">Bulan </td>
                          <td width="100%" nowrap="nowrap" class="noline">
                           <select name="bulan" id="bulan">
                           <?php for($i=(date('m')+3); $i>=(date('m')-5); $i--){?>
                             <option <?php if(date('m', mktime(0, 0, 0, $i, 1, date('Y')))==$dmonth) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $i, 1, date('Y')));?>"><?php echo date('F Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>
                           <?php }; ?>
                           </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                          <td nowrap="nowrap" class="noline"><input name="button3" type="button" class="submitbutton" id="button3" value="Senarai" onclick="MM_goToURL('parent','driverlist.php');return document.MM_returnValue" /></td>
                          <td nowrap="nowrap" class="noline"><input name="button3" type="button" class="submitbutton" id="button3" value="Penyelenggaraan" onclick="MM_goToURL('parent','maintenancelist.php');return document.MM_returnValue" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td align="center" valign="middle"><?php echo viewProfilePic(getStafIDByID($dr));?></td>
                      <td width="100%" align="left" valign="middle" class="txt_line">
                        <div><strong><?php echo getDriverNameByID($dr); ?></strong></div>
                        <div class="txt_color1"><?php echo getFulldirectoryByUserID(getStafIDByID($dr));?></div>
                        <div class="txt_color1">No. Ext : <?php if(getExtNoByUserID(getStafIDByID($dr))!=NULL) echo getExtNoByUserID(getStafIDByID($dr)); else echo "-";?> &nbsp; &bull; &nbsp; No. Tel (HP) : <?php if(getTelMByStafID(getStafIDByID($dr))!=NULL)echo getTelMByStafID(getStafIDByID($dr)); else echo "-";?></div>
                        </td>
                      </tr>
                  </table>
                  <div class="note">Senarai Jadual Tugasan  pada <?php echo "<strong>" . strtoupper(date('F Y', mktime(0, 0, 0, $dmonth, 1, $dyear))) . "</strong>";?></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_title > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle">Bil</th>
                      <th align="center" valign="middle">Tarikh</th>
                      <th align="center" valign="middle">Masa</th>
                      <th align="center" valign="middle">Dari</th>
                      <th align="center" valign="middle">&nbsp;</th>
                      <th align="center" valign="middle">Ke</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Penumpang</th>  
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="<?php if(checkJourney1HourByJourneyID($row_title['journey_id'])) echo "txt_color2"; else echo "on";?>">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_title['journey_date_m'], $row_title['journey_date_d'], $row_title['journey_date_y']));?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getJourneyTimeByJourneyID($row_title['journey_id']); ?></td>
                        <td width="20%" align="center" valign="middle" ><?php echo shortText($row_title['journey_from'],25);?></td>
                        <td align="center" valign="middle" nowrap="nowrap">&raquo;</td>
                        <td width="20%" align="center" valign="middle" ><?php echo shortText($row_title['journey_to'],25);?></td>
                        <td align="left" valign="middle" class="txt_line">
                          <a href="driverdetail.php?id=<?php echo  getID(htmlspecialchars($row_title['transbook_id'],ENT_QUOTES)); ?>">
                            <strong><?php echo $row_title['transbook_title'] ;?></strong>
                            <div class="txt_color1"><?php echo getFullNameByStafID($row_title['transbook_by']) . " (" . $row_title['transbook_by'] . ")";?></div>
                            <div class="txt_color1"><?php echo getFulldirectoryByUserID($row_title['transbook_by']);?></div>
                            </a>
                        </td>
                        <td align="center" valign="middle" class="txt_line"><?php echo getTotalPassengerByTransbookID($row_title['transbook_id']);?></td>
                      </tr>
                      <?php $i++; } while ($row_title = mysql_fetch_assoc($title)); ?>
                    <tr>
                      <td colspan="8" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_title ?> rekod dijumpai</td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                      <td colspan="8" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <?php } else { ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle" class="txt_line">
                      	<div>Tiada rekod dijumpai.</div>
                        <div>Sila tambah maklumat Pemandu dan Kenderaan dalam <strong>Tatacara</strong></div>
                      </td>
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
<?php
mysql_free_result($driver);
mysql_free_result($title);

?>
<?php include('../inc/footinc.php');?>
