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
<?php
	$userid = strtoupper($row_gl['user_stafid']);
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
            <div class="note">Kemaskini Surat Pengesahan Diri dan Pengakuan Pegawai -  </div>
                <li>
                  <form id="form1" name="form1" method="POST" action="../sb/update_usergl.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Pegawai</td>
                        <td colspan="3"><strong><?php echo getFullNameByStafID($userid) . " (" . $userid . ")"; ?></strong>
                          <br/><?php echo getJobtitleReal($userid) . " (" . getGred($userid) . ")";?>
                          <br/><span class="txt_color1"><?php echo getFulldirectoryByUserID($userid);?></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Rujukan</td>
                        <td colspan="3"><?php echo $row_gl['user_stafid'] . " / " . $row_gl['usergl_date_m'] . " / " . $row_gl['usergl_date_y'] . " / " . $row_gl['usergl_siri'];?></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Jenis<br />Perhubungan</td>
                        <td colspan="3">
						  
                          <select name="relationship_id" id="relationship_id">
                            <?php
							do {  
							?>
                            <?php
                            mysql_select_db($database_hrmsdb, $hrmsdb);
                            $query_relation = "SELECT * FROM relationship WHERE relationship_status = 1 ";
                            $relation = mysql_query($query_relation, $hrmsdb) or die(mysql_error());
                            $row_relation = mysql_fetch_assoc($relation);
                            $totalRows_relation = mysql_num_rows($relation);
                            ?>
                            
                          <?php if ($totalRows_relation > 0) { // Show if recordset not empty ?>
                            <?php
							do {  
							?>
                            <option <?php if($row_relation['relationship_id']==$row_gl['relationship_id']) echo "selected=\"selected\"";?> value="<?php echo $row_relation['relationship_id']?>"><?php echo $row_relation['relationship_name']?></option>
                            <?php
							} while ($row_relation = mysql_fetch_assoc($relation));
							  $rows = mysql_num_rows($relation);
							  if($rows > 0) {
								  mysql_data_seek($relation, 0);
								  $row_kewetype = mysql_fetch_assoc($relation);
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
                        mysql_free_result($relation);
						
                        ?></td>
                      </tr>

                      <tr>
                        <td nowrap="nowrap" class="label">Nama Ahli<br />
                        Keluarga *</td>
                        <td colspan="3">
                          <span id="butiranperubahan"><span class="textareaRequiredMsg">Maklumat Diperlukan.</span>
                          <input name="usergl_name" type="text" class="w35" id="usergl_name" value=" <?php echo $row_gl['usergl_name']; ?>" />
                          <?php getEditor('usergl_name', '1'); ?>
                        </span></td>
                      </tr>
                      
                      <tr>
                        <td nowrap="nowrap" class="label">No Kad<br />
                        Pengenalan *</td>
                        <td colspan="3">
                          <span id="butiranperubahan1"><span class="textareaRequiredMsg">Maklumat Diperlukan.</span>
                          <input name="usergl_ic" type="text" class="w35" id="usergl_ic" value="<?php echo $row_gl['usergl_ic']; ?>" />
                          <?php getEditor('usergl_ic', '1'); ?>
                        </span></td>
                      </tr>
                      
                     
                      
                      <tr>
                        <td nowrap="nowrap" class="label">Butiran<br />
                        Hospital *</td>
                        <td colspan="3">
                          <span id="butiranperubahan"><span class="textareaRequiredMsg">Maklumat Diperlukan.</span>


                          <select name="usergl_hospital" id="usergl_hospital">
                            <?php
							do {  
							?>
                            <?php
                            mysql_select_db($database_hrmsdb, $hrmsdb);
                            $query_hospital = "SELECT * FROM hospital WHERE hospital_status = 1 ";
                            $hospital = mysql_query($query_hospital, $hrmsdb) or die(mysql_error());
                            $row_hos = mysql_fetch_assoc($hospital);
                            $totalRows_hospital = mysql_num_rows($hospital);
                            ?>
                            
                          <?php if ($totalRows_hospital > 0) { // Show if recordset not empty ?>
                            <?php
							do {  
							?>
                            <option <?php if($row_hos['hospital_id']==$row_gl['usergl_hospital']) echo "selected=\"selected\"";?> value="<?php echo $row_hos['hospital_id']?>"><?php echo $row_hos['hospital_name']?>, <?php echo getState($row_hos['state_id']);?></option>
                            <?php
							} while ($row_hos = mysql_fetch_assoc($hospital));
							  $rows = mysql_num_rows($hospital);
							  if($rows > 0) {
								  mysql_data_seek($hospital, 0);
								  $row_hostype = mysql_fetch_assoc($hospital);
							  }
							?>
                          <?php } // Show if recordset not empty ?>
    						<?php
							} while ($row_hostype = mysql_fetch_assoc($kewetype));
							  $rows = mysql_num_rows($kewetype);
							  if($rows > 0) {
								  mysql_data_seek($kewetype, 0);
								  $row_hostype = mysql_fetch_assoc($kewetype);
							  }
							?>
                          </select>


                          <!-- <textarea name="usergl_hospital" id="usergl_hospital" cols="45" rows="5"><?php echo $row_gl['usergl_hospital']; ?></textarea> -->
                          <?php getEditor('usergl_hospital', '1'); ?>
                        </span></td>
                      </tr>
                      
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td nowrap="nowrap">
                          <select name="usergl_start_d" id="usergl_start_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==$row_gl['usergl_start_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = "0" . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="usergl_start_m" id="usergl_start_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==$row_gl['usergl_start_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="usergl_start_y" id="usergl_start_y">
                            <?php for($k=(date('Y')-5); $k<=(date('Y')+5); $k++){?>
                            <option <?php if($k==$row_gl['usergl_start_y']) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
                          </select>
                        </td>
                        <td nowrap="nowrap">sehingga</td>
                        <td width="50%" nowrap="nowrap">
                          <select name="usergl_end_d" id="usergl_end_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==$row_gl['usergl_end_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = "0" . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                            <option <?php if($row_gl['usergl_end_d']==0) echo "selected=\"selected\"";?> value="0">Berterusan</option>
                          </select>
                          <select name="usergl_end_m" id="usergl_end_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==$row_gl['usergl_end_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                            <option <?php if($row_gl['usergl_end_m']==0) echo "selected=\"selected\"";?> value="0">Berterusan</option>
                          </select>
                          <select name="usergl_end_y" id="usergl_end_y">
                            <?php for($k=(date('Y')-5); $k<=(date('Y')+5); $k++){?>
                            <option <?php if($k==$row_gl['usergl_end_y']) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
                            <option <?php if($row_gl['usergl_end_y']==0) echo "selected=\"selected\"";?> value="0">Berterusan</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Gaji Pokok *</td>
                        <td colspan="3">
                        	<span id="gaji">
                            <span class="textfieldRequiredMsg">A value is required.</span>




                            <?php 
                                setlocale(LC_MONETARY,"en_US");
                            ?>
                            <span class="inputlabel">RM</span><input name="usergl_salary" type="text" class="w35" id="usergl_salary" onchange="CommaFormatted()" value="<?php echo $row_gl['usergl_salary']; ?>" />
                            </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kelayakan Kelas Wad</td>
                        <td colspan="3">
                         <select name="usergl_salaryskill" id="usergl_salaryskill">
                	            <option value="KELAS 1 BILIK 1" <?php if (!(strcmp("KELAS 1 BILIK 1", $row_gl['usergl_salaryskill']))) {echo "selected=\"selected\"";} ?>>KELAS 1 BILIK 1</option>
                	            <option value="KELAS 1 BILIK 2" <?php if (!(strcmp("KELAS 1 BILIK 2", $row_gl['usergl_salaryskill']))) {echo "selected=\"selected\"";} ?>>KELAS 1 BILIK 2</option>
                                <option value="KELAS 1 BILIK 3" <?php if (!(strcmp("KELAS 1 BILIK 3", $row_gl['usergl_salaryskill']))) {echo "selected=\"selected\"";} ?>>KELAS 1 BILIK 3</option>
                                 <option value="KELAS 2" <?php if (!(strcmp("KELAS 2", $row_gl['usergl_salaryskill']))) {echo "selected=\"selected\"";} ?>>KELAS 2</option>
              	            </select>
                            <div class="inputlabel2">KELAS 1 BILIK 1 (GRED 45 KEATAS)</div></span>
                         <div class="inputlabel2">KELAS 1 BILIK 2 (GRED 31 - 44)</div></span> 
                          <div class="inputlabel2">KELAS 1 BILIK 3 (GRED 21 - 30)</div></span> 
                           <div class="inputlabel2">KELAS 2 (GRED 1 -20)</div></span>  
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Alamat Pejabat</td>
                        <td colspan="3">
                        <textarea name="usergl_pejabat" id="usergl_pejabat" cols="45" rows="5"><?php echo $row_gl['usergl_pejabat']; ?></textarea>
                        <?php getEditor('usergl_pejabat', '1'); ?>
                        <div class="inputlabel2">Nyatakan lokasi penempatan kakitangan</div>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Ruj Surat<br />
                        Kebenaran *</td>
                        <td colspan="3">
                          <span id="noletterpermit"><span class="textfieldRequiredMsg">A value is required.</span>
                          <input name="usergl_ref" type="text" id="usergl_ref" value="<?php echo $row_gl['usergl_ref']; ?>" />
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Surat<br />
                        Kebenaran *</td>
                        <td colspan="3"><span id="dateoflatterpermite"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="usergl_refdate" type="date" class="w35" id="usergl_refdate" value="<?php echo $row_gl['usergl_refdate']; ?>" />
                        <div class="inputlabel2">dd/mm/yyyy. Cth: 01/12/2012</div></span> 
                        </td>
                      </tr>
                      
                      
                      <tr>
                        <td nowrap="nowrap" class="label">Nama Ketua<br />
                        Jabatan *</td>
                        <td colspan="3">
                           
                        <select name="usergl_ketua" id="usergl_ketua">
                	            <option value="GHAZALI BIN BAHARI" <?php if (!(strcmp("GHAZALI BIN BAHARI", $row_gl['usergl_ketua']))) {echo "selected=\"selected\"";} ?>>GHAZALI BIN BAHARI</option>
                	            <option value="NOOR EMILIA BT OTHMAN" <?php if (!(strcmp("NOOR EMILIA BT OTHMAN", $row_gl['usergl_ketua']))) {echo "selected=\"selected\"";} ?>>NOOR EMILIA BT OTHMAN</option>
                                <option value="SITI NUR AISHAH HANIM BT ZAIDON" <?php if (!(strcmp("SITI NUR AISHAH HANIM BT ZAIDON", $row_gl['usergl_ketua']))) {echo "selected=\"selected\"";} ?>>SITI NUR AISHAH HANIM BT ZAIDON</option>
                                <option value="HAZANI BIN HASHIM" <?php if (!(strcmp("HAZANI BIN HASHIM", $row_gl['usergl_ketua']))) {echo "selected=\"selected\"";} ?>>HAZANI BIN HASHIM</option>
                                <option value="EZUIN BT SOBRI" <?php if (!(strcmp("EZUIN BT SOBRI", $row_gl['usergl_ketua']))) {echo "selected=\"selected\"";} ?>>EZUIN BT SOBRI </option>
                                
              	            </select>
                        </span></td>
                      </tr>
                      
                      <tr>
                        <td nowrap="nowrap" class="label">Jawatan *</td>
                        <td colspan="3">
                          <select name="usergl_jawatan" id="usergl_jawatan">
                	            <option value="PEGAWAI BELIA DAN SUKAN" <?php if (!(strcmp("PEGAWAI BELIA DAN SUKAN", $row_gl['usergl_jawatan']))) {echo "selected=\"selected\"";} ?>>PEGAWAI BELIA DAN SUKAN</option>
                	            <option value="PENOLONG PEGAWAI BELIA DAN SUKAN" <?php if (!(strcmp("PENOLONG PEGAWAI BELIA DAN SUKAN", $row_gl['usergl_jawatan']))) {echo "selected=\"selected\"";} ?>>PENOLONG PEGAWAI BELIA DAN SUKAN</option>
                                <option value="PENGARAH BAHAGIAN KHIDMAT PENGURUSAN" <?php if (!(strcmp("PENGARAH BAHAGIAN KHIDMAT PENGURUSAN", $row_gl['usergl_jawatan']))) {echo "selected=\"selected\"";} ?>>PENGARAH BAHAGIAN KHIDMAT PENGURUSAN</option>
                                 <option value="PEGAWAI TADBIR" <?php if (!(strcmp("PEGAWAI TADBIR", $row_gl['usergl_jawatan']))) {echo "selected=\"selected\"";} ?>>PEGAWAI TADBIR</option>
              	            </select>
                        </span></td>
                      </tr>
                      
                      <tr>
                        <td nowrap="nowrap" class="label">No Telefon<br />
                        Ketua Jabatan *</td>
                        <td colspan="3">
                          <span id=""><span class="textfieldRequiredMsg">A value is required.</span>
                          <input name="usergl_ketuaphone" type="text" id="usergl_ketuaphone" value="<?php echo $row_gl['usergl_ketuaphone']; ?>" />
                        </span></td>
                      </tr>
                      
                      <tr>
                        <td nowrap="nowrap" class="label noline">
                          <input name="usergl_id" type="hidden" id="usergl_id" value="<?php echo $row_gl['usergl_id']; ?>" />
                          <input type="hidden" name="MM_update" value="formusergl" />
                        </td>
                        <td colspan="3" class="noline">
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" /> 
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','gldetail.php?id=<?php echo getID($id,1);?>');return document.MM_returnValue" /></td>
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

  function CommaFormatted() {
    var amount= document.getElementById("usergl_salary").value;
    var amount2 = amount.replace(/,/g, '')
    document.getElementById("usergl_salary").value= amount2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
</script>
</body>
</html>
<?php
mysql_free_result($gl);
?>
<?php include('../inc/footinc.php');?> 