<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='7';?>
<?php $menu2='20';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_evofficer = "SELECT * FROM ev_officer WHERE NOT EXISTS (SELECT * FROM user_report WHERE user_report.user_stafid = '" . $row_user['user_stafid'] . "' AND user_report.userreport_type = ev_officer.evofficer_id AND user_report.userreport_status = '1') ORDER BY evofficer_id ASC";
$evofficer = mysql_query($query_evofficer, $hrmsdb) or die(mysql_error());
$row_evofficer = mysql_fetch_assoc($evofficer);
$totalRows_evofficer = mysql_num_rows($evofficer);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_list = "SELECT user.*, user_scheme.userscheme_gred, user_unit.dir_id FROM user LEFT JOIN user_scheme ON user_scheme.user_stafid = user.user_stafid LEFT JOIN user_job ON user_job.user_stafid = user.user_stafid LEFT JOIN user_unit ON user_unit.user_stafid = user.user_stafid WHERE (user_scheme.userscheme_gred >= '41' AND user_unit.dir_id = '" . getDirIDByUser($row_user['user_stafid']) . "' AND user.user_stafid != '" . $row_user['user_stafid'] . "') OR ( EXISTS (SELECT * FROM user_job2 WHERE user_job2.user_stafid = user.user_stafid)) GROUP BY user.user_stafid";
$user_list = mysql_query($query_user_list, $hrmsdb) or die(mysql_error());
$row_user_list = mysql_fetch_assoc($user_list);
$totalRows_user_list = mysql_num_rows($user_list);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_userunit = "SELECT user_unit.*, user.user_firstname FROM user_unit LEFT JOIN user ON user.user_stafid = user_unit.user_stafid WHERE dir_id = '" . getUserUnitIDByUserID($row_user['user_stafid']) . "' AND user_unit.user_stafid != '" . $row_user['user_stafid'] . "' ORDER BY user.user_firstname ASC";
$userunit = mysql_query($query_userunit, $hrmsdb) or die(mysql_error());
$row_userunit = mysql_fetch_assoc($userunit);
$totalRows_userunit = mysql_num_rows($userunit);
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
        <?php include('../inc/menu_unit.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
            <?php if(checkJob2View($row_user['user_stafid'])){?>
                <li>
                	<div class="note">Sila tetapkan Pegawai Bertanggungjawab </div>
                </li>
            <li class="title">Maklumat Pegawai Bertanggungjawab<?php if ($totalRows_evofficer > 0 && $totalRows_user_list > 0) { // Show if recordset not empty ?><span class="fr add" onclick="toggleview2('formsupervision'); return false;">+ Tambahan</span><?php } // Show if recordset not empty ?></li>
                <?php if ($totalRows_evofficer > 0 && $totalRows_user_list > 0) { // Show if recordset not empty ?>
                <div id="formsupervision" class="hidden">
                <li>
                  <form id="sv" name="sv" method="POST" action="../sb/add_supervision.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Staf</td>
                      <td colspan="3"><label for="user_stafid"></label>
                        <select name="user_stafid" id="user_stafid">
                          <?php
                do {  
                ?>
                          <option value="<?php echo $row_userunit['user_stafid']?>"><?php echo getFullNameByStafID($row_userunit['user_stafid']) . " (" . $row_userunit['user_stafid'] . ")";?></option>
                          <?php
                } while ($row_userunit = mysql_fetch_assoc($userunit));
                  $rows = mysql_num_rows($userunit);
                  if($rows > 0) {
                      mysql_data_seek($userunit, 0);
                      $row_userunit = mysql_fetch_assoc($userunit);
                  }
                ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Nama Pegawai</td>
                      <td><select name="userreport_stafid">
                        <?php
                do {  
                ?>
                        <option value="<?php echo $row_user_list['user_stafid']?>"><?php echo getFullNameByStafID($row_user_list['user_stafid']) . " (" . getGred($row_user_list['user_stafid']) . ")"; ?></option>
                        <?php
                } while ($row_user_list = mysql_fetch_assoc($user_list));
                  $rows = mysql_num_rows($user_list);
                  if($rows > 0) {
                      mysql_data_seek($user_list, 0);
                      $row_user_list = mysql_fetch_assoc($user_list);
                  }
                ?>
                        </select></td>
                      <td align="left" valign="middle"><select name="userreport_type" id="userreport_type">
                        <?php
                do {  
                ?>
                        <option value="<?php echo $row_evofficer['evofficer_id']?>"><?php echo $row_evofficer['evofficer_name']?></option>
                        <?php
                } while ($row_evofficer = mysql_fetch_assoc($evofficer));
                  $rows = mysql_num_rows($evofficer);
                  if($rows > 0) {
                      mysql_data_seek($evofficer, 0);
                      $row_evofficer = mysql_fetch_assoc($evofficer);
                  }
                ?>
                      </select></td>
                      <td width="100%" align="left" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="noline"><input name="userreport_date" type="hidden" id="userreport_date" value="<?php echo date('d/m/Y');?>" />        <input name="userreport_by" type="hidden" id="userreport_by" value="<?php echo $_SESSION['user_stafid'];?>" />
                        <input type="hidden" name="MM_insert" value="sv" /></td>
                      <td colspan="3" class="noline"><input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
                        <input name="button2" type="button" class="cancelbutton" id="button2" value="Batal" onclick="toggleview2('formsupervision'); return false;" /></td>
                    </tr>
                  </table>
                  </form>
                  </li>
                </div>
                <?php } // Show if recordset not empty ?>
              <div id="supervision">
                <li>
  					<?php include('../view/job.php');?>
                </li>
  				</div>           
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
<?php include('../inc/footinc.php');?> 
<?php
mysql_free_result($evofficer);

mysql_free_result($user_list);

mysql_free_result($userunit);
?>