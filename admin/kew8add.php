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
<?php include('../inc/liload.php');?>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
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
                        <td colspan="8"><strong><?php echo getFullNameByStafID($userid) . " (" . $userid . ")"; ?></strong>
                          <br/><?php echo getJobtitleReal($userid) . " (" . getGred($userid) . ")";?>
                          <br/><span class="txt_color1"><?php echo getFulldirectoryByUserID($userid);?></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Remark</td>
                        <td colspan="8"><span id="gredORmemangku">
                          <input name="userkewe_gred_memangku" type="text" class="w35" id="userkewe_gred_memangku" />
                        <div class="inputlabel2">Cth: MEMANGKU - S48 atau KUMPULAN A</div></span> 
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Rujukan</td>
                        <td colspan="8"><?php echo $userid . " / " . date('m') . " / " . date('Y') . " / " . getKew8Siri($userid);?><input name="userkewe_siri" type="hidden" value="<?php echo getKew8Siri($userid);?>" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Jenis<br />Perubahan</td>
                        <td colspan="8">
						  <?php
							mysql_select_db($database_hrmsdb, $hrmsdb);
							$query_kewetype = "SELECT * FROM kewe_type WHERE kewetype_status = 1 ORDER BY kewetype_name ASC";
							$kewetype = mysql_query($query_kewetype, $hrmsdb) or die(mysql_error());
							$row_kewetype = mysql_fetch_assoc($kewetype);
							$totalRows_kewetype = mysql_num_rows($kewetype);
							?>
                          <select name="kewe_id" id="kewe_id" onchange="dochange('25', 'userkewe_content', this.value, '0');">
                          <option selected="selected" value="">Sila Pilih </option>
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
                        <td colspan="8" name="userkewe_content" id="userkewe_content">
                          <span id="butiranperubahan"><span class="textareaRequiredMsg">Maklumat Diperlukan.</span>
                          <!-- <textarea name="userkewe_content" id="userkewe_content" cols="45" rows="6"></textarea> -->
                          <?php getEditor('userkewe_content', '1'); ?>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td nowrap="nowrap" colspan="1" style="width:5%"><input type="checkbox" id="tarikh1" name="tarikh1" onclick="myFunction()"></td>

                        <td nowrap="nowrap" style="width:25%">
                          <!-- <input style="width:10%" type="checkbox" id="tarikh1" name="tarikh1" onclick="myFunction()"> -->
                          <select name="userkewe_start_d" id="userkewe_start_d" style="display:none">
                            <?php for($i=0; $i<=31; $i++){?>
                            <option  value="<?php if($i<10) $i = "0" . $i; if($i==0) echo null;else echo $i?>"><?php if($i==0) echo 'Pilih Hari';else echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="userkewe_start_m" id="userkewe_start_m" style="display:none">
                            <?php for($j=0; $j<=12; $j++){?>
                            <option value="<?php if($j<10) $j = "0" . $j; if($j==0) echo null; else echo $j?>"><?php if($j==0) echo 'Pilih Bulan'; else echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="userkewe_start_y" id="userkewe_start_y" style="display:none">
                            <?php for($k=(date('Y')-6); $k<=(date('Y')+5); $k++){?>
                            <option value="<?php if($k==(date('Y')-6)) echo null; else echo $k;?>"><?php if($k==(date('Y')-6)) echo 'Pilih Tahun'; else echo $k;?></option>
                            <?php }; ?>
                          </select>
                        </td>
                        <td nowrap="nowrap" style="width:5%">sehingga</td>

                        <td nowrap="nowrap" style="width:5%"><input type="checkbox" id="tarikh2" name="tarikh2" onclick="myFunction2()"></td>
                        <td nowrap="nowrap" style="width:30%">
                          <select name="userkewe_end_d" id="userkewe_end_d" style="display:none">
                            <?php for($i=0; $i<=31; $i++){?>
                            <option  value="<?php if($i<10) $i = "0" . $i; if($i==0) echo null;else echo $i?>"><?php if($i==0) echo 'Pilih Hari';else echo $i;?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                          <select name="userkewe_end_m" id="userkewe_end_m" style="display:none">
                            <?php for($j=0; $j<=12; $j++){?>
                            <option value="<?php if($j<10) $j = "0" . $j; if($j==0) echo null; else echo $j?>"><?php if($j==0) echo 'Pilih Bulan'; else echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                          <select name="userkewe_end_y" id="userkewe_end_y" style="display:none">
                            <?php for($k=(date('Y')-6); $k<=(date('Y')+5); $k++){?>
                            <option value="<?php if($k==(date('Y')-6)) echo null; else echo $k;?>"><?php if($k==(date('Y')-6)) echo 'Pilih Tahun'; else echo $k;?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                        </td>
                        <td nowrap="nowrap">Catatan</td>
                        <td style="width:30%">
                        <textarea name="userkewe_note" id="userkewe_note" cols="45" rows="5"></textarea>
                        <?php getEditor('userkewe_note', '1'); ?>
                        <div class="inputlabel2">Catatan lain</div>
                        </td>
                      </tr>
                      <tr id="userkewe_salary_prev" name="userkewe_salary_prev">
                      
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Gaji Bulanan *</td>
                        <td colspan="8">
                        	<span id="gaji">
                            <span class="textfieldRequiredMsg">A value is required.</span>
                            <span class="inputlabel">RM</span><input name="userkewe_salary" type="text" class="w35" id="userkewe_salary" onchange="CommaFormatted()" value="<?php echo getBasicSalaryByUserID($userid, 1, date('m'), date('Y'));?>" />
                            </span></td>
                      </tr>
                      <tr id="userkewe_old">
                        <!-- disini akan appear emolumen lama jika dia pilih naik pangkat (SJKAS) -->
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Emolumen / Lain-lain</td>
                        <td nowrap="nowrap" style="text-align:right">Pilih Gred :</td>
                        <td colspan="1">
                              <select name="elaun" id="elaun" onchange="chooseElaun()">
                                <option value="">Pilih Gred</option>
                                <option value="ITKR &#009;&#009;: RM3,050.00 &#13;&#10;ITP &#009;&#009;&#009;: RM1,600.00 &#13;&#10;JUSA &#009;&#009;: RM1,500.00 &#13;&#10;PEM.RUMAH &#009;: RM500.00">Gred VU6 (UTAMA B)</option>
                                <option value="ITKR &#009;: RM800.00 &#13;&#10;ITP &#009;&#009;: RM900.00 &#13;&#10;BSH &#009;&#009;: RM300.00">Gred 54</option>
                                <option value="ITKR &#009;: RM600.00 &#13;&#10;ITP &#009;&#009;: RM700.00 &#13;&#10;BSH &#009;&#009;: RM300.00">Gred 52</option>
                                <option value="ITKR &#009;&#009;: RM2,050.00 &#13;&#10;ITP &#009;&#009;&#009;: RM1,300.00 &#13;&#10;JUSA &#009;&#009;: RM1,000.00 &#13;&#10;PEM.RUMAH &#009;: RM500.00">Gred VU7 (UTAMA C)</option>
                                <option value="ITKR &#009;: RM550.00 &#13;&#10;ITP &#009;&#009;: RM700.00 &#13;&#10;BSH &#009;&#009;: RM300.00">Gred 48</option>
                                <option value="ITKR &#009;: RM400.00 &#13;&#10;ITP &#009;&#009;: RM400.00 &#13;&#10;BSH &#009;&#009;: RM300.00">Gred 44</option>
                                <option value="ITKA &#009;: RM300.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM300.00">Gred 41</option>
                                <option value="ITKA &#009;: RM220.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM350.00">Gred 38</option>
                                <option value="ITKA &#009;: RM160.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM350.00">Gred 29 - 32</option>
                                <option value="ITKA &#009;: RM140.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM350.00">Gred 26</option>
                                <option value="ITKA &#009;: RM115.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM350.00">Gred 19 - 22</option>
                                <option value="ITKA &#009;: RM95.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM350.00">Gred 1 - 16</option>
                                <option value="ITKA &#009;: RM95.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM350.00">Gred 1 - 16</option>
                                <option value="ITKA &#009;: RM115.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM350.00">Gred KP19</option>
                                <option value="ITKA &#009;: RM115.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM350.00">Gred YA2</option>
                                <option value="ITKA &#009;: RM300.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM300.00">Gred DG41/DG42</option>
                                <option value="ITKA &#009;: RM400.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM300.00">Gred DG44</option>
                                <option value="ITKA &#009;: RM160.00 &#13;&#10;ITP &#009;&#009;: RM300.00 &#13;&#10;BSH &#009;&#009;: RM300.00">Gred DG32</option>
                              </select>
                        </td>
                        <td colspan="6">
                        <textarea name="userkewe_imbuhan" id="userkewe_imbuhan" cols="45" rows="5"></textarea>
                        <?php getEditor('userkewe_imbuhan', '1'); ?>
                        <div class="inputlabel2">Imbuhan / Emolument</div>
                        </td>
                      </tr>
                      <!-- <tr>
                        <td nowrap="nowrap" class="label">Tangga Gaji</td>
                        <td colspan="8"><label for="userkewe_salaryskill"></label>
                        <input name="userkewe_salaryskill" type="text" class="w35" id="userkewe_salaryskill" value="<?php echo getSalarySkill($userid, 0, date('m'), date('Y')); ?>" />
                        <div class="inputlabel2">Cth: P1 T1</div>
                        </td>
                      </tr> -->
                      <tr>
                        <td nowrap="nowrap" class="label">No. Surat<br />
                        Kebenaran *</td>
                        <td colspan="8">
                          <span id="noletterpermit"><span class="textfieldRequiredMsg">A value is required.</span>
                          <textarea type="text" name="userkewe_ref" id="userkewe_ref" cols="45" rows="3">MSNM: &#13;&#10;</textarea>
                        </span></td>
                        
                       
                        
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Surat<br />
                        Kebenaran *</td>
                        <td colspan="8"><span id="dateoflatterpermite"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="userkewe_refdate" type="date" class="w35" id="userkewe_refdate" />
                        <div class="inputlabel2">dd/mm/yyyy. Cth: 01/12/2012</div></span> 
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Kew8 *</td>
                        <td colspan="8"><span id="dateoflatterpermite"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="userkewe_refdatekewe" type="date" class="w35" id="userkewe_refdatekewe" />
                        <div class="inputlabel2">dd/mm/yyyy. Cth: 01/12/2012</div></span> 
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Tandatangan</td>
                        <td colspan="8"><span id="dateoflatterpermite"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="userkewe_signdate" type="date" class="w35" id="userkewe_signdate" value="<?php echo date('Y-m-d') ?>"/>
                        <div class="inputlabel2">dd/mm/yyyy. Cth: 01/12/2012</div></span> 
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Nama Pelulus <br />
                        Pertama *</td>
                        <td colspan="8">
                          <select name="userkewe_pelulus">
  							<option value="GHAZALI BAHARI">GHAZALI BAHARI </option>
                            <option value="SITI NUR AISHAH HANIM ZAIDON">SITI NUR AISHAH HANIM ZAIDON </option>
  							<option value="NOOR EMILIA OTHMAN">NOOR EMILIA OTHMAN</option>
                            <option value="HAZANI HASHIM">HAZANI HASHIM </option>
						</select>
                        </span></td>
                      </tr>
                        <tr>
                        <td nowrap="nowrap" class="label">Ringkasan Jawatan </td>
                        <td colspan="8">
                           <select name="userkewe_jawatan">
                           <option value="KCT(M)">KCT(M) </option>
                           <option value="KU(TM)">KU(TM)</option>
                           <option value="PPT(M2)">PPT(M2)</option>
  							<option value="PBT">PBT</option>
						</select>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Nama Ketua <br />
                        Jabatans *</td>
                        <td colspan="8">
                          <select name="userkewe_pelulus2">
  							<option value="GHAZALI BAHARI">GHAZALI BAHARI </option>
                            <option value="SITI NUR AISHAH HANIM ZAIDON">SITI NUR AISHAH HANIM ZAIDON </option>
  							<option value="NOOR EMILIA OTHMAN">NOOR EMILIA OTHMAN</option>
                            <option value="HAZANI HASHIM">HAZANI HASHIM </option>
						</select>
                        </span></td>
                      </tr>
                        <tr>
                        <td nowrap="nowrap" class="label">Ringkasan Jawatan </td>
                        <td colspan="8">
                           <select name="userkewe_jawatan2">
                           <option value="KCT(M)">KCT(M) </option>
                           <option value="KU(TM)">KU(TM)</option>
                           <option value="PT(M1)">PT(M1)</option>
                           <option value="PPT(M2)">PPT(M2)</option>
  							           <option value="PBT">PBT</option>
						</select>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline"><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $userid;?>" /></td>
                        <td colspan="8" class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" /> <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','kew8.php');return document.MM_returnValue" />
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

  function myFunction() {
    var checkBox = document.getElementById("tarikh1");
    var input1 = document.getElementById("userkewe_start_d");
    var input2 = document.getElementById("userkewe_start_m");
    var input3 = document.getElementById("userkewe_start_y");
    if (checkBox.checked == true){
      input1.style.display = "block";
      input2.style.display = "block";
      input3.style.display = "block";
    } else {
      input1.style.display = "none";
      input2.style.display = "none";
      input3.style.display = "none";
    }
  }

  function myFunction2() {
    var checkBox = document.getElementById("tarikh2");
    var input1 = document.getElementById("userkewe_end_d");
    var input2 = document.getElementById("userkewe_end_m");
    var input3 = document.getElementById("userkewe_end_y");
    if (checkBox.checked == true){
      input1.style.display = "block";
      input2.style.display = "block";
      input3.style.display = "block";
    } else {
      input1.style.display = "none";
      input2.style.display = "none";
      input3.style.display = "none";
    }
  }

  function chooseElaun() {
    // debugger;
    document.getElementById("userkewe_imbuhan").value = document.getElementById("elaun").value ;
  }

  function CommaFormatted() {
    var amount= document.getElementById("userkewe_salary").value;
    var amount2 = amount.replace(/,/g, '')
    document.getElementById("userkewe_salary").value= amount2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
</script>
</body>
</html>
<?php include('../inc/footinc.php');?> 