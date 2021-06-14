<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='8';?>
<?php $menu2='30';?>
<?php
mysql_select_db($database_ictdb, $ictdb);
$query_reporttype = "SELECT report_symptom.reporttype_id, report_type.reporttype_name FROM ict.report_symptom LEFT JOIN ict.report_type On report_type.reporttype_id = report_symptom.reporttype_id WHERE report_symptom.reportsymptom_status=1 AND EXISTS (SELECT * FROM report_answer WHERE reportanswer_status = 1 AND report_answer.reportsymptom_id = report_symptom.reportsymptom_id) GROUP BY report_symptom.reporttype_id ORDER BY report_type.reporttype_name ASC";
$reporttype = mysql_query($query_reporttype, $ictdb) or die(mysql_error());
$row_reporttype = mysql_fetch_assoc($reporttype);
$totalRows_reporttype = mysql_num_rows($reporttype);

if(isset($_GET['rt'])){
	$rt = htmlspecialchars($_GET['rt'], ENT_QUOTES);
} else 
{
	$rt = '0';
}

if(isset($_GET['rst'])){
	$rst = htmlspecialchars($_GET['rst'], ENT_QUOTES);
} else 
{
	$rst = '0';
}

mysql_select_db($database_ictdb, $ictdb);
$query_symptom = "SELECT * FROM ict.report_symptom WHERE reporttype_id = '" . $rt . "' AND reportsubtype_id = '" . $rst . "' AND reportsymptom_status = '1' AND EXISTS (SELECT * FROM report_answer WHERE report_answer.reportsymptom_id = report_symptom.reportsymptom_id AND report_answer.reportanswer_status='1')";
$symptom = mysql_query($query_symptom, $ictdb) or die(mysql_error());
$row_symptom = mysql_fetch_assoc($symptom);
$totalRows_symptom = mysql_num_rows($symptom);

