<?php
$colname_user_personal = "-1";
if (isset($_GET['id'])) {
  $colname_user_personal = getStafIDByUserID(htmlspecialchars($_GET['id'], ENT_QUOTES));;
} else {
  $colname_user_personal = $row_user['user_stafid'];
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_personal = sprintf("SELECT * FROM user_personal WHERE user_stafid = %s ORDER BY userpersonal_id DESC", GetSQLValueString($colname_user_personal, "text"));
$user_personal = mysql_query($query_user_personal, $hrmsdb) or die(mysql_error());
$row_user_personal = mysql_fetch_assoc($user_personal);
$totalRows_user_personal = mysql_num_rows($user_personal);
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Alamat Terkini</td>
                      <td colspan="3" valign="middle"><div class="txt_line in_cappitalize"><?php if($row_user_personal['userpersonal_address']!=NULL){?><?php echo $row_user_personal['userpersonal_address']; ?><?php }; ?><?php if($row_user_personal['userpersonal_address2']!=NULL){?><br/><?php echo $row_user_personal['userpersonal_address2']; ?><?php };?><?php if($row_user_personal['userpersonal_address3']!=NULL){?><br/><?php echo $row_user_personal['userpersonal_address3']; ?><?php }; ?></div></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Poskod</td>
                      <td width="50%" valign="middle" class="w50"><?php if($row_user_personal['userpersonal_zip']!=NULL) echo $row_user_personal['userpersonal_zip']; else echo "-"; ?></td>
                      <td valign="middle" nowrap="nowrap" class="label">Bandar</td>
                      <td width="50%" valign="middle" class="in_cappitalize w50"><?php echo $row_user_personal['userpersonal_city']; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Negeri</td>
                      <td valign="middle" class="in_cappitalize"><?php echo getState($row_user_personal['userpersonal_state']); ?></td>
                      <td valign="middle" nowrap="nowrap" class="label ">Negeri Kelahiran</td>
                      <td valign="middle" class="in_cappitalize"><?php echo getState($row_user_personal['userpersonal_dob_state']); ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">No. Telefon <br />
                      (Rumah)</td>
                      <td valign="middle"><?php if($row_user_personal['userpersonal_telh']!=NULL) echo $row_user_personal['userpersonal_telh']; else echo "-"; ?></td>
                      <td valign="middle" nowrap="nowrap" class="label">No. Telefon <br />
                      (Mobile)</td>
                      <td valign="middle"><?php if($row_user_personal['userpersonal_telm']!=NULL) echo $row_user_personal['userpersonal_telm']; else echo "-"; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">No. Telefon <br />
                      (MSN Ext)</td>
                      <td valign="middle"><?php if($row_user_personal['userpersonal_telw']!=NULL) echo $row_user_personal['userpersonal_telw']; else echo "-"; ?></td>
                      <td valign="middle" nowrap="nowrap" class="label">No. Telefon<br />
(Lain)</td>
                      <td valign="middle"><?php if($row_user_personal['userpersonal_telo']!=NULL) echo $row_user_personal['userpersonal_telo']; else echo "-"; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Email <br />
                      (MSN Mail)</td>
                      <td valign="middle" class="in_lower"><?php echo getEmailISNByUserID($colname_user_personal);?></td>
                      <td valign="middle" nowrap="nowrap" class="label">Email <br />
                      (Lain)</td>
                      <td valign="middle" class="in_lower"><?php if($row_user_personal['userpersonal_emailo']!=NULL) echo $row_user_personal['userpersonal_emailo']; else echo "-"; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">No. Lesen</td>
                      <td valign="middle" class="in_upper"><?php if($row_user_personal['userpersonal_license']!=NULL) echo $row_user_personal['userpersonal_license']; else echo "-"; ?></td>
                      <td valign="middle" nowrap="nowrap" class="label">Jenis Lesen</td>
                      <td valign="middle" class="in_upper"><?php if($row_user_personal['userpersonal_licensetype']!=NULL) echo $row_user_personal['userpersonal_licensetype']; else echo "-"; ?></td>
                    </tr>
                    <tr>
                      <td valign="middle" nowrap="nowrap" class="label">Size Baju</td>
                      <td valign="middle" class="in_upper"><?php echo $row_user_personal['userpersonal_size']; ?></td>
                      <td valign="middle" nowrap="nowrap" class="label">Status <br />
                      Perkahwinan</td>
                      <td valign="middle" class="in_capitalize"><?php echo getMarital($row_user_personal['userpersonal_marital']);?></td>
                    </tr>
                  </table>
<?php mysql_free_result($user_personal); ?>