<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='37';?>
<?php
if(isset($_POST['id']))
{
	$userid = strtoupper($_POST['id']);
} else {
	$userid = strtoupper($row_user['user_stafid']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
            <div class="note">Penyata perubahan mengenai pendapatan seseorang pegawai (Kew 8 - Pin 10/96)</div>
                <?php if(!isset($_POST['id'])){?>
            	<li>
                  <form id="form2" name="form2" method="post" action="">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="label noline">Staf ID</td>
                        <td width="100%" class="noline">
                        <input name="id" type="text" class="w35" id="id" list="datastaf1" />
                        <?php echo datalistStaf('datastaf1');?>
                        <input name="button5" type="submit" class="submitbutton" id="button5" value="Semak" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php } else { ?>
                <li>
                  <form id="form1" name="form1" method="POST" action="../sb/add_userkewe.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Pegawai</td>
                        <td colspan="3"><strong><?php echo getFullNameByStafID($userid) . " (" . $userid . ")"; ?></strong>
                          <br/><?php echo getJobtitleReal($userid) . " (" . getGred($userid) . ")";?>
                          <br/><span class="txt_color1"><?php echo getFulldirectoryByUserID($userid);?></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Rujukan</td>
                        <td colspan="3"><?php echo $userid . " / " . date('m') . " / " . date('Y') . " / " . getKew8Siri($userid);?><input name="userkewe_siri" type="hidden" value="<?php echo getKew8Siri($userid);?>" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Jenis<br />Perubahan</td>
                        <td colspan="3">
						  <?php
							mysql_select_db($database_hrmsdb, $hrmsdb);
							$query_kewetype = "SELECT * FROM kewe_type WHERE kewetype_status = 1 ORDER BY kewetype_name ASC";
							$kewetype = mysql_query($query_kewetype, $hrmsdb) or die(mysql_error());
							$row_kewetype = mysql_fetch_assoc($kewetype);
							$totalRows_kewetype = mysql_num_rows($kewetype);
							?>
                          <select name="kewe_id" id="kewe_id">
                            <?php
							do {  
							?>
                            <?php
                            mysql_select_db($database_hrmsdb, $hrmsdb);
                            $query_kewe = "SELECT * FROM kewe WHERE kewe_status = 1 AND kewetype_id='" . $row_kewetype['kewetype_id'] . "' ORDER BY kewetype_id ASC";
                            $kewe = mysql_query($query_kewe, $hrmsdb) or die(mysql_error());
                            $row_kewe = mysql_fetch_assoc($kewe);
                            $totalRows_kewe = mysql_num_rows($kewe);
                            ?>
                            <option class="back_darkgrey" disabled="disabled" value="<?php echo $row_kewetype['kewetype_id']?>"><?php echo $row_kewetype['kewetype_name']?></option>
                          <?php if ($totalRows_kewe > 0) { // Show if recordset not empty ?>
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_kewe['kewe_id']?>"><?php echo $row_kewe['kewe_name']?></option>
                            <?php
							} while ($row_kewe = mysql_fetch_assoc($kewe));
							  $rows = mysql_num_rows($kewe);
							  if($rows > 0) {
								  mysql_data_seek($kewe, 0);
								  $row_kewetype = mysql_fetch_assoc($kewe);
							  }
							?>
                          <?php } // Show if recordset not empty ?>
    						<?php
							} while ($row_kewetype = mysql_fetch_assoc($kewetype));
							  $rows = mysql_num_rows($kewetype);
							  if($rows > 0) {
								  mysql_data_seek($kewetype, 0);
								  $row_kewetype = mysql_fetch_assoc($kewetype);
							  }
							?>
                          </select>
                        <?php
                        mysql_free_result($kewe);
						mysql_free_result($kewetype);
                        ?></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Butiran<br />
                        Perubahan *</td>
                        <td colspan="3">
                          <span id="butiranperubahan"><span class="textareaRequiredMsg">Maklumat Diperlukan.</span>
                          <textarea name="userkewe_content" id="userkewe_content" cols="45" rows="5"></textarea>
                          <?php getEditor('userkewe_content', '1'); ?>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td nowrap="nowrap">
                          <select name="userkewe_start_d" id="userkewe_start_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = "0" . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="userkewe_start_m" id="userkewe_start_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="userkewe_start_y" id="userkewe_start_y">
                            <?php for($k=(date('Y')-5); $k<=(date('Y')+5); $k++){?>
                            <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
                          </select>
                        </td>
                        <td nowrap="nowrap">sehingga</td>
                        <td width="50%" nowrap="nowrap">
                          <select name="userkewe_end_d" id="userkewe_end_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = "0" . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                          <select name="userkewe_end_m" id="userkewe_end_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                          <select name="userkewe_end_y" id="userkewe_end_y">
                            <?php for($k=(date('Y')-5); $k<=(date('Y')+5); $k++){?>
                            <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Gaji Bulanan *</td>
                        <td colspan="3">
                        	<span id="gaji">
                            <span class="textfieldRequiredMsg">A value is required.</span>
                            <span class="inputlabel">RM</span><input name="userkewe_salary" type="text" class="w35" id="userkewe_salary" value="<?php echo getBasicSalaryByUserID($userid, 1, date('m'), date('Y'));?>" />
                            </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tangga Gaji</td>
                        <td colspan="3"><label for="userkewe_salaryskill"></label>
                        <input name="userkewe_salaryskill" type="text" class="w35" id="userkewe_salaryskill" value="<?php echo getSalarySkill($userid, 0, date('m'), date('Y')); ?>" />
                        <div class="inputlabel2">Cth: P1 T1</div>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3">
                        <textarea name="userkewe_note" id="userkewe_note" cols="45" rows="5"></textarea>
                        <?php getEditor('userkewe_note', '1'); ?>
                        <div class="inputlabel2">Emolumen dan sebagainya</div>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Surat<br />
                        Kebenaran *</td>
                        <td colspan="3">
                          <span id="noletterpermit"><span class="textfieldRequiredMsg">A value is required.</span>
                          <input type="text" name="userkewe_ref" id="userkewe_ref" />
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Surat<br />
                        Kebenaran *</td>
                        <td colspan="3"><span id="dateoflatterpermite"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="userkewe_refdate" type="text" class="w35" id="userkewe_refdate" />
                        <div class="inputlabel2">dd/mm/yyyy. Cth: 01/12/2012</div></span> 
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $userid;?>" /></td>
                        <td colspan="3" class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" /> <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','kew8.php');return document.MM_returnValue" />
                    <input type="hidden" name="MM_insert" value="formuserkewe" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php }; ?>
            <?php } ; ?>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("butiranperubahan");
var sprytextfield1 = new Spry.Widget.ValidationTextField("dateoflatterpermite", "none", {hint:"dd/mm/yyyy"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("gaji", "none");
var sprytextfield3 = new Spry.Widget.ValidationTextField("noletterpermit");
</script>
</body>
</html>
<?php include('../inc/footinc.php');?> 