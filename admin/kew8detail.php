<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='37';?>
<?php
$kewe_id = array(10, 11, 12, 15, 17, 28, 31, 37, 41, 45);

if(isset($_GET['id']))
	$id = getID($_GET['id'],0);
else
	$id = 0;
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kew8 = "SELECT * FROM user_kewe WHERE userkewe_id = '" . $id . "' AND userkewe_status = 1 LIMIT 1";
$kew8 = mysql_query($query_kew8, $hrmsdb) or die(mysql_error());
$row_kew8 = mysql_fetch_assoc($kew8);
$totalRows_kew8 = mysql_num_rows($kew8);
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sch = sprintf("SELECT user_scheme.*, classification.classification_id FROM www.user_scheme LEFT JOIN www.scheme ON scheme.scheme_id = user_scheme.scheme_id LEFT JOIN www.classification ON classification.classification_id = scheme.classification_id WHERE user_stafid = %s AND user_scheme.userscheme_status = '1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, user_scheme.userscheme_id DESC", GetSQLValueString($row_kew8['user_stafid'], "text"));
$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
$row_sch = mysql_fetch_assoc($sch);
$totalRows_sch = mysql_num_rows($sch);
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_emo = sprintf("SELECT * FROM www.user_emolumen WHERE user_stafid = %s and useremolumen_date_y < %s and useremolumen_status = '1' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC", GetSQLValueString($row_kew8['user_stafid'], "text"), GetSQLValueString(date('Y', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))), "text"));
$emo = mysql_query($query_emo, $hrmsdb) or die(mysql_error());
$row_emo = mysql_fetch_assoc($emo);
$totalRows_emo = mysql_num_rows($emo);

//hold dulu
// mysql_select_db($database_hrmsdb, $hrmsdb);
// $query_tg = sprintf("SELECT * FROM www.user_salaryskill WHERE user_stafid = %s ORDER BY usersalaryskill_date_y DESC, usersalaryskill_date_m DESC, usersalaryskill_date_d DESC, usersalaryskill_id DESC", GetSQLValueString($colname_userprofile, "text"));
// $tg = mysql_query($query_tg, $hrmsdb) or die(mysql_error());
// $row_tg = mysql_fetch_assoc($tg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<style type="text/css">
.display-none {
	display:none;
}
</style>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_ict.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li>
                <div class="note">Penyata perubahan mengenai pendapatan seseorang pegawai (Kew 8 - Pin 10/96)</div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Nama Pegawai</td>
                    <td><strong><?php echo getFullNameByStafID($row_kew8['user_stafid']) . " (" . getICNoByStafID($row_kew8['user_stafid']) . ")"; ?></strong></td>
                  </tr>
                  <tr>
                    <td class="label">Jawatan</td>
                    <td><?php echo getJobtitleReal($row_kew8['user_stafid'])." (". getGred($row_kew8['user_stafid']).")";?><br/><span class="txt_color1"><?php echo getFulldirectoryByUserID($row_kew8['user_stafid']);?></span></td>
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
                      <td align="center" valign="middle" nowrap="nowrap" class="line_r">
                      <div style="display:<?php if(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']) == "-" && getKew8EndDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']) == null ) {echo "none";} ?>"><?php echo getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']);?></div>
                        <div style="display:<?php if(getKew8EndDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']) != null) echo "block";else echo "none" ?>" ><?php echo getKew8EndDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']);?><br/><br/></div>
                        <div style="display:<?php if(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']) == null || getKew8EndDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']) == null ) {echo "block";} ?>"><?php echo nl2br ($row_kew8['userkewe_note'], ENT_QUOTES);?></div></td>
                      <td align="center" valign="middle" nowrap="nowrap" class="line_r">
                      <div style="display:<?php if($row_kew8['kewe_id'] == '25') echo "block"; else echo "none"; ?>">
                          <br/>RM 
                              <?php echo getBasicSalaryByUserIDall($row_kew8['user_stafid'], 1, date('m', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))), date('Y', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))));?> 
                          <br/>Kepada</div>
                      <div align="left" style="display:<?php if($row_kew8['kewe_id'] == '87') echo "block"; else echo "none"; ?>">Telah Terima </br></br>Gred <?php echo getGredByKew8($row_kew8['user_stafid'], date('Y', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))));?> </br></br> RM <?php echo getBasicSalaryByUserIDall($row_kew8['user_stafid'], 1, date('m', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))), date('Y', strtotime(getKew8StartDate($row_kew8['user_stafid'], $row_kew8['userkewe_id']))-1));?> <br/></br> ITKA : RM <?php echo $row_emo['useremolumen_itkrai'];?></br>ITP : RM <?php echo $row_emo['useremolumen_itp'];?></br>BSH : RM <?php echo $row_emo['useremolumen_bsh'];?></br>Insentif Peminjam : RM <?php echo $row_emo['useremolumen_elinsentif'];?></br></div>
                      <div style="display:<?php if($row_kew8['kewe_id'] !== '87') echo "block"; else echo "none"; ?>">RM <?php echo $row_kew8['userkewe_salary'];?></div><br />
                        <!--(<?php echo $row_kew8['userkewe_salaryskill']; ?>) --> </td> 
                      <td class="line_r"><?php echo htmlspecialchars_decode($row_kew8['userkewe_imbuhan'], ENT_QUOTES); ?></td>
                      <td align="center" valign="middle"><?php echo $row_kew8['userkewe_ref']; ?><br />
                      <?php echo date('d/m/Y', strtotime($row_kew8["userkewe_refdate"])); ?></td>
                      
                       
                    </tr>
                  </table>
                  &nbsp;
                </li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="middle" class="noline">
                      <form id="form1" name="form1" method="post" action="">
                        <input name="button3" type="button" class="submitbutton" id="button3" value="Cetak" onClick="MM_openBrWindow('kew8print.php?id=<?php echo $id;?>','printkew8','scrollbars=yes,width=800,height=600')" /><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?><input name="button4" type="button" class="submitbutton" id="button4" value="Kemaskini" onclick="MM_goToURL('parent','kew8edit.php?id=<?php echo getID($id,1);?>');return document.MM_returnValue" /><?php } ; ?>
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