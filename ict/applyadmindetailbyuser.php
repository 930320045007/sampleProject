<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='69';?>
<?php
$useritemid = 0;
if (isset($_GET['id'])) 
{
	$useritemid = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
} 
	
mysql_select_db($database_ictdb, $ictdb);
$query_itemapply = "SELECT user_applyitem.* FROM ict.user_applyitem LEFT JOIN ict.user_apply ON user_apply.userapply_id = user_applyitem.userapply_id WHERE user_applyitem.user_stafid = '" . $useritemid ."' AND userapply_status = '1' ORDER BY userapply_date_y DESC, userapply_date_m DESC, userapply_date_d DESC, user_applyitem.userapply_id DESC";
$itemapply = mysql_query($query_itemapply, $ictdb) or die(mysql_error());
$row_itemapply = mysql_fetch_assoc($itemapply);
$totalRows_itemapply = mysql_num_rows($itemapply);
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
           <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
           <div class="note">Rekod permohonan peralatan / perisian ICT bagi kakitangan berikut</div>
                <ul>
                	<li>
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                        <tr>
                          <td align="center" valign="top"><?php echo viewProfilePic($useritemid);?></td>
                          <td width="100%" class="txt_line">
						  <div><strong><?php echo getFullNameByStafID($useritemid); ?></strong> (<?php echo $useritemid; ?>)</div>
                          <div><?php if(getCitizenByUserID($useritemid)=='130') echo getJobtitle($useritemid) . " (" . getGred($useritemid) . ")<br/>"; ?></div>
                          <div><?php echo getFulldirectoryByUserID($useritemid);?></div>
                          </td>
                        </tr>
                      </table>
                    </li>
                    <li class="gap">&nbsp;</li>
                	<li class="title">Maklumat Item</li>
                    <li>
  					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php if ($totalRows_itemapply > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                          <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                          <th align="center" valign="middle" nowrap="nowrap">Jenis</th>
                          <th width="100%" align="left" valign="middle" nowrap="nowrap">Item</th>
                          <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>
                        </tr>
                        <?php $i=1; do { ?>
                          <tr class="<?php if(getStatusByID($row_itemapply['uai_id'])==3) echo "offcourses"; else echo "on";?>">
                            <td align="center" valign="middle"><?php echo $i;?></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php echo getApplyDateByApplyID($row_itemapply['userapply_id']); ?></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php echo getReqTypeNameByReqID($row_itemapply['reqtype_id']); ?></td>
                            <td align="left" valign="middle" nowrap="nowrap"><a href="applyadmindetail.php?id=<?php echo $row_itemapply['userapply_id'];?>"><?php echo getItemCategoryBySubCatID($row_itemapply['subcategory_id']) . " &nbsp; &bull; &nbsp; " . getItemSubCategoryByID($row_itemapply['subcategory_id']); ?></a></td>
                             <td align="center" valign="middle" nowrap="nowrap"><?php echo getStatusNameByID(getStatusByID($row_itemapply['uai_id']));?></td>
                          </tr>
                          <?php $i++; } while ($row_itemapply = mysql_fetch_assoc($itemapply)); ?>
                        <tr>
                          <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_itemapply ?> rekod dijumpai</td>
                        </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
                    </li>
                   
               
                </ul>
           <?php } else { ?>
           <ul>
           		<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="middle" class="txt_line">
                    <div class="note">Permohonan <strong>hanya dibenarkan</strong> kepada Ketua Bahagian/Cawangan/Pusat/Unit sahaja. 
                    <br />
                    Sila berhubung dengan <strong>Ketua Bahagian/Cawangan/Pusat/Unit</strong> masing-masing.
                    </div>
                    </td>
                  </tr>
                </table>
                </li>
           </ul>
           <?php }; ?>
           </div>
          </div>
        </div>
  </div>
        
		<?php include('../inc/footer.php');?>
</div>
</div>
</body>
</html>
<?php

mysql_free_result($itemapply);
?>
<?php include('../inc/footinc.php');?> 