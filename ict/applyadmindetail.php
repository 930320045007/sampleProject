<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='69';?>
<?php
if (isset($_GET['id']))
	$id = $_GET['id'];
else $id= 0;
?>
<?php	
mysql_select_db($database_ictdb, $ictdb);
$query_apply = "SELECT * FROM ict.user_applyitem WHERE userapply_id ='" .$id. "' AND uai_status = 1 " ;
$apply = mysql_query($query_apply, $ictdb) or die(mysql_error());
$row_apply = mysql_fetch_assoc($apply);
$totalRows_apply = mysql_num_rows($apply);
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
        
        <?php include('../inc/menu_ict.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){ ?>
           <div class="note">Maklumat permohonan peralatan Unit ICT</div>
                <ul>
                	<li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                          <td colspan="2"><?php echo getApplyNoteByID($row_apply['userapply_id']);?></td>
                          </tr>
                          <tr>
                          <td>&nbsp;</td>
                           <?php if(checkApplyStatusByID($id)!=0){?><td colspan="2"><input name="button5" type="button" class="submitbutton" id="button5" value="Cetak" onclick="MM_openBrWindow('printapply.php?id=<?php echo getID(htmlspecialchars($id,ENT_QUOTES));?>','applyprint','status=yes,scrollbars=yes,width=800,height=600')" />
                      </td>
                      <?php };?>
                      </tr>
                      </table>
                    </li>
                    <li class="gap">&nbsp;</li>
                	<li class="title">Senarai Kakitangan</li>
                    <li class="gap">&nbsp;</li>
                    <li>
                     <form id="form1" name="form1" method="post" action="../sb/update_userapply.php">
  					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php if ($totalRows_apply > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th nowrap="nowrap">Bil</th>
                        <th colspan="2" align="left" valign="middle" nowrap="nowrap">Nama Kakitangan</th>
                         <th align="left" valign="middle" nowrap="nowrap">Jenis</th>
                         <th align="left" valign="middle" nowrap="nowrap">Item</th>
                        <th align="left" valign="middle" nowrap="nowrap">Status</th>
                          <th align="left" valign="middle" nowrap="nowrap">Catatan</th>
                           <th align="left" valign="middle" nowrap="nowrap">&nbsp;</th>
                        </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td><?php echo $i;?></td>
                            <td align="center" valign="top" class="txt_line"><?php echo viewProfilePic(getStafIDByApplyID($row_apply['user_stafid']));?></td>
                            <td width="100%" align="left" valign="middle" class="txt_line">
                            <div><strong><?php echo getFullNameByStafID($row_apply['user_stafid']); ?></strong> (<?php echo $row_apply['user_stafid'];?>)</div>
                            <div><?php echo getFulldirectoryByUserID($row_apply['user_stafid']);?><?php echo " &nbsp; &bull; &nbsp; Ext : " . getExtNoByUserID($row_apply['user_stafid']);?></div> 
                            </td>
                            <td align="left" valign="middle" nowrap="nowrap"><?php echo getReqTypeNameByReqID($row_apply['reqtype_id']); ?></td>
                            <td align="left" valign="middle" nowrap="nowrap"><?php echo getItemCategoryBySubCatID($row_apply['subcategory_id']) . " &nbsp; &bull; &nbsp; " . getItemSubCategoryByID($row_apply['subcategory_id']); ?></td>
                            <td align="left" valign="middle" nowrap="nowrap">
							<?php if($row_apply['ict_status']==0 && $row_apply['applystatus_id']==0){?>
                            <?php
                            mysql_select_db($database_ictdb, $ictdb);
                            $query_status = "SELECT * FROM ict.apply_status WHERE applystatus_status = '1' ORDER BY applystatus_name ASC";
                            $status = mysql_query($query_status, $ictdb) or die(mysql_error());
                            $row_status = mysql_fetch_assoc($status);
                            $totalRows_status = mysql_num_rows($status);
							?>
                             <input name="id[]" type="hidden" id="id" value="<?php echo $row_apply['uai_id'];?>" />
                             <select name="ict_status[]" id="ict_status[]">
                               <?php
								do { ?>
                               <option value="<?php echo $row_status['applystatus_id']?>"><?php echo $row_status['applystatus_name']?></option>
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
                        <?php } else echo getStatusNameByID(getStatusByID($row_apply['uai_id']));?>
                        </td>
                        <td align="left" valign="middle" nowrap="nowrap">
                       <?php if($row_apply['ict_status']==0 && $row_apply['applystatus_id']==0){?>
                         <input name="ict_note[]" type="text" id="ict_note[]" value="" size="49" />
                       <?php } else echo $row_apply['ict_note']; ?>
                        </td>
                        <td nowrap="nowrap">
                      <ul class="func">
                      <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                      <li><a href="userapplyedit.php?id=<?php echo $id;?>&uaid=<?php echo $row_apply['uai_id'];?>">Edit</a></li>
                      <?php }; ?>
                      </ul>
                      </td>
          				</tr>
                          <?php $i++; } while ($row_apply = mysql_fetch_assoc($apply)); ?>
                     <?php if(checkApplyStatusByID($id)==0){?>   <tr>
                       <td colspan="6" align="center" valign="middle" class="txt_color1 noline">&nbsp;</td>
                       <td align="center" valign="middle" class="txt_color1 noline">
                       <input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                       <input name="applyid" type="hidden" id="applyid" value="<?php echo $_GET['id'];?>" /></td>
                        </tr>
                        <?php }; ?>
                        <tr>
                          <td colspan="9" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_apply ?> rekod dijumpai</td>
                          </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="9" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
                      </form>
                    </li>
                  <li class="form_back2 line_t"> 
                </ul>
           <?php } else { ?>
           <ul>
           	<li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" valign="middle" class="noline"><?php echo noteError(1);?></td>
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

mysql_free_result($apply);
?>
<?php include('../inc/footinc.php');?> 