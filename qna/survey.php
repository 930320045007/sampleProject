<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/selidikdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/admin_sta.php');?>
<?php include('../inc/selidikfunc.php');?>
<?php $menu='13';?>
<?php $menu2='49';?>
<?php
$wsql2 = "";

if(isset($_GET['div']))
{
	$div = htmlspecialchars($_GET['div'], ENT_QUOTES);
	$wsql2 .= " AND division_id = '" . $div . "'";
} else
	$div = 0;
	
if(isset($_GET['gro']))
{
	$gro = htmlspecialchars($_GET['gro'], ENT_QUOTES);
	$wsql2 .= " AND group_id = '" . $gro . "'";
} else
	$gro = 0;
	
mysql_select_db($database_selidikdb, $selidikdb);
$query_sur = "SELECT * FROM selidik.surveydetail WHERE sd_status = 1 " . $wsql2 . " ORDER BY sd_id DESC";
$sur = mysql_query($query_sur, $selidikdb) or die(mysql_error());
$row_sur = mysql_fetch_assoc($sur);
$totalRows_sur = mysql_num_rows($sur);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kumpsasaran = "SELECT * FROM `group` WHERE group_status = 1 AND group_view = 1 ORDER BY group_id ASC";
$kumpsasaran = mysql_query($query_kumpsasaran, $hrmsdb) or die(mysql_error());
$row_kumpsasaran = mysql_fetch_assoc($kumpsasaran);
$totalRows_kumpsasaran = mysql_num_rows($kumpsasaran);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_khusus = "SELECT dir_id, dir_name FROM dir WHERE dir_type = 1 AND dir_status = 1 ORDER BY dir_sort ASC";
$khusus = mysql_query($query_khusus, $hrmsdb) or die(mysql_error());
$row_khusus = mysql_fetch_assoc($khusus);
$totalRows_khusus = mysql_num_rows($khusus);
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
        <?php include('../inc/menu_ict.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="survey.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Kumpulan</td>
                        <td width="100%">
                        <select name="div" id="div">
                          <option <?php if($div == 0) echo "selected=\"selected\"";?> value="0">Semua</option>
                          <?php
							do {  
							?>
                          <option <?php if($div == $row_kumpsasaran['group_id']) echo "selected=\"selected\"";?> value="<?php echo $row_kumpsasaran['group_id']?>"><?php echo $row_kumpsasaran['group_name']?></option>
                          <?php
							} while ($row_kumpsasaran = mysql_fetch_assoc($kumpsasaran));
							  $rows = mysql_num_rows($kumpsasaran);
							  if($rows > 0) {
								  mysql_data_seek($kumpsasaran, 0);
								  $row_kumpsasaran = mysql_fetch_assoc($kumpsasaran);
							  }
							?>
                        </select>
                          <select name="gro" id="gro">
                          <option <?php if($gro == $row_khusus['dir_id']) echo "selected=\"selected\"";?> value="0">Semua</option>
                            <?php
							do {  
							?>
                            <option <?php if($gro == $row_khusus['dir_id']) echo "selected=\"selected\"";?> value="<?php echo $row_khusus['dir_id']?>"><?php echo $row_khusus['dir_name']?></option>
                            <?php
								} while ($row_khusus = mysql_fetch_assoc($khusus));
								  $rows = mysql_num_rows($khusus);
								  if($rows > 0) {
									  mysql_data_seek($khusus, 0);
									  $row_khusus = mysql_fetch_assoc($khusus);
								  }
								?>
                          </select>
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
                        <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                        <td><input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onclick="MM_goToURL('parent','surveyadd.php');return document.MM_returnValue" /></td>
                        <?php }; ?>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                <div class="note">Senarai soal selidik</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_sur > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh Mula</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh Tamat</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">Jumlah</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getSurveyDateStart($row_sur['sd_id']);?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getSurveyDateEnd($row_sur['sd_id']);?></td>
                        <td align="left" valign="middle" class="txt_line">
                        <a href="surveydetail.php?id=<?php echo $row_sur['sd_id']; ?>">
						<?php echo $row_sur['sd_title']; ?>
                        <br/><span class="txt_color1 inputlabel2">Pengkhususan : <?php if($row_sur['division_id']!=0)echo getDirSubName($row_sur['division_id']); else echo "Semua";?> &nbsp; &bull; &nbsp; Kumpulan : <?php if($row_sur['group_id']!=0) echo getGroup($row_sur['group_id']); else echo "Semua";?></span>
                        </a>
                        </td>
                        <td align="center" valign="middle" nowrap="nowrap" class="txt_line">
						<div><?php echo countAnswerBySDID($row_sur['sd_id']);?> / <?php echo totalStaff(getSurveyDateStart($row_sur['sd_id'], 1), getSurveyDateStart($row_sur['sd_id'], 2), getSurveyDateStart($row_sur['sd_id'], 3));?></div>
                        <div><?php echo percentUserAnswer($row_sur['sd_id']);?>%</div></td>
                        <td align="center" valign="middle"><?php if(getSurveyView($row_sur['sd_id'])) echo "&radic;"; else echo "&nbsp;";?></td>
                        <td nowrap="nowrap"><ul class="func"><li><a href="surveyedit.php?id=<?php echo $row_sur['sd_id']; ?>">Edit</a></li><li>X</li></ul></td>
                      </tr>
                      <?php $i++; } while ($row_sur = mysql_fetch_assoc($sur)); ?>
                    <tr>
                      <td colspan="7" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_sur ?>  rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="7" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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
<?php
mysql_free_result($kumpsasaran);

mysql_free_result($khusus);

mysql_free_result($sur);
?>
<?php include('../inc/footinc.php');?> 