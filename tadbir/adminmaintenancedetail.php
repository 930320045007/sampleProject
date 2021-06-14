<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='86';?>
<?php
$colname_tr = "-1";
if (isset($_GET['id'])) {
  $colname_tr = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
}

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_main = sprintf("SELECT * FROM tadbir.maintenance WHERE maintenance_status = 1 AND maintenance_id=%s ORDER BY maintenance_id DESC", GetSQLValueString($colname_tr,"int"));
$main = mysql_query($query_main, $tadbirdb) or die(mysql_error());
$row_main = mysql_fetch_assoc($main);
$totalRows_main = mysql_num_rows($main);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_type = "SELECT * FROM tadbir.transport_type LEFT JOIN tadbir.transport ON transport_type.transporttype_id= transport.transporttype_id LEFT JOIN tadbir.maintenance ON transport.transport_id= maintenance.transport_id WHERE transporttype_status = 1 AND maintenance_status=1 ORDER BY transporttype_name ASC";
$type = mysql_query($query_type, $tadbirdb) or die(mysql_error());
$row_type = mysql_fetch_assoc($type);
$totalRows_type = mysql_num_rows($type);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_maintype = sprintf("SELECT * FROM tadbir.maintenance_type LEFT JOIN tadbir.maintenance_normalize ON maintenance_type.maintenancetype_id= maintenance_normalize.maintenancetype_id WHERE maintenance_id = %s AND maintenancetype_status = 1 AND mainnormalize_status=1 ORDER BY maintenance_normalize.maintenancetype_id DESC", GetSQLValueString($colname_tr, "int"));
$maintype = mysql_query($query_maintype, $tadbirdb) or die(mysql_error());
$row_maintype = mysql_fetch_assoc($maintype);
$totalRows_maintype = mysql_num_rows($maintype);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_maintenancetype = "SELECT * FROM tadbir.maintenance_type WHERE maintenancetype_status = 1 ORDER BY maintenancetype_id DESC";
$maintenancetype = mysql_query($query_maintenancetype, $tadbirdb) or die(mysql_error());
$row_maintenancetype = mysql_fetch_assoc($maintenancetype);
$totalRows_maintenancetype = mysql_num_rows($maintenancetype);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_ag = "SELECT * FROM transport_agency WHERE transagency_status = 1 ORDER BY transagency_name ASC";
$ag = mysql_query($query_ag, $tadbirdb) or die(mysql_error());
$row_ag = mysql_fetch_assoc($ag);
$totalRows_ag = mysql_num_rows($ag);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_desc = "SELECT * FROM description WHERE desc_status = 1 ORDER BY desc_name ASC";
$desc = mysql_query($query_desc, $tadbirdb) or die(mysql_error());
$row_desc = mysql_fetch_assoc($desc);
$totalRows_desc = mysql_num_rows($desc);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_cat = "SELECT * FROM category WHERE category_status = 1 ORDER BY category_name ASC";
$cat = mysql_query($query_cat, $tadbirdb) or die(mysql_error());
$row_cat = mysql_fetch_assoc($cat);
$totalRows_cat = mysql_num_rows($cat);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_desc_inv = sprintf("SELECT * FROM tadbir.desc_invoice WHERE maintenance_id = %s AND descinv_status = 1 ORDER BY maintenance_id ASC", GetSQLValueString($colname_tr, "int"));
$desc_inv = mysql_query($query_desc_inv, $tadbirdb) or die(mysql_error());
$row_desc_inv= mysql_fetch_assoc($desc_inv);
$totalRows_desc_inv = mysql_num_rows($desc_inv);

 $_SESSION['desc'] = NULL;
  unset($_SESSION['desc']);
  
  $_SESSION['cat'] = NULL;
  unset($_SESSION['cat']);
  
  $_SESSION['quantity'] = NULL;
  unset($_SESSION['quantity']);
  
  $_SESSION['amount'] = NULL;
  unset($_SESSION['amount']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
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
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            	<li>
            	  <div class="note">Maklumat lengkap penyelenggaraan kenderaan</div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Pemohon</td>
                      <td align="center" valign="middle" class="txt_line"><?php echo viewProfilePic(getMaintenanceBy($colname_tr));?></td>
                      <td width="100%" class="txt_line">
                      <div><strong><?php echo getFullNameByStafID(getMaintenanceBy($colname_tr)) . " (" . getMaintenanceBy($colname_tr) . ")";?></strong></div>
                      <div>Email : <?php echo getEmailISNByUserID(getMaintenanceBy($colname_tr));?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID(getMaintenanceBy($colname_tr));?></div>
                      </td>
                    </tr> 
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Kenderaan</td>
                      <td colspan="2"><?php echo getTypeNameByMaintenanceID($colname_tr);?> <?php echo getTransportNameByMaintenanceID($colname_tr);?></td>
                    </tr> 
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">No. Pendaftaran</td>
                      <td colspan="2"><?php echo getTransportPlatByMaintenanceID($colname_tr);?></td>
                    </tr>
                     <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Bacaan Odometer</td>
                      <td colspan="2"><?php echo getOdometerByID($colname_tr);?></td>
                    </tr>   
                     <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Ulasan</td>
                      <td colspan="2"><?php echo getMaintenanceNoteByID($colname_tr);?></td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Jenis Penyelenggaraan 
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onclick="toggleview2('formmaintype'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formmaintype" class="hidden">
                <li>
                  <form id="form3" name="form3" method="post" action="../sb/add_maintype_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label noline"> Jenis Penyelenggaraan</td>
                        <td width="100%">
					    <?php do { ?>
					      <ul class="inputradio">
						  <li>
						    <label>
						      <input name="jp[]" type="checkbox" id="jp[]" value="<?php echo $row_maintenancetype['maintenancetype_id']; ?>" />
						    <?php echo $row_maintenancetype['maintenancetype_name']; ?>
					        </label>
                            </li>
                          </ul>
				        <?php } while ($row_maintenancetype = mysql_fetch_assoc($maintenancetype)); ?>
                        <input name="maintenance_id" type="hidden" id="maintenance_id" value="<?php echo $colname_tr;?>" /></td><td>
                        <input name="button5" type="submit" class="submitbutton" id="button5" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
              <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_maintype > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="25%" align="left" valign="middle" nowrap="nowrap">Jenis Penyelenggaraan</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>  
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                         <td width="100%"><?php echo $row_maintype['maintenancetype_name']; ?></td>
                        <td align="center" valign="middle"><ul class="func">  <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>
                        <li><a onclick="return confirm('Anda mahu berikut dipadam? \r\n\n Jenis Penyelenggaraan: <?php echo $row_maintype['maintenancetype_name']; ?>')" href="../sb/del_maintype_admin.php?mtid=<?php echo htmlspecialchars($row_maintype['maintenancetype_id'],ENT_QUOTES); ?>">X</a></li>
                         <?php }; ?>
                         </ul></td>
                      </tr>
                      <?php $i++; } while ($row_maintype = mysql_fetch_assoc($maintype)); ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_maintype ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                 <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                   <?php if($row_main['maintenance_adminstatus']==0){?>
                <li class="title"> Kelulusan</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <form id="form1" name="form1" method="POST" action="../sb/update_adminapp.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Kelulusan</td>
                        <td><ul class="inputradio">
                          <li><input name="maintenance_adminstatus" type="radio" value="1" checked /> Diluluskan</li>
                          <li><input name="maintenance_adminstatus" type="radio" value="2" /> Tidak Diluluskan</li>
                        </ul></td>
                      </tr>
                      <tr>
                        <td class="label">Catatan</td>
                        <td><textarea name="maintenance_adminnote" id="maintenance_adminnote" cols="45" rows="5"></textarea></td>
                      </tr>
                      <tr>
                        <td class="noline"><input type="hidden" name="MM_update" value="form1" /> 
                        <input name="maintenance_id" type="hidden" id="maintenance_id" value="<?php echo $colname_tr;?>" /></td>
                        <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php }; ?>
                 <li class="gap">&nbsp;</li>
                 <?php if($row_main['maintenance_adminstatus']!=0){?>
                 <li class="title"> Kelulusan</li>
                 <li class="gap">&nbsp;</li>
                 <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Kelulusan</td>
                      <td><strong><?php if($row_main['maintenance_adminstatus']==1) echo "Diluluskan"; else echo "Tidak Diluluskan";?></strong> oleh <strong><?php echo getFullNameByStafID(getAdminAppBy($colname_tr));?></strong></td>
                    </tr>
                    <tr>
                      <td class="label">Tarikh</td>
                      <td><?php echo getAdminAppDateByID($colname_tr);?></td>
                    </tr>
                    <tr>
                      <td class="label">Catatan</td>
                      <td><?php echo getAdminAppNoteByID($colname_tr);?></td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <?php }; ?> 
                <?php if ($row_main['maintenance_adminstatus']==1 && $row_main['maintenance_validstatus']==0){?>
                  <li class="title">Pengesahan</li>
                  <li class="gap">&nbsp;</li>
                <li>
                  <form id="form1" name="form1" method="POST" action="../sb/update_mainValid.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Pengesahan</td>
                        <td><ul class="inputradio">
                          <li><input name="maintenance_validstatus" type="radio" value="1" checked /> Diluluskan</li>
                          <li><input name="maintenance_validstatus" type="radio" value="2" /> Tidak Diluluskan</li>
                        </ul></td>
                      </tr>
                      <tr>
                        <td class="label">Catatan</td>
                        <td><textarea name="maintenance_validnote" id="maintenance_validnote" cols="45" rows="5"></textarea></td>
                      </tr>
                      <tr>
                        <td class="noline"><input type="hidden" name="MM_update" value="form1" /><input name="maintenance_id" type="hidden" id="maintenance_id" value="<?php echo $colname_tr;?>" /></td>
                        <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
               <?php }; ?>
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
                        <?php echo getFullNameByStafID(getAdminAppBy($colname_tr));?></strong></td>
                  </tr>
                  <tr>
                    <td class="label">Tarikh</td>
                    <td><?php echo getValidDateByID($colname_tr);?></td>
                  </tr> 
                  <tr>
                    <td class="label">Catatan</td>
                    <td><?php echo getValidNoteByID($colname_tr);?></td>
                  </tr>
                </table>
                </li> 
				<?php }; ?>
                  <li class="gap">&nbsp;</li>
                <?php if(checkAdminApp($colname_tr) && checkMaintenanceValid($colname_tr)){?>
                <li class="title">Maklumat Penyelenggaraan</li>
                <?php if(!checkMaintenanceApp($colname_tr)){?>
                <li>
                  <?php if ($totalRows_ag > 0) { // Show if recordset not empty ?>
                  <form id="form2" name="form2" method="post" action="../sb/update_maintenanceinfo.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                       <tr>
                        <td nowrap="nowrap" class="label">Agensi</td>
                        <td colspan="3">
                          <select name="transagency_id" id="transagency_id">
                            <?php
                                            do {  
                                            ?>
                            <option value="<?php echo $row_ag['transagency_id']?>"><?php echo $row_ag['transagency_name']?></option>
                            <?php
                                            } while ($row_ag = mysql_fetch_assoc($ag));
                                              $rows = mysql_num_rows($ag);
                                              if($rows > 0) {
                                                  mysql_data_seek($ag, 0);
                                                  $row_ag = mysql_fetch_assoc($ag);
                                              }
                                            ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kenderaan Masuk</td>
                        <td width="100%" nowrap="nowrap" class="w50">
                          <select name="maintenance_in_d" id="maintenance_in_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="maintenance_in_m" id="maintenance_in_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="maintenance_in_y" id="maintenance_in_y">
                             <?php for($k=date('Y'); $k<=(date('Y')+2); $k++){?>
                              <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                <?php }; ?>
                          </select>
                        </td>
                        <td align="left" nowrap="nowrap" class="label">Masa</td>
                        <td width="30%" class="w50">
                         <select name="maintenance_in_time" id="maintenance_in_time">
                              <?php for($i=0; $i<24; $i++){?>
								  <?php for($j=0; $j<60; $j+=15){?>
                                <option <?php if($i == 9 && $j == 0) echo "selected=\"selected\"";?> value="<?php echo date('H:i A', mktime($i, $j, 0, 1, 1, date('Y')));?>"><?php echo date('h:i A', mktime($i, $j, 0, 1, 1, date('Y')));?></option>
                                  <?php }; ?>
							  <?php }; ?>
                          </select>
                        </td>
                        </tr>
                       <tr>
                        <td nowrap="nowrap" class="label">Kenderaan Keluar</td>
                        <td width="100%" nowrap="nowrap" class="w50">
                          <select name="maintenance_out_d" id="maintenance_out_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="maintenance_out_m" id="maintenance_out_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="maintenance_out_y" id="maintenance_out_y">
                              <?php for($k=date('Y'); $k<=(date('Y')+2); $k++){?>
                                  <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                <?php }; ?>
                          </select>
                        </td>
                        <td align="left" nowrap="nowrap" class="label">Masa</td>
                        <td width="30%" class="w50">
                       <select name="maintenance_out_time" id="maintenance_out_time">
                              <?php for($i=0; $i<24; $i++){?>
								  <?php for($j=0; $j<60; $j+=15){?>
                                <option <?php if($i == 9 && $j == 0) echo "selected=\"selected\"";?> value="<?php echo date('H:i A', mktime($i, $j, 0, 1, 1, date('Y')));?>"><?php echo date('h:i A', mktime($i, $j, 0, 1, 1, date('Y')));?></option>
                                  <?php }; ?>
							  <?php }; ?>
                        </select>
                         </td>
                      </tr>  
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Invois</td>
                        <td width="100%" nowrap="nowrap" class="w50">
                          <select name="maintenance_do_d" id="maintenance_do_d">
                            <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="maintenance_do_m" id="maintenance_do_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="maintenance_do_y" id="maintenance_do_y">
                              <?php for($k=date('Y'); $k<=(date('Y')+2); $k++){?>
                                  <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                <?php }; ?>
                          </select>
                        </td>
                      </tr>             
                      <tr>
                        <td nowrap="nowrap" class="label">No. Rujukan DO/Invois*</td>
                        <td colspan="3">
                          <span id="ref">
                    <input name="maintenance_refno" type="text" class="w50" id="maintenance_refno" onkeypress="return handleEnter(this, event)" />
                    <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                           <div class="inputlabel2">Merujuk pada Invois</div>
                          </span>
                        </td>
                      </tr>
                    </table>
                    <div class="note">2. Deskripsi Invois</div>
                    <ul>
                        <li class="form_back line_t line_l line_r">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="20%" align="left" valign="middle">
                              <div class="inputlabel2">Deskripsi</div>
                             <select name="desc" id="desc">
                            <?php
                                            do {  
                                            ?>
                            <option value="<?php echo $row_desc['desc_id']?>"><?php echo $row_desc['desc_name']?></option>
                            <?php
                                            } while ($row_desc = mysql_fetch_assoc($desc));
                                              $rows = mysql_num_rows($desc);
                                              if($rows > 0) {
                                                  mysql_data_seek($desc, 0);
                                                  $row_desc = mysql_fetch_assoc($desc);
                                              }
                                            ?>
                          </select>
                              </td>
                              <td width="20%" align="left" valign="middle">
                              <div class="inputlabel2">Kategori</div>
                              <select name="cat" id="cat">
                            <?php
                                            do {  
                                            ?>
                            <option value="<?php echo $row_cat['category_id']?>"><?php echo $row_cat['category_name']?></option>
                            <?php
                                            } while ($row_cat = mysql_fetch_assoc($cat));
                                              $rows = mysql_num_rows($cat);
                                              if($rows > 0) {
                                                  mysql_data_seek($cat, 0);
                                                  $row_cat = mysql_fetch_assoc($cat);
                                              }
                                            ?>
                          </select>                              </td>
                              <td width="30%" align="left" valign="middle" nowrap="nowrap"><div class="inputlabel2">Kuantiti</div>
                              <input type="text" name="descinv_quantity" id="descinv_quantity" onkeypress="return handleEnter(this, event)" />
                              <div class="inputlabel2">Cth: 1</div>
                              </td>
                              <td width="20%" align="left" valign="middle">
                              <div class="inputlabel2">RM</div>
                              <input type="text" name="descinv_amount" id="descinv_amount" onkeypress="return handleEnter(this, event)" />
                              <div class="inputlabel2">&nbsp;Cth: 200.00</div>
                              </td>
                              <td align="left" valign="middle">
                              <input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="xmlhttpPost('addinvoice.php?add=1', 'form2', 'senaraiinvoice', 'Proses penambahan ...'); return false;" />
                              </td>
                            </tr>
                          </table>
                        </li>
                		<li class="line_b line_l line_r">
                    	<div id="senaraiinvoice">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="100" align="center" valign="middle" class="noline txt_line">
                              <div>Sila isi maklumat yang dikehendaki dan klik 'Tambah'.</div>
                              <div>Ulangi langkah ini untuk tambahan maklumat seterusnya.</div>
                              </td>
                            </tr>
                          </table>
                      	</div>
                        </li>
                    </ul>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3"><textarea name="maintenance_appnote" id="maintenance_appnote" cols="45" rows="5"></textarea></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="noline">
                          <input type="hidden" name="MM_update" value="form2" />
                          <input name="maintenance_id" type="hidden" id="maintenance_id" value="<?php echo $colname_tr;?>" />
                        </td>
                        <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Kemaskini" /></td>
                      </tr>
                    </table>
                  </form>
                  <?php } else { ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline"><img src="<?php echo $url_main;?>icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>Agensi</strong> terlebih dahulu.</td>
                    </tr>
                  </table>
                  <?php };?>
                </li>
                <?php } else { ?>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Tarikh</td>
                      <td><?php echo $row_main['maintenance_appdate'];?></td>
                    </tr>
                    <tr>
                      <td class="label">Agensi</td>
                      <td class="txt_line">
					  	<div><strong><?php echo getTransagencyNameByID($row_main['transagency_id']);?></strong></div>
                        <div><?php if(getTransagencyNoTelByID($row_main['transagency_id'])!=NULL) echo "Tel : " . getTransagencyNoTelByID($row_main['transagency_id']);?><?php if(getTransagencyNoFaxByID($row_main['transagency_id'])!=NULL) echo " &nbsp; &bull; &nbsp; Fax : " . getTransagencyNoFaxByID($row_main['transagency_id']);?><?php if(getTransagencyEmailByID($row_main['transagency_id'])!=NULL) echo " &nbsp; &bull; &nbsp; Email : " . getTransagencyEmailByID($row_main['transagency_id']);?></div>
                      </td>
                    </tr>
                     <tr>
                       <td class="label">Kenderaan Masuk</td>
                       <td width="100%" nowrap="nowrap" class="w50">
                     <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_main['maintenance_in_m'], $row_main['maintenance_in_d'], $row_main['maintenance_in_y']));?></td>
                       <td class="label">Masa</td>
                       <td width="100%" nowrap="nowrap" class="w50">
                      <?php echo $row_main['maintenance_in_time'];?></td>
                    </tr>
                    <tr>
                      <td class="label">Kenderaan Keluar</td>
                      <td width="100%" nowrap="nowrap" class="w50">
                     <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_main['maintenance_out_m'], $row_main['maintenance_out_d'], $row_main['maintenance_out_y']));?></td>
                       <td class="label">Masa</td>
                       <td width="100%" nowrap="nowrap" class="w50">
                      <?php echo $row_main['maintenance_out_time'];?></td>
                    </tr>
                    <tr>
                      <td class="label">Tarikh Invois</td>
                      <td><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_main['maintenance_do_m'], $row_main['maintenance_do_d'], $row_main['maintenance_do_y']));?></td>
                      <td class="label">No. Rujukan Invois</td>
                      <td><?php echo $row_main['maintenance_refno'];?></td>
                    </tr>
                    <tr>
                      <td class="label">Catatan</td>
                      <td><?php echo $row_main['maintenance_appnote'];?></td>
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
                        <td align="center" class="back_darkgrey"><strong><?php echo number_format(getAmountByID($colname_tr),2); ?></strong></td>
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
<script type="text/javascript">
var sprytextfield3 = new Spry.Widget.ValidationTextField("ref");
</script>
</body>
</html>
<?php

mysql_free_result($main);

mysql_free_result($type);

mysql_free_result($maintype);

mysql_free_result($maintenancetype);

mysql_free_result($ag);

mysql_free_result($desc);

mysql_free_result($cat);

mysql_free_result($desc_inv);

?>
<?php include('../inc/footinc.php');?> 