<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='6';?>
<?php $menu2='15';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_menulist = "SELECT* FROM menu WHERE menutype_id = 2 AND menu_status = 1 ORDER BY menutype_id ASC";
$menulist = mysql_query($query_menulist, $hrmsdb) or die(mysql_error());
$row_menulist = mysql_fetch_assoc($menulist);
$totalRows_menulist = mysql_num_rows($menulist);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_usu = "SELECT user_sysacc.user_stafid FROM user_sysacc WHERE usersysacc_status = 1 GROUP BY user_sysacc.user_stafid ORDER BY user_sysacc.user_stafid ASC";
$usu = mysql_query($query_usu, $hrmsdb) or die(mysql_error());
$row_usu = mysql_fetch_assoc($usu);
$totalRows_usu = mysql_num_rows($usu);

$uslsql = "";

if(isset($_POST['mm']) && $_POST['mm']!=0)
{
	$uslsql .= " AND user_sysacc.menu_id = '" . htmlspecialchars($_POST['mm'], ENT_QUOTES) . "'";
	$mm = htmlspecialchars($_POST['mm'], ENT_QUOTES);
} else {
	$mm = 0;
}
	
if(isset($_POST['sidc']) && $_POST['sidc']!='0')
{
	$uslsql .= " AND user_sysacc.user_stafid = '" . htmlspecialchars($_POST['sidc'], ENT_QUOTES) . "'";
	$sidc = htmlspecialchars($_POST['sidc'], ENT_QUOTES);
} else {
	$sidc = '0';
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_uselevel = "SELECT * FROM user_sysacc WHERE usersysacc_status = 1 " . $uslsql . " ORDER BY user_stafid ASC, menu_id ASC, submenu_id ASC LIMIT 100";
$uselevel = mysql_query($query_uselevel, $hrmsdb) or die(mysql_error());
$row_uselevel = mysql_fetch_assoc($uselevel);
$totalRows_uselevel = mysql_num_rows($uselevel);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
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
                	<li class="form_back">
                	  <form id="form1" name="form1" method="post" action="userlevel.php">
                	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	      <tr>
                	        <td nowrap="nowrap" class="label noline">Main Menu</td>
                	        <td class="noline">
                	          <select name="mm" id="mm">
                	            <option <?php if($mm==0) echo "selected=\"selected\"";?> value="0">Semua</option>
                	            <?php
								do {  
								?>
                	            <option <?php if($mm==$row_menulist['menu_id']) echo "selected=\"selected\"";?> value="<?php echo $row_menulist['menu_id']?>"><?php echo strtoupper($row_menulist['menu_name']);?></option>
                	            <?php
								} while ($row_menulist = mysql_fetch_assoc($menulist));
								  $rows = mysql_num_rows($menulist);
								  if($rows > 0) {
									  mysql_data_seek($menulist, 0);
									  $row_menulist = mysql_fetch_assoc($menulist);
								  }
								?>
                            </select>
                            </td>
                	        <td nowrap="nowrap" class="noline label">atau Staf ID</td>
                	        <td class="noline">
                	          <select name="sidc" id="sidc">
                	            <option <?php if($sidc == '0') echo "selected=\"selected\"";?> value="0">Semua</option>
                	            <?php
								do {  
								?>
                	            <option <?php if($sidc == $row_usu['user_stafid']) echo "selected=\"selected\"";?> value="<?php echo $row_usu['user_stafid']?>"><?php echo $row_usu['user_stafid'] . " - " . shortText(getFullNameByStafID($row_usu['user_stafid']),30)?></option>
                	            <?php
								} while ($row_usu = mysql_fetch_assoc($usu));
								  $rows = mysql_num_rows($usu);
								  if($rows > 0) {
									  mysql_data_seek($usu, 0);
									  $row_usu = mysql_fetch_assoc($usu);
								  }
								?>
                            </select>
                            </td>
                	        <td width="100%" class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
               	          </tr>
               	        </table>
              	      </form>
                	</li>
                    <div class="note">Senarai nama dan akses yang telah ditetapkan</div>
                    <li class="title">Senarai <span class="fr add" onclick="toggleview2('formlevel'); return false;">+ Tambah</span></li>
                    <div id="formlevel" class="hidden">
                    <li>
                      <form id="formual" name="formual" method="POST" action="../sb/userlevel_admin.php">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td nowrap="nowrap" class="label">Staf ID</td>
                            <td width="100%" colspan="5">
                              <span id="stafid"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                              <input name="user_stafid" type="text" class="w50" id="user_stafid" list="datastafid"/>
                              <?php echo datalistStaf('datastafid');?>
                            </span></td>
                          </tr>
                          <tr>
                            <td nowrap="nowrap" class="label">Menu</td>
                            <td colspan="5"><span id="menuid">
                              <span class="selectInvalidMsg">Sila pilih Main Menu</span><span class="selectRequiredMsg"> &nbsp; Sila pilih Main Menu</span>
                            <select name="menu_id" id="menu_id" onchange="dochange('3', 'submenu_id', this.value, '0');">
                                <option value="0">Sila pilih Main Menu</option>
                                <?php
								do {  
								?>
                                <option value="<?php echo $row_menulist['menu_id']?>"><?php echo $row_menulist['menu_name']?></option>
                                <?php
									} while ($row_menulist = mysql_fetch_assoc($menulist));
									  $rows = mysql_num_rows($menulist);
									  if($rows > 0) {
										  mysql_data_seek($menulist, 0);
										  $row_menulist = mysql_fetch_assoc($menulist);
									  }
									?>
                              </select></span>
                              <span id="submenuid">
                              <span class="selectInvalidMsg"> &nbsp; &bull; &nbsp; Sila pilih Sub Menu</span><span class="selectRequiredMsg"> &nbsp; &bull; &nbsp; Sila pilih Sub Menu</span>
                              <select name="submenu_id" id="submenu_id">
                                <option value="0">&laquo; Sila pilih Main Menu</option>
                              </select></span></td>
                          </tr>
                          <tr>
                            <td nowrap="nowrap" class="label">View</td>
                            <td width="50%">
                            <ul class="inputradio">
                                <li><input type="radio" name="usersysacc_view" value="1" id="usersysacc_view_0" /> Yes</li>
                                <li><input name="usersysacc_view" type="radio" id="usersysacc_view_1" value="0" checked="checked" /> No</li>
                            </ul>
                            </td>
                            <td nowrap="nowrap" class="label">Add</td>
                            <td width="50%">
                            <ul class="inputradio">
                                <li><input type="radio" name="usersysacc_add" value="1" id="usersysacc_view_0" /> Yes</li>
                                <li><input name="usersysacc_add" type="radio" id="usersysacc_view_1" value="0" checked="checked" /> No</li>
                            </ul></td>
                          </tr>
                          <tr>
                            <td nowrap="nowrap" class="label">Edit</td>
                            <td>
                            <ul class="inputradio">
                                <li><input type="radio" name="usersysacc_edit" value="1" id="usersysacc_view_0" /> Yes</li>
                                <li><input name="usersysacc_edit" type="radio" id="usersysacc_view_1" value="0" checked="checked" /> No</li>
                            </ul></td>
                            <td nowrap="nowrap" class="label">Delete</td>
                            <td>
                            <ul class="inputradio">
                                <li><input type="radio" name="usersysacc_del" value="1" id="usersysacc_view_0" /> Yes</li>
                                <li><input name="usersysacc_del" type="radio" id="usersysacc_view_1" value="0" checked="checked" /> No</li>
                            </ul></td>
                          </tr>
                          <tr>
                            <td class="label noline"><input type="hidden" name="MM_insert" value="formual" /></td>
                            <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" /> <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" onclick="toggleview2('formlevel'); return false;"/></td>
                          </tr>
                        </table>
                      </form>
                    </li>
                    </div>
                    <li>
                    <div class="off">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <?php if ($totalRows_uselevel > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th nowrap="nowrap">Bil</th>
                          <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama / Jawatan</th>
                          <th nowrap="nowrap">Main Menu</th>
                          <th nowrap="nowrap">Sub Menu</th>
                          <th nowrap="nowrap">View</th>
                          <th nowrap="nowrap">Add</th>
                          <th nowrap="nowrap">Edit</th>
                          <th nowrap="nowrap">Delete</th>
                          <th nowrap="nowrap">&nbsp;</th>
                        </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td><?php echo $i;?></td>
                            <td><strong><?php echo getFullNameByStafID($row_uselevel['user_stafid']); ?></strong> (<?php echo $row_uselevel['user_stafid']; ?>)<br/><span class="txt_color1"><?php echo getFulldirectoryByUserID($row_uselevel['user_stafid']);?></span></td>
                            <td align="center" valign="middle"><?php echo getMenuName($row_uselevel['menu_id']); ?></td>
                            <td align="center" valign="middle"><?php echo getSubMenuName($row_uselevel['submenu_id']); ?></td>
                            <td align="center" valign="middle"><?php echo viewIconAcc($row_uselevel['user_stafid'], $row_uselevel['menu_id'], $row_uselevel['submenu_id'], 1);?></td>
                            <td align="center" valign="middle"><?php echo viewIconAcc($row_uselevel['user_stafid'], $row_uselevel['menu_id'], $row_uselevel['submenu_id'], 2);?></td>
                            <td align="center" valign="middle"><?php echo viewIconAcc($row_uselevel['user_stafid'], $row_uselevel['menu_id'], $row_uselevel['submenu_id'], 3);?></td>
                            <td align="center" valign="middle"><?php echo viewIconAcc($row_uselevel['user_stafid'], $row_uselevel['menu_id'], $row_uselevel['submenu_id'], 4);?></td>
                            
                            <td align="center" valign="middle" nowrap="nowrap"><ul class="func">
                            <li><a href="userleveledit.php?id=<?php echo $row_uselevel['usersysacc_id'];?>&menu_id=<?php echo $row_uselevel['menu_id'];?>&submenu_id=<?php echo $row_uselevel['submenu_id'];?>">Edit</a></li>                           
                              <td align="left">
                              
                                <td><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo getFullNameByStafID($row_uselevel['user_stafid']); ?> - <?php echo getFulldirectoryByUserID($row_uselevel['user_stafid']);?> <?php echo $row_uselevel['menu_id']; ?>')" href=" <?php echo $url_main;?>sb/del_userlevel.php?id=<?php echo $row_uselevel['usersysacc_id'];?>">X</a></li></ul></td>
                  
                      
            </td>
                           
                          </tr>
                          <?php $i++; } while ($row_uselevel = mysql_fetch_assoc($uselevel)); ?>
                        <tr>
                          <td colspan="9" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_uselevel ?>  rekod dijumpai</td>
                        </tr>
                      <?php } else {?>
                        <tr>
                          <td colspan="9" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
                      </div>
                    </li>
                </ul>
          	</div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("stafid");
var spryselect1 = new Spry.Widget.ValidationSelect("menuid", {invalidValue:"0"});
var spryselect2 = new Spry.Widget.ValidationSelect("submenuid", {invalidValue:"0"});
</script>
</body>
</html>
<?php
mysql_free_result($menulist);

mysql_free_result($uselevel);

mysql_free_result($usu);
?>
<?php include('../inc/footinc.php');?> 