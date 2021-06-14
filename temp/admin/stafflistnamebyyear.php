<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='5';?> 
<?php $menu3='2';?> 
<?php
if(isset($_GET['id']) && $_GET['id']==1) {
	$year = date('Y') - 1;
	$ysql = " user_job.userjob_start_y = '" . $year . "'";
	$yname = "1 tahun";
} elseif(isset($_GET['id']) && $_GET['id']==2) {
	$year = date('Y') - 2;
	$ysql = " user_job.userjob_start_y = '" . $year . "'";
	$yname = "2 tahun";
} elseif(isset($_GET['id']) && $_GET['id']==3) {
	$year = date('Y') - 3;
	$ysql = " user_job.userjob_start_y = '" . $year . "'";
	$yname = "3 tahun";
} elseif(isset($_GET['id']) && $_GET['id']==4) {
	$year = date('Y') - 4;
	$ysql = " user_job.userjob_start_y = '" . $year . "'";
	$yname = "4 tahun";
} elseif(isset($_GET['id']) && $_GET['id']==5) {
	$year = date('Y') - 5;
	$ysql = " user_job.userjob_start_y = '" . $year . "'";
	$yname = "5 tahun";
} elseif(isset($_GET['id']) && $_GET['id']==6){
	$year = date('Y') - 6;
	$ysql = " user_job.userjob_start_y = '" . $year . "'";
	$yname = "6 tahun";
} elseif(isset($_GET['id']) && $_GET['id']==7){
	$year = date('Y') - 7;
	$ysql = " user_job.userjob_start_y = '" . $year . "'";
	$yname = "7 tahun";
} elseif(isset($_GET['id']) && $_GET['id']==8){
	$year = date('Y') - 8;
	$ysql = " user_job.userjob_start_y = '" . $year . "'";
	$yname = "8 tahun";
} elseif(isset($_GET['id']) && $_GET['id']==9){
	$year = date('Y') - 9;
	$ysql = " user_job.userjob_start_y = '" . $year . "'";
	$yname = "9 tahun";
} elseif(isset($_GET['id']) && $_GET['id']==10){
	$year = date('Y') - 10;
	$ysql = " user_job.userjob_start_y = '" . $year . "'";
	$yname = "10 tahun";
} elseif(isset($_GET['id']) && $_GET['id']==11){
	$year = date('Y') - 11;
	$ysql = " user_job.userjob_start_y <= '" . $year . "'";
	$yname = "10 tahun dan keatas";
} else {
	$year = date('Y') - 1;
	$ysql = " user_job.userjob_start_y = '" . $year . "'";
	$yname = "1 tahun";
}
	
$sql_where = " login.login_status = '1' AND " . $ysql;
$orderby = "user_job.userjob_start_y ASC, user_job.userjob_start_m ASC, user_job.userjob_start_d ASC, user_firstname ASC, user_lastname ASC";

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_staf = sqlAllStaf($sql_where, $orderby);
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
            <?php include('../inc/menu_senaraistaf.php');?>
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li class="line_b">
                  <form id="form1" name="form1" method="get" action="stafflistnamebyyear.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Tempoh</td>
                        <td class="noline" width="100%">
                          <select name="id" id="id">
                            <option <?php if((isset($_GET['id']) && $_GET['id']==1) || !isset($_GET['id'])) echo "selected=\"selected\"";?> value="1">1 Tahun</option>
                            <option <?php if(isset($_GET['id']) && $_GET['id']==2) echo "selected=\"selected\"";?> value="2">2 Tahun</option>
                            <option <?php if(isset($_GET['id']) && $_GET['id']==3) echo "selected=\"selected\"";?> value="3">3 Tahun</option>
                            <option <?php if(isset($_GET['id']) && $_GET['id']==4) echo "selected=\"selected\"";?> value="4">4 Tahun</option>
                            <option <?php if(isset($_GET['id']) && $_GET['id']==5) echo "selected=\"selected\"";?> value="5">5 Tahun</option>
                            <option <?php if(isset($_GET['id']) && $_GET['id']==6) echo "selected=\"selected\"";?> value="6">6 Tahun</option>
                            <option <?php if(isset($_GET['id']) && $_GET['id']==7) echo "selected=\"selected\"";?> value="7">7 Tahun</option>
                            <option <?php if(isset($_GET['id']) && $_GET['id']==8) echo "selected=\"selected\"";?> value="8">8 Tahun</option>
                            <option <?php if(isset($_GET['id']) && $_GET['id']==9) echo "selected=\"selected\"";?> value="9">9 Tahun</option>
                            <option <?php if(isset($_GET['id']) && $_GET['id']==10) echo "selected=\"selected\"";?> value="10">10 Tahun</option>
                            <option <?php if(isset($_GET['id']) && $_GET['id']==11) echo "selected=\"selected\"";?> value="11">11 Tahun dan keatas</option>
                          </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                <div class="note">Senarai nama kakitangan yang berkhidmat bagi tempoh <strong><?php echo $yname;?></strong></div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>
                  <tr>
                    <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                    <th align="center" valign="middle" nowrap="nowrap">Tarikh Lantikan</th>
                    <th align="left" valign="middle" nowrap="nowrap">Nama</th>
                    <th align="center" valign="middle" nowrap="nowrap">No. KP</th>
                    <th width="100%" align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                  </tr>
				  <?php $i=1; do{ ?>
                  <tr class="on">
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php echo getServiceDate($row_staf['user_stafid']);?></td>
                    <td align="left" valign="middle" nowrap="nowrap" class="txt_line"><?php echo getFullNameByStafID($row_staf['user_stafid'],1) . " (" . $row_staf['user_stafid'] . ")";?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php echo getICNoByStafID($row_staf['user_stafid']);?></td>
                    <td align="center" valign="middle" nowrap="nowrap">&nbsp;</td>
                  </tr>
                  <?php $i++; } while ($row_staf = mysql_fetch_assoc($staf)); ?>
                  <tr>
                    <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_staf; ?> rekod dijumpai</td>
                  </tr>
                  <?php } else { ?>
                  <tr>
                    <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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
?>