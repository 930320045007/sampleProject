<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='3';?>
<?php $menu2='16';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutitype = "SELECT * FROM www.leave_type ORDER BY leavetype_id ASC";
$cutitype = mysql_query($query_cutitype, $hrmsdb) or die(mysql_error());
$row_cutitype = mysql_fetch_assoc($cutitype);
$totalRows_cutitype = mysql_num_rows($cutitype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutikategori = "SELECT * FROM www.leave_category WHERE leavetype_id = 1 ORDER BY leavecategory_id ASC";
$cutikategori = mysql_query($query_cutikategori, $hrmsdb) or die(mysql_error());
$row_cutikategori = mysql_fetch_assoc($cutikategori);
$totalRows_cutikategori = mysql_num_rows($cutikategori);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	function color(newC, newR) {
		tmp = document.getElementById(newC);
		if(document.getElementById(newR).checked)
		{
			tmp.style.background = "red";
			tmp.checked = true;
		} else {
			tmp.style.background = "white";
			tmp.checked = false;
		}
	}
</script>
<script type="text/javascript" src="../js/disenter.js"></script>
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
          <?php if(!$maintenance && !$leaveform){?>
          <?php if(checkWaris($row_user['user_stafid']) && checkEdu($row_user['user_stafid']) && checkAddressByStafID($row_user['user_stafid']) && checkTelMByStafID($row_user['user_stafid']) && checkAccBankByUserID($row_user['user_stafid']) && checkBankByUserID($row_user['user_stafid']) && checkPERKESOByUserID($row_user['user_stafid']) && checkKWSPByUserID($row_user['user_stafid'])){?>
          <?php if(countLeaveBalance($row_user['user_stafid'],date('Y'))>0){?>
          <form action="<?php echo $url_main;?>sb/add_userleaveadd.php" name="formleave" method="POST" id="formleave" >
          	<ul>
            	<li class="padt">
                &nbsp;
            	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
            	    <tr>
            	      <td align="center" class="icon_pad1"><img src="../icon/bag.png" width="48" height="48" alt="iD" /></td>
            	      <td class="line_r w50 txt_line"><div>Baki Cuti Rehat / Tahunan + Cuti Ganti<?php if(getDesignationType($row_user['user_stafid'])) echo " + Cuti Dibawa Kehadapan";?>  &sup1;</div>
                      <div class="txt_size1"><?php echo countLeaveBalance($row_user['user_stafid'],date('Y'));?> <span class="txt_size2">Hari</span></div></td>
            	      <td class="icon_pad1"><?php echo viewProfilePic(getHeadIDByUserID($row_user['user_stafid']));?></td>
            	      <td class="w50 txt_line">
                      <div>Kelulusan cuti oleh &sup1;</div>
                      <div><strong><?php echo getFullNameByStafID(getHeadIDByUserID($row_user['user_stafid'])) . " (" . getHeadIDByUserID($row_user['user_stafid']) . ")";?></strong></div>
                      <div class="txt_color1"><?php echo getJobtitle2(getHeadIDByUserID($row_user['user_stafid'])) . " " . getFulldirectoryByUserID(getHeadIDByUserID($row_user['user_stafid']));?></div>
                      </td>
          	      </tr>
          	    </table>
                </li>
                <li>
                <div class="note">1. Sila pilih tarikh yang ingin permohonan *</div>
                <span id="totaldayselected">
    			<span class="checkboxMinSelectionsMsg"><div class="passbox_form2">Sila pilih satu (1) hari bercuti.</div></span><span class="checkboxMaxSelectionsMsg"><div class="passbox_form2"><img src="../icon/sign_error.png" alt="Error" width="16" height="16" align="absmiddle" /> &nbsp; Melebihi had baki cuti yang dibenarkan.</div></span>
				<?php 
					 //This gets today's date 
					 $date =time(); 
					 
				   for($i=0; $i<2; $i++)
				   {
					
					 //This puts the day, month, and year in seperate variables 
					 $day = date('d', $date); 
					 $month = date('m', $date)+$i; 
					 $year = date('Y', $date);
					 
					 if($month <10)
						$month = '0' . $month;
					 
					 if($month > 12)
					 {
					 	$month = '1';
					 	$year = date('Y', $date)+$i;
					 }
						
					 if($year == date('Y'))
					{
						 //Here we generate the first day of the month 
						 $first_day = mktime(0,0,0,$month, 1, $year) ; 
							
						 //This gets us the month name 					
						 $title = date('F', $first_day) ; 
						 
						 //Here we find out what day of the week the first day of the month falls on 
						$day_of_week = date('D', $first_day) ; 
						
						//Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero
						 switch($day_of_week){ 
							 case "Sun": $blank = 0; break; 
							 case "Mon": $blank = 1; break; 
							 case "Tue": $blank = 2; break; 
							 case "Wed": $blank = 3; break; 
							 case "Thu": $blank = 4; break; 
							 case "Fri": $blank = 5; break; 
							 case "Sat": $blank = 6; break; 
						 }
						 
						 //We then determine how many days are in the current month
						 $days_in_month = cal_days_in_month(0, $month, $year) ; 
						 echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"line_b line_t line_l line_r\">";
						 echo "<tr><td colspan=7 class=\"title txt_size3\" align=\"center\"><strong>$title $year</strong></td></tr>";
						 echo "<tr><td class=\"back_lightgrey txt_color1 line_r line_b3\" align=\"center\">Ahad</td><td class=\"line_r line_b3\" align=\"center\">Isnin</td><td class=\"line_r line_b3\" align=\"center\">Selasa</td><td class=\"line_r line_b3\" align=\"center\">Rabu</td><td class=\"line_r line_b3\" align=\"center\">Khamis</td><td class=\"line_r line_b3\" align=\"center\">Jumaat</td><td class=\"back_lightgrey txt_color1 line_r line_b3\" align=\"center\">Sabtu</td></tr>";
						
						 //This counts the days in the week, up to 7
						 $day_count = 1;
						 echo "<tr>";
						
						 //first we take care of those blank days
						 while ( $blank > 0 ) 
						 { 
							if(checkDayWeekend($day, $month, $year))
								echo "<td class=\"back_lightgrey line_r\">&nbsp;</td>";
							else
								echo "<td class=\"line_r\">&nbsp;</td>"; 
								
							$blank = $blank-1; 
							$day_count++;
						 } 
						 
						 //sets the first day of the month to 1 
						 $day_num = 1;
						 
						 //count up the days, untill we've done all of them in the month
						 while ( $day_num <= $days_in_month )
						 {
							
							if($day_num<10)
								$day_num = '0' . $day_num;
								
							 if(checkHoliday($day_num, $month, $year, $row_user['user_stafid']))
							 {
							 	echo "<td class=\"line_r\"> " . $day_num . " - " . getHolidayName($day_num, $month, $year) . "</td>"; 
							 } 
							 else if(!checkStateWeekendByDate($row_user['user_stafid'], $day_num, $month, $year))
							 {
							 	echo "<td class=\"back_lightgrey txt_color1 line_r\"> $day_num </td>"; 
							 } 
							 else if(checkDayLeave($row_user['user_stafid'], 0, $day_num, $month, $year))
							{
							 	echo "<td width=\"17%\" class=\"line_r\">";
								if(getLeaveTypeByLeaveID(getLeaveID($row_user['user_stafid'], 0, $day_num, $month, $year))==1)
								{
									echo "<a href=\"detail.php?id=" . getLeaveID($row_user['user_stafid'], 1, $day_num, $month, $year) . "\">";
									echo $day_num . " - " . shortText(getLeaveTitle($row_user['user_stafid'], 1, $day_num, $month, $year), 20) . " &nbsp; &nbsp; ";
									echo viewIconLeave($row_user['user_stafid'], getLeaveID($row_user['user_stafid'], 0, $day_num, $month, $year), 0, $day_num, $month, $year) . "</a></td>"; 
								} else {
									echo $day_num . " - " . getLeaveType(getLeaveTypeByLeaveID(getLeaveID($row_user['user_stafid'], 0, $day_num, $month, $year)));
								}
							}
							 else if($year==date('Y') && $month == date('m') && $day_num < date('d')-7) // back dated 7 day
							 {
							 	echo "<td width=\"17%\" class=\"txt_color1 line_r\">" . $day_num;
								if($day_num==date('d') && $month==date('m')) echo " today";
								echo "</td>";
							 }
							else
							{
							 	echo "<td width=\"17%\" class=\"backch line_r\" id=\"C" . $day_num . $month . "\"><input class=\"w25\" onclick=\"color('C" . $day_num . $month . "', 'R" . $day_num . $month . "')\" name=\"listday[]\" type=\"checkbox\" id=\"R" . $day_num . $month . "\" value=\"" . $day_num . "/" . $month . "\"/>" . $day_num;
								if($day_num==date('d') && $month==date('m')) echo " - Kini";
								echo " </td>";
							}
								
							 $day_num++; 
							 $day_count++;
							 
							 //Make sure we start a new row every week
							 if ($day_count > 7)
								 {
								 echo "</tr><tr>";
								 $day_count = 1;
								 }
						 } 
						 
						 //Finaly we finish out the table with some blank details if needed
						 while ( $day_count >1 && $day_count <=7 ) 
						 { 
							 echo "<td class=\"line_r\">&nbsp;</td>"; 
							 $day_count++; 
						 } 
						 
						 echo "</tr></table>";
						 } // tamat semakkan setahun
					 
				   } // tamat loop 2 bulan
					 ?>
                </span>
                </li>
                <li>
                <div class="note">2. Sila isi maklumat dibawah</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Perkara  *</td>
                      <td width="100%" colspan="3"><label for="userleavestatus_name"></label>
                        <span id="tajuk"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                        <input name="userleavedate_name" required="required" type="text" id="userleavestatus_name" maxlength="140" onkeypress="return handleEnter(this, event)"/>
                        <div class="inputlabel2">Cth: Menghabiskan baki cuti tahunan</div>
                      </span></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Catatan *</td>
                      <td width="100%" colspan="3"><span id="Cutinote">
                      <span class="textareaMaxCharsMsg">Melebihi 300 huruf.</span><span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                          <textarea name="userleavedate_note" required="required" id="userleavedate_note" cols="45" rows="5"></textarea>
                          <div class="txt_color1"><span id="countCutinote">&nbsp;</span> huruf</div>
                      </span></td>
                    </tr>
                    <tr>
                      <td class="noline">
                      <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" />
                      <input name="leavetype_id" type="hidden" id="leavetype_id" value="1" />
                      <input name="userleavedate_head" type="hidden" id="userleavedate_head" value="<?php echo getHeadIDByUserID($row_user['user_stafid']);?>" />
<input type="hidden" name="MM_insert_leavedate" value="formleavedate" /></td>
                      <td colspan="3" class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Hantar" /></td>
                    </tr>
                  </table>
                </li>
                <li class="line_t">
                <div class="note">
                    <div>Perhatian :</div>
                    <div>
                        <ol>
                            <li>Borang ini hanya untuk permohonan Cuti Rehat / Tahunan sahaja. Untuk Cuti Sakit, Cuti Bersalin, Cuti Tanpa Gaji, dan Cuti Tanpa Rekod, sila berhubung dengan <?php echo $adname;?>.</li>
                            <li>Permohonan Cuti Rehat / Tahunan yang lambat dihantar ( selepas <?php echo date('d/m/Y');?> ) akan dikira sebagai Cuti Kecemasan (EL).</li><li>Cuti keluar negara (secara peribadi / agensi ) perlu mengisi Borang Lawatan Keluar Negara daripada <?php echo $adname;?>.</li>
                       </ol>
                    </div>
                </div>
                </li>
            </ul>
          </form>
          <?php } elseif($leaveform) { ?>
          <ul>
          	<li><div class="note"><img src="<?php echo $url_main;?>icon/sign_error.png" alt="Error" width="16" height="16" align="absbottom" /> &nbsp; Modul Cuti dalam proses kemaskini. Sila berhubung dengan <?php echo $adname;?> untuk maklumat lanjut.</div></li>
          </ul>
          <?php } else { ?>
          <ul>
          	<li><div class="note"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; <strong>Baki Cuti Rehat / Tahunan tidak mencukupi</strong> untuk permohonan cuti. Sila semak baki cuti dalam <strong>Laporan</strong> atau berhubung dengan <strong><?php echo $adname;?></strong> untuk maklumat lanjut.</div></li>
          </ul>
          <?php }; ?>
          <?php } else { ?>
          <ul>
          	<?php if(!checkAccBankByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>No. Akaun Bank</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkBankByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>Nama Bank</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkKWSPByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>No. KWSP</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkPERKESOByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>No. PERKESO</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; if(!checkAddressByStafID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>Alamat Terkini</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; if(!checkTelMByStafID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>No. Tel (Mobile)</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkWaris($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>Waris / Rujukan Kecemasan</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; if(!checkEdu($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>Rekod Pendidikan</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; ?>
          </ul>
          <?php }; ?>
          <?php } else { ?>
          <ul>
          	<li><div class="note"><img src="<?php echo $url_main;?>icon/sign_error.png" alt="Error" width="16" height="16" align="absbottom" /> &nbsp; Sistem dalam proses pengemaskinian dan penambahbaikkan.</div></li>
          </ul>
          <?php }; ?>
          </div>
        </div>
        <?php echo noteHR('1'); ?>
        <?php echo noteFooter('1'); ?>
        <?php echo noteEmail('1'); ?>
</div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("totaldayselected", {isRequired:false, minSelections:1, maxSelections:<?php echo countLeaveBalance($row_user['user_stafid'],date('Y'));?>, validateOn:["change"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("tajuk");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("Cutinote", {counterId:"countCutinote", counterType:"chars_remaining", maxChars:300});
</script>
</body>
</html>
<?php
mysql_free_result($cutitype);

mysql_free_result($cutikategori);
?>
<?php include('../inc/footinc.php');?>
