<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='23';?>
<?php $menu3 = '4';?>

<?php
if(isset($_GET['d']))
	$dd = $_GET['d'];
else
	$dd = date('d');
	
if(isset($_GET['m']))
	$dm = $_GET['m'];
else
	$dm = date('m');
	
if(isset($_GET['y']))
	$dy = $_GET['y'];
else
	$dy = date('Y');

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_ul = "SELECT user_leavedate.* FROM www.user_leavedate LEFT JOIN (SELECT * FROM www.user_job2 WHERE user_job2.userjob2_status = '1' ORDER BY user_job2.userjob2_id DESC) AS user_job2 ON user_job2.user_stafid = user_leavedate.user_stafid LEFT JOIN www.user ON user.user_stafid = user_leavedate.user_stafid LEFT JOIN www.user_unit ON user_unit.user_stafid = user_leavedate.user_stafid LEFT JOIN www.user_scheme ON user_scheme.user_stafid = user_leavedate.user_stafid WHERE userleavedate_status = '1' AND userleavedate_app != '2' AND userleavedate_date_d = '" . $dd . "' AND userleavedate_date_m = '" . $dm . "' AND userleavedate_date_y = '" . $dy . "' GROUP BY user_leavedate.user_stafid ORDER BY user.user_firstname ASC, user.user_lastname ASC, userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";
$ul = mysql_query($query_ul, $hrmsdb) or die(mysql_error());
$row_ul = mysql_fetch_assoc($ul);
$totalRows_ul = mysql_num_rows($ul);
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
           <?php include('../inc/menu_senaraicuti.php');?>
          	<ul>
                <li class="line_b">
                  <form id="form1" name="form1" method="get" action="stafleaveday.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="noline label">Tarikh</td>
                        <td width="100%" class="noline"><label for="y"></label>
                          <select name="d" id="d">
                          <?php for($i=1; $i<=31; $i++){?>
                          	<option <?php if($i==$dd) echo "selected=\"selected\"";?> value="<?php if($i<10) echo "0" . $i; else echo $i;?>"><?php if($i<10) echo "0" . $i; else echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="m" id="m">
                          <?php for($j=1; $j<=12; $j++){?>
                          	<option <?php if($j==$dm) echo "selected=\"selected\"";?> value="<?php if($j<10) echo "0" . $j; else echo $j;?>"><?php if($j<10) $m = "0" . $j; else $m = $j; echo date('m - M', mktime(0, 0, 0, $m, 1, date('Y')));?></option>
                            <?php }; ?>
                            </select>
                          <select name="y" id="y">
                          <?php for($k=date('Y'); $k>=2012; $k--){?>
                          	<option <?php if($k==$dy) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
                            </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                	<div class="note">Senarai kakitangan yang bercuti pada <strong><?php echo date('d/m/Y (D)', mktime(0, 0, 0, $dm, $dd, $dy));?></strong></div>
                    <?php if(checkHolidayByDate($dd, $dm, $dy)){?>
                    	<div class="note line_t line_r line_b line_l form_back">Cuti Umum : <strong><?php echo getHolidayName($dd, $dm, $dy);?></strong> <?php if(!checkHolidayForAll($dd, $dm, $dy)) echo " bagi negeri-negeri tertentu sahaja.";?></div>
                    <?php }; ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <?php if ($totalRows_ul > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle">Bil</th>
                      <th width="100%" colspan="2" align="left" valign="middle">Nama / Jawatan</th>
                      <th align="center" valign="middle">Kategori</th>
                      <th align="center" valign="middle">Status</th>
                    </tr>
                    <?php $i=1; do { ?>
              <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="top"><?php echo viewProfilePic($row_ul['user_stafid']);?></td>
                        <td width="100%" align="left" valign="middle"><div><strong><?php echo getFullNameByStafID($row_ul['user_stafid']) . " (" . $row_ul['user_stafid'] . ")"; ?></strong></div><div class="txt_color1"><?php echo getJobtitle($row_ul['user_stafid']) . " (" . getGred($row_ul['user_stafid']) . ")";?></div><div class="txt_color1"><?php echo getFulldirectoryByUserID($row_ul['user_stafid']);?></div>
                        <?php if($row_ul['userleavedate_app']!=0){ ?><div class="txt_color1 padt">Oleh <?php echo getFullNameByStafID($row_ul['userleavedate_appby']); ?> pada <?php echo $row_ul['userleavedate_appdate']; ?></div><?php }; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php echo getLeaveType($row_ul['leavetype_id']); ?><br/><?php echo getLeaveCategory($row_ul['leavecategory_id']);?></td>
                <td align="center" valign="middle"><?php echo viewIconLeave($row_ul['user_stafid'], $row_ul['userleavedate_id'], $row_ul['leavetype_id'], $row_ul['userleavedate_date_d'], $row_ul['userleavedate_date_m'], $row_ul['userleavedate_date_y']); ?></td>
                      </tr>
                      <?php $i++; } while ($row_ul = mysql_fetch_assoc($ul)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_ul ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
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
mysql_free_result($ul);
?>
<?php include('../inc/footinc.php');?>
