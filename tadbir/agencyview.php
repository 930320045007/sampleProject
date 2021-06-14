<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='86';?>
<?php 
	if(isset($_GET['id']))
		$id = $_GET['id'];
	else
		$id = 0;
		
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_ag = sprintf("SELECT * FROM transport_agency WHERE transagency_status = 1 AND transagency_id= %s ORDER BY transagency_name ASC", GetSQLValueString($id, "int"));
$ag = mysql_query($query_ag, $tadbirdb) or die(mysql_error());
$row_ag = mysql_fetch_assoc($ag);
$totalRows_ag = mysql_num_rows($ag);		
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1) && $id != 0){?>
                <li>
                <div class="note">Maklumat lengkap agensi</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Nama</td>
                      <td colspan="3"><?php echo $row_ag['transagency_name']; ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Alamat</td>
                      <td colspan="3"><?php echo  $row_ag['transagency_address']; ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">No. Tel</td>
                      <td width="50%"><?php echo $row_ag['transagency_notel']; ?></td>
                      <td nowrap="nowrap" class="label">No. Fax</td>
                      <td width="50%"><?php echo $row_ag['transagency_nofax']; ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Email</td>
                      <td><?php echo $row_ag['transagency_email']; ?></td>
                    </tr>
                    <tr>
                      <td class="label">&nbsp;</td>
                      <td colspan="3"><input name="button3" type="button" class="submitbutton" id="button3" value="Kemaskini" onClick="MM_goToURL('parent','agencyedit.php?id=<?php echo $id;?>');return document.MM_returnValue" /></td>
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
mysql_free_result($ag);
?>
<?php include('../inc/footinc.php');?> 