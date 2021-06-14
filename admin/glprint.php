<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='117';?>
<?php
  if(isset($_GET['id']))
	  $id = getID($_GET['id'],0);
  else
	  $id = 0;
	  
  mysql_select_db($database_hrmsdb, $hrmsdb);
  // $query_gl = "SELECT * FROM user_gl WHERE usergl_id = '" . $id . "' AND usergl_status = 1 LIMIT 1";
  $query_gl = "SELECT user_gl.*, hospital.hospital_name, hospital.state_id FROM user_gl INNER JOIN hospital WHERE hospital.hospital_id = user_gl.usergl_hospital AND usergl_id = '" . $id . "' AND usergl_status = 1 LIMIT 1";
  $gl = mysql_query($query_gl, $hrmsdb) or die(mysql_error());
  $row_gl = mysql_fetch_assoc($gl);
  $totalRows_gl = mysql_num_rows($gl);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/printgl.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">
<div style="margin-left:25px; margin-right:25px">
  <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
  		<font size="5">
        
      <!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <br /><br /><br /><br /><br /><br /><br />
        </tr>
        <tr>
          <td align="left" valign="top" nowrap="nowrap" style="padding-left: 800px;">Ruj. Kami : <?php echo $row_gl['usergl_ref'];?> <br /></td>
        </tr>
        <tr> 
          <td colspan="1" align="left" valign="top" nowrap="nowrap"> Tarikh&nbsp; &nbsp; &nbsp; &nbsp; : <?php echo date('d/m/Y', strtotime($row_gl["usergl_refdate"]));?> <br /></td>
        </tr>
        <tr>
          <td class="" colspan="3" font-size: 15px>SILA SEBUTKAN RUJUKAN JABATAN INI APABILA MENJAWAB <br /><br /></td>   
        </tr>
        <tr>
          <td class="" colspan="3"><strong>SURAT PENGESAHAN DIRI DAN PENGAKUAN PEGAWAI</strong><br /><br />
            <strong><?php echo nl2br ($row_gl['usergl_hospital'], ENT_QUOTES); ?></strong><br /><br />
           </td>
        </tr>
        <tr>
          <td colspan="3"><strong>Tuan,</strong><br /><br /></td>
        </tr>
        <tr>
          <td colspan="3">Dengan ini disahkan bahawa penama di bawah adalah seorang pegawai Kerajaan di pejabat ini:<br /><br /></td>
        </tr>
      </table> -->

    <div>
      <table style="width:1300px; table-layout:fixed;" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <br /><br /><br /><br /><br /><br /><br /><br />
        </tr>
        <tr>
          <td style="width:60%; font-size:20px;"><strong>SILA SEBUTKAN RUJUKAN JABATAN INI APABILA MENJAWAB</strong></td>
          <td style="width:40%; font-size:21px;" valign="top" nowrap="nowrap">Ruj. Kami&nbsp; : <strong> <?php echo $row_gl['usergl_ref'];?></strong><br /></td> 
        </tr>
        <tr>
          <td style="width:70%;">&nbsp;</td>
          <td style="width:30%; font-size:21px;" valign="top" nowrap="nowrap">Tarikh&nbsp; &nbsp; &nbsp; &nbsp; : <strong><?php echo date('d/m/Y', strtotime($row_gl["usergl_refdate"]));?></strong><br /><br /><br /><br />
        </tr>
        <tr>
          <td style="width:100%;" valign="top" nowrap="nowrap"><strong>SURAT PENGESAHAN DIRI DAN PENGAKUAN PEGAWAI</strong><br /><br /></td> 
        </tr>
        <tr>
          <td style="width:100%; font-size:21px;" valign="top" nowrap="nowrap"><strong><?php echo nl2br($row_gl['hospital_name'], ENT_QUOTES); echo ", ".getState($row_gl['state_id']);?></strong><br /><br /></td> 
        </tr>
        <tr>
          <td style="width:100%;" valign="top" nowrap="nowrap"><strong>Tuan,</strong><br /><br /></td> 
        </tr>
        <tr>
          <td style="width:100%;" valign="top" nowrap="nowrap">Dengan ini disahkan bahawa penama di bawah adalah seorang pegawai Kerajaan di pejabat ini:<br /><br /></td> 
        </tr>
      </table>
    </div>
      
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo" >
        <tr>
          <td nowrap="nowrap"><strong>&nbsp; &nbsp;&nbsp;&nbsp; Nama Pegawai</td><td>:</td>
          <td width="100%" class="" style="font-size:20px"><strong><?php echo getFullNameByStafIDkew8($row_gl['user_stafid']); ?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap"><strong>&nbsp; &nbsp;&nbsp;&nbsp; No Kad Pengenalan</td><td>:</td>
          <td class="" style="font-size:20px"><strong><?php echo getICNoByStafID($row_gl['user_stafid']) ;?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class=""><strong>&nbsp; &nbsp;&nbsp;&nbsp; Jawatan</td><td>:</td>
          <td class="" style="font-size:20px"><strong><?php echo getJobtitleReal($row_gl['user_stafid']) ;?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class=""><strong>&nbsp; &nbsp;&nbsp;&nbsp; Gred Gaji</td><td>:</td>
          <td class="" style="font-size:20px"><strong><?php echo getGred($row_gl['user_stafid']);?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class=""><strong>&nbsp; &nbsp;&nbsp;&nbsp; No Pekerja</td><td>:</td>
          <td class="" style="font-size:20px"><strong><?php echo adjustID($row_gl['user_stafid']);?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class=""><strong>&nbsp; &nbsp;&nbsp;&nbsp; Gaji Pokok</td><td>:</td>
          	
          <td class="" style="font-size:20px"><strong>RM<?php echo $row_gl['usergl_salary'];?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class=""><strong>&nbsp; &nbsp;&nbsp;&nbsp; Kelayakan Kelas Wad</td><td>:</td>
          <td class="" style="font-size:20px"><strong><?php echo $row_gl['usergl_salaryskill'];?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class="" valign="top"><strong>&nbsp; &nbsp;&nbsp;&nbsp; Alamat Pejabat </td><td valign="top">:</td>
          <td class="" style="font-size:20px"><strong><?php echo nl2br  ($row_gl['usergl_pejabat'], ENT_QUOTES); ?></strong></td>
        </tr>
  </table>

  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
          <td colspan="3"><br /> 2.&nbsp; &nbsp; &nbsp;&nbsp; Pegawai berkenaan/isteri/suami/ibu/bapa/anak** pegawai berkenaan seperti butir-butir di bawah memerlukan rawatan.<br /><br /></td>
        </tr>
    </table>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
   
        <tr>
          <td nowrap="nowrap"><strong>&nbsp; &nbsp;&nbsp;&nbsp; Nama </td>
          <td width="100%" class="" style="font-size:20px"><strong>: <?php echo (strtoupper($row_gl['usergl_name']));?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class=""><strong>&nbsp; &nbsp;&nbsp;&nbsp; No Kad Pengenalan</td>
          <td class="" style="font-size:20px"><strong>: <?php echo $row_gl['usergl_ic'];?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class=""><strong>&nbsp; &nbsp;&nbsp;&nbsp; Perhubungan Keluarga</td>
          <td class="" style="font-size:20px"><strong>: <?php echo (strtoupper (getGL8NameByID($row_gl['relationship_id'])));?></strong></td>
        </tr>
       
  </table>
  
    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
    	<tr>
          <td colspan="3"><br /> 3.&nbsp; &nbsp; &nbsp;&nbsp; Jabatan ini bersetuju akan memotong dari gaji pegawai ini bagi menjelaskan bil hospital untuk rawatan berkenaan.<br /></td>
        </tr>
    </table>
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
       
       <tr>
        <td>
          <br /><br /><br />
          <p style="text-align:center; font-size:12px"><i>"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"</p></i>
          <br /><br /><br />
        </td>
       </tr>
        <!-- <tr>
          <td width="50%" align="left" valign="top" nowrap="nowrap" class=""><br /><br /><br />------------------------------------------------<br />
            <strong> &nbsp; &nbsp; &nbsp; (Tandatangan Ketua Jabatan) </strong><br /><br />
            Nama : <strong style="font-size:20px"><?php echo $row_gl['usergl_ketua'];?></strong><br />
            Jawatan : <strong style="font-size:20px"><?php echo $row_gl['usergl_jawatan'];?></strong><br />
            Telefon : <strong style="font-size:20px"><?php echo $row_gl['usergl_ketuaphone'];?></strong><br />
          	</td>
            <td width="50%" align="right" valign="top" nowrap="nowrap" class=""><br /><br /><br /><br /><br /><br /><br />------------------------------------------------<br />
            <strong>&nbsp; &nbsp; &nbsp; (Cop Rasmi Jabatan) &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;</strong><br />
            </td>
        </tr> -->
        
  </table>
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
       
        <tr>
          <td width="50%" align="left" valign="top" nowrap="nowrap" class=""><br />
        <br /><br /><br /><br />
          
        </td>
        </tr>
        
  </table>
  

  <!DOCTYPE html>
