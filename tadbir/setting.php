<?php require_once('../Connections/hrmsdb.php'); ?>

<?php require_once('../Connections/tadbirdb.php'); ?>

<?php include('../inc/user.php');?>

<?php include('../inc/func.php');?>

<?php include('../inc/tadbirfunc.php');?>

<?php $menu='10';?>

<?php $menu2='41';?>

<?php

mysql_select_db($database_tadbirdb, $tadbirdb);

$query_hallist = "SELECT * FROM tadbir.hall WHERE hall_status = 1 ORDER BY halltype_id ASC";

$hallist = mysql_query($query_hallist, $tadbirdb) or die(mysql_error());

$row_hallist = mysql_fetch_assoc($hallist);

$totalRows_hallist = mysql_num_rows($hallist);


mysql_select_db($database_tadbirdb, $tadbirdb);

$query_halltypelist = "SELECT * FROM tadbir.hall_type WHERE halltype_status = 1 ORDER BY halltype_name ASC";

$halltypelist = mysql_query($query_halltypelist, $tadbirdb) or die(mysql_error());

$row_halltypelist = mysql_fetch_assoc($halltypelist);

$totalRows_halltypelist = mysql_num_rows($halltypelist);


mysql_select_db($database_tadbirdb, $tadbirdb);

$query_driver = "SELECT driver.* FROM tadbir.driver LEFT JOIN www.user ON user.user_stafid = driver.user_stafid WHERE driver_status = 1 ORDER BY user.user_firstname ASC, user.user_lastname ASC";

$driver = mysql_query($query_driver, $tadbirdb) or die(mysql_error());

$row_driver = mysql_fetch_assoc($driver);

$totalRows_driver = mysql_num_rows($driver);


mysql_select_db($database_tadbirdb, $tadbirdb);

$query_transport = "SELECT * FROM tadbir.transport WHERE transport_status = 1 ORDER BY transport_name ASC, transport_plat ASC";

$transport = mysql_query($query_transport, $tadbirdb) or die(mysql_error());

$row_transport = mysql_fetch_assoc($transport);

$totalRows_tranport = mysql_num_rows($transport);


mysql_select_db($database_tadbirdb, $tadbirdb);

$query_feedback = "SELECT * FROM tadbir.feedback WHERE feedback_status = 1 ORDER BY feedback_name ASC";

$feedback = mysql_query($query_feedback, $tadbirdb) or die(mysql_error());

$row_feedback = mysql_fetch_assoc($feedback);

$totalRows_feedback = mysql_num_rows($feedback);


mysql_select_db($database_tadbirdb, $tadbirdb);

$query_desc = "SELECT * FROM tadbir.description WHERE desc_status = 1 ORDER BY desc_name ASC";

$desc = mysql_query($query_desc, $tadbirdb) or die(mysql_error());

$row_desc = mysql_fetch_assoc($desc);

$totalRows_desc = mysql_num_rows($desc);


mysql_select_db($database_tadbirdb, $tadbirdb);

$query_transtype= "SELECT * FROM tadbir.transport_type WHERE transporttype_status = 1 ORDER BY transporttype_name ASC";

$transtype = mysql_query($query_transtype, $tadbirdb) or die(mysql_error());

$row_transtype = mysql_fetch_assoc($transtype);

$totalRows_transtype = mysql_num_rows($transtype);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="../css/index.css" rel="stylesheet" type="text/css" />

<?php include('../inc/headinc.php');?>

