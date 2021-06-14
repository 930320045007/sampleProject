<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php $menu='12';?>
<?php $menu2='45';?>
<?php 
if(isset($_GET['id']))
{
	$urid = $_GET['id'];
} else {
	$urid = 0;
}
?>
<?php
mysql_select_db($database_hartadb, $hartadb);
$query_urf = "SELECT * FROM harta.user_reportfeedback WHERE userreport_id = '" . $urid . "' AND urf_status = 1 ORDER BY urf_id ASC";
$urf = mysql_query($query_urf, $hartadb) or die(mysql_error());
$row_urf = mysql_fetch_assoc($urf);
$totalRows_urf = mysql_num_rows($urf);

mysql_select_db($database_hartadb, $hartadb);
$query_fbt = "SELECT * FROM harta.feedback_type WHERE feedbacktype_status = 1 ORDER BY feedbacktype_name ASC";
$fbt = mysql_query($query_fbt, $hartadb) or die(mysql_error());
$row_fbt = mysql_fetch_assoc($fbt);
$totalRows_fbt = mysql_num_rows($fbt);

mysql_select_db($database_hartadb, $hartadb);
$query_ui = "SELECT * FROM user_item WHERE userreport_id = '" . $urid . "' AND useritem_status = 1 ORDER BY useritem_id ASC";
$ui = mysql_query($query_ui, $hartadb) or die(mysql_error());
$row_ui = mysql_fetch_assoc($ui);
$totalRows_ui = mysql_num_rows($ui);

