 <?php
 $colname_user_exwork = "-1";
if (isset($_GET['id'])) {
  $colname_user_exwork = getStafIDByUserID(htmlspecialchars($_GET['id'], ENT_QUOTES));
} else {
  $colname_user_exwork = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_exwork = sprintf("SELECT * FROM user_exwork WHERE user_stafid = %s AND userexwork_status = '1' ORDER BY userexwork_startdate ASC", GetSQLValueString($colname_user_exwork, "text"));
$user_exwork = mysql_query($query_user_exwork, $hrmsdb) or die(mysql_error());
$row_user_exwork = mysql_fetch_assoc($user_exwork);
$totalRows_user_exwork = mysql_num_rows($user_exwork);
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_user_exwork > 0) { // Show if recordset not empty ?>
<tr>
      <th width="50%" align="left" valign="middle">Jawatan / Majikan / Lokasi</th>
      <th align="center" valign="middle">Tarikh Mula</th>
      <th align="center" valign="middle">Tarikh Tamat</th>
      <th>&nbsp;</th>
    </tr>
    <?php do { ?>
      <tr class="on">
        <td align="left" valign="middle"><div class="txt_line"><strong class="in_cappitalize"><?php echo $row_user_exwork['userexwork_title']; ?></strong><br />
            <span class="in_cappitalize"><?php echo $row_user_exwork['userexwork_employer']; ?></span>
          <?php if($row_user_exwork['userexwork_location']!=NULL){?>
          <br />
          <span class="in_cappitalize"><?php echo $row_user_exwork['userexwork_location']; ?></span>
          <?php }; ?></div></td>
        <td align="center" valign="middle"><?php if($row_user_exwork['userexwork_startdate']!=NULL) echo $row_user_exwork['userexwork_startdate']; else echo "-"; ?></td>
        <td align="center" valign="middle"><?php if($row_user_exwork['userexwork_enddate']!=NULL) echo $row_user_exwork['userexwork_enddate']; else echo "-"; ?></td>
        
        <td align="right" valign="middle">
		<?php if($colname_user_exwork == $row_user['user_stafid'] && $menu == '2'){?>
        <ul class="func"><li><a onclick="return confirm('Anda mahu maklumat kerjaya berikut dipadam? \r\n\n <?php echo $row_user_exwork['userexwork_title']; ?>, <?php echo $row_user_exwork['userexwork_employer']; ?>')" href="sb/del_exwork.php?delexwork=<?php echo $row_user_exwork['userexwork_id']; ?>">X</a></li></ul>
		<?php }; ?>
        </td>
      </tr>
      <?php } while ($row_user_exwork = mysql_fetch_assoc($user_exwork)); ?>
    <tr>
      <td colspan="4" align="center" valign="middle" class="noline txt_color1">&nbsp;<?php echo $totalRows_user_exwork ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila isi Rekod Kerjaya</td>
    </tr>
    <?php };?>
  </table>
  <?php
mysql_free_result($user_exwork);
?>