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
};

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
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
              <tr>
                  <td align="center" valign="middle" nowrap="nowrap"><img src="<?php echo $url_main;?>img/isn.png" width="75" height="70" alt="isn" /></td>
                  <td width="100%" align="left" valign="middle" nowrap="nowrap" class="fsize2"><strong>INSTITUT SUKAN NEGARA</strong><br />
                  Borang Penyelenggaraan Kenderaan Rasmi ISN</td>
                  <td align="left" valign="middle" nowrap="nowrap">Tarikh : <?php echo date('d / m / Y (D)', mktime(0 , 0, 0, date('m'), date('d'), date('Y')));?></td>
              </tr>
            </table>
        </tr>
        <tr>
          <td width="100%" height="100%" align="left" valign="top" style="border-right: #999 thin solid;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
        <tr class="line_b">
          <td valign="middle" nowrap="nowrap" class="label"> Pemohon</td>
          <td width="100%" nowrap="nowrap"><?php echo getFullNameByStafID(getMaintenanceBy($colname_main)) . " (" . getMaintenanceBy($colname_main) . ")";?></td>
        </tr>
        <tr class="line_b">
          <td valign="middle" nowrap="nowrap" class="label">Kenderaan</td>
          <td><?php echo getTypeNameByMaintenanceID($colname_main);?> <?php echo getTransportNameByMaintenanceID($colname_main);?></td>
        </tr>
        <tr class="line_b">
         <td valign="middle" nowrap="nowrap" class="label">No. Pendaftaran</td>
         <td><?php echo getTransportPlatByMaintenanceID($colname_main);?></td>
        </tr>
        <tr class="line_b">
          <td valign="middle" nowrap="nowrap" class="label">Tarikh Tamat Cukai</td>
          <td><?php echo getRoadTaxDateByTransportID(getTransportIDByMaintenanceID($colname_main));?></td>
        </tr>
        <tr class="line_b">
          <td valign="middle" nowrap="nowrap" class="label">Bacaan Odometer</td>
          <td><?php echo getOdometerByID($colname_main);?></td>
        </tr>
        <tr class="line_b">
          <td valign="middle" nowrap="nowrap" class="label">Ulasan</td>
          <td><?php echo getMaintenanceNoteByID($colname_main);?></td>
        </tr>
      </table>
      <?php if ($totalRows_maintype > 0) { // Show if recordset not empty ?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle" nowrap="nowrap">Maklumat Penyelenggaraan</td>
        </tr>
	</table>     
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
    <tr>
      <th align="center" valign="middle">Bil</th>
      <th align="center" valign="middle">Jenis Penyelenggaraan</th>
    </tr>
   <?php $i=1; do { ?>
      <tr class="on">
        <td align="center" valign="middle"><?php echo $i;?></td>
        <td width="100%"><?php echo $row_maintype['maintenancetype_name']; ?></td>
      </tr>
     <?php $i++; } while ($row_maintype = mysql_fetch_assoc($maintype)); ?>
  <?php } else { ?>
    <tr>
      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
    </tr>
    <?php }; ?>
  </table> 
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Penyelenggaraan kenderaan selain daripada yang dilaporkan perlu mendapat kebenaran terlebih dahulu daripada Pegawai Pentadbiran Institut.</strong></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
        <tr>
          <td nowrap="nowrap">PENGESAHAN BENGKEL</td>
        </tr>
      </table>
      <br/>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
        <tr>
          <td nowrap="nowrap"><strong>Nama Syarikat :</strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap"><strong>Tarikh Masuk :</strong></td>
          <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
          <td>/</td>
          <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
          <td>/</td>
          <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
          <td>&nbsp;</td>
          <td width="50%" align="left" nowrap="nowrap"><strong>Masa :</strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap"><strong>Tarikh Keluar :</strong></td>
          <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
          <td>/</td>
          <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
          <td>/</td>
          <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
          <td>&nbsp;</td>
          <td width="50%" align="left" nowrap="nowrap"><strong>Masa :</strong></td>
        </tr>
      </table>
       <br/>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td colspan="4" class="tabborder"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        </tr>
        <tr>
          <td colspan="3">Tandatangan &amp; Cop Rasmi Syarikat</td>
        </tr>
     </table>
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Tarikh : </td>
        </tr>
     </table>
     <br />
     <br /><br />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
      <tr>
        <td align="left" valign="top" nowrap="nowrap"><img src="<?php echo $url_main;?>qr/qrmaintenance.php?mid=<?php echo $colname_main;?>" alt="" /></td>
        <td width="100%" align="left" valign="middle">Borang ini adalah cetakan melalui <?php echo $systitle_full;?> (<?php echo $systitle_short;?>)<br/>
              <br />
              <?php echo time();?></td>
      </tr>
    </table>       
</table>
</td>
</tr>
</table>
</body>
</html>
<?php
mysql_free_result($main);

mysql_free_result($maintype);

?>
<?php include('../inc/footinc.php');?> 