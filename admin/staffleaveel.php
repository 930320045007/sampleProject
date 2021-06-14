<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='23';?>
<?php $menu3 = '1';?>
<?php
if(isset($_GET['dmy']))
{
	$dmy = explode("/", $_GET['dmy']);
	$d = 1;
	$m = $dmy['0'];
	$y = $dmy['1'];
} else {
	$d = date('d');
	$m = date('m');
	$y = date('Y');
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT * FROM www.dir WHERE dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);
$totalRows_dir = mysql_num_rows($dir);

if(isset($_GET['dir']))
	$jtl = $_GET['dir'];
else
	$jtl = $row_dir['dir_id'];
	
$sql_where = " login.login_status = '1' AND user_unit.dir_id = '" .$jtl . "' AND userdesignation_status = '1' AND user_designation.userdesignation_status = '1'";
	$order_by = "userdesignation_date_y DESC, userdesignation_date_m DESC, userdesignation_date_d DESC, userdesignation_id DESC, user.user_firstname ASC, user.user_lastname ASC";
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
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <?php include('../inc/menu_senaraicuti.php');?>
          		<ul>
                 <li class="line_b">
                  <form id="form1" name="form1" method="get" action="staffleaveel.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Bhg/Cwgn/Pusat/Unit</td>
                        <td class="noline" width="100%">
                           <select name="dir" id="dir">
            	            <?php
							do {  
							?>
                           <option <?php if(isset($_GET['dir']) && $_GET['dir']==$row_dir['dir_id']) echo "selected=\"selected\"";?> value="<?php echo $row_dir['dir_id']?>"><?php echo getFullDirectory($row_dir['dir_id'],0)?></option>
                            <?php
                            } while ($row_dir = mysql_fetch_assoc($dir));
                              $rows = mysql_num_rows($dir);
                              if($rows > 0) {
                                  mysql_data_seek($dir, 0);
                                  $row_dir = mysql_fetch_assoc($dir);
                              }
                            ?>
                          </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                      </tr>
                    </table>
                </form>
                </li>
                <li>
                	<div class="note">Senarai cuti kakitangan bagi tahun <strong><?php echo date('Y');?></strong> </div>
                </li>
                <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>
                <li>
                <div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama</th>
                      <?php for($mv=1; $mv<13; $mv++){?>
                      <th align="center" valign="middle" nowrap="nowrap"><?php echo $mv;?></th>
                      <?php }; ?>
                      <th align="center" valign="middle" nowrap="nowrap">JUMLAH</th>
                    </tr>
                    <?php $i=1; do{ ?>
                    <tr class="on">
                      <td align="center" valign="middle"><?php echo $i;?></td>
                      <td align="left" valign="middle" nowrap="nowrap" class="txt_line">
					  <div><?php echo getFullNameByStafID($row_staf['user_stafid'],1) . " (" . $row_staf['user_stafid'] . ")";?></div>
                      </td>
                     <?php for($mc=1; $mc<13; $mc++){?>
                      <?php if($mc<10) $mc = '0' . $mc;?>
                      <td align="center" valign="middle" nowrap="nowrap" <?php if(countLeaveTypeByStafID($row_staf['user_stafid'], '1', $mc, '2018')=='0') echo "class=\"txt_color1\"";?>><?php echo countLeaveTypeByStafID($row_staf['user_stafid'], '1', $mc, '2018');?></td>
                      <?php }; ?>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo countLeaveBalance($row_staf['user_stafid'], '2018');?></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo countLeaveTypeByStafID($row_staf['user_stafid'], '1', '0', '2018');?></td>
                    </tr>
      				<?php $i++; } while ($row_staf = mysql_fetch_assoc($staf)); ?>
                  </table>
                </div>
                </li>
				<?php } else { ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="11" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  </table>
                 </li>
                <?php }; ?>
            </ul>
            <?php } ; ?>
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
