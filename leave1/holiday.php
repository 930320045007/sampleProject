<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='3';?>
<?php $menu2='54';?>
<?php
$y = date('Y');

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_h = "SELECT * FROM www.holiday WHERE holiday_status = 1 AND holiday_date_y = '" . $y . "' ORDER BY holiday_date_y ASC, holiday_date_m ASC, holiday_date_d ASC";
$h = mysql_query($query_h, $hrmsdb) or die(mysql_error());
$row_h = mysql_fetch_assoc($h);
$totalRows_h = mysql_num_rows($h);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_s = "SELECT * FROM www.state WHERE state_status = 1 ORDER BY state_name ASC";
$s = mysql_query($query_s, $hrmsdb) or die(mysql_error());
$row_s = mysql_fetch_assoc($s);
$totalRows_s = mysql_num_rows($s);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div class="passbox_back hidden2" id="cuti">
    <div class="passbox_form">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
            <tr>
              <td class="title">Langgan Rekod Cuti Rehat Tahun <?php echo date('Y');?></td>
            </tr>
            <tr>
              <td class="txt_line">
              <div>Pindah turun atau langgan Cuti Umum bagi tahun <?php echo date('Y');?> melalui URL berikut : </div>
              <div><a href="<?php echo $url_main;?>csv/cutiumum.php"><em><?php echo $url_main;?>csv/cutiumum.php</em></a></div>
              </td>
            </tr>
            <tr>
              <td class="fr">
              <input name="OK" type="button" class="submitbutton" value="OK" onclick="toggleview2('cuti'); return false;" />
              </td>
            </tr>
          </table>
    </div>
</div>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_leave.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
                <li><div class="note"><span class="fl w50">Senarai Cuti Umum Tahun <?php echo date('Y');?></span><span class="fr txt_right cursorpoint" onclick="toggleview2('cuti'); return false;">Langgan</span></div></li>
                <?php if ($totalRows_h > 0) { // Show if recordset not empty ?>
                <li>
                  <div class="off2">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th align="center" valign="middle">Bil</th>
                        <th align="center" valign="middle">Tarikh</th>
                        <th width="400" align="left" valign="middle">Perkara</th>
                        <?php do { ?>
                          <th height="80" align="center" valign="middle" style="margin:0px; padding:0px;"><div class="txt_vertical"><?php echo $row_s['state_name']; ?></div></th>
                          <?php } while ($row_s = mysql_fetch_assoc($s)); ?>
                      </tr>
                      <?php $i=1; do { ?>
                        <?php
                                          mysql_select_db($database_hrmsdb, $hrmsdb);
                                          $query_s2 = "SELECT * FROM www.state WHERE state_status = 1 ORDER BY state_name ASC";
                                          $s2 = mysql_query($query_s2, $hrmsdb) or die(mysql_error());
                                          $row_s2 = mysql_fetch_assoc($s2);
                                          $totalRows_s2 = mysql_num_rows($s2);
                                          ?>
                        <tr class="on">
                          <td align="center" valign="middle"><?php echo $i;?></td>
                          <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d/m/Y (D)', mktime(0, 0, 0, $row_h['holiday_date_m'], $row_h['holiday_date_d'], $row_h['holiday_date_y']));?></td>
                          <td align="left" valign="middle" nowrap="nowrap"><?php echo $row_h['holiday_name']; ?></td>
                          <?php do { ?>
                            <td align="center" class="line_l" <?php if(checkHolidayByState($row_h['holiday_id'], $row_s2['state_id'])) echo "style=\"background-color:#9C0;\"";?> ><?php if(checkHolidayByState($row_h['holiday_id'], $row_s2['state_id'])) echo "&bull;"; else echo "&nbsp;";?></td>
                            <?php } while ($row_s2 = mysql_fetch_assoc($s2)); ?>
                        </tr>
                        <?php mysql_free_result($s2);?>
                        <?php $i++; } while ($row_h = mysql_fetch_assoc($h)); ?>
                      <tr>
                        <td colspan="<?php echo ($totalRows_s + 4);?>" align="center" valign="middle" nowrap="nowrap" class="noline txt_color1"><?php echo $totalRows_h ?> rekod dijumpai</td>
                      </tr>
                    </table>
                  </div>
                </li>
                <?php } else { ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
        
		<?php include('../inc/footer.php');?>
        </div>
</div>
</body>
</html>
<?php
mysql_free_result($h);

mysql_free_result($s);
?>
<?php include('../inc/footinc.php');?>
