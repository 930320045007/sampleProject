<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='9';?>
<?php $menu2='55';?>
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
  
  $_SESSION['dateh'] = NULL;
  unset($_SESSION['dateh']);
  
  $_SESSION['stafidt'] = NULL;
  unset($_SESSION['stafidt']);
  
  $_SESSION['name'][] = NULL;
  unset($_SESSION['name']);
  
  $_SESSION['ic'][] = NULL;
  unset($_SESSION['ic']);
  
  $_SESSION['pp'][] = NULL;
  unset($_SESSION['pp']);
  
  $_SESSION['ct'][] = NULL;
  unset($_SESSION['ct']);
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
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
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
            <form id="formtravel" name="form1" method="POST" action="../sb/add_ticket.php">
            <ul>
            <?php if(!$maintenance || checkUserSysAcc($row_user['user_stafid'], 10, 57, 2)){?>
                <li>
                	<div class="note">Borang Penempahan Tiket Kapal Terbang</div>
                </li>
                <li>
               	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
               	      <tr>
               	        <td nowrap="nowrap" class="label">Jenis Tiket</td>
               	        <td>
                            <ul class="inputradio">
                                <li><input name="tickettype_id" type="radio" value="1" checked="checked" /> Kapal Terbang</li>
                            </ul>
                        </td>
           	          </tr>
               	      <tr>
               	        <td nowrap="nowrap" class="label">Tujuan / Program *</td>
               	        <td>
                        <span id="tajuk"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
               	          <input required="required" autofocus="autofocus" type="text" name="ticket_title" id="ticket_title" onkeypress="return handleEnter(this, event)" />
           	            </span>
                        </td>
           	          </tr>
               	      <tr>
               	        <td nowrap="nowrap" class="label">No. Rujukan<br />Kelulusan *</td>
               	        <td>
                        <span id="ruj"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
               	          <input required="required" name="ticket_ref" type="text" class="w50" id="ticket_ref" onkeypress="return handleEnter(this, event)" maxlength="25" />
                        <div class="inputlabel2">Merujuk kepada Surat Kelulusan </div>
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
                              <td width="20%" align="left" valign="middle">
                              <div class="inputlabel2">Dari / From</div>
                              <input type="text" name="travel_from" id="travel_from" onkeypress="return handleEnter(this, event)" />
                              <div class="inputlabel2">Cth: Kuala Lumpur, Malaysia</div>
                              </td>
                              <td width="20%" align="left" valign="middle">
                              <div class="inputlabel2">Ke / To</div>
                              <input type="text" name="travel_to" id="travel_to" onkeypress="return handleEnter(this, event)" />
                              <div class="inputlabel2">Cth: Guangzhou, China</div>
                              </td>
                              <td width="30%" align="left" valign="middle" nowrap="nowrap"><div class="inputlabel2">Tarikh / Date</div>
                                <select name="travel_date_d" id="travel_date_d">
                                <?php for($i=1; $i<=31; $i++){?>
                                  <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                                <?php }; ?>
                                </select>
                                <select name="travel_date_m" id="travel_date_m">
                                <?php for($j=1; $j<=12; $j++){?>
                                  <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                                <?php }; ?>
                              </select>
                                <select name="travel_date_y" id="travel_date_y">
                                <?php for($k=date('Y'); $k<=(date('Y')+2); $k++){?>
                                  <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                <?php }; ?>
                              </select>
                              <div class="inputlabel2">&nbsp;</div>
                              </td>
                              <td width="20%" align="left" valign="middle">
                              <div class="inputlabel2">Masa Berlepas / Departure Time</div>
                                <select name="travel_time" id="travel_time">
                                <?php for($i=0; $i<24; $i++) {?>
                                	<?php for($j=0; $j<60; $j+=30){?>
                                    <option <?php if($i==9 && $j==0) echo "selected=\"selected\"";?> value="<?php echo date('h:i A', mktime($i, $j, 0, 1, 1, date('Y')));?>"><?php echo date('h:i A', mktime($i, $j, 0, 1, 1, date('Y')));?></option>
                                    <?php }; ?>
                                <?php }; ?>
                                </select>
                                <div class="inputlabel2">&nbsp;</div>
                              </td>
                              <td align="left" valign="middle">
                              <div class="inputlabel2">&nbsp;</div>
                              <input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="xmlhttpPost('addtravel.php?add=1', 'formtravel', 'senaraitravel', 'Proses penambahan ...'); return false;" />
                              <div class="inputlabel2">&nbsp;</div>
                              </td>
                            </tr>
                          </table>
                        </li>
                		<li class="line_b line_l line_r">
                    	<div id="senaraitravel">
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
                    <div class="note">3. Senarai Penumpang (Kakitangan ISN)</div>
                    <ul>
                        <li class="form_back line_t line_l line_r">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td align="left" valign="middle" nowrap="nowrap" class="label">Staf ID</td>
                              <td width="100%" align="left" valign="middle">
                              <input name="user_stafid" type="text" class="w25" id="user_stafid" onkeypress="return handleEnter(this, event)" list="datalist1" />
                              <?php echo datalistStaf("datalist1");?>
                              <input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="xmlhttpPost('addisnpassenger.php?add=1', 'formtravel', 'senaraiisnpassenger', 'Proses penambahan ...'); return false;" />
                              </td>
                            </tr>
                          </table>
                        </li>
                		<li class="line_b line_l line_r">
                    	<div id="senaraiisnpassenger">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="100" align="center" valign="middle" class="noline txt_line">
                              <div>Sila isi maklumat Staf ID dan klik 'Tambah'.</div>
                              <div>Ulangi langkah ini untuk tambahan maklumat seterusnya</div>
                              </td>
                            </tr>
                          </table>
                      	</div>
                        </li>
                    </ul>
                </li>
                <li class="gap">&nbsp;</li>
                <li>
                    <div class="note">4. Senarai Penumpang Tanggungan (Bukan Kakitangan ISN)</div>
                    <ul>
                        <li class="form_back line_t line_l line_r">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="20%" align="left" valign="middle"><div class="inputlabel2">Nama Penuh / Full Name</div>
                                <input type="text" name="nip_name" id="nip_name" onkeypress="return handleEnter(this, event)" /></td>
                              <td width="20%" align="left" valign="middle"><div class="inputlabel2">Kad Pengenalan</div>
                                <input type="text" name="nip_noic" id="textfield8" onkeypress="return handleEnter(this, event)" /></td>
                              <td width="20%" align="left" valign="middle"><div class="inputlabel2">Passport</div>
                                <input type="text" name="nip_passport" id="textfield9" onkeypress="return handleEnter(this, event)" /></td>
                              <td width="20%" align="left" valign="middle"><div class="inputlabel2">Catatan</div>
                                <input name="nip_notes" type="text" id="textfield10" onkeypress="return handleEnter(this, event)" /></td>
                              <td width="20%" align="left" valign="middle"><div class="inputlabel2">&nbsp;</div>
                                <input name="button4" type="button" class="submitbutton" id="button4" value="Tambah" onclick="xmlhttpPost('addnonisnpassenger.php?add=1', 'formtravel', 'senarainonisnpassenger', 'Proses penambahan ...'); return false;" /></td>
                            </tr>
                          </table>
                        </li>
                		<li class="line_b line_l line_r">
                    	<div id="senarainonisnpassenger">
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
                    <div class="note">5. Maklumat Tambahan</div>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="70%" align="left" valign="middle">Tambahan Bagasi (Sila rujuk <strong> (A) Terma dan Syarat Bagasi </strong> dibawah)</td>
                            <td align="left" valign="middle" nowrap="nowrap"><input name="ticket_bagasi" type="number" class="w30 txt_right" id="ticket_bagasi" value="0" onkeypress="return handleEnter(this, event)" /> <span class="inputlabel">kg</span></td>
                        </tr>
                          <tr>
                            <td align="left" valign="middle">Insuran Perjalanan (Sila rujuk <strong>(B) Terma dan Syarat Insuran Perjalanan</strong> dibawah)</td>
                            <td align="left" valign="middle" nowrap="nowrap">
                                <ul class="inputradio">
                                    <li><input name="ticket_insuran" type="radio" value="1" checked="checked" /> Ya</li>
                                    <li><input name="ticket_insuran" type="radio" value="2" /> Tidak</li>
                                </ul>
                            </td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="noline">Visa perjalanan</td>
                            <td align="left" valign="middle" nowrap="nowrap" class="noline">
                                <ul class="inputradio">
                                    <li><input name="ticket_visa" type="radio" value="1" /> Ya</li>
                                    <li><input name="ticket_visa" type="radio" value="2" checked="checked" /> Tidak</li>
                                </ul>
                            </td>
                          </tr>
                      </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="back_darkgrey">
                <span id="sah">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="top" class="w5 noline">
                      <input type="checkbox" name="checkbox" id="checkbox" required="required" />
                    </td>
                    <td class="noline txt_line">
                    <div class="checkboxRequiredMsg">Sila buat pengesahan.</div>
                    <div>Saya dengan ini mengesahkan bahawa segala maklumat yang diberikan adalah benar dan disokong bersama dokumen-dokumen berikut :
                    <ol class="listnumber">
                    	<li>Surat Arahan/Jemputan yang telah yang telah disokong oleh Ketua Bahagian/Cawangan/Pusat dan diluluskan oleh Ketua Pegawai Eksekutif (<strong>WAJIB</strong> mendapat kelulusan)</li>
                        <li>Salinan Jadual Program</li>
                        <li>Salinan Passport dan Visa (<strong>WAJIB</strong> bagi perjalanan Luar Negara dan Pegawai Asing)</li>
                        <li>Cetakan Tempahan <strong>WAJIB</strong> dihantar bersama Dokumen Asal kepada KPE/PBT</li>
                    </ol>
                    </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="noline"> <input type="hidden" name="MM_insert" value="form1" /></td>
                    <td class="noline"><input name="button5" type="submit" class="submitbutton" id="button5" value="Hantar" /></td>
                  </tr>
                </table>
                </span>
                </li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="txt_line">
                      <ul>
                      	<li><strong>(A) Terma dan Syarat Tambahan Bagasi</strong>
                        	<ol class="listnumber">
                            	<li>Tempahan tambahan bagasi perlu dibuat bersama tempahan tiket kapal terbang</li>
                                <li>Bagasi tambahan adalah barang dan peralatan yang diisytihar (senarai yang disahkan oleh Ketua Bahagian/Cawangan/Pusat/Unit sebagai pengunaan untuk tugasan rasmi sahaja)</li>
                                <li>Bagasi tambahan peribadi perlu ditanggung oleh penumpang</li>
                                <li>Pendahuluan kos bagasi tambahan perlu dipohon oleh penumpang kepada Cawangan Kewangan (mengikut prosedur kewangan) sebelum penerbangan. Kos / Caj utk tambahan bagasi per/kg mengikut destinasi perlu dirujuk <?php echo getDirSubName(getDirIDByMenuID($menu));?> terlebih dahulu sebelum membuat permohonan di Cawangan Kewangan</li>
                                <li>Sekiranya penumpang tidak memohon pendahuluan  kos bagasi tambahan penumpang wajib memaklumkan kepada Cawangan Pentadbiran 2 minggu sebelum perjalanan</li>
                            </ol>
                            <div class="note"><strong>Notis Pembatasan Liabiliti Bagasi:</strong> Liabiliti untuk kehilangan, kelewatan atau kerosakan bagasi adalah terhad kecuali jika nilai yang lebih tinggi diisytiharkan terlebih dahulu dan caj tambahan telah dibayar. Liabiliti untuk perjalanan domestik dan liabiliti untuk perjalanan antarabangsa berbeza mengikut undang-undang masing-masing.</div>
                        </li>
                      </ul>
                      </td>
                    </tr>
                    <tr>
                      <td class="txt_line">
                      <ul>
                        <li><strong>(B) Terma dan Syarat Insuran Perjalanan</strong>
                        	<ol class="listnumber">
                            	<li>Permohonan insuran perjalanan berpandu pada pekeliling yang terpakai dan mendapat kelulusan Kewangan/Jabatan</li>
                                <li>Penumpang yang telah mempunyai insuran perjalanan peribadi perlu memaklumkan <?php echo getDirSubName(getDirIDByMenuID($menu));?></li>
                            </ol>
                        </li>
                      </ul>
                      </td>
                    </tr>
                    <tr>
                      <td class="txt_line">
                      <ul>
                        <li><strong>Rujukan </strong>
                        	<ol class="listnumber">
                            	<li><a href="32003.pdf" target="_blank"><strong>PEKELILING PERBENDAHARAAN BIL. 3 TAHUN 2003</strong> - KADAR DAN SYARAT TUNTUTAN ELAUN, KEMUDAHAN DAN BAYARAN KEPADA PEGAWAI PERKHIDMATAN AWAM KERANA MENJALANKAN TUGAS RASMI (TIDAK TERMASUK ANGGOTA TENTERA DAN ANGGOTA POLIS) (Format : PDF)</a></li>
                                <li><a href="spp151995.pdf" target="_blank"><strong>SURAT PEKELILING PERBENDAHARAAN BIL. 15 TAHUN 1995</strong> - SKIM PERLINDUNGAN INSURANS PERJALANAN UDARA KELUAR NEGERI (Format : PDF)</a></li>
                                <li><a href="spp051976.pdf" target="_blank"><strong>SURAT PEKELILING PERBENDAHARAAN BIL. 5 TAHUN 1976</strong> - INSURAN NYAWA YANG MELIPUTI PENERBANGAN-PENERBANGAN TENTERA UDARA DI RAJA MALAYSIA ATAU PENERBANGAN-PENERBANGAN YANG TIDAK BERJADUAL BAGI PEGAWAI-PEGAWAI YANG BERTUGAS DI DALAM DAN DI LUAR NEGERI (Format : PDF)</a></li>
                            </ol>
                        </li>
                      </ul>
                      </td>
                    </tr>
                  </table>
                </li>
                <?php } else { ?>
                <li>
                <div class="note">Sistem dalam proses pengemaskinian dan penambahbaikkan buat sementara waktu</div>
                </li>
                <?php }; ?>
            </ul>
            </form>
            </div>
        </div>
        <?php echo noteFooter('1'); ?>
        <?php echo noteEmail('1'); ?>
        <?php echo noteMade($menu);?>
        </div>
      	<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sah");
var sprytextfield1 = new Spry.Widget.ValidationTextField("tajuk");
var sprytextfield2 = new Spry.Widget.ValidationTextField("ruj");
</script>
</body>
</html>
<?php include('../inc/footinc.php');?> 