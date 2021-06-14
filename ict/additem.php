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
	unset($_SESSION['peralatan'][$_GET['deli']]);
	unset($_SESSION['kuantiti'][$_GET['deli']]);
	
}else if(isset($_GET['del']) && $_GET['del']=='1'){
	
	  $_SESSION['peralatan'] = NULL;
	  unset($_SESSION['peralatan']);
	  
	  $_SESSION['kuantiti'] = NULL;
	  unset($_SESSION['kuantiti']);
	  
} else if(isset($_GET['add']) && $_GET['add']=='1'){
	
	if(!isset($_SESSION['peralatan']))
		$_SESSION['peralatan']=array();
		
	if(!isset($_SESSION['kuantiti']))
		$_SESSION['kuantiti']=array();
	
	if(isset($_POST['kuantiti']) && $_POST['kuantiti']!=0)
	{
		$_SESSION['peralatan'][] = htmlspecialchars($_POST['peralatan'], ENT_QUOTES);
		$_SESSION['kuantiti'][] = htmlspecialchars($_POST['kuantiti'], ENT_QUOTES);
	} else {
		$_SESSION['kuantiti'][]=1;
	}	
}

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if(isset($_SESSION['peralatan']) && count($_SESSION['peralatan'])!=0){ ?>
  <tr>
    <th nowrap="nowrap">Bil</th>
    <th width="100%" align="left" valign="middle">Item</th>
    <th align="center" valign="middle" nowrap="nowrap">Kuantiti</th>
    <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
  </tr>
  <?php foreach($_SESSION['peralatan'] as $key => $value) {?>
  <tr class="on">
    <td nowrap="nowrap"><?php echo $num; $num++;?></td>
    <td><?php echo getItemSubCategoryByID($value);?><input name="subcat[]" type="hidden" value="<?php echo $value;?>" /></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php echo $_SESSION['kuantiti'][$key];?><input name="subcatk[]" type="hidden" value="<?php echo $_SESSION['kuantiti'][$key];?>" /></td>
    <td align="center" valign="middle" nowrap="nowrap"><ul class="func">
      <li><a class="cursorpoint" onclick="xmlhttpPost('additem.php?deli=<?php echo $key;?>', 'alat', 'senaraialat', 'Proses pembatalan...'); return false;">X</a></li>
    </ul></td>
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