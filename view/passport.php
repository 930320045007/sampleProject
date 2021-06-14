<?php
$colname_user_passport = "-1";
if (isset($_GET['id'])) {
  $colname_user_passport = getStafIDByUserID(htmlspecialchars($_GET['id'], ENT_QUOTES));
} else {
  $colname_user_passport = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_passport = sprintf("SELECT * FROM user_passport WHERE user_stafid = %s ORDER BY userpassport_id DESC", GetSQLValueString($colname_user_passport, "text"));
$user_passport = mysql_query($query_user_passport, $hrmsdb) or die(mysql_error());
$row_user_passport = mysql_fetch_assoc($user_passport);
$totalRows_user_passport = mysql_num_rows($user_passport);
mysql_free_result($user_passport);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_user_passport > 0) { // Show if recordset not empty ?>
    <tr>
      <td class="label">Jenis</td>
      <td><?php echo getPassport($row_user_passport['userpassport_type']);?></td>
      <td class="label">Kewarganegaraan</td>
      <td class="in_cappitalize"><?php echo getCitizen($row_user_passport['userpassport_citizen']); ?></td>
      </tr>
    <tr>
      <td class="label">No. Passport</td>
      <td class="in_upper"><?php echo $row_user_passport['userpassport_no']; ?></td>
      <td class="label">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td class="label">Tarikh Mula</td>
      <td><?php echo $row_user_passport['userpassport_start']; ?></td>
      <td class="label">Tarikh Tamat</td>
      <td><?php echo $row_user_passport['userpassport_expire']; ?></td>
    </tr>
    <tr>
      <td class="label">Tarikh Tamat<br/>Permit Kerja</td>
      <td><?php echo $row_user_passport['userpassport_permit']; ?></td>
      <td class="label">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  <?php } else { ?>
   <tr>
      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila kemaskini Maklumat Passport</td>
      </tr>
  <?php }; ?>
  </table>