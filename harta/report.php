<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php $menu='11';?>
<?php $menu2='43';?>
<?php
if(isset($_GET['y']))
	$y = $_GET['y'];
else
	$y = date('Y');

//userreport_date_m = '" . $my[0] . "' AND userreport_date_y = '" . $my[1] . "' AND 
mysql_select_db($database_hartadb, $hartadb);
$query_ur = "SELECT * FROM harta.user_report WHERE userreport_status = 1 AND user_stafid = '" . $row_user['user_stafid'] . "' AND userreport_date_y = '" . $y . "' ORDER BY userreport_date_y DESC, userreport_date_m DESC, userreport_date_d DESC, userreport_id DESC";
$ur = mysql_query($query_ur, $hartadb) or die(mysql_error());
$row_ur = mysql_fetch_assoc($ur);
$totalRows_ur = mysql_num_rows($ur);
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
        <?php include('../inc/menu_harta_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            	<li class="form_back">
                  <form id="dateform" name="dateform" method="get" action="report.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tahun</td>
                        <td width="100%">
                          <select name="y" id="y">
                            <?php for($i=2011; $i<=date('Y'); $i++){?>
                              <option <?php if($i==$y) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
               	            </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                <div class="note"> Rekod aduan pada <strong><?php echo $y; // echo "bulan " . date('F Y', mktime(0, 0, 0, $my[0], 1, $my[1]));?></strong></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_ur > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th align="center" valign="middle" nowrap="nowrap">No. Tiket</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Status</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pengesahan</th>
                    </tr>
                    <?php $i=1; do { ?>
                  <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                <td align="center" valign="middle" nowrap="nowrap" class="txt_line"><?php echo getReportDate($row_ur['userreport_id'], 1);?></td>
                    <td align="center" valign="middle"><?php echo getReportTicketByID($row_ur['userreport_id']); ?></td>
                <td align="left" valign="middle" class="txt_line">
                <a href="reportdetail.php?id=<?php echo getID($row_ur['userreport_id']); ?>">
				<div><?php echo getCategoryNameByRCID($row_ur['rc_id']); ?> &nbsp; &bull; &nbsp; <?php echo getSubCategoryNameByRCID($row_ur['rc_id']); ?> &nbsp; &bull; &nbsp; <?php echo getRCTitleByID($row_ur['rc_id']);?></div>
                <div class="txt_color1">Lokasi : <?php echo getReportLocationByID($row_ur['userreport_id']);?></div>
                
               <?php if(checkReportFeedbackByID($row_ur['userreport_id'])){?><div class="inputlabel2">Tindakan oleh <?php echo getFullNameByStafID(getFeedbackLastStafID($row_ur['userreport_id'])) . " (" . getFeedbackLastStafID($row_ur['userreport_id']) . ")";?> pada <?php echo getFeedbackLastDate($row_ur['userreport_id']);?></div><?php }; ?>
                </a>
                </td>
                        <td align="center" valign="middle"><?php echo iconReportStatus($row_ur['userreport_id']);?></td>
                        <td align="center" valign="middle"><?php echo iconReportAprrovalStatus($row_ur['userreport_id']);?></td>
                      </tr>
                    <?php $i++; } while ($row_ur = mysql_fetch_assoc($ur)); ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_ur ?>  rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
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
mysql_free_result($ur);
?>
<?php include('../inc/footinc.php');?> 