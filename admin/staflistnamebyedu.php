<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='5';?> 
<?php $menu3='9';?> 
<?php

$sql_where = " login.login_status = '1'";
$orderby = "user_firstname ASC, user_lastname ASC";

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
<?php include('../inc/liload.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>
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
                <li>
                <div class="note">Senarai nama kakitangan berserta pendidikan</div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>
                  <tr>
                    <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                   
                    <th align="left" valign="middle" nowrap="nowrap">Nama</th> 
                   <th width="50%" align="left" valign="middle" nowrap="nowrap">Jawatan</th>
                    <th width="50%" align="left" valign="middle" nowrap="nowrap">Pendidikan</th>
                  </tr>
				  <?php $i=1; do{ ?>
                  <tr class="on">
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td align="left" valign="middle" nowrap="nowrap" class="txt_line"><?php echo getFullNameByStafID($row_staf['user_stafid'],1) . " (" . $row_staf['user_stafid'] . ")";?></td>
                     <td><?php echo getJobtitleReal($row_staf['user_stafid']);?> (<?php echo getGred($row_staf['user_stafid']); ?>)</td>
                    <td width="20%" align="left" valign="middle"><?php echo getEdulevel(getEduLevelByStafID($row_staf['user_stafid'])); ?><?php echo getEduMajor(getEduMajorByStafID($row_staf['user_stafid'])); ?> </td>
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