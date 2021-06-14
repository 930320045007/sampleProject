<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='28';?>
<?php
mysql_select_db($database_ictdb, $ictdb);
$query_reporttype = "SELECT * FROM report_type WHERE reporttype_status = 1 ORDER BY reporttype_name ASC";
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
$query_symptom = "SELECT * FROM ict.report_symptom WHERE reporttype_id = '" . $rt . "' AND reportsubtype_id = '" . $rst . "' AND reportsymptom_status = '1'";
$symptom = mysql_query($query_symptom, $ictdb) or die(mysql_error());
$row_symptom = mysql_fetch_assoc($symptom);
$totalRows_symptom = mysql_num_rows($symptom);

if(isset($_GET['rt']) && isset($_GET['rst'])){
	mysql_select_db($database_ictdb, $ictdb);
	$query_rst2 = "SELECT * FROM ict.report_subtype WHERE reporttype_id = '" . $rt . "' AND reportsubtype_status = '1' ORDER BY reportsubtype_name ASC";
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
            	<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
				  <li class="form_back">
          			<form action="isu.php" method="get">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Kategori</td>
                        <td width="100%" class="noline">
                          <select name="rt" id="rt" onChange="dochange('9', 'rst', this.value, '0');">
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
                            <option value="<?php echo $row_rst2['reportsubtype_id']?>" <?php if (!(strcmp($row_rst2['reportsubtype_id'], $_GET['rst']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rst2['reportsubtype_name']?></option>
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
                  			<div class="hidden2" id="formqa<?php echo $row_symptom['reportsymptom_id']; ?>">
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
							            <?php if($row_answer['reportanswer_title']!=NULL){?><strong><?php echo htmlspecialchars_decode($row_answer['reportanswer_title']);?></strong><br/><?php }; ?>
							            <?php echo htmlspecialchars_decode($row_answer['reportanswer_detail']);?>
                                        </div>
                                        <div class="inputlabel2 padt">Oleh <?php echo getFullNameByStafID($row_answer['reportanswer_by']); ?> &nbsp; &bull; &nbsp; <?php echo $row_answer['reportanswer_date']; ?></div>
						            </td>
							        <td align="center" valign="middle" nowrap="nowrap" class="noline"><ul class="func"><li><a href="isuedit.php?id=<?php echo $row_answer['reportanswer_id']; ?>">Edit</a></li><li>X</li></ul></td>
						          </tr>
						        </table>
						      <?php $j++; } while ($row_answer = mysql_fetch_assoc($answer)); ?>
							<?php } else { ?>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="100%" align="left" valign="top" class="noline">Tiada isu yang direkodkan</td>
                                  </tr>
                                </table>
                              <?php }; ?>
						<?php mysql_free_result($answer);?>
                            </li>
                            <li class="form_back2">
                              <form id="form1" name="form1" method="post" action="../sb/add_reportanswer.php">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="left" valign="middle" class="label">Tajuk</td>
                                    <td width="100%" align="left" valign="middle"><input name="reportanswer_title" type="text" class="w70" id="reportanswer_title" /></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="label">Perkara</td>
                                    <td width="100%" align="left" valign="middle">
                                    <?php $txt_reportanswer = "reportanswer_detail" . $row_symptom['reportsymptom_id']; ?>
                                    <textarea name="<?php echo $txt_reportanswer;?>" rows="7" class="w70" id="<?php echo $txt_reportanswer;?>"></textarea>
                                    <?php getEditor($txt_reportanswer, '1'); ?></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="label noline">&nbsp;</td>
                                    <td width="100%" align="left" valign="middle" class="noline">
                                    <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                                    <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onClick="toggleview2('formqa<?php echo $row_symptom['reportsymptom_id']; ?>'); return false;"/>
									<input name="reportsymptom_id" type="hidden" id="reportsymptom_id" value="<?php echo $row_symptom['reportsymptom_id']; ?>" />
                                  <input name="reporttype_id" type="hidden" id="reporttype_id" value="<?php echo $rt;?>" />
                                  <input name="reportsubtype_id" type="hidden" id="reportsubtype_id" value="<?php echo $rst;?>" />
                                  <input name="MM_insert" type="hidden" value="ans" />
                                    </td>
                                  </tr>
                                </table>
                              </form>
                            </li>
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
                                <td width="100%" class="noline">Tiada isu yang direkodkan</td>
                              </tr>
                            </table>
                            </li>
                        <?php }; ?>
                    <?php } else {?>
                    <li>
                   	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    	  <tr>
                    	    <td align="center" valign="middle" class="noline">Sila pilih kategori berkaitan dengan aduan atau permasalahan untuk rujukan.</td>
                  	    </tr>
                  	  </table>
                    </li>
                    <?php }; ?>
                    <?php if(isset($_GET['rt']) && isset($_GET['rst'])){?>
                    <li class="form_back2">
                      <form id="form1" name="form1" method="post" action="../sb/add_reportisu.php">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" valign="middle" class="label noline">Isu</td>
                            <td width="100%" align="left" valign="middle" class="noline"><label for="reportsymptom_question"></label>
                              <input name="MM_insert" type="hidden" id="MM_insert" value="isu" />
                              <input name="reporttype_id" type="hidden" id="reporttype_id" value="<?php echo $rt;?>" />
                              <input name="reportsubtype_id" type="hidden" id="reportsubtype_id" value="<?php echo $rst;?>" />
                              <input name="reportsymptom_question" type="text" class="w70" id="reportsymptom_question" />
                            <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" /></td>
                          </tr>
                        </table>
                      </form>
                    </li>
                    <?php }; ?>
                    <?php } else { ?>
                        <li>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" class="noline"><?php echo noteError(1);?></td>
                          </tr>
                        </table>
                        </li>
                    <?php }; ?>
                </ul>
          </div>
        </div>
        <?php echo noteEmail('1');?>
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
