<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='9';?>
<?php $menu2='56';?>
<?php

$colname_tr = "-1";
if (isset($_GET['id'])) {
  $colname_tr = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
}
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = sprintf("SELECT * FROM transport_book WHERE transbook_id = %s AND transbook_status = 1 ORDER BY transbook_id ASC", GetSQLValueString($colname_tr, "int"));
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_passenger = sprintf("SELECT * FROM passenger WHERE passenger_status=1 AND transbook_id = %s ORDER BY passenger_id ASC", GetSQLValueString($colname_tr, "int"));
$passenger = mysql_query($query_passenger, $tadbirdb) or die(mysql_error());
$row_passenger = mysql_fetch_assoc($passenger);
$totalRows_passenger = mysql_num_rows($passenger);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_journey = sprintf("SELECT * FROM journey WHERE journey_status=1 AND transbook_id = %s ORDER BY journey_id ASC", GetSQLValueString($colname_tr, "int"));
$journey = mysql_query($query_journey, $tadbirdb) or die(mysql_error());
$row_journey = mysql_fetch_assoc($journey);
$totalRows_journey = mysql_num_rows($journey);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_transport = sprintf("SELECT * FROM transport WHERE transport_status=1 AND transport_id = %s ORDER BY transport_id ASC", GetSQLValueString($colname_tr, "int"));
$transport = mysql_query($query_transport, $tadbirdb) or die(mysql_error());
$row_transport = mysql_fetch_assoc($transport);
$totalRows_tranport = mysql_num_rows($transport);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_driver = sprintf("SELECT * FROM driver WHERE driver_status=1 AND driver_id = %s ORDER BY driver_id ASC", GetSQLValueString($colname_tr, "int"));
$driver = mysql_query($query_driver, $tadbirdb) or die(mysql_error());
$row_driver = mysql_fetch_assoc($driver);
$totalRows_driver = mysql_num_rows($driver);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_transdriver = sprintf("SELECT * FROM transdriver WHERE transbook_id = %s AND transdriver_status= 1 ORDER BY transdriver_id ASC", GetSQLValueString($colname_tr, "int"));
$transdriver = mysql_query($query_transdriver, $tadbirdb) or die(mysql_error());
$row_transdriver = mysql_fetch_assoc($transdriver);
$totalRows_transdriver = mysql_num_rows($transdriver);

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
            	<li><div class="note">Maklumat lengkap permohonan penggunaan kenderaan</div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" class="label">Tujuan / Program</td>
                      <td><?php echo $row_tr['transbook_title']; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" class="label">Bil kenderaan (cadangan)</td>
                      <td><?php echo $row_tr['transbook_notrans'];?></td>
                    </tr>
                    <tr>
                      <td valign="middle" class="label">Catatan</td>
                      <td><?php echo $row_tr['transbook_note'];?></td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Maklumat Perjalanan</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <?php if ($totalRows_journey > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="25%" align="left" valign="middle" nowrap="nowrap">Dari</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                      <th width="25%" align="left" valign="middle" nowrap="nowrap">Ke</th>
                      <th width="25%" align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="25%" align="center" valign="middle" nowrap="nowrap">Masa</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle"><?php echo $row_journey['journey_from']; ?></td>
                        <td align="center" valign="middle">&raquo;</td>
                        <td align="left" valign="middle"><?php echo $row_journey['journey_to']; ?></td>
                        <td align="center" valign="middle"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_journey['journey_date_m'], $row_journey['journey_date_d'], $row_journey['journey_date_y']));?></td>
                        <td align="center" valign="middle"><?php echo getJourneyTimeByJourneyID($row_journey['journey_id']); ?></td>
                      </tr>
                      <?php $i++; } while ($row_journey = mysql_fetch_assoc($journey)); ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_journey ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                   <li class="gap">&nbsp;</li>
                <li class="title">Maklumat Penumpang</li>
                <li>
                <div class="note">Senarai Penumpang</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_passenger > 0) { // Show if recordset not empty ?>
                      <tr>
                        <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                        <th width="100%" align="left" valign="middle" nowrap="nowrap">Maklumat Penumpang</th>
                      </tr>
                      <?php $i=1; do { ?>
          <tr class="on">
                          <td><?php echo $i;?></td>
                          <td align="left" class="txt_line">
                          	<div><strong><?php echo getFullNameByStafID($row_passenger['user_stafid']) . " (" . $row_passenger['user_stafid'] . ")";?></strong></div>
                            <div><?php echo getFulldirectoryByUserID($row_passenger['user_stafid']);?> &nbsp; &bull; &nbsp; No. Ext : <?php if(getExtNoByUserID($row_passenger['user_stafid'])!=NULL) echo getExtNoByUserID($row_passenger['user_stafid']); else echo "Tidak dinyatakan";?>
                            </div>
                          </td>
                        </tr>
                        <?php $i++; } while ($row_passenger = mysql_fetch_assoc($passenger)); ?>
                      <tr>
                        <td colspan="3" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_passenger ?>  rekod dijumpai</td>
                      </tr>
                    <?php } else { ?>
                      <tr>
                        <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                      </tr>
                    <?php }; ?>
                    </table>  
              </li>
              <?php if($row_tr['admin_status']==0){?>
               <li class="form_back2 line_t">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="../icon/lock.png" alt="Pending" width="16" height="16" border="0" align="absbottom"></td>
                      <td class="noline txt_line">Permohonan penggunaan kenderaan masih dalam proses kelulusan daripada <?php echo getDirSubName(getDirIDByMenuID($menu));?>. Sebarang penukaran maklumat perlu dimaklumkan kepada <?php echo getDirSubName(getDirIDByMenuID($menu));?>.</td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
                <?php if($row_tr['admin_status']!=0){?>
                <li class="title">Kelulusan</li>
                <li class="gap">&nbsp;</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Kelulusan</td>
                    <td><strong>
                      <?php if(checkAdminAppByID($colname_tr)) echo "Diluluskan"; else echo "Tidak Diluluskan";?>
                      </strong> oleh <strong>
                        <?php echo getFullNameByStafID($row_tr['admin_by']) . " (" . $row_tr['admin_by'] . ")";?>
                      </strong></td>
                  </tr>
                  <tr>
                    <td class="label">Tarikh</td>
                    <td><?php echo $row_tr['admin_date'];?></td>
                  </tr>
                  <?php if($row_tr['admin_note']!=NULL){?>
                  <tr>
                    <td class="label">Catatan</td>
                    <td><?php echo $row_tr['admin_note'];?></td>
                  </tr>
                  <?php }; ?>
                </table>
                </li>
                <?php }; ?>  
                <?php if($row_tr['admin_status']==1){?>
                <li class="gap">&nbsp;</li>
                <li class="title">Maklumat Kenderaan</li>
                <li class="gap">&nbsp;</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_transdriver> 0) { // Show if recordset not empty ?>
                      <tr>
                        <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                        <th width="50%" align="left" valign="middle" nowrap="nowrap">Kenderaan</th>
                        <th width="50%" colspan="2" align="left" valign="middle" nowrap="nowrap">Maklumat Pemandu</th>
                      </tr>
                      <?php $i=1; do { ?>
                      <tr class="on">
                          <td align="center" valign="middle"><?php echo $i;?></td>
                          <td align="left" valign="middle" class="txt_line">
                          	<div><strong><?php echo getTransportNameByID($row_transdriver['transport_id']);?></strong></div>
                            <div><?php echo getTransportPlatByID($row_transdriver['transport_id']);?></div>
                          </td>
                          <td align="center" valign="middle" class="txt_line"><?php echo viewProfilePic(getStafIDByID($row_transdriver['driver_id']));?></td>
                          <td width="100%" align="left" valign="middle" class="txt_line">
                          	<div><strong><?php echo  getDriverNameByID($row_transdriver['driver_id']) . " (" . getStafIDByID($row_transdriver['driver_id']) . ")";?></strong></div>
                            <div><?php echo getFulldirectoryByUserID(getStafIDByID($row_transdriver['driver_id']));?></div>
                            <div>Ext : <?php if(getExtNoByUserID(getStafIDByID($row_transdriver['driver_id']))!=NULL) echo getExtNoByUserID(getStafIDByID($row_transdriver['driver_id'])); else echo "Tidak dinyatakan";?> &nbsp; &bull; &nbsp; No. Tel (HP) : <?php if(checkTelMByStafID(getStafIDByID($row_transdriver['driver_id']))) echo getTelMByStafID(getStafIDByID($row_transdriver['driver_id'])); else echo "-";?></div>
                          </td>
                        </tr>
                        <?php $i++; } while ($row_transdriver = mysql_fetch_assoc($transdriver)); ?>
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_transdriver ?>  rekod dijumpai</td>
                      </tr>
                    <?php } else { ?>
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="noline txt_line">
                        <div>Masih dalam proses pengemaskinian.</div>
                        <div>Sila berhubung dengan <?php echo getDirSubName(getDirIDByMenuID($menu));?> untuk maklumat lanjut.</div>
                        </td>
                      </tr>
                    <?php }; ?>
                    </table>
              <li class="gap">&nbsp;</li>
                <?php }; ?>
            </ul>
            </div>
        </div>
        <?php echo noteMade($menu);?>
        </div> 
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($tr);
mysql_free_result($passenger);
mysql_free_result($transport);
mysql_free_result($driver);
mysql_free_result($journey);
mysql_free_result($transdriver);
?>
<?php include('../inc/footinc.php');?> 