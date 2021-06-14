<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='34';?>
<?php 
if(isset($_POST['y']))
	$y = htmlspecialchars($_POST['y'], ENT_QUOTES);
elseif(isset($_GET['y']))
	$y = htmlspecialchars($_GET['y'], ENT_QUOTES);
else
	$y = date('Y');

if(isset($_POST['id']))
	$usersalary = strtoupper($_POST['id']);
else if(isset($_GET['id']))
	$usersalary = getID($_GET['id'],0);
else
	$usersalary = $row_user['user_stafid'];
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
        <?php include('../inc/menu_ict.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            <li class="form_back">
              <form id="formcheckstaf" name="formcheckstaf" method="post" action="salaryyearlist.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td nowrap="nowrap" class="label">Staf ID</td>
                    <td width="100%">
                    <input name="id" type="text" class="w30" id="id" value="<?php echo $usersalary;?>" list="datastaf" />
                    <?php echo datalistStaf('datastaf');?>
                    <select name="y" id="y">
                    <?php for($i=2012; $i<=date('Y'); $i++){?>
                      <option <?php if($i==$y) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php }; ?>
                    </select>
                    <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
            		<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                    <td><input name="button3" type="button" class="submitbutton" id="button3" value="Senarai" onclick="MM_goToURL('parent','profilelist.php');return document.MM_returnValue" /></td>
                    <td align="left" valign="middle"><input name="button4" type="button" class="submitbutton" id="button4" value="Tahunan" onclick="MM_openBrWindow('salstatementyear.php?id=<?php echo $usersalary?>&y=<?php echo $y;?>','salary','status=yes,scrollbars=yes,width=800,height=600')" /></td>
                    <td><input name="button3" type="button" class="submitbutton" id="button3" value="Block" onclick="MM_goToURL('parent','salaryblock.php');return document.MM_returnValue" /></td>
                    <?php }; ?>
                  </tr>
                </table>
              </form>
            </li>
              <li class="gap">&nbsp;</li>
              <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic($usersalary);?></td>
                    <td class="label">Nama</td>
                    <td width="100%"><?php echo getFullNameByStafID($usersalary) . " (" . $usersalary . ")"; ?></td>
                  </tr>
                  <tr>
                    <td class="label noline">Lokasi</td>
                    <td class="noline"><?php echo getFulldirectoryByUserID($usersalary);?></td>
                  </tr>
                </table>
              </li>
              <li class="gap">&nbsp;</li>
              <li class="title">Penyata Gaji Tahunan</li>
              <li class="gap">&nbsp;</li>
              <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                    <th width="100%" align="left" valign="middle" nowrap="nowrap">Bulan</th>
                    <th align="center" valign="middle" nowrap="nowrap">Pendapatan</th>
                    <th align="center" valign="middle" nowrap="nowrap">Potongan</th>
                    <th align="center" valign="middle" nowrap="nowrap">Gaji Bersih</th>
                  </tr>
                  <?php 
				  $tpd =0; 
				  $tpt=0; 
				  $tgd =0; 
				  for($i=1; $i<=12; $i++){
					if($i<10) $i = '0' . $i;
					?>
                  <tr class="on <?php  if(checkSalaryBlockByUserID($usersalary, $i, $y)) echo "txt_color2";?>">
                    <td align="center" valign="middle"><?php  if(checkSalaryBlockByUserID($usersalary, $i, $y)) echo "<img src=\"" . $url_main . "icon/sign_error.png\"/>"?></td>
                    <td align="left" valign="middle"><a href="<?php echo $url_main;?>admin/salary.php?id=<?php echo $usersalary;?>&amp;bulan=<?php echo $i . "/" . $y;?>"><?php echo date('F Y', mktime(0, 0, 0, $i, 1, $y));?></a> </td>
                    <td align="center" valign="middle"><?php $tpd += getTotalSalaryByUserID($usersalary, 1, $i, $y); echo number_format(getTotalSalaryByUserID($usersalary, 1, $i, $y), 2);?></td>
                    <td align="center" valign="middle"><?php $tpt += getTotalCutByUserID($usersalary, 1, $i, $y); echo number_format(getTotalCutByUserID($usersalary, 1, $i, $y), 2);?></td>
                    <td align="center" valign="middle"><?php $tgd += getGajiBersihByUserID($usersalary, 1, $i, $y); echo number_format(getGajiBersihByUserID($usersalary, 1, $i, $y), 2);?></td>
                  </tr>
                  <?php }; ?>
                  <tr class="back_lightgrey">
                    <td align="center" valign="middle" class="line_t line_b">&nbsp;</td>
                    <td align="left" valign="middle" class="line_t line_b"><strong>Jumlah</strong></td>
                    <td align="center" valign="middle" class="line_t line_b"><strong><?php echo number_format($tpd, 2);?></strong></td>
                    <td align="center" valign="middle" class="line_t line_b"><strong><?php echo number_format($tpt, 2);?></strong></td>
                    <td align="center" valign="middle" class="line_t line_b"><strong><?php echo number_format($tgd, 2);?></strong></td>
                  </tr>
                </table>
              </li>
              <li class="gap">&nbsp;</li>
              <?php } else { ?>
              <li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" valign="middle" class="noline">Tiada rekod dijumpai / Staf ID tidak aktif.</td>
                </tr>
              </table>
              </li>
            <?php } ; ?>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php include('../inc/footinc.php');?> 