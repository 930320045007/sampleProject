<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='2';?>
<?php $menu2='83';?>
<?php

$colname_tr = "-1";

if (isset($_GET['id'])) 
{
  $colname_tr = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_property = sprintf("SELECT * FROM www.user_property WHERE userproperty_id=%s AND userproperty_status = 1", GetSQLValueString($colname_tr,"int"));
$property = mysql_query($query_property, $hrmsdb) or die(mysql_error());
$row_property = mysql_fetch_assoc($property);
$totalRows_property = mysql_num_rows($property);
	
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
        	 <form id="form1" name="form1" method="POST" action="sb/update_property.php">
              <div class="note">Borang Pengistiharan Harta</div>
              <ul>
              <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="185" nowrap="nowrap" class="label">Jenis</td>
                        <td colspan="3"><span class="noline">
                          <select name="propertytype_id" id="propertytype_id">
                          <?php do { ?>
            	            <option value="<?php echo $row_type['propertytype_id']?>"<?php if (!(strcmp($row_type['propertytype_id'], $row_property['property_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_type['propertytype_name']?></option>
            	            <?php
							} while ($row_type = mysql_fetch_assoc($type));
							  $rows = mysql_num_rows($type);
							  if($rows > 0) {
								  mysql_data_seek($type, 0);
								  $row_type = mysql_fetch_assoc($type);
							  }
							?>
                        </select>
                        </span></td>
                      </tr>
                      <tr>
                        <td class="label noline">Keterangan Harta*</td>
                        <td class="noline" colspan="3"><span id="name">
                        <input name="userproperty_detail" type="text" class="w50" id="userproperty_detail"onkeypress="return handleEnter(this, event)" value="<?php echo $row_property['userproperty_detail']; ?>" />
                    <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                    <div class="inputlabel2">Cth: Rumah teres setingkat/ Kereta MyVI</div>
                    </span>
                         </td>
                      </tr>
                	  <tr>
                	    <td class="label">Pemilik</td>
                	    <td colspan="3"><span class="noline">
                          <select name="owner_id" id="owner_id">
            	            <?php
do {  
?>
            	            <option value="<?php echo $row_owner['owner_id']?>"<?php if (!(strcmp($row_owner['owner_id'], $row_property['owner_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_owner['owner_name']?></option>
            	            <?php
} while ($row_owner = mysql_fetch_assoc($owner));
  $rows = mysql_num_rows($owner);
  if($rows > 0) {
      mysql_data_seek($owner, 0);
	  $row_owner = mysql_fetch_assoc($owner);
  }
?>
                        </select>
                        </span></td>
              	    </tr>
                    <tr>
                        <td class="label noline">No. Sijil/ Pendaftaran</td>
                        <td colspan="3"><input name="userproperty_regno" type="text" class="w30" id="userproperty_regno" onkeypress="return handleEnter(this, event)" value="<?php echo $row_property['userproperty_regno']; ?>" /></td>
                    </tr>
                    <tr>
                	     <td class="label">Alamat Harta</td>
                	     <td colspan="3">
                             <input name="userproperty_address1" type="text" id="userproperty_address1" size="30" maxlength="50" value="<?php echo $row_property['userproperty_address1']; ?>" />
               	            <input name="userproperty_address2" type="text" id="userproperty_address2" size="30" maxlength="50" value="<?php echo $row_property['userproperty_address2']; ?>" />
               	            <input name="userproperty_address3" type="text" id="userproperty_address3" size="30" maxlength="50" value="<?php echo $row_property['userproperty_address3']; ?>" />
                        </td>
              	   </tr>
                   <tr>
                	     <td class="label">Poskod</td>
                	     <td> <input name="userproperty_poscode" type="text" class="w50" id="userproperty_poscode"onkeypress="return handleEnter(this, event)" value="<?php echo $row_property['userproperty_poscode']; ?>" /><div class="inputlabel2">Cth: 57000</div></td>
                	     <td class="label">Bandar</td>
                	     <td><input name="userproperty_city" type="text" class="w50" id="userproperty_city"onkeypress="return handleEnter(this, event)" value="<?php echo $row_property['userproperty_city']; ?>" /></td>
              	    </tr>
                    <tr>
                	     <td class="label">Negeri</td>
                	     <td colspan="3"><span class="noline">
                          <select name="state_id" id="state_id">
            	            <?php
do {  
?>
            	            <option value="<?php echo $row_state['state_id']?>"<?php if (!(strcmp($row_state['state_id'], $row_property['state_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_state['state_name']?></option>
            	            <?php
} while ($row_state = mysql_fetch_assoc($state));
  $rows = mysql_num_rows($state);
  if($rows > 0) {
      mysql_data_seek($state, 0);
	  $row_state = mysql_fetch_assoc($state);
  }
?>
                        </select>
                        </span></td>
              	    </tr>
                    <tr>
                        <td class="label">Tarikh Pemilikan</td>
                        <td colspan="3"><span id="owned_date"><span class="textfieldInvalidFormatMsg">Sila pastikan format dimasukkan dengan betul.</span>
                          <input name="userproperty_owned_date" type="text" class="miniinput" id="userproperty_owned_date" maxlength="10"  value="<?php echo $row_property['userproperty_owned_date']; ?>" />
                          </span>                          
                        <div class="inputlabel2">Format: dd/mm/yyyy Cth: 23/05/1980</div></td>
                   </tr>
                   <tr>
                        <td class="label">Kuantiti</td>
                        <td><span id="quantity"><span class="textfieldInvalidFormatMsg">Sila pastikan format dimasukkan dengan betul.</span>
                          <input name="userproperty_quantity" type="text" class="miniinput" id="userproperty_quantity" maxlength="10" value="<?php echo $row_property['userproperty_quantity']; ?>" />
                          </span>                          
                        <div class="inputlabel2">Format dalam bilangan/ekar/kaki persegi/unit</div></td>
                        <td class="label noline">Nilai Perolehan (RM)</td>
                        <td><input name="userproperty_amount" type="text" class="w30" id="userproperty_amount" onkeypress="return handleEnter(this, event)"  value="<?php echo $row_property['userproperty_amount']; ?>" /><div class="inputlabel2">Cth: 45000.00</div></td>
                   </tr>
                   <tr>
                       <td nowrap="nowrap" class="label">Sumber Perolehan</td>
                       <td colspan="3"><span class="noline">
                          <select name="source_id" id="source_id">
            	            <?php
do {  
?>
            	            <option value="<?php echo $row_source['source_id']?>"<?php if (!(strcmp($row_source['source_id'], $row_property['source_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_source['source_name']?></option>
            	            <?php
} while ($row_source = mysql_fetch_assoc($source));
  $rows = mysql_num_rows($source);
  if($rows > 0) {
      mysql_data_seek($source, 0);
	  $row_source = mysql_fetch_assoc($source);
  }
?>
                        </select>
                        </span></td>
                      </tr>
                  </table>
                	<li class="gap">&nbsp;</li>
                  <li class="title">Maklumat Pinjaman</li>
                  <li class="gap">&nbsp;</li>
                  <li>
                	<div class="note">1. Sila isikan maklumat pinjaman yang diperlukan jika sumber perolehan adalah Pinjaman.</div>
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="180" class="label noline">Institusi Pinjaman</td>
                    <td colspan="3"><input name="userproperty_instituteloan" type="text" class="w30" id="userproperty_instituteloan" onkeypress="return handleEnter(this, event)" value="<?php echo $row_property['userproperty_instituteloan']; ?>" /></td>
                  </tr>
                  <tr>
                    <td class="label">Tarikh Mula Bayaran</td>
                    <td>
                          <input name="userproperty_start_date" type="text" class="miniinput" id="userproperty_start_date" maxlength="10" value="<?php echo $row_property['userproperty_start_date']; ?>" />                       
                        <div class="inputlabel2">Format: dd/mm/yyyy Cth: 23/05/1980</div></td>
                     <td class="label">Tarikh Akhir Bayaran</td>
                     <td>
                          <input name="userproperty_end_date" type="text" class="miniinput" id="userproperty_end_date" maxlength="10" value="<?php echo $row_property['userproperty_end_date']; ?>" />          
                        <div class="inputlabel2">Format: dd/mm/yyyy Cth: 23/05/1980</div></td>
                  </tr>
                  <tr>
                    <td width="180" class="label noline">Tempoh Bayaran</td>
                    <td colspan="3"><input name="userproperty_durationloan" type="text" class="w30" id="userproperty_durationloan" onkeypress="return handleEnter(this, event)" value="<?php echo $row_property['userproperty_durationloan']; ?>" /><span class="inputlabel">bulan</span></td>
                 </tr>
                 <tr>
                     <td class="label noline">Jumlah Pinjaman (RM)</td>
                     <td><input name="userproperty_totalloan" type="text" class="w30" id="userproperty_totalloan" onkeypress="return handleEnter(this, event)" value="<?php echo $row_property['userproperty_totalloan']; ?>" /> <div class="inputlabel2">Cth: 45000.00</div></td>
                      <td class="label noline">Ansuran Bulanan (RM)</td>
                      <td width="356"><input name="userproperty_monthlyloan" type="text" class="w30" id="userproperty_monthlyloan" onkeypress="return handleEnter(this, event)" value="<?php echo $row_property['userproperty_monthlyloan']; ?>" /> <div class="inputlabel2">Cth: 45000.00</div></td>
                 </tr>
                 <tr>
                	  <td nowrap="nowrap" class="label">Keterangan Lain</td>
                	  <td colspan="3"> 
                       <textarea name="userproperty_note" id="userproperty_note" cols="45" rows="5"><?php echo $row_property['userproperty_note']; ?></textarea>
                      </td>
              	 </tr>
                 <tr>
                      <td nowrap="nowrap" class="label noline"><input name="userproperty_id" type="hidden" id="userproperty_id" value="<?php echo $colname_tr;?>" />                          <input name="MM_update" type="hidden" id="MM_update" value="form1" /></td>
                	  <td class="noline" colspan="3"><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onClick="MM_goToURL('parent','property.php');return document.MM_returnValue"/></td>
              	 </tr>
              </table>
              </li>
              </li>
              </ul>
           </form>
    </div>
    </div>
    </div>
		<?php include('inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("name");
var sprytextfield1 = new Spry.Widget.ValidationTextField("owned_date");
</script>
</body>
</html>
<?php
mysql_free_result($type);
mysql_free_result($owner);
mysql_free_result($state);
mysql_free_result($source);
?>
<?php include('inc/footinc.php');?>
