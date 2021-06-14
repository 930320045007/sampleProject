<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/func.php');?>
<?php $menu='1';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
<script src="SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('inc/header.php');?>
        
   	  <div class="content">
        <div class="fl w50 content2">
            <div class="title2">Semakkan Kata Laluan</div>
            <div class="note">
            	<ul>
                	<li class="txt_line">Cawangan ICT akan menyimpan maklumat kakitangan yang menggunakan modul ini untuk rekod. </li>
                    <li class="txt_line">Kakitangan dinasihatkan untuk tidak cuai dalam menetapkan kata laluan supaya masalah ini tidak mengganggu pengurusan kerjaya kakitangan.</li>
                    <li class="txt_line"><span class="txt_color2"><strong>PERINGATAN!</strong></span> Kakitangan hanya boleh menggunakan modul ini kembali setelah 2 minggu (pada <?php echo date('d/m/Y', mktime(0, 0, 0, date('m'), date('d')+14, date('Y')));?>) daripada tarikh semakkan email dibuat.</li>
                 </ul>
            </div>
         </div>
            <div class="fr w50">
              <form id="formKL" name="formKL" method="post" action="sb/fail.php">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="form_table">
                  <tr>
                    <td colspan="2" class="title">Semakkan Email</td>
                  </tr>
                <?php if($sendemailfunc){?>
                  <tr>
                    <td nowrap="nowrap" >Email Pengguna</td>
                    <td width="100%">
                      <span id="username"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                      <input name="isnmail" type="text" class="user txt_right" id="isnmail" />
                     <div class="inputlabel">@nsc.gov.my</div></span> </td>
                  </tr>
                  <tr>
                    <td colspan="2" nowrap="nowrap" >
                    <span id="syarat">
                    <ul class="inputradio">
                      <li>
                        <input type="checkbox" name="checkbox" id="checkbox" />
                      </li>
                    <li><span class="checkboxRequiredMsg">Sila buat pegesahan penerimaan berikut.<br/></span>
                    Saya dengan ini bersetuju dengan syarat yang ditetapkan.</li></ul></span></td>
                  </tr>
                  <tr>
                    <td colspan="2"><input name="MM_insert_formKL" type="hidden" id="MM_insert_formKL" value="formKL" /><input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" />
                    <input name="button4" type="button" class="cancelbutton" id="button4" value="Kembali" onclick="MM_goToURL('parent','index.php');return document.MM_returnValue" /></td>
                  </tr>
                  <?php } else { ?>
                  <tr>
                    <td colspan="2" nowrap="nowrap" ><?php echo noteEmail(2);?></td>
                  </tr>
                  <tr>
                    <td colspan="2" nowrap="nowrap" ><input name="button4" type="button" class="cancelbutton" id="button4" value="Kembali" onclick="MM_goToURL('parent','index.php');return document.MM_returnValue" /></td>
                  </tr>
                  <?php }; ?>
                </table>
              </form>
            </div>
      </div>
      
		<?php include('inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("syarat");
var sprytextfield1 = new Spry.Widget.ValidationTextField("username");
</script>
</body>
</html>
<?php include('inc/footinc.php');?> 