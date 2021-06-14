<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='8';?>
<?php $menu2='29';?>
<?php
if(isset($_GET['y']))
	$y = $_GET['y'];
else
	$y = date('Y');
	
mysql_select_db($database_ictdb, $ictdb);
$query_userborrow = "SELECT * FROM ict.user_borrow WHERE userborrow_date_y = '" . $y . "' AND userborrow_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
$userborrow = mysql_query($query_userborrow, $ictdb) or die(mysql_error());
$row_userborrow = mysql_fetch_assoc($userborrow);
$totalRows_userborrow = mysql_num_rows($userborrow);

mysql_select_db($database_ictdb, $ictdb);
$query_userreport = "SELECT * FROM user_report WHERE userreport_date_y = '" . $y . "' AND userreport_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' AND userreport_result = '0' ORDER BY userreport_id DESC";
$userreport = mysql_query($query_userreport, $ictdb) or die(mysql_error());
$row_userreport = mysql_fetch_assoc($userreport);
$totalRows_userreport = mysql_num_rows($userreport);

mysql_select_db($database_ictdb, $ictdb);
$query_userapply = "SELECT * FROM ict.user_apply WHERE userapply_by = '" . $row_user['user_stafid'] . "' AND userapply_status = '1' ORDER BY userapply_date_y DESC, userapply_date_m DESC, userapply_date_d DESC, userapply_id DESC";
$userapply = mysql_query($query_userapply, $ictdb) or die(mysql_error());
$row_userapply = mysql_fetch_assoc($userapply);
$totalRows_userapply = mysql_num_rows($userapply);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        
        <?php include('../inc/menu_ict_user.php');?>
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
                            <?php for($i=2011; $i<=date('Y'); $i++){?>
                              <option <?php if($i==$y) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
               	            </select>
               	            <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
               	          </tr>
               	        </table>
                  	  </form>
                    </li>
                	<li><div class="note">Rekod sepanjang tahun <?php echo $y;?></div></li>
                	<li class="title">Rekod Pinjaman</li>
					<li>
                    <div class="off">
  					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php if ($totalRows_userborrow > 0) { // Show if recordset not empty ?>
<tr>
                          <th nowrap="nowrap">Bil</th>
                          <th nowrap="nowrap">Tarikh</th>
                          <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                          <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>
                          <th align="center" valign="middle" nowrap="nowrap">Penyerahan</th>
                      </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td><?php echo $i;?></td>
                            <td nowrap="nowrap"><?php echo getDateBorrowByUserBorrowID($row_userborrow['userborrow_id']);?></td>
                            <td class="txt_line">
                            <a href="recorddetail.php?id=<?php echo getID($row_userborrow['userborrow_id']); ?>">
                            <div>
                            <strong><?php echo $row_userborrow['userborrow_title']; ?></strong>
                            </div>
                            <div class="txt_color1">Tempat : <?php echo $row_userborrow['userborrow_location']; ?> &nbsp; &bull; &nbsp; Masa : <?php echo getTimeBorrowByUserBorrowID($row_userborrow['userborrow_id']);?> &nbsp; &bull; &nbsp; Tempoh : <?php echo getDurationByUserBorrowID($row_userborrow['userborrow_id']);?>
                            </div>
                            </a>
                            </td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php echo iconICTApproval($row_userborrow['userborrow_id']);?></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php echo iconICTReturn($row_userborrow['userborrow_id']);?></td>
                          </tr>
                          <?php $i++; } while ($row_userborrow = mysql_fetch_assoc($userborrow)); ?>
                        <tr>
                          <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_userborrow ?> rekod dijumpai</td>
                        </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
                      </div>
                    </li>
                    <li></li>
                    <li class="title">Rekod Aduan</li>
                    <li>
                    <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <?php if ($totalRows_userreport > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Isu</th>
                      <th align="center" valign="middle" nowrap="nowrap">Status</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pengesahan</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getReportDateByID($row_userreport['userreport_id']); ?><br/><?php echo $row_userreport['userreport_time']; ?></td>
                        <td><a href="reportdetail.php?id=<?php echo getID($row_userreport['userreport_id']); ?>"><?php echo getReportTypeByID(getReportTypeBySymptomID($row_userreport['reportsymptom_id'])) . " &nbsp; &bull; &nbsp; " . getReportSubTypeByID(getReportSubTypeBySymptomID($row_userreport['reportsymptom_id'])) . " &nbsp &bull; &nbsp; " . getReportSymptomByID($row_userreport['reportsymptom_id']); ?></a></td>
                        <td align="center" valign="middle"><?php iconFeedbackStatusByUserReportID($row_userreport['userreport_id']);?></td>
                        <td align="center" valign="middle"><?php echo iconFeedbackApprovalByUserReportID($row_userreport['userreport_id']);?></td>
                      </tr>
                      <?php $i++; } while ($row_userreport = mysql_fetch_assoc($userreport)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_userreport ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                    </li>
                    <?php if (getJob2ID($row_user['user_stafid'])!=0){ ?>
                    <li></li>
                    <li class="title">Rekod Permohonan</li>
					<li>
                    <div class="off">
  					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php if ($totalRows_userapply > 0) { // Show if recordset not empty ?>
<tr>
                          <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                          <th width="100%" align="left" valign="middle" nowrap="nowrap">Tarikh</th>
                          <th align="center" valign="middle" nowrap="nowrap">Bil. Pemohon<br />
                          (kakitangan)</th>
                          <th align="center" valign="middle" nowrap="nowrap">Status</th>
                      </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td align="center" valign="middle"><?php echo $i;?></td>
                            <td align="left" valign="middle" nowrap="nowrap">
                            <a href="applydetail.php?id=<?php echo getID($row_userapply['userapply_id']); ?>">
							<?php echo getApplyDateByApplyID($row_userapply['userapply_id']);?>
                            </a>
                            </td> 
                            <td align="center" valign="middle" nowrap="nowrap"><?php echo countTotalStafByApplyID($row_userapply['userapply_id']);?></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php echo iconApplyStatus($row_userapply['userapply_id']);?></td>
                          </tr>
                          <?php $i++; } while ($row_userapply = mysql_fetch_assoc($userapply)); ?>
                        <tr>
                          <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_userapply ?> rekod dijumpai</td>
                        </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
                      </div>
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
mysql_free_result($userborrow);

mysql_free_result($userreport);
mysql_free_result($userapply);
?>
<?php include('../inc/footinc.php');?> 