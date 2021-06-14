<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='69';?>
<?php

$colname_uai = "-1";
if (isset($_GET['uaid'])) {
  $colname_uai = $_GET['uaid'];
}

$userapply_id = "-1";
if (isset($_GET['id'])) {
  $userapply_id = $_GET['id'];
}

mysql_select_db($database_ictdb, $ictdb);
$query_apply = sprintf("SELECT * FROM user_applyitem WHERE userapply_id = '". $userapply_id ."' AND uai_id = %s ORDER BY uai_id DESC", GetSQLValueString($colname_uai, "int"));
$apply = mysql_query($query_apply, $ictdb) or die(mysql_error());
$row_apply = mysql_fetch_assoc($apply);
$totalRows_apply = mysql_num_rows($apply);
	
//mysql_select_db($database_ictdb, $ictdb);
//$query_apply = "SELECT * FROM ict.user_applyitem WHERE uai_id ='" .$id. "' AND uai_status = 1 " ;
//$apply = mysql_query($query_apply, $ictdb) or die(mysql_error());
//$row_apply = mysql_fetch_assoc($apply);
//$totalRows_apply = mysql_num_rows($apply);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script type="text/javascript" src="../js/disenter.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
                    <li class="gap">&nbsp;</li>
              <li>
                  <form id="form1" name="form1" method="post" action="../sb/update_userapplyitem.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_apply > 0) { // Show if recordset not empty ?>
                        <tr>
                        <th colspan="2" align="left" valign="middle" nowrap="nowrap">Nama Kakitangan</th>
                         <th align="left" valign="middle" nowrap="nowrap">Jenis</th>
                         <th align="left" valign="middle" nowrap="nowrap">Item</th>
                        <th align="left" valign="middle" nowrap="nowrap">Status</th>
                          <th align="left" valign="middle" nowrap="nowrap">Catatan</th>
                        </tr>
                          <tr class="on">
                            <td align="center" valign="top" class="txt_line"><?php echo viewProfilePic(getStafIDByApplyID($row_apply['user_stafid']));?></td>
                            <td align="left" valign="middle" class="txt_line">
                            <div><strong><?php echo getFullNameByStafID($row_apply['user_stafid']); ?></strong> (<?php echo $row_apply['user_stafid'];?>)</div>
                            <div><?php echo getFulldirectoryByUserID($row_apply['user_stafid']);?><?php echo " &nbsp; &bull; &nbsp; Ext : " . getExtNoByUserID($row_apply['user_stafid']);?></div> 
                            </td>
                            <td align="left" valign="middle" nowrap="nowrap"><?php echo getReqTypeNameByReqID($row_apply['reqtype_id']); ?></td>
                            <td align="left" valign="middle" nowrap="nowrap"><?php echo getItemCategoryBySubCatID($row_apply['subcategory_id']) . " &nbsp; &bull; &nbsp; " . getItemSubCategoryByID($row_apply['subcategory_id']); ?></td>
                            <td align="left" valign="middle" nowrap="nowrap">
                            <?php
                            mysql_select_db($database_ictdb, $ictdb);
                            $query_status = "SELECT * FROM ict.apply_status WHERE applystatus_status = '1' ORDER BY applystatus_name ASC";
                            $status = mysql_query($query_status, $ictdb) or die(mysql_error());
                            $row_status = mysql_fetch_assoc($status);
                            $totalRows_status = mysql_num_rows($status);
							?>
<select name="ict_status" id="ict_status">
            	            <?php
do {  
?>
            	            <option value="<?php echo $row_status['applystatus_id']?>"<?php if (!(strcmp($row_status['applystatus_id'], $row_apply['applystatus_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_status['applystatus_name']?></option>
            	            <?php
} while ($row_status = mysql_fetch_assoc($status));
  $rows = mysql_num_rows($status);
  if($rows > 0) {
      mysql_data_seek($status, 0);
	  $row_status = mysql_fetch_assoc($status);
  }
?>
                        </select>
                              <?php mysql_free_result($status);?>
                        </td>
                        <td align="left" valign="middle" nowrap="nowrap">
                         <input name="ict_note" type="text" id="ict_note" value="<?php echo $row_apply['ict_note']; ?>" size="80" />
                        </td>
                        </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline"><input name="uai_id" type="hidden" id="uai_id" value="<?php echo $row_apply['uai_id'];?>" /><input name="userapply_id" type="hidden" id="userapply_id" value="<?php echo $userapply_id;?>" />
                        <input type="hidden" name="MM_update" value="form1" /></td>
                        <td colspan="5" class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                        <input name="button4" type="submit" class="cancelbutton" id="button4" value="Batal" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
            <?php } else { ?>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Tiada rekod dijumpai</td>
                    </tr>
                  </table>
                </li>
            <?php }; ?>
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
mysql_free_result($apply);
?>
<?php include('../inc/footinc.php');?> 