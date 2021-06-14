<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php 

if (!isset($_SESSION)) {
  session_start();
}

$num = 1;

if(isset($_GET['deli']) && $_GET['deli']!=NULL)
{
  unset($_SESSION['lokasi'][$_GET['deli']]);
  unset($_SESSION['staf'][$_GET['deli']]);
	
}else if(isset($_GET['del']) && $_GET['del']=='1'){
	
  $_SESSION['lokasi'] = NULL;
  unset($_SESSION['lokasi']);
  
  $_SESSION['staf'] = NULL;
  unset($_SESSION['staf']);
	  
} else if(isset($_GET['add']) && $_GET['add']=='1' && $_POST['lokasi']!=NULL && $_POST['staf']!=NULL){
	
  if(!isset($_SESSION['lokasi']))
	  $_SESSION['lokasi'] = array();
	  
  if(!isset($_SESSION['staf']))
	  $_SESSION['staf'] = array();
	
  if(isset($_SESSION['lokasi']))
  {
	$_SESSION['lokasi'][] = strtoupper($_POST['lokasi']);
	$_SESSION['staf'][] = strtoupper($_POST['staf']);
  };
  
}

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if(isset($_SESSION['lokasi']) && count($_SESSION['lokasi'])!=0){ ?>
  <tr>
    <th nowrap="nowrap">Bil</th>
    <th width="100%" align="left" valign="middle">Bahagian/Cawangan/Pusat/Unit</th>
    <th align="center" valign="middle" nowrap="nowrap">Nama Penerima</th>
    <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
  </tr>
  <?php foreach($_SESSION['lokasi'] as $key => $value) {?>
  <tr class="on">
    <td nowrap="nowrap"><?php echo $num; $num++;?></td>
    <td><?php echo getFulldirectory($value);?><input name="dir[]" type="hidden" value="<?php echo $value;?>" /></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php echo getFullNameByStafID($_SESSION['staf'][$key]) . " (" . $_SESSION['staf'][$key] . ")";?><input name="receiver[]" type="hidden" value="<?php echo $_SESSION['staf'][$key];?>" /></td>
     <td align="center" valign="middle" nowrap="nowrap">
    <ul class="func">
      <li><a class="cursorpoint" onclick="xmlhttpPost('addreceiver.php?deli=<?php echo $key;?>', 'penerima', 'senaraipenerima', 'Proses pembatalan...'); return false;">X</a></li>
    </ul>
    </td>
  </tr>
  <?php }; ?>
  <tr>
    <td colspan="4" align="center" valign="middle" class="noline txt_color1"><?php echo $num-1;?> rekod dijumpai</td>
  </tr>
  <?php } else { ?>
  <tr>
    <td width="100" align="center" valign="middle" class="noline">Sila pilih bahagian/cawangan/pusat/unit dan penerima kemudian klik 'Tambah'</td>
  </tr>
  <?php };?>
</table>