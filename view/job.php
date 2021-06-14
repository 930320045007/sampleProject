<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_report = "SELECT user_report.* FROM user_report LEFT JOIN user_unit ON user_report.user_stafid = user_unit.user_stafid WHERE user_unit.dir_id = '" . getUserUnitIDByUserID($row_user['user_stafid']) . "' AND user_report.user_stafid != '" . $row_user['user_stafid'] . "'";
$user_report = mysql_query($query_user_report, $hrmsdb) or die(mysql_error());
$row_user_report = mysql_fetch_assoc($user_report);
$totalRows_user_report = mysql_num_rows($user_report);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <?php if ($totalRows_user_report > 0) { // Show if recordset not empty ?>
    <tr>
      <th width="50%" align="left" valign="middle">Staf</th>
      <th width="50%" align="left" valign="middle">Nama Pegawai Penilai / Jawatan</th>
      <th align="center" valign="middle" nowrap="nowrap">Pegawai Penilai</th>
      <th>&nbsp;</th>
    </tr>
    <?php do { ?>
      <tr class="on">
        <td width="50%" align="left" valign="middle"><div class="txt_line"><strong><?php echo getFullNameByStafID($row_user_report['user_stafid']) ?> (<?php echo $row_user_report['user_stafid'];?>)</strong> <br />
          <span class="txt_color1"><?php echo getJobtitle($row_user_report['userreport_stafid']); ?> (<?php echo getGred($row_user_report['user_stafid']);?>)</span></div></td>
        <td width="50%" align="left" valign="middle"><div class="txt_line"><strong><?php echo getFullNameByStafID($row_user_report['userreport_stafid']) ?> (<?php echo $row_user_report['userreport_stafid'];?>)</strong> <br />
          <span class="txt_color1"><?php echo getJobtitle($row_user_report['userreport_stafid']); ?> (<?php echo getGred($row_user_report['userreport_stafid']);?>)<?php echo ", " . getFulldirectoryByUserID($row_user_report['userreport_stafid']); ?></span></div></td>
        <td align="center" valign="middle" nowrap="nowrap"><?php echo getReportType($row_user_report['userreport_type']); ?></td>
        <td align="right" valign="middle"><?php if(getDelReport($row_user_report['userreport_id'])==$row_user['user_stafid']){?><a onclick="return confirm('Anda mahu maklumat berikut dipadam?')" href="sb/del_supervision.php?delsv=<?php echo $row_user_report['userreport_id']; ?>">X</a><?php }; ?></td>
      </tr>
      <?php } while ($row_user_report = mysql_fetch_assoc($user_report)); ?>
    <tr class="noline">
      <td colspan="4" align="center" valign="middle" class="noline txt_color1">&nbsp;<?php echo $totalRows_user_report ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila isi Maklumat Pegawai Bertanggungjawab</td>
    </tr>
    <?php }; ?>
  </table>
  <?php 
mysql_free_result($user_report);
?>