<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='117';?>
<?php
if(isset($_GET['id']))
	$id = getID($_GET['id'],0);
else
	$id = 0;
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_gl = "SELECT * FROM user_gl WHERE usergl_id = '" . $id . "' AND usergl_status = 1 LIMIT 1";
$gl = mysql_query($query_gl, $hrmsdb) or die(mysql_error());
$row_gl = mysql_fetch_assoc($gl);
$totalRows_gl = mysql_num_rows($gl);
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
        <?php include('../inc/menu_ict.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <li>
                <div class="note">Surat Pengesahan Diri dan Pengakuan Pegawai -  </div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Nama Pegawai</td>
                    <td><strong><?php echo getFullNameByStafID($row_gl['user_stafid']) . " (" . getICNoByStafID($row_gl['user_stafid']) . ")"; ?></strong></td>
                  </tr>
                  <tr>
                    <td class="label">Jawatan</td>
                    <td><?php echo getJobtitleReal($row_gl['user_stafid']) . " (" . getGred($row_gl['user_stafid']) . ")";?><br/><span class="txt_color1"><?php echo getFulldirectoryByUserID($row_gl['user_stafid']);?></span></td>
                  </tr>
                  <tr>
                    <td class="label">No Kakitangan</td>
                    <td><?php echo $row_gl['user_stafid'];?></td>
                  </tr>
                  <tr>
                    <td class="label">No. Siri</td>
                    <td><?php echo getGLSiriByID($row_gl['usergl_id']);?></td>
                  </tr>
                  <tr>
                    <td class="label">Hubungan</td>
                    <td><?php echo getGL8NameByID($row_gl['relationship_id']);?></td>
                  </tr>
                 
                </table>
              </li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabbox">
                    <tr>
                      <th align="left" valign="middle" nowrap="nowrap" class="w30 line_r line_t">Maklumat Ahli Keluarga</th>
                      <th align="center" valign="middle" nowrap="nowrap" class="line_r line_t">Tarikh</th>
                      <th align="center" valign="middle" nowrap="nowrap" class="line_r line_t">Gaji Pokok</th>
                      <th align="center" nowrap="nowrap" class="w30 line_r line_t">Alamat Pejabat</th>
                      <th align="center" valign="middle" nowrap="nowrap" class="line_t">No. Ruj Surat Kebenaran</th>
                    </tr>
                    <tr class="line_b">
                      <td align="left" valign="middle" class="line_r"><?php echo $row_gl['usergl_name'];?> (<?php echo $row_gl['usergl_ic']; ?>)</td>
                      <td align="center" valign="middle" nowrap="nowrap" class="line_r"><?php echo getGLStartDate($row_gl['user_stafid'], $row_gl['usergl_id']);?><br/><?php echo getKew8EndDate($row_gl['user_stafid'], $row_gl['usergl_id']);?></td>


                      <?php 
              setlocale(LC_MONETARY,"ms_MY");
            ?>

                      <td align="center" valign="middle" nowrap="nowrap" class="line_r">RM<?php echo $row_gl['usergl_salary'];?><br />
                        <!--(<?php echo $row_gl['usergl_salaryskill']; ?>) --> </td> 
                      <td class="line_r"><?php echo htmlspecialchars_decode($row_gl['usergl_pejabat'], ENT_QUOTES); ?></td>
                      <td align="center" valign="middle"><?php echo $row_gl['usergl_ref']; ?><br />
                      <?php echo $row_gl['usergl_refdate']; ?></td>
                    </tr>
                  </table>
                  &nbsp;
                </li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="middle" class="noline">
                      <form id="form1" name="form1" method="post" action="">
                        <input name="button3" type="button" class="submitbutton" id="button3" value="Cetak" onClick="MM_openBrWindow('glprint.php?id=<?php echo $id;?>','printkew8','scrollbars=yes,width=800,height=600')" /><input name="button4" type="button" class="submitbutton" id="button4" value="Kemaskini" onclick="MM_goToURL('parent','gledit.php?id=<?php echo getID($id,1);?>');return document.MM_returnValue" />
                    </form>
                    </td>
                  </tr>
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
mysql_free_result($gl);
?>
<?php include('../inc/footinc.php');?> 