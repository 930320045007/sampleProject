<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='3';?>
<?php $menu2='22';?>
<?php
$secondyear = date('Y') - 2;

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_plc = "SELECT user_stafid, usplc_date_y, usplc_status, SUM(usplc_total) AS usplc_total FROM user_plc WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND usplc_status = '1' GROUP BY user_stafid, usplc_date_y ORDER BY usplc_date_y DESC";
$plc = mysql_query($query_plc, $hrmsdb) or die(mysql_error());
$row_plc = mysql_fetch_assoc($plc);
$totalRows_plc = mysql_num_rows($plc);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_gcr = "SELECT  SUM(uspgcr_total) AS uspgcr_total, uspgcr_date_y, user_stafid  FROM user_gcr WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND uspgcr_status = '1' GROUP BY user_stafid, uspgcr_date_y ORDER BY uspgcr_date_y DESC";
$gcr = mysql_query($query_gcr, $hrmsdb) or die(mysql_error());
$row_gcr = mysql_fetch_assoc($gcr);
$totalRows_gcr = mysql_num_rows($gcr);
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
        <?php include('../inc/menu_leave.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          <ul>
          <?php if(getDesignationType($row_user['user_stafid'])){?>
            <li>
              <div class="note">Rekod cuti dibawa mengikut kategori :</div></li>
            	<li class="title">Cuti Dibawa Kehadapan <?php if(getDesignationType($row_user['user_stafid'])){?><span class="fr add" onClick="toggleview2('formplc'); return false;">Tambah</span><?php }; ?></li>
                <?php if(getDesignationType($row_user['user_stafid'])){?>
                <div id="formplc" class="hidden">
                <li>
                  <form id="formplc2" name="formplc2" method="POST" action="../sb/add_plc.php">
                <div class="note">Pastikan anda telah membuat perbincangan dengan Cawangan Sumber Manusia berkaitan dengan Cuti Dibawa Kehadapan.<br />Jumlah maksimum hari yang dibenarkan iaitu <strong><?php echo countLeaveBalance($row_user['user_stafid'], date('Y'));?> Hari</strong> bagi Tahun <?php echo date('Y');?></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Tahun</td>
                        <td class="noline">
                          <select name="usplc_date_y" id="usplc_date_y">
                          <?php for($i=(date('Y')-1); $i<=(date('Y')+2); $i++){?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                        </select></td>
                        <td nowrap="nowrap" class="label noline">Jumlah Hari</td>
                        <td width="100%" class="noline"><input name="usplc_total" type="text" class="w25" id="usplc_total" value="<?php echo countLeaveBalance($row_user['user_stafid'], date('Y'));?>" />
                          <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" />
<input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" /><input name="batal" type="button" class="cancelbutton" id="batal" value="Batal" onClick="toggleview2('formplc'); return false;" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="formplc2" />
                  </form>
                </li>
                </div>
                <?php }; ?>
                <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_plc > 0) { // Show if recordset not empty ?>
<tr>
                      <th nowrap="nowrap">Tahun</th>
                      <th nowrap="nowrap">&nbsp;</th>
                      <th align="left" nowrap="nowrap">Tahun dikira</th>
                      <th width="100%" align="left" nowrap="nowrap">&nbsp;</th>
                    <th align="center" valign="middle" nowrap="nowrap">Kiraan (Hari)</th>
                    </tr>
                    <?php do { ?>
                      <tr class="<?php if($row_plc['usplc_date_y']>=$secondyear) echo "on"; else echo "offcourses";?>">
                        <td align="center"><?php echo $row_plc['usplc_date_y']; ?></td>
                        <td align="center"><span class="txt_size3">&rarr;</span></td>
                        <td align="center"><?php $viewyear = "0"; if($row_plc['usplc_date_y']==date('Y')) echo $viewyear = $row_plc['usplc_date_y'] + 1; else if($row_plc['usplc_date_y']<date('Y') && $row_plc['usplc_date_y']>=(date('Y'))) echo $viewyear = date('Y'); else if($row_plc['usplc_date_y']>date('Y')) echo $viewyear = $row_plc['usplc_date_y'] + 1; else if($row_plc['usplc_date_y']<date('Y')) echo $viewyear = $row_plc['usplc_date_y'] - 1;?></td>
                        <td align="left"><span class="txt_color1"><?php if($viewyear == date('Y')) echo "Ditambah dalam Cuti Rehat / Tahunan bagi tahun semasa"; else if($viewyear > date('Y')) echo "Ditambah dalam Cuti Rehat / Tahunan bagi tahun " . $viewyear; else echo "Lupus";?></span></td>
                        <td align="center" valign="middle"><?php echo $row_plc['usplc_total']; ?> <?php if($row_plc['usplc_date_y']==date('Y')) echo "**"; else if($row_plc['usplc_date_y']<date('Y') && $row_plc['usplc_date_y']>=$secondyear) echo "*";?></td>
                      </tr>
                      <?php } while ($row_plc = mysql_fetch_assoc($plc)); ?>
                    <tr>
                      <td colspan="5" align="center" class="noline txt_color1"><?php echo $totalRows_plc ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                <li class="title">GCR <?php if(getDesignationType($row_user['user_stafid']) && checkGCRLimit($row_user['user_stafid'])){?><span class="fr add" onClick="toggleview2('formgcr'); return false;">Tambah</span><?php }; ?></li>
                <?php if(getDesignationType($row_user['user_stafid']) && checkGCRLimit($row_user['user_stafid'])){?>
                <div id="formgcr" class="hidden">
                <li>
                  <form id="formgcr2" name="formgcr2" method="POST" action="../sb/add_gcr.php">
                <div class="note">Pastikan anda telah membuat perbincangan dengan Cawangan Sumber Manusia berkaitan dengan GCR.<br />Jumlah maksimum hari yang dibenarkan iaitu <strong><?php echo countGCRPLCLimit($row_user['user_stafid'], date('Y'));?> Hari</strong> bagi Tahun <?php echo date('Y');?></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Tahun</td>
                        <td class="noline">
                          <select name="uspgcr_date_y" id="uspgcr_date_y">
                          <?php for($i=date('Y')-1; $i<=(date('Y')+2); $i++){?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                        </select></td>
                        <td nowrap="nowrap" class="label noline">Jumlah Hari</td>
                        <td width="100%" class="noline"><input name="uspgcr_total" type="text" class="w25" id="uspgcr_total" value="<?php echo countGCRPLCLimit($row_user['user_stafid'], date('Y'));?>" />
                          <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" />
<input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" /><input name="batal" type="button" class="cancelbutton" id="batal" value="Batal" onClick="toggleview2('formgcr'); return false;" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="formgcr2" />
                  </form>
                </li>
                </div>
                <?php }; ?>
            <li>
    <div class="note">Jumlah terkumpul tidak boleh melebihi <strong><?php echo getGCRLimit();?> hari</strong> sepanjang tempoh berkhidmat</div>
    <div class="off">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <?php if ($totalRows_gcr > 0) { // Show if recordset not empty ?>
    <tr>
      <th width="100%" align="left" nowrap="nowrap">Tahun</th>
      <th width="25%" align="center" nowrap="nowrap">Hari  Terkumpul</th>
    </tr>
    <?php do { ?>
      <tr class="on">
        <td nowrap="nowrap"><?php echo $row_gcr['uspgcr_date_y']; ?></td>
        <td align="center" nowrap="nowrap" class="back_lightgrey"><?php echo $row_gcr['uspgcr_total']; ?> <?php if($row_gcr['uspgcr_date_y']==date('Y')) echo "**"; ?></td>
      </tr>
      <?php } while ($row_gcr = mysql_fetch_assoc($gcr)); ?>
    <tr>
      <td align="right" nowrap="nowrap" class="noline"><strong>Jumlah terkumpul</strong></td>
      <td align="center" nowrap="nowrap" class="back_lightgrey"><strong><?php echo countTotalGCR($row_user['user_stafid']); ?></strong></td>
    </tr>
    <tr>
      <td colspan="2" align="center" class="noline txt_color1"><?php echo $totalRows_gcr ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="2" align="center" class="noline">Tiada rekod dijumpai</td>
    </tr>
    <?php }; ?>
  </table>
  </div>
                  <div class="inputlabel2">* Cuti Rehat / Tahunan bagi tahun semasa (<?php echo date('Y');?>) ditambah.<br/>
                  ** Cuti Rehat / Tahunan bagi tahun semasa (<?php echo date('Y');?>) ditolak.</div>
                </li>
                <li class="gap">&nbsp;</li>
            <?php } else { //semakkan user akses?>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
                  </tr>
                </table>
				</li>
            <?php };?>
            </ul>
          </div>
        </div>
        <?php echo noteHR('2');?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($plc);

mysql_free_result($gcr);
?>
<?php include('../inc/footinc.php');?> 