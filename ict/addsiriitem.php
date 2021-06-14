<?php 
if (!isset($_SESSION)) {
  session_start();
}

	$num = 1;

if(isset($_GET['deli']) && $_GET['deli']!=NULL)
{
	unset($_SESSION['siri'][$_GET['deli']]);
	
}else if(isset($_GET['del']) && $_GET['del']=='1'){
	
	  $_SESSION['siri'] = NULL;
	  unset($_SESSION['siri']);
	  
} else if(isset($_GET['add']) && $_GET['add']=='1' && $_POST['siri']!=NULL){
	
	if(!isset($_SESSION['siri']))
		$_SESSION['siri']=array();
	
	$_SESSION['siri'][] = strtoupper(htmlspecialchars($_POST['siri'], ENT_QUOTES));
	
}

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if(isset($_SESSION['siri']) && count($_SESSION['siri'])!=0){ ?>
  <tr>
    <td nowrap="nowrap" class="noline w100">
    <ul class="li2c">
  <?php foreach($_SESSION['siri'] as $key => $value) {?>
	<?php $num++;?>
    <li>
	<input name="itemnosiri[]" type="hidden" value="<?php echo $value;?>" /><?php echo $value;?><span class="del fr"><a class="cursorpoint" onclick="xmlhttpPost('addsiriitem.php?deli=<?php echo $key;?>', 'formitem', 'senaraisiri', 'Proses pembatalan...'); return false;">X</a></span>
    </li>
  <?php }; ?>
    </ul>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="noline txt_color1"><?php echo $num-1;?> rekod dijumpai</td>
  </tr>
  <?php } else { ?>
  <tr>
    <td width="100" align="center" valign="middle" class="noline">Masukkan No. Siri Pendaftaran dan klik 'Tambah'</td>
  </tr>
  <?php };?>
</table>