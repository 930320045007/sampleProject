<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='7';?>
<?php $menu2='92';?>
<?php

if(isset($_GET['d']))
	$dd = $_GET['d'];
else
	$dd = date('d');
	
if(isset($_GET['m']))
	$dm = $_GET['m'];
else
	$dm = date('m');
	
if(isset($_GET['y']))
	$dy = $_GET['y'];
else
	$dy = date('Y');

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
	$sql_where = "";
	// if(checkJob2($row_user['user_stafid']) && checkJob2Not1($row_user['user_stafid']))
	// {
  //   if(isset($_POST['cpu']))
  //   {
  //     $sql_where .= " user_unit.dir_id = '" . $_POST['cpu'] . "' AND login.login_status = 1";
  //   }
	// 	else {
	// 		$sql_where .= " user_unit.dir_id = '" . $row_dirsub['dir_id'] . "' AND login.login_status = 1";
	// 	}
	// } else {
	// 	$sql_where .= " user_unit.dir_id = '" . getUserUnitIDByUserID($row_user['user_stafid']) . "' AND login.login_status = 1";
  // }
  
  if(isset($_GET['cpu']))
	{
    if(checkJob2($row_user['user_stafid']) && checkJob2Not1($row_user['user_stafid']))
    {
      $sql_where .= " user_unit.dir_id = '" . $_GET['cpu'] . "' AND login.login_status = 1";
    }
    else {
      $sql_where .= " user_unit.dir_id = '" . getUserUnitIDByUserID($row_user['user_stafid']) . "' AND login.login_status = 1";
    }
  } 
  else {
    $sql_where .= " user_unit.dir_id = '" . $row_dirsub['dir_id'] . "' AND login.login_status = 1";
  }

  
	
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
            <ul>
            
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="statusattendance.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
					  <?php if(checkJob2($row_user['user_stafid']) && checkJob2Not1($row_user['user_stafid'])){?>
                      <td nowrap="nowrap" class="label">Lokasi </td>
          	          <td width="100%">
          	            <select name="cpu" id="cpu">
          	              <?php 
do {  
?>
          	              <option <?php if(isset($_GET['cpu']) && $_GET['cpu']==$row_dirsub['dir_id']) echo "selected=\"selected\"";?>  value="<?php echo $row_dirsub['dir_id']?>"><?php echo getFulldirectory($row_dirsub['dir_id'], 0);?></option>
          	              <?php
} while ($row_dirsub = mysql_fetch_assoc($dirsub));
  $rows = mysql_num_rows($dirsub);
  if($rows > 0) {
      mysql_data_seek($dirsub, 0);
	  $row_dirsub = mysql_fetch_assoc($dirsub);
  }
?>
                        </select>
                        </td>
                        <?php }; ?>
                          <td class="noline label">Tarikh</td>
                        <td width="100%" class="noline"><label for="y"></label>
                          <select name="d" id="d">
                          <?php for($i=1; $i<=31; $i++){?>
                          	<option <?php if($i==$dd) echo "selected=\"selected\"";?> value="<?php if($i<10) echo "0" . $i; else echo $i;?>"><?php if($i<10) echo "0" . $i; else echo $i;?></option>
                              <?php }; ?>
                          </select>
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
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php if(getStatusByStafID($row_user['user_stafid'])==1){?>
                <li> 
                  <div class="note">Senarai kehadiran kakitangan  pada <strong><?php echo date('d/m/Y (D)', mktime(0, 0, 0, $dm, $dd, $dy));?></strong></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_userunit > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th class="line_l line_r line_t">Bil</th>
                      <th width="40%" align="left" valign="middle" class="line_l line_r line_t">Nama / Jawatan</th>
                      <th align="center" valign="middle" class="line_l line_r line_t">Waktu Masuk</th>
                      <th align="center" valign="middle" class="line_l line_r line_t">Waktu Keluar</th>
                      <th width="20%" align="center" valign="middle" class="line_l line_r line_t">Cuti</th>
                      <th width="20%" align="center" valign="middle" class="line_l line_r line_t">Kehadiran</th>
                      <th width="30%" align="center" valign="middle" class="line_l line_r line_t">Pergerakan</th>
                    </tr>
                   <?php $i=1; do { ?>
                          <tr class="on">
                           <td class="txt_line line_r line_l"><?php echo $i;?></td>
                           <td class="txt_line line_r line_l"> <div class="txt_line"><?php echo getFullNameByStafID($row_userunit['user_stafid']); ?></strong>(<?php echo $row_userunit['user_stafid'];?>)<br/>
                            <span class="txt_color1"><?php echo getJobtitle($row_userunit['user_stafid']); ?> (<?php echo getGred($row_userunit['user_stafid']);?>)</span>
                            </div></td>
                          <td align="left" valign="middle" class="txt_line line_r line_l">
                           <?php if(getTimeInByDate($row_userunit['user_stafid'], $dd, $dm, $dy)!='NULL') echo getTimeInByDate($row_userunit['user_stafid'], $dd, $dm, $dy); else echo ' ';?>
							 </td>
                          <td align="left" valign="middle" class="txt_line line_r line_l">
                           <?php if(getTimeOutByDate($row_userunit['user_stafid'], $dd, $dm, $dy)!='NULL') echo getTimeOutByDate($row_userunit['user_stafid'], $dd, $dm, $dy); else echo ' ';?>
							 </td>
                      <td align="left" valign="middle" class="txt_line line_r line_l">
                      <?php if(checkHolidayByDate($dd, $dm, $dy)) echo "<div> &bull; " . getHolidayName($dd, $dm, $dy) . "</div>";?>
                      <?php if(checkDayLeave($row_userunit['user_stafid'], 0, $dd, $dm, $dy)) {?>
                      <div>
                      <?php echo getLeaveType(getLeaveTypeByLeaveID(getLeaveID($row_userunit['user_stafid'], 0, $dd, $dm, $dy, 0)));?> &nbsp;
					  <?php echo viewIconLeave($row_user['user_stafid'], getLeaveID($row_userunit['user_stafid'], 0, $dd, $dm, $dy, 0), 0, 0, 0, 0); ?>
                      </div>
                      <?php }; ?>
                      </td>
                      <td align="left" valign="middle" class="txt_line line_r line_l">
                      <?php $id = getNewLeaveOfficeIDByDate($row_userunit['user_stafid'], 0, $dd, $dm, $dy); ?>

                              <div><?php iconApplyByLeaveStatus($id);?> &nbsp; <strong><?php echo getReasonNameByID(getReasonByLeaveOfficeID($id));?></strong> 
                              <?php if(getReasonType(getReasonByLeaveOfficeID($id))=='0') { ?>
                              &nbsp; &bull; &nbsp; <?php echo getTimeLeaveByLeaveOfficeID($id);?> - <?php echo getTimeBackByLeaveOfficeID($id);?>
							  <?php }; ?>
                              <?php if(getReasonType(getReasonByLeaveOfficeID($id))=='1')  { ?>
                         &nbsp; &bull; &nbsp; <?php echo getLeaveOfficeDayByLeaveOfficeID($id); ?> <?php echo getDayType(getLeaveOfficeDayTypeByLeaveOfficeID($id));?>
                        <?php }; ?>	
                              </div>
                              <div class="txt_color1"><?php echo getLeaveNoteByLeaveOfficeID($id);?></div>
                      </td>



 <!-- pergerakan -->
                      <td align="left" valign="middle" class="txt_line line_r line_l">
                      <?php $pergerakanIDByDateTemp = getNewPergerakanIDByDate($row_userunit['user_stafid'], $dd, $dm, $dy); 
                          


                          if(isset($pergerakanIDByDateTemp))
                          {
                            for($ii=0; $ii < count($pergerakanIDByDateTemp) ;$ii++)
                            {
                                echo "<div class=\"txt_color1\">".getPergerakanStaffByID($pergerakanIDByDateTemp[$ii])."</div>";
                            }
                          }
                      ?>
                      </td>







                    </tr>
                     <?php $i++; } while ($row_userunit = mysql_fetch_assoc($userunit)); ?>
                        <tr>
                          <td colspan="6" align="center" class="noline txt_color1"><?php echo $totalRows_userunit ?>  rekod dijumpai</td>
                        </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="6" align="center" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                       <?php }; ?>
                </table>
                </li>
                <?php }; ?>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html
><?php
	if(checkJob2($row_user['user_stafid']) && checkJob2Not1($row_user['user_stafid']))
	{
		mysql_free_result($dirsub);
	}

mysql_free_result($userunit);
?>
<?php include('../inc/footinc.php');?> 