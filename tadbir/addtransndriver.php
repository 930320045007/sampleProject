<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php 
if (!isset($_SESSION)){
  session_start();
}

$num = 1;

if(isset($_GET['deli']) && $_GET['deli']!=NULL)
{
  unset($_SESSION['transport1'][$_GET['deli']]);
  unset($_SESSION['driver1'][$_GET['deli']]);
	
}else if(isset($_GET['del']) && $_GET['del']=='1'){
	
  $_SESSION['transport1'] = NULL;
  unset($_SESSION['transport1']);
  
  $_SESSION['driver1'] = NULL;
  unset($_SESSION['driver1']);
	  
} else if(isset($_GET['add']) && $_GET['add']=='1'){
	
  	if(!isset($_SESSION['transport1']))
		$_SESSION['transport1'] = array();
  	if(!isset($_SESSION['driver1']))
		$_SESSION['driver1'] = array(); 

 if(isset($_SESSION['transport1']))
  {	
	$_SESSION['transport1'][] = htmlspecialchars($_POST['transport1'],ENT_QUOTES);
	$_SESSION['driver1'][] = htmlspecialchars($_POST['driver1'],ENT_QUOTES);
  };
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if(isset($_SESSION['transport1']) && count($_SESSION['transport1'])!=0){ ?>
  <tr>
    <th nowrap="nowrap">Bil</th>
    <th width="100%" align="left" valign="middle">Nama Kenderaan</th>
    <th align="center" valign="middle" nowrap="nowrap">No Plat</th>
    <th align="left" valign="middle" nowrap="nowrap">Pemandu</th>
    <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
  </tr>
 <?php foreach($_SESSION['transport1'] as $key => $value) {?>
  <tr class="on">
    <td nowrap="nowrap"><?php echo $num; $num++;?></td>
    <td align="left" valign="middle"><input name="transport[]" type="hidden" value="<?php echo $value;?>" /><?php echo getTransportNameByID($value);?></td>  
    <td align="left" valign="middle" nowrap="nowrap"><?php echo getTransportPlatByID($_SESSION['transport1'][$key]);?></td>
    <td align="left" valign="middle" nowrap="nowrap"><input name="driver[]" type="hidden" value="<?php echo $_SESSION['driver1'][$key];?>" /><?php echo getDriverNameByID($_SESSION['driver1'][$key]);?></td>  
   
    <td align="center" valign="middle" nowrap="nowrap">
    <ul class="func">
      <li><a class="cursorpoint" onclick="xmlhttpPost('addtransndriver.php?deli=<?php echo $key;?>', 'form2', 'senaraikenderaan', 'Proses pembatalan...'); return false;">X</a></li>
    </ul>
    </td>
  </tr>
  <?php }; ?>
  <tr>
    <td colspan="4" align="center" valign="middle" class="noline txt_color1"><?php echo $num-1;?> rekod dijumpai</td>
  </tr>
  <?php } else { ?>
  <tr>
    <td width="100" align="center" valign="middle" class="noline">Sila pilih kenderaan dan pemandu yang diperlukan dan klik 'Tambah'</td>
  </tr>
  <?php };?>
</table>