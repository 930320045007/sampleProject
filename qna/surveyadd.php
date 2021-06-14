<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/selidikdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/selidikfunc.php');?>
<?php $menu='13';?>
<?php $menu2='49';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kumpsasaran = "SELECT * FROM www.group WHERE group_status = 1 AND group_view = 1 ORDER BY group_id ASC";
$kumpsasaran = mysql_query($query_kumpsasaran, $hrmsdb) or die(mysql_error());
$row_kumpsasaran = mysql_fetch_assoc($kumpsasaran);
$totalRows_kumpsasaran = mysql_num_rows($kumpsasaran);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_khusus = "SELECT dir_id, dir_name FROM www.dir WHERE dir_type = 1 AND dir_status = 1 ORDER BY dir_sort ASC";
$khusus = mysql_query($query_khusus, $hrmsdb) or die(mysql_error());
$row_khusus = mysql_fetch_assoc($khusus);
$totalRows_khusus = mysql_num_rows($khusus);
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
                <li>
                <div class="note">Penambahan soal selidik baru</div>
                  <form id="form1" name="form1" method="POST" action="../sb/add_surveyadd.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Tajuk</td>
                        <td colspan="3"><input type="text" name="sd_title" id="sd_title" /></td>
                      </tr>
                      <tr>
                        <td class="label">Maklumat <br />
                        Lengkap</td>
                        <td colspan="3">
                        <textarea name="sd_desc" id="sd_desc" cols="45" rows="5"></textarea>
                        <?php getEditor('sd_desc', '1'); ?>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">Tarikh Mula</td>
                        <td class="w35">
                        <select name="sd_date_d" id="sd_date_d">
                        <?php for($i=1; $i<=31; $i++){?>
                          <option <?php if($i<10) $i = '0' . $i; if($i==date('d')) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php }; ?>
                        </select>
                        <select name="sd_date_m" id="sd_date_m">
                        <?php for($j=date('m'); $j<=12; $j++){?>
                          <option <?php if($j<10) $j = '0' . $j; if($j==date('m')) echo "selected=\"selected\"";?> value="<?php echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                        <?php }; ?>
                        </select>
                        <select name="sd_date_y" id="sd_date_y">
                          <option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
                        </select>
                        </td>
                        <td class="label">Tarikh Tamat</td>
                        <td class="w35">
                        <select name="sd_end_d" id="sd_end_d">
                        <?php for($k=1; $k<=31; $k++){?>
                          <option <?php if($k<10) $k = '0' . $k; if($k==date('d')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                        <?php }; ?>
                        </select>
                        <select name="sd_end_m" id="sd_end_m">
                        <?php for($l=date('m'); $l<=12; $l++){?>
                          <option <?php if($l<10) $i = '0' . $l; if($l==date('m')) echo "selected=\"selected\"";?> value="<?php if($l<10) $l = '0' . $l; echo $l;?>"><?php echo date('M', mktime(0, 0, 0, $l, 1, date('Y')));?></option>
                        <?php }; ?>
                        </select>
                        <select name="sd_end_y" id="sd_end_y">
                          <option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
                        </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">Kumpulan Sasaran</td>
                        <td colspan="3">
                        <select name="group_id" id="group_id">
                          <option value="0">Semua</option>
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_kumpsasaran['group_id']?>"><?php echo $row_kumpsasaran['group_name']?></option>
                          <?php
							} while ($row_kumpsasaran = mysql_fetch_assoc($kumpsasaran));
							  $rows = mysql_num_rows($kumpsasaran);
							  if($rows > 0) {
								  mysql_data_seek($kumpsasaran, 0);
								  $row_kumpsasaran = mysql_fetch_assoc($kumpsasaran);
							  }
							?>
                        </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">Pengkhususan</td>
                        <td colspan="3">
                        <select name="division_id" id="division_id">
                          <option value="0">Semua</option>
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_khusus['dir_id']?>"><?php echo $row_khusus['dir_name']?></option>
                          <?php
							} while ($row_khusus = mysql_fetch_assoc($khusus));
							  $rows = mysql_num_rows($khusus);
							  if($rows > 0) {
								  mysql_data_seek($khusus, 0);
								  $row_khusus = mysql_fetch_assoc($khusus);
							  }
							?>
                        </select></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="3"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="form1">
                  </form>
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
<?php
mysql_free_result($kumpsasaran);

mysql_free_result($khusus);
?>
<?php include('../inc/footinc.php');?>
