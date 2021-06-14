<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php $menu='16';?>
<?php $menu2='89';?>
<?php $menu3='4';?>
<?php
$bil2 = "";
$dir2 = "";

if(isset($_GET['bil']))
	$bil2 = "AND bil_id = '" . htmlspecialchars($_GET['bil'], ENT_QUOTES) . "' ";
else
	$bil2 = "";
	
	if(isset($_GET['dir']))
	$dir2 = "AND dir_id = '" . htmlspecialchars($_GET['dir'], ENT_QUOTES) . "' ";
else
	$dir2 = "";
	
mysql_select_db($database_financedb, $financedb);
$query_bil = "SELECT * FROM finance.bil WHERE bil_status = 1 AND EXISTS (SELECT * FROM finance.jkb WHERE jkb.bil_id = bil.bil_id AND jkb.jkb_status = 1) ORDER BY bil_no ASC";
$bil = mysql_query($query_bil, $financedb) or die(mysql_error());
$row_bil = mysql_fetch_assoc($bil);
$totalRows_bil = mysql_num_rows($bil);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT * FROM dir WHERE dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);
$totalRows_dir = mysql_num_rows($dir);

mysql_select_db($database_financedb, $financedb);
$query_report="SELECT * FROM finance.apply LEFT JOIN finance.jkb ON jkb.jkb_id = apply.jkb_id WHERE jkb.jkb_status = 1 AND apply.apply_status= 1 " . $dir2 . "  " . $bil2 ." ORDER BY jkb.jkb_date_y DESC, jkb.jkb_date_m DESC, jkb.jkb_date_d DESC, jkb.jkb_id DESC";
$report = mysql_query($query_report, $financedb) or die(mysql_error());
$row_report = mysql_fetch_assoc($report);
$totalRows_report = mysql_num_rows($report);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="js/ajaxsbmt.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<?php include('../inc/headinc.php');?>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="reportjkb.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                      <td class="noline label">Bahagian</td>
            	        <td class="noline">
            	          <select name="dir" id="dir">
            	            <?php
							do {  
							?>
                           <option <?php if(isset($_GET['dir']) && $_GET['dir']==$row_dir['dir_id']) echo "selected=\"selected\"";?> value="<?php echo $row_dir['dir_id']?>"><?php echo getFullDirectory($row_dir['dir_id'],0)?></option>
                            <?php
                            } while ($row_dir = mysql_fetch_assoc($dir));
                              $rows = mysql_num_rows($dir);
                              if($rows > 0) {
                                  mysql_data_seek($dir, 0);
                                  $row_dir = mysql_fetch_assoc($dir);
                              }
                            ?>
                          </select>
                   </td>
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
                    <td><input name="button5" type="button" class="submitbutton" id="button5" value="Cetak" onclick="MM_openBrWindow('printreportJKB.php?dir=<?php echo htmlspecialchars($_GET['dir'],ENT_QUOTES);?>&bil=<?php echo htmlspecialchars($_GET['bil'],ENT_QUOTES);?>','reportprint','status=yes,scrollbars=yes,width=800,height=600')" />
                      </td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                <div class="note">Senarai laporan permohonan JKB  <strong><?php if(isset($_GET['dir'])) echo "<strong>" . getFulldirectory($_GET['dir'],0) . "</strong>"; ?></strong> <?php if(isset($_GET['bil'])) echo "<strong>" . getBilNoByBilID($_GET['bil']) . "</strong>"; ?> </div>
                </li>
                <li class="title">Rekod Permohonan JKB</li>
                <li>
                <div class="off">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_report > 0) { // Show if recordset not empty ?>
                    <tr>
                    <th align="center" valign="middle" nowrap="nowrap">BIL</th>
                    <th align="left" valign="middle" nowrap="nowrap">PERMOHONAN</th>
                     <th align="center" valign="middle" nowrap="nowrap">CAWANGAN</th>
                    <th align="center" valign="middle" nowrap="nowrap">PERIHAL</th>
                    <th align="center" valign="middle" nowrap="nowrap">DESKRIPSI / <br />PERBELANJAAN DIPOHON</th>
                    <th align="center" valign="middle">KUANTITI</th>
                    <th align="center" valign="middle" nowrap="nowrap">PENGIRAAN</th>
                    <th align="center" valign="middle">JUMLAH (RM)</th>
                    <th align="center" valign="middle" nowrap="nowrap">KEPUTUSAN</th>
                    <th align="center" valign="middle">CATATAN</th>
                    </tr>
					<?php $i=1; do { ?>
                  <tr>
                       <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td width="50%" align="left" valign="middle"><?php echo getJkbActivityByID($row_report['jkb_id']);?></td>
                        <td align="center" valign="middle"><?php echo getFullDirectory(getDirIDByJkbID($row_report['jkb_id']),0);?></td>
                        <td width="50%" align="center" valign="middle"><?php if(getJkbDetailByID($row_report['jkb_id'])!='') echo getJkbDetailByID($row_report['jkb_id']); else echo "-"; ?></td>
                        <td align="center" valign="middle"><?php echo getApplyDescriptionByApplyID($row_report['apply_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getApplyQuantityByApplyID($row_report['apply_id']); ?></td>
                        <td align="center" valign="middle"><?php echo getApplyCalculationByApplyID($row_report['apply_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getApplyAmountByApplyID($row_report['apply_id']); ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getStatusNameByID(getStatusByID($row_report['apply_id'])); ?></td>
                        <td align="center" valign="middle"><?php if(getFinNoteByApplyID($row_report['apply_id'])!='') echo getFinNoteByApplyID($row_report['apply_id']); else echo "-"; ?></td> 
                      </tr>
                      <?php $i++; } while ($row_report = mysql_fetch_assoc($report)); ?>
                    <tr>
                      <td colspan="10" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_report ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="10" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                  </div>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="gap">&nbsp;</li>
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
mysql_free_result($bil);
mysql_free_result($dir);
mysql_free_result($report);
?>
<?php include('../inc/footinc.php');?> 