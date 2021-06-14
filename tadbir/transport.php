<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='9';?>
<?php $menu2='76';?>
<?php
?>
<?php
 $_SESSION['from'] = NULL;
  unset($_SESSION['from']);
  
  $_SESSION['to'] = NULL;
  unset($_SESSION['to']);
  
  $_SESSION['dated'] = NULL;
  unset($_SESSION['dated']);
  
  $_SESSION['datem'] = NULL;
  unset($_SESSION['datem']);
  
  $_SESSION['datey'] = NULL;
  unset($_SESSION['datey']);
  
  $_SESSION['time'] = NULL;
  unset($_SESSION['time']);
  
 $_SESSION['stafidt'] = NULL;
  unset($_SESSION['stafidt']);
  
if(isset($_POST['id']))
	$userbook = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES));
else if(isset($_GET['id']))
	$userbook = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
else
	$userbook = $row_user['user_stafid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/disenter.js"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
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
            <?php if(!checkUserFeedbackByUserID($row_user['user_stafid'])){?>
            <form id="formtransport" name="form1" method="POST" action="../sb/add_transport.php">
            <ul>
                <li>
                	<div class="note">1. Borang Permohonan Penggunaan Kenderaan </div>
                </li>
                <li>
               	    <table width="100%" border="0" cellpadding="0" cellspacing="0">
               	      <tr>
               	        <td nowrap="nowrap" class="label">Tujuan / Program *</td>
               	        <td>
                         <span id="tajuk"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                         <input type="text" name="transbook_title" id="transbook_title" onkeypress="return handleEnter(this, event)" />
                         </span>
                        </td>
           	          </tr>
               	      <tr>
               	        <td class="label">No. Rujukan</td>
               	        <td>
               	          <input name="transbook_ref" type="text" class="w50" id="transbook_ref" onkeypress="return handleEnter(this, event)" maxlength="20" />
                        <div class="inputlabel2">Merujuk kepada Minit Mesyuarat / Jemputan</div>
                        </td>
           	          </tr>
                      <tr>
                       <td nowrap="nowrap" class="label txt_line">
                       <div>Bil Kenderaan</div>
                       <div class="txt_color1">(Cadangan)</div>
                       </td>
                      <td align="left" valign="middle">
                       <select name="transbook_notrans">
                            <?php for($nt = 1; $nt<=5; $nt++){?>
                            <option <?php if($nt==1) echo "selected=\"selected\"";?> value="<?php echo $nt; ?>"><?php echo $nt; ?></option>
                            <?php }; ?>
                          </select>
                          </td></tr>
                          <tr>
                       <td class="label">Catatan *</td>
                        <td> 
                        <div class="inputlabel2">Sila nyatakan keperluan kenderaan</div>
                        <span id="catatan">
                        <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                        <span class="textareaMaxCharsMsg">Melebihi had yang dibenarkan.</span>
                        <textarea name="transbook_note" cols="45" rows="5" id="transbook_note" onkeypress="return handleEnter(this, event)"></textarea>
                        <div class="inputlabel2"><span id="countcatatan">&nbsp;</span> huruf</div>
                        </span>
                        </td>
                      </tr>
           	        </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li>
                    <div class="note">2. Maklumat Perjalanan</div>
                  <ul>
                        <li class="form_back line_t line_l line_r">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="50%" align="left" valign="middle">
                              <div class="inputlabel2">Dari / From</div>
                              <input name="journey_from" type="text" id="journey_from" onkeypress="return handleEnter(this, event)" maxlength="50" />
                              <div class="inputlabel2">Cth: MSN, Bukit Jalil</div></td>
                              <td width="50%" align="left" valign="middle">
                              <div class="inputlabel2">Ke / To</div>
                              <input name="journey_to" type="text" id="journey_to" onkeypress="return handleEnter(this, event)" maxlength="50" />
                              <div class="inputlabel2">Cth: KBS, Putrajaya</div>
                              </td>
                              <td align="left" valign="middle" nowrap="nowrap">
                              <div class="inputlabel2">Tarikh / Date</div>
                                 <select name="dmy" id="dmy">
                                <?php for($i=date('d'); $i<=(date('d')+90); $i++){?>
                                  <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php echo date('d/m/Y', mktime(0, 0, 0, date('m'), $i, date('Y')));?>"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, date('m'), $i, date('Y')));?></option>
                                <?php }; ?>
                                </select>
                              </td>
                              <td align="left" valign="middle">
                              <div class="inputlabel2">Masa / Time</div>
                              <select name="journey_time" id="journey_time">
                              <?php for($i=0; $i<24; $i++){?>
								  <?php for($j=0; $j<60; $j+=15){?>
                                <option <?php if($i == 9 && $j == 0) echo "selected=\"selected\"";?> value="<?php echo date('H:i', mktime($i, $j, 0, 1, 1, date('Y')));?>"><?php echo date('h:i A', mktime($i, $j, 0, 1, 1, date('Y')));?></option>
                                  <?php }; ?>
							  <?php }; ?>
                              </select>
                              </td>
                              <td align="left" valign="middle">
                              <div class="inputlabel2">&nbsp;</div>
                              <input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="xmlhttpPost('addjourney.php?add=1', 'formtransport', 'senaraijourney', 'Proses penambahan ...'); return false;" /></td>
                            </tr>
                          </table>

                        </li>
                		<li class="line_b line_l line_r">
                    	<div id="senaraijourney">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="100" align="center" valign="middle" class="noline txt_line">
                              <div>Sila isi maklumat yang dikehendaki dan klik 'Tambah'.</div>
                              <div>Ulangi langkah ini untuk tambahan maklumat seterusnya.</div>
                              </td>
                            </tr>
                          </table>
                      	</div>
                        </li>
                    </ul>
                    </li>
                    <li class="gap">&nbsp;</li>
                    <li>
                    <div class="note">3. Senarai Penumpang</div>
                    <ul>
                        <li class="form_back line_t line_l line_r">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td align="left" valign="middle" nowrap="nowrap" class="label">Staf ID</td>
                              <td width="100%" align="left" valign="middle">
                              <input name="id" type="text" class="w30" id="id" list="datastafid" value="<?php echo $userbook; ?>"/><?php echo datalistStaf('datastafid');?>
                              
                              <input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="xmlhttpPost('addpassenger.php?add=1', 'formtransport', 'senaraipassenger', 'Proses penambahan ...'); return false;" />
                              </td>
                            </tr>
                          </table>
                        </li>
                		<li class="line_b line_l line_r">
                    	<div id="senaraipassenger">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="100" align="center" valign="middle" class="noline txt_line">
                              <div>Sila isi maklumat Staf ID dan klik 'Tambah'.</div>
                              <div>Ulangi langkah ini untuk tambahan maklumat seterusnya.</div>
                              </td>
                            </tr>
                          </table>
                      	</div>
                        </li>
                    </ul>
                </li>
                <li class="gap">&nbsp;</li>
                <li>
                <div class="note">4. Pengesahan Tempahan</div>
                <span id="sah">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="top" class="w10 noline">
                    <ul class="inputradio">
                    <li>
                    <input name="checkbox" type="checkbox" id="checkbox" />
                    </li>
                    </ul>
                    </td>
                     <td width="100%" align="left" valign="middle" class="noline txt_line">
                     <span class="checkboxRequiredMsg"><div>Sila buat pengesahan. </div></span>
                     <div>Saya mengesahkan setiap maklumat yang diberikan adalah benar. <?php echo getDirSubName(getDirIDByMenuID($menu));?> berhak untuk menukar atau membatalkan tempahan kenderaan ini tanpa sebarang notis atau makluman.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="noline">
                     <input type="hidden" name="MM_insert" value="form1" />
                      <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" />
                     </td>
                    <td class="noline"><input name="button5" type="submit" class="submitbutton" id="button5" value="Hantar" /></td>
                  </tr>
                </table>
               </span>
               </li>
                <li class="line_t txt_line">
                <div class="note">
                    <div>Perhatian:-</div>
                    <div>
                        <ol>
                            <li>Untuk kegunaan luar Kuala Lumpur, borang permohonan perlu dihantar <strong>Tiga Hari</strong> sebelum tarikh yang dikehendaki.</li>
                            <li>Untuk kegunaan kem, bengkel dan karnival, borang perlu dihantar <strong>Seminggu</strong> sebelum program tersebut diadakan.</li>
                            <li>Untuk kegunaan ke KLIA, kenderaan akan diberi mengikut keperluan semasa.</li>
                            <li>Untuk kegunaan dalam Kuala Lumpur, permohonan akan dipertimbangkan mengikut kekosongan dan jadual perjalanan.</li>
                            <li>Sila berhubung dengan <?php echo getDirSubName(getDirIDByMenuID($menu));?> untuk maklumat lanjut berkaitan jadual kenderaan.</li>
                       </ol>
                    </div>
                </div>
                </li>
            </ul>
            </form>
             <?php } else { ?>
              <ul>
        	<li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="noline"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /></td>
                  <td width="100%" class="noline txt_line">
                  <div>Modul Kenderaan tidak dapat digunakan kerana anda masih belum menjawab soal selidik untuk tempahan kenderaan yang lama.</div>
                  <div>Klik pada Modul Admin > Rekod > Tempahan Kenderaan > klik pada 'Isi' sebaris dengan rekod tempahan kenderaan yang masih belum mengisi borang soal selidik.</div>
                  </td>
                </tr>
              </table>
            </li>
        </ul>
        <?php  }; ?>
            </div>
        </div>
        <?php echo noteEmail('1'); ?>
        <?php echo noteMade($menu);?>
        </div>
      	<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sah");
var sprytextfield1 = new Spry.Widget.ValidationTextField("tajuk");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("catatan", {counterId:"countcatatan", counterType:"chars_remaining", maxChars:300});
</script>
</body>
</html>
<?php include('../inc/footinc.php');?> 