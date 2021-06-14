<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='86';?>
<?php
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_ag = "SELECT * FROM transport_agency WHERE transagency_status = 1 ORDER BY transagency_name ASC";
$ag = mysql_query($query_ag, $tadbirdb) or die(mysql_error());
$row_ag = mysql_fetch_assoc($ag);
$totalRows_ag = mysql_num_rows($ag);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <li><div class="note">Senarai Agensi</div></li>
                <li class="title">Agensi <span class="fr add" onclick="toggleview2('formagensi'); return false;">Tambah</span></li>
                <div id="formagensi" class="hidden">
                <li>
                  <form id="form1" name="form1" method="POST" action="../sb/add_agency.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Nama Agensi</td>
                        <td colspan="3">
                        <span id="nama">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input type="text" name="transagency_name" id="transagency_name" />
                        </span></td>
                      </tr>
                      <tr>
                        <td class="label">Alamat</td>
                        <td colspan="3">
                        <textarea name="transagency_address" id="transagency_address" cols="45" rows="5"></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">No. Tel</td>
                        <td>
                        <span id="tel">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                        <input type="text" name="transagency_notel" id="transagency_notel" />
                        </span>
                        </td>
                        <td class="label">No. Fax</td>
                        <td>
                        <input type="text" name="transagency_nofax" id="transagency_nofax" />
                        </td>
                      </tr>
                      <tr>
                        <td class="label">Email</td>
                        <td>
                        <span id="agensiemail">
                        <span class="textfieldInvalidFormatMsg">Tidak mengikut format email.</span>
                        <input type="text" name="transagency_email" id="transagency_email" />
                        </span>
                        </td>
                        <td class="label">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="noline">&nbsp;</td>
                        <td colspan="3" class="noline">
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="toggleview2('formagensi'); return false;"/>
                        </td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="form1" />
                  </form>
                </li>
                </div>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_ag > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle"><a href="agencyview.php?id=<?php echo $row_ag['transagency_id']; ?>"><?php echo $row_ag['transagency_name']; ?></a><?php if($row_ag['transagency_notel']!=NULL) echo " &nbsp; &bull; &nbsp; Tel : " . $row_ag['transagency_notel']; ?><?php if($row_ag['transagency_nofax']!=NULL) echo " &nbsp; &bull; &nbsp; Fax : " . $row_ag['transagency_nofax']; ?>
                        </td>
                        <td><ul class="func"><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>
                      <li><a onclick="return confirm('Anda mahu maklumat agensi berikut dipadam? \r\n\n <?php echo $row_ag['transagency_name']; ?>')" href="../sb/del_agency.php?id=<?php echo $row_ag['transagency_id'];?>">X</a></li>
                      <?php }; ?></ul></td>
                      </tr>
                      <?php $i++; } while ($row_ag = mysql_fetch_assoc($ag)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_ag ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
            <?php } ; ?>
            </ul>
            </div>
        </div>
        </div>
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("nama");
var sprytextfield2 = new Spry.Widget.ValidationTextField("tel");
var sprytextfield3 = new Spry.Widget.ValidationTextField("agensiemail", "email", {isRequired:false});
</script>
</body>
</html>
<?php
mysql_free_result($ag);
?>
<?php include('../inc/footinc.php');?> 