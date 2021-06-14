<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='70';?>
<?php 
if(isset($_POST['id']))
	$userclaim = strtoupper($_POST['id']);
else if(isset($_GET['id']))
	$userclaim = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
else
	$userclaim = "-1";	 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?> 
      	<div class="content">
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
             <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
             <?php if(!isset($_POST['id'])){?>
              <form id="cli" name="cli" method="POST" action="../sb/add_claim.php">
			 <li>
             <div class="note">Permohonan Tuntutan Elaun Kerja Lebih Masa</div>
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                  <tr>
                   <td align="center" valign="middle"><?php echo viewProfilePic($userclaim);?></td>
                   <td width="100%" align="left" valign="middle" class="txt_line">
				   <div><strong><?php echo getFullNameByStafID($userclaim) . " (" . $userclaim . ")"; ?></strong></div>
                   <div><?php echo getJobtitle($userclaim); ?>, <?php echo getFulldirectoryByUserID($userclaim);?></div>
                   <div>Lantikan : <?php echo getJobtype($userclaim); ?> &nbsp; &bull; &nbsp; Gaji Pokok : RM <?php echo getSalaryByStafID($userclaim); ?></div>
                   </td>
                  </tr>
                </table>
               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Tarikh OT</td>
                    <td colspan="3">
                      <select name="claim_on_d" id="claim_on_d">
                      <?php for($i=1; $i<=31; $i++){?>
                        <option <?php if($i<10) $i = '0' . $i; if($i==date('d')) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                      <?php }; ?>
                      </select>
                      <select name="claim_on_m" id="claim_on_m">
                      <?php for($j=date('m'); $j>=(date('m')-2); $j--){?>
                        <option <?php if($j<10) $j = '0' . $j; if($j==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                      <?php }; ?>
                      </select>
                      <select name="claim_on_y" id="claim_on_y">
                      <?php for($k=(date('Y')-2); $k<=(date('Y')); $k++){?>
                        <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                      <?php }; ?>
                      </select>
                    </td>
                </tr>
                <tr>
                 	<td nowrap="nowrap" class="label">Waktu Bekerja</td>
             		<td>
                    <select name="claim_in_h">
                      <?php for($ih = 1; $ih<=12; $ih++){?>
                      <option <?php if($ih==8) echo "selected=\"selected\"";?> value="<?php echo $ih; ?>"><?php echo $ih; ?></option>
                      <?php }; ?>
                    </select> 
                  <select name="claim_in_m">
                      <?php for($im = 0; $im<60; $im+=15){?>
                      <option <?php if($im==date('i')) echo "selected=\"selected\"";?> value="<?php if($im==0) $im = "00"; echo $im; ?>"><?php echo $im; ?></option>
                      <?php }; ?>
                  </select>
                   <select name="claim_in_ap">
                            <option selected="selected" value="AM">AM</option>
                            <option value="PM">PM</option>
                    </select>
                           <span class="inputlabel"> hingga </span>
                    <select name="claim_out_h">
                      <?php for($oh = 1; $oh<=12; $oh++){?>
                      <option <?php if($oh==5) echo "selected=\"selected\"";?> value="<?php echo $oh; ?>"><?php echo $oh; ?></option>
                      <?php }; ?>
                   </select>
                    <select name="claim_out_m">
                      <?php for($om = 0; $om<60; $om+=15){?>
                      <option <?php if($om==date('i')) echo "selected=\"selected\"";?> value="<?php if($om==0) $om = "00"; echo $om; ?>"><?php echo $om; ?></option>
                      <?php }; ?>
                    </select>
                    <select name="claim_out_ap">
                            <option value="AM">AM</option>
                            <option selected="selected" value="PM">PM</option>
                      </select>
                	</td>
                </tr>
                <tr>
                    <td class="label">Kiraan Kerja Lebih Masa</td>
                    <td colspan="3">
                          <select name="claim_from_h">
                            <?php for($fh = 1; $fh<=24; $fh++){?>
                            <option <?php if($fh==6) echo "selected=\"selected\"";?> value="<?php echo $fh; ?>"><?php echo $fh; ?></option>
                            <?php }; ?>
                          </select>
                          <select name="claim_from_m">
                            <?php for($fm = 0; $fm<60; $fm++){?>
                            <option <?php if($fm==00) echo "selected=\"selected\"";?> value="<?php if($fm==0) $fm = "00"; echo $fm; ?>"><?php echo $fm; ?></option>
                            <?php }; ?>
                          </select>
                          <select name="claim_from_ap">
                            <option value="AM">AM</option>
                            <option selected="selected" value="PM">PM</option>
                          </select>
                          <span class="inputlabel"> hingga </span>
                          <select name="claim_till_h">
                            <?php for($th = 1; $th<=24; $th++){?>
                            <option <?php if($th==8) echo "selected=\"selected\"";?> value="<?php echo $th; ?>"><?php echo $th; ?></option>
                            <?php }; ?>
                          </select>
                          <select name="claim_till_m">
                            <?php for($tm = 0; $tm<60; $tm++){?>
                            <option <?php if($fm==00) echo "selected=\"selected\"";?> value="<?php if($tm==0) $tm = "00"; echo $tm; ?>"><?php echo $tm; ?></option>
                            <?php }; ?>
                          </select>
                          <select name="claim_till_ap">
                            <option value="AM">AM</option>
                            <option selected="selected" value="PM">PM</option>
                      </select>
                      <span class="inputlabel"> = </span>
                          <select name="claim_total_h">
                            <?php for($h = 0; $h<=24; $h++){?>
                            <option <?php if($h==2) echo "selected=\"selected\"";?> value="<?php echo $h; ?>"><?php echo $h; ?></option>
                            <?php }; ?>
                          </select>&nbsp;<span class="inputlabel">Jam</span>
                          <select name="claim_total_m">
                            <?php for($m = 0; $m<60; $m++){?>
                            <option <?php if($m==00) echo "selected=\"selected\"";?> value="<?php if($m==0) $m = "00"; echo $m; ?>"><?php echo $m; ?></option>
                            <?php }; ?>
                          </select>&nbsp;<span class="inputlabel">Minit</span>
                    </td>
               	  </tr>
                </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Pecahan Kiraan</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                     <th colspan="2" align="left" valign="middle" nowrap="nowrap" class="labelli">Jenis</th>
                     <th align="left" valign="middle" nowrap="nowrap" class="labelli">Jam</th>
                     <th width="100%" align="left" valign="middle" nowrap="nowrap" class="labelli">Minit</th>
                </tr>
                <tr class="back_lightgrey">
                   <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="label line_b back_darkgrey">Siang</td>
                   <td align="left" valign="middle" nowrap="nowrap" class="back_darkgrey">
                       <select name="claim_siang_h">
						   <?php for($sh = 0; $sh<=24; $sh++){?>
                           <option <?php if($sh==0) echo "selected=\"selected\"";?> value="<?php echo $sh; ?>"><?php echo $sh; ?></option>
                           <?php }; ?>
                       </select> 
                   </td>
                   <td align="left" valign="middle" class="line_b back_darkgrey">
                       <select name="claim_siang_m">
						   <?php for($sm = 0; $sm<60; $sm+=15){?>
                           <option <?php if($sm==00) echo "selected=\"selected\"";?> value="<?php if($sm==0) $sm = "00"; echo $sm; ?>"><?php echo $sm; ?></option>
                           <?php }; ?>
                       </select>
                   </td>
                </tr>
                <tr>
                    <td rowspan="2" align="left" valign="middle" nowrap="nowrap" class="label line_b">Ahad</td>
                    <td align="left" valign="middle" nowrap="nowrap" class="label">Malam & Siang</td>
                    <td align="left" valign="middle" nowrap="nowrap">
                        <select name="claim_malamsiang_h">
                            <?php for($msh = 0; $msh<=24; $msh++){?>
                            <option <?php if($msh==0) echo "selected=\"selected\"";?> value="<?php echo $msh; ?>"><?php echo $msh; ?></option>
                            <?php }; ?>
                        </select>        
                    </td>
                    <td align="left" valign="middle">
                        <select name="claim_malamsiang_m">
                            <?php for($msm = 0; $msm<60; $msm+=15){?>
                            <option <?php if($msm==00) echo "selected=\"selected\"";?> value="<?php if($msm==0) $msm = "00"; echo $msm; ?>"><?php echo $msm; ?></option>
                            <?php }; ?>
                        </select>
                    </td>
              </tr>
              <tr>
                  <td align="left" valign="middle" nowrap="nowrap" class="label line_b">Malam</td>
                  <td align="left" valign="middle" nowrap="nowrap">
                      <select name="claim_malamahad_h">
                          <?php for($mah = 0; $mah<=24; $mah++){?>
                          <option <?php if($mah==0) echo "selected=\"selected\"";?> value="<?php echo $mah; ?>"><?php echo $mah; ?></option>
                          <?php }; ?>
                      </select>
                  </td>
                  <td align="left" valign="middle" class="line_b">
                      <select name="claim_malamahad_m">
                          <?php for($mam = 0; $mam<60; $mam+=15){?>
                          <option <?php if($mam==00) echo "selected=\"selected\"";?> value="<?php if($mam==0) $mam = "00"; echo $mam; ?>"><?php echo $mam; ?></option>
                          <?php }; ?>
                      </select>
                  </td>
              </tr>
              <tr>
                  <td rowspan="2" align="left" valign="middle" nowrap="nowrap" class="label line_b back_darkgrey">Hari Am</td>
                  <td align="left" valign="middle" nowrap="nowrap" class="label back_darkgrey">Siang</td>
                  <td align="left" valign="middle" nowrap="nowrap" class="back_darkgrey"><select name="claim_amsiang_h">
                        <?php for($ash = 0; $ash<=24; $ash++){?>
                        <option <?php if($ash==0) echo "selected=\"selected\"";?> value="<?php echo $ash; ?>"><?php echo $ash; ?></option>
                        <?php }; ?>
                      </select>                    </td>
                  <td align="left" valign="middle" class="back_darkgrey"><select name="claim_amsiang_m">
                        <?php for($asm = 0; $asm<60; $asm+=15){?>
                        <option <?php if($asm==00) echo "selected=\"selected\"";?> value="<?php if($asm==0) $asm = "00"; echo $asm; ?>"><?php echo $asm; ?></option>
                        <?php }; ?>
                      </select>                    </td>
            </tr>
            <tr>
                <td align="left" valign="middle" nowrap="nowrap" class="label line_b back_darkgrey">Malam</td>
                <td align="left" valign="middle" nowrap="nowrap" class="line_b back_darkgrey"><select name="claim_ammalam_h">
                  <?php for($amh = 0; $amh<=24; $amh++){?>
                  <option <?php if($amh==0) echo "selected=\"selected\"";?> value="<?php echo $amh; ?>"><?php echo $amh; ?></option>
                  <?php }; ?>
                </select>                  </td>
                <td align="left" valign="middle" class="line_b back_darkgrey"><select name="claim_ammalam_m">
                  <?php for($amm = 0; $amm<60; $amm+=15){?>
                  <option <?php if($amm==00) echo "selected=\"selected\"";?> value="<?php if($amm==0) $amm = "00"; echo $amm; ?>"><?php echo $amm; ?></option>
                  <?php }; ?>
                </select>                    </td>
            </tr>
            <tr>
                <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="label">Catatan *</td>
                <td colspan="3">
                  <span id="claimnote">
                  <span class="textareaRequiredMsg">Maklumat diperlukan. &nbsp; </span>
                  <div class="inputlabel2">Sila nyatakan maklumat dengan lebih lengkap</div>
                  <textarea name="claim_note" cols="45" rows="5" class="w50" id="claim_note"></textarea>
                  </span></td>
            </tr>        
            <tr>
            	<td colspan="2" nowrap="nowrap" class="noline">
                    <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $userclaim;?>" />
                    <input type="hidden" name="MM_insert" value="cli" />
                </td>
                <td colspan="2" class="noline">
                  <input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
                  <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','adminclaim.php?id=<?php echo $userclaim;?>');return document.MM_returnValue" />
                </td>
            </tr>
            </table>
         </li> 
         </form>
		  <?php }; ?>
          <?php } else {?>
          <li>Tiada rekod</li>
          <?php };?>
          </ul>
          </div>
          </div>
          <?php echo  noteFooter('1');?>
      </div>    
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("claimnote");
</script>
</body>
</html>
<?php include('../inc/footinc.php');?> 
                       