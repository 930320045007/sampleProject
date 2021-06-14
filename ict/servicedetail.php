<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='31';?>
<?php
if(isset($_GET['id']))
	$wsql = " AND service_id='" . getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0) . "'";
else
	$wsql = " AND service_id='-1'";

mysql_select_db($database_ictdb, $ictdb);
$query_service = "SELECT * FROM ict.service WHERE service_status = 1 " . $wsql . " ORDER BY service_date_y DESC, service_date_m DESC, service_date_d DESC, service_id DESC";
$service = mysql_query($query_service, $ictdb) or die(mysql_error());
$row_service = mysql_fetch_assoc($service);
$totalRows_service = mysql_num_rows($service);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            	<li>
            	  <div class="note">Maklumat lengkap perkhidmatan</div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Jenis</td>
                      <td colspan="3"><?php echo getServiceTypeNameByID($row_service['servicetype_id']);?></td>
                    </tr> 
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Perkara</td>
                      <td colspan="3"><?php echo $row_service['service_title'];?></td>
                    </tr>
                     <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Vendor</td>
                      <td colspan="3"><?php echo getVendorNameByID($row_service['vendor_id']);?></td>
                    </tr>
                     <tr>
                     <td valign="middle" nowrap="nowrap" class="label">Tarikh</td>
                      <td><?php echo getServiceStartDateByID($row_service['service_id']). " - " . getServiceEndDateByID($row_service['service_id']) ;?></td>
                      <td valign="middle" nowrap="nowrap" class="label">Tempoh</td>
                      <td><?php echo $row_service['service_duration_y']. " tahun " . $row_service['service_duration_m']." bulan";?></td>
                    </tr>   
                     <tr>
                      <td valign="middle" nowrap="nowrap" class="label">No. LO</td>
                      <td colspan="3"><?php echo $row_service['service_lono'];?></td>
                    </tr>
                     <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Jumlah (RM)</td>
                      <td colspan="3"><?php echo $row_service['service_amount'];?></td>
                    </tr>
                     <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Dokumen / Rujukan</td>
                      <td colspan="3"><?php echo $row_service['service_refno'];?></td>
                    </tr>   
                     <tr>
                      <td valign="middle" nowrap="nowrap" class="label">ID Pengguna / Kata Laluan</td>
                      <td colspan="3"><?php if(($row_service['service_username'] && $row_service['service_password'])!='') echo $row_service['service_username'] ." / ". $row_service['service_password']; else echo "Tiada"; ?></td>
                    </tr>
                     <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Catatan</td>
                      <td colspan="3"><?php echo $row_service['service_note'];?></td>
                      <tr>
                        <td class="label noline"></td>
                        <td class="noline" colspan="3">
                         <input name="button4" type="button" class="cancelbutton" id="button4" value="Kembali" onClick="MM_goToURL('parent','servicelist.php');return document.MM_returnValue"/></td>
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
</body>
</html>
<?php
mysql_free_result($service);
?>
<?php include('../inc/footinc.php');?> 