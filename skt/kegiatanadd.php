<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='64';?>
<?php
mysql_select_db($database_skt, $skt);
$query_orgarch = "SELECT * FROM skt.org_arch WHERE orgarch_status = 1 ORDER BY orgarch_name ASC";
$orgarch = mysql_query($query_orgarch, $skt) or die(mysql_error());
$row_orgarch = mysql_fetch_assoc($orgarch);
$totalRows_orgarch = mysql_num_rows($orgarch);

mysql_select_db($database_skt, $skt);
$query_orglevel = "SELECT * FROM skt.org_level WHERE orglevel_status = 1 ORDER BY orglevel_name ASC";
$orglevel = mysql_query($query_orglevel, $skt) or die(mysql_error());
$row_orglevel = mysql_fetch_assoc($orglevel);
$totalRows_orglevel = mysql_num_rows($orglevel);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
      	<?php include('../inc/menu_skt.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
                <li>
                <div class="note">Penambahan kegiatan/aktiviti baru</div>
                <form id="form1" name="form1" method="POST" action="../sb/add_sktkegiatan.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Tahun</td>
                      <td>
                        <select name="useraktiviti_year" id="useraktiviti_year">
                        <?php for($i=date('Y'); $i>=2012; $i--){?>
                          <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php }; ?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="label">Organisasi *</td>
                      <td><span id="nameorg"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                        <input type="text" name="useraktiviti_name" id="useraktiviti_name" />
                      <div class="inputlabel2">Cth: PUSPANITA</div>
                      </span></td>
                    </tr>
                    <tr>
                      <td class="label">Peringkat</td>
                      <td>
                        <select name="orgarch_id" id="orgarch_id">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_orgarch['orgarch_id']?>"><?php echo $row_orgarch['orgarch_name']?></option>
                          <?php
							} while ($row_orgarch = mysql_fetch_assoc($orgarch));
							  $rows = mysql_num_rows($orgarch);
							  if($rows > 0) {
								  mysql_data_seek($orgarch, 0);
								  $row_orgarch = mysql_fetch_assoc($orgarch);
							  }
							?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="label">Jawatan</td>
                      <td>
                        <select name="orglevel_id" id="orglevel_id">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_orglevel['orglevel_id']?>"><?php echo $row_orglevel['orglevel_name']?></option>
                          <?php
							} while ($row_orglevel = mysql_fetch_assoc($orglevel));
							  $rows = mysql_num_rows($orglevel);
							  if($rows > 0) {
								  mysql_data_seek($orglevel, 0);
								  $row_orglevel = mysql_fetch_assoc($orglevel);
							  }
							?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="label">Ringkasan Jawatan</td>
                      <td>
                      <input type="text" name="useraktiviti_jawat" id="useraktiviti_jawat" />
                      <div class="inputlabel2">Cth: AJK Kebajikan</div></td>
                    </tr>
                    <tr>
                      <td class="label noline">
                      <input name="id" type="hidden" id="id" value="<?php echo $row_user['user_stafid'];?>" />
                  		<input type="hidden" name="MM_insert" value="form1" /></td>
                      <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                      <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','kegiatan.php');return document.MM_returnValue" /></td>
                    </tr>
                  </table>
                </form>
                </li>
                <li class="gap">&nbsp;</li>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("nameorg");
</script>
</body>
</html>
<?php
mysql_free_result($orgarch);

mysql_free_result($orglevel);
?>
<?php include('../inc/footinc.php');?> 