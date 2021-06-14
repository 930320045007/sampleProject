<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='7';?>
<?php $menu2='18';?>
<?php $menu3 = '1';?>
<?php

if(isset($_GET['sid']) && $_GET['sid']!=NULL)
	$staffid = getStafIDByUserID(getID(htmlspecialchars($_GET['sid'], ENT_QUOTES), 0));
else
	$staffid = '0';

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dsg = sprintf("SELECT * FROM www.user_designation WHERE user_stafid = %s AND userdesignation_status = 1 ORDER BY userdesignation_date_y DESC, userdesignation_date_m DESC, userdesignation_date_d DESC, userdesignation_id DESC", GetSQLValueString($staffid, "text"));
$dsg = mysql_query($query_dsg, $hrmsdb) or die(mysql_error());
$row_dsg = mysql_fetch_assoc($dsg);
$totalRows_dsg = mysql_num_rows($dsg);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sch = sprintf("SELECT user_scheme.*, classification.classification_id FROM www.user_scheme LEFT JOIN www.scheme ON scheme.scheme_id = user_scheme.scheme_id LEFT JOIN www.classification ON classification.classification_id = scheme.classification_id WHERE user_stafid = %s AND user_scheme.userscheme_status = '1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, user_scheme.userscheme_id DESC", GetSQLValueString($staffid, "text"));
$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
$row_sch = mysql_fetch_assoc($sch);
$totalRows_sch = mysql_num_rows($sch);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<?php include('../inc/liload.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
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
                <li class="title">Tarikh Lantikan</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap="nowrap" class="label">Tarikh Mula Dilantik <br />
                        Perkhidmatan Kerajaan</td>
                      <td><?php echo getInDayDate($staffid, 0); ?></td>
                      </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Tarikh Mula <br />
                        Dilantik Ke MSN</td>
                      <td><?php echo getStartDayDate($staffid, 0); ?></td>
                      </tr>
                    <tr>
                      <td nowrap="nowrap" class="label">Tarikh Sah Jawatan</td>
                      <td><?php echo getPromotedDayDate($staffid, 0); ?></td>
                      </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Taraf Penjawatan </li>
                <li class="gap">&nbsp;</li>
                <li>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_dsg > 0) { // Show if recordset not empty ?>
                      <tr>
                        <th align="left">Tarikh</th>
                        <th width="100%" align="left">Status</th>
                        <th align="left" nowrap="nowrap">Tempoh (Bulan)</th>
                      </tr>
                      <?php do { ?>
                      <tr class="<?php if($row_dsg['userdesignation_status']=='1') echo "on"; else echo "offcourses";?>">
                          <td align="left" valign="middle" nowrap="nowrap"><?php echo $row_dsg['userdesignation_date_d']; ?>/<?php echo $row_dsg['userdesignation_date_m']; ?>/<?php echo $row_dsg['userdesignation_date_y']; ?></td>
                          <td><?php echo getJobtypeByID($row_dsg['jobtype_id']); ?></td>
                          <td align="center" valign="middle"><?php echo $row_dsg['userdesignation_period']; ?></td>
                      </tr>
                      <?php } while ($row_dsg = mysql_fetch_assoc($dsg)); ?>
                      <tr>
                        <td colspan="4" align="center" valign="middle" nowrap="nowrap" class="noline txt_color1"><?php echo $totalRows_dsg; ?> rekod dijumpai</td>
                      </tr>
                      <?php } else { ?>
                      <tr>
                        <td colspan="4" align="center" valign="middle" nowrap="nowrap" class="noline">Tiada rekod dijumpai</td>
                      </tr>
                      <?php }; ?>
                    </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Jawatan </li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_sch > 0) { // Show if recordset not empty ?>
                      <tr>
                          <th align="left">Tarikh</th>
                          <th>Gred</th>
                          <th width="100%" align="left">Skim</th>
                      </tr>
                      <?php do { ?>
                        <tr class="on">
                          <td align="left" nowrap="nowrap"><?php echo $row_sch['userscheme_in_d']; ?>/<?php echo $row_sch['userscheme_in_m']; ?>/<?php echo $row_sch['userscheme_in_y']; ?></td>
                          <td nowrap="nowrap"><?php echo getGred($staffid, $row_sch['userscheme_id']); ?></td>
                          <td><?php echo getSchemeNameByID($row_sch['scheme_id']);?> <?php if(checkNoSchemeBySchemeID($row_sch['userscheme_id'])) echo "<span class=\"txt_color1\"> &nbsp; &bull; &nbsp; Tidak Berskim</span>";;?></td>
                        </tr>
                        <?php } while ($row_sch = mysql_fetch_assoc($sch)); ?>
                      <tr>
                        <td colspan="4" align="center" valign="middle" nowrap="nowrap" class="noline txt_color1"><?php echo $totalRows_sch ?> rekod dijumpai</td>
                      </tr>
                    <?php } else { ?>
                      <tr>
                        <td colspan="4" align="center" valign="middle" nowrap="nowrap" class="noline">Tiada rekod dijumpai</td>
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

mysql_free_result($dsg);

mysql_free_result($sch);

?>
<?php include('../inc/footinc.php');?>
