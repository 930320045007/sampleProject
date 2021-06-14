<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='69';?>
<?php

$colname_apply = "-1";

if (isset($_GET['id'])) {
  $colname_apply = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
};

mysql_select_db($database_ictdb, $ictdb);
$query_apply = sprintf("SELECT * FROM ict.user_applyitem WHERE userapply_id =%s AND uai_status = 1", GetSQLValueString($colname_apply,"int")) ;
$apply = mysql_query($query_apply, $ictdb) or die(mysql_error());
$row_apply = mysql_fetch_assoc($apply);
$totalRows_apply = mysql_num_rows($apply);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300' rel='stylesheet' type='text/css'>
<link href="../css/print.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
<tr>
    <td align="center" valign="middle" nowrap="nowrap"><img src="<?php echo $url_main;?>img/msn1.png" heigh="70" width="90" alt="Logo MSN" /></td>
    <td width="100%" align="left" valign="middle" nowrap="nowrap" class="fsize2"><strong>MAJLIS SUKAN NEGARA</strong><br />
    Permohonan Peralatan ICT</td>
    <td align="left" valign="middle" nowrap="nowrap">Tarikh : <?php echo date('d / m / Y (D)', mktime(0 , 0, 0, date('m'), date('d'), date('Y')));?></td>
</tr>
</table>
  
<?php if ($totalRows_apply > 0) { // Show if recordset not empty ?>       

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
                        <tr>
                          <td nowrap="nowrap" class="label">Nama Pemohon</td>
                          <td align="center" valign="top" class="txt_line"><?php echo viewProfilePic(getStafIDByApplyID($row_apply['userapply_id']));?></td>
                          <td width="100%" align="left" valign="middle" class="txt_line">
                          <div><strong><?php echo getFullNameByStafID(getStafIDByApplyID($row_apply['userapply_id'])); ?></strong> (<?php echo getStafIDByApplyID($row_apply['userapply_id']); ?>)</div>
						  <div><?php echo getFulldirectoryByUserID(getStafIDByApplyID($row_apply['userapply_id']));?><?php echo " &nbsp; &bull; &nbsp; Ext : " . getExtNoByUserID(getStafIDByApplyID($row_apply['userapply_id']));?></div></td>
                        </tr>
                        <tr>
                          <td nowrap="nowrap" class="label">Tarikh</td>
                          <td colspan="2"><?php echo getApplyDateByApplyID($row_apply['userapply_id']);?></td>
                        </tr>
                        <tr>
                          <td nowrap="nowrap" class="label">Catatan</td>
                          <td colspan="2" nowrap="nowrap"><?php echo getApplyNoteByID($row_apply['userapply_id']);?></td>
                          </tr>   
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">
  <tr>
    <td nowrap="nowrap" class="line_b line_r"><strong>SENARAI KAKITANGAN</strong></td>
  </tr>
    </table>
  					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
                      <?php if ($totalRows_apply > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th nowrap="nowrap">Bil</th>
                        <th colspan="2" align="left" valign="middle" nowrap="nowrap">Nama Kakitangan</th>
                         <th align="left" valign="middle" nowrap="nowrap">Jenis</th>
                         <th align="left" valign="middle" nowrap="nowrap">Item</th>
                        <th align="left" valign="middle" nowrap="nowrap">Status</th>
                          <th align="left" valign="middle" nowrap="nowrap">Catatan</th>
                        </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td><?php echo $i;?></td>
                            <td align="center" valign="top" class="txt_line"><?php echo viewProfilePic(getStafIDByApplyID($row_apply['user_stafid']));?></td>
                            <td align="left" valign="middle" class="txt_line">
                            <div><strong><?php echo getFullNameByStafID($row_apply['user_stafid']); ?></strong> (<?php echo $row_apply['user_stafid'];?>)</div>
                            <div><?php echo getFulldirectoryByUserID($row_apply['user_stafid']);?><?php echo " &nbsp; &bull; &nbsp; Ext : " . getExtNoByUserID($row_apply['user_stafid']);?></div> 
                            </td>
                            <td align="left" valign="middle" nowrap="nowrap"><?php echo getReqTypeNameByReqID($row_apply['reqtype_id']); ?></td>
                            <td align="left" valign="middle" nowrap="nowrap"><?php echo getItemCategoryBySubCatID($row_apply['subcategory_id']) . " &nbsp; &bull; &nbsp; " . getItemSubCategoryByID($row_apply['subcategory_id']); ?></td>
                            <td align="left" valign="middle" nowrap="nowrap">
							<?php echo getStatusNameByID(getStatusByID($row_apply['uai_id']));?>
                        </td>
                        <td align="left" valign="middle" nowrap="nowrap">
                       <?php echo $row_apply['ict_note']; ?>
                        </td>
          				</tr>
                          <?php $i++; } while ($row_apply = mysql_fetch_assoc($apply)); ?>
                        <tr>
                          <td colspan="9" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_apply ?> rekod dijumpai</td>
                          </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="9" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
    <?php }; ?>
</body>
</html>
<?php
mysql_free_result($apply);
?>
<?php include('../inc/footinc.php');?> 
              