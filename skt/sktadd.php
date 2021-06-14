<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='58';?>
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
            <div class="note">Penambahan Aktiviti dalam Sasaran Kerja Tahunan (SKT) bagi tahun <strong><?php echo date('Y');?></strong></div>
            <form id="form1" name="form1" method="POST" action="../sb/add_uskt.php">
            <ul>
            	<li class="title">Aktiviti / Projek / Keterangan *</li>
                <li>
                <div class="note">PYD dan PPP hendaklah berbincang bersama sebelum menetapkan SKT dan Petunjuk Prestasinya</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">
                      <span id="akt">
                      <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                        <textarea name="uskt_aktiviti" id="uskt_aktiviti" cols="45" rows="5"></textarea>
                      </span></td>
                    </tr>
                  </table>
              </li>
                  <li class="title">Petunjuk Prestasi</li>
                  <li>
                <div class="note">SKT yang ditetapkan hendaklah mengandungi sekurang-kurangnya satu Petunjuk Prestasi iaitu sama ada Kuantiti, Kualiti, Masa atau Kos bergantung kepada kesesuaian sesuatu aktiviti / projek.</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th nowrap="nowrap">&nbsp;</th>
                      <th width="50%" nowrap="nowrap">Penerangan</th>
                      <th width="50%" nowrap="nowrap">Sasaran Kerja</th>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Kuantiti *</td>
                      <td><textarea name="uskt_kuantiti" id="uskt_kuantiti" cols="45" rows="5"></textarea></td>
                      <td><textarea name="uskt_kuantiti_sk" id="uskt_kuantiti_sk" cols="45" rows="5"></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Masa *</td>
                      <td><textarea name="uskt_masa" id="uskt_masa" cols="45" rows="5"></textarea></td>
                      <td><textarea name="uskt_masa_sk" id="uskt_masa_sk" cols="45" rows="5"></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Tempoh *</td>
                      <td>&nbsp;</td>
                      <td>
                        <select name="uskt_masa_mula" id="uskt_masa_mula">
                        <?php for($i=1; $i<=12; $i++){?>
                          <option <?php if($i==date('m')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo date('M Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>
                        <?php }; ?>
                      	</select> 
                        <div class="inputlabel"> hingga </div>
                        <select name="uskt_masa_tamat" id="uskt_masa_tamat">
                        <?php for($j=1; $j<=12; $j++){?>
                          <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M Y', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                        <?php }; ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Kualiti *</td>
                      <td><textarea name="uskt_kualiti" id="uskt_kualiti" cols="45" rows="5"></textarea></td>
                      <td><textarea name="uskt_kualiti_sk" id="uskt_kualiti_sk" cols="45" rows="5"></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Kos</td>
                      <td><textarea name="uskt_kos" id="uskt_kos" cols="45" rows="5"></textarea></td>
                      <td><textarea name="uskt_kos_sk" id="uskt_kos_sk" cols="45" rows="5"></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Lain - lain</td>
                      <td><textarea name="uskt_lain" id="uskt_lain" cols="45" rows="5"></textarea></td>
                      <td><textarea name="uskt_lain_sk" id="uskt_lain_sk" cols="45" rows="5"></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">&nbsp;</td>
                      <td colspan="2">
                      <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                      <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','index.php');return document.MM_returnValue" />
                      </td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_insert" value="form1" />
                </li>
            </ul>
            </form>
            </div>
        </div>
        <?php echo noteEmail('1'); ?>
        <?php echo noteFooter('1'); ?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("akt");
</script>
</body>
</html>
<?php include('../inc/footinc.php');?> 