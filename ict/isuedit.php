<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='28';?>
<?php
if(isset($_GET['id']))
	$id = htmlspecialchars($_GET['id'], ENT_QUOTES);
else
	$id = '0';
	
  mysql_select_db($database_ictdb, $ictdb);
  $query_answer = "SELECT * FROM ict.report_answer WHERE reportanswer_status = '1' AND reportanswer_id = '" . $id . "' ORDER BY reportanswer_id ASC";
  $answer = mysql_query($query_answer, $ictdb) or die(mysql_error());
  $row_answer = mysql_fetch_assoc($answer);
  $totalRows_answer = mysql_num_rows($answer);
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                <li>
                <div class="note">Kemaskini isu berikut :</div>
                <form id="form1" name="form1" method="post" action="../sb/update_reportanswer.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle" class="label">Tajuk</td>
                      <td width="100%" align="left" valign="middle"><input name="reportanswer_title" type="text" class="w70" id="reportanswer_title" value="<?php echo $row_answer['reportanswer_title']; ?>" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="label">Perkara</td>
                      <td width="100%" align="left" valign="middle">
                      <textarea name="reportanswer_detail" rows="7" class="w70" id="reportanswer_detail"><?php echo $row_answer['reportanswer_detail']; ?></textarea>
                      <?php getEditor('reportanswer_detail', '1'); ?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="label noline">&nbsp;</td>
                      <td width="100%" align="left" valign="middle" class="noline">
                      <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                      <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onClick="MM_goToURL('parent','isu.php?rt=<?php echo getReportTypeBySymptomID($row_answer['reportsymptom_id']);?>&rst=<?php echo getReportSubTypeBySymptomID($row_answer['reportsymptom_id']);?>');return document.MM_returnValue"/>
                      <input name="reportsymptom_id" type="hidden" id="reportsymptom_id" value="<?php echo $row_answer['reportsymptom_id']; ?>" />
                      <input name="reporttype_id" type="hidden" id="reporttype_id" value="<?php echo getReportTypeBySymptomID($row_answer['reportsymptom_id']);?>" />
                      <input name="reportsubtype_id" type="hidden" id="reportsubtype_id" value="<?php echo getReportSubTypeBySymptomID($row_answer['reportsymptom_id']);?>" />
                      <input name="reportanswer_id" type="hidden" value="<?php echo $row_answer['reportanswer_id']; ?>" />
                      <input name="MM_update" type="hidden" value="ans" />
                      </td>
                    </tr>
                  </table>
                </form>
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
<?php mysql_free_result($answer);?>
<?php include('../inc/footinc.php');?> 