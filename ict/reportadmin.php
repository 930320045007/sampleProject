<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='28';?>
<?php

$wb = "";
$dm = 0;
$dy = 0;

if(isset($_POST['jenis']) && $_POST['jenis']!=0)
	$jenis = htmlspecialchars($_POST['jenis'], ENT_QUOTES);
else
	$jenis = 0;


if(isset($_POST['dm']) && isset($_POST['dy']))
{
	$dm = htmlspecialchars($_POST['dm'], ENT_QUOTES);
	$dy = htmlspecialchars($_POST['dy'], ENT_QUOTES);
	$wb .= " AND userreport_date_m = '" . $dm . "' AND userreport_date_y = '" . $dy . "'";
} else {
	$dm = date('m');
	$dy = date('Y');
	$wb .= " AND userreport_date_m = '" . $dm . "' AND userreport_date_y = '" . $dy . "'";
}

if($jenis != 0)
{
	$wb .= " AND report_symptom.reportsubtype_id = '" . $jenis . "'";
}

?>
<?php
mysql_select_db($database_ictdb, $ictdb);
$query_userreport = "SELECT user_report.* FROM ict.user_report LEFT JOIN ict.report_symptom ON report_symptom.reportsymptom_id = user_report.reportsymptom_id WHERE userreport_result = '0' AND userreport_status = '1' " . $wb . " ORDER BY userreport_id DESC"; //userreport_result utk hidden
$userreport = mysql_query($query_userreport, $ictdb) or die(mysql_error());
$row_userreport = mysql_fetch_assoc($userreport);
$totalRows_userreport = mysql_num_rows($userreport);

