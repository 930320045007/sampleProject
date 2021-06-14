<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='23';?> 
<?php
if(isset($_GET['dmy']))
	$y = htmlspecialchars($_GET['dmy'], ENT_QUOTES);
else
	$y = date('Y');
?>
<?php
  mysql_select_db($database_hrmsdb, $hrmsdb);
$query_hol = "SELECT * FROM holiday WHERE holiday_status = 1 AND holiday_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' ORDER BY holiday_date_y ASC, holiday_date_m ASC, holiday_date_d ASC";
$hol = mysql_query($query_hol, $hrmsdb) or die(mysql_error());
$row_hol = mysql_fetch_assoc($hol);
$totalRows_hol = mysql_num_rows($hol);
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
        <?php include('../inc/menu_admin.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="holiday.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Tahun</td>
                        <td width="100%">
                          <select name="dmy" id="dmy">
                          <?php for($i=2012; $i<=(date('Y')+5); $i++){?>
                            <option <?php if($y==$i) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                        <td><input name="button4" type="button" class="submitbutton" id="button4" value="Tambah" onclick="MM_goToURL('parent','holidayadd.php');return document.MM_returnValue"/></td>
                      </tr>
                    </table>
                  </form>
              </li>
                <li>
                <div class="note">Senarai Cuti Umum bagi tahun <strong><?php echo $y;?></strong></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_hol > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="30%" align="left" valign="middle" nowrap="nowrap">Peristiwa</th>
                      <th width="50%" align="left" valign="middle" nowrap="nowrap">Negeri</th>
                      <th width="20%" align="left" valign="middle" nowrap="nowrap">Padam</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_hol['holiday_date_m'], $row_hol['holiday_date_d'], $row_hol['holiday_date_y']));?></td>
                        <td align="left"><?php echo $row_hol['holiday_name']; ?></td>
                        <td align="left"><?php echo getHolidayState($row_hol['holiday_id']); ?></td>
                
                     <td align="left"><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo $row_hol['holiday_name']; ?> - <?php echo getHolidayState($row_hol['holiday_id'], false); ?>')" href="../sb/del_holiday.php?id=<?php echo $row_hol['holiday_id']; ?>"><img title="delete" src="../icon/delete.jpg" width="20" height="20"/></a>
            </td>
                      </tr>
                      <?php $i++; } while ($row_hol = mysql_fetch_assoc($hol)); ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_hol ?> rekod dijumpai</td>
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
        
		<div align="center">
		  <?php include('../inc/footer.php');?>
	  </div>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($hol);
?>
<?php include('../inc/footinc.php');?> 