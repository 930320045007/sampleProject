<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php 
$error = 0;
$num = 1;
if(checkStafID($_POST['id']))
{
	if (!isset($_SESSION)) {
	  session_start();
	};

	if(isset($_GET['deli']) && $_GET['deli']!=NULL)
	{
		unset($_SESSION['stafidt'][$_GET['deli']]);
		
	} elseif(isset($_GET['add']) && $_GET['add']=='1'){
		
		if(!isset($_SESSION['stafidt']))
			$_SESSION['stafidt']=array();
			
		if(!in_array($_POST['id'],$_SESSION['stafidt']))
			$_SESSION['stafidt'][] = htmlspecialchars($_POST['id'],ENT_QUOTES);
		else
			$error = 2;
	};
	
} else {
	$error = 1;
};
?>

<?php 
if($error == 1){ ?>
	<div class="note txt_color2"><strong>Staf ID</strong> tidak dikenalpasti atau tidak aktif</div>
<?php } else if($error == 2){?>
	<div class="note txt_color2"><strong>Staf ID</strong> tidak didaftarkan dalam senarai penumpang</div>
<?php }; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if(isset($_SESSION['stafidt']) && count($_SESSION['stafidt'])!=0){ ?>
  <tr>
    <th align="center" valign="middle">Bil</th>
    <th align="left" valign="middle" width="100%">Maklumat Penumpang</th>
    <th align="center" valign="middle">&nbsp;</th>
  </tr>
  <?php foreach($_SESSION['stafidt'] as $key => $value) {?>
  <tr class="on">
    <td align="center" valign="middle"><?php echo $num; $num++;?></td>
    <td align="left" valign="left" class="txt_line">
    	<div><input name="passenger[]" type="hidden" value="<?php echo $value;?>" /><strong><?php echo getFullNameByStafID($value) . " (" . $value . ")";?></strong></div>
        <div><?php echo getFulldirectoryByUserID($value);?> &nbsp; &bull; &nbsp; No. Ext : <?php if(getExtNoByUserID($value)!=NULL) echo getExtNoByUserID($value); else echo "Tidak dinyatakan";?></div>
    </td>
    <td align="center" valign="middle"><ul class="func"><li><a class="cursorpoint" onclick="xmlhttpPost('addpassenger.php?deli=<?php echo $key;?>', 'formtransport', 'senaraipassenger', 'Proses pembatalan...'); return false;">X</a></li></ul></td>
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

