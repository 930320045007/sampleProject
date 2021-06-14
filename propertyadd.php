<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='2';?>
<?php $menu2='83';?>
<?php

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_type = "SELECT * FROM www.property_type WHERE propertytype_status = 1";
$type = mysql_query($query_type, $hrmsdb) or die(mysql_error());
$row_type = mysql_fetch_assoc($type);
$totalRows_type = mysql_num_rows($type);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_owner = "SELECT * FROM www.owner WHERE owner_status = 1";
$owner = mysql_query($query_owner, $hrmsdb) or die(mysql_error());
$row_owner = mysql_fetch_assoc($owner);
$totalRows_owner = mysql_num_rows($owner);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_source = "SELECT * FROM www.source WHERE source_status = 1";
$source = mysql_query($query_source, $hrmsdb) or die(mysql_error());
$row_source = mysql_fetch_assoc($source);
$totalRows_source = mysql_num_rows($source);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_state = "SELECT * FROM www.state ORDER BY state_name ASC";
$state = mysql_query($query_state, $hrmsdb) or die(mysql_error());
$row_state = mysql_fetch_assoc($state);
$totalRows_state = mysql_num_rows($state);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<script src="js/ajaxsbmt.js" type="text/javascript"></script>
<?php include('inc/liload.php');?>
<?php include('inc/headinc.php');?>
<script src="SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/disenter.js"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('inc/bodyinc.php');?>>
<div>
	<div>
	  <?php include('inc/header.php');?>
      <?php include('inc/menu.php');?>
      	<div class="content">
		<?php include('inc/menu_profail.php');?>
        <div class="tabbox">
        <div class="profilemenu">
        	<form action="sb/add_property.php" method="POST" name="formproperty" id="formproperty">
           	 <div class="note"> <ul class="inputradio">

                    <li><input name="noproperty" type="checkbox" id="noproperty" value="1"/> 
                    Sila tanda jika tiada pemilikan harta dan borang istihar harta tidak perlu diisi.</li>
                    </ul></div>
            <ul>
            <li class="title">Borang Pengistiharan Harta</li>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="185" nowrap="nowrap" class="label">Jenis</td>
                        <td colspan="3" nowrap="nowrap">
                        <select name="type" id="type">
                       <option value="0">Sila Pilih</option>
					   <?php
                       do {  ?>
                       <option value="<?php echo $row_type['propertytype_id']?>"><?php echo $row_type['propertytype_name']?></option>
					   <?php } while ($row_type = mysql_fetch_assoc($type));
					   $rows = mysql_num_rows($type);
					   if($rows > 0) {
						   mysql_data_seek($type, 0);
						   $row_type = mysql_fetch_assoc($type);
						   } ?>
                           </select>
                           </td>
                      </tr>
                      <tr>
                        <td class="label"> Keterangan Harta</td>
                        <td colspan="3">
                        <input name="userproperty_detail" type="text" class="w50" id="userproperty_detail"onkeypress="return handleEnter(this, event)" />
                    
                             <div class="inputlabel2">Cth: Rumah teres setingkat/ Kereta MyVI</div>
                         
                        </td>
                      </tr>
                	  <tr>
                	    <td class="label">Pemilik</td>
                	    <td colspan="3" nowrap="nowrap"><select name="owner" id="owner">
                          <option value="0">Sila Pilih</option>
						  <?php 
						  do {  ?>
                          <option value="<?php echo $row_owner['owner_id']?>"><?php echo $row_owner['owner_name']?></option>
						  <?php } while ($row_owner = mysql_fetch_assoc($owner));
						  $rows = mysql_num_rows($owner);
						  if($rows > 0) {
							  mysql_data_seek($owner, 0);
							  $row_owner = mysql_fetch_assoc($owner);
							  } ?>
                              </select></td>
              	    </tr>
                    <tr>
                        <td class="label">No. Sijil/ Pendaftaran</td>
                        <td colspan="3"><input name="userproperty_regno" type="text" class="w30" id="userproperty_regno" onkeypress="return handleEnter(this, event)" /></td>
                    </tr>
                    <tr>
                	    <td class="label">Alamat Harta</td>
                	    <td colspan="3">
                             <input name="userproperty_address1" type="text" id="userproperty_address1" size="30" maxlength="50" />
               	             <input name="userproperty_address2" type="text" id="userproperty_address2" size="30" maxlength="50" />
               	             <input name="userproperty_address3" type="text" id="userproperty_address3" size="30" maxlength="50" />
                        </td>
              	   </tr>
                   <tr>
                	    <td class="label">Poskod</td>
                	    <td> <input name="userproperty_poscode" type="text" class="w50" id="userproperty_poscode"onkeypress="return handleEnter(this, event)" /><div class="inputlabel2">Cth: 57000</div></td>
                	    <td class="label">Bandar</td>
                	    <td><input name="userproperty_city" type="text" class="w50" id="userproperty_city"onkeypress="return handleEnter(this, event)" /></td>
              	   </tr>
                   <tr>
                	    <td class="label">Negeri</td>
                	    <td nowrap="nowrap" colspan="3"><select name="state_id" id="state_id">
                        <option value="0">Sila Pilih</option>
						<?php 
						do {  ?>
                        <option value="<?php echo $row_state['state_id']?>"><?php echo $row_state['state_name']?></option>
						<?php } while ($row_state = mysql_fetch_assoc($state));
						$rows = mysql_num_rows($state);
						if($rows > 0) {
							mysql_data_seek($state, 0);
							$row_state = mysql_fetch_assoc($state);
							} ?>
                            </select></td>  
              	  </tr>
                  <tr>
                        <td class="label">Tarikh Pemilikan</td>
                        <td colspan="3"><span id="owned_date"><span class="textfieldInvalidFormatMsg">Sila pastikan format dimasukkan dengan betul.</span>
                          <input name="userproperty_owned_date" type="text" class="miniinput" id="userproperty_owned_date" maxlength="10" />
                          </span>                          
                        <div class="inputlabel2">Format: dd/mm/yyyy Cth: 23/05/1980</div></td>
                  </tr>
                  <tr>
                        <td class="label">Kuantiti</td>
                        <td><span id="quantity"><span class="textfieldInvalidFormatMsg">Sila pastikan format dimasukkan dengan betul.</span>
                          <input name="userproperty_quantity" type="text" class="miniinput" id="userproperty_quantity" maxlength="10" />
                          </span>                          
                        <div class="inputlabel2">Format dalam bilangan/ekar/kaki persegi/unit</div></td>
                        <td class="label">Nilai Perolehan (RM)</td>
                        <td><input name="userproperty_amount" type="text" class="w30" id="userproperty_amount" onkeypress="return handleEnter(this, event)" /> <div class="inputlabel2">Cth: 45000.00</div></td>
                  </tr>
                  <tr>
                       <td nowrap="nowrap" class="label noline">Sumber Perolehan</td>
                       <td nowrap="nowrap" colspan="3" class="noline"><select name="source" id="source">
                       <option value="0">Sila Pilih</option>
					   <?php
                       do {  ?>
                       <option value="<?php echo $row_source['source_id']?>"><?php echo $row_source['source_name']?></option>
					   <?php } while ($row_source = mysql_fetch_assoc($source));
					   $rows = mysql_num_rows($source);
					   if($rows > 0) {
						   mysql_data_seek($source, 0);
						   $row_source = mysql_fetch_assoc($source);
						   } ?>
                           </select></td>
                </tr>
           </table>
            <li class="gap">&nbsp;</li>
                  <li class="title">Maklumat Pinjaman</li>
                  <li class="gap">&nbsp;</li>
                  <li>
                	<div class="note">1. Sila isikan maklumat pinjaman yang diperlukan jika sumber perolehan adalah Pinjaman.</div>
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="180" class="label">Institusi Pinjaman</td>
                    <td colspan="3"><input name="userproperty_instituteloan" type="text" class="w30" id="userproperty_instituteloan" onkeypress="return handleEnter(this, event)" /></td>
                  </tr>
                   <tr>
                    <td class="label">Tarikh Mula Bayaran</td>
                    <td>
                      <input name="userproperty_start_date" type="text" class="miniinput" id="userproperty_start_date" maxlength="10" />                        
                    <div class="inputlabel2">Format: dd/mm/yyyy Cth: 23/05/1980</div></td>
                    <td class="label">Tarikh Akhir Bayaran</td>
                    <td>
                      <input name="userproperty_end_date" type="text" class="miniinput" id="userproperty_end_date" maxlength="10" />          
                    <div class="inputlabel2">Format: dd/mm/yyyy Cth: 23/05/1980</div></td>
                  </tr>
                  <tr>
                    <td width="180" class="label">Tempoh Bayaran</td>
                    <td colspan="3"><input name="userproperty_durationloan" type="text" class="w30" id="userproperty_durationloan" onkeypress="return handleEnter(this, event)" /><span class="inputlabel">bulan</span></td>
                  </tr>
                  <tr>
                   <td class="label">Jumlah Pinjaman (RM)</td>
                   <td><input name="userproperty_totalloan" type="text" class="w30" id="userproperty_totalloan" onkeypress="return handleEnter(this, event)" /> <div class="inputlabel2">Cth: 45000.00</div></td>
                   <td class="label">Ansuran Bulanan (RM)</td>
                   <td width="356"><input name="userproperty_monthlyloan" type="text" class="w30" id="userproperty_monthlyloan" onkeypress="return handleEnter(this, event)" /> <div class="inputlabel2">Cth: 45000.00</div></td>
                   </tr>
                   <tr>
                	   <td nowrap="nowrap" class="label noline">Keterangan Lain</td>
                	   <td colspan="3" class="noline"> 
                       <textarea name="userproperty_note" id="userproperty_note" cols="45" rows="5"></textarea>
                       </td>
              	    </tr>
                    <tr>
                       <td class="noline">&nbsp;
                      </td>
                      <td align="left" valign="middle" class="txt_line noline" colspan="3" nowrap="nowrap"> 
                     <ul class="inputradio">
                    <li>
                    <input name="checkbox" type="checkbox" id="checkbox" />
                     <span class="checkboxRequiredMsg"><div>Sila buat pengesahan.</div></span>
                     <div>Saya mengesahkan setiap maklumat pengistiharan harta yang diberikan adalah benar.</div> 
                     </li>
                    </ul>
                    </td>
                  </tr>
                    <tr>
                    <td><input type="hidden" name="MM_insert" value="formproperty" />
                     <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" /></td>
                    <td colspan="3"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                    <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onClick="MM_goToURL('parent','property.php');return document.MM_returnValue"/></td>
                  </tr>
            </table>
            </li>
         </li>
     </ul>
   </form>
   </div>
   </div>
		<?php echo noteFooter('1');?>
    </div>
		<?php include('inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($type);
mysql_free_result($owner);
mysql_free_result($state);
mysql_free_result($source);
?>
<?php include('inc/footinc.php');?> 