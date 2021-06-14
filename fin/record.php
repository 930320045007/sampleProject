<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php $menu='17';?>
<?php $menu2='88';?>
<?php

if(isset($_GET['y']))
	$y = $_GET['y'];
else
	$y = date('Y');

if(isset($_GET['m']))
	$m = $_GET['m'];
else
	$m = date('m');

$colname_tr = "-1";

if (isset($_GET['id'])) 
{
  $colname_tr = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
}

mysql_select_db($database_financedb, $financedb);
$query_jkb = "SELECT * FROM finance.jkb WHERE jkb_date_y = '" . $y . "' AND jkb_date_m = '". $m . "' AND jkb_status = 1 AND user_stafid = '" . $row_user['user_stafid'] . "' ORDER BY jkb_date_y DESC, jkb_date_m DESC, jkb_date_d DESC, jkb_id DESC";
$jkb = mysql_query($query_jkb, $financedb) or die(mysql_error());
$row_jkb = mysql_fetch_assoc($jkb);
$totalRows_jkb = mysql_num_rows($jkb);

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
         <?php include('../inc/menu_fin_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="record.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
            	        <td class="label noline">Tarikh</td>
            	        <td width="100%" class="noline">                          
            	        <select name="m" id="m">
                          <?php for($j=1; $j<=12; $j++){?>
            	            <option <?php if($j==$m) echo "selected=\"selected\"";?> value="<?php if($j<10) $j= "0" . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                          <?php }; ?>
          	            </select>
            	        <select name="y" id="y">
                          <?php for($k=2012; $k<=date('Y'); $k++){?>
            	            <option <?php if($k==$y) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                          <?php }; ?>
          	            </select>
           	            <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
          	        </tr>
                    </table>
                  </form>
                </li>
            	<li><div class="note">Senarai rekod mengikut kategori bagi <strong><?php echo date(' M  Y', mktime(0, 0, 0, $m, 1, $y));?></strong></div></li>
                <li class="title">Permohonan Jawatankuasa Bantuan Pelaksanaan Program / Aktivti (JKB)</li>
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_jkb > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="50%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th width="20%" align="center" valign="middle" nowrap="nowrap">Bilangan JKB</th> 
                      <th align="center" valign="middle" nowrap="nowrap">Semakan</th> 
                    </tr>
                    <?php $i=1; do { ?>
                  	<tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getJKBDate($row_jkb['jkb_id']);?></td>
                    	<td align="left" valign="middle"><strong><a href="jkbdetail.php?id=<?php echo getID(htmlspecialchars($row_jkb['jkb_id'],ENT_QUOTES)); ?>"><?php echo $row_jkb['jkb_activity']; ?></a></strong>
                        <div class="txt_color1">Kelulusan : <?php if($row_jkb['classification']==0) echo "PENGARAH BAHAGIAN"; if($row_jkb['classification']==1) echo "AHLI MESYUARAT"; if($row_jkb['classification']==2) echo "KETUA PEGAWAI EKSEKUTIF (KPE)";?></div></td>
                		<td align="center" valign="middle"><?php if($row_jkb['bil_id']!=0) echo getBilNoByBilID(getBilIDByJkbID($row_jkb['jkb_id'])); else echo "-";?></td>
                        <td align="center" valign="middle"><?php echo iconJKBApp($row_jkb['jkb_id']);?></td>  
                    </tr>
                      <?php $i++; } while ($row_jkb = mysql_fetch_assoc($jkb)); ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_jkb ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
            </ul>
            </div>
        </div>
        <?php echo noteMade($menu);?>
        </div>        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($jkb);

?>
<?php include('../inc/footinc.php');?> 