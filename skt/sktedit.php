<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='58';?>
<?php
$colname_uskt = "-1";

if (isset($_GET['id'])) {
  $colname_uskt = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
}

mysql_select_db($database_skt, $skt);
$query_uskt = sprintf("SELECT * FROM user_skt WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND uskt_id = %s ORDER BY uskt_id DESC", GetSQLValueString($colname_uskt, "int"));
$uskt = mysql_query($query_uskt, $skt) or die(mysql_error());
$row_uskt = mysql_fetch_assoc($uskt);
$totalRows_uskt = mysql_num_rows($uskt);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
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
            <div class="note">Kemaskini maklumat Aktiviti dalam Sasaran Kerja Tahunan (SKT)</div>
            <form id="form1" name="form1" method="POST" action="../sb/update_uskt.php">
          <ul>
          <?php if(getSKTTahun($row_uskt['uskt_id'])==date('Y') && !checkFeedbackCancel($row_uskt['uskt_id']) && getFeedbackLatest($row_user['user_stafid'], $row_uskt['uskt_id'], 0)==0){?>
                <li class="title">Aktiviti / Projek / Keterangan *</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">
                      <span id="akt">
                      <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                        <textarea name="uskt_aktiviti" id="uskt_aktiviti" cols="45" rows="5"><?php echo $row_uskt['uskt_aktiviti']; ?></textarea>
                      </span></td>
                    </tr>
                  </table>
              </li>
                <li class="title">Petunjuk Prestasi</li>       
                <li>           
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th nowrap="nowrap">&nbsp;</th>
                      <th width="50%" nowrap="nowrap">Penerangan</th>
                      <th width="50%" nowrap="nowrap">Sasaran Kerja</th>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Kuantiti</td>
                      <td><textarea name="uskt_kuantiti" id="uskt_kuantiti" cols="45" rows="5"><?php echo $row_uskt['uskt_kuantiti']; ?></textarea></td>
                      <td><textarea name="uskt_kuantiti_sk" id="uskt_kuantiti_sk" cols="45" rows="5"><?php echo $row_uskt['uskt_kuantiti_sk']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Masa</td>
                      <td><textarea name="uskt_masa" id="uskt_masa" cols="45" rows="5"><?php echo $row_uskt['uskt_masa']; ?></textarea></td>
                      <td><textarea name="uskt_masa_sk" id="uskt_masa_sk" cols="45" rows="5"><?php echo $row_uskt['uskt_masa_sk']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Tempoh</td>
                      <td>&nbsp;</td>
                      <td>
                        <select name="uskt_masa_mula" id="uskt_masa_mula">
                        <?php for($i=1; $i<=12; $i++){?>
                          <option <?php if($i==$row_uskt['uskt_masa_mula']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo date('M Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>
                        <?php }; ?>
                      	</select> 
                        <div class="inputlabel"> hingga </div>
                        <select name="uskt_masa_tamat" id="uskt_masa_tamat">
                        <?php for($j=1; $j<=12; $j++){?>
                          <option <?php if($j==$row_uskt['uskt_masa_tamat']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M Y', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                        <?php }; ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Kualiti</td>
                      <td><textarea name="uskt_kualiti" id="uskt_kualiti" cols="45" rows="5"><?php echo $row_uskt['uskt_kualiti']; ?></textarea></td>
                      <td><textarea name="uskt_kualiti_sk" id="uskt_kualiti_sk" cols="45" rows="5"><?php echo $row_uskt['uskt_kualiti_sk']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Kos</td>
                      <td><textarea name="uskt_kos" id="uskt_kos" cols="45" rows="5"><?php echo $row_uskt['uskt_kos']; ?></textarea></td>
                      <td><textarea name="uskt_kos_sk" id="uskt_kos_sk" cols="45" rows="5"><?php echo $row_uskt['uskt_kos_sk']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Lain - lain</td>
                      <td><textarea name="uskt_lain" id="uskt_lain" cols="45" rows="5"><?php echo $row_uskt['uskt_lain']; ?></textarea></td>
                      <td><textarea name="uskt_lain_sk" id="uskt_lain_sk" cols="45" rows="5"><?php echo $row_uskt['uskt_lain_sk']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label"><input name="uskt_id" type="hidden" id="uskt_id" value="<?php echo $row_uskt['uskt_id']; ?>" />                        <input type="hidden" name="MM_insert" value="form1" /></td>
                      <td colspan="2">
                      <input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                      <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','index.php');return document.MM_returnValue" />
                      </td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_update" value="form1" />
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
            </ul>
            </form>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("akt");
</script>
</body>
</html>
<?php
mysql_free_result($uskt);
?>
<?php include('../inc/footinc.php');?> 