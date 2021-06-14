<?php
$colname_user_ec = "-1";
if (isset($_GET['id'])) {
  $colname_user_ec = getStafIDByUserID(htmlspecialchars($_GET['id'], ENT_QUOTES));
} else {
  $colname_user_ec = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_ec = sprintf("SELECT * FROM user_ec WHERE user_stafid = %s AND userec_status = '1' ORDER BY userec_name ASC", GetSQLValueString($colname_user_ec, "text"));
$user_ec = mysql_query($query_user_ec, $hrmsdb) or die(mysql_error());
$row_user_ec = mysql_fetch_assoc($user_ec);
$totalRows_user_ec = mysql_num_rows($user_ec);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <?php if ($totalRows_user_ec > 0) { // Show if recordset not empty ?>
<tr>
      <th width="50%" align="left" valign="middle">Nama / Hubungan</td>
        <th align="center" valign="middle">No. Kad Pengenalan</td>
        <th align="center" valign="middle">No. Tel (Rumah)</td>
          <th align="center" valign="middle">No. Tel (Mobile)</td>
            <th align="center" valign="middle">No. Tel (Pejabat)</td>
              <th align="center" valign="middle">&nbsp;</th>                      
              </tr>
    <?php do { ?>
      <tr class="on">
        <td align="left" class="txt_line">
        <div><span class="in_cappitalize"><strong><?php echo $row_user_ec['userec_name']; ?></strong></span></div>
        <div><span class="in_cappitalize"><?php echo getRelation($row_user_ec['userec_relation']); ?></span></div>
        <?php if($row_user_ec['userrec_address']!=NULL){?>
        <div><?php echo shortText($row_user_ec['userrec_address']); ?></div>
        <?php }; ?>
        </td>
         <td align="center" valign="middle"><?php if($row_user_ec['userec_noic']!=NULL)echo $row_user_ec['userec_noic']; else echo "-"; ?></td>
        <td align="center" valign="middle"><?php if($row_user_ec['userec_telh']!=NULL)echo $row_user_ec['userec_telh']; else echo "-"; ?></td>
        <td align="center" valign="middle"><?php if($row_user_ec['userec_telm']!=NULL)echo $row_user_ec['userec_telm']; else echo "-"; ?></td>
        <td align="center" valign="middle"><?php if($row_user_ec['userec_telw']!=NULL)echo $row_user_ec['userec_telw']; else echo "-"; ?></td>
        
        <td align="right" valign="middle">
		<?php if($colname_user_ec == $row_user['user_stafid'] && $menu == '2'){?>
        <ul class="func">
            <li><a onclick="return confirm('Anda mahu maklumat waris/rujukan berikut dipadam? \r\n\n <?php echo $row_user_ec['userec_name']; ?> (<?php echo getRelation($row_user_ec['userec_relation']); ?>)')" href="sb/del_ec.php?delec=<?php echo $row_user_ec['userec_id']; ?>">X</a></li>
        </ul>
        <?php }; ?>
        </td>
      </tr>
      <?php } while ($row_user_ec = mysql_fetch_assoc($user_ec)); ?>
    <tr>
      <td colspan="5" align="center" class="noline txt_color1">&nbsp;<?php echo $totalRows_user_ec ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="5" align="center" class="noline">Tiada rekod dijumpai, Sila isi Rujukan Kecemasan</td>
    </tr>
    <?php }; ?>
  </table>
<?php
mysql_free_result($user_ec);
?>