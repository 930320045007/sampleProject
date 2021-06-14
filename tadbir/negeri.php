<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='9';?>
<?php $menu2='116';?>
<?php
/*mysql_select_db($database_ictdb, $ictdb);
$query_subcat = "SELECT subcategory.subcategory_id, subcategory.subcategory_name FROM ict.item LEFT JOIN ict.subcategory ON subcategory.subcategory_id = item.subcategory_id WHERE item_borrow = 1 AND item_status = '1' GROUP BY subcategory_id ORDER BY subcategory.subcategory_name ASC";
$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
$row_subcat = mysql_fetch_assoc($subcat);
$totalRows_subcat = mysql_num_rows($subcat);*/

$colname_user_personal = "-1";
if (isset($_SESSION['user_stafid'])) {
  $colname_user_personal = $_SESSION['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_personal = sprintf("SELECT * FROM www.user_personal WHERE user_stafid = %s ORDER BY userpersonal_id DESC", GetSQLValueString($colname_user_personal, "text"));
$user_personal = mysql_query($query_user_personal, $hrmsdb) or die(mysql_error());
$row_user_personal = mysql_fetch_assoc($user_personal);
$totalRows_user_personal = mysql_num_rows($user_personal);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_durationtype = "SELECT * FROM tadbir.duration_type ORDER BY durationtype_id ASC";
$durationtype = mysql_query($query_durationtype, $tadbirdb) or die(mysql_error());
$row_durationtype = mysql_fetch_assoc($durationtype);
$totalRows_durationtype = mysql_num_rows($durationtype);


if(isset($_POST['transporttype']) && $_POST['transporttype']!='0')
{
	$wsql .= " AND transporttype_id='" . htmlspecialchars($_POST['transporttype'], ENT_QUOTES) . "' ";
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_transporttype = "SELECT * FROM transporttype WHERE transporttype_status = 1 ORDER BY transporttype_name ASC";
$transporttype = mysql_query($query_transporttype, $hrmsdb) or die(mysql_error());
$row_transporttype = mysql_fetch_assoc($transporttype);
$totalRows_transporttype = mysql_num_rows($transporttype);


?>
<?php
  /*$_SESSION['peralatan'] = NULL;
  unset($_SESSION['peralatan']);
  
  $_SESSION['kuantiti'] = NULL;
  unset($_SESSION['kuantiti']);*/
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
<script>
	/*window.onload = function ()
	{
		dochange('6', 'kuantiti', document.getElementById('peralatan').value, document.getElementById('dmy').value, 0);
	}*/
</script>
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
      		<form action="../sb/add_userictborrow.php" method="POST" id="alat" name="alat">
                <ul>
				  <li>
  					<div class="note">PERMOHONAN UNTUK LAWATAN DALAM NEGERI 
                    (MELAINKAN KUALA LUMPUR atau PEJABAT ISN NEGERI)</div>
					<div class="note">1. Sila isi maklumat berikut :</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Nama</td>
                        <td width="100" colspan="3"><span id="tujuan">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.<br/>
                        </span>
                        <?php echo getFullNameByStafID($row_user['user_stafid']); ?></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Jawatan</td>
                        <td colspan="3"><span id="lokasi"><span class="textfieldRequiredMsg">Maklumat diperlukan.<br/></span>
                          <?php echo getJobtitleReal($row_user['user_stafid']);?></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Bahagian </td>
                        <td colspan="3" nowrap="nowrap" class="w50"><?php echo getFulldirectory(getDirIDByUser($row_user['user_stafid']));?></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tempat Lawatan</td>
                        <td colspan="3" nowrap="nowrap" class="w50"> <input type="text" name="transbook_title" id="transbook_title" onkeypress="return handleEnter(this, event)" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh lawatan</td>
                        <td width="100" nowrap="nowrap" class="w50">                          
                           <select name="travel_date_d" id="travel_date_d">
                                <?php for($i=1; $i<=31; $i++){?>
                                  <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                                <?php }; ?>
                                </select>
                                <select name="travel_date_m" id="travel_date_m">
                                <?php for($j=1; $j<=12; $j++){?>
                                  <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                                <?php }; ?>
                              </select>
                                <select name="travel_date_y" id="travel_date_y">
                                <?php for($k=date('Y'); $k<=(date('Y')+2); $k++){?>
                                  <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                <?php }; ?>
                              </select>
                        </td>
                        <td nowrap="nowrap" class="label">&nbsp;</td>
                        <td width="30%" class="w50">
                          
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tempoh</td>
                        <td colspan="3">
                          <select name="userborrow_duration" id="userborrow_duration">
                            <?php for($i=1; $i<10; $i++){?>
                           	  <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                          <select name="durationtype_id" id="durationtype_id">
                            <?php
                            do {  
                            ?>
                            <option value="<?php echo $row_durationtype['durationtype_id']?>"><?php echo $row_durationtype['durationtype_name']?></option>
                            <?php
                            } while ($row_durationtype = mysql_fetch_assoc($durationtype));
                              $rows = mysql_num_rows($durationtype);
                              if($rows > 0) {
                                  mysql_data_seek($durationtype, 0);
                                  $row_durationtype = mysql_fetch_assoc($durationtype);
                              }
                            ?>
                          </select></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Sebab-sebab lawatan *</td>
                        <td colspan="3"><span id="catatan"><span class="textareaRequiredMsg">Maklumat diperlukan.<br/></span><span class="textareaMaxCharsMsg">500 huruf sahaja.<br/></span>
                        <div class="inputlabel2">Sila nyatakan keperluan dengan lebih lengkap.</div>
                            <textarea name="userborrow_note" required="required" id="userborrow_note" cols="45" rows="5"></textarea>
                        <div class="inputlabel2"><span id="countcatatan">&nbsp;</span> huruf sahaja.</div>
                        </span> </td>
                      </tr>
                      <tr>
                        <td colspan="4" nowrap="nowrap" class="label"><p>Lain-lain keterangan latar belakang sebagai sokongan kepada lawatan:-</p>
                        <p>(Sila tandakan X dalam kotak yang  berkenaan dan lampirkan bersama-sama dokumen tersebut)                         :-</p></td>
                      </tr>
                      <tr>
                        <td rowspan="3" nowrap="nowrap" class="label"><p>Cara perjalanan (Tandakan &quot;X&quot; )</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p></td>
                        <td colspan="2" rowspan="3" nowrap="nowrap" class="label">
                        <div id="spryselect1">
                        <div class="selectInvalidMsg">Sila pilih kenderaan</div>
                        <div>
                          <select name="transporttype" id="transporttype" onChange="dochange('16', this.value, 0, 0);">
                            <?php
                          do {  
                          ?>
                            <option value="<?php echo $row_transporttype['transporttype_id']?>"><?php echo $row_transporttype['reason_name']?></option>
                            <?php
                          } while ($row_transporttype = mysql_fetch_assoc($transporttype));
                            $rows = mysql_num_rows($transporttype);
                            if($rows > 0) {
                                mysql_data_seek($transporttype, 0);
                                $row_transporttype = mysql_fetch_assoc($transporttype);
                            }
                          ?>
                          </select>
                        </div>
                        </div>
                        
                        
                        
                        
                        
                        </td>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Cara untuk dihubungi</td>
                       <td colspan="3"><span id="catatan"><span class="textareaRequiredMsg">Maklumat diperlukan.<br/></span>
                            <textarea name="userborrow_note" required="required" id="userborrow_note" cols="45" rows="5"></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Hal-hal lain</td>
                        <td colspan="3"><span id="catatan">
                        
                            <textarea name="userborrow_note" required="required" id="userborrow_note" cols="45" rows="5"></textarea>
                        
                        </span> </td>
                      </tr>
                      
                    </table>
            	</li>
                <li>&nbsp;</li>
                <li>                </li>
                <li>&nbsp;</li>
                <li>
                	<div class="note"> Pengesahan :</div>
                    <span id="pengesahan">
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td align="left" valign="top" class="noline">
                        <ul class="inputradio">
                            <li><input name="checkbox" type="checkbox" required="required" id="checkbox" /></li>
                	    </ul>
                        </td>
                	    <td width="100%" align="left" valign="middle" class="noline"><span class="checkboxRequiredMsg">Sila buat pengesahan.<br/> </span>Saya mengesahkan setiap maklumat yang diberikan adalah benar. Sekiranya maklumat yang diberikan tidak benar,<?php echo getDirSubName(getDirIDByMenuID($menu));?> berhak untuk menukar atau membatalkan permohonan tanpa sebarang makluman atau notis.</td>
              	    </tr>
                	  <tr>
                	    <td class="noline">
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_user['user_stafid'];?>" />
                        <input name="userborrow_type" type="hidden" id="userborrow_type" value="2" />
                		<input type="hidden" name="MM_insert" value="alat" />
                        </td>
                	    <td class="noline">
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Hantar" /></td>
              	    </tr>
              	  </table>
                  </span>
                </li>
            </ul>
          </form>
		
        <?php echo noteFooter('1');?>
        <?php echo noteEmail('1');?>
        <?php echo noteMade($menu);?>
         
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("tujuan", "none");
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("pengesahan");
var sprytextfield2 = new Spry.Widget.ValidationTextField("lokasi");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("catatan", {counterId:"countcatatan", counterType:"chars_remaining", maxChars:500});
</script>
</body>
</html>
<?php
mysql_free_result($subcat);

mysql_free_result($durationtype);
?>
<?php include('../inc/footinc.php');?> 