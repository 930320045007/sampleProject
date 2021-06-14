<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='8';?>
<?php $menu2='29';?>
<?php
if(isset($_GET['id']))
	$applyid = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
else
	$applyid = 0;
	
mysql_select_db($database_ictdb, $ictdb);
$query_app = "SELECT user_applyitem.* FROM ict.user_applyitem LEFT JOIN ict.user_apply ON user_apply.userapply_id = user_applyitem.userapply_id WHERE user_apply.userapply_by = '" . $row_user['user_stafid'] . "' AND user_applyitem.userapply_id = '" . $applyid . "' AND uai_status = 1 ORDER BY uai_id ASC";
$app = mysql_query($query_app, $ictdb) or die(mysql_error());
$row_app = mysql_fetch_assoc($app);
$totalRows_app = mysql_num_rows($app);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        
		<?php include('../inc/menu_ict_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
			<?php if (getJob2ID($row_user['user_stafid'])!=0 && getStafIDByApplyID($applyid)==$row_user['user_stafid']){ ?>
            <ul>
                <li>
                <div class="note">Maklumat berkaitan permohonan peralatan</div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="middle" class="label">Tarikh</td>
                    <td width="100%"><?php echo getApplyDateByApplyID($applyid);?></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="label">Catatan</td>
                    <td><?php echo getApplyNoteByID($applyid);?></td>
                  </tr>
                </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Senarai Kakitangan</li>
                <li class="gap">&nbsp;</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_app > 0) { // Show if recordset not empty ?>
                <tr>
                  <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                  <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama Kakitangan</th>
                  <th align="left" valign="middle" nowrap="nowrap">Jenis Keperluan</th>
                  <th align="left" valign="middle" nowrap="nowrap">Item</th>
                  <th align="left" valign="middle" nowrap="nowrap">Status</th>
                  <th align="left" valign="middle" nowrap="nowrap">Catatan</th>
                </tr>
                <?php $i=1; do { ?>
                    <tr class="on">
                      <td align="center" valign="middle"><?php echo $i;?></td>
                      <td align="left" valign="middle"><a href="applydetailbyuser.php?id=<?php echo getID($row_app['user_stafid']); ?>"><?php echo getFullNameByStafID($row_app['user_stafid']) . " (" . $row_app['user_stafid'] . ")"; ?></a></td>
                      <td align="left" valign="middle" nowrap="nowrap"><?php echo getReqTypeNameByReqID($row_app['reqtype_id']); ?></td>
                      <td align="left" valign="middle" nowrap="nowrap"><?php echo getItemCategoryBySubCatID($row_app['subcategory_id']) . " &nbsp; &bull; &nbsp; " . getItemSubCategoryByID($row_app['subcategory_id']); ?></td>
                      <td align="left" valign="middle" nowrap="nowrap"><?php echo getStatusNameByID($row_app['applystatus_id']); ?></td>
                      <td align="left" valign="middle" nowrap="nowrap"><?php echo getICTNoteByID($row_app['uai_id']);?></td>
                    </tr>
                    <?php $i++; } while ($row_app = mysql_fetch_assoc($app)); ?>
                <tr>
                  <td colspan="6" align="center" valign="middle"><?php echo $totalRows_app ?> rekos dijumpai</td>
                </tr>
                <?php } else { ?>
                <tr>
                  <td colspan="6" align="center" valign="middle">Tiada rekod dijumpai</td>
                </tr>
                <?php }; ?>
                </table>
              </li>
            </ul>
            <?php }; ?>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($app);
?>
<?php include('../inc/footinc.php');?> 