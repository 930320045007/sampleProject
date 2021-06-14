<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='7';?>
<?php $menu2='18';?>
<?php $menu3 = '2';?>
<?php

if(isset($_GET['sid']) && $_GET['sid']!=NULL)
	$staffid = getStafIDByUserID(getID(htmlspecialchars($_GET['sid'], ENT_QUOTES), 0));
else
	$staffid = '0';

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_ec = sprintf("SELECT * FROM www.user_ec WHERE user_stafid = '" .$staffid. "' AND userec_status = '1' ORDER BY userec_name ASC", GetSQLValueString($staffid, "text"));
$user_ec = mysql_query($query_user_ec, $hrmsdb) or die(mysql_error());
$row_user_ec = mysql_fetch_assoc($user_ec);
$totalRows_user_ec = mysql_num_rows($user_ec);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
	  <?php include('../inc/header.php');?>
      <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_unit.php');?>
        <div class="tabbox">
        <div class="profilemenu">
        
         <?php if (getUserUnitIDByUserID($row_user['user_stafid'])==getUserUnitIDByUserID($staffid)){?>
         
            <?php include('../inc/menu_head.php');?>
        	<ul>
                <li class="gap">&nbsp;</li>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  <td rowspan="2" align="center" valign="top" class="noline"><?php echo viewProfilePic($staffid);?></td>
                    <td nowrap="nowrap" class="label">Nama</td>
                    <td width="100%"><strong><?php echo strtoupper(getFullNameByStafID($staffid)) . " (" . $staffid . ")"; ?></strong></td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label noline">Jawatan</td>
                    <td class="noline txt_line"><?php echo getJobtitle($staffid); ?><br/><?php echo getFulldirectoryByUserID($staffid);?></td>
                  </tr>
                </table>
                </li>
                <li class="gap">&nbsp;</li>
           	  <li class="title">Maklumat Peribadi</li>
                <li class="gap">&nbsp;</li>
                <li>
                 <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Umur</td>
                      <td colspan="3"><?php echo getAgeByUserID($staffid);?> Tahun</td>
                      </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Jantina</td>
                      <td><?php echo getGender($gender = getGenderIDByUserID($staffid)); ?></td>
                      <td nowrap="nowrap" class="label">Kaum</td>
                      <td><?php echo getRace($race = getRaceByUserID($staffid)); ?></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Kewarganegaraan</td>
                      <td><?php echo getCitizen($citizen = getCitizenByUserID($staffid)); ?></td>
                      <td nowrap="nowrap" class="label">Agama</td>
                      <td><?php echo getReligion($rg =  getReligionByUserID($staffid)); ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Alamat Terkini</td>
                      <td colspan="5" valign="middle"><div class="txt_line in_cappitalize"><?php echo getAddressByStafID($staffid); ?></div></td>
                      </tr>
                      <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Status <br />
                      Perkahwinan</td>
                      <td width="50%" valign="middle" class="in_capitalize"><?php echo getMarital($marital = getMaritalByUserID($staffid));?></td>
                      <td valign="middle" nowrap="nowrap" class="label">Saiz Baju</td>
                      <td width="50%" valign="middle" class="in_capitalize"><?php echo getSize($staffid); ?></td>
                      </tr>
                      </table>
                </li>
            <li class="gap">&nbsp;</li>
           		<li class="title">Waris / Rujukan Kecemasan</li>
        <li class="gap">&nbsp;</li>
                  <li>
  					<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<?php if ($totalRows_user_ec > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th width="50%" align="left" valign="middle">Nama / Hubungan</th>
                      <th align="center" valign="middle">No. Tel (Rumah)</th>
                      <th align="center" valign="middle">No. Tel (Mobile)</th>
                      <th align="center" valign="middle">No. Tel (Pejabat)</th>                 
                    </tr>
                    <?php do { ?>
                      <tr class="on">
                        <td align="left">
                        <div class="txt_line">
                        <div class="in_cappitalize"><strong><?php echo $row_user_ec['userec_name']; ?></strong></div>
                        <div class="in_cappitalize"><?php echo getRelation($row_user_ec['userec_relation']); ?></div>
                        </div>
                        </td>
                        <td align="center" valign="middle"><?php if($row_user_ec['userec_telh']!=NULL)echo $row_user_ec['userec_telh']; else echo "-"; ?></td>
                        <td align="center" valign="middle"><?php if($row_user_ec['userec_telm']!=NULL)echo $row_user_ec['userec_telm']; else echo "-"; ?></td>
                        <td align="center" valign="middle"><?php if($row_user_ec['userec_telw']!=NULL)echo $row_user_ec['userec_telw']; else echo "-"; ?></td>
                      </tr>
                      <?php } while ($row_user_ec = mysql_fetch_assoc($user_ec)); ?>
                    <tr>
                      <td colspan="4" align="center" class="noline txt_color1">&nbsp;<?php echo $totalRows_user_ec ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="4" align="center" class="noline">Tiada rekod dijumpai, Sila isi Rujukan Kecemasan</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
            </ul>
             <?php }else{ ?>
          	<ul>
            	<li><div class="note" >Tiada rekod yang dijumpai.</div></li>
            </ul>
           <?php };?>
        </div>
        
        </div>
      </div>
        
	  <?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php

mysql_free_result($user_ec);
?>
<?php include('../inc/footinc.php');?>
