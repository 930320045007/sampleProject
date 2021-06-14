<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php 
if (!isset($_SESSION)) {
  session_start();
}

$num = 1;

if(isset($_GET['deli']) && $_GET['deli']!=NULL)
{
  unset($_SESSION['stafid2'][$_GET['deli']]);
  unset($_SESSION['jenis2'][$_GET['deli']]);
  unset($_SESSION['item2'][$_GET['deli']]);
	
}else if(isset($_GET['del']) && $_GET['del']=='1'){
	
  $_SESSION['stafid2'] = NULL;
  unset($_SESSION['stafid2']);
  
  $_SESSION['jenis2'] = NULL;
  unset($_SESSION['jenis2']);
  
  $_SESSION['item2'] = NULL;
  unset($_SESSION['item2']);
	  
} else if(isset($_GET['add']) && $_GET['add']=='1' && $_POST['stafid2']!=NULL && $_POST['jenis2']!=NULL && $_POST['item2']!=NULL){
	
  if(!isset($_SESSION['stafid2']))
	  $_SESSION['stafid2'] = array();
	  
  if(!isset($_SESSION['jenis2']))
	  $_SESSION['jenis2'] = array();
	  
  if(!isset($_SESSION['item2']))
	  $_SESSION['item2'] = array();
	
  if(isset($_SESSION['stafid2']))
  {
	$_SESSION['stafid2'][] = strtoupper($_POST['stafid2']);
	$_SESSION['jenis2'][] = htmlspecialchars($_POST['jenis2'], ENT_QUOTES);
	$_SESSION['item2'][] = htmlspecialchars($_POST['item2'], ENT_QUOTES);
  };
  
}

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if(isset($_SESSION['stafid2']) && count($_SESSION['stafid2'])!=0){ ?>
  <tr>
    <th nowrap="nowrap">Bil</th>
    <th width="100%" align="left" valign="middle">Nama</th>
    <th align="center" valign="middle" nowrap="nowrap">Jenis</th>
    <th align="center" valign="middle" nowrap="nowrap">Item</th>
    <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
  </tr>
  <?php foreach($_SESSION['stafid2'] as $key => $value) {?>
  <tr class="on">
    <td nowrap="nowrap"><?php echo $num; $num++;?></td>
    <td align="left" valign="middle" nowrap="nowrap"><?php echo getFullNameByStafID($_SESSION['stafid2'][$key]) . " (" . $_SESSION['stafid2'][$key] . ")";?><input name="stafid[]" type="hidden" value="<?php echo $_SESSION['stafid2'][$key];?>" /></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php if($_SESSION['jenis2'][$key]=='1') echo "Penggantian"; else echo "Peralatan Baru";?><input name="jenis[]" type="hidden" value="<?php echo $_SESSION['jenis2'][$key];?>" /></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php echo getItemSubCategoryByID($_SESSION['item2'][$key]);?><input name="item[]" type="hidden" value="<?php echo $_SESSION['item2'][$key];?>" /></td>
    <td align="center" valign="middle" nowrap="nowrap">
    <ul class="func">
      <li><a class="cursorpoint" onclick="xmlhttpPost('additemapply.php?deli=<?php echo $key;?>', 'alat', 'senaraialat', 'Proses pembatalan...'); return false;">X</a></li>
    </ul>
    </td>
  </tr>
  <?php }; ?>
  <tr>
    <td colspan="4" align="center" valign="middle" class="noline txt_color1"><?php echo $num-1;?> rekod dijumpai</td>
  </tr>
  <?php } else { ?>
  <tr>
    <td width="100" align="center" valign="middle" class="noline">Sila pilih item dan kuantiti yang ingin dipinjam dan klik 'Tambah'</td>
  </tr>
  <?php };?>
</table>