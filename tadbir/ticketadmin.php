<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='57';?>
<?php
$m = array();
if(isset($_GET['m']))
{
	$m = explode("/", htmlspecialchars($_GET['m'], ENT_QUOTES));
	$wsql = " AND ticket_date_m = '" . $m['0'] . "' AND ticket_date_y = '" . $m['1'] . "'";
} else
{
	$m[0] = date('m');
	$m[1] = date('Y');
	$wsql = " AND ticket_date_m = '" . $m['0'] . "' AND ticket_date_y = '" . $m['1'] . "'";
};
	
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tiket = "SELECT * FROM tadbir.ticket WHERE ticket_status = 1 " . $wsql . " ORDER BY ticket_date_y DESC, ticket_date_m DESC, ticket_date_d DESC";
$tiket = mysql_query($query_tiket, $tadbirdb) or die(mysql_error());
$row_tiket = mysql_fetch_assoc($tiket);
$totalRows_tiket = mysql_num_rows($tiket);
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
              <form id="form1" name="form1" method="get" action="ticketadmin.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Tarikh</td>
                    <td width="100%">
                    <select name="m" id="m">
                    <?php for($i=1; $i<=12; $i++){?>
            	            <option <?php if($i<10) $i= "0" . $i;  if($i==$m['0']) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $i, 1, date('Y')));?>"><?php echo date('M Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>
                          <?php }; ?>
                    </select>
                    <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                    <td><input name="button3" type="button" class="submitbutton" id="button3" value="Agensi" onclick="MM_goToURL('parent','agensi.php');return document.MM_returnValue" /></td>
                  </tr>
                </table>
              </form>
            </li>
            	<li><div class="note">Senarai tempahan bagi bulan<strong> <?php echo date('M Y', mktime(0, 0, 0, $m['0'], 1, $m['1']));?></strong></div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_tiket > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Status Tiket</th>
                      <th>&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                  	<tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getTiketDate($row_tiket['ticket_id']);?></td>
                    	<td align="left" valign="middle" class="txt_line">
                        <a href="ticketdetailadmin.php?id=<?php echo $row_tiket['ticket_id']; ?>">
                        <div><strong><?php echo $row_tiket['ticket_title']; ?></strong> &nbsp; &bull; &nbsp; <?php echo getTiketRef($row_tiket['ticket_id']);?></div>
                        <div class="txt_color1">Oleh : <?php echo getFullNameByStafID(getTiketBy($row_tiket['ticket_id'])) . " (" . getTiketBy($row_tiket['ticket_id']) . ")";?>, <?php echo getFulldirectoryByUserID(getTiketBy($row_tiket['ticket_id']));?></div>
                        </a>
                        </td>
                		<td align="center" valign="middle"><?php echo iconTiketApp($row_tiket['ticket_id']);?></td>
                        <td align="center" valign="middle"><?php echo iconTiketInv($row_tiket['ticket_id']);?></td>
                        <td><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo getTiketRef($row_tiket['ticket_id']);?>\r\n<?php echo getTiketDate($row_tiket['ticket_id']);?>')" href="<?php echo $url_main;?>sb/del_ticket.php?id=<?php echo $row_tiket['ticket_id'];?>">X</a></li></ul></td>
                      </tr>
                      <?php $i++; } while ($row_tiket = mysql_fetch_assoc($tiket)); ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_tiket ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle">Tiada rekod dijumpai</td>
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
mysql_free_result($tiket);
?>
<?php include('../inc/footinc.php');?> 