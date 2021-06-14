<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='8';?>
<?php $menu2='29';?>
<?php
if(isset($_GET['id']) && $_GET['id']!=NULL)
	$id = getID(htmlspecialchars($_GET['id'], ENT_QUOTES), 0);
else
	$id = "-1";
	
mysql_select_db($database_ictdb, $ictdb);
$query_userborrow = "SELECT * FROM ict.user_borrow WHERE userborrow_id = '" . $id . "' AND user_stafid = '" . $row_user['user_stafid'] . "' AND userborrow_status = 1";
$userborrow = mysql_query($query_userborrow, $ictdb) or die(mysql_error());
$row_userborrow = mysql_fetch_assoc($userborrow);
$totalRows_userborrow = mysql_num_rows($userborrow);

mysql_select_db($database_ictdb, $ictdb);
$query_itemborrow = "SELECT * FROM ict.item_borrow WHERE itemborrow_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' AND userborrow_id = '" . $row_userborrow['userborrow_id'] . "' ORDER BY itemborrow_id ASC";
$itemborrow = mysql_query($query_itemborrow, $ictdb) or die(mysql_error());
$row_itemborrow = mysql_fetch_assoc($itemborrow);
$totalRows_itemborrow = mysql_num_rows($itemborrow);
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
        
        <?php include('../inc/menu_ict_user.php');?>
        <div class="tabbox">
          <div class="profilemenu">
           <div class="note">Maklumat pinjaman peralatan Unit ICT</div>
                <ul>
                <?php if($row_userborrow['user_stafid']==$row_user['user_stafid']){?>
                	<li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="label">Tujuan</td>
                          <td colspan="3"><strong><?php echo $row_userborrow['userborrow_title']; ?></strong></td>
                        </tr>
                        <tr>
                          <td class="label">Lokasi</td>
                          <td colspan="3"><?php echo $row_userborrow['userborrow_location']; ?></td>
                        </tr>
                        <tr>
                          <td class="label">Tarikh</td>
                          <td class="w30"><?php echo getDateBorrowByUserBorrowID($row_userborrow['userborrow_id']);?></td>
                          <td class="label">Masa</td>
                          <td class="w30"><?php echo getTimeBorrowByUserBorrowID($row_userborrow['userborrow_id']);?></td>
                        </tr>
                        <tr>
                          <td class="label">Tempoh</td>
                          <td colspan="3"><?php echo getDurationByUserBorrowID($row_userborrow['userborrow_id']);?></td>
                        </tr>
                        <?php if($row_userborrow['userborrow_note']!=NULL){?>
                        <tr>
                          <td class="label noline">Catatan</td>
                          <td colspan="3" class="noline"><?php echo $row_userborrow['userborrow_note']; ?></td>
                        </tr>
                        <?php }; ?>
                      </table>
                    </li>
                    <li class="gap">&nbsp;</li>
                	<li class="title">Maklumat Item</li>
                    <li class="gap">&nbsp;</li>
                    <li>
  					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php if ($totalRows_itemborrow > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th nowrap="nowrap">Bil</th>
                          <th align="left" nowrap="nowrap">Item</th>
                          <th width="50%" align="left" valign="middle" nowrap="nowrap">No. Siri MSN / Jenama / Model</th>
                          <th width="50%" align="left" valign="middle" nowrap="nowrap">Catatan</th>
                        </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td><?php echo $i;?></td>
                            <td align="left" nowrap="nowrap"><?php echo getItemCategoryBySubCatID($row_itemborrow['subcategory_id']) . " &nbsp; &bull; &nbsp; " . getItemSubCategoryByID($row_itemborrow['subcategory_id']); ?></td>
                            <td>
							<?php if($row_userborrow['ict_item']!=0 && $row_itemborrow['item_id']!=0){?>
							<?php echo getItemISNSiriByID($row_itemborrow['item_id']) . " &nbsp; &bull; &nbsp; " . getItemBrandNameByItemID($row_itemborrow['item_id']) . " " . getModelByItemID($row_itemborrow['item_id']); ?>
							<?php }; ?></td>
                            <td>
							<?php if($row_userborrow['ict_item']!=0 && $row_itemborrow['itemborrow_note']!=NULL){?>
							<?php echo $row_itemborrow['itemborrow_note']; ?>
                            <?php }; ?>
                            </td>
                          </tr>
                          <?php $i++; } while ($row_itemborrow = mysql_fetch_assoc($itemborrow)); ?>
                        <tr>
                          <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_itemborrow ?> rekod dijumpai</td>
                        </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
                    </li>
                    <li class="gap">&nbsp;</li>
                    <?php if($row_userborrow['ict_status']==0){?>
                    <li class="form_back2 line_t">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td colspan="2" class="noline"><img src="../icon/lock.png" alt="Pending" width="16" height="16" border="0" align="absbottom"> &nbsp; Permohonan pinjaman peralatan Unit ICT masih dalam proses pengesahan.</td>
                        </tr>
                      </table>
                    </li>
                    <?php } else if($row_userborrow['ict_status']==1){?>
                    <li class="form_back2 line_t">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td>Pengesahan tempahan berdasarkan maklumat yang dinyatakan seperti diatas <strong>DILULUSKAN</strong> pada <strong><?php echo $row_userborrow['ict_date']; ?></strong></td>
                        </tr>
                        <tr>
                          <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><?php echo viewProfilePic($row_userborrow['ict_by']);?></td>
                              <td width="100%" class="txt_line">
                              <div class="txt_size2">Diluluskan oleh</div>
                              <div><strong><?php echo getFullNameByStafID($row_userborrow['ict_by']) . " (" . $row_userborrow['ict_by'] . ")"; ?></strong></div>
                              <div><?php echo getFulldirectoryByUserID($row_userborrow['ict_by']);?></div></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table>
                      <?php if($row_userborrow['ict_note']!=NULL){?>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="label">Catatan</td>
                          <td width="100%"><?php echo $row_userborrow['ict_note']; ?></td>
                        </tr>
                      </table>
                      <?php }; ?>
                    </li>
                    <?php } else if($row_userborrow['ict_status']==2){ ?>
                    <li class="form_back2">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td>Pengesahan tempahan berdasarkan maklumat yang dinyatakan seperti diatas <strong>TIDAK DILULUSKAN</strong> pada <strong><?php echo $row_userborrow['ict_date']; ?></strong></td>
                        </tr>
                        <tr>
                          <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><?php echo viewProfilePic($row_userborrow['ict_by']);?></td>
                              <td width="100%" class="txt_line"><div class="txt_size2">Tidak diluluskan oleh</div>
                                <div><strong><?php echo getFullNameByStafID($row_userborrow['ict_by']) . " (" . $row_userborrow['ict_by'] . ")"; ?></strong></div>
                                <div><?php echo getFulldirectoryByUserID($row_userborrow['ict_by']);?></div></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table>
                      <?php if($row_userborrow['ict_note']!=NULL){?>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="label">Catatan</td>
                          <td width="100%"><?php echo $row_userborrow['ict_note']; ?></td>
                        </tr>
                      </table>
                      <?php }; ?>
                    </li>
                    <?php }; ?>
                    <?php if($row_userborrow['ict_return']==0 && $row_userborrow['ict_status']==1){?>
                    <li class="form_back2 line_t">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        	<td class="noline"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /></td>
                          <td class="noline">Sila buat pengesahan penyerahan balik item dan kuantiti seperti yang tertera diatas setelah selesai. Sekiranya tidak dipulangkan dari tempoh yg ditetapkan (1 hari selepas daripada tempoh pinjaman), pemohon tidak dibenarkan untuk membuat pinjaman baru.</td>
                        </tr>
                      </table>
                    </li>
                    <?php } else if($row_userborrow['ict_return']==1 && $row_userborrow['ict_status']==1){?>
                    <li class="form_back2 line_t">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td colspan="2" class="noline">Pengesahan penyerahan balik item pada <strong><?php echo $row_userborrow['ict_returndate']; ?></strong> dengan jumlah kuantiti yang dinyatakan diatas dalam keadaan baik sebagaimana sewaktu penyerahan.</td>
                        </tr>
                        <tr>
                          <td width="50%" valign="top" class="noline">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="center" valign="top"><?php echo viewProfilePic($row_userborrow['ict_returnuser']);?></td>
                                <td width="100%" class="txt_line">
                                <div class="txt_size2">Penyerahan oleh</div>
                                <div><strong><?php echo getFullNameByStafID($row_userborrow['ict_returnuser']) . " (" . $row_userborrow['ict_returnuser'] . ")"; ?></strong></div>
                                <div><?php echo getFulldirectoryByUserID($row_userborrow['ict_returnuser']);?></div>
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td width="50%" valign="top" class="noline"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td align="center" valign="top"><?php echo viewProfilePic($row_userborrow['ict_returnby']);?></td>
                              <td width="100%"><div class="txt_size2">Diterima oleh</div>
                                <div><strong><?php echo getFullNameByStafID($row_userborrow['ict_returnby']) . " (" . $row_userborrow['ict_returnby'] . ")"; ?></strong></div>
                                <div><?php echo getFulldirectoryByUserID($row_userborrow['ict_returnby']);?></div></td>
                            </tr>
                          </table></td>
                        </tr>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <?php if($row_userborrow['ict_returnnote']!=NULL){?>
                        <tr>
                          <td nowrap="nowrap" class="label">Catatan</td>
                          <td width="100%" class="noline"><?php echo $row_userborrow['ict_returnnote']; ?></td>
                        </tr>
                        <?php }; ?>
                      </table>
                    </li>
                    <?php }; ?>
                    <?php } else { ?>
                    <li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                      </table>
                    </li>
                    <?php }; ?>
                </ul>
           </div>
          </div>
        </div>
  </div>
        
		<?php include('../inc/footer.php');?>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($userborrow);

mysql_free_result($itemborrow);
?>
<?php include('../inc/footinc.php');?> 