if(isset($_GET['rt']) && isset($_GET['rst'])){
	mysql_select_db($database_ictdb, $ictdb);
	$query_rst2 = "SELECT report_symptom.reportsubtype_id FROM ict.report_answer LEFT JOIN ict.report_symptom ON report_symptom.reportsymptom_id = report_answer.reportsymptom_id WHERE report_symptom.reporttype_id = '" . $rt . "' AND report_answer.reportanswer_status = 1 GROUP BY report_symptom.reportsubtype_id";
	$rst2 = mysql_query($query_rst2, $ictdb) or die(mysql_error());
	$row_rst2 = mysql_fetch_assoc($rst2);
	$totalRows_rst2 = mysql_num_rows($rst2);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language="javascript">
function checkForm(form)
{
	form.buttonfeedback.disabled=true;
	form.buttonfeedback.value="Proses...";
	return true;
}
</script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
<div class="content">
        
        <?php include('../inc/menu_ict_user.php');?>
<div class="tabbox">
          <div class="profilemenu">
                <ul>
                <?php if(!$maintenance){?>
                <?php if(!checkFeedbackApprovalByUserID($row_user['user_stafid'])){?>
				  <li class="form_back">
          			<form action="report.php" method="get">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Kategori</td>
                        <td width="100%" class="noline">
                          <select name="rt" id="rt" onChange="dochange('8', 'rst', this.value, '0', '0');">
                          	<option value="0">Sila pilih kategori</option>
                            <?php
							do {  
							?>
                            <option <?php if($rt==$row_reporttype['reporttype_id']) echo "selected=\"selected\"";?> value="<?php echo $row_reporttype['reporttype_id']?>"><?php echo $row_reporttype['reporttype_name']?></option>
                            <?php
							} while ($row_reporttype = mysql_fetch_assoc($reporttype));
							  $rows = mysql_num_rows($reporttype);
							  if($rows > 0) {
								  mysql_data_seek($reporttype, 0);
								  $row_reporttype = mysql_fetch_assoc($reporttype);
							  }
							?>
                          </select>
                          <?php if(!isset($_GET['rt']) && !isset($_GET['rst'])){?>
                          <select name="rst" id="rst">
                          	<option value="0">Sila pilih kategori</option>
                          </select>
                          <?php } else { ?>
  						<select name="rst" id="rst">
                          <?php if ($totalRows_rst2 > 0) { // Show if recordset not empty ?>
							<?php do { ?>
                            <option value="<?php echo $row_rst2['reportsubtype_id']?>" <?php if (!(strcmp($row_rst2['reportsubtype_id'], $_GET['rst']))) {echo "selected=\"selected\"";} ?>><?php echo getReportSubTypeByID($row_rst2['reportsubtype_id']);?></option>
                            <?php } while ($row_rst2 = mysql_fetch_assoc($rst2)); ?>
                          <?php } else { ?>
                          	<option value="0">Sila pilih kategori</option>
                          <?php }; ?>
                          </select>
                        <?php }; ?>
                        <input name="proses" type="submit" class="submitbutton" id="proses" value="Semak" /></td>
                      </tr>
                    </table>
          			</form>
					</li>
                    <?php if(isset($_GET['rt']) && isset($_GET['rst'])){?>
						<?php if ($totalRows_symptom > 0) { // Show if recordset not empty ?>
                  		<?php $i = 1; do { ?>
						<div class="line_b">
							<li>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td class="noline"><?php echo $i . ".0";?></td>
                                <td width="100%" class="noline"><span class="cursorpoint" onClick="toggleview2('formqa<?php echo $row_symptom['reportsymptom_id']; ?>'); return false;"><?php echo $row_symptom['reportsymptom_question']?></span></td>
                              </tr>
                              </table>
                           </li>
                  			<div id="formqa<?php echo $row_symptom['reportsymptom_id']; ?>" class="hidden2">
                            <li class="line_dot">
                            <?php
							mysql_select_db($database_ictdb, $ictdb);
							$query_answer = "SELECT * FROM ict.report_answer WHERE reportanswer_status = '1' AND reportsymptom_id = '" . $row_symptom['reportsymptom_id'] . "' ORDER BY reportanswer_id ASC";
							$answer = mysql_query($query_answer, $ictdb) or die(mysql_error());
							$row_answer = mysql_fetch_assoc($answer);
							$totalRows_answer = mysql_num_rows($answer);
							?>
                            <?php if ($totalRows_answer > 0) { // Show if recordset not empty ?>
							    <table width="100%" border="0" cellspacing="0" cellpadding="0">
							      <tr>
							        <td align="center" valign="top" nowrap="nowrap" class="noline">&nbsp;</td>
							        <td width="100%" align="left" valign="top" class="noline">
                                    <div class="txt_size3"><strong>Panduan</strong></div>
						            </td>
						          </tr>
						        </table>
							  <?php $j=1; do { ?>
							    <table width="100%" border="0" cellspacing="0" cellpadding="0">
							      <tr>
							        <td align="center" valign="top" nowrap="nowrap" class="noline">&nbsp;</td>
							        <td align="center" valign="top" nowrap="nowrap" class="noline"><div class="txt_line"><?php echo $i . "." . $j;?></div></td>
							        <td width="100%" align="left" valign="top" class="noline">
							          <div class="txt_line">
							            <?php if($row_answer['reportanswer_title']!=NULL){?>
                                        <strong><?php echo htmlspecialchars_decode($row_answer['reportanswer_title'], ENT_QUOTES);?></strong><br/>
										<?php }; ?>
							            <?php echo htmlspecialchars_decode($row_answer['reportanswer_detail'], ENT_QUOTES);?>
                                      </div>
                                      <div class="inputlabel2 padt">Oleh <?php echo getFullNameByStafID($row_answer['reportanswer_by']); ?> &nbsp; &bull; &nbsp; <?php echo $row_answer['reportanswer_date']; ?></div>
						            </td>
						          </tr>
						        </table>
						      <?php $j++; } while ($row_answer = mysql_fetch_assoc($answer)); ?>
							<?php } else { ?>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="100%" align="left" valign="top" class="noline"><img src="<?php echo $url_main;?>icon/sign_error.png" alt="Error" width="16" height="16" border="0" align="absbottom" /> &nbsp; Unit ICT dalam proses mengemaskini kandungan dalam isu ini. Harap maklum.</td>
                                  </tr>
                                </table>
                              <?php }; ?>
							<?php mysql_free_result($answer);?>
                            </li>
                            <?php if ($totalRows_answer > 0) { // Show if recordset not empty ?>
                            <li class="form_back">
                            <?php if(!checkReportTodayByUserID($row_user['user_stafid'], $row_symptom['reportsymptom_id'])){?>
                            <form action="../sb/add_ictuserreport.php" method="post" id="formfeedback<?php echo $row_symptom['reportsymptom_id']; ?>" onsubmit="return checkForm(this) && true;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td nowrap="nowrap" class="noline">Adakah panduan diatas membantu ?</td>
                                <td width="100%" class="noline">
                                <select name="userreport_result" id="userreport_result">
                                    <option value="1" selected="selected">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                                </td>
                                <td class="noline">
                                <input name="MM_insert" type="hidden" value="reportsymptom" />
                                <input name="reportsymptom_id" type="hidden" id="reportsymptom_id" value="<?php echo $row_symptom['reportsymptom_id']; ?>" />
                                <input class="submitbutton" name="buttonfeedback" type="submit" id="buttonfeedback" value="Hantar" />
                                </td>
                              </tr>
                            </table>
                            </form>
                            <?php } else {?>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td class="noline">Terima kasih atas maklum balas.</td>
                              </tr>
                            </table>
                            <?php }; ?>
                            </li>
                            <?php }; ?>
                           </div>
                  </div>
						  <?php
						  $i++;
                            } while ($row_symptom = mysql_fetch_assoc($symptom));
                              $rows = mysql_num_rows($symptom);
                              if($rows > 0) {
                                  mysql_data_seek($symptom, 0);
                                  $row_symptom = mysql_fetch_assoc($symptom);
                              }
                            ?>
                        <?php } else { ?>
                            <li class="line_b">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="100%" align="center" class="noline txt_line">Tiada isu yang direkodkan. Sila emailkan aduan anda ke email berikut <strong>support@msn.gov.my</strong> dengan menyertakan<br />
 							Nama, Cawangan/Pusat/Unit, Staf ID, dan penerangan ringkas berkaitan permasalahan anda.</td>
                              </tr>
                            </table>
                            </li>
                        <?php }; ?>
                    <?php } else {?>
                    <li>
                   	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    	  <tr>
                    	    <td align="center" valign="middle" class="noline txt_line">
                            <div>Sila pilih kategori berkaitan dengan aduan atau permasalahan untuk rujukan. </div><br />
                            <br />
                            <div class="note">Jika isu yang dihadapi tiada dalam senarai, sila emailkan aduan anda ke <strong>support@msn.gov.my</strong> dengan menyertakan
                            <br />
                             Nama, Cawangan/Pusat/Unit, Staf ID, dan penerangan ringkas berkaitan permasalahan anda.</div>
                            </td>
                  	    </tr>
                  	  </table>
                    </li>
                    <?php }; ?>
                    <?php } else { ?>
                    <li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="noline"><img src="../icon/sign_error.png" width="16" height="16" alt="Error" /></td>
                          <td width="100%" class="noline">Sila buat pengesahan kepada aduan sebelum ini. Klik pada 'Rekod' dan semak rekod aduan yang masih belum dibuat pengesahan</td>
                        </tr>
                      </table>
                    </li>
                    <?php }; ?>
                    <?php } else { ?>
                    <li>
                    <div class="note">Sistem dalam proses pengemaskinian dan penambahbaikkan buat sementara waktu</div>
                    </li>
                    <?php }; ?>
                </ul>
          </div>
        </div>
        <div class="inputlabel2 padt fl">Setiap aduan yang dibuat akan dinilai untuk tujuan penambahbaik perkhidmatan. Setiap pemohon hanya dibenarkan untuk membuat <strong>5 (lima)</strong> kali aduan dalam tempoh tarikh tersebut dan setiap isu yang dihantar hanya boleh dibuat sekali dalam tempoh tarikh tersebut. Sehubungan itu, pemohon diminta untuk memilih isu yang betul berkaitan permasalahan atau aduan yang ingin dibuat.</div>
        <div class="inputlabel2 padt fl">Cawangan Teknologi Maklumat berhak untuk membatalkan atau menukar maklumat aduan tanpa sebarang notis atau makluman.</div>
        <?php echo noteEmail('1');?>
<div class="inputlabel2 padt f1">Modul ini diuruskan oleh CAWANGAN TEKNOLOGI MAKLUMAT</div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($reporttype);
if(isset($_GET['rt']) && isset($_GET['rst'])){
	mysql_free_result($rst2);
}
mysql_free_result($symptom);
?>
<?php include('../inc/footinc.php');?>
