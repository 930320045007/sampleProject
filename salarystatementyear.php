<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='2';?>
<?php $menu2='36';?>
<?php

if(isset($_POST['y']))
{
	$y = htmlspecialchars($_POST['y'], ENT_QUOTES);
} else {
	$y = date('Y');
}

$usersalary = $row_user['user_stafid'];

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jadual = "SELECT salarysch_d, salarysch_m, salarysch_y FROM www.salary_sch WHERE salarysch_status = 1 GROUP BY salarysch_y ORDER BY salarysch_y DESC, salarysch_m DESC LIMIT 5";
$jadual = mysql_query($query_jadual, $hrmsdb) or die(mysql_error());
$row_jadual = mysql_fetch_assoc($jadual);
$totalRows_jadual = mysql_num_rows($jadual);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
</head>
<body <?php include('inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('inc/header.php');?>
        <?php include('inc/menu.php');?>
        
      	<div class="content">
        <?php include('inc/menu_profail.php');?>
        <div class="tabbox">        	
        <?php include('inc/profile.php');?>
        <div class="profilemenu">
            <ul>
                <li class="title">Penyata Gaji Tahunan</li>
            </ul>
          </div> 
          <?php if(checkWaris($row_user['user_stafid']) && checkEdu($row_user['user_stafid']) && checkAddressByStafID($row_user['user_stafid']) && checkTelMByStafID($row_user['user_stafid']) && checkAccBankByUserID($row_user['user_stafid']) && checkBankByUserID($row_user['user_stafid']) && checkPERKESOByUserID($row_user['user_stafid']) && checkKWSPByUserID($row_user['user_stafid']) && !$maintenance){?>
        <div class="profilemenu">
          	<ul>
                <li class="form_back">
                  <form id="form1" name="form1" method="post" action="salarystatementyear.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tahun</td>
                        <td width="100%" align="left" valign="middle">
                          <select name="y" id="y">
                            <?php
							do {  
							?>
                            <option <?php if($y == $row_jadual['salarysch_y']) echo "selected=\"selected\"";?> value="<?php echo $row_jadual['salarysch_y']?>"><?php echo date('Y', mktime(0, 0, 0, $row_jadual['salarysch_m'], $row_jadual['salarysch_d'], $row_jadual['salarysch_y']));?></option>
                            <?php
								} while ($row_jadual = mysql_fetch_assoc($jadual));
								  $rows = mysql_num_rows($jadual);
								  if($rows > 0) {
									  mysql_data_seek($jadual, 0);
									  $row_jadual = mysql_fetch_assoc($jadual);
								  }
								?>
                          </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" />
                        </td>
			 <?php if(date('m')>=1 || date('m')<=4) { ?>
                        <td align="left" valign="middle"><input name="button4" type="button" class="submitbutton" id="button4" value="EC" onclick="MM_openBrWindow('<?php echo $url_main;?>pcbstatement.php?y=<?php echo $y;?>','pcb','status=yes,scrollbars=yes,width=800,height=600')" /></td> 
                       <?php };?>
                        <td align="left" valign="middle"><input name="button6" type="button" class="submitbutton" id="button6" value="Bulanan" onclick="MM_goToURL('parent','salarystatement.php');return document.MM_returnValue" /></td>
                        <td align="left" valign="middle"><input name="button4" type="button" class="submitbutton" id="button4" value="Cetak" onclick="MM_openBrWindow('<?php echo $url_main;?>salarystatementdetail.php?y=<?php echo $y;?>','salary','status=yes,scrollbars=yes,width=800,height=600')" /></td>
                      </tr>
                    </table>
                  </form>
              </li>
            </ul>
            </div>
          </div> 
        <div class="tabbox profilemenu">
       	  <ul>
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
				
				if(date('Y')==$y)
					$limit = date('m');
				else
					$limit = 12;
					
                for($i=1; $i<=$limit; $i++){
                  if($i<10) $i = '0' . $i;
                  ?>
                <tr class="on <?php  if(checkSalaryBlockByUserID($usersalary, $i, $y)) echo "txt_color2";?>">
                  <td align="center" valign="middle"><?php  if(checkSalaryBlockByUserID($usersalary, $i, $y)) echo "<img src=\"" . $url_main . "icon/sign_error.png\"/>"?></td>
                  <td align="left" valign="middle"><?php echo date('F Y', mktime(0, 0, 0, $i, 1, $y));?></td>
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
          </ul>
        </div>
        </div>
            
          <?php } else { ?>
          
        <div class="profilemenu">
			<ul>
          	<?php if(!checkAccBankByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>No. Akaun Bank</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkBankByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>Nama Bank</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkKWSPByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>No. KWSP</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkPERKESOByUserID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; &sup1; Sila kemaskini maklumat <strong>No. PERKESO</strong> dalam <strong>Modul Profil > Penjawatan</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; if(!checkAddressByStafID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>Alamat Terkini</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; if(!checkTelMByStafID($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>No. Tel (Mobile)</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
            <?php }; if(!checkWaris($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>Waris / Rujukan Kecemasan</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; if(!checkEdu($row_user['user_stafid'])){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sila kemaskini maklumat <strong>Rekod Pendidikan</strong> dalam <strong>Modul Profil > Asas</strong> terlebih dahulu sebelum menggunakan Modul Cuti.</div></li>
          	<?php }; if($maintenance){?>
          	<li class="line_b"><div class="note"><img src="icon/sign_error.png" width="16" height="16" alt="Error" /> &nbsp; &nbsp; Sistem dalam proses pengemaskinian dan penambahbaikkan buat sementara waktu.</div></li>
          	<?php }; ?>
			</ul>
          </div>
          <?php } ?>
        </div>
        </div>
		<?php include('inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($jadual);
?>
<?php include('inc/footinc.php');?>
