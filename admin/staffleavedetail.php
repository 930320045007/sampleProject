<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='23';?>
<?php
$colname_userprofile = "-1";


if (isset($_GET['id'])) {

  $colname_userprofile = getStafIDByUserID(getID($_GET['id'],0));

}


$dateyear = date('Y');


if(isset($_POST['tahun']) && $_POST['tahun']!=0)

	$dateyear = htmlspecialchars($_POST['tahun'], ENT_QUOTES);

	

mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cuti = "SELECT * FROM www.user_leave WHERE userleave_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND userleave_status = '1' AND userleave_year = '" . $dateyear . "' ORDER BY leavetype_id ASC, userleave_year DESC, userleave_month DESC, userleave_day DESC, userleave_id DESC";

$cuti = mysql_query($query_cuti, $hrmsdb) or die(mysql_error());

$row_cuti = mysql_fetch_assoc($cuti);

$totalRows_cuti = mysql_num_rows($cuti);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_usercuti = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND leavetype_id = '1'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

$usercuti = mysql_query($query_usercuti, $hrmsdb) or die(mysql_error());

$row_usercuti = mysql_fetch_assoc($usercuti);

$totalRows_usercuti = mysql_num_rows($usercuti);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutisakit = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND leavetype_id = '2'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

$cutisakit = mysql_query($query_cutisakit, $hrmsdb) or die(mysql_error());

$row_cutisakit = mysql_fetch_assoc($cutisakit);

$totalRows_cutisakit = mysql_num_rows($cutisakit);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutitanparekod = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND leavetype_id = '4'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

$cutitanparekod = mysql_query($query_cutitanparekod, $hrmsdb) or die(mysql_error());

$row_cutitanparekod = mysql_fetch_assoc($cutitanparekod);

$totalRows_cutitanparekod = mysql_num_rows($cutitanparekod);


if(getGenderIDByUserID($colname_userprofile)==2){

	mysql_select_db($database_hrmsdb, $hrmsdb);

	$query_cutibersalin = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND leavetype_id = '5' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

	$cutibersalin = mysql_query($query_cutibersalin, $hrmsdb) or die(mysql_error());

	$row_cutibersalin = mysql_fetch_assoc($cutibersalin);

	$totalRows_cutibersalin = mysql_num_rows($cutibersalin);

}

mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutiseparuhgaji = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND leavetype_id = '10'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

$cutiseparuhgaji = mysql_query($query_cutiseparuhgaji, $hrmsdb) or die(mysql_error());

$row_cutiseparuhgaji = mysql_fetch_assoc($cutiseparuhgaji);

$totalRows_cutiseparuhgaji = mysql_num_rows($cutiseparuhgaji);

mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutitanpagaji = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND leavetype_id = '6'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

$cutitanpagaji = mysql_query($query_cutitanpagaji, $hrmsdb) or die(mysql_error());

$row_cutitanpagaji = mysql_fetch_assoc($cutitanpagaji);

$totalRows_cutitanpagaji = mysql_num_rows($cutitanpagaji);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutimelebihikelayakkan = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND leavetype_id = '7'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

$cutimelebihikelayakkan = mysql_query($query_cutimelebihikelayakkan, $hrmsdb) or die(mysql_error());

$row_cutimelebihikelayakkan = mysql_fetch_assoc($cutimelebihikelayakkan);

$totalRows_cutimelebihikelayakkan = mysql_num_rows($cutimelebihikelayakkan);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutikhas = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND leavetype_id = '8'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

$cutikhas = mysql_query($query_cutikhas, $hrmsdb) or die(mysql_error());

$row_cutikhas = mysql_fetch_assoc($cutikhas);

$totalRows_cutikhas = mysql_num_rows($cutikhas);

mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutikuarantin = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND leavetype_id = '11'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

$cutikuarantin = mysql_query($query_cutikuarantin, $hrmsdb) or die(mysql_error());

$row_cutikuarantin = mysql_fetch_assoc($cutikuarantin);

$totalRows_cutikuarantin = mysql_num_rows($cutikuarantin);


?>

<?php

if(getDesignationType($colname_userprofile)){

$secondyear = date('Y') - 2;


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_plc = "SELECT usplc_id, user_stafid, usplc_date_y, usplc_status, SUM(usplc_total) AS usplc_total FROM www.user_plc WHERE user_stafid = '" . $colname_userprofile . "' AND usplc_status = '1' GROUP BY user_stafid, usplc_date_y ORDER BY usplc_date_y DESC";

$plc = mysql_query($query_plc, $hrmsdb) or die(mysql_error());

$row_plc = mysql_fetch_assoc($plc);

$totalRows_plc = mysql_num_rows($plc);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_gcr = "SELECT uspgcr_id, SUM(uspgcr_total) AS uspgcr_total, uspgcr_date_y, user_stafid  FROM www.user_gcr WHERE user_stafid = '" . $colname_userprofile . "' AND uspgcr_status = '1' GROUP BY user_stafid, uspgcr_date_y ORDER BY uspgcr_date_y DESC";

$gcr = mysql_query($query_gcr, $hrmsdb) or die(mysql_error());

$row_gcr = mysql_fetch_assoc($gcr);

$totalRows_gcr = mysql_num_rows($gcr);

}

?>

<?php

mysql_select_db($database_hrmsdb, $hrmsdb);

$query_lt = "SELECT * FROM www.leave_type WHERE leavetype_view = 1 AND leavetype_status = 1 ORDER BY leavetype_name ASC";

$lt = mysql_query($query_lt, $hrmsdb) or die(mysql_error());

$row_lt = mysql_fetch_assoc($lt);

$totalRows_lt = mysql_num_rows($lt);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutikategori = "SELECT * FROM www.leave_category WHERE leavetype_id = 4 ORDER BY leavecategory_name ASC";

$cutikategori = mysql_query($query_cutikategori, $hrmsdb) or die(mysql_error());

$row_cutikategori = mysql_fetch_assoc($cutikategori);

$totalRows_cutikategori = mysql_num_rows($cutikategori);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutikategori2 = "SELECT * FROM www.leave_category WHERE leavetype_id = 5 ORDER BY leavecategory_name ASC";

$cutikategori2 = mysql_query($query_cutikategori2, $hrmsdb) or die(mysql_error());

$row_cutikategori2 = mysql_fetch_assoc($cutikategori2);

$totalRows_cutikategori2 = mysql_num_rows($cutikategori2);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutikategori3 = "SELECT * FROM www.leave_category WHERE leavetype_id = 6 ORDER BY leavecategory_name ASC";

$cutikategori3 = mysql_query($query_cutikategori3, $hrmsdb) or die(mysql_error());

$row_cutikategori3 = mysql_fetch_assoc($cutikategori3);

$totalRows_cutikategori3 = mysql_num_rows($cutikategori3);


mysql_select_db($database_hrmsdb, $hrmsdb);


$query_cutikategori4 = "SELECT * FROM www.leave_category WHERE leavetype_id = 1 ORDER BY leavecategory_name ASC";

$cutikategori4 = mysql_query($query_cutikategori4, $hrmsdb) or die(mysql_error());

$row_cutikategori4 = mysql_fetch_assoc($cutikategori4);

$totalRows_cutikategori4 = mysql_num_rows($cutikategori4);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutikategori5 = "SELECT * FROM www.leave_category WHERE leavetype_id = 7 ORDER BY leavecategory_name ASC";

$cutikategori5 = mysql_query($query_cutikategori5, $hrmsdb) or die(mysql_error());

$row_cutikategori5 = mysql_fetch_assoc($cutikategori5);

$totalRows_cutikategori5 = mysql_num_rows($cutikategori5);


mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutikategori6 = "SELECT * FROM www.leave_category WHERE leavetype_id = 8 ORDER BY leavecategory_name ASC";
$cutikategori6 = mysql_query($query_cutikategori6, $hrmsdb) or die(mysql_error());
$row_cutikategori6 = mysql_fetch_assoc($cutikategori6);
$totalRows_cutikategori6 = mysql_num_rows($cutikategori6);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutikategori10 = "SELECT * FROM www.leave_category WHERE leavetype_id = 10 ORDER BY leavecategory_name ASC";
$cutikategori10 = mysql_query($query_cutikategori10, $hrmsdb) or die(mysql_error());
$row_cutikategori10 = mysql_fetch_assoc($cutikategori10);
$totalRows_cutikategori10 = mysql_num_rows($cutikategori10);
mysql_select_db($database_hrmsdb, $hrmsdb);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cutikategori11 = "SELECT * FROM www.leave_category WHERE leavetype_id = 11 ORDER BY leavecategory_name ASC";
$cutikategori11 = mysql_query($query_cutikategori11, $hrmsdb) or die(mysql_error());
$row_cutikategori11 = mysql_fetch_assoc($cutikategori11);
$totalRows_cutikategori11 = mysql_num_rows($cutikategori11);
mysql_select_db($database_hrmsdb, $hrmsdb);

// cuti ganti
mysql_select_db($database_hrmsdb, $hrmsdb);

// $query_cutikategori12 = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND leavetype_id = '3'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

$query_cutikategori12 = "SELECT * FROM www.leave_category WHERE leavetype_id = 3 ORDER BY leavecategory_name ASC";
$cutikategori12 = mysql_query($query_cutikategori12, $hrmsdb) or die(mysql_error());
$row_cutikategori12 = mysql_fetch_assoc($cutikategori12);
$totalRows_cutikategori12 = mysql_num_rows($cutikategori12);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_cutikategori12 = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $colname_userprofile . "' AND leavetype_id = '3'  AND userleavedate_date_y = '" . $dateyear . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";

$cutikategori123 = mysql_query($query_cutikategori12, $hrmsdb) or die(mysql_error());


$totalRows_cutikategori123 = mysql_num_rows($cutikategori123);



$query_approvallist = "SELECT * FROM www.user_job2 LEFT JOIN www.login ON login.user_stafid = user_job2.user_stafid WHERE login.login_status = 1 AND userjob2_status = 1 AND jobss_id != 1 GROUP BY user_job2.user_stafid ORDER BY userjob2_id ASC";

$approvallist = mysql_query($query_approvallist, $hrmsdb) or die(mysql_error());

$row_approvallist = mysql_fetch_assoc($approvallist);

$totalRows_approvallist = mysql_num_rows($approvallist);


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_clinictype = "SELECT * FROM www.clinic_type ORDER BY clinictype_name ASC";

$clinictype = mysql_query($query_clinictype, $hrmsdb) or die(mysql_error());

$row_clinictype = mysql_fetch_assoc($clinictype);

$totalRows_clinictype = mysql_num_rows($clinictype);


mysql_select_db($database_tadbirdb, $tadbirdb);

$query_cli = "SELECT * FROM tadbir.clinic WHERE clinic_status = 1 ORDER BY clinic_name ASC";

$cli = mysql_query($query_cli, $tadbirdb) or die(mysql_error());

$row_cli = mysql_fetch_assoc($cli);

