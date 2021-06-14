<?php require_once('../Connections/hrmsdb.php'); ?> 
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='63';?>
<?php
$y = date('Y');

mysql_select_db($database_skt, $skt);
$query_uskt = "SELECT * FROM user_skt WHERE uskt_date_y = '" . $y . "' AND user_stafid = '" . $row_user['user_stafid'] . "' AND uskt_status = 1 ORDER BY uskt_masa_mula ASC, uskt_masa_tamat ASC, uskt_id ASC";
$uskt = mysql_query($query_uskt, $skt) or die(mysql_error());
$row_uskt = mysql_fetch_assoc($uskt);
$totalRows_uskt = mysql_num_rows($uskt);
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
      	<?php include('../inc/menu_skt.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
                <li>
                	<div class="note">Carta Bulanan bagi <?php echo date('Y');?></div>
                </li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_uskt > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap" class="line_r">Perkara</th>
                      <?php for($i=1; $i<=12; $i++){?>
                      <th align="center" valign="middle" nowrap="nowrap" class="line_t line_r"><?php echo $i;?></th>
                      <?php }; ?>
                    </tr>
                    <?php $ti=1; do { ?>
                      <tr class="<?php if(checkFeedbackCancel($row_uskt['uskt_id'])) echo "offcourses"; else echo "on";?>">
                        <td align="center" valign="middle"><?php echo $ti; ?></td>
                        <td align="left" valign="middle" class="line_r"><a href="<?php echo $url_main;?>skt/sktdetail.php?id=<?php echo getID($row_uskt['uskt_id']); ?>"><?php echo $row_uskt['uskt_aktiviti'];?></a></td>
                      	<?php for($i=1; $i<=12; $i++){?>
                        <td align="center" valign="middle" class="line_r" <?php if(checkSKTMasaInMonth($row_uskt['uskt_id'], $i)) {  if(checkFeedbackCancel($row_uskt['uskt_id'])) { echo "style=\"background-color:#EEE;\""; } elseif($i<date('m')) echo "style=\"background-color:#DDD;\""; else echo "style=\"background-color:#9C0;\"";}?>>&nbsp;</td>
                        <?php }; ?>
                      </tr>
                      <?php $ti++; } while ($row_uskt = mysql_fetch_assoc($uskt)); ?>
                    <tr>
                      <td colspan="15" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_uskt ?>  rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="15" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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
mysql_free_result($uskt);
?>
<?php include('../inc/footinc.php');?> 