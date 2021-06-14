<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='81';?>
<?php
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_type = "SELECT * FROM tadbir.transport_type WHERE transporttype_status = 1 ORDER BY transporttype_name ASC";
$type = mysql_query($query_type, $tadbirdb) or die(mysql_error());
$row_type = mysql_fetch_assoc($type);
$totalRows_type = mysql_num_rows($type);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = "SELECT * FROM transport WHERE transport_status = 1 ORDER BY transport_name ASC";
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/disenter.js"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
        	<form action="../sb/add_transportlist.php" method="POST" name="formtransport" id="formtransport">
           	  <div class="note">Penambahan kenderaan </div>
            <ul>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Jenis Kenderaan</td>
                        <td width="100%" nowrap="nowrap"><select name="type" id="type">
                         <?php
                         do {  
						 ?>
                         <option value="<?php echo $row_type['transporttype_id']?>"><?php echo $row_type['transporttype_name']?></option>
						 <?php
                         } while ($row_type = mysql_fetch_assoc($type));
						 $rows = mysql_num_rows($type);
						 if($rows > 0) {
							  mysql_data_seek($type, 0);
							  $row_type = mysql_fetch_assoc($type);
							  }
							  ?>
                              </select></td>
                      </tr>
                      <tr>
                        <td class="label noline">Nama Kenderaan *</td>
                        <td class="noline"><span id="name">
                    <span class="selectRequiredMsg">Maklumat diperlukan.<br/></span>
                        <input name="transport_name" type="text" class="w50" id="transport_name" onkeypress="return handleEnter(this, event)" /></span></td>
                      </tr>
                	  <tr>
                	    <td class="label">No. Plat *</td>
                	    <td><span id="noplat">
               	        <span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                	      <input name="transport_plat" type="text" class="w50" id="transport_plat"  onkeypress="return handleEnter(this, event)"/>
                          </span></td>
              	      </tr>
                	  <tr>
                        <td class="noline"><input type="hidden" name="MM_insert" value="formtransport" /></td>
                	    <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onClick="MM_goToURL('parent','transportlist.php');return document.MM_returnValue"/></td>
              	    </tr>
                  </table>
                </li>
            </ul>
            </form>
                <?php } else { ?>
                <ul>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
                  </tr>
                </table>
				</li>
                </ul>
                <?php }; ?>
            </div>
        </div>
    </div> 
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("name");
var sprytextfield2 = new Spry.Widget.ValidationTextField("noplat");
</script>
</body>
</html>
<?php
mysql_free_result($type);

mysql_free_result($tr);
?>
<?php include('../inc/footinc.php');?> 