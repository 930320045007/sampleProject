<?php require_once('Connections/hrmsdb.php'); ?>
<?php require_once('Connections/ictdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='24';?>
<?php $menu2='1';?>
<?php
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_wfh = "SELECT * FROM user_workhome WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND date_d=DAYOFMONTH(CURDATE()) AND date_m=MONTH(CURDATE()) AND date_y=YEAR(CURDATE())";
$wfh = mysql_query($query_wfh, $hrmsdb) or die(mysql_error());
$row_wfh = mysql_fetch_assoc($wfh);
$totalRows_wfh = mysql_num_rows($wfh);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<script src="js/ajaxsbmt.js" type="text/javascript"></script>
<script src="js/disenter.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<?php include('inc/liload.php');?>
<?php include('inc/headinc.php');?>
<script>
	window.onload = function ()
	{
		//dochange('16', 'tempohlist', document.getElementById('sebab').value, 0, 0);
		display_ct();
	}
</script>
</head>
<body <?php include('inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('inc/header.php');?>
      <?php include('inc/menu.php');?>
        
      	<div class="content">
         <?php //include('inc/menu_leave.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          <form action="sb/add_userwfh.php" method="POST" id="workfromhome" name="workfromhome">
                <ul>
				  <li>
                  	<div class="note"><strong>Rekod Kehadiran Bertugas Sempena Perintah Kawalan Pergerakan</strong></div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td align="center" valign="middle"><?php echo viewProfilePic($row_user['user_stafid']);?></td>
                      <td width="100%" align="left" valign="middle">
                        <div><strong><?php echo getFullNameByStafID($row_user['user_stafid']) . " (" . $row_user['user_stafid'] . ")"; ?></strong></div>
                        <div class="txt_color1"><?php echo getJobtitle($row_user['user_stafid']) . " (" . getGred($row_user['user_stafid']) . ")";?></div>
                        <div class="txt_color1"><?php echo getFulldirectoryByUserID($row_user['user_stafid']);?></div>
                      </td>
                    </tr>
                  </table>
                  </li>
                  <?php if ($totalRows_wfh == 0) { ?>
                  <li>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="label">Tarikh</td>
                        <td colspan="3" align="left" valign="middle">
                        <strong><span id="ct"></span></strong>
                        </td>
                     </tr>
                     <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="label">Lokasi</td>
                        <td colspan="3" align="left" valign="middle">
                        <div>
                          <label for="userleavestatus_name"></label>
                          <span id="tajuk"><span class="textfieldRequiredMsg">Lokasi diperlukan.</span>
                          <input name="pergerakan_lokasi" required="required" type="text" id="pergerakan_lokasi" maxlength="150" onkeypress="return handleEnter(this, event)"/>
                          <div class="inputlabel2">Cth: Bangi, Selangor</div>
                          </span>
                        </div>
                        </td>
                     </tr>
                     <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="label noline">Deskripsi Tugasan</td>
                        <td colspan="4" align="left" valign="middle" class="noline">
                        <span id="leavenote">
                        <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                        <span class="textareaMaxCharsMsg">Hanya 300 huruf sahaja.</span>
                        <div class="inputlabel2">Sila huraikan tugasan harian anda sepanjang bekerja dari rumah.</div>
                        <textarea name="leaveoffice_note" required="required" cols="20" rows="5" id="leaveoffice_note" autofocus="autofocus"></textarea>
                        <div class="inputlabel2"><span id="countleavenote">&nbsp;</span> huruf</div>
                        </span>
                        </td>
                      </tr>
                      <tr>
                          <td align="left" valign="top" class="noline w5">&nbsp;</td>
                          <td align="left" valign="middle" nowrap="nowrap">
                          <div class="fl w5"><input name="checkboxin" type="checkbox" id="checkboxin" /></div>
                          <div class="fl w90"><strong>Daftar Masuk</strong></div>
                          </td>
                          <td align="left" valign="middle" nowrap="nowrap">
                          <div class="fl w5"><input name="checkboxout" type="checkbox" id="checkboxout" /></div>
                          <div class="fl w90"><strong>Daftar Keluar</strong></div>
                          </td>
                          <td colspan="2" align="left" valign="middle"></td>
                      </tr>
                    </table>
                      </li>
                  <?php } else { ?>
                  <li>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                      <td align="left" valign="middle" nowrap="nowrap" class="label">Tarikh</td>
                        <td colspan="3" align="left" valign="middle">
                        <strong><span id="ct"></span></strong>
                        </td>
                     </tr>
                     <tr>
                      <td align="left" valign="middle" nowrap="nowrap" class="label">Lokasi</td>
                        <td colspan="3" align="left" valign="middle">
                        <div>
                          <input name="pergerakan_lokasi" type="text" id="pergerakan_lokasi" maxlength="150" value="<?php echo $row_wfh['work_location']; ?>" onkeypress="return handleEnter(this, event)"/>
                          <div class="inputlabel2">Cth: Bangi, Selangor</div>
                        </div>
                        </td>
                     </tr>
                       <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="label noline">Deskripsi Tugasan</td>
                        <td colspan="4" align="left" valign="middle" class="noline">
                        <span id="leavenote">
                        <span class="textareaMaxCharsMsg">Hanya 300 huruf sahaja.</span>
                        <div class="inputlabel2">Sila huraikan tugasan harian anda sepanjang bekerja dari rumah.</div>
                        <textarea name="leaveoffice_note" cols="20" rows="5" id="leaveoffice_note" autofocus="autofocus"><?php echo $row_wfh['work_description']; ?></textarea>
                        <div class="inputlabel2"><span id="countleavenote">&nbsp;</span> huruf</div>
                        </span>
                        </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" class="noline w5">&nbsp;</td>
                          <td align="left" valign="middle" nowrap="nowrap">
                          <?php if($row_wfh['time_in']==NULL) { ?>
                          <div class="fl w5"><input name="checkboxin" type="checkbox" id="checkboxin" /></div>
                          <div class="fl w90"><strong>Daftar Masuk</strong></div>
                          <?php } else { 
						  	echo "<strong>" ."Daftar Masuk - ". $row_wfh['time_in']. "</strong>";
						  }?>
                        </td>
                        <td align="left" valign="middle" nowrap="nowrap">
                          <?php if($row_wfh['time_out']==NULL) { ?>
                          <div class="fl w5"><input name="checkboxout" type="checkbox" id="checkboxout" /></div>
                          <div class="fl w90"><strong>Daftar Keluar</strong></div>
                          <?php } else { 
						  	echo "<strong>" ."Daftar Keluar - ". $row_wfh['time_out']. "</strong>";
						  }?>
                        </td>
                        <td colspan="2" align="left" valign="middle">
                        </td>
                      	</tr>
                        </table>
                      </li>
                      <?php } ?>
                      <?php if(($totalRows_wfh == 0) || (($totalRows_wfh > 0) && (($row_wfh['time_in']==NULL) || ($row_wfh['time_out']==NULL)))) { ?>                      
                      <li>
                      	<table>
                        <tr>
                          <td class="noline">
                          <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" />
                          <input type="hidden" name="MM_insert" value="workfromhome" />
                          </td>
                          <td colspan="4" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Hantar" /></td>
                        </tr>
                        </table>
                      </li>
                      <?php } ?>
                      <li class="gap">&nbsp;</li>
                      <li class="line_t">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="txt_line noline">
                            <div>Perhatian :</div>
                            <div>
                                <ol>
                                    <li>Pegawai/anggota dikehendaki Daftar Masuk dan Daftar Keluar sepanjang tempoh Bekerja Dari Rumah (BDR).</li>
                                    <li>Tandakan kotak pilihan Daftar Masuk/Daftar Keluar sebelum menekan butang Hantar untuk membolehkan sistem merekod waktu masuk/keluar. Sila ulang langkah ini sehingga waktu Daftar Masuk/Daftar Keluar dipaparkan.</li>
                                    <li>Pegawai/anggota boleh mengemaskini maklumat Lokasi dan Deskripsi Tugas untuk hari semasa. Kemaskini maklumat dan tekan butang Hantar tanpa menanda mana-mana kotak pilihan(jika tidak berkenaan).</li>
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
            	<?php //echo noteEmail(1);?>
        	</div>
    	<?php include('inc/footer.php');?>
	</div>
</div>           
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("leavenote", {counterId:"countleavenote", counterType:"chars_remaining", maxChars:300});
var sprytextfield1 = new Spry.Widget.ValidationTextField("tajuk");

function display_c(){
var refresh=1000; // Refresh rate in milli seconds
mytime=setTimeout('display_ct()',refresh)
}

function display_ct() {
var x = new Date()

var month=x.getMonth()+1;
var day=x.getDate();
var year=x.getFullYear();
if (month <10 ){month='0' + month;}
if (day <10 ){day='0' + day;}
var x3= day+'/'+month+'/'+year;

// time part //
var hour=x.getHours();
var minute=x.getMinutes();
var second=x.getSeconds();
if(hour <10 ){hour='0'+hour;}
if(minute <10 ) {minute='0' + minute; }
if(second<10){second='0' + second;}
var x3 = x3 + ' ' +  hour+':'+minute+':'+second

document.getElementById('ct').innerHTML = x3;
display_c();
}
</script>
</body>
</html>
<?php
mysql_free_result($wfh);

?>
<?php include('inc/footinc.php');?> 