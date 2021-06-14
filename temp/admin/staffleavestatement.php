<?php require_once('../Connections/hrmsdb.php'); ?>

<?php require_once('../Connections/tadbirdb.php'); ?>

<?php include('../inc/user.php');?>

<?php include('../inc/func.php');?>

<?php $menu='5';?>

<?php $menu2='23';?>

<?php 

if(isset($_GET['id']))

	$userid = getStafIDByUserID(getID($_GET['id'],0));

else

	$userid = $row_user['user_stafid'];


if(isset($_GET['y']))

	$y = htmlspecialchars($_GET['y'], ENT_QUOTES);

else

	$y = date('Y');

	
$totalkelayakan = 0;

$totalcuti = 0;

$totalGanti = 0;

$totalleave = 0;

$totalPLC = 0;


mysql_select_db($database_hrmsdb, $hrmsdb);

$query_allleave = "SELECT userleavedate_id, userleavedate_note, clinictype_id FROM www.user_leavedate WHERE user_stafid = '" . $userid . "' AND userleavedate_date_y = '" . $y . "' AND (leavetype_id = '1' OR leavetype_id = '2' OR leavetype_id = '4' OR leavetype_id = '5' OR leavetype_id = '6' OR leavetype_id = '7') AND userleavedate_status = '1' AND userleavedate_app < '2' ORDER BY userleavedate_date_y ASC, userleavedate_date_m ASC, userleavedate_date_d ASC";

$allleave = mysql_query($query_allleave, $hrmsdb) or die(mysql_error());

$row_allleave = mysql_fetch_assoc($allleave);

