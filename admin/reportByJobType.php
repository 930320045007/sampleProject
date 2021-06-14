<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='14';?> 
<?php $menu3='1';?> 
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jt = "SELECT * FROM www.job_type WHERE jobtype_status = 1 ORDER BY jobtype_id ASC";
$jt = mysql_query($query_jt, $hrmsdb) or die(mysql_error());
$row_jt = mysql_fetch_assoc($jt);
$totalRows_jt = mysql_num_rows($jt);

if(isset($_GET['jt']))
	$jtl = $_GET['jt'];
else
	$jtl = $row_jt['jobtype_id'];
	
mysql_select_db($database_hrmsdb, $hrmsdb);
	$sql_where = "login.login_status = '1' AND jobtype_id = '" . $jtl . "' AND userdesignation_status = '1' AND user_designation.userdesignation_status = '1'";
	$order_by = "user_scheme.userscheme_gred DESC,userdesignation_date_y ASC, userdesignation_date_m ASC, userdesignation_date_d ASC, userdesignation_id DESC";
	$query_staf = sqlAllStaf($sql_where, $order_by);
	$staf = mysql_query($query_staf, $hrmsdb) or die(mysql_error());
	$row_staf = mysql_fetch_assoc($staf);
	$totalRows_staf = mysql_num_rows($staf);
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
            <?php include('../inc/menu_senarailaporan.php');?>
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
              <li class="line_b">
                  <form id="form1" name="form1" method="get" action="reportByJobType.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Status</td>
                        <td class="noline" width="100%">
                          <select name="jt" id="jt">
                            <?php
							do {  
							?>
                            <option <?php if($jtl == $row_jt['jobtype_id']) echo "selected=\"selected\"";?> value="<?php echo $row_jt['jobtype_id']?>"><?php echo $row_jt['jobtype_name']?></option>
                            <?php
							} while ($row_jt = mysql_fetch_assoc($jt));
							  $rows = mysql_num_rows($jt);
							  if($rows > 0) {
								  mysql_data_seek($jt, 0);
								  $row_jt = mysql_fetch_assoc($jt);
							  }
							?>
                          </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                      </tr>
                    </table>
                </form>
                </li>
                <li>
                <div class="note">Jumlah kursus bagi kakitangan berstatus <strong><?php echo getJobtypeByID($jtl);?></strong></div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>
                  <tr>
                    <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                    <th align="left" valign="middle" nowrap="nowrap">Nama</th>
                    <th align="center" valign="middle" nowrap="nowrap">No. KP</th>
                    <th align="center" valign="middle" nowrap="nowrap">Jawatan</th>
                    <th align="center" valign="middle" nowrap="nowrap">Gred</th>
                    <th align="center" valign="middle" nowrap="nowrap">Jumlah Hari<br />Menghadiri Kursus</th>
                    <th align="center" valign="middle" nowrap="nowrap">Baki Hari Belum<br />Menghadiri Kursus</th>
                    <th align="center" valign="middle" nowrap="nowrap">Tarikh Lantikan</th>    
                  </tr>
				  <?php $i=1; do{ ?>
                  <tr class="on">
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td align="left" valign="middle" nowrap="nowrap" class="txt_line"><?php echo getFullNameByStafID($row_staf['user_stafid'],1);?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php echo getICNoByStafID($row_staf['user_stafid']);?></td>
                    <td align="center" valign="middle"><?php echo getJobtitle($row_staf['user_stafid']); ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php echo getGred($row_staf['user_stafid']);?></td>
                    <td align="center" valign="middle" nowrap="nowrap">
		<?php $courseshour = countCoursesHour($row_staf['user_stafid'], date('2016'));?>
		<?php 
			if($courseshour['0']>0) 
				echo $courseshour['0']; 
			else if($courseshour['1']<0) 
				echo ""; 
			if($courseshour['1']>0) 
				echo "";
		?>
        </td>
        <td align="center" valign="middle" nowrap="nowrap">
		<?php 
			if($courseshour['0']<7) 
				echo 7 - $courseshour['0'];
		 if($courseshour['0']>=7)
				echo "0"; 
		?>
        </td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_staf['userdesignation_date_m'], $row_staf['userdesignation_date_d'], $row_staf['userdesignation_date_y']));?></td>
                  </tr>
                  <?php $i++; } while ($row_staf = mysql_fetch_assoc($staf)); ?>
                  <tr>
                    <td colspan="8" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_staf; ?> rekod dijumpai</td>
                  </tr>
                  <?php } else { ?>
                  <tr>
                    <td colspan="8" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                  </tr>
                  <?php }; ?>
                </table>
              </li>
            <?php } ; ?>
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
mysql_free_result($staf);

mysql_free_result($jt);
?>
