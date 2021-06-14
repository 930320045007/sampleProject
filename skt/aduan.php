<?php require_once('../Connections/hrmsdb.php'); ?>

<?php require_once('../Connections/skt.php'); ?>

<?php include('../inc/user.php');?>

<?php include('../inc/func.php');?>

<?php include('../inc/sktfunc.php');?>

<?php $menu='15';?>

<?php $menu2='111';?>

<?php

if(isset($_GET['y']))

	$y = htmlspecialchars($_GET['y'], ENT_QUOTES);

else

	$y = date('Y');

	

mysql_select_db($database_skt, $skt);

$query_uskt = "SELECT * FROM user_skt WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND uskt_status = 1 AND uskt_date_y = '" . $y . "' ORDER BY uskt_masa_mula ASC, uskt_masa_tamat ASC, uskt_id ASC";

$uskt = mysql_query($query_uskt, $skt) or die(mysql_error());

$row_uskt = mysql_fetch_assoc($uskt);

$totalRows_uskt = mysql_num_rows($uskt);



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

      	<?php include('../inc/menu_skt.php');?>

      	  <div class="tabbox">

        	<div class="profilemenu">

            <ul>
              <li class="form_back"></li>
            </ul>
            <ul>
              
              <li class="title">Sistem Aduan Intergriti (SAI) </li>
              </ul>
            <p>&nbsp;</p>
            <ul>
              <li>Sistem Aduan Intergriti (SAI) Institut Sukan Negara (ISN) merupakan saluran untuk warga ISN menyalurkan maklumat atau aduan berkaitan perlakuan jenayah rasuah, penyelewengan, salah guna kuasa atau pelanggaran tatakelakuan dan etika organisasi. Sistem Aduan Intergrasi (SAI) akan menapis, memproses, meneliti dan menilai maklumat atau aduan yang di terima sebelum tindakan selanjutnya. Sila muat turun maklumat sepenuhnya melalui pautan berikut :</li>
              </ul>
            <p>&nbsp;</p>
            <ul>
              <li> </li>
            </ul>
            <tr>
            
            
             <td width="100%" nowrap="nowrap">-- <a href="SISTEMADUAN.pdf" target="_blank"><strong>LAMPIRAN SISTEM ADUAN INTERGRITI (SAI)</strong> --</a></td></tr>
                  	</p>
            <ul>
              <li></li>
              
              <li class="title">Aduan Intergriti </li>
              
              <li>
                
                <div class="note">Perhatian:-</div>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  
                  <tr>
                  <td colspan="2">1. Borang Aduan boleh dimuat turun melalui pautan berikut:-</td></tr>
                  
                  <?php if(getGredByStafID($row_user['user_stafid'])>='7JUSA' && getGredByStafID($row_user['user_stafid'])<='7JUSA') { ?>
                  
                  <tr>
                    
                    
                    <td><img src="../icon/download.png" alt="Lampiran" title="Lampiran"/></td>
                    
                  <td width="100%" nowrap="nowrap">-- <a href="BorangAduan.pdf" target="_blank"><strong>Borang Aduan</strong> --</a></td></tr>
                  
                  
                  
                  <?php };

                 if(getGredByStafID($row_user['user_stafid'])>='41' && getGredByStafID($row_user['user_stafid'])<='54') {?>
                  
                  
                  <td><img src="../icon/download.png" alt="Lampiran" title="Lampiran"/></td>
                    
                    <td width="100%" nowrap="nowrap">-- <a href="BorangAduan.pdf" target="_blank"><strong>Borang Aduan</strong> --</a></td></tr>
                  
                  
                  
                  <?php };

                 if(getGredByStafID($row_user['user_stafid'])>='17' && getGredByStafID($row_user['user_stafid'])<='38') {?>
                  
                  <tr>
                    
                    
                    
                    <td><img src="../icon/download.png" alt="Lampiran" title="Lampiran"/></td>
                    
                  <td width="100%" nowrap="nowrap">-- <a href="BorangAduan.pdf" target="_blank"><strong> Borang Aduan</strong> --</a></td></tr>
                  
                  <?php };

                 if(getGredByStafID($row_user['user_stafid'])>='1' && getGredByStafID($row_user['user_stafid'])<='16') {?>
                  
                  <tr><td><img src="../icon/download.png" alt="Lampiran" title="Lampiran"/></td> <td width="100%" nowrap="nowrap">-- <a href="BorangAduan.pdf" target="_blank"><strong>Borang Aduan</strong> --</a></td></tr>
                  
                  <?php };?>
                  
                  <tr>
                  <td colspan="2">2. Maklum balas berkaitan borang aduan boleh berhubung dengan Unit Prestasi dan Tatatertib.</td></tr>
                  
                </table>
                
              </li>
              
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

mysql_free_result($uskt);

?>

<?php include('../inc/footinc.php');?> 