mysql_select_db($database_ictdb, $ictdb);
$query_rstype = "SELECT * FROM report_subtype WHERE reportsubtype_status = 1 ORDER BY reportsubtype_name ASC";
$rstype = mysql_query($query_rstype, $ictdb) or die(mysql_error());
$row_rstype = mysql_fetch_assoc($rstype);
$totalRows_rstype = mysql_num_rows($rstype);
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
        <?php include('../inc/menu_ict.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){ ?>
            	<li class="form_back">
            	  <form id="form1" name="form1" method="post" action="reportadmin.php">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td class="label">Tarikh</td>
            	        <td width="100%" align="left" valign="middle" nowrap="nowrap">
            	          <select name="dm" id="dm">
                          <?php for($j=1; $j<=12; $j++){?>
                          <option <?php if($dm==$j) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; echo $j;?>"><?php echo $j . " - " . date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                          <?php }; ?>
          	            </select>
            	        <select name="dy" id="dy">
                          <?php for($k=date('Y'); $k>=2012; $k--){?>
                          <option <?php if($dy==$k) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                          <?php }; ?>
          	            </select>
                        <span class="inputlabel"> &nbsp; <b>Jenis</b></span>
                        <select name="jenis" id="jenis">
            	          <option value="0">Semua</option>
            	          <?php do { ?>
            	          <option <?php if($jenis==$row_rstype['reportsubtype_id']) echo "selected=\"selected\"";?> value="<?php echo $row_rstype['reportsubtype_id']?>"><?php echo $row_rstype['reportsubtype_name']?></option>
            	          <?php
							} while ($row_rstype = mysql_fetch_assoc($rstype));
							  $rows = mysql_num_rows($rstype);
							  if($rows > 0) {
								  mysql_data_seek($rstype, 0);
								  $row_rstype = mysql_fetch_assoc($rstype);
							  }
							?>
                        </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" />
                        </td>
            	        <td align="right" valign="middle"><span class="noline">
            	          <input name="button4" type="button" class="submitbutton" id="button4" value="Isu" onclick="MM_goToURL('parent','isu.php');return document.MM_returnValue"/>
            	        </span></td>
          	          </tr>
          	      </table>
          	      </form>
            	</li>
                <li>
                <div class="note">Senarai aduan bagi <?php if($dm != 0 && $dy != 0) echo "bulan " . date('F Y', mktime(0, 0, 0, $dm, 1, $dy)); else if($jenis!=0) echo getReportSubTypeBySymptomID($jenis);?></div>
  				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_userreport > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle">Bil</th>
                      <th align="center" valign="middle">Masa</th>
                      <th width="100%" colspan="2" align="left" valign="middle">Aduan / Nama / Unit</th>
                      <th align="center" valign="middle">Status</th>
                      <th align="center" valign="middle">Pengesahan</th>
                    </tr>
                    <?php $i=1; do { ?>
                  <tr class="on">
                        <td align="center" valign="middle"><?php echo $i; ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><div class="txt_line"><?php echo getReportDateByID($row_userreport['userreport_id']);?><br/><?php echo $row_userreport['userreport_time']; ?></div></td>
                        <td align="center" valign="top" class="txt_line"><?php echo viewProfilePic($row_userreport['user_stafid']);?></td>
                        <td width="100%" class="txt_line">
                        <div>
                          <div><a href="reportadmindetail.php?id=<?php echo $row_userreport['userreport_id']; ?>"><?php echo getReportTypeByID(getReportTypeBySymptomID($row_userreport['reportsymptom_id'])) . " &nbsp; &bull; &nbsp; " . getReportSubTypeByID(getReportSubTypeBySymptomID($row_userreport['reportsymptom_id'])) . " &nbsp; &bull; &nbsp; " . getReportSymptomByID($row_userreport['reportsymptom_id']); ?></a></div>
                          <div class="txt_color1">Oleh : <?php echo getFullNameByStafID($row_userreport['user_stafid']) . " (" . $row_userreport['user_stafid'] . ")"; ?><br/><?php echo getFulldirectoryByUserID($row_userreport['user_stafid']);?><?php echo " &nbsp; &bull; &nbsp; Ext : " . getExtNoByUserID($row_userreport['user_stafid']);?></div>
                          <?php if(getTotalFeedbackByUserReportID($row_userreport['userreport_id'])>0){?>
                          <div class="inputlabel2">Kemaskini oleh <?php echo getFullNameByStafID(getLastFeedbackUserIDByUserReportID($row_userreport['userreport_id'])) . " (" . getLastFeedbackUserIDByUserReportID($row_userreport['userreport_id']) . ")";?> pada <?php echo getLastFeedbackDateByUserReportID($row_userreport['userreport_id']);?> <?php if(getLastFeedbackToUserIDByUserReportID($row_userreport['userreport_id'])!='0'){?> untuk perhatian <?php echo getFullNameByStafID(getLastFeedbackToUserIDByUserReportID($row_userreport['userreport_id'])) . " (" . getLastFeedbackToUserIDByUserReportID($row_userreport['userreport_id']) . ")";?><?php }; ?></div>
                          <?php }; ?>
                        </div>
                        </td>
                  <td align="center" valign="middle" nowrap="nowrap">
				  <?php iconFeedbackStatusByUserReportID($row_userreport['userreport_id']);?> 
				  <?php if(!checkFeedbackEndByUserReportID($row_userreport['userreport_id']) && getFeedbackDayLong($row_userreport['userreport_id'])!= 0) 
				  echo "<div class=\"txt_size2\">" . getFeedbackDayLong($row_userreport['userreport_id']) . " Hari</div>";?>
                  </td>
                <td align="center" valign="middle" nowrap="nowrap"><?php echo iconFeedbackApprovalByUserReportID($row_userreport['userreport_id']);?> 
				<?php 
					$day = ((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - mktime(0, 0, 0, getFeedbackEndDateByUserReportID($row_userreport['userreport_id'], 2), getFeedbackEndDateByUserReportID($row_userreport['userreport_id'], 1), getFeedbackEndDateByUserReportID($row_userreport['userreport_id'], 3)))/86400); 
					
				if($day!= 0 && checkFeedbackEndByUserReportID($row_userreport['userreport_id']) && !checkFeedbackApprovalByUserReportID($row_userreport['userreport_id']))
				{ 
					echo "<div class=\"txt_size2\">" . $day . " Hari</div>";
				}
				?>
            </td>
                      </tr>
                      <?php $i++; } while ($row_userreport = mysql_fetch_assoc($userreport)); ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_userreport ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
            <?php } else {?>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
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
mysql_free_result($rstype);

mysql_free_result($userreport);
?>
<?php include('../inc/footinc.php');?> 