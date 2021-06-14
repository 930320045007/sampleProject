<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='21';?>
<?php $menu2='84';?>
<?php

if(isset($_POST['y']) && $_POST['y']!='')
{
	$wsql = "AND user_property.userproperty_date_y = '" . $_POST['y'] . "'";
	$y = $_POST['y'];
} else {
	$wsql = "";
	$y = date('Y');
}

if(isset($_GET['id']) && $_GET['id']!=NULL)
	$colname_userprofile = getStafIDByUserID($_GET['id']);
else
	$colname_userprofile = '0';
	
	
//$colname_userprofile = "-1";
//
//if (isset($_GET['id'])) {
//
//  $colname_userprofile = getStafIDByUserID($_GET['id']);
//
//}
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_property = sprintf("SELECT * FROM user_property WHERE userproperty_date_y = '" . $y . "' AND user_stafid =%s " . $wsql . "  AND userproperty_noproperty= '0' ORDER BY userproperty_date_y DESC",GetSQLValueString($colname_userprofile, "text"));
$property = mysql_query($query_property, $hrmsdb) or die(mysql_error());
$row_property = mysql_fetch_assoc($property);
$totalRows_property = mysql_num_rows($property);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<?php include('../inc/headinc.php');?>
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
                <li class="form_back">
                  <form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                       <td nowrap="nowrap" class="label">Tahun</td>
                        <td>
                          <select name="y" id="y">
                          <?php for($i=2012; $i<=date('Y'); $i++){?>
                            <option <?php if($i == $y) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                          </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                        <td><input name="button5" type="button" class="submitbutton" id="button5" value="Cetak" onclick="MM_openBrWindow('<?php echo $url_main;?>printproperty.php?id=<?php echo $colname_userprofile;?>&y=<?php echo $y;?>','propertyprint','status=yes,scrollbars=yes,width=800,height=600')" />
                      </td>
                      </tr>
                    </table>
                  </form>
                </li>
            	<li>
            	  <div class="note">Senarai harta bagi tahun <?php echo $y;?></div></li>     
                  <li class="title">Rekod Harta</li>
                  <li>
                  <div class="off">  
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if(getNoPropertyByUserID($colname_userprofile)==0){?>
                  
                    <?php if ($totalRows_property > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="50%" align="left" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th align="center" valign="middle" nowrap="nowrap">Harta</th>
                      <th align="center" valign="middle" nowrap="nowrap">Pemilik</th>
                      <th align="center" valign="middle">No Sijil/ Pendaftaran</th>
                      <th align="center" valign="middle" nowrap="nowrap">Alamat</th>
                      <th align="center" valign="middle">Tarikh Pemilikan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Kuantiti</th>
                      <th align="center" valign="middle">Nilai Perolehan (RM)</th>
                      <th align="center" valign="middle">Sumber Perolehan</th>
                      <th align="center" valign="middle">Institusi Pinjaman</th>
                      <th align="center" valign="middle">Tarikh Pembayaran</th>
                      <th align="center" valign="middle">Tempoh Pembayaran (bulan)</th>
                      <th align="center" valign="middle">Jumlah Pinjaman (RM)</th>
                      <th align="center" valign="middle">Ansuran Bulanan (RM)</th>
                      <th width="30%" align="center" valign="middle" nowrap="nowrap">Keterangan Lain</th>
                      <th></th>
                    </tr>
                       <?php $i=1; do { ?>
                      <tr <?php if(checkDelPropertyByPropertyID($row_property['userproperty_id'])==0) echo "class=\"offcourses\""; else echo "class=\"on\"";?>>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="left" valign="middle" nowrap="nowrap"><?php echo getSubmitDate($row_property['userproperty_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getPropertyTypeByPropertyID($row_property['userproperty_id']); ?><br />&nbsp; &bull; &nbsp; <?php echo getPropertyDetailByID($row_property['userproperty_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getOwnerByPropertyID($row_property['userproperty_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php if(getRegNoByPropertyID($row_property['userproperty_id'])!='') echo getRegNoByPropertyID($row_property['userproperty_id']); else echo "-"; ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><div class="txt_line in_cappitalize"><?php if((getAddressByPropertyID($row_property['userproperty_id']))!=NULL) {echo getAddressByPropertyID($row_property['userproperty_id']);?><br/><?php echo getCityByPropertyID($row_property['userproperty_id']); ?><br /><?php echo getPoscodeByPropertyID($row_property['userproperty_id']); ?> <?php echo getState(getStateIDByPropertyID($row_property['userproperty_id']));?><?php }else echo "-";?><br /></div></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getOwnedDateByPropertyID($row_property['userproperty_id']); ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getQuantityByPropertyID($row_property['userproperty_id']); ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php if(getAmountByPropertyID($row_property['userproperty_id'])!='') echo number_format(getAmountByPropertyID($row_property['userproperty_id']),2); else echo "-"; ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getSourceNameByID(getSourceIDByPropertyID($row_property['userproperty_id'])); ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php if(getInstituteLoanByPropertyID($row_property['userproperty_id'])!='') echo getInstituteLoanByPropertyID($row_property['userproperty_id']); else echo "-"; ?></td>
                        <td align="center" valign="middle"><?php if(getPayDateByPropertyID($row_property['userproperty_id'])!='') echo getPayDateByPropertyID($row_property['userproperty_id']); else echo "-"; ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php if(getDurationLoanByPropertyID($row_property['userproperty_id'])!='') echo getDurationLoanByPropertyID($row_property['userproperty_id']); else echo "-"; ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php if(getTotalLoanByPropertyID($row_property['userproperty_id'])!='') echo number_format(getTotalLoanByPropertyID($row_property['userproperty_id']),2); else echo "-"; ?></td>
                       <td align="center" valign="middle" nowrap="nowrap"><?php if(getMonthlyLoanByPropertyID($row_property['userproperty_id'])!='') echo number_format(getMonthlyLoanByPropertyID($row_property['userproperty_id']),2); else echo "-"; ?></td>
                        <td align="center" valign="middle"><?php if(getNoteByPropertyID($row_property['userproperty_id'])!='') echo getNoteByPropertyID($row_property['userproperty_id']); else echo "-"; ?></td> 
                        <td valign="middle" nowrap="nowrap"><li><?php if(checkDelPropertyByPropertyID($row_property['userproperty_id'])==0) echo "<a href=\"" . $url_main . "integrity/adminpropertydetail.php?id=" . getID(htmlspecialchars($row_property['userproperty_id']),ENT_QUOTES) . "\">Maklumat Pelupusan</a>";
						?></li></td>
                      </tr>
                      <?php $i++; } while ($row_property = mysql_fetch_assoc($property)); ?>
                    <tr>
                      <td colspan="18" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_property ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="18" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                    <?php } else { ?>
                    <tr>
                <td colspan="18" align="center" valign="middle" class="noline">Tiada Pemilikan Harta</td>
                    </tr>
                    <?php };?>
                  </table>
                  </div>
                </li> 
                <li class="gap">&nbsp;</li>
                <li class="gap">&nbsp;</li>
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
mysql_free_result($property);
?>
<?php include('../inc/footinc.php');?> 