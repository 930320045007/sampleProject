<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php $menu='16';?>
<?php $menu2='89';?>
<?php $menu3='3';?>
<?php
$colname_jkb = "-1";
if (isset($_GET['id'])) {
  $colname_jkb = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
}
mysql_select_db($database_financedb, $financedb);
$query_jkb = sprintf("SELECT * FROM finance.jkb WHERE jkb_id = %s AND jkb_status = 1 ORDER BY jkb_id ASC", GetSQLValueString($colname_jkb, "int"));
$jkb = mysql_query($query_jkb, $financedb) or die(mysql_error());
$row_jkb = mysql_fetch_assoc($jkb);
$totalRows_jkb = mysql_num_rows($jkb);

mysql_select_db($database_financedb, $financedb);
$query_apply = sprintf("SELECT * FROM finance.apply WHERE apply_status = 1 AND jkb_id = %s ORDER BY apply_id ASC", GetSQLValueString($colname_jkb, "int"));
$apply = mysql_query($query_apply, $financedb) or die(mysql_error());
$row_apply = mysql_fetch_assoc($apply);
$totalRows_apply = mysql_num_rows($apply);

mysql_select_db($database_financedb, $financedb);
$query_bil = "SELECT * FROM bil WHERE bil_status = 1 ORDER BY bil_no ASC";
$bil = mysql_query($query_bil, $financedb) or die(mysql_error());
$row_bil= mysql_fetch_assoc($bil);
$totalRows_bil = mysql_num_rows($bil);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script type="text/javascript" src="../js/tabber.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
     <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <?php include('../inc/menu_jkbsenarai.php');?>
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            	<li>  <div class="note">Maklumat permohonan Jawatankuasa Bantuan Pelaksanaan Program / Aktiviti Institut Sukan Negara <strong><?php if($row_jkb['bil_id']!=0) echo getBilNoByBilID(getBilIDByJkbID($row_jkb['jkb_id']));?></strong></div></li>
                <li>
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="label">Kategori</td>
                          <td><?php echo getCategory($row_jkb['jkb_id']); ?></td>
                        </tr>
                         <tr>
                          <td class="label">No. Rujukan</td>
                          <td><?php echo $row_jkb['jkb_ref']; ?></td>
                        </tr>
                        <tr>
                          <td class="label">Aktiviti</td>
                          <td nowrap="nowrap"><?php echo $row_jkb['jkb_activity']; ?></td>
                        </tr>
                        <tr>
                          <td class="label">Perihal</td>
                          <td nowrap="nowrap"><?php echo $row_jkb['jkb_detail'];?></td>
                        </tr>
                      </table>
                    </li>
                    <li class="gap">&nbsp;</li>
                	<li class="title">Maklumat Permohonan</li>
                    <li class="gap">&nbsp;</li>
                    <li>
                     <?php if ($totalRows_apply > 0) { // Show if recordset not empty ?>
                     <form id="form1" name="form1" method="post" action="../sb/update_jkbstatus.php">
  					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <th nowrap="nowrap">Bil</th>
                          <th align="left" nowrap="nowrap">Diskripsi/Perbelanjaan Dipohon</th>
                          <th width="50%" align="center" valign="middle" nowrap="nowrap">Kuantiti</th>
                          <th align="left" nowrap="nowrap">Pengiraan </th>
                          <th width="50%" align="center" valign="middle" nowrap="nowrap">Jumlah (RM)</th>
                          <th align="center" valign="middle" nowrap="nowrap">Status</th>
                          <th align="center" valign="middle" nowrap="nowrap">Catatan</th>
                          <th></th>
                        </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td><?php echo $i;?></td>
                            <td align="left"><?php echo $row_apply['apply_description']; ?></td>
                            <td align="center" nowrap="nowrap"><?php echo $row_apply['apply_quantity']; ?></td>
                            <td align="left" nowrap="nowrap"><?php echo $row_apply['apply_calculation']; ?></td>
                            <td align="center" nowrap="nowrap"><?php if($row_apply['applystatus_id']==2) echo "( - ) "  . number_format($row_apply['apply_amount'],2); else echo number_format($row_apply['apply_amount'],2); ?></td>
                            <td align="left" valign="middle" nowrap="nowrap">
							<?php if($row_apply['applystatus_id']==0){?>
                            <?php
                            mysql_select_db($database_financedb, $financedb);
                            $query_status = "SELECT * FROM finance.apply_status WHERE applystatus_status = '1' ORDER BY applystatus_name ASC";
                            $status = mysql_query($query_status, $financedb) or die(mysql_error());
                            $row_status = mysql_fetch_assoc($status);
                            $totalRows_status = mysql_num_rows($status);
							?>
                             <input name="id[]" type="hidden" id="id" value="<?php echo $row_apply['apply_id'];?>" />
                             <select name="fin_status[]" id="fin_status[]">
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
                        <?php } else echo getStatusNameByID(getStatusByID($row_apply['apply_id']));?>
                        </td>
                         <td align="center" valign="middle" nowrap="nowrap">
                       <?php if($row_apply['applystatus_id']==0){?>
                         <input name="fin_note[]" type="text" id="fin_note[]" value="" size="49" />
                       <?php } else echo $row_apply['fin_note']; ?>
                        </td>
                         <td align="center" valign="middle"><ul class="func"><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                         
                      <?php echo "<a href=\"editapply.php?appid=" . $row_apply['apply_id'] . "&id=" . $colname_jkb . "\">Edit</a>"; ?>
                      <?php }; ?>
                      </ul>
                      </td>
                          </tr>
                          <?php $i++; } while ($row_apply = mysql_fetch_assoc($apply)); ?>
                           
                           <tr>
                        <td colspan="4" align="right"></td>
                        <td align="center" class="back_darkgrey"><strong><?php echo number_format(getActualTotalAmountByJkbID($row_jkb['jkb_id']),2);?></strong></td><?php if(checkJKBApp($colname_jkb)==NULL){?> 
                       <td align="center" valign="middle" class="txt_color1 noline">&nbsp;</td>
                       <td align="center" valign="middle" class="txt_color1 noline">
                        <input name="jkb_id" type="hidden" id="jkb_id" value="<?php echo $colname_jkb;?>" />
                       <input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />                       
                        <?php }; ?>
                      </tr> 
                        <tr>
                          <td colspan="7" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_apply ?> rekod dijumpai</td>
                        </tr>
                      <?php } else { ?>
                        <tr>
                          <td colspan="7" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
                </form>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Pengesahan</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Pengesahan oleh</td>
                      <td><strong><?php if(getJKBAppBy($colname_jkb)==1) echo getJob2Name('2'); if (getJKBAppBy($colname_jkb)==2) echo "Pengarah Bahagian"; if(getJKBAppBy($colname_jkb)==3) echo "Ahli Mesyuarat"; ?></strong></td>
                    </tr>
                    <tr>
                      <td class="label">Tarikh</td>
                      <td><?php echo getJKBAppDate($colname_jkb);?></td>
                    </tr>
                    <?php if(getJKBAppNote($colname_jkb)!=NULL){?>
                    <tr>
                      <td class="label">Catatan</td>
                      <td><?php echo getJKBAppNote($colname_jkb);?></td>
                    </tr> 
                     <?php }; ?>
                    <tr>
                      <td colspan="2" class="txt_line noline"><div class="inputlabel2">Dikemaskini oleh <?php echo getFullNameByStafID(getAppUpdateByJKBApp($colname_jkb)) . " (" . getAppUpdateByJKBApp($colname_jkb) . ")";?> pada <?php echo getAppUpdateDateJKBApp($colname_jkb);?></div></td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
              
            <?php } else { ?>
                <li>
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td align="center" valign="middle" class="noline"><?php echo noteError();?></td>
              	    </tr>
              	  </table>
                </li>
            <?php }; ?>
            </ul>
            </div>
        </div>
        <?php echo noteFooter('1'); ?>
        <?php echo noteEmail('1'); ?>
        </div>
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($jkb);
mysql_free_result($bil);
mysql_free_result($apply);

?>
<?php include('../inc/footinc.php');?> 