$totalRows_cli = mysql_num_rows($cli);
$count = 0;
$total = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
      <?php include('../inc/menu.php');?>
   	  <div class="content">
        <?php include('../inc/menu_admin.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li class="form_back">
                  <form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="noline label">Tahun</td>
                        <td width="100%" class="noline"><label for="tahun"></label>
                          <select name="tahun" id="tahun">
                          <?php for($i=(date('Y')+1); $i>=2011; $i--){?>
                            <option <?php if($i == $dateyear) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                          </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                        <td class="noline"><input name="button8" type="button" class="submitbutton" id="button8" value="Kenyataan Cuti" onclick="MM_goToURL('parent','staffleavestatement.php?id=<?php echo htmlspecialchars($_GET['id'],ENT_QUOTES);?>&y=<?php echo $dateyear;?>');return document.MM_returnValue" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                	&nbsp;
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic($colname_userprofile);?></td>
                	    <td class="label">Nama</td>
                	    <td width="100%"><div class="txt_line"><strong><?php echo getFullNameByStafID($colname_userprofile); ?></strong> (<?php echo $colname_userprofile;?>)<br/><?php echo getJobtitle($colname_userprofile);?> (<?php echo getGred($colname_userprofile); ?>)</div></td>
              	    </tr>
                	  <tr>
                	    <td class="label noline">Lokasi</td>
                	    <td class="noline"><?php echo getFulldirectoryByUserID($colname_userprofile);?></td>
              	    </tr>
           	      </table>
                	
                	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                	  <tr>
                	    <td class="icon_pad1"><img src="../icon/bag.png" width="48" height="48" alt="Cuti" /></td>
                	    <td>
                        	<div>Baki Cuti Rehat / Tahunan <?php if(getDesignationType($colname_userprofile)) echo " + Cuti Dibawa Kehadapan";?></div>
                            <div class="txt_size1"><?php echo countLeaveBalance($colname_userprofile, $dateyear);?> <span class="txt_size2">Hari</span></div>
                          <div>Maklumat Cuti Ganti                          </div><div class="txt_size1"><?php echo getTotalLeaveGanti($colname_userprofile, $dateyear)-getTotalLeaveGantiUse($colname_userprofile, $dateyear)?> <span class="txt_size2">Hari</span></div></td>
                	    <td class="icon_pad1 line_l"><?php echo viewProfilePic(getHeadIDByUserID($colname_userprofile));?></td>
                	    <td>
                	      <div>Kelulusan cuti oleh</div>
                	      <div><strong><?php echo getFullNameByStafID(getHeadIDByUserID($colname_userprofile)) . " (" . getHeadIDByUserID($colname_userprofile) . ")";?></strong></div>
                	      <div><?php echo getFulldirectoryByUserID(getHeadIDByUserID($colname_userprofile));?></div>
               	        </td>
              	    </tr>
              	  </table>
              </li>
                <li class="title">Jumlah Peruntukan bagi Tahun <?php echo $dateyear;?> <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile != $row_user['user_stafid']){?><span class="fr add" onclick="toggleview2('formcuti'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?>
                <div id="formcuti" class="hidden">
                  <li>
                    <form id="formcuti" name="formcuti" method="post" action="<?php echo $url_main;?>sb/profile_admin.php?id=<?php echo $colname_userprofile;?>&url=edit">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Jenis</td>
                        <td colspan="3" width="100%">
                          <select name="leavetype_id" id="leavetype_id">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_lt['leavetype_id']?>"><?php echo $row_lt['leavetype_name']?></option>
                            <?php
							} while ($row_lt = mysql_fetch_assoc($lt));
							  $rows = mysql_num_rows($lt);
							  if($rows > 0) {
								  mysql_data_seek($lt, 0);
								  $row_lt = mysql_fetch_assoc($lt);
							  }
							?>
                          </select>
                        </td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Tahun</td>
                      <td nowrap="nowrap">
                      <select name="userleave_day" id="userleave_day">
                        <?php for($i=1; $i<=31; $i++){?>
                        <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                        <?php }; ?>
                        </select>
                      <span class="inputlabel">/</span>
                      <select name="userleave_month" id="userleave_month">
                        <?php for($j=1; $j<=12; $j++){?>
                        <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m M", mktime(0, 0, 0, $j, 1, 2000));?></option>
                        <?php }; ?>
                        </select>
                      <span class="inputlabel">/</span><input name="userleave_year" type="text" class="w25" id="userleave_year" value="<?php echo date('Y');?>" size="4" maxlength="4" />
                      </td>
                      <td valign="middle" nowrap="nowrap" class="label">Hari *</td>
                      <td class="w50"><span id="leave"> <span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="textfieldInvalidFormatMsg">Sila pastikan Format Hari dimasukkan dengan betul</span>
                        <input name="userleave_annual" type="text" class="w25 txt_right" id="userleave_annual" value="25" size="3" />
                        <span class="inputlabel"> hari</span></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kelulusan (Staf ID)</td>
                        <td nowrap="nowrap">
                            <select name="userleave_approvelby" id="userleave_approvelby">
                              <option value="0">Tiada</option>
                              <?php
                              do {  
                              ?>
                              <option value="<?php echo $row_approvallist['user_stafid'];?>"><?php echo getFullNameByStafID($row_approvallist['user_stafid'],1);?></option>
                              <?php
                                  } while ($row_approvallist = mysql_fetch_assoc($approvallist));
                                    $rows = mysql_num_rows($approvallist);
                                    if($rows > 0) {
                                        mysql_data_seek($approvallist, 0);
                                        $row_approvallist = mysql_fetch_assoc($approvallist);
                                    }
                                  ?>
                          </select>
                          <div class="inputlabel2">Sila isi sekiranya Cuti Ganti</div>
                        </td>
                        <td nowrap="nowrap" class="label">No Fail / Minit</td>
                        <td nowrap="nowrap">
                          <input type="text" name="userleave_nofail" id="userleave_nofail" />
                          <div class="inputlabel2">Sila isi sekiranya Cuti Ganti</div>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3" nowrap="nowrap" class="label"><input type="text" name="userleave_note" id="userleave_note" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline">&nbsp;</td>
                        <td colspan="3" nowrap="nowrap" class="label noline">
                          <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile; ?>" />
                          <input name="MM_insert_cuti" type="hidden" id="MM_insert_cuti" value="formcuti" />
                          <input name="button14" type="submit" class="submitbutton" id="button14" value="Tambah" />
                          <input name="button18" type="button" class="cancelbutton" id="button18" value="Batal" onclick="toggleview2('formcuti'); return false;"/>
                        </td>
                      </tr>
                    </table>
                  </form>
                  </li>
                  </div>
                  <?php }; ?>
                <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_cuti > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tamat</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>

                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                    </tr>
					<?php $i=1; do { ?>
                    <tr class="<?php if(!checkDatePast(getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 3), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 2), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'],1)) && $row_cuti['leavetype_id']==3) echo "offcourses"; else echo "on";?>">
                    <td class="<?php if(!checkDatePast(getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 3), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 2), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'],1)) && $row_cuti['leavetype_id']==3) echo "offcourses"; else echo "on";?>"><?php echo $i; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap" class="<?php if(!checkDatePast(getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 3), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 2), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'],1)) && $row_cuti['leavetype_id']==3) echo "offcourses"; else echo "on";?>"><?php if($row_cuti['leavetype_id']!='1'){?><?php echo $row_cuti['userleave_day']; ?>/<?php echo $row_cuti['userleave_month']; ?>/<?php }; ?><?php echo $row_cuti['userleave_year']; ?></td>
                    <td class="<?php if(!checkDatePast(getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 3), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 2), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'],1)) && $row_cuti['leavetype_id']==3) echo "offcourses"; else echo "on";?>"><?php echo getLeaveType($row_cuti['leavetype_id']); ?> &nbsp; <span class="txt_color1"><?php echo shortText($row_cuti['userleave_note']); ?><?php if($row_cuti['userleave_nofail']!=NULL) echo " &nbsp; &bull; &nbsp; No Fail : " . $row_cuti['userleave_nofail']; ?></span></td>
                    <td align="center" valign="middle" nowrap="nowrap" class="<?php if(!checkDatePast(getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 3), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'], 2), getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id'],1)) && $row_cuti['leavetype_id']==3) echo "offcourses"; else echo "on";?>"> &nbsp; <?php if($row_cuti['leavetype_id']==3) echo getLeaveEndDate($row_cuti['userleave_id'], $row_cuti['leavetype_id']); else echo "-";?> &nbsp; </td>
                    <td align="center" valign="middle" nowrap="nowrap" class="back_lightgrey"><?php echo $row_cuti['userleave_annual']; ?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo getLeaveType($row_cuti['leavetype_id']); ?> (<?php echo $row_cuti['userleave_annual']; ?> Hari) milik <?php echo getFullNameByStafID($row_cuti['user_stafid']);?>')" href="<?php echo $url_main;?>sb/del_userleaverestadmin.php?delul=<?php echo $row_cuti['userleave_id']; ?>&id=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                    </tr>
                    <?php $i++; } while ($row_cuti = mysql_fetch_assoc($cuti)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline line_t"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" nowrap="nowrap" class="back_lightgrey line_t"><strong><?php echo getTotalAllLeave($colname_userprofile,$dateyear);?></strong></td>
                      <td align="center" valign="middle" nowrap="nowrap" class="line_t">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cuti ?>  rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
               </div>
               <div class="note inputlabel2">Cuti Ganti hanya sah dalam tempoh tiga (3) bulan dari tarikh kelulusan</div>
                <?php if(getDesignationType($colname_userprofile)){?>
                <li class="title">GCR 
				<?php if(getDesignationType($colname_userprofile) && checkGCRLimit($colname_userprofile) && $colname_userprofile!=$row_user['user_stafid']){?> <?php //&& countLeaveBalance($colname_userprofile, $dateyear)>0){?>
                <span class="fr add" onClick="toggleview2('formgcr'); return false;">Tambah</span>
				<?php }; ?>
                </li>
                <?php if(getDesignationType($colname_userprofile) && checkGCRLimit($colname_userprofile) && $colname_userprofile!=$row_user['user_stafid']){?> <?php //&& countLeaveBalance($colname_userprofile, $dateyear)>0){?>
                <div id="formgcr" class="hidden">
                <li>
                  <form id="formgcr2" name="formgcr2" method="POST" action="../sb/add_gcr.php">
				  <div class="note"> Jumlah maksimum hari yang dibenarkan iaitu <strong><?php echo countGCRPLCLimit($colname_userprofile, $dateyear);?> Hari</strong> </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Tahun</td>
                        <td class="noline">
                          <select name="uspgcr_date_y" id="uspgcr_date_y">
                          <?php for($i=date('Y')-39; $i<=(date('Y')+2); $i++){?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                        </select></td>
                        <td nowrap="nowrap" class="label noline">Jumlah Hari</td>
                        <td width="100%" class="noline">
                        <input name="uspgcr_total" type="text" class="w25" id="uspgcr_total" value="<?php echo countGCRPLCLimit($colname_userprofile, $dateyear);?>" />
                        <input name="url" type="hidden" value="1" />
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        <input name="batal" type="button" class="cancelbutton" id="batal" value="Batal" onClick="toggleview2('formgcr'); return false;" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="formgcr2" />
                  </form>
                </li>
                </div>
          <?php }; ?>
              <?php if(countLeaveBalance($colname_userprofile, $dateyear)<=0){?>
              <li class="form_back">
              <div class="note txt_color2"><img src="<?php echo $url_main;?>icon/sign_error.png" alt="Error" width="16" height="16" align="absbottom" /> &nbsp; GCR tidak dibenarkan kerana tiada peruntukan Cuti Rehat / Tahunan.</div>
              </li>
              <?php }; ?>
                <li>
                <div class="note">Jumlah terkumpul tidak boleh melebihi <strong><?php echo getGCRLimit();?> hari</strong> sepanjang tempoh berkhidmat</div>
                <div class="off">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_gcr > 0) { // Show if recordset not empty ?>
<tr>
                  <th width="100%" align="left" nowrap="nowrap">Tahun</th>
                  <th align="center" nowrap="nowrap">Kiraan (Hari)</th>
                  <th align="center" nowrap="nowrap">&nbsp;</th>
              </tr>
                <?php do { ?>
                  <tr class="on">
                    <td nowrap="nowrap"><?php echo $row_gcr['uspgcr_date_y']; ?></td>
                    <td align="center" nowrap="nowrap" class="back_lightgrey"><?php echo $row_gcr['uspgcr_total']; ?></td>
                    <td align="center" nowrap="nowrap"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n Tahun <?php echo date('Y', mktime(0, 0, 0, 1, 1, $row_gcr['uspgcr_date_y'])); ?> sebanyak <?php echo $row_gcr['uspgcr_total'];?> Hari')" href="<?php echo $url_main;?>sb/del_gcr.php?delgcr=<?php echo $row_gcr['uspgcr_id']; ?>&uid=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                  </tr>
                  <?php } while ($row_gcr = mysql_fetch_assoc($gcr)); ?>
                <tr>
                  <td align="right" nowrap="nowrap" class="noline"><strong>Jumlah terkumpul</strong></td>
                  <td align="center" nowrap="nowrap" class="back_lightgrey line_t"><strong><?php echo countTotalGCR($colname_userprofile); ?></strong></td>
                  <td align="center" nowrap="nowrap" class="line_t">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="center" class="noline txt_color1"><?php echo $totalRows_gcr ?> rekod dijumpai</td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td colspan="3" align="center" class="noline">Tiada rekod dijumpai</td>
                </tr>
                <?php }; ?>
              </table>
              </div>
            <div class="note inputlabel2">Cuti Tahunan akan ditolak sekiranya GCR didaftarkan bagi tahun tersebut.</div>
              </li>
            	<li class="title">Cuti Dibawa Kehadapan <?php if(getDesignationType($colname_userprofile) && $colname_userprofile!=$row_user['user_stafid'] && countLeaveBalance($colname_userprofile, $dateyear)>0){?><span class="fr add" onClick="toggleview2('formplc'); return false;">Tambah</span><?php }; ?></li>
                <?php if(getDesignationType($colname_userprofile) && $colname_userprofile!=$row_user['user_stafid'] && countLeaveBalance($colname_userprofile, $dateyear)>0){?>
                <div id="formplc" class="hidden">
                <li>
                  <form id="formplc2" name="formplc2" method="POST" action="../sb/add_plc.php">
                  <?php $count = countLeaveBalance($colname_userprofile,$dateyear) - $row_gcr['uspgcr_total'];?>
                  <div class="note"> Jumlah maksimum hari yang dibenarkan iaitu <strong><?php echo $count;?> Hari</strong> </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Tahun</td>
                        <td class="noline">
                          <select name="usplc_date_y" id="usplc_date_y">
                          <?php for($i=date('Y')-2; $i<=(date('Y')+2); $i++){?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                        </select></td>
                        <td nowrap="nowrap" class="label noline">Jumlah Hari</td>
                        <td width="100%" class="noline">
                        <input name="usplc_total" type="text" class="w25" id="usplc_total" value="<?php echo $count;?>" />
                        <input name="url" type="hidden" value="1" />
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        <input name="batal" type="button" class="cancelbutton" id="batal" value="Batal" onClick="toggleview2('formplc'); return false;" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="formplc2" />
                  </form>
                </li>
                </div>
                <?php }; ?>
              <?php if(countLeaveBalance($colname_userprofile, $dateyear)<=0){?>
              <li class="form_back">
              <div class="note txt_color2"><img src="<?php echo $url_main;?>icon/sign_error.png" alt="Error" width="16" height="16" align="absbottom" /> &nbsp; Cuti Dibawa Kehadapan tidak dibenarkan kerana tiada peruntukan Cuti Rehat / Tahunan.
              </div>
              </li>
              <?php }; ?>
                <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_plc > 0) { // Show if recordset not empty ?>
<tr>
                  <th nowrap="nowrap">Tahun</th>
                  <th nowrap="nowrap">&nbsp;</th>
                  <th align="center" valign="middle" nowrap="nowrap">Tahun dikira</th>
                  <th width="100%" align="left" valign="middle" nowrap="nowrap">&nbsp;</th>
                      <th align="center" nowrap="nowrap">Kiraan (Hari)</th>
                      <th align="left" nowrap="nowrap">&nbsp;</th>
                  </tr>
                    <?php do { ?>
                      <tr class="<?php if($row_plc['usplc_date_y']>=$secondyear) echo "on"; else echo "offcourses";?>">
                        <td align="center"><?php echo $row_plc['usplc_date_y']; ?></td>
                        <td align="center"><span class="txt_size3">&rarr;</span></td>
                        <td align="center" valign="middle"><?php if($row_plc['usplc_date_y']==date('Y')) echo $row_plc['usplc_date_y'] + 1; else if($row_plc['usplc_date_y']<date('Y')) echo date('Y');?></td>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="center" nowrap="nowrap" class="back_lightgrey"><?php echo $row_plc['usplc_total']; ?> <?php if($row_plc['usplc_date_y']==date('Y')) echo "**"; else if($row_plc['usplc_date_y']<date('Y') && $row_plc['usplc_date_y']>=$secondyear) echo "*";?></td>
                        <td><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n Tahun <?php echo date('Y', mktime(0, 0, 0, 1, 1, $row_plc['usplc_date_y'])); ?> sebanyak <?php echo $row_plc['usplc_total'];?> Hari')" href="<?php echo $url_main;?>sb/del_plc.php?delplc=<?php echo $row_plc['usplc_id']; ?>&uid=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                      </tr>
                      <?php } while ($row_plc = mysql_fetch_assoc($plc)); ?>
                    <tr>
                      <td colspan="6" align="center" class="noline txt_color1"><?php echo $totalRows_plc ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                  <div class="note inputlabel2">* Cuti Tahunan <?php echo date('Y');?> ditambah.<br/>
                  ** Cuti Tahunan <?php echo date('Y');?> ditolak.</div>
              </li> 
                            <?php };?> 
        <li class="title">Permohonan Cuti Rehat / Tahunan <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid'] && countLeaveBalance($colname_userprofile, $dateyear)>0){?><span class="fr add" onclick="toggleview2('formcutiyear'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid'] && countLeaveBalance($colname_userprofile, $dateyear)>0){?>
                <div id="formcutiyear" class="hidden">
                	<li>
                	  <form id="form2" name="form2" method="POST" action="../sb/leave_admin.php">
                	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	      <tr>
                	        <td nowrap="nowrap" class="label">Tarikh</td>
                	        <td colspan="3"><select name="userleavedate_date_d" id="userleavedate_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                          <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                          <span class="inputlabel">/ </span>
                          <select name="userleavedate_date_m" id="userleavedate_date_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m M", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/ </span>
                          <input name="userleavedate_date_y" type="text" class="w25" id="userleavedate_date_y" value="<?php echo date('Y');?>" size="4" maxlength="4" /></td>
               	          </tr>
                	      <tr>
                	        <td nowrap="nowrap" class="label">No Fail</td>
                	        <td width="50%"><input name="userleavedate_nofail" type="text" class="w50" id="userleavedate_nofail" /></td>
                	        <td nowrap="nowrap" class="label">Kategori</td>
                	        <td width="50%">
                	          <select name="leavecategory_id" id="leavecategory_id">
                	            <?php
								do {  
								?>
                	            <option value="<?php echo $row_cutikategori4['leavecategory_id']?>"><?php echo $row_cutikategori4['leavecategory_name']?></option>
                	            <?php
								} while ($row_cutikategori4 = mysql_fetch_assoc($cutikategori4));
								  $rows = mysql_num_rows($cutikategori4);
								  if($rows > 0) {
									  mysql_data_seek($cutikategori4, 0);
									  $row_cutikategori4 = mysql_fetch_assoc($cutikategori4);
								  }
								?>
                            </select></td>
              	        </tr>
                        <tr>
                        	<td nowrap="nowrap" class="label">Catatan</td>
                            <td colspan="3">
                            <input type="text" name="userleavedate_note" id="userleavedate_note" /></td>
                        </tr>
                	      <tr>
                	        <td class="noline"><input name="leavetype_id" type="hidden" id="leavetype_id" value="1" />
                	          <input name="userleavedate_app" type="hidden" id="userleavedate_app" value="1" />
                	          <input name="userleavedate_appby" type="hidden" id="userleavedate_appby" value="<?php echo $row_user['user_stafid'];?>" />
                	          <input name="userleavedate_appdate" type="hidden" id="userleavedate_appdate" value="<?php echo date('d/m/Y h:i:s A');?>" />
								<input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                	          <input name="userleavestatus_id" type="hidden" id="userleavestatus_id" value="0" />
								<input type="hidden" name="MM_insert" value="formcuti" /></td>
                	        <td colspan="3" class="noline"><input name="button6" type="submit" class="submitbutton" id="button6" value="Simpan" />
                	          <span class="noline">
                	          <input name="button7" type="button" class="cancelbutton" id="button7" value="Batal" onclick="toggleview2('formcutiyear'); return false;" />
               	            </span></td>
               	          </tr>
              	      </table>
              	      </form>
                	</li>
                </div>
              <?php }; ?>
              <?php if(countLeaveBalance($colname_userprofile, $dateyear)<=0){?>
              <li class="form_back">
              <div class="note txt_color2"><img src="<?php echo $url_main;?>icon/sign_error.png" alt="Error" width="16" height="16" align="absbottom" /> &nbsp; Permohonan Cuti Rehat / Tahunan tidak dibenarkan kerana tiada peruntukan Cuti Rehat / Tahunan.
              </div>
              </li>
              <?php }; ?>
			  <?php if(!checkWaris($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat Waris/Rujukan Kecemasan</div>
              </li>
              <?php };?>
			  <?php if(!checkEdu($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat Pendidikan</div>
              </li>
              <?php };?>
			  <?php if(!checkAddressByStafID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat Alamat Terkini</div>
              </li>
              <?php };?>
			  <?php if(!checkTelMByStafID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat No. Telefon (Mobile)</div>
              </li>
              <?php };?>
			  <?php if(!checkBankByUserID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat Nama Bank</div>
              </li>
              <?php };?>
			  <?php if(!checkAccBankByUserID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat No. Akaun Bank</div>
              </li>
              <?php };?>
			  <?php if(!checkPERKESOByUserID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat No. PERKESO</div>
              </li>
              <?php };?>
			  <?php if(!checkKWSPByUserID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat No. KWSP</div>
              </li>
              <?php };?>
              <div id="cutiyear">
                <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_usercuti > 0) { // Show if recordset not empty ?>
<tr>
                      <th nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Amaran *</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                    <tr class="on">
                      <td><?php echo $i;?></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_y'])); ?></td>
                      <td><?php echo getLeaveCategory($row_usercuti['leavecategory_id']); ?> - <?php echo getLeaveTitle($row_usercuti['user_stafid'], 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y']);?> &nbsp; <span class="txt_color1"><?php if(getLeaveNote($row_usercuti['user_stafid'], 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y'])!=NULL) echo shortText(getLeaveNote($row_usercuti['user_stafid'], 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y']));?>
                        <?php if($row_usercuti['userleavedate_app']==1){?>
                        &nbsp; &bull; &nbsp; Diluluskan oleh <?php echo getFullNameByStafID($row_usercuti['userleavedate_appby']); ?> pada <?php echo $row_usercuti['userleavedate_appdate']; ?><?php if($row_usercuti['userleavedate_nofail']!=NULL) echo " &nbsp; &bull; &nbsp; No Fail : " . $row_usercuti['userleavedate_nofail'];?>
                        <?php } else if($row_usercuti['userleavedate_app']==2){?>
                        &nbsp; &bull; &nbsp; Tidak diluluskan oleh <?php echo getFullNameByStafID($row_usercuti['userleavedate_appby']); ?> pada <?php echo $row_usercuti['userleavedate_appdate']; ?>
                        <?php } else { ?>
                        &nbsp; &bull; &nbsp; Penilai oleh <?php echo getFullNameByStafID($row_usercuti['userleavedate_head']) . " (" . $row_usercuti['userleavedate_head'] . ")"; ?>
                        <?php };?>
                      </span></td>
                      <td align="center" valign="middle"><?php echo viewIconLeave($row_usercuti['user_stafid'], $row_usercuti['userleavedate_id'], $row_usercuti['leavetype_id'], $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y']);?></td>
                        <td align="center" valign="middle"><?php viewIconNotice($row_usercuti['user_stafid'], $row_usercuti['userleavedate_id'], 1, $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_y']);?></td>
                      <td align="center" valign="middle" class="back_lightgrey"><?php if($row_usercuti['userleavedate_app']==0) echo "1"; else if($row_usercuti['userleavedate_app']==1) echo "1"; else if($row_usercuti['userleavedate_app']==2) echo "-";?></td>
                      <td align="center" valign="middle"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_usercuti['userleavedate_date_m'], $row_usercuti['userleavedate_date_d'], $row_usercuti['userleavedate_date_y'])); ?> - <?php echo getLeaveCategory($row_usercuti['leavecategory_id']); ?>')" href="<?php echo $url_main;?>sb/del_userleaveadmin.php?deluld=<?php echo $row_usercuti['userleavedate_id']; ?>&id=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                    </tr>
                    <?php $i++; } while ($row_usercuti = mysql_fetch_assoc($usercuti)); ?>
                    <tr>
                      <td colspan="5" align="right" valign="middle" class="line_t noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo calAllLeave($colname_userprofile, $dateyear);?></strong></td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_usercuti ?> rekod dijumpai</td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </div>
                </li>
              </div>
              <?php $total = getELGov($colname_userprofile, $dateyear) + getELSwasta($colname_userprofile, $dateyear);?>
              
                 <li class="title">Permohonan Cuti Ganti <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid'] && countLeaveGantiBalance($colname_userprofile, $dateyear)>0){?><span class="fr add" onclick="toggleview2('formcutiganti'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid'] && countLeaveGantiBalance($colname_userprofile, $dateyear)>0){?>
                  
                <div id="formcutiganti" class="hidden">
                	<li>
                	  <form id="form2" name="form2" method="POST" action="../sb/leave_admin.php">
                	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	      <tr>
                	        <td nowrap="nowrap" class="label">Tarikh</td>
                	        <td colspan="3">
                	        	<select name="userleavedate_date_d" id="userleavedate_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                          <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                          <span class="inputlabel">/ </span>
                          <select name="userleavedate_date_m" id="userleavedate_date_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m M", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/ </span>
                          <input name="userleavedate_date_y" type="text" class="w25" id="userleavedate_date_y" value="<?php echo date('Y');?>" size="4" maxlength="4" /></td>
               	          </tr>
                	      <tr>
                	        <td nowrap="nowrap" class="label">No Fail</td>
                	        <td width="50%"><input name="userleavedate_nofail" type="text" class="w50" id="userleavedate_nofail" /></td>
                	        <td nowrap="nowrap" class="label">Kategori</td>
                	        <td width="50%">
                	          <select name="leavecategory_id" id="leavecategory_id">
                	            <?php

								do {  
								?>
                	            <option value="<?php echo $row_cutikategori12['leavecategory_id']?>"><?php echo $row_cutikategori12['leavecategory_name']?></option>
                	            <?php
								} while ($row_cutikategori12 = mysql_fetch_assoc($cutikategori12));
								  $rows = mysql_num_rows($cutikategori12);
								  if($rows > 0) {
									  mysql_data_seek($cutikategori12, 0);
									  $row_cutikategori12 = mysql_fetch_assoc($cutikategori12);
								  }
								?>
                            </select></td>
              	        </tr>
                        <tr>
                        	<td nowrap="nowrap" class="label">Catatan</td>
                            <td colspan="3">
                            <input type="text" name="userleavedate_note" id="userleavedate_note" /></td>
                        </tr>
                	      <tr>
                	        <td class="noline"><input name="leavetype_id" type="hidden" id="leavetype_id" value="3" />
                	          <input name="userleavedate_app" type="hidden" id="userleavedate_app" value="1" />
                	          <input name="userleavedate_appby" type="hidden" id="userleavedate_appby" value="<?php echo $row_user['user_stafid'];?>" />
                	          <input name="userleavedate_appdate" type="hidden" id="userleavedate_appdate" value="<?php echo date('d/m/Y h:i:s A');?>" />
								<input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                	          <input name="userleavestatus_id" type="hidden" id="userleavestatus_id" value="0" />
								<input type="hidden" name="MM_insert" value="formcuti" /></td>
                	        <td colspan="3" class="noline"><input name="button6" type="submit" class="submitbutton" id="button6" value="Simpan" />
                	          <span class="noline">
                	          <input name="button7" type="button" class="cancelbutton" id="button7" value="Batal" onclick="toggleview2('formcutiganti'); return false;" />
               	            </span></td>
               	          </tr>
              	      </table>
              	      </form>
                	</li>
                </div>
              <?php }; ?>
              <?php if(countLeaveGantiBalance($colname_userprofile, $dateyear)<=0){?>
              <li class="form_back">
              <div class="note txt_color2"><img src="<?php echo $url_main;?>icon/sign_error.png" alt="Error" width="16" height="16" align="absbottom" /> &nbsp; Permohonan Cuti Ganti tidak dibenarkan kerana tiada peruntukan Cuti Ganti
              </div>
              </li>
              <?php }; ?>
			  <?php if(!checkWaris($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat Waris/Rujukan Kecemasan</div>
              </li>
              <?php };?>
			  <?php if(!checkEdu($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat Pendidikan</div>
              </li>
              <?php };?>
			  <?php if(!checkAddressByStafID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat Alamat Terkini</div>
              </li>
              <?php };?>
			  <?php if(!checkTelMByStafID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat No. Telefon (Mobile)</div>
              </li>
              <?php };?>
			  <?php if(!checkBankByUserID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat Nama Bank</div>
              </li>
              <?php };?>
			  <?php if(!checkAccBankByUserID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat No. Akaun Bank</div>
              </li>
              <?php };?>
			  <?php if(!checkPERKESOByUserID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat No. PERKESO</div>
              </li>
              <?php };?>
			  <?php if(!checkKWSPByUserID($colname_userprofile)){?>
              <li class="form_back">
              <div class="note txt_color2">Kakitangan masih belum mengemaskini maklumat No. KWSP</div>
              </li>
              <?php };?>
              <div id="cutiyear">
                <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_cutikategori12 > 0) { // Show if recordset not empty ?>
<tr>
                      <th nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Amaran *</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php //$i=1; do { ?>

                    <?php $i=1;
						$cutikategori12 = mysql_query($query_cutikategori12, $hrmsdb) or die(mysql_error());
                    	while($cutikategori12 = mysql_fetch_array($cutikategori123)){?>
                    <tr class="on">
                      <td><?php echo $i++;?> </td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $cutikategori12['userleavedate_date_m'], $cutikategori12['userleavedate_date_d'], $cutikategori12['userleavedate_date_y'])); ?></td>
                      <td><?php echo getLeaveCategory($cutikategori12['leavecategory_id']); ?> - <?php echo getLeaveTitle($cutikategori12['user_stafid'], 1, $cutikategori12['userleavedate_date_d'], $cutikategori12['userleavedate_date_m'], $cutikategori12['userleavedate_date_y']);?> &nbsp; <span class="txt_color1"><?php if(getLeaveNote($cutikategori12['user_stafid'], 1, $cutikategori12['userleavedate_date_d'], $cutikategori12['userleavedate_date_m'], $cutikategori12['userleavedate_date_y'])!=NULL) echo shortText(getLeaveNote($cutikategori12['user_stafid'], 1, $cutikategori12['userleavedate_date_d'], $cutikategori12['userleavedate_date_m'], $cutikategori12['userleavedate_date_y']));?>
                        <?php if($cutikategori12['userleavedate_app']==1){?>
                        &nbsp; &bull; &nbsp; Diluluskan oleh <?php echo getFullNameByStafID($cutikategori12['userleavedate_appby']); ?> pada <?php echo $cutikategori12['userleavedate_appdate']; ?><?php if($cutikategori12['userleavedate_nofail']!=NULL) echo " &nbsp; &bull; &nbsp; No Fail : " . $cutikategori12['userleavedate_nofail'];?>
                        <?php } else if($cutikategori12['userleavedate_app']==2){?>
                        &nbsp; &bull; &nbsp; Tidak diluluskan oleh <?php echo getFullNameByStafID($cutikategori12['userleavedate_appby']); ?> pada <?php echo $cutikategori12['userleavedate_appdate']; ?>
                        <?php } else { ?>
                        &nbsp; &bull; &nbsp; Penilai oleh <?php echo getFullNameByStafID($cutikategori12['userleavedate_head']) . " (" . $cutikategori12['userleavedate_head'] . ")"; ?>
                        <?php };?>
                      </span></td>
                      <td align="center" valign="middle"><?php echo viewIconLeave($cutikategori12['user_stafid'], $cutikategori12['userleavedate_id'], $cutikategori12['leavetype_id'], $cutikategori12['userleavedate_date_d'], $cutikategori12['userleavedate_date_m'], $cutikategori12['userleavedate_date_y']);?></td>
                        <td align="center" valign="middle"><?php viewIconNotice($cutikategori12['user_stafid'], $cutikategori12['userleavedate_id'], 1, $cutikategori12['userleavedate_date_d'], $cutikategori12['userleavedate_date_m'], $cutikategori12['userleavedate_date_y']);?></td>
                      <td align="center" valign="middle" class="back_lightgrey"><?php if($cutikategori12['userleavedate_app']==0) echo "1"; else if($cutikategori12['userleavedate_app']==1) echo "1"; else if($cutikategori12['userleavedate_app']==2) echo "-";?></td>
                      <td align="center" valign="middle"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $cutikategori12['userleavedate_date_m'], $cutikategori12['userleavedate_date_d'], $cutikategori12['userleavedate_date_y'])); ?> - <?php echo getLeaveCategory($cutikategori12['leavecategory_id']); ?>')" href="<?php echo $url_main;?>sb/del_userleaveadmin.php?deluld=<?php echo $cutikategori12['userleavedate_id']; ?>&id=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                    </tr>
                    <?php// $i++; } while ($cutikategori12 = mysql_fetch_assoc($cutikategori12)); ?>
                	<?php }?>
                    <tr>
                      <td colspan="5" align="right" valign="middle" class="line_t noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo calGantiLeave($colname_userprofile, $dateyear);?></strong></td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutikategori12 ?> rekod dijumpai</td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </div>
                </li>
              </div>
              <?php $total = getELGov($colname_userprofile, $dateyear) + getELSwasta($colname_userprofile, $dateyear);?>
              
              
              
              
              
              
              
              
              
              
          <li class="title">Cuti Sakit<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?><?php if(getDesignationType($colname_userprofile) && countEL($colname_userprofile, $dateyear)<$total){ ?><span class="fr add" onclick="toggleview2('formcutisakit'); return false;">Tambah</span><?php } else { ?><?php if(countEL($colname_userprofile, $dateyear)<getEL($colname_userprofile)){?><span class="fr add" onclick="toggleview2('formcutisakit'); return false;">Tambah</span><?php }; ?><?php }; ?><?php }; ?></li>
          <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?>
          <?php if((getDesignationType($colname_userprofile) && countEL($colname_userprofile, $dateyear)<$total) || countEL($colname_userprofile, $dateyear)<getEL($colname_userprofile)){?>
              <div id="formcutisakit" class="hidden">
                <li>
                  <form id="formcutisakit2" name="formcutisakit" method="POST" action="../sb/leave_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td colspan="3">
                        <select name="userleavedate_date_d" id="userleavedate_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                          <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                          <span class="inputlabel">/ </span>
                          <select name="userleavedate_date_m" id="userleavedate_date_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m M", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/ </span>
                          <input name="userleavedate_date_y" type="text" class="w25" id="userleavedate_date_y" value="<?php echo date('Y');?>" size="4" maxlength="4" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Tempoh</td>
                        <td colspan="3">
                        <span id="cutisakitday">
                        <span class="textfieldInvalidFormatMsg">Maklumat yang dimasukkan tidak mengikut format.</span>
                        <span class="textfieldMinValueMsg">Nilai minimum adalah 1 Hari.</span>
                        <span class="textfieldMaxValueMsg">Nilai maklsimum adalah <?php echo countELBalance($colname_userprofile, $dateyear);?> Hari</span>
                        <input name="userleavedate_day" type="text" class="txt_right w10" id="userleavedate_day" value="1" maxlength="3"/>
                        <span class="inputlabel">&nbsp; Hari</span>
                        <div class="inputlabel2">Bilangan hari bercuti. Cth: 7 untuk 7 hari / seminggu</div></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Klinik</td>
                        <td colspan="3">
                          <select name="clinictype_id" id="clinictype_id">
                            <?php do { ?>
                            <option value="<?php echo $row_clinictype['clinictype_id']?>"><?php echo $row_clinictype['clinictype_name']?></option>
                            <?php
							} while ($row_clinictype = mysql_fetch_assoc($clinictype));
							  $rows = mysql_num_rows($clinictype);
							  if($rows > 0) {
								  mysql_data_seek($clinictype, 0);
								  $row_clinictype = mysql_fetch_assoc($clinictype);
							  }
							?>
                            </select>
                          <select name="clinic_id" id="clinic_id">
                          <option value="0" selected="selected">Tiada / Lain-lain</option>
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_cli['clinic_id']?>"><?php echo $row_cli['clinic_name']?>, <?php echo getState($row_cli['state_id']); ?></option>
                            <?php
							} while ($row_cli = mysql_fetch_assoc($cli));
							  $rows = mysql_num_rows($cli);
							  if($rows > 0) {
								  mysql_data_seek($cli, 0);
								  $row_cli = mysql_fetch_assoc($cli);
							  }
							?>
                        </select></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kelulusan oleh</td>
                        <td width="50%">
                          <select name="userleavedate_approvelby" id="userleavedate_approvelby">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_approvallist['user_stafid'];?>"><?php echo getFullNameByStafID($row_approvallist['user_stafid'], 1);?></option>
                            <?php
								} while ($row_approvallist = mysql_fetch_assoc($approvallist));
								  $rows = mysql_num_rows($approvallist);
								  if($rows > 0) {
									  mysql_data_seek($approvallist, 0);
									  $row_approvallist = mysql_fetch_assoc($approvallist);
								  }
								?>
                            <option value="0">Tiada</option>
                        </select></td>
                        <td nowrap="nowrap" class="label">No Fail</td>
                        <td width="50%"><input name="userleavedate_nofail" type="text" class="w50" id="userleavedate_nofail" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3"><label for="userleavedate_note"></label>
                        <input type="text" name="userleavedate_note" id="userleavedate_note" /></td>
                      </tr>
                      <tr>
                        <td class="noline"><input name="leavetype_id" type="hidden" id="leavetype_id" value="2" />
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                        <input type="hidden" name="MM_insert" value="formcuti" /></td>
                        <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" onclick="toggleview2('formcutisakit'); return false;" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
              </div>
                <?php }; ?>
                <?php }; ?>
                <li>
                <?php if(getDesignationType($colname_userprofile)){ ?>
                <div>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countELBalance($colname_userprofile, $dateyear, 1);?></div><div>Hari</div></td>
                      <td align="left" valign="middle" class="line_r txt_line"><div>Baki Cuti Sakit</div><div class="txt_color1">Melalui Klinik Kerajaan</div></td>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countELBalance($colname_userprofile, $dateyear, 2);?></div><div>Hari</div></td>
                      <td align="left" valign="middle" class="txt_line"><div>Baki Cuti Sakit</div><div class="txt_color1">Melalui Klinik Swasta</div></td>
                    </tr>
                  </table>
                </div>
                <?php } else { ?>
                <div class="note">Cuti Sakit yang diperuntukan sebanyak <strong><?php echo getEL($colname_userprofile);?> Hari</strong> sahaja bagi tahun <?php echo $dateyear;?></div>
                <?php }; ?>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_cutisakit > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                </tr>
          <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutisakit['userleavedate_date_m'], $row_cutisakit['userleavedate_date_d'], $row_cutisakit['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle"><?php echo "Klinik " . getClinicTypeName($row_cutisakit['clinictype_id']); ?> &nbsp; &bull; &nbsp; <?php echo getLeaveTitle($row_cutisakit['user_stafid'], 2, $row_cutisakit['userleavedate_date_d'], $row_cutisakit['userleavedate_date_m'], $row_cutisakit['userleavedate_date_y']); ?><span class="txt_color1"> &nbsp; &bull; &nbsp; Oleh <?php echo getFullNameByStafID($row_cutisakit['userleavedate_by']); ?> pada <?php echo $row_cutisakit['userleavedate_date']; ?> <?php if($row_cutisakit['userleavedate_nofail']!=NULL) echo " &nbsp; &bull; &nbsp; No. Fail : " . $row_cutisakit['userleavedate_nofail'];?></span></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutisakit['userleavedate_day']; ?></td>
                        <td align="center" valign="middle"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutisakit['userleavedate_date_m'], $row_cutisakit['userleavedate_date_d'], $row_cutisakit['userleavedate_date_y'])); ?> - <?php echo getLeaveTitle($row_cutisakit['user_stafid'], 2, $row_cutisakit['userleavedate_date_d'], $row_cutisakit['userleavedate_date_m'], $row_cutisakit['userleavedate_date_y']); ?>')" href="<?php echo $url_main;?>sb/del_userleaveadmin.php?deluld=<?php echo $row_cutisakit['userleavedate_id']; ?>&id=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutisakit = mysql_fetch_assoc($cutisakit)); ?>
                    <tr>
                      <td colspan="3" align="right" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo countEL($colname_userprofile, $dateyear);?></strong></td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center" class="noline txt_color1"><?php echo $totalRows_cutisakit ?>  rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                <li class="title">Cuti Tanpa Rekod<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?><?php if(countLeaveWOR($colname_userprofile, $dateyear)<getLeaveWOR($colname_userprofile, $dateyear)){?><span class="fr add" onclick="toggleview2('formcutitanparekod'); return false;">Tambah</span><?php }; ?><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?>
              <?php if(countLeaveWOR($colname_userprofile, $dateyear)<getLeaveWOR($colname_userprofile, $dateyear)){?>
              <div id="formcutitanparekod" class="hidden">
                <li>
                  <form id="formcutisakit2" name="formcutisakit" method="POST" action="../sb/leave_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td colspan="3"><select name="userleavedate_date_d" id="userleavedate_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                          <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                          <span class="inputlabel">/ </span>
                          <select name="userleavedate_date_m" id="userleavedate_date_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m M", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/ </span>
                          <input name="userleavedate_date_y" type="text" class="w25" id="userleavedate_date_y" value="<?php echo date('Y');?>" size="4" maxlength="4" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kategori</td>
                        <td width="50%">
                          <select name="leavecategory_id" id="leavecategory_id">
                          <option value="0">Tiada</option>
                          <?php if ($totalRows_cutikategori > 0) { // Show if recordset not empty ?>
                            <?php
							do {  
							?>
                            <?php if($row_cutikategori['leavecategory_id']!=1 || (getGenderIDByUserID($colname_userprofile)==1 && getMaritalByUserID($colname_userprofile)!=1)){?>
                            <option value="<?php echo $row_cutikategori['leavecategory_id']?>"><?php echo $row_cutikategori['leavecategory_name']?> <?php if($row_cutikategori['leavecategory_totalday']!=0) echo "(" . $row_cutikategori['leavecategory_totalday'] . "Hari)"; else "";?></option>
                            <?php }; ?>
                            <?php
							} while ($row_cutikategori = mysql_fetch_assoc($cutikategori));
							  $rows = mysql_num_rows($cutikategori);
							  if($rows > 0) {
								  mysql_data_seek($cutikategori, 0);
								  $row_cutikategori = mysql_fetch_assoc($cutikategori);
							  }
							?>
                            <?php }; ?>
                          </select></td>
                        <td nowrap="nowrap" class="label">Tempoh</td>
                        <td width="50%"><span id="cutitanparekodday"><span class="textfieldInvalidFormatMsg">Maklumat tidak mengikut format.</span><span class="textfieldMinValueMsg">Nilai minimum adalah 1 Hari.</span>
                        <input name="userleavedate_day" type="text" class="txt_right w30" id="userleavedate_day" value="1" maxlength="3"/><span class="inputlabel">&nbsp; Hari</span>
                        <div class="inputlabel2">Isi jika Kategori adalah Peperiksaan Akhir. Cth: 7 untuk 7 hari / seminggu</div></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kelulusan oleh</td>
                        <td>
                          <select name="userleavedate_approvelby" id="userleavedate_approvelby">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_approvallist['user_stafid'];?>"><?php echo getFullNameByStafID($row_approvallist['user_stafid'],1);?></option>
                            <?php
								} while ($row_approvallist = mysql_fetch_assoc($approvallist));
								  $rows = mysql_num_rows($approvallist);
								  if($rows > 0) {
									  mysql_data_seek($approvallist, 0);
									  $row_approvallist = mysql_fetch_assoc($approvallist);
								  }
								?>
                            <option value="0">Tiada</option>
                        </select></td>
                        <td nowrap="nowrap" class="label">No Fail</td>
                        <td><input name="userleavedate_nofail" type="text" class="w50" id="userleavedate_nofail" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3"><label for="userleavedate_note"></label>
                        <input type="text" name="userleavedate_note" id="userleavedate_note" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Amaran</td>
                        <td colspan="3">
                    <ul class="inputradio">
                    	<li><input type="radio" name="serleavedate_notice" value="1" id="amaran_0" />Ya</li>
                        <li><input type="radio" name="serleavedate_notice"  value="0" id="amaran_1" checked="checked" />Tidak</li>
                    </ul></td>
                      </tr>
                      <tr>
                        <td class="noline"><input name="leavetype_id" type="hidden" id="leavetype_id" value="4" />
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                        <input type="hidden" name="MM_insert" value="formcuti" /></td>
                        <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <?php }; ?>
                <li>
                <div class="note">Cuti Tanpa Rekod yang diperuntukan <strong><?php echo getLeaveWOR($colname_userprofile, $dateyear);?> Hari</strong> sahaja bagi tahun <?php echo $dateyear;?></div>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_cutitanparekod > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                    <th nowrap="nowrap">Tamat</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                </tr>
                  <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutitanparekod['userleavedate_date_m'], $row_cutitanparekod['userleavedate_date_d'], $row_cutitanparekod['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle"><?php echo getLeaveCategory($row_cutitanparekod['leavecategory_id']); ?> <span class="txt_color1"> <?php if($row_cutitanparekod['userleavedate_note']!=NULL) echo " - " . shortText($row_cutitanparekod['userleavedate_note']); ?> &nbsp;  &bull;  &nbsp; Oleh <?php echo getFullNameByStafID($row_cutitanparekod['userleavedate_by']); ?> pada <?php echo $row_cutitanparekod['userleavedate_date']; ?> <?php if($row_cutitanparekod['userleavedate_nofail']!=NULL) echo " &nbsp; &bull; &nbsp; No. Fail : " . $row_cutitanparekod['userleavedate_nofail'];?></span></td>
                        <td nowrap="nowrap"><?php echo countLeaveWOREndDate($row_cutitanparekod['userleavedate_id']);?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo getLeaveWORDay($row_cutitanparekod['userleavedate_id']); ?></td>
                        <td align="center" valign="middle"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutitanparekod['userleavedate_date_m'], $row_cutitanparekod['userleavedate_date_d'], $row_cutitanparekod['userleavedate_date_y'])); ?> - <?php echo getLeaveCategory($row_cutitanparekod['leavecategory_id']); ?>')" href="<?php echo $url_main;?>sb/del_userleaveadmin.php?deluld=<?php echo $row_cutitanparekod['userleavedate_id']; ?>&id=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutitanparekod = mysql_fetch_assoc($cutitanparekod)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo countLeaveWOR($colname_userprofile, $dateyear);?></strong></td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutitanparekod ?>  rekod dijumpai</td>
                    </tr>
                  <?php } else {?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
    </li>
    			<?php if(getGenderIDByUserID($colname_userprofile)==2){ ?>
                <li class="title">Cuti Bersalin<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?><?php if(countLeaveBirth($colname_userprofile)<getLeaveBirth($colname_userprofile)){?><span class="fr add" onclick="toggleview2('formcutibersalin'); return false;">Tambah</span><?php }; ?><?php };?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?>
                <?php if(countLeaveBirth($colname_userprofile)<getLeaveBirth($colname_userprofile)){?>
                <div id="formcutibersalin" class="hidden">
                <li>
                  <form id="formcutisakit2" name="formcutisakit" method="POST" action="../sb/leave_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td colspan="3">
                        <select name="userleavedate_date_d" id="userleavedate_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                          <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                          <span class="inputlabel">/ </span>
                          <select name="userleavedate_date_m" id="userleavedate_date_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m M", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/ </span>
                          <input name="userleavedate_date_y" type="text" class="w25" id="userleavedate_date_y" value="<?php echo date('Y');?>" size="4" maxlength="4" />
                          </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kategori</td>
                        <td width="50%">
                          <select name="leavecategory_id" id="leavecategory_id">
                          <option value="0">Tiada</option>
                          <?php if ($totalRows_cutikategori2 > 0) { // Show if recordset not empty ?>
                            <?php
							do {  
							?>
                                <option value="<?php echo $row_cutikategori2['leavecategory_id']?>"><?php echo $row_cutikategori2['leavecategory_name']?></option>
                                <?php
							} while ($row_cutikategori2 = mysql_fetch_assoc($cutikategori2));
							  $rows = mysql_num_rows($cutikategori2);
							  if($rows > 0) {
								  mysql_data_seek($cutikategori2, 0);
								  $row_cutikategori2 = mysql_fetch_assoc($cutikategori2);
							  }
							?>
                            <?php }; ?>
                        </select></td>
                        <td nowrap="nowrap" class="label">&nbsp;</td>
                        <td width="50%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kelulusan oleh</td>
                        <td>
                          <select name="userleavedate_approvelby" id="userleavedate_approvelby">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_approvallist['user_stafid'];?>"><?php echo getFullNameByStafID($row_approvallist['user_stafid'],1);?></option>
                            <?php
								} while ($row_approvallist = mysql_fetch_assoc($approvallist));
								  $rows = mysql_num_rows($approvallist);
								  if($rows > 0) {
									  mysql_data_seek($approvallist, 0);
									  $row_approvallist = mysql_fetch_assoc($approvallist);
								  }
								?>
                            <option value="0">Tiada</option>
                        </select></td>
                        <td nowrap="nowrap" class="label">No Fail</td>
                        <td><input name="userleavedate_nofail" type="text" class="w50" id="userleavedate_nofail" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Anak ke </td>
                        <td>
                          <select name="userleavedate_sonby" id="userleavedate_sonby">
                          <?php for($i=1; $i<=15; $i++){?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }; ?>
                        </select></td>
                        <td nowrap="nowrap" class="label">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3"><label for="userleavedate_note"></label>
                        <input type="text" name="userleavedate_note" id="userleavedate_note" /></td>
                      </tr>
                      <tr>
                        <td class="noline"><input name="leavetype_id" type="hidden" id="leavetype_id" value="5" /><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                        <input type="hidden" name="MM_insert" value="formcuti" /></td>
                        <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <?php }; ?>
                <li>
                <div class="note">Cuti Bersalin yang diperuntukan adalah <strong><?php echo getLeaveBirth($colname_userprofile);?> Hari</strong> sepanjang tempoh perkhidmatan.</div>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_cutibersalin > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Anak</th>
                      <th nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                  <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutibersalin['userleavedate_date_m'], $row_cutibersalin['userleavedate_date_d'], $row_cutibersalin['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle"><?php echo getLeaveCategory($row_cutibersalin['leavecategory_id']); ?> <span class="txt_color1"> <?php if($row_cutibersalin['userleavedate_note']!=NULL) echo " - " . shortText($row_cutibersalin['userleavedate_note']); ?> &nbsp; &bull; &nbsp; Oleh <?php echo getFullNameByStafID($row_cutibersalin['userleavedate_by']); ?> pada <?php echo $row_cutibersalin['userleavedate_date']; ?> <?php if($row_cutibersalin['userleavedate_nofail']!=NULL) echo " &nbsp; &bull; &nbsp; No. Fail : " . $row_cutibersalin['userleavedate_nofail'];?></span></td>
                        <td align="center" valign="middle"><?php echo $row_cutibersalin['userleavedate_sonby']; ?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo getLeaveBirthDay($row_cutibersalin['userleavedate_id']);?></td>
                        <td align="center" valign="middle"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutibersalin['userleavedate_date_m'], $row_cutibersalin['userleavedate_date_d'], $row_cutibersalin['userleavedate_date_y'])); ?> - <?php echo getLeaveCategory($row_cutibersalin['leavecategory_id']); ?>')" href="<?php echo $url_main;?>sb/del_userleaveadmin.php?deluld=<?php echo $row_cutibersalin['userleavedate_id']; ?>&id=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutibersalin = mysql_fetch_assoc($cutibersalin)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo countLeaveBirth($colname_userprofile);?></strong></td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutibersalin ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                <li class="title">Cuti Tanpa Gaji<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?><span class="fr add" onclick="toggleview2('formcutitanpagaji'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?>
                <div id="formcutitanpagaji" class="hidden">
                <li>
                  <form id="formcutisakit2" name="formcutisakit" method="POST" action="../sb/leave_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td colspan="3">
                        <select name="userleavedate_date_d" id="userleavedate_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                          <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                          <span class="inputlabel">/ </span>
                          <select name="userleavedate_date_m" id="userleavedate_date_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m M", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/ </span>
                          <input name="userleavedate_date_y" type="text" class="w25" id="userleavedate_date_y" value="<?php echo date('Y');?>" size="4" maxlength="4" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kategori</td>
                        <td width="50%">
                          <select name="leavecategory_id" id="leavecategory_id">
                          	<option value="0">Tiada</option>
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_cutikategori3['leavecategory_id']?>"><?php echo $row_cutikategori3['leavecategory_name']?></option>
                            <?php
							} while ($row_cutikategori3 = mysql_fetch_assoc($cutikategori3));
							  $rows3 = mysql_num_rows($cutikategori3);
							  if($rows3 > 0) {
								  mysql_data_seek($cutikategori3, 0);
								  $row_cutikategori3 = mysql_fetch_assoc($cutikategori3);
							  }
							?>
                          </select></td>
                        <td nowrap="nowrap" class="label">Tempoh</td>
                        <td width="50%"><span id="cutitanpagajiday">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="textfieldInvalidFormatMsg">Maklumat tidak mengikut format.</span><span class="textfieldMinValueMsg">Nilai minimum adalah 1 Hari.</span>
                        <input name="userleavedate_day" type="text" class="txt_right w30" id="userleavedate_day" value="1" maxlength="3"/><span class="inputlabel">&nbsp; Hari</span>
                        <div class="inputlabel2">Bilangan hari bercuti. Cth: 7 untuk 7 hari / seminggu</div></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kelulusan oleh</td>
                        <td>
                          <select name="userleavedate_approvelby" id="userleavedate_approvelby">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_approvallist['user_stafid'];?>"><?php echo getFullNameByStafID($row_approvallist['user_stafid'], 1);?></option>
                            <?php
								} while ($row_approvallist = mysql_fetch_assoc($approvallist));
								  $rows = mysql_num_rows($approvallist);
								  if($rows > 0) {
									  mysql_data_seek($approvallist, 0);
									  $row_approvallist = mysql_fetch_assoc($approvallist);
								  }
								?>
                            <option value="0">Tiada</option>
                        </select></td>
                        <td nowrap="nowrap" class="label">No Fail</td>
                        <td><input name="userleavedate_nofail" type="text" class="w50" id="userleavedate_nofail" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3"><label for="userleavedate_note"></label>
                        <input type="text" name="userleavedate_note" id="userleavedate_note" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Amaran</td>
                        <td colspan="3">
                    <ul class="inputradio">
                    	<li><input name="userleavedate_notice" type="radio"id="amaran_0" value="1" />Ya</li>
                        <li><input name="userleavedate_notice" type="radio" id="amaran_1" value="0" checked="checked" />Tidak</li>
                    </ul></td>
                      </tr>
                      <tr>
                        <td class="noline"><input name="leavetype_id" type="hidden" id="leavetype_id" value="6" /><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                        <input type="hidden" name="MM_insert" value="formcuti" /></td>
                        <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_cutitanpagaji > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="left" valign="middle" nowrap="nowrap">Amaran</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                  </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutitanpagaji['userleavedate_date_m'], $row_cutitanpagaji['userleavedate_date_d'], $row_cutitanpagaji['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle"><?php echo getLeaveCategory($row_cutitanpagaji['leavecategory_id']); ?> <span class="txt_color1"> <?php if($row_cutitanpagaji['userleavedate_note']!=NULL) echo " - " . shortText($row_cutitanpagaji['userleavedate_note']); ?>  &nbsp;  &bull;  &nbsp; Oleh <?php echo getFullNameByStafID($row_cutitanpagaji['userleavedate_by']); ?> pada <?php echo $row_cutitanpagaji['userleavedate_date']; ?> <?php if($row_cutitanpagaji['userleavedate_nofail']!=NULL) echo " &nbsp; &bull; &nbsp; No. Fail : " . $row_cutitanpagaji['userleavedate_nofail'];?></span></td>
                        <td align="center" valign="middle">
                          <?php if($row_cutitanpagaji['userleavedate_notice']==1) echo "<img src=\"" . $url_main . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Notice\" />"; else echo ""; ?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutitanpagaji['userleavedate_day']; ?></td>
                        <td align="center" valign="middle"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutitanpagaji['userleavedate_date_m'], $row_cutitanpagaji['userleavedate_date_d'], $row_cutitanpagaji['userleavedate_date_y'])); ?> - <?php echo getLeaveCategory($row_cutitanpagaji['leavecategory_id']); ?>')" href="<?php echo $url_main;?>sb/del_userleaveadmin.php?deluld=<?php echo $row_cutitanpagaji['userleavedate_id']; ?>&id=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutitanpagaji = mysql_fetch_assoc($cutitanpagaji)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo getLeaveWOS($colname_userprofile, $dateyear);?></strong></td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutitanpagaji ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
            </li>
            
             <li class="title">Cuti Kuarantin<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?><span class="fr add" onclick="toggleview2('formcutikuarantin'); return false;">Tambah</span><?php };?></li>
              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?>
              <div id="formcutikuarantin" class="hidden">
                <li>
                  <form id="formcutisakit2" name="formcutisakit" method="POST" action="../sb/leave_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td colspan="3">
                        <select name="userleavedate_date_d" id="userleavedate_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                          <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                          <span class="inputlabel">/</span>
                          <select name="userleavedate_date_m" id="userleavedate_date_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m M", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/</span>
                          <input name="userleavedate_date_y" type="text" class="w25" id="userleavedate_date_y" value="<?php echo date('Y');?>" size="4" maxlength="4" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kategori</td>
                        <td width="50%">
                            <select name="leavecategory_id" id="leavecategory_id">
                            <option value="0">Tiada</option>
                          <?php if ($totalRows_cutikategori11 > 0) { // Show if recordset not empty ?>
                              <?php
							do {  
							?>
                              <option value="<?php echo $row_cutikategori11['leavecategory_id']?>"><?php echo $row_cutikategori11['leavecategory_name']?></option>
                              <?php
							} while ($row_cutikategori11 = mysql_fetch_assoc($cutikategori11));
							  $rows = mysql_num_rows($cutikategori11);
							  if($rows > 0) {
								  mysql_data_seek($cutikategori11, 0);
								  $row_cutikategori18 = mysql_fetch_assoc($cutikategori11);
							  }
							?>
                            <?php } // Show if recordset not empty ?>
                            </select></td>
                        <td nowrap="nowrap" class="label">Tempoh</td>
                        <td width="50%"><span id="cutimelebihikelayakkanday">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="textfieldInvalidFormatMsg">Maklumat tidak mengikut format.</span><span class="textfieldMinValueMsg">Nilai minimum adalah 1 Hari.</span>
                        <input name="userleavedate_day" type="text" class="txt_right w30" id="userleavedate_day" value="1" maxlength="3"/><span class="inputlabel">&nbsp; Hari</span>
                        <div class="inputlabel2">Bilangan hari bercuti. Cth: 7 untuk 7 hari / seminggu</div></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kelulusan oleh</td>
                        <td>
                          <select name="userleavedate_approvelby" id="userleavedate_approvelby">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_approvallist['user_stafid'];?>"><?php echo getFullNameByStafID($row_approvallist['user_stafid'], 1);?></option>
                            <?php
								} while ($row_approvallist = mysql_fetch_assoc($approvallist));
								  $rows = mysql_num_rows($approvallist);
								  if($rows > 0) {
									  mysql_data_seek($approvallist, 0);
									  $row_approvallist = mysql_fetch_assoc($approvallist);
								  }
								?>
                            <option value="0">Tiada</option>
                        </select>
                        </td>
                        <td nowrap="nowrap" class="label">No Fail</td>
                        <td><input name="userleavedate_nofail" type="text" class="w50" id="userleavedate_nofail" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3">
                        <input type="text" name="userleavedate_note" id="userleavedate_note" /></td>
                      </tr>
                      <tr>
                        <td class="noline">
                        <input name="leavetype_id" type="hidden" id="leavetype_id" value="8" />
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                        <input type="hidden" name="MM_insert" value="formcuti" />
                        </td>
                        <td colspan="3" class="noline">
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
              </div>
              <?php }; ?>
                <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <?php if ($totalRows_cutikhas > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="left" valign="middle" nowrap="nowrap">Amaran</th>
                      <th nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutikhas['userleavedate_date_m'], $row_cutikhas['userleavedate_date_d'], $row_cutikhas['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle"><?php echo getLeaveCategory($row_cutikhas['leavecategory_id']); ?> <span class="txt_color1"> <?php if($row_cutikhas['userleavedate_note']!=NULL) echo " - " . $row_cutikhas['userleavedate_note']; ?>  &nbsp; &bull; &nbsp;  Oleh <?php echo getFullNameByStafID($row_cutikhas['userleavedate_by']); ?> pada <?php echo $row_cutikhas['userleavedate_date']; ?> <?php if($row_cutikhas['userleavedate_nofail']!=NULL) echo " &nbsp; &bull; &nbsp; No. Fail : " . $row_cutikhas['userleavedate_nofail'];?></span></td>
                        <td align="left" valign="middle">
                                    <?php if($row_cutikhas['userleavedate_notice']==1) echo "<img src=\"" . $url_main . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Notice\" />"; else echo ""; ?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutikhas['userleavedate_day']; ?></td>
                        <td align="center" valign="middle"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutikhas['userleavedate_date_m'], $row_cutikhas['userleavedate_date_d'], $row_cutikhas['userleavedate_date_y'])); ?> - <?php echo getLeaveCategory($row_cutikhas['leavecategory_id']); ?> (<?php echo $row_cutikhas['userleavedate_day']; ?> Hari)')" href="<?php echo $url_main;?>sb/del_userleaveadmin.php?deluld=<?php echo $row_cutikhas['userleavedate_id']; ?>&id=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutikhas = mysql_fetch_assoc($cutikhas)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo getLeaveKhas($colname_userprofile, $dateyear);?></strong></td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutikhas; ?> rekod dijumpai</td>
                    </tr>
                  <?php } else {?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                <?php }; ?>
                <li class="title">Cuti Melebihi Kelayakkan<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?><span class="fr add" onclick="toggleview2('formcutimelebihikelayakkan'); return false;">Tambah</span><?php };?></li>
              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?>
              <div id="formcutimelebihikelayakkan" class="hidden">
                <li>
                  <form id="formcutisakit2" name="formcutisakit" method="POST" action="../sb/leave_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td colspan="3"><select name="userleavedate_date_d" id="userleavedate_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                          <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                          <span class="inputlabel">/ </span>
                          <select name="userleavedate_date_m" id="userleavedate_date_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m M", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/ </span>
                          <input name="userleavedate_date_y" type="text" class="w25" id="userleavedate_date_y" value="<?php echo date('Y');?>" size="4" maxlength="4" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kategori</td>
                        <td width="50%">
                            <select name="leavecategory_id" id="leavecategory_id">
                              <option value="0">Tiada</option>
                          <?php if ($totalRows_cutikategori5 > 0) { // Show if recordset not empty ?>
                              <?php
							do {  
							?>
                              <option value="<?php echo $row_cutikategori5['leavecategory_id']?>"><?php echo $row_cutikategori5['leavecategory_name']?></option>
                              <?php
							} while ($row_cutikategori5 = mysql_fetch_assoc($cutikategori5));
							  $rows = mysql_num_rows($cutikategori5);
							  if($rows > 0) {
								  mysql_data_seek($cutikategori5, 0);
								  $row_cutikategori5 = mysql_fetch_assoc($cutikategori5);
							  }
							?>
                            <?php } // Show if recordset not empty ?>
                            </select></td>
                        <td nowrap="nowrap" class="label">Tempoh</td>
                        <td width="50%"><span id="cutimelebihikelayakkanday">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="textfieldInvalidFormatMsg">Maklumat tidak mengikut format.</span><span class="textfieldMinValueMsg">Nilai minimum adalah 1 Hari.</span>
                        <input name="userleavedate_day" type="text" class="txt_right w30" id="userleavedate_day" value="1" maxlength="3"/><span class="inputlabel">&nbsp; Hari</span>
                        <div class="inputlabel2">Bilangan hari bercuti. Cth: 7 untuk 7 hari / seminggu</div></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kelulusan oleh</td>
                        <td>
                          <select name="userleavedate_approvelby" id="userleavedate_approvelby">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_approvallist['user_stafid'];?>"><?php echo getFullNameByStafID($row_approvallist['user_stafid'], 1);?></option>
                            <?php
								} while ($row_approvallist = mysql_fetch_assoc($approvallist));
								  $rows = mysql_num_rows($approvallist);
								  if($rows > 0) {
									  mysql_data_seek($approvallist, 0);
									  $row_approvallist = mysql_fetch_assoc($approvallist);
								  }
								?>
                            <option value="0">Tiada</option>
                        </select></td>
                        <td nowrap="nowrap" class="label">No Fail</td>
                        <td><input name="userleavedate_nofail" type="text" class="w50" id="userleavedate_nofail" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3"><label for="userleavedate_note"></label>
                        <input type="text" name="userleavedate_note" id="userleavedate_note" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Amaran</td>
                        <td colspan="3">
                    <ul class="inputradio">
                    	<li><input type="radio" name="userleavedate_notice" value="1" id="amaran_0" />Ya</li>
                        <li><input name="userleavedate_notice" type="radio" id="amaran_1" value="0" checked="checked" />Tidak</li>
                    </ul></td>
                      </tr>
                      <tr>
                        <td class="noline"><input name="leavetype_id" type="hidden" id="leavetype_id" value="7" /><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                        <input type="hidden" name="MM_insert" value="formcuti" /></td>
                        <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
              </div>
              <?php }; ?>
                <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <?php if ($totalRows_cutimelebihikelayakkan > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="left" valign="middle" nowrap="nowrap">Amaran</th>
                      <th nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutimelebihikelayakkan['userleavedate_date_m'], $row_cutimelebihikelayakkan['userleavedate_date_d'], $row_cutimelebihikelayakkan['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle"><?php echo getLeaveCategory($row_cutimelebihikelayakkan['leavecategory_id']); ?> <span class="txt_color1"> <?php if($row_cutimelebihikelayakkan['userleavedate_note']!=NULL) echo " - " . $row_cutimelebihikelayakkan['userleavedate_note']; ?>  &nbsp;  &bull;  &nbsp; Oleh <?php echo getFullNameByStafID($row_cutimelebihikelayakkan['userleavedate_by']); ?> pada <?php echo $row_cutimelebihikelayakkan['userleavedate_date']; ?> <?php if($row_cutimelebihikelayakkan['userleavedate_nofail']!=NULL) echo " &nbsp; &bull; &nbsp; No. Fail : " . $row_cutimelebihikelayakkan['userleavedate_nofail'];?></span></td>
                        <td align="left" valign="middle">
                                    <?php if($row_cutimelebihikelayakkan['userleavedate_notice']==1) echo "<img src=\"" . $url_main . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Notice\" />"; else echo ""; ?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutimelebihikelayakkan['userleavedate_day']; ?></td>
                        <td align="center" valign="middle"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutimelebihikelayakkan['userleavedate_date_m'], $row_cutimelebihikelayakkan['userleavedate_date_d'], $row_cutimelebihikelayakkan['userleavedate_date_y'])); ?> - <?php echo getLeaveCategory($row_cutimelebihikelayakkan['leavecategory_id']); ?>')" href="<?php echo $url_main;?>sb/del_userleaveadmin.php?deluld=<?php echo $row_cutimelebihikelayakkan['userleavedate_id']; ?>&id=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutimelebihikelayakkan = mysql_fetch_assoc($cutimelebihikelayakkan)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo getLeaveMTQ($colname_userprofile, $dateyear);?></strong></td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutimelebihikelayakkan ?> rekod dijumpai</td>
                    </tr>
                  <?php } else {?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                <li class="title">Cuti Khas<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?><span class="fr add" onclick="toggleview2('formcutikhas'); return false;">Tambah</span><?php };?></li>
              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?>
              <div id="formcutikhas" class="hidden">
                <li>
                  <form id="formcutisakit2" name="formcutisakit" method="POST" action="../sb/leave_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td colspan="3">
                        <select name="userleavedate_date_d" id="userleavedate_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                          <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                          <span class="inputlabel">/</span>
                          <select name="userleavedate_date_m" id="userleavedate_date_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m M", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/</span>
                          <input name="userleavedate_date_y" type="text" class="w25" id="userleavedate_date_y" value="<?php echo date('Y');?>" size="4" maxlength="4" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kategori</td>
                        <td width="50%">
                            <select name="leavecategory_id" id="leavecategory_id">
                            <option value="0">Tiada</option>
                          <?php if ($totalRows_cutikategori6 > 0) { // Show if recordset not empty ?>
                              <?php
							do {  
							?>
                              <option value="<?php echo $row_cutikategori6['leavecategory_id']?>"><?php echo $row_cutikategori6['leavecategory_name']?></option>
                              <?php
							} while ($row_cutikategori6 = mysql_fetch_assoc($cutikategori6));
							  $rows = mysql_num_rows($cutikategori6);
							  if($rows > 0) {
								  mysql_data_seek($cutikategori6, 0);
								  $row_cutikategori6 = mysql_fetch_assoc($cutikategori6);
							  }
							?>
                            <?php } // Show if recordset not empty ?>
                            </select></td>
                        <td nowrap="nowrap" class="label">Tempoh</td>
                        <td width="50%"><span id="cutimelebihikelayakkanday">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="textfieldInvalidFormatMsg">Maklumat tidak mengikut format.</span><span class="textfieldMinValueMsg">Nilai minimum adalah 1 Hari.</span>
                        <input name="userleavedate_day" type="text" class="txt_right w30" id="userleavedate_day" value="1" maxlength="3"/><span class="inputlabel">&nbsp; Hari</span>
                        <div class="inputlabel2">Bilangan hari bercuti. Cth: 7 untuk 7 hari / seminggu</div></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kelulusan oleh</td>
                        <td>
                          <select name="userleavedate_approvelby" id="userleavedate_approvelby">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_approvallist['user_stafid'];?>"><?php echo getFullNameByStafID($row_approvallist['user_stafid'], 1);?></option>
                            <?php
								} while ($row_approvallist = mysql_fetch_assoc($approvallist));
								  $rows = mysql_num_rows($approvallist);
								  if($rows > 0) {
									  mysql_data_seek($approvallist, 0);
									  $row_approvallist = mysql_fetch_assoc($approvallist);
								  }
								?>
                            <option value="0">Tiada</option>
                        </select>
                        </td>
                        <td nowrap="nowrap" class="label">No Fail</td>
                        <td><input name="userleavedate_nofail" type="text" class="w50" id="userleavedate_nofail" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3">
                        <input type="text" name="userleavedate_note" id="userleavedate_note" /></td>
                      </tr>
                      <tr>
                        <td class="noline">
                        <input name="leavetype_id" type="hidden" id="leavetype_id" value="8" />
                        <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                        <input type="hidden" name="MM_insert" value="formcuti" />
                        </td>
                        <td colspan="3" class="noline">
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
              </div>
              <?php }; ?>
                <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <?php if ($totalRows_cutikhas > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="left" valign="middle" nowrap="nowrap">Amaran</th>
                      <th nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutikhas['userleavedate_date_m'], $row_cutikhas['userleavedate_date_d'], $row_cutikhas['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle"><?php echo getLeaveCategory($row_cutikhas['leavecategory_id']); ?> <span class="txt_color1"> <?php if($row_cutikhas['userleavedate_note']!=NULL) echo " - " . $row_cutikhas['userleavedate_note']; ?>  &nbsp; &bull; &nbsp;  Oleh <?php echo getFullNameByStafID($row_cutikhas['userleavedate_by']); ?> pada <?php echo $row_cutikhas['userleavedate_date']; ?> <?php if($row_cutikhas['userleavedate_nofail']!=NULL) echo " &nbsp; &bull; &nbsp; No. Fail : " . $row_cutikhas['userleavedate_nofail'];?></span></td>
                        <td align="left" valign="middle">
                                    <?php if($row_cutikhas['userleavedate_notice']==1) echo "<img src=\"" . $url_main . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Notice\" />"; else echo ""; ?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutikhas['userleavedate_day']; ?></td>
                        <td align="center" valign="middle"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutikhas['userleavedate_date_m'], $row_cutikhas['userleavedate_date_d'], $row_cutikhas['userleavedate_date_y'])); ?> - <?php echo getLeaveCategory($row_cutikhas['leavecategory_id']); ?> (<?php echo $row_cutikhas['userleavedate_day']; ?> Hari)')" href="<?php echo $url_main;?>sb/del_userleaveadmin.php?deluld=<?php echo $row_cutikhas['userleavedate_id']; ?>&id=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutikhas = mysql_fetch_assoc($cutikhas)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo getLeaveKhas($colname_userprofile, $dateyear);?></strong></td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cutikhas; ?> rekod dijumpai</td>
                    </tr>
                  <?php } else {?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                 <li class="title">Cuti Separuh Gaji<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?><span class="fr add" onclick="toggleview2('formcutiseparuhgaji'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $colname_userprofile!=$row_user['user_stafid']){?>
                <div id="formcutiseparuhgaji" class="hidden">
                <li>
                  <form id="formcutisakit2" name="formcutisakit" method="POST" action="../sb/leave_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Tarikh</td>
                        <td colspan="3">
                        <select name="userleavedate_date_d" id="userleavedate_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                          <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                          <span class="inputlabel">/ </span>
                          <select name="userleavedate_date_m" id="userleavedate_date_m">
                            <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date("m M", mktime(0, 0, 0, $j, 1, 2000));?></option>
                            <?php }; ?>
                          </select>
                          <span class="inputlabel">/ </span>
                          <input name="userleavedate_date_y" type="text" class="w25" id="userleavedate_date_y" value="<?php echo date('Y');?>" size="4" maxlength="4" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kategori</td>
                        <td width="50%">
                          <select name="leavecategory_id" id="leavecategory_id">
                          	<option value="0">Tiada</option>
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_cutikategori10['leavecategory_id']?>"><?php echo $row_cutikategori10['leavecategory_name']?></option>
                            <?php
							} while ($row_cutikategori10 = mysql_fetch_assoc($cutikategori10));
							  $rows = mysql_num_rows($cutikategori10);
							  if($rows > 0) {
								  mysql_data_seek($cutikategori10, 0);
								  $row_cutikategori10 = mysql_fetch_assoc($cutikategori10);
							  }
							?>
                          </select></td>
                        <td nowrap="nowrap" class="label">Tempoh</td>
                        <td width="50%"><span id="cutitanpagajiday">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.</span><span class="textfieldInvalidFormatMsg">Maklumat tidak mengikut format.</span><span class="textfieldMinValueMsg">Nilai minimum adalah 1 Hari.</span>
                        <input name="userleavedate_day" type="text" class="txt_right w30" id="userleavedate_day" value="1" maxlength="3"/><span class="inputlabel">&nbsp; Hari</span>
                        <div class="inputlabel2">Bilangan hari bercuti. Cth: 7 untuk 7 hari / seminggu</div></span></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Kelulusan oleh</td>
                        <td>
                          <select name="userleavedate_approvelby" id="userleavedate_approvelby">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_approvallist['user_stafid'];?>"><?php echo getFullNameByStafID($row_approvallist['user_stafid'], 1);?></option>
                            <?php
								} while ($row_approvallist = mysql_fetch_assoc($approvallist));
								  $rows = mysql_num_rows($approvallist);
								  if($rows > 0) {
									  mysql_data_seek($approvallist, 0);
									  $row_approvallist = mysql_fetch_assoc($approvallist);
								  }
								?>
                            <option value="0">Tiada</option>
                        </select></td>
                        <td nowrap="nowrap" class="label">No Fail</td>
                        <td><input name="userleavedate_nofail" type="text" class="w50" id="userleavedate_nofail" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Catatan</td>
                        <td colspan="3"><label for="userleavedate_note"></label>
                        <input type="text" name="userleavedate_note" id="userleavedate_note" /></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">Amaran</td>
                        <td colspan="3">
                    <ul class="inputradio">
                    	<li><input name="userleavedate_notice" type="radio"id="amaran_0" value="1" />Ya</li>
                        <li><input name="userleavedate_notice" type="radio" id="amaran_1" value="0" checked="checked" />Tidak</li>
                    </ul></td>
                      </tr>
                      <tr>
                        <td class="noline"><input name="leavetype_id" type="hidden" id="leavetype_id" value="6" /><input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $colname_userprofile;?>" />
                        <input type="hidden" name="MM_insert" value="formcuti" /></td>
                        <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                 <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <?php if ($totalRows_cutitanpagaji > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="left" valign="middle" nowrap="nowrap">Amaran</th>
                      <th align="center" valign="middle" nowrap="nowrap"> &nbsp; Kiraan (Hari)&nbsp; </th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                  </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutiseparuhgaji['userleavedate_date_m'], $row_cutiseparuhgaji['userleavedate_date_d'], $row_cutiseparuhgaji['userleavedate_date_y'])); ?></td>
                        <td align="left" valign="middle"><?php echo getLeaveCategory($row_cutiseparuhgaji['leavecategory_id']); ?> <span class="txt_color1"> <?php if($row_cutiseparuhgaji['userleavedate_note']!=NULL) echo " - " . shortText($row_cutiseparuhgaji['userleavedate_note']); ?>  &nbsp;  &bull;  &nbsp; Oleh <?php echo getFullNameByStafID($row_cutiseparuhgaji['userleavedate_by']); ?> pada <?php echo $row_cutiseparuhgaji['userleavedate_date']; ?> <?php if($row_cutiseparuhgaji['userleavedate_nofail']!=NULL) echo " &nbsp; &bull; &nbsp; No. Fail : " . $row_cutiseparuhgaji['userleavedate_nofail'];?></span></td>
                        <td align="center" valign="middle">
                          <?php if($row_cutiseparuhgaji['userleavedate_notice']==1) echo "<img src=\"" . $url_main . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Notice\" />"; else echo ""; ?></td>
                        <td align="center" valign="middle" class="back_lightgrey"><?php echo $row_cutiseparuhgaji['userleavedate_day']; ?></td>
                        <td align="center" valign="middle"><?php if($colname_userprofile!=$row_user['user_stafid'] && checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_cutiseparuhgaji['userleavedate_date_m'], $row_cutiseparuhgaji['userleavedate_date_d'], $row_cutiseparuhgaji['userleavedate_date_y'])); ?> - <?php echo getLeaveCategory($row_cutiseparuhgaji['leavecategory_id']); ?>')" href="<?php echo $url_main;?>sb/del_userleaveadmin.php?deluld=<?php echo $row_cutiseparuhgaji['userleavedate_id']; ?>&id=<?php echo getID($_GET['id']); ?>">X</a></li></ul><?php }; ?></td>
                      </tr>
                      <?php $i++; } while ($row_cutiseparuhgaji = mysql_fetch_assoc($cutiseparuhgaji)); ?>
                    <tr>
                      <td colspan="4" align="right" valign="middle" class="noline"><strong>Jumlah Terkumpul</strong></td>
                      <td align="center" valign="middle" class="back_lightgrey line_t"><strong><?php echo getLeaveWOS($colname_userprofile, $dateyear);?></strong></td>
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $row_cutiseparuhgaji ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
            </li>
                <?php } else { // semakkan user akses?>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
                  </tr>
                </table>
				</li>
                <?php }; ?>
            </ul>
          </div>
        </div>
        <?php echo noteEmail('1');?>
