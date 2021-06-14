<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='11';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_ctype = "SELECT * FROM courses_type WHERE coursestype_status = 1 ORDER BY coursestype_name ASC";
$ctype = mysql_query($query_ctype, $hrmsdb) or die(mysql_error());
$row_ctype = mysql_fetch_assoc($ctype);
$totalRows_ctype = mysql_num_rows($ctype);

$wsql = "";
if(isset($_POST['jenis']) && $_POST['jenis']!=0)
{
	$wsql .= " AND coursestype_id='" . $_POST['jenis'] . "' ";
} else {
	$wsql .= " AND coursestype_id='" . $row_ctype['coursestype_id'] . "' ";
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_c = "SELECT * FROM courses WHERE courses_status = 1 " . $wsql . " ORDER BY courses_start_y DESC, courses_start_m DESC, courses_start_d DESC, courses_id DESC";
$c = mysql_query($query_c, $hrmsdb) or die(mysql_error());
$row_c = mysql_fetch_assoc($c);
$totalRows_c = mysql_num_rows($c);
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
        <?php include('../inc/menu_admin.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li class="form_back">
                  <form id="form1" name="form1" method="post" action="coursesreport.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Kategori</td>
                        <td>
                          <select name="jenis" id="jenis">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_ctype['coursestype_id']?>"><?php echo $row_ctype['coursestype_name']?></option>
                            <?php
							} while ($row_ctype = mysql_fetch_assoc($ctype));
							  $rows = mysql_num_rows($ctype);
							  if($rows > 0) {
								  mysql_data_seek($ctype, 0);
								  $row_ctype = mysql_fetch_assoc($ctype);
							  }
							?>
                          </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
  				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_c > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Kehadiran</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr>
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle"><?php echo getCoursesDate($row_c['courses_id']);?></td>
                        <td align="left" valign="middle">
                          <div class="txt_line"><strong class="txt_size3"><?php echo $row_c['courses_name']; ?></strong><br />Anjuran : <?php echo getOrganizedBy($row_c['organizedby_id'],$row_c['courses_id']); ?> &nbsp; <span class="txt_color1">&bull;</span> &nbsp; Tempat : <?php echo $row_c['courses_location']; ?>
                            <?php if($row_c['dir_id']!='0' || $row_c['group_id']!='0'){ ?>
                            <?php if($row_c['dir_id']!='0') echo "<div><span class=\"txt_color1\">&bull;</span> &nbsp; Pengkhususan : " . getDirSubName($row_c['dir_id']) . "</div>"; ?> 
                            <?php if($row_c['group_id']!='0') echo "<div><span class=\"txt_color1\">&bull;</span> &nbsp; Kumpulan : " . getGroup($row_c['group_id']) . "</div>"; ?>
                            <?php }; ?>
                          </div>
                        </td>
                        <td align="center" valign="middle">
                        <?php $tt = getTotalAttendence($row_c['courses_id']);?>
                        <?php echo $tt['0'];?>
                        </td>
                      </tr>
                      <?php $i++; } while ($row_c = mysql_fetch_assoc($c)); ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_c ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
            <?php } ; ?>
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
mysql_free_result($ctype);

mysql_free_result($c);
?>
<?php include('../inc/footinc.php');?> 