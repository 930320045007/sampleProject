<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='81';?>
<?php
$colname_tr = "-1";
if (isset($_GET['id'])) {
  $colname_tr = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
}

$m = array();
if(isset($_GET['m']))
{
	$m = explode("/", htmlspecialchars($_GET['m'],ENT_QUOTES));
	$wsql = " transbook_date_m = '" . $m['0'] . "' AND transbook_date_y = '" . $m['1'] . "'";
} else
{
	$m[0] = date('m');
	$m[1] = date('Y');
	$wsql = " transbook_date_m = '" . $m['0'] . "' AND transbook_date_y = '" . $m['1'] . "'";
};
	
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = "SELECT * FROM tadbir.transport_book WHERE " . $wsql . " ORDER BY transbook_date_y DESC, transbook_date_m DESC, transbook_date_d DESC, transbook_id DESC";
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_transdriver = sprintf("SELECT * FROM transdriver WHERE transbook_id = %s ORDER BY transdriver_id ASC", GetSQLValueString($colname_tr, "int"));
$transdriver = mysql_query($query_transdriver, $tadbirdb) or die(mysql_error());
$row_transdriver = mysql_fetch_assoc($transdriver);
$totalRows_transdriver = mysql_num_rows($transdriver);
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
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            <li class="form_back">
              <form id="form1" name="form1" method="get" action="admintransport.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Tarikh</td>
                    <td width="100%">
                    <select name="m" id="m">
                    <?php for($i=(date('m')-5); $i<=(date('m')+5); $i++){?>
                    <option <?php if($m['0']==date('m', mktime(0, 0, 0, $i, 1, date('Y'))) && $m['1']==date('Y', mktime(0, 0, 0, $i, 1, date('Y')))) echo "selected=\"selected\"";?> value="<?php echo date('m/Y', mktime(0, 0, 0, $i, 1, date('Y')));?>"><?php echo date('M Y', mktime(0, 0, 0, $i, 1, date('Y')));?></option>
                    <?php }; ?>
                    </select>
                    <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td><td align="right" valign="middle"><span class="noline">
            	          <input name="button4" type="button" class="submitbutton" id="button4" value="Kenderaan" onclick="MM_goToURL('parent','transportlist.php');return document.MM_returnValue"/>
            	        </span></td>
                  </tr>
                </table>
              </form>
            </li>
            	<li><div class="note">Senarai tempahan bagi bulan<strong> <?php echo date('M Y', mktime(0, 0, 0, $m['0'], 1, $m['1']));?></strong></div></li>
                <li>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_tr > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh Tempahan</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                       <th align="center" valign="middle" nowrap="nowrap">Kelulusan</th>  
                        <th align="center" valign="middle" nowrap="nowrap">Penilaian</th> 
                        <th>&nbsp;</th>   
                    </tr>
                    <?php $i=1; do { ?>
                  	 <tr <?php if(checkDelTransbookByTransbookID($row_tr['transbook_id'])==0) echo "class=\"offcourses\""; else echo "class=\"on\"";?>>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap">
						<?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_tr['transbook_date_m'], $row_tr['transbook_date_d'], $row_tr['transbook_date_y']));?>
                        </td>
                    	<td align="left" valign="middle" class="txt_line">
                        <a href="admintransportdetail.php?tid=<?php echo  getID(htmlspecialchars($row_tr['transbook_id'],ENT_QUOTES)); ?>">
                        <strong><?php echo $row_tr['transbook_title']; ?></strong>
                        <div class="txt_color1"><?php echo getFullNameByStafID($row_tr['transbook_by']) . " (" . $row_tr['transbook_by'] . ")";?></div>
                        <div class="txt_color1"><?php echo getFulldirectoryByUserID($row_tr['transbook_by']);?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID($row_tr['transbook_by']);?></div>
                        </a>
                        </td>
                		<td align="center" valign="middle"><?php echo iconBookTransportStatus($row_tr['transbook_id']);?></td>
                         <td align="center" valign="middle">
						 <?php 
						 if(!checkFeedback($row_tr['transbook_id']) && checkAdminAppByID($row_tr['transbook_id'])) 
						 	echo  "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Pending\" align=\"absbottom\" />"; 
						 elseif(checkAdminAppByID($row_tr['transbook_id'])) 
						 	echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";  
						 ?>
                         </td>
                         <td><ul class="func"><li><?php if(checkUserSysAcc($row_user['user_stafid'], 10, 81, 4)){ ?><a onclick="return confirm('Anda mahu tempahan kenderaan berikut dipadam? \r\n\n <?php echo $row_tr['transbook_title']; ?> \r\n Oleh <?php echo getFullNameByStafID($row_tr['transbook_by']) . " (" . $row_tr['transbook_by'] . ")";?>')" href="../sb/del_transbook.php?deltrans=<?php echo $row_tr['transbook_id'];?>">X</a><?php }; ?></li></ul></td>
                      </tr>
                      <?php $i++; } while ($row_tr = mysql_fetch_assoc($tr)); ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle"><?php echo $totalRows_tr ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
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
mysql_free_result($tr);
mysql_free_result($transdriver);
?>
<?php include('../inc/footinc.php');?> 