<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='81';?>
<?php

if(isset($_GET['id']) && $_GET['id']!=NULL)
	$colname_main = getID(htmlspecialchars($_GET['id'],ENT_QUOTES), 0);
else
	$colname_main = '0';
	
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_main = sprintf("SELECT * FROM transport LEFT JOIN tadbir.maintenance ON transport.transport_id=maintenance.transport_id WHERE maintenance.transport_id = %s AND maintenance_status = 1 ORDER BY maintenance_id ASC", GetSQLValueString($colname_main, "int"));
$main = mysql_query($query_main, $tadbirdb) or die(mysql_error());
$row_main = mysql_fetch_assoc($main);
$totalRows_main = mysql_num_rows($main);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = sprintf("SELECT * FROM transport WHERE transport_id= %s ORDER BY transport_id DESC", GetSQLValueString($colname_main,"int"));
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_roadtax = sprintf("SELECT * FROM roadtax WHERE transport_id = %s ORDER BY roadtax_id DESC", GetSQLValueString($colname_main, "int"));
$roadtax = mysql_query($query_roadtax, $tadbirdb) or die(mysql_error());
$row_roadtax = mysql_fetch_assoc($roadtax);
$totalRows_roadtax = mysql_num_rows($roadtax);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_odometer = sprintf("SELECT * FROM maintenance WHERE transport_id = %s AND maintenance_validstatus=1 ORDER BY maintenance_id DESC", GetSQLValueString($colname_main, "int"));
$odometer = mysql_query($query_odometer, $tadbirdb) or die(mysql_error());
$row_odometer= mysql_fetch_assoc($odometer);
$totalRows_odometer = mysql_num_rows($odometer);
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
              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            	<li><div class="note">Maklumat lengkap  kenderaan</div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" class="label">Jenis Kenderaan</td>
                      <td><?php echo getTypeNameByID($row_tr['transporttype_id']); ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" class="label">Nama Kenderaan</td>
                      <td><?php echo $row_tr['transport_name'];?></td>
                    </tr>
                    <tr>
                      <td valign="middle" class="label">No Pendaftaran</td>
                      <td><?php echo $row_tr['transport_plat'];?></td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Maklumat Cukai Jalan<span class="fr add" onclick="toggleview('formcukai','cukai'); return false;">Kemaskini</span></li>
                <div id="formcukai" class="hidden">
                <li>
                  <form id="cukai1" name="cukai1" method="post" action="../sb/add_roadtax.php">
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">   
                     <tr>
                     <td nowrap="nowrap" class="label">Tarikh Tamat Cukai</td>
                     <td width="100%">
                         <select name="roadtax_date_d" id="roadtax_date_d">
                                <?php for($i=1; $i<=31; $i++){?>
                                  <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                                <?php }; ?>
                                </select>
                                <select name="roadtax_date_m" id="roadtax_date_m">
                                <?php for($j=1; $j<=12; $j++){?>
                                  <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                                <?php }; ?>
                              </select>
                                <select name="roadtax_date_y" id="roadtax_date_y">
                                <?php for($k=date('Y'); $k<=(date('Y')+2); $k++){?>
                                  <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                <?php }; ?>
                              </select>
                              <input type="hidden" name="MM_update" value="cukai1" />
                              <input name="transportid" type="hidden" id="transportid" value="<?php echo getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);?>" /> 
                              <input name="button14" type="submit" class="submitbutton" id="button14" value="Kemaskini" />
                        </td>
                      </tr>
                    </table>
                  </form>
                  </li>
                </div>
                 <div id="cukai">
                <li>
               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_roadtax > 0) { // Show if recordset not empty ?>
<tr>
      
      <td nowrap="nowrap" class="label">Tarikh Tamat Cukai</td>
     <td align="left" valign="middle" nowrap="nowrap"><?php echo getRoadTaxDateByTransportID($colname_main);?></td>
    </tr>
     <?php } else { ?>
   <tr>
      <td colspan="2" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila kemaskini Maklumat Cukai Jalan</td>
   </tr>
        <?php }; ?>
      </table>
    </li>
    </div>
     <li class="gap">&nbsp;</li>
     <li class="title">Maklumat Penyelenggaraan</li>
      <li>
               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <?php if ($totalRows_odometer > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="25%" align="left" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th align="left" valign="middle" nowrap="nowrap">Pemohon</th> 
                      <th align="left" valign="middle" nowrap="nowrap">Bacaan Odometer</th>  
                    </tr>
                     <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle"><?php echo date('d / m / Y', mktime(0, 0, 0, $row_odometer['maintenance_m'], $row_odometer['maintenance_d'], $row_odometer['maintenance_y']));?></td>
                        <td align="left" valign="middle"><?php echo getFullNameByStafID($row_odometer['maintenance_by']) . " (" . $row_odometer['maintenance_by'] . ")";?></td>
                        <td align="left" valign="middle"><?php echo $row_odometer['maintenance_odometer'];?></td>    
       <?php $i++; } while ($row_odometer = mysql_fetch_assoc($odometer)); ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_odometer ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>       
     <?php } else { ?>
                        <li>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" class="noline"><?php echo noteError(1);?></td>
                          </tr>
                        </table>
                        </li>
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
mysql_free_result($main);
mysql_free_result($roadtax);
mysql_free_result($odometer);
?>
<?php include('../inc/footinc.php');?> 