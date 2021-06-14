<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='21';?> 
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dirl = "SELECT * FROM dir WHERE dir_status = 1 AND NOT EXISTS (SELECT user_stafid FROM dir AS dir2 WHERE dir2.dir_status=1 AND user_stafid != '' AND dir2.dir_id = dir.dir_id) ORDER BY dir_type ASC, dir_name ASC";
$dirl = mysql_query($query_dirl, $hrmsdb) or die(mysql_error());
$row_dirl = mysql_fetch_assoc($dirl);
$totalRows_dirl = mysql_num_rows($dirl);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT * FROM dir WHERE user_stafid != '' AND dir_status = 1 ORDER BY dir_name ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);
$totalRows_dir = mysql_num_rows($dir);
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
  <li class="form_back">
    <form id="formhead" name="formhead" method="POST" action="../sb/add_head.php">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td nowrap="nowrap" class="label noline">Cawangan / Pusat / Unit</td>
          <td class="noline">
            <select name="dir_id" id="dir_id">
              <?php
do {  
?>
              <option value="<?php echo $row_dirl['dir_id']?>"><?php echo getFulldirectory($row_dirl['dir_id'], 0);?></option>
              <?php
} while ($row_dirl = mysql_fetch_assoc($dirl));
  $rows = mysql_num_rows($dirl);
  if($rows > 0) {
      mysql_data_seek($dirl, 0);
	  $row_dirl = mysql_fetch_assoc($dirl);
  }
?>
              </select></td>
          <td nowrap="nowrap" class="label noline">Staf ID</td>
          <td width="100%" class="noline"><label for="user_stafid"></label>
            <input name="user_stafid" type="text" class="w35" id="user_stafid" />
            <input name="button3" type="submit" class="submitbutton" id="button3" value="Daftar" /></td>
          </tr>
        </table>
      <input type="hidden" name="MM_update" value="formhead" />
      </form>
  </li>
<li>
                <div class="note">Ketua Cawangan / Pusat / Unit berperanan untuk mengesahkan, menerima maklum balas berkaitan permohonan cuti / kursus dan mengetahui maklumat staf dibawah Cawangan / Pusat / Unit beliau dan perkara - perkara dibawah tanggungjawab beliau.</div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_dir > 0) { // Show if recordset not empty ?>
    <tr>
      <th width="50%" align="left" nowrap="nowrap">Cawangan / Pusat / Unit</th>
      <th width="50%" align="left" valign="middle" nowrap="nowrap">Nama Ketua / Jawatan</th>
      <th align="left" valign="middle" nowrap="nowrap">&nbsp;</th>
    </tr>
    <?php do { ?>
      <tr class="on">
        <td><?php echo $row_dir['dir_name']; ?></td>
        <td align="left" valign="middle"><div class="txt_line"><strong><?php echo getFullNameByStafID($row_dir['user_stafid']); ?></strong> (<?php echo $row_dir['user_stafid'];?>)<div class="txt_color1"><?php echo getJobtitle($row_dir['user_stafid']);?> (<?php echo getGred($row_dir['user_stafid']);?>)</div></div></td>
        <td align="left" valign="middle"><ul class="func"><li>X</li></ul></td>
      </tr>
      <?php } while ($row_dir = mysql_fetch_assoc($dir)); ?>
    <tr>
      <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_dir ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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
<?php include('../inc/footinc.php');?> 
<?php
	mysql_free_result($dir);
	mysql_free_result($dirl);
?>