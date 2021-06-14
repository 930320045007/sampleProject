<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='31';?>
<?php
if(isset($_POST['jenis']))
{
	$jenis = htmlspecialchars($_POST['jenis'], ENT_QUOTES);
} else {
	$jenis = '1';
}

mysql_select_db($database_ictdb, $ictdb);
$query_vlist = "SELECT * FROM ict.vendor WHERE vendortype_id = '" . $jenis . "' AND vendor_status = 1 ORDER BY vendor_name ASC";
$vlist = mysql_query($query_vlist, $ictdb) or die(mysql_error());
$row_vlist = mysql_fetch_assoc($vlist);
$totalRows_vlist = mysql_num_rows($vlist);

mysql_select_db($database_ictdb, $ictdb);
$query_vtype = "SELECT * FROM ict.vendor_type WHERE vendortype_status = 1 ORDER BY vendortype_name ASC";
$vtype = mysql_query($query_vtype, $ictdb) or die(mysql_error());
$row_vtype = mysql_fetch_assoc($vtype);
$totalRows_vtype = mysql_num_rows($vtype);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script type="text/javascript">
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
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
                <li class="form_back">
                  <form id="pilihjenis" name="pilihjenis" method="post" action="vendor.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="noline label">Jenis</td>
                        <td width="100%" class="noline">
                          <select name="jenis" id="jenis">
                            <?php
							do {  
							?>
                            <option <?php if($row_vtype['vendortype_id']==$jenis) echo "selected=\"selected\"";?> value="<?php echo $row_vtype['vendortype_id']?>"><?php echo $row_vtype['vendortype_name']?></option>
                            <?php
							} while ($row_vtype = mysql_fetch_assoc($vtype));
							  $rows = mysql_num_rows($vtype);
							  if($rows > 0) {
								  mysql_data_seek($vtype, 0);
								  $row_vtype = mysql_fetch_assoc($vtype);
							  }
							?>
                          </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                        <td class="noline"><input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onClick="MM_goToURL('parent','vendoradd.php');return document.MM_returnValue"/></td>
                        <td class="noline"><input name="button5" type="button" class="submitbutton" id="button5" value="Service" onclick="MM_goToURL('parent','servicelist.php');return document.MM_returnValue"/></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                <div class="note">Senarai vendor</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_vlist > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th nowrap="nowrap">Bil</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama</th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
              <tr class="on">
                        <td><?php echo $i;?></td>
                        <td align="left" valign="middle"><a href="vendorview.php?id=<?php echo $row_vlist['vendor_id']; ?>"><?php echo $row_vlist['vendor_name']; ?></a>                          <?php if($row_vlist['vendor_notel']!=NULL) echo " &nbsp; &bull; &nbsp; Tel : " . $row_vlist['vendor_notel']; ?></td>
                      <td nowrap="nowrap">
                      <ul class="func">
                      <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                      <li><a href="vendoredit.php?id=<?php echo $row_vlist['vendor_id'];?>">Edit</a></li>
                      <?php }; ?>
                      <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>
                      <li><a onclick="return confirm('Anda mahu maklumat vendor berikut dipadam? \r\n\n <?php echo $row_vlist['vendor_name']; ?>')" href="../sb/add_vendor.php?vid=<?php echo $row_vlist['vendor_id'];?>">X</a></li>
                      <?php }; ?>
                      </ul>
                      </td>
                      </tr>
                    <?php $i++; } while ($row_vlist = mysql_fetch_assoc($vlist)); ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_vlist ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
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
mysql_free_result($vlist);

mysql_free_result($vtype);
?>
<?php include('../inc/footinc.php');?> 