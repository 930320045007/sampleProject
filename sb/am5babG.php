<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='3';?>
<?php $menu2='75';?>
<?php
	
if(isset($_GET['from']))
{
	$fy = explode("/", htmlspecialchars($_GET['from'], ENT_QUOTES));
} else {
	$fy[0] = date('H');
	$fy[1] = date('i');
	$fy[2] = date('a');
}

if(isset($_GET['till']))
{
	$ty = explode("/", htmlspecialchars($_GET['till'], ENT_QUOTES));
} else {
	$ty[0] = date('H');
	$ty[1] = date('i');
	$ty[2] = date('a');
}

if(isset($_POST['sebab']) && $_POST['sebab']!='0')
{
	$wsql .= " AND reason_id='" . htmlspecialchars($_POST['sebab'], ENT_QUOTES) . "' ";
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sebab = "SELECT * FROM reason WHERE reason_status = 1 ORDER BY reason_name ASC";
$sebab = mysql_query($query_sebab, $hrmsdb) or die(mysql_error());
$row_sebab = mysql_fetch_assoc($sebab);
$totalRows_sebab = mysql_num_rows($sebab);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../js/disenter.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
<script>
	window.onload = function ()
	{
		dochange('16', 'tempohlist', document.getElementById('sebab').value, 0, 0);
	}
</script>
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
          <form action="../sb/add_userleaveoffice.php" method="POST" id="leaveoffice" name="leaveoffice">
                <ul>
				  <li>
  					<div class="note">Borang Permohonan Kebenaran Meninggalkan Pejabat Dalam Waktu Pejabat (Am 5 Bab G)</div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                      <tr>
                        <td><?php echo viewProfilePic(getHeadIDByUserID($row_user['user_stafid']));?></td>
                        <td width="100%" class="txt_line">
                      <div>Kelulusan oleh &sup1;</div>
                      <div><strong><?php echo getFullNameByStafID(getHeadIDByUserID($row_user['user_stafid'])) . " (" . getHeadIDByUserID($row_user['user_stafid']) . ")";?></strong></div>
                      <div class="txt_color1 txt_size2"><?php echo getJobtitle2(getHeadIDByUserID($row_user['user_stafid'])) . ", " . getFulldirectoryByUserID(getHeadIDByUserID($row_user['user_stafid']));?></div>
                      </td>
                      </tr>
                    </table>
                  </li>
                  <li>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                      <td align="left" valign="middle" nowrap="nowrap" class="label">Sebab</td>
                        <td colspan="3" align="left" valign="middle">
                        <div id="spryselect1">
                        <div class="selectInvalidMsg">Sila pilih sebab</div>
                        <div>
                          <select name="sebab" id="sebab" onChange="dochange('16', 'tempohlist', this.value, 0, 0);">
                            <?php
                          do {  
                          ?>
                            <option value="<?php echo $row_sebab['reason_id']?>"><?php echo $row_sebab['reason_name']?></option>
                            <?php
                          } while ($row_sebab = mysql_fetch_assoc($sebab));
                            $rows = mysql_num_rows($sebab);
                            if($rows > 0) {
                                mysql_data_seek($sebab, 0);
                                $row_sebab = mysql_fetch_assoc($sebab);
                            }
                          ?>
                          </select>
                        </div>
                        </div>
                        </td>
                     </tr>
                      <tr>
                       <td align="left" valign="middle" nowrap="nowrap" class="label">Tarikh</td>
                        <td align="left" valign="middle" nowrap="nowrap">                          
                          <select name="dmy" id="dmy">
                           <?php for($dt=(date('d')-30); $dt<=(date('d')+30); $dt++){?>
                          	<option <?php if(date('d')==$dt) echo "selected=\"selected\"";?> value="<?php echo date('d/m/Y', mktime(0, 0, 0, date('m'), $dt, date('Y')));?>"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, date('m'), $dt, date('Y')));?></option>
                          <?php }; ?>
                        </select>
                        </td>
                        <td align="left" valign="middle" nowrap="nowrap" class="label">Tempoh</td>
                        <td width="100%" align="left" valign="middle" nowrap="nowrap">
                        <div id="tempohlist">
                            <select name="xxx" id="xxx">
                            <option value="0" disabled="disabled">Sila pilih sebab</option>
                            </select>
                        </div>
                        </td>
                        </tr>
                       <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="label noline">Catatan *</td>
                        <td colspan="4" align="left" valign="middle" class="noline">
                        <span id="leavenote">
                        <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                        <span class="textareaMaxCharsMsg">Hanya 300 huruf sahaja.</span>
                        <div class="inputlabel2">Sila huraikan sebab meninggalkan pejabat dalam waktu pejabat.</div>
                        <textarea name="leaveoffice_note" required="required" cols="30" rows="5" id="leaveoffice_note" autofocus="autofocus"></textarea>
                        <div class="inputlabel2"><span id="countleavenote">&nbsp;</span> huruf</div>
                        </span>
                        </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" class="noline w5">&nbsp;</td>
                          <td colspan="4" width="100%" align="left" valign="top" class="noline">
                        <span id="pengesahan">
                          <div class="fl w5"><input name="checkbox" required="required" type="checkbox" id="checkbox" /></div>
                          <div class="fl w90">
                          <span class="checkboxRequiredMsg">Sila buat pengesahan. <br/></span>
                          Saya mengesahkan maklumat yang diberikan adalah benar dan dibincangkan / dimaklumkan kepada <strong><?php echo getFullNameByStafID(getHeadIDByUserID($row_user['user_stafid'])) . " (" . getHeadIDByUserID($row_user['user_stafid']) . ")";?></strong> sebelum permohonan ini dibuat. Kelulusan adalah tertakluk pada keperluan dan budi bicara.
                          </div>
                        </span>
                        </td>
                      	</tr>
                        <tr>
                          <td class="noline">
                          <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" />
                          <input type="hidden" name="MM_insert" value="leaveoffice" />
                          </td>
                          <td colspan="4" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Hantar" /></td>
                        </tr>
                        </table>
                      </li>
                      <li class="gap">&nbsp;</li>
                      <li class="line_t">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="txt_line noline">
                            <div>Perhatian :</div>
                            <div>
                                <ol>
                                    <li>Sekiranya tempoh pegawai/anggota meninggalkan pejabat dalam waktu kerja melebihi <strong>4 jam</strong> atau <strong>separuh</strong> daripada waktu bekerja yang ditetapkan pada hari tersebut, maka pegawai/anggota dikehendaki mengambil Cuti Rehat atau Cuti lain yang berkelayakan.</li>
                                    <li>Pegawai/anggota hendaklah sentiasa bersedia untuk <strong>menggantikan semula</strong> tempoh waktu bekerja yang telah digunakan untuk tujuan menyelesaikan tugas hakikinya supaya penyampaian perkhidmatan tidak terjejas sekiranya diarah oleh Pegawai Penyelianya atau bayaran elaun lebih masa boleh dipotong kepada mana-mana pegawai/anggota yang menggunakan kemudahan ini bagi menggantikan jumlah jam pegawai/anggota meninggalkan pejabat.</li>
                                    <li>Pegawai/anggota dikehendaki <i>'Thumbprint'</i> terlebih dahulu sebelum atau selepas meninggalkan pejabat.</li>
                                    <li>Borang kehadiran ini hanya boleh diisi dua (2) kali dalam satu tarikh yang sama.</li>
                                    <li>Pengarah/Ketua Bahagian/Cawangan/Pusat/Unit berhak memberikan amaran kepada permohonan yang lewat. Setiap tiga (3) kali amaran yang diterima, satu (1) maklumat email dihantar kepada Cawangan Sumber Manusia untuk tindakan susulan.</li>
                               </ol>
                            </div>
                          </td>
                        </tr>
                      </table>
                      </li>
                </ul>
                </form>
                </div>
                </div>
            	<?php echo noteEmail(1);?>
        	</div>
    	<?php include('../inc/footer.php');?>
	</div>
</div>           
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("leavenote", {counterId:"countleavenote", counterType:"chars_remaining", maxChars:300});
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("pengesahan");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {isRequired:false, invalidValue:"0"});
</script>
</body>
</html>
<?php
mysql_free_result($sebab);

?>
<?php include('../inc/footinc.php');?> 