mysql_select_db($database_hartadb, $hartadb);
$query_itemlist = "SELECT * FROM item WHERE category_id = '" . getCategoryIDByRCID(getReportCaseByURID($urid)) . "' AND item_status = 1 ORDER BY item_name ASC";
$itemlist = mysql_query($query_itemlist, $hartadb) or die(mysql_error());
$row_itemlist = mysql_fetch_assoc($itemlist);
$totalRows_itemlist = mysql_num_rows($itemlist);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<?php include('../inc/liload.php');?>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
                <div class="note">Maklumat lengkap berkaitan aduan</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Tarikh</td>
                      <td width="100%" colspan="2"><?php echo getReportDate($urid);?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">No. Tiket</td>
                      <td colspan="2"><?php echo getReportTicketByID($urid); ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Perkara</td>
                      <td colspan="2" ><?php echo getCategoryNameByRCID(getReportCaseByURID($urid)); ?> &nbsp; &bull; &nbsp; <?php echo getSubCategoryNameByRCID(getReportCaseByURID($urid)); ?> &nbsp; &bull; &nbsp; <?php echo getRCTitleByID(getReportCaseByURID($urid));?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Lokasi</td>
                      <td colspan="2" ><?php echo getReportLocationByID($urid);?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label noline">Oleh</td>
                      <td align="center" valign="top" class="txt_line noline"><?php echo viewProfilePic(getReportByByID($urid));?></td>
                      <td width="100%" class="txt_line noline"><strong><?php echo getFullNameByStafID(getReportByByID($urid)) . " (" . getReportByByID($urid) . ")";?></strong> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID(getReportByByID($urid));?><br/><?php echo getFulldirectoryByUserID(getReportByByID($urid));?></td>
                    </tr>
                  </table>
              </li>
              <li class="gap">&nbsp;</li>
              <li class="title">Item dibekalkan <?php if(!checkFeedbackEnd($urid) && $totalRows_itemlist > 0){?><span class="fr add" onClick="toggleview2('formitem'); return false;">Tambah</span><?php }; ?></li>
              <?php if($totalRows_itemlist > 0){?>
              <div id="formitem" class="hidden">
              <li>
                <form id="form1" name="form1" method="post" action="../sb/add_harta_userreport_item.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label noline">Item
                      <input name="MM_insert" type="hidden" id="MM_insert" value="form2" /></td>
                      <td width="100%" class="noline">
                      <input name="userreport_id" type="hidden" id="userreport_id" value="<?php echo $urid;?>" />
                        <select name="item_id" id="item_id">
                        <?php
						do {  
						?>
                        <?php if(getItemBalByItemID($row_itemlist['item_id'])>0){?>
                        <option value="<?php echo $row_itemlist['item_id']?>"><?php echo $row_itemlist['item_name']?></option>
                        <?php }; ?>
                        <?php
						  } while ($row_itemlist = mysql_fetch_assoc($itemlist));
							$rows = mysql_num_rows($itemlist);
							if($rows > 0) {
								mysql_data_seek($itemlist, 0);
								$row_itemlist = mysql_fetch_assoc($itemlist);
							}
						  ?>
                      </select>
                        <span id="kuantiti"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="textfieldInvalidFormatMsg">Masukkan nombor sahaja.</span>
                        <input name="useritem_kuantiti" type="text" class="w25" id="useritem_kuantiti" value="1" />
                        </span>                        
                      <input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" /></td>
                    </tr>
                  </table>
                </form>
              </li>
              </div>
              <?php }; ?>
              <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_ui > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Item</th>
                      <th align="center" valign="middle" nowrap="nowrap">Kuantiti</th>
                      <th align="center" valign="middle" nowrap="nowrap">Unit</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle"><?php echo getItemName($row_ui['item_id']); ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_ui['useritem_kuantiti']; ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getUnitName(getUnitByItemID($row_ui['item_id']));?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><ul class="func"><?php if(!checkFeedbackEnd($urid)){?><li><a onclick="return confirm('Anda mahu item berikut dipadam? \r\n\n <?php echo getItemName($row_ui['item_id']); ?> ( <?php echo $row_ui['useritem_kuantiti']; ?> <?php echo getUnitName(getUnitByItemID($row_ui['item_id']));?> )')" href="../sb/del_harta_userreport_item.php?id=<?php echo $row_ui['useritem_id'];?>&urid=<?php echo $urid;?>">X</a></li><?php }; ?></ul></td>
                      </tr>
                      <?php $i++; } while ($row_ui = mysql_fetch_assoc($ui)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_ui ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
              </li>
                <li class="title">Maklum Balas <?php if(!checkFeedbackEnd($urid)){?><span class="fr add" onClick="toggleview2('formfeedback'); return false;">Tambah</span><?php }; ?></li>
                <?php if(!checkFeedbackEnd($urid)){?>
                <div id="formfeedback" class="hidden">
                <li>
                  <form id="forminfeedback" name="forminfeedback" method="post" action="../sb/add_harta_userreportfeedback.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tindakan</td>
                        <td width="100%">
                          <select name="feedbacktype_id" id="feedbacktype_id" onChange="dochange('14', 'urf_stafid', this.value, '0');">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_fbt['feedbacktype_id']?>"><?php echo $row_fbt['feedbacktype_name']?></option>
                            <?php
							} while ($row_fbt = mysql_fetch_assoc($fbt));
							?>
                            <option value="0">Tamat</option>
                          </select>
                          <select name="urf_stafid" id="urf_stafid">
                            <option value="0">Tiada</option>
                        </select></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td>
               		    <span id="note">
                            <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                          	<textarea name="urf_note" id="urf_note" cols="45" rows="5"></textarea>
                          	</span>
                       	  <div class="txt_color1 txt_line">Oleh : <strong><?php echo getFullNameByStafID($row_user['user_stafid']) . " (" . $row_user['user_stafid'] . ")";?></strong></div>
                        	<input name="MM_insert" type="hidden" value="reportfeedback" />
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline"><input name="userreport_id" type="hidden" id="userreport_id" value="<?php echo $urid; ?>" /></td>
                        <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <?php if ($totalRows_urf > 0) { // Show if recordset not empty ?>
				  <?php do { ?>
                    <li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic(getFeedbackByByURFID($row_urf['urf_id']));?></td>
                          <td width="100%" class="noline">
                          <strong><?php echo getFeedbackTypeName($row_urf['feedbacktype_id']);?></strong>
						  <?php if(checkFeedbackActionByURFID($row_urf['urf_id'])) echo "<span class=\"txt_color1\"> &nbsp; &bull; &nbsp; " . getFullNameByStafID(getFeedbackActionStafIDByURFID($row_urf['urf_id'])) . " (" . getFeedbackActionStafIDByURFID($row_urf['urf_id']) . ")</span>";?>
                          </td>
                        </tr>
                        <tr>
                          <td class="noline"><?php echo getFeedbackNoteByURFID($row_urf['urf_id']);?></td>
                        </tr>
                      </table>
              </li>
                    <li class="form_back2 line_b3">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="noline">Oleh : <strong><?php echo getFullNameByStafID(getFeedbackByByURFID($row_urf['urf_id'])) . " (" . getFeedbackByByURFID($row_urf['urf_id']) . ")";?></strong> &nbsp; &bull; &nbsp; <?php echo getFeedbackDateByURFID($row_urf['urf_id']);?></td>
                        </tr>
                      </table>
                    </li>
                    <?php } while ($row_urf = mysql_fetch_assoc($urf)); ?>
                    <li class="hidden">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_urf ?> rekod dijumpai</td>
                      </tr>
                    </table>
                    </li>
                  <?php } else { ?>
                  <li>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                      </tr>
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
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("note");
var sprytextfield1 = new Spry.Widget.ValidationTextField("kuantiti", "integer", {hint:"kuantiti"});
</script>
</body>
</html>
<?php
mysql_free_result($urf);

mysql_free_result($fbt);

mysql_free_result($ui);

mysql_free_result($itemlist);
?>
<?php include('../inc/footinc.php');?> 