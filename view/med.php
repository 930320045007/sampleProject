<?php
$colname_user_med = "-1";
if (isset($_GET['id'])) {
  $colname_user_med = getStafIDByUserID(htmlspecialchars($_GET['id'], ENT_QUOTES));
} else {
	$colname_user_med = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_med = sprintf("SELECT * FROM user_med WHERE user_stafid = %s ORDER BY usermed_id DESC", GetSQLValueString($colname_user_med, "text"));
$user_med = mysql_query($query_user_med, $hrmsdb) or die(mysql_error());
$row_user_med = mysql_fetch_assoc($user_med);
$totalRows_user_med = mysql_num_rows($user_med);
?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_user_med > 0) { // Show if recordset not empty ?>
                    <tr>
                      <td class="label">Jenis Darah</td>
                      <td class="in_upper"><?php echo $row_user_med['usermed_blood']; ?></td>
                      <td class="label">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="label">Tinggi (cm) </td>
                      <td><?php if($row_user_med['usermed_height']!=NULL) echo $row_user_med['usermed_height']; else echo "-"; ?></td>
                      <td class="label">Berat (kg) </td>
                      <td><?php if($row_user_med['usermed_weight']!=NULL) echo $row_user_med['usermed_weight']; else echo "-"; ?></td>
                    </tr>
                    <tr>
                      <td class="label">Kecacatan</td>
                      <td colspan="3"><?php if($row_user_med['usermed_disable']!=NULL) echo $row_user_med['usermed_disable']; else echo "Tiada"; ?></td>
                    </tr>                  
                    <tr>
                      <td class="label">Alahan</td>
                      <td colspan="3"><?php if($row_user_med['usermed_allergic']!=NULL) echo $row_user_med['usermed_allergic']; else echo "Tiada"; ?></td>
                    </tr>                  
                    <tr>
                      <td class="label">Penyakit Kritikal</td>
                      <td colspan="3"><?php if($row_user_med['usermed_disease']!=NULL) echo $row_user_med['usermed_disease']; else echo "Tiada"; ?></td>
                    </tr>                  
                    <tr>
                      <td class="label">Maklumat Rawatan</td>
                      <td colspan="3"><?php if($row_user_med['usermed_doctor']!=NULL) echo $row_user_med['usermed_doctor']; else echo "Tiada"; ?></td>
                    </tr>                  
                    <tr>
                      <td class="label">Tarikh Rawatan</td>
                      <td colspan="3"><?php if($row_user_med['usermed_datetreatment']!=NULL) echo $row_user_med['usermed_datetreatment']; else echo "-"; ?></td>
                    </tr>
                      <?php } else { ?>                  
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai, Sila kemaskini Maklumat Perubatan</td>
                    </tr>  
                      <?php }; ?>
                  </table>
                
<?php mysql_free_result($user_med); ?>