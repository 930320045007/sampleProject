<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='80';?>
<?php
$colname_main = "-1";
if (isset($_GET['id'])) {
  $colname_main = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
}

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_main = sprintf("SELECT * FROM tadbir.maintenance WHERE maintenance_status = 1 AND maintenance_id=%s ORDER BY maintenance_id DESC", GetSQLValueString($colname_main,"int"));
$main = mysql_query($query_main, $tadbirdb) or die(mysql_error());
$row_main = mysql_fetch_assoc($main);
$totalRows_main = mysql_num_rows($main);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_maintype = sprintf("SELECT * FROM tadbir.maintenance_type LEFT JOIN tadbir.maintenance_normalize ON maintenance_type.maintenancetype_id= maintenance_normalize.maintenancetype_id WHERE maintenance_id = %s AND maintenancetype_status = 1 AND mainnormalize_status=1 ORDER BY maintenance_normalize.maintenancetype_id DESC", GetSQLValueString($colname_main, "int"));
$maintype = mysql_query($query_maintype, $tadbirdb) or die(mysql_error());
$row_maintype = mysql_fetch_assoc($maintype);
$totalRows_maintype = mysql_num_rows($maintype);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_type = "SELECT * FROM tadbir.transport_type WHERE transporttype_status = 1 ORDER BY transporttype_name ASC";
$type = mysql_query($query_type, $tadbirdb) or die(mysql_error());
$row_type = mysql_fetch_assoc($type);
$totalRows_type = mysql_num_rows($type);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = "SELECT transport.transport_id, transport.transport_name, transport.transporttype_id FROM tadbir.maintenance LEFT JOIN tadbir.transport ON transport.transport_id = maintenance.transport_id WHERE  maintenance_status = '1' GROUP BY transport_id ORDER BY transport.transport_name ASC";
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_desc_inv = sprintf("SELECT * FROM tadbir.desc_invoice WHERE maintenance_id = %s AND descinv_status = 1 ORDER BY maintenance_id ASC", GetSQLValueString($colname_main, "int"));
$desc_inv = mysql_query($query_desc_inv, $tadbirdb) or die(mysql_error());
$row_desc_inv= mysql_fetch_assoc($desc_inv);
$totalRows_desc_inv = mysql_num_rows($desc_inv);
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
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(getMaintenanceBy($colname_main)==$row_user['user_stafid']){?>
                <?php  if(checkAdminApp($colname_main) && !checkMaintenanceApp($colname_main)){ ?>
                <li class="form_back">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">Bersama-sama ini disertakan dokumen-dokumen untuk permohonan kelulusan dan penyimpanan rekod penyelenggaraan :</td>
                    </tr>
                    <tr>
                      <td class="noline txt_line">
                      <ol>
                      	<li>Borang Penyelenggaraan Kenderaan  (Sila klik pada butang 'Cetak' dibawah)</li>
                    	<li>Salinan DO yang dikeluarkan oleh Agensi Penyelenggaraan</li> 
                      </ol>
                      </td>
                    </tr>
                    <tr>
                      <td><input name="button3" type="button" class="submitbutton" id="button3" value="Cetak" onClick="MM_openBrWindow('maintenanceprint.php?id=<?php echo getID($colname_main);?>','printmaintenance','scrollbars=yes,width=930,height=600')" /></td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
            	<li><div class="note">Maklumat lengkap penyelenggaraan kenderaan</div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Kenderaan</td>
                      <td colspan="2"><?php echo getTypeNameByMaintenanceID($colname_main);?> <?php echo getTransportNameByMaintenanceID($colname_main);?></td>
                    </tr> 
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">No. Pendaftaran</td>
                      <td colspan="2"><?php echo getTransportPlatByMaintenanceID($colname_main);?></td>
                    </tr>
                     <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Bacaan Odometer</td>
                      <td colspan="2"><?php echo getOdometerByID($colname_main);?></td>
                    </tr>   
                     <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Ulasan</td>
                      <td colspan="2"><?php echo getMaintenanceNoteByID($colname_main);?></td>
                    </tr>
                  </table>
                </li>
                 <?php if(!checkAdminApp($colname_main)){?>
               <li class="form_back2 line_t">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="../icon/lock.png" alt="Pending" width="16" height="16" border="0" align="absbottom"></td>
                      <td class="noline txt_line">Permohonan penyelenggaraan kenderaan masih dalam proses kelulusan daripada pegawai bertanggungjawab. Sebarang penukaran maklumat perlu dimaklumkan.</td>
                    </tr>
                  </table>
              </li>
                <?php }; ?>
                 <li class="gap">&nbsp;</li>
                <li class="title">Jenis Penyelenggaraan</li>
                <li class="gap">&nbsp;</li>
                 <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_maintype > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="25%" align="left" valign="middle" nowrap="nowrap">Jenis Penyelenggaraan</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                         <td width="100%"><?php echo $row_maintype['maintenancetype_name']; ?></td>
                      </tr>
                      <?php $i++; } while ($row_maintype = mysql_fetch_assoc($maintype)); ?>
                    <tr>
                      <td colspan="2" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_maintype ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="2" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                <?php  if(checkAdminApp($colname_main)){ ?>
                <li class="title">Kelulusan</li>
                <li class="gap">&nbsp;</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Kelulusan</td>
                    <td><strong><?php if($row_main['maintenance_adminstatus']==1) echo "Diluluskan"; else echo "Tidak Diluluskan";?></strong> oleh <strong><?php echo getFullNameByStafID(getAdminAppBy($colname_main));?></strong></td>
                  </tr>
                  <tr>
                    <td class="label">Tarikh</td>
                    <td><?php echo getAdminAppDateByID($colname_main);?></td>
                  </tr>
                  <?php if(getAdminAppNoteByID($colname_main)!=NULL){?>
                  <tr>
                    <td class="label">Catatan</td>
                    <td><?php echo getAdminAppNoteByID($colname_main);?></td>
                  </tr>
                  <?php }; ?>
                </table>
                </li>
                 <?php if ($row_main['maintenance_adminstatus']==1 && $row_main['maintenance_validstatus']!=0){?>
                <li class="title">Pengesahan</li>
                <li class="gap">&nbsp;</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Pengesahan</td>
                    <td><strong>
                      <?php if($row_main['maintenance_validstatus']==1) echo "Diluluskan"; else echo "Tidak Diluluskan";?>
                      </strong> oleh <strong>
                        <?php echo getFullNameByStafID(getAdminAppBy($colname_main));?></strong></td>
                  </tr>
                  <tr>
                    <td class="label">Tarikh</td>
                    <td><?php echo getValidDateByID($colname_main);?></td>
                  </tr> 
                  <tr>
                    <td class="label">Catatan</td>
                    <td><?php echo getValidNoteByID($colname_main);?></td>
                  </tr>
                </table>
                </li> 
                 <?php }; ?>
                <li class="gap">&nbsp;</li>
              <?php if(checkMaintenanceApp($colname_main)){?> 
              <li class="title">Maklumat Penyelenggaraan</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Tarikh</td>
                      <td colspan="3"><?php echo $row_main['maintenance_appdate'];?></td>
                    </tr>
                    <tr>
                      <td class="label">Agensi</td>
                      <td colspan="3" class="txt_line">
					  	<div><strong><?php echo getTransagencyNameByID($row_main['transagency_id']);?></strong></div>
                        <div><?php if(getTransagencyNoTelByID($row_main['transagency_id'])!=NULL) echo "Tel : " . getTransagencyNoTelByID($row_main['transagency_id']);?><?php if(getTransagencyNoFaxByID($row_main['transagency_id'])!=NULL) echo " &nbsp; &bull; &nbsp; Fax : " . getTransagencyNoFaxByID($row_main['transagency_id']);?><?php if(getTransagencyEmailByID($row_main['transagency_id'])!=NULL) echo " &nbsp; &bull; &nbsp; Email : " . getTransagencyEmailByID($row_main['transagency_id']);?></div>
                      </td>
                    </tr>
                     <tr>
                      <td class="label">Kenderaan Masuk</td>
                        <td width="100%" nowrap="nowrap" class="w35">
                     <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_main['maintenance_in_m'], $row_main['maintenance_in_d'], $row_main['maintenance_in_y']));?></td>
                       <td class="label">Masa</td>
                        <td width="100%" nowrap="nowrap" class="w35">
                      <?php echo $row_main['maintenance_in_time'];?></td>
                    </tr>
                    <tr>
                      <td class="label">Kenderaan Keluar</td>
                        <td width="100%" nowrap="nowrap" class="w35">
                     <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_main['maintenance_out_m'], $row_main['maintenance_out_d'], $row_main['maintenance_out_y']));?></td>
                       <td class="label">Masa</td>
                        <td width="100%" nowrap="nowrap" class="w35">
                      <?php echo $row_main['maintenance_out_time'];?></td>
                    </tr>
                    <tr>
                      <td class="label">Tarikh Invois</td>
                     <td width="100%" nowrap="nowrap" class="w35">
					 <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_main['maintenance_do_m'], $row_main['maintenance_do_d'], $row_main['maintenance_do_y']));?></td>
                      <td class="label">No. Rujukan DO/Invois</td>
                      <td><?php echo $row_main['maintenance_refno'];?></td>
                    </tr>
                    <tr>
                      <td class="label">Catatan</td>
                      <td colspan="3"><?php echo $row_main['maintenance_appnote'];?></td>
                    </tr>
                  </table>
              <li>
              <li class="gap">&nbsp;</li>
                     <div class="note">Deskripsi Invois</div>
                     </li>
                     <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_desc_inv > 0) { // Show if recordset not empty ?>
                    <tr>
                    <th align="center" valign="middle">Bil</th>
                    <th align="left" valign="middle">Deskripsi</th>
                    <th align="left" valign="middle">Kategori</th>
                    <th align="left" valign="middle">Kuantiti</th>
                    <th align="center" valign="middle">Amount (RM)</th>  
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td><?php echo getDescNameByID($row_desc_inv['desc_id']); ?></td>
                        <td><?php echo getTadbirCategoryNameByID($row_desc_inv['category_id']); ?></td>
                        <td><?php echo $row_desc_inv['descinv_quantity']; ?></td>
                        <td align="center"><?php echo $row_desc_inv['descinv_amount']; ?></td>
                      </tr>
                      
                      <?php $i++; } while ($row_desc_inv = mysql_fetch_assoc($desc_inv)); ?>
                      <tr>
                        <td colspan="4" align="right"><strong>Jumlah (RM)</strong></td>
                        <td align="center" class="back_darkgrey"><strong><?php echo number_format(getAmountByID($colname_main),2); ?></strong></td>
                      </tr> 
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_desc_inv ?> rekod dijumpai</td>
                      </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
              </li> 
                <?php }; ?>
			<?php }; ?>
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

mysql_free_result($main);

mysql_free_result($desc_inv);

mysql_free_result($tr);

mysql_free_result($maintype);

mysql_free_result($type);
?>
<?php include('../inc/footinc.php');?> 