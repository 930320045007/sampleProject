<?php require_once('../Connections/hrmsdb.php');?>
<?php require_once('../Connections/financedb.php');?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php $menu='16';?>
<?php $menu2='89';?>
<?php $menu3='1';?>
<?php
$colname_apply = "-1";
if (isset($_GET['appid'])) {
  $colname_apply = getID(htmlspecialchars($_GET['appid'], ENT_QUOTES),0);
}
mysql_select_db($database_financedb, $financedb);
$query_apply = sprintf("SELECT * FROM finance.apply WHERE apply_status = 1 AND apply_id = %s ORDER BY apply_id ASC", GetSQLValueString($colname_apply, "int"));
$apply = mysql_query($query_apply, $financedb) or die(mysql_error());
$row_apply = mysql_fetch_assoc($apply);
$totalRows_apply = mysql_num_rows($apply); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<?php include('../inc/headinc.php');?>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
      	<div class="content">
        <div class="tabbox">
        <div class="line_t">
        </div>
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                <li>
                	<div class="note">Kemaskini maklumat permohonan</div>
                    <li class="title">Maklumat Permohonan</li>
                      <li>&nbsp;
                  <form id="form1" name="form1" method="POST" action="../sb/update_apply.php">
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td align="left" valign="middle" nowrap="nowrap"><div class="inputlabel2">Deskripsi/Perbelanjaan dipohon</div>
                             <textarea name="apply_description" id="apply_description" cols="40" rows="3"><?php echo $row_apply['apply_description']; ?></textarea>
                               <div class="inputlabel2">&nbsp;</div>
                              </td>
                              <td align="left" valign="middle" nowrap="nowrap">
                              <div class="inputlabel2">Kuantiti</div>
                              <input type="text" name="apply_quantity" id="apply_quantity" onkeypress="return handleEnter(this, event)" value="<?php echo $row_apply['apply_quantity']; ?>" />
                              <div class="inputlabel2">&nbsp;unit/orang</div>
                              </td>
                              <td align="left" valign="middle" nowrap="nowrap"><div class="inputlabel2">Pengiraan</div>
                              <textarea name="apply_calculation" required="required" cols="40" rows="3" id="apply_calculation"><?php echo $row_apply['apply_calculation'];?></textarea>
                               <div class="inputlabel2">harga seunit x kuantiti dipohon</div>
                              </td>
                              <td align="left" valign="middle" nowrap="nowrap">
                              <div class="inputlabel2">Jumlah (RM)</div>
                              <input type="text" name="apply_amount" id="apply_amount" onkeypress="return handleEnter(this, event)"  value="<?php echo $row_apply['apply_amount'];?>"/>
                              <div class="inputlabel2">&nbsp;Cth: 2500.00</div>
                              </td>
                              </tr>
                              <tr>
                              <td  colspan="2" nowrap="nowrap" class="label noline"><input name="jkb_id" type="hidden" id="jkb_id" value="<?php echo getID(htmlspecialchars($row_apply['jkb_id'],ENT_QUOTES),0);?>" />
                        <input name="apply_id" type="hidden" id="apply_id" value="<?php echo getID(htmlspecialchars($row_apply['apply_id'],ENT_QUOTES),0);?>" />
                          <input name="MM_update" type="hidden" id="MM_update" value="form1" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                        <input name="button4" type="submit" class="cancelbutton" id="button4" value="Batal" /></td>
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
</body>
</html>
<?php
mysql_free_result($apply);
?>
<?php include('../inc/footinc.php');?> 