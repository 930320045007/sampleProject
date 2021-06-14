<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/selidikdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/selidikfunc.php');?>
<?php $menu='14';?>
<?php $menu2='51';?>
<?php
mysql_select_db($database_selidikdb, $selidikdb);
$query_sur = "SELECT * FROM selidik.surveydetail WHERE (group_id = '" . getGroupIDByUserID($row_user['user_stafid']) . "' OR group_id = '0') AND (division_id = '" . getDirSubIDByUser($row_user['user_stafid']) . "' OR division_id = '0') AND sd_view = 1 AND sd_status = 1 ORDER BY sd_id DESC";
$sur = mysql_query($query_sur, $selidikdb) or die(mysql_error());
$row_sur = mysql_fetch_assoc($sur);
$totalRows_sur = mysql_num_rows($sur);
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
        <?php include('../inc/menu_qna.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
                <li>
                  <form id="form1" name="form1" method="post" action="">
                  <div class="note">Senarai soal selidik </div>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    	<?php if ($totalRows_sur > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                          <th align="center" valign="middle" nowrap="nowrap">Tarikh Mula</th>
                          <th align="center" valign="middle" nowrap="nowrap">Tarikh Tamat</th>
                          <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                          <th nowrap="nowrap">&nbsp;</th>
                        </tr>
                        <?php $i=1; do { ?>
                      <tr class="<?php if(checkStartDateBySDID($row_sur['sd_id'], date('d'), date('m'), date('Y')) && checkEndDateBySDID($row_sur['sd_id'], date('d'), date('m'), date('Y'))) echo "on"; else echo "offcourses";?>">
                            <td align="center" valign="middle"><?php echo $i;?></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php echo getSurveyDateStart($row_sur['sd_id']);?><br/></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php echo getSurveyDateEnd($row_sur['sd_id']);?></td>
                            <td align="left" valign="middle" class="txt_line">
                            <?php if(checkStartDateBySDID($row_sur['sd_id'], date('d'), date('m'), date('Y')) && checkEndDateBySDID($row_sur['sd_id'], date('d'), date('m'), date('Y'))){?><a href="surveydetailuser.php?id=<?php echo getID($row_sur['sd_id']); ?>"><?php }; ?>
							<?php echo $row_sur['sd_title']; ?>
                        	<br/>
                            <span class="txt_color1 inputlabel2">Pengkhususan : <?php if($row_sur['division_id']!=0)echo getDirSubName($row_sur['division_id']); else echo "Semua";?> &nbsp; &bull; &nbsp; Kumpulan : <?php if($row_sur['group_id']!=0) echo getGroup($row_sur['group_id']); else echo "Semua";?></span>
                            <?php if(checkStartDateBySDID($row_sur['sd_id'], date('d'), date('m'), date('Y')) && checkEndDateBySDID($row_sur['sd_id'], date('d'), date('m'), date('Y'))){?></a><?php }; ?>
                            </td>
                            <td><?php if(checkAnswerBySDID($row_user['user_stafid'], $row_sur['sd_id'])) echo "&radic;";?></td>
                          </tr>
                          <?php $i++; } while ($row_sur = mysql_fetch_assoc($sur)); ?>
                        <tr>
                          <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_sur ?> rekod dijumpai</td>
                        </tr>
                      	<?php } else { // Show if recordset not empty ?>
                        <tr>
                          <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
                  </form>
                </li>
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
mysql_free_result($sur);
?>
<?php include('../inc/footinc.php');?> 