<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='8';?>
<?php $menu2='67';?>
<?php 
	
	$_SESSION['stafid2'] = NULL;
	unset($_SESSION['stafid2']);
	
	$_SESSION['jenis2'] = NULL;
	unset($_SESSION['jenis2']);
	
	$_SESSION['item2'] = NULL;
	unset($_SESSION['item2']);
	  
	$sql_where = " (user_unit.dir_id = '" . getDirIDByUser(htmlspecialchars($row_user['user_stafid'], ENT_QUOTES)) . "' OR dir.dir_sub = '" . getDirIDByUser(htmlspecialchars($row_user['user_stafid'], ENT_QUOTES)) . "') AND login.login_status = 1";
	
	$orderby = " user_firstname ASC, user_lastname ASC";
	
	mysql_select_db($database_hrmsdb, $hrmsdb); //sql untuk melihat semua senarai staf
	$query_userunit = sqlAllStaf($sql_where, $orderby);
	$userunit = mysql_query($query_userunit, $hrmsdb) or die(mysql_error());
	$row_userunit = mysql_fetch_assoc($userunit);
	$totalRows_userunit = mysql_num_rows($userunit);
		
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_sch = "SELECT subcategory.* FROM ict.subcategory WHERE subcategory_status = '1' ORDER BY subcategory_name ASC";
	$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
	$row_sch = mysql_fetch_assoc($sch);
	$totalRows_sch = mysql_num_rows($sch);
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<?php include('../inc/headinc.php');?>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_ict_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <?php if(getJob2ID($row_user['user_stafid'])!=0 && !$maintenance){ ?>
            <form id="alat" name="alat" method="POST" action="../sb/add_ict_userapply.php">
            <ul>
            	<li>
                <div class="note">Borang Permohonan Peralatan Baru/Penggantian</div>
            	</li>
                <li>
                    <div class="note">1. Pilihan Nama Kakitangan dan Jenis Item</div>
                    <ul>
                	<li class="form_back line_t line_l line_r">
                	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	      <tr>
                	        <td valign="bottom" nowrap="nowrap">
                            <div class="inputlabel2">Nama Kakitangan/Staf ID</div>
                	        <select name="stafid2" id="stafid2">
                	          <?php do {?>
                              <option value="<?php echo $row_userunit['user_stafid'];?>"><?php echo shortText(getFullNameByStafID($row_userunit['user_stafid'], 1),20);?></option>
                              <?php }while($row_userunit = mysql_fetch_assoc($userunit));?> 
              	            </select>
                            </td>
                	        <td valign="bottom" nowrap="nowrap">  
                            <div class="inputlabel2">Jenis Keperluan</div>
                            <select name="jenis2" id="jenis2">
                              <option value="1">Penggantian</option>
                              <option value="2">Peralatan Baru</option>
              	         	</select>
                          	</td>
                	        <td valign="bottom" nowrap="nowrap">
                             <div class="inputlabel2">Item</div>
                             <select name="item2" id="item2">
                               <?php
								do {  
								?>
                               <option value="<?php echo $row_sch['subcategory_id']?>"><?php if(getItemCategoryByID($row_sch['category_id'])!=$row_sch['subcategory_name']) echo getItemCategoryByID($row_sch['category_id']) . " " . $row_sch['subcategory_name']; else echo $row_sch['subcategory_name'];?></option>
                               <?php
								} while ($row_sch = mysql_fetch_assoc($sch));
								  $rows = mysql_num_rows($sch);
								  if($rows > 0) {
									  mysql_data_seek($sch, 0);
									  $row_sch = mysql_fetch_assoc($sch);
								  }
								?>
                            </select>
                            </td>
                	        <td width="100%" valign="bottom">
                            <input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="xmlhttpPost('additemapply.php?add=1', 'alat', 'senaraialat', 'Proses penambahan ...'); return false;"/>
               	            <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="xmlhttpPost('additemapply.php?del=1', 'alat', 'senaraialat', 'Proses pembatalan ...'); return false;" />
                            </td>
              	        </tr>
              	      </table>
                	</li>
                    <li class="line_b line_l line_r">
                    	<div id="senaraialat">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="100" align="center" valign="middle" class="noline txt_line">Permohonan boleh dibuat lebih daripada satu (1) nama atau lebih daripada satu (1) item. <br />
                              Sila pilih nama, jenis keperluan dan item yang ingin dimohon dan klik 'Tambah'. Ulangi langkah ini untuk penambahan permohonan lain.</td>
                              </tr>
                          </table>
                      </div>
                    </li>
                    </ul>
                  <li>
                    <div class="note">2. Sila jelaskan justifikasi keperluan dengan lengkap supaya permohonan dapat dipertimbangkan*</div>
                    <span id="catatan">
                    <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                    <span class="textareaMaxCharsMsg">Melebihi 300 huruf yang dibenarkan.</span>
                    <textarea name="userapply_note" required="required" id="userapply_note" cols="45" rows="5"></textarea>
                    <div class="inputlabel2"><span id="countcatatan">&nbsp;</span>huruf</div>
                    </span>
                </li>
                <li>
                <div class="note">Pengesahan Permohonan</div>
                <span id="pengesahan"> 
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="top" class="noline">
                    <ul class="inputradio">
                      <li>
                        <input name="checkbox" type="checkbox" required="required" id="checkbox" />
                    </li>
                    </ul></td>
                    <td width="100%" align="left" valign="middle" class="noline">
                    <span class="checkboxRequiredMsg">Sila buat pengesahan.</span>
                    <div>Saya mengesahkan setiap permohonan peralatan dan kuantiti yang dipohon dan bertanggungjawab terhadap keadaan peralatan sepertimana diserahkan kepada saya. Pihak ICT berhak untuk menukar atau membatalkan mana-mana permohonan peralatan atau kuantiti yang dipohon tanpa sebarang makluman atau notis.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="noline">&nbsp;</td>
                    <td class="noline"><input name="button5" type="submit" class="submitbutton" id="button5" value="Hantar" /></td>
                  </tr>
                </table></span>
                </li>
            </ul>
            <input type="hidden" name="MM_insert" value="alat" />
            </form>
            <?php } else{ ?>
				<ul>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="middle" class="txt_line">
                    <div class="note">Permohonan peralatan / perisian ICT <strong>hanya dibenarkan</strong> kepada Ketua Bahagian/Cawangan/Pusat/Unit sahaja. 
                    <br />
                    Sila berhubung dengan <strong>Ketua Bahagian/Cawangan/Pusat/Unit</strong> masing-masing.
                    </div>
                    </td>
                  </tr>
                </table>
                </li>
                </ul>
			<?php } ?>
			
          </div>
        </div>
        <?php echo noteEmail('1');?>
        <?php echo noteMade($menu);?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("catatan", {maxChars:300, counterId:"countcatatan", counterType:"chars_remaining"});
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("pengesahan");
</script>
</body>
</html>
<?php
mysql_free_result($userunit); //penutup kepada sql yang diishtihar
mysql_free_result($sch);
?>
<?php include('../inc/footinc.php');?> 