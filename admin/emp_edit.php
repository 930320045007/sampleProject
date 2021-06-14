<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='7';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_klas = "SELECT * FROM classification ORDER BY classification_code ASC";
$klas = mysql_query($query_klas, $hrmsdb) or die(mysql_error());
$row_klas = mysql_fetch_assoc($klas);
$totalRows_klas = mysql_num_rows($klas);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_grp = "SELECT * FROM `group` ORDER BY group_id ASC";
$grp = mysql_query($query_grp, $hrmsdb) or die(mysql_error());
$row_grp = mysql_fetch_assoc($grp);
$totalRows_grp = mysql_num_rows($grp);

$colname_sch = "-1";
if (isset($_GET['id'])) {
  $colname_sch = $_GET['id'];
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sch = sprintf("SELECT * FROM scheme WHERE scheme_id = %s ORDER BY scheme_id DESC", GetSQLValueString($colname_sch, "int"));
$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
$row_sch = mysql_fetch_assoc($sch);
$totalRows_sch = mysql_num_rows($sch);
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
        <?php include('../inc/menu_admin.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
            	<li>
                <div class="note">Pendaftaran jawatan baru (sila rujuk JPA)</div>
            	  <form id="sch" name="sch" method="POST" action="../sb/update_scheme.php">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td class="label">Klasifikasi</td>
            	        <td nowrap="nowrap">
            	          <select name="classification_id" id="classification_id">
            	            <?php
do {  
?>
            	            <option value="<?php echo $row_klas['classification_id']?>"<?php if (!(strcmp($row_klas['classification_id'], $row_sch['classification_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_klas['classification_name']?></option>
            	            <?php
} while ($row_klas = mysql_fetch_assoc($klas));
  $rows = mysql_num_rows($klas);
  if($rows > 0) {
      mysql_data_seek($klas, 0);
	  $row_klas = mysql_fetch_assoc($klas);
  }
?>
                        </select></td>
           	          </tr>
            	      <tr>
            	        <td class="label">Nama Skim</td>
            	        <td nowrap="nowrap"><span id="nama"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>
            	          <input name="scheme_name" type="text" id="scheme_name" value="<?php echo $row_sch['scheme_name']; ?>" />
           	            </span></td>
           	          </tr>
            	      <tr>
            	        <td class="label">Kod Skim</td>
            	        <td nowrap="nowrap"><span id="kod"><span class="textfieldRequiredMsg">Maklumat diperlukan</span><span class="textfieldInvalidFormatMsg">Sila </span>
                        <input name="scheme_code" type="text" class="w35" id="scheme_code" value="<?php echo $row_sch['scheme_code']; ?>" />
                        </span></td>
           	          </tr>
            	      <tr>
            	        <td class="label">Kumpulan Perkhidmatan</td>
            	        <td nowrap="nowrap">
            	          <select name="group_id" id="group_id">
            	            <?php
do {  
?>
            	            <option value="<?php echo $row_grp['group_id']?>"<?php if (!(strcmp($row_grp['group_id'], $row_sch['group_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_grp['group_name']?></option>
            	            <?php
} while ($row_grp = mysql_fetch_assoc($grp));
  $rows = mysql_num_rows($grp);
  if($rows > 0) {
      mysql_data_seek($grp, 0);
	  $row_grp = mysql_fetch_assoc($grp);
  }
?>
                        </select></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Kod Gred Tambahan</td>
            	        <td nowrap="nowrap"><label for="scheme_code2"></label>
           	            <input name="scheme_code2" type="text" class="w25" id="scheme_code2" value="<?php echo $row_sch['scheme_code2']; ?>" /></td>
          	        </tr>
            	      <tr>
            	        <td class="label">Gred</td>
            	        <td nowrap="nowrap">
           	            <input name="scheme_gred" type="text" id="scheme_gred" value="<?php echo $row_sch['scheme_gred'];?>"/><div class="inputlabel2">Dibezakan dengan simbol koma ','. Cth: 41, 44, 48, 52, 54</div></td>
          	          </tr>
            	      <tr>
            	        <td class="noline"><input name="scheme_id" type="hidden" id="scheme_id" value="<?php echo $row_sch['scheme_id']; ?>" /></td>
            	        <td nowrap="nowrap" class="noline"><input name="button" type="submit" class="submitbutton" id="button" value="Kemaskini" />
                        <input name="button" type="button" class="cancelbutton" id="button" value="Batal" onclick="MM_goToURL('parent','emp.php');return document.MM_returnValue"/></td>
           	          </tr>
          	        </table>
            	    <input type="hidden" name="MM_update" value="sch" />
                  </form>
            	</li>
            </ul>
          </div>
         </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("nama");
var sprytextfield2 = new Spry.Widget.ValidationTextField("kod", "none");
</script>
</body>
</html>
<?php include('../inc/footinc.php');?>
<?php
mysql_free_result($klas);

mysql_free_result($grp);

mysql_free_result($sch);
?>