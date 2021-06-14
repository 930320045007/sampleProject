<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/admin_sta.php');?>
<?php $menu='7';?>
<?php $menu2='24';?>
<?php $menu3 = '2';?>
<?php
	if(checkJob2($row_user['user_stafid']) && checkJob2Not1($row_user['user_stafid']))
	{
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$query_dirsub = "SELECT * FROM dir WHERE dir_sub = '" . getUserUnitIDByUserID($row_user['user_stafid']) . "' OR dir_id = '" . getUserUnitIDByUserID($row_user['user_stafid']) . "' ORDER BY dir_id ASC, dir_sort ASC";
		$dirsub = mysql_query($query_dirsub, $hrmsdb) or die(mysql_error());
		$row_dirsub = mysql_fetch_assoc($dirsub);
		$totalRows_dirsub = mysql_num_rows($dirsub);
	}
?>
<?php
	
if(isset($_GET['m']))
	$dm = $_GET['m'];
else
	$dm = date('m');
	
if(isset($_GET['y']))
	$dy = $_GET['y'];
else
	$dy = date('Y');

$dir = getDirIDByUser($row_user['user_stafid']);

if(isset($_POST['cpu']) && $_POST['cpu']!=NULL)
{
	$v = " AND user_unit.dir_id='" . htmlspecialchars($_POST['cpu'], ENT_QUOTES) ."' AND user_unit.userunit_status = '1'";
	$dir = htmlspecialchars($_POST['cpu'], ENT_QUOTES);
} else if(checkJob2($row_user['user_stafid']) && checkJob2Not1($row_user['user_stafid'])) 
{
	$v = " AND user_unit.dir_id='" . $row_dirsub['dir_id'] ."' AND user_unit.userunit_status = '1'";
	$dir = $row_dirsub['dir_id'];
} else
{
	$v = " AND user_unit.dir_id='" . getDirIDByUser($row_user['user_stafid']) ."' AND user_unit.userunit_status = '1'";
	$dir = getDirIDByUser($row_user['user_stafid']);
}

