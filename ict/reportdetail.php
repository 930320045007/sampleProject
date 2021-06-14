<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='8';?>
<?php $menu2='29';?>
<?php
$colname_userreport = "-1";
if (isset($_GET['id'])) {
  $colname_userreport = getID(htmlspecialchars($_GET['id'], ENT_QUOTES), 0);
}
mysql_select_db($database_ictdb, $ictdb);
$query_userreport = sprintf("SELECT * FROM user_report WHERE userreport_id = %s ORDER BY userreport_id DESC", GetSQLValueString($colname_userreport, "int"));
$userreport = mysql_query($query_userreport, $ictdb) or die(mysql_error());
$row_userreport = mysql_fetch_assoc($userreport);
$totalRows_userreport = mysql_num_rows($userreport);

mysql_select_db($database_ictdb, $ictdb);
$query_urfeedback = "SELECT * FROM user_reportfeedback WHERE userreport_id = '" . $colname_userreport . "' ORDER BY urf_id ASC";
$urfeedback = mysql_query($query_urfeedback, $ictdb) or die(mysql_error());
$row_urfeedback = mysql_fetch_assoc($urfeedback);
$totalRows_urfeedback = mysql_num_rows($urfeedback);

mysql_select_db($database_ictdb, $ictdb);
$query_ftype = "SELECT * FROM feedback_type ORDER BY feedbacktype_name ASC";
$ftype = mysql_query($query_ftype, $ictdb) or die(mysql_error());
$row_ftype = mysql_fetch_assoc($ftype);
$totalRows_ftype = mysql_num_rows($ftype);
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
        <?php include('../inc/menu_ict_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            	<li>
                	<div class="note">Maklumat lengkap berkaitan aduan</div>
                </li>
                <?php if($row_userreport['user_stafid']==$row_user['user_stafid']){?>
            	<li>
            	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	  	<tr>
            	        <td nowrap="nowrap" class="label">Isu</td>
            	        <td colspan="3" width="100%"><strong><?php echo getReportSymptomByID($row_userreport['reportsymptom_id']); ?></strong></td>
          	        </tr>
            	  	<tr>
            	  	  <td nowrap="nowrap" class="label">Tarikh</td>
            	  	  <td colspan="3"><?php echo getReportDateByID($row_userreport['userreport_id']);?> &nbsp; &bull; &nbsp; <?php echo $row_userreport['userreport_time']; ?></td>
          	  	  </tr>
            	      <tr>
            	        <td nowrap="nowrap" class="label">Nama</td>
            	        <td colspan="3"><?php echo "<strong>" . getFullNameByStafID($row_userreport['user_stafid']) . " (" . $row_userreport['user_stafid'] . ")" . "</strong><div class=\"txt_color1\">" . getFulldirectoryByUserID($row_userreport['user_stafid']) . "</div>"; ?></td>
          	        </tr>
            	      <tr>
            	        <td nowrap="nowrap" class="label noline">Email</td>
            	        <td class="noline"><?php echo getEmailISNByUserID($row_userreport['user_stafid']); ?></td>
            	        <td class="label noline">Ext</td>
            	        <td width="100%" class="noline"><?php echo getExtNoByUserID($row_userreport['user_stafid']); ?></td>
          	        </tr>
            	  </table>
            	</li>
            	<li class="gap">&nbsp;</li>
                <li class="title">Maklum balas</li>
                <?php if ($totalRows_urfeedback > 0) { // Show if recordset not empty ?>
				  <?php do { ?>
                    <li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic($row_urfeedback['urf_by']);?></td>
                          <td width="100%" class="noline"><strong><?php echo getFeedbackTypeByID($row_urfeedback['feedbacktype_id']); ?></strong> <?php if($row_urfeedback['urf_stafid']!='0' && $row_urfeedback['urf_stafid']!=NULL) echo " kepada " . getFullNameByStafID($row_urfeedback['urf_stafid']) . " (" . $row_urfeedback['urf_stafid'] . ")"; ?></td>
                        </tr>
                        <tr>
                          <td class="noline"><?php echo $row_urfeedback['urf_note']; ?></td>
                        </tr>
                      </table>
                    </li>
      <li class="form_back2 line_b3">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="noline">Oleh <?php echo "<strong>" . getFullNameByStafID($row_urfeedback['urf_by']) . "</strong> (" . $row_urfeedback['urf_by'] .")"; ?> &nbsp; &bull; &nbsp; <?php echo getFeedbackDateByUserReportID($row_urfeedback['userreport_id'], $row_urfeedback['urf_id']); ?></td>
                        </tr>
                      </table>
                    </li>
                    <?php } while ($row_urfeedback = mysql_fetch_assoc($urfeedback)); ?>
                    <?php if(checkFeedbackEndByUserReportID($colname_userreport) && $row_userreport['userreport_star']==0){?>
                    <li class="title">Pengesahan</li>
                    <li>
                      <form id="form1" name="form1" method="post" action="../sb/update_reportfeedbackapproval.php">
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
                              <li class="txt_color1">Sangat memuaskan</li>
                          </ul>
                          </td>
                          <td class="noline">
                          <input name="MM_update" type="hidden" id="MM_update" value="formfeedback" />
                          <input name="id" type="hidden" id="id" value="<?php echo $row_userreport['userreport_id']; ?>" />
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
        <?php echo noteEmail('1');?>
		</div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($userreport);

mysql_free_result($urfeedback);

mysql_free_result($ftype);
?>
<?php include('../inc/footinc.php');?> 