<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

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

            <div class="note">Konfigurasi untuk senarai berikut</div>

                <li class="title">Senarai Lokasi <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onclick="toggleview2('forminhall'); return false;">Tambah</span><?php }; ?></li>

                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>

                <div id="forminhall" class="hidden">

                <li>

                  <form id="form1" name="form1" method="post" action="../sb/setting_tadbir.php">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td class="label noline">Nama</td>

                        <td width="100%" class="noline">

                          <span id="hallname">

                          <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>

                          <select name="halltype_id" id="halltype_id">

                            <?php

							do {  

							?>

                            <option value="<?php echo $row_halltypelist['halltype_id']?>"><?php echo $row_halltypelist['halltype_name']?></option>

                            <?php

							} while ($row_halltypelist = mysql_fetch_assoc($halltypelist));

							  $rows = mysql_num_rows($halltypelist);

							  if($rows > 0) {

								  mysql_data_seek($halltypelist, 0);

								  $row_halltypelist = mysql_fetch_assoc($halltypelist);

							  }

							?>

                          </select>

                          <input name="hall_name" type="text" class="w50" id="hall_name" />

                          <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />

                        <input name="MM_insert_hall" type="hidden" id="MM_insert_hall" value="hall_submit" />

                        </span></td>

                      </tr>

                    </table>

                  </form>

                </li>

                </div>

                <?php }; ?>

                <li>

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td class="noline">

                      <ul class="li2c">

                      	<?php do { ?>

                   	    <li><span class="name"><?php echo getHallName($row_hallist['hall_id']); ?></span>

						            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>

                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo getHallName($row_hallist['hall_id']); ?>')" href="<?php echo $url_main;?>sb/setting_tadbir.php?hid=<?php echo getID(htmlspecialchars($row_hallist['hall_id']),ENT_QUOTES);?>">&times;</a></span>

                        <?php }; ?>

                        </li>

                      	<?php } while ($row_hallist = mysql_fetch_assoc($hallist)); ?>

                      </ul>

                      </td>

                    </tr>

                  </table>

                </li>

                  <li class="title">Jenis Kenderaan<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formtransporttype'); return false;">Tambah</span><?php }; ?></li>

              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>

              <div id="formtransporttype" class="hidden">

                <li class="form_back">

                  <form id="formtransporttype" name="formtransporttype" method="POST" action="../sb/setting_tadbir.php">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td class="label noline">Jenis Kenderaan</td>

                        <td class="noline"><label for="transporttype_name"></label>

                          <input type="hidden" name="MM_insert" value="transporttype" />

                          <input name="transporttype_name" type="text" class="w50" id="transporttype_name" onkeypress="return handleEnter(this, event)" />

                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />

                        </td>

                      </tr>

                    </table>

                  </form>

                </li>

                </div>

                <?php }; ?>

                <li>

                <div class="off">

                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td class="noline">

                    <ul class="li2c">

                    	<?php do { ?>

                    	  <li><span class="name"><?php echo $row_transtype['transporttype_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo $row_transtype['transporttype_name']; ?>')" href="../sb/setting_tadbir.php?ttid=<?php echo getID(htmlspecialchars($row_transtype['transporttype_id']),ENT_QUOTES);?>">&times;</a></span><?php }; ?></li>

                    	<?php } while ($row_transtype = mysql_fetch_assoc($transtype)); ?>

                    </ul>

                    </td>

                  </tr>

                </table>

                </div>

                </li>

                <li class="title">Senarai  Kenderaan 

                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formtransport'); return false;">Tambah</span><?php }; ?></li>

                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>

              <div id="formtransport" class="hidden">

                <li class="form_back">

                  <form id="formtransport" name="formtransport" method="POST" action="../sb/setting_tadbir.php">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td class="label noline">Nama</td>

                        <td width="50%" nowrap="nowrap" class="noline">
 
                          <input name="transport_name" type="text" id="transport_name" onkeypress="return handleEnter(this, event)" />

                        </td>

                        <td class="label noline">No Plat</td>

                        <td width="50%" class="noline">

                          <input name="transport_plat" type="text" class="w50" id="transport_plat" onkeypress="return handleEnter(this, event)" />

                          <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />

                          <input type="hidden" name="MM_insert" value="transport" />

                        </td>

                      </tr>

                    </table>

                  </form>

                </li>

              </div>

              <?php }; ?>

                 <li>

                   <?php if ($totalRows_tranport > 0) { // Show if recordset not empty ?>

                    <div class="off">

                      <table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td class="noline">

                            <ul class="li2c">

                              <?php do { ?>

                                <li><span class="name"><?php echo getTransportNameByID($row_transport['transport_id']); ?> (<?php echo getTransportPlatByID($row_transport['transport_id']);?>)</span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo getTransportNameByID($row_transport['transport_id']); ?>')" href="../sb/setting_tadbir.php?tid=<?php echo getID(htmlspecialchars($row_transport['transport_id']),ENT_QUOTES);?>">&times;</a></span><?php }; ?></li>

                                <?php } while ($row_transport = mysql_fetch_assoc($transport)); ?>

                            </ul>

                          </td>

                        </tr>

                      </table>

                    </div>

                    <?php } else { ?>

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>

                    </tr>

                    </table>

                    <?php };?>

                 </li>

                <li class="title">Senarai Pemandu<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formPemandu'); return false;">Tambah</span><?php }; ?></li>

                <div id="formPemandu" class="hidden">

                <li class="form_back">

                <form id="form2" name="form2" method="post" action="../sb/setting_tadbir.php">

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td class="label" nowrap="nowrap">Staf ID</td>

                      <td width="100%"><input name="user_stafid" type="text" class="w25" id="user_stafid" onkeypress="return handleEnter(this, event)" list="datalist1" />

                        <?php echo datalistStaf("datalist1");?>

                      <input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />

                      <input name="MM_insert" type="hidden" id="MM_insert" value="driver" /></td>

                    </tr>

                  </table>

                </form>

                </li>

                </div>

                <li>

                <div class="off">

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <?php if ($totalRows_driver > 0) { // Show if recordset not empty ?>

                    <tr>

                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>

                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama</th>

                      <th nowrap="nowrap">&nbsp;</th>

                    </tr>

                    <?php $i=1; do { ?>

                      <tr class="on">

                        <td align="center" valign="middle"><?php echo $i;?></td>

                        <td align="left" valign="middle" class="txt_line">

                          <div><strong><?php echo getFullNameByStafID($row_driver['user_stafid']) . " (" . $row_driver['user_stafid'] . ")";?></strong></div>

                          <div><?php echo getFulldirectoryByUserID($row_driver['user_stafid']);?></div>

                        </td>

                        <td nowrap="nowrap">

                            <li><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo getFullNameByStafID($row_driver['user_stafid']) . " (" . $row_driver['user_stafid'] . ")";?>')" href="../sb/setting_tadbir.php?drid=<?php echo getID(htmlspecialchars($row_driver['driver_id']),ENT_QUOTES);?>">X</a></span><?php };?></li>

                        </td>

                      </tr>

                      <?php $i++; } while ($row_driver = mysql_fetch_assoc($driver)); ?>

                    <tr>

                      <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_driver ?> rekod dijumpai</td>

                    </tr>

                  <?php } else { ?>

                    <tr>

                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>

                    </tr>

                    <?php }; ?>

                  </table>

              </div>

              </li>

              <li class="title">Soal Selidik Tempahan Kenderaan<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formfeedback'); return false;">Tambah</span><?php }; ?></li>

              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>

              <div id="formfeedback" class="hidden">

                <li class="form_back">

                  <form id="formfeedback" name="formfeedback" method="POST" action="../sb/setting_tadbir.php">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td nowrap="nowrap" class="label noline">Soalan</td>

                        <td width="100%" class="noline">

                          <input name="feedback_name" type="text" class="w50" id="feedback_name" onkeypress="return handleEnter(this, event)" />

                          <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />

                          <input type="hidden" name="MM_insert" value="feedback" />

                        </td>

                      </tr>

                    </table>

                  </form>

                </li>

                </div>

                <?php }; ?>

                <li>

                <div class="off">

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <?php if ($totalRows_feedback > 0) { // Show if recordset not empty ?>

                      <tr class="on">

                          <th nowrap="nowrap">Bil</th>

                          <th align="left" valign="middle" nowrap="nowrap">Perkara</th>

                          <th nowrap="nowrap">&nbsp;</th>

                      </tr>

                    <?php $i=1; do { ?>

                      <tr class="on">

                        <td><?php echo $i;?></td>

                        <td width="100%" align="left" valign="middle"><?php echo getFeedbackNameByID($row_feedback['feedback_id']); ?></td>

                        <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>

                        <td>

                            <li><span class="fr del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo getFeedbackNameByID($row_feedback['feedback_id']); ?>')" href="../sb/setting_tadbir.php?fid=<?php echo getID(htmlspecialchars($row_feedback['feedback_id']),ENT_QUOTES);?>">X</a></span></li>

                        </td>

                        <?php }; ?>

                      </tr>

                      <?php $i++; } while ($row_feedback = mysql_fetch_assoc($feedback)); ?>

                    <tr class="on">

                      <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_feedback ?> rekod dijumpai</td>

                    </tr>

                  <?php } else {?>

                    <tr class="on">

                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>

                    </tr>

                  <?php }; ?>

                  </table>

                </div>

                </li>

                 <li class="title">Senarai Penyelenggaraan <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formmaintenance'); return false;">Tambah</span><?php }; ?></li>

              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>

              <div id="formmaintenance" class="hidden">

                <li class="form_back">

                  <form id="formmaintenance" name="formmaintenance" method="POST" action="../sb/setting_tadbir.php">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td class="label noline">Nama</td>

                        <td class="noline"><label for="desc_name"></label>

                          <input type="hidden" name="MM_insert" value="maintenance" />

                          <input name="desc_name" type="text" class="w50" id="desc_name" onkeypress="return handleEnter(this, event)" />

                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />

                        </td>

                      </tr>

                    </table>

                  </form>

                </li>

                </div>

                <?php }; ?>

                <li>

                <div class="off">

                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td class="noline">

                    <ul class="li2c">

                    	<?php do { ?>

                    	  <li><span class="name"><?php echo $row_desc['desc_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo $row_desc['desc_name']; ?>')" href="../sb/setting_tadbir.php?did=<?php echo getID(htmlspecialchars($row_desc['desc_id']),ENT_QUOTES);?>">&times;</a></span><?php }; ?></li>

                    	<?php } while ($row_desc = mysql_fetch_assoc($desc)); ?>

                    </ul>

                    </td>

                  </tr>

                </table>

                </div>

                </li>

                <li class="gap">&nbsp;</li>

            <?php } ; ?>

            </ul>

            </div>

        </div>

        </div>

        

		<?php include('../inc/footer.php');?>

    </div>

</div>

<script type="text/javascript">

var sprytextfield1 = new Spry.Widget.ValidationTextField("hallname");

</script>

</body>

</html>

<?php

mysql_free_result($hallist);


mysql_free_result($halltypelist);


mysql_free_result($driver);


mysql_free_result($transport);


mysql_free_result($feedback);


mysql_free_result($desc);


mysql_free_result($transtype);

?>

<?php include('../inc/footinc.php');?>

