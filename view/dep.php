<?php
$colname_user_dependents = "-1";
if (isset($_GET['id'])) {
  $colname_user_dependents = getStafIDByUserID(htmlspecialchars($_GET['id'], ENT_QUOTES));
} else {
	$colname_user_dependents = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_dependents = sprintf("SELECT * FROM user_dependents WHERE user_stafid = %s AND userdependents_status = '1' ORDER BY userdependents_relation ASC", GetSQLValueString($colname_user_dependents, "text"));
$user_dependents = mysql_query($query_user_dependents, $hrmsdb) or die(mysql_error());
$row_user_dependents = mysql_fetch_assoc($user_dependents);
$totalRows_user_dependents = mysql_num_rows($user_dependents);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
     <?php if ($totalRows_user_dependents > 0) { // Show if recordset not empty ?>
<tr>
      <th width="50%" align="left" valign="middle">Nama</th>
      <th align="center" valign="middle">Hubungan</th>
      <th align="center" valign="middle">No Kad Pengenalan</th>
      <th>&nbsp;</th>
    </tr>
    <?php do { ?>
      <tr class="on">
        <td align="left" valign="middle" class="in_cappitalize"><?php echo $row_user_dependents['userdependents_name']; ?></td>
        <td align="center" valign="middle" class="in_cappitalize"><?php echo getRelation($row_user_dependents['userdependents_relation']); ?></td>
        <td align="center" valign="middle"><?php if($row_user_dependents['userdependents_ic']!=NULL) echo $row_user_dependents['userdependents_ic']; else echo "-"; ?></td>
        <td align="right">
		<?php if($colname_user_dependents == $row_user['user_stafid'] && $menu == '2'){?>
        	<ul class="func"><li><a onclick="return confirm('Anda mahu maklumat tanggungan berikut dipadam? \r\n\n <?php echo $row_user_dependents['userdependents_name']; ?> (<?php echo getRelation($row_user_dependents['userdependents_relation']); ?>)')" href="sb/del_dep.php?deldep=<?php echo $row_user_dependents['userdependents_id']; ?>">X</a></li></ul>
		<?php }; ?>
        </td>
      </tr>
      <?php } while ($row_user_dependents = mysql_fetch_assoc($user_dependents)); ?>
    <tr>
      <td colspan="4" align="center" valign="middle" class="noline txt_color1">&nbsp;<?php echo $totalRows_user_dependents ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila isi Maklumat Tanggungan</td>
    </tr>
    <?php }; ?>
  </table>
  <?php
mysql_free_result($user_dependents);
?>