$totalRows_allleave = mysql_num_rows($allleave);

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

                <li class="form_back">

                  <form id="form1" name="form1" method="get" action="staffleavestatement.php">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td class="label">Tahun</td>

                        <td width="100%"><label for="y"></label>

                          <select name="y" id="y">

                          <?php for($i=(date('Y')-2); $i<=date('Y'); $i++){?>

                            <option <?php if($i==$y) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>

                          <?php }; ?>

                          </select><input name="id" type="hidden" value="<?php echo $_GET['id'];?>" />

                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>

                        <td><input name="button4" type="submit" class="submitbutton" id="button4" value="Cetak" onClick="MM_openBrWindow('staffleavestatementprint.php?id=<?php echo getID($_GET['id'],1);?>&y=<?php echo $y;?>','printleave','scrollbars=yes,width=800,height=600')" /></td>

                      </tr>

                    </table>

                  </form>

                </li>

                <li>

                <div class="note">Kenyataan Cuti bagi Tahun <strong><?php echo $y;?></strong></div>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td rowspan="3" align="center" valign="top" class="noline"><?php echo viewProfilePic($userid);?></td>

                    <td nowrap="nowrap" class="label">Nama Pegawai</td>

                    <td width="100%" colspan="3"><?php echo getFullNameByStafID($userid);?></td>

                  </tr>

                  <tr>

                    <td nowrap="nowrap" class="label">No. Kad Pengenalan</td>

                    <td><?php echo getICNoByStafID($userid);?></td>

                    <td nowrap="nowrap" class="label">Tarikh Lantikan</td>

                    <td><?php echo getStartDayDate($userid, 0);?></td>

                  </tr>

                  <tr>

                    <td nowrap="nowrap" class="label noline">Jawatan</td>

                    <td width="50%" class="noline"><?php echo getJobtitleReal($userid);?> (<?php echo getGred($userid); ?>)</td>

                    <td nowrap="nowrap" class="label noline">No. Fail</td>

                    <td width="50%" class="noline"><?php echo $userid;?></td>

                  </tr>

                </table>

                </li>

                <li class="gap">&nbsp;</li>

                <li>

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <th rowspan="2" align="left" valign="middle" nowrap="nowrap" class="line_l line_t">Tahun</th>

                      <th colspan="3" align="center" valign="middle" nowrap="nowrap" class="line_l line_t">Cuti</th>

                      <th rowspan="2" align="center" valign="middle" nowrap="nowrap" class="line_l line_t">GCR</th>

                      <th rowspan="2" align="center" valign="middle" nowrap="nowrap" class="line_l line_t">Bawa Ke Hadapan</th>

                      <th rowspan="2" align="center" valign="middle" nowrap="nowrap" class="line_l line_t line_r">Baki</th>

                    </tr>

                    <tr>
					<th align="center" valign="middle" nowrap="nowrap" class="line_l">Kelayakan Cuti</th>
                      <th align="center" valign="middle" nowrap="nowrap" class="line_l">Peruntukan</th>

                      <th align="center" valign="middle" nowrap="nowrap" class="line_l">Ganti</th>

                      <th align="center" valign="middle" nowrap="nowrap" class="line_l">Penggunaan</th>

                    </tr>

                    <?php for($i=$y; $i>=($y-2); $i--){?>

                    <tr class="on">

                      <td align="left" valign="middle" class="line_l"><?php echo $i;?></td>
                      <td align="center" valign="middle" class="line_l"><?php $totalkelayakan += getLeave($userid, $i); echo getLeave($userid, $i);?></td>
                      <td align="center" valign="middle" class="line_l"><?php $totalcuti += getLeave($userid, $i); echo getLeave($userid, $i) + countPLC2year($userid, $i);?></td>

                      <td align="center" valign="middle" class="line_l"><?php $totalGanti += getTotalLeaveGanti($userid, $i); echo getTotalLeaveGanti($userid, $i);?></td>

                      <td align="center" valign="middle" class="line_l"><?php $totalleave += calAllLeave($userid, $i); echo calAllLeave($userid, $i);?></td>

                      <td align="center" valign="middle" class="line_l"><?php echo getGCRPerYearByUserID($userid, $i);?></td>

                      <td align="center" valign="middle" class="line_l"><?php $totalPLC += countPLC($userid, $i); echo countPLC($userid, $i);?></td>

                      <td align="center" valign="middle" class="line_l line_r"><?php echo countLeaveBalance($userid, $i);?></td>

                    </tr>

                    <?php }; ?>

                    <tr class="back_lightgrey">

                      <td align="left" valign="middle" class="line_l line_t line_b">Jumlah</td>
		      <td align="center" valign="middle" class="line_l line_t line_b"><?php echo $totalkelayakan;?></td>

                      <td align="center" valign="middle" class="line_l line_t line_b"><?php echo $totalcuti;?></td>

                      <td align="center" valign="middle" class="line_l line_t line_b"><?php echo $totalGanti;?></td>

                      <td align="center" valign="middle" class="line_l line_t line_b"><?php echo $totalleave;?></td>

                      <td align="center" valign="middle" class="line_l line_t line_b"><?php echo countTotalGCR($userid);?></td>

                      <td align="center" valign="middle" class="line_l line_t line_b"><?php echo $totalPLC;?></td>

                      <td align="center" valign="middle" class="line_l line_r line_t line_b">&nbsp;</td>

                    </tr>

                  </table>

          		</li>

                <li class="gap">&nbsp;</li>

                <li>

                <div class="off2">

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <th width="200" rowspan="<?php if(getDesignationType($userid)) echo "3"; else echo "2"; ?>" align="left" valign="middle" nowrap="nowrap" class="line_l line_t">Kelulusan</th>

                      <th rowspan="<?php if(getDesignationType($userid)) echo "3"; else echo "2"; ?>" align="left" valign="middle" nowrap="nowrap" class="line_l line_t">Jenis Cuti</th>

                      <th rowspan="<?php if(getDesignationType($userid)) echo "3"; else echo "2"; ?>" align="center" valign="middle" nowrap="nowrap" class="line_l line_t">Tarikh</th>

                      <th colspan="<?php if(getDesignationType($userid)) echo "7"; else echo "6"; ?>" align="center" valign="middle" nowrap="nowrap" class="line_l line_t">Baki Peruntukan</th>

                      <th width="300" rowspan="<?php if(getDesignationType($userid)) echo "3"; else echo "2"; ?>" align="center" valign="middle" nowrap="nowrap" class="line_l line_t line_r">Catatan</th>

                    </tr>

                    <tr>

                      <th width="100" <?php if(getDesignationType($userid)) echo "rowspan=\"2\""; ?> align="center" valign="middle" nowrap="nowrap" class="line_l">Cuti Rehat +<br />Cuti Ganti</th>

                      <th width="100" <?php if(getDesignationType($userid)) echo "colspan=\"2\"";?> align="center" valign="middle" nowrap="nowrap" class="line_l">Cuti<br />Sakit</th>

                      <th width="100" <?php if(getDesignationType($userid)) echo "rowspan=\"2\""; ?> align="center" valign="middle" nowrap="nowrap" class="line_l">Cuti Tanpa<br />Rekod</th>

                      <th width="100" <?php if(getDesignationType($userid)) echo "rowspan=\"2\""; ?> align="center" valign="middle" nowrap="nowrap" class="line_l">Cuti<br />Bersalin</th>

                      <th width="100" <?php if(getDesignationType($userid)) echo "rowspan=\"2\""; ?> align="center" valign="middle" nowrap="nowrap" class="line_l">Cuti Tanpa<br />Gaji</th>

                      <th width="100" <?php if(getDesignationType($userid)) echo "rowspan=\"2\""; ?> align="center" valign="middle" nowrap="nowrap" class="line_l">Cuti Melebihi<br/>Kelayakkan</th>

                    </tr>

                    <?php if(getDesignationType($userid)){?>

                    <tr>

                      <th align="center" valign="middle" nowrap="nowrap" class="line_l">Kerajaan</th>

                      <th align="center" valign="middle" nowrap="nowrap" class="line_l">Swasta</th>

                    </tr>

                    <?php }; ?>

                    <tr class="back_lightgrey">

                      <td align="left" valign="middle" class="line_l">&nbsp;</td>

                      <td align="left" valign="middle" class="line_l">&nbsp;</td>

                      <td align="center" valign="middle" class="line_l">&nbsp;</td>

                      <td align="center" valign="middle" class="line_l">

					  <?php $ddCuti = getLeave($userid, $y)+ getTotalLeaveGanti($userid, $y) + countPLC2year($userid, $y);?>

                      <strong><?php echo $ddCuti;?></strong>

                      </td>

                    <?php if(getDesignationType($userid)){?>

                      <td align="center" valign="middle" class="line_l"><strong><?php echo getEL($userid, $y, 1);?></strong></td>

                      <td align="center" valign="middle" class="line_l"><strong><?php echo getEL($userid, $y, 2);?></strong></td>

                      <?php } else { ?>

                      <td align="center" valign="middle" class="line_l"><strong><?php echo getEL($userid, $y);?></strong></td>

                      <?php }; ?>

                      <td align="center" valign="middle" class="line_l"><strong><?php $lwor = getLeaveWOR($userid); echo $lwor;?></strong></td>

                      <td align="center" valign="middle" class="line_l">&nbsp;</td>

                      <td align="center" valign="middle" class="line_l">&nbsp;</td>

                      <td align="center" valign="middle" class="line_l">&nbsp;</td>

                      <td class="line_l line_r">&nbsp;</td>

                    </tr>

                    <?php if ($totalRows_allleave > 0) { // Show if recordset not empty ?>

                    

                    <?php $ddSakit = getEL($userid);?>

                    <?php $ddSakitG = getEL($userid, $y, 1); // Staf Tetap melalui Klinik Kerajaan?>

                    <?php $ddSakitS = getEL($userid, $y, 2); // Staf Tetap melalui Klinik Swasta?>

                    <?php do { ?>

                      <tr class="on">

                        <td align="left" valign="middle" nowrap="nowrap" class="line_l"><?php echo getShortNameByStafID(getLeaveAppBy($row_allleave['userleavedate_id']));?></td>

                        <td align="left" valign="middle" nowrap="nowrap" class="line_l"><?php echo getLeaveType(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])); ?></td>

                        <td align="center" valign="middle" nowrap="nowrap" class="line_l"><?php echo getLeaveDate($row_allleave['userleavedate_id']);?></td>

                        <td align="center" valign="middle" nowrap="nowrap" class="line_l"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==1){$ddCuti-=1; echo $ddCuti;}; ?></td>

                    <?php if(getDesignationType($userid)){?>

                        <td align="center" valign="middle" nowrap="nowrap" class="line_l"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==2 && $row_allleave['clinictype_id']==1){$ddSakitG-=1; echo $ddSakitG;}; ?></td>

                        <td align="center" valign="middle" nowrap="nowrap" class="line_l"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==2 && $row_allleave['clinictype_id']==2){$ddSakitS-=1; echo $ddSakitS;}; ?></td>

                        <?php } else { ?>

                        <td align="center" valign="middle" nowrap="nowrap" class="line_l"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==2){$ddSakit-=1; echo $ddSakit;}; ?></td>

                        <?php }; ?>

                        <td align="center" valign="middle" nowrap="nowrap" class="line_l"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==4){$lwor-=1; echo $lwor;}; ?></td>

                        <td align="center" valign="middle" nowrap="nowrap" class="line_l"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==5){ echo getLeaveBirthDay($row_allleave['userleavedate_id']);}; ?></td>

                        <td align="center" valign="middle" nowrap="nowrap" class="line_l"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==6){ echo getDayLeaveWOSByID($row_allleave['userleavedate_id']);}; ?></td>

                        <td align="center" valign="middle" nowrap="nowrap" class="line_l"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==7){ echo getDayLeaveMTQByID($row_allleave['userleavedate_id']);}; ?></td>

                        <td class="line_l line_r"><?php if(getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==4 || getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==5 || getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==6 || getLeaveTypeByLeaveID($row_allleave['userleavedate_id'])==7) echo $row_allleave['userleavedate_note'];?></td>

                      </tr>

                      <?php } while ($row_allleave = mysql_fetch_assoc($allleave)); ?>

                    <tr>

                      <td colspan="<?php if(getDesignationType($userid)) echo "11"; else echo "10"; ?>" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_allleave ?> rekod dijumpai</td>

                    </tr>

					<?php } else { ?>

                    <tr>

                      <td colspan="<?php if(getDesignationType($userid)) echo "11"; else echo "10"; ?>" align="center" valign="middle" class="line_l line_r">Tiada rekod dijumpai</td>

                    </tr>

                    <?php }; ?>

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

</body>

</html>

<?php

mysql_free_result($allleave);

?>

<?php include('../inc/footinc.php');?>

