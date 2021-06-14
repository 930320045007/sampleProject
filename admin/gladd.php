<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='117';?>
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
            <div class="note">Surat Pengesahan Diri dan Pengakuan Pegawai -  </div>
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
                  <form id="form1" name="form1" method="POST" action="../sb/add_usergl.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Pegawai</td>
                        <td colspan="3"><strong><?php echo getFullNameByStafID($userid) . " (" . $userid . ")"; ?></strong>
                          <br/><?php echo getJobtitleReal($userid) . " (" . getGred($userid) . ")";?>
                          <br/><span class="txt_color1"><?php echo getFulldirectoryByUserID($userid);?></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Rujukan</td>
                        <td colspan="3"><?php echo $userid . " / " . date('m') . " / " . date('Y') . " / " . getGLSiri($userid);?><input name="usergl_siri" type="hidden" value="<?php echo getGLSiri($userid);?>" /></td>
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
                            $row_gl = mysql_fetch_assoc($relation);
                            $totalRows_relation = mysql_num_rows($relation);
                            ?>
                            
                          <?php if ($totalRows_relation > 0) { // Show if recordset not empty ?>
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_gl['relationship_id']?>"><?php echo $row_gl['relationship_name']?></option>
                            <?php
							} while ($row_gl = mysql_fetch_assoc($relation));
							  $rows = mysql_num_rows($relation);
							  if($rows > 0) {
								  mysql_data_seek($relation, 0);
								  $row_gltype = mysql_fetch_assoc($relation);
							  }
							?>
                          <?php } // Show if recordset not empty ?>
    						<?php
							} while ($row_gltype = mysql_fetch_assoc($kewetype));
							  $rows = mysql_num_rows($kewetype);
							  if($rows > 0) {
								  mysql_data_seek($kewetype, 0);
								  $row_gltype = mysql_fetch_assoc($kewetype);
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
                          <select name="usergl_name" id="usergl_name">
                            <?php
              do {  
              ?>
                            <?php
                            mysql_select_db($database_hrmsdb, $hrmsdb);
                            $query_relation = "SELECT * FROM user_dependents WHERE userdependents_status = 1 AND user_stafid = '" . $userid . "'";
                            $relation = mysql_query($query_relation, $hrmsdb) or die(mysql_error());
                            $row_gl = mysql_fetch_assoc($relation);
                            $totalRows_relation = mysql_num_rows($relation);
                            ?>
                            
                          <?php if ($totalRows_relation > 0) { // Show if recordset not empty ?>
                            <?php
              do {  
              ?>
                            <!-- <option value="<?php echo strtoupper($row_gl['userdependents_name'])?>"><?php echo $row_gl['userdependents_name']?></option> -->
                            <?php
              } while ($row_gl = mysql_fetch_assoc($relation));
                $rows = mysql_num_rows($relation);
                if($rows > 0) {
                  mysql_data_seek($relation, 0);
                  $row_gltype = mysql_fetch_assoc($relation);
                }
              ?>
                          <?php } // Show if recordset not empty ?>
                <?php
              } while ($row_gltype = mysql_fetch_assoc($kewetype));
                $rows = mysql_num_rows($kewetype);
                if($rows > 0) {
                  mysql_data_seek($kewetype, 0);
                  $row_gltype = mysql_fetch_assoc($kewetype);
                }
              ?>
                          </select>
                        <?php
                        mysql_free_result($relation);
            
                        ?></td>
                      </tr>
                      
                      <tr>
                        <td nowrap="nowrap" class="label">No Kad<br />
                        Pengenalan *</td>
                        <td colspan="3">
                          <select name="usergl_ic" id="usergl_ic">
                            <?php
              do {  
              ?>
                            <?php
                            mysql_select_db($database_hrmsdb, $hrmsdb);
                            $query_relation = "SELECT * FROM user_dependents WHERE userdependents_status = 1 AND user_stafid = '" . $userid . "'";
                            $relation = mysql_query($query_relation, $hrmsdb) or die(mysql_error());
                            $row_gl = mysql_fetch_assoc($relation);
                            $totalRows_relation = mysql_num_rows($relation);
                            ?>
                            
                          <?php if ($totalRows_relation > 0) { // Show if recordset not empty ?>
                            <?php
              do {  
              ?>
                            <!-- <option value="<?php echo strtoupper($row_gl['userdependents_ic'])?>"><?php echo $row_gl['userdependents_ic']?></option> -->
                            <?php
              } while ($row_gl = mysql_fetch_assoc($relation));
                $rows = mysql_num_rows($relation);
                if($rows > 0) {
                  mysql_data_seek($relation, 0);
                  $row_gltype = mysql_fetch_assoc($relation);
                }
              ?>
                          <?php } // Show if recordset not empty ?>
                <?php
              } while ($row_gltype = mysql_fetch_assoc($kewetype));
                $rows = mysql_num_rows($kewetype);
                if($rows > 0) {
                  mysql_data_seek($kewetype, 0);
                  $row_gltype = mysql_fetch_assoc($kewetype);
                }
              ?>
                          </select>
                        <?php
                        mysql_free_result($relation);
            
                        ?></td>
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
                            <option value="<?php echo $row_hos['hospital_id']?>"><?php echo $row_hos['hospital_name']?>, <?php echo getState($row_hos['state_id']);?></option>
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

                          <input type="hidden" name="usergl_hospital_id" id="usergl_hospital_id" value="<?php echo $row_hos['hospital_id']?>" />


                          <!-- <textarea name="usergl_hospital" id="usergl_hospital" cols="45" rows="5"></textarea> -->
                          <?php getEditor('usergl_hospital', '1'); ?>
                        </span></td>
                      </tr>
                      
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td nowrap="nowrap">
                          <select name="usergl_start_d" id="usergl_start_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = "0" . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="usergl_start_m" id="usergl_start_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="usergl_start_y" id="usergl_start_y">
                            <?php for($k=(date('Y')-5); $k<=(date('Y')+5); $k++){?>
                            <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
                          </select>
                        </td>
                        <td nowrap="nowrap">sehingga</td>
                        <td width="50%" nowrap="nowrap">
                          <select name="usergl_end_d" id="usergl_end_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = "0" . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                          <select name="usergl_end_m" id="usergl_end_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                          <select name="usergl_end_y" id="usergl_end_y">
                            <?php for($k=(date('Y')-5); $k<=(date('Y')+5); $k++){?>
                            <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Gaji Pokok *</td>
                        <td colspan="3">
                        	<span id="gaji">
                            <span class="textfieldRequiredMsg">A value is required.</span>
                            <span class="inputlabel">RM</span><input name="usergl_salary" type="text" class="w35" id="usergl_salary" onchange="CommaFormatted()" value="<?php echo getBasicSalaryByUserID($userid, 1, date('m'), date('Y'));?>" />
                            </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kelayakan Kelas Wad</td>
                        <td colspan="3">
                          <select name="usergl_salaryskill">
                            <option value="KELAS 1 BILIK 1">KELAS 1 BILIK 1 </option>
                            <option value="KELAS 1 BILIK 2">KELAS 1 BILIK 2</option>
                            <option value="KELAS 1 BILIK 3">KELAS 1 BILIK 3</option>
                            <option value="KELAS 2">KELAS 2</option>
						              </select>
                        <div class="inputlabel2">KELAS 1 BILIK 1 (GRED 45 KEATAS)</div></span>
                         <div class="inputlabel2">KELAS 1 BILIK 2 (GRED 31 - 44)</div></span> 
                          <div class="inputlabel2">KELAS 1 BILIK 3 (GRED 21 - 30)</div></span> 
                           <div class="inputlabel2">KELAS 2 (GRED 1 -20)</div></span>  
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Alamat Pejabat</td>
                        <td colspan="3">
                        <textarea name="usergl_pejabat" id="usergl_pejabat" cols="45" rows="5">MAJLIS SUKAN NEGARA, MALAYSIA,&#13;&#10;KOMPLEKS SUKAN NEGARA,&#13;&#10;57000 BUKIT JALIL,&#13;&#10;KUALA LUMPUR&#13;&#10;</textarea>
                        <?php getEditor('usergl_pejabat', '1'); ?>
                        <div class="inputlabel2">Nyatakan lokasi penempatan kakitangan</div>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Ruj Surat<br />
                        Kebenaran *</td>
                        <td colspan="3">
                          <span id="noletterpermit"><span class="textfieldRequiredMsg">A value is required.</span>
                          <input type="text" name="usergl_ref" id="usergl_ref" />
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Surat<br />
                        Kebenaran *</td>
                        <td colspan="3"><span id="dateoflatterpermite"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="usergl_refdate" type="date" class="w35" id="usergl_refdate" />
                        <div class="inputlabel2">dd/mm/yyyy. Cth: 01/12/2018</div></span> 
                        </td>
                      </tr>
                      
                      
                      <tr>
                        <td nowrap="nowrap" class="label">Nama Ketua<br />
                        Jabatan *</td>
                        <td colspan="3">
                          <select name="usergl_ketua">
  							<option value="GHAZALI BIN BAHARI">GHAZALI BIN BAHARI </option>
  							<option value="NOOR EMILIA BT OTHMAN">NOOR EMILIA BT OTHMAN</option>
  							<option value="SITI NUR AISHAH HANIM BT ZAIDON">SITI NUR AISHAH HANIM BT ZAIDON</option>
                            <option value="HAZANI BIN HASHIM">HAZANI BIN HASHIM </option>
						</select>
                        </span></td>
                      </tr>
                      
                       <tr>
                        <td nowrap="nowrap" class="label">Jawatan </td>
                        <td colspan="3">
                           <select name="usergl_jawatan">
                           <option value="PEGAWAI BELIA DAN SUKAN">PEGAWAI BELIA DAN SUKAN </option>
                           <option value="PENOLONG PEGAWAI BELIA DAN SUKAN">PENOLONG PEGAWAI BELIA DAN SUKAN</option>
                           <option value="PENGARAH BAHAGIAN KHIDMAT PENGURUSAN">PENGARAH BAHAGIAN KHIDMAT PENGURUSAN</option>
  							<option value="PEGAWAI TADBIR">PEGAWAI TADBIR</option>
						</select>
                        </span></td>
                      </tr>
                      
                       <tr>
                        <td nowrap="nowrap" class="label">No Telefon<br />
                        Ketua Jabatan *</td>
                        <td colspan="3">
                          <span id=""><span class="textfieldRequiredMsg">A value is required.</span> 
                          <input type="text" name="usergl_ketuaphone" id="usergl_ketuaphone" value="03-89929600"/> 
                        </span></td>
                      </tr>
                      
                      
                      
                      <tr>
                        <td nowrap="nowrap" class="label noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $userid;?>" /></td>
                        <td colspan="3" class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" /> <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','gl.php');return document.MM_returnValue" />
                    <input type="hidden" name="MM_insert" value="formusergl" /></td>
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

  function CommaFormatted() {
    var amount= document.getElementById("usergl_salary").value;
    var amount2 = amount.replace(/,/g, '')
    document.getElementById("usergl_salary").value= amount2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

</script>
</body>
</html>
<?php include('../inc/footinc.php');?> 

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<script type="text/javascript">
$( "#relationship_id" ).change(function() {
  var userdependents_relation=$('#relationship_id').val();
  $.post( "../inc/func_dependent.php", { user_stafid: "<?php echo $userid?>", userdependents_relation: userdependents_relation,column:'userdependents_name' })
  .done(function( data ) {
    $('#usergl_name').html(data);
    // alert( "Data Loaded: " + data );
  });
  $.post( "../inc/func_dependent.php", { user_stafid: "<?php echo $userid?>", userdependents_relation: userdependents_relation,column:'userdependents_ic' })
  .done(function( data ) {
    $('#usergl_ic').html(data);
    // alert( "Data Loaded: " + data );
  });

});

// $("#usergl_hospital").change(function(){
//   var usergl_hospital=$('#usergl_hospital').val();
//   debugger;
// })
</script>