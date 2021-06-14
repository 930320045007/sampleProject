<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='5';?> 
<?php $menu3='8';?> 
<?php

if(isset($_GET['birthday']))
	$m = $_GET['birthday'];
	else
	$m = $row_user['user_dob_m'];
	
mysql_select_db($database_hrmsdb, $hrmsdb);
	$sql_where = " login.login_status = '1' AND user_dob_m = '" . $m . "' AND userdesignation_status = '1' AND user_designation.userdesignation_status = '1'";
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
                  <form id="form1" name="form1" method="get" action="staflistnamebybirthday.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Bulan</td>
                        <td width="100%" class="noline">
                            
                         <select name="birthday" id="birthday">
                                <?php for($j=1; $j<=12; $j++){?>
                                  <option <?php if($j==$m) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                                <?php }; ?>
                              </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                      </tr>
                    </table>
                </form>
                </li>
                <li>
                <div class="note">Senarai nama kakitangan lahir pada bulan <?php echo date('M', mktime(0, 0, 0, $m, 1, date('Y')));?></div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>
                  <tr>
                    <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                   
                    <th align="left" valign="middle" nowrap="nowrap">Nama</th>
                    <th align="left" valign="middle" nowrap="nowrap">Tarikh Lahir</th>
                    <th width="50%" align="left" valign="middle" nowrap="nowrap">Cawangan</th>
                    <th width="50%" align="left" valign="middle" nowrap="nowrap">Jawatan</th>
                  </tr>
				  <?php $i=1; do{ ?>
                  <tr class="on">
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td align="left" valign="middle" nowrap="nowrap" class="txt_line"><?php echo getFullNameByStafID($row_staf['user_stafid'],1) . " (" . $row_staf['user_stafid'] . ")";?></td>
                    <td width="30%" align="left" valign="middle" nowrap="nowrap"><?php echo $row_staf['user_dob_d']."/". $row_staf['user_dob_m'] . "/". $row_staf['user_dob_y'] . " (". getAgeByUserID($row_staf['user_stafid']) . " tahun)";?></td>
                     <td width="30%" align="left" valign="middle"><?php echo getFulldirectoryByUserID($row_staf['user_stafid']);?></td>
                    <td width="20%" align="left" valign="middle"><?php echo getJobtitle($row_staf['user_stafid']); ?></td>
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