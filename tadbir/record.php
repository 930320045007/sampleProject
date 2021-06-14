<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='9';?>
<?php $menu2='56';?>
<?php

if(isset($_GET['y']))
	$y = $_GET['y'];
else
	$y = date('Y');

$colname_tr = "-1";

if (isset($_GET['id'])) 
{
  $colname_tr = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
}

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tiket = "SELECT * FROM ticket WHERE ticket_date_y = '" . $y . "' AND ticket_status = 1 AND ticket_by = '" . $row_user['user_stafid'] . "' ORDER BY ticket_date_y DESC";
$tiket = mysql_query($query_tiket, $tadbirdb) or die(mysql_error());
$row_tiket = mysql_fetch_assoc($tiket);
$totalRows_tiket = mysql_num_rows($tiket);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = "SELECT * FROM transport_book WHERE transbook_date_y = '" . $y . "' AND transbook_status = 1 AND transbook_by = '" . $row_user['user_stafid'] . "' ORDER BY transbook_id DESC";
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

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
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="record.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Tahun</td>
                        <td width="100%">
                          <select name="y" id="y">
                          <?php for($i=2012; $i<=date('Y'); $i++){?>
                            <option <?php if($i == $y) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                          </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
            	<li><div class="note">Senarai rekod mengikut kategori bagi tahun <?php echo $y;?></div></li>
                <li class="title">Tempahan Tiket</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_tiket > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Status Tiket</th>
                    </tr>
                    <?php $i=1; do { ?>
                  	<tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getTiketDate($row_tiket['ticket_id']);?></td>
                    	<td align="left" valign="middle"><strong><a href="ticketdetail.php?id=<?php echo $row_tiket['ticket_id']; ?>"><?php echo $row_tiket['ticket_title']; ?></a></strong></td>
                		<td align="center" valign="middle"><?php echo iconTiketApp($row_tiket['ticket_id']);?></td>
                        <td align="center" valign="middle"><?php echo iconTiketInv($row_tiket['ticket_id']);?></td>
                    </tr>
                      <?php $i++; } while ($row_tiket = mysql_fetch_assoc($tiket)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_tiket ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Tempahan Kenderaan</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_tr > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>                     
                      <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>
                       <th align="center" valign="middle" nowrap="nowrap">Penilaian</th>
                    </tr>
                    <?php $i=1; do { ?>
                  	<tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getBookDateByTransbookID($row_tr['transbook_id']);?></td>
                    	<td align="left" valign="middle"><strong><a href="transportdetail.php?id=<?php echo getID(htmlspecialchars($row_tr['transbook_id'],ENT_QUOTES)); ?>"><?php echo $row_tr['transbook_title']; ?></a></strong></td>        
                		<td align="center" valign="middle"><?php echo iconBookTransportStatus($row_tr['transbook_id']);?></td>
                        <td align="center" valign="middle">
                        <?php 
						if(checkFeedback($row_tr['transbook_id']) && checkAdminAppByID($row_tr['transbook_id'])) 
							echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
						elseif(!checkFeedback($row_tr['transbook_id']) && checkAdminAppByID($row_tr['transbook_id']) && checkTransbookEndByTransID($row_tr['transbook_id']))
							echo "<a href=\"" . $url_main . "tadbir/feedbackadd.php?id=" . getID($row_tr['transbook_id']) . "\">Isi</a>";
						?>
                        </td>
                      </tr>
                      <?php $i++; } while ($row_tr = mysql_fetch_assoc($tr)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_tr ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
            </ul>
            </div>
        </div>
        <?php echo noteMade($menu);?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($tiket);
mysql_free_result($tr);
?>
<?php include('../inc/footinc.php');?> 