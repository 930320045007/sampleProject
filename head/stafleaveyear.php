<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/admin_sta.php');?>
<?php $menu='7';?>
<?php $menu2='24';?>
<?php $menu3 = '3';?>
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
	
if(isset($_GET['y']))
	$dy = $_GET['y'];
else
	$dy = date('Y');

if(isset($_POST['cpu']) && $_POST['cpu']!=NULL)
	$dir = htmlspecialchars($_POST['cpu'], ENT_QUOTES);	
else if(checkJob2($row_user['user_stafid']) && checkJob2Not1($row_user['user_stafid']))
	$dir = $row_dirsub['dir_id'];
else
	$dir = getDirIDByUser($row_user['user_stafid']);

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
        
      	<div class="content fl">
        <?php include('../inc/menu_unit.php');?>
        <div class="tabbox fl">
          <div class="profilemenu fl">
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
                	<div class="note">Senarai kakitangan yang bercuti pada <strong><?php echo $dy;?></strong></div>
                </li>
                <li class="fl">
                	<span>
					<?php
					for($i=1; $i<=12; $i++)
					{ 
					 //This gets today's date 
					 $date =time(); 
					
					 //This puts the day, month, and year in seperate variables 
					 $day = date('d', $date); 
					 $month = $i; 
					 $year = $dy;
					 
					 if($month<10)
					 	$month = '0' . $month;
					 
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
						 echo "<div class=\"padb padr fl\"><table width=\"33.33%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"line_b line_t line_l line_r\">";
						 echo "<tr><td colspan=7 class=\"title txt_size3\" align=\"center\"><strong>$title $year</strong></td></tr>";
						 echo "<tr><td class=\"txt_color1 line_r line_b3\" align=\"center\">A</td><td class=\"line_r line_b3\" align=\"center\">I</td><td class=\"line_r line_b3\" align=\"center\">S</td><td class=\"line_r line_b3\" align=\"center\">R</td><td class=\"line_r line_b3\" align=\"center\">K</td><td class=\"line_r line_b3\" align=\"center\">J</td><td class=\"txt_color1 line_r line_b3\" align=\"center\">S</td></tr>";
						
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
							
							if(totalUserByDirID($dir, 0)>0)
								$color = round((getAllLeaveByDirID($dir, $day_num, $month, $year)/$totalStafDir)*100);
							else
								$color = 0;
							
							echo "<td class=\"line_r\" " . color($color) . " align=\"center\" id=\"C" . $day_num . $month . "\"><a href=\"" . $url_main . "head/stafleave.php?d=" . $day_num . "&m=" . $month . "&y=" . $year . "\">" . $day_num;
							if(checkHolidayByDate($day_num, $month, $year))
								echo "*";
							echo "</a></td>";
								
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
						 
						 echo "</tr></table></div>";
						 } // tamat semakkan setahun
					}
					 ?>
                    </span>
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