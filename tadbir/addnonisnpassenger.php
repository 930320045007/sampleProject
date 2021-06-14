<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php 
$num = 1;

if (!isset($_SESSION)) {
  session_start();
}

if(isset($_GET['deli']) && $_GET['deli']!=NULL)
{
	unset($_SESSION['name'][$_GET['deli']]);
	unset($_SESSION['ic'][$_GET['deli']]);
	unset($_SESSION['pp'][$_GET['deli']]);
	unset($_SESSION['ct'][$_GET['deli']]);
	
} elseif(isset($_GET['add']) && $_GET['add']=='1'){
	
	if(!isset($_SESSION['name']))
		$_SESSION['name']=array();
	if(!isset($_SESSION['ic']))
		$_SESSION['ic']=array();
	if(!isset($_SESSION['pp']))
		$_SESSION['pp']=array();
	if(!isset($_SESSION['ct']))
		$_SESSION['ct']=array();
		
	$_SESSION['name'][] = htmlspecialchars($_POST['nip_name'], ENT_QUOTES);
	$_SESSION['ic'][] = htmlspecialchars($_POST['nip_noic'], ENT_QUOTES);
	$_SESSION['pp'][] = htmlspecialchars($_POST['nip_passport'], ENT_QUOTES);
	$_SESSION['ct'][] = htmlspecialchars($_POST['nip_notes'], ENT_QUOTES);
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if(isset($_SESSION['name']) && count($_SESSION['name'])!=0){ ?>
  <tr>
    <th align="center" valign="middle">Bil</th>
    <th align="left" valign="middle" width="100%">Maklumat Penumpang</th>
    <th align="center" valign="middle">&nbsp;</th>
  </tr>
  <?php foreach($_SESSION['name'] as $key => $value) {?>
  <tr class="on">
    <td align="center" valign="middle"><?php echo $num; $num++;?></td>
    <td align="left" valign="left" class="txt_line">
    	<div><strong><?php echo $value;?></strong><input name="nispname[]" type="hidden" value="<?php echo $value;?>" /></div>
        <div>No. KP : <?php if($_SESSION['ic'][$key]!=NULL) echo $_SESSION['ic'][$key]; else echo "Tidak dinyatakan";?> <input name="nispic[]" type="hidden" value="<?php echo $_SESSION['ic'][$key];?>" /> &nbsp; &bull; &nbsp; No. Passport : <?php if($_SESSION['pp'][$key]!='0')echo $_SESSION['pp'][$key]; else echo "Tidak dinyatakan";?> <input name="nisppp[]" type="hidden" value="<?php echo $_SESSION['pp'][$key];?>" /> </div>
        <div><?php echo $_SESSION['ct'][$key];?> <input name="nispnote[]" type="hidden" value="<?php echo $_SESSION['ct'][$key];?>" /></div>
    </td>
    <td align="center" valign="middle"><ul class="func"><li><a class="cursorpoint" onclick="xmlhttpPost('addnonisnpassenger.php?deli=<?php echo $key;?>', 'formtravel', 'senarainonisnpassenger', 'Proses pembatalan...'); return false;">X</a></li></ul></td>
  </tr>
  <?php }; ?>
  <tr>
    <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $num-1;?> rekod dijumpai</td>
  </tr>
  <?php } else { ?>
  <tr>
    <td colspan="3" width="100" align="center" valign="middle" class="noline">Sila isi maklumat Staf ID dan klik 'Tambah'</td>
  </tr>
  <?php }; ?>
</table>

