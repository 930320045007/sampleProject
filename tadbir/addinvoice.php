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

if(isset($_GET['inv']) && $_GET['inv']!=NULL)
{
	unset($_SESSION['desc'][$_GET['inv']]);
	unset($_SESSION['cat'][$_GET['inv']]);
	unset($_SESSION['quantity'][$_GET['inv']]);
	unset($_SESSION['amount'][$_GET['inv']]);
	
} elseif(isset($_GET['add']) && $_GET['add']=='1'){
	
	if($_POST['desc']!=NULL && $_POST['cat']!=NULL)
	{
		if(!isset($_SESSION['desc']))
			$_SESSION['desc']=array();
		if(!isset($_SESSION['cat']))
			$_SESSION['cat']=array();
		if(!isset($_SESSION['quantity']))
			$_SESSION['quantity']=array();
		if(!isset($_SESSION['amount']))
			$_SESSION['amount']=array();
	
			$_SESSION['desc'][] = htmlspecialchars($_POST['desc'], ENT_QUOTES);
			$_SESSION['cat'][] = htmlspecialchars($_POST['cat'], ENT_QUOTES);
			$_SESSION['quantity'][] = htmlspecialchars($_POST['descinv_quantity'], ENT_QUOTES);
			$_SESSION['amount'][] = htmlspecialchars($_POST['descinv_amount'], ENT_QUOTES);	
	};
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if($_POST['desc']==NULL || $_POST['cat']==NULL) {?>
<tr>
	<td colspan="6" class="noline txt_color2">Sila pastikan maklumat <b>Deskripsi</b> dan <b>Kategori</b> disertakan dengan betul.</td>
</tr>
<?php }?>
<?php if(isset($_SESSION['desc']) && count($_SESSION['desc'])!=0){ ?>
  <tr>
    <th align="center" valign="middle">Bil</th>
    <th align="center" valign="middle" width="25%">Deskripsi</th>
    <th align="center" valign="middle" width="25%">Kategori</th>
    <th align="center" valign="middle" width="25%">Kuantiti</th>
    <th align="center" valign="middle" width="25%">Amount (RM)</th>
    <th align="center" valign="middle">&nbsp;</th>
  </tr>
  <?php foreach($_SESSION['desc'] as $key => $value) {?>
  <tr class="on">
    <td align="center" valign="middle"><?php echo $num; $num++;?></td>
    <td align="center" valign="middle"><?php echo getDescNameByID($value);?><input name="invdesc[]" type="hidden" value="<?php echo $value;?>" /></td>
    <td align="center" valign="middle"><?php echo getTadbirCategoryNameByID($_SESSION['cat'][$key]);?><input name="invcat[]" type="hidden" value="<?php echo $_SESSION['cat'][$key];?>" /></td>
    <td align="center" valign="middle"><?php echo $_SESSION['quantity'][$key];?><input name="invquantity[]" type="hidden" value="<?php echo $_SESSION['quantity'][$key];?>" /></td>
    <td align="center" valign="middle"><?php echo $_SESSION['amount'][$key];?><input name="invamount[]" type="hidden" value="<?php echo $_SESSION['amount'][$key];?>" /></td>
    <td align="center" valign="middle"><ul class="func"><li><a class="cursorpoint" onclick="xmlhttpPost('addinvoice.php?inv=<?php echo $key;?>', 'form2', 'senaraiinvoice', 'Proses pembatalan...'); return false;">X</a></li></ul></td>
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

