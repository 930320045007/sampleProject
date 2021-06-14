<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php 
$error = 0;
$num = 1;
	
if (!isset($_SESSION))
{
  session_start();
}

if(isset($_GET['deli']) && $_GET['deli']!=NULL)
{
	unset($_SESSION['from'][$_GET['deli']]);
	unset($_SESSION['to'][$_GET['deli']]);
	unset($_SESSION['dated'][$_GET['deli']]);
	unset($_SESSION['datem'][$_GET['deli']]);
	unset($_SESSION['datey'][$_GET['deli']]);
	unset($_SESSION['time'][$_GET['deli']]);
	
	$error = 1;
	
} elseif(isset($_GET['add']) && $_GET['add']=='1'){
	
	$dmy = explode("/", $_POST['dmy']);
	
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
	if(!isset($_SESSION['time']))
		$_SESSION['time']=array();
	
	if($_POST['journey_from']!=NULL && $_POST['journey_to']!=NULL)
	{
		$error = 1;
	};
	
	if($error==1)
	{
		$_SESSION['from'][] = htmlspecialchars($_POST['journey_from'],ENT_QUOTES);
		$_SESSION['to'][] = htmlspecialchars($_POST['journey_to'],ENT_QUOTES);
		$_SESSION['dated'][] = htmlspecialchars($dmy[0],ENT_QUOTES);
		$_SESSION['datem'][] = htmlspecialchars($dmy[1],ENT_QUOTES);
		$_SESSION['datey'][] = htmlspecialchars($dmy[2],ENT_QUOTES);
		$_SESSION['time'][] = htmlspecialchars($_POST['journey_time'], ENT_QUOTES);
	};
}
?>

<?php 
if($error == 0){ ?>
	<div class="note txt_color2">Maklumat tidak didaftarkan. Sila cuba sekali lagi.</div>
<?php };
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
		<?php echo date('d / m / Y (D)', mktime(0, 0, 0, $_SESSION['datem'][$key], $_SESSION['dated'][$key], $_SESSION['datey'][$key]));?>
        <input name="td[]" type="hidden" value="<?php echo $_SESSION['dated'][$key];?>" />
        <input name="tm[]" type="hidden" value="<?php echo $_SESSION['datem'][$key];?>" />
        <input name="ty[]" type="hidden" value="<?php echo $_SESSION['datey'][$key];?>" />
    </td>
    <td align="center" valign="middle"><?php $hms = explode(":",$_SESSION['time'][$key],2); echo date('h:i A', mktime($hms[0], $hms[1], 0, $_SESSION['datem'][$key], $_SESSION['dated'][$key], $_SESSION['datey'][$key])); ?><input name="th[]" type="hidden" value="<?php echo $_SESSION['time'][$key];?>" /></td>
    <td align="center" valign="middle"><ul class="func"><li><a class="cursorpoint" onclick="xmlhttpPost('addjourney.php?deli=<?php echo $key;?>', 'formtransport', 'senaraijourney', 'Proses pembatalan...'); return false;">X</a></li></ul></td>
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

