<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ekad.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='14';?>
<?php $menu2='65';?>
<?php
	
	$_SESSION['np2'] = NULL;
	unset($_SESSION['np2']);
	
	$_SESSION['ep2'] = NULL;
	unset($_SESSION['ep2']);
	
mysql_select_db($database_ekad, $ekad);
$query_cct = "SELECT * FROM ekad.cat WHERE cat_status = 1 AND (dir_id = '0' OR dir_id = '" . getDirIDByUser($row_user['user_stafid']) . "') ORDER BY cat_name ASC";
$cct = mysql_query($query_cct, $ekad) or die(mysql_error());
$row_cct = mysql_fetch_assoc($cct);
$totalRows_cct = mysql_num_rows($cct);

if(isset($_GET['cat']))
	$cc = htmlspecialchars($_GET['cat'], ENT_QUOTES);
else
	$cc = $row_cct['cat_id'];

mysql_select_db($database_ekad, $ekad);
$query_kad = "SELECT * FROM ekad.card WHERE cat_id = '" . $cc . "' AND card_status = 1 ORDER BY card_id ASC";
$kad = mysql_query($query_kad, $ekad) or die(mysql_error());
$row_kad = mysql_fetch_assoc($kad);
$totalRows_kad = mysql_num_rows($kad);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_qna.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(!$maintenance){?>
            	<li class="form_back">
               	  <form id="form1" name="form1" method="get" action="index.php">
               	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
               	      <tr>
               	        <td class="label">Tema</td>
               	        <td width="100%">
               	          <select name="cat" id="cat">
               	            <?php do { ?>
               	            <option <?php if($cc==$row_cct['cat_id']) echo "selected=\"selected\"";?> value="<?php echo $row_cct['cat_id']?>"><?php echo $row_cct['cat_name']?></option>
               	            <?php
							$i++;
							} while ($row_cct = mysql_fetch_assoc($cct));
							  $rows = mysql_num_rows($cct);
							  if($rows > 0) {
								  mysql_data_seek($cct, 0);
								  $row_cct = mysql_fetch_assoc($cct);
							  }
							?>
       	                  </select>
           	            <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
           	          </tr>
           	        </table>
              	  </form>
                </li>
            </ul>
              <form id="kad" name="kad" method="post" action="../sb/emailekad.php">
                <ul>
            <?php if ($totalRows_kad > 0) { // Show if recordset not empty ?>
                  <li>
                    <div class="note">1. Pilih kad ucapan</div>
                    <div class="off2">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <?php $i=1; do { ?>
                          <?php if($i%3==1) echo "<tr>";?>
                          <td align="center" valign="middle" class="noline">
                            <div><img width="300" class="line_b line_t line_r line_l" src="<?php echo $url_main . "ekad/" . $row_kad['card_thumb']; ?>" alt="Kad" /></div>
                            <div class="padt">
                              <ul class="inputradio">
                                <li><input <?php if((isset($_GET['kad']) && $row_kad['card_id']==$_GET['kad'])||($i==1)) echo "checked=\"checked\"";?> type="radio" name="kad" id="kad<?php echo $row_kad['card_id']; ?>" value="<?php echo $row_kad['card_id']; ?>" /> <?php echo $row_kad['card_name']; ?></li>
                              </ul>
                            </div>
                          </td>
                            <?php if($i%3==0) echo "</tr>";?>
                            <?php $i++; } while ($row_kad = mysql_fetch_assoc($kad)); ?>
                      </table>
                    </div>
                  </li>
                  <li>
                    <div class="note">2. Isi maklumat penerima</div>
                    <ul>
                    <li class="form_back line_t line_l line_r">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Nama Penerima *</td>
                        <td width="30%"><input name="np2" type="text" autofocus="autofocus" class="w70" id="np2" /></td>
                        <td class="label">Email Penerima *</td>
                        <td width="50%">
                        <input name="ep2" id="ep2" class="w50" type="text" />
                        <input name="button5" type="button" class="submitbutton" id="button5" value="Tambah" onclick="xmlhttpPost('addPenerima.php?add=1', 'kad', 'senaraPenerima', 'Proses penambahan ...'); return false;" />
                        </td>
                      </tr>
                      </table>
                    </li>
                    <li class="line_b line_l line_r">
                    	<div id="senaraPenerima">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="100" align="center" valign="middle" class="noline txt_line">Hanya lima (5) nama penerima yang dibenarkan.<br />
                              Sila isi Nama Penerima, Email Penerima dan klik 'Tambah'. Ulangi langkah ini untuk penambahan penerima lain.</td>
                              </tr>
                          </table>
                      </div>
                    </li>
                    </ul>
                 </li>
                 <li>
                 <div class="note">3. Ucapan / dedikasi</div>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <td class="noline">
                    <span id="ucv">
                    <span class="textareaMaxCharsMsg">Tidak melebihi 300 huruf.</span>
                    <textarea name="ucapan" id="ucapan" cols="45" rows="5"></textarea>
                    <div class="txt_color1"><span id="countucv">&nbsp;</span> huruf</div>
                    </span>
                    </td>
                  </tr>
                  <tr>
                    <td class="noline">
                    <input name="id" type="hidden" id="id" value="<?php echo $row_user['user_stafid'];?>" />
                    <input name="id" type="hidden" id="id" value="<?php echo $row_user['user_stafid'];?>" />
                    <input name="button4" type="submit" class="submitbutton" id="button4" value="Hantar" />
                    </td>
                  </tr>
                  </table>
                  </li>
				  <?php } else { ?>
                  <li>
                  <table>
                      <tr>
                        <td align="center" valign="middle" nowrap="nowrap" class="noline">Tiada rekod dijumpai. Sila pilih tema yang lain.</td>
                      </tr>
                    </table>
                  </li>
                  <?php }; ?>
                  <li class="line_t">
                    <div class="note">
                      <div>Perhatian :</div>
                      <div>
                        <ol>
                          <li>eKad yang dihantar tidak akan disimpan dalam <?php echo $systitle_short;?> dan penerima hanya menerima melalui email yang disertakan dalam Email Penerima</li>
                          <li>Bahagian Khidmat Pengurusan tidak akan bertanggungjawab terhadap eKad yang dihantar.</li>
                        </ol>
                      </div>
                    </div>
                  </li>
                  <?php } else { ?>
                  <li>
                  <div class="note">Sistem dalam proses pengemaskinian dan penambahbaikkan buat sementara waktu.</div>
                  </li>
                  <?php }; ?>
                </ul>
              </form>
            </div>
        </div>
        <?php echo noteEmail(1);?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("ucv", {isRequired:false, maxChars:300, counterId:"countucv", counterType:"chars_remaining"});
</script>
</body>
</html>
<?php include('../inc/footinc.php');?> 
<?php
mysql_free_result($kad);
mysql_free_result($cct);
?>