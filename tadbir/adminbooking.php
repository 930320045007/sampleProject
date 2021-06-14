<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='40';?>
<?php
if(isset($_GET['bulan']))
{
	$my = explode("/", htmlspecialchars($_GET['bulan'], ENT_QUOTES));
} else {
	$my[0] = date('m');
	$my[1] = date('Y');
}

if(isset($_GET['lokasi']))
{
	$lokasi = htmlspecialchars($_GET['lokasi'], ENT_QUOTES);
} else {
	$lokasi = 1;
}
	
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_bookinglist = "SELECT * FROM hall_book WHERE hallbook_status = 1 AND hall_id = '" . $lokasi . "' AND hallbook_start_m = '" . $my[0] . "' AND hallbook_start_y = '" . $my[1] . "' ORDER BY hallbook_start_y+0 DESC, hallbook_start_m+0 DESC, hallbook_start_d+0 DESC, hallbook_id DESC";
$bookinglist = mysql_query($query_bookinglist, $tadbirdb) or die(mysql_error());
$row_bookinglist = mysql_fetch_assoc($bookinglist);
$totalRows_bookinglist = mysql_num_rows($bookinglist);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_hallist = "SELECT * FROM hall WHERE hall_status = 1 ORDER BY halltype_id ASC";
$hallist = mysql_query($query_hallist, $tadbirdb) or die(mysql_error());
$row_hallist = mysql_fetch_assoc($hallist);
$totalRows_hallist = mysql_num_rows($hallist);
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
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <li class="form_back">
                <form action="" method="get">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Lokasi</td>
                      <td>
                        <select name="lokasi" id="lokasi">
                          <?php
							do {  
							?>
                          <option value="" selected disabled hidden>*SILA PILIH</option>
                          <option <?php if($lokasi==$row_hallist['hall_id']) echo "selected=\"selected\"";?> value="<?php echo $row_hallist['hall_id'];?>"><?php echo getHallName($row_hallist['hall_id']); ?></option>
                          <?php
							} while ($row_hallist = mysql_fetch_assoc($hallist));
							  $rows = mysql_num_rows($hallist);
							  if($rows > 0) {
								  mysql_data_seek($hallist, 0);
								  $row_hallist = mysql_fetch_assoc($hallist);
							  }
							?>
                      </select></td>
                      <td nowrap="nowrap" class="label">Bulan</td>
                      <td width="100%">
                        <select name="bulan" id="bulan">
                        <?php for($i=1; $i<=12; $i++){?>
                          <option <?php if($my[0]==$i) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $i, 1, date('Y'))); ?>"><?php echo date('M Y', mktime(0, 0, 0, $i, 1, date('Y'))); ?></option>
                       	<?php }; ?>
                        </select>
                      <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                    </tr>
                  </table>
                </form>
              </li>
              <?php
      if($_GET['lokasi'] != ''){

     ?>
              <li>
              <div class="note">Tempahan <?php echo getHallName($lokasi); ?> bagi bulan <?php echo date('F Y', mktime(0, 0, 0, $my[0], 1, $my[1]));?></div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_bookinglist > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th align="center" valign="middle">Sesi</th>
                      <th width="100%" colspan="2" align="left" valign="middle">Perkara</th>
                      <th>&nbsp;</th>
                    </tr>
                    <?php do { ?>
                      <tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getBookingDate($row_bookinglist['hallbook_id']);?></td>
                        <td align="center" valign="middle"><?php echo getBookingSesi($row_bookinglist['hallbook_id']);?></td>
                        <td align="center" valign="top"><?php echo viewProfilePic($row_bookinglist['user_stafid']);?></td>
                        <td width="100%" align="left" valign="middle" class="txt_line">
                        <div>
                            <div><?php echo getBookingName($row_bookinglist['hallbook_id']);?></div>
                            <div class="padt"><strong><?php echo getFullNameByStafID($row_bookinglist['user_stafid']) . " (" . $row_bookinglist['user_stafid'] . ")"; ?></strong> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID($row_bookinglist['user_stafid'],0);?></div>
                            <div><?php echo getFulldirectoryByUserID($row_bookinglist['user_stafid']);?></div>
                            <?php if($row_bookinglist['hallbook_detail']!=NULL){?>
                            <div><?php echo $row_bookinglist['hallbook_detail']; ?></div>
                            <?php }; ?>
                        </div>
                        </td>
                        <td><ul class="func"><li><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){ ?><a onclick="return confirm('Anda mahu tempahan berikut dipadam? \r\n\n <?php echo getBookingDate($row_bookinglist['hallbook_id']);?> Sesi <?php echo getBookingSesi($row_bookinglist['hallbook_id']);?> \r\n\n <?php echo getBookingName($row_bookinglist['hallbook_id']);?> \r\n Oleh <?php echo getFullNameByStafID($row_bookinglist['user_stafid']) . " (" . $row_bookinglist['user_stafid'] . ")"; ?>')" href="../sb/del_hallbook.php?delhall=<?php echo $row_bookinglist['hallbook_id'];?>">X</a><?php }; ?></li></ul></td>
                      </tr>
                      <?php } while ($row_bookinglist = mysql_fetch_assoc($bookinglist)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_bookinglist;?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
              </li>
            <?php } ; ?>
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
<?php
mysql_free_result($bookinglist);

mysql_free_result($hallist);
?>
<?php include('../inc/footinc.php');?> 