<?php 
$colname_user_edu = "-1";

if (isset($_GET['id'])) {
  $colname_user_edu = getStafIDByUserID(htmlspecialchars($_GET['id'], ENT_QUOTES));
  $userstafid = htmlspecialchars($_GET['id'], ENT_QUOTES);
} else {
  $colname_user_edu = $row_user['user_stafid'];
  $userstafid = $row_user['user_id'];
};

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_edu = sprintf("SELECT * FROM user_edu WHERE user_stafid = %s AND useredu_status = '1' ORDER BY useredu_year ASC", GetSQLValueString($colname_user_edu, "text"));
$user_edu = mysql_query($query_user_edu, $hrmsdb) or die(mysql_error());
$row_user_edu = mysql_fetch_assoc($user_edu);
$totalRows_user_edu = mysql_num_rows($user_edu);
?>
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_user_edu > 0) { // Show if recordset not empty ?>
<tr>
      <th width="100%" align="left" valign="middle">Tahap / Bidang / Institusi / Lokasi</th>
    <th align="left" valign="middle">Penaja</th>
  <th align="center" valign="middle">Tahun<br/>Penganugerahan</th>
      <th align="center" valign="middle" nowrap="nowrap">CGPA / Skor</th>
      <th align="right" valign="middle">&nbsp;</th>
    </tr>
    <?php do { ?>
      <tr class="on">
        <td align="left" valign="middle"><div class="txt_line"><strong><?php echo getEdulevel($row_user_edu['useredu_level']); ?></strong><br />
            <?php if($row_user_edu['useredu_major']!=NULL){ ?><span class="in_cappitalize"><?php echo $row_user_edu['useredu_major']; ?></span><br /><?php }; ?>
            <?php if($row_user_edu['useredu_institution']!=NULL){ ?><span class="in_cappitalize"><?php echo $row_user_edu['useredu_institution']; ?></span><?php }; ?>
            <?php if($row_user_edu['useredu_location']!=NULL) echo ", " . $row_user_edu['useredu_location']; ?></div></td>
        <td align="left" valign="middle" nowrap="nowrap"><?php echo getEduSponsor($row_user_edu['useredu_id']);?></td>
        <td align="center" valign="middle"><?php echo $row_user_edu['useredu_year']; ?></td>
        <td align="center" valign="middle">
		<?php if(checkEduResultSubmit($colname_user_edu, $row_user_edu['useredu_id'])) {?>
        	<a href="#edu2" onclick="MM_openBrWindow('<?php echo $url_main;?>result.php?id=<?php echo getUserIDByStafID($row_user_edu['user_stafid']);?>&ided=<?php echo $row_user_edu['useredu_id'];?>','result','status=yes,scrollbars=yes,width=800,height=600')">Semak</a>
		<?php } else if(checkEduResult($row_user_edu['useredu_level']) && $colname_user_edu == $row_user['user_stafid'] && $menu == '2') {?>
        	<a href="#edu2" onclick="MM_openBrWindow('<?php echo $url_main;?>result.php?ided=<?php echo $row_user_edu['useredu_id'];?>','result','status=yes,scrollbars=yes,width=800,height=600')">Hantar</a>
		<?php } else if($row_user_edu['useredu_cgpa']!=NULL) echo $row_user_edu['useredu_cgpa']; else echo "-"; ?>
        </td>
        
        <td align="right" valign="middle">
        <?php if($colname_user_edu == $row_user['user_stafid']){?>
        <ul class="func"><?php if(getDelEdu($row_user_edu['useredu_id'])==$row_user['user_stafid'] && $menu == '2'){?><li><a onclick="return confirm('Anda mahu maklumat pendidikan berikut dipadam? \r\n\n <?php echo getEdulevel($row_user_edu['useredu_level']); ?>, <?php echo $row_user_edu['useredu_institution']; ?>')" href="sb/del_edu.php?deledu=<?php echo $row_user_edu['useredu_id']; ?>">X</a></li><?php }; ?></ul>
        <?php }; ?>
        </td>
      </tr>
      <?php } while ($row_user_edu = mysql_fetch_assoc($user_edu)); ?>
    <tr>
      <td colspan="5" align="center" valign="middle" class="noline txt_color1">&nbsp;<?php echo $totalRows_user_edu ?> rekod dijumpai</td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila isi Rekod Pendidikan</td>
    </tr>
    <?php }; ?>
  </table>
  <?php mysql_free_result($user_edu);?>