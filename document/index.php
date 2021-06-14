<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='18';?>
<?php $menu2='95';?>
<?php

//if(isset($_POST['lokasi']) && $_POST['lokasi']!='0')
//{
//	$wsql .= " AND dir_id='" . htmlspecialchars($_POST['lokasi'], ENT_QUOTES) . "' ";
//}


mysql_select_db($database_tadbirdb, $tadbirdb);
$query_kat = "SELECT * FROM tadbir.doc_category WHERE doccategory_status = 1 ORDER BY doccategory_name ASC";
$kat = mysql_query($query_kat, $tadbirdb) or die(mysql_error());
$row_kat = mysql_fetch_assoc($kat);
$totalRows_kat = mysql_num_rows($kat);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT dir.dir_id, dir.dir_name FROM www.user_unit LEFT JOIN www.dir ON dir.dir_id = user_unit.dir_id WHERE location_id = 1 AND userunit_status = '1' AND dir.dir_status = '1' GROUP BY dir_id ORDER BY dir_type ASC, dir.dir_name ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);
$totalRows_dir = mysql_num_rows($dir);

//mysql_select_db($database_hrmsdb, $hrmsdb);
//$query_dir = "SELECT * FROM dir WHERE dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
//$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
//$row_dir = mysql_fetch_assoc($dir);
//$totalRows_dir = mysql_num_rows($dir);
?>
<?php
  $_SESSION['lokasi'] = NULL;
  unset($_SESSION['lokasi']);
  
  $_SESSION['staf'] = NULL;
  unset($_SESSION['staf']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../js/disenter.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
      <?php include('../inc/menu.php');?>
        
      	<div class="content">
        
        <?php include('../inc/menu_document.php');?>
        <div class="tabbox">
          <div class="profilemenu">
      		<form action="../sb/add_document.php" method="POST" id="penerima" name="penerima">
                <ul>
				  <li>
  					<div class="note">Borang penghantaran dokumen</div>
					<div class="note">1. Sila isi maklumat berikut :</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Kategori</td>
                        <td width="130%" colspan="3"> 
                        <select name="category_id" id="category_id">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_kat['doccategory_id']?>"><?php echo $row_kat['doccategory_name'];?></option>
                            <?php
							} while ($row_kat = mysql_fetch_assoc($kat));
							  $rows = mysql_num_rows($kat);
							  if($rows > 0) {
								  mysql_data_seek($kat, 0);
								  $row_kat = mysql_fetch_assoc($kat);
							  }
							?>
                          </select></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">No Rujukan Minit *</td>
                        <td>
                        <span id="ruj"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
               	          <input required="required" name="doc_refno" type="text" class="w50" id="doc_refno" onkeypress="return handleEnter(this, event)" maxlength="25" />
                        <div class="inputlabel2">Merujuk kepada Minit / Memo </div>
           	            </span>
                        </td>
                      </tr>
                      <tr>
               	        <td nowrap="nowrap" class="label">Tajuk *</td>
               	        <td>
                        <span id="tajuk"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
               	          <input required="required" autofocus="autofocus" type="text" name="doc_title" id="doc_title" onkeypress="return handleEnter(this, event)" />
           	            </span>
                        </td>
           	          </tr>  
                    </table>
            	</li>
                <li>&nbsp;</li>
                <li>
                <div class="note">2. Maklumat Penerima</div>
                <ul>
                	<li class="form_back line_t line_l line_r">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td nowrap="nowrap" class="label">Bahagian
                          <select name="lokasi" id="lokasi" onChange="dochange('20', 'staf', this.value, '0');">
                          	<option value="0">Pilih Bhgn/Cwg/Unit/Pusat</option>
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_dir['dir_id']?>"><?php echo getFulldirectory($row_dir['dir_id'], 0);?></option>
      <?php
} while ($row_dir = mysql_fetch_assoc($dir));
  $rows = mysql_num_rows($dir);
  if($rows > 0) {
      mysql_data_seek($dir, 0);
	  $row_dir = mysql_fetch_assoc($dir);
  }
?>
                          </select></td>
                          <td class="label">Penerima
                            <select name="staf" id="staf">
           	               <option value="0">Sila Pilih Penerima</option>
       	         </select>
                 </td><td width="50%">
                          <input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="xmlhttpPost('addreceiver.php?add=1', 'penerima', 'senaraipenerima', 'Proses penambahan ...'); return false;"/>
                          <input name="button6" type="button" class="cancelbutton" id="button6" value="Batal Semua" onclick="xmlhttpPost('addreceiver.php?del=1', 'penerima', 'senaraipenerima', 'Proses pembatalan ...'); return false;" /></td>
                        </tr>
                      </table>
                	</li>
                	<li class="line_b line_l line_r">
                    	<div id="senaraipenerima">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="100" align="center" valign="middle" class="noline"><div>Sila pilih bahagian / cawangan / unit / pusat dan penerima. Kemudian klik 'Tambah'</div></td>
                            </tr>
                          </table>
                      </div>
               	  </li>
                </ul>
                </li>
                <li>&nbsp;</li>
                <li>
                	<div class="note">3. Pengesahan pinjaman :</div>
                    <span id="pengesahan">
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td align="left" valign="top" class="noline"><ul class="inputradio"><li>
                	      <input name="checkbox" type="checkbox" class="w25" id="checkbox" />
                	      </li>
                	    </ul></td>
                	    <td width="100%" align="left" valign="middle" class="noline"><span class="checkboxRequiredMsg">Sila buat pengesahan. <br/></span>Saya mengesahkan setiap maklumat yang diberikan adalah benar.</td>
              	    </tr>
                	  <tr>
                	    <td class="noline">
                		<input type="hidden" name="MM_insert" value="penerima" />
                        </td>
                	    <td class="noline">
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Hantar" /></td>
              	    </tr>
              	  </table>
                  </span>
                </li>
            </ul>
          </form>
          </div>
        </div>
        <?php echo noteEmail('1');?>
        <?php echo noteFooter('1');?>
         
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("pengesahan");
var sprytextfield2 = new Spry.Widget.ValidationTextField("ruj");
var sprytextfield2 = new Spry.Widget.ValidationTextField("tajuk");
</script>
</body>
</html>
<?php

mysql_free_result($dir);
mysql_free_result($kat);
?>
<?php include('../inc/footinc.php');?>
