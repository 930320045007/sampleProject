<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='3';?>
<?php $menu2='109';?>
<?php
$wsql = "";
if(isset($_POST['bulanCawangan']))
{
	$dateCawangan = explode("/", $_POST['bulanCawangan']);
} else {
	$dateCawangan[0] = htmlspecialchars(date('m'), ENT_QUOTES);
	$dateCawangan[1] = htmlspecialchars(date('Y'), ENT_QUOTES);
};
if(isset($_POST['bulan']))
{
	$datec = explode("/", $_POST['bulan']);
}else if(isset($_GET['bulan']))
{
	$datec = explode("/", $_GET['bulan']);
} else {
	$datec[0] = htmlspecialchars(date('m'), ENT_QUOTES);
	$datec[1] = htmlspecialchars(date('Y'), ENT_QUOTES);
};

//if($_SESSION['user_stafid'] != null)
//{
//	$id = $_SESSION['user_stafid'];
//	$sql_user = "";	
//	$sql_where = "";
//	
//	$sql_user = getDirIDByUser($row_user['user_stafid']);
//	
//	function checkSubDir(&$dir, $id){
//		//get all low level 
//		$query_ss = "SELECT * FROM www.dir WHERE dir_sub = ".$id." AND dir_status=1";
//		$dir_ss = mysql_query($query_ss) or die(mysql_error());
//	
//		while ($row = mysql_fetch_array($dir_ss)) {
//			$dir[] = $row['dir_id'];
//	    	checkSubDir($dir, $row['dir_id']);
//		}
//	}
//	
//	function recursiveDirID($dirID){	
//		$dir = array();		
//		checkSubDir($dir, $dirID);
//		return $dir;
//	}
//
//	$dir = recursiveDirID($sql_user);
//
//	foreach($dir as $id){
//		$sql_where .= " OR dir_id = '".$id."'";
//	}
	
	//print back own user dir
	 if(getDirTypeByDirID(getDirIDByUser($row_user['user_stafid']))=='1')
	 {
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_dirsub = "SELECT * FROM dir WHERE dir_status='1' AND dir_id = '" . getDirIDByUser($row_user['user_stafid']) . "' OR dir_sub = '".getDirIDByUser($row_user['user_stafid'])."' ORDER BY dir_type ASC, dir_name ASC";
	$dirsub = mysql_query($query_dirsub, $hrmsdb) or die(mysql_error());
	$row_dirsub = mysql_fetch_assoc($dirsub);
	$totalRows_dirsub = mysql_num_rows($dirsub);
}
if(getDirTypeByDirID(getDirIDByUser($row_user['user_stafid']))!='1')
	 {
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_dirsub = "SELECT * FROM dir WHERE dir_status ='1' AND (dir_sub = '" . getDirSubIDByUser($row_user['user_stafid']) . "' OR dir_id = '".getDirSubIDByUser($row_user['user_stafid'])."') OR dir_sub ='".getDirIDByUser($row_user['user_stafid'])."' ORDER BY dir_type ASC, dir_name ASC";
	$dirsub = mysql_query($query_dirsub, $hrmsdb) or die(mysql_error());
	$row_dirsub = mysql_fetch_assoc($dirsub);
	$totalRows_dirsub = mysql_num_rows($dirsub);
}
?>
<?php
	$sql_where = "";
	if(isset($_POST['cpu']))
		$sql_where .= " user_unit.dir_id = '" . htmlspecialchars($_POST['cpu'], ENT_QUOTES) . "' AND login.login_status = 1";
	else {
		$sql_where .= " user_unit.dir_id = '" . $row_dirsub['dir_id'] . "' AND login.login_status = 1";
	}
	
	$sql_where;
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_userunit = sqlAllStaf($sql_where);
	$userunit = mysql_query($query_userunit, $hrmsdb) or die(mysql_error());
	$row_userunit = mysql_fetch_assoc($userunit);
	$totalRows_userunit = mysql_num_rows($userunit);

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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
          <?php if(!$leaveform){?>
          <ul>
          <li class="form_back">
            <ul>              
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <form id="form1" name="form1" method="post" action="pergerakan.php">
                  <tr>
                    <td class="label">Cawangan/Bahagian</td>
                    <td width="100%"><select name="cpu" id="cpu">
                        <?php
						do {  
						?>
                        <option <?php if(isset($_POST['cpu']) && $_POST['cpu']==$row_dirsub['dir_id']) echo "selected=\"selected\"";?> value="<?php echo $row_dirsub['dir_id']?>"><?php echo getFulldirectory($row_dirsub['dir_id'], 0);?></option>
                        <?php
						} while ($row_dirsub = mysql_fetch_assoc($dirsub));
							$rows = mysql_num_rows($dirsub);
							if($rows > 0) {
								mysql_data_seek($dirsub, 0);
								$row_dirsub = mysql_fetch_assoc($dirsub);
							}
						?>
                      </select>
                      <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      <?php if(isset($_POST["cpu"]) && $totalRows_userunit > 0){
                      echo "<td><input name=\"button3\" type=\"button\" class=\"submitbutton\" id=\"btnExport\" value=\"Export to excel (xls)\" onclick=window.open(\"exportpergerakan.php?cpu=". $_POST['cpu'] ."&bulan=" .( isset($_POST['bulanCawangan']) ? $_POST['bulanCawangan'] : date('m/Y', mktime(0, 0, 0, date('m'), 1, date('Y'))))."\");></td>";
					  } ?>
                  </tr>
                  <?php	if(isset($_POST["cpu"]) && $totalRows_userunit > 0){ ?>
                  <tr class="form_back">
                    <td class="label noline">Bulan/Tahun</td>
                    <td class="noline"><select name="bulanCawangan" id="bulanCawangan">
                        <?php for($i=(date('m')-2); $i<=(date('m')+2); $i++){?>
                        <option <?php if($dateCawangan['0']==date('m', mktime(0, 0, 0, $i, 1, date('Y')))) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $i, 1, date('Y')));?>"><?php echo date('F Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>
                        <?php }; ?>
                      </select>
                      <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      <td></td>
                  </tr>
                  <?php }; ?>
                </form>
              </table>
              <?php 
			  if( $_SESSION['user_stafid'] != null && isset($_POST["cpu"])){
			  ?>
              <li>
                <div class="note">Senarai staf dibawah <?php echo getFulldirectory($_POST['cpu']);?></div>
                <div class="off2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="TablePergerakan">
                    <?php
					$id = $row_dirsub['dir_id'];
					if ($totalRows_userunit > 0) { // Show if recordset not empty
					
					//This gets today's date 
					$date =time();
				
					//This puts the day, month, and year in seperate variables
					$day = date('d', $date); 
					if(isset($_POST['bulanCawangan']))
					{
						$month = $dateCawangan[0];
						$year = $dateCawangan[1];
					} else {
						$month = date('m', $date); 
						$year = date('Y', $date);
					}
					 
					if(strlen($month) < 2){
						$month = '0' . $month;
					}
							 
					if($month > 12)
					{
						$month = '1';
						$year = date('Y', $date);
					}
					
					if($year == date('Y'))
					{
						//Here we generate the first day of the month 
						$first_day = mktime(0,0,0,$month, 1, $year) ; 
								
						//This gets us the month name 					
						$title = date('F', $first_day) ; 
						 
						//Here we find out what day of the week the first day of the month falls on 
						$day_of_week = date('D', $first_day) ; 
													 
						//We then determine how many days are in the current month
						$days_in_month = cal_days_in_month(0, $month, $year) ; 
							
						//This counts the days in the week, up to 7
						$day_count = 1;
						
						echo "<tr><th colspan=". ($days_in_month + 2) ." class=\"title txt_size3\" align=\"center\"><strong>$title $year</strong></th></tr>";					 
					?>
                    <tr>
                    	<th class="back_lightgrey line_r">Bil</th>
                    	<th width="100%" class="back_lightgrey line_r" align="left" valign="middle">Nama / Jawatan</th>
                     	<?php
					 	//sets the first day of the month to 1 
						$day_num = 1;
						
						//count up the days, untill we've done all of them in the month
						while ( $day_num <= $days_in_month )
						{	
							if($day_num<10)
							$day_num = '0' . $day_num;						
							
							if(checkHoliday($day_num, $month, $year, $id))
							{
								echo "<th align=\"center\" class=\"back_lightgrey line_r\"> " . $day_num . "</th>"; 
							} 
							else if(!checkStateWeekendByDate($id, $day_num, $month, $year))
							{
								echo "<th align=\"center\" class=\"back_lightgrey line_r\"> $day_num </th>"; 
							}
							else
							{
								echo "<th align=\"center\" class=\"line_r\" id=\"CC" . $day_num . $month . "\">";
								echo $day_num;
								echo "</th>";
							}					
							$day_num++; 
							$day_count++;							 
						}				
					?>
                    </tr>
                    <?php $i=1; do { ?>
                    <tr class="on">
                      <td align="center" class="back_lightgrey line_r" valign="middle"><?php echo $i;?></td>
                      <td align="center" class="back_lightgrey line_r">
                        <div class="txt_line"><?php echo getFullNameByStafID($row_userunit['user_stafid']); ?></div></td>
                      <?php
						//sets the first day of the month to 1 
						$day_num = 1;
						
						//for every staff from database
						$id = $row_userunit['user_stafid'];
						
						//count up the days, untill we've done all of them in the month
						while ( $day_num <= $days_in_month )
						{	
							if($day_num<10)
								$day_num = '0' . $day_num;
											
							if(checkHoliday($day_num, $month, $year, $id))
							{
								echo "<td align=\"center\" class=\"back_lightgrey txt_color1 line_r\"> " . getHolidayName($day_num, $month, $year) . "</td>";
							} 
							else if(!checkStateWeekendByDate($id, $day_num, $month, $year))
							{
								echo "<td align=\"center\" class=\"back_lightgrey txt_color1 line_r\">weekend</td>"; 
							}
							else if(getLeaveID($id, 1, $day_num, $month, $year))
							{
								echo "<td class=\"backch line_r\" style=\"background-color:#9C0;\">";
								echo "<div class=\"hari\">";
								echo "<div class=\"passbox_back hidden2\" id=\"Leave" . getLeaveID($id, 1, $day_num, $month, $year) . "\">";
								echo "<div class=\"passbox_form\">";
								echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
								echo "<tr>";
								echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year)) . "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td nowrap=\"nowrap\" class=\"back_white label\">Perkara</td>";
								echo "<td class=\"back_white\" width=\"100%\">" .  getLeaveTitle($id, 1, $day_num, $month, $year, getLeaveID($id, 1, $day_num, $month, $year)) . "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td nowrap=\"nowrap\" class=\"back_white label\">Catatan</td>";
								echo "<td class=\"back_white\" width=\"100%\">" .  getLeaveNote($id, 1, $day_num, $month, $year, getLeaveID($id, 1, $day_num, $month, $year)) . "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td class=\"back_white\">&nbsp;</td>";
								echo "<td class=\"back_white\" width=\"100%\">";
								echo "<input type=\"button\" name=\"button2\" id=\"button2\" value=\"OK\" class=\"submitbutton\" onclick=\"toggleview2('Leave" . getLeaveID($id, 1, $day_num, $month, $year) . "'); return false;\" />";
								echo "</td>";
								echo "</tr>";
								echo "</table>";
								echo "</div>";
								echo "</div>";
								echo "<div class=\"txt_color1 cursorpoint\" onclick=\"toggleview2('Leave" . getLeaveID($id, 1, $day_num, $month, $year) . "'); return false;\">";					
								echo shortText(getLeaveTitle($id, 1, $day_num, $month, $year), 20) . " &nbsp; &nbsp; ";
								echo viewIconLeave($id, getLeaveID($id, 0, $day_num, $month, $year), 0, $day_num, $month, $year);
								echo "</td>";
							 }
							 else if(checkLeaveOfficeByDate($id, $day_num, $month, $year) == 1)
							 {
								 $leaveofficeID = getNewLeaveOfficeIDByDate($id, 0, $day_num, $month, $year);
								 echo "<td class=\"backch line_r\" style=\"background-color:#9C0;\">";
								 $char = 30; // bil huruf utk view dlm calendar
								 echo "<div class=\"hari\">";						
								 echo "<div class=\"passbox_back hidden2\" id=\"LeaveOffice" . $leaveofficeID . "\">";
								 echo "<div class=\"passbox_form\">";
								 echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
								 echo "<tr>";
								 echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year)) . "</td>";
								 echo "</tr>";
								 if(getReasonType(getReasonByLeaveOfficeID($leaveofficeID))=='0'){
									 echo "<tr>";
									 echo "<td nowrap=\"nowrap\" class=\"back_white label\">Masa</td>";
									 echo "<td class=\"back_white\" width=\"100%\">" .  getTimeLeaveByLeaveOfficeID($leaveofficeID) . " &nbsp; hingga &nbsp; " . getTimeBackByLeaveOfficeID($leaveofficeID) . "</td>";
									 echo "</tr>";
								 }
								 elseif(getReasonType(getReasonByLeaveOfficeID($leaveofficeID))=='1'){
									 echo "<tr>";
									 echo "<td nowrap=\"nowrap\" class=\"back_white label\">Tempoh</td>";
									 echo "<td class=\"back_white\" width=\"100%\">" .  getLeaveOfficeDayByLeaveOfficeID($leaveofficeID) . getDayType(getLeaveOfficeDayTypeByLeaveOfficeID($leaveofficeID)) . "</td>";
									 echo "</tr>";
								 }
								 echo "<tr>";
								 echo "<td nowrap=\"nowrap\" class=\"back_white label\">Sebab</td>";
								 echo "<td class=\"back_white\" width=\"100%\">" . getReasonNameByID(getReasonByLeaveOfficeID($leaveofficeID)) . "</td>";
								 echo "</tr>";
								 echo "<tr>";
								 echo "<td nowrap=\"nowrap\" class=\"back_white label\">Catatan</td>";
								 echo "<td class=\"back_white\" width=\"100%\">" . getLeaveNoteByLeaveOfficeID($leaveofficeID) . "</td>";
								 echo "</tr>";
								 echo "<tr>";
								 echo "<td class=\"back_white\">&nbsp;</td>";
								 echo "<td class=\"back_white\" width=\"100%\">";
								 echo "<input type=\"button\" name=\"button2\" id=\"button2\" value=\"OK\" class=\"submitbutton\" onclick=\"toggleview2('LeaveOffice" . $leaveofficeID . "'); return false;\" />";
								 echo "</td>";
								 echo "</tr>";
								 echo "</table>";
								 echo "</div>";
								 echo "</div>";
								 echo "<div class=\"txt_color1 cursorpoint\" onclick=\"toggleview2('LeaveOffice" . $leaveofficeID . "'); return false;\">";					
								 echo shortText(getLeaveNoteByLeaveOfficeID($leaveofficeID), 20) . " &nbsp; ";
								 iconApplyLeaveStatus($leaveofficeID);
								 echo "</td>";
							 }
							 else if(checkPergerakan($id, $day_num, $month, $year))
							 {								
								$pergerakanID = getPergerakanID($id, $day_num, $month, $year);
								echo "<td class=\"backch line_r\" style=\"background-color:#9C0;\">";					
								echo "<div class=\"passbox_back hidden2\" id=\"Pergerakan" . $pergerakanID . "\">";
								//edit toggle form
								echo "<div id='edit_lokasi". $pergerakanID . "' class=\"passbox_form\" hidden >";
								echo "<li>";
								echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
								echo "<tr>";
								echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year));
								if(!$maintenance && checkUserSysAcc($_SESSION['user_stafid'],7,101,3)){
									echo "<span class=\"fr add\" onclick=\"toggleview('edit_lokasi". $pergerakanID ."', 'form_lokasi". $pergerakanID ."'); return false;\">Kemaskini</span>";
							 	}								
								echo "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td nowrap=\"nowrap\"class=\"back_white label\">Lokasi</td>";
								echo "<td class=\"back_white\" width=\"100%\"><input name=\"lokasi_baru\" required=\"required\" type=\"text\" id=\"lokasi_baru".$pergerakanID."\" value='" . getPergerakanLocationByID($id, $day_num, $month, $year) . "'\>";
								echo "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td nowrap=\"nowrap\" class=\"back_white\"></td>";
								echo "<td class=\"back_white\" width=\"100%\">";
								echo "<input name=\"button\" type=\"button\" class=\"submitbutton\" id=\"button\" value=\"Kemaskini\" onclick=\"updatelocation(".$pergerakanID.");\" /><input name=\"button\" type=\"button\" class=\"cancelbutton\" id=\"button\" value=\"Batal\" onclick=\"toggleview('edit_lokasi". $pergerakanID ."','form_lokasi". $pergerakanID ."'); return false;\" />";
								echo "</td>";
								echo "</tr>";
								echo "</table>";
								echo "</li>";
								echo "</div>";
								//default display
								echo "<div id=\"form_lokasi". $pergerakanID ."\" class=\"passbox_form\">";
								echo "<li>";
								echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
								echo "<tr>";
								echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year));
								if(!$maintenance || checkUserSysAcc($_SESSION['user_stafid'],7,101,3)){
									echo "<span class=\"fr add\" onclick=\"toggleview('edit_lokasi". $pergerakanID ."','form_lokasi". $pergerakanID ."'); return false;\">Kemaskini</span>";
							 	}								
								echo "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td nowrap=\"nowrap\" class=\"back_white label\">Lokasi</td>";
								echo "<td class=\"back_white\" width=\"100%\">" . getPergerakanLocationByID($id, $day_num, $month, $year) . "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td class=\"back_white\">&nbsp;</td>";
								echo "<td class=\"back_white\" width=\"100%\">";
								echo "<input type=\"button\" name=\"button2\" id=\"button2\" value=\"OK\" class=\"submitbutton\" onclick=\"toggleview2('Pergerakan" . getPergerakanID($id, $day_num, $month, $year) . "'); return false;\" />";
								echo "</td>";
								echo "</tr>";
								echo "</table>";
								echo "</li>";
								echo "</div>";
								echo "</div>";
								echo "<div class=\"cursorpoint txt_color1\" onclick=\"toggleview2('Pergerakan" . getPergerakanID($id, $day_num, $month, $year) . "'); return false;\">";					
								echo shortText(getPergerakanLocationByID($id, $day_num, $month, $year), 20) . " &nbsp; ";
								echo "</td>";
						 	 }
							 else
							 {								
							 	echo "<td class=\"backch line_r\" align=\"center\" style=\"background-color:#FFFF33;\" >";
								if(checkUserSysAcc($_SESSION['user_stafid'],7,101,2)){
									echo "<form action=". $url_main ."sb/add_pergerakan.php name=\"new\" method=\"POST\" id=\"new\" >";
									echo "<div class=\"passbox_back hidden2\" id=\"New". $day_num.'/'.$month .'/'. $year."\">";
									echo "<div class=\"passbox_form\">";								
									echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
									echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year));								
									echo "</td>";
									echo "<tr>";
									echo "<td nowrap=\"nowrap\" class=\"back_white label\">Lokasi</td>";
									echo "<td class=\"back_white\" width=\"100%\"><input name=\"pergerakan_lokasi\" required=\"required\" type=\"text\" id=\"pergerakan_lokasi\" maxlength=\"140\" /></td>";
									echo "</tr>";
									echo "<tr>";
									echo "<td class=\"back_white\">&nbsp;</td>";
									echo "<td class=\"back_white\" width=\"100%\">";
									echo "<input name=\"button2\" type=\"submit\" class=\"submitbutton\" id=\"button2\" value=\"Hantar\" /><input name=\"button\" type=\"button\" class=\"cancelbutton\" id=\"button\" value=\"Batal\" onclick=\"toggleview2('New". $day_num .'/'. $month . '/'. $year ."'); return false;\" />";
									echo "</td>";
									echo "</tr>";
									echo "</table>";							
									echo "</div>";
									echo "</div>";
									echo "<input name=\"user_stafid\" type=\"hidden\" id=\"user_stafid\" value=". $id ." >";
									echo "<input name=\"listday[]\" type=\"hidden\" id=\"R" . $day_num . $month . "\" value=\"" . $day_num . "/" . $month . "\" >";
									echo "</form>";
									echo "<div class=\"cursorpoint txt_color1\" onclick=\"toggleview2('New". $day_num .'/'. $month . '/'. $year ."'); return false;\">";
									echo "<input type=\"checkbox\" />";
									echo "</div>";
								}
								echo "</td>";
								
							 }
							 $day_num++; 
							 $day_count++;
						}
					?>
                    </tr>
                    <?php $i++; } while ($row_userunit = mysql_fetch_assoc($userunit)); 
						}
                    } else { ?>
                    <tr>
                      <td colspan="7" align="center" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </div>
              </li>
              <?php }; ?>
            </ul>
          </li>
          <li>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	<form id="form1" name="form1" method="post" action="">
            	<tr class="form_back">
              	<td class="label noline">Bulan/Tahun</td>
              	<td class="noline"><select name="bulan" id="bulan">
                <?php for($i=(date('m')-2); $i<=(date('m')+2); $i++){?>
                	<option <?php if($datec['0']==date('m', mktime(0, 0, 0, $i, 1, date('Y')))) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $i, 1, date('Y')));?>"><?php echo date('F Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>
                <?php }; ?>
                	</select>
             	<input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
            	</tr>
          	</form>
          </table>          
          <div class="note">1. Sila pilih tarikh yang ingin permohonan *</div>
          <form action="<?php echo $url_main;?>sb/add_pergerakan.php" name="pergerakan" method="POST" id="pergerakan" >
            <span id="totaldayselected"> <span class="checkboxMinSelectionsMsg">
            <div class="passbox_form2">Sila pilih satu (1) hari.</div>
            </span>
            <?php
			//Reset $id to current session user id to always obtain current session user pergerakan.
			$id = $_SESSION['user_stafid'];
          	
			//This gets today's date 
		 	$date =time();
		  	for($i=0; $i<1; $i++)
			{
				//This puts the day, month, and year in seperate variables
				$day = date('d', $date); 
				if(isset($_POST['bulan']))
				{
					$month = $datec[0]+$i;
					$year = $datec[1];
				} else if(isset($_GET['bulan']))
				{
					$month = $datec[0]+$i;
					$year = $datec[1];
				} else {
					$month = date('m', $date)+$i; 
					$year = date('Y', $date);
				}
					 
				if(strlen($month) < 2){
					$month = '0' . $month;
				}
					 
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
								
							if(checkHoliday($day_num, $month, $year, $id))
							{
								echo "<td class=\"line_r\"> " . $day_num . " <br/> " . getHolidayName($day_num, $month, $year) . "</td>"; 
							} 
							else if(!checkStateWeekendByDate($id, $day_num, $month, $year))
							{
								echo "<td width='10%' class=\"back_lightgrey txt_color1 line_r\"> $day_num </td>"; 
							}
							else if(getLeaveID($id, 1, $day_num, $month, $year))
							{
								echo "<td width=\"16%\" class=\"line_r\">";
								echo "<div class=\"hari\">";
								echo "<div class=\"passbox_back hidden2\" id=\"Leave" . getLeaveID($id, 1, $day_num, $month, $year) . "\">";
								echo "<div class=\"passbox_form\">";
								echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
								echo "<tr>";
								echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year)) . "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td nowrap=\"nowrap\" class=\"back_white label\">Perkara</td>";
								echo "<td nowrap=\"nowrap\" class=\"back_white\" width=\"100%\">" .  getLeaveTitle($id, 1, $day_num, $month, $year, getLeaveID($id, 1, $day_num, $month, $year)) . "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td nowrap=\"nowrap\" class=\"back_white label\">Catatan</td>";
								echo "<td class=\"back_white\" width=\"100%\">" .  getLeaveNote($id, 1, $day_num, $month, $year, getLeaveID($id, 1, $day_num, $month, $year)) . "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td class=\"back_white\">&nbsp;</td>";
								echo "<td class=\"back_white\" width=\"100%\">";
								echo "<input type=\"button\" name=\"button2\" id=\"button2\" value=\"OK\" class=\"submitbutton\" onclick=\"toggleview2('Leave" . getLeaveID($id, 1, $day_num, $month, $year) . "'); return false;\" />";
								echo "</td>";
								echo "</tr>";
								echo "</table>";
								echo "</div>";
								echo "</div>";
								echo "<div class=\"txt_color1 cursorpoint\" onclick=\"toggleview2('Leave" . getLeaveID($id, 1, $day_num, $month, $year) . "'); return false;\">";					
								echo $day_num . " - " . shortText(getLeaveTitle($id, 1, $day_num, $month, $year), 20) . " &nbsp; &nbsp; ";
								echo viewIconLeave($id, getLeaveID($id, 0, $day_num, $month, $year), 0, $day_num, $month, $year);						
							 }
							 else if(checkLeaveOfficeByDate($id, $day_num, $month, $year) == 1)
							 {
								 $leaveofficeID = getNewLeaveOfficeIDByDate($id, 0, $day_num, $month, $year);
								 echo "<td width=\"16%\" class=\"backch line_r\">";
								 $char = 30; // bil huruf utk view dlm calendar
								 echo "<div class=\"hari\">";						
								 echo "<div class=\"passbox_back hidden2\" id=\"LeaveOffice" . $leaveofficeID . "\">";
								 echo "<div class=\"passbox_form\">";
								 echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
								 echo "<tr>";
								 echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year)) . "</td>";
								 echo "</tr>";
								 if(getReasonType(getReasonByLeaveOfficeID($leaveofficeID))=='0'){
									 echo "<tr>";
									 echo "<td class=\"back_white label\">Masa</td>";
									 echo "<td nowrap=\"nowrap\" class=\"back_white\" width=\"100%\">" .  getTimeLeaveByLeaveOfficeID($leaveofficeID) . " &nbsp; hingga &nbsp; " . getTimeBackByLeaveOfficeID($leaveofficeID) . "</td>";
									 echo "</tr>";
								 }
								 elseif(getReasonType(getReasonByLeaveOfficeID($leaveofficeID))=='1'){
									 echo "<tr>";
									 echo "<td class=\"back_white label\">Tempoh</td>";
									 echo "<td nowrap=\"nowrap\" class=\"back_white\" width=\"100%\">" .  getLeaveOfficeDayByLeaveOfficeID($leaveofficeID) . getDayType(getLeaveOfficeDayTypeByLeaveOfficeID($leaveofficeID)) . "</td>";
									 echo "</tr>";
								 }
								 echo "<tr>";
								 echo "<td class=\"back_white label\">Sebab</td>";
								 echo "<td nowrap=\"nowrap\" class=\"back_white\" width=\"100%\">" . getReasonNameByID(getReasonByLeaveOfficeID($leaveofficeID)) . "</td>";
								 echo "</tr>";
								 echo "<tr>";
								 echo "<td class=\"back_white label\">Catatan</td>";
								 echo "<td class=\"back_white\" width=\"100%\">" . getLeaveNoteByLeaveOfficeID($leaveofficeID) . "</td>";
								 echo "</tr>";
								 echo "<tr>";
								 echo "<td class=\"back_white\">&nbsp;</td>";
								 echo "<td class=\"back_white\" width=\"100%\">";
								 echo "<input type=\"button\" name=\"button2\" id=\"button2\" value=\"OK\" class=\"submitbutton\" onclick=\"toggleview2('LeaveOffice" . $leaveofficeID . "'); return false;\" />";
								 echo "</td>";
								 echo "</tr>";
								 echo "</table>";
								 echo "</div>";
								 echo "</div>";
								 echo "<div class=\"txt_color1 cursorpoint\" onclick=\"toggleview2('LeaveOffice" . $leaveofficeID . "'); return false;\">";					
								 echo $day_num . " - " . shortText(getLeaveNoteByLeaveOfficeID($leaveofficeID), 20) . " &nbsp; ";
								 iconApplyLeaveStatus($leaveofficeID);
							 }
							 else if(checkPergerakan($id, $day_num, $month, $year))
							 {								
								$pergerakanID = getPergerakanID($id, $day_num, $month, $year);
								echo "<td width=\"16%\" class=\"backch line_r\">";					
								echo "<div class=\"passbox_back hidden2\" id=\"Pergerakan" . $pergerakanID . "\">";
								//edit toggle form
								echo "<div id='edit_lokasi". $pergerakanID . "' class=\"passbox_form\" hidden >";
								echo "<li>";
								echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
								echo "<tr>";
								echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year));
								if(!$maintenance && $_SESSION['user_stafid'] == $id || checkUserSysAcc($id,7,101,3)){
									echo "<span class=\"fr add\" onclick=\"toggleview('edit_lokasi". $pergerakanID ."', 'form_lokasi". $pergerakanID ."'); return false;\">Kemaskini</span>";
							 	}								
								echo "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td nowrap=\"nowrap\"class=\"back_white label\">Lokasi</td>";
								echo "<td class=\"back_white\" width=\"100%\"><input name=\"lokasi_baru\" required=\"required\" type=\"text\" id=\"lokasi_baru".$pergerakanID."\" value='" . getPergerakanLocationByID($id, $day_num, $month, $year) . "'\>";
								echo "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td nowrap=\"nowrap\" class=\"back_white\"></td>";
								echo "<td class=\"back_white\" width=\"100%\">";
								echo "<input name=\"button\" type=\"button\" class=\"submitbutton\" id=\"button\" value=\"Kemaskini\" onclick=\"updatelocation(".$pergerakanID.");\" /><input name=\"button\" type=\"button\" class=\"cancelbutton\" id=\"button\" value=\"Batal\" onclick=\"toggleview('edit_lokasi". $pergerakanID ."','form_lokasi". $pergerakanID ."'); return false;\" />";
								echo "</td>";
								echo "</tr>";
								echo "</table>";
								echo "</li>";
								echo "</div>";
								//default display
								echo "<div id=\"form_lokasi". $pergerakanID ."\" class=\"passbox_form\">";
								echo "<li>";
								echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
								echo "<tr>";
								echo "<td colspan=\"2\" class=\"title noline\">" . date('d / m / Y (D)', mktime(0, 0, 0, $month, $day_num, $year));
								if(!$maintenance && $_SESSION['user_stafid'] == $id && $year==date('Y') && $month>date('m') || ($month==date('m') && $day_num >= date('d')) || checkUserSysAcc($id,7,101,3)){
									echo "<span class=\"fr add\" onclick=\"toggleview('edit_lokasi". $pergerakanID ."','form_lokasi". $pergerakanID ."'); return false;\">Kemaskini</span>";
							 	}								
								echo "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td nowrap=\"nowrap\" class=\"back_white label\">Lokasi</td>";
								echo "<td class=\"back_white\" width=\"100%\">" . getPergerakanLocationByID($id, $day_num, $month, $year) . "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td class=\"back_white\">&nbsp;</td>";
								echo "<td class=\"back_white\" width=\"100%\">";
								echo "<input type=\"button\" name=\"button2\" id=\"button2\" value=\"OK\" class=\"submitbutton\" onclick=\"toggleview2('Pergerakan" . getPergerakanID($id, $day_num, $month, $year) . "'); return false;\" />";
								echo "</td>";
								echo "</tr>";
								echo "</table>";
								echo "</li>";
								echo "</div>";
								echo "</div>";
								echo "<div class=\"txt_color1 cursorpoint\" onclick=\"toggleview2('Pergerakan" . getPergerakanID($id, $day_num, $month, $year) . "'); return false;\">";					
								echo $day_num . " - " . shortText(getPergerakanLocationByID($id, $day_num, $month, $year), 20) . " &nbsp; ";
								echo "</td>";
						 	 }
							 else if($year==date('Y') && $month==date('m') && $day_num < date('d') || $year==date('Y') && $month<date('m')) // check previous day
							 {
							 	echo "<td width=\"16%\" class=\"txt_color1 line_r\">" . $day_num;
								echo "</td>";
							 }
							 else
							 {
							 	echo "<td width=\"16%\" class=\"backch line_r\" id=\"C" . $day_num . $month . "\">";
								echo "<input class=\"w25\" onclick=\"color('C" . $day_num . $month . "', 'R" . $day_num . $month . "')\" name=\"listday[]\" type=\"checkbox\" id=\"R" . $day_num . $month . "\" value=\"" . $day_num . "/" . $month . "\"/>";
								echo $day_num;
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
				   } // tamat loop 1 bulan
				?>
            </span>
            <li>
              <?php if(!$maintenance){ ?>
              <div class="note">2. Sila isi maklumat dibawah</div>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td nowrap="nowrap" class="label">Lokasi  *</td>
                  <td width="100%" colspan="3"><label for="userleavestatus_name"></label>
                    <span id="tajuk"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                    <input name="pergerakan_lokasi" required="required" type="text" id="pergerakan_lokasi" maxlength="140" onkeypress="return handleEnter(this, event)"/>
                    <div class="inputlabel2">Cth: Dewan</div>
                    </span></td>
                </tr>
                <tr>
                  <td class="noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $id;?>" /></td>
                  <td colspan="3" class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Hantar" /></td>
                </tr>
              </table>
              <?php } ?>
            <li class="line_t">
              <div class="note">
                <div>Perhatian :</div>
                <div>
                  <ol>
                    <li>Borang ini hanya untuk kemaskini lokasi pergerakan sahaja. </li>
                  </ol>
                </div>
              </div>
            </li>
            </ul>
            <br/>
          </form>
          <?php } elseif($leaveform) { ?>
          <ul>
            <li>
              <div class="note"><img src="<?php echo $url_main;?>icon/sign_error.png" alt="Error" width="16" height="16" align="absbottom" /> &nbsp; Modul Cuti dalam proses kemaskini. Sila berhubung dengan <?php echo $adname;?> untuk maklumat lanjut.</div>
            </li>
          </ul>
          <?php } else { ?>
          <ul>
            <li>
              <div class="note"><img src="<?php echo $url_main;?>icon/sign_error.png" alt="Error" width="16" height="16" align="absbottom" /> &nbsp; Sistem dalam proses pengemaskinian dan penambahbaikkan.</div>
            </li>
          </ul>
          <?php }; ?>
        </div>
      </div>
      <?php echo noteHR('1'); ?> <?php echo noteFooter('1'); ?> <?php echo noteEmail('1'); ?> </div>
    <?php include('../inc/footer.php');?>
  </div>
</div>
<script type="text/javascript">
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("totaldayselected", {isRequired:false, minSelections:1, maxSelections:<?php echo countLeaveBalance($row_user['user_stafid'],date('Y'));?>, validateOn:["change"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("tajuk");

//ajax update location.
function updatelocation(id) {

	var str = document.getElementById("lokasi_baru"+id).value;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","update_pergerakan.php?val="+str+"&id="+id,true);
	xmlhttp.send();
	
	window.location.reload();
	alert('Lokasi telah berjaya dikemaskini.');
}
</script>
</body>
</html>
<?php include('../inc/footinc.php');?>
