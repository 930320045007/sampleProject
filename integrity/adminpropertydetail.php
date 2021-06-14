<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='21';?>
<?php $menu2='84';?>
<?php

$colname_tr = "-1";

if (isset($_GET['id'])) 
{
  $colname_tr = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_property = sprintf("SELECT * FROM hr.user_property WHERE userproperty_id=%s", GetSQLValueString($colname_tr,"int"));
$property = mysql_query($query_property, $hrmsdb) or die(mysql_error());
$row_property = mysql_fetch_assoc($property);
$totalRows_property = mysql_num_rows($property);
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_disposal = "SELECT * FROM hr.disposal_way WHERE disposalway_status = 1";
$disposal = mysql_query($query_disposal, $hrmsdb) or die(mysql_error());
$row_disposal = mysql_fetch_assoc($disposal);
$totalRows_disposal = mysql_num_rows($disposal);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
<script type="../text/javascript" src="../js/disenter.js"></script>
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
            <li> 
            <div class="note">Borang Pelupusan Harta</div></li>
            <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Jenis</td>
                        <td valign="middle"><?php echo getPropertyTypeByPropertyID($row_property['userproperty_id']); ?>&nbsp; &bull; &nbsp; <?php echo getPropertyDetailByID($row_property['userproperty_id']);?></td>
                      </tr>
               	      <tr>
                	    <td class="label">Pemilik</td>
               	        <td valign="middle" nowrap="nowrap"><?php echo getOwnerByPropertyID($row_property['userproperty_id']);?></td>
              	      </tr>
                      <tr>
                        <td class="label noline">No. Sijil/ Pendaftaran</td>
                        <td valign="middle" nowrap="nowrap"><?php if(getRegNoByPropertyID($row_property['userproperty_id'])!='') echo getRegNoByPropertyID($row_property['userproperty_id']); else echo ""; ?></td>
                    </tr>
                    <tr>
                	    <td class="label">Alamat Harta</td>
                	    <td valign="middle" nowrap="nowrap"><div class="txt_line in_cappitalize"><?php if((getAddressByPropertyID($row_property['userproperty_id']))!=NULL) {echo getAddressByPropertyID($row_property['userproperty_id']);?><br/><?php echo getCityByPropertyID($row_property['userproperty_id']); ?><br /><?php echo getPoscodeByPropertyID($row_property['userproperty_id']); ?> <?php echo getState(getStateIDByPropertyID($row_property['userproperty_id']));?><?php }else echo "";?><br /></div></td>
              	   </tr>
                   <tr>
                	     <td class="label">Tarikh Pemilikan</td>
                	     <td valign="middle" nowrap="nowrap"><?php echo getOwnedDateByPropertyID($row_property['userproperty_id']); ?></td>
              	    </tr>
                  </table>  
                  </li>
                  <li class="gap">&nbsp;</li>
                  <li class="title">Maklumat Pelupusan</li>
                  <li class="gap">&nbsp;</li>
                  <li>
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Tarikh Pelupusan</td>
                    <td valign="middle" nowrap="nowrap"><?php echo getDisposalDateByPropertyID($row_property['userproperty_id']); ?></td>
                  </tr>
                  <tr>
                    <td class="label">Cara Pelupusan</td>
                    <td valign="middle" nowrap="nowrap"><?php echo getDisposalWayByPropertyID($row_property['userproperty_id']); ?></td>
                  </tr>
                  <tr>
                    <td class="label noline">Harga Jualan (RM)</td>
                    <td valign="middle" nowrap="nowrap"><?php echo getSellPriceByPropertyID($row_property['userproperty_id']); ?></td>
                 </tr>
                 <tr>
                	 <td nowrap="nowrap" class="label">Catatan</td>
                	 <td valign="middle" nowrap="nowrap"><?php echo getDisposalNoteByPropertyID($row_property['userproperty_id']); ?></td>
              	 </tr>
              </table>
              </li>
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
mysql_free_result($disposal);
?>
<?php include('../inc/footinc.php');?> 