<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='80';?>
<?php
$m = array();
if(isset($_GET['m']))
{
	$m = explode("/", htmlspecialchars($_GET['m'], ENT_QUOTES));
	$wsql = " AND maintenance_m = '" . $m['0'] . "' AND maintenance_y = '" . $m['1'] . "'";
} else
{
	$m[0] = date('m');
	$m[1] = date('Y');
	$wsql = " AND maintenance_m = '" . $m['0'] . "' AND maintenance_y = '" . $m['1'] . "'";
};
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_main = "SELECT * FROM maintenance WHERE maintenance_status = 1 ". $wsql ." AND maintenance_by ='". $row_user['user_stafid'] ."' ORDER BY maintenance_y DESC, maintenance_m DESC, maintenance_d DESC";
$main = mysql_query($query_main, $tadbirdb) or die(mysql_error());
$row_main = mysql_fetch_assoc($main);
$totalRows_main = mysql_num_rows($main);
	
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
              <form id="form1" name="form1" method="get" action="maintenancelist.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Tarikh</td>
                    <td width="100%">
                    <select name="m" id="m">
                    <?php for($i=(date('m')+5); $i>=(date('m')-5); $i--){?>
                    <option <?php if($m['0']==date('m', mktime(0, 0, 0, $i, 1, date('Y'))) && $m['1']==date('Y', mktime(0, 0, 0, $i, 1, date('Y')))) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $i, 1, date('Y')));?>"><?php echo date('M Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>
                    <?php }; ?>
                    </select>
                    <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                    <td><input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="MM_goToURL('parent','maintenance.php');return document.MM_returnValue" /></td>
                  </tr>
                </table>
              </form>
            </li>
            	<li><div class="note">Senarai penyelenggaraan kenderaan bagi bulan<strong> <?php echo date('M Y', mktime(0, 0, 0, $m['0'], 1, $m['1']));?></strong></div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_main > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Kenderaan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pengesahan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Status</th>
                    </tr>
                    <?php $i=1; do { ?>
                  	<tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getMaintenanceDateByID($row_main['maintenance_id']);?></td> 
                    	<td align="left" valign="middle" class="txt_line">
                        <a href="maintenancedetail.php?id=<?php echo getID($row_main['maintenance_id']); ?>">
                        <div><strong><?php echo getTransportNameByMaintenanceID($row_main['maintenance_id']); ?></strong> &nbsp; &bull; &nbsp; <?php echo getTransportPlatByMaintenanceID($row_main['maintenance_id']);?></div>
                        </a>
                        </td>
                		<td align="center" valign="middle"><?php echo iconAdminApp($row_main['maintenance_id']);?></td>
                        <td align="center" valign="middle"><?php echo iconMaintenanceValid($row_main['maintenance_id']);?></td>
                        <td align="center" valign="middle"><?php echo iconMaintenanceApp($row_main['maintenance_id']);?></td>
                      </tr>
                      <?php $i++; } while ($row_main = mysql_fetch_assoc($main)); ?>
                      <tr>
                        <td colspan="7" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_main ?> rekod dijumpai</td>
                      </tr>
                     <?php } else { ?>
                     <tr>
                      <td colspan="7" align="center" valign="middle">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
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
mysql_free_result($main);
?>
<?php include('../inc/footinc.php');?> 