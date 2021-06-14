<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='59';?>
<?php $menu3='3';?>
<?php

$y = date('Y');

$stafid = "-1";
if(isset($_GET['lid']))
{
	$stafid = $_GET['lid'];
}

mysql_select_db($database_skt, $skt);
$query_work = "SELECT user_work.*, pp.pp_ppp FROM skt.user_work LEFT JOIN skt.pp ON pp.user_stafid = user_work.user_stafid WHERE pp_ppp = '" . $row_user['user_stafid'] . "' AND user_work.user_stafid = '" . $stafid . "' AND uw_date_y = '" . $y . "' AND user_work.uw_status = 1";
$work = mysql_query($query_work, $work) or die(mysql_error());
$row_work = mysql_fetch_assoc($work);
$totalRows_work = mysql_num_rows($work);
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
             <?php include('../inc/menu_senaraiskt.php');?>
          <ul>
            <?php if(checkPPPByStafID($row_user['user_stafid']) && getPPPByStafID($stafid) == $row_user['user_stafid']){?>
            <li>
            <div class="note"><strong>Bahagian III - Penghasilan Kerja</strong></div>
               <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" valign="top" class="icon_pad1"><?php echo viewProfilePic($stafid);?></td>
                    <td width="100%" class="txt_line">
                      <div>Profil Pegawai Yang Dinilai (PYD)</div>
					  <div class="txt_size3"><strong><?php echo getFullNameByStafID($stafid) . " (" . $stafid . ")";?></strong></div>
                      <div><span class="txt_color1"><?php echo getJobtitle($stafid) . ", "; ?><?php echo getFulldirectoryByUserID($stafid);?></span></div>
                      <div class="txt_color1">Email : <?php echo getEmailISNByUserID($stafid);?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID($stafid);?></div>
                    </td>
                  </tr>
              </table> 
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th width="50%">KRITERIA</th>
                        <th valign="middle">PPP</th>
                        <th valign="middle">PPK</th>
                        </tr>
                        <tr>
                        <td width="50"><strong>KUANTITI HASIL KERJA</strong><br />Kuantiti hasil kerja seperti jumlah, bilangan, kadar, kekerapan dan sebagainya berbanding dengan sasaran kuantiti kerja yang ditetapkan.</td>
                        <td><?php if($row_uw['uw_ppp1']==NULL){?>
                        <select name="uw_ppp1">
                        <option value="0">Sila Pilih</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        </select>
                         <?php } else echo $row_uw['uw_ppp1'];?></td>
                        <td><?php if($row_uw['uw_ppk1']==NULL){?><?php echo '-';?>
                        <?php } else echo $row_uw['uw_ppk1'];?></td>
                       </tr>
                        <tr>
                        <td width="50"><strong>KUALITI HASIL KERJA</strong><br />
                          Dinilai dari segi kesempurnaan, teratur dan kemas.</td>
                         <td><?php if($row_uw['uw_ppp2']==NULL){?>
                         <select name="uw_ppp2">
                        <option value="0">Sila Pilih</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        </select>
                        <?php } else echo $row_uw['uw_ppp2'];?></td>
                         <td><?php if($row_uw['uw_ppk2']==NULL){?><?php echo '-';?>
                        <?php } else echo $row_uw['uw_ppk2'];?></td>
                       </tr>
                        <tr>
                        <td width="50">Dinilai dari segi usaha dan inisiatif untuk mencapai kesempurnaan hasil kerja.</td>
                         <td><?php if($row_uw['uw_ppp3']==NULL){?>
                         <select name="uw_ppp3">
                        <option value="0">Sila Pilih</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        </select>
                        <?php } else echo $row_uw['uw_ppp3'];?></td>
                         <td><?php if($row_uw['uw_ppk3']==NULL){?>
                         <?php echo '-';?>
                       <?php } else echo $row_uw['uw_ppk3'];?></td>
                       </tr>
                        <tr>
                        <td width="50"><strong>KETEPATAN MASA</strong><br />
                          Kebolehan menghasilkan kerja atau melaksanakan tugas dalam tempoh masa yang ditetapkan.</td>
                         <td><?php if($row_uw['uw_ppp4']==NULL){?>
                         <select name="uw_ppp4">
                        <option value="0">Sila Pilih</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        </select>
                        <?php } else echo $row_uw['uw_ppp4'];?></td>
                         <td><?php if($row_uw['uw_ppk4']==NULL){?><?php echo '-';?>
                        <?php } else echo $row_uw['uw_ppk4'];?></td>
                       </tr>
                        <tr>
                        <td width="50"><strong>KEBERKESANAN HASIL KERJA</strong><br />
                          Dinilai dari segi memenuhi kehendak 'stake-holder' atau pelanggan.</td>
                         <td><?php if($row_uw['uw_ppp5']==NULL){?>
                         <select name="uw_ppp5">
                        <option value="0">Sila Pilih</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        </select>
                        <?php } else echo $row_uw['uw_ppp5'];?></td>
                         <td><?php if($row_uw['uw_ppk5']==NULL){?>
                         <?php echo '-';?>
                        <?php } else echo $row_uw['uw_ppk5'];?></td>
                       </tr>
                        </table>
            <?php } else { ?>
           	  <li>
           	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
               	    <tr>
               	      <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
           	      </tr>
           	    </table>
              </li>
            <?php }; ?>
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
mysql_free_result($work);
?>
<?php include('../inc/footinc.php');?> 