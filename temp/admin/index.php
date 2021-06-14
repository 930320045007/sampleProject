<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/admin_sta.php');?>
<?php $menu='5';?>
<?php $menu2='4';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_race = "SELECT * FROM race ORDER BY race_id ASC";
$race = mysql_query($query_race, $hrmsdb) or die(mysql_error());
$row_race = mysql_fetch_assoc($race);
$totalRows_race = mysql_num_rows($race);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_race2 = "SELECT * FROM race ORDER BY race_id ASC";
$race2 = mysql_query($query_race2, $hrmsdb) or die(mysql_error());
$row_race2 = mysql_fetch_assoc($race2);
$totalRows_race2 = mysql_num_rows($race2);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_race3 = "SELECT * FROM race ORDER BY race_id ASC";
$race3 = mysql_query($query_race3, $hrmsdb) or die(mysql_error());
$row_race3 = mysql_fetch_assoc($race3);
$totalRows_race3 = mysql_num_rows($race3);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jobtype = "SELECT * FROM job_type WHERE jobtype_status = 1 ORDER BY jobtype_id ASC";
$jobtype = mysql_query($query_jobtype, $hrmsdb) or die(mysql_error());
$row_jobtype = mysql_fetch_assoc($jobtype);
$totalRows_jobtype = mysql_num_rows($jobtype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jobtype2 = "SELECT * FROM job_type WHERE jobtype_status = 1 ORDER BY jobtype_id ASC";
$jobtype2 = mysql_query($query_jobtype2, $hrmsdb) or die(mysql_error());
$row_jobtype2 = mysql_fetch_assoc($jobtype2);
$totalRows_jobtype2 = mysql_num_rows($jobtype2);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jobtype3 = "SELECT * FROM job_type WHERE jobtype_status = 1 ORDER BY jobtype_id ASC";
$jobtype3 = mysql_query($query_jobtype3, $hrmsdb) or die(mysql_error());
$row_jobtype3 = mysql_fetch_assoc($jobtype3);
$totalRows_jobtype3 = mysql_num_rows($jobtype3);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kump = "SELECT * FROM `group` WHERE group_status = 1 ORDER BY group_id ASC";
$kump = mysql_query($query_kump, $hrmsdb) or die(mysql_error());
$row_kump = mysql_fetch_assoc($kump);
$totalRows_kump = mysql_num_rows($kump);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kump2 = "SELECT * FROM `group` WHERE group_status = 1 ORDER BY group_id ASC";
$kump2 = mysql_query($query_kump2, $hrmsdb) or die(mysql_error());
$row_kump2 = mysql_fetch_assoc($kump2);
$totalRows_kump2 = mysql_num_rows($kump2);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kump3 = "SELECT * FROM `group` WHERE group_status = 1 ORDER BY group_id ASC";
$kump3 = mysql_query($query_kump3, $hrmsdb) or die(mysql_error());
$row_kump3 = mysql_fetch_assoc($kump3);
$totalRows_kump3 = mysql_num_rows($kump3);
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
        <div class="tabbox fl">
          <div class="profilemenu">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table2">
              <tr>
                <td class="line_b">Kategori (Aktif)</td>
                <td class="icon_pad1 line_b w30">
                <div class="fl padr"><img src="../icon/man.png" width="39" height="48" alt="Man" /></div>
                <div class="fl"><div>Bilangan</div><div class="txt_size1">Lelaki</div></div>
                </td>
                <td class="icon_pad1 line_b w30">
                <div class="fl padr"><img src="../icon/woman.png" width="39" height="48" alt="Woman" /></div>
                <div class="fl"><div>Bilangan</div><div class="txt_size1">Perempuan</div></div>
                </td>
                <td class="line_b w30">Jumlah<br />Keseluruhan</td>
              </tr>
              <tr>
                <td class="line_b">Jumlah</td>
                <td class="line_b">
                    <div class="txt_size1"><?php $male = totalGender('1'); echo $male;?><span class="txt_size2"> org</span></div>
                  	<div><?php $pmale = percentGender('1'); echo $pmale . "%";?></div>
                </td>
                <td class="line_b">
                    <div class="txt_size1"><?php $female = totalGender('2'); echo $female;?><span class="txt_size2"> org</span></div>
                  	<div><?php $pfmale = percentGender('2'); echo $pfmale . "%";?></div>
                </td>
                <td class="line_b">
                    <div class="txt_size1"><?php echo $male + $female;?><span class="txt_size2"> org</span></div>
                  	<div>&nbsp;</div>
                </td>
              </tr>
              <tr>
                <td class="line_b">Etnik<div class="txt_size2">(org)</div></td>
                <td class="line_b">
                <ul class="li2c">
                	<?php do { ?>
                	  <li>
                	    <div><?php echo $row_race['race_name'];?></div>
                	    <div class="txt_size1"><?php $mrace = totalRace($row_race['race_id'], '1'); echo $mrace;?></div>
                	    <div><?php echo percentRace($row_race['race_id'], '1') . "%";?></div>
               	      </li>
                	  <?php } while ($row_race = mysql_fetch_assoc($race)); ?>
                </ul>
                </td>
                <td class="line_b">
                <ul class="li2c">
                	<?php do { ?>
                	  <li>
                	    <div><?php echo $row_race2['race_name'];?></div>
                	    <div class="txt_size1"><?php $mrace2 = totalRace($row_race2['race_id'], '2'); echo $mrace2;?></div>
                	    <div><?php echo percentRace($row_race2['race_id'], '2') . "%";?></div>
               	      </li>
                	  <?php } while ($row_race2 = mysql_fetch_assoc($race2)); ?>
                </ul>
                </td>
                <td class="line_b">
                <ul class="li2c">
                	<?php do { ?>
                	  <li>
                	    <div><?php echo $row_race3['race_name'];?></div>
                	    <div class="txt_size1"><?php $mrace3 = totalRace($row_race3['race_id'], '0'); echo $mrace3;?></div>
                	    <div><?php echo percentRace($row_race3['race_id'], '0') . "%";?></div>
               	      </li>
                	<?php } while ($row_race3 = mysql_fetch_assoc($race3)); ?>
                </ul>
                </td>
              </tr>
              <tr>
                <td class="line_b">Status Penjawatan<div class="txt_size2">(org)</div></td>
                <td class="line_b">                
                <ul class="li2c">
                	  <?php do { ?>
                	  <li>
                	    <div><?php echo $row_jobtype['jobtype_name']; ?></div>
                	    <div class="txt_size1"><?php $mrace3 = totalJobType($row_jobtype['jobtype_id'], '1'); echo $mrace3;?></div>
                	    <div><?php echo percentJobType($row_jobtype['jobtype_id'], '1') . "%";?></div>
               	      </li>
                	  <?php } while ($row_jobtype = mysql_fetch_assoc($jobtype)); ?>
                </ul>
                </td>
                <td class="line_b">                
                <ul class="li2c">
                	  <?php do { ?>
                	  <li>
                	    <div><?php echo $row_jobtype2['jobtype_name']; ?></div>
                	    <div class="txt_size1"><?php $mrace3 = totalJobType($row_jobtype2['jobtype_id'], '2'); echo $mrace3;?></div>
                	    <div><?php echo percentJobType($row_jobtype2['jobtype_id'], '2') . "%";?></div>
               	      </li>
                	  <?php } while ($row_jobtype2 = mysql_fetch_assoc($jobtype2)); ?>
                </ul>
                </td>
                <td class="line_b">                
                <ul class="li2c">
                	  <?php do { ?>
                	  <li>
                	    <div><?php echo $row_jobtype3['jobtype_name']; ?></div>
                	    <div class="txt_size1"><?php $mrace3 = totalJobType($row_jobtype3['jobtype_id'], '0'); echo $mrace3;?></div>
                	    <div><?php echo percentJobType($row_jobtype3['jobtype_id'], '0') . "%";?></div>
               	      </li>
                	  <?php } while ($row_jobtype3 = mysql_fetch_assoc($jobtype3)); ?>
                </ul>
                </td>
              </tr>
              <tr>
                <td class="line_b">Kumpulan<div class="txt_size2">(org)</div></td>
                <td class="line_b">
                <ul class="li2c">
					<?php do { ?>
                        <li>
                        	<div><?php echo $row_kump['group_name']; ?></div>
                        	<div class="txt_size1"><?php echo totalUserByGroupGred($row_kump['group_id'], '1'); ?></div>
                            <div><?php echo percentGroupGred($row_kump['group_id'], '1') . "%";?></div>
                        </li>
                    <?php } while($row_kump = mysql_fetch_assoc($kump)); ?>
                </ul>
                </td>
                <td class="line_b">
                <ul class="li2c">
					<?php do { ?>
                        <li>
                        	<div><?php echo $row_kump2['group_name']; ?></div>
                        	<div class="txt_size1"><?php echo totalUserByGroupGred($row_kump2['group_id'], '2'); ?></div>
                            <div><?php echo percentGroupGred($row_kump2['group_id'], '2') . "%";?></div>
                        </li>
                    <?php } while($row_kump2 = mysql_fetch_assoc($kump2)); ?>
                </ul>
                </td>
                <td class="line_b">
                <ul class="li2c">
					<?php do { ?>
                        <li>
                        	<div><?php echo $row_kump3['group_name']; ?></div>
                        	<div class="txt_size1"><?php echo totalUserByGroupGred($row_kump3['group_id'], '0'); ?></div>
                            <div><?php echo percentGroupGred($row_kump3['group_id'], '0') . "%";?></div>
                        </li>
                    <?php } while($row_kump3 = mysql_fetch_assoc($kump3)); ?>
                </ul>
              </tr>
            </table>
          </div>
        </div>
        
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($race);
mysql_free_result($race2);
mysql_free_result($race3);

mysql_free_result($jobtype);
mysql_free_result($jobtype2);
mysql_free_result($jobtype3);

mysql_free_result($kump);
mysql_free_result($kump2);
mysql_free_result($kump3);
?>
<?php include('../inc/footinc.php');?> 