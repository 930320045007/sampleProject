<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='79';?>
<?php

$colname_tr = "-1";

if (isset($_GET['id'])) 
{
  $colname_tr = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_leaveoffice = sprintf("SELECT * FROM www.leave_office_soyal WHERE soyal_id=%s", GetSQLValueString($colname_tr,"int"));
$leaveoffice = mysql_query($query_leaveoffice, $hrmsdb) or die(mysql_error());
$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
$totalRows_leaveoffice = mysql_num_rows($leaveoffice);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_note = "SELECT * FROM leave_hrnote ORDER BY leave_hrnote_id ASC";
$note = mysql_query($query_note, $hrmsdb) or die(mysql_error());
$row_note = mysql_fetch_assoc($note);
$totalRows_note = mysql_num_rows($note);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="js/ajaxsbmt.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<?php include('../inc/headinc.php');?>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
                <?php if(getStaffBySoyalID($colname_tr) != $row_user['user_stafid']){?>
                <li class="gap">&nbsp;</li>
            	<li class="title">Catatan HR</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <form id="form3" name="form3" method="POST" action="../sb/update_catatanthumbprint.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    <td class="label">Tarikh</td>
                    <td>
                          <?php echo getDateBySoyalID($colname_tr);?>                      
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Status</td>
                        <td> <select name="leave_hrnote" id="leave_hrnote">
        <option value="0">Sila Pilih</option>
          <?php
do {  
?>
          <option value="<?php echo $row_note['leave_hrnote_id']?>"><?php echo $row_note['leave_hrnote_name']?></option>
          <?php
} while ($row_note = mysql_fetch_assoc($note));
  $rows = mysql_num_rows($note);
  if($rows > 0) {
      mysql_data_seek($note, 0);
	  $row_note = mysql_fetch_assoc($note);
  }
?>
        </select></td>
                        </tr>
                         <tr>
                      <td nowrap="nowrap" class="label noline"> <input name="soyal_id" type="hidden" id="soyal_id" value="<?php echo $colname_tr;?>" />                         <input name="MM_update" type="hidden" id="MM_update" value="hrnote" /></td>
                	  <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" /></td>
              	 </tr>
                    </table>
                      </form>
                </li>
                <?php } else { ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="2" align="center" valign="middle" class="noline">Anda tidak dibenarkan menambah maklumat sendiri.</td>
                    </tr>
                  </table>
                </li>
                <?php };?>
            </ul>
        </div>
        </div>
        </div>
        
	  <?php include('inc/footer.php');?>
     </div>
</div>
</body>
</html>
<?php include('../inc/footinc.php');?> 
<?php
mysql_free_result($leaveoffice);

mysql_free_result($note);
?>
