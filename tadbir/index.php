<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='9';?>
<?php $menu2='38';?>
<?php
	if(isset($_GET['hall']))
		$hall = htmlspecialchars($_GET['hall'], ENT_QUOTES);
	else
		$hall = '1';
		
	if(isset($_GET['bulan'])) 
	{
		$datec = explode("/", htmlspecialchars($_GET['bulan'], ENT_QUOTES));
	} else {
		$datec[0] = date('m');
		$datec[1] = date('Y');
	}
?>
<?php
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_hallist = "SELECT * FROM hall WHERE hall_status = 1 ORDER BY halltype_id ASC, hall_name ASC";
$hallist = mysql_query($query_hallist, $tadbirdb) or die(mysql_error());
$row_hallist = mysql_fetch_assoc($hallist);
$totalRows_hallist = mysql_num_rows($hallist);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script language="javascript">
function color(newC, newR) {
		tmp = document.getElementById(newC);
		if(document.getElementById(newR).checked)
		{
			tmp.style.background = "#FC0";
			tmp.checked = true;
		} else {
			tmp.style.background = "white";
			tmp.checked = false;
		}
	}

function checkForm(form)
{
	form.button4.disabled=true;
	form.button4.value="Proses...";
	return true;
}
</script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
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
            <ul>
            <?php if(!$maintenance){?>
                <li class="form_back">
                <form id="form1" name="form1" method="get" action="index.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label noline">Lokasi</td>
                      <td class="noline">
                        <select name="hall" id="hall" required="required" >
                          <?php
							do {  
							?>
							<option value="" selected disabled hidden>*SILA PILIH</option>
                          <option <?php if($hall==$row_hallist['hall_id']) echo "selected=\"selected\"";?> value="<?php echo $row_hallist['hall_id']?>"><?php echo getHallName($row_hallist['hall_id']); ?></option>
                          <?php
							} while ($row_hallist = mysql_fetch_assoc($hallist));
							  $rows = mysql_num_rows($hallist);
							  if($rows > 0) {
								  mysql_data_seek($hallist, 0);
								  $row_hallist = mysql_fetch_assoc($hallist);
							  }
							?>
                        </select>
                      </td>




                      
                      <td class="label noline">Bulan/Tahun</td>
                      <td width="100%" class="noline">
                      <select name="bulan" id="bulan">
                        <?php for($i=(date('m')-2); $i<=(date('m')+2); $i++){?>
                        <option <?php if($datec['0']==date('m', mktime(0, 0, 0, $i, 1, date('Y')))) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $i, 1, date('Y')));?>"><?php echo date('F Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>
                        <?php }; ?>
                      </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" />
                      </td>
                    </tr>
                  </table>
                </form>
                </li>
                <li>
                


		<?php
			if($_GET['hall'] != ''){

		 ?>
                <div id="paparborang">
                <div class="note">Borang Tempahan Dewan / Bilik </div>

                <div class="note">Lokasi : <strong><?php echo getHallName($hall);?></strong></div>
                <div class="note">1. Pilih Tarikh dan Sesi</div>
                
                <form id="tarikh" name="tarikh" method="POST" action="../sb/add_hallbook.php" onsubmit="return checkForm(this) && true;">
                <span id="tarikhpilih">
                <span class="checkboxMinSelectionsMsg"><div class="passbox_form2">Sila pilih satu sesi untuk tempahan.</div></span>
                <?php 
				 //This gets today's date 
				
				 $date =time () ; 
				
				 //This puts the day, month, and year in seperate variables 
				
				 $day = date('d', mktime(0, 0, 0, $datec[0], 1, $datec[1])) ; 
				
				 $month = date('m', mktime(0, 0, 0, $datec[0], 1, $datec[1])) ; 
				
				 $year = date('Y', mktime(0, 0, 0, $datec[0], 1, $datec[1])) ;
				
				
				
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
				
				//Here we start building the table heads 
				echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"cal line_b line_t line_l line_r\">";
				echo "<tr><td colspan=7 class=\"title txt_size3\" align=\"center\"><strong>$title $year</strong></td></tr>";
				echo "<tr><td class=\"txt_color1 line_r line_b3\" align=\"center\">Ahad</td><td class=\"line_r line_b3\" align=\"center\">Isnin</td><td class=\"line_r line_b3\" align=\"center\">Selasa</td><td class=\"line_r line_b3\" align=\"center\">Rabu</td><td class=\"line_r line_b3\" align=\"center\">Khamis</td><td class=\"line_r line_b3\" align=\"center\">Jumaat</td><td class=\"txt_color1 line_r line_b3\" align=\"center\">Sabtu</td></tr>";
				
				
				
				 //This counts the days in the week, up to 7
				
				 $day_count = 1;
				
				
				
				 echo "<tr>";
				
				 //first we take care of those blank days
				
				 while ( $blank > 0 ) 
				
				 { 
				
				 echo "<td class=\"line_r\">&nbsp;</td>"; 
				
				 $blank = $blank-1; 
				
				 $day_count++;
				
				 } 
				
				//sets the first day of the month to 1 
				
				 $day_num = 1;
				
				
				
				 //count up the days, untill we've done all of them in the month
				
				 while ( $day_num <= $days_in_month ) 
				
				 { 
				
				 echo "<td align=\"left\" valign=\"top\" class=\"txt_color1 line_r\" style=\"height:100px;\"><div class=\"hari\">";
					
				 echo $day_num; // paparan tarikh
				 
				 if($day_num == date('d') && $month == date('m'))
				 	echo " - Kini "; 
					
				 echo "</div>";
				 
				 $char = 30; // bil huruf utk view dlm calendar
				 
				 if(checkHallByDate($day_num, $month, $year, $hall, 1, 0, 0))
				 {
					echo "<div class=\"passbox_back hidden2\" id=\"hall" . getBookingID(0, $hall, $day_num, $month, $year, 1, 0, 0) . "\">";
					echo "<div class=\"passbox_form\">";
						echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
						  echo "<tr>";
							echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year)) . " : Sesi Pagi</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white label\">Lokasi</td>";
							echo "<td nowrap=\"nowrap\" class=\"back_white\" width=\"100%\">" . getHallName($hall) . "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white label\">Tajuk</td>";
							echo "<td  class=\"back_white\" width=\"100%\">" . getBookName($day_num, $month, $year, $hall, 1, 0, 0) . "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white label\">Oleh</td>";
							echo "<td  class=\"back_white\" width=\"100%\"><div><b>" . getFullNameByStafID(getBookingBy(getBookingID(0, $hall, $day_num, $month, $year, 1, 0, 0))) . "</b></div><div>" . getFulldirectoryByUserID(getBookingBy(getBookingID(0, $hall, $day_num, $month, $year, 1, 0, 0))) . "</div></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white\">&nbsp;</td>";
							echo "<td class=\"back_white\" width=\"100%\">";
							echo "<input type=\"button\" name=\"button2\" id=\"button2\" value=\"OK\" class=\"submitbutton\" onclick=\"toggleview2('hall" . getBookingID(0, $hall, $day_num, $month, $year, 1, 0, 0) . "'); return false;\" />";
							echo "</td>";
						echo "</tr>";
					  echo "</table>";
					echo "</div>";
					echo "</div>";
				 	echo "<div class=\"pagi cursorpoint\" onclick=\"toggleview2('hall" . getBookingID(0, $hall, $day_num, $month, $year, 1, 0, 0) . "'); return false;\">";					
					echo substr(getBookName($day_num, $month, $year, $hall, 1, 0, 0), 0, $char);
					if(strlen(getBookName($day_num, $month, $year, $hall, 1, 0, 0))>$char) echo "...";
					echo "</div>";
				 } elseif(((date('d')<=$day_num && date('m')==$month && date('Y')==$year) || (date('m')<$month && date('Y')==$year)) || (date('Y')<$year)) {
					 echo "<div class=\"nobook\" id=\"C0" . $day_num . $month . "\">";
				 
					 if(!checkHallFullBook($day_num, $month, $year, $hall)) //&& (($day_num>=date('d') && $month == date('m'))||($month>date('m') && $year>=date('Y'))))
					 {
						echo "<input ";
						
						//if($day_num == date('d') && $month == date('m'))
						//	echo "checked=\"checked\"";
						
						echo " class=\"w10\" id=\"R0" . $day_num . $month . "\" onclick=\"color('C0" . $day_num . $month . "', 'R0" . $day_num . $month . "')\" name=\"hallbook[]\" type=\"checkbox\" value=\"" . $day_num . "/" . $month . "/" . $year . "/1\" />";
					 }
					 
					 echo " &nbsp; Pagi </div>";
				 }
				 
				 if(checkHallByDate($day_num, $month, $year, $hall, 0, 1, 0))
				 {
					echo "<div class=\"passbox_back hidden2\" id=\"hall" . getBookingID(0, $hall, $day_num, $month, $year, 0, 1, 0) . "\">";
					echo "<div class=\"passbox_form\">";
						echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
						  echo "<tr>";
							echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year)) . " : Sesi Petang</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white label\">Lokasi</td>";
							echo "<td nowrap=\"nowrap\" class=\"back_white\" width=\"100%\">" . getHallName($hall) . "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white label\">Tajuk</td>";
							echo "<td  class=\"back_white\" width=\"100%\">" . getBookName($day_num, $month, $year, $hall, 0, 1, 0) . "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white label\">Oleh</td>";
							echo "<td  class=\"back_white\" width=\"100%\"><div><b>" . getFullNameByStafID(getBookingBy(getBookingID(0, $hall, $day_num, $month, $year, 0, 1, 0))) . "</b></div><div>" . getFulldirectoryByUserID(getBookingBy(getBookingID(0, $hall, $day_num, $month, $year, 0, 1, 0))) . "</div></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white\">&nbsp;</td>";
							echo "<td class=\"back_white\" width=\"100%\">";
							echo "<input type=\"button\" name=\"button2\" id=\"button2\" value=\"OK\" class=\"submitbutton\" onclick=\"toggleview2('hall" . getBookingID(0, $hall, $day_num, $month, $year, 0, 1, 0) . "'); return false;\" />";
							echo "</td>";
						echo "</tr>";
					  echo "</table>";
					echo "</div>";
					echo "</div>";
				 	echo "<div class=\"petang cursorpoint\" onclick=\"toggleview2('hall" . getBookingID(0, $hall, $day_num, $month, $year, 0, 1, 0) . "'); return false;\">";
					echo substr(getBookName($day_num, $month, $year, $hall, 0, 1, 0), 0, $char);
					if(strlen(getBookName($day_num, $month, $year, $hall, 0, 1, 0))>$char) echo "...";
					echo "</div>";
				 } elseif(((date('d')<=$day_num && date('m')==$month && date('Y')==$year) || (date('m')<$month && date('Y')==$year)) || (date('Y')<$year)) {
					 echo "<div class=\"nobook\" id=\"C1" . $day_num . $month . "\">";
				 
					 if(!checkHallFullBook($day_num, $month, $year, $hall)) //&& (($day_num>=date('d') && $month == date('m'))||($month>date('m') && $year>=date('Y'))))
					 {
						echo "<input ";
						
						//if($day_num == date('d') && $month == date('m'))
						//	echo "checked=\"checked\"";
						
						echo " class=\"w10\" id=\"R1" . $day_num . $month . "\" onclick=\"color('C1" . $day_num . $month . "', 'R1" . $day_num . $month . "')\" name=\"hallbook[]\" type=\"checkbox\" value=\"" . $day_num . "/" . $month . "/" . $year . "/2\" />";
					 }
					 echo " &nbsp; Petang</div>";
				 }
				 
				 if(checkHallByDate($day_num, $month, $year, $hall, 0, 0, 1))
				 {
					echo "<div class=\"passbox_back hidden2\" id=\"hall" . getBookingID(0, $hall, $day_num, $month, $year, 0, 0, 1) . "\">";
					echo "<div class=\"passbox_form\">";
						echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
						  echo "<tr>";
							echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year)) . " : Sesi Malam</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white label\">Lokasi</td>";
							echo "<td nowrap=\"nowrap\" class=\"back_white\" width=\"100%\">" . getHallName($hall) . "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white label\">Tajuk</td>";
							echo "<td  class=\"back_white\" width=\"100%\">" . getBookName($day_num, $month, $year, $hall, 0, 0, 1) . "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white label\">Oleh</td>";
							echo "<td  class=\"back_white\" width=\"100%\"><div><b>" . getFullNameByStafID(getBookingBy(getBookingID(0, $hall, $day_num, $month, $year, 0, 0, 1))) . "</b></div><div>" . getFulldirectoryByUserID(getBookingBy(getBookingID(0, $hall, $day_num, $month, $year, 0, 0, 1))) . "</div></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td  class=\"back_white\">&nbsp;</td>";
							echo "<td class=\"back_white\" width=\"100%\">";
							echo "<input type=\"button\" name=\"button2\" id=\"button2\" value=\"OK\" class=\"submitbutton\" onclick=\"toggleview2('hall" . getBookingID(0, $hall, $day_num, $month, $year, 0, 0, 1) . "'); return false;\" />";
							echo "</td>";
						echo "</tr>";
					  echo "</table>";
					echo "</div>";
					echo "</div>";
				 	echo "<div class=\"malam cursorpoint\" onclick=\"toggleview2('hall" . getBookingID(0, $hall, $day_num, $month, $year, 0, 0, 1) . "'); return false;\">";
					echo substr(getBookName($day_num, $month, $year, $hall, 0, 0, 1), 0, $char);
					if(strlen(getBookName($day_num, $month, $year, $hall, 0, 0, 1))>$char) echo "...";
					echo "</div>";
				 } elseif(((date('d')<=$day_num && date('m')==$month && date('Y')==$year) || (date('m')<$month && date('Y')==$year)) || (date('Y')<$year)) {
					 echo "<div class=\"nobook\" id=\"C2" . $day_num . $month . "\">";
				 
					 if(!checkHallFullBook($day_num, $month, $year, $hall)) //&& (($day_num>=date('d') && $month == date('m'))||($month>date('m') && $year>=date('Y'))))
					 {
						echo "<input ";
						
						//if($day_num == date('d') && $month == date('m'))
						//	echo "checked=\"checked\"";
						
						echo " class=\"w10\" id=\"R2" . $day_num . $month . "\" onclick=\"color('C2" . $day_num . $month . "', 'R2" . $day_num . $month . "')\" name=\"hallbook[]\" type=\"checkbox\" value=\"" . $day_num . "/" . $month . "/" . $year . "/3\" />";
					 }
					 echo " &nbsp; Malam</div>";
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
				
				 echo "<td> </td>"; 
				
				 $day_count++; 
				
				 } 
				
				 
				 echo "</tr></table>"; 
				 ?>
                 </span>
                 <div class="note">2. Isi maklumat berikut </div>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                     <td nowrap="nowrap" class="label">Lokasi</td>
                     <td width="100%"><strong><?php echo getHallName($hall);?></strong>
                       <input name="hall_id" type="hidden" id="hall_id" value="<?php echo $hall;?>" /></td>
                   </tr>
                   <tr>
                     <td nowrap="nowrap" class="label">Tajuk *</td>
                     <td>
                   <span id="tujuan"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                       <input type="text" required="required" name="hallbook_name" id="hallbook_name" />
                     </span></td>
                   </tr>
                   <tr>
                     <td nowrap="nowrap" class="label">Catatan *</td>
                     <td>
                     <span id="note"><span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                       <textarea required="required" name="hallbook_detail" id="hallbook_detail" cols="45" rows="7"></textarea>
                     </span>
                     </td>
                   </tr>
               </div>
                   <tr>
                     <td>&nbsp;</td>
                     <td>
                     <span id="sah"><span class="checkboxRequiredMsg"><div>Sila buat pengesahan berikut.</div></span>
                     <div><input name="nafi" type="checkbox" class="w5" id="nafi" value="1" /></div>
                     <div class="txt_line">
                      Saya mengesahkan setiap maklumat yang diberi adalah benar dan bertanggungjawab terhadap setiap peralatan dan dewan berada dalam keadaan baik setelah menamatkan program. <?php echo getDirSubName(getDirIDByMenuID($menu));?> berhak untuk menukar atau membatalkan tempahan dewan / bilik tanpa sebarang notis.
                      </div>
                     </span></td>
                   </tr>
                   <tr>
                     <td class="noline"><input type="hidden" name="MM_insert" value="tarikh"></td>
                     <td class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tempah" /></td>
                   </tr>
                 </table>
                </form>
                </li>
                <li class="line_t">
                	<?php } ?>
                <div class="note txt_line">
                    <div>Perhatian :</div>
                    <div>
                        <ol>
                            <li>Tempahan Dewan / Bilik ini hanya boleh digunapakai oleh kakaitangan MSN untuk tujuan dalaman sahaja. Sebarang tempahan daripada pihak luar perlu berhubung dengan <?php echo getDirSubName(getDirIDByMenuID($menu));?> dengan mengemukakan surat rasmi.</li>
                            <li>Jika terdapat Tempahan Penggunaan yang lebih penting, pihak <?php echo getDirSubName(getDirIDByMenuID($menu));?> berhak membatalkan tempahan tuan/puan dengan makluman Email/Panggilan Telefon.</li>
                            <li>Segala permasalahan atau maklum balas, sila berhubung dengan <?php echo getDirSubName(getDirIDByMenuID($menu));?>.</li>
                            <li>Sesi Pagi bermula 8.00 pg hingga 1.00 tgh, Sesi Petang bermula 2.00 ptg hingga 5.30 ptg.</li>
                            <li>Kakitangan boleh memilih lebih daripada satu (1) sesi dan lebih daripada satu (1) hari bagi satu tempahan.</li>
                       </ol>
                    </div>
                </div>
                </li>
		
                <?php } else { ?>
                <li>
                <div class="note">Sistem dalam proses pengemaskinian dan penambahbaikkan buat sementara waktu</div>
                </li>
                <?php }; ?>
            </ul>
            </div>
        </div>
        <?php echo noteFooter('1');?>
        <?php echo noteEmail('1');?>
        <?php echo noteMade($menu);?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("tujuan");
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("tarikhpilih", {isRequired:false, minSelections:1});
var sprycheckbox2 = new Spry.Widget.ValidationCheckbox("sah");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("note", {hint:"Masa dan Maklumat berkaitan :"});
</script>
</body>
</html>
<?php
mysql_free_result($hallist);
?>
<?php include('../inc/footinc.php');?> 