<html>
<head>
<style>
p.small {
  line-height: 0.7;
}

p.big {
  line-height: 1.8;

}
</style>
</head>
<body>







  <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
          <td colspan="3"><font size="5.5"> <strong>PERAKUAN PEGAWAI MEMBENAR POTONGAN GAJI BAGI MENJELASKAN BAYARAN BIL HOSPITAL ATAS RAWATAN YANG DITERIMA</strong><br /></font><br>
           </td><br />
        </tr>
        <?php 
          		setlocale(LC_MONETARY,"ms_MY");
          	?>
          
         <tr>
          <td colspan="3" align="justify" ><p class="big"><br />Saya &nbsp; <strong style="font-size:20px">  <?php echo getFullNameByStafID($row_gl['user_stafid']); ?>   </strong> &nbsp; yang sekarang menerima gaji pokok sebanyak &nbsp; <strong style="font-size:20px"> <?php echo $row_gl['usergl_salary'];?> </strong> &nbsp; di Kementerian/ Jabatan &nbsp; <strong style="font-size:20px"> MAJLIS SUKAN NEGARA MALAYSIA </strong> &nbsp;  bertanggungjawab menjelaskan bayaran yang dituntut dan dengan ini membenarkan dan memberikuasa kepada Ketua Jabatan memotong gaji saya bagi menjelaskan bayaran hospital yang dikenakan kerana rawatan ke atas diri saya/ahli keluarga/ibu/bapa**  saya seperti maklumat-maklumat berikut: <br /><br /></p></td>
        </tr>
        
   </table>
   
   </body>