$totalStafDir = totalUserByDirID($dir, 0);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_unit.php');?>
        <div class="tabbox">
          <div class="profilemenu">
        	<?php include('../inc/menu_headleave.php');?>
          	<ul>
                <li class="line_b">
                  <form id="form1" name="form1" method="get" action="stafleavemonth.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                      <?php if(checkJob2($row_user['user_stafid']) && checkJob2Not1($row_user['user_stafid'])){?>
                        <td nowrap="nowrap" class="noline label">Cawangan / Pusat <br />
                        / Unit</td>
                        <td class="noline">
                        <select name="cpu" id="cpu">
          	              <?php
							do {  
							?>
          	              <option <?php if(isset($_POST['cpu']) && $_POST['cpu']==$row_dirsub['dir_id']) echo "selected=\"selected\"";?>  value="<?php echo $row_dirsub['dir_id']?>"><?php echo getFulldirectory($row_dirsub['dir_id'], 0);?></option>
          	              <?php
							} while ($row_dirsub = mysql_fetch_assoc($dirsub));
							  $rows = mysql_num_rows($dirsub);
							  if($rows > 0) {
								  mysql_data_seek($dirsub, 0);
								  $row_dirsub = mysql_fetch_assoc($dirsub);
							  }
							?>
                        </select></td>
                        <?php }; ?>
                        <td class="noline label">Tarikh</td>
                        <td width="100%" class="noline">
                          <select name="m" id="m">
                          <?php for($j=1; $j<=12; $j++){?>
                          	<option <?php if($j==$dm) echo "selected=\"selected\"";?> value="<?php if($j<10) echo "0" . $j; else echo $j;?>"><?php if($j<10) $m = "0" . $j; else $m = $j; echo date('m - M', mktime(0, 0, 0, $m, 1, date('Y')));?></option>
                            <?php }; ?>
                            </select>
                          <select name="y" id="y">
                          <?php for($k=date('Y'); $k>=2012; $k--){?>
                          	<option <?php if($k==$dy) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
                            </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                	<div class="note">Senarai kakitangan yang bercuti pada <strong><?php echo date('F Y', mktime(0, 0, 0, $dm, 1, $dy));?></strong></div>
                </li>
                <li>
                	<div class="off2">
					<?php 
					 //This gets today's date 
					 $date =time(); 
					
					 //This puts the day, month, and year in seperate variables 
					 $day = date('d', $date); 
					 $month = $dm; 
					 $year = $dy;
					 
					 if($month > 12)
					 {
					 	$month = '01';
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
						 echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"cal line_b line_t line_l line_r\">";
						 echo "<tr><td colspan=7 class=\"title txt_size3\" align=\"center\"><strong>$title $year</strong></td></tr>";
						 echo "<tr>
						 <td width=\"14%\" class=\"txt_color1 line_r line_b3\" align=\"center\">Ahad</td>
						 <td width=\"14%\" class=\"line_r line_b3\" align=\"center\">Isnin</td>
						 <td width=\"14%\" class=\"line_r line_b3\" align=\"center\">Selasa</td>
						 <td width=\"14%\" class=\"line_r line_b3\" align=\"center\">Rabu</td>
						 <td width=\"14%\" class=\"line_r line_b3\" align=\"center\">Khamis</td>
						 <td width=\"14%\" class=\"line_r line_b3\" align=\"center\">Jumaat</td>
						 <td width=\"14%\" class=\"txt_color1 line_r line_b3\" align=\"center\">Sabtu</td>
						 </tr>";
						
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
							
							if($day_num<10)
								$day_num = '0' . $day_num;
							 
							mysql_select_db($database_hrmsdb, $hrmsdb);
							$query_ul = "SELECT user_leavedate.* FROM www.user_leavedate LEFT JOIN (SELECT * FROM www.user_job2 WHERE user_job2.userjob2_status = '1' ORDER BY user_job2.userjob2_id DESC) AS user_job2 ON user_job2.user_stafid = user_leavedate.user_stafid LEFT JOIN www.user_unit ON user_unit.user_stafid = user_leavedate.user_stafid LEFT JOIN www.user_scheme ON user_scheme.user_stafid = user_leavedate.user_stafid WHERE userleavedate_status = '1' AND userleavedate_app != '2' AND userleavedate_date_d = '" . $day_num . "' AND userleavedate_date_m = '" . $month . "' AND userleavedate_date_y = '" . $year . "' " . $v . " GROUP BY user_leavedate.user_stafid ORDER BY user_job2.jobss_id DESC, user_scheme.userscheme_gred DESC, userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";
							$ul = mysql_query($query_ul, $hrmsdb) or die(mysql_error());
							$row_ul = mysql_fetch_assoc($ul);
							$totalRows_ul = mysql_num_rows($ul);
							
							$trc = 0;
								
							if($totalRows_ul>0)
							 {
							
								if(totalUserByDirID($dir, 0)>0)
									$color = round((getAllLeaveByDirID($dir, $day_num, $month, $year)/$totalStafDir)*100);
								else
									$color = 0;
								
							 	echo "<td valign=\"top\" width=\"14%\" class=\"line_r\" nowrap=\"nowrap\">";
								echo "<div class=\"note\" " . color($color) . "><a href=\"" . $url_main . "head/stafleave.php?d=" . $day_num . "&m=" . $month . "&y=" . $year . "\">" . $day_num;
								if(checkHolidayByDate($day_num, $month, $year))
									echo " - " . shortText(getHolidayName($day_num, $month, $year),15);
								echo "</a></div>";
								
								do{
									if($trc<=3)
									{
										$trc++;
										echo  "<div class=\"note\"> " . shortText(getFullNameByStafID(getStafIDByLeaveID($row_ul['userleavedate_id'])),15) . "</div>";
									}
								} while($row_ul = mysql_fetch_assoc($ul));
								
								if($totalRows_ul>3)
									echo  "<div class=\"note2\"><a href=\"" . $url_main . "head/stafleave.php?d=" . $day_num . "&m=" . $month . "&y=" . $year . "\"> --- " . $totalRows_ul . " rekod --- </a></div>";
								
								echo " </td>";
								
							}else
							{
							 	echo "<td valign=\"top\" width=\"14%\" class=\"line_r\" id=\"C" . $day_num . $month . "\" nowrap=\"nowrap\">" . $day_num;
								if(checkHolidayByDate($day_num, $month, $year))
									echo " - " . shortText(getHolidayName($day_num, $month, $year),15);
								else if($day_num==date('d') && $month==date('m')) echo " - Kini";
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
								 
							// free sql
							mysql_free_result($ul);
							
						 } 
						 
						 //Finaly we finish out the table with some blank details if needed
						 while ( $day_count >1 && $day_count <=7 ) 
						 { 
							 echo "<td class=\"line_r\">&nbsp;</td>"; 
							 $day_count++; 
						 } 
						 
						 echo "</tr></table>";
						 } // tamat semakkan setahun
					 ?>
                    </div>
                </li>
                <li class="gap">&nbsp;</li>
            </ul>
           </div>
        </div>
		</div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
	if(checkJob2($row_user['user_stafid']) && checkJob2Not1($row_user['user_stafid']))
	{
		mysql_free_result($dirsub);
	}
?>
<?php include('../inc/footinc.php');?>
