<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='5';?>
<?php $menu2='53';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sta = "SELECT * FROM `state` WHERE state_status = 1 ORDER BY state_name ASC";
$sta = mysql_query($query_sta, $hrmsdb) or die(mysql_error());
$row_sta = mysql_fetch_assoc($sta);
$totalRows_sta = mysql_num_rows($sta);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_ct = "SELECT * FROM clinic_type WHERE clinictype_status = 1 ORDER BY clinictype_name ASC";
$ct = mysql_query($query_ct, $tadbirdb) or die(mysql_error());
$row_ct = mysql_fetch_assoc($ct);
$totalRows_ct = mysql_num_rows($ct);

$colname_cl = "-1";

if (isset($_GET['id'])) {
  $colname_cl = htmlspecialchars($_GET['id'], ENT_QUOTES);
}

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_cl = sprintf("SELECT * FROM clinic WHERE clinic_id = %s ORDER BY clinic_id DESC", GetSQLValueString($colname_cl, "int"));
$cl = mysql_query($query_cl, $tadbirdb) or die(mysql_error());
$row_cl = mysql_fetch_assoc($cl);
$totalRows_cl = mysql_num_rows($cl);
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
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <li>
                <div class="note">Penambahan Klinik Panel</div>
                  <form id="form1" name="form1" method="POST" action="../sb/update_clinic.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Jenis</td>
                        <td colspan="3"><select name="clinictype_id" id="clinictype_id">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_ct['clinictype_id']?>"<?php if (!(strcmp($row_ct['clinictype_id'], $row_cl['clinictype_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_ct['clinictype_name']?></option>
                          <?php
							} while ($row_ct = mysql_fetch_assoc($ct));
							  $rows = mysql_num_rows($ct);
							  if($rows > 0) {
								  mysql_data_seek($ct, 0);
								  $row_ct = mysql_fetch_assoc($ct);
							  }
							?>
                        </select></td>
                      </tr>
                      <tr>
                        <td class="label">Nama *</td>
                        <td colspan="3"><input name="clinic_name" type="text" id="clinic_name" value="<?php echo $row_cl['clinic_name']; ?>" /></td>
                      </tr>
                      <tr>
                        <td class="label">Alamat *</td>
                        <td colspan="3"><textarea name="clinic_address" id="clinic_address" cols="45" rows="5"><?php echo $row_cl['clinic_address']; ?></textarea></td>
                      </tr>
                      <tr>
                        <td class="label">Negeri</td>
                        <td colspan="3"><select name="state_id" id="state_id">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_sta['state_id']?>"<?php if (!(strcmp($row_sta['state_id'], $row_cl['state_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_sta['state_name']?></option>
                          <?php
							} while ($row_sta = mysql_fetch_assoc($sta));
							  $rows = mysql_num_rows($sta);
							  if($rows > 0) {
								  mysql_data_seek($sta, 0);
								  $row_sta = mysql_fetch_assoc($sta);
							  }
							?>
                        </select></td>
                      </tr>
                      <tr>
                        <td class="label">No. Tel (1) *</td>
                        <td><input name="clinic_notel1" type="text" id="clinic_notel1" value="<?php echo $row_cl['clinic_notel1']; ?>" /></td>
                        <td class="label">No. Tel (2)</td>
                        <td><input name="clinic_notel2" type="text" id="clinic_notel2" value="<?php echo $row_cl['clinic_notel2']; ?>" /></td>
                      </tr>
                      <tr>
                        <td class="label">No. Fax</td>
                        <td><input name="clinic_nofax" type="text" id="clinic_nofax" value="<?php echo $row_cl['clinic_nofax']; ?>" /></td>
                        <td class="label">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><input name="clinic_id" type="hidden" id="clinic_id" value="<?php echo $row_cl['clinic_id']; ?>" /></td>
                        <td colspan="3"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','adminclinic.php');return document.MM_returnValue" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_update" value="form1" />
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
</body>
</html>
<?php
mysql_free_result($sta);

mysql_free_result($ct);

mysql_free_result($cl);
?>
<?php include('../inc/footinc.php');?> 