<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='6';?>
<?php $menu2='10';?>
<?php

if(isset($_POST['y']))
	$y = htmlspecialchars($_POST['y'], ENT_QUOTES);
else
	$y = date('Y');

if(isset($_POST['cpulist']) && $_POST['cpulist']!=NULL)
	$wsql = " AND user_unit.dir_id='" . htmlspecialchars($_POST['cpulist'], ENT_QUOTES) . "' AND user_unit.userunit_status = '1'";
else
	$wsql = " AND user_unit.userunit_status = '1'";
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_login = "SELECT user.* FROM user LEFT JOIN (SELECT * FROM www.user_unit WHERE user_unit.userunit_status = '1' ORDER BY user_unit.userunit_id) AS user_unit ON user_unit.user_stafid = user.user_stafid WHERE EXISTS (SELECT * FROM www.login WHERE user.user_stafid = login.user_stafid AND login_status = '0' AND login_date_y = '" . $y . "') " . $wsql . " GROUP BY user.user_stafid ORDER BY user.user_firstname ASC, user.user_lastname ASC";
$login = mysql_query($query_login, $hrmsdb) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);
$totalRows_login = mysql_num_rows($login);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT * FROM dir WHERE dir_status = 1 ORDER BY dir_type ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);
$totalRows_dir = mysql_num_rows($dir);
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){ ?>
            <li class="form_back">
              <form id="cpu" name="cpu" method="post" action="listexstaf.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td nowrap="nowrap" class="label noline">Cawangan / Pusat / Unit</td>
                    <td width="100%" class="noline"><label for="cpulist"></label>
                      <select name="cpulist" id="cpulist">
                        <?php
						do {  
						?>
                        <option <?php if(isset($_POST['cpulist']) && $_POST['cpulist']==$row_dir['dir_id']) echo "selected=\"selected\"";?> value="<?php echo $row_dir['dir_id']?>"><?php echo getFulldirectory($row_dir['dir_id'], 0);?></option>
                        <?php
						} while ($row_dir = mysql_fetch_assoc($dir));
						  $rows = mysql_num_rows($dir);
						  if($rows > 0) {
							  mysql_data_seek($dir, 0);
							  $row_dir = mysql_fetch_assoc($dir);
						  }
						?>
                      </select>
                      <select name="y" id="y">
                      <?php for($i=date('Y'); $i>=2012; $i--){?>
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                      <?php }; ?>
                      </select>
                    <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                    <td class="noline">&nbsp;</td>
                  </tr>
                </table>
              </form>
            </li>
            <?php if ($totalRows_login > 0) { // Show if recordset not empty ?>
            <li>
            <div class="note">Senarai kakitangan yang tidak aktif</div>
            </li>
              <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama / Bahagian</th>
                    <th align="center" valign="middle">Email</th>
                  </tr>
                  <?php do { ?>
                    <tr class="on">
                      <td nowrap="nowrap" class="txt_line w50"><strong><?php echo $row_login['user_firstname']; ?> <?php echo $row_login['user_lastname']; ?></strong> (<?php echo $row_login['user_stafid']; ?>)<br />
                      <?php echo getFulldirectoryByUserID($row_login['user_stafid']);?></span></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo getEmailISNByUserID($row_login['user_stafid'], 1); ?></td>
                    </tr>
                    <?php } while ($row_login = mysql_fetch_assoc($login)); ?>
                  <tr>
                    <td colspan="2" align="center" valign="middle" class="noline txt_color1">&nbsp;<?php echo $totalRows_login ?> rekod dijumpai</td>
                  </tr>
                </table>
              </li>
              <?php } else {?>
              <li>
              	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              	  <tr>
              	    <td align="center" valign="middle" class="noline">Tiada rekod dijumpai. Sila cuba Cawangan / Pusat / Unit yang lain.</td>
           	      </tr>
           	    </table>
           	  </li>
              <?php }; ?>
                <?php } else { // semakkan user akses?>
                    <li>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" class="noline"><?php echo noteError(1);?></td>
                          </tr>
                        </table>
                    </li>
                <?php }; ?>
            </ul>
            </div>
         </div>
         <?php echo noteEmail('1');?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($login);
mysql_free_result($dir);
?>
<?php include('../inc/footinc.php');?>
