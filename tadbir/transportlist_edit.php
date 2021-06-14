<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='81';?>
<?php

$colname_tr = "-1";
if (isset($_GET['id'])) {
  $colname_tr = $_GET['id'];
}
	
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = sprintf("SELECT * FROM transport WHERE transport_id = %s ORDER BY transport_id DESC", GetSQLValueString($colname_tr, "int"));
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);
	
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_type = "SELECT * FROM tadbir.transport_type WHERE transporttype_status = 1 ORDER BY transporttype_name ASC";
$type = mysql_query($query_type, $tadbirdb) or die(mysql_error());
$row_type = mysql_fetch_assoc($type);
$totalRows_type = mysql_num_rows($type);
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
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                <li>
                	<div class="note">Kemaskini maklumat kenderaan</div>
                  <form id="form1" name="form1" method="POST" action="../sb/update_transport.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Jenis</td>
                        <td width="150%"><span class="noline">
                          <select name="transporttype_id" id="transporttype_id">
            	            <?php
do {  
?>
            	            <option value="<?php echo $row_type['transporttype_id']?>"<?php if (!(strcmp($row_type['transporttype_id'], $row_tr['transporttype_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_type['transporttype_name']?></option>
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
                        <td nowrap="nowrap" class="label">Nama</td>
                        <td><span id="nama"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                          <input name="transport_name" type="text" id="transport_name" onkeypress="return handleEnter(this, event)" value="<?php echo $row_tr['transport_name']; ?>" />
                       </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No Plat</td>
                        <td><span id="noplat"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                          <input name="transport_noplat" type="text" id="transport_noplat" onkeypress="return handleEnter(this, event)" value="<?php echo $row_tr['transport_plat']; ?>" />
                       </span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline"><input name="transport_id" type="hidden" id="transport_id" value="<?php echo $row_tr['transport_id'];?>" />                          <input name="MM_update" type="hidden" id="MM_update" value="form1" /></td>
                        <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                         <input name="button" type="button" class="cancelbutton" id="button" value="Batal" onclick="MM_goToURL('parent','transportlist.php');return document.MM_returnValue"/></td>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("nama");
Spry.Widget.ValidationTextField("noplat");
</script>
</body>
</html>
<?php
mysql_free_result($tr);
mysql_free_result($type);
?>
<?php include('../inc/footinc.php');?> 