<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='31';?>
<?php
if(isset($_GET['id']))
	$id = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
else
	$id = 0;
	
mysql_select_db($database_ictdb, $ictdb);
$query_serv = sprintf("SELECT * FROM service WHERE service_id = %s ORDER BY service_id DESC", GetSQLValueString($id, "int"));
$serv = mysql_query($query_serv, $ictdb) or die(mysql_error());
$row_serv = mysql_fetch_assoc($serv);
$totalRows_serv = mysql_num_rows($serv);
	
mysql_select_db($database_ictdb, $ictdb);
$query_type = "SELECT * FROM ict.service_type WHERE servicetype_status = 1 ORDER BY servicetype_name ASC";
$type = mysql_query($query_type, $ictdb) or die(mysql_error());
$row_type = mysql_fetch_assoc($type);
$totalRows_type = mysql_num_rows($type);

mysql_select_db($database_ictdb, $ictdb);
$query_vendor = "SELECT * FROM ict.vendor WHERE vendor_status = 1 ORDER BY vendor_name ASC";
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3) && $id != 0){?>
                <li>
                	<div class="note">Kemaskini maklumat perkhidmatan</div>
                  <form id="form1" name="form1" method="POST" action="../sb/update_service.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Jenis</td>
                        <td><span class="noline">
                        <select name="servicetype_id" id="servicetype_id">
						<?php
                        do {  
						?>
            	            <option value="<?php echo $row_type['servicetype_id']?>"<?php if (!(strcmp($row_type['servicetype_id'], $row_serv['servicetype_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_type['servicetype_name']?></option>
							<?php
                            } while ($row_type = mysql_fetch_assoc($type));
							$rows = mysql_num_rows($type);
							if($rows > 0) {
								mysql_data_seek($type, 0);
								$row_type = mysql_fetch_assoc($type);
								}
								?>
                        </select>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Perkara</td>
                        <td><span id="title"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                          <input name="service_title" type="text" id="service_title" onkeypress="return handleEnter(this, event)" value="<?php echo getServiceTitleByID($id); ?>" />
                       </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Vendor</td>
                        <td><span class="noline">
                          <select name="vendor_id" id="vendor_id">
            	            <?php
                            do {  
							?>
            	            <option value="<?php echo $row_vendor['vendor_id']?>"<?php if (!(strcmp($row_vendor['vendor_id'], $row_serv['vendor_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_vendor['vendor_name']?></option>
            	            <?php
                            } while ($row_vendor = mysql_fetch_assoc($vendor));
							$rows = mysql_num_rows($vendor);
							if($rows > 0) {
								mysql_data_seek($vendor, 0);
								$row_vendor = mysql_fetch_assoc($vendor);
								}
								?>
                        </select>
                        </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tempoh</td>
                        <td>  <select name="service_duration_y">
                            <?php for($y = 0; $y<=10; $y++){?>
                            <option <?php if($y==$row_serv['service_duration_y']) echo "selected=\"selected\"";?> value="<?php echo $y; ?>"><?php echo $y ?></option>
                            <?php }; ?>
                          </select>&nbsp;<span class="inputlabel">Tahun</span>
                          <select name="service_duration_m">
                            <?php for($m = 0; $m<=11; $m++){?>
                            <option <?php if($m==$row_serv['service_duration_m']) echo "selected=\"selected\"";?> value="<?php echo $m; ?>"><?php echo $m ?></option>
                            <?php }; ?>
                          </select>&nbsp;<span class="inputlabel">Bulan</span></td>
                      </tr>
                      <tr>
                          <td nowrap="nowrap" class="label">Taikh Mula</td>
                          <td width="100%" nowrap="nowrap" class="w50"> 
                          <select name="service_start_date_d">
                            <?php for($d = 1; $d<=31; $d++){?>
                            <option <?php if($d==$row_serv['service_start_date_d']) echo "selected=\"selected\"";?> value="<?php echo $d; ?>"><?php echo $d ?></option>
                            <?php }; ?>
                          </select>
                          <select name="service_start_date_m">
                          <?php for($m = 1; $m<=12; $m++){?><option <?php if($m==$row_serv['service_start_date_m']) echo "selected=\"selected\"";?> value="<?php if($m<10) $m = '0' . $m; echo $m;?>"><?php echo date('M', mktime(0, 0, 0, $m, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="service_start_date_y">
                          <?php for($y = 2012; $y<=date('Y'); $y++){?>
                           <option <?php if($m==$row_serv['service_start_date_y']) echo "selected=\"selected\"";?> value="<?php echo $y; ?>"><?php echo $y ?></option>
                            <?php }; ?>
                          </select>
                          </td>
                          <td nowrap="nowrap" class="label">Taikh Akhir</td>
                           <td width="100%" nowrap="nowrap" class="w50">
                            <select name="service_end_date_d">
                            <?php for($d = 0; $d<=31; $d++){?>
                            <option <?php if($d==$row_serv['service_end_date_d']) echo "selected=\"selected\"";?> value="<?php echo $d; ?>"><?php echo $d ?></option>
                            <?php }; ?>
                          </select>
                           <select name="service_end_date_m">
                          <?php for($m = 1; $m<=12; $m++){?><option <?php if($m==$row_serv['service_end_date_m']) echo "selected=\"selected\"";?> value="<?php if($m<10) $m = '0' . $m; echo $m;?>"><?php echo date('M', mktime(0, 0, 0, $m, 1, date('Y')));?></option>
                            <?php }; ?>
                          </select>
                          <select name="service_end_date_y">
                           <?php for($y=date('Y'); $y<=(date('Y')+2); $y++){?>
                           <option <?php if($y==$row_serv['service_end_date_y']) echo "selected=\"selected\"";?> value="<?php echo $y; ?>"><?php echo $y ?></option>
                            <?php }; ?>
                          </select>
                          </td>
                      </tr>
                       <tr>
                         <td class="label">No. LO</td>
                         <td class="w30"><input name="service_lono" type="text" id="service_lono" onkeypress="return handleEnter(this, event)" value="<?php echo $row_serv['service_lono']; ?>" /></td>
                         <td class="label">Jumlah (RM)</td>
                         <td><span id="amount"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                          <input type="text" name="service_amount" id="service_amount" onkeypress="return handleEnter(this, event)" value="<?php echo $row_serv['service_amount']; ?>" />
                            <div class="inputlabel2">&nbsp;Cth: 200.00</div>
                       </span>
                       </td>
                    </tr>
                    <tr>
                       <td class="label">Dokumen/Rujukan</td>
                       <td class="w30"><input name="service_refno" type="text" id="service_refno" onkeypress="return handleEnter(this, event)" value="<?php echo $row_serv['service_refno']; ?>" /></td>
                    </tr>
                    <tr>
                        <td class="label">ID Pengguna</td>
                        <td class="w30"><input name="service_username" type="text" id="service_username" onkeypress="return handleEnter(this, event)" value="<?php echo $row_serv['service_username']; ?>" /></td>
                        <td class="label">Kata Laluan</td>
                        <td class="w30"><input name="service_password" type="text" id="service_password" onkeypress="return handleEnter(this, event)" value="<?php echo $row_serv['service_password']; ?>" /></td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3"><textarea name="service_note" id="service_note" cols="45" rows="5"><?php echo $row_serv['service_note']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap" class="label noline"><input name="service_id" type="hidden" id="service_id" value="<?php echo $id;?>" />                          <input name="MM_update" type="hidden" id="MM_update" value="form1" /></td>
                        <td colspan="3" class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onClick="MM_goToURL('parent','servicelist.php');return document.MM_returnValue"/></td>
                   </tr>
                </table>
              </form>
            </li>
			<?php } else { ?>
            <li>
               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td>Tiada rekod dijumpai</td>
                  </tr>
               </table>
            </li>
            <?php }; ?>
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
mysql_free_result($serv);
mysql_free_result($type);
mysql_free_result($vendor);
?>
<?php include('../inc/footinc.php');?> 