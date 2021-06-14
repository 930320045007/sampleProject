<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php $menu='16';?>
<?php $menu2='89';?>
<?php $menu3='3';?>
<?php
if(isset($_GET['bil']))
	$bil2 = " AND bil_id = '" . htmlspecialchars($_GET['bil'], ENT_QUOTES) . "' ";
else
	$bil2 = "";
	
mysql_select_db($database_financedb, $financedb);
$query_bil = "SELECT * FROM finance.bil WHERE bil_status = 1 AND EXISTS (SELECT * FROM finance.jkb WHERE jkb.bil_id = bil.bil_id AND jkb.jkb_status = 1) ORDER BY bil_no ASC";
$bil = mysql_query($query_bil, $financedb) or die(mysql_error());
$row_bil = mysql_fetch_assoc($bil);
$totalRows_bil = mysql_num_rows($bil);
	
mysql_select_db($database_financedb, $financedb);
$query_jkb = "SELECT * FROM finance.jkb WHERE jkb_status = 1 " . $bil2 ." AND classification !='1' AND bil_id != '0' ORDER BY jkb_date_y DESC, jkb_date_m DESC, jkb_date_d DESC, jkb_id DESC";
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
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
              <?php include('../inc/menu_jkbsenarai.php');?>
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            <li class="form_back">
              <form id="form1" name="form1" method="get" action="informjkb.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
            	        <td class="label noline">Bil</td>
            	        <td width="100%" class="noline">
                          <select name="bil" id="bil">
                          <?php
							do {  
							?>
                         <option <?php if((isset($_GET['bil']) && $_GET['bil']==$row_bil['bil_id'])) echo "selected=\"selected\"";?> value="<?php echo $row_bil['bil_id']?>"><?php echo $row_bil['bil_no'] ."/". date('Y', mktime(0, 0, 0, 1,1, $row_bil['bil_date_y']));?></option>
                          <?php
							} while ($row_bil = mysql_fetch_assoc($bil));
							  $rows = mysql_num_rows($bil);
							  if($rows > 0) {
								  mysql_data_seek($bil, 0);
								  $row_bil = mysql_fetch_assoc($bil);
							  }
							?>
                        </select>
                    <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
          	        </tr>
                    </table>
              </form>
            </li>
            	<li>
            	  <div class="note">Senarai permohonan  <strong> <?php if(isset($_GET['bil'])) echo "<strong>" . getBilNoByBilID($_GET['bil']) . "</strong>"; ?></strong></div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_jkb > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Semakan</th>
                    </tr>
                    <?php $i=1; do { ?>
                  	<tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getJKBDate($row_jkb['jkb_id']);?></td>
                    	<td align="left" valign="middle" class="txt_line">
                        <a href="informjkbdetail.php?id=<?php echo getID(htmlspecialchars($row_jkb['jkb_id'],ENT_QUOTES)); ?>">
                        <div><strong><?php echo $row_jkb['jkb_activity']; ?></strong></div>
                        <div class="txt_color1">Oleh : <?php echo getFullNameByStafID($row_jkb['user_stafid']);?></div>
                        <div class="txt_color1"><?php echo getFullDirectory(getDirIDByJkbID($row_jkb['jkb_id']));?></div>
                        <div class="txt_color1">Kelulusan : <?php if($row_jkb['classification']==0) echo "PENGARAH BAHAGIAN"; if($row_jkb['classification']==1) echo "AHLI MESYUARAT"; if($row_jkb['classification']==2) echo "KETUA PEGAWAI EKSEKUTIF (KPE)";?></div>
                        </a>
                        </td>
                		<td align="center" valign="middle"><?php echo iconJKBApp($row_jkb['jkb_id']);?></td>
                      </tr>
                      <?php $i++; } while ($row_jkb = mysql_fetch_assoc($jkb)); ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_jkb ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle">Tiada rekod dijumpai</td>
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
mysql_free_result($jkb);
mysql_free_result($bil);
?>
<?php include('../inc/footinc.php');?> 