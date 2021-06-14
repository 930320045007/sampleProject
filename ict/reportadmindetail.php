<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='28';?>
<?php
$colname_userreport = "-1";
if (isset($_GET['id'])) {
  $colname_userreport = htmlspecialchars($_GET['id'], ENT_QUOTES);
}
mysql_select_db($database_ictdb, $ictdb);
$query_userreport = sprintf("SELECT * FROM ict.user_report WHERE userreport_id = %s ORDER BY userreport_id DESC", GetSQLValueString($colname_userreport, "int"));
$userreport = mysql_query($query_userreport, $ictdb) or die(mysql_error());
$row_userreport = mysql_fetch_assoc($userreport);
$totalRows_userreport = mysql_num_rows($userreport);

mysql_select_db($database_ictdb, $ictdb);
$query_urfeedback = "SELECT * FROM ict.user_reportfeedback WHERE userreport_id = '" . $colname_userreport . "' ORDER BY urf_id ASC";
$urfeedback = mysql_query($query_urfeedback, $ictdb) or die(mysql_error());
$row_urfeedback = mysql_fetch_assoc($urfeedback);
$totalRows_urfeedback = mysql_num_rows($urfeedback);

mysql_select_db($database_ictdb, $ictdb);
$query_ftype = "SELECT * FROM ict.feedback_type ORDER BY feedbacktype_name ASC";
$ftype = mysql_query($query_ftype, $ictdb) or die(mysql_error());
$row_ftype = mysql_fetch_assoc($ftype);
$totalRows_ftype = mysql_num_rows($ftype);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
            	<li>
                <div class="note">Laporan lengkap aduan dan maklum balas</div>
            	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	  	<tr>
            	        <td nowrap="nowrap" class="label">Isu</td>
            	        <td colspan="3"><strong><?php echo getReportTypeByID(getReportTypeBySymptomID($row_userreport['reportsymptom_id'])) . " &nbsp; &bull; &nbsp; " . getReportSubTypeByID(getReportSubTypeBySymptomID($row_userreport['reportsymptom_id'])) . " &nbsp; &bull; &nbsp; " . getReportSymptomByID($row_userreport['reportsymptom_id']); ?></strong></td>
          	        </tr>
            	  	<tr>
            	  	  <td nowrap="nowrap" class="label">Tarikh</td>
            	  	  <td colspan="3"><?php echo getReportDateByID($row_userreport['userreport_id']);?> &nbsp; <?php echo $row_userreport['userreport_time']; ?></td>
          	  	  </tr>
            	      <tr>
            	        <td nowrap="nowrap" class="label">Nama</td>
            	        <td colspan="3"><?php echo "<strong>" . getFullNameByStafID($row_userreport['user_stafid']) . " (" . $row_userreport['user_stafid'] . ")" . "</strong><div class=\"txt_color1\">" . getFulldirectoryByUserID($row_userreport['user_stafid']) . "</div>"; ?></td>
          	        </tr>
            	      <tr>
            	        <td nowrap="nowrap" class="label noline">Email</td>
            	        <td width="50%" class="noline"><?php echo getEmailISNByUserID($row_userreport['user_stafid']); ?></td>
            	        <td nowrap="nowrap" class="label noline">Ext</td>
            	        <td width="50%" class="noline"><?php echo getExtNoByUserID($row_userreport['user_stafid']); ?></td>
          	        </tr>
            	  </table>
            	</li>
                <li class="gap">&nbsp;</li>
                <li class="title">Maklum balas <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formfeedback'); return false;">+ Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formfeedback" class="hidden">
                <li>
                  <form id="form1" name="form1" method="post" action="../sb/add_reportfeedback.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Jenis</td>
                        <td width="100%">
                          <select name="feedbacktype_id" id="feedbacktype_id" onChange="dochange('11', 'urf_stafid', this.value, '0');">
                            <?php
							do {  
							?>
							<option value="<?php echo $row_ftype['feedbacktype_id']?>"><?php echo $row_ftype['feedbacktype_name']?></option>
							<?php
							} while ($row_ftype = mysql_fetch_assoc($ftype));
							  $rows = mysql_num_rows($ftype);
							  if($rows > 0) {
								  mysql_data_seek($ftype, 0);
								  $row_ftype = mysql_fetch_assoc($ftype);
							  }
							?>
                            <option value="0">Tamat</option>
                        </select>
                        <div id="urf_stafid">
                        </div>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td><span id="catatan"><span class="textareaRequiredMsg">Maklumat diperlukan.</span><span class="textareaMaxCharsMsg">500 huruf sahaja.</span>  
                        <textarea name="urf_note" id="urf_note" cols="45" rows="5"></textarea>
                          <?php //getEditor('urf_note', '1'); ?>
                          <div class="txt_color1 txt_line"><span id="countcatatan">&nbsp;</span> huruf &nbsp; &bull; &nbsp; oleh <?php echo "<strong>" . getFullNameByStafID($row_user['user_stafid']) . " (" . $row_user['user_stafid'] . ")</strong>";?></div></span>
                        </td>
                      </tr>
                      <tr>
                        <td class="label noline"><input name="MM_insert" type="hidden" id="MM_insert" value="reportfeedback" />
                        <input name="userreport_id" type="hidden" id="userreport_id" value="<?php echo $row_userreport['userreport_id']; ?>" /></td>
                        <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Hantar" />
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onClick="toggleview2('formfeedback'); return false;" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <?php if ($totalRows_urfeedback > 0) { // Show if recordset not empty ?>
				  <?php do { ?>
                    <li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic($row_urfeedback['urf_by']);?></td>
                          <td width="100%" class="noline"><strong><?php echo getFeedbackTypeByID($row_urfeedback['feedbacktype_id']); ?></strong>
                          <?php 
						  if($row_urfeedback['urf_stafid']!= '0' && $row_urfeedback['urf_stafid']!=NULL) 
						  echo " &nbsp; &nbsp; <span class=\"txt_color1\">&bull; &nbsp; &nbsp; " . getFullNameByStafID($row_urfeedback['urf_stafid']) . " (" . $row_urfeedback['urf_stafid'] . ")</span>"; ?>
                          <?php
						  if(getFeedbackEndWithPembekalanByUserReportFeedbackID($row_urfeedback['urf_id'])==1)
						  	echo " &nbsp; &nbsp; &bull; &nbsp; &nbsp;  menunggu pembekalan";
						  ?>
                          </td>
                        </tr>
                        <tr>
                          <td class="noline"><?php echo $row_urfeedback['urf_note']; ?></td>
                        </tr>
                      </table>
              </li>
      				<li class="form_back2 line_b3">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="noline">Oleh <?php echo "<strong>" . getFullNameByStafID($row_urfeedback['urf_by']) . " (" . $row_urfeedback['urf_by'] .")</strong>"; ?> &nbsp; &bull; &nbsp; <?php echo getFeedbackDateByUserReportID($row_urfeedback['userreport_id'], $row_urfeedback['urf_id']); ?></td>
                        </tr>
                      </table>
                    </li>
                    <?php } while ($row_urfeedback = mysql_fetch_assoc($urfeedback)); ?>
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
                            <td align="center" class="noline"><?php echo noteError(1);?></td>
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
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("catatan", {counterId:"countcatatan", counterType:"chars_remaining", maxChars:500});
</script>
</body>
</html>
<?php
mysql_free_result($userreport);

mysql_free_result($urfeedback);

mysql_free_result($ftype);
?>
<?php include('../inc/footinc.php');?> 