<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='5';?> 
<?php $menu3='7';?> 
<?php

if(isset($_GET['gender']))
	$m = $_GET['gender'];
	
mysql_select_db($database_hrmsdb, $hrmsdb);
	$sql_where = " login.login_status = '1' AND user_gender = '" . $m . "' AND userdesignation_status = '1' AND user_designation.userdesignation_status = '1'";
	$order_by = "user.user_firstname ASC, user.user_lastname ASC";
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
<?php include('../inc/liload.php');?>
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
                  <form id="form1" name="form1" method="get" action="stafflistnamebygender.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  class="label noline" nowrap="nowrap">Status Jantina</td>
                        <td width="100%" class="noline">
                            
                         <select name="gender" id="gender">
                	             <option <?php if((isset($_GET['gender']) && $_GET['gender']==1) || !isset($_GET['gender'])) echo "selected=\"selected\"";?> value="1">Lelaki</option>
                            <option <?php if(isset($_GET['gender']) && $_GET['gender']==2) echo "selected=\"selected\"";?> value="2">Perempuan</option>
                                </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                      </tr>
                    </table>
                </form>
                </li>
                <li>
                <div class="note">Senarai nama kakitangan</div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>
                  <tr>
                    <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                   
                    <th align="left" valign="middle" nowrap="nowrap">Nama</th>
                    <th align="left" valign="middle" nowrap="nowrap">Email</th>
                    <th align="left" valign="middle" nowrap="nowrap">No. Telefon</th>
                    <th align="left" valign="middle" nowrap="nowrap">Ext</th>
                  </tr>
				  <?php $i=1; do{ ?>
                  <tr class="on">
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td align="left" valign="middle" nowrap="nowrap" class="txt_line"><?php echo getFullNameByStafID($row_staf['user_stafid'],1) . " (" . $row_staf['user_stafid'] . ")";?></td>
                    <td width="30%" align="left" valign="middle" nowrap="nowrap"><?php echo getEmailISNByUserID($row_staf['user_stafid']);?></td>
                     <td width="30%" align="left" valign="middle" nowrap="nowrap"><?php echo getTelMByStafID($row_staf['user_stafid']);?></td>
                    <td width="20%" align="left" valign="middle" nowrap="nowrap"><?php echo getExtNoByUserID($row_staf['user_stafid']);?></td>
                  </tr>
                  <?php $i++; } while ($row_staf = mysql_fetch_assoc($staf)); ?>
                  <tr>
                    <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_staf; ?> rekod dijumpai</td>
                  </tr>
                  <?php } else { ?>
                  <tr>
                    <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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