</div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("cutitanparekodday", "integer", {minValue:1, isRequired:false});
var sprytextfield2 = new Spry.Widget.ValidationTextField("cutitanpagajiday", "integer", {minValue:1});
var sprytextfield3 = new Spry.Widget.ValidationTextField("cutimelebihikelayakkanday", "integer", {minValue:1});
var sprytextfield4 = new Spry.Widget.ValidationTextField("cutisakitday", "integer", {isRequired:false, minValue:1});
</script>
<?php }; ?>
</body>
</html>
<?php
mysql_free_result($usercuti);

mysql_free_result($cutisakit);

mysql_free_result($cutitanparekod);

if(getGenderIDByUserID($colname_userprofile)==2)
	mysql_free_result($cutibersalin);

mysql_free_result($cutitanpagaji);

mysql_free_result($cutiseparuhgaji);

mysql_free_result($cutimelebihikelayakkan);

mysql_free_result($cutikhas);

mysql_free_result($cuti);

mysql_free_result($lt);

mysql_free_result($cutikategori);

mysql_free_result($cutikategori2);

mysql_free_result($cutikategori3);

mysql_free_result($cutikategori4);

mysql_free_result($cutikategori5);

mysql_free_result($cutikategori6);

mysql_free_result($cutikategori10);

mysql_free_result($cutikategori11);

mysql_free_result($cutikategori12);

mysql_free_result($approvallist);

mysql_free_result($clinictype);

mysql_free_result($cli);

if(getDesignationType($colname_userprofile)){
	mysql_free_result($plc);
	
	mysql_free_result($gcr);
}
?>
<?php include('../inc/footinc.php');?> 