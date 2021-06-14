<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php 
$num = 1;

if (!isset($_SESSION)) {
  session_start();
}

if(isset($_GET['deli']) && $_GET['deli']!=NULL)
{
	unset($_SESSION['description'][$_GET['deli']]);
	unset($_SESSION['quantity'][$_GET['deli']]);
	unset($_SESSION['calculation'][$_GET['deli']]);
	unset($_SESSION['amount'][$_GET['deli']]);
	
} elseif(isset($_GET['add']) && $_GET['add']=='1'){
	
	if(!isset($_SESSION['description']))
		$_SESSION['description']=array();
	if(!isset($_SESSION['quantity']))
		$_SESSION['quantity']=array();
	if(!isset($_SESSION['calculation']))
		$_SESSION['calculation']=array();
	if(!isset($_SESSION['amount']))
		$_SESSION['amount']=array();
		
	$_SESSION['description'][] = htmlspecialchars($_POST['apply_description'], ENT_QUOTES);
	$_SESSION['quantity'][] = htmlspecialchars($_POST['apply_quantity'], ENT_QUOTES);
	$_SESSION['calculation'][] = htmlspecialchars($_POST['apply_calculation'], ENT_QUOTES);
	$_SESSION['amount'][] = htmlspecialchars($_POST['apply_amount'], ENT_QUOTES);
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if(isset($_SESSION['description']) && count($_SESSION['description'])!=0){ ?>
  <tr>
    <th align="center" valign="middle">Bil</th>
    <th align="left" valign="middle">Deskripsi/Perbelanjaan dipohon</th>
      <th align="left" valign="middle">Kuantiti</th>
      <th align="left" valign="middle">Pengiraan</th>
      <th align="left" valign="middle">Jumlah (RM)</th>
    <th align="center" valign="middle">&nbsp;</th>
  </tr>
  <?php foreach($_SESSION['description'] as $key => $value) {?>
  <tr class="on">
    <td align="center" valign="middle"><?php echo $num; $num++;?></td>
    <td align="left" valign="left" class="txt_line"><?php echo $value;?></strong><input name="desc[]" type="hidden" value="<?php echo $value;?>" /></td>
    <td align="left" valign="middle"><?php echo $_SESSION['quantity'][$key];?><input name="quantity[]" type="hidden" value="<?php echo $_SESSION['quantity'][$key];?>" /></td>
    <td align="left" valign="middle"><?php echo $_SESSION['calculation'][$key];?><input name="calc[]" type="hidden" value="<?php echo $_SESSION['calculation'][$key];?>" /></td>
    <td align="left" valign="middle"><?php echo $_SESSION['amount'][$key];?><input name="amount[]" type="hidden" value="<?php echo $_SESSION['amount'][$key];?>" /></td>
    <td align="center" valign="middle"><ul class="func"><li><a class="cursorpoint" onclick="xmlhttpPost('addapply.php?deli=<?php echo $key;?>', 'form2', 'senaraiapply', 'Proses pembatalan...'); return false;">X</a></li></ul></td>
  </tr>
  <?php }; ?>
  <tr>
    <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $num-1;?> rekod dijumpai</td>
  </tr>
  <?php } else { ?>
  <tr>
    <td colspan="6" width="100" align="center" valign="middle" class="noline">Sila isi maklumat permohonan dan klik 'Tambah'</td>
  </tr>
  <?php }; ?>
</table>

