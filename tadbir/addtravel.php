<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php 
if (!isset($_SESSION)) {
  session_start();
}

$num = 1;

if(isset($_GET['deli']) && $_GET['deli']!=NULL)
{
	unset($_SESSION['from'][$_GET['deli']]);
	unset($_SESSION['to'][$_GET['deli']]);
	unset($_SESSION['dated'][$_GET['deli']]);
	unset($_SESSION['datem'][$_GET['deli']]);
	unset($_SESSION['datey'][$_GET['deli']]);
	unset($_SESSION['dateh'][$_GET['deli']]);
	
} elseif(isset($_GET['add']) && $_GET['add']=='1'){
	
	if($_POST['travel_from']!=NULL && $_POST['travel_to']!=NULL)
	{
		if(!isset($_SESSION['from']))
			$_SESSION['from']=array();
		if(!isset($_SESSION['to']))
			$_SESSION['to']=array();
		if(!isset($_SESSION['dated']))
			$_SESSION['dated']=array();
		if(!isset($_SESSION['datem']))
			$_SESSION['datem']=array();
		if(!isset($_SESSION['datey']))
			$_SESSION['datey']=array();
		if(!isset($_SESSION['dateh']))
			$_SESSION['dateh']=array();
	
			$_SESSION['from'][] = htmlspecialchars($_POST['travel_from'], ENT_QUOTES);
			$_SESSION['to'][] = htmlspecialchars($_POST['travel_to'], ENT_QUOTES);
			$_SESSION['dated'][] = htmlspecialchars($_POST['travel_date_d'], ENT_QUOTES);
			$_SESSION['datem'][] = htmlspecialchars($_POST['travel_date_m'], ENT_QUOTES);
			$_SESSION['datey'][] = htmlspecialchars($_POST['travel_date_y'], ENT_QUOTES);
			$_SESSION['dateh'][] = htmlspecialchars($_POST['travel_time'], ENT_QUOTES);
	};
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if($_POST['travel_from']==NULL || $_POST['travel_to']==NULL) {?>
<tr>
	<td colspan="6" class="noline txt_color2">Sila pastikan maklumat <b>'Dari/From'</b> dan <b>'Ke/To'</b> disertakan dengan betul.</td>
</tr>
<?php }?>
<?php if(isset($_SESSION['from']) && count($_SESSION['from'])!=0){ ?>
  <tr>
    <th align="center" valign="middle">Bil</th>
    <th align="center" valign="middle" width="25%">Dari</th>
    <th align="center" valign="middle" width="25%">Ke</th>
    <th align="center" valign="middle" width="25%">Tarikh</th>
    <th align="center" valign="middle" width="25%">Masa</th>
    <th align="center" valign="middle">&nbsp;</th>
  </tr>
  <?php foreach($_SESSION['from'] as $key => $value) {?>
  <tr class="on">
    <td align="center" valign="middle"><?php echo $num; $num++;?></td>
    <td align="center" valign="middle"><?php echo $value;?><input name="tfrom[]" type="hidden" value="<?php echo $value;?>" /></td>
    <td align="center" valign="middle"><?php echo $_SESSION['to'][$key];?><input name="tto[]" type="hidden" value="<?php echo $_SESSION['to'][$key];?>" /></td>
    <td align="center" valign="middle">
		<?php echo date('d M Y (D)', mktime(0, 0, 0, $_SESSION['datem'][$key], $_SESSION['dated'][$key], $_SESSION['datey'][$key]));?>
        <input name="td[]" type="hidden" value="<?php echo $_SESSION['dated'][$key];?>" />
        <input name="tm[]" type="hidden" value="<?php echo $_SESSION['datem'][$key];?>" />
        <input name="ty[]" type="hidden" value="<?php echo $_SESSION['datey'][$key];?>" />
    </td>
    <td align="center" valign="middle"><?php echo $_SESSION['dateh'][$key];?><input name="th[]" type="hidden" value="<?php echo $_SESSION['dateh'][$key];?>" /></td>
    <td align="center" valign="middle"><ul class="func"><li><a class="cursorpoint" onclick="xmlhttpPost('addtravel.php?deli=<?php echo $key;?>', 'formtravel', 'senaraitravel', 'Proses pembatalan...'); return false;">X</a></li></ul></td>
  </tr>
  <?php }; ?>
  <tr>
    <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $num-1;?> rekod dijumpai</td>
  </tr>
  <?php } else { ?>
  <tr>
    <td colspan="6" width="100" align="center" valign="middle" class="noline">Sila isi maklumat yang dikehendaki dan klik 'Tambah'</td>
  </tr>
  <?php }; ?>
</table>

