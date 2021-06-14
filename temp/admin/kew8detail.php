<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='37';?>
<?php
if(isset($_GET['id']))
	$id = getID($_GET['id'],0);
else
	$id = 0;
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kew8 = "SELECT * FROM user_kewe WHERE userkewe_id = '" . $id . "' AND userkewe_status = 1 LIMIT 1";
$kew8 = mysql_query($query_kew8, $hrmsdb) or die(mysql_error());
$row_kew8 = mysql_fetch_assoc($kew8);
$totalRows_kew8 = mysql_num_rows($kew8);
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
                <div class="note">Penyata perubahan mengenai pendapatan seseorang pegawai (Kew 8 - Pin 10/96)</div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Nama Pegawai</td>
                    <td><strong><?php echo getFullNameByStafID($row_kew8['user_stafid']) . " (" . getICNoByStafID($row_kew8['user_stafid']) . ")"; ?></strong></td>
                  </tr>
                  <tr>
                    <td class="label">Jawatan</td>
                    <td><?php echo getJobtitleReal($row_kew8['user_stafid']) . " (" . getGred($row_kew8['user_stafid']) . ")";?><br/><span class="txt_color1"><?php echo getFulldirectoryByUserID($row_kew8['user_stafid']);?></span></td>
                  </tr>
                  <tr>
                    <td class="label">No Gaji Berkomputer</td>
                    <td><?php echo $row_kew8['user_stafid'];?></td>
                  </tr>
                  <tr>
                    <td class="label">No. Siri</td>
                    <td><?php echo getKew8SiriByID($row_kew8['userkewe_id']);?></td>
                  </tr>
                </table>
              </li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabbox">
                    <tr>
                      <th align="left" valign="middle" nowrap="nowrap" class="w30 line_r line_t">Butir - butir Perubahan</th>
                      <th align="center" valign="middle" nowrap="nowrap" class="line_r line_t">Tarikh</th>
                      <th align="center" valign="middle" nowrap="nowrap" class="line_r line_t">Gaji Bulanan</th>
                      <th nowrap="nowrap" class="w30 line_r line_t">Catatan</th>
                      <th align="center" valign="middle" nowrap="nowrap" class="line_t">No. Surat Kebenaran</th>
                    </tr>
                    <tr class="line_b">
                      <td align="left" valign="middle" class="line_r"><?php echo htmlspecialchars_decode($row_kew8['userkewe_content'], ENT_QUOTES); ?></td>
                      <td align="center" valign="middle" nowrap="nowrap" class="line_r"><?php echo getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']);?><br/><?php echo getKew8EndDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']);?></td>
                      <td align="center" valign="middle" nowrap="nowrap" class="line_r">RM <?php echo $row_kew8['userkewe_salary']; ?><br />
                        (<?php echo $row_kew8['userkewe_salaryskill']; ?>)</td>
                      <td class="line_r"><?php echo htmlspecialchars_decode($row_kew8['userkewe_note'], ENT_QUOTES); ?></td>
                      <td align="center" valign="middle"><?php echo $row_kew8['userkewe_ref']; ?><br />
                      <?php echo $row_kew8['userkewe_refdate']; ?></td>
                    </tr>
                  </table>
                  &nbsp;
                </li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="middle" class="noline">
                      <form id="form1" name="form1" method="post" action="">
                        <input name="button3" type="button" class="submitbutton" id="button3" value="Cetak" onClick="MM_openBrWindow('kew8print.php?id=<?php echo $id;?>','printkew8','scrollbars=yes,width=800,height=600')" /><input name="button4" type="button" class="submitbutton" id="button4" value="Kemaskini" onclick="MM_goToURL('parent','kew8edit.php?id=<?php echo getID($id,1);?>');return document.MM_returnValue" />
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
mysql_free_result($kew8);
?>
<?php include('../inc/footinc.php');?> 