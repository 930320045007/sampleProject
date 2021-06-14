<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='5';?> 
<?php $menu3='4';?> 
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_klas = "SELECT * FROM classification ORDER BY classification_code ASC";
$klas = mysql_query($query_klas, $hrmsdb) or die(mysql_error());
$row_klas = mysql_fetch_assoc($klas);
$totalRows_klas = mysql_num_rows($klas);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_scheme = "SELECT * FROM user_scheme ORDER BY userscheme_gred ASC";
$scheme = mysql_query($query_scheme, $hrmsdb) or die(mysql_error());
$row_scheme = mysql_fetch_assoc($scheme);
$totalRows_scheme = mysql_num_rows($scheme);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sc = "SELECT * FROM scheme ORDER BY scheme_name ASC";
$sc = mysql_query($query_sc, $hrmsdb) or die(mysql_error());
$row_sc = mysql_fetch_assoc($sc);
$totalRows_sc = mysql_num_rows($sc);

		
if(isset($_GET['userscheme_gred']))
	$ug = $_GET['userscheme_gred'];
else
	$ug = $row_scheme['userscheme_gred'];
	
if(isset($_GET['userscheme_no']))
	$un = $_GET['userscheme_no'];
else
	$un = $row_scheme['userscheme_no'];
	
if(isset($_GET['scheme_id']))
	$scid = $_GET['scheme_id'];
else
	$scid = $row_sc['scheme_name'];

$c = "";
$type = 0;

if(isset($_GET['userscheme_gred']) && $_GET['scheme_id'] != NULL)
{
	$type = 1;
	$c = " AND (userscheme_gred ='".$ug."' AND user_scheme.scheme_id ='".$scid."')";	
}else if(isset($_GET['userscheme_no'])) {
	$type = 2;
	$c = " AND userscheme_no = '" . $un . "'";
}
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$sql_where = " login.login_status = '1' ". $c . " AND userdesignation_status = '1'";
$order_by = "userdesignation_date_y DESC, userdesignation_date_m DESC, userdesignation_date_d DESC, userdesignation_id DESC, user.user_firstname ASC, user.user_lastname ASC";
$query_staf = sqlAllStaf($sql_where, $order_by);
$staf = mysql_query($query_staf, $hrmsdb) or die(mysql_error());
$row_staf = mysql_fetch_assoc($staf);
$totalRows_staf = mysql_num_rows($staf);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<?php include('../inc/liload.php');?>
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
            <?php include('../inc/menu_senaraistaf.php');?>
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
              <li class="line_b">
                  <form id="form1" name="form1" method="get" action="stafflistnamebygred.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" class="label noline">Gred</td>
                        <td width="100%" class="noline">
                            <select name="klas" id="klas" onchange="dochange('1', 'scheme_id', this.value, '0');">
                            <option value="0">&laquo; Pilih Gred</option>
        <?php
            do {  
            ?>
        <option value="<?php echo $row_klas['classification_id']?>"><?php echo $row_klas['classification_code'] . " - " . $row_klas['classification_name'];?></option>
        <?php
            } while ($row_klas = mysql_fetch_assoc($klas));
              $rows = mysql_num_rows($klas);
              if($rows > 0) {
                  mysql_data_seek($klas, 0);
                  $row_klas = mysql_fetch_assoc($klas);
              }
            ?>
      </select>
      <select name="scheme_id" id="scheme_id" onchange="dochange('2', 'userscheme_gred', this.value, '0');">
        <option value="0" disabled="disabled">&laquo; Pilih Klasifikasi</option>
      </select>
      <select name="userscheme_gred" id="userscheme_gred">
        <option value="0" disabled="disabled">&laquo; Pilih Skim</option>
      </select></td> 
      <td nowrap="nowrap"><ul class="inputradio"><li><input name="userscheme_no" type="checkbox" id="userscheme_no" value="1" /> Tidak Berskim</li></ul></td>
     <td nowrap="nowrap"><ul class="inputradio"><li><input name="userscheme_no" type="checkbox" id="userscheme_no" value="2" /> Terbuka</li></ul></td>
                       <td width="207"><input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                      </tr>
                    </table>
                </form>
                </li>
                <li>
                <div class="note">Senarai nama kakitangan</div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>
                  <tr>
                    <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                   
                    <th align="left" valign="middle" nowrap="nowrap">Nama</th>
                    <th align="left" valign="middle" nowrap="nowrap">Cawangan</th>
                    <th align="left" valign="middle" nowrap="nowrap">Email</th>
                    <th align="left" valign="middle" nowrap="nowrap">Ext</th>
                  </tr>
				  <?php $i=1; do{ ?>
                  <tr class="on">
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td align="left" valign="middle" nowrap="nowrap" class="txt_line"><?php echo getFullNameByStafID($row_staf['user_stafid'],1) . " (" . $row_staf['user_stafid'] . ")";?></td>
                    <td width="50%" align="left" valign="middle"><?php echo getFulldirectoryByUserID($row_staf['user_stafid']);?></td>
                    <td width="30%" align="left" valign="middle" nowrap="nowrap"><?php echo getEmailISNByUserID($row_staf['user_stafid']);?></td>
                    <td width="20%" align="left" valign="middle" nowrap="nowrap"><?php echo getExtNoByUserID($row_staf['user_stafid']);?></td>
                  </tr>
                  <?php $i++; } while ($row_staf = mysql_fetch_assoc($staf)); ?>
                  <tr>
                    <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_staf; ?> rekod dijumpai</td>
                  </tr>
                  <?php } else { ?>
                  <tr>
                    <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                  </tr>
                  <?php }; ?>
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
<?php
mysql_free_result($staf);
mysql_free_result($scheme);
mysql_free_result($klas);
mysql_free_result($sc);
?>