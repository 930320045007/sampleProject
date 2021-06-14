<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ekad.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php 
if (!isset($_SESSION)) {
  session_start();
}

$num = 1;
$error = 0;

if(isset($_GET['deli']) && $_GET['deli']!=NULL)
{
  unset($_SESSION['np2'][$_GET['deli']]);
  unset($_SESSION['ep2'][$_GET['deli']]);
	
} elseif(isset($_GET['del']) && $_GET['del']=='1')
{
	
  $_SESSION['np2'] = NULL;
  unset($_SESSION['np2']);
  
  $_SESSION['ep2'] = NULL;
  unset($_SESSION['ep2']);
	  
} else if(isset($_GET['add']) && $_GET['add']=='1')
{
  if(!isset($_SESSION['np2']) && !isset($_SESSION['ep2']))
  {
	  $_SESSION['np2'] = array();
	  $_SESSION['ep2'] = array();
	  
  }
  
  if(isset($_SESSION['np2']))
  {
	  if(count($_SESSION['ep2'])<5)
	  {
		  if(filter_var($_POST['ep2'], FILTER_VALIDATE_EMAIL))
		  {
			  if(!in_array($_POST['ep2'],$_SESSION['ep2']))//if(isset($_POST['np2']) && $_POST['np2']!=NULL && isset($_POST['ep2']) && $_POST['ep2']!=NULL)
			  {
				  $np2 = $_POST['np2'];
				  $ep2 = $_POST['ep2'];
				  
				  $_SESSION['np2'][] = strtoupper(htmlspecialchars($np2, ENT_QUOTES));
				  $_SESSION['ep2'][] = strtolower(htmlspecialchars($ep2, ENT_QUOTES));
				  
			  } else {
			  	$error = 2;
			  };
		  
		  } else {
			  $error = 1;
		  };
	  };
  };
}

?>
<?php
if($error!=0)
{
	echo "<div class=\"note txt_color2\">";
	
	if($error==1)
		echo "Format Email Penerima tidak betul. Sila semak email penerima.";
	elseif($error==2)
		echo "Nama Penerima dan Email Penerima telah ditambah dalam senarai. Sila cuba sekali lagi.";
		
	echo "</div>";
};
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if(isset($_SESSION['np2']) && $_SESSION['np2']!=NULL){ ?>
  <tr>
    <th nowrap="nowrap">Bil</th>
    <th width="100%" align="left" valign="middle">Nama Penerima</th>
    <th align="center" valign="middle" nowrap="nowrap">Email Penerima</th>
    <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
  </tr>
  <?php foreach($_SESSION['np2'] as $key => $value) {?>
  <tr class="on">
    <td nowrap="nowrap"><?php echo $num; $num++;?></td>
    <td align="left" valign="middle" nowrap="nowrap"><?php echo $_SESSION['np2'][$key];?><input name="np[]" type="hidden" value="<?php echo $_SESSION['np2'][$key];?>" /></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php echo $_SESSION['ep2'][$key];?><input name="ep[]" type="hidden" value="<?php echo $_SESSION['ep2'][$key];?>" /></td>
    <td align="center" valign="middle" nowrap="nowrap">
    <ul class="func">
      <li><a class="cursorpoint" onclick="xmlhttpPost('addPenerima.php?deli=<?php echo $key;?>', 'kad', 'senaraPenerima', 'Proses pembatalan...'); return false;">X</a></li>
    </ul>
    </td>
  </tr>
  <?php }; ?>
  <tr>
    <td colspan="4" align="center" valign="middle" class="noline txt_color1"><?php echo $num-1;?> rekod dijumpai</td>
  </tr>
  <?php } else { ?>
  <tr>
    <td width="100" align="center" valign="middle" class="noline">Sila isi Nama Penerima, Email Penerima dan klik 'Tambah'.</td>
  </tr>
  <?php };?>
</table>