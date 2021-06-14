<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/selidikdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/admin_sta.php');?>
<?php include('../inc/selidikfunc.php');?>
<?php $menu='13';?>
<?php $menu2='49';?>
<?php
if(isset($_GET['id']))
	$id = htmlspecialchars($_GET['id'], ENT_QUOTES);
else
	$id = '-1';
	
mysql_select_db($database_selidikdb, $selidikdb);
$query_sur = "SELECT * FROM selidik.surveydetail WHERE sd_status = 1 AND sd_id = " . $id . " ORDER BY sd_id DESC";
$sur = mysql_query($query_sur, $selidikdb) or die(mysql_error());
$row_sur = mysql_fetch_assoc($sur);
$totalRows_sur = mysql_num_rows($sur);

mysql_select_db($database_selidikdb, $selidikdb);
$query_bhg = "SELECT * FROM selidik.questiongroup WHERE sd_id = " . $id . " ORDER BY qg_sort ASC";
$bhg = mysql_query($query_bhg, $selidikdb) or die(mysql_error());
$row_bhg = mysql_fetch_assoc($bhg);
$totalRows_bhg = mysql_num_rows($bhg);

if(countAnswerBySDID($id)==0)
	$ua = true;
else
	$ua = false;
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li>
                <div class="note">Maklumat lanjut berkaitan soal selidik</div>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                  <tr>
                    <td align="center" valign="middle" class="icon_pad1"><img src="../icon/user.png" width="39" height="48" alt="User" /></td>
                    <td class="line_r">
                    <div>Responden</div>
                    <div class="txt_size1"><?php echo countAnswerBySDID($id);?></div>
                    <div class="txt_size2"><?php echo percentUserAnswer($id);?>%</div>
                    </td>
                    <td align="center" valign="middle" class="icon_pad1"><img src="../icon/calculator.png" width="33" height="48" alt="Purata" /></td>
                    <td>
                    <div>Purata Keseluruhan</div>
                    <div class="txt_size1"><?php echo totalAverage($id);?></div>
                    </td>
                  </tr>
                </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="label">Tajuk</td>
                  <td colspan="3"><?php echo $row_sur['sd_title']; ?></td>
                </tr>
                <tr>
                  <td class="label">Maklumat Lengkap</td>
                  <td colspan="3"><?php echo $row_sur['sd_desc']; ?></td>
                </tr>
                <tr>
                  <td class="label">Tarikh Mula</td>
                  <td class="w35"><?php echo getSurveyDateStart($row_sur['sd_id']);?></td>
                  <td class="label">Tarikh tamat</td>
                  <td class="w35"><?php echo getSurveyDateEnd($row_sur['sd_id']);?></td>
                </tr>
                <tr>
                  <td class="label">Kumpulan Sasaran</td>
                  <td><?php if($row_sur['group_id']!=0) echo getGroup($row_sur['group_id']); else echo "Semua";?></td>
                  <td class="label">Pengkhususan</td>
                  <td><?php if($row_sur['division_id']!=0)echo getDirSubName($row_sur['division_id']); else echo "Semua";?></td>
                </tr>
                </table>
                </li>
				<?php if ($totalRows_bhg > 0) { // Show if recordset not empty ?>
				<?php $pkt=0; do { ?>
                <li class="title"><?php echo $row_bhg['qg_title']; ?> <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $ua){?><span class="fr add" onclick="toggleview2('formsoalan<?php echo $row_bhg['qg_id']; ?>'); return false;">Tambah</span><?php }; ?> <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?><span class="fr add" onclick="toggleview2('formbahagian<?php echo $row_bhg['qg_id']; ?>'); return false;">Edit</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                <div id="formbahagian<?php echo $row_bhg['qg_id']; ?>" class="hidden">
                <li>
                      <form id="form1" name="form1" method="post" action="../sb/add_surveydetail_bahagian.php">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td nowrap="nowrap" class="label">Bahagian</td>
                            <td width="100%"><input name="qg_title" type="text" class="w70" id="qg_title" value="<?php echo $row_bhg['qg_title']; ?>" /></td>
                          </tr>
                          <tr>
                            <td nowrap="nowrap" class="label">Ringkasan</td>
                            <td><textarea name="qg_desc" rows="5" class="w70" id="qg_desc"><?php echo $row_bhg['qg_desc']; ?></textarea></td>
                          </tr>
                          <tr>
                            <td class="label noline">
                            <input name="MM_update" type="hidden" value="form1" />
                            <input name="qg_id" type="hidden" value="<?php echo $row_bhg['qg_id']; ?>" />
                            <input name="sd_id" type="hidden" id="sd_id" value="<?php echo $row_bhg['sd_id']; ?>" />
                            </td>
                            <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" /></td>
                          </tr>
                        </table>
            			</form>
                </li>
                </div>
                <?php }; ?>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $ua){?>
                <div id="formsoalan<?php echo $row_bhg['qg_id']; ?>" class="hidden">
                <li>
                  <form id="form2" name="form2" method="post" action="../sb/add_surveydetail_soalan.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label noline">Soalan</td>
                        <td width="100%" class="noline"><input name="MM_insert" type="hidden" id="MM_insert" value="form1" />
                          <input name="sd_id" type="hidden" id="sd_id" value="<?php echo $row_sur['sd_id']; ?>" />
                          <input name="qg_id" type="hidden" id="qg_id" value="<?php echo $row_bhg['qg_id']; ?>" />
                          <input name="q_title" type="text" class="w70" id="q_title" />
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <div id="desc" class="padb">
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline"><?php echo $row_bhg['qg_desc']; ?></td>
                    </tr>
                  </table>
                </li>
                </div>
				<?php
					mysql_select_db($database_selidikdb, $selidikdb);
					$query_soalan = "SELECT * FROM selidik.question WHERE sd_id = " . $id . " AND qg_id = " . $row_bhg['qg_id'] . " ORDER BY q_id ASC";
					$soalan = mysql_query($query_soalan, $selidikdb) or die(mysql_error());
					$row_soalan = mysql_fetch_assoc($soalan);
					$totalRows_soalan = mysql_num_rows($soalan);
				?>
                <?php if ($totalRows_soalan > 0) { // Show if recordset not empty ?>
                <li>
                <div class="padb">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th nowrap="nowrap">&nbsp;</th>
                        <th width="100%">&nbsp;</th>
                        <th nowrap="nowrap">
                    	<ul class="inputradiolabel">
                              <li>1</li>
                              <li>2</li>
                              <li>3</li>
                              <li>4</li>
                              <li>5</li>
                          </ul>
                        </th>
                        <th align="center" valign="middle" nowrap="nowrap">Purata</th>
                        <th nowrap="nowrap">&nbsp;</th>
                      </tr>
                    <?php $i=1; $pk=0; do {?>
                      <tr class="on">
                        <td nowrap="nowrap"><?php echo $i;?>.</td>
                        <td width="100%"><?php echo $row_soalan['q_title']; ?></td>
                        <td nowrap="nowrap">
                          <ul class="inputradiolabel">
                              <li <?php echo color(percentAnswer($row_soalan['q_id'], '1'));?>><?php echo percentAnswer($row_soalan['q_id'], '1'); //echo " (" . countAnswer($row_soalan['q_id'], '1') . ")";?></li>
                              <li <?php echo color(percentAnswer($row_soalan['q_id'], '2'));?>><?php echo percentAnswer($row_soalan['q_id'], '2'); //echo " (" . countAnswer($row_soalan['q_id'], '2') . ")";?></li>
                              <li <?php echo color(percentAnswer($row_soalan['q_id'], '3'));?>><?php echo percentAnswer($row_soalan['q_id'], '3'); //echo " (" . countAnswer($row_soalan['q_id'], '3') . ")";?></li>
                              <li <?php echo color(percentAnswer($row_soalan['q_id'], '4'));?>><?php echo percentAnswer($row_soalan['q_id'], '4'); //echo " (" . countAnswer($row_soalan['q_id'], '4') . ")";?></li>
                              <li <?php echo color(percentAnswer($row_soalan['q_id'], '5'));?>><?php echo percentAnswer($row_soalan['q_id'], '5'); //echo " (" . countAnswer($row_soalan['q_id'], '5') . ")";?></li>
                          </ul>
                        </td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php $pk += averageAnswer($row_soalan['q_id']); echo averageAnswer($row_soalan['q_id']);?></td>
                        <td nowrap="nowrap">
                        <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4) && $ua){?><ul class="func"><li>X</li></ul><?php }; ?></td>
                      </tr>
                      <?php $i++; } while ($row_soalan = mysql_fetch_assoc($soalan)); 
						mysql_free_result($soalan); ?>
                      <tr>
                        <td nowrap="nowrap" class="back_lightgrey">&nbsp;</td>
                        <td width="100%" class="back_lightgrey"><strong>Purata Bahagian</strong></td>
                        <td nowrap="nowrap" class="back_lightgrey">&nbsp;</td>
                        <td align="center" valign="middle" nowrap="nowrap" class="back_lightgrey"><strong><?php $pkv = round($pk/$totalRows_soalan, 2); echo $pkv;?></strong></td>
                        <td nowrap="nowrap" class="back_lightgrey">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_soalan ?> rekod dijumpai</td>
                    </tr>
                  </table>
                </div>
                </li>
                <?php }; // Show if recordset not empty ?>
                <?php } while ($row_bhg = mysql_fetch_assoc($bhg));?>
                <?php } else { ?>
                <li class="title">Bahagian</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Untuk mengisi soalan dalam soal selidik. Sila tambah bahagian menggunakan ruangan dibawah.</td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $ua){?>
                <li class="form_back2 line_t">
                <div class="note">Penambahan bahagian pada soal selidik</div>
                      <form id="form1" name="form1" method="post" action="../sb/add_surveydetail_bahagian.php">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td nowrap="nowrap" class="label">Bahagian</td>
                            <td width="100%"><input name="qg_title" type="text" class="w70" id="qg_title" /></td>
                          </tr>
                          <tr>
                            <td nowrap="nowrap" class="label">Ringkasan</td>
                            <td><textarea name="qg_desc" rows="5" class="w70" id="qg_desc"></textarea></td>
                          </tr>
                          <tr>
                            <td class="label noline">
                            <input name="MM_insert" type="hidden" value="form1" />
                            <input name="sd_id" type="hidden" id="sd_id" value="<?php echo $row_sur['sd_id']; ?>" />
                            </td>
                            <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" /></td>
                          </tr>
                        </table>
            			</form>
                    </li>
                <?php } ; ?>
            <?php }; ?>
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
mysql_free_result($sur);

mysql_free_result($bhg);
?>
<?php include('../inc/footinc.php');?> 