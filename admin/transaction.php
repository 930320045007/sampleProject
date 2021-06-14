<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='35';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_transtype = "SELECT * FROM www.transaction_type WHERE transactiontype_status = 1 ORDER BY transactiontype_name ASC";
$transtype = mysql_query($query_transtype, $hrmsdb) or die(mysql_error());
$row_transtype = mysql_fetch_assoc($transtype);
$totalRows_transtype = mysql_num_rows($transtype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_perkesolist = "SELECT * FROM www.perkeso WHERE perkeso_status = 1 ORDER BY perkeso_min ASC";
$perkesolist = mysql_query($query_perkesolist, $hrmsdb) or die(mysql_error());
$row_perkesolist = mysql_fetch_assoc($perkesolist);
$totalRows_perkesolist = mysql_num_rows($perkesolist);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_clublist = "SELECT * FROM www.club WHERE club_status = 1 ORDER BY club_min ASC";
$clublist = mysql_query($query_clublist, $hrmsdb) or die(mysql_error());
$row_clublist = mysql_fetch_assoc($clublist);
$totalRows_clublist = mysql_num_rows($clublist);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kwsplist = "SELECT * FROM kwsp WHERE kwsp_status = 1 ORDER BY kwsp_type ASC, kwsp_min ASC";
$kwsplist = mysql_query($query_kwsplist, $hrmsdb) or die(mysql_error());
$row_kwsplist = mysql_fetch_assoc($kwsplist);
$totalRows_kwsplist = mysql_num_rows($kwsplist);
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
            <li>
            	<div class="note">Berikut adalah senarai transaksi gaji mengikut kategori :</div>
            </li>
            <?php do { ?>
            <li class="title"><?php echo $row_transtype['transactiontype_name']; ?>  <span class="fr add" onclick="toggleview2('form<?php echo $row_transtype['transactiontype_id']; ?>'); return false;">Tambah</span></li>
            <div class="hidden" id="form<?php echo $row_transtype['transactiontype_id']; ?>">
            <li>
              <form id="form<?php echo $row_transtype['transactiontype_id']; ?>" name="form<?php echo $row_transtype['transactiontype_id']; ?>" method="post" action="../sb/add_salarytransactiontype.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td nowrap="nowrap" class="label noline">Nama</td>
                    <td width="100%" class="noline"><input name="transactiontype_id" type="hidden" id="transactiontype_id" value="<?php echo $row_transtype['transactiontype_id']; ?>" />
                      <input name="tansaction_name" type="text" class="w50" id="tansaction_name" />
                      <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" /></td>
                  </tr>
                </table>
              </form>
            </li>
            </div>
            <li>
            <?php
				mysql_select_db($database_hrmsdb, $hrmsdb);
				$query_trans = "SELECT * FROM `transaction` WHERE transaction_status = 1 AND transactiontype_id = '" . $row_transtype['transactiontype_id'] . "' ORDER BY transaction_name ASC";
				$trans = mysql_query($query_trans, $hrmsdb) or die(mysql_error());
				$row_trans = mysql_fetch_assoc($trans);
				$totalRows_trans = mysql_num_rows($trans);
			?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_trans > 0) { // Show if recordset not empty ?>
				<tr>
                  <td valign="middle" class="noline">
                    <ul class="li2c">
                    <?php do { ?>
                          <li><span class="name"><?php echo $row_trans['transaction_name']; ?></span><span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_trans['transaction_name']; ?>')" href="<?php echo $url_main;?>sb/setting_transaction.php?tid=<?php echo $row_trans['transaction_id'];?>">&times;</a></span> </li>
                      <?php } while ($row_trans = mysql_fetch_assoc($trans)); ?>
                    </ul>
                  </td>
          		</tr>
                <tr>
                  <td align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_trans ?>  rekod dijumpai</td>
                </tr>
                <?php mysql_free_result($trans); ?>
			  <?php } else { ?>
                <tr>
                  <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                </tr>
              <?php }; ?>
              </table>
            </li>
            <?php } while ($row_transtype = mysql_fetch_assoc($transtype)); ?>
            <a name="kelab" id="kelab"></a>
            <li class="title">Kelab MSN <span class="fr add" onclick="toggleview2('forminkelab'); return false;">Tambah</span></li>
            <div id="forminkelab" class="hidden">
            <li>
              <form action="../sb/add_club.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Tarikh</td>
                    <td colspan="3">
                      <select name="club_date_d" id="club_date_d">
                      <?php for($i=1; $i<=31; $i++){?>
                        <option value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                      <?php }; ?>
                      </select>
                      <select name="club_date_m" id="club_date_m">
                      <?php for($j=1; $j<=12; $j++){?>
                        <option <?php if($j==date('Y')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                      <?php }; ?>
                      </select>
                      <select name="club_date_y" id="club_date_y">
                      <?php for($k=(date('Y')-5); $k<=(date('Y')+5); $k++){?>
                        <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                      <?php }; ?>
                      </select>
                      </td>
                    </tr>
                  <tr>
                    <td class="label">Gaji Bulanan Minimum</td>
                    <td><label for="club_min"></label>
                      <input type="text" name="club_min" id="club_min" /></td>
                    <td class="label">Gaji Bulanan Maksimum</td>
                    <td><input type="text" name="club_max" id="club_max" /></td>
                  </tr>
                  <tr>
                    <td class="label">Potongan Majikan</td>
                    <td><input type="text" name="club_oneemp" id="club_oneemp" /></td>
                    <td class="label">Potongan Pekerja</td>
                    <td><input type="text" name="club_onestaf" id="club_onestaf" /></td>
                  </tr>
                  <tr>
                    <td class="label noline">&nbsp;</td>
                    <td colspan="3" class="noline">
                    <input type="hidden" name="MM_insert" value="forminkelab" />
                    <input name="button6" type="submit" class="submitbutton" id="button6" value="Tambah" />
                      <input name="button7" type="button" class="cancelbutton" id="button7" value="Batal" onclick="toggleview2('forminkelab'); return false;" /></td>
                    </tr>
                </table>
              </form>
            </li>
            </div>
            <li>
            <div class="off">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_clublist > 0) { // Show if recordset not empty ?>
<tr>
                  <th align="center" valign="middle">Bil</th>
                  <th align="center" valign="middle">Gaji Bulanan <br />
                    Minimum</th>
                  <th align="center" valign="middle">Gaji Bulanan <br />
                    Maksimum</th>
                  <th align="center" valign="middle">Potongan Majikan</th>
                  <th align="center" valign="middle">Potongan Pekerja</th>
                  <th align="center" valign="middle">Jumlah</th>
                  <th align="center" valign="middle">&nbsp;</th>
              </tr>
                <?php $i=1; do { ?>
                  <tr class="on">
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td align="center" valign="middle"><?php echo $row_clublist['club_min']; ?></td>
                    <td align="center" valign="middle"><?php echo $row_clublist['club_max']; ?></td>
                    <td align="center" valign="middle"><?php echo $row_clublist['club_oneemp']; ?></td>
                    <td align="center" valign="middle"><?php echo $row_clublist['club_onestaf']; ?></td>
                    <td align="center" valign="middle"><?php echo number_format(($row_clublist['club_oneemp']+$row_clublist['club_onestaf']),2); ?></td>
                    <td align="center" valign="middle"><ul class="func"><li><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n Gaji Bulanan : <?php echo  $row_clublist['club_min']; ?> - <?php echo $row_clublist['club_max']; ?>')" href="<?php echo $url_main;?>sb/setting_transaction.php?cid=<?php echo $row_clublist['club_id'];?>">&times;</a></li></ul></td>
                  </tr>
                  <?php $i++; } while ($row_clublist = mysql_fetch_assoc($clublist)); ?>
                <tr>
                  <td colspan="7" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_clublist ?> rekod dijumpai</td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td colspan="7" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                </tr>
                <?php }; ?>
              </table>
            </div>
            </li>
            <a name="kwsp" id="kwsp"></a>
            <li class="title">KWSP<span class="fr add" onclick="toggleview2('forminkwsp'); return false;">Tambah</span></li>
            <div id="forminkwsp" class="hidden">
            <li>
              <form id="form2" name="form2" method="post" action="../sb/add_kwsp.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Tarikh</td>
                    <td colspan="3">
                      <select name="kwsp_date_d" id="kwsp_date_d">
                      <?php for($i=1; $i<=31; $i++){?>
                        <option value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                      <?php }; ?>
                      </select>
                      <select name="kwsp_date_m" id="kwsp_date_m">
                      <?php for($j=1; $j<=12; $j++){?>
                        <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                      <?php }; ?>
                      </select>
                      <select name="kwsp_date_y" id="kwsp_date_y">
                      <?php for($k=(date('Y')-5); $k<=(date('Y')+5); $k++){?>
                        <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                      <?php }; ?>
                      </select>
                      </td>
                    </tr>
                  <tr>
                    <td class="label">Kategori</td>
                    <td colspan="3"><label for="kwsp_type"></label>
                      <select name="kwsp_type" id="kwsp_type">
                        <option value="1">1 - 11%</option>
                        <option value="2" selected="selected">2 - 5.5%</option>
                      </select></td>
                  </tr>
                  <tr>
                    <td class="label">Gaji Bulanan Minimum</td>
                    <td><label for="kwsp_min"></label>
                      <input type="text" name="kwsp_min" id="kwsp_min" /></td>
                    <td class="label">Gaji Bulanan Maksimum</td>
                    <td><input type="text" name="kwsp_max" id="kwsp_max" /></td>
                  </tr>
                  <tr>
                    <td class="label">Potongan Majikan</td>
                    <td><input type="text" name="kwsp_oneemp" id="kwsp_oneemp" /></td>
                    <td class="label">Potongan Pekerja</td>
                    <td><input type="text" name="kwsp_onestaf" id="kwsp_onestaf" /></td>
                  </tr>
                  <tr>
                    <td><input type="hidden" name="MM_insert_kwsp" value="forminkwsp" /></td>
                    <td colspan="3"><input name="button8" type="submit" class="submitbutton" id="button8" value="Tambah" />
                      <input name="button9" type="button" class="cancelbutton" id="button9" value="Batal" /></td>
                    </tr>
                </table>
              </form>
            </li>
            </div>
            <li>
            <div class="note">Kategori : 1 untuk 11% dan 2 untuk 5.5%</div>
            <div class="off">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <?php if ($totalRows_kwsplist > 0) { // Show if recordset not empty ?>
                <tr>
                  <th align="center" valign="middle">Bil</th>
                  <th align="center" valign="middle">Kategori</th>
                  <th align="center" valign="middle">Gaji Bulanan <br />
                    Minimum</th>
                  <th align="center" valign="middle">Gaji Bulanan <br />
                    Maksimum</th>
                  <th align="center" valign="middle">Potongan Majikan</th>
                  <th align="center" valign="middle">Potongan Pekerja</th>
                  <th align="center" valign="middle">Jumlah</th>
                  <th align="center" valign="middle">&nbsp;</th>
                </tr>
                <?php $i=1; do { ?>
                  <tr class="on">
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td align="center" valign="middle"><?php echo $row_kwsplist['kwsp_type']; ?></td>
                    <td align="center" valign="middle"><?php echo $row_kwsplist['kwsp_min']; ?></td>
                    <td align="center" valign="middle"><?php echo $row_kwsplist['kwsp_max']; ?></td>
                    <td align="center" valign="middle"><?php echo $row_kwsplist['kwsp_oneemp']; ?></td>
                    <td align="center" valign="middle"><?php echo $row_kwsplist['kwsp_onestaf']; ?></td>
                    <td align="center" valign="middle"><?php echo number_format(($row_kwsplist['kwsp_oneemp']+$row_kwsplist['kwsp_onestaf']),2); ?></td>
                   <td align="center" valign="middle"><ul class="func"><li><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n Gaji Bulanan : <?php echo  $row_kwsplist['kwsp_min']; ?> - <?php echo $row_kwsplist['kwsp_max']; ?>')" href="<?php echo $url_main;?>sb/setting_transaction.php?kid=<?php echo $row_kwsplist['kwsp_id'];?>">&times;</a></li></ul></td>
                  </tr>
                  <?php $i++; } while ($row_kwsplist = mysql_fetch_assoc($kwsplist)); ?>
                <tr>
                  <td colspan="7" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_kwsplist ?>  rekod dijumpai</td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td colspan="7" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                </tr>
              <?php }; ?>
              </table>
            </div>
            </li>
            <a name="perkeso" id="perkeso"></a>
            <li class="title">PERKESO <span class="fr add" onclick="toggleview2('formperkeso'); return false;">Tambah</span></li>
            <div id="formperkeso" class="hidden">
            <li>
              <form id="forminperkeso" name="forminperkeso" method="POST" action="../sb/add_perkeso.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Tarikh</td>
                    <td colspan="4" align="left" valign="middle"><label for="perkeso_date_d"></label>
                      <select name="perkeso_date_d" id="perkeso_date_d">
                      <?php for($i=1; $i<=31; $i++){?>
                        <option value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                      <?php }; ?>
                      </select>
                      <select name="perkeso_date_m" id="perkeso_date_m">
                      <?php for($j=1; $j<=12; $j++){?>
                        <option value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                      <?php }; ?>
                      </select>
                      <select name="perkeso_date_y" id="perkeso_date_y">
                      <?php for($k=date('Y'); $k>=(date('Y')-5); $k--){?>
                        <option value="<?php if($k<10) $k = '0' . $k; echo $k;?>"><?php echo $k;?></option>
                      <?php }; ?>
                      </select></td>
                  </tr>
                  <tr>
                    <td class="label">Nota</td>
                    <td colspan="4" align="left" valign="middle"><label for="perkeso_note"></label>
                      <input type="text" name="perkeso_note" id="perkeso_note" /></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" valign="middle" class="noline">&nbsp;</td>
                    <td colspan="2" align="center" valign="middle" class="label line_l line_r line_t"><span>Jenis Pertama</span></td>
                    <td align="center" valign="middle" class="label line_r line_t"><span>Jenis Kedua</span></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle" class="label line_l line_t line_r"><span>Gaji Bulanan Manimum</span></td>
                    <td align="center" valign="middle" class="label line_t"><span>Gaji Bulanan Maximum</span></td>
                    <td align="center" valign="middle" class="label line_t line_l line_r"><span>Syer Majikan</span></td>
                    <td align="center" valign="middle" class="label line_t line_r"><span>Syer Pekerja</span></td>
                    <td align="center" valign="middle" class="label line_t line_r"><span>Syer Majikan</span></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle" class="line_l line_t line_r"><input type="text" name="perkeso_min" id="perkeso_min" /></td>
                    <td align="center" valign="middle" class="line_t"><input type="text" name="perkeso_max" id="perkeso_max" /></td>
                    <td align="center" valign="middle" class="line_t line_l line_r"><input type="text" name="perkeso_oneemp" id="perkeso_oneemp" /></td>
                    <td align="center" valign="middle" class="line_t line_r"><input type="text" name="perkeso_onestaf" id="perkeso_onestaf" /></td>
                    <td align="center" valign="middle" class="line_t line_r"><input type="text" name="perkeso_twoemp" id="perkeso_twoemp" /></td>
                  </tr>
                  <tr>
                    <td colspan="5" align="center" valign="middle" class="noline">
                    <input type="hidden" name="MM_insert" value="forminperkeso" />
                      <input name="button4" type="submit" class="submitbutton" id="button4" value="Hantar" />
                      <input name="button5" type="submit" class="cancelbutton" id="button5" value="Batal" /></td>
                    </tr>
                </table>
              </form>
            </li>
            </div>
            <li>
            <div class="off">
            <div class="note">Jadual Potongan PERKESO</div>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <?php if ($totalRows_perkesolist > 0) { // Show if recordset not empty ?>
                <tr>
                  <th rowspan="2" align="center" valign="middle">Bil</th>
                  <th rowspan="2" align="center" valign="middle">Gaji Bulanan<br/>Minimum</th>
                  <th rowspan="2" align="center" valign="middle">Gaji Bulanan<br/>Maksimum</th>
                  <th colspan="2" align="center" valign="middle" class="line_l line_r line_t">Jenis Pertama</th>
                  <th align="center" valign="middle" class="line_r line_t">Jenis Kedua</th>
                  <th rowspan="2" align="center" valign="middle">&nbsp;</th>
                </tr>
                <tr>
                  <th align="center" valign="middle" class="line_l line_r">Syer Majikan (RM)</th>
                  <th align="center" valign="middle" class="line_r">Syer Pekerja (RM)</th>
                  <th align="center" valign="middle" class="line_r">Majikan (RM)</th>
                  </tr>
                <?php $i=1;?>
                  <?php do { ?>
                    <tr class="on">
                      <td align="center" valign="middle"><?php echo $i;?></td>
                      <td align="center" valign="middle"><?php echo $row_perkesolist['perkeso_min']; ?></td>
                      <td align="center" valign="middle"><?php echo $row_perkesolist['perkeso_max']; ?></td>
                      <td align="center" valign="middle"><?php echo $row_perkesolist['perkeso_oneemp']; ?></td>
                      <td align="center" valign="middle"><?php echo $row_perkesolist['perkeso_onestaf']; ?></td>
                      <td align="center" valign="middle"><?php echo $row_perkesolist['perkeso_twoemp']; ?></td>
                      <td align="center" valign="middle"><ul class="func"><li><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n Gaji Bulanan : <?php echo  $row_perkesolist['perkeso_min']; ?> - <?php echo $row_perkesolist['perkeso_max']; ?>')" href="<?php echo $url_main;?>sb/setting_transaction.php?pid=<?php echo $row_perkesolist['perkeso_id'];?>">&times;</a></li></ul></td>
                    </tr>
					<?php $i++;?>
                    <?php } while ($row_perkesolist = mysql_fetch_assoc($perkesolist)); ?>
                <tr>
                  <td colspan="7" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_perkesolist ?> rekod dijumpai</td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td colspan="7" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                </tr>
              <?php }; ?>
              </table>
            </div>
            </li>
            <?php } else { ?>
            <li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>Tiada akses untuk maklumat</td>
                </tr>
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
mysql_free_result($transtype);

mysql_free_result($perkesolist);

mysql_free_result($clublist);

mysql_free_result($kwsplist);?>
?>
<?php include('../inc/footinc.php');?>
