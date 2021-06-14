<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='31';?>
<?php
mysql_select_db($database_ictdb, $ictdb);
$query_type = "SELECT * FROM service_type WHERE servicetype_status = 1 ORDER BY servicetype_name ASC";
$type = mysql_query($query_type, $ictdb) or die(mysql_error());
$row_type = mysql_fetch_assoc($type);
$totalRows_type = mysql_num_rows($type);

mysql_select_db($database_ictdb, $ictdb);
$query_vendor = "SELECT * FROM vendor WHERE vendor_status = 1 ORDER BY vendor_name ASC";
$vendor = mysql_query($query_vendor, $ictdb) or die(mysql_error());
$row_vendor = mysql_fetch_assoc($vendor);
$totalRows_vendor = mysql_num_rows($vendor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script type="text/javascript" src="../js/disenter.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <li>
                  <form id="form1" name="form1" method="POST" action="../sb/add_service.php">
                  <div class="note">Tambah service baru</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Jenis</td>
                        <td colspan="3">
                          <select name="type" id="type">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_type['servicetype_id']?>"><?php echo $row_type['servicetype_name']?></option>
                            <?php
							} while ($row_type = mysql_fetch_assoc($type));
							  $rows = mysql_num_rows($type);
							  if($rows > 0) {
								  mysql_data_seek($type, 0);
								  $row_type = mysql_fetch_assoc($type);
							  }
							?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Perkara</td>
                        <td colspan="3"><span id="title"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                          <input type="text" name="service_title" id="service_title" onkeypress="return handleEnter(this, event)" />
                       </span></td>
                      </tr>
                      <tr>
                        <td class="label">Vendor</td>
                        <td colspan="3">
                          <select name="vendor" id="vendor">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_vendor['vendor_id']?>"><?php echo $row_vendor['vendor_name']?></option>
                            <?php
							} while ($row_vendor = mysql_fetch_assoc($vendor));
							  $rows = mysql_num_rows($vendor);
							  if($rows > 0) {
								  mysql_data_seek($vendor, 0);
								  $row_vendor = mysql_fetch_assoc($vendor);
							  }
							?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="label">Tempoh</td>
                        <td colspan="3">
                         <select name="service_duration_y">
                            <?php for($y =0; $y<=10; $y++){?>
                            <option <?php if($y==0) echo "selected=\"selected\"";?> value="<?php echo $y; ?>"><?php echo $y; ?></option>
                            <?php }; ?>
                          </select>&nbsp;<span class="inputlabel">Tahun</span> &nbsp;
                          <select name="service_duration_m">
                            <?php for($m = 0; $m<12; $m++){?>
                            <option <?php if($m==0) echo "selected=\"selected\"";?> value="<?php if($m==0) $m = "0"; echo $m; ?>"><?php echo $m; ?></option>
                            <?php }; ?>
                          </select>&nbsp;<span class="inputlabel">Bulan</span>
                          </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh Mula</td>
                        <td width="100%" nowrap="nowrap" class="w50">
                             <select name="service_start_date_d" id="service_start_date_d">
                                <?php for($i=1; $i<=31; $i++){?>
                                  <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                                <?php }; ?>
                                </select>
                                <select name="service_start_date_m" id="service_start_date_m">
                                <?php for($j=1; $j<=12; $j++){?>
                                  <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                                <?php }; ?>
                              </select>
                                <select name="service_start_date_y" id="service_start_date_y">
                                 <?php for($k=2012; $k<=date('Y'); $k++){?>
                                  <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                <?php }; ?>
                              </select>
                           </td>
                           <td  nowrap="nowrap" class="label">Tarikh Akhir</td>
                           <td width="100%" nowrap="nowrap" class="w50">
                               <select name="service_end_date_d" id="service_end_date_d">
                                <?php for($i=1; $i<=31; $i++){?>
                                  <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                                <?php }; ?>
                                </select>
                                <select name="service_end_date_m" id="service_end_date_m">
                                <?php for($j=1; $j<=12; $j++){?>
                                  <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                                <?php }; ?>
                              </select>
                                <select name="service_end_date_y" id="service_end_date_y">
                                <?php for($k=date('Y'); $k<=(date('Y')+2); $k++){?>
                                  <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                <?php }; ?>
                              </select>
                           </td>
                      </tr>
                      <tr>
                          <td class="label">No. LO</td>
                          <td class="w30"><input name="service_lono" type="text" id="service_lono" onkeypress="return handleEnter(this, event)" /></td>
                          <td class="label">Jumlah (RM)</td>
                          <td><span id="amount"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                          <input type="text" name="service_amount" id="service_amount" onkeypress="return handleEnter(this, event)" />
                            <div class="inputlabel2">&nbsp;Cth: 200.00</div>
                       </span></td>
                      </tr>
                      <tr>
                        <td class="label">Dokumen/Rujukan</td>
                        <td colspan="3"><input name="service_refno" type="text" class="w30" id="service_refno" onkeypress="return handleEnter(this, event)" /></td>
                      </tr>
                       <tr>
                        <td class="label">ID Pengguna</td>
                        <td class="w30"><input name="service_username" type="text" id="service_username" onkeypress="return handleEnter(this, event)" /></td>
                        <td class="label">Kata Laluan</td>
                        <td class="w30"><input name="service_password" type="text" id="service_password" onkeypress="return handleEnter(this, event)" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3"><textarea name="service_note" id="service_note" cols="45" rows="5"></textarea></td>
                      </tr>
                      <tr>
                        <td class="label noline"><input type="hidden" name="MM_insert" value="form1" /></td>
                        <td class="noline" colspan="3"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                         <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onClick="MM_goToURL('parent','servicelist.php');return document.MM_returnValue"/></td>
                      </tr>
                    </table>
                  </form>
                </li>
            <?php } ; ?>
            </ul>
            </div>
        </div>
</div>
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("title");
var sprytextfield1 = new Spry.Widget.ValidationTextField("amount");
</script>
</body>
</html>
<?php
mysql_free_result($type);
mysql_free_result($vendor);
?>
<?php include('../inc/footinc.php');?> 