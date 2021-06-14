<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/selidikdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/selidikfunc.php');?>
<?php $menu='14';?>
<?php $menu2='51';?>
<?php
if(isset($_GET['id']))
	$id = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
else
	$id = '-1';
	
mysql_select_db($database_selidikdb, $selidikdb);
$query_sur = "SELECT * FROM selidik.surveydetail WHERE sd_view = 1 AND sd_status = 1 AND sd_id = " . $id . " ORDER BY sd_id DESC";
$sur = mysql_query($query_sur, $selidikdb) or die(mysql_error());
$row_sur = mysql_fetch_assoc($sur);
$totalRows_sur = mysql_num_rows($sur);

mysql_select_db($database_selidikdb, $selidikdb);
$query_bhg = "SELECT * FROM selidik.questiongroup WHERE sd_id = " . $id . " ORDER BY qg_sort ASC";
$bhg = mysql_query($query_bhg, $selidikdb) or die(mysql_error());
$row_bhg = mysql_fetch_assoc($bhg);
$totalRows_bhg = mysql_num_rows($bhg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
	  <?php include('../inc/header.php');?>
        <?php if(checkSurveyMandatory($row_user['user_stafid'])==0){?>
			<?php include('../inc/menu.php');?>
		<?php }; ?>
        
      	<div class="content">
        <?php if(checkSurveyMandatory($row_user['user_stafid'])==0){?>
			<?php include('../inc/menu_qna.php');?>
		<?php }; ?>
        <div class="tabbox <?php if(checkSurveyMandatory($row_user['user_stafid'])!=0) echo "line_t";?>">
        	<div class="profilemenu">
            <?php if(getSurveyView($id)){?>
            <?php if((getGroupIDByUserID($row_user['user_stafid'])==getSurveyGroup($id)) || (getSurveyGroup($id)==0)){?>
            <?php if((getDirSubIDByUser($row_user['user_stafid'])==getSurveyDivision($id)) || (getSurveyDivision($id)==0)){?>
              <?php if(!checkAnswerBySDID($row_user['user_stafid'], $id) && checkEndDateBySDID($id, date('d'), date('m'), date('Y')) && getSurveyView($id)){?>
              <form id="form1" name="form1" method="POST" action="../sb/add_useranswer.php">
              <?php }; ?>
              <ul>
                <li>
                <div class="padb padt">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="3" class="noline"><strong><?php echo $row_sur['sd_title']; ?></strong></td>
                    </tr>
                    <tr>
                      <td colspan="3" class="noline"><div class="txt_line"><?php echo $row_sur['sd_desc']; ?></div></td>
                    </tr>
                  </table>
                </div>
                </li>
                <li>
                  <div class="note txt_line">Skala Pemarkahan : <br>
                1 - Sangat Tidak Memuaskan / Sangat Tidak Bersetuju, 2 - Tidak Memuaskan / Tidak Bersetuju, 3 - Sederhana, 4 - Memuaskan / Bersetuju, 5 - Sangat Memuaskan / Sangat Bersetuju</div></li>
				<?php do { ?>
                <li class="title"><?php echo $row_bhg['qg_title']; ?></li>
                <?php if($row_bhg['qg_desc']!=NULL){ ?><li><div class="note padb padt txt_line"><?php echo $row_bhg['qg_desc']; ?></div></li><?php }; ?>
				<?php
					mysql_select_db($database_selidikdb, $selidikdb);
					$query_soalan = "SELECT * FROM selidik.question WHERE sd_id = " . $id . " AND qg_id = " . $row_bhg['qg_id'] . " ORDER BY q_id ASC";
					$soalan = mysql_query($query_soalan, $selidikdb) or die(mysql_error());
					$row_soalan = mysql_fetch_assoc($soalan);
					$totalRows_soalan = mysql_num_rows($soalan);
				?>
                <?php if ($totalRows_soalan > 0) { // Show if recordset not empty ?>
                <li>
                <div class="padb">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th>Bil</th>
                        <th width="100%" align="left" valign="middle">Perkara</th>
                        <th nowrap="nowrap">
                    	<ul class="inputradiolabel">
                              <li>1</li>
                              <li>2</li>
                              <li>3</li>
                              <li>4</li>
                              <li>5</li>
                          </ul>
                        </th>
                    </tr>
                    <?php $i=1; do {?>
                      <tr class="on">
                        <td><?php echo $i;?></td>
                        <td width="100%"><?php echo $row_soalan['q_title']; ?><input name="qid[]" type="hidden" value="<?php echo $row_soalan['q_id']; ?>" /></td>
                        <td nowrap="nowrap">
                        <?php if(!checkAnswer($row_user['user_stafid'], $row_soalan['q_id']) && checkEndDateBySDID($id, date('d'), date('m'), date('Y')) && getSurveyView($id)){?>
                          <ul class="inputradio">
                              <li>
                                  <input type="radio" name="jawab<?php echo $row_soalan['q_id']; ?>" value="1" id="jawab_0<?php echo $row_soalan['q_id']; ?>" />
                              </li>
                              <li>
                                  <input type="radio" name="jawab<?php echo $row_soalan['q_id']; ?>" value="2" id="jawab_1<?php echo $row_soalan['q_id']; ?>" />
                              </li>
                              <li>
                                  <input checked="checked" type="radio" name="jawab<?php echo $row_soalan['q_id']; ?>" value="3" id="jawab_2<?php echo $row_soalan['q_id']; ?>" />
                              </li>
                              <li>
                                  <input type="radio" name="jawab<?php echo $row_soalan['q_id']; ?>" value="4" id="jawab_3<?php echo $row_soalan['q_id']; ?>" />
                              </li>
                              <li>
                                  <input type="radio" name="jawab<?php echo $row_soalan['q_id']; ?>" value="5" id="jawab_4<?php echo $row_soalan['q_id']; ?>" />
                              </li>
                          </ul>
                          <?php } else { ?>
                          <ul class="inputradiolabel">
                              <li <?php echo color(percentAnswer($row_soalan['q_id'], '1'));?>><?php echo percentAnswer($row_soalan['q_id'], '1'); //echo " (" . countAnswer($row_soalan['q_id'], '1') . ")";?></li>
                              <li <?php echo color(percentAnswer($row_soalan['q_id'], '2'));?>><?php echo percentAnswer($row_soalan['q_id'], '2'); //echo " (" . countAnswer($row_soalan['q_id'], '2') . ")";?></li>
                              <li <?php echo color(percentAnswer($row_soalan['q_id'], '3'));?>><?php echo percentAnswer($row_soalan['q_id'], '3'); //echo " (" . countAnswer($row_soalan['q_id'], '3') . ")";?></li>
                              <li <?php echo color(percentAnswer($row_soalan['q_id'], '4'));?>><?php echo percentAnswer($row_soalan['q_id'], '4'); //echo " (" . countAnswer($row_soalan['q_id'], '4') . ")";?></li>
                              <li <?php echo color(percentAnswer($row_soalan['q_id'], '5'));?>><?php echo percentAnswer($row_soalan['q_id'], '5'); //echo " (" . countAnswer($row_soalan['q_id'], '5') . ")";?></li>
                          </ul>
                          <?php };?>
                        </td>
                      </tr>
                      <?php $i++; } while ($row_soalan = mysql_fetch_assoc($soalan)); 
						mysql_free_result($soalan); ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_soalan ?> rekod dijumpai</td>
                    </tr>
                  </table>
                </div>
                </li>
                <?php }; // Show if recordset not empty ?>
                <?php } while ($row_bhg = mysql_fetch_assoc($bhg));?>
              <?php if(!checkAnswerBySDID($row_user['user_stafid'], $id) && checkEndDateBySDID($id, date('d'), date('m'), date('Y')) && getSurveyView($id)){?>
                <li class="form_back2 padt">
                <span id="sah">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10%" nowrap>
                        <input name="checkbox" type="checkbox" id="checkbox" value="1" />
                      </td>
                      <td width="90%" class="txt_line"><span class="checkboxRequiredMsg">&laquo; Sila buat pengesahan</span>
                      <div>Saya mengesahkan semua maklum balas yang diberikan adalah sahih berdasarkan pandangan dan penilaian saya terhadap pengalaman dan pengetahuan berkaitan tanpa melibatkan paksaan atau emosi.</div></td>
                    </tr>
                    <tr>
                      <td><input name="sd_id" type="hidden" id="sd_id" value="<?php echo $row_sur['sd_id']; ?>" /></td>
                      <td><input name="button3" type="submit" class="submitbutton" id="button3" value="Hantar" /></td>
                    </tr>
                </table>
                  </span>
                </li>
                <?php }; ?>
              </ul>
              <?php if(!checkAnswerBySDID($row_user['user_stafid'], $id)){?>
              <input type="hidden" name="MM_insert" value="form1" />
              </form>
              <?php }; ?>
              <?php } else { ?>
              <ul>
              	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left"><div class="txt_line">Soal selidik ini hanya dibuka untuk kumpulan <strong><?php echo getDirSubName(getSurveyDivision($id)); ?></strong> sahaja.</div></td>
                    </tr>
                  </table>
                </li>
              </ul>
              <?php }; ?>
              <?php } else { ?>
              <ul>
              	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left"><div class="txt_line">Soal selidik ini hanya dibuka untuk <strong><?php echo getGroup(getSurveyGroup($id)); ?></strong> sahaja.</div></td>
                    </tr>
                  </table>
                </li>
              </ul>
              <?php }; ?>
              <?php } else { ?>
              <ul>
              	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left">Soal selidik ini akan dibuka pada <strong><?php echo getSurveyDateStart($id);?></strong> sehingga <strong><?php echo getSurveyDateEnd($id);?></strong>  atau masih dalam proses kemaskini. Terima kasih.</td>
                    </tr>
                  </table>
                </li>
              </ul>
              <?php }; ?>
        	</div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sah");
</script>
</body>
</html>
<?php
mysql_free_result($sur);

mysql_free_result($bhg);
?>
<?php include('../inc/footinc.php');?> 