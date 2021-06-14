<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='125';?>
<?php 



if(isset($_POST['stafid']) && $_POST['stafid']!=NULL && isset($_POST['newID']) && $_POST['newID']!=NULL )
{
  
  mysql_select_db($database_hrmsdb, $hrmsdb);
  $query_changeid = "SELECT * FROM www.user WHERE user.user_stafid = '" . $_POST['stafid'] . "' ";
  $changeid = mysql_query($query_changeid, $hrmsdb) or die(mysql_error());
  $row_changeid = mysql_fetch_assoc($changeid);
  $totalRows_changeid = mysql_num_rows($changeid);

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $query_sysaccid = "SELECT * FROM www.user_sysacc WHERE user_sysacc.user_stafid = '" . $_POST['stafid'] . "' ";
  $sysaccid = mysql_query($query_sysaccid, $hrmsdb) or die(mysql_error());
  for($x=0; $row_sysacc = mysql_fetch_array($sysaccid); $x++)
	{		
		$row_sysaccid[] = $row_sysacc;
	}
  // $row_sysaccid = mysql_fetch_array($sysaccid);
  $totalRows_sysaccid = mysql_num_rows($sysaccid);

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $query_loginid = "SELECT * FROM www.login WHERE login.user_stafid = '" . $_POST['stafid'] . "' ";
  $loginid = mysql_query($query_loginid, $hrmsdb) or die(mysql_error());
  $row_loginid = mysql_fetch_assoc($loginid);
  $totalRows_loginid = mysql_num_rows($loginid);

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $query_leave_office = "SELECT * FROM www.leave_office WHERE leave_office.user_stafid = '" . $_POST['stafid'] . "' ";
  $leave_officeid = mysql_query($query_leave_office, $hrmsdb) or die(mysql_error());
  for($x=0; $row_leave_office = mysql_fetch_array($leave_officeid); $x++)
	{		
		$row_leave_officeid[] = $row_leave_office;
	}
  $totalRows_leave_officeid = mysql_num_rows($leave_officeid);


  if(checkUserSysAcc($row_changeid['user_stafid'], 5, 6, 3))
	{ 
    if(isset($row_failid['fail_id']))
    {
      echo $row_failid['fail_id'];
    }
    else echo "tiada";
		// semak user access level

    // dari sini komen untuk test
		// $updateSQL = sprintf("UPDATE www.user SET user_stafid=%s, user_stafid2=%s WHERE user_id=%s",
		// 					 GetSQLValueString($_POST['newID'], "text"),
		// 					 GetSQLValueString($_POST['stafid'], "text"),
		// 					 GetSQLValueString($row_changeid['user_id'], "text"));
	  
		// mysql_select_db($database_hrmsdb, $hrmsdb);
		// $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());

    // for ($x = 0; $x < $totalRows_sysaccid; $x++) {
    //   $updateSQL2 = sprintf("UPDATE www.user_sysacc SET user_stafid=%s WHERE usersysacc_id=%s",
		// 					 GetSQLValueString($_POST['newID'], "text"),
		// 					 GetSQLValueString($row_sysaccid[$x]['usersysacc_id'], "int"));

    //   mysql_select_db($database_hrmsdb, $hrmsdb);
    //   $Result2 = mysql_query($updateSQL2, $hrmsdb) or die(mysql_error());
    // }
    
	  // $updateLogin = sprintf("UPDATE www.login SET user_stafid=%s WHERE login_id=%s",
		// 					 GetSQLValueString($_POST['newID'], "text"),
		// 					 GetSQLValueString($row_loginid['login_id'], "text"));
	  
		// mysql_select_db($database_hrmsdb, $hrmsdb);
		// $Result1 = mysql_query($updateLogin, $hrmsdb) or die(mysql_error());

    // for ($i = 0; $i < $totalRows_leave_officeid; $i++) {
    //   $updateSQL2 = sprintf("UPDATE www.leave_office SET user_stafid=%s WHERE usersysacc_id=%s",
		// 					 GetSQLValueString($_POST['newID'], "text"),
		// 					 GetSQLValueString($row_leave_officeid[$i]['leaveoffice_id'], "int"));

    //   mysql_select_db($database_hrmsdb, $hrmsdb);
    //   $Result2 = mysql_query($updateSQL2, $hrmsdb) or die(mysql_error());
    // }
    // dari sini komen untuk test
		

    $userid= $row_changeid['user_id'];
	}
  //kalau tak ada akaun SPSM
  else {
    echo "ini xde akaun";
  };

  if(isset($_GET['url']) && $_GET['url']=='edit')
		$insertGoTo = $url_main . "admin/change_id.php?id=" . $userid . "&msg=add";
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li class="form_back">
                  <form id="form1" name="form1" method="post" action="change_id.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label">Pilih Staf ID</td>
                        <td width="100%">
                          <span id="nostaf">
                          <input name="stafid" type="text" class="w25" id="stafid" list="datastaf">
                          <?php echo datalistStaf('datastaf');?>
                          </span>
                          
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label">
                        <span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                          Staf ID Baharu
                        </td>
                        <td>
                        <input name="newID" type="text" class="w25" id="newID" value="" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <input name="button3" type="submit" class="submitbutton" id="button3" value="Kemaskini" />
                        </td>
                      </tr>
                    </table>
                  </form>
                
                </li>
                <li>
                <!-- <div class="note">Senarai nama</strong></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_changeid > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th width="10%" align="left" valign="middle" nowrap="nowrap"></th>
                      <th width="70%" align="left" valign="middle" nowrap="nowrap">Nama</th>
                      <th nowrap="nowrap">&nbsp;</th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        
                        <td align="center" valign="top" class="txt_line"><?php echo viewProfilePic($row_changeid['user_stafid']);?></td>
                        <td width="100%" align="left" valign="middle" class="txt_line">
                        <div><strong class="in_upper"><a href="edit.php?id=<?php echo $row_changeid['user_id']; ?>"><?php echo getFullNameByStafID($row_changeid['user_stafid']); ?> &nbsp; ( <?php echo $row_changeid['user_stafid']; ?> )</a></strong></div>
                        <div><span class="txt_color1"><?php echo getJobtitle($row_changeid['user_stafid']) . ", "; ?><?php echo getFulldirectoryByUserID($row_changeid['user_stafid']);?></span></div>
                        <div class="txt_color1">Email : <?php echo getEmailISNByUserID($row_changeid['user_stafid']);?> &nbsp; &bull; &nbsp; Ext : <?php echo getExtNoByUserID($row_changeid['user_stafid']);?></div>
                        </td>
                        <td>&nbsp;</td>
                        <td><ul class="func" onClick="toggleview('formchangeid','profile'); return false;"><li>X</li></ul></td>
                      </tr>
                      <?php $i++; } while ($row_changeid = mysql_fetch_assoc($changeid)); ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_changeid ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                 	<?php }; ?>
                  </table>
                </li>
            <?php } ; ?>
            </ul>
            </div> -->
        </div>
        <!-- <?php if(checkUserSysAcc($row_changeid['user_stafid'], 5, 6, 3)){ //semak user level utk update profile?>
          <div id="formchangeid" class="hidden">
            <li>
              <form id="formchangeid" name="formchangeid" method="POST" action="<?php echo $url_main;?>sb/profile_admin.php?id=<?php echo $colname_userprofile;?>&url=edit">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">ID sekarang</td>
                    <td colspan="3"><span id="firstname"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                    <input disabled="true" name="user_stafid" type="text" class="in_cappitalize w70" id="user_stafid" value="<?php echo $row_changeid['user_stafid']; ?>" /></span></td>
                  </tr>
                  <tr>
                    <td class="label">ID baharu *</td>
                    <td colspan="3"><span id="firstname"><span class="textfieldRequiredMsg">Maklumat diperlukan</span>
                    <input name="user_stafidnew" type="text" class="in_cappitalize w70" id="user_stafidnew" value="<?php echo $row_changeid['user_stafid']; ?>" /></span></td>
                  </tr>
                </table>
              </form>
            </li>
          </div>
          <?php }; ?> -->

        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("nostaf", "none", {hint:"Staf ID", isRequired:false});
</script>
</body>
</html>
<?php
// mysql_free_result($kew8);
?>
<?php include('../inc/footinc.php');?>