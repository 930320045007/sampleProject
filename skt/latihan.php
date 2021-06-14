<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='68';?>
<?php
mysql_select_db($database_skt, $skt);
$query_tr = "SELECT * FROM skt.user_training WHERE usertraining_date_y = '" . date('Y') . "' AND user_stafid = '" . $row_user['user_stafid'] . "' AND usertraining_status = 1 ORDER BY usertraining_id ASC";
$tr = mysql_query($query_tr, $skt) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);
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
      	<?php include('../inc/menu_skt.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
              <li><div class="note">Senarai latihan yang diperlukan bagi tahun <strong><?php echo date('Y', mktime(0, 0, 0, 1, 1, date('Y')+1));?></strong></div></li>
              <li class="title">Latihan <span class="fr add" onclick="toggleview2('formtr'); return false;">Tambah</span></li>
              <div id="formtr" class="hidden">
              <li>
                <form id="form1" name="form1" method="POST" action="../sb/add_skttraining.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap class="label">Tajuk Kursus</td>
                      <td width="100%"><label for="usertraining_name"></label>
                      <input type="text" name="usertraining_name" id="usertraining_name" /></td>
                    </tr>
                    <tr>
                      <td class="label">Sebab Diperlukan</td>
                      <td><textarea name="usertraining_note" id="usertraining_note" cols="45" rows="5"></textarea></td>
                    </tr>
                    <tr>
                      <td class="label">&nbsp;</td>
                      <td><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah">
                      <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="toggleview2('formtr'); return false;"></td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_insert" value="form1" />
                </form>
              </li>
              </div>
              <li class="gap">&nbsp;</li>
              <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_tr > 0) { // Show if recordset not empty ?>
                  <tr>
                    <th>Bil</th>
                    <th width="100%" align="left" valign="middle">Latihan</th>
                    <th>&nbsp;</th>
                  </tr>
                  <?php $i=1; do { ?>
                    <tr class="on">
                      <td><?php echo $i;?></td>
                      <td align="left" valign="middle" class="txt_line">
                        <div><b><?php echo $row_tr['usertraining_name']; ?></b></div>
                        <div class="txt_color1"><?php echo $row_tr['usertraining_note']; ?></div>
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <?php $i++; } while ($row_tr = mysql_fetch_assoc($tr)); ?>
                  <tr>
                    <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_tr ?> rekod dijumpai</td>
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
<?php
mysql_free_result($tr);
?>
<?php include('../inc/footinc.php');?> 