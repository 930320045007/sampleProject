<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='7';?>
<?php $menu2='18';?>
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
	$sql_where = "";
	if(checkJob2($row_user['user_stafid']) && checkJob2Not1($row_user['user_stafid']))
	{
		if(isset($_POST['cpu']))
			$sql_where .= " user_unit.dir_id = '" . htmlspecialchars($_POST['cpu'], ENT_QUOTES) . "' AND login.login_status = 1";
		else {
			$sql_where .= " user_unit.dir_id = '" . $row_dirsub['dir_id'] . "' AND login.login_status = 1";
		}
	} else {
		$sql_where .= " user_unit.dir_id = '" . getUserUnitIDByUserID($row_user['user_stafid']) . "' AND login.login_status = 1";
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
          
           <?php if(checkJob2($row_user['user_stafid']) && checkJob2Not1($row_user['user_stafid'])){ ?>
          	  <li class="form_back">
          	    <form id="form1" name="form1" method="post" action="">
          	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	        <tr>
          	          <td nowrap="nowrap" class="label">Lokasi</td>
          	          <td width="100%">
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
                        </select>
       	              <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
       	            </tr>
       	          </table>
       	        </form>
          	  </li>
              <?php }; ?>
                <li>
                	<div class="note">Senarai staf dibawah <?php echo getFulldirectory(getUserUnitIDByUserID($row_user['user_stafid']));?></div>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_userunit > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th>Bil</th>
                          <th width="100%" colspan="2" align="left" valign="middle">Nama / Jawatan</th>
                          <th align="center" valign="middle" nowrap="nowrap">Email<br/>(@nsc.gov.my)</th>
                          <th align="center" valign="middle" nowrap="nowrap">Ext</th>
                          <th align="center" valign="middle" nowrap="nowrap">Baki Cuti<br />
                            (Hari)</th>
                          <th align="center" valign="middle" nowrap="nowrap">Kursus</th>
                        </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td align="center" valign="middle"><?php echo $i;?></td>
                            <td align="center"><?php echo viewProfilePic($row_userunit['user_stafid']);?></td>
                            <td width="100%"><div class="txt_line"><a href="profil.php?sid=<?php echo getID($row_userunit['user_id']);?>"><strong class="in_upper"><?php echo getFullNameByStafID($row_userunit['user_stafid']); ?> </strong>(<?php echo $row_userunit['user_stafid'];?>)</a><br/>
                            <span class="txt_color1"><?php echo getJobtitle($row_userunit['user_stafid']); ?> (<?php echo getGred($row_userunit['user_stafid']);?>),<br/><?php echo getFulldirectoryByUserID($row_userunit['user_stafid']);?> &nbsp; &bull; &nbsp; <?php echo getLocationByUserID($row_userunit['user_stafid']);?></span>
                            </div></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php if(getEmailISNByUserID($row_userunit['user_stafid'], 1)!="") echo getEmailISNByUserID($row_userunit['user_stafid'], 1);?></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php if(getExtNoByUserID($row_userunit['user_stafid'], 0)!='-') echo getExtNoByUserID($row_userunit['user_stafid'], 0);?></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php echo countLeaveBalance($row_userunit['user_stafid'], date('Y'));?></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php $courses = countCoursesHour($row_userunit['user_stafid'], date('Y'));?><?php if($courses[0]!=0) echo $courses[0] . "<span class=\"txt_size2\">  Hari </span> &nbsp; ";?><?php if($courses[1]!=0) echo $courses[1] . "<span class=\"txt_size2\"> Jam </span>"; ?><?php if($courses[0]==0 && $courses[1]==0) echo "0";?></td>
                          </tr>
                          <?php $i++; } while ($row_userunit = mysql_fetch_assoc($userunit)); ?>
                        <tr>
                          <td colspan="7" align="center" class="noline txt_color1"><?php echo $totalRows_userunit ?>  rekod dijumpai</td>
                        </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="7" align="center" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                       <?php }; ?>
                      </table>
                </li>
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

mysql_free_result($userunit);
?>
<?php include('../inc/footinc.php');?> 