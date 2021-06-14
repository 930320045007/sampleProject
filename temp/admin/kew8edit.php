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
<?php
	$userid = strtoupper($row_kew8['user_stafid']);
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
            <div class="note">Kemaskini penyata perubahan mengenai pendapatan seseorang pegawai</div>
                <li>
                  <form id="form1" name="form1" method="POST" action="../sb/update_userkewe.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Pegawai</td>
                        <td colspan="3"><strong><?php echo getFullNameByStafID($userid) . " (" . $userid . ")"; ?></strong>
                          <br/><?php echo getJobtitleReal($userid) . " (" . getGred($userid) . ")";?>
                          <br/><span class="txt_color1"><?php echo getFulldirectoryByUserID($userid);?></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Rujukan</td>
                        <td colspan="3"><?php echo $row_kew8['user_stafid'] . " / " . $row_kew8['userkewe_date_m'] . " / " . $row_kew8['userkewe_date_y'] . " / " . $row_kew8['userkewe_siri'];?></td>
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
                            <option <?php if($row_kewe['kewe_id']==$row_kew8['kewe_id']) echo "selected=\"selected\"";?> value="<?php echo $row_kewe['kewe_id']?>"><?php echo $row_kewe['kewe_name']?></option>
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
                          <textarea name="userkewe_content" id="userkewe_content" cols="45" rows="5"><?php echo $row_kew8['userkewe_content']; ?></textarea>
                          <?php getEditor('userkewe_content', '1'); ?>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td nowrap="nowrap">
                          <select name="userkewe_start_d" id="userkewe_start_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==$row_kew8['userkewe_start_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = "0" . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="userkewe_start_m" id="userkewe_start_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==$row_kew8['userkewe_start_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="userkewe_start_y" id="userkewe_start_y">
                            <?php for($k=(date('Y')-5); $k<=(date('Y')+5); $k++){?>
                            <option <?php if($k==$row_kew8['userkewe_start_y']) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
                          </select>
                        </td>
                        <td nowrap="nowrap">sehingga</td>
                        <td width="50%" nowrap="nowrap">
                          <select name="userkewe_end_d" id="userkewe_end_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==$row_kew8['userkewe_end_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = "0" . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                            <option <?php if($row_kew8['userkewe_end_d']==0) echo "selected=\"selected\"";?> value="0">Berterusan</option>
                          </select>
                          <select name="userkewe_end_m" id="userkewe_end_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==$row_kew8['userkewe_end_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                            <option <?php if($row_kew8['userkewe_end_m']==0) echo "selected=\"selected\"";?> value="0">Berterusan</option>
                          </select>
                          <select name="userkewe_end_y" id="userkewe_end_y">
                            <?php for($k=(date('Y')-5); $k<=(date('Y')+5); $k++){?>
                            <option <?php if($k==$row_kew8['userkewe_end_y']) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
                            <option <?php if($row_kew8['userkewe_end_y']==0) echo "selected=\"selected\"";?> value="0">Berterusan</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Gaji Bulanan *</td>
                        <td colspan="3">
                        	<span id="gaji">
                            <span class="textfieldRequiredMsg">A value is required.</span>
                            <span class="inputlabel">RM</span><input name="userkewe_salary" type="text" class="w35" id="userkewe_salary" value="<?php echo $row_kew8['userkewe_salary']; ?>" />
                            </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tangga Gaji</td>
                        <td colspan="3"><label for="userkewe_salaryskill"></label>
                        <input name="userkewe_salaryskill" type="text" class="w35" id="userkewe_salaryskill" value="<?php echo $row_kew8['userkewe_salaryskill']; ?>" />
                        <div class="inputlabel2">Cth: P1 T1</div>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3">
                        <textarea name="userkewe_note" id="userkewe_note" cols="45" rows="5"><?php echo $row_kew8['userkewe_note']; ?></textarea>
                        <?php getEditor('userkewe_note', '1'); ?>
                        <div class="inputlabel2">Emolumen dan sebagainya</div>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Surat<br />
                        Kebenaran *</td>
                        <td colspan="3">
                          <span id="noletterpermit"><span class="textfieldRequiredMsg">A value is required.</span>
                          <input name="userkewe_ref" type="text" id="userkewe_ref" value="<?php echo $row_kew8['userkewe_ref']; ?>" />
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Surat<br />
                        Kebenaran *</td>
                        <td colspan="3"><span id="dateoflatterpermite"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="userkewe_refdate" type="text" class="w35" id="userkewe_refdate" value="<?php echo $row_kew8['userkewe_refdate']; ?>" />
                        <div class="inputlabel2">dd/mm/yyyy. Cth: 01/12/2012</div></span> 
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline">
                          <input name="userkewe_id" type="hidden" id="userkewe_id" value="<?php echo $row_kew8['userkewe_id']; ?>" />
                          <input type="hidden" name="MM_update" value="formuserkewe" />
                        </td>
                        <td colspan="3" class="noline">
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" /> 
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','kew8detail.php?id=<?php echo getID($id,1);?>');return document.MM_returnValue" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php }; ?>
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
<?php
mysql_free_result($kew8);
?>
<?php include('../inc/footinc.php');?> 