</html>
   <table width="100%" border="0" cellspacing="10" cellpadding="0" class="tabinfo">

        <tr>
          <td nowrap="nowrap" class=""><strong>Nama </td>
          <td width="100%" class="" style="font-size:20px"><strong>: <?php echo (strtoupper($row_gl['usergl_name']));?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class=""><strong>No Gaji </td>
          <td class="" style="font-size:20px"><strong>: <?php echo adjustID($row_gl['user_stafid']);?></strong></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class=""><strong>Perhubungan Keluarga</td>
          <td class="" style="font-size:20px"><strong>: <?php echo (strtoupper (getGL8NameByID($row_gl['relationship_id'])));?></strong></td>
        </tr>
       
  </table>
  
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
       
        <tr>
          <td width="50%" align="left" valign="top" nowrap="nowrap" class="">
          <br /><br /><br />--------------------------------------------<br />
            &nbsp; &nbsp; &nbsp; &nbsp; <strong>(Tandatangan Pegawai) </strong><br /><br />
            <strong> No Kad Pengenalan : <?php echo getICNoByStafID($row_gl['user_stafid']) ;?><br />
          	</td>
 
        </tr>
        
        <tr>
          <td width="50%" align="left" valign="top" nowrap="nowrap" class=""><br /><br /><br />
      
            <strong>Catatan : </strong>Butir-butir di atas hendaklah diisi dengan lengkap. <br /><br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; * Tempoh laku surat ini ialah tiga (3) bulan daripada tarikh di atas. <br /><br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ** Potong mana-mana yang tidak berkenaan.
        
            </td>
        </tr>
        
        <tr>
          <td width="50%" align="left" valign="top" nowrap="nowrap" class=""><br /><br /><br /><font size="5.5">
            <strong> s.k : </strong> Unit Urusan Gaji (Alamat) : <strong style="font-size:20px">&nbsp; &nbsp; MAJLIS SUKAN NEGARA MALAYSIA <br />
            
            &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; BUKIT JALIL <br />
            &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; 57000 KUALA LUMPUR </strong><br /></font>
            </td>
        </tr>
        <tr>
            <td width="50%" align="left" valign="top" nowrap="nowrap" class=""><br /><br /><br />
            &nbsp; &nbsp; &nbsp; &nbsp; Fail Pegawai : <br />
            </td>
        </tr>
        <tr>
        <td>
          <br /><br /><br />
          <p style="text-align:center; font-size:12px"><i>"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"</p></i>
        </td>
       </tr>
  </table>
  
<?php } ; ?>
</div>
</body>
</html>
<?php
mysql_free_result($gl);
?>
<?php include('../inc/footinc.php');?> 