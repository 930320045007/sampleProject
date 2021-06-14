<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT * FROM dir WHERE dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);
$totalRows_dir = mysql_num_rows($dir);

$sql_where = " login.login_status = '1'";

if(isset($_POST['unit']))
{
	$sql_where .= " AND user_unit.dir_id='" . htmlspecialchars($_POST['unit'], ENT_QUOTES) . "' AND userunit_status = '1' ";
	$orderby = "0";
	
} elseif(isset($_POST['jc']) && $_POST['jc']!=0)
{
	$sql_where .= " AND scheme.group_id = '" . htmlspecialchars($_POST['jc'], ENT_QUOTES) . "' ";
	$orderby = "0";
	
} elseif(isset($_POST['n']) && $_POST['n']!=NULL)
{
	$sql_where .= " AND (user.user_firstname LIKE '%" . htmlspecialchars($_POST['n'], ENT_QUOTES) . "%' OR user.user_lastname LIKE '%" . htmlspecialchars($_POST['n'], ENT_QUOTES) . "%')";
	$orderby = "user_firstname ASC, user_lastname ASC";
	
} elseif(isset($_POST['si']) && $_POST['si']!=NULL)
{
	$sql_where .= " AND user.user_stafid = '" . htmlspecialchars($_POST['si'], ENT_QUOTES) . "'";
	$orderby = "user_firstname ASC, user_lastname ASC";
	
} elseif(isset($_POST['kp']) && $_POST['kp']!=NULL)
{
	$sql_where .= " AND user.user_noic = '" . htmlspecialchars($_POST['kp'], ENT_QUOTES) . "'";
	$orderby = "user_firstname ASC, user_lastname ASC";
	
} elseif(isset($_POST['c']) && $_POST['c']!=NULL)
{
	$sql_where .= " AND user.user_firstname LIKE '" . htmlspecialchars($_POST['c'], ENT_QUOTES) . "%'";
	$orderby = "user_firstname ASC, user_lastname ASC";

} else {
	$sql_where .= " AND user_unit.dir_id = '1' AND userunit_status = '1' ";
	$orderby = "0";
};
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_staflist = sqlAllStaf($sql_where);
$staflist = mysql_query($query_staflist, $hrmsdb) or die(mysql_error());
$row_staflist = mysql_fetch_assoc($staflist);
$totalRows_staflist = mysql_num_rows($staflist);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('load.php');?>
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <div class="tabbox">
          <div class="profilemenu line_t">
              <ul>
               	  <li class="form_back">
                    <form id="form1" name="form1" method="post" action="">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="label noline">Carian</td>
                          <td width="100%" class="noline">
                            <select name="select" id="select" onchange="dochange('17', 'stype', this.value, '0');">
                              <option value="0">Jenis Carian</option>
                              <option value="1">Bhg/Cwg/Pusat/Unit</option>
                              <option value="2">Nama</option>
                              <option value="5">Alphabet</option>
                            </select>
                            <div id="stype">
                            </div>
                            </td>
                        </tr>
                      </table>
                    </form>
                  </li>
                  <li>
                  <div class="note">Senarai kakitangan</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_staflist > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle">Bil</th>
                      <th align="left" valign="middle" nowrap="nowrap">&nbsp;</th>
                      <th width="100%" align="left" valign="middle">Nama / Jawatan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tel / No. Ext</th>
                      <th align="center" valign="middle" nowrap="nowrap">Email <br />
                        (@msn.gov.my)</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle" nowrap="nowrap"><?php echo viewProfilePic($row_staflist['user_stafid'], 1);?></td>
                        <td align="left" valign="middle">
                        <div class="txt_line">
                        <div><strong><?php echo getFullNameByStafID($row_staflist['user_stafid']) . " (" . $row_staflist['user_stafid'] . ")";?></strong></div>
                        <div class="txt_color1"><?php if(getCitizenByUserID($row_staflist['user_stafid'])=='130') echo getJobtitle($row_staflist['user_stafid']) . " (" . getGred($row_staflist['user_stafid']) . ")<br/>"; ?><?php echo getFulldirectoryByUserID($row_staflist['user_stafid']);?></div>
						<div class="txt_color1"><?php echo getLocationByUserID($row_staflist['user_stafid']);?></div>
                        </div>
                        </td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getExtNoByUserID($row_staflist['user_stafid'],0);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getEmailISNByUserID($row_staflist['user_stafid'],1);?></td>
                    </tr>
                      <?php $i++; } while ($row_staflist = mysql_fetch_assoc($staflist)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_staflist ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai. Sila pilih Bahagian / Cawangan / Pusat / Unit.</td>
                    </tr>
                  <?php }; ?>
                  </table>
                  </li>
              </ul>
            </div>
        </div>
  	</div>
    </div>
</div>
</body>
</html>

<?php
mysql_free_result($dir);

mysql_free_result($staflist);
?>