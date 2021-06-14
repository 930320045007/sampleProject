<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='53';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sta = "SELECT * FROM www.state WHERE state_status = 1 AND EXISTS (SELECT * FROM tadbir.clinic WHERE clinic.state_id = state.state_id AND clinic.clinic_status = 1) ORDER BY state_name ASC";
$sta = mysql_query($query_sta, $hrmsdb) or die(mysql_error());
$row_sta = mysql_fetch_assoc($sta);
$totalRows_sta = mysql_num_rows($sta);

if(isset($_GET['state']))
	$sta2 = " AND state_id = '" . htmlspecialchars($_GET['state'], ENT_QUOTES) . "' ";
else
	$sta2 = "";
	
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_cl = "SELECT * FROM tadbir.clinic WHERE clinic_status = 1 " . $sta2 . " ORDER BY clinic_id DESC";
$cl = mysql_query($query_cl, $tadbirdb) or die(mysql_error());
$row_cl = mysql_fetch_assoc($cl);
$totalRows_cl = mysql_num_rows($cl);
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="adminclinic.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Negeri</td>
                        <td width="100%">
                        <select name="state" id="state">
                          <?php
							do {  
							?>
                          <option <?php if(isset($_GET['state']) && $_GET['state']==$row_sta['state_id']) echo "selected=\"selected\"";?> value="<?php echo $row_sta['state_id']?>"><?php echo $row_sta['state_name']?></option>
                          <?php
							} while ($row_sta = mysql_fetch_assoc($sta));
							?>
                        </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
            			<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                        <td><input name="button4" type="button" class="submitbutton" id="button4" value="Tambah" onclick="MM_goToURL('parent','adminclinicadd.php');return document.MM_returnValue" /></td>
                        <?php }; ?>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                <div class="note">Senarai Klinik Panel <?php if(isset($_GET['state'])) echo "<strong>" . getState($_GET['state']) . "</strong>"; ?></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_cl > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle">Bil</th>
                      <th width="100%" align="left" valign="middle">Perkara</th>
                      <th align="center" valign="middle">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle" class="txt_line"><strong><?php echo $row_cl['clinic_name']; ?></strong><br />
                          <?php echo $row_cl['clinic_address']; ?>, <?php echo getState($row_cl['state_id']); ?><br />
                        No. Tel : <?php echo $row_cl['clinic_notel1']; ?><?php if($row_cl['clinic_notel2']!=NULL) echo " / " . $row_cl['clinic_notel2']; ?><?php if($row_cl['clinic_nofax']!=NULL) echo ", No. Fax : " . $row_cl['clinic_nofax']; ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><ul class="func">
                          <li><a href="adminclinicedit.php?id=<?php echo $row_cl['clinic_id']; ?>">Edit</a></li>
                          <li>X</li>
                        </ul></td>
                    </tr>
                    <?php $i++; } while ($row_cl = mysql_fetch_assoc($cl)); ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_cl ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
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
mysql_free_result($cl);

mysql_free_result($sta);
?>
<?php include('../inc/footinc.php');?>
