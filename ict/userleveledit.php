<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='15';?>
<?php
if(isset($_GET['id']))
	$id = htmlspecialchars($_GET['id'], ENT_QUOTES);
else
	$id = 0;
	
$menu_id = htmlspecialchars($_GET['menu_id'], ENT_QUOTES);
$submenu_id = htmlspecialchars($_GET['submenu_id'], ENT_QUOTES);	
	
mysql_select_db($database_ictdb, $ictdb);
$query_vtype = "SELECT * FROM www.user_sysacc WHERE usersysacc_id=$id";
$vtype = mysql_query($query_vtype, $ictdb) or die(mysql_error());
$row_vtype = mysql_fetch_assoc($vtype);
$totalRows_vtype = mysql_num_rows($vtype);

$user_stafid  		= $row_vtype["user_stafid"];
$usersysacc_view  	= $row_vtype["usersysacc_view"];
$usersysacc_add  	= $row_vtype["usersysacc_add"];
$usersysacc_edit  	= $row_vtype["usersysacc_edit"];
$usersysacc_del  	= $row_vtype["usersysacc_del"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script type="text/javascript" src="../js/disenter.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $id != 0){?>
                <li>
                	<div class="note">Kemaskini maklumat akses yang telah ditetapkan</div>
                   
                    <form id="formual" name="formual" method="POST" action="../sb/userlevel_admin.php">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td nowrap="nowrap" class="label">Staf ID</td>
                            <td width="100%" colspan="5">
                              <span id="stafid"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                              <input name="user_stafid" type="text" class="w50" id="user_stafid" list="datastafid" value="<?php echo $user_stafid;?>" readonly="readonly"/>
                              <?php echo  datalistStaf('datastafid');?>
                            </span></td>
                          </tr>
                          <tr>
                            <td nowrap="nowrap" class="label">Menu</td>
                            <td colspan="5"><span id="menuid">
                            <select name="menu_id" id="menu_id">
                                <option value="0"><?php echo getMenuName($menu_id); ?></option>
                            </select></span>
                              <span id="submenuid">
                              <select name="submenu_id" id="submenu_id">
                                <option value="0"><?php echo getSubMenuName($submenu_id); ?></option>
                              </select></span></td>
                          </tr>
                          <tr>
                            <td nowrap="nowrap" class="label">View</td>
                            <td width="50%">
                            <ul class="inputradio">
                                <li><input type="radio" name="usersysacc_view" value="1" id="usersysacc_view_0" <?PHP if($usersysacc_view == 1) echo "checked" ;?>  /> Yes</li>
                                <li><input name="usersysacc_view" type="radio" id="usersysacc_view_1" value="0" <?PHP if($usersysacc_view == 0) echo "checked" ;?> /> No</li>
                            </ul>
                            </td>
                            <td nowrap="nowrap" class="label">Add</td>
                            <td width="50%">
                            <ul class="inputradio">
                                <li><input type="radio" name="usersysacc_add" value="1" id="usersysacc_view_0"  <?PHP if($usersysacc_add == 1) echo "checked" ;?>/> Yes</li>
                                <li><input name="usersysacc_add" type="radio" id="usersysacc_view_1" value="0" <?PHP if($usersysacc_add == 0) echo "checked" ;?> /> No</li>
                            </ul></td>
                          </tr>
                          <tr>
                            <td nowrap="nowrap" class="label">Edit</td>
                            <td>
                            <ul class="inputradio">
                                <li><input type="radio" name="usersysacc_edit" value="1" id="usersysacc_view_0" <?PHP if($usersysacc_edit == 1) echo "checked" ;?> /> Yes</li>
                                <li><input name="usersysacc_edit" type="radio" id="usersysacc_view_1" value="0" <?PHP if($usersysacc_edit == 0) echo "checked" ;?> /> No</li>
                            </ul></td>
                            <td nowrap="nowrap" class="label">Delete</td>
                            <td>
                            <ul class="inputradio">
                                <li><input type="radio" name="usersysacc_del" value="1" id="usersysacc_view_0" <?PHP if($usersysacc_del == 1) echo "checked" ;?>/> Yes</li>
                                <li><input name="usersysacc_del" type="radio" id="usersysacc_view_1" value="0" <?PHP if($usersysacc_del == 0) echo "checked" ;?> /> No</li>
                            </ul></td>
                          </tr>
                          <tr>
                            <td class="label noline"><input name="usersysacc_id" type="hidden" id="usersysacc_id" value="<?php echo $id;?>" />                          <input name="MM_update" type="hidden" id="MM_update" value="formual" /></td>
                            <td colspan="3" class="noline"><input name="button4" type="submit" class="submitbutton" id="button4" value="Kemaskini" /> 
                            <input name="button5" type="submit" class="cancelbutton" id="button5" value="Batal"/></td>
                          </tr>
                        </table>
                  </form>
                 
                 
                 
                 
                
              </li>
            <?php } else { ?>
            	<li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Tiada rekod dijumpai</td>
                    </tr>
                  </table>
                </li>
            <?php }; ?>
            </ul>
            </div>
        </div>
		</div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("nama");
</script>
</body>
</html>
<?php
mysql_free_result($vtype);
?>
<?php include('../inc/footinc.php');?> 