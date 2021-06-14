<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='70';?>
<?php 

if(isset($_POST['id']))
	$userclaim = strtoupper(htmlspecialchars($_POST['id'], ENT_QUOTES));
else if(isset($_GET['id']))
	$userclaim = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
else
	$userclaim = $row_user['user_stafid'];

$wsql = "";	

if((isset($_GET['dmy'])&& $_GET['dmy']!=0)||(isset($_POST['dmy']) && $_POST['dmy']!=0))
{
	if(isset($_GET['dmy']))
		$dmy = explode("/", htmlspecialchars($_GET['dmy'], ENT_QUOTES));
	else
		$dmy = explode("/", htmlspecialchars($_POST['dmy'], ENT_QUOTES));
		
	$d=1;
	$m = $dmy['0'];
	$wsql=" AND claim_on_m='".$m."'";
	$y = $dmy['1'];
	
} else if((isset($_GET['dmy'])&& $_GET['dmy']==0)||(isset($_POST['dmy']) && $_POST['dmy']==0))
{
	$wsql="";
	$m=0;
	$y = date('Y');
	
} else {
	
	$d=date('d');
	$m = date('m');
	$wsql=" AND claim_on_m='".$m."'";
	$y = date('Y');
}
?>
<?php 

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_claim = "SELECT * FROM tadbir.claim WHERE claim_on_y='".$y."' AND user_stafid = '".$userclaim."' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
$claim = mysql_query($query_claim, $tadbirdb) or die(mysql_error());
$row_claim = mysql_fetch_assoc($claim);
$totalRows_claim = mysql_num_rows($claim);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
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
             <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
			 <li class="form_back">
               <form id="formcheckstaf" name="formcheckstaf" method="get" action="adminclaim.php">
               		<table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                        <td nowrap="nowrap" class="label">Staf ID</td>
                        <td width="100%">
                        <input name="id" type="text" class="w30" id="id" list="datastafid" value="<?php echo $userclaim; ?>"/><?php echo datalistStaf('datastafid');?>
                        <select name="dmy" id="dmy">
                        <?php for($j=1;$j<=12;$j++){?>
                      		<option <?php if($m!=0 && $j==$m) echo "selected=\"selected\"";?>  value="<?php echo date('m/Y',mktime(0,0,0,$j,1,date('Y')));?>"><?php echo date('m/Y',mktime(0,0,0,$j,1,date('Y')));?></option>
					  	<?php }; ?>
                   			 <option <?php if($m==0) echo "selected=\"selected\"";?> value="0">2012</option>
                    	</select>
                   		<input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" />
                    	</td>
                        <td><input name="button3" type="button" class="submitbutton" id="button3" value="Senarai" onclick="MM_goToURL('parent','claimlist.php');return document.MM_returnValue" /></td>
                        <?php if($userclaim != $row_user['user_stafid']){?>
                        <td>
                        <input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="MM_goToURL('parent','claimadd.php?id=<?php echo $userclaim; ?>');return document.MM_returnValue" />
                        </td>
                        <?php }; ?>
                  	</tr>
                </table>
               </form>
              </li>
              <?php if(getStatusByStafID($userclaim)){?>
           	  <li>
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
               </li>
               <li>
               <div class="note">Tuntutan kerja lebih masa <?php if($m!=0){?>bagi bulan <strong><?php echo date('F Y', mktime(0, 0, 0, $m, 1, $y));?></strong><?php } else { echo "tahun <strong>".$y."</strong>";};?></div>
               <div class="off2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php if ($totalRows_claim > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" nowrap="nowrap">Bil</th>
                      <th align="left" nowrap="nowrap">Tarikh OT</th>
                      <th align="left" nowrap="nowrap">Tarikh Proses</th>
                      <th align="left" nowrap="nowrap">Kerja lebih masa</th>
                      <th width="100" align="center" nowrap="nowrap" class="line_l line_t">1 1/8</th>
                      <th width="100" align="center" nowrap="nowrap" class="line_l">1 1/4</th>
                      <th width="100" align="center" nowrap="nowrap" class="line_l line_t">1 1/2</th>
                      <th width="100" align="center" nowrap="nowrap" class="line_l">1 3/4</th>
                      <th width="100" align="center" nowrap="nowrap" class="line_l line_t">2</th>
                      <th align="center" nowrap="nowrap" class="line_l">Jumlah</th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                 <?php $i=1; do { ?>
                    <tr class="on">
                      <td align="center" valign="middle"><?php echo $i;?></td>
                      <td align="left" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0 , 0, 0, $row_claim['claim_on_m'], $row_claim['claim_on_d'], $row_claim['claim_on_y']));?></td>
                      <td align="left" valign="middle" nowrap="nowrap"><?php echo date('M Y', mktime(0 , 0, 0, $row_claim['claim_date_m'], $row_claim['claim_date_d'], $row_claim['claim_date_y']));?></td>
                      <td align="left" valign="middle" nowrap="nowrap"><?php echo $row_claim['claim_from_h'] . "." . $row_claim['claim_from_m'] . " " . $row_claim['claim_from_ap'];?> - <?php echo $row_claim['claim_till_h'] . "." . $row_claim['claim_till_m'] . " " . $row_claim['claim_till_ap'];?></td>
                      <td class="line_l" align="center" valign="middle" nowrap="nowrap"><?php if($row_claim['claim_siang_h']!=0) echo $row_claim['claim_siang_h']." j";?> <?php if($row_claim['claim_siang_m']!=0) echo $row_claim['claim_siang_m']." m";?></td>
                      <td class="line_l" align="center" valign="middle" nowrap="nowrap"><?php if($row_claim['claim_malamsiang_h']!=0) echo $row_claim['claim_malamsiang_h']." j";?> <?php if($row_claim['claim_malamsiang_m']!=0)echo $row_claim['claim_malamsiang_m']." m";?></td>
                      <td class="line_l" align="center" valign="middle" nowrap="nowrap"><?php if($row_claim['claim_malamahad_h']!=0) echo $row_claim['claim_malamahad_h']." j";?> <?php if($row_claim['claim_malamahad_h']!=0)echo $row_claim['claim_malamahad_m']." m";?></td>
                      <td class="line_l" align="center" valign="middle" nowrap="nowrap"><?php if($row_claim['claim_amsiang_h']!=0) echo $row_claim['claim_amsiang_h']." j";?> <?php if($row_claim['claim_amsiang_m']!=0)echo $row_claim['claim_amsiang_m']." m";?></td>
                      <td class="line_l" align="center" valign="middle" nowrap="nowrap"><?php if($row_claim['claim_ammalam_h']!=0) echo $row_claim['claim_ammalam_h']." j";?> <?php if($row_claim['claim_ammalam_m']!=0)echo $row_claim['claim_ammalam_m']." m";?></td>
                      <td align="center" valign="middle" nowrap="nowrap" class="line_l"><?php if($row_claim['claim_total_h']!=0) echo $row_claim['claim_total_h']." j";?> <?php if($row_claim['claim_total_m']!=0) echo $row_claim['claim_total_m']." m";?></td>
                      <td align="left" nowrap="nowrap">
                        <ul class="func">
                            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){ ?>
                            <li><a href="claim_edit.php?id=<?php echo $row_claim['claim_id']; ?>">Edit</a></li>
                            <?php }; ?>
                            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){ ?>
                            <li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo getFullNameByStafID($row_claim['user_stafid']);?> \r\n <?php echo date('d / m / Y (D)', mktime(0 , 0, 0, $row_claim['claim_on_m'], $row_claim['claim_on_d'], $row_claim['claim_on_y'])); ?>')" href="../sb/del_claim.php?id=<?php echo $row_claim['claim_id']; ?>">X</a></li>
                            <?php }; ?>
                        </ul>
                        </td>
                	</tr>
                 <?php $i++; } while ($row_claim = mysql_fetch_assoc($claim)); ?>
                 <tr class="back_darkgrey">
                      <td colspan="4" align="right" valign="middle"><strong>Jumlah</strong></td>
                      <td class="line_l" align="center" valign="middle" nowrap="nowrap">
					  <?php if(getTotalSiangOn($userclaim, $m, $y, 1)!='0') echo getTotalSiangOn($userclaim,$m, $y, 1)." j";?> <?php if(getTotalSiangOn($userclaim,$m, $y, 2)!='00') echo getTotalSiangOn($userclaim, $m, $y, 2)." m";?>
                      </td>
                      
                      <td class="line_l" align="center" valign="middle" nowrap="nowrap">
					  <?php if(getTotalMalamSiangOn($userclaim, $m, $y, 1)!='0') echo getTotalMalamSiangOn($userclaim,$m, $y, 1)." j";?> <?php if(getTotalMalamSiangOn($userclaim,$m, $y, 2)!='00') echo getTotalMalamSiangOn($userclaim, $m, $y, 2)." m";?>
                      </td>
                      
                      <td class="line_l" align="center" valign="middle" nowrap="nowrap">
					  <?php if(getTotalMalamAhadOn($userclaim, $m, $y, 1)!='0') echo getTotalMalamAhadOn($userclaim,$m, $y, 1)." j";?> <?php if(getTotalMalamAhadOn($userclaim,$m, $y, 2)!='00') echo getTotalMalamAhadOn($userclaim, $m, $y, 2)." m";?>
                      </td>
                      
                      <td class="line_l" align="center" valign="middle" nowrap="nowrap">
					  <?php if(getTotalAmSiangOn($userclaim, $m, $y, 1)!='0') echo getTotalAmSiangOn($userclaim,$m, $y, 1)." j";?> <?php if(getTotalAmSiangOn($userclaim,$m, $y, 2)!='00') echo getTotalAmSiangOn($userclaim, $m, $y, 2)." m";?>
                      </td>
                      
                      <td class="line_l line_r" align="center" valign="middle" nowrap="nowrap">
					  <?php if(getTotalAmMalamOn($userclaim, $m, $y, 1)!='0') echo getTotalAmMalamOn($userclaim,$m, $y, 1)." j";?> <?php if(getTotalAmMalamOn($userclaim,$m, $y, 2)!='00') echo getTotalAmMalamOn($userclaim, $m, $y, 2)." m";?>
                      </td>
                      <td class="line_l" align="center" valign="middle" nowrap="nowrap">&nbsp;</td>
                      <td nowrap="nowrap">&nbsp;</th>
                </tr>
                <tr>
                  <td colspan="11" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_claim ?> rekod dijumpai</td>
                </tr>
                <?php } else{ ?>
                <tr>
                  <td align="center" valign="middle" class="txt_color1 noline">Tiada rekod dijumpai</td>
                </tr>
                <?php };?>
             </table>
             </div>
           </li> 
           <?php } else { ?>
           <li>
          	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="middle" class="noline txt_line">Tiada rekod dijumpai.<br />Sila pastikan Satf ID yang dimasukkan adalah betul</td>
              </tr>
           </table>
           </li>
           <?php }; ?>
           <?php } else { ?>
           <li>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" class="noline"><?php echo noteError(0);?></td>
            </tr>
          </table>
          </li>
        <?php };?>
       </ul>
     </div>
     </div>
     </div>       
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($claim);
?>
<?php include('../inc/footinc.php');?> 
                       

