<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php $menu='11';?>
<?php $menu2='43';?>
<?php 
if(isset($_GET['id']) && checkReportID(getID($_GET['id'],0), $row_user['user_stafid']))
{
	$urid = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
} else {
	$urid = 0;
}
?>
<?php
mysql_select_db($database_hartadb, $hartadb);
$query_urf = "SELECT * FROM user_reportfeedback WHERE userreport_id = '" . $urid . "' AND urf_status = 1 ORDER BY urf_id ASC";
$urf = mysql_query($query_urf, $hartadb) or die(mysql_error());
$row_urf = mysql_fetch_assoc($urf);
$totalRows_urf = mysql_num_rows($urf);


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
            	<li>
                <div class="note">Maklumat lengkap berkaitan aduan</div>
                </li>
            	<?php if(getReportByByID($urid)==$row_user['user_stafid']){?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Tarikh</td>
                      <td width="100%"><?php echo getReportDate($urid);?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">No. Tiket</td>
                      <td><?php echo getReportTicketByID($urid); ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Perkara</td>
                      <td ><?php echo getCategoryNameByRCID(getReportCaseByURID($urid)); ?> &nbsp; &bull; &nbsp; <?php echo getSubCategoryNameByRCID(getReportCaseByURID($urid)); ?> &nbsp; &bull; &nbsp; <?php echo getRCTitleByID(getReportCaseByURID($urid));?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Lokasi</td>
                      <td ><?php echo getReportLocationByID($urid);?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Oleh</td>
                      <td class="txt_line noline"><strong><?php echo getFullNameByStafID(getReportByByID($urid)) . " (" . getReportByByID($urid) . ")";?></strong>, Ext : <?php echo getExtNoByUserID(getReportByByID($urid));?><br/><?php echo getFulldirectoryByUserID(getReportByByID($urid));?></td>
                    </tr>
                  </table>
              </li>
            	<li class="gap">&nbsp;</li>
                <li class="title">Maklum Balas </li>
                <?php if ($totalRows_urf > 0) { // Show if recordset not empty ?>
				  <?php do { ?>
                    <li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic(getFeedbackByByURFID($row_urf['urf_id']));?></td>
                          <td width="100%" class="noline">
                          <strong><?php echo getFeedbackTypeName(getFeedbackTypeByURFID($row_urf['urf_id']));?></strong>
						  <?php if(checkFeedbackActionByURFID($row_urf['urf_id'])) echo "<span class=\"txt_color1\"> &nbsp; &bull; &nbsp; " . getFullNameByStafID(getFeedbackActionStafIDByURFID($row_urf['urf_id'])) . " (" . getFeedbackActionStafIDByURFID($row_urf['urf_id']) . ")</span>";?>
                          </td>
                        </tr>
                        <tr>
                          <td class="noline"><?php echo getFeedbackNoteByURFID($row_urf['urf_id']);?></td>
                        </tr>
                        </table>
              </li>
                    <li class="form_back2 line_b3">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="noline">Oleh : <strong><?php echo getFullNameByStafID(getFeedbackByByURFID($row_urf['urf_id'])) . " (" . getFeedbackByByURFID($row_urf['urf_id']) . ")";?></strong> &nbsp; &bull; &nbsp; <?php echo getFeedbackDateByURFID($row_urf['urf_id']);?></td>
                          </tr>
                        </table>
                    </li>
                    <?php } while ($row_urf = mysql_fetch_assoc($urf)); ?>
                    <?php if(checkFeedbackEnd($urid) && !checkReportApprovalHarta($urid)){?>
                    <li class="title">Pengesahan</li>
                    <li>
                      <form id="formfeedbackapproval" name="formfeedbackapproval" method="post" action="../sb/update_mbj_reportfeedbackapproval.php">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                      <td colspan="2" class="noline">Dengan membuat penilaian ini bermaksud anda mengesahkan perkara diatas.</td>
                      </tr>
                        <tr>
                          <td width="100%" class="noline">
                          <ul class="inputradio">
                          <li class="txt_color1">Tidak memuaskan</li>
                          <li><input name="star" type="radio" id="star" value="1" /> 1</li>
                          <li><input name="star" type="radio" id="star" value="2" /> 2</li>
                          <li><input name="star" type="radio" id="star" value="3" checked="checked" /> 3</li>
                          <li><input name="star" type="radio" id="star" value="4" /> 4</li>
                          <li><input name="star" type="radio" id="star" value="5" /> 5</li>
                          <li class="txt_color1">Sangat memuaskan</li></ul>
                          </td>
                          <td class="noline">
                          <input name="MM_update" type="hidden" id="MM_update" value="formfeedback" />
                          <input name="userreport_id" type="hidden" id="userreport_id" value="<?php echo $urid;?>" />
                          <input name="button3" type="submit" class="submitbutton" id="button3" value="Hantar" />
                          </td>
                        </tr>
                      </table>
                      </form>
                    </li>
                 <?php }; ?>
                  <?php } else { ?>
                  <li>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                      </tr>
                    </table>
                  </li>
                  <?php }; ?>
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
mysql_free_result($urf);
?>
<?php include('../inc/footinc.php');?> 