<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='81';?>
<?php
if(isset($_GET['tid']) && $_GET['tid']!=NULL)
	$transbookid = getID(htmlspecialchars($_GET['tid'],ENT_QUOTES), 0);
else
	$transbookid = '0';
  
$_SESSION['transport1'] = NULL;
unset($_SESSION['transport1']);
	
$_SESSION['driver1'] = NULL;
unset($_SESSION['driver1']);

if(isset($_POST['id']))
	$userbook = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES));
else if(isset($_GET['id']))
	$userbook = getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);
else
	$userbook = $row_user['user_stafid'];
	
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = "SELECT * FROM tadbir.transport_book WHERE transbook_id= '". $transbookid . "' AND transbook_status = 1 ORDER BY transbook_id DESC";
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_passenger = "SELECT * FROM tadbir.passenger LEFT JOIN tadbir.transport_book ON transport_book.transbook_id= passenger.transbook_id WHERE passenger_status=1 AND passenger.transbook_id= '" . $transbookid . "' ORDER BY passenger_id ASC";
$passenger = mysql_query($query_passenger, $tadbirdb) or die(mysql_error());
$row_passenger = mysql_fetch_assoc($passenger);
$totalRows_passenger = mysql_num_rows($passenger);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_journey = "SELECT * FROM tadbir.journey LEFT JOIN tadbir.transport_book ON transport_book.transbook_id = journey.transbook_id WHERE journey_status=1 AND journey.transbook_id= '" . $transbookid . "' ORDER BY journey_date_y ASC, journey_date_m ASC, journey_date_d ASC, journey_time_h ASC, journey_time_m ASC, journey_id ASC";
$journey = mysql_query($query_journey, $tadbirdb) or die(mysql_error());
$row_journey = mysql_fetch_assoc($journey);
$totalRows_journey = mysql_num_rows($journey);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_trname = "SELECT transport.* FROM tadbir.transport WHERE transport.transport_status = 1 ORDER BY transport.transport_name ASC";
$trname = mysql_query($query_trname, $tadbirdb) or die(mysql_error());
$row_trname = mysql_fetch_assoc($trname);
$totalRows_trname = mysql_num_rows($trname);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_driver = "SELECT driver.* FROM tadbir.driver LEFT JOIN www.user ON user.user_stafid = driver.user_stafid LEFT JOIN www.login ON login.user_stafid = driver.user_stafid WHERE login.login_status = 1 AND driver_status = 1 ORDER BY user_firstname ASC, user_lastname DESC";
$driver = mysql_query($query_driver, $tadbirdb) or die(mysql_error());
$row_driver = mysql_fetch_assoc($driver);
$totalRows_driver = mysql_num_rows($driver);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_transdriver = "SELECT * FROM tadbir.transdriver LEFT JOIN transport_book ON transport_book.transbook_id= transdriver.transbook_id WHERE transdriver.transbook_id= '" . $transbookid . "' ORDER BY transdriver_id ASC";
$transdriver = mysql_query($query_transdriver, $tadbirdb) or die(mysql_error());
$row_transdriver = mysql_fetch_assoc($transdriver);
$totalRows_transdriver = mysql_num_rows($transdriver);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script src="../js/ajaxsbmt.js" type="text/javascript"></script>
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
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
           	  <li><div class="note">Maklumat lengkap permohonan penggunaan kenderaan</div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" class="label">Tujuan / Program</td>
                      <td colspan="2"><?php echo $row_tr['transbook_title']; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" class="label">Bil kenderaan dicadangkan</td>
                      <td colspan="2"><?php echo $row_tr['transbook_notrans'];?></td>
                    </tr>
                    <tr>
                      <td valign="middle" class="label">Catatan</td>
                      <td colspan="2"><?php echo $row_tr['transbook_note'];?></td>
                      </tr>
                    <tr>
                      <td valign="middle" class="label">Oleh</td>
                      <td align="center" valign="middle" class="txt_line"><?php echo viewProfilePic($row_tr['transbook_by']);?></td>
                      <td width="100%" class="txt_line">
                      <div><strong><?php echo getFullNameByStafID(getUserIDByTransbookID($transbookid)) . " (" . getUserIDByTransbookID($transbookid) . ")";?></strong></div>
                      <div><?php echo getFulldirectoryByUserID($row_tr['transbook_by']);?></div>
                      <div>Ext : <?php echo getExtNoByUserID($row_tr['transbook_by']);?></div>
                      </td>
                    </tr>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <li class="title">Maklumat Perjalanan
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <span class="fr add" onclick="toggleview2('formjourney'); return false;">Tambah</span><?php }; ?>
                </li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) ){?>
                <div id="formjourney" class="hidden">
                <li>
                  <form id="form3" name="form3" method="post" action="../sb/add_journey_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle">
                        <span id="from2">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                        <div class="inputlabel2">Dari / From</div>
                        <input type="text" name="journey_from" id="journey_from" />
                        <div class="inputlabel2">Cth : ISN</div>
                        </span>
                        </td>
                        <td align="left" valign="middle">
                          <span id="to2">
                          <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                          <div class="inputlabel2">Ke / To</div>
                          <input type="text" name="journey_to" id="journey_to" />
                          <div class="inputlabel2">Cth : KBS</div>
                          </span>
                        </td>
                        <td align="left" valign="middle">
                        <div class="inputlabel2">Tarikh / Date</div>
                        <select name="journey_date_d" id="journey_date_d">
                        <?php for($i = 1; $i<=31; $i++){?>
                          <option <?php if($i<10) $i = "0" . $i; if($i==date('d')) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php }; ?>
                        </select>
                          <select name="journey_date_m" id="journey_date_m">
                        <?php for($j = 1; $j<=12; $j++){?>
                          <option <?php if($j<10) $j = "0" . $j; if($j==date('m')) echo "selected=\"selected\"";?> value="<?php echo $j;?>"><?php echo $j;?></option>
                        <?php }; ?>
                          </select>
                          <select name="journey_date_y" id="journey_date_y">
                        <?php for($k = date('Y'); $k<=(date('Y')+2); $k++){?>
                          <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                        <?php }; ?>
                          </select>
                        </td>
                        <td align="left" valign="middle">
                        <div class="inputlabel2">Masa / Time</div>
                        <select name="journeytime" id="journeytime">
							<?php for($i=0; $i<24; $i++){?>
								<?php for($j=0; $j<60; $j+=15){?>
                                	<option <?php if($i == 9 && $j == 0) echo "selected=\"selected\"";?> value="<?php echo date('H:i', mktime($i, $j, 0, 1, 1, date('Y')));?>"><?php echo date('h:i A', mktime($i, $j, 0, 1, 1, date('Y')));?></option>
                                <?php }; ?>
                            <?php }; ?>
                        </select>
                        </td>
                        <td align="left" valign="middle">
                        <input name="transbookid" type="hidden" id="transbookid" value="<?php echo getID(htmlspecialchars($_GET['tid'],ENT_QUOTES),0);?>" /> 
                        <input name="button5" type="submit" class="submitbutton" id="button5" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <li class="gap">&nbsp;</li>
                <li>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if ($totalRows_journey > 0) { // Show if recordset not empty ?>
<tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="25%" align="left" valign="middle" nowrap="nowrap">Dari</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                      <th width="25%" align="left" valign="middle" nowrap="nowrap">Ke</th>
                      <th width="25%" align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                      <th width="25%" align="center" valign="middle" nowrap="nowrap">Masa</th>
                       <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle"><?php echo $row_journey['journey_from']; ?></td>
                        <td align="center" valign="middle">&raquo;</td>
                        <td align="left" valign="middle"><?php echo $row_journey['journey_to']; ?></td>
                        <td align="center" valign="middle"><?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_journey['journey_date_m'], $row_journey['journey_date_d'], $row_journey['journey_date_y']));?></td>
                        <td align="center" valign="middle"><?php echo getJourneyTimeByJourneyID($row_journey['journey_id']); ?></td>
                         <td align="center" nowrap="nowrap">
                         <ul class="func">
                         <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4) && !checkFeedback($row_tr['transbook_id']) && checkAdminAppByID($row_tr['transbook_id'])){?>
                         <li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_journey['journey_date_m'], $row_journey['journey_date_d'], $row_journey['journey_date_y']));?> <?php echo $row_journey['journey_time']; ?> \r\n\n Dari <?php echo $row_journey['journey_from']; ?> ke <?php echo $row_journey['journey_to']; ?>')" href="../sb/del_journey_admin.php?trid=<?php echo $row_journey['journey_id'];?>&id=<?php echo  getID(htmlspecialchars($transbookid,ENT_QUOTES)) ?>">X</a></li>
                         <?php }; ?>
                         </ul>
                         </td>
                      </tr>
                      <?php $i++; } while ($row_journey = mysql_fetch_assoc($journey)); ?>
                    <tr>
                      <td colspan="7" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_journey ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="7" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                   <li class="gap">&nbsp;</li>
                <li class="title">Maklumat Penumpang
				 <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) ){?>
                <span class="fr add" onclick="toggleview2('formaddpassenger'); return false;">Tambah</span><?php }; ?>
                </li>
              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) ){?>
                <div id="formaddpassenger" class="hidden">
                <li>
                 <form id="form4" name="form4" method="post" action="../sb/add_passengeradd.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label noline">Staf ID</td>
                        <td width="100%" class="noline">
                        <input name="user_stafid" type="text" class="w30" id="user_stafid" list="datastafid" value="<?php echo $userbook; ?>" />
                        <?php echo datalistStaf("datastafid");?>
                      <input name="transbookid" type="hidden" id="transbookid" value="<?php echo getID(htmlspecialchars($_GET['tid'],ENT_QUOTES),0);?>" />   
                      <input name="button6" type="submit" class="submitbutton" id="button6" value="Tambah" />
                        
                        </td>
                      </tr>
                    </table>
                    </form>
                    </li>
                    </div>  
                <?php }; ?>
                <li>
                <div class="note">Senarai Penumpang</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_passenger > 0) { // Show if recordset not empty ?>
                      <tr>
                        <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                        <th width="100%" colspan="2" align="left" valign="middle" nowrap="nowrap">Maklumat Penumpang</th>
                        <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                      </tr>
                      <?php $i=1; do { ?>
          <tr class="on">
                          <td><?php echo $i;?></td>
                          <td align="center" valign="middle" class="txt_line"><?php echo viewProfilePic($row_passenger['user_stafid']);?></td>
                          <td width="100%" align="left" class="txt_line">
                          	<div><strong><?php echo getFullNameByStafID($row_passenger['user_stafid']) . " (" . $row_passenger['user_stafid'] . ")";?></strong></div>
                            <div><?php echo getFulldirectoryByUserID($row_passenger['user_stafid']);?></div>
                            <div>No. Ext : <?php if(getExtNoByUserID($row_passenger['user_stafid'])!=NULL) echo getExtNoByUserID($row_passenger['user_stafid']); else echo "Tidak dinyatakan";?> 
                            &nbsp; &bull; &nbsp; No. Tel (HP) : 
                            <?php if(getTelMByStafID($row_passenger['user_stafid'])!='0')echo getTelMByStafID($row_passenger['user_stafid']); else echo "Tidak dinyatakan";?></div>
                    </td>
                    <td align="center" nowrap="nowrap">
                    	<ul class="func">
                    	<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4) && !checkFeedback($row_tr['transbook_id']) && checkAdminAppByID($row_tr['transbook_id'])){?>
               			  <li><a onclick="return confirm('Anda mahu berikut dipadam? \r\n\n <?php echo getFullNameByStafID($row_passenger['user_stafid']) . " (" . $row_passenger['user_stafid'] . ")";?>')" href="../sb/del_passenger.php?trid=<?php echo $row_passenger['passenger_id']; ?>&id=<?php echo  getID(htmlspecialchars($transbookid,ENT_QUOTES))?>">X</a></li>
           			    </ul>
                        <?php }; ?>
                        </td>
                        </tr>
                        <?php $i++; } while ($row_passenger = mysql_fetch_assoc($passenger)); ?>
                      <tr>
                        <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_passenger ?>  rekod dijumpai</td>
                      </tr>
                    <?php } else { ?>
                      <tr>
                        <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                      </tr>
                    <?php }; ?>
                    </table>  
              </li>
                <?php if($row_tr['admin_status']==0){?>
               <li class="title"> Kelulusan</li>
              <li class="gap">&nbsp;</li>
                <li>
                  <form id="kenderaan" name="kenderaan" method="POST" action="../sb/update_transadminapp.php">
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                        <td class="label">Kelulusan</td>
                        <td><ul class="inputradio">
                          <li><input name="admin_status" type="radio" value="1" checked/> Diluluskan</li>
                          <li><input name="admin_status" type="radio" value="2" /> Tidak Diluluskan</li>
                        </ul></td>
                     </tr>
                       <tr>
                        <td class="label">Catatan</td>
                        <td><textarea name="admin_note" id="admin_note" cols="45" rows="5"></textarea></td>
                      </tr>
                       <tr>
                        <td class="noline">&nbsp;</td>                   
                        <td class="noline">
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                        <input name="transbookid" type="hidden" id="transbookid" value="<?php echo $transbookid;?>" />
                        <input type="hidden" name="MM_update" value="kenderaan" /> 
                        </td>
                      </tr>
                    </table>
                    </form>
                 </li>
                 <?php }; ?>
              <li class="gap">&nbsp;</li>
                 <?php if($row_tr['admin_status']!=0){?>
                 <li class="title"> Kelulusan</li>
                 <li class="gap">&nbsp;</li>
                 <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Kelulusan</td>
                      <td><strong><?php if($row_tr['admin_status']==1) echo "Diluluskan"; else echo "Tidak Diluluskan";?></strong> oleh <strong> <?php echo getFullNameByStafID($row_tr['admin_by']) . " (" . $row_tr['admin_by'] . ")";?></strong></td>
                    </tr>
                    <tr>
                      <td class="label">Tarikh</td>
                      <td><?php echo $row_tr['admin_date'];?></td>
                    </tr>
                    <?php if ($row_tr['admin_note']!=NULL){?>
                    <tr>
                      <td class="label">Catatan</td>
                      <td><?php echo $row_tr['admin_note'];?></td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                <li class="gap">&nbsp;</li>
                <?php if(checkAdminAppByID($transbookid)){?>
                <li class="title">Maklumat Kenderaan dan Pemandu
				<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) ){?>
                <span class="fr add" onclick="toggleview2('formaddtransdriver'); return false;">Tambah</span>
				<?php }; ?>
                </li>
              	<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) ){?>
                <div id="formaddtransdriver" class="hidden noline">
              	<form id="form2" name="form2" method="POST" action="../sb/update_transndriver.php">
                <li class="form_back">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr class="noline">
                      <td align="left" valign="middle" nowrap="nowrap">Kenderaan</td>
                        <td align="left" valign="middle" nowrap="nowrap">
                        <select name="transport_id" id="transport_id">
                          <?php do { ?>
                          <option value="<?php echo $row_trname['transport_id']?>"><?php echo getTransportNameByID($row_trname['transport_id']);?> (<?php echo getTransportPlatByID($row_trname['transport_id']);?>)</option>
                            <?php
                            } while ($row_trname = mysql_fetch_assoc($trname));
                            $rows = mysql_num_rows($trname);
                            if($rows > 0) {
                                mysql_data_seek($trname, 0);
                                $row_trname = mysql_fetch_assoc($trname);
                            }
                            ?>
                        </select>
                        </td>
                        <td align="left" valign="middle" nowrap="nowrap">Pemandu</td>
                        <td width="100%" align="left" valign="middle" nowrap="nowrap">
                        <select name="driver_id" id="driver_id">
                          <?php do { ?>
                          <option value="<?php echo $row_driver['driver_id']?>"><?php echo getDriverNameByID($row_driver['driver_id']);?></option>
                            <?php
                            } while ($row_driver = mysql_fetch_assoc($driver));
                            $rows = mysql_num_rows($driver);
                            if($rows > 0) {
                                mysql_data_seek($driver, 0);
                                $row_driver = mysql_fetch_assoc($driver);
                            }
                            ?>
                        </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        <input type="hidden" name="MM_insert" value="form2" />
                        <input name="transbookid" type="hidden" id="transbookid" value="<?php echo getID(htmlspecialchars($_GET['tid'],ENT_QUOTES),0);?>" />
                      </td>
                    </tr>
                </table>
                </li>
        		</form>    
                </div>
                <?php };?> 
                <?php if($totalRows_trname>0 && $totalRows_driver>0){?>
              <li>
                <div class="note">Senarai Kenderaan dan Pemandu</div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_transdriver > 0) { // Show if recordset not empty ?>
                      <tr>
                        <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                        <th width="50%" align="left" valign="middle" nowrap="nowrap">Maklumat Kenderaan</th>
                        <th width="50%" colspan="2" align="left" valign="middle" nowrap="nowrap">Pemandu</th>
                         <th nowrap="nowrap">&nbsp;</th>
                      </tr>
                      <?php $i=1; do { ?>
                      <tr <?php if(checkAdminDelByTransdriverID($row_transdriver['transdriver_id'])==0) echo "class=\"offcourses\""; else echo "class=\"on\"";?>>
                          <td><?php echo $i;?></td>
                          <td align="left" class="txt_line">
                          	<div><strong><?php echo getTransportNameByID($row_transdriver['transport_id']);?></strong></div>
                            <div><?php echo getTransportPlatByID($row_transdriver['transport_id']);?></div>
                          </td>
                          <td align="center" valign="middle" nowrap="nowrap" class="txt_line"><?php echo viewProfilePic(getStafIDByID($row_transdriver['driver_id']));?></td>
                          <td width="100%" align="left" nowrap="nowrap" class="txt_line">
						  <div><strong><?php echo getDriverNameByID($row_transdriver['driver_id']). " (" . getStafIDByID($row_transdriver['driver_id']) . ")";?></strong></div>
                          <div>Ext : <?php if(getExtNoByUserID(getStafIDByID($row_transdriver['driver_id']))!=NULL) echo getExtNoByUserID(getStafIDByID($row_transdriver['driver_id'])); else echo "Tidak dinyatakan";?> &nbsp; &bull; &nbsp; No. Tel (HP) : <?php if(checkTelMByStafID(getStafIDByID($row_transdriver['driver_id']))) echo getTelMByStafID(getStafIDByID($row_transdriver['driver_id'])); else echo "-";?></div>
                          </td>
                      <td nowrap="nowrap">
                      <ul class="func">
                      <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4) && !checkFeedback($row_tr['transbook_id']) && checkAdminAppByID($row_tr['transbook_id'])){ ?>
                      <li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n<?php echo getTransportNameByID($row_transdriver['transport_id']); ?> <?php echo getTransportPlatByID($row_transdriver['transport_id']);?>  \r\n\n<?php echo getDriverNameByID($row_transdriver['driver_id']); ?>')" href="../sb/del_transdriver.php?trid=<?php echo $row_transdriver['transdriver_id'];?>&id=<?php echo  getID(htmlspecialchars($transbookid,ENT_QUOTES)); ?>">X</a></li>
                             <?php }; ?>
                      </ul>
                      </td>
                        </tr>
                        <?php $i++; } while ($row_transdriver = mysql_fetch_assoc($transdriver)); ?>
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_transdriver ?>  rekod dijumpai</td>
                      </tr>
                    <?php } else { ?>
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="noline txt_line">
                        <div>Tiada rekod dijumpai.</div>
                        <div>Klik pada 'Tambah' untuk menetapkan Maklumat Kenderaan dan Pemandu</div>
                        </td>
                      </tr>
                    <?php }; ?>
                    </table>  
              </li>
              <li class="gap">&nbsp;</li>
              <?php } else { ?>
              <li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="5" align="center" valign="middle" class="noline txt_line">
                        <div>Sila pastikan maklumat Pemandu dan Kenderaan telah dikemaskini.</div>
                        <div>Klik pada <strong>Tatacara</strong> untuk penambahan Pemandu dan Kenderaan</div>
                        </td>
                      </tr>
              </table>
              </li>
              <?php }; ?>
              <?php }; ?> 
              <?php }; ?>
              <?php }; ?>
            </ul>
            </div>
        </div>
        <?php echo noteEmail('1'); ?>
        </div>
		<?php include('../inc/footer.php');?>
    </div>
</div>
<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>

<script type="text/javascript">
var sprytextfield3 = new Spry.Widget.ValidationTextField("to2");
var sprytextfield4 = new Spry.Widget.ValidationTextField("from2");
</script>

<?php }; ?>
</body>
</html>
<?php
mysql_free_result($tr);

mysql_free_result($passenger);

mysql_free_result($trname);

mysql_free_result($driver);

mysql_free_result($journey);

mysql_free_result($transdriver);
?>
<?php include('../inc/footinc.php');?>
