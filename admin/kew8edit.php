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
                        <td colspan="8"><strong><?php echo getFullNameByStafID($userid) . " (" . $userid . ")"; ?></strong>
                          <br/><?php echo getJobtitleReal($userid) . " (" . getGred($userid) . ")";?>
                          <br/><span class="txt_color1"><?php echo getFulldirectoryByUserID($userid);?></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Remark</td>
                        <td colspan="8"><span id="gredORmemangku">
                          <input name="userkewe_gred_memangku" type="text" class="w35" id="userkewe_gred_memangku" value="<?php echo $row_kew8['userkewe_gred_memangku']; ?>" />
                        <div class="inputlabel2">Cth: MEMANGKU - S48 atau KUMPULAN A</div></span> 
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No. Rujukan</td>
                        <td colspan="8"><?php echo $row_kew8['user_stafid'] . " / " . $row_kew8['userkewe_date_m'] . " / " . $row_kew8['userkewe_date_y'] . " / " . $row_kew8['userkewe_siri'];?></td>
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
                        <td colspan="8">
                          <span id="butiranperubahan"><span class="textareaRequiredMsg">Maklumat Diperlukan.</span>
                          <textarea name="userkewe_content" id="userkewe_content" cols="45" rows="5"><?php echo $row_kew8['userkewe_content']; ?>&#13;&#10;</textarea>
                          <?php getEditor('userkewe_content', '1'); ?>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td colspan="1" nowrap="nowrap" style="width:5%"><input style="width:auto" type="checkbox" id="tarikh1" name="tarikh1" onclick="myFunction()" <?php if($row_kew8['userkewe_start_d'] != null) echo "checked"; ?>></td>

                        

                        <td nowrap="nowrap" style="width:25%">
                          <select name="userkewe_start_d" id="userkewe_start_d" style="display:none">
                            <?php for($i=0; $i<=31; $i++){?>
                            <option <?php if($i==$row_kew8['userkewe_start_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = "0" . $i;if($i==0) echo null;else echo $i;?>"><?php if($i==0) echo 'Pilih Hari';else echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="userkewe_start_m" id="userkewe_start_m" style="display:none">
                            <?php for($j=0; $j<=12; $j++){?>
                            <option <?php if($j==$row_kew8['userkewe_start_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; if($j==0) echo null; else echo $j;?>"><?php if($j==0) echo 'Pilih Bulan'; else echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="userkewe_start_y" id="userkewe_start_y" style="display:none">
                            <?php for($k=(date('Y')-6); $k<=(date('Y')+5); $k++){?>
                            <option <?php if($k==$row_kew8['userkewe_start_y']) echo "selected=\"selected\"";?> value="<?php if($k==(date('Y')-6)) echo null; else echo $k;?>"><?php if($k==(date('Y')-6)) echo 'Pilih Tahun'; else echo $k;?></option>
                            <?php }; ?>
                          </select>
                        </td>
                        <td nowrap="nowrap" style="width:5%">sehingga</td>
                        <td nowrap="nowrap" style="width:5%"><input type="checkbox" id="tarikh2" name="tarikh2" onclick="myFunction2()" <?php if($row_kew8['userkewe_end_d'] != null) echo "checked"; ?>></td>

                        <td style="width:30%" nowrap="nowrap">
                          <select name="userkewe_end_d" id="userkewe_end_d" style="display:none">
                            <?php for($i=0; $i<=31; $i++){?>
                            <option <?php if($i==$row_kew8['userkewe_end_d']) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = "0" . $i; if($i==0) echo null;else echo $i;?>"><?php if($i==0) echo 'Pilih Hari';else echo $i;?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                          <select name="userkewe_end_m" id="userkewe_end_m" style="display:none">
                            <?php for($j=0; $j<=12; $j++){?>
                            <option <?php if($j==$row_kew8['userkewe_end_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = "0" . $j; if($j==0) echo null; else echo $j;?>"><?php if($j==0) echo 'Pilih Bulan'; else echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                          <select name="userkewe_end_y" id="userkewe_end_y" style="display:none">
                            <?php for($k=(date('Y')-6); $k<=(date('Y')+5); $k++){?>
                            <option <?php if($k==$row_kew8['userkewe_end_y']) echo "selected=\"selected\"";?> value="<?php if($k==(date('Y')-6)) echo null; else echo $k;?>"><?php if($k==(date('Y')-6)) echo 'Pilih Tahun'; else echo $k;?></option>
                            <?php }; ?>
                            <option value="0">Berterusan</option>
                          </select>
                        </td>
                        <td nowrap="nowrap">Catatan</td>
                        <td style="width:30%">
                        <textarea name="userkewe_note" id="userkewe_note" cols="45" rows="5"><?php echo $row_kew8['userkewe_note']; ?></textarea>
                        <?php getEditor('userkewe_note', '1'); ?>
                        <div class="inputlabel2">Catatan lain</div>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Gaji Bulanan *</td>
                        <td colspan="8">
                        	<span id="gaji">
                            <span class="textfieldRequiredMsg">A value is required.</span>
                            <span class="inputlabel">RM</span><input name="userkewe_salary" type="text" class="w35" id="userkewe_salary" onchange="CommaFormatted()" value="<?php echo $row_kew8['userkewe_salary']; ?>" />
                            </span></td>
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
                        <textarea name="userkewe_imbuhan" id="userkewe_imbuhan" cols="45" rows="5"><?php echo $row_kew8['userkewe_imbuhan']; ?></textarea>
                        <?php getEditor('userkewe_imbuhan', '1'); ?>
                        <div class="inputlabel2">Emolumen dan sebagainya</div>
                        </td>
                      </tr>
                      <!-- <tr>
                        <td nowrap="nowrap" class="label">Tangga Gaji</td>
                        <td colspan="8"><label for="userkewe_salaryskill"></label>
                        <input name="userkewe_salaryskill" type="text" class="w35" id="userkewe_salaryskill" value="<?php echo $row_kew8['userkewe_salaryskill']; ?>" />
                        <div class="inputlabel2">Cth: P1 T1</div>
                        </td>
                      </tr> -->
                      <!-- <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="8">
                        <textarea name="userkewe_note" id="userkewe_note" cols="45" rows="5"><?php echo $row_kew8['userkewe_note']; ?></textarea>
                        <?php getEditor('userkewe_note', '1'); ?>
                        <div class="inputlabel2">Catatan lain</div>
                        </td>
                      </tr>
                      <tr> -->
                        <td nowrap="nowrap" class="label">No. Surat<br />
                        Kebenaran *</td>
                       
                        
                        <td colspan="8">
                          <span id="noletterpermit"><span class="textareaRequiredMsg">Maklumat Diperlukan.</span>
                          <textarea name="userkewe_ref" id="userkewe_ref" cols="45" rows="3"><?php echo $row_kew8['userkewe_ref']; ?></textarea>
                          <?php getEditor('userkewe_ref', '1'); ?>
                        </span></td>
                        
                        
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Surat<br />
                        Kebenaran *</td>
                        <td colspan="8"><span id="dateoflatterpermite"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="userkewe_refdate" type="date" class="w35" id="userkewe_refdate" value="<?php echo $row_kew8['userkewe_refdate']; ?>" />
                        <div class="inputlabel2">dd/mm/yyyy. Cth: 01/12/2012</div></span> 
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Kew*</td>
                        <td colspan="8"><span id="dateoflatterpermite"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="userkewe_refdatekewe" type="date" class="w35" id="userkewe_refdatekewe" value="<?php echo $row_kew8['userkewe_refdatekewe']; ?>" />
                        <div class="inputlabel2">dd/mm/yyyy. Cth: 01/12/2012</div></span> 
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Tandatangan</td>
                        <td colspan="8"><span id="dateoflatterpermite"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <input name="userkewe_signdate" type="date" class="w35" id="userkewe_signdate" value="<?php echo $row_kew8['userkewe_date_y'].'-'.$row_kew8['userkewe_date_m'].'-'.$row_kew8['userkewe_date_d']; ?>" />
                        <div class="inputlabel2">dd/mm/yyyy. Cth: 01/12/2012</div></span> 
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Nama Pelulus<br />
                        Pertama *</td>
                        <td colspan="8">
                           
                        <select name="userkewe_pelulus" id="userkewe_pelulus">
                	            <option value="GHAZALI BAHARI" <?php if (!(strcmp("GHAZALI BAHARI", $row_kew8['userkewe_pelulus']))) {echo "selected=\"selected\"";} ?>>GHAZALI BAHARI</option>
                	            <option value="NOOR EMILIA OTHMAN" <?php if (!(strcmp("NOOR EMILIA OTHMAN", $row_kew8['userkewe_pelulus']))) {echo "selected=\"selected\"";} ?>>NOOR EMILIA OTHMAN</option>
                                <option value="SITI NUR AISHAH HANIM ZAIDON" <?php if (!(strcmp("SITI NUR AISHAH HANIM ZAIDON", $row_kew8['userkewe_pelulus']))) {echo "selected=\"selected\"";} ?>>SITI NUR AISHAH HANIM ZAIDON</option>
                                <option value="HAZANI HASHIM" <?php if (!(strcmp("HAZANI HASHIM", $row_kew8['userkewe_pelulus']))) {echo "selected=\"selected\"";} ?>>HAZANI HASHIM</option>

              	            </select>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Ringkasan Jawatan *</td>
                        <td colspan="8">
                          <select name="userkewe_jawatan" id="userkewe_jawatan">
                	            <option value="KCT(M)" <?php if (!(strcmp("KCT(M)", $row_kew8['userkewe_jawatan']))) {echo "selected=\"selected\"";} ?>>KCT(M)</option>
                	            <option value="KU(TM)" <?php if (!(strcmp("KU(TM)", $row_kew8['userkewe_jawatan']))) {echo "selected=\"selected\"";} ?>>KU(TM)</option>
                                <option value="PPT(M2)" <?php if (!(strcmp("PPT(M2)", $row_kew8['userkewe_jawatan']))) {echo "selected=\"selected\"";} ?>>PPT(M2)</option>
                                 <option value="PBT" <?php if (!(strcmp("PBT", $row_kew8['userkewe_jawatan']))) {echo "selected=\"selected\"";} ?>>PBT</option>
              	            </select>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Nama Ketua<br />
                        Jabatan *</td>
                        <td colspan="8">
                           
                        <select name="userkewe_pelulus2" id="userkewe_pelulus2">
                              <option value="GHAZALI BAHARI" <?php if (!(strcmp("GHAZALI BAHARI", $row_kew8['userkewe_pelulus2']))) {echo "selected=\"selected\"";} ?>>GHAZALI BAHARI</option>
                              <option value="NOOR EMILIA OTHMAN" <?php if (!(strcmp("NOOR EMILIA OTHMAN", $row_kew8['userkewe_pelulus2']))) {echo "selected=\"selected\"";} ?>>NOOR EMILIA OTHMAN</option>
                                <option value="SITI NUR AISHAH HANIM ZAIDON" <?php if (!(strcmp("SITI NUR AISHAH HANIM ZAIDON", $row_kew8['userkewe_pelulus2']))) {echo "selected=\"selected\"";} ?>>SITI NUR AISHAH HANIM ZAIDON</option>
                                <option value="HAZANI HASHIM" <?php if (!(strcmp("HAZANI HASHIM", $row_kew8['userkewe_pelulus2']))) {echo "selected=\"selected\"";} ?>>HAZANI HASHIM</option>

                            </select>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Ringkasan Jawatan *</td>
                        <td colspan="8">
                          <select name="userkewe_jawatan2" id="userkewe_jawatan2">
                              <option value="KCT(M)" <?php if (!(strcmp("KCT(M)", $row_kew8['userkewe_jawatan2']))) {echo "selected=\"selected\"";} ?>>KCT(M)</option>
                              <option value="KU(TM)" <?php if (!(strcmp("KU(TM)", $row_kew8['userkewe_jawatan2']))) {echo "selected=\"selected\"";} ?>>KU(TM)</option>
                              <option value="PT(M1)" <?php if (!(strcmp("PT(M1)", $row_kew8['userkewe_jawatan2']))) {echo "selected=\"selected\"";} ?>>PT(M1)</option>
                                <option value="PPT(M2)" <?php if (!(strcmp("PPT(M2)", $row_kew8['userkewe_jawatan2']))) {echo "selected=\"selected\"";} ?>>PPT(M2)</option>
                                 <option value="PBT" <?php if (!(strcmp("PBT", $row_kew8['userkewe_jawatan2']))) {echo "selected=\"selected\"";} ?>>PBT</option>
                            </select>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline">
                          <input name="userkewe_id" type="hidden" id="userkewe_id" value="<?php echo $row_kew8['userkewe_id']; ?>" />
                          <input type="hidden" name="MM_update" value="formuserkewe" />
                        </td>
                        <td colspan="8" class="noline">
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

  if(document.getElementById("tarikh1").checked == true)
  {
    document.getElementById("userkewe_start_d").style.display ="block";
    document.getElementById("userkewe_start_m").style.display ="block";
    document.getElementById("userkewe_start_y").style.display ="block";
  }

  if(document.getElementById("tarikh2").checked == true)
  {
    document.getElementById("userkewe_end_d").style.display ="block";
    document.getElementById("userkewe_end_m").style.display ="block";
    document.getElementById("userkewe_end_y").style.display ="block";
  }

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
<?php
mysql_free_result($kew8);
?>
<?php include('../inc/footinc.php');?> 