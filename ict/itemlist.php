<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='69';?>
<?php $menu3 = '1';?>
<?php

if(isset($_GET['jenis']))
	$jenis = htmlspecialchars($_GET['jenis'], ENT_QUOTES);
else 
	$jenis=1;

if(isset($_GET['sts']))
	$sts = htmlspecialchars($_GET['sts'], ENT_QUOTES);
else
	$sts = 0;

if(isset($_GET['dmy']))
	$dmy = explode("/",htmlspecialchars($_GET['dmy'], ENT_QUOTES));
else {
	$dmy[0]= date("m");
	$dmy[1]= date("Y");
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sch = "SELECT subcategory.* FROM ict.subcategory WHERE subcategory_status = '1' ORDER BY subcategory_name ASC";
$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
$row_sch = mysql_fetch_assoc($sch);
$totalRows_sch = mysql_num_rows($sch);

mysql_select_db($database_ictdb, $ictdb);
$query_status = "SELECT apply_status.* FROM ict.apply_status WHERE applystatus_status = '1' ORDER BY applystatus_name ASC";
$status = mysql_query($query_status, $ictdb) or die(mysql_error());
$row_status = mysql_fetch_assoc($status);
$totalRows_status= mysql_num_rows($status);

if($sts!=0)
	$sqljenis = " AND user_applyitem.applystatus_id = '" . $sts . "'";
else
	$sqljenis = "";

mysql_select_db($database_ictdb, $ictdb);
$query_apply = "SELECT * FROM ict.user_applyitem LEFT JOIN ict.user_apply ON user_apply.userapply_id = user_applyitem.userapply_id WHERE uai_status = 1  AND user_applyitem.subcategory_id= '".$jenis. "' AND user_apply.userapply_date_m = '". $dmy[0]."'  AND user_apply.userapply_date_y = '". $dmy[1]."' " . $sqljenis . " ORDER BY user_apply.userapply_date_y ASC, user_apply.userapply_date_m ASC, user_apply.userapply_date_d ASC, user_apply.userapply_id ASC";
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
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <?php include('../inc/menu_senaraipermohonan.php');?>
                <ul>
                	<li class="line_b">
                        <form action="itemlist.php" method="get">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td nowrap="nowrap" class="label">Jenis Item</td>
                                  	<td width="100%">
                                    <select name="jenis" id="jenis">
										   <?php
                                            do {  
                                            ?>
                                           <option <?php if($jenis == $row_sch['subcategory_id']) echo "selected=\"selected\"";?> value="<?php echo $row_sch['subcategory_id']?>"><?php if(getItemCategoryByID($row_sch['category_id'])!=$row_sch['subcategory_name']) echo getItemCategoryByID($row_sch['category_id']) . " " . $row_sch['subcategory_name']; else echo $row_sch['subcategory_name'];?></option>
                                           <?php
                                            } while ($row_sch = mysql_fetch_assoc($sch));
                                              $rows = mysql_num_rows($sch);
                                              if($rows > 0) {
                                                  mysql_data_seek($sch, 0);
                                                  $row_sch = mysql_fetch_assoc($sch);
                                              }
                                            ?>
                                    </select>
                                    <select name="sts" id="sts">
                                    	<option <?php if($sts== 0) echo "selected=\"selected\"";?> value="0">semua</option>
                                      <?php
										do {  
										?>
                                      <option <?php if($sts== $row_status['applystatus_id']) echo "selected=\"selected\"";?> value="<?php echo $row_status['applystatus_id']?>"><?php echo $row_status['applystatus_name']?></option>
                                      <?php
										} while ($row_status = mysql_fetch_assoc($status));
										  $rows = mysql_num_rows($status);
										  if($rows > 0) {
											  mysql_data_seek($status, 0);
											  $row_status = mysql_fetch_assoc($status);
										  }
										?>
                                    </select> 
                                     <select name="dmy" id="dmy">
                                          <?php
										  for ($i=0; $i<=12; $i++){  
										  ?><option <?php $dmyfull = $dmy[0] . "/" . $dmy[1]; if($dmyfull==date("m/Y",mktime(0,0,0,(date('m')-$i),1,date("Y"))))echo "selected=\"selected\"";?> value="<?php if ($i<10)$i="0".$i; echo date("m/Y",mktime(0,0,0,(date('m')-$i),1,date("Y"))); ?>"><?php echo date("M Y",mktime(0,0,0,(date('m')-$i),1,date("Y")));?>
                                          </option>
										  <?php };?>
                                      </select>
                                      <input name="semak" type="submit" class="submitbutton" id="semak" value="Semak" />
                                    </td>
                              </tr>
                           </table>
                        </form>
               	  </li>
               </ul>
             <ul>
                	<li>
                    <div class="note">Senarai maklumat kakitangan berdasarkan <b><?php echo getItemCategoryBySubCatID($jenis) . " " . getItemSubCategoryByID($jenis); ?></b> bagi bulan <strong><?php echo date("M Y",mktime(0,0,0,$dmy[0],1,$dmy[1]))?></strong></div>
                        <div class="off2">
                      		<table width="100%" border="0" cellspacing="0" cellpadding="0">
                			<?php if ($totalRows_apply > 0) { // Show if recordset not empty ?>
                                <tr>
                                  <th align="left" valign="middle" nowrap="nowrap">Bil</th>
                                  <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                                  <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama Kakitangan</th>
                                  <th align="center" valign="middle" nowrap="nowrap">Jenis</th>
                                  <th align="center" valign="middle" nowrap="nowrap">Status</th>
                                  <th width="214" align="left" valign="middle" nowrap="nowrap">Catatan</th>
                                </tr>
                             <?php $i=1; do { ?>
                                <tr class="<?php if(getStatusByID($row_apply['uai_id'])==3) echo "offcourses"; else echo "on";?>">
                                  <td align="left" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                                  <td width="165" align="center" valign="middle" nowrap="nowrap"><?php echo getApplyDateByApplyID($row_apply['userapply_id']);?></td>
                               	  <td width="408" align="left" nowrap="nowrap" class="txt_line">
                                  <div><strong><a href="applyadmindetailbyuser.php?id=<?php echo getID($row_apply['user_stafid']);?>"><?php echo getFullNameByStafID($row_apply['user_stafid'],1); ?> (<?php echo $row_apply['user_stafid'];?>)</a></strong></div>
                           	      <div><?php echo getFulldirectoryByUserID($row_apply['user_stafid']);?></div>
								  <div>Ext : <?php echo getExtNoByUserID($row_apply['user_stafid']);?></div></td>
                                  <td align="center" valign="middle" nowrap="nowrap"><?php echo getReqTypeNameByReqID($row_apply['reqtype_id']); ?></td>
                                  <td align="center" valign="middle" nowrap="nowrap"><?php echo getStatusNameByID(getStatusByID($row_apply['uai_id']));?></td>
                                  <td align="left" valign="middle" nowrap="nowrap"><?php echo $row_apply['ict_note'];?></td>
                                </tr>
                            <?php $i++; } while ($row_apply = mysql_fetch_assoc($apply)); ?>
                                <tr>
                                  <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_apply; ?> rekod dijumpai
                                  </td>
                                </tr>
							<?php } else { ?>
                                <tr>
                                  <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                                </tr>
                			<?php }; ?>
                          </table>
                    </div>
                </li>
            </ul>
            <?php } ; ?>
          </div>
        </div>
      </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php include('../inc/footinc.php');?> 
<?php
mysql_free_result($status);
mysql_free_result($sch);
mysql_free_result($apply);
?>